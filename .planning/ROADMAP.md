# Roadmap: PTVX Fila5 Mono

**Created:** 2026-03-18  
**Core Value:** Provide Italian Public Administrations with a compliant, automated system for managing the complete employee performance evaluation cycle  
**Total Phases:** 10  
**Granularity:** Fine (68 requirements across 10 phases)

---

## Phase Overview

| Phase | Name | Requirements | Status |
|-------|------|--------------|--------|
| 1 | Foundation & Compliance Hardening | AUDT-01..05 | ○ Pending |
| 2 | Core Calculation Engine | INDN-01..06 | ○ Pending |
| 3 | Performance Evaluation Workflow | PERF-01..10 | ○ Pending |
| 4 | Employee Self-Service Portal | ESS-01..08 | ○ Pending |
| 5 | Manager Dashboard | MGR-01..07 | ○ Pending |
| 6 | Transparency Portal | TRSP-01..05 | ○ Pending |
| 7 | Integration & API Standardization | INTG-01..05 | ○ Pending |
| 8 | Queue & Reliability | RLBL-01..04 | ○ Pending |
| 9 | Absence & Time Management | ATND-01..06 | ○ Pending |
| 10 | Career Progression & Reporting | CARR-01..05 | ○ Pending |

---

## Phase 1: Foundation & Compliance Hardening

**Goal:** Ensure system is compliant-auditable and prevents critical pitfalls

**Why First:** Audit trail and compliance are foundational — all other features depend on accurate logging and data integrity. Research identified incomplete audit trails as CRITICAL pitfall.

**Requirements:**
- AUDT-01: System logs all data changes with before/after values
- AUDT-02: System logs all user actions (who did what when)
- AUDT-03: System maintains GDPR-compliant data export
- AUDT-04: System implements data retention policies
- AUDT-05: System provides audit trail report for compliance reviews

**Key Deliverables:**
- Activity module enhanced with complete field-level logging
- GDPR export endpoint (complete data package)
- Data retention policy enforcement (automatic archival/deletion)
- Audit trail report generator
- Compliance dashboard for HR administrators

**Pitfalls Addressed:**
- Incomplete audit trail (properties vuote)
- GDPR data export incompleteness
- Missing data retention enforcement

**Dependencies:** None (foundational)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify GDPR export includes all related records (evaluations, indemnities, attendance)
- ⚠️ Test retention policies with large datasets (1000+ employees)

---

## Phase 2: Core Calculation Engine

**Goal:** Ensure all monetary calculations are accurate and auditable

**Why Second:** Indemnity calculations are high-risk (legal compliance, employee trust). Research identified floating-point drift as CRITICAL pitfall.

**Requirements:**
- INDN-01: System uses BCMath/Decimal for all monetary calculations (no float)
- INDN-02: System stores calculation formula version with each record
- INDN-03: System applies CCNL rates correctly (seniority-based)
- INDN-04: System calculates Law 104 permits accurately (3 days/month)
- INDN-05: System generates monthly indemnity report for payroll
- INDN-06: System maintains audit trail for all calculation changes

**Key Deliverables:**
- BCMath calculation layer (replace all float operations)
- Formula versioning system
- CCNL rate engine (seniority-based lookup)
- Law 104 permit calculator
- Monthly payroll export (Excel/CSV)
- Calculation audit trail viewer

**Pitfalls Addressed:**
- Floating-point calculation drift
- Hardcoded regulatory percentages
- Law 104 permit calculation errors
- Missing calculation audit trail

**Dependencies:** Phase 1 (audit trail infrastructure)

**Estimated Complexity:** High

**Research Flags:**
- ⚠️ Audit all existing calculation code for float usage
- ⚠️ Test with edge cases (fractional hours, overlapping permits)
- ⚠️ Verify CCNL rates match current national contract

---

## Phase 3: Performance Evaluation Workflow

**Goal:** Complete, compliant performance evaluation cycle management

**Why Third:** Core domain functionality — this is the primary value proposition. Must have audit trail (Phase 1) and accurate calculations (Phase 2) first.

