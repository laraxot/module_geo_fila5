# 📅 Design Comuni Italia - Sprint Plan

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔄 **In Progress**
**Priority:** 🔴 **CRITICAL**
**Version:** 1.0

---

## 📊 Sprint Overview

| Sprint | Duration | Focus | Stories | Status |
|--------|----------|-------|---------|--------|
| **Sprint 1** | Week 1-2 | Foundation + Header/Footer | 9 | ⏳ Pending |
| **Sprint 2** | Week 3-4 | Block Components | 10 | ⏳ Pending |
| **Sprint 3** | Week 5-6 | Core Pages | 9 | ⏳ Pending |
| **Sprint 4** | Week 7-8 | Content Pages | 8 | ⏳ Pending |
| **Sprint 5** | Week 9-10 | Wizards | 17 | ⏳ Pending |
| **Sprint 6** | Week 11-12 | QA & Documentation | 9 | ⏳ Pending |

**Total:** 62 stories across 6 sprints
**Total Duration:** 12 weeks

---

## 🎯 Sprint 1: Foundation (Week 1-2)

**Goal:** Setup architettura base e componenti header/footer

**Stories:** 9
**Capacity:** High
**Focus Area:** Architecture, Routing, Theme Detection

---

### Day 1-2: Foundation Setup

#### STORY-1.1: Create Single [slug].blade.php

**Assignee:** Developer
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Create file: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- [ ] Implement Volt component with mount(string $slug)
- [ ] Build pageSlug: 'tests.' . $slug
- [ ] Load JSON content from config path
- [ ] Implement error handling (404)

**Definition of Done:**
- [ ] File created
- [ ] Route working: /it/tests/{slug}
- [ ] JSON loading functional
- [ ] Tests passing

---

#### STORY-1.2: Define JSON Content Structure

**Assignee:** Developer
**Effort:** 2h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Define JSON schema
- [ ] Create template file
- [ ] Document block types
- [ ] Implement validation

**Definition of Done:**
- [ ] Schema documented
- [ ] Template created
- [ ] Validation working

---

#### STORY-1.3: Implement Block Rendering System

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Create `<x-page>` component
- [ ] Implement @foreach block loop
- [ ] Add dynamic component resolver
- [ ] Test data passing

**Definition of Done:**
- [ ] Component created
- [ ] Blocks render correctly
- [ ] Data passed to blocks

---

#### STORY-1.4: Implement Theme Detection

**Assignee:** Developer
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Parse APP_URL
- [ ] Build config path
- [ ] Load theme from config
- [ ] Add fallback mechanism

**Definition of Done:**
- [ ] Theme detection working
- [ ] Fallback to Sixteen
- [ ] Caching implemented

---

#### STORY-1.5: Configure Vite Build

**Assignee:** Developer
**Effort:** 2h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Update vite.config.js (outDir: './public')
- [ ] Update package.json scripts
- [ ] Test npm run build
- [ ] Test npm run copy

**Definition of Done:**
- [ ] Build successful
- [ ] Assets copied to public_html/themes/Sixteen/
- [ ] Manifest generated

---

### Day 3-5: Header & Footer

#### STORY-2.1: Implement Skip Links

**Assignee:** Developer
**Effort:** 1h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Add "Vai ai contenuti" link
- [ ] Add "Vai al footer" link
- [ ] Implement visually-hidden-focusable CSS
- [ ] Test keyboard navigation

**Definition of Done:**
- [ ] Links present
- [ ] Focus on Tab key
- [ ] Accessible

---

#### STORY-2.2: Implement Top Bar

**Assignee:** Developer
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Region name display
- [ ] Language selector (ITA/ENG)
- [ ] Login button with icon
- [ ] Responsive behavior

**Definition of Done:**
- [ ] All elements present
- [ ] Responsive
- [ ] Accessible

---

#### STORY-2.3: Implement Header Branding

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Stemma comunale
- [ ] Nome comune (H1)
- [ ] Slogan (optional)
- [ ] Social links

**Definition of Done:**
- [ ] Branding complete
- [ ] H1 semantic
- [ ] Social icons

