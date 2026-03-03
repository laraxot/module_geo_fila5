# Activity - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Activity Module Team

## 1. Purpose & Vision
The Activity module provides a comprehensive **audit trail and event sourcing infrastructure** for the PTVX platform. It tracks every user action and domain event using `spatie/laravel-activitylog` and `spatie/laravel-event-sourcing`, exposing data through specialized Filament resources.

## 2. Problem Statement
Enterprise HR systems require:
- Full traceability of user and system actions for compliance and security.
- Event sourcing capability to reconstruct system state at any point in time.
- Centralized audit logs for administrators and compliance officers.
- GDPR compliance through tracking of sensitive data operations.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **System Admin** | Auditor | Investigate anomalies, monitor system-wide changes. |
| **Compliance Officer** | Auditor | Generate audit reports, verify data integrity. |
| **Developer** | Builder | Replay stored events to debug or reconstruct state. |

## 4. Scope
### In Scope
- Automatic tracking of Eloquent model changes (Create/Update/Delete).
- Custom event logging (emails, PDFs, exports).
- Domain event storage with versioning and aggregate state.
- Aggregate state snapshots for optimized replay.
- Filament resources for Activity, Stored Events, and Snapshots.

### Out of Scope
- Public-facing activity feeds.
- Real-time notification delivery (Notify module).

## 5. Functional Requirements (Prioritized)

### P0: Core Audit & Events (Must-have)
- **FR-001: Automatic Eloquent Logging**: Traceability for all models via the `LogsActivity` trait.
- **FR-003: Domain Event Storage**: Maintain a history of domain events in the `stored_events` table with versioning.
- **FR-005: Activity Dashboard**: Searchable and filterable Filament resource for all activity logs.

### P1: System Reliability (Important)
- **FR-004: State Snapshots**: Capture snapshots of aggregate state to optimize event replay performance.
- **FR-008: Shared Action Interface**: `ListLogActivitiesAction` for cross-module integration in Filament resources.

### P2: Advanced Compliance (Nice-to-have)
- **FR-009: Retention Policies**: Automated cleanup of old logs according to GDPR requirements.
- **FR-010: Audit Export**: CSV/Excel export of activity logs for external auditors.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Cross-Cutting Service**: Activity acts as a passive observer; it MUST NOT depend on domain-specific modules.
- **Interoperability**: Provides standardized traits and actions that any module can use to enable logging.
- **Isolation**: Uses a dedicated `activity` database connection to ensure audit logs do not impact primary database performance.

### Performance & Safety
- **NFR-001: Performance**: Minimal overhead on model operations through asynchronous logging where possible.
- **NFR-002: Type Safety**: 100% PHPStan Level 10 compliance.
- **NFR-003: Data Integrity**: Event sourcing ensures that the current state can always be mathematically verified from the event stream.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base classes.
- **Spatie Activitylog**: Core logging engine.
- **Spatie Event Sourcing**: Event stream management.
### Data Model
- `activity_log`, `stored_events`, `snapshots`.

## 8. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Log Coverage | 100% | Audit of critical domain models. |
| Replay Accuracy | 100% | Integrity check of event stream vs current state. |
| PHPStan Compliance | Level 10 | Static analysis result. |
