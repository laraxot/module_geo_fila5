---
stepsCompleted: ['step-01-document-discovery', 'step-02-prd-analysis', 'step-03-epic-coverage-validation', 'step-04-ux-alignment', 'step-05-epic-quality-review', 'step-06-final-assessment']
project: FixCity Fila5
date: 2026-04-03
documentInventory:
  prd:
    - _bmad-output/prd.md
    - _bmad-output/design-comuni-prd.md
  architecture:
    - _bmad-output/architecture.md
    - _bmad-output/design-comuni-architecture.md
    - _bmad-output/codebase/architecture-analysis.md
  epicsAndStories:
    - _bmad-output/epics-and-stories.md
    - _bmad-output/design-comuni-epics.md
  uxSpec:
    - _bmad-output/ui-spec.md
    - _bmad-output/design-comuni-ui-spec.md
---

# Implementation Readiness Assessment Report

**Date:** 2026-04-03
**Project:** FixCity Fila5

---

## Document Inventory

| Tipo | File | Dimensione | Data |
|------|------|-----------|------|
| PRD principale | `_bmad-output/prd.md` | 18K | 01/04 |
| PRD Design Comuni | `_bmad-output/design-comuni-prd.md` | 23K | 01/04 |
| Architecture principale | `_bmad-output/architecture.md` | 32K | 01/04 |
| Architecture Design Comuni | `_bmad-output/design-comuni-architecture.md` | 33K | 01/04 |
| Architecture Analysis (codebase) | `_bmad-output/codebase/architecture-analysis.md` | 26K | 01/04 |
| Epics & Stories principali | `_bmad-output/epics-and-stories.md` | 20K | 01/04 |
| Epics & Stories Design Comuni | `_bmad-output/design-comuni-epics.md` | 21K | 01/04 |
| UX Spec principale | `_bmad-output/ui-spec.md` | 32K | 01/04 |
| UX Spec Design Comuni | `_bmad-output/design-comuni-ui-spec.md` | 35K | 01/04 |

---

## PRD Analysis

### Functional Requirements — PRD Principale (FixCity Platform)

**Gestione Segnalazioni (FR-001–007):**
- FR-001: Creazione segnalazione con geolocalizzazione
- FR-002: Upload foto e media allegati
- FR-003: Categorizzazione automatica e manuale
- FR-004: Auto-assegnazione basata su regole
- FR-005: Workflow stati segnalazione (Nuova → In Lavorazione → Risolta)
- FR-006: Tracking storico modifiche
- FR-007: Commenti e collaborazioni tra operatori

**Gestione Utenti (FR-010–014):**
- FR-010: Registrazione e autenticazione
- FR-011: Gestione ruoli e permessi (RBAC)
- FR-012: Profilo utente e preferenze
- FR-013: Recupero password
- FR-014: Verifica email

**Multi-Tenancy (FR-020–023):**
- FR-020: Isolamento dati per tenant
- FR-021: Configurazione specifica per tenant
- FR-022: Switch tra tenant (super-admin)
- FR-023: Billing e subscription per tenant

**CMS (FR-030–033):**
- FR-030: Pagine CMS dinamiche
- FR-031: Gestione menu e navigazione
- FR-032: Blocchi contenuto riutilizzabili
- FR-033: Versioning contenuti

**Blog (FR-040–044):**
- FR-040: Pubblicazione articoli
- FR-041: Categorie e tag
- FR-042: Commenti articoli
- FR-043: SEO optimization
- FR-044: Newsletter integration

**Notifiche (FR-050–055):**
- FR-050: Notifiche email
- FR-051: Notifiche SMS
- FR-052: Push notification
- FR-053: Template notifiche
- FR-054: Preferenze notifica utente
- FR-055: Queue e retry logic

**Geolocalizzazione (FR-060–063):**
- FR-060: Geocoding indirizzi
- FR-061: Mappe interattive
- FR-062: Calcolo distanze
- FR-063: Zone e aree di competenza

**Media Management (FR-070–074):**
- FR-070: Upload file multipli
- FR-071: Conversione immagini
- FR-072: Responsive images
- FR-073: Library media
- FR-074: Tagging e categorizzazione

**Activity Logging (FR-080–083):**
- FR-080: Log attività utenti
- FR-081: Audit trail
- FR-082: Report attività
- FR-083: Monitoraggio performance

**GDPR Compliance (FR-090–094):**
- FR-090: Gestione consensi
- FR-091: Privacy policy
- FR-092: Diritto all'oblio
- FR-093: Export dati personali
- FR-094: Cookie management

**Localizzazione (FR-100–103):**
- FR-100: Multi-lingua
- FR-101: Traduzioni dinamiche
- FR-102: Fallback lingue
- FR-103: Gestione chiavi traduzione

