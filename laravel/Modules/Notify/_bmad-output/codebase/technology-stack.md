# FixCity Fila5 - Technology Stack

**Analysis Date:** 2026-04-01  
**Project Root:** `/var/www/_bases/base_fixcity_fila5/laravel`

---

## Executive Summary

FixCity Fila5 is built on a **modern Laravel 12 stack** with **Filament v5** for admin interfaces, **Livewire v4** for reactive components, and **Tailwind CSS v4** for styling. The platform uses a **modular architecture** powered by **nwidart/laravel-modules** with **21 active modules**.

**Runtime:** PHP 8.2+  
**Framework:** Laravel 12.0  
**Admin Panel:** Filament v5.0  
**Database:** SQLite (dev) / MySQL/PostgreSQL (prod)  
**Frontend:** Livewire v4 + Flux UI v2 + Tailwind CSS v4

---

## 1. Languages

### Primary
- **PHP 8.2+** - Backend development
  - Required version: `^8.2` (from composer.json)
  - Features used: Typed properties, enums, readonly classes, match expressions
  - All code uses strict typing: `declare(strict_types=1);`

### Secondary
- **JavaScript ES2022** - Frontend interactivity
- **TypeScript 5.x** - Type-safe JavaScript (optional)
- **Blade** - Laravel templating engine
- **SQL** - Database queries (MySQL/PostgreSQL/SQLite)

---

## 2. Runtime

### Environment
- **PHP Runtime:** Zend Engine v4.2+
- **Web Server:** Apache/Nginx (production), PHP built-in server (development)
- **Laravel Version:** 12.0.x

### Package Manager
- **Composer:** v2.7+ (PHP dependencies)
  - Lockfile: `composer.lock` (present)
  - Autoload: PSR-4
- **npm:** v10+ (JavaScript dependencies)
  - Lockfile: `package-lock.json` (present)
  - Bundler: Vite v5.x

---

## 3. Frameworks

### Core Framework

| Framework | Version | Purpose | Location |
|-----------|---------|---------|----------|
| **Laravel** | v12.0 | Application framework | `vendor/laravel/framework` |
| **Filament** | v5.0 | Admin panel framework | `vendor/filament/filament` |
| **Livewire** | v4.x | Full-stack reactive components | `vendor/livewire/livewire` |
| **nwidart/laravel-modules** | v12.0 | Modular architecture | `vendor/nwidart/laravel-modules` |

### Frontend Frameworks

| Framework | Version | Purpose | Location |
|-----------|---------|---------|----------|
| **Flux UI** | v2.1.1 | Livewire component library | `vendor/livewire/flux` |
| **Volt** | v1.x | Single-file Livewire components | `vendor/livewire/volt` |
| **Tailwind CSS** | v4.x | Utility-first CSS framework | `vendor/tailwindcss/tailwindcss` |
| **Alpine.js** | v3.x | Lightweight JavaScript framework | `vendor/alpinejs` |

### Testing Frameworks

| Framework | Version | Purpose | Location |
|-----------|---------|---------|----------|
| **Pest PHP** | v4.x | Testing framework | `vendor/pestphp/pest` |
| **PHPUnit** | v12.x | Unit testing (underlying) | `vendor/phpunit/phpunit` |
| **Testbench** | v9.x | Package testing | `vendor/orchestra/testbench` |
| **Mockery** | v1.6 | Mocking framework | `vendor/mockery/mockery` |

### Build & Development Tools

| Tool | Version | Purpose | Location |
|------|---------|---------|----------|
| **Vite** | v5.x | Frontend bundler | `vendor/vitejs/vite` |
| **Laravel Pint** | v1.25 | Code formatter | `vendor/laravel/pint` |
| **PHPStan** | v2.1 | Static analysis | `vendor/phpstan/phpstan` |
| **Larastan** | v3.7 | Laravel-specific PHPStan rules | `vendor/larastan/larastan` |
| **PHPMD** | v2.15 | Mess detection | Via PHAR |
| **Biome** | v2.2.4 | JavaScript/TypeScript linter | `node_modules/@biomejs/biome` |
| **ESLint** | v9.36 | JavaScript linting | `node_modules/eslint` |
| **Prettier** | v3.x | Code formatting | Via Biome |