---

#### STORY-2.4: Implement Footer

**Assignee:** Developer
**Effort:** 5h
**Status:** ⏳ To Do

**Tasks:**
- [ ] 6 colonne
- [ ] Social links
- [ ] Legal bar
- [ ] Responsive stacking

**Definition of Done:**
- [ ] All columns present
- [ ] Responsive
- [ ] Legal links

---

### Sprint 1 Deliverables

- [ ] `[slug].blade.php` functional
- [ ] JSON content system working
- [ ] Block rendering operational
- [ ] Theme detection active
- [ ] Vite build configured
- [ ] Header complete
- [ ] Footer complete

### Sprint 1 Acceptance Criteria

- [ ] All 9 stories completed
- [ ] Tests passing
- [ ] Code reviewed
- [ ] Documentation updated

---

## 🎯 Sprint 2: Block Components (Week 3-4)

**Goal:** Implementare tutti i block types universali

**Stories:** 10
**Capacity:** High
**Focus Area:** Components, Reusability, Design System

---

### Week 3: Basic Blocks

#### STORY-3.1: Hero Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Create component file
- [ ] Implement with/without image
- [ ] Add overlay option
- [ ] Add theme (dark/light)

**Definition of Done:**
- [ ] Component created
- [ ] Variants working
- [ ] Accessible

---

#### STORY-3.2: Topics Grid Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Responsive grid (1/2/3 columns)
- [ ] Card with icon
- [ ] Title, description, url
- [ ] "Mostra tutti" button

**Definition of Done:**
- [ ] Grid responsive
- [ ] Cards functional
- [ ] Button present

---

#### STORY-3.3: Card Block

**Assignee:** Developer
**Effort:** 5h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Variant: default
- [ ] Variant: with-image
- [ ] Variant: with-icon
- [ ] Category badge
- [ ] Date display

**Definition of Done:**
- [ ] All variants created
- [ ] Responsive
- [ ] Accessible

---

#### STORY-3.4: News Section Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Section title
- [ ] 3-column grid
- [ ] News cards
- [ ] "Tutte le novità" link

**Definition of Done:**
- [ ] Section complete
- [ ] Grid responsive
- [ ] Link functional

---

#### STORY-3.5: Governance Section Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Section title
- [ ] Cards per organ
- [ ] Name, role, description
- [ ] "Vai alla pagina" button

**Definition of Done:**
- [ ] Section complete
- [ ] Cards functional
- [ ] Buttons working

---

### Week 4: Advanced Blocks

#### STORY-3.6: Events List Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Title + month
- [ ] Vertical list
- [ ] Date (day/month)
- [ ] Title, time, link

**Definition of Done:**
- [ ] List complete
- [ ] Date display
- [ ] Links working

---

#### STORY-3.7: Search Form Block

**Assignee:** Developer
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Input field
- [ ] Submit button
- [ ] Placeholder text
- [ ] Accessibility labels

**Definition of Done:**
- [ ] Form functional
- [ ] Accessible
- [ ] Styled

---

#### STORY-3.8: Feedback Form Block

**Assignee:** Developer
**Effort:** 5h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Rating stars (1-5)
- [ ] Checklist liked aspects
- [ ] Checklist difficulties
- [ ] Text area details
- [ ] Navigation buttons

**Definition of Done:**
- [ ] All fields present
- [ ] Validation working
- [ ] Accessible

---

#### STORY-3.9: Services Grid Block

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Responsive grid
- [ ] Service cards
- [ ] Icon, title, description
- [ ] Category

**Definition of Done:**
- [ ] Grid responsive
- [ ] Cards functional
- [ ] Category display

---

#### STORY-3.10: Appointment Wizard Block

**Assignee:** Developer
**Effort:** 8h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Multi-step form (8 steps)
- [ ] Progress indicator
- [ ] Validation per step
- [ ] Summary step

**Definition of Done:**
- [ ] All steps implemented
- [ ] Validation working
- [ ] Progress shown

---

### Sprint 2 Deliverables

