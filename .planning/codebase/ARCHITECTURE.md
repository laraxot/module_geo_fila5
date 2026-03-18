# PTVX Architecture

> **Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
> **Architecture**: Laraxot Modular Monolith  
> **Last Updated**: 2026-03-18

---

## Table of Contents

1. [System Overview](#system-overview)
2. [Architectural Principles](#architectural-principles)
3. [Modular Structure](#modular-structure)
4. [Core Components](#core-components)
5. [Module Dependencies](#module-dependencies)
6. [Data Flow](#data-flow)
7. [Integration Patterns](#integration-patterns)

---

## System Overview

PTVX is a **modular enterprise HR & Performance evaluation system** designed for Italian Public Administrations. The system follows a **modular monolith architecture** built on the Laraxot framework, providing:

- **42+ modules** organized in a hierarchical dependency structure
- **Domain-driven design** with clear bounded contexts
- **Actions-over-Services** pattern for business logic
- **Filament v5** for admin panel UI
- **Multi-tenancy support** for multiple public administrations

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                      Presentation Layer                          │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Filament v5 Admin Panel                     │   │
│  │    (Resources, Pages, Widgets, Tables, Forms)           │   │
│  └─────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Livewire + Flux UI Components              │   │
│  └─────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                       Application Layer                          │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │         Spatie Queueable Actions (Business Logic)       │   │
│  │         (CreateUserAction, EvaluatePerformanceAction)   │   │
│  └─────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Spatie Laravel Data (DTOs)                 │   │
│  │              (UserData, PerformanceData)                │   │
│  └─────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                        Domain Layer                              │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │               Eloquent Models (XotBaseModel)            │   │
│  │         (User, Performance, Incentivo, Progressione)    │   │
│  └─────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Value Objects & Enums                      │   │
│  └─────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│                     Infrastructure Layer                         │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │           MySQL/PostgreSQL Database                     │   │
│  │           (Multi-tenant, Multi-connection)              │   │
│  └─────────────────────────────────────────────────────────┘   │
│  ┌─────────────────────────────────────────────────────────┐   │
│  │              Redis Cache & Queue                        │   │
│  └─────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Architectural Principles

### 1. Modular Monolith (Laraxot Pattern)

The system uses `nwidart/laravel-modules` for modular organization:

- **Each module is a self-contained unit** with its own:
  - Models, Actions, Services
  - Database migrations and seeders
  - Filament resources and pages
  - Configuration and routes
  - Tests and documentation

- **Modules communicate through well-defined interfaces**:
  - No direct cross-module model access
  - Dependencies declared in `module.json`
  - Shared functionality via Xot core module

### 2. XotBase Wrappers

**CRITICAL RULE**: Never extend Laravel/Filament classes directly. Always use XotBase wrappers.

```php
// ❌ WRONG - Direct extension
class UserPage extends Filament\Pages\Page

// ✅ CORRECT - XotBase wrapper
class UserPage extends Modules\Xot\Filament\Pages\XotBasePage
```

**Available XotBase Classes**:
- `XotBaseModel` - Base Eloquent model
- `XotBaseResource` - Base Filament resource
- `XotBasePage` - Base Filament page
- `XotBaseWidget` - Base Filament widget
- `XotBaseServiceProvider` - Base service provider

### 3. Actions-over-Services

Business logic is encapsulated in **Spatie Queueable Actions**:

```php
// ✅ CORRECT - Action pattern
class CreatePerformanceEvaluationAction
{
    use QueueableAction;
    
    public function execute(PerformanceEvaluationData $data): PerformanceEvaluation
    {
        // Business logic here
    }
}

// Usage
app(CreatePerformanceEvaluationAction::class)->execute($data);
```

**Benefits**:
- Single responsibility principle
- Queueable without code changes
- Easy to test in isolation
- Clear dependency injection

### 4. Data Transfer Objects

All data transfer uses **Spatie Laravel Data**:

```php
class PerformanceEvaluationData extends Data
{
    public function __construct(
        public readonly string $employee_id,
        public readonly string $period,
        public readonly float $score,
        public readonly ?string $notes = null,
    ) {}
}
```

**Benefits**:
- Type-safe data transfer
- Built-in validation
- Immutable by default
- Auto-documentation

### 5. Multi-Tenancy

Built-in support for multiple public administrations:

- **Tenant module** provides isolation
- **Database connections** per tenant
- **Shared Xot core** across all tenants
- **Tenant-aware models** via trait

---

## Modular Structure

### Module Categories

#### 1. Core Infrastructure Modules

| Module | Priority | Description |
|--------|----------|-------------|
| **Xot** | 2 | Core base classes, shared services, foundational patterns |
| **User** | 0 | Authentication, authorization, roles, permissions |
| **Tenant** | 2 | Multi-tenancy support, tenant isolation |
| **Setting** | 0 | System configuration and settings management |
| **Lang** | 4 | Translation and localization system |

#### 2. Domain Modules (HR & Performance)

| Module | Description |
|--------|-------------|
| **Performance** | Employee performance evaluations, KPI tracking |
| **Ptv** | Core PTV (Personale Tempo Variabile) functionality |
| **Incentivi** | Performance bonuses, productivity rewards |
| **IndennitaCondizioniLavoro** | Working conditions indemnities |
| **IndennitaResponsabilita** | Responsibility-based indemnities |
| **Progressioni** | Career progression tracking |
| **PresenzeAssenze** | Attendance and absence management |
| **Job** | Job positions and organizational structure |
| **Rating** | Employee rating and scoring |
| **Questionari** | Surveys and questionnaires |
| **Badge** | Skills and competencies tracking |

#### 3. Compliance & Legal Modules

| Module | Description |
|--------|-------------|
| **Gdpr** | GDPR compliance, consent management |
| **Legge104** | Law 104 disability support management |
| **Legge109** | Law 109 public works compliance |
| **Inail** | INAIL workplace injury reporting |
| **ContoAnnuale** | Annual financial reporting |
| **MobilitaVolontaria** | Voluntary mobility programs |
| **Sindacati** | Union relations and permits |
| **CertFisc** | Fiscal certifications |

#### 4. Integration Modules

| Module | Description |
|--------|-------------|
| **Pdnd** | PDND (Piattaforma Digitale Nazionale Dati) integration |
| **Sigma** | External Sigma system integration |
| **Europa** | European systems integration |

#### 5. Utility Modules

| Module | Description |
|--------|-------------|
| **Activity** | User activity tracking and audit logs |
| **Media** | File and media management |
| **Notify** | Notifications system |
| **UI** | UI components and design system |
| **Seo** | SEO optimization |
| **DbForge** | Database management tools |
| **Mensa** | Canteen meal booking |
| **Prenotazioni** | General booking system |

### Module Directory Structure

```
Modules/{ModuleName}/
├── app/                          # ALL PHP classes go here
│   ├── Actions/                  # Business logic (Queueable Actions)
│   ├── Datas/                    # Data objects (Spatie Laravel Data)
│   ├── Filament/                 # Filament resources, pages, widgets
│   │   ├── Resources/
│   │   ├── Pages/
│   │   └── Widgets/
│   ├── Http/                     # HTTP layer
│   │   ├── Controllers/
│   │   └── Requests/
│   ├── Models/                   # Eloquent models (extend XotBaseModel)
│   ├── Providers/                # Service providers
│   ├── Services/                 # Services (legacy, being migrated)
│   ├── Enums/                    # PHP 8.1+ backed enums
│   ├── Traits/                   # Reusable traits
│   └── ValueObjects/             # Domain value objects
├── config/                       # Module configuration
├── database/                     # Database layer
│   ├── factories/                # Model factories
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── docs/                         # Module documentation
├── lang/                         # Translations
│   ├── en/
│   └── it/
├── resources/                    # Resources
│   ├── views/                    # Blade views
│   └── assets/                   # CSS, JS
├── routes/                       # Route definitions
│   ├── web.php
│   └── api.php
├── tests/                        # Pest tests
│   ├── Feature/
│   └── Unit/
├── composer.json                 # Module dependencies
└── module.json                   # Module metadata
```

**Exception**: Xot module can have special folders in root (`helpers/`, `Helpers/`, `packages/`, `stubs/`) for legacy reasons.

---

## Core Components

### Xot Module - The Heart

The Xot module is the **foundation** of the entire system:

#### Base Classes

| Class | Purpose |
|-------|---------|
| `XotBaseModel` | Base Eloquent model with shared traits |
| `XotBaseMigration` | Standardized migration patterns |
| `XotBaseResource` | Base Filament resource |
| `XotBasePage` | Base Filament page |
| `XotBaseWidget` | Base Filament widget |
| `XotBaseServiceProvider` | Modular service provider |

#### Shared Traits

- `HasXotTable` - Filament table management
- `InteractsWithForms` - Form handling in widgets
- `RelationX` - Extended many-to-many relations

#### Core Services

- Array manipulation utilities
- Helper functions (via `helpers/Helper.php`)
- Database connection management
- Multi-tenancy support

### User Module - Authentication & Authorization

```
Modules/User/
├── Models/
│   ├── User (extends XotBaseModel)
│   └── Role (Spatie Permission)
├── Actions/
│   ├── CreateUserAction
│   ├── UpdateUserAction
│   └── DeleteUserAction
├── Providers/
│   ├── UserServiceProvider
│   ├── PassportServiceProvider
│   └── SocialiteServiceProvider
└── Filament/
    └── Resources/
        └── UserResource
```

**Features**:
- Laravel Passport API authentication
- Laravel Socialite OAuth (Google, GitHub, Microsoft)
- Spatie Laravel Permission (roles & permissions)
- Multi-guard support

### Tenant Module - Multi-Tenancy

```
Modules/Tenant/
├── Models/
│   └── Tenant (extends XotBaseModel)
├── Actions/
│   ├── CreateTenantAction
│   └── SwitchTenantAction
└── Middleware/
    └── TenantIdentification
```

**Features**:
- Database-per-tenant isolation
- Shared tenant configuration
- Tenant-aware model scoping
- Automatic tenant switching

---

## Module Dependencies

### Dependency Graph

```
                    ┌─────────┐
                    │   Xot   │
                    │ (Core)  │
                    └────┬────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
    ┌────▼────┐    ┌────▼────┐    ┌────▼────┐
    │  User   │    │ Tenant  │    │ Setting │
    └────┬────┘    └────┬────┘    └────┬────┘
         │               │               │
         └───────────────┼───────────────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
    ┌────▼────┐    ┌────▼────┐    ┌────▼────┐
    │ Lang    │    │   UI    │    │ Activity│
    └─────────┘    └─────────┘    └────┬────┘
                                       │
                    ┌──────────────────┼──────────────────┐
                    │                  │                  │
               ┌────▼────┐       ┌────▼────┐       ┌────▼────┐
               │Performance│       │   Ptv   │       │Incentivi│
               └─────────┘       └─────────┘       └─────────┘
```

### Declared Dependencies

Modules declare dependencies in `module.json`:

```json
{
    "name": "Activity",
    "requires": ["Xot", "User"]
}
```

**Known Dependencies**:

| Module | Requires |
|--------|----------|
| Activity | Xot, User |
| DbForge | Xot, User |
| Performance | Xot, User, Tenant |
| Incentivi | Xot, User, Performance |
| Progressioni | Xot, User, Performance |
| PresenzeAssenze | Xot, User |
| Gdpr | Xot, User |
| Notify | Xot, User |
| Media | Xot |
| UI | Xot |

---

## Data Flow

### Typical Request Flow

```
1. HTTP Request
       ↓
2. Route (module routes/web.php)
       ↓
3. Controller (thin HTTP layer)
       ↓
4. Form Request (validation + DTO)
       ↓
5. Action (business logic)
       ↓
6. Model (data persistence)
       ↓
7. Database (MySQL/PostgreSQL)
       ↓
8. Response (Filament page/JSON)
```

### Example: Create Performance Evaluation

```php
// 1. Filament Resource
class PerformanceEvaluationResource extends XotBaseResource
{
    public static function model(): string
    {
        return PerformanceEvaluation::class;
    }
    
    // 2. Form Schema
    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->relationship('employee', 'name'),
            DatePicker::make('evaluation_date'),
            TextInput::make('score')
                ->numeric()
                ->minValue(1)
                ->maxValue(10),
            Textarea::make('notes'),
        ]);
    }
}

// 3. Action (called by Filament)
class CreatePerformanceEvaluationAction
{
    use QueueableAction;
    
    public function execute(PerformanceEvaluationData $data): PerformanceEvaluation
    {
        // Business logic: validate period, check duplicates
        $this->validateEvaluationPeriod($data);
        
        // Create evaluation
        return PerformanceEvaluation::create([
            'employee_id' => $data->employee_id,
            'period' => $data->period,
            'score' => $data->score,
            'notes' => $data->notes,
        ]);
    }
}

// 4. Data Object
class PerformanceEvaluationData extends Data
{
    public function __construct(
        public readonly string $employee_id,
        public readonly string $period,
        public readonly float $score,
        public readonly ?string $notes = null,
    ) {}
    
    // Validation rules
    public static function rules(): array
    {
        return [
            'employee_id' => ['required', 'uuid', 'exists:users,id'],
            'period' => ['required', 'string'],
            'score' => ['required', 'numeric', 'between:1,10'],
        ];
    }
}
```

### Cross-Module Data Flow

```
┌──────────────┐
│  Incentivi   │  (Needs performance data)
└──────┬───────┘
       │
       │ Calls Action from Performance module
       ↓
┌──────────────┐
│ Performance  │  (Provides evaluation scores)
└──────┬───────┘
       │
       │ Queries User module for employee data
       ↓
┌──────────────┐
│     User     │  (Provides employee info)
└──────────────┘
```

**Rule**: Modules should never directly access another module's models. Use Actions instead.

---

## Integration Patterns

### 1. Action Chaining

Multiple actions can be chained for complex workflows:

```php
// Sequential execution
$evaluation = app(CreateEvaluationAction::class)->execute($data);
app(NotifyEvaluationAction::class)->execute($evaluation);
app(CalculateBonusAction::class)->execute($evaluation);

// Or queued
app(CreateEvaluationAction::class)
    ->onQueue('evaluations')
    ->execute($data)
    ->chain([
        new NotifyEvaluationAction(),
        new CalculateBonusAction(),
    ]);
```

### 2. Event-Driven Communication

Modules communicate via Laravel events:

```php
// In Performance module
event(new PerformanceEvaluationCreated($evaluation));

// In Incentivi module (listener)
class CalculateIncentiveListener
{
    public function handle(PerformanceEvaluationCreated $event): void
    {
        // Calculate incentive based on evaluation
    }
}
```

### 3. Shared Database Connections

Xot provides centralized connection management:

```php
// In Xot config
'connections' => [
    'xot' => 'mysql',      // Core data
    'tenant' => 'mysql',   // Tenant-specific
    'external' => 'mysql', // External integrations
],

// Usage in models
class PerformanceEvaluation extends XotBaseModel
{
    protected $connection = 'tenant';
}
```

### 4. Multi-Tenancy Isolation

```php
// Tenant scope automatically applied
Tenant::current()->run(function () {
    // All queries scoped to current tenant
    $evaluations = PerformanceEvaluation::all();
});
```

---

## Quality Gates

### PHPStan Level 10

All modules must pass PHPStan Level 10 analysis:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse
```

**Requirements**:
- `declare(strict_types=1)` in every file
- No `@phpstan-ignore` annotations
- Full type coverage
- No `property_exists()` on Eloquent models

### Testing

All modules use Pest PHP v4:

```bash
./vendor/bin/pest
```

**Patterns**:
- No `RefreshDatabase` (use `DatabaseTransactions`)
- Action testing with `app(Action::class)->execute()`
- Model factories with `HasXotFactory` trait

### Code Formatting

Laravel Pint enforces PSR-12:

```bash
./vendor/bin/pint
```

---

## Related Documentation

- [Module Catalog](./MODULES.md)
- [Technology Stack](./STACK.md)
- [Domain Overview](./DOMAIN.md)
- [Module Structure Rule](../../laravel/Modules/Xot/docs/module-directory-structure-rule.md)
- [Actions-over-Services](./architecture/actions-over-services.md)

---

*Last Updated: 2026-03-18*