**SEO (FR-110–114):**
- FR-110: Meta tag management
- FR-111: Sitemap XML
- FR-112: Redirect 301
- FR-113: Open Graph tags
- FR-114: Schema.org markup

**Rating e Feedback (FR-120–123):**
- FR-120: Sistema valutazione stelle
- FR-121: Feedback utenti
- FR-122: Moderazione recensioni
- FR-123: Statistiche rating

**AI (FR-130–134):**
- FR-130: Categorizzazione automatica segnalazioni
- FR-131: Suggerimenti risoluzione
- FR-132: Analisi sentiment
- FR-133: Predizione tempi risoluzione
- FR-134: Rilevamento duplicati

**Admin Dashboard (FR-200–204):**
- FR-200: Dashboard personalizzabile
- FR-201: Widget statistici
- FR-202: Chart e grafici
- FR-203: KPI monitoring
- FR-204: Alert e notifiche

**Resource Management (FR-210–214):**
- FR-210: Liste filtrate e ordinabili
- FR-211: Ricerca avanzata
- FR-212: Bulk actions
- FR-213: Export dati (Excel, CSV, PDF)
- FR-214: Import dati

**Actions & Operations (FR-220–223):**
- FR-220: Azioni con modal e form
- FR-221: Azioni bulk
- FR-222: Azioni contestuali
- FR-223: Workflow approvativi

**REST API (FR-300–304):**
- FR-300: API versioning (v1, v2)
- FR-301: Autenticazione JWT/OAuth2
- FR-302: Rate limiting
- FR-303: Documentazione OpenAPI/Swagger
- FR-304: API resources e trasformazioni

**Webhooks (FR-310–313):**
- FR-310: Webhooks in uscita
- FR-311: Retry logic
- FR-312: Logging webhook
- FR-313: Gestione firme

**Totale FRs PRD principale: 73**

---

### Functional Requirements — PRD Design Comuni (Tema Sixteen)

**Pagine Statiche (FR-1.1–1.5):**
- FR-1.1: Homepage `/it/tests/homepage` — Critical
- FR-1.2: Argomenti `/it/tests/argomenti` — Critical
- FR-1.3: FAQ `/it/tests/faq` — High
- FR-1.4: Ricerca `/it/tests/ricerca` — High
- FR-1.5: Mappa Sito `/it/tests/mappa-sito` — Medium

**Amministrazione (FR-2.1–2.2):**
- FR-2.1: Amministrazione — Critical
- FR-2.2: Documenti e Dati — High

**Novità (FR-3.1–3.2):**
- FR-3.1: Novità — Critical
- FR-3.2: Dettaglio Notizia — High

**Servizi (FR-4.1–4.3):**
- FR-4.1: Servizi — Critical
- FR-4.2: Categoria Servizio — High
- FR-4.3: Dettaglio Servizio — Critical

**Vivere il Comune (FR-5.1–5.2):**
- FR-5.1: Eventi — Critical
- FR-5.2: Dettaglio Evento — High

**Prenotazione Appuntamento (FR-6.1–6.8):**
- FR-6.1: Step 1 Ufficio — High
- FR-6.2: Step 1 Luogo — Medium
- FR-6.3: Step 2 Data/Ora — High
- FR-6.4: Step 3 Dettagli — High
- FR-6.5: Step 4 Richiedente — Medium
- FR-6.6: Step 4 Auth — Medium
- FR-6.7: Step 5 Riepilogo — High
- FR-6.8: Step 6 Conferma — High

**Richiesta Assistenza (FR-7.1–7.2):**
- FR-7.1: Step 1 Dati — Medium
- FR-7.2: Step 2 Conferma — Medium

**Segnalazione Disservizio (FR-8.1–8.7):**
- FR-8.1: Dettaglio Servizio — High
- FR-8.2: Step 1 Privacy — Medium
- FR-8.3: Step 2 Dati — High
- FR-8.4: Step 3 Riepilogo — Medium
- FR-8.5: Step 4 Conferma — High
- FR-8.6: Area Personale — Medium
- FR-8.7: Elenco Segnalazioni — Medium

**Totale FRs Design Comuni: 31**

**TOTALE FRs COMBINATI: 104**

---

### Non-Functional Requirements — PRD Principale

- NFR-001: TTFB < 200ms (attuale 780ms)
- NFR-002: Page load < 2s
- NFR-003: API response < 100ms (p95)
- NFR-004: Supporto 1000+ utenti concorrenti
- NFR-005: Database query < 50ms (p95)
- NFR-010: Horizontal scaling ready
- NFR-011: Database read replicas
- NFR-012: Cache stratification (Redis)
- NFR-013: Queue-based processing
- NFR-014: CDN integration
- NFR-020: OWASP Top 10 compliance
- NFR-021: CSRF protection
- NFR-022: XSS prevention
- NFR-023: SQL injection prevention
- NFR-024: Rate limiting API
- NFR-025: Audit logging completo
- NFR-026: GDPR compliance
- NFR-030: Uptime 99.9%
- NFR-031: Backup automatico giornaliero
- NFR-032: Disaster recovery plan
- NFR-033: Monitoring e alerting
- NFR-034: Health check endpoints
- NFR-040: PHPStan Level 10
- NFR-041: Test coverage > 85%
- NFR-042: Code coverage > 90%
- NFR-043: Documentation completeness
- NFR-044: CI/CD pipeline
- NFR-045: Automated quality gates
- NFR-050: WCAG 2.1 AA accessibility
- NFR-051: Mobile responsive
- NFR-052: Multi-language support
- NFR-053: Intuitive UX
- NFR-054: Onboarding utenti