- [ ] All 10 block components created
- [ ] Documentation for each block
- [ ] Tests written
- [ ] Examples provided

### Sprint 2 Acceptance Criteria

- [ ] All 10 stories completed
- [ ] Components reusable
- [ ] Tests passing (80%+ coverage)
- [ ] Documentation complete

---

## 🎯 Sprint 3: Core Pages (Week 5-6)

**Goal:** Replicare homepage e pagine core

**Stories:** 9
**Capacity:** High
**Focus Area:** Content, JSON, Visual Parity

---

### Week 5: Homepage

#### STORY-4.1: Create Homepage JSON

**Assignee:** Content Manager
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Create file: tests.homepage.json
- [ ] Define blocks: hero, news, governance, events, topics, search, feedback
- [ ] Populate with data
- [ ] Validate JSON

**Definition of Done:**
- [ ] JSON file created
- [ ] Valid structure
- [ ] All blocks defined

---

#### STORY-4.2: Implement Homepage HTML

**Assignee:** Developer
**Effort:** 5h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Replicate HTML structure
- [ ] Apply correct CSS classes
- [ ] Add data attributes
- [ ] Exclude scripts

**Definition of Done:**
- [ ] HTML identical
- [ ] Classes correct
- [ ] No scripts

---

#### STORY-4.3: Visual Parity Check

**Assignee:** QA
**Effort:** 3h
**Status:** ⏳ To Do

**Tasks:**
- [ ] Take screenshot Design Comuni
- [ ] Take screenshot FixCity
- [ ] Side-by-side comparison
- [ ] Document gaps

**Definition of Done:**
- [ ] Screenshots taken
- [ ] Comparison complete
- [ ] Gaps documented

---

### Week 6: Argomenti & Amministrazione

#### STORY-5.1: Create Argomenti JSON

**Assignee:** Content Manager
**Effort:** 2h
**Status:** ⏳ To Do

---

#### STORY-5.2: Implement Argomenti HTML

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

---

#### STORY-5.3: Implement Mega Menu

**Assignee:** Developer
**Effort:** 5h
**Status:** ⏳ To Do

---

#### STORY-6.1: Create Amministrazione JSON

**Assignee:** Content Manager
**Effort:** 2h
**Status:** ⏳ To Do

---

#### STORY-6.2: Implement Amministrazione HTML

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

---

#### STORY-6.3: Implement Documenti e Dati

**Assignee:** Developer
**Effort:** 4h
**Status:** ⏳ To Do

---

### Sprint 3 Deliverables

- [ ] Homepage complete
- [ ] Argomenti complete
- [ ] Amministrazione complete
- [ ] JSON files for all pages
- [ ] Visual parity achieved

### Sprint 3 Acceptance Criteria

- [ ] All 9 stories completed
- [ ] HTML parity verified
- [ ] Visual parity >98%
- [ ] Tests passing

---

## 🎯 Sprint 4: Content Pages (Week 7-8)

**Goal:** Replicare pagine Novità, Eventi, Servizi

**Stories:** 8

---

### Week 7: Novità & Eventi

#### STORY-7.1: Create Novità JSON

**Assignee:** Content Manager
**Effort:** 2h

---

#### STORY-7.2: Implement Novità HTML

**Assignee:** Developer
**Effort:** 4h

---

#### STORY-7.3: Create Eventi JSON

**Assignee:** Content Manager
**Effort:** 2h

---

#### STORY-7.4: Implement Eventi HTML

**Assignee:** Developer
**Effort:** 4h

---

### Week 8: Servizi

#### STORY-8.1: Create Servizi JSON

**Assignee:** Content Manager
**Effort:** 2h

---

#### STORY-8.2: Implement Servizi HTML

**Assignee:** Developer
**Effort:** 4h

---

#### STORY-8.3: Create Servizio Dettaglio JSON

**Assignee:** Content Manager
**Effort:** 3h

---

#### STORY-8.4: Implement Servizio Dettaglio HTML

**Assignee:** Developer
**Effort:** 5h

---

### Sprint 4 Deliverables

