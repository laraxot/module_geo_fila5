# PTVX Fila5 Mono Research Summary

**Project**: PTVX Fila5 Mono - HR & Performance Evaluation for Italian Public Administrations
**Domain**: Enterprise HR & Performance Evaluation System (Italian PA)
**Researched**: 2026-03-18
**Confidence**: HIGH
**Context**: BROWNFIELD — 42+ modules already deployed in production

---

## Executive Summary

PTVX Fila5 Mono is a mature enterprise HR & performance evaluation system built on Laravel 12.47 and Filament v5, serving Italian Public Administrations with regulatory compliance (D.Lgs. 150/2009, GDPR, Law 104/1992, CCNL). The system has 42+ production modules covering performance evaluations, indemnity management, career progression, attendance tracking, and compliance reporting.

**Recommended approach**: Enhance and consolidate the existing stack rather than rebuild. The current architecture (Laraxot modular monolith, Actions-over-Services, PHPStan Level 10) is production-grade and exceeds competitor technical quality. Focus on filling critical feature gaps (Employee Self-Service Portal, Manager Dashboard, Transparency Portal, OpenAPI Documentation) and consolidating technical debt (PDF engines, queue monitoring).

**Key risks**: 
1. **Calculation integrity** — Floating-point drift in indemnity formulas creates legal liability
2. **Compliance gaps** — Missing intermediate colloquy tracking and evaluation differentiation enforcement
3. **Audit trail completeness** — Activity logs with empty properties fail legal traceability requirements
4. **Multi-tenant isolation** — Cross-tenant data exposure risks GDPR violations
5. **PDF data staleness** — Certificates generated from cached data create legal disputes

**Mitigation**: Address calculation patterns and audit trail configuration in Phase 1. All monetary calculations must use BCMath/decimal, all models must configure `->logAll()` for activity logging, and tenant scoping must be verified across all 42+ modules.

---

## Key Findings

### Recommended Stack (from STACK.md)

**Keep Current **(Excellent)
- Laravel 12.47, Filament v5, Pest v4, PHPStan Level 10, Spatie Laravel Data, Queueable Actions

**Enhance **(High Priority)
- **PHP 8.2 → 8.3** — Typed class constants, improved enums (Q2 2026)
- **PDF consolidation** — Standardize on `spatie/laravel-pdf` (Browsershot/Chromium), remove DomPDF and spipu/html2pdf
- **Queue monitoring** — Switch from database to Redis driver, add Laravel Horizon
- **OpenAPI documentation** — Add `dedoc/laravel-openapi` for PA integrations (Sigma, Europa, Pdnd)
- **API clients** — Add Saloon PHP for type-safe external API integrations
- **Security scanning** — Add `sensiolabs/security-checker` for CI/CD, `spatie/laravel-security-health-check`

**Defer **(Evaluate Later)
- Meilisearch (only for 500+ employee administrations)
- Laravel Octane (only for 1000+ concurrent users)
- Sanctum migration (Passport works, only if issues arise)

**Installation Commands**:
```bash
composer require dedoc/laravel-openapi
composer require saloonphp/laravel-saloon
composer require saloonphp/laravel-plugin
composer require laravel/horizon
composer require spatie/laravel-failed-job-monitor
composer require spatie/laravel-security-health-check
composer require sensiolabs/security-checker --dev
```

### Expected Features (from FEATURES.md)

**Must Have **(Table Stakes — P1)
- Employee Database ✅ (User module)
- Performance Evaluation Cycle ✅ (Performance module — D.Lgs. 150/2009 compliant)
- Indemnity Calculation ✅ (Incentivi + Indennita modules)
- Attendance Tracking ✅ (PresenzeAssenze + Ptv modules)
- Career Progression ✅ (Progressioni module)
- Multi-Tenancy ✅ (Tenant module)
- GDPR Compliance ✅ (Gdpr module)
- Audit Trail ✅ (Activity module)
- Italian Localization ✅ (Lang module)

**Critical Gaps **(Must Fill — P1)
- **Employee Self-Service Portal** ❌ — Employees can't access own data
- **Manager Dashboard** ❌ — Managers lack team overview tools
- **Transparency Portal** ❌ — Manual publication to PA website
- **OpenAPI Documentation** ❌ — Integration difficulty with PA systems
- **Intermediate Colloquy Tracking** ⚠️ — Partial (compliance gap)
- **Evaluation Differentiation Enforcement** ⚠️ — Not enforced (non-compliance risk)
- **Behavior Catalog Expansion** ⚠️ — Partial (Badge module incomplete)

