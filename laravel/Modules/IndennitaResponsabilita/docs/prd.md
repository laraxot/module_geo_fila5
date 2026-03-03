# IndennitaResponsabilita - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: IndennitaResponsabilita Team

## 1. Purpose & Vision
The IndennitaResponsabilita module manages **responsibility allowances tied to specific roles and leadership positions** for the PTVX platform. It provides a configurable system to evaluate and reward the level of responsibility, autonomy, and strategic impact of individual positions, ensuring merit-based compensation in accordance with organizational policies.

## 2. Problem Statement
Organizations need to:
- Define criteria for evaluating the "weight" of a specific position or role (e.g., complexity, budget managed).
- Record and approve the assignment of responsibility allowances to specific employees.
- Validate that the total allowance amount stays within budgetary and contractual limits.
- Provide a clear justification for why a specific position receives a certain allowance.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Director** | Policy Maker | Define evaluation criteria, oversee budget allocation. |
| **Evaluator** | Superior | Perform structured evaluations for specific positions. |
| **Payroll Manager** | Comp Admin | Process calculated allowances into payroll. |

## 4. Scope
### In Scope
- Responsibility Position (Incarico) management and registry.
- Structured evaluation engine for role-based criteria.
- Calculation of periodic allowance amounts.
- Validation and approval workflows for evaluations.
- Support for multi-year evaluation cycles.
- Filament resources for all management phases.

### Out of Scope
- Evaluation of individual performance (delegated to Performance module).
- Core payroll processing (delegated to Sigma).

## 5. Functional Requirements
### FR-001: Position Registry
- **Priority**: Must-have
- **Description**: Define specific positions of responsibility within the organization.
- **Acceptance Criteria**: Positions are linked to organizational units and job profiles.

### FR-002: Responsibility Evaluation
- **Priority**: Must-have
- **Description**: Guide evaluators through a series of weighted criteria to determine the position's "point value".
- **Acceptance Criteria**: Uses a structured scoring system with predefined options.

### FR-003: Allowance Calculation
- **Priority**: Must-have
- **Description**: Convert evaluation points into monetary amounts according to current value tables.
- **Acceptance Criteria**: Support for proportional calculation (pro-rata) based on period dates.

### FR-004: TDD & Validation
- **Priority**: Should-have
- **Description**: Strong test-driven validation for the complex calculation logic.
- **Acceptance Criteria**: Minimum 80% test coverage for calculation actions.

## 6. Non-Functional Requirements
- **NFR-001: Justification**: Every allowance requires a documented justification in the system.
- **NFR-002: Budget Control**: Ensure the sum of allowances does not exceed the total allocated fund for the year.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **Rating**: (Optional but recommended) for structured criteria.
- **User**: For employee association.
### Data Model
- Incarichi, Valutazioni, Criteri, Graduatorie.
### Integration Points
- Consumed by final payroll processing for year-end or periodic payments.

## 8. User Experience
- Visual "scorecards" showing how a position reached its final point value.
- Easy "copy-forward" for unchanged positions across multi-year cycles.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Calculation Accuracy | 100% | Automated test result. |
| Time to Evaluate | < 10 mins | Average time per position evaluation. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- The organization has a defined methodology for valuing positions.
- Budgetary funds are allocated and known at the start of the cycle.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Criteria ambiguity | Medium | Use multiple-choice options instead of open text. |
| Multi-incumbency issues | High | Logic to handle shared responsibilities or split periods. |

## 11. Dependencies & Constraints
- Must adhere to Italian PA regulations for "Indennità di Posizione e Risultato".

## 12. Release Plan
### Phase 1: Foundation (Stable)
- Core models and basic evaluation forms. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Calculation (In Progress)
- Complexity-based formula engine.
- Full TDD coverage for all edge cases.

## 13. References
- [roadmap.md](roadmap.md)
