<<<<<<< .merge_file_l0blMf
---
title: "Rimando a status.md"
description: "Documento unificato: il contenuto canonico vive in status.md."
status: merged
tags: [merge, duplicato, case-only]
---

# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [status.md](./status.md).
=======
# Laravel 13 Upgrade Status - Root Project 🐄✨

## Overview
This document tracks the overall progress of the Laravel 13 upgrade for the entire repository.

## Global Status
- [x] PHP Version: ^8.4 (Mandatory for Laravel 13)
- [x] Framework: Laravel ^13.0
- [x] Modular System: nWidart/laravel-modules ^13.0
- [x] All 35 Modules updated
- [x] 3 Themes updated
- [x] Spatie Permission Configuration fixed

## Critical Fixes
1. **Namespace Detection**: Fixed `composer.json` psr-4 mapping and corrected nesting issues.
2. **Debugbar**: Switched from `barryvdh/laravel-debugbar` to `fruitcake/laravel-debugbar` for L13 compatibility.
3. **Permissions**: Resolved `TeamModelNotConfigured` by enabling the `User` module and verifying tenant-specific configurations.

## Post-Upgrade Checklist
1. Execute `composer go` in the `laravel/` directory.
2. Run `php artisan optimize:clear`.
3. Run `php artisan module:publish-stubs`.
4. Run full test suite.

---
**Status**: Ready for final verification.
>>>>>>> .merge_file_JvpNnS
