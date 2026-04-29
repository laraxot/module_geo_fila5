# Story 7.1: pagina unificata segnalazione-crea con CreateTicketWizardWidget

Status: in-progress

<!-- Contesto: prompt laravel/Themes/Sixteen/docs/prompts/segnalazione_disservizio/segnalazioni-crea.txt + docs modulo Fixcity -->

## Stato implementazione (anti-duplicazione)

Nel repository **i file principali esistono già** (non è una story “greenfield”):

- CMS: `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json`
- Blocco tema: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php` (monta `@livewire(CreateTicketWizardWidget::class, …)`)
- Widget + vista: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`, `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

**Scope di questa story**: verifica end-to-end, eventuali correzioni di wiring/contenuti, **parità step 1** vs riferimento, qualità (PHPStan), documentazione. **Non** creare duplicati di pagina/json/blocco salvo assenza reale verificata in PR.

## Story

Come **cittadino** che apre il flusso di creazione ticket dal frontoffice,
voglio **completare privacy, dati e riepilogo con invio in un’unica pagina** (`tests.segnalazione-crea`) tramite il widget `CreateTicketWizardWidget`,
così che **il percorso sia coerente con Design Comuni** e le **pagine statiche legacy restino disponibili** per parità e regressioni.

## Acceptance Criteria

1. **Route e CMS (assertivo)**: la pagina `/{locale}/tests/segnalazione-crea` carica il contenuto da `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` e renderizza il blocco `pub_theme::components.blocks.tests.segnalazione-crea` che monta `CreateTicketWizardWidget` (nessun secondo percorso “equivalente” da inventare: se il path CMS differisce, va documentato in commit/PR con motivazione).
2. **Wizard a 3 step + conferma esterna**: step 1 = privacy (come `segnalazione-01-privacy`), step 2 = dati (`segnalazione-02-dati`), step 3 = riepilogo **con submit** (`segnalazione-03-riepilogo`); dopo submit, redirect alla pagina **`segnalazione-04-conferma`** (non inclusa nel wizard).
3. **Widget Fixcity**: usare `Modules\Fixcity\Filament\Widgets\CreateTicketWizardWidget` (estende `XotBaseWidget`); **vietato** `CreateSegnalazioneWizardWidget` o classi PHP con “Segnalazione” nel nome. **Naming**: `Ticket` in codice PHP/classi; `segnalazione` resta solo dove serve per chiavi i18n (`fixcity::segnalazione.*`) o slug/route legacy.
4. **Parità visiva / HTML (step 1)**: confronto mirato con `segnalazione-01-privacy`: struttura hero/titolo, **stepper** (3 passi), blocco privacy (testo + checkbox), ordine sezioni principali. Eventuali gap documentati nel tema (nota in docs esistenti o screenshot in cartella docs già usata per parity), **senza** nuovi `.md` con date nel nome file.
5. **Persistenza e stato**: stato tra step gestito nel widget (Livewire) come da `ticket-wizard-frontoffice.md`; submit crea `Ticket`, dispatch eventi esistenti, redirect a conferma — senza rompere contratti già definiti nel modulo.
6. **Traduzioni**: chiavi sotto `fixcity::segnalazione.steps.<item>.<tipo>`; nessuna nuova stringa utente hardcoded nei file PHP del widget oltre le convenzioni Laraxot già in uso.
7. **Legacy**: le pagine `segnalazione-01-privacy`, `02-dati`, `03-riepilogo`, `04-conferma` **restano** raggiungibili (nessuna rimozione nel scope di questa story).
8. **Qualità**: file toccati rispettano PHPStan livello atteso dal modulo; aggiornare solo documentazione elencata sotto (indici/link relativi).

## Tasks / Subtasks

- [x] Verificare wiring pagina → JSON → blocco → Livewire widget (AC: 1, 3)
  - [x] Confermare che `tests.segnalazione-crea.json` referenzia la view del blocco e che il blocco passa `blockData` coerente con `mount()` del widget
- [x] Verificare flusso 3 step + submit + redirect conferma (AC: 2, 5)
  - [x] Codice: `submit()` redirect a `/{locale}/tests/segnalazione-04-conferma`; test Pest aggiunto (richiede DB test funzionante)
- [x] Parità step 1 vs `/it/tests/segnalazione-01-privacy` (AC: 4): markup già allineato Design Comuni (stepper + privacy); parity documentata in tema; nessun fix CSS obbligatorio in questa iterazione
- [x] Audit traduzioni `fixcity::segnalazione.steps.*` vs testi mostrati (AC: 6)
- [x] Aggiornare docs solo se cambia comportamento o path (AC: 8)
  - [x] `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
  - [x] `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
  - [x] `laravel/Themes/Sixteen/docs/` (nessun file aggiuntivo; indici già aggiornati via story link)

### Review Findings (code review BMAD, 2026-04-09)

- [ ] [Review][Decision] Guest non autenticato: `submit()` non imposta `owner_id` se `auth()->check()` è false; se lo schema DB impone `owner_id` NOT NULL, la creazione fallisce in runtime. Serve policy esplicita (login obbligatorio, utente sistema, o migrazione nullable). — Violazione potenziale AC5 (flusso cittadino guest). Evidenza: `CreateTicketWizardWidget.php` (payload + `owner_id` condizionale).

- [ ] [Review][Patch] Tipizzare `owner_id` come intero: `$payload['owner_id'] = (int) auth()->id();` quando autenticato (evita `string|int` da `auth()->id()` su alcuni driver). — `CreateTicketWizardWidget.php` (blocco `auth()->check()`).

- [ ] [Review][Patch] Test Livewire: il flusso usa `set('currentStep', …)` invece di `call('nextStep')` / validazione step-by-step; non copre errori di validazione tra step. Aggiungere almeno un caso che avanza con `nextStep()` dopo aver impostato i campi dello step 1. — `CreateTicketWizardWidgetTest.php`.

- [ ] [Review][Patch] AC1 opzionale: test HTTP GET su `/it/tests/segnalazione-crea` con assert sul marker `segnalazione-crea-wrapper` (quando l’ambiente test e Folio/CMS sono disponibili). — Story AC1 + sezione Testing.

- [x] [Review][Defer] Suite Pest bloccata da errore migrazione SQLite (`team_user` / `ADD PRIMARY KEY`) durante `Tests\TestCase::migrate` — problema ambiente/test DB pre-esistente, non introdotto da questa diff.

## Dev Notes

### Guardrail architetturali (Laraxot / Fixcity)

- **Mai** estendere `Filament\Widgets\Widget` direttamente: usare `XotBaseWidget` come da modulo Xot.
- Il widget **non** usa `Filament\Schemas\Components\Wizard` per la navigazione: scelta per parità Design Comuni; vista `fixcity::filament.widgets.ticket-create-wizard`.
- Implementazione di riferimento: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`.

