# Story 7-42: segnalazione-crea — busy feedback su «Usa la tua posizione»

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL verifica**: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2`  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **cittadino che compila una segnalazione**,  
voglio vedere subito che il click su **«Usa la tua posizione»** sta davvero lavorando,  
così non interpreto il silenzio del browser come un bug e non clicco più volte lo stesso controllo.

---

## Perché esiste questa story

- La geolocalizzazione browser è **asincrona** e può restare in attesa per permessi, GPS e rete.
- Nel flusso reale c'è anche il **reverse geocoding** verso Nominatim, quindi l'attesa non finisce col click.
- Senza busy feedback l'utente non distingue tra:
  - click ricevuto,
  - popup permessi aperto ma invisibile,
  - richiesta lenta,
  - errore.

Questa non è una rifinitura estetica. È la regola UX di base: **visibility of system status**.

Fonti:
- MDN Geolocation API: `getCurrentPosition()` avvia una richiesta asincrona di posizione e richiede gestione success/error/timeouts.  
  https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API/Using_the_Geolocation_API
- Nominatim Reverse API / usage policy: il reverse geocoding è una seconda attesa e va trattato come lavoro in corso, non come operazione istantanea.  
  https://nominatim.org/release-docs/latest/api/Reverse/  
  https://operations.osmfoundation.org/policies/nominatim/

---

## Regola architetturale

- Il comportamento di **«Usa la tua posizione»** appartiene a **Geo**, non a Fixcity.
- Il busy feedback va quindi implementato nel componente proprietario:
  `Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- Fixcity consuma il componente; non deve duplicare spinner, JS o stato locale della geolocalizzazione.
- Se esiste già uno spinner riusabile nel tema, Geo lo riusa invece di reinventarlo.

---

## Visione / filosofia / zen

- **Un click deve sempre avere una risposta visibile.**
- **Un'azione lenta senza feedback è indistinguibile da un bug.**
- **Il dominio proprietario del comportamento possiede anche il suo stato di caricamento.**
- **Spinner da solo non basta**: servono anche testo/stato accessibile e blocco dei click duplicati.

---

## Implementazione attesa

1. Nel componente `address-input.blade.php` introdurre uno stato locale esplicito, ad esempio:
   - `idle`
   - `locating`
   - `reverse_geocoding`
   - `error`

2. Al click su **«Usa la tua posizione»**:
   - disabilitare il controllo subito;
   - mostrare spinner o indicatore di progresso già disponibile nel tema;
   - mostrare una label runtime tradotta tipo `geo::address.geolocation.loading.label`.

3. Durante `navigator.geolocation.getCurrentPosition(...)`:
   - mantenere `aria-busy="true"`;
   - impedire click multipli;
   - non usare testo hardcoded in italiano dentro JS/PHP.

4. Durante il `fetch()` di reverse geocoding:
   - mantenere lo stesso busy state;
   - opzionalmente distinguere il messaggio tra:
     - ricerca posizione
     - recupero indirizzo

5. In tutti i rami finali:
   - success
   - permission denied
   - timeout
   - browser unsupported
   - reverse geocode error

   ripristinare sempre lo stato `idle`.

---

## Acceptance Criteria

```gherkin
Feature: Busy feedback su Usa la tua posizione

  Scenario: Click ricevuto
    Dato che sono allo step 2 del wizard
    Quando clicco "Usa la tua posizione"
    Allora vedo immediatamente un indicatore di caricamento
    E il controllo non è cliccabile una seconda volta

  Scenario: Geolocalizzazione lenta
    Dato che il browser impiega alcuni secondi a risolvere la posizione
    Quando la richiesta è in corso
    Allora il componente mostra uno stato busy accessibile
    E l'utente capisce che il sistema sta lavorando

  Scenario: Errore o permesso negato
    Dato che la geolocalizzazione fallisce
    Quando il browser restituisce errore
    Allora l'utente vede il messaggio tradotto corretto
    E lo spinner scompare
    E il controllo torna disponibile

  Scenario: Successo con reverse geocoding
    Dato che la geolocalizzazione ha successo
    Quando il reverse geocoding completa
    Allora l'indirizzo viene scritto nel campo
    E lo stato busy termina
```

---

## File candidati

- `laravel/Modules/Geo/resources/views/filament/forms/components/address-input.blade.php`
- `laravel/Modules/Geo/lang/it/address.php`
- `laravel/Modules/Geo/lang/en/address.php`
- `laravel/Themes/Sixteen/resources/views/components/feedback/spinner.blade.php` solo se serve riuso/contract, non per spostare lì la logica geo
- `laravel/Modules/Geo/docs/address-field.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`

---

## Vincoli

- Niente hardcode italiano nel runtime.
- Niente duplicazione del flusso geo dentro Fixcity.
- Niente layer JS gratuiti: Alpine locale basta.
- Nessun refactor del wizard Fixcity se il problema vive già nel field Geo.

---

## Definition of Done

- Click su **«Usa la tua posizione»** mostra sempre feedback visibile entro il primo frame utile.
- Lo stato busy copre geolocalizzazione e reverse geocoding.
- I testi runtime sono tradotti.
- Il controllo torna a `idle` in tutti i rami.
- Docs Geo/Fixcity/Sixteen aggiornate con il pattern.

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per busy feedback geolocalizzazione |

---

## Status

ready-for-dev
