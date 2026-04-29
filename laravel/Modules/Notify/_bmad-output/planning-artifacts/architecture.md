---
stepsCompleted: ["step-01-init", "step-02-context", "step-03-starter", "step-04-decisions", "step-05-patterns", "step-06-structure", "step-07-validation", "step-08-complete"]
inputDocuments:
  - "_bmad-output/planning-artifacts/prd.md"
workflowType: 'architecture'
project_name: 'base_fixcity_fila5'
user_name: 'Xot'
date: '2026-04-04'
lastStep: 8
status: 'complete'
completedAt: '2026-04-04'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Contesto

Questo documento definisce le decisioni architetturali per il progetto **Design Comuni Visual Parity** - replica visiva del design Design Comuni usando Tailwind + Alpine.js (NO Bootstrap Italia).

## Riferimenti

- PRD: `_bmad-output/planning-artifacts/prd.md`
- Tema: `laravel/Themes/Sixteen`
- Build: Vite + npm run build

---

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**
| ID | Requisito | Impatto Architetturale |
|----|-----------|----------------------|
| FR-01 | Visual Replication | Componenti Blade riutilizzabili |
| FR-02 | Tailwind Only | Configurazione Tailwind, no Bootstrap |
| FR-03 | Alpine.js Components | Interazioni client-side |
| FR-04 | Responsive Design | Breakpoints, mobile-first |
| FR-05 | Accessibility | WCAG compliance |
| FR-06 | Blade Components | Component architecture |
| FR-07 | JSON Content | Data layer |
| FR-08 | Vite Build | Build pipeline |

**Non-Functional Requirements:**
- Performance: Page load <3s, CLS <0.1
- Accessibility: Lighthouse ≥90, WCAG 2.1 AA
- Bundle: CSS <200KB
- Code Quality: PHPStan Level 10

### Scale & Complexity

| Aspect | Valutazione |
|--------|-------------|
| Primary Domain | Web / CMS Theme |
| Complexity | Medium-High |
| Componenti | ~15 core components |
| Pagine | 40 MVP |

### Technical Constraints

1. NO Bootstrap Italia - Vincolo hard
2. Laravel Blade - Template system
3. Vite - Build system
4. Alpine.js v3 - Interactive components
5. Tailwind v4 - CSS framework

---

## Core Architectural Decisions

### Decision Priority Analysis

**Critical Decisions:**
- Tailwind Only - ZERO Bootstrap Italia classes
- Alpine.js for all interactive components

**Important Decisions:**
- Component Architecture: Blade components con Tailwind integrato
- Visual Testing: Playwright visual regression
- CSS Organization: Tailwind config + custom utilities

**Deferred (Post-MVP):**
- Multi-language support (EN)
- Analytics integration
- SEO advanced features

### Component Architecture

| Decision | Scelta | Rationale |
|----------|--------|-----------|
| CSS | Tailwind utilities + custom | Pattern Laraxot |
| JS | Alpine.js v3 | Leggero, integrato |
| Components | Blade reusable | Manutenibilità |
| Content | JSON-driven | Database-driven |

### Visual Testing Strategy

- Tool: Playwright
- Comparison: Screenshot diff
- CI: GitHub Actions on PR

### Build Process

| Step | Command |
|------|---------|
| Build | `npm run build` |
| Copy | `npm run copy` |

### Implementation Sequence

1. Setup Tailwind config per Design Comuni
2. Create core Blade components
3. Implement Alpine.js interactions
4. Build page templates matching reference
5. Add visual regression tests

---

## Implementation Patterns & Consistency Rules

### Naming Conventions

| Tipo | Pattern |
|------|---------|
| Blade Components | PascalCase |
| CSS Classes | kebab-case (Tailwind) |
| Alpine Components | camelCase |
| CSS Files | kebab-case |

### CSS Organization

```
resources/css/
├── sixteen.css (main)
└── components/
    ├── header.css
    ├── footer.css
    ├── card.css
    └── form.css
```

### Consistency Rules

- NO Bootstrap Italia classes allowed
- Tailwind first, then custom utilities
- Blade components extend existing patterns
- Alpine.js directives: x-data, x-show, x-transition
- Accessibility: aria-*, role, tabindex

---

## Project Structure

```
Themes/Sixteen/
├── resources/
│   ├── css/
│   │   ├── sixteen.css
│   │   └── components/
│   ├── js/alpine/
│   └── views/
│       ├── components/
│       └── pages/tests/
├── public/
│   ├── css/ (built)
│   └── js/ (built)
├── tailwind.config.js
├── vite.config.js
└── package.json
```

### Requirements Mapping

| FR Category | Location |
|-------------|----------|
| Visual Replication | resources/views/pages/tests/ |
| Tailwind Styling | resources/css/ |
| Alpine Interactions | resources/js/alpine/ |
| Build | vite.config.js, tailwind.config.js |

---

## Architecture Completion

**Status:** ✅ COMPLETO
**Data:** 2026-04-04
**Steps Completed:** 7/7

### Validation Results

| Check | Status |
|-------|--------|
| Decision Compatibility | ✅ Pass |
| Requirements Coverage | ✅ 100% |
| Coherence | ✅ Pass |
| Gap Analysis | ✅ No gaps |

### Prossimi Passi

1. **Epic Creation** - Scomposizione in epics (bmad-create-epics-and-stories)
2. **Sprint Planning** - Timeline e milestone
3. **Implementation** - Start working on CSS/JS

---

*Documento generato con BMAD-METHOD workflow*