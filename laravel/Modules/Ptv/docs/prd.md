# Ptv - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Ptv Module Team

## 1. Purpose & Vision
The Ptv module is the **upstream integration and legacy proxy** for the PTVX platform. It handles the specific communication protocols, data mapping, and service orchestration required to interface with the core PTV (Provincia Trento Valutazione) legacy systems, acting as a gateway for data synchronization and procedural alignment.

## 2. Problem Statement
The PTVX platform must:
- Integrate with existing PTV legacy web services and databases.
- Handle legacy-specific data structures and translate them to Laraxot models.
- Orchestrate complex cross-system procedures (e.g., final evaluation submission to central systems).
- Provide a stable abstraction layer that isolates modern modules from legacy changes.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | Integration Engineer | Stable API and models to interact with PTV legacy data. |
| **System Admin** | Infrastructure Manager | Monitor integration health and sync performance. |
| **Data Analyst** | Reconciliation Specialist | Verify data consistency between PTVX and PTV core. |

## 4. Scope
### In Scope
- Web Service clients for PTV legacy endpoints (SOAP/REST).
- Specialized models for PTV-specific entities (e.g., `Dipendente`, `Struttura`).
- Data mapping logic (Transformers) between PTV and internal modules.
- Proxy actions for external system triggers.
- Multi-protocol support (DB Link, WebService, Flat-files).
- Filament resources for monitoring integration status.

### Out of Scope
- Modern HR business logic (lives in domain modules).
- Public-facing features.

## 5. Functional Requirements (Prioritized)

### P0: Integration Foundation (Must-have)
- **FR-001: Legacy Proxy Models**: Provide Eloquent-like models that interact with remote PTV legacy data (Dipendente, Struttura).
- **FR-002: Service Orchestration**: Coordinate sequences of calls to PTV services for complex operations with atomic execution.
- **FR-003: Data Transformation**: Map legacy field names and cryptic data structures to Laraxot's standard schema.

### P1: Enhanced Monitoring (Important)
- **FR-004: Integration Health Check**: Monitor the status of PTV web services and database links, reporting to Xot Health.
- **FR-005: Proxy Actions**: Standardized actions to trigger external system procedures from PTVX.

### P2: Advanced Sync (Nice-to-have)
- **FR-006: Automated Reconciliation**: Generation of discrepancy reports between systems.
- **FR-007: Webhook Ingestion**: Real-time sync from legacy systems.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Isolation of Legacy**: All PTV-specific logic (SOAP, DB Links) MUST be contained within this module.
- **Interoperability**: Exposes data to other modules (User, Performance) through standardized Laraxot models, shielding them from legacy complexity.
- **Agnostic consumption**: Other modules do not need to know the source of data (DB Link vs API).

### Performance & Safety
- **NFR-001: Robustness**: Graceful handling of external system timeouts and errors.
- **NFR-002: Performance**: Caching of frequently accessed remote data (TTL 1h).
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **Setting**: For connection strings and API keys.
### Integration Points
- Serves data to `User`, `Performance`, and `Progressioni`.
### Core Rule
- The Ptv module should be the *only* module directly calling PTV legacy web services.

## 8. User Experience
- (Admin) "Integration Dashboard" showing uptime and latency of external services.
- Detailed logs for failed transformation or proxy calls.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Sync Latency | < 5s | Time to fetch remote employee details. |
| Transformation Error Rate| < 0.1% | Logs of mapping failures. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- PTV legacy APIs are stable and well-documented.
- Network connectivity between PTVX and PTV core is reliable.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Breaking API changes | High | Versioned service clients and transformers. |
| Inconsistent data types | Medium | Strict validation during transformation phase. |

## 11. Dependencies & Constraints
- Must adhere to the security protocols mandated by Provincia Autonoma di Trento.

## 12. Release Plan
### Phase 1: Core Proxy (Stable)
- Base web service clients and mapping logic. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Orchestration (Planned)
- Fully automated reconciliation reports.
- Bi-directional real-time sync via webhooks.

## 13. References
- [roadmap.md](roadmap.md)
- [business-logic-ptv.md](business-logic-ptv.md)
