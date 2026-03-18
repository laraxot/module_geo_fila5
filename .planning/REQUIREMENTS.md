# Requirements: PTVX Fila5 Mono

**Defined:** 2026-03-18  
**Core Value:** Provide Italian Public Administrations with a compliant, automated system for managing the complete employee performance evaluation cycle

---

## v1 Requirements

Requirements for next milestone. Each maps to roadmap phases.

### Employee Self-Service (ESS)

- [ ] **ESS-01**: Employee can view own performance evaluations (current and historical)
- [ ] **ESS-02**: Employee can view own indemnities and bonuses breakdown
- [ ] **ESS-03**: Employee can view own absence/presence records
- [ ] **ESS-04**: Employee can view own career progression history
- [ ] **ESS-05**: Employee can download PDF certificates (GDPR export)
- [ ] **ESS-06**: Employee can update own contact information
- [ ] **ESS-07**: Employee can view assigned training courses
- [ ] **ESS-08**: Employee can submit self-evaluation for performance cycle

### Manager Dashboard

- [ ] **MGR-01**: Manager can view team overview (direct reports count, status)
- [ ] **MGR-02**: Manager can view team performance evaluation progress
- [ ] **MGR-03**: Manager can initiate performance evaluation for direct reports
- [ ] **MGR-04**: Manager can view team absence/presence summary
- [ ] **MGR-05**: Manager can approve/reject team leave requests
- [ ] **MGR-06**: Manager can view team indemnities overview
- [ ] **MGR-07**: Manager can export team data to Excel/PDF

### Performance Evaluation

- [ ] **PERF-01**: System enforces evaluation timeline (start/end dates, deadlines)
- [ ] **PERF-02**: System tracks intermediate colloquies (mandatory per D.Lgs. 150/2009)
- [ ] **PERF-03**: System prevents evaluator conflict of interest
- [ ] **PERF-04**: System enforces evaluation differentiation (no all-max scores)
- [ ] **PERF-05**: Employee can submit self-evaluation
- [ ] **PERF-06**: Evaluator can complete evaluation form with criteria scoring
- [ ] **PERF-07**: System calculates final score automatically
- [ ] **PERF-08**: Employee can appeal evaluation within configured period
- [ ] **PERF-09**: HR can generate SMVP (Scheda Misura Valutazione Performance)
- [ ] **PERF-10**: System generates PDF evaluation document

### Transparency Portal

- [ ] **TRSP-01**: System publishes performance evaluations to public website (anonymized)
- [ ] **TRSP-02**: System publishes bonus allocation to public website (anonymized)
- [ ] **TRSP-03**: System publishes CVs of management to public website
- [ ] **TRSP-04**: System publishes organizational chart to public website
- [ ] **TRSP-05**: Transparency data exported in open format (CSV/JSON)

### Indemnity Calculations

- [ ] **INDN-01**: System uses BCMath/Decimal for all monetary calculations (no float)
- [ ] **INDN-02**: System stores calculation formula version with each record
- [ ] **INDN-03**: System applies CCNL rates correctly (seniority-based)
- [ ] **INDN-04**: System calculates Law 104 permits accurately (3 days/month)
- [ ] **INDN-05**: System generates monthly indemnity report for payroll
- [ ] **INDN-06**: System maintains audit trail for all calculation changes

### Attendance & Absences

- [ ] **ATND-01**: System tracks daily presence/absence with timestamps
- [ ] **ATND-02**: System integrates with biometric readers (where available)
- [ ] **ATND-03**: System calculates overtime hours automatically
- [ ] **ATND-04**: System manages leave requests workflow
- [ ] **ATND-05**: System tracks remote work (smart working) days
- [ ] **ATND-06**: System generates monthly attendance report

### Career Progression

- [ ] **CARR-01**: System tracks seniority accrual (anni di anzianità)
- [ ] **CARR-02**: System manages progression applications workflow
- [ ] **CARR-03**: System validates progression requirements automatically
- [ ] **CARR-04**: System generates progression PDF decree
- [ ] **CARR-05**: System updates employee record after progression

### Integrations

- [ ] **INTG-01**: System exposes OpenAPI documentation for all endpoints
- [ ] **INTG-02**: System integrates with Sigma (stipendi) via API
- [ ] **INTG-03**: System integrates with Europa (EU funds) tracking
- [ ] **INTG-04**: System integrates with Pdnd (Piattaforma Digitale Nazionale Dati)
- [ ] **INTG-05**: System sends INAIL injury reports within legal deadline (2-5 days)

### Queue & Reliability

- [ ] **RLBL-01**: System uses Redis queue driver (not database)
- [ ] **RLBL-02**: System monitors failed jobs with alerts
- [ ] **RLBL-03**: System implements retry logic for external API calls
- [ ] **RLBL-04**: System generates daily queue health report

### Audit & Compliance

- [ ] **AUDT-01**: System logs all data changes with before/after values
- [ ] **AUDT-02**: System logs all user actions (who did what when)
- [ ] **AUDT-03**: System maintains GDPR-compliant data export
- [ ] **AUDT-04**: System implements data retention policies
- [ ] **AUDT-05**: System provides audit trail report for compliance reviews

