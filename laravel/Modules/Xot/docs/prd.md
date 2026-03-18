# PRD: Xot Core Framework Module

## 📋 Executive Summary
Xot is the foundational module of the PTVX ecosystem. It provides the core abstractions, base classes, and behavioral guards (Nyquist validation, PHPStan Level 10) that ensure all other modules operate within a consistent architectural framework. Its primary mission is to eliminate boilerplate and enforce strict typing across the entire multi-tenant system.

## 👥 Target Personas
- **Module Developers**: Need reliable base classes (`XotBase*`) to build domain features rapidly.
- **System Architects**: Need to monitor compliance and architectural integrity.
- **AI Agents**: Need standardized patterns and rich metadata to assist in code generation and maintenance.
- **DevOps Engineers**: Need predictable module registration and discovery.

## 🎯 Functional Requirements (P0/P1)
- **P0: Base Abstractions**: Comprehensive set of wrappers for Laravel/Filament (`XotBaseModel`, `XotBaseResource`, `XotBasePage`, `XotBaseAction`).
- **P0: Module Registry**: Automatic discovery and initialization of all modules in `laravel/Modules/`.
- **P0: Strict Type Enforcement**: Global configuration for PHPStan Level 10 and strict types.
- **P1: Universal Helpers**: Shared traits for translations, logging (no `Log::debug`), and data transformation.
- **P1: Database Governance**: Dynamic connection management for modular isolation.

## 🛠️ Technical Specs
- **Architecture**: Modular Monolith foundation with Domain-Driven Design (DDD) principles.
- **Registry Pattern**: Each module registers its own service providers and resources via the `XotBaseServiceProvider`.
- **Validation**: Integrated Nyquist validation for complete feature coverage.
- **Database Schema**: Manages the `_prisma_migrations` and core system tables.

## 🔌 Service Interface (The Contract)
- **Extensibility**: All application modules MUST extend `XotBase` equivalents.
- **Property Access**: No `property_exists()` on models; use `getAttribute()` or `??`.
- **Action Pattern**: Business logic isolated in `Action` classes resolved via `app()`.

## 🛡️ Non-Functional Requirements
- **Quality Gate**: 100% PHPStan Level 10 compliance.
- **Performance**: Zero-to-negligible overhead for module discovery.
- **Security**: Strict multi-tenant data isolation at the foundation level.
- **Observability**: Standardized logging and tracing for cross-module operations.

## ✅ Release Criteria
- All core tests passing in Pest.
- Zero issues found by PHPMD and PHPInsights.
- Clear documentation for all `XotBase` wrappers.
