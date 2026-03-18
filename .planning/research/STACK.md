# Stack Research: HR & Performance Evaluation System Enhancements

**Domain:** HR & Performance Evaluation for Italian Public Administrations  
**Researched:** 2026-03-18  
**Confidence:** HIGH  
**Context:** BROWNFIELD — 42+ modules already deployed in production

---

## Executive Summary

PTVX Fila5 Mono is a mature enterprise system built on Laravel 12.47 and Filament v5. This research focuses on **enhancements and optimizations** for the existing stack, not greenfield recommendations. All suggestions consider:

- **Regulatory compliance** (D.Lgs. 150/2009, GDPR, Italian PA requirements)
- **Multi-tenant architecture** with data isolation
- **Auditability** for all calculations and workflows
- **Integration requirements** (Sigma, Europa, Pdnd)
- **Performance** for large administrations (1000+ employees)

---

## Current Stack Assessment

### ✅ What's Working Well

| Component | Current Version | Assessment | Notes |
|-----------|----------------|------------|-------|
| **Laravel** | 12.47.0 | ✅ Excellent | Latest stable, well-configured |
| **Filament** | v5.0.0 | ✅ Excellent | Modern admin panel, XotBase wrappers |
| **PHP** | 8.2+ | ✅ Excellent | Modern features, strict typing |
| **Pest** | v4 | ✅ Excellent | Modern testing syntax |
| **PHPStan** | Level 10 | ✅ Excellent | Maximum strictness achieved |
| **Spatie Data** | 4.7 | ✅ Excellent | Type-safe DTOs |
| **Queueable Actions** | 2.16 | ✅ Excellent | Clean business logic |
| **Redis** | Configured | ✅ Good | Queue + cache driver |
| **Pulse** | 1.2 | ✅ Good | Basic monitoring active |
| **Sentry** | Latest | ✅ Good | Error tracking active |

### ⚠️ Areas for Enhancement

| Area | Current State | Issue | Priority |
|------|---------------|-------|----------|
| **PDF Generation** | Mixed (DomPDF + spatie/laravel-pdf + spipu/html2pdf) | Inconsistent engines, maintenance overhead | HIGH |
| **Queue Management** | Database driver (default) | Limited visibility, no Horizon | MEDIUM |
| **Excel Processing** | Maatwebsite 3.1 | Good but could optimize large exports | MEDIUM |
| **API Documentation** | Not standardized | External PA integrations need OpenAPI | HIGH |
| **Performance Monitoring** | Pulse only | Missing APM depth | MEDIUM |
| **Security Scanning** | Basic | PA compliance requires more | HIGH |
| **Feature Flags** | Pennant 1.11 | Underutilized | LOW |
| **Search** | Database queries | Missing full-text optimization | MEDIUM |

---

## Recommended Stack Enhancements

### Core Technologies

| Technology | Version | Purpose | Why Recommended | Confidence |
|------------|---------|---------|-----------------|------------|
| **Laravel** | 12.x (current) | Framework | ✅ Keep current — latest stable, no upgrade needed | HIGH |
| **Filament** | v5.x (current) | Admin panel | ✅ Keep current — excellent ecosystem, active development | HIGH |
| **PHP** | 8.3+ (upgrade from 8.2) | Language | PHP 8.3 adds typed class constants, improved enums | HIGH |
| **Redis** | 7.0+ | Cache/Queue | Upgrade from 6.x for better performance, Lua scripting | MEDIUM |
| **PostgreSQL** | 16+ (alternative to MySQL) | Database | Better JSON support, full-text search for PA compliance | MEDIUM |

### Supporting Libraries (New Additions)

#### 1. API Documentation & Integration

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`laravel-openapi`** (dedoc) | ^3.0 | Auto-generate OpenAPI specs from routes | External PA integrations (Sigma, Europa, Pdnd) | HIGH |
| **`saloonphp/laravel-saloon`** | ^3.0 | API client SDK builder | Standardize external API integrations | HIGH |
| **`spatie/laravel-rate-limiter`** | ^2.0 | Rate limiting for API endpoints | PA API compliance, throttling | MEDIUM |

