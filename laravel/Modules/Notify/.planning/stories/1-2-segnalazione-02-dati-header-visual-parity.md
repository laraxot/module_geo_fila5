# Story: Header Visual Parity - segnalazione-02-dati

## Status: backlog

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a developer replicating Design Comuni static pages,
I want the segnalazione-02-dati header to visually match the reference pixel-by-pixel,
so that citizens see an identical interface when reporting service disruptions.

---

## Acceptance Criteria

### AC1: Hamburger Menu Position
- **Given** the reference header at desktop/tablet/mobile breakpoints
- **When** I view the local page header
- **Then** the hamburger menu button appears to the LEFT of the logo (not right)
- **And** clicking it opens the mobile navigation overlay

### AC2: Logo + Slogan Layout
- **Given** the reference header with logo and tagline
- **When** I inspect the header structure
- **Then** the slogan "Un comune da vivere" appears BELOW the logo text "Il mio Comune"
- **And** the slogan is visible at all breakpoints (not hidden on mobile)

### AC3: Language Selector
- **Given** the reference language selector showing only "ITA" with a dropdown arrow
- **When** I inspect the language selector
- **Then** it shows ONLY the text "ITA" and a chevron-down icon
- **And** there are NO extra arrows, icons, or text beyond the reference

### AC4: Search Icon Position
- **Given** the reference search icon positioned on the far right of the header
- **When** I inspect the header right zone
- **Then** the search icon (lente d'ingrandimento) is the RIGHTMOST element
- **And** social icons appear to its left

### AC5: HTML Parity Maintained
- **Given** the HTML parity requirement (≥80%)
- **When** I run the HTML comparison script
- **Then** the structural similarity score remains ≥80%
- **And** NO new Bootstrap Italia CSS/JS files are added

### AC6: Body Tag Plain (NO Classes)
- **Given** the reference HTML has `<body>` without classes or ids
- **When** I inspect the local page source
- **Then** the body tag is plain `<body>` with NO classes or ids
- **And** any page-specific CSS classes are applied to wrapper divs inside body, NOT the body tag itself

---

## Tasks / Subtasks

### Task 1: Fix Hamburger Menu Position (AC: 1, 6)
- [ ] Study reference header structure in `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- [ ] Check if reference uses `it-header-wrapper` with hamburger button BEFORE logo
- [ ] Modify `Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- [ ] Move hamburger button to left of `.it-brand-wrapper`
- [ ] Use Tailwind CSS order utilities or flex-direction for positioning
- [ ] Verify at mobile breakpoint (<768px)
- [ ] Ensure body tag remains plain with NO classes added

### Task 2: Fix Logo + Slogan Layout (AC: 2, 6)
- [ ] Check if slogan is hidden on mobile (`d-none d-md-block`)
- [ ] Modify to show slogan at ALL breakpoints
- [ ] Ensure proper vertical spacing between title and tagline
- [ ] Use Tailwind `@apply` in `style-apply.css` for responsive adjustments
- [ ] Ensure body tag remains plain

### Task 3: Fix Language Selector (AC: 3)
- [ ] Inspect current language selector in header.blade.php
- [ ] Remove any extra icons/buttons beyond "ITA" text + chevron
- [ ] Match reference: simple text "ITA" with dropdown arrow only
- [ ] Verify dropdown menu structure matches reference

### Task 4: Fix Search Icon Position (AC: 4)
- [ ] Check current search icon position in header
- [ ] Move search to far right (after social icons)
- [ ] Use flex order or DOM order to position correctly
- [ ] Verify at all breakpoints

### Task 5: Build + Verify Visual Parity
- [ ] Run `cd Themes/Sixteen && npm run build && npm run copy`
- [ ] Take desktop/tablet/mobile screenshots
- [ ] Compare with reference screenshots
- [ ] Verify HTML parity script still shows ≥80%
- [ ] Verify body tag is plain `<body>` with no classes

---

## Dev Notes

### Architecture Context

**Files to Modify:**
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — Header HTML structure
- `laravel/Themes/Sixteen/resources/css/style-apply.css` — Tailwind @apply for Bootstrap classes

**Key Principle:** 
- HTML structure must match reference EXACTLY (same tags, same attributes)
- Visual differences are fixed via CSS ONLY (Tailwind @apply)
- NEVER add/remove HTML elements to fix visual issues
- NEVER load Bootstrap Italia CSS/JS files
- **CRITICAL**: `<body>` tag MUST remain plain with NO classes or ids — apply page-specific CSS to wrapper divs inside body

**Reference Header Structure:**
```html
<header class="it-header-wrapper">
  <div class="it-header-slim-wrapper">
    <!-- Region link, language selector, login -->
  </div>
  <div class="it-nav-wrapper">
    <div class="it-header-center-wrapper">
      <!-- Logo + slogan LEFT, social + search RIGHT -->
    </div>
  </div>
</header>
```

**Current Issues (from screenshots):**
1. Hamburger menu is on RIGHT of logo instead of LEFT
2. Slogan hidden on mobile (`d-none d-md-block`)
3. Language selector has extra elements beyond reference
4. Search icon not positioned as far right as reference

**Completed Fixes:**
- ✅ Stepper CSS: Mobile-first responsive stepper added (Commit: `8f547e01d`)
- ✅ Stepper i18n: Hardcoded Italian replaced with translation keys
- ✅ Body tag: Plain `<body>` with no classes (Commit: `3c1417e0a`)

### Technical Constraints
- PHP 8.3.20, Laravel 12, Livewire 3, Volt, Folio
- TailwindCSS v3 + Alpine.js (NO Bootstrap CSS/JS)
- Bootstrap class names ARE used in HTML for parity
- Styling via `@apply` in `style-apply.css`
- Multilingual: ALL text must use `__('namespace::key')` translation helpers
- Translation format: 5 levels (`fixcity::context.collection.element.type`)

---

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-12 | 1.0 | Initial story creation from screenshot analysis | AI Agent |
| 2026-04-12 | 1.1 | Updated with completed stepper fixes and body tag rule | AI Agent |

---

## Dev Agent Record

### Agent Model Used
_(not yet run)_

### Debug Log References
- Commit `8f547e01d`: Mobile-first responsive stepper CSS + i18n
- Commit `3c1417e0a`: Plain body tag (no classes)

### Completion Notes
_(not yet run)_

### File List
_(not yet run)_

### Change Log
_(not yet run)_