---

## v2 Requirements

Deferred to future release. Tracked but not in current roadmap.

### Advanced Features

- **AI-01**: AI-powered prediction of performance trends
- **AI-02**: Prediction markets for organizational climate
- **ANLT-01**: Advanced analytics dashboard (turnover prediction, absence patterns)
- **MOBL-01**: Mobile PWA app for employees
- **SRCH-01**: Advanced search across all modules
- **BULK-01**: Advanced bulk operations (bulk edit, bulk export)
- **DOCS-01**: Document repository/management system
- **NOTF-01**: Real-time notifications (in-app + email)

### Workflow Enhancements

- **WF-01**: Configurable approval workflows (drag-and-drop builder)
- **WF-02**: Email/SMS notifications for pending actions
- **WF-03**: Escalation rules for overdue evaluations
- **WF-04**: Delegation workflow (evaluator delegates to another)

---

## Out of Scope

Explicitly excluded. Documented to prevent scope creep.

| Feature | Reason |
|---------|--------|
| Real-time chat/instant messaging | Security concerns, not core to HR workflows |
| Native mobile app (iOS/Android) | 3x cost, PWA sufficient for mobile access |
| Blockchain integration | Over-engineering, traditional DB meets requirements |
| Machine learning predictions | Not auditable for PA compliance requirements |
| Video conferencing | Outside HR domain, integrate with existing tools |
| Social network features | Low value for PA HR context |
| Gamification | Inappropriate for public administration context |
| Non-Italian localization | System designed specifically for Italian PA regulations |

---

## Traceability

Which phases cover which requirements. Updated during roadmap creation.

| Requirement | Phase | Status |
|-------------|-------|--------|
| ESS-01 | Phase 4 | Pending |
| ESS-02 | Phase 4 | Pending |
| ESS-03 | Phase 4 | Pending |
| ESS-04 | Phase 4 | Pending |
| ESS-05 | Phase 4 | Pending |
| ESS-06 | Phase 4 | Pending |
| ESS-07 | Phase 4 | Pending |
| ESS-08 | Phase 4 | Pending |
| MGR-01 | Phase 5 | Pending |
| MGR-02 | Phase 5 | Pending |
| MGR-03 | Phase 5 | Pending |
| MGR-04 | Phase 5 | Pending |
| MGR-05 | Phase 5 | Pending |
| MGR-06 | Phase 5 | Pending |
| MGR-07 | Phase 5 | Pending |
| PERF-01 | Phase 3 | Pending |
| PERF-02 | Phase 3 | Pending |
| PERF-03 | Phase 3 | Pending |
| PERF-04 | Phase 3 | Pending |
| PERF-05 | Phase 3 | Pending |
| PERF-06 | Phase 3 | Pending |
| PERF-07 | Phase 3 | Pending |
| PERF-08 | Phase 3 | Pending |
| PERF-09 | Phase 3 | Pending |
| PERF-10 | Phase 3 | Pending |
| TRSP-01 | Phase 6 | Pending |
| TRSP-02 | Phase 6 | Pending |
| TRSP-03 | Phase 6 | Pending |
| TRSP-04 | Phase 6 | Pending |
| TRSP-05 | Phase 6 | Pending |
| INDN-01 | Phase 2 | Pending |
| INDN-02 | Phase 2 | Pending |
| INDN-03 | Phase 2 | Pending |
| INDN-04 | Phase 2 | Pending |
| INDN-05 | Phase 2 | Pending |
| INDN-06 | Phase 2 | Pending |
| ATND-01 | Phase 9 | Pending |
| ATND-02 | Phase 9 | Pending |
| ATND-03 | Phase 9 | Pending |
| ATND-04 | Phase 9 | Pending |
| ATND-05 | Phase 9 | Pending |
| ATND-06 | Phase 9 | Pending |
| CARR-01 | Phase 10 | Pending |
| CARR-02 | Phase 10 | Pending |
| CARR-03 | Phase 10 | Pending |
| CARR-04 | Phase 10 | Pending |
| CARR-05 | Phase 10 | Pending |
| INTG-01 | Phase 7 | Pending |
| INTG-02 | Phase 7 | Pending |
| INTG-03 | Phase 7 | Pending |
| INTG-04 | Phase 7 | Pending |
| INTG-05 | Phase 7 | Pending |
| RLBL-01 | Phase 8 | Pending |
| RLBL-02 | Phase 8 | Pending |
| RLBL-03 | Phase 8 | Pending |
| RLBL-04 | Phase 8 | Pending |
| AUDT-01 | Phase 1 | Pending |
| AUDT-02 | Phase 1 | Pending |
| AUDT-03 | Phase 1 | Pending |
| AUDT-04 | Phase 1 | Pending |
| AUDT-05 | Phase 1 | Pending |

**Coverage:**
- v1 requirements: 68 total
- Mapped to phases: 68
- Unmapped: 0 ✓

---

*Requirements defined: 2026-03-18*  
*Last updated: 2026-03-18 after initial definition*
