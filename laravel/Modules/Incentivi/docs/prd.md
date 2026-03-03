# Incentivi - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Incentivi Module Team

## 1. Purpose & Vision
The Incentivi module manages **performance incentives and bonus distributions** for the PTVX platform. It streamlines the lifecycle of incentive projects, from design and participant assignment to workgroup coordination, capital percentage allocation, and final liquidation, ensuring fair and transparent reward systems.

## 2. Problem Statement
Organizations need to:
- Design and manage complex incentive projects with multiple criteria.
- Assign employees to specific workgroups and projects.
- Calculate incentive amounts based on capital percentages and project outcomes.
- Track liquidation status and ensure accurate payment processing.
- Provide transparency to employees regarding their performance rewards.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Manager** | Incentive Designer | Define project criteria, assign participants, manage budgets. |
| **Dept Head** | Workgroup Coordinator | Oversee team progress, approve percentage allocations. |
| **Employee** | Participant | Track incentive status, view calculated rewards. |
| **Finance Officer** | Liquidation Admin | Process payments, verify accounting alignment. |

## 4. Scope
### In Scope
- Incentive Project and Workgroup management.
- Employee participant assignment and role definition.
- Capital percentage allocation (percentage of the incentive pool per user).
- Liquidation status tracking and reporting.
- Association with specific funding sources.
- Filament resources for admin and management controls.

### Out of Scope
- Detailed time tracking (delegated to PresenzeAssenze or Job).
- Core payroll processing (delegated to Sigma).

## 5. Functional Requirements
### FR-001: Project Definition
- **Priority**: Must-have
- **Description**: Create incentive projects with specific start/end dates and funding pools.
- **Acceptance Criteria**: Admin can define the project scope and total incentive amount.

### FR-002: Workgroup Coordination
- **Priority**: Must-have
- **Description**: Group participants into workgroups within a project for easier management.
- **Acceptance Criteria**: Workgroups have defined leads and participant lists.

### FR-003: Percentage Allocation
- **Priority**: Must-have
- **Description**: Assign a specific percentage of the incentive pool to each participant.
- **Acceptance Criteria**: Total percentage within a workgroup or project must not exceed 100%.

### FR-004: Liquidation Workflow
- **Priority**: Should-have
- **Description**: Mark incentive amounts as "Calculated", "Approved", and "Liquidated".
- **Acceptance Criteria**: Audit trail for each status change.

## 6. Non-Functional Requirements
- **NFR-001: Auditability**: Every allocation change must be logged.
- **NFR-002: Precision**: Financial calculations must maintain high decimal precision (e.g., 4 decimals).
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: Participant identification.
- **Notify**: For notification of approved incentives.
### Data Model
- Projects, Workgroups, Participants, Liquidations.
### Integration Points
- Consumes payroll data from Sigma for base salary context (if needed).

## 8. User Experience
- Progress bars for incentive pool allocation.
- Clean dashboards for Dept Heads to manage their respective workgroups.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Allocation Errors | 0 | Validation checks on percentages. |
| Liquidation Cycle Time | < 5 days | Time from approval to liquidation. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Funding pools are clearly defined for each project.
- Employee performance data is available for allocation decisions.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Over-allocation of budget | High | Real-time budget validation in forms. |
| Late liquidation | Medium | System alerts for approved but non-liquidated items. |

## 11. Dependencies & Constraints
- Must comply with internal labor contracts and agreements.

## 12. Release Plan
### Phase 1: Core Management (Stable)
- Project and Workgroup registry. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Refined Liquidation (Planned)
- Advanced PDF reporting for payroll.
- Automated percentage calculation based on performance scores (Rating module).

## 13. References
- [roadmap.md](roadmap.md)