**Competitive Differentiators **(Already Achieved)
- PHPStan Level 10 (competitors lack strict typing)
- Modern stack (Laravel 12 + Filament v5 vs. legacy competitors)
- Modular architecture (Zucchetti/TeamSystem are monolithic)
- Actions-over-Services pattern (clearer business logic)
- Queueable Actions (async processing out-of-box)
- 100% test coverage goal (in progress)

**Defer **(v2+)
- Mobile App (PWA sufficient from responsive web)
- Advanced Analytics (Pulse dashboard adequate)
- Predictive Turnover Analysis (not essential for launch)
- Succession Planning (advanced HR feature)

### Architecture Approach (from ARCHITECTURE.md)

**Modular Monolith **(Laraxot) 42+ modules organized hierarchically with Xot core providing base classes.

**Major Components**:
1. **Presentation Layer** — Filament v5 Admin Panel + Livewire + Flux UI
2. **Application Layer** — Spatie Queueable Actions (business logic) + Spatie Laravel Data (DTOs)
3. **Domain Layer** — Eloquent Models (XotBaseModel) + Value Objects + Enums
4. **Infrastructure Layer** — MySQL/PostgreSQL (multi-tenant) + Redis (cache/queue)

**Critical Rules**:
- Never extend Filament/Laravel classes directly — always use XotBase wrappers
- Business logic in Actions, never in controllers or models
- All PHP classes under `app/` folder (except Xot legacy exceptions)
- No hardcoded strings — auto-translate via Lang module
- Forward-only Git workflow — no reset/revert

**Module Dependencies**:
```
Xot (Core) → User/Tenant/Setting → Lang/UI/Activity → Domain Modules (Performance/Ptv/Incentivi)
```

### Critical Pitfalls (from PITFALLS.md)

**Top 5 to Avoid**:

1. **Floating-Point Calculation Drift** (CRITICAL)
   - **Problem**: Indemnity calculations use float arithmetic, causing cumulative rounding errors
   - **Avoid**: Mandatory BCMath for all monetary calculations, `DECIMAL(10,2)` database columns
   - **Test**: Recalculate all indemnities monthly, flag discrepancies > €0.01
   - **Phase**: Phase 2 (Core Calculation Engine)

2. **Incomplete Audit Trail** (CRITICAL)
   - **Problem**: Activity logs capture "updated" events but not which fields changed
   - **Avoid**: Mandatory `->logAll()` in `getActivitylogOptions()` for all models
   - **Test**: Every update test must assert `Activity::latest()->properties` is not empty
   - **Phase**: Phase 1 (Foundation & Compliance)

3. **Hardcoded Regulatory Percentages** (HIGH)
   - **Problem**: CCNL percentages hardcoded, requiring code deployment for policy changes
   - **Avoid**: Central config files + database-backed settings per tenant
   - **Test**: Search codebase for magic numbers (`* 0.15`, `>= 24`)
   - **Phase**: Phase 2 (Core Calculation Engine)

4. **Missing Multi-Tenant Isolation** (CRITICAL)
   - **Problem**: Queries cross tenant boundaries, exposing one PA's data to another
   - **Avoid**: Tenant scope on BaseModel, explicit tenant ID in all queries, cache key prefixing
   - **Test**: Verify all 42+ modules apply tenant scoping in complex queries
   - **Phase**: Phase 1 (Foundation & Compliance)

5. **Performance Evaluation Timeline Misalignment** (HIGH)
   - **Problem**: System allows evaluations outside legally-mandated annual cycle
   - **Avoid**: EvaluationCycle model with strict date ranges, form validation guards
   - **Test**: Attempt to create evaluations outside cycle dates — should fail
   - **Phase**: Phase 3 (Performance Evaluation Workflow)

**Other Critical Pitfalls**:
- Law 104 permit calculation errors (CRITICAL — discrimination liability)
- GDPR data export incompleteness (CRITICAL — fines up to €20M)
- Union consultation workflow bypass (HIGH — decisions legally voidable)
- ContoAnnuale reporting data mismatch (HIGH — ministry audit)
- PDF certificates with stale data (MEDIUM-HIGH — legal disputes)

---

## Implications for Roadmap

Based on research, suggested phase structure:

