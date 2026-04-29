# Story: Segnalazione-02-Dati Stepper Responsive + No Hardcoded Italian + Body Plain Rule

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a mobile-first citizen using the Fixcity platform,
I want the segnalazione-02-dati stepper to be fully responsive on mobile/tablet with NO hardcoded Italian text,
so that I can complete my service disruption report on any device in my preferred language.

---

## Acceptance Criteria

### AC1: Stepper Responsive on Mobile (<768px)
- **Given** the segnalazione-02-dati page viewed on a mobile device (320px-767px)
- **When** I inspect the stepper header (`.steppers-header`)
- **Then** the step labels wrap or truncate gracefully without overflow
- **And** the stepper index (e.g., "2/3") remains visible
- **And** NO horizontal scrollbar appears
- **And** the stepper height adapts to content (NOT fixed 64px)

### AC2: Stepper Responsive on Tablet (768px-1023px)
- **Given** the segnalazione-02-dati page viewed on a tablet device
- **When** I inspect the stepper header
- **Then** step labels display fully without truncation
- **And** the layout matches the reference at tablet breakpoint
- **And** the sidebar navigation (navscroll) remains collapsed or adapts appropriately

### AC3: NO Hardcoded Italian in Blade Templates
- **Given** the segnalazione-02-dati.blade.php template
- **When** I scan for hardcoded strings
- **Then** ALL user-visible text uses `__('fixcity::segnalazione.*')` translation keys
- **And** ZERO hardcoded Italian strings exist (e.g., "Home", "Servizi", "Danneggiamento proprietà pubblica")
- **And** breadcrumb items, placeholders, labels, button text all use translation helpers

### AC4: Body Tag Remains Plain
- **Given** the layout file `Themes/Sixteen/resources/views/components/layouts/main.blade.php`
- **When** I inspect the `<body>` tag
- **Then** it is EXACTLY `<body>` — NO classes, NO attributes
- **And** ALL page-specific styling is handled via CSS scoped to `.tests-view-wrapper[data-slug="..."]`

### AC5: Build and Visual Verification
- **Given** all CSS changes applied
- **When** I run `npm run build && npm run copy` from `Themes/Sixteen/`
- **And** I view the page on mobile (375px) and tablet (768px) viewports
- **Then** the stepper is fully usable and visually matches the reference
- **And** NO layout breakage occurs in sidebar, cards, or navigation buttons

---

## Dev Technical Guidance

### Current Issues Identified

#### 1. Stepper CSS NOT Responsive
File: `Themes/Sixteen/resources/css/segnalazione-parity.css`

**Current code (WRONG — fixed height, no responsive):**
```css
.steppers-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 24px;
  height: 64px;          /* ❌ FIXED HEIGHT — breaks on mobile */
  background: #fff;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  margin-bottom: 2rem;
  gap: 1rem;
}

.steppers-header li {
  font-size: 1.125rem;
  white-space: nowrap;   /* ❌ NO WRAP — overflows on mobile */
  flex: 1 1 0;
}
```

**Required fix — Add mobile/tablet media queries:**
```css
/* Mobile first: stepper stacks vertically or wraps */
@media (max-width: 767px) {
  .steppers-header {
    height: auto;        /* ✅ Allow content to dictate height */
    flex-wrap: wrap;
    padding: 0 16px;
    gap: 0.5rem;
  }

  .steppers-header ul {
    flex-wrap: wrap;
  }

  .steppers-header li {
    font-size: 0.875rem; /* ✅ Smaller font on mobile */
    white-space: normal; /* ✅ Allow text wrap */
    padding: 0 0.5rem 0.5rem;
  }

  .steppers-index {
    font-size: 0.75rem;
    order: -1;           /* ✅ Show index at top on mobile */
    width: 100%;
    text-align: center;
  }
}

/* Tablet: partial restoration */
@media (min-width: 768px) and (max-width: 1023px) {
  .steppers-header {
    height: auto;
    padding: 0 20px;
  }

  .steppers-header li {
    font-size: 1rem;
    white-space: nowrap;
  }
}
```

[Source: `segnalazione-parity.css` lines 1013-1080]

