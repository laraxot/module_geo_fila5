# Sigma - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Sigma Module Team

## 1. Purpose & Vision
The Sigma module acts as the **legacy integration and data bridge** for the Laraxot ecosystem. It contains abstractions and models for interacting with legacy Sigma databases, allowing the modern Laraxot application to consume and synchronize data with old systems (HR, Payroll, etc.) while gradually moving towards a modern architecture.

## 2. Problem Statement
The PTVX platform must:
- Integrate with existing legacy data from the Sigma system.
- Support a large number of legacy tables (1000+) without bloating the core.
- Provide a modern API and Model layer for old data.
- Handle data migration and mass updates from legacy formats to modern ones.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | Data Integrator | Access legacy data using modern Eloquent models. |
| **System Admin** | System Manager | Sync data between Sigma and Laraxot. |
| **Analyst** | Data Researcher | Query legacy tables for reports and historical analysis. |

## 4. Scope
### In Scope
- Definitions for hundreds of legacy Sigma tables as Eloquent models.
- Specialized database connection for Sigma integration.
- Actions for mass data cleanup and normalization.
- WebService bridge for remote legacy access.
- Mapping legacy codes to modern Laraxot entities.

### Out of Scope
- Developing new features inside the legacy system (read/sync only).
- Directly modifying legacy table schemas.

## 5. Functional Requirements
### FR-001: Legacy Data Access
- **Priority**: Must-have
- **Description**: Provide 1000+ Eloquent models for Sigma database tables.
- **Acceptance Criteria**: Developers can query `Sigma\Models\Ana00f` just like any other model.

### FR-002: Mass Normalization
- **Priority**: Must-have
- **Description**: Actions to fix common legacy data issues (upper/lowercase names, malformed codes).
- **Acceptance Criteria**: `MassUpdateCognomeNomeAction` and similar normalize data for better display.

### FR-003: WebService Bridge
- **Priority**: Should-have
- **Description**: Capability to fetch legacy data through a specialized WebService if direct DB access isn't available.
- **Acceptance Criteria**: Unified model API regardless of underlying driver.

### FR-004: Recursive Diffing
- **Priority**: Should-have
- **Description**: Identify differences between Laraxot state and Sigma legacy state.
- **Acceptance Criteria**: `DiffAssocRecursiveAction` reports discrepancies precisely.

## 6. Non-Functional Requirements
- **NFR-001: Cold Storage Efficiency**: Models must be lightweight since there are 1000+ of them.
- **NFR-002: Performance**: Large sync operations must be memory-efficient.
- **NFR-003: Compatibility**: Supports legacy database charset and collation.

## 7. Technical Architecture
### Dependencies
- **Xot**: Core framework.
- **Setting**: For dedicated Sigma database connection.
### Data Model
- 1000+ models representing Sigma legacy tables (Ana00f, Dip00f, etc.).
### Integration Points
- Consumed by almost all domain modules (Performance, Progressioni) for initial data seeding and ongoing sync.

## 8. User Experience
- Mostly developer-facing via models and CLI sync commands.
- Admin view to trigger mass updates or check sync status.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Table Coverage | 100% required tables | Model count vs DB table count. |
| Sync Accuracy | Zero data loss | Checksum comparison. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Sigma legacy schema is stable but complex.
- Direct database access is the primary integration method.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Naming collisions | Medium | Namespace all legacy models under `Sigma\Models`. |
| Performance overhead | High | Use cursors and optimized joins for large syncs. |

## 11. Dependencies & Constraints
- Reliance on the availability and uptime of the legacy Sigma database.

## 12. Release Plan
### Phase 1: Model Generation (Stable)
- Full model set generation. ✅
- Basic connection management. ✅
### Phase 2: Refined Normalization (Planned)
- Advanced data normalization actions.
- Automated drift detection between systems.

## 13. References
- [roadmap.md](roadmap.md)
