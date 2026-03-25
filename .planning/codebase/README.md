# PTVX Codebase Documentation

> **Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
> **Documentation Version**: 1.0  
> **Created**: 2026-03-18

---

## Overview

This directory contains comprehensive codebase documentation for the PTVX Fila5 Mono project - a modular enterprise HR & Performance evaluation system for Italian Public Administrations.

**Stack**: Laravel 12.47 | Filament v5 | Pest v4 | PHPStan Level 10 | PHP 8.3+

---

## Documentation Files

### 1. [ARCHITECTURE.md](./ARCHITECTURE.md) - System Architecture

**High-level system architecture and design patterns**

- System overview and context
- Architectural principles (Modular Monolith, XotBase wrappers, Actions-over-Services)
- Modular structure and organization
- Core components (Xot, User, Tenant modules)
- Module dependencies and relationships
- Data flow patterns
- Integration patterns

**Key Sections**:
- High-Level Architecture Diagram
- XotBase Wrappers Pattern
- Actions-over-Services Migration
- Module Dependency Graph
- Typical Request Flow

**File**: `/var/www/_bases/base_ptvx_fila5/.planning/codebase/ARCHITECTURE.md`  
**Lines**: 659

---

### 2. [STACK.md](./STACK.md) - Technology Stack

**Complete technology stack inventory with versions and usage**

- Core Framework (Laravel 12.47)
- Admin Panel & UI (Filament v5, Livewire, Flux UI)
- Database & Storage (MySQL/PostgreSQL, Redis, Media Library)
- Testing & Quality (Pest v4, PHPStan Level 10, Pint)
- Build & Development (Vite, npm, Laravel Boost)
- Security & Authentication (Passport, Socialite, Spatie Permission)
- Monitoring & Performance (Pulse, Health checks)
- Integration & APIs (Spatie Data, Queueable Actions)
- Domain-Specific Packages (Excel, PDF, Model States)

**Key Sections**:
- Package Version Table
- Configuration Examples
- Usage Patterns
- Quality Gates

**File**: `/var/www/_bases/base_ptvx_fila5/.planning/codebase/STACK.md`  
**Lines**: 977

---

### 3. [MODULES.md](./MODULES.md) - Module Catalog

**Complete catalog of all 42+ modules with descriptions and dependencies**

**Module Categories**:
- **Core Infrastructure** (5 modules): Xot, User, Tenant, Setting, Lang
- **Domain Modules** (13 modules): Performance, Ptv, Incentivi, Progressioni, etc.
- **Compliance & Legal** (8 modules): Gdpr, Legge104, Legge109, Inail, etc.
- **Integration Modules** (3 modules): Pdnd, Sigma, Europa
- **Utility Modules** (6 modules): Activity, Media, Notify, UI, Seo, DbForge

**Key Sections**:
- Quick Reference Table
- Module Descriptions
- Dependencies Map
- Module Status Dashboard
- Module Creation Checklist

**File**: `/var/www/_bases/base_ptvx_fila5/.planning/codebase/MODULES.md`  
**Lines**: 998

---

### 4. [DOMAIN.md](./DOMAIN.md) - Business Domain Overview

**Italian Public Administration HR management domain knowledge**

- Domain context and regulatory framework
- Core business capabilities
- HR management (employee lifecycle, organizational structure)
- Performance evaluation workflows (D.Lgs. 150/2009 compliance)
- Indemnity & bonus calculation formulas
- Career progression tracking
- Compliance requirements (GDPR, Law 104, INAIL)
- Italian public administration organizational structure
- Key business processes
- Domain terminology (Italian/English)

**Key Sections**:
- Performance Evaluation Cycle
- Indemnity Calculation Formulas
- Career Progression Workflows
- Compliance Matrix
- Business Process Diagrams
- Domain Glossary

**File**: `/var/www/_bases/base_ptvx_fila5/.planning/codebase/DOMAIN.md`  
**Lines**: 770

