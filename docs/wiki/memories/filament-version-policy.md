# Filament Version Policy — Second Brain Canonical Memory

**Status**: ACTIVE • CRITICAL • PROJECT-WIDE

**Current Stack (2026-05)**
- **Filament**: v5 (NOT v4)
- **Livewire**: v4 (Filament v5 requirement)
- **Schemas package**: primary for layout (`Filament\Schemas\Components\*`)
- **Forms package**: only for field components (`Filament\Forms\Components\*`)

## Golden Rule
> All new code, all docblocks, all wiki entries, all skills, and all generated documentation **MUST** declare and use **Filament v5** conventions.

Never default to "Filament v4" language unless explicitly talking about historical migration work.

## Correct Namespaces (v5)
- Layout / structure → `Filament\Schemas\Components\Section`, `Tabs`, `Grid`, `Wizard`, `Component` (base)
- Form fields → `Filament\Forms\Components\TextInput`, `Select`, `Toggle`, etc.
- Table columns → `Filament\Tables\Columns\*`
- Infolists → `Filament\Infolists\Components\*`

Return type example for modern resources:
```php
/**
 * @return array<string, \Filament\Schemas\Components\Component>
 */
public function getFormSchema(): array
```

## Historical v4 Documents
Many legacy files still contain "filament-4", "filament4", "v4 migration" in their names and content.
These are **archival only** and must be clearly labeled as "pre-v5 migration history".

When referencing them, always add a note:
> "Historical — this document describes the 2025 Filament v4 upgrade. Current target is Filament v5."

## Where to Update When Changing Version
- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/memories/filament-version-policy.md` (this file)
- `docs/templates/module-docs-template.md`
- `docs/templates/theme-docs-template.md`
- Every module's `docs/` folder (inject `filament-version.md`)
- Every theme's `docs/` folder (same)
- All Filament-related skills under `.agents/skills/` (already mostly v5)
- Root `docs/development/filament-*.md` files

## Propagation Command (for agents)
```bash
# After editing the canonical memory, run something like:
find laravel/Modules -type d -path '*/docs' -exec cp docs/templates/filament-version.md {}/filament-version.md \;
find laravel/Themes  -type d -path '*/docs' -exec cp docs/templates/filament-version.md {}/filament-version.md \;
```

## Related Memories & Rules
- `docs/wiki/rules/filament-rules-summary.md`
- `docs/wiki/rules/xotbase-critical-rules.md`
- `docs/wiki/memories/xotbase-never-extend-filament.md`
- `laravel/Modules/Xot/docs/filament-5-laraxot-rules.md` (authoritative for Xot base classes)

**Last updated**: 2026-05-21 by Kilo (AI Software Engineer)
**Signed**: Kilo — always follow this policy on every edit involving Filament code or docs.
