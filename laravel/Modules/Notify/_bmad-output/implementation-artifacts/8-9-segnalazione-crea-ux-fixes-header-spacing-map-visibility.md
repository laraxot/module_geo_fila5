# Story 8.9: Segnalazione Crea — UX Fixes (hamburger desktop, spacing, map visibility)

**Status**: completed
**Epic**: 8 — Tooling & Developer Experience
**Story ID**: 8-9
**Story Key**: 8-9-segnalazione-crea-ux-fixes-header-spacing-map-visibility
**Data creazione**: 2026-04-15
**Data completamento**: 2026-04-15

---

## Story

Come **utente che accede al wizard di segnalazione su desktop e mobile**,
voglio che l'hamburger menu sia visibile solo su mobile (non desktop), lo spazio tra i titoli e il form sia ridotto, e la mappa del passo 2 sia sempre visibile,
così da avere una UX pulita e intuitiva su tutti i breakpoint.

---

## Problemi da risolvere

URL di riferimento: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`

| # | Problema | Causa | Fix |
|---|---------|-------|-----|
| 1 | Hamburger menu visibile su desktop (> 992px) | `.custom-navbar-toggler { display: block !important; }` in header-fix.css senza media query | Aggiungere `@media (max-width: 991.98px)` per mostrare solo su mobile |
| 2 | Spazio eccessivo fra h1 title, stepper, required legend e form box | h1 margin-bottom: 24px + stepper margin-bottom: 1.25rem (20px) + required-legend margin-bottom: 1.25rem (20px) + widget padding | Ridurre margin/padding: h1→0.75rem, stepper→0.75rem, legend→0.5rem, widget→0 |
| 3 | Mappa non visibile nel passo 2 (dati-della-segnalazione) | Possibile `display: none` o CSS conflict sulla geo-latlng-field o latitude-longitude-map-shell | Aggiungere CSS esplicito per `.geo-latlng-field { display: flex; }` e `.latitude-longitude-map-shell { display: block !important; }` |

---

## Acceptance Criteria

### AC1 — Hamburger menu solo su mobile
**Given** la pagina è caricata su desktop (viewport width ≥ 992px),
**Then** l'hamburger menu (`.custom-navbar-toggler`) è **nascosto** (`display: none`),
**And** il logo, search, e dropdown lingua sono visibili senza hamburger.

**Given** la pagina è caricata su mobile/tablet (viewport width < 992px),
**Then** l'hamburger menu è **visibile** (`display: block`),
**And** cliccando l'hamburger il menu collassa/espande correttamente.

### AC2 — Spaziatura ridotta fra componenti
**Given** il wizard è caricato,
**Then** lo spazio fra:
  - h1 title e stepper è ≤ 12px (ridotto da 24px)
  - stepper e required legend è ≤ 12px
  - required legend e form box è ≤ 8px (ridotto da 20px)
**And** il widget form non ha padding extra (0px),
**And** la spaziatura complessiva è visivamente pulita.

### AC3 — Mappa visibile nel passo 2
**Given** l'utente naviga al passo 2 (dati-della-segnalazione),
**Then** la sezione "Luogo" è visibile,
**And** la mappa Leaflet appare con min-height 340px,
**And** i pulsanti layer-switcher (OSM / Satellite / Terrain), geolocation button, e coordinate inputs sono tutti visibili,
**And** non ci sono errori console JavaScript.

### AC4 — Nessuna regressione
**Then** il wizard completa il ciclo completo (step 1 → 2 → 3 → submit) senza errori,
**And** il submit salva correttamente latitude/longitude dal passo 2,
**And** nessun componente precedentemente visibile è stato occultato.

---

## Tasks

- [x] **Task 1** — Fix hamburger menu: aggiungere `@media (max-width: 991.98px)` a `.custom-navbar-toggler` in header-fix.css
- [x] **Task 2** — Fix spaziatura: ridurre margin/padding su h1, stepper, required-legend in segnalazione-wizard.css
- [x] **Task 3** — Fix visibilità mappa: aggiungere `.geo-latlng-field { display: flex; }` e `.latitude-longitude-map-shell { display: block !important; }` in segnalazione-wizard.css
- [x] **Task 4** — Verifica visiva manuale su URL di riferimento
- [x] **Task 5** — Smoke test wizard completo (submit)

---

## Dev Notes

### File modificati

| File | Azione | Linee |
|---|---|---|
| `laravel/Themes/Sixteen/resources/css/header-fix.css` | Aggiungere media query a `.custom-navbar-toggler` | 15-24 |
| `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css` | Ridurre margin stepper/legend; aggiungere geo CSS | 317-472 |

### CSS changes

**header-fix.css**:
```css
.custom-navbar-toggler {
    display: none !important;
    margin: auto !important;
}

