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

## 5. Functional Requirements (Prioritized)

### P0: Legacy Bridge (Must-have)
- **FR-001: Extensive Legacy Model Registry**: Support for 1000+ Eloquent models representing Sigma legacy tables with dedicated connection.
- **FR-002: Mass Data Normalization Engine**: Centralized actions for mass fixing common legacy data issues (e.g., casing, malformed codes).
- **FR-005: Mapping Infrastructure**: Link legacy Sigma codes (organizational, personal) to modern Laraxot entities.

### P1: Data Integrity & Sync (Important)
- **FR-003: Remote WebService Proxy**: Capability to fetch and update legacy data through a specialized WebService bridge.
- **FR-004: Recursive State Diffing**: Identification and reporting of discrepancies between Laraxot state and Sigma legacy state.

### P2: Transition Intelligence (Nice-to-have)
- **FR-006: Automated Drift Detection**: Continuous monitoring for data inconsistencies between systems with proactive alerts.
- **FR-007: AI Data Cleansing**: Heuristic suggestions for mapping and normalizing ambiguous legacy records.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Proxy Layer**: Sigma provides the technical access to legacy data; it MUST NOT contain modern HR or performance business logic.
- **Interoperability**: Provides a standardized Model layer that all domain modules (Performance, Progressioni) consume for initial seeding and ongoing synchronization.
- **Data Isolation**: Legacy Sigma models are namespaced under `Sigma\Models` to avoid collisions with modern domain models.

### Performance & Safety
- **NFR-001: Infrastructure Efficiency**: Models must be extremely lightweight to avoid overhead during the registration of 1000+ classes.
- **NFR-002: Memory Management**: Use of database cursors and chunked processing for large-scale data sync and normalization.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
