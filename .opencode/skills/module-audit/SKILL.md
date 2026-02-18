---
name: module-audit
description: Perform a comprehensive audit of a Laravel module for compliance with all Laraxot rules. Checks XotBase usage, translations, PHPStan, actions vs services, code quality, and documentation completeness.
---

# Module Audit - Comprehensive Compliance Check

Audit a module against all Laraxot/PTVX coding standards and rules.

## When to Use

- Before considering a module "complete"
- When reviewing a module for quality
- When the user asks to "check", "audit", or "verify" a module
- After significant changes to a module

## Audit Checklist

### 1. XotBase Compliance (CRITICAL)

Search for direct Filament class extensions:

```bash
cd laravel
# Find violations
grep -rn "extends.*Filament\\\\Resources\\\\Resource[^s]" Modules/{Module}/
grep -rn "extends.*Filament\\\\Resources\\\\Pages" Modules/{Module}/
grep -rn "extends.*Filament\\\\Pages\\\\Page" Modules/{Module}/
grep -rn "extends.*Filament\\\\Widgets" Modules/{Module}/
grep -rn "extends.*RelationManager[^s]" Modules/{Module}/ | grep -v XotBase
```

All must extend XotBase* classes instead.

### 2. Translation Violations (CRITICAL)

Search for hardcoded labels:

```bash
cd laravel
grep -rn "->label(" Modules/{Module}/app/Filament/
grep -rn "->placeholder(" Modules/{Module}/app/Filament/
grep -rn "->helperText(" Modules/{Module}/app/Filament/
grep -rn "->tooltip(" Modules/{Module}/app/Filament/
grep -rn "->modalHeading(" Modules/{Module}/app/Filament/
```

None should have hardcoded string arguments.

### 3. Services Check (CRITICAL)

```bash
# Services are FORBIDDEN - should not exist
ls laravel/Modules/{Module}/app/Services/ 2>/dev/null
```

All business logic must use Actions with `QueueableAction` trait.

### 4. PHPStan Level 10

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/{Module} --memory-limit=-1
```

Must report 0 errors.

### 5. property_exists() Check

```bash
cd laravel
grep -rn "property_exists" Modules/{Module}/
```

Must NOT be used on Eloquent models.

### 6. Array Syntax

```bash
cd laravel
grep -rn "array(" Modules/{Module}/app/
```

Must use short syntax `[]` only.

### 7. Model Casts

```bash
cd laravel
grep -rn "protected \$casts" Modules/{Module}/
```

Must use `protected function casts(): array` method instead.

### 8. Code Formatting

```bash
cd laravel && vendor/bin/pint --test Modules/{Module}/
```

### 9. Documentation Check

Verify these files exist:
- `Modules/{Module}/docs/00-index.md` or `docs/README.md`
- `Modules/{Module}/docs/roadmap.md`
- Module `module.json` is properly configured

### 10. Tests Existence

```bash
ls laravel/Modules/{Module}/tests/
```

Must have test files covering business logic.

## Output Format

Produce a report with:
- Module name and version
- PASS/FAIL for each check
- List of specific violations found
- Suggested fixes for each violation
- Overall compliance score

## After Audit

1. Update `docs/roadmap.md` with findings
2. Create action items for each violation
3. Fix violations one-by-one following Laraxot patterns
