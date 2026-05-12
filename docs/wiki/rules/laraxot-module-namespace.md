---
title: "Laraxot Module Namespace — no \\app\\ segment"
type: "rule"
tags: [namespace, psr-4, composer, modules, laraxot]
created: 2026-05-12
updated: 2026-05-12
confidence: high
sources:
  - laravel/Modules/Notify/composer.json
  - laravel/Modules/Activity/app/Filament/Resources/ActivityResource/Pages/CreateActivity.php
---

# Laraxot Module Namespace — no `\app\` segment

## Regola

Ogni modulo Laraxot ha il proprio `composer.json` con PSR-4 che mappa `"Modules\\<Name>\\": "app/"`.

La cartella `app/` è la **radice del namespace** — sparisce nel PHP.

> **MAI includere `app` nel namespace di un modulo Laraxot.**

## Perché

```json
// Modules/Notify/composer.json
"autoload": {
    "psr-4": {
        "Modules\\Notify\\": "app/"
    }
}
```

PSR-4 dice: il path `app/` corrisponde al namespace `Modules\Notify\`.  
Quindi `app/Providers/NotifyServiceProvider.php` → `Modules\Notify\Providers\NotifyServiceProvider`.

## Tabella ✅ / ❌

| File fisico | ✅ Namespace corretto | ❌ SBAGLIATO |
|---|---|---|
| `Modules/User/app/Models/User.php` | `Modules\User\Models\User` | `Modules\User\app\Models\User` |
| `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/CreateActivity.php` | `Modules\Activity\Filament\Resources\ActivityResource\Pages\CreateActivity` | `Modules\Activity\app\Filament\...` |
| `Modules/Notify/app/Providers/NotifyServiceProvider.php` | `Modules\Notify\Providers\NotifyServiceProvider` | `Modules\Notify\app\Providers\...` |

## Codice confermato

```php
// ✅ Corretto — da CreateActivity.php reale
namespace Modules\Activity\Filament\Resources\ActivityResource\Pages;
```

## Differenza da Laravel standard

In Laravel puro il namespace include `App\` perché `app/` → `App\`.  
In Laraxot **ogni modulo ha il suo prefix** (`Modules\<Name>\`) che già include tutto — `app/` è solo la directory fisica.

## Vedi anche

- [xotbase-critical-rules](./xotbase-critical-rules.md)
- [filament-resource-property](./filament-resource-property.md)
- Spec: `bashscripts/tools/prompts/llm-wiki.txt` §16
