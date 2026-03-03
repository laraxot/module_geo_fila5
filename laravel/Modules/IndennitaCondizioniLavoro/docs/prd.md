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

## 5. Functional Requirements
### FR-001: Allowance Definition
- **Priority**: Must-have
- **Description**: Define different types of allowances (hardship, hazard, etc.) with their base rates.
- **Acceptance Criteria**: Admin can create and version allowance types.

### FR-002: Condition Evaluation
- **Priority**: Must-have
- **Description**: Form-based evaluation of an employee's working conditions against defined criteria.
- **Acceptance Criteria**: Uses a structured survey/rating pattern to determine eligibility.

### FR-003: Automated Calculation
- **Priority**: Must-have
- **Description**: Calculate the gross allowance amount based on evaluation results and employment data.
- **Acceptance Criteria**: Results are auditable and exportable.

### FR-004: Criteria Management
- **Priority**: Should-have
- **Description**: Manage complex evaluation criteria through a unified interface.
- **Acceptance Criteria**: Integration with `CriteriValutazione` and `CriteriOption` resources.

## 6. Non-Functional Requirements
- **NFR-001: Traceability**: Every evaluation leading to an allowance must be historical and immutable once finalized.
- **NFR-002: Accuracy**: Calculations must precisely follow contractual formulas.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

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
