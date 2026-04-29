---
stepsCompleted: ['step-01-init']
inputDocuments:
  - '_bmad-output/prd.md'
  - '_bmad-output/codebase/architecture-analysis.md'
  - '_bmad-output/codebase/technology-stack.md'
  - '_bmad-output/codebase/quality-assessment.md'
  - '_bmad-output/codebase/concerns-and-debt.md'
  - '.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md'
workflowType: 'architecture'
project_name: 'FixCity Fila5'
user_name: 'Xot'
date: '2026-04-01'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

---

## 1. Executive Summary

### 1.1 Architecture Vision

FixCity Fila5 adotta un'**architettura modulare monolitica** basata sul framework Laraxot, con separazione chiara dei livelli e dipendenze che puntano verso l'interno (Dependency Rule).

### 1.2 Key Architectural Decisions

| ID | Decision | Status | Impact |
|----|----------|--------|--------|
| ARCH-001 | Modular Monolith with Laraxot | ✅ Approved | High |
| ARCH-002 | Actions-over-Services pattern | ✅ Approved | High |
| ARCH-003 | XotBase wrapper classes | ✅ Approved | High |
| ARCH-004 | Volt + Folio + Filament stack | ✅ Approved | Medium |
| ARCH-005 | Multi-tenancy database isolation | ✅ Approved | High |
| ARCH-006 | Spatie QueueableAction | ✅ Approved | Medium |
| ARCH-007 | PHPStan Level 10 enforcement | ✅ Approved | Medium |
| ARCH-008 | Pest PHP testing framework | ✅ Approved | Medium |

---

## 2. System Architecture

### 2.1 High-Level Architecture

```
┌─────────────────────────────────────────────────────────┐
│                  PRESENTATION LAYER                      │
│  ┌──────────────────┐  ┌─────────────────────────────┐  │
│  │  Filament v5     │  │  Public Site                │  │
│  │  Admin Panel     │  │  (Folio + Volt + Livewire)  │  │
│  │  - Resources     │  │  - CMS Pages                │  │
│  │  - Widgets       │  │  - Blog                     │  │
│  │  - Actions       │  │  - User Dashboard           │  │
│  └──────────────────┘  └─────────────────────────────┘  │
│              ↓                    ↓                       │
│  ┌──────────────────────────────────────────────────┐   │
│  │              Flux UI v2 Components                │   │
│  │         (Tailwind CSS v4 + Alpine.js)             │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│                 APPLICATION LAYER                        │
│  ┌──────────────────┐  ┌─────────────────────────────┐  │
│  │  Action Classes  │  │  Form Request Validation    │  │
│  │  (Spatie QA)     │  │  - Rules                    │  │
│  │  - handle()      │  │  - Messages                 │  │
│  │  - queueable     │  │  - DTOs                     │  │
│  └──────────────────┘  └─────────────────────────────┘  │
│                          ↓                               │
│  ┌──────────────────────────────────────────────────┐   │
│  │              Domain Services                     │   │
│  │         (Business Logic Layer)                   │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│                   DOMAIN LAYER                           │
│  ┌──────────────────┐  ┌─────────────────────────────┐  │
│  │  Domain Models   │  │  Contracts/Interfaces       │  │
│  │  (XotBaseModel)  │  │  - Repository interfaces    │  │
│  │  - Entities      │  │  - Service contracts        │  │
│  │  - Value Objects │  │  - Strategy interfaces      │  │
│  └──────────────────┘  └─────────────────────────────┘  │
│                          ↓                               │
│  ┌──────────────────────────────────────────────────┐   │
│  │              Domain Policies                     │   │
│  │         (Authorization & Business Rules)         │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│              INFRASTRUCTURE LAYER                        │
│  ┌──────────────────┐  ┌─────────────────────────────┐  │
│  │  Data Access     │  │  External Services          │  │
│  │  - Eloquent ORM  │  │  - AI Services (Ollama)     │  │
│  │  - Query Builders│  │  - Maps (Google/OSM)        │  │
│  │  - Repositories  │  │  - SMS/Email providers      │  │
│  └──────────────────┘  └─────────────────────────────┘  │
│                          ↓                               │
│  ┌──────────────────┐  ┌─────────────────────────────┐  │
│  │  Database        │  │  Supporting Infrastructure  │  │
│  │  - MySQL/PG      │  │  - Redis (cache/queue)      │  │
│  │  - Migrations    │  │  - File storage             │  │
│  │  - Seeders       │  │  - CDN                      │  │
│  └──────────────────┘  └─────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

### 2.2 Module Architecture

Il sistema è organizzato in **17 moduli** indipendenti ma collaborativi:

```
┌──────────────────────────────────────────────────────────┐
│                    CORE MODULES                           │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  Xot        │ │  User       │ │  Tenant             │ │
│  │  (Base)     │ │ (Auth/RBAC) │ │ (Multi-tenancy)     │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
└──────────────────────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────┐
│                  DOMAIN MODULES                           │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  Fixcity    │ │  Geo        │ │  Activity           │ │
│  │  (Tickets)  │ │ (Maps/Geo)  │ │  (Logging)          │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  Cms        │ │  Blog       │ │  Comment            │ │
│  │  (Content)  │ │ (Articles)  │ │  (Feedback)         │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  Media      │ │  Notify     │ │  Rating             │ │
│  │  (Files)    │ │ (Notif.)    │ │  (Reviews)          │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
└──────────────────────────────────────────────────────────┘
                          ↓
