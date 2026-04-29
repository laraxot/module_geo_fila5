# Story: Segnalazione-Crea Visual Parity — Filament Wizard + Design Comuni Reference

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a citizen using `/it/tests/segnalazione-crea`,
I want the segnalazione wizard to visually match the Design Comuni reference `segnalazione-01-privacy.html`,
so that I experience a consistent, professional interface when reporting service disruptions.

---

## Acceptance Criteria

### AC1: Breadcrumbs Match Reference
- **Given** the page at `/it/tests/segnalazione-crea`
- **When** I view the top of the page
- **Then** breadcrumbs appear matching reference structure:
  ```html
  <div class="cmp-breadcrumbs" role="navigation">
    <nav class="breadcrumb-container" aria-label="breadcrumb">
      <ol class="breadcrumb p-0" data-element="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a><span class="separator">/</span></li>
        <li class="breadcrumb-item"><a href="/it/tests/servizi">Servizi</a><span class="separator">/</span></li>
        <li class="breadcrumb-item active" aria-current="page">Segnalazione disservizio</li>
      </ol>
    </nav>
  </div>
  ```

### AC2: Page Title Matches Reference
- **Given** the page rendered
- **When** I view the title
- **Then** it uses `<h1 class="title-xxxlarge mb-4">Segnalazione disservizio</h1>`
- **And** the text matches the translation key `fixcity::segnalazione.page.title.label`

### AC3: Filament Wizard Stepper Visually Matches Reference
- **Given** the Filament Wizard renders its stepper
- **When** I compare with reference stepper
- **Then** the overall layout is equivalent (horizontal on desktop, wrapped on mobile)
- **And** step labels use same font size and weight
- **And** the step index (e.g. "1/3") appears in same position
- **And** active/confirmed step styling is similar
- **And** CSS overrides in `segnalazione-parity.css` make Filament's stepper look like Design Comuni's

### AC4: Step 1 (Privacy) Visually Matches Reference
- **Given** I am on step 1
- **When** I compare with reference
- **Then** the privacy text uses same paragraph styling (`text-paragraph mb-lg-4`)
- **And** the privacy link uses same link styling (`t-primary`)
- **And** the checkbox uses Bootstrap Italia pattern (`form-check`, `checkbox-body d-flex`)
- **And** the "Avanti" button uses `btn btn-primary mobile-full` class

### AC5: Step 2 (Dati) Form Fields Readable and Functional
- **Given** I am on step 2
- **When** I view the form fields
- **Then** labels are visible and legible
- **And** input fields are styled consistently
- **And** the select dropdown works (non-native)
- **And** file upload works
- **And** responsive on mobile (fields stack, buttons full-width)

### AC6: Step 3 (Summary) Matches Reference Pattern
- **Given** I am on step 3
- **When** I compare with reference
- **Then** summary data is displayed in a readable format
- **And** the warning notice uses `callout callout-highlight` pattern
- **And** the submit button uses `btn btn-primary mobile-full`

### AC7: Contacts Section Matches Reference EXACTLY
- **Given** the contacts section at the bottom
- **When** I compare with reference
- **Then** it matches HTML structure exactly:
  ```html
  <div class="bg-grey-card shadow-contacts">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-6 offset-lg-3 p-contacts">
          <div class="cmp-contacts">
            <div class="card w-100">
              <div class="card-body">
                <h2 class="title-medium-2-semi-bold">Contatta il comune</h2>
                <ul class="contact-list p-0">
                  <li>...</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  ```

### AC8: Responsive on All Breakpoints
- **Given** the page viewed at 375px, 768px, 1024px
- **When** I check layout
- **Then** all elements are usable and readable
- **And** buttons are full-width on mobile (`mobile-full` class)
- **And** no horizontal overflow

---

## Dev Technical Guidance — GAP ANALYSIS

### Reference Structure (segnalazione-01-privacy.html)
```
<main>
  <div class="container" id="main-container">
    <div class="cmp-breadcrumbs">...</div>
  </div>
  <div class="container">
    <h1 class="title-xxxlarge mb-4">Segnalazione disservizio</h1>
    <div class="steppers">
      <div class="steppers-header">
        <ul>
          <li class="active">Autorizzazioni e condizioni</li>
          <li class="">Dati di segnalazione</li>
          <li class="">Riepilogo</li>
        </ul>
        <span class="steppers-index">1/3</span>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="col-12 col-lg-8 pb-40 pb-lg-80">
      <p class="text-paragraph">Privacy text...</p>
      <div class="form-check">...checkbox...</div>
      <button class="btn btn-primary mobile-full">Avanti</button>
    </div>
  </div>
  <div class="bg-grey-card shadow-contacts">...contacts...</div>
</main>
```

