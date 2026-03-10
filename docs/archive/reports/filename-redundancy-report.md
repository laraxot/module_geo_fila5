# Filename Redundancy and Naming Violations Report

This document lists files that violate the project's naming conventions, specifically case-insensitive duplicates and Markdown files containing dates in their names.

## Case-Insensitive Duplicates (To be deleted/merged)

The following files differ only by case. According to the new rule, the incorrect version (usually lowercase) must be removed.

- `laravel/Modules/Activity/.github/CONTRIBUTING.md` vs `contributing.md`
- `laravel/Modules/Activity/.github/SECURITY.md` vs `security.md`
- `laravel/Modules/Activity/docs/README.md` vs `readme.md`
- `laravel/Modules/Xot/CHANGELOG.md` vs `changelog.md`
- `laravel/Modules/Xot/docs/CHANGELOG.MD` vs `CHANGELOG.md`
- `laravel/Modules/Xot/app/Console/Commands/WorkerStop.txt` vs `workerstop.txt`
- `laravel/Modules/Xot/stubs/Filament.stub` vs `filament.stub`
- ... (many more found in `docs/redundancy-analysis.txt`)

## Markdown Files with Dates (To be renamed)

The following files contain dates in their names and must be renamed to be date-free.

- `laravel/Modules/User/docs/translation-syntax-fixes-2025.md`
- `laravel/Modules/User/docs/redundancy-fixes-january-2026.md`
- `laravel/Modules/User/docs/roadmap-2025.md`
- `laravel/Modules/Notify/docs/roadmap-2025.md`
- `laravel/Modules/Xot/docs/testing-progress-session-2025-01-22.md`
- ... (full list identified in automated scan)

## Action Plan

1. **Delete** all all-lowercase duplicates where a CamelCase or UPPERCASE version exists.
2. **Rename** all `.md` files to remove date patterns (YYYY, YYYY-MM-DD, Month-YYYY).
3. **Standardize** all `README.md` and `CHANGELOG.md` to UPPERCASE.
