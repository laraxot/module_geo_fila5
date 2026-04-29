# Story: Refactor CreateTicketWizardWidget — NO hardcoded blade, NO Filament Schemas Wizard

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a citizen using the frontoffice segnalazione wizard at `/it/tests/segnalazione-crea`,
I want a fully functional multi-step form that visually matches the Design Comuni reference and works without Filament admin panel dependencies,
so that I can report a service disruption reliably on any device.

---

## Acceptance Criteria

### AC1: NO Filament Schemas Wizard on Frontoffice
- **Given** the CreateTicketWizardWidget runs on a public/frontoffice page
- **When** the page loads at `/it/tests/segnalazione-crea`
- **Then** NO `Filament\Schemas\Components\Wizard` is used
- **And** step navigation works via pure Livewire state (`$currentStep`)
- **And** NO Filament schema JS assets are required (`step`, `isFirstStep`, `filamentSchemaComponent`)
- **And** the widget extends `XotBaseWidget` with `InteractsWithForms` + `InteractsWithActions`

### AC2: Design Comuni HTML Structural Parity
- **Given** the page rendered at `/it/tests/segnalazione-crea`
- **When** I compare with `segnalazione-01-privacy.html` reference
- **Then** the stepper HTML structure matches EXACTLY:
  ```html
  <div class="steppers">
    <div class="steppers-header">
      <ul>
        <li class="active|confirmed|">Step label</li>
      </ul>
      <span class="steppers-index" aria-hidden="true">1/3</span>
    </div>
  </div>
  ```
- **And** step content sections use Design Comuni card patterns (`cmp-card`, `card has-bkg-grey`)
- **And** NO Filament-specific HTML classes leak into the output

### AC3: Step Navigation Functional
- **Given** I am on step 1 (Privacy)
- **When** I check the privacy checkbox and click "Avanti"
- **Then** step 2 (Dati) is displayed with all form fields
- **And** the stepper updates to show step 2 as "active"
- **And** step 1 shows as "confirmed" with checkmark icon
- **And** the URL query `?step=2` is updated (if allowed)

### AC4: Step 2 Form Fields Functional
- **Given** I am on step 2 (Dati)
- **When** I fill in address, issue type, title, details
- **And** I click "Avanti"
- **Then** validation runs and errors display correctly
- **And** if valid, step 3 (Riepilogo) displays with summary data

### AC5: Step 3 Summary + Submit
- **Given** I am on step 3 (Riepilogo)
- **When** I review the summary data
- **And** I click "Conferma e invia"
- **Then** the ticket is created in the database
- **And** I am redirected to `/it/tests/segnalazione-04-conferma`

### AC6: Geolocation "Usa la tua posizione" Works
- **Given** I am on step 2
- **When** I click "Usa la tua posizione"
- **And** I grant browser location permission
- **Then** the address field is filled with reverse-geocoded address
- **And** Nominatim API is used for reverse geocoding

### AC7: Responsive on Mobile/Tablet
- **Given** the page is viewed on mobile (375px)
- **When** I interact with the wizard
- **Then** all steps, fields, buttons are fully usable
- **And** the stepper wraps without overflow
- **And** the layout matches reference mobile behavior

---

## Dev Technical Guidance — CURRENT STATE ANALYSIS

### What We Have Now

**Widget PHP** (`CreateTicketWizardWidget.php`):
- Extends `XotBaseWidget` ✅
- Uses `Filament\Schemas\Components\Wizard` ❌ (forbidden on frontoffice)
- Uses `Filament\Forms\Components\*` for fields (TextInput, Select, Textarea, etc.)
- Has `getFormSchema()` returning `Wizard::make([Step::make('1'), Step::make('2'), Step::make('3')])`
- Has `submit()` method with validation and Ticket creation
- Has `getIssueTypeOptions()` for dynamic options
- Has `resolveInitialStepFromQuery()` for `?step=N` support

**Blade Template** (`ticket-create-wizard.blade.php`):
- Uses Design Comuni wrapper structure ✅
- Has hardcoded stepper HTML in blade (not from Wizard) ✅
- Has hardcoded form fields for each step ❌ (duplicated from PHP schema)
- Uses `{{ $this->form }}` to render Filament Wizard ❌
- Has contacts section at bottom ✅

### The Core Problem

**The Wizard is currently rendered TWICE:**
1. Via `{{ $this->form }}` which renders Filament's Wizard (with its own stepper) — this uses Filament admin JS that's NOT available on frontoffice
2. Via hardcoded HTML in blade template (which is static, non-interactive)

**Result:** The page shows the static HTML stepper (non-functional) and may or may not render the Filament Wizard (broken without JS assets).