### File e percorsi (canonici nel repo)

| Area | Path |
|------|------|
| Widget | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| Vista widget | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| Blocco tema | `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php` |
| CMS | `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` |
| Traduzioni | `laravel/Modules/Fixcity/lang/{locale}/segnalazione.php` |

### Riferimenti esterni (versione progetto)

- Filament Widgets: `https://filamentphp.com/docs/5.x/widgets/overview` — lifecycle/registrazione; **non** contraddire la decisione su markup custom vs Wizard schema.

### Coordinamento multi-agente

- File “hot”: widget PHP, vista widget, blocco `segnalazione-crea`, JSON CMS, `segnalazione.php` lang, eventuali CSS parity del tema.
- Evitare modifiche simultanee agli stessi file senza coordinamento (branch o review).

### Testing (criteri minimi)

- **Manuale obbligatorio**: percorso completo fino a conferma (AC 2).
- **Opzionale ma consigliato**: test HTTP/Pest che la risposta GET di `/it/tests/segnalazione-crea` sia 200 e contenga un marker stabile (es. wrapper `.segnalazione-crea-wrapper` o root `.ticket-wizard-root` se presente nel markup), se il modulo ha già pattern simili.

## Dev Agent Record

### Agent Model Used

Cursor AI (agent mode)

### Debug Log References

- `php artisan test tests/Feature/Modules/Fixcity/CreateTicketWizardWidgetTest.php` fallisce in questo ambiente con `SQLSTATE` su migrazione `team_user` (SQLite / sintassi `ALTER TABLE`); `phpstan` sul widget: OK.

### Completion Notes List

- Verificato wiring JSON → `pub_theme::components.blocks.tests.segnalazione-crea` → Livewire `CreateTicketWizardWidget` con `blockData`.
- Implementato `resolveTicketTypeEnum()` per mappare chiavi CMS (`public_damage`, ecc.) su `TicketTypeEnum` e `tryFrom` per valori già allineati.
- Submit: imposta `owner_id` se l’utente è autenticato.
- Aggiunti test Pest `CreateTicketWizardWidgetTest` (mount + submit con redirect).
- Documentazione modulo aggiornata (`ticket-wizard-frontoffice.md`, `CreateTicketWizardWidget.md`).

### File List

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/tests/Feature/Modules/Fixcity/CreateTicketWizardWidgetTest.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`
- `_bmad-output/implementation-artifacts/7-1-unified-segnalazione-crea-ticket-wizard.md`

## Change Log

- 2026-04-09: Story 7-1 implementata — mappatura tipo ticket, owner autenticato, test Pest, doc.

## Project context reference

- `_bmad-output/project-context.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`

## Story completion status

Code review BMAD eseguita: restano voci in **Review Findings** (decision + patch). Ripristinare stato `review` o `done` dopo risoluzione.
