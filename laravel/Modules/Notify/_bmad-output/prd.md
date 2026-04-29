---
stepsCompleted: ['step-01-init']
inputDocuments:
  - '.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md'
  - 'laravel/Modules/Xot/docs/user-research-1.md'
  - 'laravel/Modules/User/docs/user-research-1.md'
  - 'laravel/Modules/Activity/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Activity/docs/user-research.md'
  - 'laravel/Modules/AI/docs/research.md'
  - 'laravel/Modules/AI/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Blog/docs/research.md'
  - 'laravel/Modules/Blog/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Blog/docs/user-research.md'
  - 'laravel/Modules/Cms/docs/research.md'
  - 'laravel/Modules/Cms/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Cms/docs/user-research.md'
  - 'laravel/Modules/Comment/docs/research.md'
  - 'laravel/Modules/Comment/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Fixcity/docs/research.md'
  - 'laravel/Modules/Fixcity/docs/roadmap/user-research.md'
  - 'laravel/Modules/Gdpr/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Gdpr/docs/user-research.md'
  - 'laravel/Modules/Geo/docs/research.md'
  - 'laravel/Modules/Geo/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Geo/docs/user-research.md'
  - 'laravel/Modules/Job/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Job/docs/user-research.md'
  - 'laravel/Modules/Lang/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Lang/docs/user-research.md'
  - 'laravel/Modules/Media/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Media/docs/user-research.md'
  - 'laravel/Modules/Notify/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Notify/docs/user-research.md'
  - 'laravel/Modules/Rating/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Rating/docs/user-research.md'
  - 'laravel/Modules/Seo/docs/research.md'
  - 'laravel/Modules/Seo/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Seo/docs/user-research.md'
  - 'laravel/Modules/Tenant/docs/research.md'
  - 'laravel/Modules/Tenant/docs/USER_RESEARCH.md'
  - 'laravel/Modules/UI/docs/USER_RESEARCH.md'
  - 'laravel/Modules/UI/docs/user-research.md'
  - 'laravel/Modules/Xot/docs/USER_RESEARCH.md'
  - 'laravel/Modules/Xot/docs/user-research.md'
  - 'laravel/Themes/Sixteen/docs/research.md'
  - 'laravel/Themes/Sixteen/docs/user_research.md'
  - 'laravel/Themes/TwentyOne/docs/research.md'
  - 'laravel/Themes/TwentyOne/docs/user_research.md'
  - '_bmad-output/codebase/architecture-analysis.md'
  - '_bmad-output/codebase/technology-stack.md'
  - '_bmad-output/codebase/quality-assessment.md'
  - '_bmad-output/codebase/concerns-and-debt.md'
documentCounts:
  briefCount: 0
  researchCount: 61
  brainstormingCount: 0
  projectDocsCount: 153
workflowType: 'prd'
project_name: 'FixCity Fila5'
user_name: 'Xot'
date: '2026-04-01'
---

# Product Requirements Document - FixCity Fila5

**Author:** Xot
**Date:** 2026-04-01
**Version:** 1.0
**Status:** Draft

---

## Document Purpose

This Product Requirements Document (PRD) defines the comprehensive requirements for the FixCity Fila5 platform - a modern urban issue management system built on Laravel 12 + Filament 5.

This is a **brownfield project** with extensive existing functionality undergoing continuous improvement and feature expansion.

---

## Table of Contents

<!-- TOC will be generated -->

---

## 1. Executive Summary

### 1.1 Product Vision

FixCity è una piattaforma completa per la gestione delle problematiche urbane che consente ai cittadini di segnalare problemi (buche, infrastrutture danneggiate, ecc.) e tracciarne la risoluzione attraverso un sistema avanzato di auto-assegnazione, gestione SLA e notifiche multi-canale.

### 1.2 Current State

