---
name: git-commit
description: Perform safe git operations following the forward-only workflow. Use when committing changes, managing branches, or any git operation. NEVER reset, revert, or checkout old commits.
disable-model-invocation: true
---

# Git Commit - Forward-Only Workflow

Safe git operations following the INVIOLABLE forward-only rule.

## When to Use

- When committing code changes
- When managing branches
- When the user asks to "commit", "save changes", or "push"

## INVIOLABLE RULE: Forward-Only

**NEVER go backward in git history.**

### FORBIDDEN Commands
```bash
git checkout <old-commit>    # FORBIDDEN
git reset --hard             # FORBIDDEN
git revert                   # FORBIDDEN
git restore . --source=<old> # FORBIDDEN
git clean -f                 # FORBIDDEN unless explicitly requested
```

### EXCEPTION
Only allowed on local, unpushed branches for personal cleanup.

## Workflow

### 1. Check Status
```bash
cd /var/www/_bases/base_ptvx_fila5_mono
git status
git diff --stat
```

### 2. Stage Changes
```bash
# Stage specific files (preferred)
git add laravel/Modules/{Module}/path/to/file.php

# Stage module changes
git add laravel/Modules/{Module}/
```

### 3. Commit
```bash
git commit -m "$(cat <<'EOF'
{type}({module}): {description}

{body if needed}
EOF
)"
```

### Commit Types
- `fix` - Bug fix
- `feat` - New feature
- `refactor` - Code refactoring
- `docs` - Documentation changes
- `test` - Test additions/changes
- `style` - Formatting, code style
- `chore` - Build, CI, dependencies
- `phpstan` - PHPStan error fixes

### Examples
```bash
git commit -m "phpstan(User): fix type errors in BaseUser model"
git commit -m "feat(Notify): add bulk notification action"
git commit -m "fix(Tenant): correct database config for multi-tenancy"
git commit -m "docs(Xot): update roadmap with completed tasks"
```

## Pre-Commit Checklist

1. Run PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/{Module} --memory-limit=-1`
2. Run Pint: `cd laravel && vendor/bin/pint --dirty`
3. Run Tests: `cd laravel && php artisan test Modules/{Module}/tests/ --compact`
4. Verify no secrets in staged files (.env, credentials, etc.)

## Philosophy

> Fix forward, never backward. Every commit moves the project forward.
> If something broke, create a NEW commit that fixes it.
