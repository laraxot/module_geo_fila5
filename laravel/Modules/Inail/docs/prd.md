# Inail - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Inail Module Team

## 1. Purpose & Vision
The Inail module manages **workplace accident reporting and safety insurance documentation** for the PTVX platform, specifically integrated with the Italian INAIL (Istituto Nazionale per l'Assicurazione contro gli Infortuni sul Lavoro) standards. It ensures that every workplace incident is correctly recorded and reported or transmitted to the national insurance body.

## 2. Problem Statement
The HR and Safety departments must:
- Record workplace accidents immediately and accurately.
- Generate mandatory documentation for INAIL within strict deadlines (e.g., 48 hours).
- Identify and manage the registry of INAIL insurance codes (posizioni assicurative).
- Maintain a historic safety record for the organization.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Safety Officer** | RSPP / ASPP | Document accidents, generate safety reports. |
| **HR Manager** | Employee Admin | Communicate incident to the national body, manage payouts (if applicable). |
| **Doctor** | Competent Physician | Record medical findings related to the incident. |

## 4. Scope
### In Scope
- Workplace accident (Infortunio) management lifecycle.
- Management of INAIL insurance position codes (PAT).
- Document generation for accident reporting.
- History of accidents by employee and workplace unit.
- Milestone tracking for reporting deadlines.

### Out of Scope
- Health & Safety risk assessments (DVR) - delegated to specialized safety software.
- Physical medical treatment (hospital-bound).

## 5. Functional Requirements (Prioritized)

### P0: Incident Compliance (Must-have)
- **FR-001: Accident Recording**: Detailed lifecycle management of workplace incidents (Infortunio).
- **FR-002: Insurance Registry (PAT)**: Manage and assign INAIL insurance position codes to organizational units or employees.
- **FR-003: Deadline Monitoring**: High-priority tracking of the 48-hour mandatory communication deadline for accident reports.

### P1: Operational Safety (Important)
- **FR-004: Official Report Generation**: Automated generation of official INAIL accident reports in PDF format.
- **FR-005: Workplace History**: Historical record of safety incidents categorized by unit and employee.

### P2: Digital Integration (Nice-to-have)
- **FR-006: Digital Transmission**: Integration with INAIL APIs for direct electronic submission of accident reports.
- **FR-007: AI Safety Analysis**: Predictive analysis of high-risk units based on accident history.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Regulatory Engine**: Inail MUST support periodic regulatory template updates without breaking the core incident logic.
- **Interoperability**: Integrates with `User` for employee context and `Notify` for deadline alerts.
- **Independence**: Incident records are kept separate from general performance or HR evaluations.

### Performance & Safety
- **NFR-001: Confidentiality**: Strict access control for sensitive medical/safety data.
- **NFR-002: Reliability**: Zero-tolerance for delayed notifications due to legal penalties.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: For employee association.
- **Notify**: For deadline alerts.
### Data Model
- `infortuni`: Registry of accidents.
- `posizioni_assicurative`: INAIL PAT registry.

## 8. User Experience
- Streamlined mobile-friendly form for immediate on-site accident reporting.
- Clear status overview (Not started, In progress, Reported).

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Reporting Deadline Met | 100% | Audit of report date vs accident date. |
| Data Completeness | 100% | Validation checks on submitted reports. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Administrators are aware of the legal penalties for late reporting.
- Correct employee/unit association is available.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Late reporting | High | Automatic SMS/Email alerts to HR/Safety leads. |
| Missing mandatory data | Medium | Advanced form validation before final submission. |

## 11. Dependencies & Constraints
- Must adhere to current Legislative Decree 81/08 and INAIL regulations.

## 12. Release Plan
### Phase 1: Core Registry (Stable)
- Accident registry and basic reporting. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Integration (Planned)
- Fully automated TEAMS integration for accident alerts.
- Digital transmission to INAIL API (if available).

## 13. References
- [roadmap.md](roadmap.md)