---

## 4. Key Dependencies

### Critical Packages

| Package | Version | Why It Matters |
|---------|---------|----------------|
| **spatie/laravel-permission** | v5.x | Role-based access control (RBAC) |
| **spatie/laravel-medialibrary** | v10.x | File/media management |
| **spatie/laravel-model-states** | v2.7 | State machine for models |
| **spatie/laravel-queueable-action** | v2.16 | Queueable business logic |
| **spatie/laravel-data** | v4.7 | DTOs and validation |
| **spatie/laravel-tags** | v2.x | Tagging system |
| **laravel/passport** | v13.x | OAuth2 server |
| **laravel/sanctum** | v3.x | API token authentication |
| **laravel/socialite** | v5.x | Social authentication |
| **maatwebsite/excel** | v3.1 | Excel import/export |

### Infrastructure Packages

| Package | Version | Purpose |
|---------|---------|---------|
| **predis/predis** | v2.x | Redis client |
| **doctrine/dbal** | v3.x | Database abstraction layer |
| **guzzlehttp/guzzle** | v7.x | HTTP client |
| **symfony/dom-crawler** | v6.x | HTML parsing |
| **spatie/laravel-health** | v1.29 | Health checks |
| **spatie/laravel-responsecache** | v7.6 | Response caching |
| **staudenmeir/eloquent-has-many-deep** | v1.x | Deep relationships |
| **staudenmeir/laravel-adjacency-list** | v1.22 | Tree structures |

### Developer Experience Packages

| Package | Version | Purpose |
|---------|---------|---------|
| **barryvdh/laravel-ide-helper** | v3.2 | IDE autocompletion |
| **barryvdh/laravel-debugbar** | v3.14 | Debug toolbar |
| **fakerphp/faker** | v1.24 | Fake data generation |
| **nunomaduro/collision** | v8.6 | CLI error handling |
| **nunomaduro/phpinsights** | v2.x | Code quality metrics |
| **thecodingmachine/safe** | v3.x | Safe PHP functions |
| **thecodingmachine/phpstan-safe-rule** | v1.x | PHPStan rules for safe functions |
| **webmozart/assert** | v1.x | Assertion library |

---

## 5. Configuration

### Environment Configuration

**Required Environment Variables:**

```env
# Application
APP_NAME=FixCity
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false
APP_URL=http://localhost
APP_TIMEZONE=Europe/Berlin
APP_LOCALE=it
APP_FALLBACK_LOCALE=en

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fixcity
DB_USERNAME=root
DB_PASSWORD=secret

# Redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@fixcity.com
MAIL_FROM_NAME="${APP_NAME}"

# Queue
QUEUE_CONNECTION=redis

# Session
SESSION_DRIVER=redis
SESSION_LIFETIME=120
SESSION_ENCRYPT=true

# Cache
CACHE_DRIVER=redis
CACHE_PREFIX=fixcity

# Broadcasting
BROADCAST_DRIVER=log
BROADCASTER_KEY=base64:...

# Filesystem
FILESYSTEM_DISK=public
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# OAuth (Passport)
PASSPORT_ENCRYPTION_KEY=base64:...

# Multi-tenancy
TENANT_DATABASE_PREFIX=tenant_

# Feature Flags
PENNANT_DRIVER=database

# Monitoring
PULSE_ENABLED=true
PULSE_INGEST_ENABLED=true

# Debugging
IGNITION_ENABLED=false
TELESCOPE_ENABLED=false
```

### Build Configuration

**Vite Configuration:**
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

**Tailwind Configuration:**
```javascript
// tailwind.config.js
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './Themes/**/resources/**/*.blade.php',
        './Modules/**/resources/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                'italia-blue': { /* ... */ },
                'italia-green': { /* ... */ },
                'italia-red': { /* ... */ },
                'italia-yellow': { /* ... */ },
            },
            fontFamily: {
                sans: ['Titillium Web', 'Inter', 'system-ui'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
```