**Rationale**: Italian PA integrations require standardized API documentation. OpenAPI enables automatic client generation for external systems. Saloon provides type-safe API clients with retry logic.

**Installation**:
```bash
composer require dedoc/laravel-openapi
composer require saloonphp/laravel-saloon
composer require saloonphp/laravel-plugin
```

**Migration Path**:
1. Add OpenAPI annotations to existing controllers
2. Generate `/api/docs` endpoint
3. Create Saloon connectors for Sigma, Europa, Pdnd
4. Replace raw Guzzle calls with Saloon requests

---

#### 2. PDF Generation Standardization

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`spatie/laravel-pdf`** | ^1.5 (keep) | PDF generation | Official documents, certificates | HIGH |
| **`dompdf/dompdf`** | ^3.0 (upgrade from barryvdh) | Simple PDFs | Internal reports, basic exports | MEDIUM |
| **`spipu/html2pdf`** | ^5.3.3 (upgrade from 5.2) | Complex layouts | Performance evaluation forms | MEDIUM |

**⚠️ RECOMMENDATION: Consolidate to Single Engine**

**Option A: Spatie Laravel PDF (Recommended)**
- Uses Browsershot (Chromium) — best HTML/CSS support
- Better for complex Italian PA forms
- Active maintenance
- Already used in Incentivi module

**Option B: DomPDF Only**
- Simpler, no external dependencies
- Good for basic documents
- Less accurate CSS rendering

**Avoid**: Maintaining 3 PDF engines (current state)

**Migration Path**:
```bash
# Keep spatie/laravel-pdf, remove others gradually
composer require spatie/laravel-pdf
composer remove barryvdh/laravel-dompdf  # After migration
# Keep spipu/html2pdf only if specific features needed
```

**Confidence**: HIGH — Spatie PDF provides best balance of features and maintainability

---

#### 3. Queue & Job Processing

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`laravel/horizon`** | ^5.27 | Redis queue dashboard | Production queue monitoring | HIGH |
| **`spatie/laravel-queueable-action`** | ^2.16 (keep) | Queueable actions | Business logic (already excellent) | HIGH |
| **`spatie/laravel-failed-job-monitor`** | ^1.2 | Failed job alerts | Production reliability | MEDIUM |

**Current Issue**: Using `database` queue driver (config/queue.php line 16)

**Recommendation**: Switch to Redis + Horizon

```bash
composer require laravel/horizon
composer require spatie/laravel-failed-job-monitor
```

**Configuration**:
```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'redis'), // Changed from 'database'

'horizon' => [
    'domains' => ['ptvx.localhost'],
    'path' => 'horizon',
    'middleware' => ['web', 'auth'],
],
```

**Benefits**:
- Real-time queue monitoring
- Failed job alerts
- Worker management
- Performance metrics

**Confidence**: HIGH — Horizon is production standard for Laravel queues

---

#### 4. Search & Full-Text

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`laravel/scout`** | ^10.0 | Full-text search | Employee search, document search | MEDIUM |
| **`meilisearch/meilisearch-laravel`** | ^1.0 | Search engine | Better than database LIKE queries | MEDIUM |
| **`spatie/laravel-search`** | ^1.0 | Database search | Simple use cases | LOW |

**Current State**: Database queries with LIKE (slow for large datasets)

**Recommendation**: Scout + Meilisearch for large administrations

```bash
composer require laravel/scout
composer require meilisearch/meilisearch-laravel
```

**When to Use**:
- ✅ Administrations with 500+ employees
- ✅ Document-heavy modules (Performance, Incentivi)
- ❌ Small administrations (<100 employees) — database search sufficient

**Confidence**: MEDIUM — Depends on deployment size

---