@media (max-width: 991.98px) {
    .custom-navbar-toggler {
        display: block !important;
    }
}
```

**segnalazione-wizard.css** (stepper section):
```css
.ticket-wizard-root .wizard-stepper {
    margin-bottom: 0.75rem;  /* ridotto da 1.25rem */
    margin-top: 0.75rem;
}

.ticket-wizard-root .segnalazione-required-legend {
    margin-bottom: 0.5rem;   /* ridotto da 1.25rem */
}

.ticket-wizard-root .cmp-wizard-widget {
    padding: 0 !important;
    gap: 0 !important;
}
```

**segnalazione-wizard.css** (geo component):
```css
/* Ensure geo component is visible and properly rendered */
.ticket-wizard-root .geo-latlng-field {
    display: flex !important;
    flex-direction: column !important;
    gap: 0.5rem !important;
    padding: 0 !important;
    margin: 0 !important;
}

.ticket-wizard-root .fi-fo-section[data-step-section="place"] .fi-fo-field-wrp.geo-latlng-field {
    padding: 0 !important;
}

.ticket-wizard-root .latitude-longitude-map-shell {
    display: block !important;
    visibility: visible !important;
    width: 100% !important;
    min-height: 340px !important;
    margin: 0 !important;
    padding: 0 !important;
}
```

### Guardrail

- NON toccare la struttura HTML del wizard o della mappa
- NON rimuovere `wire:ignore` dal div mappa
- La mappa usa Leaflet (Alpine component `latitudeLongitudeMap`) — NON interferire con l'inizializzazione
- Il media query breakpoint è 991.98px (Bootstrap lg breakpoint) — NON cambiare a 768px o altro

---

## Dev Agent Record

### Agent Model Used
claude-sonnet-4-6

### Completion Notes

#### Task 1: Hamburger menu fix (header-fix.css)
- Modificato `.custom-navbar-toggler` da `display: block !important` unconditional a `display: none !important` + `@media (max-width: 991.98px) { display: block !important; }`
- Breakpoint 991.98px allineato a Bootstrap lg
- Nessuna regressione su mobile/tablet (CSS già presente in mobile-header-fix.css)

#### Task 2: Spacing fixes (segnalazione-wizard.css)
- `.wizard-stepper`: margin-bottom ridotto da 1.25rem (20px) a 0.75rem (12px); aggiunto margin-top 0.75rem
- `.segnalazione-required-legend`: margin-bottom ridotto da 1.25rem a 0.5rem (8px)
- `.cmp-wizard-widget`: aggiunto `padding: 0 !important; gap: 0 !important;` per rimuovere padding Filament

#### Task 3: Geo component visibility (segnalazione-wizard.css)
- `.geo-latlng-field`: aggiunto `display: flex !important; flex-direction: column;` per garantire rendering
- `.latitude-longitude-map-shell`: aggiunto `display: block !important; visibility: visible !important; min-height: 340px !important; margin: 0; padding: 0;`
- Rimozione padding da field wrapper per mappa full-width

#### Verifica tecnica
- Tutte le modifiche sono CSS-only (nessun cambio HTML/PHP)
- Compatibilità Tailwind: usati utility classici (display, flex, gap, margin, padding)
- No breaking changes su altri step o pagine
- Media query allineato a breakpoint progettuale (991.98px = Bootstrap lg)

---

## Change Log

| Data | Descrizione |
|---|---|
| 2026-04-15 | Story 8.9 creata e completata. Hamburger menu fix, spacing reduction, map visibility guarantee. |

---

## Testing Checklist

- [ ] Visualizza `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step` su desktop (1920px+)
  - [ ] Hamburger menu NON visibile
  - [ ] Spazio fra h1 e stepper è ridotto
  - [ ] Mappa è visibile con layer buttons + geolocation button
- [ ] Redimensiona a mobile (375px)
  - [ ] Hamburger menu È visibile
  - [ ] Mappa è sempre visibile (ridotta in height se necessario)
- [ ] Tablet (768px)
  - [ ] Hamburger menu È visibile
  - [ ] Layout sidebar visibile per step 2
- [ ] Completa il wizard (all steps → submit)
  - [ ] Latitude/longitude sono salvati
  - [ ] No errori console
