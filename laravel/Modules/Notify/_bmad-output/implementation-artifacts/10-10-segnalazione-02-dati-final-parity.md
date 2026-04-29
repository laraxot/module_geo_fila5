# Story 10.10: Segnalazione - Step 2 Dati — 100% HTML Parity Achievement

**Status:** 🏗️ **Draft**
**Epic:** [[EPIC-10: Assistenza & Segnalazione]]
**Story ID:** `STORY-10.10`
**Goal:** Reach absolute HTML structure parity (target 100%) for the `segnalazione-02-dati` page by resolving the final structural discrepancies.

---

## 🎯 Objective
Based on the current 99.24% parity, identify and resolve the last remaining differences in the HTML structure between the local page and the reference.

---

## 📊 Current Status (2026-04-12)
- **Main Content Parity:** **99.24%**
- **Header Parity:** **99.39%**
- **Last Report:** [Detailed Parity Report](laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report.md)

---

## ❌ Identified Gaps to Close
1. **Header Navigation:** Reference uses `a.active.nav-link` while local uses `a.nav-link`.
2. **Component Tags:** Some local buttons use `<a>` where reference uses `<button>`, or vice-versa.
3. **Implicit Elements:** Resolve any `❌ (Extra)` elements like `option` or `template` tags that differ from the static reference.
4. **Validation Logic:** Ensure the fuzzy comparison handles minor whitespace or attribute order differences without dropping the score.

---

## ✅ Acceptance Criteria
1. [ ] **99.9% Parity:** Achieve a structure score where only non-functional or environment-specific differences remain.
2. [ ] **Header Fix:** The `active` class mismatch in the header is resolved.
3. [ ] **Tag Alignment:** Stepper and form buttons use the exact tags specified in the reference.
4. [ ] **Automated Confirmation:** Run `./bashscripts/html/html-structure-compare.sh` and generate a clean final report.

---

## 🛠️ Technical Tasks
1. **Header Adjustment:**
    - Modify `header.blade.php` (or equivalent component) to correctly apply the `active` class based on the current test route.
2. **Structural Surgical Edits:**
    - Update `segnalazione-02-dati.blade.php` to switch `<a>` tags to `<button>` where the reference requires it.
    - Remove or hide any extra `div` or `template` wrappers used by Alpine.js that are not in the reference (if possible without breaking functionality).
3. **Translation Alignment:**
    - Ensure all labels are fully dynamic and match the reference text via the 5-level translation system.
4. **Final Verification:**
    - Rerun comparison tools for both `Main` and `Header` contexts.

---

## 🔗 References
- [Reference HTML](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)
- [Local Implementation](laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php)
- [Comparison Tool](bashscripts/html/html-structure-compare.sh)