┌──────────────────────────────────────────────────────────┐
│                 SUPPORT MODULES                           │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  Lang       │ │  Seo        │ │  Gdpr               │ │
│  │  (i18n)     │ │ (SEO)       │ │  (Compliance)       │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────────────┐ │
│  │  UI         │ │  AI         │ │  Job                │ │
│  │  (Components)│ │(ML/AI)     │ │  (Employment)       │ │
│  └─────────────┘ └─────────────┘ └─────────────────────┘ │
└──────────────────────────────────────────────────────────┘
```

### 2.3 Module Dependency Graph

```
                    ┌─────────┐
                    │  Xot    │
                    │ (Core)  │
                    └────┬────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
    ┌────▼────┐    ┌────▼────┐    ┌─────▼─────┐
    │  User   │    │ Tenant  │    │   Lang    │
    └────┬────┘    └────┬────┘    └─────┬─────┘
         │               │               │
         └───────────────┼───────────────┘
                         │
              ┌──────────▼──────────┐
              │     Fixcity         │
              │   (Core Domain)     │
              └──────────┬──────────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
    ┌────▼────┐    ┌────▼────┐    ┌─────▼─────┐
    │  Geo    │    │  Media  │    │  Notify   │
    └─────────┘    └─────────┘    └───────────┘
```

---

## 3. Architectural Patterns

### 3.1 Design Patterns Implementati

| Pattern | Implementation | Module | Status |
|---------|---------------|--------|--------|
| **Repository** | Data access abstraction | Xot | ✅ |
| **Strategy** | Config resolvers | Xot | ✅ |
| **Command** | Action handlers | All | ✅ |
| **Factory** | Model creation | Xot | ✅ |
| **Observer** | Event-driven architecture | Notify | ✅ |
| **Decorator** | XotBase wrappers | All | ✅ |
| **Template Method** | Base classes | Xot | ✅ |

### 3.2 Action Pattern (Spatie QueueableAction)

```php
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Actions\Ticket;

use Spatie\QueueableAction\QueueableAction;

class CreateTicket
{
    use QueueableAction;

    public function handle(array $data): Ticket
    {
        // Business logic here
        return Ticket::create($data);
    }
}
```

**Usage:**
```php
// Synchronous
$ticket = new CreateTicket()->handle($data);

// Asynchronous
CreateTicket::dispatch($data);

// Chained
(new CreateTicket())
    ->onQueue('tickets')
    ->handle($data);
```

### 3.3 XotBase Pattern

Tutti i modelli estendono `XotBaseModel`:

```php
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Models;

use Xot\Base\Models\BaseModel;