#### 2. Hardcoded Italian Strings in Blade

File: `Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

**Lines with hardcoded Italian (MUST FIX):**

| Line | Hardcoded Italian | Translation Key to Use |
|------|------------------|----------------------|
| ~38 | `'Home'` | `fixcity::segnalazione.breadcrumb.home.label` |
| ~39 | `'Servizi'` | `fixcity::segnalazione.breadcrumb.services.label` |
| ~158 | `'Danneggiamento proprietà pubblica'` | `fixcity::segnalazione.inefficiency_types.property_damage` |
| ~174 | `'6yhakandsahm413d8.jpg'` | (remove or use placeholder) |
| ~176 | `'elimina immagina caricata'` | `fixcity::segnalazione.actions.remove_image.aria.label` |
| Various | Check ALL `<a>` text, `<span>` text | Use `__('fixcity::segnalazione.*')` |

**Fix pattern:**
```blade
{{-- WRONG --}}
<a href="{{ $homeUrl }}">Home</a>

{{-- CORRECT --}}
<a href="{{ $homeUrl }}">{{ __('fixcity::segnalazione.breadcrumb.home.label') }}</a>
```

#### 3. Body Tag Rule (Already Enforced — Verify)

File: `Themes/Sixteen/resources/views/components/layouts/main.blade.php`

```blade
{{-- ✅ CORRECT — Already plain --}}
<body>
    {{ $slot }}
    ...
</body>

{{-- ❌ NEVER DO THIS --}}
<body @class(['page-tests-' . (request()->route('slug') ?? '') => $isTestsRoute])>
```

### Existing Translation File

Check: `Modules/Fixcity/lang/en/segnalazione.php` and `Modules/Fixcity/lang/it/segnalazione.php`

If keys are missing, ADD them to BOTH language files.

### File Paths to Modify

1. **CSS (responsive stepper):**
   - `Themes/Sixteen/resources/css/segnalazione-parity.css`

2. **Blade (hardcoded Italian):**
   - `Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

3. **Translations (add missing keys):**
   - `Modules/Fixcity/lang/it/segnalazione.php`
   - `Modules/Fixcity/lang/en/segnalazione.php`

4. **Verify (body plain):**
   - `Themes/Sixteen/resources/views/components/layouts/main.blade.php` (already correct)

### Build Process

After CSS changes:
```bash
cd laravel/Themes/Sixteen
npm run build && npm run copy
```

---

## Tasks / Subtasks

### Task 1: Fix Stepper CSS Responsive (AC: 1, 2)
- [ ] Read `segnalazione-parity.css` lines 1010-1100 (stepper section)
- [ ] Add `@media (max-width: 767px)` rules for mobile stepper
- [ ] Add `@media (min-width: 768px) and (max-width: 1023px)` rules for tablet
- [ ] Ensure `.steppers-header` has `height: auto` on mobile/tablet
- [ ] Ensure `.steppers-header li` has `white-space: normal` on mobile
- [ ] Ensure `.steppers-index` is visible and properly positioned on mobile
- [ ] Run `npm run build && npm run copy` from `Themes/Sixteen/`
- [ ] Visually verify at 375px (mobile), 768px (tablet), 1024px (desktop)

### Task 2: Fix Hardcoded Italian in segnalazione-02-dati.blade.php (AC: 3)
- [ ] Read `segnalazione-02-dati.blade.php` fully
- [ ] Replace `'Home'` → `__('fixcity::segnalazione.breadcrumb.home.label')`
- [ ] Replace `'Servizi'` → `__('fixcity::segnalazione.breadcrumb.services.label')`
- [ ] Replace hardcoded `<option>` values → use translation keys
- [ ] Replace `'elimina immagina caricata'` → `__('fixcity::segnalazione.actions.remove_image.aria.label')`
- [ ] Scan ENTIRE file for ANY remaining hardcoded Italian
- [ ] Add missing translation keys to `lang/it/segnalazione.php`
- [ ] Add matching keys to `lang/en/segnalazione.php` with English translations

