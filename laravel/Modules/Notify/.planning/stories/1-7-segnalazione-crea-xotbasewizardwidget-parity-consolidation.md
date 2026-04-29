# Story: segnalazione-crea XotBaseWizardWidget Parity Consolidation

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a citizen using `/it/tests/segnalazione-crea`,
I want the page to reach strong visual parity with the Design Comuni reference while preserving the Laraxot wizard architecture,
so that the frontoffice flow remains consistent, maintainable, and aligned with Xot/Filament standards.

---

## Architectural Decision

`CreateTicketWizardWidget` MUST extend `Modules\\Xot\\Filament\\Widgets\\XotBaseWizardWidget`.

### Why

- The page is a real Filament multi-step wizard, not a generic linear form.
- `XotBaseWizardWidget` centralizes the shared wizard policy:
  - guarded `?step=` support
  - wrapper-key normalization via `normalizeWizardFormState()`
  - a single Laraxot contract for wizard widgets across modules
- Replacing it with ad-hoc manual step state would duplicate navigation, validation, and submit-state plumbing already standardized by Xot.
- The correct direction is not "remove Wizard", but "keep Wizard inside the right Xot base class and fix parity around it".

Primary local references:

- `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`
- `laravel/Modules/Xot/docs/filament/widgets/xot-base-wizard-widget.md`
- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

Official reference:

- Filament schemas overview: `https://filamentphp.com/docs/5.x/schemas/overview/`

---

## Consolidation Scope

This story supersedes the overlapping direction of:

- [1-4-segnalazione-crea-header-parity-stepper-responsive.md](./1-4-segnalazione-crea-header-parity-stepper-responsive.md)
- [1-6-refactor-wizard-no-filament-schemas-no-hardcoded-blade.md](./1-6-refactor-wizard-no-filament-schemas-no-hardcoded-blade.md)

`1-5` remains separate because geolocation and `?step=` behavior are a distinct feature slice:

- [1-5-geolocation-step-navigation-segnalazione-crea.md](./1-5-geolocation-step-navigation-segnalazione-crea.md)

---

## Acceptance Criteria

### AC1: Xot wizard base remains the canonical architecture
- **Given** `CreateTicketWizardWidget`
- **When** the implementation is reviewed
- **Then** it extends `XotBaseWizardWidget`
- **And** wizard-specific behavior is not reimplemented manually in Blade/Livewire unless the Xot base contract itself is changed upstream
- **And** docs/rules no longer suggest removing Filament Wizard from this widget

### AC2: HTML parity rules remain intact
- **Given** `/it/tests/segnalazione-crea`
- **When** parity fixes are applied
- **Then** the page keeps plain `<body>`
- **And** page-level scoping starts from the canonical wrapper `.page-content[data-slug][data-side]`
- **And** no solution depends on `.tests-view-wrapper`
- **And** no body classes are introduced for parity

### AC3: Mobile stepper matches the reference behavior
- **Given** a mobile viewport around `375px`
- **When** the stepper is rendered
- **Then** the active step label is visible without horizontal overflow
- **And** the step index is visible on the right
- **And** the component wraps responsively like `segnalazione-01-privacy.html`

### AC4: Header parity issues are corrected
- **Given** the shared header on `/it/tests/segnalazione-crea`
- **When** I compare it with the reference page
- **Then** the hamburger button is vertically centered in the navbar row
- **And** the search area shows `Cerca` next to the icon on tablet and desktop, but not on narrow mobile
- **And** the slogan remains under the logo
- **And** the search area is aligned like the reference

### AC5: Language selector matches reference behavior and styling
- **Given** the language selector in the slim header
- **When** I interact with it
- **Then** the dropdown opens and closes correctly
- **And** only a single chevron-style icon is shown
- **And** the icon has no extra background
- **And** the control visually matches the reference as closely as possible via CSS/JS

### AC6: CSS/JS-first parity work around the wizard
- **Given** the widget architecture is fixed by XotBaseWizardWidget
- **When** parity work is implemented
- **Then** fixes happen primarily in CSS/JS and in wrapper-adjacent Blade only where required
- **And** no duplicate hardcoded wizard markup is introduced
- **And** no second source of step state is introduced next to Filament Wizard

### AC7: Screenshot-led verification across breakpoints
- **Given** local and reference pages
- **When** verification is run
- **Then** screenshots are collected at mobile, tablet, and desktop widths
- **And** the comparison covers stepper, hamburger, search area, language selector, and top-of-page spacing

### AC8: Token-efficient workflow is used
- **Given** this parity task requires repeated inspection and documentation
- **When** work is executed
- **Then** targeted reads, shared summaries, screenshot diffing, and indexed docs are used to reduce token waste

---

## Current State Snapshot

- `CreateTicketWizardWidget` already extends `XotBaseWizardWidget`
- Existing docs/rules still contain contradictory instructions that say both "use Wizard" and "remove Wizard"
- The active work is to remove those contradictions and implement parity without breaking the Xot wizard contract

---

## Research References

- Filament schemas overview: `https://filamentphp.com/docs/5.x/schemas/overview/`
- OpenAI Prompt Caching: `https://developers.openai.com/api/docs/guides/prompt-caching`
- Google Gemini token counting: `https://ai.google.dev/gemini-api/docs/tokens`
- Playwright visual comparisons: `https://playwright.dev/docs/test-snapshots`
