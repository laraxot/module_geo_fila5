# Story 7-34: CreateTicketWizardWidget — refactor a Filament Schema `Wizard` (v5)

**Stato**: done  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**Riferimento ufficiale Filament**: [Schemas — Wizards](https://filamentphp.com/docs/5.x/schemas/wizards)  
**Vista widget**: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` (wrapper titolo/contatti + `{{ $this->form }}`)  
**Classe**: `Modules\Fixcity\Filament\Widgets\CreateTicketWizardWidget` (estende `XotBaseWidget`)

**Ultimo aggiornamento documento**: 2026-04-09

---

## Story

Come **sviluppatore del modulo Fixcity**,  
voglio che il flusso di creazione ticket sul frontoffice usi la **Filament way** per i passi multipli, cioè `Filament\Schemas\Components\Wizard` e `Wizard\Step` con schema dichiarato in PHP,  
così **navigazione, validazione per step, submit sull’ultimo passo e persistenza step in query** sono gestiti dal framework invece di markup Blade monolitico e stato manuale (`$currentStep`, `nextStep()`, ecc.).

---

## Contesto: perché c’era Blade “hardcoded”

Storicamente il widget aveva `getFormSchema(): array` vuoto e una vista Blade molto lunga per **parità HTML/CSS con Design Comuni** (Bootstrap Italia replicato nel tema Sixteen). Questo creava duplicazione di step e validazione.

**Implementazione (2026-04)**: `getFormSchema()` espone `Wizard::make()` con tre `Step`, stato in `data` (`XotBaseWidget`), `submitAction()`, `nextAction`/`previousAction`, `persistStepInQueryString('step')` quando l’override è consentito, `startOnStep()` da `wizardStartStep`. Riferimenti esterni: [Wizards Filament v5](https://filamentphp.com/docs/5.x/schemas/wizards); su Livewire pubblico assicurare layout con `@filamentStyles` / `@filamentScripts` se gli asset non sono già nel tema (vedi [discussione Stack Overflow](https://stackoverflow.com/questions/79542652/filamentphp-form-wizard-on-livewire-component-not-using-filamentstyles-or-fila)).

---

## Decisioni di prodotto / architettura (da confermare in implementazione)

### 1) Parità visiva Design Comuni vs componenti Filament

| Approccio | Pro | Contro |
|-----------|-----|--------|
| **A — Wizard Filament “default”** + CSS tema (`segnalazione-parity.css`) per avvicinare al reference | Meno Blade custom; usa `nextAction()` / `previousAction()` / `submitAction()` | Può differire dal pixel-perfect del reference |
| **B — `Step::schema()` con campi + `ViewField` / `Placeholder` / Blade view** per blocchi critici (stepper header, card) | Maggiore controllo HTML | Più codice; va rispettata regola traduzioni (no label hardcoded) |
| **C — Ibrido**: `Wizard` Filament per stato e validazione; sotto-step con `customView` o componenti Blade registrati come field | Bilanciamento | Richiede disciplina sui confini |

**La story impone**: usare **`Wizard::make([...])` in `getFormSchema()`** (non più array vuoto). La scelta A/B/C va documentata in `ticket-wizard-frontoffice.md` in una sola sezione aggiornata, senza creare un secondo file sullo stesso argomento.

### 2) Stato form e `XotBaseWidget`

`XotBaseWidget` configura `Schema` con `statePath('data')` (vedi `Modules\Xot\Filament\Widgets\XotBaseWidget::form()`).  
Migrazione tipica:

- mappare i campi attuali (`privacyAccepted`, `address`, …) in **`$data['key']`** oppure usare un **Form Model** / DTO coerente con Filament;
- rimuovere `public int $currentStep` se sostituito dallo stato interno del `Wizard` (o sincronizzarlo solo se necessario per URL legacy).

### 3) Funzionalità Filament da usare (documentazione)

Da [Wizards](https://filamentphp.com/docs/5.x/schemas/wizards):

- **`Step::make()`** + `->schema([...])` per ogni passo (privacy, dati, riepilogo).
- **`persistStepInQueryString()`** (opzionale `?step=` o chiave custom) per sostituire o integrare `applyInitialStepFromQuery()` manuale.
- **`startOnStep()`** se serve aprire uno step iniziale da logica server.
- **`beforeValidation()` / `afterValidation()`** sui singoli step al posto di `nextStep()` con validate inline.
- **`submitAction()`** sull’ultimo step per il bottone “Conferma e invia” (come da doc).
- **`nextAction()` / `previousAction()`** per etichette e stile allineati alle traduzioni `fixcity::segnalazione.actions.*`.

### 4) Vista del widget

Oggi: `protected string $view = 'fixcity::filament.widgets.ticket-create-wizard';`

Dopo refactor: valutare vista minimale che renderizza **solo** il form (`{{ $this->form }}` o equivalente previsto da `XotBaseWidget` / tema), oppure estendere `xot::filament.widgets.base` se già include il form.  
**Non** duplicare centinaia di righe di markup se il `Wizard` li genera.

### 5) Regole Laraxot

- Estendere **`XotBaseWidget`** (già fatto).
- **Actions** per logica dominio riusabile (es. submit ticket), non `Service` class.
- Traduzioni: chiavi `fixcity::segnalazione.*` strutturate; niente `->label()` hardcoded nei field senza lang.
- **PHPStan livello 10** sui file PHP toccati.

---

## Acceptance criteria (BDD)

```gherkin
Feature: Wizard ticket Filament Schema

  Scenario: Schema non è vuoto
    Dato il widget CreateTicketWizardWidget
    Allora getFormSchema() restituisce almeno un Wizard con tre Step
    E i campi principali sono definiti nello schema, non solo in Blade statico

  Scenario: Ultimo step ha submit
    Dato il wizard configurato
    L’invio finale usa il pattern submitAction() o equivalente documentato Filament v5

  Scenario: Query step (opzionale)
    Dato persistStepInQueryString abilitato dove serve
    Allora lo step corrente è riflesso nella query string senza logica duplicata fragile
```

---

## Tasks / Subtasks

- [x] Analizzare `XotBaseWidget` / rendering form nel widget
- [x] Mappatura stato su `data` + wrapper schema `ticket_create_wizard` + `normalizeDehydratedState()`
- [x] Implementare `Wizard::make([Step::make('1'|'2'|'3')])` con campi Filament
- [x] Validazione step via wizard; submit finale con `Validator` su stato disidratato
- [x] Rimossi `nextStep`/`prevStep` manuali
- [x] `submit()` mantiene creazione `Ticket`, evento, redirect
- [ ] Test Pest dedicati (CreateTicketWizardWidgetTest) — backlog opzionale
- [x] `docs/ticket-wizard-frontoffice.md` aggiornato
- [x] Vista Blade ridotta a wrapper + `{{ $this->form }}`

---

## Rischi e mitigazioni

- **Rischio**: regressione parity HTML. **Mitigazione**: screenshot/visual parity su `/it/tests/segnalazione-crea` prima/dopo; CSS tema invariato dove possibile.
- **Rischio**: Livewire + file upload nel wizard. **Mitigazione**: usare `FileUpload` / `WithFileUploads` come da doc Filament per lo step immagini.
- **Rischio**: tempo di sviluppo elevato. **Mitigazione**: story può essere spezzata in sotto-PR (solo schema + poi styling).

---

## Riferimenti interni

- [ticket-wizard-frontoffice.md](../../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [XotBaseWidget.php](../../../laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php)
- Story correlate: 7-32 (CTA/step copy), 7-33 (geolocation), 7-29 (header)

---

## Dev Agent Record

- **Approccio parity**: A (wizard Filament default) + CSS tema / seguimenti in story 7-32/7-33 per pixel parity.
- **Dipendenze**: `filament/filament` ^5 già in `laravel/composer.json`; nessun pacchetto aggiuntivo richiesto.

---

## File List

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-crea/README.md`

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-09 | SM | Story creata: migrazione a Filament Schema Wizard v5 |
| 2026-04-09 | Dev | Implementazione Wizard + Step, vista slim, doc modulo/tema |

---

## Status

done
