---
name: Laravel 13 Upgrade Analysis
description: Complete analysis of Laravel 13 migration with dependency conflict resolution
type: architecture
related:
  - ../../laravel/Modules/Xot/docs/wiki/index.md
  - ./index.md
---

# Laravel 13 Upgrade Analysis & Resolution Strategy

**Status**: In Progress  
**Date**: 2026-05-05  
**Goal**: Upgrade all Laravel 13 dependencies across root, all modules (37+), and all themes

---

## Executive Summary

The project uses **nWidart/laravel-modules** (modular monolith) where:
- Root `composer.json` is minimal and references framework packages
- Each of 37+ modules maintains its own `composer.json` 
- Each of 2 themes maintains its own `composer.json`

**Laravel 13 Upgrade Blockers** identified via `composer require -W laravel/framework:^13`:

| # | Blocker | Status | Resolution |
|---|---------|--------|-----------|
| 1 | PHP 8.3.30 < 8.4 required by Laravel 13 | ⚠️ Environment | Requires host PHP upgrade |
| 2 | barryvdh/laravel-debugbar no Laravel 13 support | ✅ RESOLVED | Use fruitcake/laravel-debugbar fork |
| 3 | Package replacement conflict (illuminate/support) | 🔧 Pending | Update module composer.json files |
| 4 | spatie/once conflicts with framework | 🔧 Pending | Verify compatibility or find alternative |

---

## Blocker Analysis

### Blocker #1: PHP Version (8.3.30 → 8.4 required)

**Error**: `laravel/framework v13.0.0 requires php ^8.4`  
**Current Environment**: PHP 8.3.30  
**Resolution**: Host/environment PHP upgrade (outside scope of this documentation)

**Status**: ⚠️ Blocking - requires PHP 8.4+ installation

---

### Blocker #2: barryvdh/laravel-debugbar Compatibility ✅ RESOLVED

**Original Error**: `barryvdh/laravel-debugbar ^3.14 doesn't support illuminate/support ^13`

**Root Cause**: Original barryvdh/laravel-debugbar package no longer maintained for Laravel 13+

**Solution Found**: The package has been forked and is now actively maintained at:
- **New Repository**: https://github.com/fruitcake/laravel-debugbar/
- **Package Name**: `fruitcake/laravel-debugbar`
- **Status**: Supports Laravel 13

**Action Items**:
1. Replace `barryvdh/laravel-debugbar` → `fruitcake/laravel-debugbar` in root composer.json
2. Update all module composer.json files that reference barryvdh/laravel-debugbar
3. Verify package version compatibility with Laravel 13 (check latest release)

**Implementation**:
```bash
# Remove old package
composer remove barryvdh/laravel-debugbar

# Add new package with Laravel 13 support
composer require -W fruitcake/laravel-debugbar:^4.0
```

---

### Blocker #3: Package Replacement Conflicts (illuminate/support)

**Error**: `laravel/framework v13 replaces illuminate/support`

**Root Cause**: Laravel 13 bundles illuminate/support package. Any explicit requirement of `illuminate/support` or packages requiring older versions creates conflicts.

**Resolution Strategy**:
1. Audit all module/theme composer.json files for explicit `illuminate/support` requirements
2. Remove explicit requirements (let laravel/framework provide it)
3. For third-party packages: verify they support Laravel 13, update versions as needed

**Files to Audit**:
- Root: `/var/www/_bases/base_ptvx_fila5/composer.json`
- Modules: `/var/www/_bases/base_ptvx_fila5/laravel/Modules/*/composer.json` (37+ files)
- Themes: `/var/www/_bases/base_ptvx_fila5/laravel/Themes/*/composer.json`

---

### Blocker #4: spatie/once Compatibility

**Error**: `spatie/once[3.1.0-3.1.2] conflicts with laravel/framework and illuminate/support`

**Root Cause**: spatie/once has explicit version constraints on illuminate packages

**Resolution Strategy**:
1. Check if newer version of spatie/once supports Laravel 13
2. If not, evaluate alternative libraries or vendor patches
3. Update constraint in composer.json files that require spatie/once

---

## Implementation Roadmap

### Phase 1: Environment Setup (Day 1)
- [ ] Verify PHP 8.4+ availability in environment
- [ ] Document environment requirements
- [ ] Create PHP upgrade plan (if needed)

### Phase 2: Dependency Resolution (Days 2-3)
- [ ] Update root composer.json:
  - Replace barryvdh/laravel-debugbar → fruitcake/laravel-debugbar
  - Require laravel/framework ^13
  - Verify all root dependencies support Laravel 13
- [ ] Audit all 37+ module composer.json files
  - Identify modules with explicit illuminate/* requirements
  - Identify modules with barryvdh/laravel-debugbar references
  - Identify modules with spatie/once requirements
- [ ] Create module-specific migration guides

### Phase 3: Per-Module Upgrades (Days 4-7)
- [ ] Update each module's composer.json for Laravel 13 compatibility
- [ ] Run `composer update` for each module
- [ ] Document migration notes in module docs/wiki/

### Phase 4: Per-Theme Upgrades (Day 8)
- [ ] Update theme composer.json files
- [ ] Verify theme asset compilation still works
- [ ] Document in theme docs/wiki/

### Phase 5: Verification & Documentation (Days 9-10)
- [ ] Run full integration tests
- [ ] Verify all modules load correctly
- [ ] Update docs/wiki/index.md with complete upgrade guide
- [ ] Append entry to docs/wiki/log.md

---

## Key Files to Modify

| File | Action | Impact |
|------|--------|--------|
| `/composer.json` | Update framework & debugbar | Root-level, all modules depend |
| `laravel/Modules/*/composer.json` | Update illuminate/*, remove barryvdh | Per-module, 37+ files |
| `laravel/Themes/*/composer.json` | Update illuminate/* | Per-theme, 2 files |
| `docs/wiki/laravel-13-upgrade.md` | Create detailed guide | Reference for entire team |
| `docs/wiki/log.md` | Append upgrade entry | Maintain audit trail |

---

## Documentation Structure

After analysis complete, create:

```
docs/wiki/
├── laravel-13-upgrade.md          # This file (analysis)
├── laravel-13-how-to.md           # Team guide for upgrade process
└── laravel-13-blocker-resolution/ # Detailed solutions per blocker
    ├── blocker-1-php-version.md
    ├── blocker-2-debugbar-resolution.md
    ├── blocker-3-package-replacement.md
    └── blocker-4-spatie-once.md

laravel/Modules/{Module}/docs/wiki/
├── laravel-13-migration.md        # Module-specific upgrade guide

laravel/Themes/{Theme}/docs/wiki/
├── laravel-13-migration.md        # Theme-specific upgrade guide
```

---

## Next Steps

1. ✅ **Blocker #2 Resolved**: Use fruitcake/laravel-debugbar instead
2. ⚠️ **Blocker #1**: Requires PHP 8.4 environment
3. 🔧 **Blocker #3 & #4**: Proceed with module audit phase

**Immediate Action**: Audit all module/theme composer.json files to identify packages requiring updates.

---

**Created**: 2026-05-05  
**Last Updated**: 2026-05-05
