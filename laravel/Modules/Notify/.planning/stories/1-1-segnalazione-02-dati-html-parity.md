# Story 1-1-segnalazione-02-dati-html-parity

## Status: ready-for-dev

## Story

As a developer replicating Design Comuni static pages,
I want the segnalazione-02-dati page to achieve ≥80% HTML structural parity with the reference,
so that citizens see an identical interface when reporting service disruptions.

## Epic

**Epic 1**: Design Comuni HTML Parity — Segnalazione Flow
**Story**: 1 of 7 (segnalazione pages)

---

## Acceptance Criteria

### AC1: HTML Structure Parity ≥80%
- **Given** the reference page at `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **When** I run `bashscripts/html/compare-html.sh` comparing reference vs `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Then** the structural similarity score is ≥80%
- **And** all semantic HTML5 tags match (`<header>`, `<main>`, `<nav>`, `<section>`, `<article>`, `<aside>`, `<footer>`)
- **And** all `data-element` AGID attributes are present and match reference

### AC2: Header Parity (Desktop/Tablet/Mobile)
- **Given** the reference header with `it-header-slim-wrapper` + `it-header-wrapper`
- **When** I view the local page at 3 breakpoints (≥1200px, 768-1199px, <768px)
- **Then** the header structure matches:
  - **Desktop**: Slim header (region link + language dropdown + login) + Full header (logo + search + main nav)
  - **Tablet**: Collapsed navigation with hamburger menu
  - **Mobile**: Single-column header with accessible navigation
- **And** all header semantic IDs are present: `#head-section`, `#it-main-menu`, `#mobile-menu`, `#search-modal`

### AC3: Skiplinks Present
- **Given** WCAG 2.1 AA requires skip navigation links
- **When** I inspect the page source
- **Then** a `<div class="skiplinks">` exists as the first element inside `<body>`
- **And** it contains links to `#main-container` and `#it-main-menu`

### AC4: Stepper Component Structural Match
- **Given** the reference stepper with 4 steps (Privacy → Dati → Dettagli → Conferma)
- **When** I inspect the stepper HTML
- **Then** it has the exact structure: `<div class="steppers">` > `<div class="steppers-header">` > `<ul>` > `<li>` items
- **And** completed steps have class `confirmed` with check icon SVG
- **And** active step has class `active` with number span
- **And** `data-bs-navscroll=""` attribute is present on the navscroll `<nav>`

### AC5: Form Elements Match
- **Given** the reference form with autocomplete, select, and input fields
- **When** I inspect form elements
- **Then** all `<label>` elements have correct `for` attributes matching input `id`
- **And** autocomplete region field has `active` class on its label
- **And** all `<select>` elements have proper `<option>` structure matching reference
- **And** no hardcoded Italian text — all strings use `__('fixcity::...')` translations

### AC6: No Bootstrap Italia CSS/JS
- **Given** the project uses TailwindCSS + Alpine.js (NOT Bootstrap)
- **When** I inspect the rendered HTML
- **Then** NO `<link>` to bootstrap-italia CSS is present
- **And** NO `<script>` loading bootstrap-italia JS is present
- **And** Bootstrap class names ARE present in HTML (row, col-12, btn, card, etc.)
- **And** styling is provided via TailwindCSS `@apply` in `style-apply.css`

---

## Tasks / Subtasks

### Task 1: Add Skiplinks to Layout (AC: 3)
- [ ] Edit `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php`
- [ ] Add `<div class="skiplinks">` as first element inside `<body>` (before header)
- [ ] Include links: "Vai al contenuto principale" → `#main-container`, "Vai al menu" → `#it-main-menu`
- [ ] Follow reference pattern: `<a href="#main-container" class="visually-hidden">...</a>`

### Task 2: Fix Header Structure (AC: 2, 6)
- [ ] Review `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php` header section
- [ ] Ensure structure matches reference:
  ```html
  <div id="head-section">
    <div class="it-header-slim-wrapper">
      <!-- Region link, language dropdown, login -->
    </div>
    <div class="it-header-wrapper">
      <!-- Logo, search, main nav -->
    </div>
  </div>
  ```
- [ ] Verify responsive behavior at 3 breakpoints
- [ ] Ensure Alpine.js replaces Bootstrap JS for hamburger menu toggle
- [ ] Ensure `data-element` attributes match reference

### Task 3: Fix Stepper data-bs-navscroll (AC: 4)
- [ ] Edit `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- [ ] Find the navscroll `<nav>` element (around line 88)
- [ ] Add `data-bs-navscroll=""` attribute
- [ ] Verify stepper structure matches reference exactly

### Task 4: Fix Form Label active Class (AC: 5)
- [ ] In `segnalazione-02-dati.blade.php`, find the autocomplete region label (around line 131)
- [ ] Add `active` class to the `<label>` element
- [ ] Verify label `for` matches input `id`

### Task 5: Add Missing card-footer Div (AC: 1)
- [ ] In `segnalazione-02-dati.blade.php`, find the report-author section
- [ ] Add missing `<div class="card-footer p-0 d-none"></div>` before closing `</div>` of card
- [ ] Verify structural parity with reference

### Task 6: Run HTML Parity Validation
- [ ] Run: `bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html" "http://127.0.0.1:8000/it/tests/segnalazione-02-dati" /tmp/validate-02-dati`
- [ ] Verify similarity ≥80%
- [ ] Check all `data-element` attributes present
- [ ] Check all semantic HTML5 tags present
- [ ] If <80%, iterate on remaining structural differences