**Totale NFRs PRD principale: 33**

### Non-Functional Requirements — PRD Design Comuni

- NFR-DC-1: First Contentful Paint < 1.5s
- NFR-DC-2: Time to Interactive < 3.0s
- NFR-DC-3: Cumulative Layout Shift < 0.1
- NFR-DC-4: Total Blocking Time < 200ms
- NFR-DC-5: Lighthouse Score > 90
- NFR-DC-6: WCAG 2.1 Level AA completo (ARIA, keyboard, focus, skip links, 4.5:1 contrast, screen reader)
- NFR-DC-7: PHPStan Level 10
- NFR-DC-8: Pest Tests 80%+ coverage
- NFR-DC-9: PSR-12 compliance (Pint)
- NFR-DC-10: DRY / KISS / SOLID principles
- NFR-DC-11: JSON Content separation (dati/view)
- NFR-DC-12: Reusable blocks (no page-specific code)

**Totale NFRs Design Comuni: 12**

**TOTALE NFRs COMBINATI: 45**

### PRD Completeness Assessment

**PRD Principale:**
- ✅ Requisiti funzionali strutturati e numerati
- ✅ NFRs con target misurabili
- ⚠️ Sezione User Personas marcata "To be expanded"
- ⚠️ Sezione Module Dependencies marcata "To be expanded"
- ⚠️ Sezione Database Schema marcata "To be expanded"
- ⚠️ API requirements mancano rate limit specifici, versioning strategy, deprecation policy

**PRD Design Comuni:**
- ✅ Scope chiarissimo (38 pagine specifiche)
- ✅ Personas definite (3 profili)
- ✅ Definition of Done per-page e overall
- ✅ Design system colori/tipografia documentato
- ✅ Architettura JSON content ben definita
- ⚠️ Manca sprint planning integrato (è in documento separato)


---

## Epic Coverage Validation

### Nota Metodologica Importante

Il progetto ha **due set paralleli di epics**:

1. **epics-and-stories.md** — Epics per il miglioramento del sistema esistente (technical debt, performance, testing, sicurezza). **Non copre i FRs funzionali** perché il sistema è brownfield e le feature sono già implementate nel codebase.
2. **design-comuni-epics.md** — Epics per la nuova feature "Tema Design Comuni Italia" (38 pagine statiche). Copre tutti i FRs del PRD Design Comuni.

---

### Coverage Matrix — PRD Principale (epics-and-stories.md)

| FR | Requisito | Copertura Epic | Stato |
|----|-----------|----------------|-------|
| FR-001–007 | Gestione Segnalazioni | Nessuna (già implementato nel codebase) | ⚠️ ASSUNTO |
| FR-010–014 | Gestione Utenti | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-020–023 | Multi-Tenancy | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-030–033 | CMS | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-040–044 | Blog | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-050–055 | Notifiche | EPIC-004 (US-004.03 test) + già impl. | ⚠️ PARZIALE |
| FR-060–063 | Geolocalizzazione | EPIC-004 (US-004.04 test) + già impl. | ⚠️ PARZIALE |
| FR-070–074 | Media Management | EPIC-004 (US-004.05 test) + già impl. | ⚠️ PARZIALE |
| FR-080–083 | Activity Logging | EPIC-009 (monitoring) parziale | ⚠️ PARZIALE |
| FR-090–094 | GDPR | EPIC-004 (US-004.06) + EPIC-010 | ✓ COPERTO |
| FR-100–103 | Localizzazione | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-110–114 | SEO | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-120–123 | Rating | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-130–134 | AI | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-200–204 | Admin Dashboard | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-210–214 | Resource Management | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-220–223 | Actions & Operations | Nessuna (già implementato) | ⚠️ ASSUNTO |
| FR-300–304 | REST API | EPIC-003 (full) + EPIC-006 (rate limit) | ✓ COPERTO |
| FR-310–313 | Webhooks | Nessuna | ❌ MANCANTE |

**Legenda:**
- ✓ COPERTO = epic esplicito esiste
- ⚠️ ASSUNTO = presupposto già implementato, nessun epic per verifica
- ❌ MANCANTE = nessuna copertura, non risulta implementato

---

