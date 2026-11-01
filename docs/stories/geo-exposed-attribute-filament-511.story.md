---
title: L'attributo Exposed di Filament non esiste nella versione installata
status: done
owner: Geo
created: 2026-10-29
related:
  - ../../../Tenant/docs/stories/sushi-to-jsons-single-source-cleanup.story.md
---

# L'attributo Exposed di Filament non esiste nella versione installata

## Fase BMAD

Analisi, dopo il pull dei sottomoduli (2026-10-29). In attesa di una decisione dell'utente.

## Problema

Il commit upstream `afc3a419` (2026-10-28, messaggio ".") sostituisce `#[ExposedLivewireMethod]`
con `#[Exposed]` su `searchAddress()` e `reverseGeocode()` in:

- `app/Filament/Forms/Components/Traits/HasCoordinatePicker.php` (righe 235 e 293)
- `app/Filament/Forms/Components/XotBaseCoordinateField.php` (righe 204 e 214)

PHPStan: `attribute.notFound`, 20 errori. 18 vengono dal trait (2 righe per ognuna delle 9 classi
che lo usano), 2 da `XotBaseCoordinateField`.

## Causa

- `Filament\Support\Components\Attributes\Exposed` nasce in Filament **v5.11.0** (2026-10-26).
  Nella stessa versione `ExposedLivewireMethod` diventa deprecato e `extends Exposed`.
- Il progetto ha Filament **v5.10.1** (`laravel/composer.lock`, vincolo `^5.0`), dove `Exposed`
  non esiste.
- In 5.10.1 `InteractsWithSchemas::callSchemaComponentMethod()` restituisce `null` se il metodo
  non ha `#[ExposedLivewireMethod]`. Con `#[Exposed]` la ricerca dell'indirizzo e la geocodifica
  inversa chiamate dal browser restituiscono `null`, senza errori.
- In 5.11.0 il controllo e' `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`:
  li' funzionano entrambi gli attributi.

Impatto oggi: nessun modulo o tema fuori da Geo usa questi campi in questo progetto.

## Opzioni

1. **Aggiornare Filament a 5.11.0** (`composer update` dei pacchetti `filament/*`, dentro `^5.0`).
   Allinea il progetto a quello che l'upstream usa gia'. Cambia `composer.lock` per tutta l'app e
   va portato in produzione. 5.11.0 ha 3 giorni.
2. **Rimettere `#[ExposedLivewireMethod]`** nei 4 punti. Funziona sia con 5.10.1 sia con 5.11
   (deprecato). Si allontana dall'upstream: al prossimo pull i file possono andare in conflitto.

## Decisione

2026-10-29: l'utente sceglie l'opzione 1, aggiornare Filament.

## Blocco trovato durante l'opzione 1

Dry-run di `composer update "filament/*" livewire/livewire` (nessun comando reale eseguito):

- Serve anche Livewire: `filament/support` 5.11.0 richiede `livewire/livewire ^4.4.8` (installato 4.4.7).
- L'aggiornamento vero e' piccolo: 12 pacchetti `filament/*` da 5.10.1 a 5.11.0, Livewire a 4.4.8,
  e l'installazione di `laravel/head` (lo chiede `Modules/Cms/composer.json` da questo pull).
- Ma il lock e' disallineato: `composer validate` dice che `laravel/head` manca dal lock, e il dry-run
  **rimuove 106 pacchetti** tra cui Pest, PHPUnit, Pint, Larastan, PHPInsights, ide-helper e Debugbar.
  Il motivo: il `composer.json` root ha solo 3 `require` e 2 `require-dev`, e il merge-plugin dai
  `Modules/*/composer.json` porta solo i `require`, non i `require-dev`. Quegli strumenti sono nel lock
  ma oggi nessuno li richiede piu', quindi qualsiasi `composer update` li toglie.

Prima di aggiornare va deciso dove dichiarare gli strumenti di sviluppo. Nuova scelta chiesta all'utente.

2026-10-29: l'utente esegue lui `composer update -W`, poi si riprende. Nessun file di Geo modificato.

## Correzione: le 106 rimozioni non erano reali

Dopo il `composer update -W` vero, Pest, PHPUnit, Pint, Larastan, PHPInsights, PHPMD, ide-helper e
Debugbar sono ancora installati (`packages-dev` del lock, binari in `vendor/bin`). Le rimozioni del
dry-run erano un artefatto: probabilmente il merge-plugin applica i `require-dev` dei moduli in un
secondo passaggio, che `--dry-run` non esegue. Lezione: con il merge-plugin il dry-run non basta per
giudicare cosa viene rimosso.

Altro fatto utile: `laravel/composer.lock` e' ignorato dal `.gitignore` root (riga 46) e non e'
tracciato dal 2026-09-03, quindi l'aggiornamento non produce nulla da committare.

## Verifica (2026-10-29)

- `composer validate`: valido. Nel lock: `filament/*` 5.11.0, `livewire/livewire` 4.4.8, `laravel/head` 0.2.2.
- In `vendor/filament/schemas/src/Concerns/InteractsWithSchemas.php:107` il controllo e'
  `getAttributes(Exposed::class, ReflectionAttribute::IS_INSTANCEOF)`: `searchAddress()` e
  `reverseGeocode()` sono di nuovo chiamabili dal browser.
- PHPStan, `./vendor/bin/phpstan analyse` da `laravel/`: **0 errori in Geo**, totale 5.
- Pest `tests/Unit/Filament/Forms/Components/MapPickerTest.php`: 18/18.

## Effetto collaterale

Filament 5.11 depreca `Widget::isLazy()` (sostituto `isLazyLoaded()`): 3 nuovi errori PHPStan
`staticMethod.deprecated` nei test di Quaeris (`QuestionChartDataTableWidgetTest.php:247`,
`QuestionChartItemWidgetTest.php:483`, `QuestionChartStatsOverviewWidgetTest.php:156`). Fuori dal
modulo Geo.