### Phase 1: Foundation & Compliance Hardening
**Rationale**: Non-negotiable compliance requirements must be verified before feature work
**Delivers**: 
- Audit trail verification (all models with `->logAll()`)
- Multi-tenant isolation audit (all 42+ modules)
- GDPR export completeness verification
- PHPStan Level 10 maintenance
**Addresses**: Employee Database, Audit Trail, Multi-Tenancy, GDPR Compliance
**Avoids**: Pitfall #2 (Incomplete Audit Trail), Pitfall #4 (Missing Multi-Tenant Isolation), Pitfall #7 (GDPR Export Incompleteness)

### Phase 2: Core Calculation Engine
**Rationale**: Monetary calculations are legally binding — must be exact
**Delivers**:
- BCMath migration for all indemnity calculations
- Configurable regulatory percentages (remove hardcoded values)
- PDF engine consolidation (spatie/laravel-pdf only)
- PDF versioning and digital signature
**Uses**: Spatie Laravel Data (DTOs), Queueable Actions
**Implements**: Calculation integrity, PDF standardization
**Avoids**: Pitfall #1 (Floating-Point Drift), Pitfall #3 (Hardcoded Percentages), Pitfall #10 (Stale PDF Data)

### Phase 3: Performance Evaluation Workflow
**Rationale**: D.Lgs. 150/2009 compliance is mandatory for market entry
**Delivers**:
- EvaluationCycle model with date validation
- Intermediate colloquy tracking
- Evaluation differentiation enforcement (statistical distribution checking)
- Behavior catalog expansion
- Evaluator conflict of interest detection
**Uses**: Performance module, Rating module, Notification module
**Implements**: Complete D.Lgs. 150/2009 compliance
**Avoids**: Pitfall #5 (Timeline Misalignment), Pitfall #11 (Conflict of Interest)

### Phase 4: Employee Self-Service Portal
**Rationale**: Critical gap — employees can't access own data (competitors have this)
**Delivers**:
- Employee dashboard (personal data, evaluations, bonuses, absences)
- Document repository (centralized access to certificates, payslips)
- Leave request submission (streamlined UI)
- Evaluation view (transparency requirement)
**Uses**: User module, Performance module, Incentivi module, PresenzeAssenze module, Media module
**Implements**: Employee Self-Service differentiator
**Avoids**: Creating feature that feels broken to end users

### Phase 5: Manager Dashboard
**Rationale**: Managers lack team overview tools (critical for adoption)
**Delivers**:
- Team performance overview
- Absence calendar
- Bonus/indemnity summary
- Approval workflows
**Uses**: User module, Performance module, PresenzeAssenze module, Incentivi module
**Implements**: Manager Dashboard differentiator

### Phase 6: Transparency Portal
**Rationale**: Manual publication to PA website is operational burden
**Delivers**:
- Automated SMVP documentation generation
- OIV reporting automation
- One-click publication to PA website
- Public-facing performance results view
**Uses**: Performance module, Setting module, Media module
**Implements**: Transparency Portal differentiator
**Avoids**: Manual administrative work for HR staff

### Phase 7: Integration & API Standardization
**Rationale**: External PA integrations (Sigma, Europa, Pdnd) require OpenAPI
**Delivers**:
- OpenAPI 3.0 documentation (auto-generated from routes)
- Saloon connectors for Sigma, Europa, Pdnd
- Rate limiting for external API access
- Integration monitoring dashboard
**Uses**: dedoc/laravel-openapi, Saloon PHP, Pdnd/Sigma/Europa modules
**Implements**: OpenAPI Documentation (critical gap)

### Phase 8: Queue & Reliability
**Rationale**: Production reliability requires queue visibility
**Delivers**:
- Redis queue driver migration
- Laravel Horizon installation
- Failed job monitoring and alerts
- Queue performance metrics
**Uses**: Laravel Horizon, Redis, spatie/laravel-failed-job-monitor
**Implements**: Queue Monitoring (important gap)
**Avoids**: Silent job failures, production incidents

### Phase 9: Absence & Time Management Enhancements
**Rationale**: Law 104 and biometric integration are high-risk incomplete features
**Delivers**:
- Law 104 permit calculator (accurate accrual tracking)
- Biometric attendance sync (idempotent, monitored)
- Time bank (banca ore) enhancements
**Uses**: Legge104 module, PresenzeAssenze module
**Implements**: Law 104 compliance, attendance reliability
**Avoids**: Pitfall #6 (Law 104 Errors), Pitfall #13 (Biometric Sync Failures)