#### 5. Security & Compliance

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`spatie/laravel-security-health-check`** | ^1.0 | Security checks | Production deployments | HIGH |
| **`laravel/sanctum`** | ^4.0 | API tokens | Internal API auth (lighter than Passport) | HIGH |
| **`beyondcode/laravel-self-diagnosis`** | ^1.0 | Environment checks | Pre-deployment validation | MEDIUM |
| **`sensiolabs/security-checker`** | ^6.0 | Dependency vulnerabilities | CI/CD pipeline | HIGH |

**Current Issue**: Passport is heavy for internal APIs

**Recommendation**:
```bash
composer require laravel/sanctum
composer require spatie/laravel-security-health-check
composer require sensiolabs/security-checker --dev
```

**PA Compliance**:
- Security health checks for INAIL requirements
- Dependency scanning for anti-corruption (Law 109/2016)
- Audit logging enhancement via Activity module

**Confidence**: HIGH — Security is critical for PA systems

---

#### 6. Performance Optimization

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`laravel/octane`** | ^2.0 | Application server | High-traffic deployments | MEDIUM |
| **`spatie/laravel-responsecache`** | ^7.6 (keep) | Response caching | Already configured well | HIGH |
| **`renatomarinho/laravel-page-speed`** | ^2.0 | Auto-optimization | Frontend performance | LOW |
| **`barryvdh/laravel-debugbar`** | ^3.14 (dev only) | Debugging | Development only | HIGH |

**Current State**: Good caching, no Octane

**Recommendation**: Octane for large deployments

```bash
composer require laravel/octane
# Choose Swoole or RoadRunner
pecl install swoole
```

**When to Use**:
- ✅ 1000+ concurrent users
- ✅ Batch operations (massive PDF generation)
- ❌ Small deployments — traditional PHP-FPM sufficient

**Confidence**: MEDIUM — Only needed for scale

---

#### 7. Testing Enhancements

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`pestphp/pest`** | v4 (keep) | Testing | ✅ Perfect current setup | HIGH |
| **`spatie/pest-plugin-snapshots`** | ^2.0 | Snapshot testing | PDF output, API responses | MEDIUM |
| **`brianium/paratest`** | ^7.0 | Parallel testing | Faster test suite | MEDIUM |
| **`laravel/dusk`** | ^8.0 | Browser testing | E2E workflows | LOW |

**Current State**: Excellent Pest v4 setup

**Recommendation**: Add snapshot testing for PDFs

```bash
composer require --dev spatie/pest-plugin-snapshots
composer require --dev brianium/paratest
```

**Example**:
```php
it('generates correct PDF', function () {
    $pdf = app(GeneratePdfAction::class)->execute($data);
    
    expect($pdf->getContent())
        ->toMatchSnapshot('performance-evaluation-pdf');
});
```

**Confidence**: HIGH — Snapshot testing prevents regressions

---

#### 8. Monitoring & APM

| Library | Version | Purpose | When to Use | Confidence |
|---------|---------|---------|-------------|------------|
| **`laravel/pulse`** | ^1.2 (keep) | Application monitoring | ✅ Good baseline | HIGH |
| **`spatie/laravel-health`** | ^1.29 (keep) | Health checks | ✅ Excellent current setup | HIGH |
| **`sentry/sentry-laravel`** | * (keep) | Error tracking | ✅ Production ready | HIGH |
| **`clockwork-laravel/clockwork`** | ^5.0 | Debugging toolbar | Development alternative to Debugbar | LOW |
| **`laravel/telescope`** | ^5.0 | Debug assistant | Development only | MEDIUM |

**Current State**: Excellent (Pulse + Health + Sentry)

**Recommendation**: Keep current stack, add Telescope for dev

```bash
composer require --dev laravel/telescope
```

**PA Compliance Monitoring**:
- Add custom Pulse cards for evaluation cycles
- Health checks for external integrations (Sigma, Pdnd)
- Sentry performance monitoring for slow queries

**Confidence**: HIGH — Current monitoring is production-grade

---

## Packages to Avoid

### ❌ Do NOT Add