class Ticket extends BaseModel
{
    protected $table = 'fixcity_tickets';
    
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
    ];
    
    public function casts(): array
    {
        return [
            'id' => 'integer',
            'priority' => 'integer',
            'created_at' => 'datetime',
        ];
    }
    
    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## 4. Database Architecture

### 4.1 Database Strategy

- **Development**: SQLite (rapido, testing locale)
- **Production**: MySQL 8.0+ o PostgreSQL 14+
- **Multi-Tenancy**: Database per tenant o schema isolation

### 4.2 Key Entities

```
┌──────────────────────────────────────────────────────────┐
│                    CORE ENTITIES                          │
└──────────────────────────────────────────────────────────┘

┌──────────────┐       ┌──────────────┐       ┌──────────────┐
│    users     │       │    tenants    │       │   tickets    │
├──────────────┤       ├──────────────┤       ├──────────────┤
│ id           │       │ id           │       │ id           │
│ name         │       │ name         │       │ title        │
│ email        │◄──────┤ tenant_id    │       │ description  │
│ password     │       │ config       │       │ status       │
│ role_id      │       │ created_at   │       │ priority     │
│ tenant_id    │       └──────────────┘       │ user_id      │
│ created_at   │                              │ assigned_to  │
└──────────────┘                              │ created_at   │
       │                                      └──────────────┘
       │                                             │
       │                                             │
┌──────────────┐                              ┌──────────────┐
│    roles     │                              │   comments   │
├──────────────┤                              ├──────────────┤
│ id           │                              │ id           │
│ name         │                              │ ticket_id    │
│ permissions  │                              │ user_id      │
└──────────────┘                              │ content      │
                                              │ created_at   │
                                              └──────────────┘
```

### 4.3 Migration Strategy

**Forward-Only Migrations** (MAI refresh/rollback):

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('fixcity_tickets')) {
            Schema::create('fixcity_tickets', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('status')->default('new');
                $table->integer('priority')->default(1);
                $table->foreignId('user_id')->constrained();
                $table->timestamps();
            });
        }
    }
};
```

---

## 5. API Architecture

### 5.1 API Design Principles

- **RESTful**: Resource-oriented design
- **Versioning**: URI versioning (`/api/v1/`)
- **Authentication**: JWT via Laravel Passport
- **Rate Limiting**: Redis-backed
- **Documentation**: OpenAPI 3.0 (Swagger)

### 5.2 API Endpoints (v1)

```
Authentication:
  POST   /api/v1/auth/login
  POST   /api/v1/auth/register
  POST   /api/v1/auth/refresh
  POST   /api/v1/auth/logout

Tickets:
  GET    /api/v1/tickets
  POST   /api/v1/tickets
  GET    /api/v1/tickets/{id}
  PATCH  /api/v1/tickets/{id}
  DELETE /api/v1/tickets/{id}
  
Users:
  GET    /api/v1/users
  GET    /api/v1/users/{id}
  PATCH  /api/v1/users/{id}
  
Tenants:
  GET    /api/v1/tenants
  POST   /api/v1/tenants
  GET    /api/v1/tenants/{id}
```

### 5.3 API Resource Pattern

```php
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            'user' => new UserResource($this->whenLoaded('user')),
            'comments' => CommentResource::collection(
                $this->whenLoaded('comments')
            ),
        ];
    }
}
```

---

## 6. Security Architecture

### 6.1 Authentication & Authorization

```
┌──────────────────────────────────────────────────────────┐
│              AUTHENTICATION FLOW                          │
└──────────────────────────────────────────────────────────┘

User Request
     │
     ▼
┌─────────────┐
│  Middleware │
│  Auth:api   │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Passport  │
│  JWT Verify │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│    User     │
│   Model     │
└──────┬──────┘
       │
       ▼
┌─────────────┐
│   Policies  │
│  (RBAC)     │
└──────┬──────┘
       │
       ▼
   Resource
   Access
