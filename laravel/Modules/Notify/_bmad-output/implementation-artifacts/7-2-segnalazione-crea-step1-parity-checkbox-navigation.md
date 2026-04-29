# Story 7.2: step 1 wizard — parity privacy, checkbox visibile, navigazione step

Status: review

## Story

Come **visitatore** della pagina unificata di segnalazione,
voglio che lo **step 1 (privacy)** sia **visivamente allineato** al riferimento Design Comuni e che il **checkbox di accettazione sia chiaramente visibile**,
così che il flusso sia riconoscibile e accessibile come sulla pagina statica di riferimento; in questa fase la **navigazione tra step deve restare sequenziale** (niente salto libero tra step dall’interfaccia), con **opzione di URL dedicata** per aprire uno step specifico (es. verifica automatica / QA).

## Contesto e sintomi

- Pagina locale: `http://127.0.0.1:8000/it/tests/segnalazione-crea` (o `/{locale}/tests/segnalazione-crea`).
- Segnalazione: **il checkbox privacy non si vede** (o è quasi invisibile / non stilato come il riferimento).
- Riferimento visivo ufficiale: [segnalazione-01-privacy — Design Comuni (pagine statiche)](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html) (titolo, testi, stepper “1/3”, link informativa, checkbox + label “Ho letto…”, pulsante Avanti).
- **Analisi tecnica (root cause probabile)**: in `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` gli stili del **checkbox** (dimensioni, bordo, `appearance`, stato checked) sono definiti sotto **`.segnalazione-privacy-page .form-check input[type="checkbox"]`**, mentre il widget Livewire (`ticket-create-wizard.blade.php`) è dentro **`.ticket-wizard-root`** / pagina `body.page-tests-segnalazione-crea` **senza** quella classe wrapper: le regole generiche potrebbero non applicarsi all’input, con risultato **checkbox non visibile** o non conforme. La story deve **riusare o duplicare in modo DRY** le stesse regole per il wizard (es. selettore `body.page-tests-segnalazione-crea` e/o `.ticket-wizard-root`).

## Acceptance Criteria

1. **Checkbox visibile e cliccabile**: nello step 1 della pagina `tests/segnalazione-crea`, l’input privacy è visibile (dimensioni minime, bordo, contrasto) e coerente con il pattern Bootstrap Italia / reference; stato checked leggibile.
2. **Parità step 1 vs reference**: confronto con [segnalazione-01-privacy](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html): ordine contenuti (titolo → stepper → testi privacy → checkbox → area azioni), tipografia e spaziatura **non peggiorative** rispetto alla pagina statica locale `tests/segnalazione-01-privacy` (se presente nel progetto come baseline).
3. **Niente salto libero tra step (UI)**: gli elementi dello **stepper** sono solo **indicativi** del passo corrente (non devono permettere di saltare allo step 2 o 3 cliccando sulle label dei passi). Navigazione avanti/indietro solo tramite i controlli previsti (es. pulsanti Avanti / Indietro già presenti nel wizard).
4. **URL opzionale per step (QA / verifica)**: è possibile aprire uno step specifico tramite **query string** sulla stessa pagina, es. `?step=2`, con queste regole:
   - valori ammessi solo `1`, `2`, `3` (validazione lato server / Livewire);
   - documentare in `ticket-wizard-frontoffice.md` il comportamento;
   - **non** esporre in produzione comportamenti pericolosi: limitare l’uso a `local` / `APP_DEBUG` / feature flag di configurazione (decisione implementativa documentata), oppure accettare solo `step=1` in produzione se si preferisce massima cautela.
5. **Nessuna regressione**: non rimuovere `CreateTicketWizardWidget` né il blocco tema; non introdurre classi PHP con “Segnalazione” nel nome.
6. **Qualità**: PHPStan sul PHP toccato; aggiornare solo documentazione modulo/tema già elencata (link relativi).

## Tasks / Subtasks

- [x] Riprodurre il bug in locale (screenshot prima) e verificare computed style su `input#privacy` nella pagina wizard vs `segnalazione-01-privacy` — root cause: selettori CSS 26.3 solo su `.segnalazione-privacy-page`
- [x] Estendere CSS checkbox (sezione 26.3) con `body.page-tests-segnalazione-crea .ticket-wizard-root` (DRY, stessi valori)
- [x] Verificare layout step 1 in `ticket-create-wizard.blade.php` — già `form-check` / `checkbox-body` / `for="privacy"`
- [x] Stepper non cliccabile: CSS `pointer-events: none` su `.ticket-wizard-root .steppers-header li` (nessun `wire:click` sui `<li>`)
- [x] `?step=` in `CreateTicketWizardWidget::mount()` + `config('fixcity.wizard.allow_step_query_override')` + env `FIXCITY_WIZARD_ALLOW_STEP_QUERY`
- [x] Aggiornare `ticket-wizard-frontoffice.md`
- [x] Build asset tema (`npm run build` in `Themes/Sixteen`)

## Dev Notes

### File hot

| Area | Path |
|------|------|
| Widget | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| Vista wizard | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| CSS parity | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` |
| Config modulo | `laravel/Modules/Fixcity/config/config.php` |

### Dipendenze

- Story correlata: [7-1 unified segnalazione-crea ticket wizard](./7-1-unified-segnalazione-crea-ticket-wizard.md) (widget base).

### Testing

- Manuale: `/{locale}/tests/segnalazione-crea` — checkbox visibile; in local `?step=2` apre step 2.
- PHPStan: OK sul widget.

## Dev Agent Record

### Agent Model Used

Cursor AI

### Debug Log References

### Completion Notes List

- Sezione CSS 26.3 estesa con selettori wizard; stepper wizard con `pointer-events: none` sui `<li>`.
- **Fix critico checkbox**: aggiunti `opacity: 1 !important; position: static !important` all'input nella sezione 26.3 (senza questi BI imponeva `opacity:0; position:absolute` e il checkbox restava invisibile). Aggiunte regole per nascondere i pseudo-elementi `::before`/`::after` BI sul label (evita doppia visual checkbox). Label `position: static !important` per annullare `position:relative` di BI (non più necessario).
- `applyInitialStepFromQuery()` + `FIXCITY_WIZARD_ALLOW_STEP_QUERY` / local / debug.
- Doc `ticket-wizard-frontoffice.md` aggiornata.
- `npm run build` + `npm run copy` tema Sixteen eseguiti (nuovi hash in `public/manifest.json` / `public/assets/`).
- PHPStan: OK (zero errori). Test SQLite falliscono per bug pre-esistente `team_user` (non introdotto da questa story, documentato in 7-1).

### File List

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/config/config.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Themes/Sixteen/public/manifest.json`
- `laravel/Themes/Sixteen/public/assets/*` (output vite)
- `_bmad-output/implementation-artifacts/sprint-status.yaml`
- `_bmad-output/implementation-artifacts/7-2-segnalazione-crea-step1-parity-checkbox-navigation.md`

## Project context reference

- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

## Story completion status

Implementazione completata; pronta per code review (`/bmad-code-review`).
