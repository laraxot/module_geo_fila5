# GSD Phase: CSS/JS Visual Parity - Segnalazione Pages

**Phase**: CSS/JS Parity
**Started**: 2026-04-09 10:00 UTC
**Status**: 🔄 IN PROGRESS - Phase 2 Active

---

## 🎯 Goal

Make all 7 segnalazione pages visually identical to their references working **ONLY** on CSS/JS files.

**Constraints**:
- ✅ HTML is LOCKED - DO NOT MODIFY (parity established)
- ✅ Work only in `laravel/Themes/Sixteen/resources/css/`
- ✅ Build with `npm run build && npm run copy`
- ✅ Use Playwright screenshots for verification
- ✅ Ticket naming (not Segnalazione) in PHP classes

---

## 📊 All 7 Pages Status

| Page | HTML Parity | CSS/JS Phase | Visual Analysis | Status |
|------|-------------|--------------|-----------------|--------|
| segnalazione-01-privacy | 99.5% | ✅ YES | Done | 🔄 CSS fixes applied |
| segnalazione-02-dati | 97.0% | ✅ YES | Done | 🔄 CSS fixes applied |
| segnalazione-03-riepilogo | 83.3% | ✅ YES | Done | 🔄 CSS fixes applied |
| segnalazione-area-personale | 91.9% | ✅ YES | Done | 🔄 CSS fixes applied |
| segnalazione-dettaglio | 86.8% | ✅ YES | Done | 🔄 CSS fixes applied |
| segnalazioni-elenco | 72.5% | ❌ NO | - | ⏳ Needs HTML fix |
| segnalazione-04-conferma | 43.6% | ❌ NO | - | ⏳ Needs HTML fix |
| **segnalazione-crea** | **83.6%** | ✅ YES | ✅ Done | 🔄 **Wizard active, CSS fixes needed** |

**6 out of 8 pages qualify for CSS/JS phase (>80% HTML parity)**

---

## ✅ Phase 1: Analysis & Foundation (COMPLETE)

### Tools Installed & Configured
- ✅ Supermemory SDK + API
- ✅ Playwright visual parity analysis
- ✅ HTML comparison scripts
- ✅ MCP servers (8 total)

### Baseline Analysis Complete
- All 8 pages analyzed
- Screenshots captured (local + reference)
- Font/color differences identified
- Global CSS issues documented

## ✅ Phase 2: Global CSS Fixes (COMPLETE)

### Tasks Completed

1. ✅ **design-comuni-global-fixes.css Created**
   - Font size utilities: .fs-18, .fs-16, .fs-14
   - Nav links: 18px Titillium Web
   - Breadcrumbs: 16px Titillium Web
   - Steppers index: 14px
   - Body text: #1a1a1a (reference value)
   - Secondary text: #455a64
   - Border colors: #d4d4d4
   - Header/footer: #17334f / #ffffff
   - Link colors: #007a52 green
   - Background colors: #ebeef0

2. ✅ **Import Order Fixed**
   - Global fixes moved to END of CSS import chain
   - Proper cascade override of page-specific rules

3. ✅ **All 8 Pages Verified**
   - All loading HTTP 200
   - CSS rebuilt: app-CtJ3wuUu.css (1,029.68 kB)
   - Assets deployed to public_html/themes/Sixteen/

4. ✅ **segnalazione-crea Wizard Operational**
   - CreateTicketWizardWidget extends XotBaseWidget
   - 3-step wizard working: Privacy → Dati → Riepilogo+Submit
   - Submit redirects to segnalazione-04-conferma
   - Old pages remain available

### Build Artifacts
```
public/assets/app-BRKXMWAJ.css   4.97 kB (Filament styles)
public/assets/app-CtJ3wuUu.css   1,029.68 kB (main styles)
public/assets/app--a8bupAA.js    9.48 kB (app JS)
public/assets/splide.esm-*.js    32.60 kB (carousel)
```

---

## ⏳ Phase 3: Page-Specific Visual Fixes (TODO)

### Remaining Visual Issues

| Issue | Affected Pages | Fix Required | Priority |
|-------|---------------|--------------|----------|
| Header slim colors | All pages | #17334f background | 🔴 HIGH |
| Card shadows | All pages | Consistent 0 2px 5px rgba(0,0,0,0.2) | 🟡 MEDIUM |
| Spacing inconsistencies | 02-dati, 03-riepilogo | Padding/margin adjustments | 🟡 MEDIUM |
| Upload widget styling | 02-dati, crea | Image preview styles | 🟡 MEDIUM |
| Steppers active state | All wizard pages | Green active indicator | 🟢 LOW |

### Action Plan
1. Run visual parity analysis for each page
2. Identify page-specific CSS gaps
3. Create page-specific parity CSS files
4. Rebuild and verify
5. Update documentation

---

## ⏳ Phase 4: Verification (TODO)

1. ⏳ Final screenshots for all 8 pages
2. ⏳ Side-by-side comparison with reference
3. ⏳ Verify HTML parity unchanged (>80% maintained)
4. ⏳ Update documentation with results
5. ⏳ Archive phase directories

---

## 🛠️ Tools Used

| Tool | Purpose | Status |
|------|---------|--------|
| **Playwright** | Screenshot capture + analysis | ✅ Installed & working |
| **Supermemory** | AI context indexing | ✅ SDK installed, API configured |
| **bashscripts/html/compare-html.sh** | HTML parity check | ✅ Working (99.8%) |
| **scripts/visual-parity.mjs** | Visual analysis | ✅ Created & tested |
| **scripts/supermemory-context.js** | Doc indexing | ✅ Created, needs testing |

---

## 📝 Decisions & Rationale

### Decision 1: Lock HTML at 99.8%
**Why**: HTML structure is already excellent. Further tweaks would yield diminishing returns. CSS/JS fixes will provide better visual ROI.

### Decision 2: Use CSS Variables for Colors
**Why**: Creates a single source of truth for Bootstrap Italia colors. Makes future updates easier and ensures consistency across all pages.

### Decision 3: Playwright Over Manual Screenshots
**Why**: Automated, repeatable, programmatic analysis. Can extract computed styles, not just visual comparison.

### Decision 4: Supermemory for AI Context
**Why**: Enables multi-agent collaboration. All agents can query the same context about project decisions, colors, fonts, and architecture.

---

## 🔗 Cross-References

- [Visual Parity Report](../../laravel/Themes/Sixteen/storage/visual-parity/segnalazione-01-privacy/analysis.json)
- [HTML Parity Report](../../bashscripts/html/output/report.md)
- [CSS Fix Documentation](../../laravel/Themes/Sixteen/docs/css-js-parity/segnalazione-01-privacy-css-fix.md)
- [Theme Docs Index](../../laravel/Themes/Sixteen/docs/README.md)
- [Design Comuni Reference](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html)

---

**Next Agent**: Continue with Phase 2 color/font fixes. All context is in this file and linked documentation.
