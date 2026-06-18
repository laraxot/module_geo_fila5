---
title: "PHPStan Memory Optimization for Large Codebases"
description: "Workaround for memory constraints in WSL2/Linux environments"
tags: [phpstan, testing, performance, laravel]
updated: 2026-06-18
---

# PHPStan Memory Optimization

## Problem

On WSL2/Linux systems with memory constraints, PHPStan's default parallel processing exhausts memory when analyzing large codebases (1000+ files), even with `--memory-limit=-1` or `memory_limit = -1` in php.ini.

**Error:**
```
PHP Fatal error: Allowed memory size of 536870912 bytes exhausted
PHPStan process crashed because it reached configured PHP memory limit: 512M
```

**Root Cause:** PHPStan's parallel workers have an internal 512M limit that doesn't inherit from parent processes.

## Solution

### Option 1: Analyze Modules Individually (Recommended)

Use the provided script to analyze each module separately:

```bash
# Analyze a specific module
./vendor/bin/phpstan analyse Modules/User --memory-limit=4G

# Or with PHP memory override (more reliable)
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/User

# Analyze all modules (using helper script)
cd laravel
./phpstan-analyze-modules.sh all
```

### Option 2: Disable Parallel Processing

**Configuration in `phpstan.neon`:**
```neon
parameters:
    parallel:
        maximumNumberOfProcesses: 0  # Disables parallel workers
```

Then run:
```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/
```

### Option 3: Increase System Memory

If available, increase available memory:
```bash
# Check current WSL2 memory
wsl --status

# Configure .wslconfig (Windows)
[wsl2]
memory=8GB
```

## Recommended Workflow

1. **Configure phpstan.neon:** Set `maximumNumberOfProcesses: 0` to disable parallel processing
2. **Per-module analysis:** Use the helper script for CI/CD:
   ```bash
   ./phpstan-analyze-modules.sh User
   ./phpstan-analyze-modules.sh Lang
   # ... etc
   ```
3. **Local development:** Analyze only the module you're working on

## Performance Expectations

- **Single module:** 30-60 seconds
- **All modules sequentially:** 10-15 minutes
- **With parallel (if available):** 2-3 minutes

## Configuration Reference

**Current Project Setup:**
- Most modules are excluded from global analysis (`phpstan.neon`)
- Run per-module using: `php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/[ModuleName]`
- Helper script: `./laravel/phpstan-analyze-modules.sh`

## See Also

- [[module-structure-organization-rule]] — Directory structure standards
- PHPStan Issue: https://github.com/phpstan/phpstan/issues/4695

---

*Last updated: June 2026*
