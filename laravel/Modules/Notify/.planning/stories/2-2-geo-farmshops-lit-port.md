# Story: Farmshops.eu Port to Lit Web Component in Geo Module

## Status: Draft

## Epic
**Epic 2**: Modular Architecture — Domain-Driven Module Boundaries

## Story
As a developer working on the `Geo` module,
I want a Lit-based web component that reproduces the functional behavior of `farmshops.eu`,
so that the project can reuse that proven Leaflet UX inside the modular Laravel/Filament architecture without carrying forward legacy jQuery/global-script structure.

---

## Context

Reference source:
- Public repository: `https://github.com/CodeforKarlsruhe/farmshops.eu`
- License verified: **MIT**

Local technical sources already present in this project:
- `laravel/Modules/Geo/resources/views/maps/farmshops/`
- `laravel/Modules/Geo/resources/views/maps/farmshops/js/direktvermarkter.js`
- `laravel/Modules/Geo/resources/js/direktvermarkter.js`

Important interpretation:
- The requested outcome is **feature parity / UX parity / interaction parity**
- It is **not** a literal copy-paste migration of legacy code
- The new implementation must be rewritten as a modern Lit Web Component inside the `Geo` module
- No jQuery, no CDN, no page-global imperative bootstrap as the primary architecture

---

## Acceptance Criteria

### AC1: Geo-only ownership
- **Given** the project modular architecture
- **When** the new component is implemented
- **Then** all PHP, Blade, JS, CSS, test files live only under `laravel/Modules/Geo/`
- **And** no logic is added to unrelated modules

### AC2: Lit Web Component
- **Given** the existing requirement for reusable map UI
- **When** the solution is delivered
- **Then** the map UI is implemented as a Lit Web Component
- **And** the component manages Leaflet initialization internally
- **And** the component uses light DOM via `createRenderRoot() { return this; }` for Leaflet compatibility

### AC3: Farmshops functional parity
- **Given** the legacy `farmshops.eu` map behavior
- **When** I use the new component
- **Then** it supports the same core interaction model:
- base map + satellite switch
- clustered markers
- category-specific markers
- marker click popup
- geolocation control
- scale control
- zoom controls
- URL/permalink state if technically feasible in the new architecture

### AC4: Category behavior parity
- **Given** the original farmshops implementation
- **When** features are rendered
- **Then** categories equivalent to `farm`, `vending_machine`, `marketplace`, and `beekeeper` are visually distinguishable
- **And** unknown category fallback is supported
- **And** cluster rendering reflects category composition similarly to the original UX

### AC5: Modernized architecture
- **Given** the legacy reference uses jQuery and global scripts
- **When** the new component is implemented
- **Then** no jQuery is used
- **And** no legacy `$.getJSON()` pattern remains
- **And** popup content is rendered from already loaded data or from a modern internal adapter pattern
- **And** dependencies are bundled through the existing frontend build, not CDN tags

### AC6: Data loading strategy
- **Given** the original project relies on GeoJSON and details payloads
- **When** the new component is implemented
- **Then** the component accepts a GeoJSON-style dataset contract
- **And** data loading is explicit and modular
- **And** there is a documented strategy for either:
- fully preloaded data
- or controlled lazy detail loading without jQuery

### AC7: Filament integration path
- **Given** this project uses Filament v5 and Livewire v4
- **When** the implementation is completed
- **Then** the component is consumable from the `Geo` module through a clear integration point
- **And** if used in Filament, the wrapper follows established `Geo` widget/component conventions

### AC8: Build and asset discipline
- **Given** the project build rules
- **When** assets are added
- **Then** they are built with the module/frontend build system already used in this repository
- **And** resulting assets are registrable from the module/provider layer
- **And** no ad-hoc script tags are required in production

### AC9: Testability
- **Given** the module quality requirements
- **When** the story is implemented
- **Then** Pest tests cover PHP-side contract and configuration serialization
- **And** JS behavior that cannot be directly covered is documented with verification steps

### AC10: Verification
- **Given** the repository-wide quality workflow
- **When** validation is run
- **Then** the implementation is checked with the standard project commands
- **And** validation starts at project level
- **And** only if noise is too high, validation is narrowed module-by-module

---

## Tasks / Subtasks

### Task 1: Analyze the existing local farmshops implementation
- [ ] Read `laravel/Modules/Geo/resources/views/maps/farmshops/js/direktvermarkter.js`
- [ ] Read the local farmshops asset folder to identify required marker images, controls, popup behavior, and CSS dependencies
- [ ] Document the exact parity scope to preserve
- [ ] Separate mandatory parity features from legacy-only implementation details

### Task 2: Define the new component contract
- [ ] Define the Web Component public API: config, dataset, selected feature, active layers
- [ ] Define the GeoJSON/property schema expected by the component
- [ ] Define emitted custom events for selection and state changes
- [ ] Decide whether permalink support is in scope or deferred with explicit note

### Task 3: Implement the Lit Web Component in Geo
- [ ] Create the new Lit component under `laravel/Modules/Geo/resources/js/components/`
- [ ] Implement Leaflet map initialization and cleanup
- [ ] Add marker creation by category
- [ ] Add clustering behavior and custom cluster icon logic
- [ ] Add popup rendering and selection state
- [ ] Add base layer switching and geolocation control

### Task 4: Add integration wrapper in Geo
- [ ] Create the Blade wrapper/view needed by the module
- [ ] If needed, create or update a Geo widget/component PHP wrapper
- [ ] Ensure config/data are serialized safely from PHP to the Web Component
- [ ] Register assets via the module’s provider/build path

### Task 5: Migrate visual assets and styles
- [ ] Reuse only the assets needed for parity from the local farmshops source
- [ ] Remove dependency on legacy global CSS where possible
- [ ] Keep styling scoped to the Geo implementation
- [ ] Preserve recognizable farmshops interaction patterns without dragging in the whole legacy page shell

### Task 6: Add tests and validation
- [ ] Add Pest coverage for PHP-side wrapper/config generation
- [ ] Add at least one regression test for the Geo-side integration point
- [ ] Run build verification
- [ ] Run project validation with standard commands and narrow scope only if the global run is too noisy

---

## Dev Notes

### Source-of-truth rule
- Treat the upstream repository and the local `farmshops` copy as reference material
- Do not delete source materials after ingest or analysis
- `docs/wiki/` is compiled knowledge, not a replacement for source files

### Architectural rule
- Prefer porting behavior, not porting technical debt
- The original structure is acceptable as research input, not as final architecture

### Expected implementation style
- Lit Web Component
- Leaflet in light DOM
- npm/Vite-managed assets
- No jQuery
- No CDN
- No page-global bootstrap as final pattern

### Existing local leverage
- The project already contains farmshops assets and script copies in the Geo module
- Reuse that local reference before fetching or recreating assets

---

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-16 | 1.0 | Initial brownfield story for farmshops.eu Lit port in Geo module | AI Agent |

---

## Dev Agent Record

### Agent Model Used
_(not yet run)_

### Debug Log References
_(not yet run)_

### Completion Notes
_(not yet run)_

### File List
_(not yet run)_

### Change Log
_(not yet run)_
