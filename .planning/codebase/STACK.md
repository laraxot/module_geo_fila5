# PTVX Technology Stack

> **Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
> **Stack Version**: 2026-Q1  
> **Last Updated**: 2026-03-18

---

## Table of Contents

1. [Core Framework](#core-framework)
2. [Admin Panel & UI](#admin-panel--ui)
3. [Database & Storage](#database--storage)
4. [Testing & Quality](#testing--quality)
5. [Build & Development](#build--development)
6. [Security & Authentication](#security--authentication)
7. [Monitoring & Performance](#monitoring--performance)
8. [Integration & APIs](#integration--apis)
9. [Domain-Specific Packages](#domain-specific-packages)

---

## Core Framework

### Laravel 12.47.0

**Purpose**: Main application framework

**Key Features Used**:
- File-based routing (Laravel Folio)
- Eloquent ORM
- Blade templating
- Artisan CLI
- Service container
- Event/Listener pattern
- Queue system
- Task scheduling

**Configuration**:
```json
{
    "require": {
        "laravel/framework": "^12.3"
    }
}
```

**Key Laravel Packages**:

| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/folio` | ^1.1 | File-based routing |
| `laravel/pennant` | ^1.11 | Feature flags |
| `laravel/pulse` | ^1.2 | Application monitoring |
| `laravel/tinker` | ^2.10.1 | REPL console |

---

## Admin Panel & UI

### Filament v5.0.0

**Purpose**: Admin panel framework

**Key Features Used**:
- Resources (CRUD interfaces)
- Pages (custom admin pages)
- Widgets (dashboard components)
- Tables (data grids with filters)
- Forms (with validation)
- Infolists (read-only data display)
- Actions (modal-based operations)
- Notifications
- Navigation system

**Configuration**:
```json
{
    "require": {
        "filament/filament": "^5.0"
    }
}
```

**Filament Plugins**:

| Plugin | Purpose |
|--------|---------|
| `filament/spatie-laravel-media-library-plugin` | Media library integration |
| `coolsam/panel-modules` | Module management in panel |
| `provtv/filament-nested-resources` | Nested resource support (comment) |

### Livewire v3.x

**Purpose**: Full-stack reactive components

**Key Features Used**:
- Component lifecycle
- Real-time updates
- Form handling
- File uploads
- Pagination
- Lazy loading

**Configuration**:
```json
{
    "require": {
        "livewire/livewire": "*"
    }
}
```

### Volt v1.0

**Purpose**: Single-file Livewire components

**Key Features Used**:
- Functional API
- Class-based API
- Inline component logic in Blade

```json
{
    "require": {
        "livewire/volt": "^1.0"
    }
}
```

### Flux UI v2.1.1

**Purpose**: UI component library for Livewire

**Key Components Used**:
- Buttons, inputs, selects
- Modals, dropdowns, popovers
- Date pickers, file uploads
- Tables, data grids
- Charts, stats
- Navigation, sidebar

```json
{
    "require": {
        "livewire/flux": "^2.1.1"
    }
}
```

### Tailwind CSS v4

**Purpose**: Utility-first CSS framework

**Key Features Used**:
- Utility classes
- Responsive design
- Dark mode
- Custom themes via `@theme`
- Design tokens
- CSS Grid & Flexbox

**Configuration**:
- PostCSS processing
- PurgeCSS for production
- Custom theme in `tailwind.config.js`

---

## Database & Storage

### MySQL / PostgreSQL

**Purpose**: Primary database

**Version**: 8.0+ (MySQL) / 14+ (PostgreSQL)

**Features Used**:
- Transactions
- Foreign keys
- Indexes
- JSON columns
- Full-text search
- Window functions

**Connection Configuration**:
```php
// Multiple connections in config/database.php
'connections' => [
    'xot' => 'mysql',      // Core module data
    'tenant' => 'mysql',   // Tenant-specific data
    'external' => 'mysql', // External integrations
],
```

### Laravel Migrations

**Purpose**: Database schema versioning

**Features Used**:
- Schema builder
- Column types
- Indexes
- Foreign key constraints
- Rollback support
- Anonymous class migrations

**Pattern**:
```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        Schema::create('performance_evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('employee_id')->constrained('users');
            $table->string('period');
            $table->decimal('score', 5, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
```

### Doctrine DBAL

**Purpose**: Database schema introspection

**Version**: Latest

**Use Cases**:
- Column type detection
- Schema comparison
- Database platform detection

```json
{
    "require": {
        "doctrine/dbal": "*"
    }
}
```

### Redis

**Purpose**: Cache and queue driver

**Features Used**:
- Query caching
- Session storage
- Queue backend
- Rate limiting
- Real-time events

### Spatie Laravel Media Library

**Purpose**: File and media management

**Features Used**:
- File associations with models
- Media collections
- Image conversions
- Responsive images
- File downloads

```json
{
    "require": {
        "spatie/laravel-medialibrary": "*"
    }
}
```

---

## Testing & Quality

### Pest PHP v4

**Purpose**: Testing framework

**Key Features Used**:
- Expectations
- Matchers
- Datasets
- Parallel testing
- Coverage reporting
- Browser tests (Pest 4+)

**Configuration**:
```json
{
    "require-dev": {
        "pestphp/pest": "*"
    }
}
```

**Test Pattern**:
```php
it('can create performance evaluation', function () {
    $data = PerformanceEvaluationData::from([...]);
    
    $evaluation = app(CreatePerformanceEvaluationAction::class)
        ->execute($data);
    
    expect($evaluation)
        ->toBeInstanceOf(PerformanceEvaluation::class)
        ->score->toBe($data->score);
});
```

### PHPStan Level 10

**Purpose**: Static analysis

**Configuration**:
- Level 10 (maximum strictness)
- Laravel extensions (Larastan)
- Safe rule extensions
- No ignores allowed

```json
{
    "require-dev": {
        "larastan/larastan": "*",
        "thecodingmachine/phpstan-safe-rule": "*"
    }
}
```

**Execution**:
```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse
```

### Laravel Pint v1.18

**Purpose**: Code formatter

**Configuration**:
- PSR-12 standard
- Laravel-specific rules
- Auto-fix on save (IDE)

```json
{
    "require-dev": {
        "laravel/pint": "^1.18"
    }
}
```

**Execution**:
```bash
./vendor/bin/pint
```

### PHP Insights v2.x

**Purpose**: Code quality metrics

**Metrics**:
- Code style
- Complexity
- Architecture
- Security

```json
{
    "require-dev": {
        "nunomaduro/phpinsights": "*"
    }
}
```

### PHPMD

**Purpose**: Mess detection

**Metrics**:
- Code complexity
- Unused code
- Naming conventions
- Design issues

**Configuration**: `phpmd.ruleset.xml`

### Mockery v1.6

**Purpose**: Mocking framework

**Use Cases**:
- Service mocks
- External API mocks
- Event listener mocks

### Orchestra Testbench

**Purpose**: Laravel package testing

**Features**:
- Full Laravel environment
- Database setup
- Service provider testing

---

## Build & Development

### Vite v5+

**Purpose**: Frontend build tool

**Features Used**:
- Hot Module Replacement (HMR)
- Asset bundling
- Code splitting
- TypeScript support
- CSS processing

**Configuration**:
```javascript
// vite.config.js
export default {
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
};
```

### npm

**Purpose**: Package manager

**Scripts**:
```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "preview": "vite preview"
    }
}
```

### Laravel Boost v2.0

**Purpose**: Development performance

**Features**:
- Autoloader optimization
- Cache warming
- Config caching

### Laravel IDE Helper v3.2

**Purpose**: IDE autocomplete

**Features**:
- Facade helpers
- Model properties
- Macro autocomplete

**Commands**:
```bash
php artisan ide-helper:generate
php artisan ide-helper:models --no-interaction
```

### Laravel Debugbar v3.14

**Purpose**: Development debugging

**Features**:
- Query logging
- Route inspection
- View debugging
- Timeline

### Laravel Sail v1.41

**Purpose**: Docker development environment

**Features**:
- Pre-configured containers
- MySQL, Redis, Mailpit
- Easy setup

---

## Security & Authentication

### Laravel Passport v13.4

**Purpose**: API authentication

**Features Used**:
- OAuth2 server
- Personal access tokens
- Client credentials grant
- Token scopes

```json
{
    "require": {
        "laravel/passport": "^13.4"
    }
}
```

### Laravel Socialite

**Purpose**: OAuth authentication

**Providers Configured**:
- Google
- GitHub
- Microsoft

**Use Cases**:
- Social login
- SSO integration

### Spatie Laravel Permission

**Purpose**: Role and permission management

**Features Used**:
- Roles
- Permissions
- Permission middleware
- Blade directives
- Team support

```json
{
    "require": {
        "spatie/laravel-permission": "*"
    }
}
```

**Pattern**:
```php
// Assign role
$user->assignRole('admin');

// Check permission
if ($user->can('edit evaluations')) {
    // ...
}

// In Blade
@can('edit evaluations')
    <!-- Button -->
@endcan
```

### Sentry Laravel

**Purpose**: Error tracking

**Features Used**:
- Automatic error capture
- Breadcrumbs
- User context
- Release tracking

---

## Monitoring & Performance

### Laravel Pulse v1.2

**Purpose**: Application monitoring

**Metrics Tracked**:
- Slow queries
- Memory usage
- Request throughput
- Exception tracking
- Cache usage
- Queue metrics

**Dashboard**: `/pulse`

### Spatie Laravel Health v1.29

**Purpose**: Health checks

**Checks Configured**:
- Database connection
- Cache status
- Queue status
- Disk space
- CPU load
- Scheduled tasks

```json
{
    "require": {
        "spatie/laravel-health": "^1.29"
    }
}
```

### Spatie CPU Load Health Check

**Purpose**: Server load monitoring

```json
{
    "require": {
        "spatie/cpu-load-health-check": "^1.0"
    }
}
```

### Spatie Laravel Response Cache v7.6

**Purpose**: Response caching

**Features Used**:
- Full-page cache
- Profile-specific cache
- Cache tags

```json
{
    "require": {
        "spatie/laravel-responsecache": "^7.6"
    }
}
```

### Laravel Octane (Optional)

**Purpose**: High-performance runtime

**Features**:
- Swoole/RoadRunner support
- Request caching
- Concurrent tasks

---

## Integration & APIs

### Guzzle HTTP Client

**Purpose**: HTTP requests

**Use Cases**:
- External API calls
- Webhook sending
- File downloads

### Spatie Laravel Data v4.7

**Purpose**: Data transfer objects

**Features Used**:
- Type-safe data objects
- Validation rules
- Transformation
- API resources

```json
{
    "require": {
        "spatie/laravel-data": "^4.7"
    }
}
```

**Pattern**:
```php
class PerformanceEvaluationData extends Data
{
    public function __construct(
        public readonly string $employee_id,
        public readonly string $period,
        public readonly float $score,
    ) {}
    
    public static function rules(): array
    {
        return [
            'employee_id' => ['required', 'uuid'],
            'score' => ['required', 'numeric', 'between:1,10'],
        ];
    }
}
```

### Spatie Laravel Queueable Action

**Purpose**: Action pattern implementation

**Features Used**:
- Queueable actions
- Action chaining
- Progress tracking
- Failed action handling

```json
{
    "require": {
        "spatie/laravel-queueable-action": "^2.16"
    }
}
```

**Pattern**:
```php
class CreateEvaluationAction
{
    use QueueableAction;
    
    public function execute(PerformanceEvaluationData $data): PerformanceEvaluation
    {
        // Business logic
    }
}

// Usage
app(CreateEvaluationAction::class)->execute($data);

// Or queued
app(CreateEvaluationAction::class)
    ->onQueue('evaluations')
    ->execute($data);
```

### Staudenmeir Eloquent Has Many Deep

**Purpose**: Advanced Eloquent relationships

**Features Used**:
- Deep nested relationships
- Many-to-many-through
- Polymorphic relations

```json
{
    "require": {
        "staudenmeir/eloquent-has-many-deep": "*"
    }
}
```

### Staudenmeir Laravel Adjacency List

**Purpose**: Tree structures

**Features Used**:
- Recursive relationships
- Tree queries
- Hierarchy management

---

## Domain-Specific Packages

### Maatwebsite Excel v3.1

**Purpose**: Excel import/export

**Features Used**:
- Export to XLSX/CSV
- Import from Excel
- Queued exports
- Batch inserts

**Use Cases**:
- Performance evaluation exports
- Employee data imports
- Report generation

### Spatie Laravel PDF (via barryvdh/laravel-dompdf)

**Purpose**: PDF generation

**Features Used**:
- Blade to PDF
- Custom styling
- Page breaks
- Headers/footers

**Use Cases**:
- Performance evaluation reports
- Incentive certificates
- Official documents

### Spatie Laravel Model States v2.7

**Purpose**: State machine pattern

**Features Used**:
- State definitions
- State transitions
- State validation

**Use Cases**:
- Evaluation workflow states
- Approval process states

### Spatie Laravel Model Status

**Purpose**: Model status tracking

**Features Used**:
- Pending status
- Approved status
- Rejected status

### Spatie Laravel Sluggable v3.6

**Purpose**: URL-friendly slugs

**Features Used**:
- Auto-generation
- Unique constraints
- History tracking

### Spatie Laravel Tags

**Purpose**: Tagging system

**Features Used**:
- Multi-language tags
- Tag types
- Tag collections

### Sushi v2.5

**Purpose**: Array-to-database

**Features Used**:
- In-memory SQLite
- Array data as Eloquent models

**Use Cases**:
- Static data tables
- Configuration data

### Tightenco Parental

**Purpose**: Single-table inheritance

**Features Used**:
- Class inheritance
- Type column
- Instantiation

### Laravel Modules (nwidart)

**Purpose**: Modular architecture

**Features Used**:
- Module scaffolding
- Module discovery
- Asset publishing
- Migration management

```json
{
    "require": {
        "nwidart/laravel-modules": "*"
    }
}
```

---

## Development Tools

### Laravel Debugbar

**Purpose**: Debugging toolbar

**Features**:
- Query logging
- Route info
- View debugging
- Timeline

### Ray (Optional)

**Purpose**: Debugging tool

**Features**:
- Remote debugging
- Variable inspection
- Performance profiling

### Rector (Comment)

**Purpose**: Automated refactoring

**Use Cases**:
- PHP version upgrades
- Code modernization
- Framework migrations

---

## Package Summary Table

### Core Dependencies

| Package | Version | Category | Purpose |
|---------|---------|----------|---------|
| `laravel/framework` | ^12.3 | Framework | Core framework |
| `filament/filament` | ^5.0 | UI | Admin panel |
| `livewire/livewire` | * | UI | Reactive components |
| `livewire/flux` | ^2.1.1 | UI | Component library |
| `nwidart/laravel-modules` | * | Architecture | Modular structure |

### Testing & Quality

| Package | Version | Purpose |
|---------|---------|---------|
| `pestphp/pest` | * | Testing framework |
| `larastan/larastan` | * | Static analysis |
| `laravel/pint` | ^1.18 | Code formatting |
| `nunomaduro/phpinsights` | * | Code quality |
| `mockery/mockery` | ^1.6 | Mocking |
| `orchestra/testbench` | * | Package testing |

### Security

| Package | Version | Purpose |
|---------|---------|---------|
| `laravel/passport` | ^13.4 | API auth |
| `spatie/laravel-permission` | * | RBAC |
| `sentry/sentry-laravel` | * | Error tracking |

### Data & Business Logic

| Package | Version | Purpose |
|---------|---------|---------|
| `spatie/laravel-data` | ^4.7 | DTOs |
| `spatie/laravel-queueable-action` | ^2.16 | Actions |
| `spatie/laravel-model-states` | ^2.7 | State machine |

---

## Version Compatibility Matrix

| Component | Version | PHP Required |
|-----------|---------|--------------|
| Laravel | 12.47 | ^8.2 |
| Filament | 5.0 | ^8.2 |
| Livewire | 3.x | ^8.1 |
| Pest | 4.x | ^8.2 |
| PHPStan | 1.x | ^8.1 |

---

## Related Documentation

- [Architecture Overview](./ARCHITECTURE.md)
- [Module Catalog](./MODULES.md)
- [Domain Overview](./DOMAIN.md)
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)

---

*Last Updated: 2026-03-18*