**PHPStan Configuration:**
```neon
# phpstan.neon
includes:
    - ./vendor/larastan/larastan/extension.neon
    - ./vendor/nesbot/carbon/extension.neon
    - ./vendor/phpstan/phpstan/conf/bleedingEdge.neon
    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon
    - ./vendor/pestphp/pest/extension.neon

parameters:
    level: max
    paths:
        - ./Modules/
        - ./Themes/
    excludePaths:
        - ./*/vendor/*
        - ./*/docs/*
        - ./*/tests/*
```

---

## 6. Platform Requirements

### Development

**Minimum Requirements:**
- PHP 8.2+
- Composer 2.7+
- Node.js 20+
- npm 10+
- SQLite 3.x (default)
- Git 2.40+

**Recommended:**
- PHP 8.3
- MySQL 8.0 or PostgreSQL 15
- Redis 7.x
- Docker (optional, via Laravel Sail)
- 4GB RAM minimum

**Development Tools:**
- Laravel Sail (Docker)
- Laravel Herd (macOS/Windows)
- Valet (macOS)
- Xdebug 3.x (debugging)
- PHPStorm / VS Code (IDE)

### Production

**Server Requirements:**
- PHP 8.2+ with extensions:
  - bcmath
  - ctype
  - curl
  - dom
  - fileinfo
  - gd
  - intl
  - json
  - mbstring
  - openssl
  - pdo
  - pdo_mysql (or pdo_pgsql)
  - tokenizer
  - xml
  - zip
- Web server: Nginx 1.24+ or Apache 2.4+
- Database: MySQL 8.0+ or PostgreSQL 15+
- Redis 7.x (recommended)
- 2GB RAM minimum (4GB+ recommended)
- 10GB storage minimum

**Deployment Target:**
- **Hosting:** Traditional VPS, Cloud (AWS, DigitalOcean, Hetzner)
- **CI/CD:** GitHub Actions
- **Container:** Docker (optional)
- **Process Manager:** Supervisor (queues)

---

## 7. Database Systems

### Supported Databases

| Database | Version | Usage |
|----------|---------|-------|
| **SQLite** | 3.x | Development, testing |
| **MySQL** | 8.0+ | Production (primary) |
| **PostgreSQL** | 15+ | Production (alternative) |
| **MariaDB** | 10.6+ | Production (alternative) |

### ORM

**Laravel Eloquent ORM:**
- Active Record pattern
- Relationships: hasOne, hasMany, belongsTo, belongsToMany, morphTo, morphMany
- Query Builder: Fluent interface
- Migrations: Version control for schema
- Factories: Model generation for testing
- Seeders: Database seeding

### Database Packages

| Package | Purpose |
|---------|---------|
| **doctrine/dbal** | Schema introspection |
| **staudenmeir/eloquent-has-many-deep** | Deep relationships |
| **staudenmeir/laravel-adjacency-list** | Tree structures |
| **spatie/laravel-schemaless-attributes** | JSON attributes |

---

## 8. Caching Systems

### Supported Cache Drivers

| Driver | Usage |
|--------|-------|
| **File** | Development (default) |
| **Redis** | Production (recommended) |
| **Database** | Fallback |
| **Memcached** | Alternative |
| **DynamoDB** | AWS deployments |

### Cache Configuration

```php
// config/cache.php
'default' => env('CACHE_DRIVER', 'redis'),

'stores' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
    ],
],
```

---

## 9. Queue Systems

### Supported Queue Drivers

| Driver | Usage |
|--------|-------|
| **Sync** | Development (default) |
| **Database** | Simple deployments |
| **Redis** | Production (recommended) |
| **SQS** | AWS deployments |
| **Beanstalkd** | Alternative |

### Queue Configuration

```php
// config/queue.php
'default' => env('QUEUE_CONNECTION', 'redis'),

'connections' => [
    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => env('REDIS_QUEUE', 'default'),
        'retry_after' => 90,
        'block_for' => null,
    ],
],
```

---

## 10. Authentication Systems

### Authentication Guards

