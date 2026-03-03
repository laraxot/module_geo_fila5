# Legge109 - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Legge109 Module Team

## 1. Purpose & Vision
The Legge109 module manages **mandatory hirings and related social benefits** for the PTVX platform, specifically in relation to the Italian Law 109/1996 and subsequent regulations regarding public works and employment incentives. It tracks compliance with hiring quotas and ensures that the organization correctly implements related fiscal and social security reliefs.

## 2. Problem Statement
The HR department needs to:
- Monitor compliance with mandatory hiring quotas (e.g., protected categories).
- Manage specific employment benefits and social security reductions associated with Legge 109.
- Track documentation and eligibility for subsidized hiring programs.
- Report on these statistics for government audits and accountability.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Recruitment Specialist** | Hiring Admin | Identify candidates for protected category positions, track quota status. |
| **HR Manager** | Compliance Officer | Monitor organization-wide compliance with Legge 109 and similar laws. |
| **Finance Officer** | Payroll Admin | Monitor social security reliefs and benefits for eligible employees. |

## 4. Scope
### In Scope
- Quota compliance tracking for designated employee categories.
- Management of hiring incentives and social security reliefs.
- Registry of specific "Legge 109" employment contracts and profiles.
- Automated reporting on hiring statistics for regulatory bodies.
- Secure storage of supporting eligibility documentation.

### Out of Scope
- General recruitment (delegated to a dedicated Recruitment or User module).
- Physical workplace adaptations (delegated to Safety/Inail).

## 5. Functional Requirements
### FR-001: Quota Management
- **Priority**: Must-have
- **Description**: Calculate and monitor the required percentage of mandatory hirings based on total workforce.
- **Acceptance Criteria**: Visual dashboard showing actual vs required hiring count.

### FR-002: Benefit Tracking
- **Priority**: Should-have
- **Description**: Record and track specific social security and fiscal benefits per employee.
- **Acceptance Criteria**: Integration with the payroll logic for correct relief application.

### FR-003: Eligibility Registry
- **Priority**: Must-have
- **Description**: Track why an employee belongs to a specific protected or subsidized category.
- **Acceptance Criteria**: Includes documentation proof and validity period.

### FR-004: Regulatory Reporting
- **Priority**: Should-have
- **Description**: Generate periodic reports on hiring quotas as required by the Ministry of Labor.
- **Acceptance Criteria**: Output matches official government templates.

## 6. Non-Functional Requirements
- **NFR-001: Accuracy**: Precise calculation of workforce percentages including part-time adjustment.
- **NFR-002: Privacy**: Sensitive treatment of data related to protected categories.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: Core employee records.
- **Media**: For sensitive document storage.
### Data Model
- Quotas, HiringCategories, Benefits, Contracts.
### Integration Points
- Works closely with the User module to identify eligible profiles during onboarding.

## 8. User Experience
- Real-time "Compliance Meter" for HR managers.
- Easy categorization of new hires during the onboarding process.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Quota Gap | 0 | Difference between required and actual hirings. |
| Benefit Accuracy | 100% | Audit of applied reliefs vs eligibility. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Workforce numbers are correctly reported from the core User module.
- Legal quota definitions are updated annually by the system admin.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Under-compliance penalties | High | Proactive alerts for missing quotas. |
| Data sensitivity | High | Highly restricted access to protected category flags. |

## 11. Dependencies & Constraints
- Must comply with the Italian "Collocamento Obbligatorio" (Law 68/99) which often overlaps with 109.

## 12. Release Plan
### Phase 1: Registry & Quotas (Planned)
- Quota calculation engine and basic registry.
- PHPStan Level 10 compliance.
### Phase 2: Full Reporting (Future)
- Automated report generation for the Ministry.
- Integration with external hiring portals.

## 13. References
- [roadmap.md](roadmap.md)