### Current Structure (ticket-create-wizard.blade.php)
```
<div class="ticket-wizard-root">
  <div class="container" id="main-container">
    <div class="cmp-heading">...title...<h1>...</div>  ← ❌ Missing breadcrumbs, uses cmp-heading not reference pattern
  </div>
  <div class="container">
    <x-filament-widgets::widget>
      <form wire:submit="submit">{{ $this->form }}</form>  ← Filament renders Wizard + Stepper
    </x-filament-widgets::widget>
  </div>
  <div class="bg-grey-card shadow-contacts">...contacts...</div>  ← ✅ Matches reference
</div>
```

### Gap #1: Missing Breadcrumbs

**Fix:** Add breadcrumbs before the title in the blade template:
```blade
<div class="container" id="main-container">
    {{-- ADD THIS --}}
    <div class="cmp-breadcrumbs" role="navigation">
        <nav class="breadcrumb-container" aria-label="breadcrumb">
            <ol class="breadcrumb p-0" data-element="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{ app()->getLocale() }}/tests/homepage">Home</a><span class="separator">/</span></li>
                <li class="breadcrumb-item"><a href="/{{ app()->getLocale() }}/tests/servizi">Servizi</a><span class="separator">/</span></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </nav>
    </div>
    {{-- END ADD --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <h1 class="title-xxxlarge mb-4">{{ $pageTitle }}</h1>
        </div>
    </div>
</div>
```

### Gap #2: Filament Wizard Stepper vs Design Comuni Stepper

Filament's Wizard renders its own stepper UI with different HTML structure:
```html
<!-- Filament's rendered stepper (approximate) -->
<div class="fi-wi-wizard">
  <ol class="fi-fo-wizard-steps">
    <li class="fi-fo-wizard-step">...</li>
  </ol>
</div>
```

Reference stepper:
```html
<div class="steppers">
  <div class="steppers-header">
    <ul>
      <li class="active">...</li>
    </ul>
    <span class="steppers-index">1/3</span>
  </div>
</div>
```

**CSS Override Strategy:**
Add CSS overrides to make Filament's stepper look like the reference. Target Filament's stepper classes and apply Design Comuni styling:

```css
/* segnalaione-parity.css */
.fi-fo-wizard-steps {
  @apply flex flex-wrap list-none p-0 m-0;
}

.fi-fo-wizard-step {
  @apply flex items-center gap-2 font-semibold text-gray-700;
  font-size: 0.875rem;
  padding: 0 0.5rem 0.5rem;
  border-bottom: 2px solid #d9e1e8;
}

.fi-fo-wizard-step.fi-active {
  color: #06c;
}

.fi-fo-wizard-step.fi-completed {
  color: #06c;
}
```

### Gap #3: Form Fields Styling

Filament form fields use different classes than Bootstrap Italia. We need CSS overrides to make them look similar:

```css
/* Make Filament inputs look like Bootstrap Italia inputs */
.fi-fo-field-wrp {
  /* Apply Bootstrap Italia-like styling */
}

.fi-fo-text-input input {
  @apply form-control; /* Bootstrap Italia class via style-apply.css */
}
```

### Gap #4: Submit Button

The submit button already uses `btn btn-primary mobile-full` — verify this class is applied correctly.

### File Paths to Modify

| File | Purpose |
|------|---------|
| `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` | Add breadcrumbs, fix title structure |
| `Themes/Sixteen/resources/css/segnalazione-parity.css` | CSS overrides for Filament Wizard stepper + form fields |
| `Themes/Sixteen/resources/css/style-apply.css` | General Design Comuni pattern classes |

### Current Widget PHP (ALREADY CORRECT)

The `CreateTicketWizardWidget` already:
- ✅ Extends `XotBaseWidget`
- ✅ Uses `Filament\Schemas\Components\Wizard`
- ✅ Configures `nextAction()`, `previousAction()`, `submitAction()`
- ✅ Has `makeStepPrivacy()`, `makeStepData()`, `makeStepSummary()`
- ✅ Supports `?step=N` URL navigation

**No PHP changes needed** — this is purely a CSS/blade template task.

---

## Tasks / Subtasks

### Task 1: Add Breadcrumbs to Blade (AC: 1)
- [ ] Read `ticket-create-wizard.blade.php`
- [ ] Add breadcrumbs section before title, matching reference HTML structure EXACTLY
- [ ] Use correct URLs for Home and Servizi links
- [ ] Use `{{ $pageTitle }}` for current page in breadcrumb

