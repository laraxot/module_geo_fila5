---
story_id: "design-comuni-segnalazione-02-dati-css-js"
story_title: "Design Comuni: Convert segnalazione-02-dati CSS/JS from Bootstrap Italia to Tailwind + Alpine"
epic: "design-comuni-visual-parity"
status: "ready-for-dev"
priority: "medium"
created: "2026-04-14"
updated: "2026-04-14"
owner: ""
---

# 🎨 Design Comuni: Segnalazione-02-Dati — CSS/JS Phase

## User Story

**As a** FixCity theme developer  
**I want to** convert the segnalazione-02-dati (step 2: data form) page from Bootstrap Italia CSS to our Tailwind CSS + Alpine.js stack  
**So that** the page achieves ≥90% visual parity with the official Design Comuni Italia reference while maintaining semantic HTML and class naming conventions.

---

## Acceptance Criteria

### AC1: HTML Structure Parity
- [ ] Local HTML structure matches reference design HTML (excludes `<script>` tags)
- [ ] All semantic elements preserved: `<section>`, `<nav>`, `<article>`, `<form>`, etc.
- [ ] Bootstrap class names (`cmp-*`, `title-*`, `icon-*`) remain unchanged as CSS class hooks
- [ ] No new classes added except Tailwind utility classes (no custom `cmp-*` variants)
- [ ] Accessible landmarks preserved: `role="navigation"`, `aria-label`, `aria-current`, etc.

### AC2: Visual Parity — CSS/JS Phase
- [ ] Page renders identically to reference at 1920x1080 (desktop)
- [ ] Page renders identically to reference at 768x1024 (tablet)
- [ ] Page renders identically to reference at 375x812 (mobile)
- [ ] Spacing, colors, typography, shadows, borders match exactly
- [ ] Alpine.js interactive elements function: accordion toggles, file uploads, step navigation
- [ ] No bootstrap Italia CSS runtime classes applied (pure Tailwind)
- [ ] Screenshot diff <5% pixel variation vs reference

### AC3: Technical Requirements
- [ ] All Bootstrap Italia class selectors mapped to Tailwind equivalents in `resources/css/app.css`
- [ ] CSS compiled via `npm run build` (Webpack) without errors
- [ ] CSS minified and copied via `npm run copy` into theme dist
- [ ] Alpine.js directives (`x-data`, `x-show`, `@click`) execute correctly in browser
- [ ] No runtime console errors in DevTools
- [ ] Page loads with <3s TTFB on localhost

### AC4: Documentation
- [ ] CSS mapping table created: Bootstrap class → Tailwind @apply rule (see section below)
- [ ] Screenshot comparison saved: local vs reference at 3 viewports
- [ ] Dev notes logged in section "Implementation Notes" for future maintainers
- [ ] Any Alpine.js customizations documented with inline comments

---

## Background & Context

### Design Comuni Italia Requirement
FixCity Fila5 must conform to **Design Comuni Italia** — the mandatory design system for Italian public administrations (AGID/CAD). The page `segnalazione-02-dati` (step 2: report data form) is part of a 7-step wizard for reporting service disruptions (`segnalazione`).

**Reference:** https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html  
**Local:** http://127.0.0.1:8000/it/tests/segnalazione-02-dati

### Current State (as of 2026-04-14)

| Metric | Status |
|--------|--------|
| HTML structural parity | ~70% (body matches, minor nesting differences) |
| CSS/JS visual parity | ~30% (Bootstrap classes applied, colors/spacing off) |
| Bootstrap Italia dependency | CDN not used; classes defined in local CSS |
| Alpine.js directives | Present in Blade template but CSS styling incomplete |
| HTTP status local | 200 ✅ |
| HTTP status reference | 200 ✅ |