| Guard | Driver | Provider | Usage |
|-------|--------|----------|-------|
| **web** | session | eloquent | Web sessions |
| **sanctum** | sanctum | eloquent | API tokens |
| **passport** | passport | eloquent | OAuth2 |

### OAuth Providers

| Provider | Package | Status |
|----------|---------|--------|
| **Google** | Laravel Socialite | Configured |
| **Facebook** | Laravel Socialite | Configured |
| **GitHub** | Laravel Socialite | Configured |
| **Microsoft** | Laravel Socialite | Available |

---

## 11. File Storage

### Storage Disks

| Disk | Driver | Usage |
|------|--------|-------|
| **local** | Local filesystem | Development |
| **public** | Local filesystem | Public assets |
| **s3** | Amazon S3 | Production (optional) |
| **ftp** | FTP | Legacy systems |

### Media Library

**Spatie MediaLibrary v10:**
- File uploads with conversions
- Responsive images
- S3 compatible
- Custom filename generators
- File validation

---

## 12. Monitoring & Observability

### Application Monitoring

| Tool | Purpose | Status |
|------|---------|--------|
| **Laravel Pulse** | Real-time monitoring | Enabled |
| **Spatie Health** | Health checks | Enabled |
| **Laravel Debugbar** | Debug toolbar | Dev only |
| **Sentry** | Error tracking | Available (commented) |
| **Clockwork** | Debugging tool | Available |

### Logging

**Channels:**
- `stack` - Aggregate channel
- `single` - Single file logging
- `daily` - Daily rotating logs
- `slack` - Slack notifications
- `papertrail` - Papertrail integration
- `stderr` - Standard error
- `syslog` - System log
- `errorlog` - PHP error log

**Log levels:**
- `debug`, `info`, `notice`, `warning`, `error`, `critical`, `alert`, `emergency`

---

## 13. API & Integration

### API Protocols

| Protocol | Usage |
|----------|-------|
| **REST** | Primary API style |
| **GraphQL** | Available (not configured) |
| **SOAP** | Not supported |
| **gRPC** | Not supported |

### API Authentication

| Method | Package | Usage |
|--------|---------|-------|
| **Sanctum Tokens** | laravel/sanctum | Simple API auth |
| **Passport OAuth2** | laravel/passport | Full OAuth2 server |
| **JWT** | Custom | Not configured |

### Webhooks

**Incoming:**
- GitHub webhooks (CI/CD)
- Payment webhooks (Stripe - not configured)

**Outgoing:**
- Ticket notifications
- User events

---

## 14. CI/CD & Deployment

### Continuous Integration

| Tool | Usage |
|------|-------|
| **GitHub Actions** | Primary CI/CD |
| **GitLab CI** | Not configured |
| **CircleCI** | Not configured |
| **Travis CI** | Not configured |

### Deployment

| Method | Usage |
|--------|-------|
| **Manual** | SSH + Git |
| **Envoyer** | Not configured |
| **Forge** | Not configured |
| **Docker** | Available (Sail) |
| **Kubernetes** | Not configured |

### GitHub Actions Workflows

**Workflows identified:**
- `sync-remote-repo.yml` - Subtree sync (daily 2 AM)
- `semantic-versioning.yml` - Auto-tagging
- `changelog-automation.yml` - Changelog generation
- `build-provenance-attestation.yml` - SLSA compliance

---

## 15. Security Tools

### Security Packages

| Package | Purpose |
|---------|---------|
| **laravel/sanctum** | API authentication |
| **laravel/passport** | OAuth2 server |
| **spatie/laravel-permission** | RBAC |
| **laravel/socialite** | OAuth social login |
| **spatie/laravel-csp** | Content Security Policy (available) |
| **spatie/laravel-honeypot** | Spam protection (available) |

### Security Features

- **CSRF Protection:** Enabled on web routes
- **XSS Protection:** Blade auto-escaping
- **SQL Injection:** Eloquent ORM (parameterized)
- **Password Hashing:** bcrypt (12 rounds)
- **Rate Limiting:** Laravel rate limiter
- **CORS:** Configured in `config/cors.php`

---

## 16. Feature Flags

### Laravel Pennant