**Requirements:**
- PERF-01: System enforces evaluation timeline (start/end dates, deadlines)
- PERF-02: System tracks intermediate colloquies (mandatory per D.Lgs. 150/2009)
- PERF-03: System prevents evaluator conflict of interest
- PERF-04: System enforces evaluation differentiation (no all-max scores)
- PERF-05: Employee can submit self-evaluation
- PERF-06: Evaluator can complete evaluation form with criteria scoring
- PERF-07: System calculates final score automatically
- PERF-08: Employee can appeal evaluation within configured period
- PERF-09: HR can generate SMVP (Scheda Misura Valutazione Performance)
- PERF-10: System generates PDF evaluation document

**Key Deliverables:**
- Evaluation cycle configuration (timeline, evaluators, criteria)
- Intermediate colloquy tracker (mandatory meetings log)
- Conflict of interest checker
- Differentiation enforcement (score distribution rules)
- Self-evaluation form
- Evaluator form with criteria scoring
- Automatic score calculator
- Appeal workflow
- SMVP generator
- PDF evaluation document generator

**Pitfalls Addressed:**
- Performance evaluation timeline misalignment
- Missing intermediate colloquies (D.Lgs. 150/2009 compliance gap)
- Evaluator conflict of interest
- All-max scores (no differentiation)
- Manual SMVP compilation errors

**Dependencies:** Phase 1 (audit trail), Phase 2 (calculation engine)

**Estimated Complexity:** High

**Research Flags:**
- ⚠️ Verify SMVP format matches latest performance.gov.it guidelines
- ⚠️ Test differentiation rules with various organizational sizes
- ⚠️ Confirm appeal period configuration matches CCNL requirements

---

## Phase 4: Employee Self-Service Portal

**Goal:** Employees can access own HR data without HR intermediary

**Why Fourth:** Research identified this as P1 critical gap. Employees currently cannot view own data — major usability issue. Depends on audit trail (Phase 1) for access logging.

**Requirements:**
- ESS-01: Employee can view own performance evaluations (current and historical)
- ESS-02: Employee can view own indemnities and bonuses breakdown
- ESS-03: Employee can view own absence/presence records
- ESS-04: Employee can view own career progression history
- ESS-05: Employee can download PDF certificates (GDPR export)
- ESS-06: Employee can update own contact information
- ESS-07: Employee can view assigned training courses
- ESS-08: Employee can submit self-evaluation for performance cycle

**Key Deliverables:**
- Employee dashboard (personalized overview)
- Evaluation history viewer
- Indemnities breakdown viewer
- Attendance calendar viewer
- Career progression timeline
- GDPR export generator (on-demand)
- Profile editor (contact info)
- Training course viewer
- Self-evaluation submission form

**Pitfalls Addressed:**
- Missing employee self-service (critical usability gap)
- Manual HR requests for basic data
- GDPR export delays

**Dependencies:** Phase 1 (audit trail for access logging), Phase 2 (calculation data), Phase 3 (evaluation data)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify access control prevents viewing other employees' data
- ⚠️ Test with multi-tenant isolation (cross-tenant access prevention)
- ⚠️ Confirm GDPR export includes all required data categories

---

## Phase 5: Manager Dashboard

**Goal:** Managers have tools to oversee team HR activities

**Why Fifth:** Research identified this as P1 compliance requirement. Managers need visibility into team performance, absences, evaluations. Depends on ESS data model (Phase 4).

**Requirements:**
- MGR-01: Manager can view team overview (direct reports count, status)
- MGR-02: Manager can view team performance evaluation progress
- MGR-03: Manager can initiate performance evaluation for direct reports
- MGR-04: Manager can view team absence/presence summary
- MGR-05: Manager can approve/reject team leave requests
- MGR-06: Manager can view team indemnities overview
- MGR-07: Manager can export team data to Excel/PDF

**Key Deliverables:**
- Manager dashboard (team overview widget)
- Evaluation progress tracker (completion status)
- Evaluation initiator (bulk start for team)
- Attendance summary report
- Leave request approval workflow
- Indemnities overview (aggregate view)
- Export generator (Excel/PDF)

**Pitfalls Addressed:**
- Missing manager visibility (compliance gap)
- Manual tracking of evaluation progress
- Delayed leave approvals

**Dependencies:** Phase 3 (evaluation workflow), Phase 4 (ESS data model)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify manager hierarchy correctly reflects organizational structure
- ⚠️ Test with large teams (50+ direct reports)
- ⚠️ Confirm leave approval workflow matches CCNL requirements