```

### 6.2 Security Layers

1. **Network Layer**: HTTPS/TLS, firewall rules
2. **Application Layer**: CSRF, XSS, SQL injection prevention
3. **Authentication Layer**: JWT, OAuth2, rate limiting
4. **Authorization Layer**: RBAC, policies, gates
5. **Data Layer**: Encryption, hashing, GDPR compliance

### 6.3 GDPR Compliance

- **Consenso**: Gdpr module per gestione consensi
- **Diritto all'oblio**: Soft delete + anonymization
- **Portabilità dati**: Export JSON/CSV
- **Privacy by design**: Data minimization, purpose limitation

---

## 7. Performance Architecture

### 7.1 Caching Strategy

```
┌──────────────────────────────────────────────────────────┐
│              CACHING LAYERS                               │
└──────────────────────────────────────────────────────────┘

Layer 1: Browser Cache
  - Static assets (Vite hashed)
  - API responses (ETag, Last-Modified)
  
Layer 2: CDN
  - Images, media files
  - Static pages
  
Layer 3: Redis Cache
  - Query results
  - Session data
  - API rate limiting
  
Layer 4: Application Cache
  - Config cache
  - Route cache
  - View cache
```

### 7.2 Query Optimization

```php
// ❌ N+1 Query Problem
$tickets = Ticket::all();
foreach ($tickets as $ticket) {
    echo $ticket->user->name; // N+1 queries!
}

// ✅ Eager Loading
$tickets = Ticket::with('user')->get();
foreach ($tickets as $ticket) {
    echo $ticket->user->name; // 1 query total
}

// ✅ Query Builder Optimization
$tickets = Ticket::query()
    ->with(['user', 'comments' => function ($q) {
        $q->latest()->limit(5);
    }])
    ->where('status', '!=', 'closed')
    ->orderBy('priority', 'desc')
    ->paginate(20);
```

### 7.3 Queue Architecture

```
┌──────────────────────────────────────────────────────────┐
│              QUEUE SYSTEM                                 │
└──────────────────────────────────────────────────────────┘

┌──────────┐     ┌──────────┐     ┌──────────┐
│  Web     │────►│  Redis   │────►│  Worker  │
│  Request │     │  Queue   │     │  Process │
└──────────┘     └──────────┘     └──────────┘
                                      │
                                      ▼
                               ┌──────────┐
                               │  Action  │
                               │  handle  │
                               └──────────┘

Queues:
  - default: General jobs
  - tickets: Ticket processing
  - notifications: Email/SMS
  - reports: Heavy reporting
```

---

## 8. Testing Architecture

### 8.1 Testing Pyramid

```
           /\
          /  \
         / E2E \        Browser Tests (10%)
        /______\
       /        \
      /Integration\    Integration Tests (30%)
     /______________\
    /                \
   /    Unit Tests    \  Unit Tests (60%)
  /____________________\
```

### 8.2 Testing Stack

- **Framework**: Pest PHP v4
- **Assertions**: Expect API
- **Mocking**: Mockery, Pest mocks
- **Database**: RefreshDatabase trait
- **Browser**: Pest Browser (Playwright)

### 8.3 Test Organization

```
tests/
├── Unit/
│   ├── Actions/
│   ├── Models/
│   └── Services/
├── Feature/
│   ├── Http/
│   ├── Resources/
│   └── Filament/
└── Browser/
    ├── Pages/
    └── Components/
```

---

## 9. Deployment Architecture

### 9.1 Environment Stack

```
┌──────────────────────────────────────────────────────────┐
│              PRODUCTION ENVIRONMENT                       │
└──────────────────────────────────────────────────────────┘

┌─────────────┐
│   Cloudflare│ (CDN + DDoS Protection)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  Load       │
│  Balancer   │
└──────┬──────┘
       │
       ├─────────────┬─────────────┐
       │             │             │
┌──────▼──────┐ ┌───▼───────┐ ┌───▼───────┐
│  Web Server │ │ Web Server│ │ Web Server│
│  (Laravel)  │ │ (Laravel) │ │ (Laravel) │
└──────┬──────┘ └───┬───────┘ └───┬───────┘
       │             │             │
       └─────────────┼─────────────┘
                     │
              ┌──────▼──────┐
              │   Redis     │
              │  Cluster    │
              └──────┬──────┘
                     │
              ┌──────▼──────┐
              │   MySQL     │
              │  Primary    │
              └──────┬──────┘
                     │
              ┌──────▼──────┐
              │   MySQL     │
              │  Read       │
              │  Replicas   │
              └─────────────┘
