---
title: policy versione filament v5
type: memory
tags: [filament, v5, livewire, schemas, xotbase]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../rules/filament-rules-summary.md
  - ../rules/xotbase-critical-rules.md
  - ../../templates/filament-version.md
---

# Filament Version Policy — Second Brain Canonical Memory

**Status**: ACTIVE • CRITICAL • PROJECT-WIDE

## Stack attuale (2026-05)

| Componente | Versione | Note |
|------------|----------|------|
| **Filament** | **v5** | `composer`: `filament/filament` ^5.0 — **non v4** |
| **Livewire** | v4 | Requisito Filament v5 |
| **Laravel** | 12.x | Monorepo Laraxot |
| Layout / schema | `filament/schemas` | `Filament\Schemas\Components\*` |
| Campi form | `filament/forms` | `Filament\Forms\Components\*` |

## Regola d’oro

> Codice nuovo, PHPDoc, wiki, skill e prompt devono usare convenzioni **Filament v5**. Non dichiarare «Filament v4» come stack attuale.

I file con nome `filament-4*`, `filament_v4*`, link `filamentphp.com/docs/4.x` sono **solo storico** (migrazione 2025). In cima o nel second-brain del modulo: rimandare a questa memory.

## Namespace corretti (v5)

- Layout → `Filament\Schemas\Components\Section`, `Tabs`, `Grid`, `Component`
- Form fields → `Filament\Forms\Components\TextInput`, …
- Table → `Filament\Tables\Columns\*`
- Infolist → `Filament\Infolists\Components\*` (estendono `Filament\Schemas\Components\Component`)

```php
/**
 * @return array<string, \Filament\Schemas\Components\Component>
 */
public function getFormSchema(): array
```

## Dove aggiornare

- `docs/wiki/rules/filament-rules-summary.md`
- `docs/templates/filament-version.md` (copia per modulo/tema)
- `laravel/Modules/<Name>/docs/second-brain.md` (link policy)
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md` (autoritativo XotBase)
- `bashscripts/tools/prompts/llm-wiki.txt` §12 false friends

## Propagazione

Ogni `laravel/Modules/<Name>/docs/` e `laravel/Themes/<Name>/docs/` deve avere in `second-brain.md` il link a questa policy (batch 2026-05-21).

Stub opzionale: `docs/filament-version.md` da `docs/templates/filament-version.md`.

---

**Firmato:** Cursor Agent (Composer) — 2026-05-21