- **Stato**: MVP production-ready con solide fondamenta
- **Framework**: Laravel 12 + Filament 5
- **Architettura**: Modulare (17 moduli + framework Laraxot)
- **Qualità Codice**: PHPStan Level 10, zero errori
- **Copertura Test**: ~65% (target: 85%)
- **Performance**: TTFB 780ms (target: 200ms)

### 1.3 Key Strengths

- ✅ Zero errori PHPStan (Level 10 compliance)
- ✅ Architettura modulare (17 moduli)
- ✅ Workflow avanzato di collaborazione AI (BMAD + GSD + Ralph Loop)
- ✅ OpenViking context management integrato
- ✅ Cultura della documentazione completa
- ✅ Infrastructure multi-agent friendly

### 1.4 Key Challenges

- ⚠️ Organizzazione documentazione (232 file markdown, 130 nella root)
- ⚠️ Roadmap multiple duplicate (16 file, dovrebbero essere 2-3)
- ⚠️ Copertura test sotto target (40% attuale vs 85% target)
- ⚠️ Ottimizzazione performance necessaria (TTFB 780ms vs 200ms target)
- ⚠️ Alcuni GitHub Actions ancora in errore

---

## 2. Product Overview

### 2.1 Product Description

FixCity è una piattaforma SaaS per la gestione delle segnalazioni cittadine che include:

- **Portale Cittadini**: Interfaccia per segnalazioni geolocalizzate
- **Pannello Amministrazione**: Dashboard Filament per gestione operativa
- **Sistema di Auto-Assegnazione**: Assegnazione automatica basata su regole
- **Gestione SLA**: Monitoraggio tempi di risoluzione
- **Notifiche Multi-Canale**: Email, SMS, push notification
- **Reporting Avanzato**: Dashboard analitiche e reportistica
- **Multi-Tenancy**: Supporto per múltiples organizzazioni/enti

### 2.2 Target Users

1. **Cittadini**: Segnalano problemi urbani
2. **Operatori Comunali**: Gestiscono le segnalazioni
3. **Amministratori di Sistema**: Configurano il sistema
4. **Responsabili di Settore**: Monitorano SLA e performance
5. **Enti Gestori**: Multi-tenancy per diversi comuni/aziende

### 2.3 User Personas

*(To be expanded based on existing user research documents)*

---

## 3. Functional Requirements

### 3.1 Core Features

#### 3.1.1 Gestione Segnalazioni (Fixcity Module)

- **FR-001**: Creazione segnalazione con geolocalizzazione
- **FR-002**: Upload foto e media allegati
- **FR-003**: Categorizzazione automatica e manuale
- **FR-004**: Auto-assegnazione basata su regole
- **FR-005**: Workflow stati segnalazione (Nuova → In Lavorazione → Risolta)
- **FR-006**: Tracking storico modifiche
- **FR-007**: Commenti e collaborazioni tra operatori

#### 3.1.2 Gestione Utenti (User Module)

- **FR-010**: Registrazione e autenticazione
- **FR-011**: Gestione ruoli e permessi (RBAC)
- **FR-012**: Profilo utente e preferenze
- **FR-013**: Recupero password
- **FR-014**: Verifica email

#### 3.1.3 Multi-Tenancy (Tenant Module)

- **FR-020**: Isolamento dati per tenant
- **FR-021**: Configurazione specifica per tenant
- **FR-022**: Switch tra tenant (super-admin)
- **FR-023**: Billing e subscription per tenant

#### 3.1.4 Content Management (Cms Module)

- **FR-030**: Pagine CMS dinamiche
- **FR-031**: Gestione menu e navigazione
- **FR-032**: Blocchi contenuto riutilizzabili
- **FR-033**: Versioning contenuti

#### 3.1.5 Blog e Comunicazione (Blog Module)

- **FR-040**: Pubblicazione articoli
- **FR-041**: Categorie e tag
- **FR-042**: Commenti articoli
- **FR-043**: SEO optimization
- **FR-044**: Newsletter integration

#### 3.1.6 Notifiche (Notify Module)

