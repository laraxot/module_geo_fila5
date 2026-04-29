# Story 7.40: CreateTicketWizardWidget — pulizia label/tooltip, Log::error, metodi duplicati in XotBase

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)  
**Ultimo aggiornamento**: 2026-04-14

---

## Story

Come **sviluppatore che mantiene il wizard segnalazione**,  
voglio che `CreateTicketWizardWidget` non contenga **override ridondanti** già gestiti da `XotBaseWizardWidget` e che non usi mai `->label()` / `->tooltip()` né `Log::error()`,  
così il codice rispetta la politica DRY del progetto e ogni violazione appena introdotta non si propaga silenziosamente.

---

## Contesto e Zen (perché queste regole esistono)

### 1. `->label()` e `->tooltip()` sono proibiti — perché

`LangServiceProvider::registerFilamentLabel()` registra tre `configureUsing()` hook:

| Hook | Cosa auto-applica |
|------|-------------------|
| `Field::configureUsing()` | `label`, `placeholder`, `helperText`, `description` |
| `Action::configureUsing()` | `label`, `tooltip` |
| `Step::configureUsing()` | `label` |

`AutoLabelAction` risolve la chiave di traduzione dal contesto della classe chiamante.  
Se la chiave non esiste nel file lang, la **crea automaticamente** (auto-save).

**Conseguenza**: scrivere `->label('...')` o `->tooltip('...')` è un clone hardcoded che:
- bypassa il sistema i18n automatico,
- rompe il DRY (stesso testo in codice + file lang),
- rende impossibile tradurre senza toccare il PHP.

**Regola**: MAI `->label(` o `->tooltip(` nei widget/form Filament. Il lang file è la fonte di verità.

### 2. `Log::error()` è proibito — perché (zen)

Il progetto segue la filosofia **"fail fast, fail visibly"** e delega il logging agli strati di infrastruttura:

- I catch block nei widget devono **rilanciare** o **notificare l'utente** — non loggare silenziosamente.
- `Log::error()` nasconde il problema nella pagina mentre il log file cresce in silenzio.
- Nei contesti Filament usa `Notification::make()->danger()->send()` per feedback immediato.
- Gli errori non previsti vanno a Sentry/Bugsnag/exception handler globale Laravel — **non** al widget.
- Un widget non è responsabile di decidere la severity di un errore applicativo: questo spetta all'exception handler.

**Regola**: Nessun `Log::error(`, `Log::warning(`, `Log::info(` nei widget Filament.  
Catch accettabili: rilanciare l'eccezione, oppure mostrare `Notification::danger()` e `addError()`.

### 3. Boolean flag hook methods — perché sono un anti-pattern

`useNativeSubmitButton(): bool { return false; }` in `XotBaseWizardWidget` è "primitive obsession" applicato ai metodi.

Il pattern completo (`useNativeSubmitButton` + `getNativeSubmitButtonLabel` + `getNativeSubmitButtonClasses`) aggiunge 3 metodi all'API della classe base per un concern che il child potrebbe gestire con un solo override diretto.

**Conseguenze:**
- API base cresce inutilmente (3 metodi × ogni concern simile = esplosione combinatoria)
- Il child con `return true;` forza il lettore a leggere il parent per capire cosa succede
- False estensibilità: vincola tutti i figli a conoscere l'API hook invece di fare override libero

**Soluzione**: override diretto di `getWizardSubmitAction()` nel widget dominio. È polimorfismo corretto:
- Un metodo nel child, zero metodi extra nel parent
- Il comportamento è visibile direttamente nel child, senza indirezione

**Regola**: Se il child fa `return true;` su un boolean del parent → il child deve fare override del metodo che quel boolean controlla.

### 4. Metodi duplicati in XotBase — perché spostarli

