# Story: segnalazione-crea Header Parity + Stepper Responsive + Language Dropdown

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a mobile-first citizen using the Fixcity segnalazione wizard at `/it/tests/segnalazione-crea`,
I want the header (hamburger alignment, search text, language selector, stepper) to visually match the Design Comuni reference `segnalazione-01-privacy.html` on all breakpoints,
so that I experience a consistent, professional interface when reporting service disruptions.

---

## Acceptance Criteria

### AC1: Hamburger Menu Vertically Centered in Navbar
- **Given** the viewport is mobile (width < 992px)
- **When** I view the header navbar-wrapper with the hamburger button
- **Then** the hamburger (`.custom-navbar-toggler`) is **vertically centered** within the navbar row
- **And** the icon inside the button is also centered (flex display)
- **And** it matches the reference behavior at `segnalazione-01-privacy.html`

### AC2: "Cerca" Text Appears Next to Search Icon on Tablet+
- **Given** the viewport is tablet or desktop (width >= 768px)
- **When** I view the header center wrapper right zone
- **Then** the text "Cerca" appears to the LEFT of the search magnifying glass
- **And** on mobile (< 768px) the text is hidden (`d-none d-md-block` pattern from reference)
- **And** the CSS class matches reference: `<span class="d-none d-md-block">Cerca</span>`

### AC3: Language Selector Dropdown Functional
- **Given** any viewport size
- **When** I click the language selector button showing "ITA"
- **Then** the dropdown menu opens showing "ITA selezionata" and "ENG" options
- **And** Bootstrap JS dropdown works (NOT Alpine.js conflict)
- **And** the dropdown structure matches reference: `.nav-item.dropdown > button.dropdown-toggle + .dropdown-menu`

### AC4: Language Selector Icon Correct Color
- **Given** the language selector dropdown toggle
- **When** I view the expand icon (chevron) to the right of "ITA"
- **Then** the icon has NO extra background color (matches text color)
- **And** the icon uses the same `fill: currentColor` as the reference
- **And** the icon class is `.icon` without additional modifier classes

### AC5: Stepper Responsive on /it/tests/segnalazione-crea
- **Given** the segnalazione-crea page with its stepper
- **When** I view at mobile (< 992px)
- **Then** the stepper labels wrap without horizontal overflow
- **And** the stepper index (e.g. "1/3") is visible and properly positioned
- **And** no scrollbar appears
- **When** I view at desktop (>= 992px)
- **Then** the stepper is fully horizontal matching `segnalazione-01-privacy.html`

### AC6: NO Hardcoded Italian in Blade Templates
- **Given** ALL blade templates modified in this story
- **When** I scan for hardcoded strings
- **Then** ALL user-visible text uses `__('fixcity::*')` translation keys
- **And** ZERO hardcoded Italian strings remain

---

## Dev Technical Guidance — GAP ANALYSIS vs REFERENCE

### Reference Source
- Page: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Fetched: 2026-04-12 via curl

### Gap 1: Search Text Uses Wrong Class

**Reference (EXACT):**
```html
<div class="it-search-wrapper">
  <span class="d-none d-md-block">Cerca</span>
  <button class="search-link rounded-icon" type="button" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="Cerca nel sito">
    <svg class="icon"><use href="...#it-search"></use></svg>
  </button>
</div>
```

**Our current (WRONG):**
```html
<div class="it-search-wrapper d-flex align-items-center">
  <span class="search-label me-2">Cerca</span>
  <button class="search-link rounded-icon" ...>
```

**Fix:** Change to match reference EXACTLY:
```blade
<div class="it-search-wrapper">
  <span class="d-none d-md-block">Cerca</span>
  <button class="search-link rounded-icon" ...>
```

Remove `d-flex align-items-center` from the wrapper — reference doesn't have it. The `d-none d-md-block` is the Bootstrap utility that hides "Cerca" on mobile and shows it on tablet+.

### Gap 2: Hamburger Button NOT Vertically Centered

**Reference (EXACT):**
```html
<div class="navbar navbar-expand-lg has-megamenu">
  <button class="custom-navbar-toggler" type="button" aria-controls="nav4" aria-expanded="false" aria-label="Mostra/Nascondi la navigazione" data-bs-target="#nav4" data-bs-toggle="navbarcollapsible">
    <svg class="icon"><use href="...#it-burger"></use></svg>
  </button>
  <div class="navbar-collapsable" id="nav4">
    <div class="overlay" style="display: none;"></div>
    <div class="close-div">...</div>
    <div class="menu-wrapper">...</div>
  </div>
</div>
```