- [ ] Novità page complete
- [ ] Eventi page complete
- [ ] Servizi page complete
- [ ] Servizio Dettaglio complete

### Sprint 4 Acceptance Criteria

- [ ] All 8 stories completed
- [ ] HTML parity verified
- [ ] Tests passing

---

## 🎯 Sprint 5: Wizards (Week 9-10)

**Goal:** Implementare wizard appuntamento, assistenza, segnalazione

**Stories:** 17
**Capacity:** Very High
**Focus Area:** Forms, Multi-step, Validation

---

### Week 9: Appuntamento (8 stories)

#### STORY-9.1 to 9.8: Appuntamento Steps

**Assignee:** Developer
**Total Effort:** 40h

**Steps:**
1. Ufficio
2. Luogo
3. Data/Ora
4. Dettagli
5. Richiedente (Non Auth)
6. Richiedente (Auth)
7. Riepilogo
8. Conferma

---

### Week 10: Assistenza & Segnalazione (9 stories)

#### STORY-10.1 to 10.9: Assistenza & Segnalazione

**Assignee:** Developer
**Total Effort:** 45h

**Flows:**
- Assistenza (2 steps)
- Segnalazione (7 steps)

---

### Sprint 5 Deliverables

- [ ] Appuntamento wizard complete
- [ ] Assistenza flow complete
- [ ] Segnalazione flow complete

### Sprint 5 Acceptance Criteria

- [ ] All 17 stories completed
- [ ] Forms validated
- [ ] Multi-step working
- [ ] Tests passing

---

## 🎯 Sprint 6: QA & Documentation (Week 11-12)

**Goal:** Testing, accessibility, performance, documentation

**Stories:** 9

---

### Week 11: Testing & QA

#### STORY-11.1: Pest Tests for Components

**Assignee:** QA
**Effort:** 8h

---

#### STORY-11.2: Accessibility Audit

**Assignee:** QA
**Effort:** 6h

---

#### STORY-11.3: Performance Audit

**Assignee:** QA
**Effort:** 4h

---

#### STORY-11.4: Cross-Browser Testing

**Assignee:** QA
**Effort:** 4h

---

#### STORY-11.5: Mobile Responsiveness Testing

**Assignee:** QA
**Effort:** 4h

---

### Week 12: Documentation

#### STORY-12.1: Screenshot Analysis

**Assignee:** Tech Writer
**Effort:** 8h

---

#### STORY-12.2: Block Usage Guide

**Assignee:** Tech Writer
**Effort:** 6h

---

#### STORY-12.3: JSON Content Guide

**Assignee:** Tech Writer
**Effort:** 4h

---

#### STORY-12.4: Update Master Index

**Assignee:** Tech Writer
**Effort:** 4h

---

### Sprint 6 Deliverables

- [ ] Test suite complete
- [ ] Accessibility audit passed
- [ ] Performance audit passed
- [ ] Documentation complete
- [ ] Master Index updated

### Sprint 6 Acceptance Criteria

- [ ] All 9 stories completed
- [ ] WCAG 2.1 AA certified
- [ ] Lighthouse >90
- [ ] Documentation published

---

## 📊 Burndown Chart

```
Week 1-2:  ████████░░░░░░░░░░░░  9/62  (15%)
Week 3-4:  ████████████████░░░░  19/62 (31%)
Week 5-6:  ████████████████████░░  28/62 (45%)
Week 7-8:  ████████████████████████░░  36/62 (58%)
Week 9-10: ████████████████████████████████░░  53/62 (85%)
Week 11-12: ████████████████████████████████████  62/62 (100%)
```

---

## 🔗 Cross-References

### Internal Documents

- → [PRD](_bmad-output/design-comuni-prd.md) - Product requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System architecture
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specifications
- → [Epics & Stories](_bmad-output/design-comuni-epics.md) - Implementation tasks

### Project Documentation

- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md) - Theme documentation
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Next Review:** Sprint 1 Planning
**🎯 Status:** Ready for Execution

🐮 **Sprint Plan Complete - Ready for Implementation!**