---

## Phase 6: Transparency Portal

**Goal:** Automatic publication of required data to public website

**Why Sixth:** Legal requirement (transparency laws), but depends on all core data being available (evaluations, indemnities, organizational structure).

**Requirements:**
- TRSP-01: System publishes performance evaluations to public website (anonymized)
- TRSP-02: System publishes bonus allocation to public website (anonymized)
- TRSP-03: System publishes CVs of management to public website
- TRSP-04: System publishes organizational chart to public website
- TRSP-05: Transparency data exported in open format (CSV/JSON)

**Key Deliverables:**
- Anonymization engine (remove personal identifiers)
- Public API/endpoint for website integration
- CSV/JSON export generator
- CV collection/management system
- Organizational chart viewer/exporter
- Publication scheduler (automatic timing)

**Pitfalls Addressed:**
- Manual transparency publication (error-prone)
- Inconsistent anonymization
- Missing publication deadlines

**Dependencies:** Phase 3 (evaluation data), Phase 2 (bonus data), Phase 10 (organizational structure)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify anonymization meets GDPR requirements
- ⚠️ Confirm publication timing matches legal deadlines
- ⚠️ Test export formats with transparency.gov.it requirements

---

## Phase 7: Integration & API Standardization

**Goal:** Standardized APIs for PA ecosystem integration

**Why Seventh:** Integrations are important but depend on stable internal APIs. Research identified missing OpenAPI documentation as critical gap.

**Requirements:**
- INTG-01: System exposes OpenAPI documentation for all endpoints
- INTG-02: System integrates with Sigma (stipendi) via API
- INTG-03: System integrates with Europa (EU funds) tracking
- INTG-04: System integrates with Pdnd (Piattaforma Digitale Nazionale Dati)
- INTG-05: System sends INAIL injury reports within legal deadline (2-5 days)

**Key Deliverables:**
- OpenAPI documentation generator
- API versioning system
- Sigma connector (payroll integration)
- Europa connector (EU funds tracking)
- Pdnd connector (national data platform)
- INAIL injury report sender (automated)
- API authentication/authorization layer

**Pitfalls Addressed:**
- Missing API documentation (integration difficulty)
- Manual data entry for Sigma payroll
- Delayed INAIL reports (compliance risk)
- Custom integration per PA (not scalable)

**Dependencies:** Phase 1 (audit trail for API logging), Phase 2 (calculation data)

**Estimated Complexity:** High

**Research Flags:**
- ⚠️ Verify Sigma API specifications match current version
- ⚠️ Confirm Pdnd integration patterns follow developers.italia.it guidelines
- ⚠️ Test INAIL report timing (2-5 day deadline enforcement)

---

## Phase 8: Queue & Reliability

**Goal:** Robust background processing with monitoring

**Why Eighth:** Reliability improvements depend on knowing what jobs exist (from previous phases). Research identified database queue driver as suboptimal.

**Requirements:**
- RLBL-01: System uses Redis queue driver (not database)
- RLBL-02: System monitors failed jobs with alerts
- RLBL-03: System implements retry logic for external API calls
- RLBL-04: System generates daily queue health report

**Key Deliverables:**
- Redis queue configuration
- Laravel Horizon installation and configuration
- Failed job alerting (email/Slack)
- Retry logic layer (exponential backoff)
- Queue health dashboard
- Daily queue report generator

**Pitfalls Addressed:**
- Database queue driver (performance bottleneck)
- Silent job failures
- No retry logic for transient API failures
- Missing queue visibility

**Dependencies:** None (cross-cutting concern, but easier after other features exist)

**Estimated Complexity:** Low-Medium

**Research Flags:**
- ⚠️ Test Redis persistence configuration
- ⚠️ Verify alert routing (right people notified)
- ⚠️ Confirm retry logic doesn't duplicate external API calls

---

## Phase 9: Absence & Time Management

**Goal:** Complete attendance and absence tracking

**Why Ninth:** Important but not as critical as performance/indemnities. Depends on calculation engine (Phase 2) for overtime calculations.

