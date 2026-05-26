# 🚀 Xot Module — The Laravel Modular Foundation

> **Enterprise-grade modular architecture for Laravel.** Xot provides the rock-solid base classes, traits, and patterns that power every module in this ecosystem.

[![Latest Release](https://img.shields.io/github/v/release/provtv/base_ptv_fila5_mono?style=flat-square)](https://github.com/provtv/base_ptv_fila5_mono/releases)
[![Build Status](https://img.shields.io/github/actions/workflow/status/provtv/base_ptv_fila5_mono/tests.yml?style=flat-square)](https://github.com/provtv/base_ptv_fila5_mono/actions)
[![License: MIT](https://img.shields.io/badge/license-MIT-green.svg?style=flat-square)](LICENSE.md)

---

## What is Xot?

**Xot** is the **architectural backbone** of a modular Laravel monorepo:

- ✅ **Base Classes** for Models, Resources, Services, and Filament components
- ✅ **Reusable Traits** for common patterns (timestamps, slugs, polymorphic relations)
- ✅ **Filament Integration** with battle-tested Resource and Table builders
- ✅ **Service Layer** patterns with Command handlers and event-driven architecture
- ✅ **Database Migrations** framework for consistent schema evolution

Think of Xot as your **modular contract**. Every module that extends it speaks the same language.

---

## 🎯 Key Features

### 1. **XotBaseModel** — Smart Model Foundation
```php
class Post extends XotBaseModel {
    // Automatic: HasFactory, HasUuids, SoftDeletes, Auditable
}
```

### 2. **Filament Resources** — Zero-Config CRUD
```php
class PostResource extends XotBaseResource {
    protected static ?string $model = Post::class;
    // Tables, Forms, Relations auto-configured
}
```

### 3. **Service Architecture** — Command Pattern
```php
class PublishPostService {
    public function __invoke(PublishPostCommand $cmd): Post {
        // Validated, event-driven, auditable
    }
}
```

---

## 📚 Documentation

| Document | Purpose |
|----------|---------|
| **[Filament Patterns](./docs/filament/)** | Resource, Table, Form builders |
| **[Bug Fixes & Issues](./docs/filament/xot-base-resource-table-fix.md)** | Recent fixes and learnings |
| **[Redundancy Analysis](./docs/filament/table-patterns-redundancy-analysis.md)** | Code quality improvements |

---

## 🛠️ Quick Start

```bash
composer require provtv/base_ptv_fila5_mono
php artisan migrate
php artisan module:make MyFeature
```

---

## 🏗️ Architecture

```
Modules/Xot/
├── app/Models/              (Base classes, Traits)
├── app/Filament/            (Resources, Tables, Forms)
├── app/Services/            (Commands, Handlers)
└── docs/                    (Guides, fixes, patterns)
```

---

## 🚨 Recent Fixes

| Issue | Status | Link |
|-------|--------|------|
| Static method context in Filament Tables | ✅ Fixed | [Read](./docs/filament/xot-base-resource-table-fix.md) |
| Column definition redundancy | 🔍 Analysis | [Details](./docs/filament/table-patterns-redundancy-analysis.md) |

---

**Made with ❤️ by ProvTV Development Team**