- **FR-050**: Notifiche email
- **FR-051**: Notifiche SMS
- **FR-052**: Push notification
- **FR-053**: Template notifiche
- **FR-054**: Preferenze notifica utente
- **FR-055**: Queue e retry logic

#### 3.1.7 Geolocalizzazione (Geo Module)

- **FR-060**: Geocoding indirizzi
- **FR-061**: Mappe interattive
- **FR-062**: Calcolo distanze
- **FR-063**: Zone e aree di competenza

#### 3.1.8 Media Management (Media Module)

- **FR-070**: Upload file multipli
- **FR-071**: Conversione immagini
- **FR-072**: Responsive images
- **FR-073**: Library media
- **FR-074**: Tagging e categorizzazione

#### 3.1.9 Activity Logging (Activity Module)

- **FR-080**: Log attività utenti
- **FR-081**: Audit trail
- **FR-082**: Report attività
- **FR-083**: Monitoraggio performance

#### 3.1.10 GDPR Compliance (Gdpr Module)

- **FR-090**: Gestione consensi
- **FR-091**: Privacy policy
- **FR-092**: Diritto all'oblio
- **FR-093**: Export dati personali
- **FR-094**: Cookie management

#### 3.1.11 Localizzazione (Lang Module)

- **FR-100**: Multi-lingua
- **FR-101**: Traduzioni dinamiche
- **FR-102**: Fallback lingue
- **FR-103**: Gestione chiavi traduzione

#### 3.1.12 SEO (Seo Module)

- **FR-110**: Meta tag management
- **FR-111**: Sitemap XML
- **FR-112**: Redirect 301
- **FR-113**: Open Graph tags
- **FR-114**: Schema.org markup

#### 3.1.13 Rating e Feedback (Rating Module)

- **FR-120**: Sistema valutazione stelle
- **FR-121**: Feedback utenti
- **FR-122**: Moderazione recensioni
- **FR-123**: Statistiche rating

#### 3.1.14 Intelligenza Artificiale (AI Module)

- **FR-130**: Categorizzazione automatica segnalazioni
- **FR-131**: Suggerimenti risoluzione
- **FR-132**: Analisi sentiment
- **FR-133**: Predizione tempi risoluzione
- **FR-134**: Rilevamento duplicati

### 3.2 Admin Panel Features (Filament v5)

#### 3.2.1 Dashboard

- **FR-200**: Dashboard personalizzabile
- **FR-201**: Widget statistici
- **FR-202**: Chart e grafici
- **FR-203**: KPI monitoring
- **FR-204**: Alert e notifiche

#### 3.2.2 Resource Management

- **FR-210**: Liste filtrate e ordinabili
- **FR-211**: Ricerca avanzata
- **FR-212**: Bulk actions
- **FR-213**: Export dati (Excel, CSV, PDF)
- **FR-214**: Import dati

#### 3.2.3 Actions e Operations

- **FR-220**: Azioni con modal e form
- **FR-221**: Azioni bulk
- **FR-222**: Azioni contestuali
- **FR-223**: Workflow approvativi

### 3.3 API Requirements

#### 3.3.1 REST API

- **FR-300**: API versioning (v1, v2)
- **FR-301**: Autenticazione JWT/OAuth2
- **FR-302**: Rate limiting
- **FR-303**: Documentazione OpenAPI/Swagger
- **FR-304**: API resources e trasformazioni

#### 3.3.2 Webhooks

- **FR-310**: Webhooks in uscita
- **FR-311**: Retry logic
- **FR-312**: Logging webhook
- **FR-313**: Gestione firme

---

## 4. Non-Functional Requirements

### 4.1 Performance

- **NFR-001**: TTFB < 200ms (attuale: 780ms)
- **NFR-002**: Page load < 2s
- **NFR-003**: API response < 100ms (p95)
- **NFR-004**: Supporto 1000+ utenti concorrenti
- **NFR-005**: Database query < 50ms (p95)

