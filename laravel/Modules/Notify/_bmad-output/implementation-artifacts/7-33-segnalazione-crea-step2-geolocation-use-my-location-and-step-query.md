# Story 7-33: segnalazione-crea — step 2 «Usa la tua posizione», coordinate su Ticket, URL `?step=2`

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL verifica**: `http://127.0.0.1:8000/it/tests/segnalazione-crea` (step 2 dati)  
**Query QA**: `.../segnalazione-crea?step=2` (vedi vincoli sotto)

**Ultimo aggiornamento documento**: 2026-04-09

---

## Story

Come **cittadino che compila la segnalazione** e come **operatore che verifica i dati**,  
voglio che il link **«Usa la tua posizione»** nello **step 2** del wizard **acquisisca la posizione** (con consenso del browser), **compili il luogo** e **salvi latitudine/longitudine** sul Ticket quando possibile,  
e che l’URL con **`?step=2`** sia **documentato e utilizzabile** negli ambienti previsti,  
così il flusso rispetta lo **scopo del Design Comuni** (localizzare il disservizio) e il **modello di dominio** (`Ticket` ha già `latitude` / `longitude`).

---

## Scopo di business (perché esiste l’elemento)

| Elemento UI | Scopo |
|-------------|--------|
| Campo indirizzo / luogo | Descrizione leggibile del punto del disservizio (comunicazione al cittadino e testo operativo). |
| **«Usa la tua posizione»** | Ridurre attrito: precompilare il luogo usando **GPS** del dispositivo e, se serve, **reverse geocoding** (coordinate → indirizzo testuale). |
| Coordinate su `Ticket` | Mappe, analisi territoriali, regole di prossimità (vedi anche `FilterCoordinatesInRadius` nel modulo). |

