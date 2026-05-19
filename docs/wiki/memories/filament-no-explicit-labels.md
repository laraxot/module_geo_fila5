---
title: "Filament — no explicit label()"
type: "memory"
tags: [filament, translations, lang]
created: 2026-05-19
updated: 2026-05-19
sources:
  - laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php
  - docs/wiki/rules/filament-rules-summary.md
---

# Filament — no explicit label()

LangServiceProvider owns labels/tooltips. `XotBaseWizardWidget` documents: do not use `->label()` on fields/actions.

Legacy violations still exist (e.g. `TenantUserForm.php`); new code must not add more.

- [filament-rules-summary](../rules/filament-rules-summary.md)
