---
name: pint-format
description: Run Laravel Pint code formatter to ensure PSR-12 compliance. Use after any code modification to maintain consistent formatting across the codebase.
disable-model-invocation: true
---

# Pint Format - Code Style Enforcement

Run Laravel Pint to enforce PSR-12 coding standards.

## When to Use

- After modifying any PHP file
- Before committing changes
- When code formatting is inconsistent
- When the user asks to "format code" or "run pint"

## Commands

### Format Changed Files Only (Preferred)
```bash
cd laravel && vendor/bin/pint --dirty
```

### Format Specific Module
```bash
cd laravel && vendor/bin/pint Modules/{Module}/
```

### Format Specific File
```bash
cd laravel && vendor/bin/pint path/to/file.php
```

### Check Without Fixing (DO NOT use for pre-commit)
```bash
cd laravel && vendor/bin/pint --test Modules/{Module}/
```

## IMPORTANT

- **MUST** run `vendor/bin/pint --dirty` before finalizing any work
- **DO NOT** run `vendor/bin/pint --test` as a pre-commit check (it doesn't fix, only reports)
- Pint follows the project's `.php-cs-fixer.dist.php` configuration
- Always run AFTER PHPStan fixes, not before

## Order of Operations

1. Write/modify code
2. Run PHPStan and fix errors
3. Run `vendor/bin/pint --dirty` (format)
4. Run tests
5. Commit