**Our current:**
```html
<div class="navbar navbar-expand-lg has-megamenu">
  <button class="custom-navbar-toggler" type="button" ... @click="toggle()">
    <svg class="icon"><use href="...#it-burger"></use></svg>
  </button>
  <div x-show="mobileNavOpen" ... class="navbar-overlay" ...></div>
  <div x-show="mobileNavOpen" ... class="navbar-collapsable" ...>
```

**Key differences:**
1. Reference uses Bootstrap JS `data-bs-toggle="navbarcollapsible"` — we use Alpine.js `@click="toggle()"`
2. Reference has `.overlay` INSIDE `.navbar-collapsable` — we have a separate `.navbar-overlay` OUTSIDE
3. Reference navbar row uses Bootstrap's flex alignment — our Alpine version may not be vertically centered

**Fix needed:**
```css
/* Center hamburger button vertically in navbar row */
.it-header-navbar-wrapper .navbar {
  display: flex;
  align-items: center;
}

.it-header-navbar-wrapper .custom-navbar-toggler {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 48px;
  padding: 0 12px;
  border: none;
  background: transparent;
  cursor: pointer;
}

.it-header-navbar-wrapper .custom-navbar-toggler .icon {
  width: 24px;
  height: 24px;
}
```

### Gap 3: Language Dropdown NOT Working

**Root cause:** Bootstrap JS dropdown (`data-bs-toggle="dropdown"`) requires Bootstrap JS bundle. If Bootstrap JS is NOT loaded on test routes, the dropdown won't open.

**Our header.blade.php (line 18-35):**
```blade
<div class="nav-item dropdown">
  <button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" ...>
    <span>ITA</span>
    <svg class="icon"><use href="...#it-expand"></use></svg>
  </button>
  <div class="dropdown-menu">...</div>
</div>
```

**Fix options:**

**Option A (Preferred): Ensure Bootstrap JS is loaded**
- Verify Bootstrap JS is included in `app.js` Vite entry
- Confirm no Alpine.js conflict with Bootstrap dropdown

**Option B (Fallback): Alpine.js dropdown**
If Bootstrap JS conflicts, convert to Alpine:
```blade
<div class="nav-item dropdown" x-data="{ langOpen: false }">
  <button type="button" class="nav-link dropdown-toggle" @click="langOpen = !langOpen" :aria-expanded="langOpen.toString()">
    <span>ITA</span>
    <svg class="icon"><use href="...#it-expand"></use></svg>
  </button>
  <div class="dropdown-menu" x-show="langOpen" @click.outside="langOpen = false" x-cloak>
    ...
  </div>
</div>
```

### Gap 4: Language Icon Has Different Background

**Reference:** The `<svg class="icon">` inside the dropdown toggle has NO extra background. The icon uses default `fill: currentColor`.

**Our current:** Same structure — the issue may be CSS from Bootstrap or Tailwind adding a background to `.dropdown-toggle`.

**Fix:**
```css
.it-header-slim-wrapper .nav-item.dropdown .dropdown-toggle .icon {
  background: transparent;
  fill: currentColor;
}
```

### Gap 5: Stepper Responsive on segnalazione-crea

