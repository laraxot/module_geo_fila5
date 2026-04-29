# Story 7.33: segnalazione-crea-wizard-html-visual-parity

Status: ready-for-dev

## Story

As a **citizen using the ticket creation wizard**,
I want **the wizard interface to match the Design Comuni reference exactly in HTML structure and visual appearance**,
so that **I experience a consistent, professional, and accessible interface across all municipality pages**.

## Acceptance Criteria

1. Wizard stepper matches Design Comuni reference (colors, icons, spacing, typography)
2. Step 1 (Privacy) HTML structure matches `segnalazione-01-privacy.html` reference
3. Step 2 (Dati) card layout matches `segnalazione-02-dati.html` reference (card headers, body, spacing)
4. Step 3 (Riepilogo) summary layout matches reference design
5. Navigation buttons (Avanti/Indietro/Submit) match Design Comuni button styles
6. Form fields use Design Comuni input/select/textarea styling
7. Geolocation "Usa la tua posizione" link styled identically to reference
8. Image upload component matches Design Comuni file upload pattern
9. Mobile responsive breakpoints match reference (320px, 576px, 768px, 992px, 1200px)
10. WCAG 2.1 AA accessibility compliance maintained
11. No visual regression on other segnalazione pages

## Tasks / Subtasks

### Task 1: Analyze Design Comuni Reference HTML/CSS (AC: #1)
- [ ] Download reference screenshots from `segnalazione-01-privacy`, `segnalazione-02-dati`, `segnalazione-03-riepilogo`
- [ ] Extract HTML structure for stepper, cards, forms, buttons
- [ ] Document CSS classes used (Bootstrap Italia + Design Comuni custom)
- [ ] Create comparison table: reference vs current implementation

### Task 2: Implement Custom Wizard Stepper Styling (AC: #1)
- [ ] Create custom wizard stepper CSS matching Design Comuni
- [ ] Style confirmed step with green check icon
- [ ] Style active step with blue highlight
- [ ] Style pending step with gray text
- [ ] Add steppers-index counter styling (e.g., "2/3")
- [ ] Test on mobile (320px-576px): show only active step + counter

### Task 3: Style Step 1 (Privacy) for HTML Parity (AC: #2, #5)
- [ ] Match privacy intro text styling (text-paragraph, mb-lg-4)
- [ ] Match privacy link styling (t-primary, link style)
- [ ] Style checkbox with Design Comuni pattern (form-check, checkbox-body)
- [ ] Match "Avanti" button: `btn btn-primary mobile-full`
- [ ] Verify HTML structure matches reference exactly

### Task 4: Style Step 2 (Dati) Cards for HTML Parity (AC: #3, #4, #6, #7)
- [ ] Create `cmp-card` CSS class matching Design Comuni card style
- [ ] Style card headers: `card-header border-0 p-0 mb-lg-20 m-0`
- [ ] Style card body: `card-body p-0`
- [ ] Style form groups with bg-white wrapper (p-3 mb-0 mt-3)
- [ ] Match input/select/textarea styling to reference
- [ ] Style geolocation link: `list-item active icon-left` with map-marker icon
- [ ] Style file upload button matching reference (rounded-icon, upload icon)
- [ ] Verify author section matches reference (cmp-info-button-card)

### Task 5: Style Step 3 (Riepilogo) for HTML Parity (AC: #4)
- [ ] Style warning callout: `callout callout-highlight ps-3 warning`
- [ ] Match summary layout: cmp-info-summary bg-white p-3 p-lg-4
- [ ] Style summary items with data-text class
- [ ] Match submit button styling

### Task 6: Implement Responsive Behavior (AC: #9)
- [ ] Test wizard on 320px, 576px, 768px, 992px, 1200px
- [ ] Ensure stepper collapses to active step only on mobile/tablet
- [ ] Ensure cards stack vertically on mobile
- [ ] Ensure buttons are `mobile-full` width on small screens
- [ ] Verify no horizontal scroll at any breakpoint

