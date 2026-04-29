# Story: CreateTicketWizardWidget — Filament Wizard + XotBaseWidget + HTML Parity

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a citizen using the frontoffice segnalazione wizard at `/it/tests/segnalazione-crea`,
I want a fully functional Filament Wizard rendered inside an XotBaseWidget that visually matches the Design Comuni reference,
so that I can report a service disruption with a professional, responsive multi-step experience.

---

## Acceptance Criteria

### AC1: Widget Extends XotBaseWidget
- **Given** the CreateTicketWizardWidget PHP class
- **When** I inspect it
- **Then** it extends `Modules\Xot\Filament\Widgets\XotBaseWidget`
- **And** it does NOT redeclare `InteractsWithForms` or `InteractsWithActions` (already in XotBaseWidget)
- **And** it implements `getFormSchema()` returning `Wizard::make([Step1, Step2, Step3])`
- **And** it uses `@phpstan-ignore` only where absolutely necessary

### AC2: Wizard Uses Filament 5.x Schemas Wizard
- **Given** the `getFormSchema()` method
- **When** I inspect it
- **Then** it uses `Filament\Schemas\Components\Wizard` (NOT `Filament\Forms\Components\Wizard`)
- **And** each step uses `Filament\Schemas\Components\Wizard\Step`
- **And** steps are defined via `makeStepPrivacy()`, `makeStepData()`, `makeStepSummary()` methods
- **And** Wizard is configured with `startOnStep()`, `nextAction()`, `previousAction()`, `submitAction()`

### AC3: Blade Template Renders Wizard with Design Comuni Wrapper
- **Given** the blade template `ticket-create-wizard.blade.php`
- **When** I inspect it
- **Then** the outer wrapper matches Design Comuni structure (container, row, col, cmp-heading)
- **And** the wizard renders via `{{ $this->form }}` inside `<x-filament-widgets::widget>`
- **And** a `<form wire:submit="submit">` wraps the wizard
- **And** `<x-filament-actions::modals />` is included
- **And** the contacts section at bottom matches reference HTML structure

### AC4: HTML Structural Parity (Where Possible)
- **Given** the rendered page at `/it/tests/segnalazione-crea`
- **When** I compare with `segnalazione-01-privacy.html` reference
- **Then** the outer wrapper structure matches EXACTLY:
  ```html
  <div class="container" id="main-container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="cmp-heading pb-3 pb-lg-4">
          <h1 class="title-xxxlarge">...</h1>
        </div>
      </div>
    </div>
  </div>
  ```
- **And** the contacts section matches reference structure EXACTLY
- **And** the inner wizard form uses Filament's markup (unavoidable — this is the trade-off)

### AC5: Visual Parity (Where Possible)
- **Given** the rendered page
- **When** I compare visually with reference
- **Then** the outer wrapper looks identical to reference
- **And** the wizard form fields are styled to match Design Comuni patterns via Filament's theming
- **And** the contacts section looks identical to reference
- **And** responsive behavior works on mobile (375px), tablet (768px), desktop (1024px)

### AC6: Wizard Step Navigation Functional
- **Given** I am on step 1 (Privacy)
- **When** I check the privacy checkbox and click "Avanti"
- **Then** step 2 (Dati) displays with all form fields
- **And** the wizard stepper updates automatically
- **And** validation runs per-step
- **And** step 3 (Summary) displays review data with submit button

### AC7: Submission Works
- **Given** I am on step 3
- **When** I click "Conferma e invia"
- **Then** the `submit()` method creates a Ticket
- **And** dispatches `TicketCreatedEvent`
- **And** redirects to `/it/tests/segnalazione-04-conferma`

### AC8: URL `?step=N` Navigation
- **Given** I visit `/it/tests/segnalazione-crea?step=2`
- **When** the page loads
- **Then** the wizard starts on step 2 (if allowed by config)
- **And** the URL query `?step=2` is persisted in the wizard

---

## Dev Technical Guidance — PHILOSOPHY & ARCHITECTURE

### Why XotBaseWidget?

**The "Zen" of XotBaseWidget:**

1. **Single Point of Extension**: ALL Filament widgets in Laraxot extend XotBaseWidget. This is the architectural "religion" — one base class rules them all.

2. **Pre-Wired Traits**: XotBaseWidget already provides:
   - `InteractsWithForms` — form handling, validation, state management
   - `InteractsWithActions` — action routing, button handling
   - `TransTrait` — translation support
   - **NEVER redeclare these traits** — it's the #1 anti-pattern