### 4.2 Scalability

- **NFR-010**: Horizontal scaling ready
- **NFR-011**: Database read replicas
- **NFR-012**: Cache stratification (Redis)
- **NFR-013**: Queue-based processing
- **NFR-014**: CDN integration

### 4.3 Security

- **NFR-020**: OWASP Top 10 compliance
- **NFR-021**: CSRF protection
- **NFR-022**: XSS prevention
- **NFR-023**: SQL injection prevention
- **NFR-024**: Rate limiting API
- **NFR-025**: Audit logging completo
- **NFR-026**: GDPR compliance

### 4.4 Reliability

- **NFR-030**: Uptime 99.9%
- **NFR-031**: Backup automatico giornaliero
- **NFR-032**: Disaster recovery plan
- **NFR-033**: Monitoring e alerting
- **NFR-034**: Health check endpoints

### 4.5 Maintainability

- **NFR-040**: PHPStan Level 10
- **NFR-041**: Test coverage > 85%
- **NFR-042**: Code coverage > 90%
- **NFR-043**: Documentation completeness
- **NFR-044**: CI/CD pipeline
- **NFR-045**: Automated quality gates

### 4.6 Usability

- **NFR-050**: WCAG 2.1 AA accessibility
- **NFR-051**: Mobile responsive
- **NFR-052**: Multi-language support
- **NFR-053**: Intuitive UX
- **NFR-054**: Onboarding utenti

---

## 5. Technical Architecture

### 5.1 High-Level Architecture

```
┌─────────────────────────────────────────┐
│         Presentation Layer              │
│  ┌─────────────┐  ┌──────────────────┐ │
│  │  Filament   │  │   Public Site    │ │
│  │  Admin v5   │  │  (Folio + Volt)  │ │
│  └─────────────┘  └──────────────────┘ │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│       Application Layer                 │
│  ┌─────────────┐  ┌──────────────────┐ │
│  │  Actions    │  │   Form Requests  │ │
│  │ (Spatie QA) │  │   (Validation)   │ │
│  └─────────────┘  └──────────────────┘ │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│         Domain Layer                    │
│  ┌─────────────┐  ┌──────────────────┐ │
│  │   Models    │  │    Contracts     │ │
│  │  (XotBase)  │  │   (Interfaces)   │ │
│  └─────────────┘  └──────────────────┘ │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│      Infrastructure Layer               │
│  ┌─────────────┐  ┌──────────────────┐ │
│  │  Database   │  │  External Svcs   │ │
│  │ (MySQL/PG)  │  │ (AI, Maps, SMS)  │ │
│  └─────────────┘  └──────────────────┘ │
└─────────────────────────────────────────┘
```

### 5.2 Module Dependencies

*(To be expanded with dependency graph from architecture-analysis.md)*

### 5.3 Database Schema

*(To be expanded with key entities and relationships)*

### 5.4 Technology Stack

| Component | Technology | Version | Status |
|-----------|-----------|---------|--------|
| **Backend** | PHP | 8.2+ | ✅ |
| **Framework** | Laravel | 12.x | ✅ |
| **Admin Panel** | Filament | 5.x | 🔄 |
| **Reactive UI** | Livewire | 4.x | ✅ |
| **Components** | Flux UI | 2.x | ✅ |
| **Frontend** | Tailwind CSS | 4.x | ✅ |
| **Testing** | Pest PHP | 4.x | ✅ |
| **Static Analysis** | PHPStan | 2.x | ✅ |
| **Database** | MySQL/PostgreSQL | 8.0+ | ✅ |
| **Cache** | Redis | 6.x | ✅ |
| **Queue** | Redis/SQS | - | ✅ |

---

## 6. User Experience Requirements

### 6.1 Design Principles

- **UX-001**: Mobile-first approach
- **UX-002**: Accessibility WCAG 2.1 AA
- **UX-003**: Consistent design system
- **UX-004**: Fast perceived performance
- **UX-005**: Clear visual hierarchy