Il principio è: **la classe base fa, la classe figlia specializza**.  
Se un metodo in `CreateTicketWizardWidget` è identico a quello in `XotBaseWizardWidget`, va rimosso dalla figlia.  
Tenerlo è un clone silenzioso: quando XotBase viene aggiornato, la figlia non eredita il fix.

---

## Analisi violazioni in `CreateTicketWizardWidget.php`

### Riepilogo DRY + KISS (tutti i pattern)

| # | Violazione | Categoria | Stato |
|---|-----------|-----------|-------|
| 1 | `getFormSchema()` duplicato | DRY | rimosso |
| 2 | `configureWizardNextAction()` + `->label()/->tooltip()` | DRY + policy | rimosso |
| 3 | `configureWizardPreviousAction()` + `->label()/->tooltip()` | DRY + policy | rimosso |
| 4 | `Log::error()` nel catch | policy | rimosso |
| 5 | `getWizardSubmitAction()` con HTML inline → `useNativeSubmitButton()` | DRY | sostituito |
| 6 | `$this->wizardStartStep = resolveInitialStepFromQuery()` in ogni widget | DRY | → `initWizardState()` in XotBase |
| 7 | `$this->form->fill($this->defaultFormData())` in ogni widget | DRY | → `initWizardState()` in XotBase |
| 8 | `$this->data = $data` dopo `form->getState()` | DRY | ridondante → rimosso |
| 9 | `catch (ValidationException $e) { throw $e; }` | KISS | catch inutile → rimosso |
| 10 | `$blockData = $this->blockData` in `render()` | KISS | copia inutile → rimosso |
| 11 | `use Filament\Schemas\Components\Wizard` | DRY | import non usato → rimosso |
| 12 | URL redirect hardcoded inline | KISS | → `getSubmitRedirectUrl()` |
| 13 | `$issueType` variabile intermedia | KISS | inlined |
| 14 | `createTicketFromFormData()` — wrapper a singola riga | KISS | rimosso |
| 15 | `validatedFormData()` — wrapper di assegnazione per type hint | KISS | rimosso |
| 16 | `useNativeSubmitButton(): bool { return true; }` — boolean flag hook | DRY + KISS | rimosso → override diretto `getWizardSubmitAction()` |
| 17 | `getNativeSubmitButtonLabel()` + `getNativeSubmitButtonClasses()` in XotBase | DRY | rimossi: hook chain inutile |

### Task 1 — Rimuovere `getFormSchema()` duplicato

**File**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

Il metodo `getFormSchema()` nella figlia è identico a quello in `XotBaseWizardWidget::getFormSchema()`.  
Va rimosso dalla figlia: la logica è già ereditata.

### Task 2 — Rimuovere `configureWizardNextAction()` override

Il metodo override chiama `->label()` e `->tooltip()` sulla action "Next" del wizard.  
**Violazione**: label/tooltip sono auto-gestiti da `LangServiceProvider`.  
Il metodo base in `XotBaseWizardWidget` restituisce già `$action` senza modifiche (comportamento corretto).  
Va rimosso dalla figlia.

### Task 3 — Rimuovere `configureWizardPreviousAction()` override

Stesso motivo di Task 2: override identico che chiama `->label()` / `->tooltip()`.  
Il metodo base è già corretto. Va rimosso dalla figlia.

### Task 4 — Rimuovere `Log::error()` da `submit()`

**File**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

Nel blocco `catch (\Throwable $e)`:
- Rimuovere la chiamata `Log::error(...)`.
- Mantenere `Notification::make()->danger()->send()` e `$this->addError()`.
- Rimuovere `use Illuminate\Support\Facades\Log;` se non usato altrove nel file.

Il catch attuale con Notification è già il pattern corretto — basta togliere il Log.

### Task 5 — Verificare `getWizardSubmitAction()` override

Questo override è **legittimo**: restituisce un `HtmlString` con `<button type="submit">` nativo  
necessario perché `@filamentScripts` non è caricato su `/tests/*` (pagine frontoffice).  
**Non va rimosso.** Documentare perché è un'eccezione consapevole.

