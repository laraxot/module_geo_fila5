# Story: Segnalazione Crea — Stepper Responsive + Header Fixes

**Epic**: Phase 1.1 — Global Component & Data Parity  
**Story ID**: 1.1.1-SEGN-CREA-STEPPER-HEADER  
**Status**: Draft  
**Priority**: P0 (Blocking visual parity)  
**Created**: 2026-04-13  

---

## User Story

Come sviluppatore front-end,
voglio che la pagina `/it/tests/segnalazione-crea` sia visivamente identica al riferimento Bootstrap Italia su **tutti i breakpoint**,
in modo che lo stepper sia responsive e l'header funzioni correttamente su mobile/tablet/desktop.

---

## Acceptance Criteria

### AC1: Stepper Responsive (Desktop/Tablet/Mobile)
**Given** la pagina `/it/tests/segnalazione-crea`  
**When** l'utente visualizza la pagina a qualsiasi breakpoint  
**Then** lo stepper deve corrispondere al reference:

- **Desktop (≥992px)**: Tab orizzontali a larghezza piena, step attivo con underline verde, step completati con spunta ✓
- **Tablet (768-991px)**: Card bianca con ombra, mostra SOLO lo step attivo + contatore "X/N" a destra
- **Mobile (≤767px)**: Card bianca con ombra, mostra SOLO lo step attivo + contatore "X/N" a destra

### AC2: Hamburger Menu Vertically Centered
**Given** viewport ≤991px  
**When** l'utente visualizza l'header  
**Then** il pulsante hamburger deve essere **centrato verticalmente** nella barra verde, non allineato in alto

### AC3: "Cerca" Text Visible on Tablet
**Given** viewport 768-991px  
**When** l'utente visualizza l'header  
**Then** il testo "Cerca" deve essere visibile accanto all'icona lente (come sul reference)

### AC4: Language Dropdown Functional
**Given** qualsiasi breakpoint  
**When** l'utente clicca sul dropdown lingua "ITA"  
**Then** il dropdown deve aprirsi mostrando ITA/ENG opzioni

### AC5: Language Icon Background
**Given** qualsiasi breakpoint  
**When** l'utente visualizza il dropdown lingua  
**Then** l'icona freccia deve avere lo stesso stile del reference (nessuno sfondo scuro extra)

### AC6: CSS Scope Without Body Classes
**Given** la rimozione delle classi body per HTML parity  
**When** i CSS vengono applicati  
**Then** tutti gli stili page-specific devono funzionare SENZA selettori `.page-content[data-slug="..."]`

---

## Dev Technical Guidance

### Root Cause Analysis

#### Issue 1: Stepper Invisible on Tablet/Mobile
**Root cause**: 167 CSS rules in `segnalazione-parity.css` use `.page-content[data-slug="..."]` selectors which NO LONGER MATCH since body classes were removed.

**Broken selectors**:
```css
.page-content[data-slug="tests.segnalazione-crea"] .steppers-header li { ... }
.page-content[data-slug="tests.segnalazione-01-privacy"] .steppers { ... }
.page-content[data-slug="tests.segnalazione-02-dati"] .steppers-header ul { ... }
```

**Reference behavior** (Bootstrap Italia):
- Mobile: `clip: rect(1px,1px,1px,1px); height: 0; position: absolute;` hides non-active steps
- Shows only active step + "X/N" counter
- White card with box-shadow

**Fix**: Replace `.page-content[data-slug="..."]` with element-based selectors:
```css
/* Use existing unique wrappers instead of body classes */
.ticket-wizard-root .steppers-header li { ... }
.segnalazione-privacy-page .steppers { ... }
main .steppers-header ul { ... }
```

#### Issue 2: Hamburger Not Centered
**Root cause**: Custom hamburger CSS has `align-items: flex-start` or missing vertical centering.

**Fix**: Add `align-items: center` to hamburger button container.

#### Issue 3: "Cerca" Text Missing
**Root cause**: CSS rule hiding the text or it was never added to the template.

**Fix**: Verify blade template has "Cerca" text with proper responsive classes.

#### Issue 4: Language Dropdown Not Working
**Root cause**: Bootstrap Italia uses `data-bs-toggle="dropdown"` but we may have removed Bootstrap JS or the dropdown is blocked by CSS.

**Fix**: Ensure dropdown HTML structure matches reference and CSS doesn't hide the menu.

### Files to Modify

1. **segnalazione-parity.css** — Replace all `.page-content[data-slug="..."]` selectors:
   - `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
   - 167 selectors to fix across 6 pages

2. **app.css** — Replace remaining `.page-content[data-slug="..."]` selectors:
   - `laravel/Themes/Sixteen/resources/css/app.css`
   - 51 selectors to fix

3. **header.blade.php** — Fix "Cerca" text and hamburger alignment:
   - `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`

### Specific CSS Replacements

#### Pattern 1: segnalazione-crea (21 rules)
```css
/* OLD (broken) */
.page-content[data-slug="tests.segnalazione-crea"] .ticket-wizard-root .steppers-header li { ... }

/* NEW */
.ticket-wizard-root .steppers-header li { ... }
```

#### Pattern 2: segnalazione-01-privacy (81 rules)
```css
/* OLD (broken) */
.page-content[data-slug="tests.segnalazione-01-privacy"] .steppers-header { ... }

