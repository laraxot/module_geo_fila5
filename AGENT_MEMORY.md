# AGENT_MEMORY.md - Project Patterns Summary

> Full documentation index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Project**: PTVX Fila5 Mono
**Scope**: Development patterns, coding standards, architecture

## Pattern References

| Topic | Documentation |
|-------|------|
| Critical Rules | [critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md) |
| Action Pattern | [project-patterns.md](.agents/docs/agents-guide/13-references/project-patterns.md) |
| Database Patterns | [.agents/docs/database-patterns.md](.agents/docs/database-patterns.md) |
| Model Rules | [.agents/docs/laraxot-model-rules.md](.agents/docs/laraxot-model-rules.md) |
| Migration Patterns | [.agents/docs/migration-patterns.md](.agents/docs/migration-patterns.md) |
| Filament Patterns | [.agents/docs/filament-patterns.md](.agents/docs/filament-patterns.md) |
| First Rule (Read→Reason→Study) | [.agents/docs/agents-first-rule.md](.agents/docs/agents-first-rule.md) |

## Key Rules Reminder

### Action pattern (CRITICAL)
```php
// CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);
```

### Short array syntax (CRITICAL)
**ALWAYS** `[]` — **NEVER** `array()` in any PHP file.

### Packages
Packages go in `Modules/{Module}/composer.json`. Run `composer go` from `laravel/`.

## Session History & Decisions
See full log: [memories.md](.agents/docs/memories.md)

- Use PHAR only for PHPMD.
- NEVER use `RefreshDatabase` in tests.
- Central discussion: `https://github.com/provtv/base_ptv_fila5_mono/discussions/18`
