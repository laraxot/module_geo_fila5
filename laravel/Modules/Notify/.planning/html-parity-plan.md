# HTML Structural Parity Plan - Design Comuni Pages

**Phase**: CSS/JS Phase - HTML Parity
**Goal**: Achieve 100% HTML structural parity with Bootstrap Italia reference pages
**Pages**: 6 remaining segnalazione pages

## Current Status

| Page | Status | Key Issues |
|------|--------|------------|
| segnalazione-01-privacy | ✅ 16/18 match | Minor: +1 container, id on main vs div |
| segnalazione-02-dati | ❓ Needs verification | Content renders (14 matches found) |
| segnalazione-03-riepilogo | ❓ Needs verification | Content likely renders |
| segnalazione-04-conferma | ❓ Needs verification | Content likely renders |
| segnalazioni-elenco | ❓ Needs verification | Complex page (412 tags) |
| segnalazione-dettaglio | ❓ Needs verification | Complex page (441 tags) |
| segnalazione-area-personale | ❓ Needs verification | Complex page (497 tags) |

## Execution Plan

### Wave 1: Verify Content Rendering (All Pages)
- [x] segnalazione-01-privacy: Verified, 16/18 match
- [ ] segnalazione-02-dati: Verify structural match
- [ ] segnalazione-03-riepilogo: Verify structural match
- [ ] segnalazione-04-conferma: Verify structural match
- [ ] segnalazioni-elenco: Verify structural match
- [ ] segnalazione-dettaglio: Verify structural match
- [ ] segnalazione-area-personale: Verify structural match

### Wave 2: Fix Structural Issues (Per Page)
For each page with issues:
1. Compare reference vs local HTML structure
2. Identify missing/mismatched elements
3. Fix component blade templates
4. Verify fix with automated comparison

### Wave 3: Final Verification
- Run comprehensive parity check on all 7 pages
- Document results
- Commit all changes

## Success Criteria
- All 7 pages match reference HTML structure ≥95%
- No duplicate IDs
- No extra wrapper divs (cms-view-wrapper, page-content)
- All Bootstrap Italia classes present
- All data-element attributes present