**Key Issues Identified:**
1. Bootstrap Italia CSS classes (`.cmp-*`, `.title-*`, `.icon-*`, etc.) are mapped to generic Bootstrap spacing/color rules
2. Tailwind equivalents have NOT been written to `app.css` — classes exist but have no styling
3. Alpine.js `x-data` state for file upload and accordion is defined in HTML but CSS not styled for states
4. Color palette: reference uses AGID brand colors (#0066CC, #DF3B00, #FFCC00); local uses default grays
5. Spacing: reference uses Design Comuni spacing scale (8px, 16px, 24px, 32px, 48px); local uses arbitrary values

---

## Technical Approach

### Phase: CSS/JS Visual Styling (This Story)
This story focuses on **CSS and JavaScript styling only**. The HTML structure is already correct (see AC1). Work happens in:

- **`laravel/Themes/Sixteen/resources/css/app.css`** — All Tailwind @apply rules for class selectors
- **`laravel/Themes/Sixteen/resources/js/app.js`** — Alpine.js event handlers and state management
- **`npm run build`** — Webpack compiles and bundles
- **`npm run copy`** — Moves compiled CSS/JS to theme `dist/` folder

### Build Workflow (Repeat for Each Fix)

```bash
# 1. Make CSS/JS changes in resources/
vim laravel/Themes/Sixteen/resources/css/app.css
vim laravel/Themes/Sixteen/resources/js/app.js

# 2. Compile
cd laravel/Themes/Sixteen
npm run build
npm run copy

# 3. Verify in browser
# Open http://127.0.0.1:8000/it/tests/segnalazione-02-dati
# Compare with https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html

# 4. Screenshot
# Use browser DevTools (F12) > Capture Screenshot at 1920x1080, 768x1024, 375x812
# Save to: laravel/Themes/Sixteen/docs/design-comuni/screenshots/segnalazione-02-dati/

# 5. Document findings
# Update this story or create adjacent dev-notes.md
```

---

## Key Components to Style

### 1. **Breadcrumb Navigation** (`.cmp-breadcrumbs`)
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html (top)
- Current: Basic black text, no separators visible
- Target: 
  - Font: 14px, semi-bold for links
  - Separators (`/`) shown in AGID primary color (#0066CC)
  - Hover state: underline on links
  - Mobile: single line, no wrap

**CSS Mapping:**
```css
.cmp-breadcrumbs {
  @apply py-3 px-4 border-b border-gray-200;
}

.breadcrumb-item {
  @apply text-sm font-semibold;
}

.breadcrumb-item a {
  @apply text-blue-600 hover:underline;
}

.breadcrumb-item .separator {
  @apply text-blue-600 mx-2;
}

.breadcrumb-item.active {
  @apply text-gray-700 cursor-default;
}
```

### 2. **Page Title & Heading** (`.cmp-heading`, `.title-xxxlarge`)
- Reference: Large, bold, left-aligned "Segnalazione disservizio"
- Current: Too small, wrong font-weight
- Target:
  - Font: 48px (desktop), 32px (mobile)
  - Weight: 700 (bold)
  - Color: #1a1a1a (near black)
  - Margin: 32px bottom

**CSS Mapping:**
```css
.cmp-heading {
  @apply pb-3 md:pb-4;
}

.title-xxxlarge {
  @apply text-4xl md:text-5xl font-bold text-gray-900 mb-0;
}
```

### 3. **Step Indicators** (`.steppers`, `.steppers-header`)
- Reference: 3 steps with checkmark on completed, current step highlighted
- Current: Steps visible but styling minimal
- Target:
  - Step 1 "Informativa sulla privacy" → checkmark (✓) in green or primary color
  - Step 2 "Dati di segnalazione" → active, bold, primary color
  - Step 3 "Riepilogo" → disabled/grayed
  - Progress indicator: `2/3` on right side
  - Mobile: hide and show numbered step badge

**CSS Mapping:**
```css
.steppers {
  @apply border-b border-gray-200;
}

.steppers-header ul {
  @apply flex justify-between p-4;
  list-style: none;
}

.steppers-header li {
  @apply text-sm flex items-center gap-2;
}

.steppers-header li.confirmed {
  @apply text-green-600 font-semibold;
}

.steppers-header li.active {
  @apply text-blue-600 font-bold;
}

.steppers-header li:not(.confirmed):not(.active) {
  @apply text-gray-400;
}

.steppers-success {
  @apply w-5 h-5 text-green-600;
}

.steppers-index {
  @apply absolute right-4 top-4 text-xs text-gray-500;
}
```

### 4. **Sidebar Navigation** (`.cmp-navscroll`, `.it-navscroll-wrapper`)
- Reference: Sticky navigation on left (desktop), collapsible accordion on mobile
- Current: Accordion not properly styled
- Target:
  - Desktop (lg+): 3-column layout with sticky left nav
    - Header "INFORMAZIONI RICHIESTE" (uppercase, bold)
    - Accordion with progress bar
    - 3 nav links: Luogo, Disservizio, Autore della segnalazione
  - Mobile: Hidden, controlled by accordion toggle
  - Active link: primary color + underline
  - Progress bar: fills as form sections are completed

**CSS Mapping:**
```css
.cmp-navscroll {
  @apply sticky top-0 hidden lg:block lg:col-span-3;
}

.it-navscroll-wrapper {
  @apply border-r border-gray-200 pr-4;
}

.accordion-button {
  @apply w-full text-left font-bold uppercase text-sm py-2 px-3 text-gray-900;
  @apply hover:bg-gray-50 transition;
}

.accordion-button:not(.collapsed) {
  @apply text-blue-600;
}

.progress {
  @apply h-1 bg-gray-200 rounded-full mt-2;
}

.it-navscroll-progressbar {
  @apply h-full bg-blue-600 rounded-full;
}

.link-list {
  @apply space-y-2 py-3;
}

.nav-link {
  @apply text-sm text-gray-700 hover:text-blue-600 block py-2;
}

.nav-link.active {
  @apply text-blue-600 font-semibold border-l-2 border-blue-600 pl-3 -ml-3;
}
```

### 5. **Form Cards / Sections** (`.cmp-card`, `.card.has-bkg-grey`)
- Reference: White cards with light gray background sections, subtle shadows
- Current: No background, no shadow
- Target:
  - Background: #f9f9f9 (light gray)
  - Padding: 24px (p-big), 32px on desktop (p-lg-4)
  - Shadow: subtle (box-shadow: 0 1px 3px rgba(0,0,0,0.1))
  - Border: none
  - Rounded corners: 4px (not 8px)
  - Section headers: bold, 24px font

**CSS Mapping:**
```css
.cmp-card {
  @apply mb-10;
}

.card.has-bkg-grey {
  @apply bg-gray-100 rounded p-6 md:p-8 shadow-sm;
}

.card-header {
  @apply mb-0 md:mb-5 border-0 p-0;
}

.card-header h2 {
  @apply text-2xl font-bold text-gray-900 mb-3;
}

.card-header .subtitle-small {
  @apply text-sm text-gray-600 mb-0;
}

.card-body {
  @apply p-0;
}
```

### 6. **Form Controls** (`.cmp-input`, `.text-area-wrapper`, `.select-wrapper`)
- Reference: Clean form inputs with labels above, subtle borders
- Current: Inputs visible but styling incomplete
- Target:
  - Label: 14px, gray-700, 8px below input
  - Input/Textarea: 
    - Border: 1px solid #e0e0e0
    - Padding: 12px 16px
    - Font: 16px
    - Focus: blue border, no outline
    - Background: white
  - Select: gray text (#999) for placeholder, custom chevron
  - Required indicator: red asterisk (*)

**CSS Mapping:**
```css
.cmp-input {
  @apply mb-4;
}

.cmp-input__label {
  @apply block text-sm font-semibold text-gray-900 mb-2;
}

.form-control,
.autocomplete,
.text-area,
select.u-grey-dark {
  @apply w-full px-4 py-3 text-base border border-gray-300 rounded;
  @apply focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500;
  @apply bg-white text-gray-900;
}

.form-control::placeholder,
.autocomplete::placeholder {
  @apply text-gray-500;
}

select.u-grey-dark {
  @apply appearance-none pr-8;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' fill='none' stroke='%23666' stroke-width='2'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px 8px;
}

.text-area-wrapper label {
  @apply block text-sm font-semibold text-gray-900 mb-2 d-block;
}

.text-area-wrapper .label {
  @apply text-xs text-gray-500 mt-2 block;
}
```

### 7. **File Upload** (`.btn-wrapper`, file upload Alpine.js)
- Reference: Upload button with file preview thumbnails, remove button per file
- Current: Alpine.js logic present, styling minimal
- Target:
  - Upload area: white background, padding 16px
  - Upload button:
    - Primary blue background (#0066CC)
    - White text, icon on left
    - Padding: 12px 24px
    - Rounded: 4px
    - Hover: darker blue
  - File preview:
    - Thumbnail 48x48px, rounded 4px, object-fit cover
    - Filename next to thumbnail
    - Close (X) button on right, red hover
    - Divider between files
  - Max files indicator: 5 max, size limit 5MB
  - Help text: "Seleziona una o più immagini da allegare alla segnalazione"

**CSS Mapping:**
```css
.btn-wrapper {
  @apply bg-white p-3 md:p-4 md:pt-5;
}

.upload-wrapper {
  @apply flex items-center justify-between py-3 gap-4;
}

.upload-wrapper .img {
  @apply w-12 h-12 rounded object-cover flex-shrink-0;
}

.upload-wrapper span {
  @apply font-bold text-blue-600 flex-1 truncate;
}

.btn.btn-primary {
  @apply bg-blue-600 text-white font-bold py-3 px-6 rounded hover:bg-blue-700 transition;
  @apply flex items-center justify-center gap-2 w-full;
}

.btn.btn-primary .rounded-icon {
  @apply bg-white bg-opacity-30 rounded-full w-6 h-6 flex items-center justify-center flex-shrink-0;
}

.btn.btn-primary .icon-white {
  @apply w-4 h-4 text-white;
}

.upload-wrapper a {
  @apply text-gray-400 hover:text-red-600 transition;
}

.upload-wrapper hr {
  @apply my-2 border-gray-200;
}

.btn-wrapper > p {
  @apply text-xs text-gray-600 mt-3;
}
```

### 8. **Author Info Card** (`.cmp-info-button-card`, `.card-info`)
- Reference: White card with user details, collapsible accordion for additional info
- Current: Card rendered but spacing and colors off
- Target:
  - Card background: white (#ffffff)
  - Padding: 16px (md: 32px)
  - Name: large, bold (18px, 700)
  - Codice Fiscale: "label: value" format, gray label
  - "Mostra tutto" button: outline style, chevron on right
  - Accordion collapse: shows phone + email, formatted as key/value
  - Borders: subtle gray between sections

**CSS Mapping:**
```css
.cmp-info-button-card {
  @apply mt-3;
}

.cmp-info-button-card .card {
  @apply bg-white p-3 md:p-4;
}

.card-body {
  @apply p-0;
}

.big-title {
  @apply text-lg font-bold text-gray-900 mb-0;
}

.card-info {
  @apply text-sm text-gray-600 mt-2 leading-relaxed;
}

.card-info span {
  @apply block text-gray-900 font-semibold;
}

.accordion-button {
  @apply flex items-center gap-2 text-sm text-gray-900 font-semibold;
  @apply hover:text-blue-600 transition py-3;
}

.cmp-info-summary {
  @apply bg-white border-l-4 border-gray-200;
}

.single-line-info {
  @apply border-b border-gray-200 py-3 flex justify-between;
}

.single-line-info > div:first-child {
  @apply text-xs text-gray-600 font-semibold uppercase;
}

.single-line-info .data-text {
  @apply text-sm text-gray-900;
}
```

### 9. **Navigation Buttons** (`.cmp-nav-steps`, `.steppers-nav`)
- Reference: Three buttons at bottom: Back (left), Save (center, desktop only), Next (right)
- Current: Buttons present, spacing unclear
- Target:
  - Layout: flex, justify-between, gap-3
  - Back button: outline style, icon on left
  - Save button: outline style (desktop only), hide on mobile
  - Next button: primary blue, icon on right
  - All buttons: 12px padding, font-semibold
  - Mobile layout: Back and Next stack or flex wrap

**CSS Mapping:**
```css
.cmp-nav-steps {
  @apply mt-8 md:mt-12;
}

.steppers-nav {
  @apply flex justify-between gap-3 items-center;
  list-style: none;
}

.steppers-btn-prev,
.steppers-btn-save,
.steppers-btn-confirm {
  @apply flex items-center gap-2 font-semibold py-2 px-4 text-sm rounded;
}

.steppers-btn-prev {
  @apply text-blue-600 border border-blue-600 hover:bg-blue-50 transition;
}

.steppers-btn-save {
  @apply hidden md:block text-blue-600 border border-blue-600 hover:bg-blue-50 transition;
  @apply bg-white;
}

.steppers-btn-confirm {
  @apply bg-blue-600 text-white hover:bg-blue-700 transition;
}

.cmp-disclaimer {
  @apply bg-green-100 text-green-800 p-4 rounded text-uppercase text-sm font-semibold;
  @apply hidden; /* shown via Alpine.js x-show */
}
```

### 10. **Success Message** (`.cmp-disclaimer`, `#alert-message`)
- Reference: Green alert at bottom, appears on "Save" click, dismisses after 4s
- Current: Present but not visible
- Target:
  - Background: #d4edda (light green)
  - Text: #155724 (dark green)
  - Message: "Richiesta salvata con successo" (uppercase)
  - Animation: fade in/fade out
  - Controlled by Alpine.js `x-show="showSaveAlert"` with 4s timeout

**CSS Mapping (in addition to above):**
```css
.cmp-disclaimer[x-cloak] {
  @apply hidden;
}

.cmp-disclaimer {
  @apply transition-opacity duration-300;
}

.cmp-disclaimer__message {
  @apply text-sm font-bold uppercase;
}
```

---

## Alpine.js Directives

### Already Present in Blade:
1. **Accordion toggle** — `x-data="{ accordionOpen: true, parentsOpen: false }"`
   - Toggle `.cmp-navscroll` sidebar accordion on mobile
   - Control "Mostra tutto" button for author info
   
2. **File upload** — `x-data="{ removeFileLabel: '...', files: [], maxFiles: 5, maxSize: 5MB, addFiles(), removeFile(index) }"`
   - Manage file list in memory
   - Show/hide file previews dynamically
   - Remove individual files
   
3. **Save alert** — `x-data="{ showSaveAlert: false }"` and `@click="showSaveAlert = true; setTimeout(() => showSaveAlert = false, 4000)"`
   - Show success message on Save button click
   - Auto-dismiss after 4s

### CSS for Alpine.js States:
- `[x-cloak]` — Hide elements during Alpine.js initialization
- `[x-show]` — Control visibility (uses `display: block/none`)
- `[@click]` — Event binding (no CSS needed)

**Ensure in CSS:**
```css
[x-cloak] {
  @apply hidden;
}

/* Optional: fade-in/out transitions */
[x-transition] {
  @apply transition-opacity duration-200;
}
```

---

## Testing & Verification

### Desktop (1920x1080)
- [ ] Breadcrumb visible and properly spaced
- [ ] Title is large and bold
- [ ] Sidebar navigation (left) is visible and sticky
- [ ] Form sections are readable with proper spacing
- [ ] Colors match reference (AGID primary blue, grays)
- [ ] Buttons are clickable and hover states work
- [ ] File upload preview works with dummy file
- [ ] Accordion toggles work for author info and sidebar

### Tablet (768x1024)
- [ ] Sidebar navigation collapses/hides
- [ ] Form expands to full width
- [ ] Buttons stack properly (Back/Next on separate rows if needed)
- [ ] Spacing scales down proportionally
- [ ] Touch targets remain ≥48px

### Mobile (375x812)
- [ ] All elements fit without horizontal scroll
- [ ] Navigation breadcrumb text wraps or abbreviates
- [ ] Form inputs are touch-friendly (≥44px tap target)
- [ ] File upload button works with mobile file picker
- [ ] Buttons are full-width or compact

### Alpine.js Interactivity
- [ ] Click sidebar "INFORMAZIONI RICHIESTE" → accordion opens/closes
- [ ] Click "Mostra tutto" → author contact info expands/collapses
- [ ] Click file upload button → opens file picker
- [ ] Select file → adds to preview list (mock in browser or use real file)
- [ ] Click X on file → removes from list
- [ ] Click Save button → green success alert appears and disappears after 4s
- [ ] Click Back → navigates to previous step (should work via `onclick`)
- [ ] Click Next → navigates to next step (should work via `onclick`)

### Visual Comparison (Screenshot)
1. Take screenshot of local page at each viewport
2. Save to `laravel/Themes/Sixteen/docs/design-comuni/screenshots/segnalazione-02-dati/`
3. Compare pixel-by-pixel with reference:
   - Fonts: same size, weight, color?
   - Spacing: same gaps between elements?
   - Colors: exact match (use color picker)?
   - Shadows: present and correct depth?
   - Borders: same thickness and color?

**Success Criteria:** <5% pixel diff visually

---

## File Locations

| File | Purpose | Status |
|------|---------|--------|
| `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` | Template with HTML structure | ✅ Exists, no changes needed |
| `laravel/Themes/Sixteen/resources/css/app.css` | Tailwind @apply rules | 🔄 **To be updated** |
| `laravel/Themes/Sixteen/resources/js/app.js` | Alpine.js handlers | 🔄 Verify, may need updates |
| `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json` | Page content (labels, etc.) | ✅ Exists |
| `npm` scripts in `laravel/Themes/Sixteen/package.json` | Build tools | ✅ Exists |

---

## Implementation Notes

### Key Learnings from Previous Work

1. **Bootstrap Italia Classes as Hooks** — The design system uses classes like `.cmp-breadcrumbs`, `.title-xxxlarge`, `.icon-*` as CSS selectors. These are NOT removed or renamed. Instead, we add Tailwind @apply rules that style them.

2. **@apply Pattern** — Each Bootstrap class gets one or more `@apply` rules:
   ```css
   .title-xxxlarge {
     @apply text-4xl md:text-5xl font-bold text-gray-900;
   }
   ```

3. **Responsive Design** — Use Tailwind breakpoints (`sm:`, `md:`, `lg:`, `xl:`). The design uses 3 main breakpoints:
   - Mobile: <576px
   - Tablet: 576px–1024px
   - Desktop: >1024px

4. **Spacing Scale** — Design Comuni uses 8px base (8, 16, 24, 32, 48, 64). Map to Tailwind:
   - `p-2` = 8px
   - `p-3` = 12px (use for 16px with `p-4`)
   - `p-4` = 16px
   - `p-6` = 24px
   - `p-8` = 32px
   - `p-12` = 48px
   - `p-16` = 64px

5. **Colors** — AGID primary: `#0066CC` (Tailwind `blue-600`). Avoid pure black; use `gray-900`. Backgrounds: `gray-100` (light gray), `white` (white).

6. **Fonts** — Use system font stack from `tailwind.config.js`. No Google Fonts needed. Font sizes match Design Comuni scale: 12px, 14px, 16px, 18px, 24px, 32px, 48px.

---

## Dev Agent Checklist

Before marking this story **DONE**:

- [ ] CSS changes written to `laravel/Themes/Sixteen/resources/css/app.css`
- [ ] `npm run build` executed without errors
- [ ] `npm run copy` executed successfully
- [ ] Page loads at http://127.0.0.1:8000/it/tests/segnalazione-02-dati without 404/500
- [ ] Browser DevTools console: 0 errors, 0 warnings (Alpine-related)
- [ ] All AC1–AC4 criteria verified manually
- [ ] Screenshots taken at 3 viewports and saved
- [ ] Comparison with reference visually reviewed (<5% diff)
- [ ] This story file updated with final notes
- [ ] Sprint status updated: mark story as "done"

---

## Future Related Work

- **Step 1 (Privacy):** `segnalazione-01-privacy` — same CSS/JS approach
- **Step 3 (Summary):** `segnalazione-03-riepilogo` — same CSS/JS approach
- **Step 4 (Confirmation):** `segnalazione-04-conferma` — same CSS/JS approach
- **Alpine.js Cross-Cut Bug:** If `x-data` directives are stripped at runtime, investigate `SixteenComposer.php` and middleware

---

## References

- **Design Comuni Reference:** https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- **Design Comuni Repository:** https://github.com/italia/design-comuni-pagine-statiche
- **Local Blade Template:** `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- **Tailwind Docs:** https://tailwindcss.com/docs
- **Alpine.js Docs:** https://alpinejs.dev/

---

## Story Metadata

**Status:** ready-for-dev  
**Assigned to:** [Dev Agent]  
**Created by:** BMad Create Story Workflow  
**Created:** 2026-04-14  
**Target Completion:** 2026-04-16  
**Epic:** design-comuni-visual-parity (Milestone 1 — CSS/JS Phase)  
**Type:** CSS/JS styling conversion (no HTML structural changes)  
**Estimated Effort:** 4–6 hours (analysis + implementation + testing)

---

*Generated by BMad Create Story Agent — Ultimate Context Engine*  
*For questions or issues, check related docs in `laravel/Themes/Sixteen/docs/design-comuni/`*