### Task 3: Verify Body Tag Plain (AC: 4)
- [ ] Read `Themes/Sixteen/resources/views/components/layouts/main.blade.php`
- [ ] Confirm `<body>` has NO `@class()` directive
- [ ] Confirm `<body>` has NO conditional attributes
- [ ] If violations found, remove them immediately

### Task 4: Test and Verify (AC: 5)
- [ ] Run `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- [ ] Open `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- [ ] Test at 375px viewport — stepper must be usable, no overflow
- [ ] Test at 768px viewport — stepper matches reference tablet view
- [ ] Test at 1024px+ viewport — desktop layout intact
- [ ] Verify NO hardcoded Italian visible in browser (all text from translations)
- [ ] Switch language to English — verify all text translates

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: CSS changes might affect other pages using `.steppers-header`
- **Mitigation**: Scope responsive rules specifically to `.tests-view-wrapper .steppers-header` or verify no other pages use same class
- **Verification**: Check other pages (segnalazione-01-privacy, segnalazione-03-riepilogo) after changes

### Rollback Plan
- Git commit before changes
- Revert CSS file if stepper breaks on desktop
- Keep original blade strings in git history for reference

### Safety Checks
- [ ] Desktop layout verified after mobile changes
- [ ] Other segnalazione pages tested (01-privacy, 03-riepilogo, 04-conferma)
- [ ] Build succeeds without errors
- [ ] No new hardcoded strings introduced

---

## Dev Notes

### Previous Story Insights
- Body tag plain rule already enforced in `main.blade.php` (see `html-parity-body-policy.md`)
- Stepper CSS exists but lacks responsive media queries
- Translation infrastructure exists (`fixcity::segnalazione.*` namespace)

### Translation Keys Needed (add if missing)

```php
// Modules/Fixcity/lang/it/segnalazione.php
return [
    'breadcrumb' => [
        'home' => ['label' => 'Home'],
        'services' => ['label' => 'Servizi'],
    ],
    'actions' => [
        'remove_image' => [
            'aria' => ['label' => 'elimina immagine caricata'],
        ],
    ],
    'inefficiency_types' => [
        'property_damage' => 'Danneggiamento proprietà pubblica',
        'maintenance' => 'Manutenzione stradale',
        'urban_decorum' => 'Decoro urbano',
    ],
];
```

```php
// Modules/Fixcity/lang/en/segnalazione.php
return [
    'breadcrumb' => [
        'home' => ['label' => 'Home'],
        'services' => ['label' => 'Services'],
    ],
    'actions' => [
        'remove_image' => [
            'aria' => ['label' => 'remove uploaded image'],
        ],
    ],
    'inefficiency_types' => [
        'property_damage' => 'Public property damage',
        'maintenance' => 'Road maintenance',
        'urban_decorum' => 'Urban decorum',
    ],
];
```

### Project Structure Notes

- Theme CSS: `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- Theme build: `laravel/Themes/Sixteen/` (run npm from here)
- Blade blocks: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/`
- Translations: `laravel/Modules/Fixcity/lang/{locale}/segnalazione.php`
- Layout: `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php`

### Technical Constraints

- **Mobile First**: Design for 320px+ first, then enhance for larger screens
- **Multilingual**: ALL text must use `__('namespace::key')` — NO hardcoded strings
- **Body Plain**: `<body>` tag MUST remain without classes or attributes
- **Build Required**: After CSS changes, MUST run `npm run build && npm run copy`

---

## Testing

### Visual Testing
1. Open Chrome DevTools → Device Mode
2. Test at 375px (iPhone SE) — stepper must not overflow
3. Test at 768px (iPad) — stepper should match reference
4. Test at 1024px+ (desktop) — layout unchanged
5. Switch language to EN — verify all text translates

### Translation Testing
```bash
cd laravel
php artisan lang:publish
# Verify both it/en files exist
```

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] Stepper responsive on mobile (375px), tablet (768px), desktop (1024px+)
- [ ] ZERO hardcoded Italian strings in blade template
- [ ] All translation keys added to both it/en files
- [ ] Body tag verified plain in layout
- [ ] `npm run build && npm run copy` succeeds
- [ ] Visual parity verified on all breakpoints
- [ ] Language switching works (IT ↔ EN)
