# MobilitaVolontaria - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: MobilitaVolontaria Team

## 1. Purpose & Vision
The MobilitaVolontaria module manages **voluntary employee mobility and transfer requests** for the PTVX platform. it provides a structured system to handle requests for internal transfers between organizational units, relocations, or change of role initiated by the employee, ensuring a transparent and merit-based mobility process.

## 2. Problem Statement
Managing internal transfers is complex because:
- Needs of the employee must be balanced with organizational requirements.
- Multiple requests for the same position require structured evaluation.
- Transfer history and current status must be easily accessible to HR.
- Documentation for transfer approvals must be formally recorded.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **HR Specialist** | Mobility Admin | Review requests, check eligibility, coordinate approvals between units. |
| **Employee** | Applicant | Submit transfer requests, track status, view open mobility opportunities. |
| **Dept Head** | Approver | Approve or reject incoming/outgoing transfer requests for their team. |

## 4. Scope
### In Scope
- Registry of internal mobility opportunities (announcements).
- Management of voluntary transfer requests submitted by employees.
- Eligibility check based on job profiles and time-in-role.
- Approval workflow between current and destination units.
- Documentation management for official transfer orders.
- History of employee mobility events.

### Out of Scope
- Mandatory/forced transfers (delegated to regular HR management).
- External recruitment (delegated to specialized Recruitment module).

## 5. Functional Requirements (Prioritized)

### P0: Mobility Lifecycle (Must-have)
- **FR-002: Request Submission Engine**: Secure form for employees to submit transfer requests with reasons and supporting files.
- **FR-003: Integrated Approval Workflow**: Multi-step approval process between current and destination unit managers.
- **FR-005: Eligibility Verification**: Automated check of eligibility based on job profile, time-in-role, and contract type.

### P1: Opportunity Management (Important)
- **FR-001: Mobility Announcements Board**: Public listing of internal roles or units open to mobility with defined deadlines.
- **FR-006: Official Transfer Documentation**: Automated generation of official transfer orders and hand-off records.

### P2: Advanced Talent Sourcing (Nice-to-have)
- **FR-004: Merit-based Ranking**: Evaluation and scoring of multiple applicants for the same slot using `Rating` criteria.
- **FR-007: Skill-Gap Analysis**: AI-driven assessment of how a transfer would impact the skill balance of departure and destination units.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Workflow**: MobilitaVolontaria MUST support various organizational approval chains through configurable workflow definitions.
- **Interoperability**: Consumes employee profiles from `User` and updates the unit association upon final approval.
- **Independence**: Mobility logic is managed as a standalone process, not hardcoded into the core organizational chart.

### Performance & Safety
- **NFR-001: Fairness**: Enforcement of objective criteria for all applicants to ensure merit-based decisions.
- **NFR-002: Confidentiality**: Strict privacy for transfer requests until the formal approval stage.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: Core employee profiles.
- **Media**: For request documentation.
- **Notify**: For workflow progress alerts.
### Data Model
- Announcements, Requests, Approvals, TransferHistory.
### Integration Points
- Updates the employee's organizational unit in the User module upon final approval.

## 8. User Experience
- Simple timeline view for the employee to see their request status.
- Dashboard for HR to manage active mobility calls and pending requests.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Mobility Cycle Time | < 30 days | Average time from request to final decision. |
| Satisfaction Rate | > 80% | Internal employee survey. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Unit heads are motivated to facilitate career development via mobility.
- Organization hierarchy is accurately represented in the system.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Blocking of key personnel | Medium | Limit for mobility requests within a certain period. |
| Skill gap in departure unit | High | Integration with a hand-off/knowledge transfer flag. |

## 11. Dependencies & Constraints
- Must align with internal HR policies and union agreements on mobility.

## 12. Release Plan
### Phase 1: Core Requests (Stable)
- Basic request registry and status tracking. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Workflow & Announcements (Planned)
- Full multi-step approval workflow.
- Public mobility announcements board.

## 13. References
- [roadmap.md](roadmap.md)
