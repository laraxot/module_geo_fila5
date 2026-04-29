# Story 7.39: segnalazione-crea — parity visiva step 1 (privacy) vs Design Comuni, wizard Filament

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)  
**Ultimo aggiornamento**: 2026-04-13

<!-- Validation: opzionale — `validate-create-story` prima di `dev-story`. -->

---

## Story

Come **cittadino che apre la creazione segnalazione**,  
voglio che **lo step 1 (autorizzazioni e privacy)** sulla nostra pagina locale sia **visivamente allineato** al reference ufficiale Design Comuni e che **stepper + navigazione multi-step** restino implementati con **Filament `Wizard` / `Step`**,  
così **UX, accessibilità e manutenibilità** restano coerenti con il modello Italia e con l’architettura Laraxot (nessun wizard “finto” solo Blade).

---

## Riferimenti obbligatori (fonte di verità)

| Ruolo | URL |
|--------|-----|
| **Pagina locale (da verificare)** | `http://127.0.0.1:8000/it/tests/segnalazione-crea` (ambiente dev; host può variare) |
| **Reference HTML Design Comuni — step 1 privacy** | [Segnalazione disservizio — privacy (statiche)](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html) |
| **Filament v5 — Wizards** | [Schemas — Wizards](https://filamentphp.com/docs/5.x/schemas/wizards) |

Elementi da confrontare sullo **step 1** (primo passo del wizard attivo):

- Titolo flusso **«Segnalazione disservizio»** e contesto breadcrumb/header pagina (se già in scope altre story, non duplicare lavoro: documentare delta).
- **Stepper** a tre passi: etichette coerenti con Design Comuni — il primo step deve risultare **«Autorizzazioni e condizioni»** (attivo), non sostituire con copy errato (vedi doc modulo).
- Testo informativa GDPR + link **informativa sulla privacy**.
- Checkbox **«Ho letto e compreso l’informativa sulla privacy»** (stato e copy).
- CTA **«Avanti»** (comportamento: passa allo step 2 tramite wizard Filament, non submit del ticket).
- Blocco **«Contatta il comune»** / footer pagina se nella stessa pagina test (parity per tema Sixteen).

---

## Acceptance Criteria (BDD-friendly)

1. **GIVEN** l’utente apre `/it/tests/segnalazione-crea`  
   **WHEN** è visualizzato lo step 1  
   **THEN** il markup strutturale e le classi visive del contenuto principale sono **allineati al reference** [segnalazione-01-privacy](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html) entro i limiti del tema (wrapper `data-tests-slug` / `.ticket-wizard-root`, **no** classi arbitrarie sul `<body>` — vedi policy parity).

2. **GIVEN** il flusso è il ticket wizard Fixcity  
   **WHEN** si ispeziona il codice  
   **THEN** navigazione tra step, validazione step e pulsanti next/prev/submit sono gestiti da **`Filament\Schemas\Components\Wizard`** + **`Wizard\Step`** in `CreateTicketWizardWidget::getFormSchema()` (estende `XotBaseWizardWidget`), **non** da stato manuale `$currentStep` in Blade come unico motore.

3. **GIVEN** lo stepper è mostrato in pagina  
   **WHEN** si confronta con il reference  
   **THEN** le etichette degli step e lo stato «attivo» sul primo passo rispettano le regole in [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md) e [stepper-component.md](../../laravel/Themes/Sixteen/docs/design-comuni/stepper-component.md) (incluso i18n it/en se in scope).

4. **GIVEN** modifica CSS per parity  
   **WHEN** si tocca solo presentazione  
   **THEN** gli interventi sono **scoped** (es. `segnalazione-parity.css`, `design-comuni-global-fixes.css`) e si esegue **build tema** (`npm run build` da `Themes/Sixteen/` dove applicabile).

5. **GIVEN** completamento  
   **WHEN** si chiude la story  
   **THEN** screenshot o nota in **visual parity** (cartella tema `storage/visual-parity/` o docs screenshot esistenti) documenta LOC vs REF per lo step 1, senza creare un secondo file `.md` nel modulo sullo stesso argomento: aggiornare **un solo** indice/doc puntato da `ticket-wizard-frontoffice.md`.

---

## Tasks / Subtasks

- [ ] **Mappatura delta** (AC: 1, 3): screenshot o lista differenze tra locale e reference su step 1 (stepper, tipografia, spaziature, checkbox, CTA).
- [ ] **Verifica architettura Filament** (AC: 2): confermare che `CreateTicketWizardWidget` usa solo `Wizard`/`Step` per i passi; rimuovere residui Blade che duplicano logica step se ancora presenti.
- [ ] **CSS / token** (AC: 1, 4): aggiustare classi scoped per avvicinare il rendering Filament al Design Comuni (checkbox, `.btn` / `mobile-full`, stepper).
- [ ] **Traduzioni** (AC: 3): chiavi `fixcity::segnalazione.*` allineate; nessuna `label()` hardcoded nei field Filament oltre le convenzioni modulo.
- [ ] **Regressione**: navigazione step 2–3 e `submit()` finale ancora funzionanti; `?step=` se abilitato in dev.
- [ ] **Doc**: aggiornare [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md) con 1 paragrafo «parity step 1 — 7-39» e link a questa story.

---

## Dev Notes — contesto tecnico (guardrail)

### Architettura (non negoziabile)

- **Widget**: `Modules\Fixcity\Filament\Widgets\CreateTicketWizardWidget` → `XotBaseWizardWidget` → `XotBaseWidget`.
- **Schema**: `Wizard::make([...])` con primo `Step` privacy (`privacyAccepted`); **non** reintrodurre wizard monolitico Blade per «parity».
- **Vista Blade**: `fixcity::filament.widgets.ticket-create-wizard` resta **wrapper** (titolo, contatti) + `{{ $this->form }}`; parity HTML pesante = **CSS tema**, non duplicazione markup statico.

### File tipici da toccare

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (e/o `design-comuni-global-fixes.css`)
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`
- `laravel/Modules/Fixcity/lang/*/segnalazione.php`

### Policy parity DOM

- **Body minimale**: non aggiungere classi al `<body>` per forzare stili; usare wrapper / `data-tests-slug` (vedi [html-parity-body-policy.md](../../laravel/Themes/Sixteen/docs/html-parity-body-policy.md)).

### Testing

- Verifica manuale browser sul path locale; opzionale Pest/feature se esiste harness per Folio `tests.view`.
- Dopo modifiche CSS: `npm run build` (e `npm run copy` se previsto dal tema).

### Dipendenze da altre story

- **7-34** (refactor Filament Wizard): done — base codice.
- **7-32 / 7-29**: header/stepper responsive possono sovrapporsi; coordinare per non duplicare PR.

---

## Previous story intelligence

- Da **7-34**: la parity «pixel-perfect» non deve sacrificare la **Filament way**; usare CSS e `configureWizardNextAction` / `submitAction` anziché HTML statico nel widget.
- Da **checklist create-story**: non confondere parity HTML con classi globali sul `body`; geolocation e `?step=` sono story dedicate (**7-33**).

---

## Riferimenti incrociati

- [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [xot-base-wizard-widget.md](../../laravel/Modules/Xot/docs/filament/widgets/xot-base-wizard-widget.md)
- Story correlate: [7-34](./7-34-create-ticket-wizard-filament-schema-wizard-refactor.md), [7-32](./7-32-segnalazione-crea-design-comuni-step1-cta-stepper-labels-header-parity.md), [7-6](./7-6-segnalazione-01-privacy-html-parity.md) (se overlap, chiudere scope: 7-6 HTML vs 7-39 Filament+visual step1 consolidato).

---

## Dev Agent Record

### Agent Model Used

_(da compilare in implementazione)_

### Completion Notes List

_(da compilare)_

### File List

_(da compilare)_

---

## Storia — stato completamento

- **ready-for-dev**: contesto BMAD generato — analisi checklist anti-disastro (Filament wizard, no body class, CSS scoped, doc unica modulo).
