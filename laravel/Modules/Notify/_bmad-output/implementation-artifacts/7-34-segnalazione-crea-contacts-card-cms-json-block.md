# Story 7.34: segnalazione-crea-contacts-card-cms-json-block

Status: ready-for-dev

## Story

As a **CMS content manager**,
I want **the contacts card block to be configured in the page JSON (not hardcoded in Blade)**,
so that **all pages follow the CMS-driven architecture pattern where content blocks are data-driven, not code-driven**.

## Acceptance Criteria

1. `segnalazione-crea` page renders contacts card from JSON block, not from Blade `@include`/`<x-component>`
2. Contacts card component (`x-pub_theme::blocks.design-comuni.contacts-card`) is invoked via `$blocks` iteration
3. JSON block configuration includes: `type`, `view`, `data` (with contacts array)
4. Visual parity maintained after refactoring (no CSS/layout changes)
5. All segnalazione pages (01-privacy, 02-dati, 03-riepilogo, 04-conferma, crea) use JSON block pattern
6. No hardcoded `<div class="bg-grey-card shadow-contacts">` in any Blade template
7. Documentation updated with CMS block pattern explanation

## Tasks / Subtasks

- [ ] Task 1: Understand CMS block architecture (AC: #1, #2)
  - [ ] Study `Page::getBlocksBySlug()` implementation
  - [ ] Study how blocks are stored in database JSON
  - [ ] Document block structure: `{type, view, data}`
- [ ] Task 2: Create contacts card JSON block configuration (AC: #3)
  - [ ] Add contacts card block to `segnalazione-crea` page JSON
  - [ ] Add contacts card block to `segnalazione-01-privacy` page JSON
  - [ ] Add contacts card block to `segnalazione-02-dati` page JSON
  - [ ] Add contacts card block to `segnalazione-03-riepilogo` page JSON
  - [ ] Add contacts card block to `segnalazione-04-conferma` page JSON
- [ ] Task 3: Remove hardcoded contacts blocks from Blade templates (AC: #6)
  - [ ] Remove from `segnalazione-crea` Blade
  - [ ] Remove from `segnalazione-01-privacy` Blade
  - [ ] Remove from `segnalazione-02-dati` Blade
  - [ ] Remove from `segnalazione-03-riepilogo` Blade
  - [ ] Remove from `segnalazione-04-conferma` Blade
- [ ] Task 4: Verify visual parity (AC: #4)
  - [ ] Test on desktop (1200px+)
  - [ ] Test on tablet (768px)
  - [ ] Test on mobile (320px)
  - [ ] Verify no layout/CSS regressions
- [ ] Task 5: Audit other pages for same pattern (AC: #7)
  - [ ] Find all pages with hardcoded contacts blocks
  - [ ] Migrate to JSON block pattern
  - [ ] Update documentation with CMS block pattern

## Dev Notes

### Architecture Pattern: CMS-Driven Blocks

**Zen**: Le pagine sono **composizioni di blocchi JSON**, non template hardcoded. Questo è il principio **Data over Code**.

```
Pagina = Array di Blocchi (dal database JSON)
Ogni blocco = { type: 'contact-card', view: 'pub_theme::...', data: {...} }
Rendering = foreach($blocks as $block) → @include($block->view, $block->data)
```

**Perché**:
- **Separation of Concerns**: Content (JSON) ≠ Presentation (Blade)
- **Flexibility**: Cambiare layout senza toccare codice
- **Consistency**: Un solo componente, molte pagine
- **CMS-first**: I content manager configurano, non sviluppano

### Current State

**Widget**: `CreateTicketWizardWidget` blade template
```blade
{{-- SBAGLIATO: hardcoded component --}}
<x-pub_theme::blocks.design-comuni.contacts-card :contacts="$contacts" />
```

**Correct Pattern**: Add to page JSON blocks array:
```json
{
  "blocks": [
    {
      "type": "contact-card",
      "view": "pub_theme::components.blocks.design-comuni.contacts-card",
      "data": {
        "contacts": {
          "faq": "/it/faq",
          "assistenza": "/it/assistenza",
          "phone": "05 0505",
          "phone_url": "tel:+39050505",
          "appointment": "/it/appuntamento"
        }
      }
    }
  ]
}
```

### CMS Block Rendering

Pages iterate blocks via:
```blade
@foreach($blocks as $block)
    @include($block->view, array_merge($data, ['data' => $block->data]))
@endforeach
```

Where `$blocks = Page::getBlocksBySlug($pageSlug, 'content')`

### Component Location

`laravel/Themes/Sixteen/resources/views/components/blocks/design-comuni/contacts-card.blade.php`

### References

- [CMS Block Pattern]: `laravel/Modules/Cms/app/Models/Traits/HasBlocks.php`
- [Page Model]: `laravel/Modules/Cms/app/Models/Page.php`
- [Contacts Card Component]: `laravel/Themes/Sixteen/resources/views/components/blocks/design-comuni/contacts-card.blade.php`
- [Ticket Wizard Blade]: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

## Dev Agent Record

### Agent Model Used

{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