**Configuration:**
```php
// config/pennant.php
'default' => env('PENNANT_DRIVER', 'database'),

'stores' => [
    'database' => [
        'driver' => 'database',
        'connection' => null,
        'table' => 'features',
    ],
],
```

**Usage:**
```php
// Feature flag checks
if (Features::active('new-ticket-flow')) {
    // New implementation
}

// Blade directive
@feature('new-ticket-flow')
    // New UI
@endfeature
```

---

## 17. Internationalization

### Translation System

**Package:** `mcamara/laravel-localization`

**Supported Languages:**
- Italian (it) - Primary
- English (en) - Fallback

**Translation Files:**
```
Modules/{Name}/lang/
├── en/
│   ├── module.php
│   ├── models.php
│   └── errors.php
└── it/
    ├── module.php
    ├── models.php
    └── errors.php
```

---

## 18. Build Commands

### Composer Scripts

```json
{
    "scripts": {
        "go": [
            "@php composer update -W",
            "@php artisan vendor:publish --all",
            "rm -rf database/migrations/*",
            "@php artisan migrate",
            "@php artisan optimize",
            "@php artisan filament:optimize"
        ],
        "analyse": "vendor/bin/phpstan analyse",
        "test": "vendor/bin/pest",
        "test-coverage": "vendor/bin/pest --coverage",
        "format": "vendor/bin/pint"
    }
}
```

### npm Scripts

```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "quality": "npm run quality:biome && npm run quality:eslint",
        "fix": "npm run fix:biome"
    }
}
```

### Artisan Commands

**Common commands:**
```bash
php artisan serve              # Start development server
php artisan migrate            # Run migrations
php artisan db:seed            # Run seeders
php artisan test               # Run tests
php artisan pint               # Format code
php artisan optimize           # Optimize for production
php artisan config:cache       # Cache configuration
php artisan route:cache        # Cache routes
php artisan view:cache         # Cache views
php artisan queue:work         # Process queue
php artisan pulse:check        # Check Pulse status
```

---

## 19. Version Compatibility Matrix

| Component | Version | PHP Required | Laravel Required |
|-----------|---------|--------------|------------------|
| Laravel | 12.x | 8.2+ | - |
| Filament | 5.x | 8.2+ | 11.x, 12.x |
| Livewire | 4.x | 8.1+ | 10.x, 11.x, 12.x |
| Flux UI | 2.x | 8.1+ | 10.x, 11.x, 12.x |
| Pest | 4.x | 8.1+ | - |
| PHPStan | 2.x | 7.4+ | - |
| Larastan | 3.x | 8.0+ | 10.x, 11.x, 12.x |

---

## 20. Package Statistics

### Total Packages

**Production dependencies:** 80+ packages  
**Development dependencies:** 30+ packages  
**Total npm packages:** 15+ packages

### Package Categories

| Category | Count |
|----------|-------|
| Laravel Ecosystem | 25 |
| Filament Plugins | 15 |
| Spatie Packages | 20 |
| Testing | 10 |
| Security | 8 |
| Media/Files | 5 |
| Database | 10 |
| Developer Tools | 15 |

---

## 21. External Services

### Third-Party Integrations

| Service | Purpose | Status |
|---------|---------|--------|
| **Google OAuth** | Social login | Configured |
| **Facebook OAuth** | Social login | Configured |
| **GitHub OAuth** | Social login | Configured |
| **Amazon S3** | File storage | Available |
| **Mailgun** | Email delivery | Available |
| **Stripe** | Payments | Not configured |
| **Sentry** | Error tracking | Available (commented) |

---

## 22. Technology Decisions

### Why Laravel 12?
- Latest LTS version
- Modern PHP 8.2+ features
- Improved performance
- Long-term support

### Why Filament v5?
- Rapid admin development
- Built on Livewire
- Excellent documentation
- Active community

### Why Modular Architecture?
- Clear domain boundaries
- Easier maintenance
- Team scalability
- Reusability

### Why Pest PHP?
- Cleaner syntax than PHPUnit
- Better error messages
- Built-in coverage
- Modern testing experience

---

*Technology stack analysis completed: 2026-04-01*
