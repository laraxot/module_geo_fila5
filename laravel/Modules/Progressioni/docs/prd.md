# Progressioni - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Progressioni Module Team

## 1. Purpose & Vision
The Progressioni module manages **career advancements and salary step increases** for the PTVX platform. It automates the evaluation of eligibility for horizontal or vertical career progression (in Italy, "Progressioni Economiche Orizzontali" - PEO) based on seniority and performance scores, ensuring merit-based career paths.

## 2. Problem Statement
Managing career progression manually is error-prone because:
- Eligibility rules depend on multiple factors (years in role, absence limits, disciplinary record).
- Evaluation scores must be aggregated from multiple cycles of the Performance module.
- Ranking lists (graduatorie) must be generated according to complex tie-breaking rules.
- High impact on future payroll budget requires precise calculations.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Specialist** | Progression Admin | Define progression calls, verify eligibility, generate rankings. |
| **Employee** | Applicant | View eligibility status, check progress towards next step. |
| **Dept Head** | Evaluator | Provide specific feedback for career promotion candidates. |

## 4. Scope
### In Scope
- Definition of Progression "Calls" or "Cycles".
- Automatic eligibility check (Seniority, Performance, etc.).
- Scoring engine that aggregates data from other modules.
- Generation of provisional and final ranking lists (graduatorie).
- Workflow for applicant review and objection handling.
- Management of salary step (gradino) assignment.

### Out of Scope
- Performance evaluation itself (delegated to Performance module).
- Disciplinary actions (delegated to specialized module).

## 5. Functional Requirements
### FR-001: Cycle Definition
- **Priority**: Must-have
- **Description**: Define the parameters for a new career progression cycle (year, available budget, eligible roles).
- **Acceptance Criteria**: Admin can define the required number of years in current profile as a filter.

### FR-002: Automatic Scoring
- **Priority**: Must-have
- **Description**: Aggregate scores from `Performance` module and seniority data from `User` module.
- **Acceptance Criteria**: Scored results are auditable and show the breakdown of the total points.

### FR-003: Ranking Generation
- **Priority**: Must-have
- **Description**: Sort eligible employees by score, applying tie-breaking rules (seniority, age, etc.).
- **Acceptance Criteria**: Correct generation of a list with an "assigned" vs "not assigned" flag based on budget.

### FR-004: Objection Management
- **Priority**: Should-have
- **Description**: Allow employees to contest their ranking position within a certain timeframe.
- **Acceptance Criteria**: Workflow for logging, reviewing, and responding to objections.

## 6. Non-Functional Requirements
- **NFR-001: Objectivity**: All scoring must be derived from system data to avoid bias.
- **NFR-002: Transparency**: Employees can see their score breakdown.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base infrastructure.
- **Performance**: For evaluation scores.
- **User**: For seniority and profile data.
### Data Model
- ProgressionCycles, Applicants, ScoringLogic, Graduatorie.
### Integration Points
- Final outcomes update the employee's salary step in the `User` or `Sigma` module.

## 8. User Experience
- Clear table view for HR to compare candidates.
- Personal "Career Status" view for employees.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Eligibility Error Rate | < 1% | Audit of excluded vs included employees. |
| Automation Rate | > 90% | Ratio of auto-calculated scores vs manual entries. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Historical performance data is complete in the Performance module.
- Seniority dates are accurately recorded in the User profiles.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data inconsistency | High | Pre-cycle "Data Audit" step for HR. |
| Legal contested rankings | Medium | Strict adherence to documented tie-breaking rules. |

## 11. Dependencies & Constraints
- Must comply with public sector national labor agreements (CCNL).

## 12. Release Plan
### Phase 1: Core Scoring (Stable)
- Basic cycle management and score aggregation. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Workflow & Reporting (Planned)
- Full objection management UI.
- Automated official decrees for career changes.

## 13. References
- [roadmap.md](roadmap.md)