### Task 2: Fix Title Structure (AC: 2)
- [ ] Change `<div class="cmp-heading">` to match reference structure
- [ ] Title should use `mb-4` spacing like reference
- [ ] Remove unnecessary wrapper divs

### Task 3: Add CSS Overrides for Filament Wizard Stepper (AC: 3)
- [ ] Inspect rendered Filament Wizard stepper HTML in browser
- [ ] Identify Filament's stepper classes (`.fi-fo-wizard-steps`, `.fi-fo-wizard-step`, etc.)
- [ ] Add CSS overrides in `segnalazione-parity.css` to match Design Comuni stepper
- [ ] Target: font size, font weight, colors, borders, spacing
- [ ] Active step: blue color (#06c)
- **Verified classes**: `fi-fo-wizard`, `fi-fo-wizard-header`, `fi-fo-wizard-step`, `fi-fo-wizard-step-icon`, `fi-fo-wizard-step-label`
- **Target selectors**:
  ```css
  .fi-fo-wizard-header { /* Stepper header */ }
  .fi-fo-wizard-step-label { /* Step label text */ }
  .fi-fo-wizard-step.fi-active .fi-fo-wizard-step-label { /* Active step */ }
  .fi-fo-wizard-step.fi-completed .fi-fo-wizard-step-label { /* Completed step */ }
  ```

### Task 4: Add CSS Overrides for Filament Form Fields (AC: 5)
- [ ] Inspect rendered Filament form fields in browser
- [ ] Identify Filament's input/select/textarea classes
- [ ] Add CSS overrides to make them look like Bootstrap Italia fields
- [ ] Ensure labels are visible and properly styled
- [ ] Ensure validation errors display correctly
- **Key Filament classes to override**:
  ```css
  .fi-fo-field-wrp { /* Field wrapper */ }
  .fi-fo-text-input input { /* Text inputs */ }
  .fi-fo-select { /* Select dropdowns */ }
  .fi-fo-textarea textarea { /* Textareas */ }
  .fi-fo-file-upload { /* File upload */ }
  .fi-fo-checkbox { /* Checkboxes */ }
  ```

### Task 5: Verify Submit Button Styling (AC: 4, 6)
- [ ] Check that submit button uses `btn btn-primary mobile-full`
- [ ] Verify it's full-width on mobile
- [ ] Verify it matches reference button styling

### Task 6: Verify Contacts Section (AC: 7)
- [ ] Compare contacts section HTML with reference
- [ ] Ensure structure matches EXACTLY
- [ ] Already correct in current implementation — just verify

### Task 7: Responsive Testing (AC: 8)
- [ ] Test at 375px — all usable, no overflow
- [ ] Test at 768px — tablet layout works
- [ ] Test at 1024px — desktop layout matches reference
- [ ] Screenshot comparisons for documentation

### Task 8: Build and Deploy CSS
- [ ] Run `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- [ ] Verify CSS changes are visible in browser

---

## Dev Notes

### Reference Pages
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Fetched raw HTML via curl on 2026-04-12

### Filament Wizard Classes
Based on Filament 5.x source, the wizard renders with these classes:
- `.fi-fo-wizard` — Wizard container
- `.fi-fo-wizard-header` — Stepper header (step labels)
- `.fi-fo-wizard-step` — Individual step
- `.fi-fo-wizard-step-label` — Step label text
- `.fi-fo-wizard-step-icon` — Step icon
- `.fi-fo-wizard-step-content` — Step content area
- `.fi-active` — Active step modifier
- `.fi-completed` — Completed step modifier

### Trade-off Acknowledgment

**Inner form fields will NOT match reference HTML exactly.** Filament's Wizard renders its own form field structure. We can make them LOOK similar via CSS, but the HTML structure will differ. This is an accepted trade-off because:
1. The wizard functionality requires Filament's JS runtime
2. The outer wrapper (breadcrumbs, title, contacts) matches reference exactly
3. The overall UX is consistent even if individual form fields differ

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] Breadcrumbs added and match reference structure
- [ ] Title structure matches reference
- [ ] Filament Wizard stepper visually matches reference (via CSS overrides)
- [ ] Form fields readable and styled consistently
- [ ] Submit button styled correctly
- [ ] Contacts section matches reference exactly
- [ ] Responsive on mobile/tablet/desktop
- [ ] `npm run build && npm run copy` succeeds
- [ ] Screenshot comparisons saved in docs
