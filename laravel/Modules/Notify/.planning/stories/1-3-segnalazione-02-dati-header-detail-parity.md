# Story: Header Detail Visual Parity - segnalazione-02-dati

## Status: ready-for-dev

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a developer replicating Design Comuni static pages,
I want every header element to be pixel-perfect with the reference,
so that citizens cannot distinguish local from the official Design Comuni template.

---

## Acceptance Criteria

### AC1: "Cerca" Text Position
- **Given** the reference shows "Cerca" text to the LEFT of the search icon (same baseline)
- **When** I inspect the local header search area
- **Then** "Cerca" appears on the same horizontal line as the search icon
- **And** "Cerca" is immediately to the left of the search circle button
- **And** both share the same vertical alignment (mid-height)

### AC2: "Accedi all'area personale" Visibility
- **Given** the reference shows a visible user icon + text in the slim header
- **When** I inspect the local slim header
- **Then** the user icon is clearly visible (white on dark background)
- **And** the text "Accedi all'area personale" is readable (not dark-on-dark)
- **And** the button has proper contrast matching reference

### AC3: Navigation Links — No Underline
- **Given** the reference navigation links are NOT underlined
- **When** I inspect the local main navigation
- **Then** links like "Amministrazione", "Novità", "Servizi" have NO underline
- **And** only hover state shows underline (if applicable)

### AC4: Tab Stepper Styling
- **Given** the reference tab stepper has clean horizontal dividers
- **When** I inspect the local tab stepper
- **Then** the active tab "Dati di segnalazione" has a green underline
- **And** completed tab "Informativa sulla privacy" shows a green checkmark on the right
- **And** inactive tab "Riepilogo" is grayed out
- **And** no extra decorative elements beyond reference

### AC5: Social Icons Spacing
- **Given** the reference has consistent spacing between social icons
- **When** I inspect the local social icons
- **Then** spacing between "Seguici su" text and first icon matches reference
- **And** spacing between each social icon is uniform

### AC6: HTML Parity Maintained
- **Given** the HTML parity requirement (≥80%)
- **When** I run the HTML comparison script
- **Then** the structural similarity score remains ≥80%
- **And** body tag remains plain `<body>` with no classes

---

## Tasks / Subtasks

### Task 1: Fix "Cerca" + Search Icon Alignment (AC: 1)
- [ ] Inspect reference: "Cerca" text + search icon on same baseline
- [ ] Modify `Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- [ ] Wrap "Cerca" text and search button in a flex container with `align-items: center`
- [ ] Use Tailwind `@apply` in `style-apply.css` for vertical centering
- [ ] Verify "Cerca" is LEFT of search icon (not above)

### Task 2: Fix "Accedi all'area personale" Visibility (AC: 2)
- [ ] Check current button styling in header slim wrapper
- [ ] Ensure icon is white (not dark on dark background)
- [ ] Ensure text is visible (contrast issue)
- [ ] Use CSS `@apply` to fix colors: white icon + white text on dark slim header

### Task 3: Remove Navigation Link Underlines (AC: 3)
- [ ] Add CSS rule to remove underline from main nav links
- [ ] Use `@apply no-underline` or `text-decoration: none` in `style-apply.css`
- [ ] Verify at all breakpoints

### Task 4: Fix Tab Stepper Styling (AC: 4)
- [ ] Inspect current tab stepper CSS
- [ ] Match reference: clean horizontal green underline for active tab
- [ ] Add checkmark icon for completed step (right-aligned)
- [ ] Gray out inactive tab text
- [ ] Remove any extra decorative elements

### Task 5: Fix Social Icons Spacing (AC: 5)
- [ ] Check spacing between "Seguici su" and icons
- [ ] Check spacing between individual social icons
- [ ] Adjust gap/margin using Tailwind utilities
- [ ] Verify against reference screenshot

### Task 6: Build + Verify
- [ ] Run `cd Themes/Sixteen && npm run build && npm run copy`
- [ ] Take desktop screenshot
- [ ] Compare pixel-by-pixel with reference
- [ ] Verify HTML parity ≥80%

---

## Dev Notes

### Architecture Context

**Files to Modify:**
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — HTML structure for search, slim header
- `laravel/Themes/Sixteen/resources/css/style-apply.css` — Visual fixes via `@apply`

**Reference Analysis (from screenshots):**

| Element | Reference | Local (Current) | Fix Needed |
|---------|-----------|-----------------|------------|
| "Cerca" + Search | Same line, left of icon | "Cerca" ABOVE icon | ✅ Yes — flex align |
| User icon + text | White on dark, visible | Dark on dark, invisible | ✅ Yes — color fix |
| Nav links | No underline | Underlined | ✅ Yes — remove underline |
| Tab stepper | Clean green underline | Different styling | ✅ Yes — match reference |
| Social spacing | Uniform gaps | Slightly off | ✅ Yes — adjust gap |

**Key Principle:** 
- HTML structure must match reference EXACTLY
- Visual differences fixed via CSS ONLY (Tailwind @apply)
- `<body>` tag MUST remain plain — NO classes
- ALL text must use translation keys

### Technical Constraints
- PHP 8.3.20, Laravel 12, Livewire 3, Volt, Folio
- TailwindCSS v3 + Alpine.js (NO Bootstrap CSS/JS)
- Bootstrap class names ARE used in HTML for parity
- Multilingual: ALL text via `__('namespace::key')`

### Completed Fixes (Previous Sessions)
- ✅ Stepper CSS: Mobile-first responsive (Commit: `8f547e01d`)
- ✅ Stepper i18n: No hardcoded Italian (Commit: `8f547e01d`)
- ✅ Body tag: Plain `<body>` (Commit: `3c1417e0a`)

---

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-12 | 1.0 | Initial story from screenshot analysis | AI Agent |

---

## Dev Agent Record

### Agent Model Used
_(not yet run)_

### Debug Log References
- Screenshot comparison: ref-header-closeup vs local-header-closeup

### Completion Notes
_(not yet run)_

### File List
_(not yet run)_

### Change Log
_(not yet run)_
