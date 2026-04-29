# 📚 Design Comuni Italia - BMad Documentation Index

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** ✅ **Complete**
**Total Documents:** 6 BMad docs + Block Analysis

---

## 🎯 Overview

Questo documento indice tutti i documenti BMad creati per il progetto **Design Comuni Italia Replication** nel progetto FixCity Fila5.

**Goal:** Replicare tutte le 38 pagine statiche di [Design Comuni Pagine Statiche](https://italia.github.io/design-comuni-pagine-statiche/) garantendo:
- ✅ Identità HTML (esclusi scripts)
- ✅ Tailwind CSS @apply (NO Bootstrap imports)
- ✅ JSON Content Blocks (NO hardcoded HTML)
- ✅ Blocchi Universali (NO page-specific)
- ✅ Folio + Volt (single `[slug].blade.php`)
- ✅ Conformità AGID (WCAG 2.1 AA)

---

## 📋 BMad Documents

### 1. Product Requirements Document (PRD)

**File:** [`_bmad-output/design-comuni-prd.md`](_bmad-output/design-comuni-prd.md)

**Purpose:** Definire requirements funzionali, non-funzionali, user personas, e criteri di successo

**Sections:**
- Executive Summary
- Goals & Success Metrics
- User Personas (Mario, Anna, Segretario Comunale)
- Functional Requirements (38 pagine)
- Non-Functional Requirements (Performance, Accessibility, Code Quality)
- Architecture Overview
- Content Model (JSON structure)
- Design System (Colors, Typography, Spacing)
- Implementation Strategy (5 phases)
- Acceptance Criteria
- Risk Assessment

**Key Artifacts:**
- 38 pagine mappate per priorità
- JSON content structure
- Block types catalog
- WCAG 2.1 AA requirements

**Cross-References:**
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Epics](_bmad-output/design-comuni-epics.md) - Implementation tasks
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

### 2. Architecture Design

**File:** [`_bmad-output/design-comuni-architecture.md`](_bmad-output/design-comuni-architecture.md)

**Purpose:** Definire architettura tecnica, directory structure, component hierarchy, data flow

**Sections:**
- Architectural Goals
- System Architecture (3-layer)
- Directory Structure (Theme, Module, JSON)
- Component Architecture (Layout, Section, Block)
- Data Flow (Request lifecycle)
- Design System Architecture (Tailwind @apply)
- Security Architecture (JSON validation)
- Performance Architecture (Vite, Tailwind purge)
- Testing Architecture (Pest tests)
- Database Schema
- Decision Log

**Key Artifacts:**
- Component hierarchy diagram
- Data flow diagram
- Tailwind @apply rules
- JSON validation action
- Vite configuration

**Cross-References:**
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

### 3. UI Specification

**File:** [`_bmad-output/design-comuni-ui-spec.md`](_bmad-output/design-comuni-ui-spec.md)

**Purpose:** Definire specifiche UI per componenti: colors, typography, spacing, components

**Sections:**
- Design Tokens (Colors, Typography, Spacing)
- **Component Catalog (47 componenti)** - Updated with block analysis
  - Tier 1: Fondamentali (7 componenti)
  - Tier 2: Navigazione (5 componenti)
  - Tier 3: Form & Input (10 componenti)
  - Tier 4: Card & Content (12 componenti)
  - Tier 5: Specialized (13 componenti)
- Component Specifications (Header, Hero, Topics Grid, Card, News, Governance, Events, Footer)
- Accessibility Requirements (WCAG 2.1 AA)
- Responsive Design (Breakpoints, Mobile-first)
- Interaction Patterns (Hover, Focus, Active)

**Key Artifacts:**
- Color palette (Primary, Secondary, Accent, Neutral)
- Typography scale (H1-H6, Body)
- Spacing scale (xs-5xl)
- Component props & structure
- **47 componenti identificati** da analisi 38 pagine
- Implementation priority (5 phases)

**Cross-References:**
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [Block Analysis](_bmad-output/design-comuni-block-analysis.md) - Detailed component analysis
- → [Tailwind @apply](laravel/Themes/Sixteen/docs/TAILWIND_DESIGN_COMUNI_COMPLETE.md) - Styling guide
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