### REQUIRED ARCHITECTURE

**Per project rule:**
> CRITICAL: Frontoffice Widget Architecture — NO Filament Schemas Wizard. Use pure Livewire state (`$currentStep`) with manual step navigation instead. The widget extends `BaseWidget` with `InteractsWithForms` + `InteractsWithActions`.

### Refactoring Plan

#### Step 1: Remove Filament Wizard from PHP

**Before:**
```php
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

public function getFormSchema(): array
{
    return ['ticket_create_wizard' => Wizard::make([...])];
}
```

**After:**
```php
// Remove Wizard entirely. Keep individual field definitions if needed for validation.
// Step management moves to pure Livewire state.
public int $currentStep = 1;
public int $totalSteps = 3;

// Keep form field state as public properties
public bool $privacyAccepted = false;
public string $address = '';
public string $issueType = '';
public string $title = '';
public string $details = '';
public ?string $email = null;
/** @var array<string> */
public array $images = [];
public string $userName = '';
public string $userFiscalCode = '';
public string $userPhone = '';
```

#### Step 2: Add Step Navigation Methods

```php
public function nextStep(): void
{
    // Validate current step before proceeding
    match ($this->currentStep) {
        1 => $this->validateStep1(),
        2 => $this->validateStep2(),
        default => null,
    };

    if ($this->currentStep < $this->totalSteps) {
        $this->currentStep++;
    }
}

public function previousStep(): void
{
    if ($this->currentStep > 1) {
        $this->currentStep--;
    }
}

private function validateStep1(): void
{
    if (!$this->privacyAccepted) {
        $this->addError('privacyAccepted', __('fixcity::segnalazione.privacy.required.label'));
    }
}

private function validateStep2(): void
{
    Validator::make([
        'address' => $this->address,
        'issueType' => $this->issueType,
        'title' => $this->title,
        'details' => $this->details,
    ], [
        'address' => ['required', 'string', 'max:255'],
        'issueType' => ['required', 'string'],
        'title' => ['required', 'string', 'max:255'],
        'details' => ['required', 'string'],
    ])->validate();
}
```

#### Step 3: Rewrite Blade Template

**Remove:** `{{ $this->form }}`, `x-filament-widgets::widget`, all hardcoded duplicated form fields

**Replace with:** Pure Livewire conditional rendering matching Design Comuni HTML:

