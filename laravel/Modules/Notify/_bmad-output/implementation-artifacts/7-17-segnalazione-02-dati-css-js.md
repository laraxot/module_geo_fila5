# Story 7-17: CSS/JS Parity — segnalazione-02-dati (Bootstrap Italia 2.9.0 → Tailwind @apply)

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard + segnalazione pages)
**Ultimo aggiornamento**: 2026-04-14
**Dipendenze**: 7-9 (HTML parity ≥80% richiesta come prerequisito)

---

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-02-dati`,
voglio raggiungere la **parità visiva ≥90%** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che la pagina appaia istituzionale e coerente rispetto al riferimento senza modificare la struttura HTML/Blade.

---

## Prerequisito

HTML parity ≥80% verificata dalla story **7-9** (HTML Parity — segnalazione-02-dati final parity).

```bash
./bashscripts/html/compare-html.sh \
  "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html" \
  "http://127.0.0.1:8000/it/tests/segnalazione-02-dati" \
  "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati"
```

---

## Contesto tecnico

### URLs
- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-02-dati
- **Blade view**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

### Architettura CSS della pagina di riferimento (Bootstrap Italia 2.9.0)
Il riferimento Design Comuni carica:
1. `bootstrap-italia.min.css` — framework completo BI 2.9.0
2. `bootstrap-italia-comuni.css` — layer CSS custom per Design Comuni (611KB, variabili CSS complete)
3. `bootstrap-italia.bundle.min.js` — Bootstrap JS + plugins (accordion, dropdown, ecc.)
4. `scripts.js` — JS page-specific

**NOI**: NON importiamo mai Bootstrap Italia. Reimplementiamo le stesse classi CSS con Tailwind `@apply` + Alpine.js.

### CSS custom properties chiave (da `bootstrap-italia-comuni.css` 2.9.0)
```css
:root {
  --bs-primary: #007a52;             /* Verde istituzionale */
  --bs-secondary: #5d7083;
  --bs-font-sans-serif: "Titillium Web", Geneva, Tahoma, sans-serif;
  --bs-body-color: #191919;
  --bs-body-bg: #ffffff;
  --bs-border-color: #d4d4d4;
  --bs-border-radius: 4px;
  /* Gray scale */
  --bs-gray-100: #f8f9fa;
  --bs-gray-200: #e9ecef;
  --bs-gray-300: #dee2e6;
  --bs-gray-600: #6c757d;
  --bs-gray-700: #495057;
  --bs-gray-800: #343a40;
  --bs-gray-900: #191919;
}
```

### Layout pagina (dal Blade)
```
col-12 col-lg-3  → sidebar  (cmp-navscroll sticky-top + accordion + link-list)
col-12 col-lg-8 offset-lg-1 → main content (3 sezioni: Luogo, Disservizio, Autore)
```

### 256 classi CSS uniche sulla pagina (categorizzate)

**Layout Bootstrap Grid**:
`.container`, `.row`, `.col-*`, `.offset-*`, `.d-flex`, `.d-none`, `.d-lg-block`, `.justify-content-*`, `.align-items-*`, `.gap-*`, `.g-*`, `.ms-*`, `.me-*`, `.mb-*`, `.mt-*`, `.p-*`, `.px-*`, `.py-*`

**Header components**:
`.it-header-wrapper`, `.it-header-slim-wrapper`, `.it-header-slim-wrapper-content`, `.it-header-slim-right-zone`, `.it-header-center-wrapper`, `.it-header-navbar-wrapper`, `.it-brand-wrapper`, `.it-brand-text`, `.it-header-right-zone`, `.navbar`, `.navbar-brand`

**Navigation / Stepper**:
`.steppers`, `.steppers-header`, `.steppers-content`, `.steppers-nav`, `.steppers-progress`, `.steppers-dot-active`, `.step-current`, `.step-done`, `.step-disabled`, `.it-navscroll-progressbar`

**Sidebar navigation**:
`.cmp-navscroll`, `.link-list`, `.link-list-item`, `.it-page-section`

**Accordion**:
`.accordion`, `.accordion-item`, `.accordion-header`, `.accordion-button`, `.accordion-collapse`, `.accordion-body`, `.collapsed`

**Cards**:
`.cmp-card`, `.card`, `.card-body`, `.card-title`, `.card-text`, `.has-bkg-grey`

**Form fields**:
`.form-group`, `.form-control`, `.form-label`, `.form-select`, `.form-check`, `.form-check-input`, `.form-check-label`, `.form-text`, `.is-invalid`, `.is-valid`, `.invalid-feedback`, `.valid-feedback`

**Buttons**:
`.btn`, `.btn-primary`, `.btn-secondary`, `.btn-outline-primary`, `.btn-outline-secondary`, `.btn-sm`, `.btn-lg`, `.btn-icon`

**Progress bar**:
`.progress`, `.progress-bar`, `.bg-primary`

**Typography**:
`.title-xxlarge`, `.title-xlarge`, `.title-large`, `.title-medium`, `.subtitle-small`, `.text-muted`, `.fw-bold`, `.fw-semibold`, `.fw-normal`, `.text-primary`, `.lead`

**Icons**:
`.icon`, `.icon-sm`, `.icon-lg`, `.icon-white`, `.icon-primary`, `.icon-secondary`

**Utilities**:
`.visually-hidden`, `.visually-hidden-focusable`, `.sr-only`, `.p-big`, `.shadow-sm`, `.rounded`, `.border`, `.w-100`, `.h-100`

**Autocomplete / Input**:
`.cmp-input-autocomplete`, `.autocomplete`, `.autocomplete-list`, `.autocomplete-list-item`

---

## Acceptance Criteria (BDD)

### AC1 — HTML non modificato
**GIVEN** questa story è CSS/JS only
**WHEN** lo sviluppatore lavora
**THEN** nessuna modifica a blade, JSON, o HTML generato; HTML parity dalla story 7-9 rimane ≥80%

### AC2 — Parità visiva ≥90%
**GIVEN** screenshot locale vs riferimento
**WHEN** si confrontano desktop (1200px), tablet (768px), mobile (375px)
**THEN** visual parity ≥90% su tutti i breakpoint

### AC3 — Stepper corretto
**GIVEN** step 2 della form segnalazione
**WHEN** la pagina è renderizzata
**THEN** step 1 è marcato come completato (check verde), step 2 è attivo, step 3-4 sono inattivi

### AC4 — Form fields stilizzati
**GIVEN** i campi input, select, textarea nella pagina
**WHEN** si confrontano con il riferimento
**THEN** bordi, padding, label flottanti, colori focus identici al riferimento

### AC5 — Sidebar cmp-navscroll
**GIVEN** sidebar col-lg-3 con cmp-navscroll
**WHEN** viewport ≥992px
**THEN** sidebar sticky-top, accordion navigazione funzionante via Alpine.js

### AC6 — Alpine.js sostituisce Bootstrap JS
**GIVEN** accordion sidebar, dropdown ITA/ENG, autocomplete indirizzo
**WHEN** l'utente interagisce con questi componenti
**THEN** funzionano correttamente via Alpine.js (nessun Bootstrap JS)

### AC7 — Font Titillium Web
**GIVEN** la pagina renderizzata
**WHEN** si controlla il font applicato a body, h1-h6, input, button
**THEN** è "Titillium Web" senza eccezioni

### AC8 — Responsive corretto
**GIVEN** layout 2-colonne (sidebar + main)
**WHEN** si ridimensiona a mobile
**THEN** sidebar si sposta sotto il contenuto principale (comportamento Bootstrap grid)

### AC9 — Nessuna regressione
**GIVEN** le altre pagine tests/*
**WHEN** si esegue la build con le nuove classi CSS
**THEN** nessuna pagina degrada visualmente

### AC10 — Build pipeline verde
**GIVEN** le modifiche CSS/JS
**WHEN** si esegue `npm run build && npm run copy`
**THEN** build completa senza errori

---

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥80% (story 7-9 done)
- [ ] Screenshot baseline: riferimento + locale attuale (desktop, tablet, mobile)
- [ ] **FASE 1 — Analisi gap**: confrontare computed styles riferimento vs locale per ogni componente chiave
- [ ] **FASE 2 — Stepper CSS**: stilizzare `.steppers`, `.steppers-header`, `.steppers-dot-active`, `.step-current`, `.step-done`
- [ ] **FASE 3 — Form fields**: `.form-control`, `.form-label`, `.form-select`, `.form-text`, `.is-invalid`, `.invalid-feedback`
- [ ] **FASE 4 — Sidebar**: `.cmp-navscroll`, `.link-list`, `.link-list-item`, `sticky-top`
- [ ] **FASE 5 — cmp-card + has-bkg-grey**: sezioni it-page-section con card stilizzate
- [ ] **FASE 6 — Progress bar**: `.progress`, `.progress-bar` (stepper progressbar)
- [ ] **FASE 7 — Autocomplete**: `.cmp-input-autocomplete`, `.autocomplete-list` (Alpine.js)
- [ ] **FASE 8 — Accordion Alpine.js**: sidebar accordion via x-show / x-cloak
- [ ] Verificare font Titillium Web applicato ovunque
- [ ] Verificare palette colori (verde `#007a52`, testo `#191919`, bordi `#d4d4d4`)
- [ ] Build: `npm run build && npm run copy`
- [ ] Screenshot confronto finale (desktop/tablet/mobile)
- [ ] Verificare HTML parity non sia scesa sotto 80%