### Task 7: Build Theme Assets
- [ ] Run: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- [ ] Verify no build errors
- [ ] Clear browser cache and verify visual parity

---

## Dev Notes

### Architecture Context

**File Structure:**
```
laravel/Themes/Sixteen/
├── resources/views/
│   ├── components/layouts/
│   │   └── app.blade.php          ← Layout (header, skiplinks, main wrapper)
│   └── components/blocks/
│       ├── tests/
│       │   └── segnalazione-02-dati.blade.php  ← Main page content
│       └── flow/
│           └── stepper.blade.php  ← Multi-step stepper component
├── resources/css/
│   └── style-apply.css           ← Tailwind @apply for Bootstrap classes
```

**Current HTML Parity: ~64.2%** (from batch report at `laravel/Themes/Sixteen/docs/html-parity-reports/segnalazione-02-dati/report.md`)

**Key Structural Differences:**
1. Missing `<div class="skiplinks">` → layout level
2. Missing `data-bs-navscroll=""` on navscroll nav → 1 line fix
3. Missing `active` class on autocomplete label → 1 line fix
4. Missing `card-footer p-0 d-none` div → 1 line fix

**Translation Pattern:**
- Format: `fixcity::segnalazione.fields.title.label` (5 levels: namespace::context.collection.element.type)
- WRONG: `fixcity::rating.title` (missing .collection.)
- WRONG: `SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE` (uppercase, wrong format)

**Block Loading:**
- Page loads via `Page::getBlocksBySlug('tests.segnalazione-02-dati', 'content')`
- Bug fixed in `Modules/Cms/app/Models/Traits/HasBlocks.php` (translatable fields now handled correctly)
- JSON content at: `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json`

**Bootstrap Italia Classes:**
- Bootstrap class names ARE used in HTML for structural parity (row, col-12, btn, card, form-check, title-*, etc.)
- Bootstrap CSS/JS files are NEVER loaded
- Styling via TailwindCSS `@apply` in `style-apply.css`
- Interactivity via Alpine.js (x-data, @click, x-show) — NEVER data-bs-* attributes that require JS

### Testing Requirements
- Run HTML parity script after each structural change
- Verify at 3 breakpoints: desktop (≥1200px), tablet (768-1199px), mobile (<768px)
- No regression on other segnalazione pages

### Technical Constraints
- PHP 8.3.20, Laravel 12, Livewire 3, Volt, Folio
- TailwindCSS v3 + Alpine.js
- NO Bootstrap Italia CSS/JS files
- Multi-language (it, en) — no hardcoded Italian strings

---

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-10 | 1.0 | Initial story creation | AI Agent |

## Dev Agent Record

### Agent Model Used
Qwen Code (Claude Sonnet 4 equivalent)

### Debug Log References
- HasBlocks.php translatable fields fix: `Modules/Cms/app/Models/Traits/HasBlocks.php` lines 28-44
- HTML parity batch script: `bashscripts/html/compare-batch.sh`

### Completion Notes
- **BUG FIX**: `HasBlocks.php` now correctly handles translatable fields with locale keys `{it: [...], en: []}` instead of treating them as block arrays
- **Fix 1**: Added `data-bs-navscroll=""` to navscroll nav element
- **Fix 2**: Added `active` class to autocomplete region label
- **Fix 3**: Added missing `card-footer p-0 d-none` div in report-author section
- **Fix 4**: Reverted `skiplinks` → `skiplink` to match reference
- **Result**: HTML parity improved from 46.5% → 63.6% (before → after HasBlocks fix)
- **Remaining gap**: Header/footer elements managed at layout level; Alpine.js/Livewire adds extra `<template>` and `<link>` elements not in reference

### File List
- `laravel/Modules/Cms/app/Models/Traits/HasBlocks.php` - Bug fix for translatable fields
- `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php` - Skiplink class fix
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` - 3 structural fixes
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/stepper.blade.php` - Created stepper component
- `bashscripts/html/compare-batch.sh` - Created batch comparison script
- `bashscripts/html/segnalazione-pages.txt` - Created pages list for batch
- `bashscripts/html/README.md` - Created documentation
- `laravel/Themes/Sixteen/docs/html-parity-reports/` - Created reports directory with per-page reports

### Change Log
| Date | Change |
|------|--------|
| 2026-04-10 | Created story, fixed HasBlocks bug, applied 4 structural fixes, built comparison tooling |
