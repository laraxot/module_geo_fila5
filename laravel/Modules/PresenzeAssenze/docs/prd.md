# PresenzeAssenze - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: PresenzeAssenze Team

## 1. Purpose & Vision
The PresenzeAssenze module is the **core time and attendance management system** for the PTVX platform. It monitors employee work hours, absences, leave requests, and overtime, providing a robust and precise dataset for payroll calculation and organizational capacity planning.

## 2. Problem Statement
The organization needs:
- To track daily clock-in/out events (timbrature) for all employees.
- A streamlined workflow for leave/absence requests and approvals.
- Accurate calculation of worked hours, including overtime and night shifts.
- Integration with payroll systems to reflect absences and extra hours in salaries.
- Monitoring of mandatory rest periods and working time limits.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Specialist** | Time Admin | Manage clocking errors, oversee leave balances, verify monthly totals. |
| **Manager** | Team Lead | Approve leave requests, monitor team presence, authorize overtime. |
| **Employee** | End User | Clock in/out, check leave balance, request time off. |

## 4. Scope
### In Scope
- Clocking event (Timbratura) management and registry.
- Leave and Absence request workflow (Requests/Approvals).
- Calculation engine for work hours, overtime, and specific shift bonuses.
- Annual and monthly leave balance tracking (Ferie, Permessi).
- Working shift (Turni) and schedule management.
- Integration with external physical clocking terminals.
- Filament resources for all user roles.

### Out of Scope
- Physical clocking hardware production.
- Direct payroll payment (delegated to Sigma).

## 5. Functional Requirements (Prioritized)

### P0: Time Tracking Core (Must-have)
- **FR-001: Clocking Event Management**: Capture and store daily entry/exit events (timbrature) via web, mobile, or terminal.
- **FR-002: Leave & Absence Workflow**: Multi-level approval process for vacation, sick leave, and special permits.
- **FR-003: Work Hour Calculation**: Automated calculation of net hours, overtime, and night shifts based on assigned schedules.

### P1: Compliance & Payroll (Important)
- **FR-004: Overtime Authorization**: Workflow for formal authorization of extra hours to be exported to payroll.
- **FR-005: Multi-tenant Shift Management**: Define and assign complex working shifts (Turni) and periodic schedules.
- **FR-006: External Terminal Integration**: Standardized bridge for importing data from physical clocking hardware.

### P2: Advanced Workforce Planning (Nice-to-have)
- **FR-007: Visual Shift Planner**: Interactive drag-and-drop interface for managing departmental rotations.
- **FR-008: AI Absence Prediction**: Predictive modeling of absence trends to optimize workforce capacity.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Terminal Agnosticism**: PresenzeAssenze MUST remain independent of specific physical clocking hardware vendors.
- **Interoperability**: Provides crucial hour and absence feeds to `Sigma` for payroll and `Performance` for evaluation context.
- **Independent Rules**: Calculation rules (rounding, tolerances) are configurable and independent of the core attendance logic.

### Performance & Safety
- **NFR-001: Availability**: High-uptime requirement for the entry/exit registration interface.
- **NFR-002: Auditability**: Every modification to a clocking event must be immutable and fully audit-trailed.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **User**: For employee profiles and hierarchy.
- **Notify**: For request status updates.
### Data Model
- Timbrature, Assenze, Permessi, Turni, Richieste.
### Integration Points
- Crucial feed for `Sigma` modules to calculate monthly salaries.

## 8. User Experience
- High-efficiency "One-click Clock-in" for employees.
- Visual "Who is in" dashboard for managers.
- Detailed monthly timecard view for HR.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Recording Precision | 100% | Audit of clocking logs. |
| Time to Approve | < 48h | Average duration of the approval cycle. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Employees have a defined work schedule (Orario).
- Internet/network connectivity is available at clocking points.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Clocking errors | Medium | Streamlined "Omissa Timbratura" request process. |
| Schedule complexity | High | Flexible rule engine for custom shift patterns. |

## 11. Dependencies & Constraints
- Must comply with national labor laws regarding maximum working hours and rest.

## 12. Release Plan
### Phase 1: Core Timekeeping (Stable)
- Basic clocking and absence tracking. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Scheduling (Planned)
- Fully visual Shift Planner.
- Predictive leave planning based on historical trends.

## 13. References
- [roadmap.md](roadmap.md)
