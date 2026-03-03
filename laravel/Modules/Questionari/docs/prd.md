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

## 5. Functional Requirements (Prioritized)

### P0: Survey Engine (Must-have)
- **FR-001: Structural Questionnaire Builder**: Multilingual builder for sections and questions with diverse types (MCQ, Scale, Matrix).
- **FR-002: Secure Response Collection**: Mobile-friendly landing pages for data entry with session persistence.
- **FR-005: Conditional Logic**: Support for Skip/Show logic based on respondent answers.

### P1: Data Insights (Important)
- **FR-003: Real-time Data Visualization**: Integrated trend charts (Pie, Bar) for each question type within the admin panel.
- **FR-004: Anonymous Participation**: Support for verified anonymous surveys where respondent identity is decoupled from answers.
- **FR-006: Target Audience Management**: Distribution lists and authenticated link generation.

### P2: Advanced Feedback (Nice-to-have)
- **FR-007: Automated PDF Summaries**: Generate comprehensive executive summaries of survey results.
- **FR-008: AI Sentiment Analysis**: Qualitative analysis of open-text responses to detect overarching emotional trends.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Generic Feedback Tool**: Questionari provides the collection engine; it MUST NOT be tied to any specific business domain.
- **Interoperability**: Can be embedded into other modules (e.g., Performance self-assessment) through standardized components.
- **Isolation**: Survey responses are stored independently of the core user data to maintain anonymity when required.

### Performance & Safety
- **NFR-001: Performance**: Optimized loading for long, complex questionnaires with many assets.
- **NFR-002: Integrity**: Robust protection against multiple submissions and data loss via auto-save drafts.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