### Coverage Matrix — PRD Design Comuni (design-comuni-epics.md)

| FR | Pagina | Epic/Story | Stato |
|----|--------|-----------|-------|
| FR-1.1 | Homepage | EPIC-4: STORY-4.1, 4.2, 4.3 | ✓ COPERTO |
| FR-1.2 | Argomenti | EPIC-5: STORY-5.1, 5.2 | ✓ COPERTO |
| FR-1.3 | FAQ | **Nessuna story dedicata** | ❌ MANCANTE |
| FR-1.4 | Ricerca | STORY-3.7 (search form block) ma no pagina | ❌ PARZIALE |
| FR-1.5 | Mappa Sito | **Nessuna story dedicata** | ❌ MANCANTE |
| FR-2.1 | Amministrazione | EPIC-6: STORY-6.1, 6.2 | ✓ COPERTO |
| FR-2.2 | Documenti e Dati | EPIC-6: STORY-6.3 | ✓ COPERTO |
| FR-3.1 | Novità (lista) | EPIC-7: STORY-7.1, 7.2 | ✓ COPERTO |
| FR-3.2 | Dettaglio Notizia | EPIC-7: STORY-7.2 (parziale) | ⚠️ PARZIALE |
| FR-4.1 | Servizi (lista) | EPIC-8: STORY-8.1, 8.2 | ✓ COPERTO |
| FR-4.2 | Categoria Servizio | **Nessuna story dedicata** | ❌ MANCANTE |
| FR-4.3 | Dettaglio Servizio | EPIC-8: STORY-8.3, 8.4 | ✓ COPERTO |
| FR-5.1 | Eventi (lista) | EPIC-7: STORY-7.3, 7.4 | ✓ COPERTO |
| FR-5.2 | Dettaglio Evento | **Nessuna story dedicata** | ❌ MANCANTE |
| FR-6.1–6.8 | Appuntamento (8 step) | EPIC-9: STORY-9.1 → 9.8 | ✓ COPERTO |
| FR-7.1–7.2 | Assistenza (2 step) | EPIC-10: STORY-10.1, 10.2 | ✓ COPERTO |
| FR-8.1–8.7 | Segnalazione (7 step) | EPIC-10: STORY-10.3 → 10.9 | ✓ COPERTO |

---

### Missing Requirements Summary

#### ❌ CRITICI — FR non coperti da nessun epic

**PRD Principale:**
- **FR-310–313 (Webhooks)**: Nessuna copertura — né implementazione esistente documentata, né epic pianificato
  - Impact: FR-302 del PRD richiede webhooks per integrazioni esterne
  - Raccomandazione: Aggiungere epic dedicato o verificare se già implementato

**PRD Design Comuni (5 pagine mancanti):**
- **FR-1.3 FAQ**: Nessuna story dedicata — è una delle pagine "standard" di Design Comuni
  - Raccomandazione: Aggiungere STORY-X nella sprint allocation EPIC-5 o nuovo EPIC-13
- **FR-1.4 Ricerca (pagina completa)**: Solo block component, mancano JSON + HTML completi
  - Raccomandazione: STORY dedicata in EPIC-5 o nuovo epic
- **FR-1.5 Mappa Sito**: Nessuna copertura
  - Raccomandazione: Aggiungere story a bassa priorità
- **FR-4.2 Categoria Servizio**: Pagina lista servizi per categoria — manca
  - Raccomandazione: Aggiungere STORY-8.5 in EPIC-8
- **FR-5.2 Dettaglio Evento**: Pagina dettaglio singolo evento — manca
  - Raccomandazione: Aggiungere STORY-7.5 in EPIC-7

#### ⚠️ RISCHIO — FRs "assunti" senza verifica

73 FRs del PRD principale sono marcati "già implementato" senza verifica esplicita. Il rischio è che alcune feature esistano ma abbiano regressioni o gaps. EPIC-004 (test coverage) copre parzialmente questo rischio ma non sistematicamente.

---

### Coverage Statistics

**PRD Principale:**
- Total PRD FRs: 73
- FRs esplicitamente coperti da epic: 8 (FR-090–094, FR-300–304)
- FRs assunti come già implementati: 64
- FRs mancanti: 1 set (FR-310–313 Webhooks)
- Copertura esplicita: **11%** (brownfield — intenzionale)
- Rischio per mancanza di verifica: **MEDIO**

**PRD Design Comuni:**
- Total PRD FRs: 31
- FRs coperti: 24
- FRs mancanti/parziali: 7
- Copertura: **77%** ⚠️

**Copertura complessiva: 87% dei FRs Design Comuni + sistema esistente non verificato**


---

## UX Alignment Assessment

### UX Document Status

✅ **Due documenti UX trovati:**
1. `_bmad-output/ui-spec.md` — FixCity Platform UX (admin + citizen portal)
2. `_bmad-output/design-comuni-ui-spec.md` — Design Comuni Italia UX (47 componenti)