### 4. Block Analysis

**File:** [`_bmad-output/design-comuni-block-analysis.md`](_bmad-output/design-comuni-block-analysis.md)

**Purpose:** Analisi completa dei 38 template per identificare blocchi riutilizzabili

**Sections:**
- Executive Summary
- Elenco Completo Pagine con Blocchi Identificati (38 pagine)
  - Pagine Generali (9 pagine)
  - Amministrazione (2 pagine)
  - Novità (2 pagine)
  - Servizi (3 pagine)
  - Vivere il Comune (2 pagine)
  - Prenotazione Appuntamento (8 pagine)
  - Richiesta Assistenza (2 pagine)
  - Segnalazione Disservizio (7 pagine)
- Matrice di Utilizzo Blocchi
  - Componenti Universali (100% o quasi)
  - Componenti per Categoria Funzionale
  - Blocchi Specifici per Categoria
- Pattern Architetturali
  - Pattern: Lista
  - Pattern: Dettaglio
  - Pattern: Form multi-step
  - Pattern: Riepilogo
  - Pattern: Conferma
- Raccomandazioni Implementazione
  - Tier 1-5 prioritizzazione
  - Anti-pattern da evitare
  - Convenzioni naming

**Key Artifacts:**
- **38 pagine analizzate** una per una
- **47 componenti riutilizzabili** identificati
- **5 pattern** architetturali
- **Matrice frequenza** blocchi
- **8 famiglie** componenti

**Cross-References:**
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Epics](_bmad-output/design-comuni-epics.md) - Implementation tasks
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

### 5. Epics & Stories

**File:** [`_bmad-output/design-comuni-epics.md`](_bmad-output/design-comuni-epics.md)

**Purpose:** Scomporre il progetto in epics e stories implementabili

**Structure:**
- **12 Epics** con 62 stories totali
- **EPIC-1:** Foundation Setup (5 stories)
- **EPIC-2:** Header & Footer (4 stories)
- **EPIC-3:** Block Components (10 stories) - **Updated: 47 componenti**
- **EPIC-4:** Homepage Replication (3 stories)
- **EPIC-5:** Argomenti & Navigation (3 stories)
- **EPIC-6:** Amministrazione (3 stories)
- **EPIC-7:** Novità & Eventi (4 stories)
- **EPIC-8:** Servizi (4 stories)
- **EPIC-9:** Appuntamento Wizard (8 stories)
- **EPIC-10:** Assistenza & Segnalazione (9 stories)
- **EPIC-11:** Testing & QA (5 stories)
- **EPIC-12:** Documentation (4 stories)

**Key Artifacts:**
- Story templates con acceptance criteria
- Technical tasks per story
- Test definitions
- Implementation examples

**Cross-References:**
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Block Analysis](_bmad-output/design-comuni-block-analysis.md) - Component catalog
- → [Sprint Plan](_bmad-output/design-comuni-sprint-plan.md) - Timeline
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

### 6. Sprint Plan

**File:** [`_bmad-output/design-comuni-sprint-plan.md`](_bmad-output/design-comuni-sprint-plan.md)

**Purpose:** Pianificare implementazione su 6 sprint (12 settimane)

**Structure:**
- **Sprint 1** (Week 1-2): Foundation + Header/Footer - 9 stories
- **Sprint 2** (Week 3-4): Block Components - 10 stories (Updated: 47 componenti)
- **Sprint 3** (Week 5-6): Core Pages - 9 stories
- **Sprint 4** (Week 7-8): Content Pages - 8 stories
- **Sprint 5** (Week 9-10): Wizards - 17 stories
- **Sprint 6** (Week 11-12): QA & Documentation - 9 stories

**Key Artifacts:**
- Day-by-day task breakdown
- Assignee definitions
- Effort estimates
- Definition of Done
- Burndown chart

**Cross-References:**
- → [PRD](_bmad-output/design-comuni-prd.md) - Requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Epics](_bmad-output/design-comuni-epics.md) - Implementation tasks
- → [Block Analysis](_bmad-output/design-comuni-block-analysis.md) - Component priorities
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