**Requirements:**
- ATND-01: System tracks daily presence/absence with timestamps
- ATND-02: System integrates with biometric readers (where available)
- ATND-03: System calculates overtime hours automatically
- ATND-04: System manages leave requests workflow
- ATND-05: System tracks remote work (smart working) days
- ATND-06: System generates monthly attendance report

**Key Deliverables:**
- Attendance tracker (daily check-in/out)
- Biometric reader integration layer
- Overtime calculator
- Leave request workflow
- Smart working day tracker
- Monthly attendance report generator

**Pitfalls Addressed:**
- Manual attendance tracking
- Missing biometric integration
- Overtime calculation errors
- Leave request delays

**Dependencies:** Phase 2 (calculation engine), Phase 5 (manager approval workflow)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify biometric reader models supported
- ⚠️ Test overtime calculations with CCNL rules
- ⚠️ Confirm smart working tracking matches Law 81/2017 requirements

---

## Phase 10: Career Progression & Reporting

**Goal:** Complete career progression management and organizational reporting

**Why Tenth:** Important but depends on all historical data (evaluations, attendance, seniority). Natural capstone phase.

**Requirements:**
- CARR-01: System tracks seniority accrual (anni di anzianità)
- CARR-02: System manages progression applications workflow
- CARR-03: System validates progression requirements automatically
- CARR-04: System generates progression PDF decree
- CARR-05: System updates employee record after progression

**Key Deliverables:**
- Seniority accrual tracker (automatic calculation)
- Progression application workflow
- Requirements validator (automatic eligibility check)
- Progression decree generator (PDF)
- Employee record updater (post-progression)
- Organizational chart generator
- Executive reporting dashboard

**Pitfalls Addressed:**
- Manual seniority tracking
- Missing progression requirements validation
- Delayed progression decrees
- Inconsistent record updates

**Dependencies:** Phase 1 (audit trail), Phase 2 (calculation), Phase 3 (evaluations), Phase 9 (attendance)

**Estimated Complexity:** Medium

**Research Flags:**
- ⚠️ Verify seniority calculation matches CCNL rules
- ⚠️ Test progression requirements with edge cases (transfers, leaves)
- ⚠️ Confirm decree format matches legal requirements

---

## Traceability Matrix

| Requirement | Phase | Status | Priority |
|-------------|-------|--------|----------|
| AUDT-01..05 | Phase 1 | ○ Pending | P0 (Foundational) |
| INDN-01..06 | Phase 2 | ○ Pending | P0 (Critical) |
| PERF-01..10 | Phase 3 | ○ Pending | P0 (Core Domain) |
| ESS-01..08 | Phase 4 | ○ Pending | P1 (Critical Gap) |
| MGR-01..07 | Phase 5 | ○ Pending | P1 (Compliance) |
| TRSP-01..05 | Phase 6 | ○ Pending | P1 (Legal) |
| INTG-01..05 | Phase 7 | ○ Pending | P1 (Integration) |
| RLBL-01..04 | Phase 8 | ○ Pending | P2 (Reliability) |
| ATND-01..06 | Phase 9 | ○ Pending | P2 (Important) |
| CARR-01..05 | Phase 10 | ○ Pending | P2 (Important) |

**Coverage:**
- Total requirements: 68
- Mapped to phases: 68
- Unmapped: 0 ✓

---

## Critical Path

**Phase 1 → Phase 2 → Phase 3 → Phase 4 → Phase 5**

These phases form the critical path for minimum viable product:
1. Audit trail (compliance foundation)
2. Calculation engine (accuracy foundation)
3. Performance evaluation (core domain)
4. Employee self-service (critical gap)
5. Manager dashboard (compliance requirement)

**Phases 6-10** can proceed in parallel after Phase 5, depending on priorities.

---

## Release Strategy

**Milestone 1: Compliance Foundation** (Phases 1-3)
- Audit trail, calculations, performance workflow
- Internal release to HR administrators

**Milestone 2: User Experience** (Phases 4-5)
- Employee portal, manager dashboard
- Organization-wide rollout

**Milestone 3: Ecosystem Integration** (Phases 6-8)
- Transparency, integrations, reliability
- External integrations activated

**Milestone 4: Complete HR Suite** (Phases 9-10)
- Attendance, career progression
- Full feature set available

---

*Roadmap created: 2026-03-18*  
*Last updated: 2026-03-18 after initial creation*