---

### Allineamento UX ↔ PRD

#### ui-spec.md (FixCity Platform) ↔ prd.md

| Area | PRD Requirement | UX Copertura | Allineamento |
|------|----------------|--------------|-------------|
| Design system | NFR-050 WCAG 2.1 AA | ✅ Principio #2 esplicito | ✓ |
| Mobile-first | UX-001 | ✅ Principio #1 esplicito | ✓ |
| Palette colori | UX-003 (consistent design) | ✅ Palette Tailwind completa | ✓ |
| Componenti form | FR-001 segnalazione | ✅ FileUpload, TextInput, Select | ✓ |
| Card Ticket | FR-005 workflow stati | ✅ Status badge per stato | ✓ |
| Modal | FR-220 azioni con modal | ✅ Componente Alpine.js | ✓ |
| Performance | NFR-004 UX fast perceived | ⚠️ Menzionato come principio ma no metriche UX specifiche | ⚠️ |
| User Personas | PRD sez 2.3 "To be expanded" | ❌ Nessuna persona nel ui-spec | ❌ |

#### design-comuni-ui-spec.md ↔ design-comuni-prd.md

| Area | PRD Requirement | UX Copertura | Allineamento |
|------|----------------|--------------|-------------|
| 47 componenti identificati | 38 pagine da replicare | ✅ Catalogo completo per tier | ✓ |
| Accessibilità | NFR-DC-2 WCAG 2.1 AA | ✅ Documentato per ogni componente | ✓ |
| Typography | Design Comuni standard | ✅ Titillium Web + Lato | ✓ |
| Colori Bootstrap Italia | NFR-DC-4 (visual parity) | ✅ Palette `--it-*` completa | ✓ |
| Responsive | NFR-DC-1 Performance | ✅ Mobile-first documentato | ✓ |
| Spacing Bootstrap→Tailwind | HTML parity | ✅ Mapping completo | ✓ |

---

### Allineamento UX ↔ Architecture

| Requisito UX | Supporto Architetturale | Stato |
|-------------|------------------------|-------|
| Tailwind CSS v4 | Architecture include Tailwind v4 | ✓ |
| Alpine.js (x-data) | Incluso nel stack via Livewire | ✓ |
| Vite build per assets | STORY-1.5 + EPIC-002 (US-002.05) | ✓ |
| Folio + Volt per pagine pubbliche | Architecture layer "Presentation" | ✓ |
| Filament v5 per admin | Architecture esplicita | ✓ |
| Flux UI v2 components | Listato nel tech stack PRD | ✓ |
| `x-layouts.app` layout | STORY-1.3 sistema rendering | ✓ |

---

### Problemi di Allineamento

#### ⚠️ GAP CRITICO — Componenti UX vs Stories

`design-comuni-ui-spec.md` identifica **47 componenti** divisi in 5 tier.  
`design-comuni-epics.md` EPIC-3 copre solo **10 block types** (STORY-3.1–3.10).

Componenti UX con nessuna story corrispondente:
- **Tier 2 Navigation** (5 componenti): cmp-navscroll, cmp-nav-steps, cmp-info-progress, cmp-nav-tab, cmp-category-list
- **Tier 3 Forms** (10 componenti): cmp-input, cmp-select, cmp-text-area, cmp-info-button-card, cmp-info-summary, cmp-callout, ecc.
- **Tier 4 Cards** (12 componenti): cmp-card-simple, cmp-card-teaser, cmp-list-card-img-hr, cmp-tag, ecc.
- **Tier 5 Specialized** (13 componenti): cmp-accordion, cmp-modal, cmp-map, cmp-carousel, ecc.

👉 **37 dei 47 componenti UX non hanno stories dedicate** — sono assunti come impliciti nelle page stories, ma questo aumenta il rischio di sotto-stima degli effort.

#### ⚠️ Design System Conflict — Due Palette Diverse

- **Platform (ui-spec.md)**: Usa Inter font + primary blue `#3b82f6` (FixCity brand)
- **Design Comuni (design-comuni-ui-spec.md)**: Usa Titillium Web/Lato + `#0066CC` (Bootstrap Italia)

Questo è corretto (sono due UI distinte), ma l'architettura deve gestire due temi separati — non è esplicitato nell'architecture document principale.

#### ℹ️ Minor — UX principale manca metriche specifiche

`ui-spec.md` cita "Fast perceived performance" come principio ma non definisce metriche UX specifiche (Interaction latency, animation thresholds). Questo è coperto dai NFR del PRD principale.

---

### Warnings

1. ⚠️ **37 componenti UX senza stories**: Richiedono effort nascosto nelle page stories
2. ⚠️ **Dual design system non documentato in Architecture**: Due temi (FixCity + Design Comuni) devono coesistere
3. ℹ️ **User Personas incomplete nel PRD principale**: Impatta decisioni UX future


