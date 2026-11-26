---
title: "Contratto — UpdateClientCoordinatesBulkAction"
type: contract
action: "Modules\\Geo\\Actions\\UpdateClientCoordinatesBulkAction"
module: Geo
status: active
tags: [contract, action, geocoding, coordinates, db-write, bulk, transaction]
created: 2026-11-26
updated: 2026-11-26
related:
  - get-address-data-from-full-address-action.md
  - update-coordinates-from-address-action.md
  - ../../app/Actions/UpdateClientCoordinatesBulkAction.php
---

# UpdateClientCoordinatesBulkAction

Geocodifica in lotto una collezione di indirizzi (`Modules\Geo\Models\Address`) e ne scrive latitudine e longitudine,
dentro un'unica transazione. Sorgente: `app/Actions/UpdateClientCoordinatesBulkAction.php`. Chiamanti di produzione al
2026-11-26: nessuno (`rg "UpdateClientCoordinatesBulkAction" Modules Themes app`, esclusi test e docs); la bulk action
Filament `app/Filament/Actions/UpdateCoordinatesBulkAction.php` **non** la usa: chiama
[UpdateCoordinatesFromAddressAction](update-coordinates-from-address-action.md) una volta per record, senza transazione.
Nessun test la esercita (`rg -l UpdateClientCoordinatesBulkAction Modules/Geo/tests` non trova nulla).

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).

## Input

- `Illuminate\Database\Eloquent\Collection<int, Address>`: ogni `Address` ha l'attributo `full_address` (accessor
  `Address::getFullAddressAttribute()`) e le colonne `latitude`, `longitude` fillable.

## Output

- `array{success_count: int, error_messages: array<string>}`: quanti indirizzi sono stati aggiornati e un messaggio
  `Errore per <nome>: <motivo>` per ciascuno non geocodificato.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GEO-BULKCOORDS-INV-1 | Per ogni indirizzo geocodificato si scrivono solo `latitude` e `longitude` (`Arr::only`, riga 43); gli altri campi restituiti dal geocoding non si toccano. Violata = sovrascrittura di dati anagrafici. | — (non dimostrato) |
| GEO-BULKCOORDS-INV-2 | Tutto il lotto sta in una sola `DB::transaction` (riga 35): se esce un'eccezione (da `update()` o da un `\Error` del geocoding) nessun indirizzo resta aggiornato. | — (non dimostrato) |
| GEO-BULKCOORDS-INV-3 | Un indirizzo non geocodificabile non interrompe il lotto: finisce in `error_messages` e si passa al successivo. | — (non dimostrato) |
| GEO-BULKCOORDS-INV-4 | Senza eccezioni, `success_count + count(error_messages)` è uguale al numero di indirizzi ricevuti (ogni iterazione incrementa il contatore o aggiunge un messaggio, righe 36-60). | — (non dimostrato) |

Nessuna invariante è dimostrata: manca il file di test dell'Action (vedi «Backlog test» nel README).

## Effetti collaterali

In ordine, dentro `DB::transaction`, per ogni indirizzo:

1. Una geocodifica con `GetAddressDataFromFullAddressAction` ([contratto](get-address-data-from-full-address-action.md)):
   fino a sette richieste HTTP verso servizi esterni, con l'indirizzo (dato personale) come parametro.
2. Se c'è un risultato: `Address::update(['latitude' => …, 'longitude' => …])` (scrittura DB, eventi Eloquent).
3. Altrimenti: compone il messaggio di errore e passa oltre.

La transazione resta aperta per tutta la durata delle chiamate di rete di tutti gli indirizzi.

## Errori

- Indirizzo non geocodificato = voce in `error_messages`, nessuna eccezione.
- Un'eccezione dell'`update()` esce dall'Action e annulla l'intera transazione (INV-2).

## Non fa

- Non salta gli indirizzi che hanno già coordinate né quelli con `full_address` vuota: anche l'indirizzo vuoto è
  inviato al geocoder (a differenza di `UpdateCoordinatesFromAddressAction`, che si ferma prima).
- Non limita la dimensione del lotto né la frequenza delle richieste ai provider.
- Non notifica l'utente: restituisce solo il riepilogo.
- Non è usata dalla bulk action Filament di Geo.

## Limiti noti

- **Difetto di codice**: il motivo dell'errore è sempre vuoto. `app(GetAddressDataFromFullAddressAction::class)` crea
  un'istanza nuova a ogni chiamata (nessun `singleton` in `GeoServiceProvider`): `getErrors()` (riga 53) legge una
  istanza diversa da quella che ha eseguito (riga 38) e restituisce una collezione vuota, quindi il messaggio è sempre
  `Errore sconosciuto`, testo italiano fisso nel codice.
- Una transazione lunga su chiamate HTTP: con molti indirizzi tiene aperto un lock di scrittura sul DB per minuti e un
  errore a metà annulla anche gli aggiornamenti già riusciti.
- Se `latitude`/`longitude` non sono fillable, `update()` le scarta in silenzio e il contatore sale lo stesso.