### Task 7: Accessibility Audit (AC: #10)
- [ ] Run axe-core accessibility audit
- [ ] Verify ARIA labels on stepper, icons, interactive elements
- [ ] Verify keyboard navigation through wizard steps
- [ ] Verify focus indicators on all interactive elements
- [ ] Verify color contrast ratios (4.5:1 minimum)
- [ ] Fix any accessibility issues found

### Task 8: Visual Parity Testing (AC: #11)
- [ ] Take screenshots of each step at desktop (1200px+)
- [ ] Take screenshots at tablet (768px-991px)
- [ ] Take screenshots at mobile (320px-575px)
- [ ] Compare side-by-side with Design Comuni reference
- [ ] Document any visual differences
- [ ] Fix differences to achieve ≥95% visual parity

## Dev Notes

### Architecture Patterns

- **Widget**: Extends `XotBaseWizardWidget` (not `XotBaseWidget`) - follows Single Responsibility Principle
- **Schema**: Uses `Wizard::make([Step::make(), ...])` from Filament 5.x
- **State**: Managed via `data` path (normalized with `normalizeWizardFormState()`)
- **CSS**: Custom CSS in `segnalazione-parity.css` with `body.page-tests-segnalazione-crea` prefix
- **Build**: `npm run build && npm run copy` after every CSS change

### Current Implementation State

**Widget Class**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- ✅ Extends `XotBaseWizardWidget`
- ✅ Uses Filament Schema Wizard
- ✅ 3 steps implemented
- ✅ Geolocation component created
- ❌ Missing custom stepper styling
- ❌ Missing card-based layout for form fields
- ❌ Missing Design Comuni button styling

**Blade Template**: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- ✅ Wrapper with title
- ✅ `{{ $this->form }}` renders wizard
- ❌ Missing custom CSS overrides for parity
- ❌ Missing side navigation (cmp-navscroll)
- ❌ Missing breadcrumbs

**Reference Pages**:
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-01-privacy.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-03-riepilogo.blade.php`

### Code Conventions

- Use `body.page-tests-segnalazione-crea` prefix for CSS selectors
- No `!important` unless absolutely necessary
- Follow mobile-first responsive design
- Maintain WCAG AA contrast ratios
- Use semantic HTML elements
- CSS must match Design Comuni class names where possible

### CSS Target File

`laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

Add new section for wizard parity (after existing sections):

```css
/* Section XX: Wizard HTML/Visual Parity */
body.page-tests-segnalazione-crea .fi-wizard-step-confirmed { ... }
body.page-tests-segnalazione-crea .fi-wizard-step-active { ... }
body.page-tests-segnalazione-crea .cmp-card { ... }
/* etc. */
```

### Testing Standards

- Visual parity testing with screenshots (desktop, tablet, mobile)
- Manual accessibility testing
- Cross-browser testing: Chrome, Firefox, Safari, Edge
- Lighthouse audit for performance (target: ≥90)

### Dependencies

- Epic 1: Foundation (Tailwind, Vite, Alpine) ✅ Complete
- Epic 2: Core UI Components ✅ Complete
- Epic 3: Accessibility ✅ Complete
- Epic 7: Ticket wizard (previous stories) ✅ In Progress

### Previous Story Learnings

From Epic 7 (segnalazione flows):
- Header responsiveness requires careful breakpoint handling
- Use `npm run build && npm run copy` after every CSS change
- Test on actual mobile devices, not just browser dev tools
- Visual parity requires pixel-level attention to spacing, fonts, colors

### References

- [Design Comuni Reference]: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- [Filament 5.x Wizard Docs]: https://filamentphp.com/docs/5.x/schemas/wizards
- [Filament 5.x Widgets]: https://filamentphp.com/docs/5.x/widgets/overview
- [Current Widget]: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- [Reference Blade]: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- [Pattern Doc]: `laravel/Modules/Fixcity/docs/filament-wizard-pattern.md`
- [Rules]: `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`

## Dev Agent Record

### Agent Model Used

{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