### 6.2 Key User Flows

#### 6.2.1 Citizen Reporting Flow

1. Landing page → 2. Login/Register → 3. Nuova segnalazione → 4. Upload foto → 5. Conferma → 6. Tracking

#### 6.2.2 Operator Resolution Flow

1. Dashboard → 2. Segnalazioni assegnate → 3. Dettagli → 4. Aggiorna stato → 5. Aggiungi note → 6. Chiudi

### 6.3 UI Components

- Filament v5 components
- Flux UI v2 components
- Custom components (documentati in UI module)

---

## 7. Success Metrics

### 7.1 Business Metrics

- **M-001**: Numero segnalazioni/mese
- **M-002**: Tempo medio risoluzione
- **M-003**: Tasso soddisfazione utenti
- **M-004**: Numero tenant attivi
- **M-005**: MRR (Monthly Recurring Revenue)

### 7.2 Technical Metrics

- **M-010**: TTFB < 200ms
- **M-011**: Uptime > 99.9%
- **M-012**: Test coverage > 85%
- **M-013**: Zero PHPStan errors
- **M-014**: CI/CD success rate > 95%

### 7.3 User Metrics

- **M-020**: DAU/MAU ratio
- **M-021**: User retention rate
- **M-022**: NPS (Net Promoter Score)
- **M-023**: Support ticket volume

---

## 8. Go-to-Market Strategy

### 8.1 Launch Phases

**Phase 1: Alpha (Completato)**
- MVP con funzionalità base
- Testing interno

**Phase 2: Beta (In Corso)**
- Testing con utenti pilota
- Raccolta feedback

**Phase 3: Public Launch (Pianificato)**
- Launch ufficiale
- Marketing campaign

**Phase 4: Growth (Futuro)**
- Feature expansion
- Market scaling

### 8.2 Target Markets

1. Comuni piccoli/medi (< 50k abitanti)
2. Aziende di servizi pubblici
3. Consorzi di gestione territorio

---

## 9. Risks and Mitigations

### 9.1 Technical Risks

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Performance degradation | High | Medium | Caching strategy, query optimization |
| Security vulnerabilities | High | Low | Regular audits, OWASP compliance |
| Technical debt accumulation | Medium | High | Refactoring sprints, quality gates |

### 9.2 Business Risks

| Risk | Impact | Probability | Mitigation |
|------|--------|-------------|------------|
| Low user adoption | High | Medium | UX research, onboarding optimization |
| Competition | Medium | Medium | Differentiation, feature innovation |
| Regulatory changes | Medium | Low | GDPR compliance, legal review |

---

## 10. Open Questions

1. **Integrazione Sistemi Esterni**: Quali API di terze parti sono necessarie?
2. **Modello di Pricing**: Subscription tier da definire
3. **Supporto Mobile**: App nativa o PWA?
4. **Analytics**: Quali metriche tracciare per primi?

---

## 11. Appendices

### 11.1 Glossary

- **SLA**: Service Level Agreement
- **TTFB**: Time To First Byte
- **RBAC**: Role-Based Access Control
- **QA**: Quality Assurance

### 11.2 References

- [Architecture Analysis](_bmad-output/codebase/architecture-analysis.md)
- [Technology Stack](_bmad-output/codebase/technology-stack.md)
- [Quality Assessment](_bmad-output/codebase/quality-assessment.md)
- [Concerns and Debt](_bmad-output/codebase/concerns-and-debt.md)
- [Project Research Summary](.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md)

### 11.3 Document History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-04-01 | Xot | Initial draft from BMad workflow |

---

**Next Steps:**

1. ✅ Completare documentazione codebase (DONE)
2. 🔄 Completare PRD (IN CORSO)
3. ⏳ Creare architettura tecnica
4. ⏳ Definire UX design
5. ⏳ Scomporre in epics e stories
6. ⏳ Pianificare sprint