| Package | Why Avoid | Better Alternative |
|---------|-----------|-------------------|
| **`tymon/jwt-auth`** | Laravel Passport/Sanctum are official | Use Sanctum for tokens |
| **`prettus/l5-repository`** | Over-engineering, Actions pattern is better | Keep Spatie QueueableAction |
| **`flightsafety/laravel-enum`** | Native PHP 8.3 enums are superior | Use PHP backed enums |
| **`laravelcollective/html`** | Deprecated, use Blade components | Native Blade components |
| **`way/generators`** | Deprecated, use `make:` commands | Laravel Artisan generators |
| **`orangehill/iseed`** | Maintenance issues | Use native seeders |
| **`zizaco/entrust`** | Abandoned | Spatie Permission (already using) |
| **`barryvdh/laravel-translation-manager`** | UI-based translations are risky | Use Lang module (already exists) |
| **`intervention/image`** | v2 has licensing issues | Use `spatie/laravel-medialibrary` (already using) |
| **`rap2hpoutre/laravel-log-viewer`** | Security risk in production | Use Telescope or custom admin page |

### ⚠️ Use with Caution

| Package | Concern | Mitigation |
|---------|---------|------------|
| **`nwidart/laravel-modules`** | Performance overhead | Already committed, use caching |
| **`maatwebsite/excel`** | Memory usage for large exports | Use queued exports (already implemented) |
| **`spatie/laravel-event-sourcing`** | Complexity | Only in Activity module where needed |
| **`livewire/livewire`** | Payload size for complex pages | Use Flux components, lazy loading |

---

## Version Compatibility Matrix

### Current Compatibility (2026-Q1)

| Package | Current | Compatible With | Notes |
|---------|---------|-----------------|-------|
| Laravel | 12.47 | PHP 8.2-8.4 | ✅ Stable |
| Filament | 5.0 | Laravel 11-12, PHP 8.2+ | ✅ Stable |
| Pest | 4.x | PHP 8.2+, Laravel 11-12 | ✅ Stable |
| PHPStan | 1.x | PHP 8.1+ | ✅ Stable |
| Spatie Data | 4.7 | PHP 8.2+, Laravel 10-12 | ✅ Stable |
| Livewire | 3.x | Laravel 10-12 | ✅ Stable |
| Flux | 2.1.1 | Livewire 3.x | ✅ Stable |

### Upgrade Paths

#### PHP 8.2 → 8.3

**Timeline**: Q2 2026  
**Breaking Changes**: Minimal  
**Steps**:
1. Update `composer.json`: `"php": "^8.3"`
2. Run tests on PHP 8.3
3. Check deprecated features
4. Deploy to staging
5. Production rollout

**Confidence**: HIGH — PHP 8.3 is stable, backward compatible

#### Laravel 12 → 13 (when released)

**Timeline**: Q1 2027 (expected)  
**Breaking Changes**: TBD  
**Steps**:
1. Wait for official release notes
2. Run `laravel-shift` for automated upgrade
3. Manual review of breaking changes
4. Test all 42+ modules
5. Staged rollout

**Confidence**: MEDIUM — Depends on actual release

---

## Italian PA Compliance Requirements

### Mandatory Packages

| Requirement | Package | Purpose |
|-------------|---------|---------|
| **GDPR Compliance** | `spatie/laravel-personal-data-export` (already in User module) | Data portability |
| **Audit Trails** | `spatie/laravel-activitylog` (already in Activity module) | Action logging |
| **Security Scanning** | `sensiolabs/security-checker` | Dependency vulnerabilities |
| **Health Checks** | `spatie/laravel-health` (already in Xot module) | System monitoring |

### Recommended for Compliance

| Requirement | Package | Purpose |
|-------------|---------|---------|
| **OpenAPI Documentation** | `dedoc/laravel-openapi` | API standardization for PA integrations |
| **Rate Limiting** | `spatie/laravel-rate-limiter` | API throttling for external systems |
| **Failed Job Monitoring** | `spatie/laravel-failed-job-monitor` | Reliability tracking |

---

## Migration Paths

### 1. PDF Engine Consolidation