**File:** `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

The stepper HTML structure matches the reference. The CSS fix from story 1-3 (`segnalazione-parity.css`) should apply.

**Verify:** The stepper CSS selectors target `.steppers-header` globally — confirm they apply within `.ticket-wizard-root` wrapper.

If not, add:
```css
.ticket-wizard-root .steppers-header {
  /* same mobile-first rules from segnalazione-parity.css */
}
```

### Gap 6: Other Potential Issues to Check

From the user's report "molti altri errori" — check these against reference:

1. **Header slim wrapper**: Reference has `<a class="d-lg-block navbar-brand">` — our code has `<a class="navbar-brand">` (missing `d-lg-block`)
2. **Navbar overlay**: Reference uses `.overlay` inside `.navbar-collapsable` — verify ours works the same way
3. **Menu structure**: Reference has `.menu-wrapper` with `.logo-hamburger` — verify structure matches

---

## Tasks / Subtasks

### Task 1: Fix "Cerca" Text Visibility (AC: 2)
- [ ] Read `header.blade.php` search section
- [ ] Change `<div class="it-search-wrapper d-flex align-items-center">` → `<div class="it-search-wrapper">`
- [ ] Change `<span class="search-label me-2">Cerca</span>` → `<span class="d-none d-md-block">Cerca</span>`
- [ ] Remove any CSS that hides `.search-label` (no longer needed)
- [ ] Verify: "Cerca" hidden at < 768px, visible at >= 768px

### Task 2: Fix Hamburger Menu Vertical Alignment (AC: 1)
- [ ] Read `header.blade.php` navbar section
- [ ] Add CSS to `design-comuni-global-fixes.css` or `header-parity.css`:
  - `.it-header-navbar-wrapper .navbar { display: flex; align-items: center; }`
  - `.custom-navbar-toggler { display: inline-flex; align-items: center; justify-content: center; height: 48px; }`
- [ ] Verify at 375px, 768px, 1024px — hamburger centered vertically

### Task 3: Fix Language Dropdown Functionality (AC: 3)
- [ ] Check if Bootstrap JS is loaded on `/it/tests/*` routes
- [ ] If loaded: test dropdown — if still broken, check for Alpine.js conflict
- [ ] If not loaded: EITHER add Bootstrap JS to Vite build OR convert to Alpine dropdown
- [ ] Test dropdown opens/closes at all breakpoints
- [ ] Verify language options display correctly

### Task 4: Fix Language Selector Icon Color (AC: 4)
- [ ] Check CSS for `.dropdown-toggle .icon` — ensure no background added
- [ ] Add CSS: `.it-header-slim-wrapper .dropdown-toggle .icon { background: transparent; fill: currentColor; }`
- [ ] Verify icon matches reference appearance

### Task 5: Fix Header Slim Wrapper Region Link (Gap 6)
- [ ] Read `header.blade.php` slim wrapper
- [ ] Change `<a class="navbar-brand"` → `<a class="d-lg-block navbar-brand"`
- [ ] Verify region link shows correctly at desktop

### Task 6: Verify Stepper Responsive on segnalazione-crea (AC: 5)
- [ ] Open `/it/tests/segnalazione-crea`
- [ ] Test at 375px — stepper must not overflow
- [ ] Test at 768px — stepper should be readable
- [ ] Test at 1024px — full horizontal layout
- [ ] If not responsive, add CSS selector for `.ticket-wizard-root .steppers-header`

### Task 7: Scan for Hardcoded Italian (AC: 6)
- [ ] Scan `header.blade.php` for hardcoded strings
- [ ] Replace any found with translation keys
- [ ] Add missing keys to it/en translation files

### Task 8: Build and Visual Verify (All AC)
- [ ] Run `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- [ ] Open `/it/tests/segnalazione-crea`
- [ ] Side-by-side compare with `segnalazione-01-privacy.html` reference
- [ ] Test at 375px, 768px, 1024px
- [ ] Verify ALL issues resolved

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: Bootstrap JS/Alpine.js conflict on language dropdown
- **Mitigation**: If conflict exists, use pure Alpine dropdown (x-data, x-show, @click.outside)
- **Verification**: Test dropdown opens and closes correctly

### Rollback Plan
- Git commit before changes
- Revert header CSS if hamburger centering breaks other pages

### Safety Checks
- [ ] Header works on ALL pages (not just segnalazione-crea)
- [ ] Language dropdown functional on segnalazione-crea
- [ ] Desktop layout unchanged after mobile fixes
- [ ] Build succeeds without errors

---

## Dev Notes

### Reference Pages
- Header + stepper reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Fetched raw HTML via curl on 2026-04-12

### File Paths to Modify

1. **Header HTML:**
   - `Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`

2. **CSS (hamburger centering, search text, language icon):**
   - `Themes/Sixteen/resources/css/design-comuni-global-fixes.css` OR
   - `Themes/Sixteen/resources/css/header-parity.css` (new)

3. **Stepper CSS (if needed):**
   - `Themes/Sixteen/resources/css/segnalazione-parity.css`

4. **Translations (if any new keys needed):**
   - `Modules/Fixcity/lang/it/segnalazione.php`
   - `Modules/Fixcity/lang/en/segnalazione.php`

### Build Process

```bash
cd laravel/Themes/Sixteen
npm run build && npm run copy
```

---

## Testing

### Visual Testing
1. Chrome DevTools → Device Mode
2. Test at 375px (iPhone SE) — hamburger centered, "Cerca" hidden, stepper usable
3. Test at 768px (iPad) — "Cerca" visible, language dropdown works
4. Test at 1024px+ (desktop) — all elements aligned with reference
5. Side-by-side comparison with `segnalazione-01-privacy.html`

### Functional Testing
1. Click hamburger → menu opens/closes smoothly
2. Click language dropdown → options show and are selectable
3. Click search icon → search modal opens
4. Language switching changes text (if i18n route switching implemented)

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] Hamburger menu vertically centered on mobile
- [ ] "Cerca" text visible at tablet+ breakpoints, hidden on mobile
- [ ] Language selector dropdown functional at all breakpoints
- [ ] Language icon color matches reference (no extra background)
- [ ] Stepper responsive on segnalazione-crea (mobile/tablet/desktop)
- [ ] ZERO hardcoded Italian strings
- [ ] `npm run build && npm run copy` succeeds
- [ ] Visual parity verified on all breakpoints vs `segnalazione-01-privacy.html`
