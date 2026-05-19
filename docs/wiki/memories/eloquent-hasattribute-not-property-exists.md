---
title: "Eloquent — hasAttribute not property_exists"
type: "memory"
tags: [eloquent, phpstan, models]
created: 2026-05-19
updated: 2026-05-19
sources:
  - laravel/Modules/User/app/Filament/Resources/UserResource/Schemas/UserForm.php
  - docs/wiki/rules/coding-standards.md
---

# Eloquent — hasAttribute not property_exists

`property_exists()` on Eloquent models is unreliable (magic attributes). Use `hasAttribute()`, `isset()`, or schema checks.

Evidence in repo: `UserForm.php` documents PHPStan L10 preference for `hasAttribute()`.

- [coding-standards](../rules/coding-standards.md)
- [ai-guidelines](../rules/ai-guidelines.md)