/* NEW — check if page has unique wrapper */
.segnalazione-privacy-page .steppers-header { ... }
/* OR if no unique wrapper, use generic */
main .steppers-header { ... }
```

#### Pattern 3: Other pages
```css
/* Replace all .page-content[data-slug="..."] with appropriate wrapper */
```

### Reference Stepper CSS (Bootstrap Italia)

```css
/* Mobile: hide non-active steps */
.steppers .steppers-header ul li:not(.active) {
  clip: rect(1px,1px,1px,1px);
  height: 0;
  position: absolute;
  display: block;
}

/* Active/confirmed steps */
.steppers .steppers-header ul li.active,
.steppers .steppers-header ul li.confirmed {
  color: #06c;
}

/* Index counter */
.steppers .steppers-index {
  margin-left: auto;
  font-size: .875rem;
  font-weight: 600;
  flex-shrink: 0;
}

/* Desktop: show all steps as tabs */
@media (min-width: 992px) {
  .steppers .steppers-index { display: none; }
  .steppers .steppers-header { padding: 0; box-shadow: none; height: auto; }
}
```

### Testing Requirements

- [ ] Screenshot comparativo desktop (1920px) vs reference
- [ ] Screenshot comparativo tablet (768px) vs reference
- [ ] Screenshot comparativo mobile (375px) vs reference
- [ ] Verificare stepper su tutte le 7 pagine segnalazione
- [ ] Verificare hamburger centrato verticalmente
- [ ] Verificare "Cerca" testo su tablet
- [ ] Verificare dropdown lingua funzionante
- [ ] Nessun regression CSS su altre pagine

---

## Tasks / Subtasks

### Task 1: Replace `.page-content[data-slug="..."]` Selectors
- [ ] Replace 21 selectors for `tests.segnalazione-crea` → use `.ticket-wizard-root` wrapper
- [ ] Replace 81 selectors for `tests.segnalazione-01-privacy` → use `.segnalazione-privacy-page` or generic
- [ ] Replace 39 selectors for `tests.segnalazione-02-dati` → use generic selectors
- [ ] Replace 24 selectors for `tests.segnalazione-area-personale` → use generic selectors
- [ ] Replace 1 selector for `tests.segnalazione-dettaglio` → use generic
- [ ] Replace 1 selector for `tests.segnalazione-03-riepilogo` → use generic
- [ ] Replace 51 selectors in `app.css` → use generic wrappers

### Task 2: Fix Hamburger Vertical Alignment
- [ ] Center hamburger vertically in header on tablet/mobile
- [ ] Verify at 768px and 375px

### Task 3: Fix "Cerca" Text on Tablet
- [ ] Add/verify "Cerca" text next to search icon at 768px
- [ ] Hide on mobile (≤767px)

### Task 4: Fix Language Dropdown
- [ ] Ensure dropdown opens on click
- [ ] Remove dark background from icon
- [ ] Match reference styling

### Task 5: Verification
- [ ] Screenshot comparativi tutti i breakpoint
- [ ] Test su tutte le 7 pagine segnalazione
- [ ] Verificare nessun regression

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: Replacing 218 CSS selectors could break styling on multiple pages
- **Mitigation**: Test each page individually after selector replacement
- **Verification**: Screenshot comparison for all 7 segnalazione pages

### Rollback Plan
- Git commit per batch of replacements allows selective rollback
- CSS changes are fully reversible

### Safety Checks
- [ ] Verify stepper works on all 7 segnalazione pages
- [ ] Verify header works on homepage and other pages
- [ ] No CSS conflicts with Filament admin panels

---

## Dev Agent Record

### Agent Model Used
_Qwen Code_

### Screenshot Evidence
- `ref-stepper-desktop.png` — Reference desktop: tabs full width, green underline
- `ref-stepper-tablet.png` — Reference tablet: white card, active step only, "1/3" counter
- `ref-stepper-mobile.png` — Reference mobile: white card, active step only, "1/3" counter
- `our-stepper-desktop.png` — Our desktop: similar but underline style differs
- `our-stepper-tablet.png` — Our tablet: **stepper invisible** (CSS selectors broken)
- `our-stepper-mobile.png` — Our mobile: **stepper invisible** (CSS selectors broken)

### Debug Log References
- 167 `.page-content[data-slug="..."]` selectors in `segnalazione-parity.css`
- 51 `.page-content[data-slug="..."]` selectors in `app.css`
- All selectors broken since body class removal in commit `2795d2240`
- Selector breakdown: segnalazione-01-privacy (81), segnalazione-02-dati (39), segnalazione-area-personale (24), segnalazione-crea (21), segnalazione-dettaglio (1), segnalazione-03-riepilogo (1)

### File List
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` — 167 selectors to fix
- `laravel/Themes/Sixteen/resources/css/app.css` — 51 selectors to fix
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — header fixes
- `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php` — body class removal (already done)

### Change Log
| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-13 | 1.0 | Analysis: 218 broken CSS selectors, stepper invisible, header issues | Qwen |

---

## Status: Draft

**Ready for**: Dev agent implementation  
**Estimated Effort**: 6-8 ore  
**Dependencies**: Nessuna  
**Constraint**: SOLO CSS/JS — HTML parity deve rimanere al 100%

---

## Notes

- Questa story è causata dalla rimozione delle classi body in `2795d2240` per HTML parity
- I selettori `.page-content[data-slug="..."]` funzionavano quando il body aveva classi condizionali
- Ora che `<body>` è plain, serve un nuovo approccio di scoping CSS
- Soluzione: usare wrapper element-based invece di body classes
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html
- Local: http://127.0.0.1:8000/it/tests/segnalazione-crea