```

### 9.2 CI/CD Pipeline

```yaml
GitHub Actions Workflow:
  1. Checkout code
  2. Setup PHP 8.2+
  3. Install dependencies (Composer)
  4. Run static analysis (PHPStan)
  5. Run code formatter (Pint)
  6. Run tests (Pest)
  7. Build assets (Vite)
  8. Deploy (if main branch)
```

---

## 10. Monitoring & Observability

### 10.1 Monitoring Stack

- **Application**: Laravel Pulse
- **Logs**: Laravel Log + Slack webhooks
- **Errors**: Sentry/Bugsnag (optional)
- **Performance**: Telescope (dev), Pulse (prod)
- **Uptime**: Uptime Kuma / Pingdom

### 10.2 Key Metrics

| Metric | Target | Tool |
|--------|--------|------|
| TTFB | < 200ms | Pulse |
| API p95 | < 100ms | Pulse |
| Error Rate | < 0.1% | Sentry |
| Uptime | > 99.9% | Uptime Kuma |
| Queue Lag | < 1min | Pulse |

---

## 11. Technical Debt & Improvements

### 11.1 Current Debt (from concerns-and-debt.md)

| Priority | Issue | Impact | Effort |
|----------|-------|--------|--------|
| 🔴 Critical | Migration deduplication | High | Medium |
| 🔴 Critical | N+1 query performance | High | Low |
| 🔴 Critical | API documentation missing | Medium | Medium |
| 🟡 High | Documentation organization | Medium | High |
| 🟡 High | Test coverage gaps | High | Medium |

### 11.2 Improvement Roadmap

**Phase 1 (Immediate - 2 weeks):**
- Fix migration duplicates
- Add API documentation (OpenAPI)
- Implement backup strategy
- Fix N+1 queries

**Phase 2 (Short-term - 1 month):**
- Consolidate documentation
- Implement rate limiting
- Add browser testing
- Improve monitoring

**Phase 3 (Medium-term - 3 months):**
- Performance optimization
- Test coverage to 85%
- Security audit
- CDN integration

---

## 12. Decision Log

| Date | Decision | Rationale | Status |
|------|----------|-----------|--------|
| 2026-04-01 | Modular Monolith | Balance between modularity and complexity | ✅ Approved |
| 2026-04-01 | Actions-over-Services | Better testability, queueable by default | ✅ Approved |
| 2026-04-01 | XotBase wrappers | Consistency, DRY, framework extensions | ✅ Approved |
| 2026-04-01 | Volt + Folio | File-based routing, single-file components | ✅ Approved |
| 2026-04-01 | PHPStan Level 10 | Type safety, early error detection | ✅ Approved |
| 2026-04-01 | Pest PHP | Modern testing, better DX | ✅ Approved |

---

## Appendix A: Glossary

| Term | Definition |
|------|------------|
| **Laraxot** | Base framework per moduli Laravel |
| **XotBase** | Classe base per modelli, resource, provider |
| **QueueableAction** | Pattern Spatie per azioni invocabili e queueable |
| **Volt** | Single-file Livewire components |
| **Folio** | File-based routing per Laravel |
| **Flux UI** | Componenti UI per Livewire |

---

## Appendix B: References

- [PRD Document](_bmad-output/prd.md)
- [Architecture Analysis](_bmad-output/codebase/architecture-analysis.md)
- [Technology Stack](_bmad-output/codebase/technology-stack.md)
- [Quality Assessment](_bmad-output/codebase/quality-assessment.md)
- [Concerns and Debt](_bmad-output/codebase/concerns-and-debt.md)
- [Project Research](.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md)

---

**Document Status:** ✅ Complete

**Next Steps:**
1. ✅ Architecture document created
2. 🔄 UX Design specifications (next)
3. ⏳ Epics and stories breakdown
4. ⏳ Sprint planning
