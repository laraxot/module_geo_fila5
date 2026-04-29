# Story 4.1: homepage-template

Status: ready-for-dev

## Story

As a **citizen visiting a municipality website**,
I want **to see a clear, accessible homepage with key information and navigation**,
so that **I can quickly find services, news, events, and municipal information**.

## Acceptance Criteria

1. Homepage displays municipality header with logo, name, and primary navigation
2. Hero section shows featured content or announcements
3. Quick access cards to main services are visible above the fold
4. Latest news and events sections are displayed
5. Search functionality is accessible from the homepage
6. Footer contains institutional information and links
7. Layout is fully responsive across mobile (320px+), tablet (768px+), and desktop (1200px+)
8. WCAG 2.1 AA accessibility compliance for all interactive elements
9. Page loads in <3s with Lighthouse performance score ≥90
10. Visual parity with Design Comuni reference homepage

## Tasks / Subtasks

- [ ] Task 1: Homepage header and navigation (AC: #1, #7)
  - [ ] Create municipality header component with logo and name
  - [ ] Implement primary navigation menu
  - [ ] Add mobile hamburger menu for small screens
- [ ] Task 2: Hero section and featured content (AC: #2, #7)
  - [ ] Build hero section for announcements
  - [ ] Implement featured content carousel or static display
- [ ] Task 3: Quick access services cards (AC: #3, #7)
  - [ ] Create service cards grid layout
  - [ ] Add icon and link for each primary service
- [ ] Task 4: News and events sections (AC: #4, #7)
  - [ ] Implement latest news list component
  - [ ] Add upcoming events widget
- [ ] Task 5: Search and footer (AC: #5, #6, #7)
  - [ ] Integrate search bar component
  - [ ] Build footer with institutional links
- [ ] Task 6: Visual parity and accessibility (AC: #8, #9, #10)
  - [ ] Verify visual parity with Design Comuni reference
  - [ ] Run accessibility audit and fix issues
  - [ ] Optimize performance metrics

## Dev Notes

### Architecture Patterns

- **Component Architecture**: Use Blade components following Laraxot patterns
- **CSS**: Tailwind CSS v4 utilities + custom properties in `segnalazione-parity.css` or dedicated homepage CSS
- **JS**: Alpine.js v3 for interactive components (mobile menu, carousels)
- **Content**: JSON-driven content layer from CMS module
- **Build**: Vite pipeline - `npm run build` → `npm run copy` after changes

### File Structure Requirements

- Blade template: `laravel/Themes/Sixteen/resources/views/components/blocks/homepage.blade.php`
- CSS: `laravel/Themes/Sixteen/resources/css/homepage.css` (or extend existing CSS files)
- Alpine components: Inline in Blade or separate JS files in theme assets
- Content JSON: Follow CMS module content structure

### Code Conventions

- Use `body.page-homepage` prefix for CSS selectors
- No `!important` unless absolutely necessary
- Follow mobile-first responsive design (320px → 576px → 768px → 992px → 1200px)
- Maintain WCAG AA contrast ratios (4.5:1 minimum)
- Use semantic HTML elements

### Testing Standards

- Visual parity testing with Playwright screenshots
- Lighthouse audit for performance (target: ≥90)
- Accessibility testing with axe-core or similar
- Cross-browser testing: Chrome, Firefox, Safari, Edge
- Manual testing on mobile devices

### Dependencies

- Epic 1: Foundation (Tailwind config, design tokens, Vite, Alpine) ✅ Complete
- Epic 2: Core UI Components (header, footer, cards, buttons, forms) ✅ Complete
- Epic 3: Accessibility & UX ✅ Complete

### Previous Story Learnings

From Epic 7 (segnalazione flows):
- Header responsiveness requires careful breakpoint handling at 768px and 992px
- Stepper components need mobile-first CSS with explicit viewport constraints
- Visual parity requires pixel-level attention to spacing, fonts, and colors
- Use `npm run build && npm run copy` after every CSS change
- Test on actual mobile devices, not just browser dev tools

### Project Structure Notes

- Theme: `laravel/Themes/Sixteen`
- Views: `resources/views/components/blocks/`
- CSS: `resources/css/`
- JS: `resources/js/`
- Content: CMS module drives page content via JSON

### References

- [Source: _bmad-output/planning-artifacts/prd.md] - Product Requirements for Design Comuni Visual Parity
- [Source: _bmad-output/planning-artifacts/architecture.md] - Architecture decisions (Tailwind v4, Alpine.js v3, Blade components)
- [Source: _bmad-output/implementation-artifacts/sprint-status.yaml] - Sprint tracking
- [Design Comuni Reference]: https://italia.github.io/design-comuni-pagine-statiche/
- [Theme Structure]: laravel/Themes/Sixteen/

## Dev Agent Record

### Agent Model Used

{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
