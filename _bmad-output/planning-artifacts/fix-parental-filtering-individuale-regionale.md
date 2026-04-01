---
title: 'Fix Parental STI Filtering for IndividualeRegionale'
slug: 'fix-parental-filtering-individuale-regionale'
created: '2026-04-01'
status: 'shipped'
stepsCompleted: ['research', 'fix', 'verification']
tech_stack: ['Laravel', 'Filament', 'Parental']
files_to_modify: ['laravel/Modules/Ptv/app/Filament/Resources/BaseSchedaResource.php', 'laravel/Modules/Performance/app/Models/IndividualeRegionale.php']
code_patterns: ['Parental STI', 'Global Scopes']
test_patterns: []
---

# Tech-Spec: Fix Parental STI Filtering for IndividualeRegionale

**Created:** 2026-04-01

## Overview

### Problem Statement

The `IndividualeRegionaleResource` displays all records from the `performance_individuale` table instead of filtering only for `type='regionale'`. This was due to:
1. `BaseSchedaResource::getModel()` hardcoded `Individuale::class`, bypassing the child model's Parental configuration.

### Solution

1. Modified `BaseSchedaResource::getModel()` to correctly return `parent::getModel()`, which respects `static::$model`.
2. Verified that `IndividualeRegionale` model already has the `boot()` method with global scope.

### Scope

**In Scope:**
- `BaseSchedaResource.php`: Fix `getModel()` method.
- `IndividualeRegionale.php`: Verified `boot()` method with global scope.

**Out of Scope:**
- Modifying other Scheda resources.

## Context for Development

### Codebase Patterns

- **Parental STI**: Child models use `HasParent` and a global scope in `boot()`.
- **Resource Inheritance**: Scheda resources extend `BaseSchedaResource` which extends `XotBaseResource`.

### Files to Reference

| File | Purpose |
| ---- | ------- |
| `laravel/Modules/Ptv/app/Filament/Resources/BaseSchedaResource.php` | Base resource class causing model override. |
| `laravel/Modules/Performance/app/Models/IndividualeRegionale.php` | Child model with filtering scope. |

### Technical Decisions

- **Respect static::$model**: `BaseSchedaResource` now correctly uses `parent::getModel()`.

## Implementation Plan

### Tasks

1. [x] Remove hardcoded `Individuale::class` from `BaseSchedaResource::getModel()`.
2. [x] Add boot() method to IndividualeRegionale (already present).
3. [x] Verify filtering in IndividualeRegionaleResource index page.

### Acceptance Criteria

- `IndividualeRegionaleResource` index page only shows records where `type='regionale'`.
- `IndividualeRegionale::query()->toSql()` contains `where type = 'regionale'`.

## Additional Context

### Dependencies

- `tighten/parental` package.

### Testing Strategy

- CLI: Verified SQL query filtering.
- Resource: Verified correct model resolution.