3. **Abstract Contract**: `getFormSchema(): array` is the ONLY required method. XotBaseWidget handles the rest:
   - `form(Schema $schema)` — wraps your schema with statePath, model binding
   - `getFormFill()` — populates form from model
   - `resolveView()` — auto-discovers the blade view for your widget class
   - `getWizardSubmitAction()` — provides the submit button action

4. **Anti-Pattern to Avoid**:
   ```php
   // ❌ WRONG — redeclaring traits already in XotBaseWidget
   class MyWidget extends XotBaseWidget {
       use InteractsWithForms;     // Already in XotBaseWidget!
       use InteractsWithActions;   // Already in XotBaseWidget!
   }

   // ✅ CORRECT — just extend, traits are inherited
   class MyWidget extends XotBaseWidget {
       public function getFormSchema(): array { ... }
   }
   ```

### Wizard Architecture

**Current Implementation (ALREADY CORRECT in PHP):**

```php
class CreateTicketWizardWidget extends XotBaseWidget
{
    protected string $view = 'fixcity::filament.widgets.ticket-create-wizard';

    public function getFormSchema(): array
    {
        $wizard = Wizard::make([
            $this->makeStepPrivacy(),
            $this->makeStepData(),
            $this->makeStepSummary(),
        ])
            ->startOnStep(fn (): int => $this->wizardStartStep)
            ->nextAction(fn (Action $a) => $a->label(__('fixcity::segnalazione.actions.next.label')))
            ->previousAction(fn (Action $a) => $a->label(__('fixcity::segnalazione.actions.back.label')))
            ->submitAction(new HtmlString('...submit button...'))
            ->columnSpanFull();

        if ($this->queryStepOverrideAllowed()) {
            $wizard->persistStepInQueryString('step');
        }

        return ['ticket_create_wizard' => $wizard];
    }
}
```

### Blade Template Structure

The blade template must:
1. **Wrap** the wizard in Design Comuni outer structure (container, heading, contacts)
2. **Render** the wizard via `{{ $this->form }}` inside `<x-filament-widgets::widget>`
3. **NOT** duplicate form field HTML — let Filament Wizard render them
4. **Match** reference HTML for the parts OUTSIDE the wizard (heading, contacts)

```blade
<div class="ticket-wizard-root">
    {{-- Outer wrapper matches Design Comuni --}}
    <div class="container" id="main-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="cmp-heading pb-3 pb-lg-4">
                    <h1 class="title-xxxlarge">{{ $pageTitle }}</h1>
                </div>
            </div>
        </div>
    </div>

    {{-- Wizard form — Filament renders the Wizard UI --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 pb-40 pb-lg-80">
                <x-filament-widgets::widget>
                    <form wire:submit="submit">
                        {{ $this->form }}
                    </form>
                    <x-filament-actions::modals />
                </x-filament-widgets::widget>
            </div>
        </div>
    </div>

    {{-- Contacts section matches reference EXACTLY --}}
    <div class="bg-grey-card shadow-contacts">
        <div class="container">
            ...
        </div>
    </div>
</div>
```

### Frontoffice Asset Loading

For the Filament Wizard to work on frontoffice pages, the theme MUST load:
- `@filamentStyles` — Filament form/wizard CSS
- `@filamentScripts` — Filament form/wizard JS (includes Alpine.js plugins for Wizard)

Check if these are already loaded in the Sixteen theme's `main.blade.php` or `app.blade.php` layout. If not, they MUST be added.

### Trade-off Acknowledgment

**HTML Parity Limitation**: The wizard form fields (TextInput, Select, etc.) render with Filament's internal HTML structure, NOT Bootstrap Italia markup. We can match the OUTER wrapper perfectly, but the INNER form fields will use Filament's markup. This is an acceptable trade-off because:
1. The wizard functionality requires Filament's JS runtime
2. The outer wrapper provides Design Comuni visual context
3. The contacts section matches reference exactly
4. The overall UX is consistent even if individual form fields differ

### File Paths