---

## Epic Quality Review

### Review Scope

Applicati gli standard `create-epics-and-stories` a entrambi i documenti epics.

---

### Epics Quality — epics-and-stories.md (FixCity Platform)

#### 🔴 VIOLAZIONE CRITICA: Tutti gli Epic sono Technical Milestones

**Standard violato:** Gli epics devono consegnare user value, non essere milestone tecniche.

| Epic | Titolo | Tipo | User Value | Violazione |
|------|--------|------|-----------|-----------|
| EPIC-001 | Migration Cleanup | ❌ Tecnico | Zero diretto | Technical milestone |
| EPIC-002 | Performance Optimization | ❌ Tecnico | Indiretto | Technical milestone |
| EPIC-003 | API Documentation | ❌ Tecnico | Solo dev | Technical milestone |
| EPIC-004 | Test Coverage Improvement | ❌ Tecnico | Zero | Technical milestone |
| EPIC-005 | Documentation Consolidation | ❌ Tecnico | Zero | Technical milestone |
| EPIC-006 | Rate Limiting | ⚠️ Infra | Indiretto | Infrastructure epic |
| EPIC-007 | Backup Strategy | ❌ Tecnico | Zero diretto | Technical milestone |
| EPIC-008 | Browser Testing Suite | ❌ Tecnico | Zero | Technical milestone |
| EPIC-009 | Monitoring Enhancement | ❌ Tecnico | Zero diretto | Technical milestone |
| EPIC-010 | Security Hardening | ⚠️ Infra | Indiretto | Infrastructure epic |

**Contesto attenuante:** Progetto brownfield focalizzato su riduzione technical debt — gli epic sono intenzionalmente tecnici. Il valore utente è consegnato dall'applicazione già esistente. **Accettabile per contesto brownfield**, ma strutturalmente non conforme agli standard.

**Raccomandazione:** Aggiungere una sezione "Business Value" esplicita per ogni epic che spieghi il beneficio utente indiretto.

---

#### 🔴 VIOLAZIONE: User Stories con ruolo "developer/DBA" non utenti finali

Esempi di violazioni in EPIC-001:
- `As a developer I want to identify all duplicate migrations` — non è una user story
- `As a DBA I want to safely execute the cleanup` — utente interno tecnico
- `As a DevOps engineer I want sessions stored in Redis` — tecnico

**Standard violato:** Le user stories devono avere "As a [end user type]" non ruoli tecnici.

**Eccezione:** Per epics di technical debt in brownfield, è accettabile usare "As a developer/DBA" se esplicitamente marcato come "Technical Story" (non User Story).

**Raccomandazione:** Marcare gli epic EPIC-001/002/003/004/005/007/008/009 come "**Technical Epics**" e le stories come "**Technical Stories**" per distinguerle dalle user stories proper.

---

#### ⚠️ PROBLEMA: Acceptance Criteria senza formato Given/When/Then

Quasi tutte le stories usano checklist `[ ]` invece del formato BDD standard:

```
❌ Attuale:
- [ ] All N+1 queries identified
- [ ] Eager loading implemented

✓ Corretto (BDD):
Given the ticket list page is loaded
When the page renders
Then only 2 queries are executed (tickets + users)
```

Questo limita la testabilità e la chiarezza. Le stories con codice PHP/SQL embedded (US-002.02, US-002.03) sono più una guida implementativa che criteri di accettazione.

---

#### ✅ POSITIVO: Indipendenza degli Epic

Gli epic sono strutturalmente indipendenti:
- EPIC-001 si può completare senza dipendere da EPIC-002
- EPIC-002 non dipende dal completamento di EPIC-003
- EPIC-006 (Rate Limiting) dovrebbe logicamente seguire EPIC-003 (API Documentation) ma non è dipendente tecnicamente
- Sprint plan rispetta un ordine logico ✓

---

#### ✅ POSITIVO: Sizing stories

Stories correttamente sized:
- Range 2–8 punti ✓
- Nessuna story > 8 punti ✓
- Epic EPIC-002 US-002.02 (8 pts) al limite — accettabile

---

### Epics Quality — design-comuni-epics.md (Design Comuni)

#### 🔴 VIOLAZIONE: EPIC-1 e EPIC-3 sono Technical Epics

**EPIC-1: Foundation Setup** — nessun utente finale può beneficiare dell'epic standalone. Routing Folio, JSON structure, Block rendering — puramente tecnico.

**EPIC-3: Block Components** — implementare block types non consegna valore utente standalone; gli utenti vedono le pagine, non i componenti singoli.

**Raccomandazione:** EPIC-1 e EPIC-3 potrebbero essere inglobati come "Sprint 0 Technical Foundation" o marcati come "Enabling Epics" con note esplicite.

---