Oggi nel wizard il controllo è un **`<a href="#">` senza comportamento** (`ticket-create-wizard.blade.php`): va sostituito con un’azione esplicita (bottone o link con `wire:click` / Alpine) che invoca la Geolocation API **solo dopo gesto utente** (best practice [web.dev user-location](https://web.dev/user-location/), [MDN Geolocation API](https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API)).

---

## Vincoli tecnici (browser e sicurezza)

- **Secure context**: in molti browser la Geolocation richiede **HTTPS** (in locale `http://127.0.0.1` è spesso considerato “secure” per eccezione; verificare su ambiente reale).  
- **User gesture**: chiamare `getCurrentPosition` in risposta al click su «Usa la tua posizione», **non** al load della pagina (evitare warning Lighthouse / Chrome).  
- **Permessi negati / errore**: messaggio accessibile (traduzione `fixcity::segnalazione.*`) senza bloccare il flusso: l’utente può sempre digitare l’indirizzo a mano.

---

## URL `?step=2` e hash `#`

- Lo **stato step** è lato server/Livewire (`$currentStep`), non l’hash.  
- **`#` nel solo URL non imposta lo step**: per aprire direttamente lo step 2 si usa **`?step=2`**.  
- La logica esiste già in `CreateTicketWizardWidget::applyInitialStepFromQuery()` ma è **consentita solo** se:
  - `app()->isLocal()` **oppure**
  - `config('app.debug')` **oppure**
  - `config('fixcity.wizard.allow_step_query_override')` (env `FIXCITY_WIZARD_ALLOW_STEP_QUERY`).  

**Task documentazione + prodotto**: in `.env.example` / README modulo spiegare quando usare `FIXCITY_WIZARD_ALLOW_STEP_QUERY=true` (es. staging QA) senza abilitarlo in produzione se non voluto.

---

## Implementazione attesa (linee guida, senza imporre librerie npm extra)

1. **Widget Livewire** (`CreateTicketWizardWidget`):
   - Proprietà pubbliche opzionali: es. `public ?string $latitude = null`, `public ?string $longitude = null` (allineate a `Ticket` come stringhe o cast coerenti).
   - Metodo pubblico invocabile dal client: es. `setLocationFromCoordinates(float|string $lat, float|string $lng): void` che aggiorna `latitude`, `longitude` e, se implementato, delega il **reverse geocode** a una **Spatie Queueable Action** (no Service class) nel modulo Fixcity, es. `ReverseGeocodeAddressAction` che:
     - chiama un servizio HTTP **server-side** (es. [Nominatim OSM](https://nominatim.org/release-docs/latest/api/Reverse/) con `User-Agent` identificativo del progetto e rispetto [Usage Policy](https://operations.osmfoundation.org/policies/nominatim/): max ~1 req/s, niente scraping),
     - oppure provider configurabile (`config/fixcity.php`) se in futuro si usa API a pagamento.
   - Aggiornare `submit()` per includere `latitude` / `longitude` nel payload `Ticket::create()` se valorizzati (campi già in `$fillable` del modello `Modules\Fixcity\Models\Ticket`).

2. **Vista** (`ticket-create-wizard.blade.php`):
   - Sostituire lo stub sotto «Luogo» con **bottone** `type="button"` accessibile (o link con `role="button"`) che:
     - usa `@script` Livewire 3 o `@click` + `$wire` per `navigator.geolocation.getCurrentPosition` → poi `$wire.setLocationFromCoordinates(...)` o metodo dedicato.
   - Mostrare stato: caricamento / errore (testi in lang file, struttura 5 livelli).

3. **Test**:
   - Pest: test unitario sull’Action (mock HTTP) se si aggiunge reverse geocode.
   - Feature: opzionale mock Livewire senza browser reale.

4. **Privacy**: non loggare coordinate in chiaro nei log applicativi in produzione; rispettare informativa privacy già accettata allo step 1.

---

## Riferimenti interni (evitare duplicazione)

- Architettura wizard: [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md) — sezione **Geolocalizzazione e query `?step=`** (aggiornata con questa story).  
- Pattern Livewire già presente nel modulo: `resources/views/filament/widgets/location-form.blade.php` (solo `lat`/`lng`, senza reverse geocode).  
- Modello: `Ticket::getLatLngAttributes()` e `latitude` / `longitude` in fillable.

---

## Acceptance criteria (BDD)

```gherkin
Feature: Posizione nello step 2 del wizard segnalazione-crea

  Scenario: Click su Usa la tua posizione richiede geolocalizzazione
    Dato che sono allo step 2 con browser che supporta Geolocation
    Quando clicco «Usa la tua posizione»
    Allora viene richiesto il consenso posizione se non già concesso
    E in caso di successo le coordinate sono salvate nel componente Livewire
    E il campo indirizzo può essere compilato (manualmente o da reverse geocode se implementato)

  Scenario: Submit con coordinate
    Dato che lat/lng sono valorizzate
    Quando invio la segnalazione
    Allora il Ticket creato contiene latitude e longitude coerenti con il widget

  Scenario: QA apre step 2 via query
    Dato un ambiente con override consentito
    Quando apro /it/tests/segnalazione-crea?step=2
    Allora vedo lo step 2 (dati) senza dover passare dallo step 1
```

---

## Tasks / Subtasks

- [ ] Allineare UI «Usa la tua posizione» a bottone + handler (gesto utente)
- [ ] Aggiungere proprietà e metodi Livewire per coordinate (e indirizzo se reverse geocode)
- [ ] Implementare Action reverse geocode (HTTP server-side) o, MVP, solo coordinate + indirizzo vuoto con messaggio «completa indirizzo»
- [ ] Estendere `submit()` con `latitude` / `longitude`
- [ ] Traduzioni messaggi errore / help
- [ ] Documentare `?step=` e env in modulo; link da indice tema
- [ ] Test Pest mirati

---

## Definition of Done

- Nessun `href="#"` muto sul flusso luogo; comportamento verificabile in locale HTTPS o 127.0.0.1.
- Docs modulo aggiornate (una sezione unica, nessun secondo file sullo stesso argomento).
- Story passa a `review` dopo implementazione e verifica manuale step 2.

---

## Dev Agent Record

_(da compilare in implementazione)_

---

## File List

_(da compilare in implementazione)_

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-09 | SM | Story creata: geolocation step 2, ?step=2, Ticket lat/lng |

---

## Status

ready-for-dev
