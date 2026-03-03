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

## 5. Functional Requirements (Prioritized)

### P0: Position & Allowance Management (Must-have)
- **FR-001: Position Registry (Incarichi)**: Define and manage specific positions of responsibility within the organization, linked to units and job profiles.
- **FR-002: Structured Evaluation**: Weighted criteria engine to determine the "point value" of each position.
- **FR-003: Monetary Calculation**: Convert evaluation points into monetary amounts according to current value tables with pro-rata support.

### P1: Operational Workflow (Important)
- **FR-005: Multi-Year Cycle Management**: Support for copying and adjusting positions across different fiscal years.
- **FR-006: Approval Workflow**: Multi-step validation and approval for position evaluations and final allowance assignments.

### P2: Advanced Governance (Nice-to-have)
- **FR-004: Automated TDD Validation**: Comprehensive test suite to verify complex calculation logic against edge cases.
- **FR-007: AI Position Matching**: Suggestions for position point values based on historical data of similar roles.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Logic**: IndennitaResponsabilita provides the evaluation framework; it does NOT contain hardcoded organizational structures.
- **Interoperability**: Consumes unit data from `Xot` and employee data from `User`; results are consumed by `Sigma` for payroll.
- **Independence**: Position evaluation is decoupled from the specific individual holding the position.

### Performance & Safety
- **NFR-001: Justification**: Mandatory documented justification for every assigned allowance.
- **NFR-002: Budget Control**: Real-time validation to ensure total allowances stay within the allocated fund.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
