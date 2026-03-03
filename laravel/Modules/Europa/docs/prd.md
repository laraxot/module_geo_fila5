# Europa - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Europa Module Team

## 1. Purpose & Vision
The Europa module manages **European Union funded projects and grants** for the PTVX platform. It tracks project milestones, budgets, participants, and documentation, ensuring that EU funded activities meet the strict reporting and auditing requirements of European institutions.

## 2. Problem Statement
Managing EU projects is difficult because of:
- Complex multi-partner budget tracking.
- Strict requirement for time-reporting and evidence of activities.
- Frequent audits requiring all documentation and participant lists.
- Specific KPIs and milestones established at project start.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Project Manager** | EU Project Lead | Track progress, manage budget, coordinate partners. |
| **Financial Officer** | Grant Admin | Verify expenses, generate financial statements. |
| **Participant** | End User | Register for activities, submit time reports. |
| **EU Auditor** | Auditor | Browse all documents and proof of work for a project. |

## 4. Scope
### In Scope
- EU Project entity and lifecycle management.
- Budget allocation and tracking.
- Milestone and task management.
- Participant registration and attendance tracking.
- Centralized document repository for grant evidence.
- Reporting engine for EU templates.

### Out of Scope
- General external CRM features.
- Actual bank transfers (delegated to finance systems).

## 5. Functional Requirements
### FR-001: Project Lifecycle
- **Priority**: Must-have
- **Description**: Track a project from "Draft" -> "Submitted" -> "Approved" -> "Execution" -> "Completed".
- **Acceptance Criteria**: State machine for project statuses.

### FR-002: Attendance Tracking
- **Priority**: Must-have
- **Description**: Record attendance for workshops, meetings, and activities.
- **Acceptance Criteria**: Generate attendance sheets and signed proof.

### FR-003: Milestone Tracking
- **Priority**: Should-have
- **Description**: Monitor deadlines and deliverables established in the Grant Agreement.
- **Acceptance Criteria**: Notifications for upcoming or missed milestones.

### FR-004: Document Evidence
- **Priority**: Must-have
- **Description**: Attach files to specific projects or tasks for auditing purposes.
- **Acceptance Criteria**: Integrated with Media module with project-specific tagging.

## 6. Non-Functional Requirements
- **NFR-001: Auditability**: Every change must be traceable back to a user.
- **NFR-002: Document Persistence**: Ensure long-term storage of evidence (e.g., 7-10 years).
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **Media**: For document management.
- **Notify**: For milestone alerts.
### Data Model
- Projects, Milestones, Participants, Budget items.

## 8. User Experience
- Dedicated dashboard with project progress (e.g., progress bars, timeline).
- Simple interface for participants to sign-in to events.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Audit Failure Rate | 0% | Successful project closures. |
| Milestone Adherence | > 95% | Ratio of on-time milestones. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Projects follow standard EU grant structures.
- Users provide data in a timely manner.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Missing evidence for audit | Critical | System alerts for tasks without attached documents. |
| Budget overspend | High | Real-time budget tracking vs expenses. |

## 11. Dependencies & Constraints
- Must adhere to current EU General Financial Regulations.

## 12. Release Plan
### Phase 1: Core Tracking (Stable)
- Project and milestone CRUD. ✅
- Basic participant list. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Financial Reporting (Planned)
- Advanced budget tracking.
- Automatic generation of EU financial reports.

## 13. References
- [roadmap.md](roadmap.md)