```blade
<div class="ticket-wizard-root">
    {{-- Stepper (always matches reference) --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="steppers">
                    <div class="steppers-header">
                        <ul>
                            <li class="{{ $currentStep === 1 ? 'active' : '' }}">
                                {{ __('fixcity::segnalazione.steps.privacy.label') }}
                                @if($currentStep > 1)
                                    <svg class="icon steppers-success" aria-hidden="true"><use href="{{ $sprite }}#it-check"></use></svg>
                                    <span class="visually-hidden">{{ __('fixcity::segnalazione.steps.confirmed.label') }}</span>
                                @elseif($currentStep === 1)
                                    <span class="visually-hidden">{{ __('fixcity::segnalazione.steps.active.label') }}</span>
                                @endif
                            </li>
                            <li class="{{ $currentStep === 2 ? 'active' : '' }}">
                                {{ __('fixcity::segnalazione.steps.data.label') }}
                                @if($currentStep > 2)
                                    <svg class="icon steppers-success" aria-hidden="true"><use href="{{ $sprite }}#it-check"></use></svg>
                                @elseif($currentStep === 2)
                                    <span class="visually-hidden">{{ __('fixcity::segnalazione.steps.active.label') }}</span>
                                @endif
                            </li>
                            <li class="{{ $currentStep === 3 ? 'active' : '' }}">
                                {{ __('fixcity::segnalazione.steps.summary.label') }}
                                @if($currentStep > 3)
                                    <svg class="icon steppers-success" aria-hidden="true"><use href="{{ $sprite }}#it-check"></use></svg>
                                @elseif($currentStep === 3)
                                    <span class="visually-hidden">{{ __('fixcity::segnalazione.steps.active.label') }}</span>
                                @endif
                            </li>
                        </ul>
                        <span class="steppers-index" aria-hidden="true">{{ $currentStep }}/{{ $totalSteps }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Step Content --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 pb-40 pb-lg-80">
                <form wire:submit="submit">
                    @if($currentStep === 1)
                        {{-- Step 1: Privacy --}}
                        <p class="text-paragraph mb-lg-4">...</p>
                        <div class="form-check mt-4 mb-3">
                            <div class="checkbox-body d-flex align-items-center">
                                <input type="checkbox" id="privacy" wire:model="privacyAccepted">
                                <label class="title-small-semi-bold pt-1" for="privacy">
                                    {{ __('fixcity::segnalazione.privacy.checkbox.label') }}
                                </label>
                            </div>
                            @error('privacyAccepted')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" wire:click="nextStep" class="btn btn-primary mobile-full">
                            <span>{{ __('fixcity::segnalazione.actions.next.label') }}</span>
                        </button>

                    @elseif($currentStep === 2)
                        {{-- Step 2: Dati --}}
                        <div class="cmp-card mb-40">
                            <div class="card has-bkg-grey shadow-sm p-big p-lg-4">
                                <div class="card-header border-0 p-0 mb-lg-20 m-0">
                                    <h2 class="title-xxlarge mb-1">{{ __('fixcity::segnalazione.fields.address.label') }}</h2>
                                </div>
                                <div class="card-body p-0">
                                    <div class="form-group bg-white p-3 mb-0 mt-3">
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                               wire:model="address"
                                               placeholder="{{ __('fixcity::segnalazione.create.address.placeholder') }}"
                                               required>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        {{-- Geolocation button here --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ... other fields ... --}}
                        <button type="button" wire:click="previousStep" class="btn btn-sm">
                            <span>{{ __('fixcity::segnalazione.actions.back.label') }}</span>
                        </button>
                        <button type="button" wire:click="nextStep" class="btn btn-primary">
                            <span>{{ __('fixcity::segnalazione.actions.next.label') }}</span>
                        </button>

                    @elseif($currentStep === 3)
                        {{-- Step 3: Summary + Submit --}}
                        <div class="callout callout-highlight ps-3 warning">
                            <p>{{ __('fixcity::segnalazione.warning.message.label') }}</p>
                        </div>
                        <h2 class="title-xxlarge mb-4 mt-40">{{ __('fixcity::segnalazione.heading.report.label') }}</h2>
                        @if($address)
                            <div class="single-line-info border-light">
                                <div class="text-paragraph-small">{{ __('fixcity::segnalazione.fields.address.label') }}</div>
                                <div class="border-light"><p class="data-text">{{ $address }}</p></div>
                            </div>
                        @endif
                        {{-- ... other summary fields ... --}}
                        <button type="button" wire:click="previousStep" class="btn btn-sm">
                            <span>{{ __('fixcity::segnalazione.actions.back.label') }}</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span>{{ __('fixcity::segnalazione.actions.submit.label') }}</span>
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- Contacts section (unchanged) --}}
    <div class="bg-grey-card shadow-contacts">
        ...
    </div>
</div>
```

### Key Architecture Decisions

1. **Remove Wizard::make()** — pure Livewire `$currentStep` state replaces it
2. **Keep `InteractsWithForms`** — for `wire:model` validation support
3. **Keep `WithFileUploads`** — for image upload handling
4. **Blade renders step content conditionally** — `@if($currentStep === N)`
5. **Stepper HTML matches reference EXACTLY** — no Filament classes
6. **Submit method unchanged** — `submit()` still creates Ticket and redirects
7. **Geolocation added to step 2** — Alpine.js + Nominatim (from story 1-5)
8. **`?step=N` URL support** — via `mount()` reading `request()->query('step')`

### File Paths to Modify

1. **Widget PHP (remove Wizard, add state):**
   - `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

2. **Blade template (remove hardcoded duplication, use conditional rendering):**
   - `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

3. **Translation keys (add any missing validation messages):**
   - `Modules/Fixcity/lang/it/segnalazione.php`
   - `Modules/Fixcity/lang/en/segnalazione.php`

### Translation Keys Needed

```php
// it/segnalazione.php
'privacy' => [
    'required' => ['label' => 'Devi accettare l\'informativa sulla privacy per continuare'],
],
'actions' => [
    'submit' => ['label' => 'Conferma e invia'],
],
```

### Risk Assessment

### Implementation Risks
- **Primary Risk**: Losing form validation that Wizard provided automatically
- **Mitigation**: Implement per-step validation in `nextStep()` method using `Validator::make()`
- **Verification**: Test each step with empty/invalid data — errors must display

### CSS Risks
- **Risk**: Removing Filament Wizard removes its CSS, but hardcoded blade HTML already has correct Tailwind classes
- **Mitigation**: No new CSS needed — existing `style-apply.css` already has stepper styles
- **Verification**: Visual parity at 375px, 768px, 1024px

### Rollback Plan
- Git commit before changes
- If wizard breaks, revert to previous commit (wizard was already partially broken)

---

## Tasks / Subtasks

