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

## 5. Functional Requirements (Prioritized)

### P0: Advancement Lifecycle (Must-have)
- **FR-001: Progression Cycle Definition**: Define parameters for career advancement calls (budget, eligibility roles, seniority filters).
- **FR-002: Automated Merit Scoring**: Aggregate and calculate scores from `Performance` history and `User` seniority data.
- **FR-003: Ranking Engine (Graduatorie)**: Generate auditable ranking lists applying complex tie-breaking rules (seniority, age).

### P1: Compliance & Review (Important)
- **FR-004: Objection Management Workflow**: Interface for employees to contest ranking positions and for HR to document reviews.
- **FR-006: Salary Step Integration**: Map successful progressions to specific salary steps (gradini) for payroll export.

### P2: Advanced Career Path (Nice-to-have)
- **FR-005: Multi-year Simulation**: Forecast the budgetary impact of various progression scenarios over multiple years.
- **FR-007: AI Eligibility Screening**: Proactive identification of employees approaching eligibility milestones for career growth.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Merit Engine**: Progressioni provides the scoring logic; it MUST NOT contain hardcoded career rules (which are defined in each "Call").
- **Interoperability**: Deeply integrated with `Performance` for scores and `User` for seniority; results are consumed by `Sigma` for payroll.
- **Independence**: The progression cycle is managed as a standalone legal procedure, decoupled from daily HR operations.

### Performance & Safety
- **NFR-001: Objectivity**: 100% derivation of scores from system-verified data to eliminate manual bias.
- **NFR-002: Transparency**: Visibility for employees into their individual score breakdown and ranking position.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
