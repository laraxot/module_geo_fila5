# Tenant - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Tenant Module Team

## 1. Purpose & Vision

The Tenant module provides **multi-tenancy infrastructure** for the Laraxot ecosystem, enabling multiple isolated instances of the application to operate on a single codebase. Each tenant has its own data, configuration, domains, and subscriptions.

## 2. Problem Statement

Enterprise SaaS and multi-entity deployments require:
- Data isolation between organizations/entities
- Per-tenant domain and configuration management
- Subscription-based feature gating
- Seamless tenant switching without code changes

## 3. Target Users

| User | Role | Needs |
|------|------|-------|
| **Super Admin** | Platform operator | Create/manage tenants, assign domains |
| **Tenant Admin** | Organization admin | Configure tenant settings, manage subscriptions |
| **Developer** | Module builder | Tenant-aware models and queries |

## 4. Scope

### In Scope
- Tenant CRUD and lifecycle management
- Domain-to-tenant mapping (`Domain`, `TenantDomain`)
- Per-tenant settings (`TenantSetting`)
- Subscription management (`TenantSubscription`)
- Tenant name resolution (`GetTenantNameAction`)

### Out of Scope
- User authentication (User module)
- Billing/payment processing (external systems)
- Per-tenant database separation (uses row-level isolation)

## 5. Functional Requirements

### FR-001: Tenant Management
- **Priority**: Must-have
- **Description**: Full CRUD for tenants with admin panel via `DomainResource`
- **Acceptance Criteria**: Super admin can create, update, delete tenants

### FR-002: Domain Mapping
- **Priority**: Must-have
- **Description**: Map custom domains to tenants for white-label deployments
- **Acceptance Criteria**: Accessing a mapped domain resolves to correct tenant context

### FR-003: Tenant Settings
- **Priority**: Should-have
- **Description**: Per-tenant configuration using schemaless attributes
- **Acceptance Criteria**: Each tenant can override default settings

### FR-004: Subscription Management
- **Priority**: Could-have
- **Description**: Feature-gated access based on subscription tier
- **Acceptance Criteria**: Tenant features restricted by subscription level

## 6. Non-Functional Requirements

### NFR-001: Data Isolation
- Row-level tenant isolation enforced at model layer
- No cross-tenant data leakage

### NFR-002: Performance
- Tenant resolution < 10ms per request
- Efficient query scoping without N+1

## 7. Technical Architecture

### Dependencies
- **Xot**: Base classes
- **User**: Tenant-user association

### Data Model
- `tenants` — Tenant registry
- `domains` / `tenant_domains` — Domain mapping
- `tenant_settings` — Per-tenant configuration (JSON)
- `tenant_subscriptions` — Subscription data

### Integration Points
- Global middleware for tenant resolution
- Tenant-scoped query scopes on all models
- `GetTenantNameAction` for cross-module tenant identification

## 8. User Experience

- **Admin panel**: Tenant list with domain configuration
- **Transparent**: End users see their tenant's branding/domain without awareness of multi-tenancy

## 9. Success Metrics & KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| Tenant resolution time | < 10ms | Middleware profiling |
| Data isolation | 100% | Security audit |
| PHPStan Level 10 | 0 errors | PHPStan analysis |

## 10. Risks & Assumptions

### Assumptions
- Row-level isolation is sufficient (no per-tenant databases)
- All modules respect tenant scoping via base model

### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Cross-tenant data leak | Critical | Automated isolation tests |
| Performance with many tenants | Medium | Caching tenant resolution |

## 11. Dependencies & Constraints

- **Technical**: PHP 8.3+, Laravel 12
- **Architectural**: All models must extend tenant-aware base classes.

## 12. Release Plan

### Phase 1: Core Multi-Tenancy (Stable)
- Tenant CRUD ✅
- Domain mapping ✅
- Tenant-scoped queries ✅

### Phase 2: Advanced Features (Planned)
- Subscription tier management
- White-label theming per tenant
- Tenant analytics dashboard

## 13. References

- [roadmap.md](roadmap.md)
- [module.md](module.md)
