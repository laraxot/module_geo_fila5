# Sindacati - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Sindacati Module Team

## 1. Purpose & Vision
The Sindacati module manages **union memberships, contributions, and labor relations** for the PTVX platform. It tracks employee affiliations with different labor unions, manages monthly contribution deductions, and facilitates official communications between the organization and union representatives.

## 2. Problem Statement
The organization needs:
- To track which employees are members of which labor unions.
- To calculate and process monthly union dues deductions (delega sindacale).
- To manage the registry of certified unions and their representatives.
- To provide reports and payments to union organizations.
- To handle the workflow for joining or leaving a union.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Administrator** | Union Relations | Manage union registry, track memberships, communicate with reps. |
| **Payroll Manager** | Comp Admin | Calculate and export monthly fee deductions to payroll. |
| **Employee** | Data Subject | Manage their union membership, view deduction history. |
| **Union Rep** | External Auditor | Verify member lists and collected contributions (if allowed). |

## 4. Scope
### In Scope
- Registry of Labor Unions (Sindacati).
- Management of employee memberships (Deleghe).
- Calculation of monthly membership fees (fixed or percentage-based).
- Workflow for activation and revocation of memberships.
- Generation of contribution reports for each union.
- Integration with payroll (Sigma) for monthly deductions.
- Filament resources for admin and membership management.

### Out of Scope
- Union internal voting/balloting.
- Legal representation in disputes.

## 5. Functional Requirements
### FR-001: Union Registry
- **Priority**: Must-have
- **Description**: Create and manage the list of available unions and their bank details.
- **Acceptance Criteria**: Admin can define the fee calculation rules per union.

### FR-002: Membership (Delega) Management
- **Priority**: Must-have
- **Description**: Link employees to a union with starting and ending dates.
- **Acceptance Criteria**: Includes digital attachment of the signed membership form.

### FR-003: Fee Calculation
- **Priority**: Must-have
- **Description**: Calculate the monthly fee based on the union's rules and the employee's salary.
- **Acceptance Criteria**: Accurate export format for the Sigma payroll system.

### FR-004: Revocation Workflow
- **Priority**: Should-have
- **Description**: Formal process to record and process a membership cancellation.
- **Acceptance Criteria**: Automatic alignment with payroll to stop deductions from a specific date.

## 6. Non-Functional Requirements
- **NFR-001: Privacy**: Membership data is sensitive (trade union affiliation).
- **NFR-002: Accuracy**: Exact matching of deductions with union reports.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **User**: For employee association.
- **Media**: For signed form storage.
### Data Model
- Sindacati, Deleghe, Trattenute.
### Integration Points
- Provides deduction data to the `Sigma` module for monthly payroll processing.

## 8. User Experience
- Simple "Join/Leave Union" interface for employees.
- Batch export tools for HR to send reports to unions.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Deduction Accuracy | 100% | Reconciliation reports vs payroll. |
| Processing Time | < 24h | Time to reflect membership change in system. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Enrollment requires a physical or digital signed document.
- Payroll cycle follows a standard monthly schedule.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data privacy breach | High | Selective access roles for Sindacati module. |
| Fee calculation error | Medium | Pre-payroll validation report for HR. |

## 11. Dependencies & Constraints
- Must comply with national labor laws on union membership and privacy (GDPR).

## 12. Release Plan
### Phase 1: Core Registry (Stable)
- Unions and memberships CRUD. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Payroll Automated Export (Planned)
- Fully automated API sync with payroll systems.
- Digital signature integration for enrollment.

## 13. References
- [roadmap.md](roadmap.md)