---

## 📊 Block Analysis Summary

### 38 Pagine Analizzate

| Categoria | Pagine | Blocchi Chiave |
|-----------|--------|----------------|
| **Generali** | 9 | Hero, Search, Topics-grid, Card-simple |
| **Amministrazione** | 2 | Card-simple, Card-teaser |
| **Novità** | 2 | Card-latest-messages, Navscroll, Tag |
| **Servizi** | 3 | Card-latest-messages, Timeline, Carousel |
| **Vivere il Comune** | 2 | Hero-img, Card-horizontal |
| **Appuntamento** | 8 | Form multi-step (5 steps), Progress, Summary |
| **Assistenza** | 2 | Form (2 steps), Privacy |
| **Segnalazione** | 7 | Form multi-step (3 steps), Map, Area-personale |

### 47 Componenti Identificati

**Tier 1 - Fondamentali (7):**
- `cmp-base/base` (100%)
- `cmp-breadcrumbs` (97%)
- `cmp-contacts/*` (95%)
- `cmp-rating` (87%)
- `cmp-hero/*` (79%)
- `cmp-card/*` (92%)
- `cmp-button` (85%)

**Tier 2 - Navigazione (5):**
- `cmp-navscroll` (58%)
- `cmp-nav-steps` (32%)
- `cmp-info-progress` (29%)
- `cmp-nav-tab` (3%)
- `cmp-category-list` (13%)

**Tier 3 - Form (10):**
- `cmp-input`, `cmp-select`, `cmp-text-area`
- `cmp-info-button-card`, `cmp-info-summary`
- `cmp-info-radio`, `cmp-card-radio-list`
- `cmp-input-autocomplete`, `cmp-info-summary-no-modify`, `cmp-callout`

**Tier 4 - Card (12):**
- `cmp-card-simple` (70%+), `cmp-card-latest-messages` (53%)
- `cmp-card-teaser`, `cmp-card-content-box`, `cmp-card-img`
- `cmp-list-card-img-hr`, `cmp-list-card-img`, `cmp-list-card-docs`
- `cmp-ul-list`, `cmp-icon-link`, `cmp-icon-list`, `cmp-tag`

**Tier 5 - Specialized (13):**
- `cmp-modal`, `cmp-carousel`, `cmp-map`, `cmp-timeline`
- `cmp-accordion`, `cmp-accordion-faq`, `cmp-filter`
- `cmp-heading`, `cmp-heading-detail`, `cmp-text-button`
- `cmp-hero-img-small`, `cmp-input-search`, `cmp-data-element`

### 5 Pattern Architetturali

1. **Pattern: Lista** - Pagine con elenco card (novità, servizi, eventi)
2. **Pattern: Dettaglio** - Pagina singolo elemento con navscroll, tag, carousel
3. **Pattern: Form Multi-Step** - Flussi transazionali con progress indicator
4. **Pattern: Riepilogo** - Step finale con summary read-only
5. **Pattern: Conferma** - Pagina finale con check circle e azioni

---

## 🔗 Bidirectional Link System

### From Master Index

**In [Master Index](docs/MODULE_DOCS_INDEX.md):**

```markdown
### BMad Output - Design Comuni Italia

- **Location:** `_bmad-output/`
- **Files:** 5
- **Index:** [BMad Design Comuni Index](_bmad-output/DESIGN_COMUNI_INDEX.md) - This file
- **Documents:**
  - [PRD](_bmad-output/design-comuni-prd.md) - Product requirements
  - [Architecture](_bmad-output/design-comuni-architecture.md) - System design
  - [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specifications
  - [Epics & Stories](_bmad-output/design-comuni-epics.md) - Implementation tasks
  - [Sprint Plan](_bmad-output/design-comuni-sprint-plan.md) - Timeline
```

### From Theme Docs

**In [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md):**

