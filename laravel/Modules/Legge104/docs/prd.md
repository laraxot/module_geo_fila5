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

## 5. Functional Requirements
### FR-001: Entitlement Registry
- **Priority**: Must-have
- **Description**: Record an employee's right to Law 104 benefits, including the specific person they care for.
- **Acceptance Criteria**: Requires certificate validation and validity dates.

### FR-002: Balance Tracking
- **Priority**: Must-have
- **Description**: Track used vs remaining hours/days of leave for each month/year.
- **Acceptance Criteria**: Real-time integration with attendance records.

### FR-003: Expiration Alerts
- **Priority**: Should-have
- **Description**: Notify HR and the employee when a medical certificate is approaching its expiration date.
- **Acceptance Criteria**: Automated notifications 30/60 days before expiration.

### FR-004: Document Management
- **Priority**: Must-have
- **Description**: Securely store digital copies of relevant certifications.
- **Acceptance Criteria**: Integrated with Media module with high encryption/restricted access.

## 6. Non-Functional Requirements
- **NFR-001: Data Protection**: High sensitivity of records (special categories of personal data).
- **NFR-002: Legal Compliance**: Strict adherence to Law 104/92 regulatory updates.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

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