---

## Documentation Quality Gates

All documentation files meet these standards:

- ✅ **Comprehensive Coverage**: All 42 modules documented
- ✅ **Specific Details**: Exact package versions, file paths, code examples
- ✅ **Clear Structure**: Table of contents, hierarchical organization
- ✅ **Cross-References**: Links between related documents
- ✅ **Visual Aids**: Architecture diagrams, flow charts, tables
- ✅ **Domain Accuracy**: Italian HR terminology, regulatory references
- ✅ **Actionable**: Checklists, workflows, configuration examples

---

## How to Use This Documentation

### For New Developers

1. Start with **[ARCHITECTURE.md](./ARCHITECTURE.md)** - Understand system structure
2. Read **[STACK.md](./STACK.md)** - Learn the technology stack
3. Review **[MODULES.md](./MODULES.md)** - Explore available modules
4. Study **[DOMAIN.md](./DOMAIN.md)** - Understand business context

### For Architects

- **[ARCHITECTURE.md](./ARCHITECTURE.md)** - Design patterns and principles
- **[MODULES.md](./MODULES.md)** - Module dependencies and relationships
- **[STACK.md](./STACK.md)** - Technology decisions and rationale

### For Developers

- **[STACK.md](./STACK.md)** - Package usage and configuration
- **[MODULES.md](./MODULES.md)** - Module-specific information
- **[ARCHITECTURE.md](./ARCHITECTURE.md)** - Integration patterns

### For Business Stakeholders

- **[DOMAIN.md](./DOMAIN.md)** - Business capabilities and processes
- **[MODULES.md](./MODULES.md)** - Feature overview

---

## Documentation Maintenance

### Update Triggers

Update this documentation when:

- New modules are added
- Major architectural changes occur
- Technology stack is updated
- Business processes change
- New regulations require compliance updates

### Update Process

1. **Identify affected documents** - Which files need updates?
2. **Make changes** - Update content with specific details
3. **Cross-reference** - Update links and references
4. **Version note** - Add update date and description
5. **Commit** - Follow commit & push rule

### Quality Checks

Before committing documentation updates:

- [ ] All file paths are absolute and correct
- [ ] All package versions are accurate
- [ ] All cross-references work
- [ ] No temporal strings in filenames (dates in body only)
- [ ] Italian terminology is accurate
- [ ] Code examples follow project patterns

---

## Related Documentation

### Project-Level Documentation

- **QWEN.md** - Project context & development guide
- **AGENTS.md** - Development guide index
- **docs/** - Extended documentation library

### Module Documentation

Each module has its own documentation:
- `laravel/Modules/{Module}/docs/` - Module-specific docs
- `laravel/Modules/Xot/docs/` - Core module conventions

### External Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide)
- [Pest Documentation](https://pestphp.com/docs)

---

## File Locations

```
/var/www/_bases/base_ptvx_fila5/
└── .planning/
    └── codebase/
        ├── README.md              # This file (index)
        ├── ARCHITECTURE.md        # System architecture
        ├── STACK.md               # Technology stack
        ├── MODULES.md             # Module catalog
        └── DOMAIN.md              # Business domain
```

---

## Statistics

| Metric | Value |
|--------|-------|
| **Total Documentation Files** | 5 |
| **Total Lines** | 3,404 |
| **Modules Documented** | 42 |
| **Packages Documented** | 60+ |
| **Business Processes** | 4 major |
| **Domain Terms** | 30+ |

---

## Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | 2026-03-18 | Initial comprehensive documentation |

---

## Feedback & Contributions

This documentation is maintained by the development team. For:

- **Corrections**: Submit via GitHub issue or PR
- **Additions**: Create new section or file
- **Questions**: Check related module documentation
- **Updates**: Follow documentation maintenance process

---

*Created: 2026-03-18*  
*Last Updated: 2026-03-18*
