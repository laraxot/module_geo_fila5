---
title: "ADR — integrazioni Geo come Actions"
type: decision
status: accepted
module: Geo
decision-makers: [team back office]
created: 2026-11-23
updated: 2026-11-26
---

# Integrazioni Geo come Actions

## Contesto

`BaseGeoService` era una base astratta non referenziata dal codice di
produzione. Le integrazioni operative sono già esposte dalle Queueable Actions
in `app/Actions`, mentre la regola architetturale del progetto vieta di
aggiungere use case nelle cartelle `app/Services`.

Domanda: dove vive la logica d'integrazione geografica, e cosa si fa della base astratta senza chiamanti?

## Driver della decisione

- La regola architetturale vieta use case in `app/Services`: una base lì è una violazione, non un'eccezione.
- Una classe astratta senza chiamanti verificati inganna chi la legge e suggerisce un'estensione che non esiste.
- Le integrazioni esistenti sono già Queueable Actions con contratto: il punto di estensione c'è già.

## Alternative scartate

- Conservare la classe come base futura: avrebbe mantenuto una violazione
  architetturale senza chiamanti verificati.
- Spostarla in `Support`: avrebbe solo nascosto la responsabilità condivisa
  senza risolvere l'assenza di un contratto concreto.
- Reintrodurre un Service wrapper: duplicava le Actions esistenti.

## Decisione

Il codice morto `BaseGeoService` viene rimosso. Le responsabilità HTTP,
cache, rate limiting e trasformazione delle risposte restano nelle Actions
owner, ciascuna con il proprio contratto in `docs/contracts/`.

## Conseguenze

- `Modules/Geo/app/Services` non contiene più questa base obsoleta.
- Le nuove integrazioni devono essere Queueable Actions e documentare input,
  output, invarianti, effetti collaterali, errori e limiti.
- I consumer legacy devono migrare verso l'Action specifica, non verso una
  nuova classe base generica.

## Conferma

- `cd laravel && vendor/bin/pest Modules/Xot/tests/Unit/Architecture/NoServicesTest.php`: nessuna cartella `Services` nel codice di
  produzione (test alla riga 70), nessuna classe in un namespace `Services` (riga 146), nessun `use` di un namespace `Services`
  (riga 182); il test confronta con `[]`, senza allowlist.
- `cd laravel && vendor/bin/pest --testsuite=Arch`: la regola «a use case is an Action, not a Service»
  (`Modules/Xot/tests/Arch/ArchitectureTest.php:152`) ammette solo le classi della chiave `services` di
  `Modules/Geo/tests/Arch/debt.php` (riga 29); quando i file spariscono la chiave diventa `[]`.
- Oggi la conferma non regge per Geo: vedi «Stato attuale».

## Stato attuale

Misurato il 2026-11-26: **la decisione e' accettata ma non e' applicata**.

- `Modules/Geo/app/Services/` contiene 8 file: `BaseGeoService.php`, `GeoDataService.php`, `GeoDataValidator.php`, `GeoService.php`,
  `GeocodingService.php`, `GoogleMapsService.php`, `HereService.php`, `MapService.php`. `BaseGeoService.php:18` dichiara ancora
  `abstract class BaseGeoService`, la classe che la Decisione dice rimossa.
- `Modules/Geo/tests/Arch/debt.php` li elenca tutti e 8 (righe 30-37, chiave `services` alla riga 29), con i commenti «HEAD (2026-11-20)
  dichiarava services => [] ma i file esistono ancora: elenco allineato al filesystem» e «non mass-delete Services — restano in debito
  finche' i chiamanti migrano alle Action»: la regola Arch passa perche' il debito la silenzia, mentre `NoServicesTest` (confronto con `[]`)
  fallirebbe su `Modules/Geo/app/Services` (lettura del test; non eseguito in questa passata).
- Nessun chiamante da migrare: `rg -n "Geo\\Services" Modules Themes app config routes bootstrap`, esclusi `docs` e la cartella
  `app/Services`, trova solo `tests/Arch/debt.php` e i tre test `tests/Unit/Services/GoogleMapsServiceTest.php`, `HereServiceTest.php`,
  `ServicesTest.php`.
- Decisione che serve al lead (non presa qui, il codice non e' stato toccato): cancellare i file e i tre test e mettere `'services' => []`
  in `debt.php`, come vuole la Decisione; oppure segnare questo ADR `superseded` e scrivere perche' i Service restano.