---

## Dev Notes

### File da modificare (SOLO questi — NO HTML/Blade/JSON)

| Area | Path |
|------|------|
| CSS parity pagina | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` |
| CSS classi Bootstrap Italia | `laravel/Themes/Sixteen/resources/css/components/bootstrap-italia-classes.css` |
| CSS @apply utilities | `laravel/Themes/Sixteen/resources/css/style-apply.css` |
| CSS entry point | `laravel/Themes/Sixteen/resources/css/app.css` |
| JS Alpine.js | `laravel/Themes/Sixteen/resources/js/app.js` |
| Build + deploy | `cd laravel/Themes/Sixteen && npm run build && npm run copy` |

### Stato attuale segnalazione-parity.css (già implementato)
- CSS variables `:root` (colori, tipografia)
- Titillium Web font force
- h1: 48px/700/60px/-1px, h2: 24px/600/30px, p: 16px/400/24px
- `.container` max-width + breakpoints Bootstrap
- Utilities base: `.d-flex`, `.d-none`, `.col-*`, `.mb-*`, `.btn`, `.btn-primary`
- `.card`, `.list-item`, `.card-body`

### Stato bootstrap-italia-classes.css (già implementato)
- `:root` color variables
- `body`, heading typography
- Skip links, visually-hidden
- `.it-header-slim-wrapper` (green topbar)
- `.it-header-slim-wrapper-content`, `.it-header-slim-right-zone`
- Language dropdown, login button
- Header center/navbar wrappers

### CSS da implementare o completare

#### Stepper (PRIORITÀ ALTA)
```css
/* segnalazione-parity.css */
.steppers { /* progress indicator container */ }
.steppers-header { display: flex; list-style: none; }
.steppers-header li { flex: 1; text-align: center; }
.steppers-dot-active { /* step indicator dot */ }
.steppers-header .step-current { color: #007a52; font-weight: 700; border-bottom: 2px solid #007a52; }
.steppers-header .step-done { color: #007a52; /* + checkmark */ }
.steppers-header .step-disabled { color: #5c6f82; }
```

#### Form fields (PRIORITÀ ALTA)
```css
.form-group { @apply mb-6; }
.form-control {
  @apply w-full border border-[#d4d4d4] rounded px-3 py-2
         text-[#191919] text-base bg-white
         focus:border-[#007a52] focus:ring-2 focus:ring-[#007a52]/20
         outline-none transition-all duration-200;
}
.form-label {
  @apply block text-sm font-semibold text-[#191919] mb-1;
}
.form-control.is-invalid { @apply border-[#d9364f]; }
.invalid-feedback { @apply text-[#d9364f] text-sm mt-1 block; }
```

#### Sidebar (cmp-navscroll)
```css
.cmp-navscroll { /* sticky left sidebar navigation */ }
.cmp-navscroll .link-list-item { /* nav links to page sections */ }
.cmp-navscroll .link-list-item a { @apply text-[#191919] hover:text-[#007a52] no-underline py-2 block; }
.cmp-navscroll .link-list-item.active a { @apply text-[#007a52] font-semibold; }
```

#### Sezioni pagina
```css
.it-page-section { @apply py-12; }
.has-bkg-grey { @apply bg-[#f8f9fa]; }
.p-big { @apply p-8; }
.cmp-card { @apply bg-white rounded-lg shadow-sm border border-[#e0e0e0]; }
```

#### Progress bar (stepper progressbar)
```css
.progress { @apply w-full h-1 bg-[#e9ecef] rounded-full overflow-hidden; }
.progress-bar { @apply h-full bg-[#007a52] transition-all duration-300; }
```

#### Alpine.js patterns (sidebar accordion)
```javascript
// In segnalazione-02-dati.blade.php già presente:
x-data="{ accordionOpen: true, parentsOpen: false }"
x-show="accordionOpen"
x-cloak
// Il CSS accordion si attiva via x-show — nessun Bootstrap JS necessario
```

### ⛔ Regole CRITICHE — errori del passato da NON ripetere

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| Modificare blade o JSON | Solo CSS e JS — HTML congelato |
| `bootstrap-italia.min.css` o CDN | TailwindCSS `@apply` |
| `bootstrap-italia.bundle.min.js` | Alpine.js |
| `outline: none` su focus | Focus visibile (WCAG AA: contrasto 4.5:1) |
| CSS globale non scoped | Scope a `.segnalazione-02-dati` o body[data-page] |
| Valori hardcoded in CSS | Variabili CSS `var(--bi-primary)` |
| Modificare `segnalazione-parity.css` senza leggere prima | Sempre leggere, anti-duplicate |

### Strategia conversione Bootstrap Italia 2.9.0 → Tailwind

**Fonte di verità**: `bootstrap-italia-comuni.css` dalla CDN del riferimento (611KB, compilato da SCSS)

**Step metodologico**:
1. Per ogni classe Bootstrap Italia usata sulla pagina, verificare le regole CSS nel file compilato
2. Tradurre le regole CSS in Tailwind `@apply` equivalente
3. Aggiungere/aggiornare la classe in `segnalazione-parity.css` o `bootstrap-italia-classes.css`
4. Mantenere il nome classe HTML identico al riferimento

**Esempio conversione**:
```css
/* Bootstrap Italia (compilato) */
.cmp-navscroll .link-list .link-list-item a {
  color: #191919;
  text-decoration: none;
  padding: 8px 0;
  display: block;
  font-size: 14px;
  font-weight: 600;
}

/* Nostra versione con Tailwind */
.cmp-navscroll .link-list .link-list-item a {
  @apply text-[#191919] no-underline py-2 block text-sm font-semibold;
}
```

### Build Pipeline

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen
npm run build
npm run copy
```

### Quality checks
```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
php artisan --version  # verificare che l'app sia integra
cd /var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen
npm run build 2>&1 | tail -20  # verificare build senza errori
```

---

## Definition of Done

- AC1..AC10 soddisfatti
- Build `npm run build && npm run copy` senza errori
- Screenshot confronto desktop/tablet/mobile: visual parity ≥90%
- HTML parity check: rimane ≥80% (script compare-html.sh)
- Nessuna regressione su altre pagine tests/*
- `segnalazione-parity.css` aggiornato con commenti dei gap chiusi

---

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
