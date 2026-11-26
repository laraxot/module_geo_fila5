---
title: "Contratto — UpdateCoordinatesFromAddressAction"
type: contract
action: "Modules\\Geo\\Actions\\UpdateCoordinatesFromAddressAction"
module: Geo
status: active
tags: [contract, action, geocoding, coordinates, db-write]
created: 2026-11-24
updated: 2026-11-26
related:
  - get-address-data-from-full-address-action.md
  - ../../app/Actions/UpdateCoordinatesFromAddressAction.php
  - ../../tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php
---

# UpdateCoordinatesFromAddressAction

Geocodifica l'indirizzo di un modello qualsiasi e ne scrive `latitude` e `longitude`. Sorgente:
`app/Actions/UpdateCoordinatesFromAddressAction.php`. Chiamanti di produzione: `app/Filament/Actions/UpdateCoordinatesBulkAction.php`
(riga 129, azione bulk sulle tabelle) e `app/Filament/Forms/Components/CoordinatesSection.php` (riga 43, pulsante
«geocodifica» del form); entrambi mostrano gli errori in una notifica Filament.

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`). Prova:
`cd laravel && vendor/bin/pest Modules/Geo/tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php`
(oppure `--group=GEO-COORDS-INV-<N>`).

## Input

- `Model $model` con l'attributo `full_address` (o l'accessor `getFullAddressAttribute()`, che ha la precedenza,
  righe 120-126) e le colonne `latitude`, `longitude` fillable.

## Output

- `true` se le coordinate sono state scritte; `false` altrimenti, con i motivi in `getErrors()`
  (`Collection<int, string>`, azzerata a ogni `execute()`, riga 63).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-COORDS-INV-1 | A geocodifica riuscita si scrivono solo `latitude` e `longitude`, con un solo `update()`; gli altri campi restituiti dal geocoding (città, CAP, via) non si toccano. Violata = sovrascrittura di dati anagrafici del modello. | `GEO-COORDS-INV-1` |
| GEO-COORDS-INV-2 | Indirizzo vuoto = `false` con un errore tradotto (`geo::actions.update_coordinates.errors.empty_address`), senza interrogare alcun provider. | `GEO-COORDS-INV-2` |
| GEO-COORDS-INV-3 | Se nessun provider risponde, gli errori dei provider arrivano in `getErrors()` così come sono (non sostituiti da un messaggio generico); il messaggio generico `geocoding_failed` compare solo se i provider non hanno lasciato errori. | `GEO-COORDS-INV-3` |
| GEO-COORDS-INV-4 | Un'eccezione dell'`update()` non esce: `false`, messaggio in `getErrors()` e `Log::error('Errore aggiornamento coordinate')` con classe e chiave del modello (righe 137-158). | — (non dimostrato) |

**Dimostrato** (`UpdateCoordinatesFromAddressActionTest.php`, geocoding sostituito con un mock nel container):
INV-1 (`update()` chiamato una volta con esattamente `['latitude' => 45.4642, 'longitude' => 9.19]`); INV-2
(modello senza indirizzo: `false` e `getErrors()` non vuota; il mock del geocoding non ha aspettative, quindi una
chiamata al provider farebbe fallire il test); INV-3 (i due errori dei provider ritornano identici). **Promesso ma non
coperto**: INV-4, il messaggio generico `geocoding_failed`, la precedenza dell'accessor.

## Effetti collaterali

In ordine:

1. Legge `full_address` dal modello (accessor se esiste, altrimenti attributo).
2. Con indirizzo vuoto si ferma qui (INV-2): nessuna chiamata esterna.
3. Una o più richieste HTTP ai provider di geocoding tramite `GetAddressDataFromFullAddressAction`
   (vedi il [suo contratto](get-address-data-from-full-address-action.md): l'indirizzo è un dato personale).
4. `Model::update(['latitude' => …, 'longitude' => …])`: scrive sul DB e scatena gli eventi Eloquent del modello
   (`saving`, `updated`, observer).
5. `Log::error('Errore aggiornamento coordinate', …)` solo se l'`update()` lancia.

## Errori

- Nessuna eccezione per indirizzo mancante, geocodifica fallita o `update()` fallito: tutto finisce in `false` +
  `getErrors()`; il chiamante decide se notificare.
- Cattura solo `\Exception` nell'`update()`: un `\Error` esce.
- Stato nell'istanza (`$errors`): leggere `getErrors()` subito dopo il proprio `execute()`.

## Non fa

- Non sceglie il provider: lo fa `GetAddressDataFromFullAddressAction` con `geo.driver`.
- Non scrive gli altri campi restituiti dal geocoding (città, CAP, via): solo le coordinate.
- Non invia notifiche né mostra messaggi all'utente.
- Non salta i modelli che hanno già coordinate: chi chiama decide se ricalcolarle.
- Non apre transazioni: per molti record c'è `UpdateClientCoordinatesBulkAction` ([contratto](update-client-coordinates-bulk-action.md))
  o la bulk action Filament, che chiama questa Action una volta per record.
- Non verifica che il risultato sia plausibile (es. dentro il Comune): scrive le coordinate del primo risultato.

## Limiti noti

- Il `true` non prova che le colonne siano state scritte: se `latitude`/`longitude` non sono fillable, `update()` le scarta
  in silenzio (salvo `Model::preventSilentlyDiscardingAttributes()`) e l'Action risponde comunque `true`.
- `empty($fullAddress)` (riga 68) tratta come vuota anche la stringa `"0"`.
- Le chiavi di traduzione `geo::actions.update_coordinates.errors.*` esistono solo in `lang/it/actions.php`:
  `lang/en`, `lang/de` e `lang/es` non hanno `actions.php`, quindi INV-2 produce un messaggio tradotto solo per `it`
  (negli altri casi vale il fallback di locale dell'app).
