# Badge - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Badge Module Team

## 1. Purpose & Vision
The Badge module manages **employee identification cards and access control badges** for the PTVX platform. It handles badge issuance, printing, status tracking (active/lost/expired), and integration with physical access systems, providing a centralized record of identity credentials.

## 2. Problem Statement
The PTVX HR system needs:
- Centralized tracking of all physical identification badges issued to employees.
- Support for multiple badge types (employee, contractor, visitor).
- Ability to manage badge lifecycle (issuance, suspension, renewal).
- Integration with printing systems and physical access control readers.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Human Resources** | HR Manager | Manage badge issuance for new employees, verify current status. |
| **Security Dept** | Security Officer | Track active/lost badges, monitor access control points. |
| **Employee** | Data Subject | View and request replacement for lost or damaged badges. |

## 4. Scope
### In Scope
- Badge entity and lifecycle management.
- Badge status tracking (Active, Inactive, Lost, Stolen, Expired).
- Association of badges with User profiles.
- Support for various badge formats and technologies.
- Filament resources for admin management.

### Out of Scope
- Physical printing firmware (delegated to printer drivers).
- Direct access control hardware communication (delegated to specialized middleware).

## 5. Functional Requirements (Prioritized)

### P0: Badge Lifecycle (Must-have)
- **FR-001: Badge Issuance**: Register physical badges with unique IDs linked to User profiles.
- **FR-002: Status Tracking**: Comprehensive history of badge status changes (Active, Inactive, Stolen, Expired).

### P1: Operational Efficiency (Important)
- **FR-003: Printing Preparation**: Generate print-ready metadata or PDFs with employee photos and identifiers.
- **FR-004: Multi-type Support**: Categories for employees, contractors, and visitors with specific metadata requirements.

### P2: Advanced Integration (Nice-to-have)
- **FR-005: Access Middleware**: Proxy API for synchronizing with physical access control systems.
- **FR-006: Self-Service Portal**: Employee interface to report lost badges and request replacements.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Hardware Agnosticism**: Badge module MUST remain independent of any specific printer or reader hardware vendor.
- **Interoperability**: Provides status data to Security and HR modules via standardized interfaces.
- **Isolation**: Badge-specific data remains encapsulated; it does not modify the core User schema.

### Performance & Safety
- **NFR-001: Uniqueness**: Global uniqueness constraint for badge identifiers.
- **NFR-002: Auditability**: Every status change must be recorded for security compliance.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: For employee association.
### Data Model
- `badges`: Core table for badge records and metadata.
### Integration Points
- Interfaced by Security for access logic and HR for onboarding.

## 8. User Experience
- Admin views to quickly search/filter badges by employee name or badge ID.
- Clear status indicators (e.g., green for Active, red for Stolen).

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Issuance Accuracy | 100% | No duplicate badge IDs. |
| Compliance Score | 100% | Audit of active employees vs active badges. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Every employee has exactly one primary active badge at a time.
- Physical infrastructure (printers/readers) exists.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Duplicate ID entry | High | Database level unique constraints. |
| Lost badge delay | Medium | System alerts for quick revocation. |

## 11. Dependencies & Constraints
- Must remain driver-agnostic to support different hardware vendors.

## 12. Release Plan
### Phase 1: Core Management (Stable)
- Basic badge CRUD and status management. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Integration & Printing (Planned)
- Advanced PDF generation for batch printing.
- API for external access control integration.

## 13. References
- [roadmap.md](roadmap.md)
