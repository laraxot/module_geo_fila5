# Performance - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Performance Module Team

## 1. Purpose & Vision
The Performance module is the **core evaluation and personnel development engine** for the PTVX platform. It manages the entire lifecycle of employee performance evaluation, from objective setting and self-assessment to final scoring and outcomes, facilitating a modern, merit-ocratic HR management culture.

## 2. Problem Statement
The organization needs:
- A standardized and objective way to evaluate employee performance.
- Tools for managers to set and track individual and organizational goals.
- Support for complex evaluation workflows (Self-assessment, Manager review, Validation).
- Linkage between performance results and monetary incentives.
- Historical records of employee growth and skill development.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Director** | Performance Architect | Define evaluation templates, manage cycles, oversee results. |
| **Manager** | Evaluator | Set objectives, evaluate team members, conduct feedback. |
| **Employee** | Data Subject | Perform self-assessment, view goals, track results. |
| **OIV** | Validation Body | Oversee and validate the fairness of the evaluation process. |

## 4. Scope
### In Scope
- Performance Evaluation Cycle management.
- Multi-step evaluation workflows (Self -> Mgr -> Val).
- Goal/Objective setting and tracking (OKR/KPI).
- Competency and skill mapping.
- Structured scoring based on weighted criteria.
- Historical data analysis and reporting.
- Association with incentives (Incentivi module).
- Filament resources for all user roles.

### Out of Scope
- Recruitment and Onboarding.
- Training management (delegated to specialized LMS integration).

## 5. Functional Requirements (Prioritized)

### P0: Evaluation Core (Must-have)
- **FR-001: Evaluation Cycle Lifecycle**: Manage the start, end, and transition of periodic evaluation cycles.
- **FR-002: Multi-step Workflow Orchestration**: Execute the evaluation path from self-assessment through manager review to final validation (OIV).
- **FR-003: Objective & KPI Tracking (OKR)**: Set and monitor measurable objectives with weights and results.

### P1: Competency & Reporting (Important)
- **FR-004: Standardized PDF Reporting**: Generate comprehensive, professional performance reports for employees and managers.
- **FR-005: Competency Mapping**: Register and evaluate specific skills and soft-skills as part of the evaluation process.
- **FR-006: Incentive Linkage**: Direct export of final scores to the `Incentivi` module for bonus calculation.

### P2: Advanced Merito-cracy (Nice-to-have)
- **FR-007: AI Performance Insights**: Automated detection of performance trends and potential skill gaps.
- **FR-008: Career Path Planning**: Suggestions for internal career growth based on evaluation history and skill competency.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Evaluation Engine**: Performance provides the orchestration logic; it MUST NOT contain hardcoded evaluation criteria (delegated to `Rating`).
- **Interoperability**: Consumes employee hierarchy and profiles from `User`; results are consumed by `Incentivi` and `Progressioni`.
- **Independence**: The cycle and workflow engine is abstracted from the specific organizational structure.

### Performance & Safety
- **NFR-001: Objectivity**: Mandatory audit trail for all score modifications to ensure fairness.
- **NFR-002: Confidentiality**: Strict encryption and role-based access for sensitive evaluation content.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **Rating**: (Optional but recommended) for scoring criteria.
- **User**: Core profiles and hierarchy.
- **Notify**: For cycle-related alerts.
### Data Model
- Cycles, Evaluations, Objectives, Skills.
### Integration Points
- Provides results used by `Incentivi` for bonus calculation.

## 8. User Experience
- Unified "Evaluation Center" where users can see all their active tasks.
- Guided form flows with context-sensitive help.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Cycle Completion Rate | > 95% | Completed vs total evaluations. |
| Transparency Score | > 4/5 | Employee satisfaction survey. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Organizational hierarchy is correctly maintained.
- Performance criteria are agreed upon before the cycle starts.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Evaluation bias | High | Multi-level validation (OIV review). |
| Technical dropout | Medium | Automated reminders and clear progress tracking. |

## 11. Dependencies & Constraints
- Must align with Italian P.A. "Sistema di Misurazione e Valutazione della Performance" (SMVP).

## 12. Release Plan
### Phase 1: Core Lifecycle (Stable)
- Cycle management and mult-step evaluations. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Analytics (Planned)
- Predictive analytics for performance trends.
- Career path suggestions based on evaluated skill gaps.

## 13. References
- [roadmap.md](roadmap.md)
- [module-analysis.md](module-analysis.md)