#### ⚠️ DIPENDENZE FORWARD in EPIC-9 (Appuntamento Wizard)

Le 8 stories del wizard sono strettamente sequenziali. STORY-9.2 dipende da STORY-9.1 (step precedente), STORY-9.3 da STORY-9.2, ecc. Questo crea una catena di dipendenze forward:

```
STORY-9.1 → STORY-9.2 → STORY-9.3 → ... → STORY-9.8
```

**Standard violato:** Stories devono essere il più indipendenti possibile.

**Contesto attenuante:** Un multi-step wizard ha dipendenze sequenziali per natura. Le stories rappresentano gli step del wizard, non features indipendenti.

**Raccomandazione:** Ristrutturare come: STORY-9.1 "Wizard Shell + Step 1", poi aggiungere step come enhancement stories con dipendenza esplicita documentata.

---

#### ⚠️ MISSING Acceptance Criteria nelle stories di EPIC-5 → EPIC-10

A partire da STORY-5.1, le stories hanno solo "Description" senza Acceptance Criteria completi. Esempio:

```
### STORY-5.1: Create Argomenti JSON
**Description:** Creare JSON content per pagina Argomenti
(nessun AC, nessun tasks, nessun test)
```

Solo le prime stories (EPIC-1, EPIC-2, EPIC-3, EPIC-4) hanno AC completi. Circa il **65% delle stories** (40/62) mancano di Acceptance Criteria.

**Impatto:** ALTO — le storie non sono implementabili senza AC chiari.

---

#### ✅ POSITIVO: Sprint allocation rispetta dipendenze

La sprint allocation (Sprint 1: Foundation + Header/Footer, Sprint 2: Block Components, Sprint 3–5: Pages, Sprint 6: QA) rispetta correttamente l'ordine delle dipendenze. ✓

---

#### ✅ POSITIVO: Stories con codice di implementazione (EPIC-1, EPIC-2)

Le prime stories includono implementazioni PHP complete (ThemeDetection, Vite config, JSON structure). Questo è eccellente per chiarezza implementativa, anche se tecnicamente è "too detailed" per uno standard user story. Per l'ambito di questo progetto è appropriato.

---

### Best Practices Compliance Checklist

| Criterio | epics-and-stories.md | design-comuni-epics.md |
|----------|----------------------|------------------------|
| Epic consegna user value | ❌ (contesto brownfield) | ⚠️ (2 epic tecnici) |
| Epic indipendente | ✅ | ✅ (con eccezione wizard) |
| Stories con user value | ❌ (tech stories) | ✅ (page stories) |
| No forward dependencies | ✅ | ⚠️ (wizard sequenziale) |
| Acceptance Criteria completi | ⚠️ (no BDD format) | ❌ (65% mancanti) |
| Stories testabili | ⚠️ | ❌ (no AC) |
| Traceability a FRs | ⚠️ (implicita) | ✅ |
| Sizing appropriato | ✅ | ✅ |

---

### Riepilogo Violazioni Qualità

#### 🔴 Critiche (blocca implementazione)
1. **65% stories Design Comuni senza Acceptance Criteria** — impossibile verificare completamento
2. **epics-and-stories.md**: tutti gli epic sono technical, le stories non seguono formato user story

#### 🟠 Maggiori (impatta qualità)
3. **Nessuna story usa formato BDD Given/When/Then**
4. **37 componenti UX (di 47) senza stories dedicate** nel Design Comuni
5. **5 pagine Design Comuni senza copertura** (FAQ, Ricerca, Mappa Sito, Categoria Servizio, Dettaglio Evento)
6. **FR-310–313 Webhooks senza epic né implementazione nota**

#### 🟡 Minori
7. Forward dependencies in EPIC-9 wizard non documentate esplicitamente
8. User personas incomplete nel PRD principale
9. EPIC-1 e EPIC-3 sono enabling epics mascherati da feature epics


---

## Summary and Recommendations

### Overall Readiness Status

## ⚠️ NEEDS WORK — Implementazione può iniziare su Sprint 1 con le azioni correttive indicate

Il progetto ha una solida base documentale. I problemi identificati non bloccano l'inizio dello sviluppo per Sprint 1 (Migration Cleanup), ma devono essere risolti prima di entrare nelle stories del Design Comuni e nelle feature avanzate.

---

### Scorecard Finale

| Area | Stato | Score |
|------|-------|-------|
| Documentazione completa | ✅ Tutti i documenti presenti | 9/10 |
| Copertura FRs (Design Comuni) | ⚠️ 5 pagine mancanti | 6/10 |
| Copertura FRs (Platform) | ⚠️ Brownfield assunto, Webhooks mancanti | 7/10 |
| Allineamento UX | ✅ Allineato, con gap componenti | 7/10 |
| Qualità Epic (Platform) | ⚠️ Technical epics in contesto brownfield | 6/10 |
| Qualità Epic (Design Comuni) | ❌ 65% stories senza AC | 4/10 |
| Acceptance Criteria | ❌ Quasi assenti nelle stories DC | 3/10 |
| Dipendenze | ✅ Gestite correttamente | 8/10 |