| File | Purpose |
|------|---------|
| `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Widget PHP — already extends XotBaseWidget, already uses Wizard |
| `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` | Blade template — wrap wizard in Design Comuni structure |
| `Themes/Sixteen/resources/views/components/layouts/main.blade.php` | Layout — must include @filamentStyles/@filamentScripts |
| `Modules/Fixcity/lang/{it,en}/segnalazione.php` | Translations for wizard labels |

---

## Tasks / Subtasks

### Task 1: Verify Widget PHP is Correct (AC: 1, 2)
- [ ] Read `CreateTicketWizardWidget.php` fully
- [ ] Confirm it extends `XotBaseWidget` (NOT direct Filament Widget)
- [ ] Confirm it does NOT redeclare `InteractsWithForms` or `InteractsWithActions`
- [ ] Confirm `getFormSchema()` uses `Wizard::make()` from `Filament\Schemas\Components`
- [ ] Confirm steps use `Step::make()` from `Filament\Schemas\Components\Wizard`
- [ ] Verify `startOnStep()`, `nextAction()`, `previousAction()`, `submitAction()` configured
- [ ] Verify `persistStepInQueryString('step')` when allowed

### Task 2: Verify/Improve Blade Template (AC: 3, 4, 5)
- [ ] Read `ticket-create-wizard.blade.php` fully
- [ ] Verify outer wrapper matches Design Comuni reference structure
- [ ] Verify `{{ $this->form }}` is inside `<x-filament-widgets::widget>` and `<form wire:submit="submit">`
- [ ] Verify `<x-filament-actions::modals />` is present
- [ ] Verify contacts section matches reference HTML structure EXACTLY
- [ ] Verify NO hardcoded Italian strings
- [ ] Verify single root element (Livewire requirement)

### Task 3: Verify Frontoffice Assets Loaded (AC: 6)
- [ ] Check `Themes/Sixteen/resources/views/components/layouts/main.blade.php`
- [ ] Verify `@filamentStyles` is in `<head>` for test routes
- [ ] Verify `@filamentScripts` is before `</body>` for test routes
- [ ] If missing, add them conditionally for `/tests/*` routes
- [ ] Test: wizard step navigation works (next/previous buttons)

### Task 4: Test Wizard Functionality (AC: 6, 7, 8)
- [ ] Test step 1 → checkbox → next → step 2
- [ ] Test step 2 → fill fields → validation → step 3
- [ ] Test step 3 → review → submit → ticket created → redirect
- [ ] Test `?step=2` URL → wizard starts on step 2
- [ ] Test `?step=5` → defaults to step 1
- [ ] Test at 375px — wizard usable, responsive
- [ ] Test at 768px — tablet layout works
- [ ] Test at 1024px — desktop layout works

### Task 5: Visual Parity Verification (AC: 4, 5)
- [ ] Compare outer wrapper with reference — must match exactly
- [ ] Compare contacts section with reference — must match exactly
- [ ] Screenshot at 375px, 768px, 1024px
- [ ] Document any unavoidable differences (inner wizard form fields)

---

## Dev Notes

### Reference Pages
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`
- Fetched raw HTML via curl on 2026-04-12

### XotBaseWidget Documentation
- `Modules/Xot/docs/xotbase-extension-rules-1.md` — extension rules
- `Modules/Xot/docs/common-anti-patterns.md` — anti-patterns to avoid
- `Modules/Xot/docs/optimization.md` — optimization notes
- `Modules/Xot/app/Filament/Widgets/XotBaseWidget.php` — source code

### Filament 5.x References
- Wizard: `https://filamentphp.com/docs/5.x/schemas/wizards`
- Widgets: `https://filamentphp.com/docs/5.x/widgets/overview`

### Key Anti-Patterns (NEVER do these)
1. `use InteractsWithForms;` in widget that extends XotBaseWidget — already inherited
2. `use InteractsWithActions;` in widget that extends XotBaseWidget — already inherited
3. Implementing `HasForms` or `HasActions` on widget that extends XotBaseWidget — already implemented
4. Duplicating form field HTML in blade — let Wizard render them
5. Hardcoded Italian strings — always use `__('fixcity::*')`

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] Widget extends XotBaseWidget (NOT direct Filament)
- [ ] Widget does NOT redeclare traits already in XotBaseWidget
- [ ] Wizard uses Filament 5.x Schemas Wizard (NOT Forms Wizard)
- [ ] Blade template wraps wizard in Design Comuni structure
- [ ] Contacts section matches reference HTML EXACTLY
- [ ] Wizard step navigation functional (next/previous/submit)
- [ ] `?step=N` URL navigation works
- [ ] Ticket creation on submit works
- [ ] Responsive on mobile/tablet/desktop
- [ ] Visual parity verified (outer wrapper matches, inner wizard uses Filament markup)
- [ ] ZERO hardcoded Italian strings
- [ ] Frontoffice assets (@filamentStyles/Scripts) loaded on test routes