```markdown
### Design Comuni Replication

- **BMad Documentation:**
  - [PRD](../../../_bmad-output/design-comuni-prd.md)
  - [Architecture](../../../_bmad-output/design-comuni-architecture.md)
  - [UI Spec](../../../_bmad-output/design-comuni-ui-spec.md)
  - [Epics](../../../_bmad-output/design-comuni-epics.md)
  - [Sprint Plan](../../../_bmad-output/design-comuni-sprint-plan.md)
- **Technical Guide:** [Replication Master Plan](design-comuni/REPLICATION_MASTER_PLAN.md)
```

### From Module Docs

**In [Cms Module Docs](laravel/Modules/Cms/docs/README.md):**

```markdown
### Design Comuni Integration

- [PRD](../../../_bmad-output/design-comuni-prd.md) - Requirements
- [Architecture](../../../_bmad-output/design-comuni-architecture.md) - System design
- [JSON Content Guide](../../../_bmad-output/design-comuni-ui-spec.md#json-content-structure) - Content model
```

---

## 📊 Document Relationships

```
Master Index (docs/MODULE_DOCS_INDEX.md)
  │
  ├─► BMad Index (_bmad-output/DESIGN_COMUNI_INDEX.md)
  │    │
  │    ├─► PRD (design-comuni-prd.md)
  │    │    ├─► Architecture
  │    │    ├─► UI Spec
  │    │    └─► Epics
  │    │
  │    ├─► Architecture (design-comuni-architecture.md)
  │    │    ├─► PRD
  │    │    ├─► UI Spec
  │    │    └─► Replication Master Plan
  │    │
  │    ├─► UI Spec (design-comuni-ui-spec.md)
  │    │    ├─► PRD
  │    │    ├─► Architecture
  │    │    └─► Tailwind @apply Guide
  │    │
  │    ├─► Epics (design-comuni-epics.md)
  │    │    ├─► PRD
  │    │    ├─► Architecture
  │    │    ├─► UI Spec
  │    │    └─► Sprint Plan
  │    │
  │    └─► Sprint Plan (design-comuni-sprint-plan.md)
  │         ├─► PRD
  │         ├─► Architecture
  │         ├─► UI Spec
  │         └─► Epics
  │
  └─► Theme Docs (laravel/Themes/Sixteen/docs/00-index.md)
       └─► Design Comuni Replication
```

---

## 📋 Quality Checklist

### Document Quality

- [x] **Clear Purpose** - Ogni documento ha uno scopo definito
- [x] **Complete Sections** - Tutte le sezioni necessarie presenti
- [x] **Cross-References** - Min 3 collegamenti bidirezionali
- [x] **Actionable** - Documenti utilizzabili per implementazione
- [x] **Consistent Format** - Formato BMad standard

### Link Quality

- [x] **Bidirectional** - Link reciproci tra documenti
- [x] **Relative Paths** - Percorsi relativi (portable)
- [x] **Descriptive Labels** - Etichette descrittive
- [x] **No Broken Links** - Tutti i link funzionanti

---

## 🚀 Usage Guide

### For Developers

1. **Start with PRD** - Understand requirements
2. **Read Architecture** - Understand system design
3. **Check UI Spec** - Understand components
4. **Follow Sprint Plan** - Implement in order

### For Project Managers

1. **Review PRD** - Understand scope
2. **Check Epics** - Track progress
3. **Monitor Sprint Plan** - Manage timeline

### For QA

1. **Review PRD** - Understand acceptance criteria
2. **Check UI Spec** - Understand accessibility requirements
3. **Follow Testing Stories** - EPIC-11

---

## 📞 Support

### Key Contacts

- **Product Owner:** Refer to PRD
- **Tech Lead:** Refer to Architecture doc
- **UX Designer:** Refer to UI Spec
- **Scrum Master:** Refer to Sprint Plan

### External Resources

- [Design Comuni Pagine Statiche](https://italia.github.io/design-comuni-pagine-statiche/)
- [Bootstrap Italia Documentation](https://italia.github.io/bootstrap-italia/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Laravel Folio Documentation](https://laravel.com/docs/folio)
- [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Next Review:** Sprint 1 Planning
**🎯 Status:** ✅ Complete

🐮 **BMad Documentation Index Complete!**