### Task 1: Refactor Widget PHP (Remove Wizard) (AC: 1)
- [ ] Read `CreateTicketWizardWidget.php` fully
- [ ] Remove `use Filament\Schemas\Components\Wizard;` and `use Filament\Schemas\Components\Wizard\Step;`
- [ ] Remove `getFormSchema()` method entirely
- [ ] Add public properties: `$currentStep = 1`, `$totalSteps = 3`
- [ ] Add public properties for each form field: `$privacyAccepted`, `$address`, `$issueType`, `$title`, `$details`, `$email`, `$images`, `$userName`, `$userFiscalCode`, `$userPhone`
- [ ] Add `nextStep()` method with per-step validation
- [ ] Add `previousStep()` method
- [ ] Update `mount()` to initialize `$currentStep` from query parameter
- [ ] Keep `submit()` method unchanged
- [ ] Keep `getIssueTypeOptions()` method unchanged
- [ ] Remove `normalizeDehydratedState()` (no longer needed without Wizard wrapper)

### Task 2: Rewrite Blade Template (AC: 2, 3, 4, 5, 7)
- [ ] Read current `ticket-create-wizard.blade.php` fully
- [ ] Remove `{{ $this->form }}` and `x-filament-widgets::widget`
- [ ] Keep stepper HTML structure (already matches reference)
- [ ] Replace hardcoded step content with `@if($currentStep === N)` conditionals
- [ ] Step 1: Privacy checkbox with `wire:model="privacyAccepted"`, error display, next button
- [ ] Step 2: All form fields with `wire:model`, validation errors, back/next buttons
- [ ] Step 3: Summary display with back button + submit button
- [ ] Keep contacts section unchanged
- [ ] Ensure single root element (Livewire requirement)
- [ ] Verify NO hardcoded Italian strings — all use `__('fixcity::*')`

### Task 3: Add Geolocation to Step 2 (AC: 6)
- [ ] Add Alpine.js `x-data` with `getLocation()` to address card
- [ ] Wire up "Usa la tua posizione" button with `@click.prevent="getLocation()"`
- [ ] Use Nominatim reverse geocoding
- [ ] Update Livewire `address` via `@this.set('address', ...)`
- [ ] Add error display for geolocation failures
- [ ] Add geolocation translation keys (from story 1-5)

### Task 4: Add Missing Translation Keys (AC: 1-7)
- [ ] Add `privacy.required.label` to it/en segnalazione.php
- [ ] Add `actions.submit.label` if missing
- [ ] Add any geolocation keys from story 1-5 if not already present
- [ ] Verify ALL keys exist in BOTH it and en files

### Task 5: Test and Verify (All AC)
- [ ] Test step 1 → checkbox → next → step 2 displays
- [ ] Test step 2 → fill fields → validation errors on empty fields
- [ ] Test step 2 → fill valid data → next → step 3 displays with summary
- [ ] Test step 3 → submit → ticket created → redirect to conferma
- [ ] Test `?step=2` URL → step 2 displays directly
- [ ] Test `?step=5` → defaults to step 1
- [ ] Test geolocation → address field fills
- [ ] Test at 375px — all usable, no overflow
- [ ] Test at 768px — layout matches reference
- [ ] Test at 1024px — full layout matches reference

---

## Dev Notes

### Reference Pages
- Header + stepper reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Fetched raw HTML via curl on 2026-04-12

### Project Rules (MANDATORY)
- **CRITICAL: NO Filament Schemas Wizard on frontoffice** — pure Livewire `$currentStep` only
- **CRITICAL: HTML Structural Parity** — exact match with reference
- **CRITICAL: NO hardcoded Italian** — all text via `__('fixcity::*')`
- **CRITICAL: Single root element** — Livewire requirement

### Existing Methods to Preserve
- `submit()` — creates Ticket, dispatches event, redirects
- `getIssueTypeOptions()` — returns translation-based options
- `resolveTicketTypeEnumFromKey()` — maps option key to enum
- `WithFileUploads` trait — for image uploads

### Build Process
No build needed for PHP/blade changes. Only CSS build if geolocation Alpine.js spinner is added.

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] NO `Filament\Schemas\Components\Wizard` in widget PHP
- [ ] NO `{{ $this->form }}` in blade template
- [ ] Stepper HTML matches reference EXACTLY
- [ ] Step navigation functional (next/previous)
- [ ] Per-step validation with error display
- [ ] Ticket creation works on submit
- [ ] `?step=N` URL navigation works
- [ ] Geolocation "Usa la tua posizione" works
- [ ] ZERO hardcoded Italian strings
- [ ] Responsive on mobile/tablet/desktop
- [ ] Visual parity verified on all breakpoints
