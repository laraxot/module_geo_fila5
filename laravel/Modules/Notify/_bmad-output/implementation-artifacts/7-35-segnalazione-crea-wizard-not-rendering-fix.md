# Story 7.35: segnalazione-crea-wizard-not-rendering-fix

Status: ready-for-dev

## Story

As a **citizen accessing the ticket creation wizard**,
I want **the form, stepper, and buttons to be fully visible and readable**,
so that **I can complete the ticket creation process without visual barriers**.

## Acceptance Criteria

1. Wizard form is visible on page load at http://127.0.0.1:8000/it/tests/segnalazione-crea
2. Stepper is visible with all 3 step labels rendered
3. Navigation buttons (Avanti/Indietro/Submit) display readable text content
4. Form fields (address, type, title, details) are visible and accessible
5. No CSS conflicts between Bootstrap Italia and Filament styles
6. Wizard renders correctly on mobile (320px+), tablet (768px+), desktop (1200px+)
7. Page loads without JavaScript console errors

## Tasks / Subtasks

### Task 1: Diagnose why wizard form is not visible (AC: #1, #4)
- [ ] Check if `@filamentStyles` is loading in main layout
- [ ] Check if `@filamentScripts` is loading in main layout
- [ ] Verify Livewire assets are included
- [ ] Check browser console for JavaScript errors
- [ ] Inspect HTML to see if `{{ $this->form }}` is rendering or empty

### Task 2: Fix stepper visibility (AC: #2)
- [ ] Verify Filament Wizard component renders correctly
- [ ] Check if wizard step labels are being output
- [ ] Fix any CSS hiding the stepper (display: none, visibility: hidden)
- [ ] Ensure stepper has proper z-index and positioning

### Task 3: Fix button text readability (AC: #3)
- [ ] Check button CSS classes (btn btn-primary mobile-full)
- [ ] Verify text color contrasts with background
- [ ] Check if button text is being truncated or overflowed
- [ ] Fix any white-space or overflow issues

### Task 4: Resolve CSS conflicts (AC: #5)
- [ ] Audit Bootstrap Italia vs Filament CSS conflicts
- [ ] Check for !important overrides hiding elements
- [ ] Verify Filament wizard CSS is loaded after Bootstrap
- [ ] Add specific CSS fixes in segnalazione-parity.css if needed

### Task 5: Test responsive behavior (AC: #6)
- [ ] Test on 320px mobile viewport
- [ ] Test on 768px tablet viewport
- [ ] Test on 1200px+ desktop viewport
- [ ] Verify no horizontal scroll at any breakpoint

### Task 6: Error-free rendering (AC: #7)
- [ ] Fix any JavaScript console errors
- [ ] Fix any Livewire rendering errors
- [ ] Fix any Blade template errors

## Dev Notes

### Current Implementation

**Page**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`
```blade
@props(['data' => []])
<div class="segnalazione-crea-wrapper">
    @livewire(\Modules\Fixcity\Filament\Widgets\CreateTicketWizardWidget::class, ['blockData' => $data])
</div>
```

**Widget**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- Extends `XotBaseWizardWidget`
- Uses Filament Schema Wizard with 3 steps
- `getFormSchema()` returns `Wizard::make([...])`

**Blade Template**: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- Renders `{{ $this->form }}` inside `<x-filament-widgets::widget>`
- Wrapped in Design Comuni container/row structure

**Layout**: `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php`
- Has `@filamentStyles` at line 33
- Has `@filamentScripts` (verify line)

### Potential Issues

1. **Filament Wizard CSS not loaded**: Front-end may not have `filament/schemas.css` for wizard styling
2. **CSS conflicts**: Bootstrap Italia may override Filament classes
3. **Livewire not initialized**: `@livewire` directive may not be rendering widget properly
4. **Widget wrapper issue**: `<x-filament-widgets::widget>` may be hiding content

### Debugging Steps

1. Check page source for `@filamentStyles` output
2. Open browser dev tools → Elements → inspect if form HTML exists but is hidden
3. Check Network tab for failed CSS/JS requests
4. Check Console tab for JavaScript errors
5. Add `@dump($this->form)` temporarily to see form state

### CSS Target File

`laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

Add fixes here if needed.

### References

- [Page Blade]: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`
- [Widget Class]: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- [Widget Blade]: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- [Main Layout]: `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php`
- [Filament Styles Docs]: https://filamentphp.com/docs/5.x/schemas/installation

## Dev Agent Record

### Agent Model Used

{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
