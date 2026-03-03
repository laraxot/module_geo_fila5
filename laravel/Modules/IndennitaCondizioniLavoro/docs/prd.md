# IndennitaCondizioniLavoro - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: IndennitaCondizioniLavoro Team

## 1. Purpose & Vision
The IndennitaCondizioniLavoro module manages **allowances specifically tied to working conditions** (e.g., hardship, risk, hazardous environments) for the PTVX platform. it provides a specialized evaluation and calculation engine to ensure that employees working in specific conditions receive the contractually mandated monetary compensation.

## 2. Problem Statement
The payroll and HR process needs to:
- Identify and record specific working conditions for each employee/unit.
- Evaluate the intensity or eligibility for allowances based on configurable criteria.
- Calculate the correct amount of compensation according to union/labor contracts.
- Provide evidence for these payments during labor audits.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Safety Manager** | Auditor | Identify high-risk or specific condition units. |
| **HR Administrator** | Payroll Manager | Assign allowances, calculate payments, export to payroll systems. |
| **Employee** | Recipient | Understand why they receive certain allowances. |

## 4. Scope
### In Scope
- Registry of specific working conditions and their related allowance types.
- Evaluation engine for eligibility and intensity.
- Calculation logic for periodic payments.
- Management of evaluation criteria and options.
- Integration with the Rating module for structured criteria handling.
- Filament resources for admin management.

### Out of Scope
- Time tracking of exact hours in specific conditions (delegated to PresenzeAssenze).
- Physical risk assessment (delegated to Inail or specialized safety software).

## 5. Functional Requirements (Prioritized)

### P0: Allowance Management (Must-have)
- **FR-001: Condition Registry**: Define and version different working conditions (hardship, hazard, risk) with related allowance types and rates.
- **FR-002: Eligibility Evaluation**: Form-based evaluation of employees working conditions against structured criteria using the `Rating` module.
- **FR-003: Automated Calculation**: High-precision calculation of allowance amounts based on evaluation results and employment context.

### P1: Compliance & Traceability (Important)
- **FR-004: Criteria Mapping**: Direct integration with `CriteriValutazione` and `CriteriOption` resources for structured scoring.
- **FR-005: Audit Proof**: Immutable history of evaluations and final calculations to provide evidence during labor audits.

### P2: Advanced Policy (Nice-to-have)
- **FR-006: Proactive Condition Monitoring**: Dashboards to identify and track organizational units with high-hardship conditions.
- **FR-007: AI Risk Correlation**: Correlation analysis between working conditions and safety incidents (integrated with Inail).

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Logic**: IndennitaCondizioniLavoro MUST NOT contain hardcoded labor contracts; all rates and rules are configurable via criteria.
- **Interoperability**: Consumes unit and employee data from `Xot` and `User`; results are consumed by `Sigma` for payroll.
- **Separation of Concerns**: Evaluation of *conditions* is separate from the evaluation of *individual performance*.

### Performance & Safety
- **NFR-001: Precision**: 100% calculation accuracy according to configured contractual formulas.
- **NFR-002: Immutable Audit**: Every final evaluation is historical and cannot be modified without a new version.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **Rating**: Core engine for evaluating criteria.
- **User**: Recipient identification.
### Data Model
- Allowances, Evaluations, Criteria, Results.
### Integration Points
- Results are consumed by the payroll sync actions (Sigma).

## 8. User Experience
- Guided evaluation forms that simplify complex contractual language into clear choices.
- Immediate preview of calculated allowance before final submission.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Calculation Accuracy | 100% | Manual sampling vs expected results. |
| Evaluation Time | < 5 mins | Duration of a single employee evaluation. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Union/labor contracts provide clear formulas for allowance calculations.
- Organizational units correctly reflect the physical working environment.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Subjective evaluation | Medium | Use strictly defined criteria and options. |
| Formula drift | High | Versioning for calculation rules and rates. |

## 11. Dependencies & Constraints
- Must align with Italian public sector labor contracts (CCNL).

## 12. Release Plan
### Phase 1: Registry & Evaluation (Stable)
- Core models and criteria management. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Logic & Calculation (Planned)
- Implementation of complex calculation formulas.
- Automated payroll export actions.

## 13. References
- [roadmap.md](roadmap.md)
