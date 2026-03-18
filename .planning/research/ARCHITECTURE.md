# Architecture Research: HR & Performance Evaluation Systems at Scale

**Domain:** Enterprise HR & Performance Evaluation for Italian Public Administrations
**Researched:** 2026-03-18
**Confidence:** HIGH
**Context:** BROWNFIELD — 42+ modules already deployed in production on Laraxot modular monolith

---

## Executive Summary

PTVX Fila5 Mono is a **mature modular monolith** serving Italian Public Administrations. This research provides architectural patterns for **scaling within the existing architecture**, not greenfield rewrites. All recommendations consider:

- **Regulatory compliance** (D.Lgs. 150/2009, GDPR, Law 104/1992, Italian PA requirements)
- **Multi-tenant isolation** (database-per-tenant architecture)
- **Auditability** (all calculations must be traceable and explainable)
- **Integration requirements** (Sigma, Europa, Pdnd external PA systems)
- **Performance at scale** (1000+ employees per administration, batch operations)
- **Brownfield constraints** (42+ production modules, cannot break existing functionality)

---

## 1. System Overview

### Current Architecture (Modular Monolith)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           Presentation Layer                                 │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                    Filament v5 Admin Panel                           │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐              │   │
│  │  │  Resources   │  │     Pages    │  │    Widgets   │              │   │
│  │  │  (XotBase)   │  │  (XotBase)   │  │  (XotBase)   │              │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘              │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                  Livewire v3 + Flux UI Components                    │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────────┐
│                          Application Layer                                   │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │            Spatie Queueable Actions (Business Logic)                │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  Examples: UpdateHaDirittoAction, SpareImportoTotaleAction   │  │   │
│  │  │  Pattern: app(Action::class)->execute($data)                  │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │              Spatie Laravel Data (Type-Safe DTOs)                   │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  Examples: PerformanceEvaluationData, IncentivoData          │  │   │
│  │  │  Pattern: readonly properties, validation rules               │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                   Event Sourcing (Selective)                        │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  Incentivi: ProgettoImportoTotaleUpdated → Projector         │  │   │
│  │  │  Activity: Login/Logout events → StoredEvent                 │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────────┐
│                            Domain Layer                                      │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │              Eloquent Models (XotBaseModel Extension)               │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  BaseIndividualeModel → Individuale (Performance)            │  │   │
│  │  │  Project, Activity, Employee (Incentivi)                     │  │   │
│  │  │  Traits: HasXotFactory, RelationX, Updater                   │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │              PHP 8.3+ Backed Enums + Value Objects                  │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  WorkerType (Ptv), EvaluationStatus (Performance)            │  │   │
│  │  │  Business logic in enum methods (labels, rules)              │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
                                    ↓
┌─────────────────────────────────────────────────────────────────────────────┐
│                        Infrastructure Layer                                  │
├─────────────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │              Multi-Database Architecture (Tenant-Scoped)            │   │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐           │   │
│  │  │   xot    │  │  tenant  │  │performance│  │ activity │           │   │
│  │  │ (shared) │  │(isolated)│  │ (domain) │  │  (log)   │           │   │
│  │  └──────────┘  └──────────┘  └──────────┘  └──────────┘           │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │                   Redis (Cache + Queue Driver)                      │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  Queue: database (current) → redis (recommended)             │  │   │
│  │  │  Cache: database (current) → redis (performance)             │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │              External Integrations (Sigma, Europa, Pdnd)            │   │
│  │  ┌──────────────────────────────────────────────────────────────┐  │   │
│  │  │  Current: Raw Guzzle calls, mass update actions              │  │   │
│  │  │  Recommended: Saloon PHP connectors, OpenAPI specs           │  │   │
│  │  └──────────────────────────────────────────────────────────────┘  │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Module Categories (42+ Total)

| Category | Modules | Purpose | Examples |
|----------|---------|---------|----------|
| **Core Infrastructure** | 5 | Foundation for all modules | Xot, User, Tenant, Setting, Lang |
| **Domain (HR Core)** | 12 | Primary business logic | Performance, Ptv, Incentivi, Progressioni, PresenzeAssenze |
| **Domain (Extended)** | 6 | Secondary business logic | Job, Rating, Questionari, Badge, Mensa, Prenotazioni |
| **Compliance & Legal** | 8 | Regulatory requirements | Gdpr, Legge104, Legge109, Inail, ContoAnnuale, Sindacati, CertFisc |
| **Integration** | 3 | External PA systems | Pdnd, Sigma, Europa |
| **Utility** | 8 | Cross-cutting concerns | Activity, Media, Notify, UI, Seo, DbForge |

---

## 2. Component Boundaries

### 2.1 Module Boundaries (Strict)

**Rule**: Modules are **bounded contexts** with explicit dependencies declared in `module.json`.

```
┌─────────────────────────────────────────────────────────────────┐
│                     Module Dependency Rules                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ✅ CORRECT: Explicit Dependencies                               │
│  ┌──────────────┐                                               │
│  │  Incentivi   │──requires──>┌──────────────┐                 │
│  │              │              │ Performance  │                 │
│  └──────────────┘              └──────────────┘                 │
│       │                              │                           │
│       │ calls Action                 │ provides Models           │
│       ↓                              ↓                           │
│  app(CalculateBonusAction::class)   PerformanceEvaluation       │
│                                                                  │
│  ❌ WRONG: Direct Model Access Across Modules                   │
│  ┌──────────────┐                                               │
│  │  Module A    │──queries───>┌──────────────┐                 │
│  │              │   SELECT *   │  Module B    │                 │
│  └──────────────┘              └──────────────┘                 │
│                                                                  │
│  ✅ CORRECT: Action-Mediated Communication                      │
│  ┌──────────────┐                                               │
│  │  Module A    │──calls───>┌──────────────┐                   │
│  │              │  Action    │  Module B    │                   │
│  └──────────────┘            └──────────────┘                   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 2.2 Layer Boundaries (Clean Architecture)

```
┌─────────────────────────────────────────────────────────────────┐
│                    Dependency Rule (Inward)                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Frameworks & Drivers → Entities → Use Cases → Interface Adapters│
│         (Outer)                    (Inner)                       │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Outer Layer: Filament, Livewire, Controllers, Jobs      │  │
│  │  ↓ depends on                                            │  │
│  │  Application Layer: Actions, DTOs, Events                │  │
│  │  ↓ depends on                                            │  │
│  │  Domain Layer: Models, Enums, Value Objects              │  │
│  │  ↓ depends on                                            │  │
│  │  Infrastructure: Database, Cache, Queue                  │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ⚠️ BROWNFIELD REALITY: Some violations exist (legacy code)    │
│  Priority: Prevent new violations, refactor gradually           │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 2.3 Tenant Boundaries (Data Isolation)

