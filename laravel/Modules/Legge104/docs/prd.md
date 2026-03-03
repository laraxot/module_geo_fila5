# Legge104 - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Legge104 Module Team

## 1. Purpose & Vision
The Legge104 module manages **disability assistance and medical leave entitlements** for the PTVX platform, specifically in accordance with the Italian Law 104/92. It tracks employee eligibility, permits, and documentation, ensuring that the organization correctly implements mandated support for employees with disabilities or those caring for disabled family members.

## 2. Problem Statement
The HR department must:
- Accurately track eligibility for Law 104 benefits (days off/hours off).
- Manage the expiration and renewal of medical certifications.
- Ensure that the organization complies with legal quotas and benefit limits.
- Coordinate with the attendance system to track the usage of these specific leave types.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Specialist** | Benefit Admin | Register new Law 104 entitlements, track certificate expirations. |
| **Employee** | Data Subject | View current permit balance, submit renewal documentation. |
| **Manager** | Team Lead | Monitor team availability considering Law 104 planned absences. |

## 4. Scope
### In Scope
- Registry of employees/family members eligible for Law 104 benefits.
- Tracking of medical certificates and their validity periods.
- Management of annual/monthly benefit limits (e.g., 3 days per month).
- Integration with the attendance system (PresenzeAssenze) for benefit usage.
- Secure storage of supporting medical documentation.

### Out of Scope
- Medical evaluation of disability (delegated to national health authorities - ASL/INPS).
- General sick leave management (delegated to regular HR processes).

## 5. Functional Requirements (Prioritized)

### P0: Entitlement Management (Must-have)
- **FR-001: Benefit Registry**: Record eligibility for Law 104 benefits with certificate validation and validity dates.
- **FR-002: Leave Balance Tracking**: Real-time monitoring of used vs remaining hours/days for each period.
- **FR-004: Secure Certification Storage**: Encrypted storage of medical documents using the `Media` module.

### P1: Operational Compliance (Important)
- **FR-003: Proactive Expiration Alerts**: Automated notifications for HR and employees when certificates are approaching expiration.
- **FR-005: Attendance Integration**: Hard validation in the `PresenzeAssenze` module to prevent over-usage of specific Law 104 codes.

### P2: Process Innovation (Nice-to-have)
- **FR-006: Self-Service Renewal**: Employee interface for uploading renewal documentation and tracking approval status.
- **FR-007: AI Document Verification**: Automatic data extraction and preliminary verification of uploaded medical certificates.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Logic**: Legge104 provides the entitlement engine; it MUST NOT contain organizational-specific HR policies beyond legal mandates.
- **Interoperability**: Consumes employee data from `User` and integrates with `PresenzeAssenze` for leave consumption.
- **Isolation**: Sensitive medical/disability data is encapsulated with high-security access controls.

### Performance & Safety
- **NFR-001: Data Protection**: 100% encryption and restricted access for all documents containing special categories of data.
- **NFR-002: Reliability**: Accurate calculation of monthly/annual benefit balances according to current INPS guidelines.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: For employee association.
- **Media**: For sensitive document storage.
- **PresenzeAssenze**: For leave usage tracking.
### Data Model
- Periti, Certificazioni, Permessi.
### Integration Points
- Feeds data into the attendance system to prevent over-usage of specific leave codes.

## 8. User Experience
- Simple dashboard for employees to see their "Permit Balance".
- Red-flag system for expired or missing documentation in human resources views.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Documentation Completeness | 100% | Check if all active benefits have valid certificates. |
| Over-usage Rate | 0% | Validation during attendance entry. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- The employee provides the necessary official certification.
- Integration with the national INPS database for automatic validation is a future goal.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data privacy breach | Critical | Highly restricted access roles, no plain-text logs for medical data. |
| Outdated certificates | Medium | Proactive notification system. |

## 11. Dependencies & Constraints
- Must comply with Italian Public Administration (PA) regulations and INPS guidelines.

## 12. Release Plan
### Phase 1: Core Records (Stable)
- Basic entitlement and certificate tracking. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: System Integration (Planned)
- Fully automated sync with the attendance module.
- Automated API communication with INPS for verification.

## 13. References
- [roadmap.md](roadmap.md)
