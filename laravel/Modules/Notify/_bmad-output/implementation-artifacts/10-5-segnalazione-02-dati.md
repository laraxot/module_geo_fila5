# Story 10.5: Segnalazione - Step 2 Dati — Visual & Structural Refinement

**Status:** 🏗️ **Draft**
**Epic:** [[EPIC-10: Assistenza & Segnalazione]]
**Story ID:** `STORY-10.5`
**Target Page:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
**Reference:** [Design Comuni - Segnalazione 02 Dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)

---

## 🎯 Goal
Achieve full visual parity and maintain >99% structural HTML parity for the second step of the "Segnalazione" flow, with specific focus on the header responsiveness and CSS selector alignment.

---

## 📊 Baseline Analysis (2026-04-12)

### HTML Parity
- **Main Content Parity:** **99.24%** ✅ (Target: >90%)
- **Header Structure Parity:** **99.39%** ✅
- **Identified Gaps:**
    - Minor class mismatch in header: `a.active.nav-link` vs `a.nav-link`.
    - Stepper buttons use `<a>` instead of `<button>` in some variants (intentional for test flow navigation).

### Header Responsive Analysis (Screenshots)
*Screenshots captured in: `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/`*

- **Desktop:** Header structure matches perfectly. Verify font weights and hover states.
- **Tablet:** Verify hamburger menu behavior and logo scaling.
- **Mobile:** Check slim-header visibility and vertical alignment of branding elements.

---

## ⚠️ Critical Issue: CSS Selector Mismatch
The current CSS in `segnalazione-parity.css` (§27) uses legacy selectors that do not match the optimized Blade template.

| Area | Blade Selector (REAL) | Legacy Selector (WRONG) |
|---|---|---|
| Section Cards | `.cmp-card .card.has-bkg-grey.shadow-sm` | `.section-card`, `.form-section` |
| Prev Button | `.steppers-btn-prev` | `.btn-back` |
| Next Button | `.steppers-btn-confirm` | `.btn-next` |
| Save Button | `.steppers-btn-save` | `.btn-save` |

---

## ✅ Acceptance Criteria
1. [ ] **Header Parity:** Visual alignment of header elements across all viewports (Desktop, Tablet, Mobile) matches the reference screenshots.
2. [ ] **CSS Alignment:** Section §27 of `segnalazione-parity.css` updated to use real Blade selectors.
3. [ ] **Visual Parity:** Typography, colors, and spacing of the form sections match the reference.
4. [ ] **Structural Integrity:** Maintain >99% HTML parity score.
5. [ ] **Build:** `npm run build` and `npm run copy` executed and verified.

---

## 🛠️ Technical Tasks
1. **Header Refinement:**
    - Adjust `.it-header-wrapper` scoped styles to match reference typography.
    - Ensure `active` class is correctly applied to the current navigation item if possible.
2. **CSS Selector Migration:**
    - Update `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (§27).
    - Map reference Bootstrap styles to Tailwind `@apply` rules using correct selectors.
3. **Form Component Polish:**
    - Refine `#report-place`, `#report-info`, and `#report-author` visual layout.
    - Polish the "Upload" button and thumbnail preview.
4. **Validation:**
    - Run `./bashscripts/html/html-structure-compare.sh` to confirm parity hasn't regressed.
    - Visual check of screenshots.

---

## 🔗 References
- [Structural Report (Main)](laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report.md)
- [Structural Report (Header)](laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report_header.md)
- [Screenshot Gallery](laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/)