```
┌─────────────────────────────────────────────────────────────────┐
│                  Multi-Tenant Architecture                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Tenant A (Comune di Roma)                                      │
│  ┌────────────────────────────────────────────────────────┐    │
│  │  Database: tenant_a                                    │    │
│  │  ├── users (1000 employees)                            │    │
│  │  ├── performance_evaluations                           │    │
│  │  ├── incentivi                                         │    │
│  │  └── ...                                               │    │
│  └────────────────────────────────────────────────────────┘    │
│                                                                  │
│  Tenant B (ASL Lazio)                                           │
│  ┌────────────────────────────────────────────────────────┐    │
│  │  Database: tenant_b                                    │    │
│  │  ├── users (2500 employees)                            │    │
│  │  ├── performance_evaluations                           │    │
│  │  ├── incentivi                                         │    │
│  │  └── ...                                               │    │
│  └────────────────────────────────────────────────────────┘    │
│                                                                  │
│  Shared (Xot Core)                                              │
│  ┌────────────────────────────────────────────────────────┐    │
│  │  Database: xot (shared across all tenants)             │    │
│  │  ├── xot_base_tables                                   │    │
│  │  ├── activity_logs (cross-tenant audit)                │    │
│  │  └── system_config                                     │    │
│  └────────────────────────────────────────────────────────┘    │
│                                                                  │
│  Isolation Mechanism:                                           │
│  ├── TenantIdentificationMiddleware                             │
│  ├── TenantAwareModel trait (automatic scoping)                 │
│  └── Database connection per tenant                             │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 3. Data Flow Patterns

### 3.1 Core HR Data Flow (Performance → Indemnities → Progressioni)

```
┌─────────────────────────────────────────────────────────────────┐
│              Performance Evaluation Cycle Data Flow              │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  1. Evaluation Creation                                          │
│  ┌──────────┐     ┌──────────────┐     ┌──────────────────┐    │
│  │  Manager │────>│ Filament Form│────>│ CreateEvaluation │    │
│  │  (User)  │     │  (Resource)  │     │     Action       │    │
│  └──────────┘     └──────────────┘     └─────────┬────────┘    │
│                                                   │              │
│                                                   ↓              │
│                                          ┌──────────────────┐   │
│                                          │ Performance      │   │
│                                          │ Evaluation Model │   │
│                                          └─────────┬────────┘   │
│                                                    │             │
│  2. Score Calculation                              │             │
│  ┌──────────┐     ┌──────────────┐     ┌──────────▼────────┐   │
│  │ Criteri  │<────│  Evaluation  │<────│ GetHaDiritto     │   │
│  │ Esclusione│    │   Criteria   │     │ Motivo Action     │   │
│  └──────────┘     └──────────────┘     └───────────────────┘   │
│                                                                  │
│  3. Indemnity Calculation (Incentivi Module)                    │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │  PerformanceEvaluation (score: 8.5)                     │   │
│  │         ↓                                                │   │
│  │  app(CalculateBonusAction::class)->execute($evaluation) │   │
│  │         ↓                                                │   │
│  │  Project → Activity → Employee → Settlement             │   │
│  │         ↓                                                │   │
│  │  SpareImportoTotaleAction (formula calculation)         │   │
│  └─────────────────────────────────────────────────────────┘   │
│                                                                  │
│  4. Career Progression (Progressioni Module)                    │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │  PerformanceEvaluation (excellence: true)               │   │
│  │         ↓                                                │   │
│  │  Progressioni::checkEligibility($employee, $year)       │   │
│  │         ↓                                                │   │
│  │  CareerProgression Application Created                  │   │
│  │         ↓                                                │   │
│  │  Committee Evaluation Workflow                          │   │
│  │         ↓                                                │   │
│  │  Approved → User Model Updated (new level)              │   │
│  └─────────────────────────────────────────────────────────┘   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 3.2 External Integration Data Flow (Sigma Example)

```
┌─────────────────────────────────────────────────────────────────┐
│              Sigma Integration Data Flow                         │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Current Pattern (Mass Update Actions):                         │
│  ┌──────────┐     ┌──────────────┐     ┌──────────────────┐    │
│  │  Sigma   │────>│  Raw Guzzle  │────>│ MassUpdateAction │    │
│  │   API    │     │   HTTP Call  │     │ (Direct SQL)     │    │
│  └──────────┘     └──────────────┘     └─────────┬────────┘    │
│                                                   │              │
│                                                   ↓              │
│                                          ┌──────────────────┐   │
│                                          │ Direct Database  │   │
│                                          │ UPDATE queries   │   │
│                                          └──────────────────┘   │
│                                                                  │
│  ⚠️ Issues:                                                      │
│  ├── No type safety                                             │
│  ├── No retry logic                                             │
│  ├── No error handling standardization                          │
│  └── SQL injection risk (massive string concatenation)          │
│                                                                  │
│  Recommended Pattern (Saloon PHP):                              │
│  ┌──────────┐     ┌──────────────┐     ┌──────────────────┐    │
│  │  Sigma   │<────│  Saloon      │<────│ SyncDataAction   │    │
│  │   API    │     │  Connector   │     │ (Type-Safe)      │    │
│  └──────────┘     └──────────────┘     └─────────┬────────┘    │
│                                                   │              │
│                                                   ↓              │
│                                          ┌──────────────────┐   │
│                                          │ DTO → Model      │   │
│                                          │ Validation       │   │
│                                          │ Event Dispatch   │   │
│                                          └──────────────────┘   │
│                                                                  │
│  Benefits:                                                      │
│  ├── Type-safe request/response                                 │
│  ├── Automatic retry with exponential backoff                   │
│  ├── Centralized error handling                                 │
│  └── Testable with fakes                                        │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 3.3 Event-Driven Data Flow (Incentivi Example)

```
┌─────────────────────────────────────────────────────────────────┐
│           Event Sourcing Pattern (Incentivi Module)              │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Event Flow:                                                     │
│  ┌──────────────┐                                               │
│  │  Progetto    │                                               │
│  │  Model       │                                               │
│  └──────┬───────┘                                               │
│         │ update()                                              │
│         ↓                                                       │
│  ┌──────────────┐                                               │
│  │  Observer/   │                                               │
│  │  Model Hook  │                                               │
│  └──────┬───────┘                                               │
│         │                                                       │
│         ↓                                                       │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  ProgettoImportoTotaleUpdated Event                      │  │
│  │  - projectId: int                                        │  │
│  │  - importoTotale: int                                    │  │
│  │  - timestamp: Carbon                                     │  │
│  └──────────────────────────────────────────────────────────┘  │
│         │                                                       │
│         ↓ (stored in event_store table)                        │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  AttivitaImportoProjector                                │  │
│  │  onImportUpdated(ProgettoImportoTotaleUpdated $event)   │  │
│  └──────────────────────────────────────────────────────────┘  │
│         │                                                       │
│         ↓                                                       │
│  ┌──────────────┐     ┌──────────────┐     ┌──────────────┐   │
│  │   Activity   │────>│  Employee    │────>│  Settlement  │   │
│  │   Update     │     │  Recalculate │     │  Recalculate │   │
│  └──────────────┘     └──────────────┘     └──────────────┘   │
│                                                                  │
│  Benefits:                                                      │
│  ├── Complete audit trail (every change stored)                 │
│  ├── Replay capability (rebuild state from events)              │
│  ├── Decoupled side effects (projectors handle reactions)       │
│  └── Compliance with PA audit requirements                      │
│                                                                  │
│  ⚠️ Current State: Partially implemented (Incentivi only)       │
│  Recommendation: Expand to Performance, Progressioni modules    │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 4. Architectural Patterns