### Phase 10: Career Progression & Reporting
**Rationale**: Seniority calculation and ContoAnnuale are legally binding
**Delivers**:
- Seniority calculator (explicit rules, service history)
- ContoAnnuale reconciliation (before submission)
- Career progression eligibility detection (automated)
**Uses**: Progressioni module, ContoAnnuale module
**Implements**: Career progression reliability
**Avoids**: Pitfall #9 (ContoAnnuale Mismatch), Pitfall #12 (Seniority Miscalculation)

### Phase Ordering Rationale

- **Compliance first** (Phase 1-2): Audit trails and calculation integrity are foundational — can't build features on broken compliance
- **Core domain next** (Phase 3): Performance evaluation is the primary product — must be D.Lgs. 150/2009 compliant before launch
- **User-facing gaps** (Phase 4-6): Employee Self-Service, Manager Dashboard, Transparency Portal are critical competitive gaps
- **Integration & reliability** (Phase 7-8): OpenAPI required for PA integrations, Horizon required for production monitoring
- **Domain enhancements** (Phase 9-10): Law 104, biometric sync, career progression are important but can launch with manual workarounds

### Research Flags

**Phases needing deeper research during planning**:
- **Phase 3**: Evaluation differentiation enforcement — needs statistical analysis research (what distribution is compliant?)
- **Phase 6**: SMVP automation — needs OIV reporting format research
- **Phase 7**: Saloon connectors — needs Sigma/Europa/Pdnd API documentation review
- **Phase 9**: Law 104 calculator — needs INPS circular review for edge cases

**Phases with standard patterns **(skip research-phase)
- **Phase 1**: Audit trail verification — well-documented Spatie Activity Log patterns
- **Phase 2**: BCMath migration — straightforward find-and-replace with tests
- **Phase 4-5**: Filament dashboards — standard Filament v5 patterns
- **Phase 8**: Horizon installation — well-documented Laravel package

---

## Confidence Assessment

| Area | Confidence | Notes |
|------|------------|-------|
| **Stack** | HIGH | Verified with official Laravel/Filament docs, Spatie packages, production usage |
| **Features** | HIGH | Based on 42+ production modules, competitor analysis, Italian PA regulations |
| **Architecture** | HIGH | Existing ARCHITECTURE.md + codebase analysis + Laraxot patterns |
| **Pitfalls** | HIGH | Derived from production troubleshooting docs, regulatory requirements, domain complexity |

**Overall confidence**: HIGH

### Gaps to Address

- **ARCHITECTURE.md incomplete**: OAuth quota limit prevented full research — use existing `/var/www/_bases/base_ptvx_fila5/.planning/codebase/ARCHITECTURE.md` as proxy (already comprehensive)
- **Incentivi module calculation patterns**: Need to verify BCMath usage in `/laravel/Modules/Incentivi/app/Actions/` — validate during Phase 2 planning
- **Tenant scoping completeness**: Need audit of all 42+ modules for proper tenant isolation — task for Phase 1
- **Law 104 module status**: Documentation shows "TODO" — high-risk incomplete feature, prioritize Phase 9
- **ContoAnnuale module status**: Documentation shows "TODO" — critical compliance feature, prioritize Phase 10

---

## Sources

### Primary (HIGH confidence)
- **STACK.md** (`.planning/research/STACK.md`) — Stack recommendations, version compatibility, migration paths
- **FEATURES.md** (`.planning/research/FEATURES.md`) — Feature gaps, competitor analysis, MVP definition
- **PITFALLS.md** (`.planning/research/PITFALLS.md`) — 14 critical pitfalls with domain-specific examples
- **ARCHITECTURE.md** (`.planning/codebase/ARCHITECTURE.md`) — Existing architecture documentation
- **Laravel 12 Documentation** — https://laravel.com/docs/12.x
- **Filament v5 Documentation** — https://filamentphp.com/docs/5.x
- **Italian PA Regulations** — D.Lgs. 150/2009, Law 104/1992, Law 109/1996, GDPR (EU 2016/679)

### Secondary (MEDIUM confidence)
- **Production troubleshooting docs** — Activity module properties-vuote fix, Incentivi PDF templates
- **Module documentation** — 42+ module docs/ folders (varying completeness)
- **Competitor analysis** — Zucchetti HR, TeamSystem, Altamira, NoiPA feature comparisons

### Tertiary (LOW confidence)
- **Inferred CCNL requirements** — Based on module implementation patterns, needs legal review
- **Union consultation workflows** — Sindacati module integration needs validation with RSU representatives

---

*Research completed: 2026-03-18*
*Ready for roadmap: yes*
*Next review: 2026-06-18 (quarterly)*
*Owner: Development Team*