**Current**: 3 engines (DomPDF, spatie/laravel-pdf, spipu/html2pdf)  
**Target**: 1 engine (spatie/laravel-pdf)

**Phases**:
```
Phase 1: Audit all PDF generation (2 weeks)
Phase 2: Migrate simple PDFs to Spatie (3 weeks)
Phase 3: Migrate complex PDFs (4 weeks)
Phase 4: Remove DomPDF dependency (1 week)
Phase 5: Testing & validation (2 weeks)
```

**Risk**: MEDIUM — Some templates may need adjustment

---

### 2. Queue Driver Migration

**Current**: Database driver  
**Target**: Redis + Horizon

**Phases**:
```
Phase 1: Install Redis, configure connection (1 week)
Phase 2: Install Horizon, configure dashboard (1 week)
Phase 3: Migrate queue driver in .env (1 day)
Phase 4: Monitor for 2 weeks
Phase 5: Install failed job monitor (1 week)
```

**Risk**: LOW — Transparent to application logic

---

### 3. API Documentation Standardization

**Current**: Ad-hoc documentation  
**Target**: OpenAPI 3.0 specs

**Phases**:
```
Phase 1: Install laravel-openapi (1 week)
Phase 2: Annotate existing routes (2 weeks)
Phase 3: Generate /api/docs endpoint (1 week)
Phase 4: Create Saloon connectors for integrations (3 weeks)
Phase 5: Deprecate old integration patterns (2 weeks)
```

**Risk**: MEDIUM — Requires coordination with external systems

---

## Confidence Levels Summary

| Recommendation | Confidence | Rationale |
|----------------|------------|-----------|
| **Keep Laravel 12** | HIGH | Latest stable, no upgrade needed |
| **Keep Filament v5** | HIGH | Excellent ecosystem, active development |
| **Upgrade to PHP 8.3** | HIGH | Minimal breaking changes, performance gains |
| **Consolidate PDF to Spatie** | HIGH | Best HTML/CSS support, active maintenance |
| **Add Horizon for queues** | HIGH | Production standard, excellent UX |
| **Add OpenAPI documentation** | HIGH | Required for PA integrations |
| **Add Saloon for API clients** | HIGH | Type-safe, retry logic, testing support |
| **Add Sanctum (replace Passport)** | MEDIUM | Lighter, but Passport works fine |
| **Add Meilisearch** | MEDIUM | Only for large deployments |
| **Add Octane** | MEDIUM | Only for high-traffic scenarios |
| **Add snapshot testing** | HIGH | Prevents PDF/API regressions |
| **Add security health checks** | HIGH | Required for PA compliance |

---

## Implementation Priority

### Q2 2026 (Immediate)

1. ✅ **PHP 8.2 → 8.3 upgrade**
2. ✅ **PDF engine consolidation** (start audit)
3. ✅ **OpenAPI documentation** (Sigma, Europa, Pdnd modules)
4. ✅ **Security scanning** in CI/CD

### Q3 2026

5. ✅ **Horizon installation** (Redis queue monitoring)
6. ✅ **Failed job monitoring**
7. ✅ **Snapshot testing** for PDFs
8. ✅ **Saloon API connectors**

### Q4 2026

9. ⏸️ **Meilisearch** (if performance requires)
10. ⏸️ **Octane** (if traffic requires)
11. ⏸️ **Sanctum migration** (only if Passport issues arise)

---

## Sources

- **Laravel 12 Documentation** — https://laravel.com/docs/12.x
- **Filament v5 Documentation** — https://filamentphp.com/docs/5.x
- **PHP 8.3 Release Notes** — https://www.php.net/releases/8.3/
- **Spatie Laravel PDF** — https://github.com/spatie/laravel-pdf
- **Laravel Horizon** — https://laravel.com/docs/12.x/horizon
- **Saloon PHP** — https://saloon.dev
- **Italian PA Regulations** — D.Lgs. 150/2009, Law 104/1992, GDPR

---

*Research completed: 2026-03-18*  
*Next review: 2026-06-18 (quarterly)*  
*Owner: Development Team*
