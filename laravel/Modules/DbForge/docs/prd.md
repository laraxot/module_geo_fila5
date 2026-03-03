# DbForge - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: DbForge Module Team

## 1. Purpose & Vision
The DbForge module provides a suite of **database engineering and scaffolding utilities** for the Laraxot ecosystem. Its vision is to serve as a complete developer tool that syncs database schemas with application code (Models, Filament Resources, Pest Tests) to speed up module development.

## 2. Problem Statement
Developer productivity is hampered by:
- Manual creation of models and resources from existing database tables.
- Drifting schemas that are not reflected in application code.
- Repetitive boilerplate for basic CRUD generation.
- Difficulty in inspecting and manipulating database structure in multi-tenant environments.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | Module Builder | Scaffolding tools to generate application code from DB. |
| **System Admin** | Infrastructure Manager | Database inspection and maintenance utilities. |
| **Integrator** | System Analyst | Analyze existing schemas for legacy integrations. |

## 4. Scope
### In Scope
- Database schema inspection and metadata extraction.
- Automatic generation of Xot-compliant Models.
- Automatic generation of XotBase Filament Resources.
- Syncing database changes with application artifacts.
- Utilities for database manipulation and cleanup.

### Out of Scope
- Database backups and restoration (delegated to standard Laravel/Spatie tools).
- Designing new database schemas (use migrations instead).

## 5. Functional Requirements
### FR-001: Schema Inspection
- **Priority**: Must-have
- **Description**: Inspect existing database tables and retrieve detailed information about columns, types, and indexes.
- **Acceptance Criteria**: Admin can view detailed schema info for any connected database in Filament.

### FR-002: Model Generation
- **Priority**: Must-have
- **Description**: Generate a complete `XotBaseModel` file from an existing table.
- **Acceptance Criteria**: Generated models include correct property annotations and relation suggestions.

### FR-003: Filament Scaffolding
- **Priority**: Should-have
- **Description**: Generate a basic `XotBaseResource` and associated pages from a model/table.
- **Acceptance Criteria**: Generated resource follows Laraxot architectural principles.

### FR-004: Test Generation
- **Priority**: Could-have
- **Description**: Generate basic Pest feature tests for a given database table or resource.
- **Acceptance Criteria**: Generated tests can be run immediately and cover basic CRUD operations.

## 6. Non-Functional Requirements
- **NFR-001: Safety**: Scaffolding must not overwrite existing files without explicit user confirmation.
- **NFR-002: Accuracy**: Mapping between SQL types and PHP types must be precise.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance for all utilities.

## 7. Technical Architecture
### Dependencies
- **Xot**: Core framework.
- **Setting**: For managing various database connections.
### Integration Points
- Directly interacts with various database drivers via the `DatabaseConnection` model from `Setting`.

## 8. User Experience
- Interactive CLI commands for generation.
- Admin interface to browse tables and trigger code generation.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Time-to-Resource | < 30 seconds | Time to generate ready-to-use CRUD from table. |
| Code Compliance | 100% | Generated code must pass PHPStan Level 10. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Database schema is reasonably well-structured (naming conventions).
- DB user has sufficient privileges to read metadata.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Overwriting custom code | High | Mandatory `-force` flag and file diffs. |
| Complex schema mapping | Medium | Manual override for type mapping. |

## 11. Dependencies & Constraints
- PHP 8.3+, Laravel 12.
- Adheres to Super Mucca coding standards.

## 12. Release Plan
### Phase 1: Core Scaffolding (In Progress)
- Schema inspection. ✅
- Basic model generation. ✅
### Phase 2: Complete Scaffolding (Planned)
- Advanced Filament resource generation.
- Automatic Pest test generation.

## 13. References
- [roadmap.md](roadmap.md)
