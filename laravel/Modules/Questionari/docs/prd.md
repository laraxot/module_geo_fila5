# Questionari - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Questionari Module Team

## 1. Purpose & Vision
The Questionari module provides a **flexible survey and questionnaire engine** for the Laraxot ecosystem. It enables organizational surveys, employee satisfaction checks, and data collection forms while providing advanced tools for data analysis, charting, and distribution.

## 2. Problem Statement
Organizations need:
- To collect feedback or data from large groups of people (employees/citizens).
- Diversified question types (Multiple choice, scale, open text, matrix).
- Automated analysis and visualization of results.
- Integration with other modules (e.g., performance self-assessment or feedback).
- Controlled distribution via email or authenticated links.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Survey Designer** | HR / Marketing Admin | Build complex surveys with logic and sections. |
| **Respondent** | End User / Citizen | User-friendly interface to complete surveys. |
| **Data Analyst** | Research Head | Export raw data, view charts and summaries of responses. |

## 4. Scope
### In Scope
- Questionnaire creation with multiple sections and pages.
- Rich set of question types (Text, Number, Date, MCQ, Checkbox, Scale).
- Conditional logic (Skip/Show logic based on answers).
- Respondent management (target lists, anonymous vs authenticated).
- Result analysis: charts (pie, bar) and raw data exports (Excel/CSV).
- Integration with external survey platforms (optional bridge).
- Filament resources for construction and analysis.

### Out of Scope
- Real-time polling/voting (requires a dedicated Live Voting module).
- External survey provider hosting (this is a native tool).

## 5. Functional Requirements
### FR-001: Questionnaire Builder
- **Priority**: Must-have
- **Description**: Drag-and-drop or structured UI to build questions and sections.
- **Acceptance Criteria**: Survey designers can create complex multi-page questionnaires.

### FR-002: Response collection
- **Priority**: Must-have
- **Description**: Public or private landing page for respondents to provide answers.
- **Acceptance Criteria**: Mobile-friendly, supports session saving for long questionnaires.

### FR-003: Data Visualization
- **Priority**: Should-have
- **Description**: Integrated charts for each question type to see trends at a glance.
- **Acceptance Criteria**: Real-time updates as new responses arrive.

### FR-004: Anonymous Surveys
- **Priority**: Should-have
- **Description**: Support for completely anonymous surveys for sensitive HR topics.
- **Acceptance Criteria**: Respondent identity is not stored or linked to answers.

## 6. Non-Functional Requirements
- **NFR-001: Performance**: Loading a long survey must be efficient.
- **NFR-002: Integrity**: Protection against multiple submissions from the same user if configured.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **UI**: Components for survey display.
- **Media**: For image-based questions or file uploads in responses.
### Data Model
- Questionari, Sezioni, Domande, Opzioni, Risposte.
### Integration Points
- Used by `Performance` for 360-degree feedback and self-evaluation.

## 8. User Experience
- Clean, minimal interface for respondents to minimize dropout.
- Guided "Step-by-step" wizard for designers.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Survey Completion Rate | > 60% | Completed vs started surveys. |
| Design Time | < 30 mins | Time to build a 20-question survey. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Respondents have modern browser access.
- Anonymous surveys genuinely protect user privacy at the database level.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data interpretation error | Medium | Clear labeling of charts and methodology. |
| Data loss during long survey | High | Auto-save draft functionality. |

## 11. Dependencies & Constraints
- Must comply with GDPR rules for survey-based data collection.

## 12. Release Plan
### Phase 1: Core Engine (Stable)
- Basic builder and response collection. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Analysis (Planned)
- Cross-tabulation and advanced filtering for results.
- Automated PDF report generation for survey summaries.

## 13. References
- [roadmap.md](roadmap.md)
