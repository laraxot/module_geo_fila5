# PTVX Fila5 Mono - HR & Performance Evaluation System

## What This Is

PTVX is a modular enterprise HR & Performance evaluation system for Italian Public Administrations. Built on Laravel 12.47 and Filament v5, it automates personnel evaluations, indemnity management, career progression, and compliance documentation for the Italian public sector.

## Core Value

Provide Italian Public Administrations with a compliant, automated system for managing the complete employee performance evaluation cycle — from criteria configuration to final PDF documentation — while ensuring full regulatory compliance (D.Lgs. 150/2009, Law 104, GDPR) and transparent indemnity calculations.

## Requirements

### Validated

✓ **Performance evaluation cycles** — existing in Performance module  
✓ **Indemnity calculation engine** — existing in Indennita* modules  
✓ **Career progression workflows** — existing in Progressioni module  
✓ **Multi-tenant architecture** — existing in Tenant module  
✓ **Role-based access control** — existing via Spatie Permission  
✓ **PDF documentation generation** — existing via DomPDF/Browsershot  
✓ **Activity audit trails** — existing in Activity module  
✓ **GDPR consent management** — existing in Gdpr module  
✓ **Italian localization** — existing in Lang module  
✓ **42+ production modules** — deployed and active  

### Active

- [ ] **Nyquist validation gaps** — Complete validation for all shipped features
- [ ] **Test coverage 100%** — Achieve full coverage across all modules
- [ ] **Documentation completeness** — Ensure all modules have complete docs
- [ ] **PHPStan Level 10** — Maintain across all existing and new code
- [ ] **Module interop** — Improve integration between domain modules
- [ ] **AI-powered features** — Add prediction markets and AI seeder functionality
- [ ] **Dashboard V3** — ATS-style PDF exports from LimeSurvey data
- [ ] **Workflow automation** — Streamline approval chains and notifications

### Out of Scope

- **Mobile app development** — Web-first approach, responsive design sufficient
- **Non-Italian markets** — System designed specifically for Italian PA regulations
- **Real-time collaboration** — Async workflows sufficient for HR processes
- **Blockchain integration** — Traditional database architecture meets requirements
- **Machine learning predictions** — Rule-based calculations preferred for auditability

## Context

**Technical Environment:**
- Laravel 12.47 with Laraxot modular architecture
- Filament v5 admin panel with XotBase wrappers
- MySQL/PostgreSQL database with multi-tenant isolation
- 42+ modules organized in modular monolith pattern
- PHPStan Level 10, Pest v4 testing, Pint formatting
- Actions-over-Services architecture pattern
- Multi-tenant via Tenant module with database scoping

**Regulatory Context:**
- D.Lgs. 150/2009 — Public administration performance evaluation
- Law 104/1992 — Disability protections and benefits
- Law 109/2016 — Anti-corruption and transparency
- GDPR (EU 2016/679) — Data protection and privacy
- INAIL regulations — Workplace insurance and safety
- CCNL (Contratto Collettivo Nazionale) — Public sector employment contracts

**Current State:**
- 42+ modules in production
- PHPStan Level 10 achieved across modules
- Comprehensive codebase documentation completed
- Multi-agent AI coordination active (Qwen, Gemini, Claude)
- GitHub Actions for CI/CD and semantic versioning
- Documentation-driven development workflow

## Constraints

- **Regulatory**: Must comply with Italian PA regulations — changes require legal review
- **Auditability**: All calculations must be traceable and explainable
- **Multi-tenancy**: Complete data isolation between tenant administrations
- **Performance**: Must handle batch operations for large administrations (1000+ employees)
- **Integration**: Must integrate with existing PA systems (Sigma, Europa, Pdnd)
- **Language**: Italian localization required for all user-facing content

## Key Decisions

| Decision | Rationale | Outcome |
|----------|-----------|---------|
| Laraxot modular architecture | Enables independent module development and deployment | ✓ Good — 42+ modules successfully deployed |
| Actions-over-Services | Clearer business logic boundaries, queueable operations | ✓ Good — Consistent pattern across modules |
| XotBase wrappers | Enforces conventions, reduces boilerplate | ✓ Good — All Filament pages use wrappers |
| PHPStan Level 10 | Catch type errors early, improve code quality | ✓ Good — Achieved across all modules |
| Pest v4 testing | Modern, expressive test syntax | ✓ Good — Test suite growing steadily |
| Documentation-first | AI agent coordination requires explicit docs | ✓ Good — Multi-agent collaboration successful |
| Multi-tenant database | Data isolation required for PA compliance | ✓ Good — Tenant module handles scoping |
| No refreshDatabase in tests | Performance — schema rebuild too slow | ✓ Good — Using DatabaseTransactions instead |

---
*Last updated: 2026-03-18 after codebase mapping and project initialization*