**Score complessivo: 6.25/10 — NEEDS WORK**

---

### Problemi Critici (Azione Immediata Richiesta)

#### 1. 🔴 65% Stories Design Comuni senza Acceptance Criteria
**Problema:** 40 stories su 62 nel design-comuni-epics.md hanno solo Description, senza AC.  
**Impatto:** Impossibile verificare completamento, rischio di rework, scope ambiguo.  
**Azione:** Prima di eseguire ogni story (EPIC-4 in poi), definire AC minimi con: cosa il componente renderizza, url di test, screenshot comparison attesa.

#### 2. 🔴 5 Pagine Design Comuni non hanno stories
**Problema:** FAQ (FR-1.3), Ricerca pagina completa (FR-1.4), Mappa Sito (FR-1.5), Categoria Servizio (FR-4.2), Dettaglio Evento (FR-5.2).  
**Impatto:** 5 delle 38 pagine del PRD non hanno implementazione pianificata.  
**Azione:** Aggiungere 5 stories prima di Sprint 3 (pagine core).

#### 3. 🔴 37 Componenti UX senza stories dedicate
**Problema:** UX spec identifica 47 componenti; epics copre solo 10 block types.  
**Impatto:** Effort nascosto significativo (potenzialmente 3–5 sprint points per componente = 50–100 punti extra non pianificati).  
**Azione:** Fare discovery meeting per decidere quali componenti sono necessari per le 38 pagine e aggiungere stories stimate.

---

### Problemi Maggiori (Risolvere entro Sprint 2)

#### 4. 🟠 FR-310–313 Webhooks senza copertura
**Problema:** Il PRD richiede webhooks (FR-310–313) ma nessun epic li copre.  
**Azione:** Verificare se già implementati nel codebase; se no, creare EPIC-011 Webhooks.

#### 5. 🟠 epics-and-stories.md: stories con ruolo developer, non user
**Problema:** User stories con "As a developer" sono technical stories.  
**Azione:** Marcare esplicitamente EPIC-001 → EPIC-009 come "Technical Epics" nel documento per evitare confusione.

#### 6. 🟠 Nessuna Acceptance Criteria in formato BDD
**Problema:** Tutte le stories usano checklist invece di Given/When/Then.  
**Azione:** Non blocca Sprint 1 (le stories hanno task chiari), ma le stories future devono avere BDD AC.

---

### Problemi Minori (Risolvere durante implementation)

7. 🟡 User Personas incomplete nel PRD principale (sezione marcata "To be expanded")
8. 🟡 EPIC-1 e EPIC-3 (Design Comuni) sono enabling epics non user-facing — documentare esplicitamente
9. 🟡 Forward dependencies in EPIC-9 wizard non documentate esplicitamente
10. 🟡 Dual design system (FixCity blue vs Italia blue) non documentato nell'architecture document

---

### Passi Raccomandati

#### Immediati (prima di iniziare Sprint 1 - oggi):
1. ✅ **Inizia Sprint 1** — Le stories US-001.01–001.08 sono sufficientemente chiare per procedere

#### Entro fine Sprint 1 (14 aprile):
2. **Aggiungi 5 stories mancanti** per le pagine Design Comuni (FAQ, Ricerca, Mappa Sito, Categoria Servizio, Dettaglio Evento)
3. **Verifica Webhooks** nel codebase esistente — se mancanti, aggiungi epic
4. **Marca gli epics Platform come "Technical Epics"**

#### Prima di Sprint 3 (Design Comuni pages):
5. **Completa gli Acceptance Criteria** per tutte le stories EPIC-4 → EPIC-10 nel design-comuni-epics.md
6. **Sessione di discovery componenti** per determinare quali dei 37 componenti mancanti sono necessari e stimarli

#### Ongoing:
7. **Usa formato BDD** per le nuove stories create durante il progetto
8. **Aggiorna User Personas** nel PRD principale con 3-5 profili reali

---

### Note Finali

Questo assessment ha identificato **10 problemi** in **4 categorie** (copertura FR, qualità AC, componenti UX, struttura epics).

Il progetto può procedere con **Sprint 1** immediatamente. I problemi critici riguardano principalmente il Design Comuni workflow (Sprint 3+) e possono essere risolti nei prossimi 2 sprint senza bloccare lo sviluppo corrente.

La documentazione è complessivamente di buona qualità per un progetto brownfield di questa complessità. La base architetturale è solida e ben documentata.

---

**Assessment completato:** 2026-04-03  
**Assessor:** BMad Implementation Readiness Agent  
**Report:** `_bmad-output/planning-artifacts/implementation-readiness-report-2026-04-03.md`