---

## Acceptance Criteria

1. **GIVEN** il file `CreateTicketWizardWidget.php`  
   **WHEN** si cerca `->label(` o `->tooltip(`  
   **THEN** nessun risultato (grep vuoto)

2. **GIVEN** il file `CreateTicketWizardWidget.php`  
   **WHEN** si cerca `Log::`  
   **THEN** nessun risultato (grep vuoto)

3. **GIVEN** il file `CreateTicketWizardWidget.php`  
   **WHEN** si cerca `getFormSchema`  
   **THEN** nessun risultato: il metodo non è più ridefinito nella figlia

4. **GIVEN** `configureWizardNextAction` e `configureWizardPreviousAction`  
   **WHEN** si cerca nei file  
   **THEN** esistono solo in `XotBaseWizardWidget`, non in `CreateTicketWizardWidget`

5. **GIVEN** il submit del wizard  
   **WHEN** si completa il form  
   **THEN** il comportamento è identico a prima: redirect a `segnalazione-04-conferma`, notification in caso di errore

6. **GIVEN** un lang key mancante per Next/Previous step actions  
   **WHEN** si carica il wizard  
   **THEN** `AutoLabelAction` auto-genera le chiavi nel file lang `fixcity::create_ticket_wizard` senza errori

---

## File da toccare

| File | Operazione |
|------|-----------|
| `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php` | Aggiungere: `defaultFormData(): array`, `initWizardState(): void` |
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Vedi tabella violazioni sopra: 13 cleanup applicati |
| `laravel/Modules/Fixcity/lang/it/ticket_wizard.php` | Verificare/aggiungere chiavi `steps.1.label`, `steps.2.label`, `steps.3.label`, `actions.next.label`, `actions.previous.label` se mancanti |
| `laravel/Modules/Fixcity/lang/en/ticket_wizard.php` | Stesso dei lang it |
| `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` | Aggiornare: sezione architettura, policy label/tooltip, `getSubmitRedirectUrl()` |

---

## Docs da aggiornare (Task 6)

### 6a — `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
Aggiungere sezione **"Policy label/tooltip (mai usare)"** con link a LangServiceProvider.  
Documentare `getWizardSubmitAction()` come unico override legittimo e spiegare il perché (no `@filamentScripts` su `/tests/*`).

### 6b — `laravel/Modules/Xot/docs/` (o creare se mancante)
Aggiungere/aggiornare doc su `XotBaseWizardWidget`: lista metodi protetti, quali possono essere overridati, quali NON devono mai essere overridati.

### 6c — Regola nel progetto
Aggiornare `.agents/docs/main-rules/index.md` (o il file di regole appropriato) con:
- `->label()` / `->tooltip()` proibiti in widget Filament → rimandare a LangServiceProvider
- `Log::error()` proibito nei widget → rimandare a exception handler

---

## Guardrails per il dev

- NON usare `->label()`, `->tooltip()`, `->placeholder()` in nessun campo Filament.
- NON usare `Log::` nei widget — solo `Notification::danger()`.
- Se `AutoLabelAction` non trova una chiave lang, la crea automaticamente: controllare il file lang dopo il primo run per rifinire il copy.
- Eseguire `php artisan test --filter=CreateTicketWizard` se esistono test, altrimenti verificare manualmente su `/it/tests/segnalazione-crea`.
- Il file `XotBaseWizardWidget.php` è `sacro` — non modificarlo senza story dedicata.

---

## Riferimenti

| Cosa | Dove |
|------|------|
| Widget da modificare | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| Classe base wizard | `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php` |
| LangServiceProvider | `laravel/Modules/Lang/app/Providers/LangServiceProvider.php` |
| AutoLabelAction | `laravel/Modules/Lang/app/Actions/Filament/AutoLabelAction.php` |
| Docs wizard | `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` |
| Docs widget | `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` |
