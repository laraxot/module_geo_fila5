# Story: CSS Scoping Refactor — Body Classes Removed Impact

**Epic**: Phase 1.1 — Global Component & Data Parity  
**Story ID**: 1.1.1-CSS-SCOPING-REFACTOR  
**Status**: Draft  
**Priority**: P0 (Blocking all segnalazione pages)  
**Created**: 2026-04-13  

---

## User Story

Come sviluppatore front-end,
voglio che tutti i CSS page-specific funzionino correttamente DOPO la rimozione delle classi body,
in modo che tutte le 7 pagine segnalazione siano visivamente corrette su tutti i breakpoint.

---

## Context

La rimozione delle classi body (`page-tests-*`, `dc-homepage-parity`) in commit `2795d2240` per HTML parity ha rotto 218 selettori CSS che usavano `.page-content[data-slug="..."]` come scope.

**Problema strutturale**: Su alcune pagine (es. `segnalazione-crea`), i componenti stepper sono RENDERIZZATI FUORI dal div `.page-content[data-slug="..."]`, quindi i selettori CSS non matchano.

---

## Acceptance Criteria

### AC1: Segnalazione Crea Stepper Responsive
**Given** la pagina `/it/tests/segnalazione-crea`  
**When** l'utente visualizza la pagina a qualsiasi breakpoint  
**Then** lo stepper deve essere visibile e responsive come il reference

### AC2: Tutte le Pagine Segnalazione Funzionanti
**Given** tutte le 7 pagine segnalazione  
**When** l'utente naviga ciascuna pagina  
**Then** tutti gli stili CSS page-specific devono funzionare correttamente

### AC3: Header Issues Fixed
**Given** tutte le pagine  
**When** viewport ≤991px  
**Then**:
- Hamburger menu centrato verticalmente
- "Cerca" testo visibile su tablet
- Dropdown lingua funzionante
- Icona lingua senza sfondo scuro

---

## Dev Technical Guidance

### Root Cause Analysis

#### Structural Issue: Steppers Outside .page-content

**segnalazione-crea HTML structure**:
```html
<div class="page-content content" data-slug="tests.segnalazione-crea">
</div>
<div class="segnalazione-crea-wrapper">
    <div class="ticket-wizard-root">
        <div id="main-container">
            <div class="steppers">  <!-- OUTSIDE .page-content! -->
```

**Other pages (segnalazione-01-privacy, etc.)**:
```html
<div class="page-content content" data-slug="tests.segnalazione-01-privacy">
    <div class="container" id="main-container">
        <div class="steppers">  <!-- INSIDE .page-content -->
```

#### Selector Strategy

**For segnalazione-crea** (21 rules):
- Use `.ticket-wizard-root` or `.segnalazione-crea-wrapper` as scope
- Example: `.ticket-wizard-root .steppers-header li { ... }`

**For other pages** (146 rules in segnalazione-parity.css):
- These selectors SHOULD still work since steppers are inside `.page-content`
- BUT need to verify no other structural issues

**For app.css** (51 rules):
- Similar analysis needed per selector

### Files to Modify

1. **segnalazione-parity.css** — 167 rules:
   - `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
   - 21 rules for `segnalazione-crea` → change to `.ticket-wizard-root` scope
   - 146 rules for other pages → verify still working

2. **app.css** — 51 rules:
   - `laravel/Themes/Sixteen/resources/css/app.css`
   - Similar scope analysis

3. **header.blade.php** — Header fixes:
   - `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`

### Specific Replacements

```css
/* segnalaizone-crea: OLD (broken - steppers outside .page-content) */
.page-content[data-slug="tests.segnalazione-crea"] .ticket-wizard-root .steppers-header li { ... }

/* NEW (working - scope by unique wrapper) */
.ticket-wizard-root .steppers-header li { ... }

/* Other pages: should still work but verify */
.page-content[data-slug="tests.segnalazione-01-privacy"] .steppers-header { ... }
```

---

## Tasks / Subtasks

### Task 1: Fix segnalazione-crea Selectors (21 rules)
- [ ] Replace `.page-content[data-slug="tests.segnalazione-crea"] .ticket-wizard-root` → `.ticket-wizard-root`
- [ ] Verify stepper visible on desktop/tablet/mobile

### Task 2: Verify Other Pages (146 rules)
- [ ] Test segnalazione-01-privacy (81 rules)
- [ ] Test segnalazione-02-dati (39 rules)
- [ ] Test segnalazione-area-personale (24 rules)
- [ ] Test segnalazione-dettaglio (1 rule)
- [ ] Test segnalazione-03-riepilogo (1 rule)

### Task 3: Fix app.css Selectors (51 rules)
- [ ] Analyze each selector's target element
- [ ] Replace broken selectors with working equivalents

### Task 4: Header Fixes
- [ ] Hamburger vertical centering
- [ ] "Cerca" text on tablet
- [ ] Language dropdown functional
- [ ] Language icon background fix

---

## Dev Agent Record

### Agent Model Used
_Qwen Code_

### Debug Log References
- 167 selectors in `segnalazione-parity.css` using `.page-content[data-slug="..."]`
- 51 selectors in `app.css` using `.page-content[data-slug="..."]`
- Structural issue: segnazione-crea steppers rendered OUTSIDE `.page-content` div
- Commit `2795d2240` removed body classes, exposing this pre-existing structural issue

### File List
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`

### Change Log
| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-13 | 1.0 | Analysis: 218 selectors, structural issue identified | Qwen |

---

## Status: In Progress

**Fixes Applied** (commit `52c95fb37`):
1. ✅ Replaced 21 `.page-content[data-slug="tests.segnalazione-crea"]` → `.ticket-wizard-root`
2. ✅ Replaced 146 `.page-content[data-slug="tests.XXX"]` → generic selectors in segnalazione-parity.css
3. ✅ Replaced 51 `.page-content[data-slug="tests.XXX"]` → generic selectors in app.css
4. ✅ Total: 218 CSS selectors fixed

**Root Cause Identified**:
- `.page-content` div is self-closing (`data-side="content">`)
- Page content renders as SIBLINGS, not children of `.page-content`
- Steppers for segnalazione-crea are inside `.ticket-wizard-root` (outside `.page-content`)

**Remaining Issues** (from user request):
- Hamburger menu vertical centering on tablet/mobile
- "Cerca" text visible on tablet
- Language dropdown functional
- Language icon background fix
- Other header issues to investigate

### Dev Agent Record