### 4.1 Actions-over-Services (Core Pattern)

**What**: Business logic encapsulated in invokable, queueable action classes.

**When to Use**:
- ✅ All business logic (create, update, delete operations)
- ✅ Complex calculations (indemnity formulas, evaluation scoring)
- ✅ Operations that may need to run asynchronously
- ✅ Cross-module operations

**Pattern**:
```php
// ✅ CORRECT - Action Pattern
class UpdateHaDirittoAction
{
    use QueueableAction;

    public function execute(string $modelClass, int|string $year): void
    {
        // Business logic here
        $schede = $modelClass::query()
            ->where('anno', $year)
            ->get();

        foreach ($schede as $scheda) {
            [$haDiritto, $motivo] = app(GetHaDirittoMotivoAction::class)
                ->execute($scheda, $criteriEsclusione, $criteriOption);

            $scheda->update(['ha_diritto' => $haDiritto, 'motivo' => $motivo]);
        }
    }
}

// Usage
app(UpdateHaDirittoAction::class)->execute(Individuale::class, 2025);

// Or queued
app(UpdateHaDirittoAction::class)
    ->onQueue('evaluations')
    ->execute(Individuale::class, 2025);
```

**Trade-offs**:
- ✅ Clear single responsibility
- ✅ Queueable without code changes
- ✅ Easy to test in isolation
- ✅ Consistent pattern across 42+ modules
- ⚠️ More files than service classes
- ⚠️ Requires app() resolution (not static calls)

---

### 4.2 Data Transfer Objects (Spatie Laravel Data)

**What**: Type-safe data objects for validation and transfer.

**When to Use**:
- ✅ API request/response payloads
- ✅ Form data in Filament
- ✅ Cross-module data transfer
- ✅ Complex validation scenarios

**Pattern**:
```php
class PerformanceEvaluationData extends Data
{
    public function __construct(
        public readonly string $employee_id,
        public readonly string $period,
        public readonly float $score,
        public readonly ?string $notes = null,
    ) {}

    public static function rules(): array
    {
        return [
            'employee_id' => ['required', 'uuid', 'exists:users,id'],
            'period' => ['required', 'string'],
            'score' => ['required', 'numeric', 'between:1,10'],
        ];
    }
}

// Usage in Action
class CreateEvaluationAction
{
    public function execute(PerformanceEvaluationData $data): PerformanceEvaluation
    {
        return PerformanceEvaluation::create($data->toArray());
    }
}
```

**Trade-offs**:
- ✅ Type safety with readonly properties
- ✅ Built-in validation rules
- ✅ Immutable by default
- ✅ Auto-documentation
- ⚠️ Slight performance overhead
- ⚠️ Learning curve for team

---

### 4.3 XotBase Wrappers (Laraxot Convention)

**What**: All Laravel/Filament classes extended via XotBase wrappers.

**When to Use**:
- ✅ ALWAYS - Never extend Laravel/Filament directly
- ✅ Models, Resources, Pages, Widgets, ServiceProviders

**Pattern**:
```php
// ❌ WRONG - Direct extension
class UserPage extends Filament\Pages\Page

// ✅ CORRECT - XotBase wrapper
class UserPage extends Modules\Xot\Filament\Pages\XotBasePage
```

**Trade-offs**:
- ✅ Enforces conventions across all modules
- ✅ Reduces boilerplate (shared traits)
- ✅ Centralized upgrades (change XotBase, all modules inherit)
- ✅ Multi-tenancy support built-in
- ⚠️ Abstraction layer (debugging complexity)
- ⚠️ Xot module becomes critical dependency

---

### 4.4 Multi-Tenant Database Isolation

**What**: Database-per-tenant architecture with shared Xot core.

**When to Use**:
- ✅ Required for Italian PA data isolation compliance
- ✅ Each public administration gets separate database
- ✅ Shared configuration in Xot database

**Pattern**:
```php
// TenantIdentificationMiddleware
public function handle($request, Closure $next)
{
    $tenant = Tenant::where('domain', $request->getHost())->first();

    if ($tenant) {
        config(['database.connections.tenant' => [
            'driver' => 'mysql',
            'host' => $tenant->db_host,
            'database' => $tenant->db_name,
            'username' => $tenant->db_user,
            'password' => $tenant->db_pass,
        ]]);

        DB::setDefaultConnection('tenant');
    }

    return $next($request);
}

// TenantAwareModel trait (auto-scoping)
trait TenantAwareModel
{
    protected static function bootTenantAwareModel(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (Tenant::current()) {
                $query->where('tenant_id', Tenant::current()->id);
            }
        });
    }
}
```

