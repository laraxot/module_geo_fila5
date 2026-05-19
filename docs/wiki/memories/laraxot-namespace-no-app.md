---
title: "Laraxot namespace — no App segment"
type: "memory"
tags: [namespace, modules, psr-4]
created: 2026-05-19
updated: 2026-05-19
sources:
  - laravel/Modules/Notify/composer.json
  - docs/wiki/rules/laraxot-module-namespace.md
---

# Laraxot namespace — no App segment

Physical `app/` under a module maps to `Modules\<Name>\`, never `Modules\<Name>\App\`.

- [laraxot-module-namespace](../rules/laraxot-module-namespace.md)