**Trade-offs**:
- ✅ Complete data isolation (PA compliance)
- ✅ Tenant-specific backups
- ✅ Independent scaling per tenant
- ✅ Security boundary (tenant A can't access tenant B)
- ⚠️ More complex migrations (run per tenant)
- ⚠️ Cross-tenant reporting requires special handling
- ⚠️ Database connection overhead

---

### 4.5 Audit Trail (Activity Module)

**What**: Complete audit logging using Spatie Activity Log.

**When to Use**:
- ✅ ALL write operations (create, update, delete)
- ✅ User login/logout
- ✅ Sensitive data access
- ✅ PA compliance requirements

**Pattern**:
```php
// Model with activity logging
class PerformanceEvaluation extends XotBaseModel
{
    use LogsActivity;

    protected $fillable = ['score', 'notes', 'ha_diritto', 'motivo'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Valutazione {$eventName} per dipendente {$this->employee_id}";
    }
}

// Usage
$evaluation->update(['score' => 9.0]);
// Automatically logged to activity table

// Query audit trail
Activity::forSubject($evaluation)
    ->where('event', 'updated')
    ->get();
```

**Trade-offs**:
- ✅ Complete audit trail (PA compliance)
- ✅ Queryable by subject, causer, event
- ✅ Property changes tracked (old vs new values)
- ✅ Batch UUID for bulk operations
- ⚠️ Storage overhead (activity_logs table grows)
- ⚠️ Performance impact on high-write operations

---

## 5. Scaling Considerations

### 5.1 Scaling Priorities by User Count

| Scale | Bottleneck | Solution | Priority |
|-------|------------|----------|----------|
| **0-100 users** | None (monolith fine) | Standard Laravel setup | - |
| **100-500 users** | Database queries | Add Redis cache, optimize queries | HIGH |
| **500-1000 users** | Queue processing | Switch to Redis queue + Horizon | HIGH |
| **1000-5000 users** | PDF generation | Queue PDFs, use Browsershot cluster | HIGH |
| **5000+ users** | Database load | Read replicas, partitioning | MEDIUM |
| **10000+ users** | Monolith limits | Consider service boundaries | LOW |

### 5.2 First Bottlenecks (What Breaks First)

```
┌─────────────────────────────────────────────────────────────────┐
│              Performance Bottleneck Progression                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  1. PDF Generation (First to break at ~500 users)               │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Symptom: Timeout errors during bulk PDF generation      │  │
│  │  Cause: Synchronous PDF generation blocks requests       │  │
│  │  Solution: Queue PDFs with Spatie Laravel PDF           │  │
│  │  Implementation:                                         │  │
│  │  ├── Move PDF generation to QueueableAction             │  │
│  │  ├── Add progress tracking (job status table)           │  │
│  │  └── Notify user when complete (Notify module)          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  2. Queue Processing (Breaks at ~1000 users)                    │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Symptom: Jobs stuck in queue, slow background processing│  │
│  │  Cause: Database queue driver (current) doesn't scale   │  │
│  │  Solution: Redis queue + Laravel Horizon                │  │
│  │  Implementation:                                         │  │
│  │  ├── Install Redis, configure queue connection          │  │
│  │  ├── Install Horizon for monitoring                     │  │
│  │  └── Add failed job monitoring (Spatie)                 │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  3. Database Queries (Breaks at ~2000 users)                    │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Symptom: Slow page loads, N+1 queries                  │  │
│  │  Cause: Unoptimized Eloquent queries, missing indexes   │  │
│  │  Solution: Query optimization + caching                 │  │
│  │  Implementation:                                         │  │
│  │  ├── Add database indexes (matr, anno, ente columns)   │  │
│  │  ├── Use eager loading (with() method)                  │  │
│  │  ├── Add Redis caching for read-heavy data              │  │
│  │  └── Consider read replicas for reporting               │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  4. Search Performance (Breaks at ~5000 users)                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Symptom: LIKE queries too slow for employee search     │  │
│  │  Cause: Database full-text search not optimized         │  │
│  │  Solution: Laravel Scout + Meilisearch                  │  │
│  │  Implementation:                                         │  │
│  │  ├── Install Scout + Meilisearch                        │  │
│  │  ├── Add Searchable trait to User, Performance models   │  │
│  │  └── Replace LIKE queries with Scout::search()          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 5.2 Caching Strategies

```
┌─────────────────────────────────────────────────────────────────┐
│                    Caching Strategy Matrix                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Cache Layer 1: Application Cache (Redis)                       │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  What to Cache:                                          │  │
│  │  ├── Configuration (Setting module key-value pairs)     │  │
│  │  ├── Translation strings (Lang module)                  │  │
│  │  ├── User permissions (Spatie Permission cache)         │  │
│  │  └── Expensive calculations (indemnity formulas)        │  │
│  │                                                          │  │
│  │  TTL Strategy:                                           │  │
│  │  ├── Config: 24 hours (invalidate on change)            │  │
│  │  ├── Translations: 7 days (invalidate on deploy)        │  │
│  │  ├── Permissions: 1 hour (invalidate on role change)    │  │
│  │  └── Calculations: 15 minutes (short-lived)             │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Cache Layer 2: Database Query Cache                            │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  What to Cache:                                          │  │
│  │  ├── Aggregation queries (COUNT, SUM)                   │  │
│  │  ├── Complex joins (Performance → User → Ptv data)      │  │
│  │  └── Report data (static for given period)              │  │
│  │                                                          │  │
│  │  Pattern:                                                │  │
│  │  ├── Cache::remember('key', $ttl, fn() => $query->get())│  │
│  │  └── Cache tags for selective invalidation              │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Cache Layer 3: Response Cache (Spatie)                         │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  What to Cache:                                          │  │
│  │  ├── Public pages (transparency portal)                 │  │
│  │  ├── API endpoints (read-only)                          │  │
│  │  └── Report exports (PDF, Excel)                        │  │
│  │                                                          │  │
│  │  Already configured: spatie/laravel-responsecache       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ⚠️ Cache Invalidation Rules:                                   │
│  ├── Use cache tags (easier bulk invalidation)                │
│  ├── Invalidate on model events (created, updated, deleted)   │
│  └── Never cache user-specific data without user tag          │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 6. Integration Architecture

### 6.1 External PA Integration Patterns

```
┌─────────────────────────────────────────────────────────────────┐
│              Italian PA Integration Architecture                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Integration Points:                                            │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  1. Sigma (HR Management System)                         │  │
│  │     ├── Employee data synchronization                    │  │
│  │     ├── Organizational chart updates                     │  │
│  │     ├── Salary level changes                             │  │
│  │     └── Pattern: Bi-directional sync, scheduled jobs     │  │
│  │                                                          │  │
│  │  2. Europa (European Systems)                            │  │
│  │     ├── Cross-border worker tracking                     │  │
│  │     ├── EU reporting formats                             │  │
│  │     └── Pattern: Export-only, XML/JSON formats           │  │
│  │                                                          │  │
│  │  3. Pdnd (Piattaforma Digitale Nazionale Dati)           │  │
│  │     ├── National data platform connectivity              │  │
│  │     ├── SPID/CIE authentication                          │  │
│  │     └── Pattern: API client with OAuth 2.0               │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Recommended Architecture:                                      │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  ┌──────────────┐                                        │  │
│  │  │   PTVX Core  │                                        │  │
│  │  └──────┬───────┘                                        │  │
│  │         │                                                │  │
│  │         ↓                                                │  │
│  │  ┌──────────────────────────────────────────────────┐   │  │
│  │  │          Integration Layer (Saloon PHP)          │   │  │
│  │  │  ┌────────────┐  ┌────────────┐  ┌────────────┐ │   │  │
│  │  │  │   Sigma    │  │   Europa   │  │    Pdnd    │ │   │  │
│  │  │  │ Connector  │  │ Connector  │  │ Connector  │ │   │  │
│  │  │  └────────────┘  └────────────┘  └────────────┘ │   │  │
│  │  └──────────────────────────────────────────────────┘   │  │
│  │         │                                                │  │
│  │         ↓                                                │  │
│  │  ┌──────────────────────────────────────────────────┐   │  │
│  │  │           OpenAPI Documentation Layer            │   │  │
│  │  │  ┌────────────────────────────────────────────┐ │   │  │
│  │  │  │  /api/docs (Auto-generated from routes)   │ │   │  │
│  │  │  │  - OpenAPI 3.0 specs                      │ │   │  │
│  │  │  │  - Authentication docs                    │ │   │  │
│  │  │  │  └── External PA systems can generate     │ │   │  │
│  │  │      clients automatically                   │ │   │  │
│  │  │  └────────────────────────────────────────────┘ │   │  │
│  │  └──────────────────────────────────────────────────┘   │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Authentication Patterns:                                       │
│  ├── SPID/CIE for citizen-facing endpoints                     │
│  ├── OAuth 2.0 for system-to-system (Pdnd)                     │
│  ├── API Tokens (Sanctum) for internal APIs                    │
│  └── Mutual TLS for high-security integrations                 │
│                                                                  │
│  Rate Limiting:                                                 │
│  ├── 100 requests/minute per integration (configurable)        │
│  ├── Exponential backoff on 429 responses                      │
│  └── Circuit breaker pattern for failing services              │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 6.2 API Gateway Pattern (Future)

```
┌─────────────────────────────────────────────────────────────────┐
│              API Gateway Architecture (v2+)                      │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Current State: Direct API access to Laravel routes             │
│  Future State: API Gateway for external integrations            │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  External PA Systems                                     │  │
│  │  (Sigma, Europa, Pdnd, Third Parties)                   │  │
│  └────────────────┬─────────────────────────────────────────┘  │
│                   │                                            │
│                   ↓                                            │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              API Gateway (Kong/Traefik)                  │  │
│  │  ┌────────────────────────────────────────────────────┐ │  │
│  │  │  Responsibilities:                                 │ │  │
│  │  │  ├── Authentication (OAuth 2.0, JWT validation)   │ │  │
│  │  │  ├── Rate Limiting (per client, per endpoint)     │ │  │
│  │  │  ├── Request/Response Transformation              │ │  │
│  │  │  ├── Logging & Analytics                          │ │  │
│  │  │  └── Circuit Breaker (failover handling)          │ │  │
│  │  └────────────────────────────────────────────────────┘ │  │
│  └────────────────┬─────────────────────────────────────────┘  │
│                   │                                            │
│                   ↓                                            │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              PTVX Laravel API                            │  │
│  │  ┌────────────┐  ┌────────────┐  ┌────────────┐         │  │
│  │  │  /api/v1/  │  │  /api/v1/  │  │  /api/v1/  │         │  │
│  │  │ performance│  │ incentivi  │  │  users     │         │  │
│  │  └────────────┘  └────────────┘  └────────────┘         │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ⚠️ NOT YET NEEDED: Current scale doesn't require gateway       │
│  Trigger for Implementation:                                    │
│  ├── 10+ external integrations                                  │
│  ├── Multiple API versions needed                               │
│  ├── Complex authentication requirements                        │
│  └── Need for API analytics/monitoring                          │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 7. Async Processing Patterns

### 7.1 Batch Operations (HR Data Processing)

```
┌─────────────────────────────────────────────────────────────────┐
│              Async Batch Processing Architecture                 │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Use Cases:                                                     │
│  ├── Annual evaluation cycle initialization (1000+ employees)   │
│  ├── Mass indemnity calculation (end of month)                  │
│  ├── Bulk PDF generation (performance certificates)             │
│  ├── External system synchronization (Sigma data import)        │
│  └── Report generation (Conto Annuale, OIV reports)             │
│                                                                  │
│  Pattern: Job Batching with Progress Tracking                   │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  1. User Initiates Batch Operation                       │  │
│  │     ┌──────────────┐                                     │  │
│  │     │ Filament Page│                                     │  │
│  │     └──────┬───────┘                                     │  │
│  │            │ "Generate 500 PDFs"                         │  │
│  │            ↓                                             │  │
│  │  2. Create Job Batch                                     │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  Batch::of([                                 │    │  │
│  │     │      new GeneratePdfJob($employee1),         │    │  │
│  │     │      new GeneratePdfJob($employee2),         │    │  │
│  │     │      // ... 498 more                         │    │  │
│  │     │  ])->onQueue('pdf-generation')              │    │  │
│  │     │   ->allowFailures()                         │    │  │
│  │     │   ->create();                               │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │            │                                             │  │
│  │            ↓                                             │  │
│  │  3. Store Batch Reference                                │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  job_batches table                          │    │  │
│  │     │  - id: uuid                                 │    │  │
│  │     │  - total_jobs: 500                          │    │  │
│  │     │  - pending_jobs: 500                        │    │  │
│  │     │  - failed_jobs: 0                           │    │  │
│  │     │  - status: pending                          │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │            │                                             │  │
│  │            ↓                                             │  │
│  │  4. Return Immediately to User                           │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  "Your PDFs are being generated.             │    │  │
│  │     │   We'll notify you when complete."           │    │  │
│  │     │  Batch ID: abc-123-def                       │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │                                                          │  │
│  │  5. Background Processing                                │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  Horizon Workers (Redis queue)               │    │  │
│  │     │  ├── Worker 1: Process Job 1-100            │    │  │
│  │     │  ├── Worker 2: Process Job 101-200          │    │  │
│  │     │  └── Worker 3: Process Job 201-300          │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │                                                          │  │
│  │  6. Progress Tracking                                    │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  Polling Endpoint: /api/batch/abc-123-def   │    │  │
│  │     │  Response: {                                │    │  │
│  │     │    "progress": 60,                          │    │  │
│  │     │    "processed": 300,                        │    │  │
│  │     │    "failed": 2,                             │    │  │
│  │     │    "status": "processing"                   │    │  │
│  │     │  }                                          │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │                                                          │  │
│  │  7. Completion Notification                              │  │
│  │     ┌──────────────────────────────────────────────┐    │  │
│  │     │  When batch completes:                       │    │  │
│  │     │  ├── Update job_batches status: finished    │    │  │
│  │     │  ├── Send notification (Notify module)      │    │  │
│  │     │  └── Provide download link for all PDFs     │    │  │
│  │     └──────────────────────────────────────────────┘    │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Current State: Partially implemented (QueueableAction)         │
│  Recommended Enhancements:                                      │
│  ├── Add Horizon for queue monitoring                           │
│  ├── Add failed job monitoring (Spatie)                         │
│  ├── Add progress tracking for long batches                     │
│  └── Add notification on batch completion                       │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 7.2 Event Sourcing for Audit Trails

```
┌─────────────────────────────────────────────────────────────────┐
│           Event Sourcing for Compliance Audit                    │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Current State: Spatie Activity Log (current state only)         │
│  Recommended: Event Sourcing (Spatie EventSourcing)             │
│                                                                  │
│  Benefits for PA Compliance:                                    │
│  ├── Complete history (not just current state)                  │
│  ├── Replay capability (rebuild state at any point in time)     │
│  ├── Audit trail immutable (events are append-only)             │
│  └── Debugging (see exact sequence of events)                   │
│                                                                  │
│  Implementation Pattern:                                        │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  Event Class:                                            │  │
│  │  class PerformanceScoreUpdated extends ShouldBeStored   │  │
│  │  {                                                       │  │
│  │      public int $evaluationId;                           │  │
│  │      public float $oldScore;                             │  │
│  │      public float $newScore;                             │  │
│  │      public string $changedBy;                           │  │
│  │                                                          │  │
│  │      public function __construct(                        │  │
│  │          int $evaluationId,                              │  │
│  │          float $oldScore,                                │  │
│  │          float $newScore,                                │  │
│  │          string $changedBy                               │  │
│  │      ) {                                                 │  │
│  │          $this->evaluationId = $evaluationId;            │  │
│  │          $this->oldScore = $oldScore;                    │  │
│  │          $this->newScore = $newScore;                    │  │
│  │          $this->changedBy = $changedBy;                  │  │
│  │      }                                                   │  │
│  │  }                                                       │  │
│  │                                                          │  │
│  │  Projector:                                              │  │
│  │  class PerformanceEvaluationProjector extends Projector │  │
│  │  {                                                       │  │
│  │      public function onScoreUpdated(                    │  │
│  │          PerformanceScoreUpdated $event                 │  │
│  │      ): void {                                           │  │
│  │          // Update read model                           │  │
│  │          PerformanceEvaluation::find($event->evaluationId)│  │
│  │              ->update(['score' => $event->newScore]);   │  │
│  │                                                          │  │
│  │          // Trigger side effects                        │  │
│  │          if ($event->newScore >= 9.0) {                 │  │
│  │              event(new ExcellenceThresholdReached(      │  │
│  │                  $event->evaluationId                   │  │
│  │              ));                                        │  │
│  │          }                                               │  │
│  │      }                                                   │  │
│  │  }                                                       │  │
│  │                                                          │  │
│  │  Aggregate:                                              │  │
│  │  class PerformanceEvaluationAggregate extends Aggregate │  │
│  │  {                                                       │  │
│  │      public function updateScore(                       │  │
│  │          float $newScore,                               │  │
│  │          string $changedBy                              │  │
│  │      ): void {                                           │  │
│  │          // Business rules validation                   │  │
│  │          if ($newScore < 1 || $newScore > 10) {         │  │
│  │              throw InvalidScore::outOfRange($newScore); │  │
│  │          }                                               │  │
│  │                                                          │  │
│  │          // Record event                                │  │
│  │          $this->recordThat(                             │  │
│  │              new PerformanceScoreUpdated(               │  │
│  │                  $this->id,                             │  │
│  │                  $this->score,                          │  │
│  │                  $newScore,                             │  │
│  │                  $changedBy                             │  │
│  │              )                                          │  │
│  │          );                                             │  │
│  │      }                                                   │  │
│  │  }                                                       │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ⚠️ BROWNFIELD APPROACH:                                         │
│  ├── Start with new modules (Predict, new features)             │
│  ├── Gradually migrate critical modules (Performance, Incentivi)│
│  └── Keep Activity Log for simple audit needs                   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 8. Microservice Boundaries (Future Consideration)

### 8.1 When to Consider Splitting

```
┌─────────────────────────────────────────────────────────────────┐
│              Monolith vs Microservices Decision                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ⚠️ CURRENT RECOMMENDATION: Stay Modular Monolith               │
│                                                                  │
│  Reasons:                                                       │
│  ├── 42+ modules already working well                          │
│  ├── Laraxot provides good module boundaries                   │
│  ├── Team size doesn't justify microservices overhead          │
│  ├── Deployment complexity not justified at current scale      │
│  └── Italian PA compliance easier with monolithic audit        │
│                                                                  │
│  Triggers for Re-evaluation:                                    │
│  ├── 50+ concurrent users consistently                         │
│  ├── Different scaling needs per domain                        │
│  ├── Team grows to 10+ developers                              │
│  ├── Specific modules need independent deployment              │
│  └── Technology heterogeneity required (e.g., Python for AI)   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 8.2 Potential Service Boundaries (If Splitting)

```
┌─────────────────────────────────────────────────────────────────┐
│              Potential Service Boundaries (v3+)                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  If splitting becomes necessary, these are natural boundaries:  │
│                                                                  │
│  1. Performance Evaluation Service                              │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Modules: Performance, Rating, Questionari              │  │
│  │  Responsibility: Evaluation cycles, KPIs, feedback      │  │
│  │  Database: performance_* tables                         │  │
│  │  API: /api/performance/evaluations, /api/performance/   │  │
│  │  Why Separate: Different scaling (batch-heavy)          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  2. Indemnity & Compensation Service                            │
│  ┌──────────────────────────────────────────────────────────┐  │  │
│  │  Modules: Incentivi, IndennitaCondizioniLavoro,         │  │
│  │           IndennitaResponsabilita                        │  │
│  │  Responsibility: Bonus calculation, indemnity management│  │
│  │  Database: incentivi_*, indennita_* tables              │  │
│  │  API: /api/compensation/bonuses, /api/compensation/     │  │
│  │  Why Separate: High calculation complexity, compliance  │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  3. Career Management Service                                   │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Modules: Progressioni, Job, Badge                      │  │
│  │  Responsibility: Career progression, job positions      │  │
│  │  Database: progressioni_*, job_* tables                 │  │
│  │  API: /api/career/progressions, /api/career/jobs       │  │
│  │  Why Separate: Workflow-heavy, approval chains          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  4. Workforce Management Service                                │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Modules: Ptv, PresenzeAssenze, Mensa, Prenotazioni     │  │
│  │  Responsibility: Attendance, time tracking, bookings    │  │
│  │  Database: ptv_*, presenze_*, mensa_* tables            │  │
│  │  API: /api/workforce/attendance, /api/workforce/time   │  │
│  │  Why Separate: High-frequency writes (daily attendance) │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  5. Compliance Service                                          │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Modules: Gdpr, Legge104, Legge109, Inail, ContoAnnuale │  │
│  │  Responsibility: Regulatory compliance, reporting       │  │
│  │  Database: gdpr_*, legge_*, inail_* tables              │  │
│  │  API: /api/compliance/gdpr, /api/compliance/reports    │  │
│  │  Why Separate: Legal requirements, immutable records    │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  6. Integration Service                                         │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Modules: Pdnd, Sigma, Europa                           │  │
│  │  Responsibility: External system integrations           │  │
│  │  Database: integration_logs, sync_history               │  │
│  │  API: /api/integrations/sigma, /api/integrations/pdnd  │  │
│  │  Why Separate: Different reliability requirements       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Shared Infrastructure (Would Remain):                          │
│  ├── User Service (User module)                                │
│  ├── Tenant Service (Tenant module)                            │
│  ├── Xot Core (shared libraries)                               │
│  └── Activity Service (cross-cutting audit)                    │
│                                                                  │
│  ⚠️ COMPLEXITY ADDED:                                           │
│  ├── Distributed transactions (Saga pattern needed)            │
│  ├── Inter-service communication (gRPC/RabbitMQ)               │
│  ├── Service discovery                                         │
│  ├── Centralized logging (ELK stack)                           │
│  ├── Distributed tracing (Jaeger/Zipkin)                       │
│  └── API Gateway                                               │
│                                                                  │
│  Recommendation: **DO NOT SPLIT** until clear triggers hit     │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 9. Build Order for Enhancements

### 9.1 Dependency Graph

```
┌─────────────────────────────────────────────────────────────────┐
│              Enhancement Build Order (Priority)                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Phase 1: Foundation (Q2 2026) - MUST HAVE                      │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  1.1 PHP 8.2 → 8.3 Upgrade                               │  │
│  │      └── Prerequisites: None                             │  │
│  │      └── Enables: Typed class constants, enum improvements│  │
│  │      └── Risk: LOW (backward compatible)                 │  │
│  │                                                          │  │
│  │  1.2 OpenAPI Documentation                               │  │
│  │      └── Prerequisites: None                             │  │
│  │      └── Enables: Standardized PA integrations           │  │
│  │      └── Risk: LOW (additive only)                       │  │
│  │                                                          │  │
│  │  1.3 Security Scanning                                   │  │
│  │      └── Prerequisites: None                             │  │
│  │      └── Enables: PA compliance (Law 109/2016)           │  │
│  │      └── Risk: LOW (dev tool only)                       │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Phase 2: Reliability (Q3 2026) - SHOULD HAVE                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  2.1 Redis Queue + Horizon                               │  │
│  │      └── Prerequisites: Redis installation               │  │
│  │      └── Enables: Queue monitoring, failed job alerts    │  │
│  │      └── Risk: LOW (transparent to app logic)            │  │
│  │                                                          │  │
│  │  2.2 Failed Job Monitoring                               │  │
│  │      └── Prerequisites: Horizon installed                │  │
│  │      └── Enables: Production reliability                 │  │
│  │      └── Risk: LOW (additive only)                       │  │
│  │                                                          │  │
│  │  2.3 PDF Engine Consolidation                            │  │
│  │      └── Prerequisites: Audit of all PDF generation      │  │
│  │      └── Enables: Maintainable PDF codebase              │  │
│  │      └── Risk: MEDIUM (template adjustments needed)      │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Phase 3: Integration (Q4 2026) - NICE TO HAVE                 │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  3.1 Saloon PHP Connectors                               │  │
│  │      └── Prerequisites: OpenAPI docs complete            │  │
│  │      └── Enables: Type-safe external API clients         │  │
│  │      └── Risk: MEDIUM (integration testing required)     │  │
│  │                                                          │  │
│  │  3.2 Snapshot Testing                                    │  │
│  │      └── Prerequisites: Pest v4 (already have)           │  │
│  │      └── Enables: PDF/API regression prevention          │  │
│  │      └── Risk: LOW (test-only addition)                  │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Phase 4: Performance (2027) - FUTURE                          │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                                                          │  │
│  │  4.1 Meilisearch (if needed)                             │  │
│  │      └── Prerequisites: 5000+ employees per tenant       │  │
│  │      └── Enables: Fast full-text search                  │  │
│  │      └── Risk: MEDIUM (infrastructure addition)          │  │
│  │                                                          │  │
│  │  4.2 Laravel Octane (if needed)                          │  │
│  │      └── Prerequisites: 1000+ concurrent users           │  │
│  │      └── Enables: High-performance request handling      │  │
│  │      └── Risk: HIGH (Swoole/RoadRunner learning curve)   │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 9.2 Implementation Timeline

```
┌─────────────────────────────────────────────────────────────────┐
│                    Implementation Roadmap                        │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  2026-Q2 (Immediate):                                           │
│  ├── Week 1-2: PHP 8.3 upgrade (staging → production)          │
│  ├── Week 3-4: OpenAPI documentation (Sigma, Europa, Pdnd)     │
│  ├── Week 5-6: Security scanning in CI/CD                      │
│  └── Week 7-8: PDF audit (identify all PDF generation points)  │
│                                                                  │
│  2026-Q3 (Reliability):                                         │
│  ├── Week 1-2: Redis installation + queue migration            │
│  ├── Week 3-4: Horizon setup + monitoring                      │
│  ├── Week 5-6: Failed job monitoring                           │
│  └── Week 7-12: PDF engine consolidation (gradual migration)   │
│                                                                  │
│  2026-Q4 (Integration):                                         │
│  ├── Week 1-4: Saloon connectors (Sigma, Europa, Pdnd)         │
│  ├── Week 5-6: Snapshot testing setup                          │
│  ├── Week 7-8: Integration testing                             │
│  └── Week 9-12: Documentation + training                       │
│                                                                  │
│  2027-Q1 (Performance - Conditional):                           │
│  ├── IF needed: Meilisearch for search performance             │
│  ├── IF needed: Octane for high-traffic scenarios              │
│  └── ELSE: Continue optimization within current architecture   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 10. Anti-Patterns to Avoid

### 10.1 Common Mistakes

| Anti-Pattern | What People Do | Why It's Wrong | Do This Instead |
|--------------|----------------|----------------|-----------------|
| **Direct Filament Extension** | `class MyPage extends Filament\Pages\Page` | Breaks XotBase conventions, loses shared functionality | `class MyPage extends Modules\Xot\Filament\Pages\XotBasePage` |
| **Hardcoded Labels** | `TextInput::make('name')->label('Nome')` | Breaks i18n, requires code changes for translations | `TextInput::make('name')` (auto-translated) |
| **Constructor DI in Actions** | `new CreateAction($dependency)` | Breaks queueable pattern, hard to test | `app(CreateAction::class)->execute($data)` |
| **property_exists() on Models** | `if (property_exists($model, 'attr'))` | Doesn't work with Eloquent dynamic attributes | `if (isset($model->attribute))` |
| **array() Syntax** | `$data = array('key' => 'value')` | Violates PHPStan Level 10, inconsistent | `$data = ['key' => 'value']` |
| **Direct Cross-Module Queries** | `OtherModuleModel::query()->where(...)` | Breaks module boundaries, tight coupling | Call Action from other module |
| **RefreshDatabase in Tests** | `uses(RefreshDatabase::class)` | Schema rebuild too slow for large test suites | `DatabaseTransactions` trait |
| **Ignoring PHPStan Errors** | `@phpstan-ignore-next-line` | Defeats purpose of strict typing | Fix the underlying type error |
| **Multiple PDF Engines** | Using DomPDF + spatie/laravel-pdf + spipu | Maintenance nightmare, inconsistent output | Consolidate to single engine (Spatie) |
| **Synchronous PDF Generation** | Generating PDFs in request cycle | Timeout errors for bulk operations | Queue PDFs with progress tracking |

### 10.2 Brownfield-Specific Anti-Patterns

| Anti-Pattern | Temptation | Reality | Better Approach |
|--------------|------------|---------|-----------------|
| **Big Rewrite** | "Let's rewrite this module properly" | Breaks working functionality, high risk | Refactor incrementally, test thoroughly |
| **Ignore Legacy Code** | "That old code doesn't matter" | Legacy code handles edge cases | Understand why it exists before changing |
| **Over-Engineering** | "Let's add event sourcing everywhere" | Unnecessary complexity for simple CRUD | Use event sourcing only where audit trail critical |
| **Skip Documentation** | "The code is self-documenting" | Brownfield requires explicit docs | Update docs with every code change |
| **Bypass Tests** | "Tests are too hard to update" | Tests prevent regressions | Update tests first, then code |

---

## 11. Italian PA Integration Patterns

### 11.1 Compliance Requirements

```
┌─────────────────────────────────────────────────────────────────┐
│              Italian PA Compliance Architecture                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  D.Lgs. 150/2009 (Performance Evaluation):                      │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Requirements:                                           │  │
│  │  ├── Art. 7: Performance evaluation cycle               │  │
│  │  │   └── Programming → Monitoring → Evaluation          │  │
│  │  ├── Art. 10: Evaluation differentiation                │  │
│  │  │   └── No clustering at high performance levels       │  │
│  │  ├── Art. 14: OIV oversight                             │  │
│  │  │   └── OIV must have access to all evaluation data    │  │
│  │  └── Art. 21: Transparency publication                  │  │
│  │      └── Results must be published on PA website        │  │
│  │                                                          │  │
│  │  PTVX Implementation:                                    │  │
│  │  ├── Performance module (evaluation cycle)              │  │
│  │  ├── Rating module (differentiation enforcement)        │  │
│  │  ├── Transparency portal (future enhancement)           │  │
│  │  └── OIV dashboard (future enhancement)                 │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  GDPR (EU 2016/679):                                           │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Requirements:                                           │  │
│  │  ├── Art. 13-14: Privacy notices                        │  │
│  │  │   └── Must inform data subjects of processing        │  │
│  │  ├── Art. 15: Right of access                           │  │
│  │  │   └── Export all personal data on request            │  │
│  │  ├── Art. 17: Right to erasure                          │  │
│  │  │   └── Delete data when no longer needed              │  │
│  │  ├── Art. 20: Data portability                          │  │
│  │  │   └── Export in machine-readable format              │  │
│  │  └── Art. 30: Processing records                        │  │
│  │      └── Maintain records of processing activities      │  │
│  │                                                          │  │
│  │  PTVX Implementation:                                    │  │
│  │  ├── Gdpr module (consent, policies, rights)            │  │
│  │  ├── Activity module (processing records)               │  │
│  │  ├── Spatie Personal Data Export (already integrated)  │  │
│  │  └── Automated retention policies (future)              │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Law 104/1992 (Disability Support):                            │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Requirements:                                           │  │
│  │  ├── Art. 33: Paid permits (3 days/month)               │  │
│  │  │   └── Track permits separately from vacation         │  │
│  │  ├── Workplace accommodations                           │  │
│  │  │   └── Record accommodations provided                 │  │
│  │  └── Priority in career progression                     │  │
│  │      └── Preferential treatment in evaluations          │  │
│  │                                                          │  │
│  │  PTVX Implementation:                                    │  │
│  │  ├── Legge104 module (permits, certifications)          │  │
│  │  ├── PresenzeAssenze module (permit tracking)           │  │
│  │  └── Progressioni module (preferential treatment)       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  Law 109/2016 (Anti-Corruption):                               │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │  Requirements:                                           │  │
│  │  ├── Anti-mafia certification tracking                  │  │
│  │  │   └── Verify contractors have valid certifications   │  │
│  │  ├── Conflict of interest disclosure                    │  │
│  │  │   └── Record potential conflicts                     │  │
│  │  └── Transparency in procurement                        │  │
│  │      └── Public access to contract data                 │  │
│  │                                                          │  │
│  │  PTVX Implementation:                                    │  │
│  │  ├── Legge109 module (certifications, disclosures)      │  │
│  │  └── Transparency portal (future enhancement)           │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### 11.2 Integration Checklist

```
┌─────────────────────────────────────────────────────────────────┐
│              PA Integration Checklist                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  Pre-Integration:                                               │
│  ├── [ ] OpenAPI documentation generated                       │
│  ├── [ ] Authentication mechanism agreed (OAuth 2.0/SPID)      │
│  ├── [ ] Rate limits defined (requests/minute)                 │
│  ├── [ ] Error codes documented                                │
│  ├── [ ] Test environment credentials obtained                 │
│  └── [ ] Data format agreed (JSON/XML)                         │
│                                                                  │
│  Implementation:                                                │
│  ├── [ ] Saloon connector created                              │
│  ├── [ ] Request/response DTOs defined                         │
│  ├── [ ] Retry logic with exponential backoff                  │
│  ├── [ ] Circuit breaker for failing services                  │
│  ├── [ ] Logging for all API calls                             │
│  └── [ ] Error handling for all HTTP status codes              │
│                                                                  │
│  Testing:                                                       │
│  ├── [ ] Unit tests with fakes                                 │
│  ├── [ ] Integration tests with test environment               │
│  ├── [ ] Load testing (rate limit validation)                  │
│  ├── [ ] Failure scenario testing                              │
│  └── [ ] Security testing (authentication, injection)          │
│                                                                  │
│  Deployment:                                                    │
│  ├── [ ] Configuration in Setting module                       │
│  ├── [ ] Monitoring dashboard (Horizon/Pulse)                  │
│  ├── [ ] Alert rules for failures                              │
│  ├── [ ] Rollback plan documented                              │
│  └── [ ] Support team trained                                  │
│                                                                  │
│  Compliance:                                                    │
│  ├── [ ] Data processing agreement signed                      │
│  ├── [ ] Privacy impact assessment completed                   │
│  ├── [ ] Security documentation provided                       │
│  ├── [ ] Audit trail enabled                                   │
│  └── [ ] Retention policy defined                              │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 12. Sources & References

### 12.1 Technical References

- **Laravel 12 Documentation** — https://laravel.com/docs/12.x
- **Filament v5 Documentation** — https://filamentphp.com/docs/5.x
- **Spatie Queueable Action** — https://github.com/spatie/laravel-queueable-action
- **Spatie Laravel Data** — https://spatie.be/docs/laravel-data
- **Spatie Event Sourcing** — https://spatie.be/docs/laravel-event-sourcing
- **Saloon PHP** — https://saloon.dev
- **Laravel Horizon** — https://laravel.com/docs/12.x/horizon
- **Laravel OpenAPI** — https://github.com/dedoc/laravel-openapi

### 12.2 Italian PA Regulations

- **D.Lgs. 150/2009** — Performance evaluation in public administration
- **D.Lgs. 74/2017** — Performance bonuses and indemnities
- **Law 104/1992** — Disability support and accommodations
- **Law 109/2016** — Anti-corruption and transparency
- **GDPR (EU 2016/679)** — Data protection and privacy
- **CCNL Pubbliche Amministrazioni** — National employment contract for PA

### 12.3 Architecture Patterns

- **Clean Architecture** — Robert C. Martin (Dependency Rule)
- **Domain-Driven Design** — Eric Evans (Bounded Contexts)
- **Modular Monolith** — Kamil Grzybek (modular-monolith-with-ddd)
- **Event Sourcing** — Martin Fowler (event-sourcing pattern)
- **Microservices** — Sam Newman (when to split monoliths)

---

## 13. Confidence Assessment

| Recommendation | Confidence | Rationale |
|----------------|------------|-----------|
| **Stay Modular Monolith** | HIGH | 42+ modules working well, Laraxot provides good boundaries |
| **Actions-over-Services** | HIGH | Consistent pattern across all modules, queueable by default |
| **XotBase Wrappers** | HIGH | Enforces conventions, reduces boilerplate |
| **Multi-Tenant Database** | HIGH | Required for PA data isolation compliance |
| **Event Sourcing (Selective)** | MEDIUM | Critical for audit trails, overkill for simple CRUD |
| **Redis + Horizon** | HIGH | Production standard for queue management |
| **OpenAPI Documentation** | HIGH | Required for PA system integrations |
| **Saloon PHP Connectors** | HIGH | Type-safe API clients, retry logic, testable |
| **PDF Consolidation** | HIGH | Multiple engines create maintenance burden |
| **Meilisearch** | MEDIUM | Only needed for large deployments (5000+ employees) |
| **Laravel Octane** | MEDIUM | Only needed for high-traffic (1000+ concurrent users) |
| **Microservices** | LOW | Not justified at current scale, high complexity |

---

*Architecture research completed: 2026-03-18*
*Next review: 2026-09-18 (biannual)*
*Owner: Development Team*
*Status: Ready for implementation planning*
