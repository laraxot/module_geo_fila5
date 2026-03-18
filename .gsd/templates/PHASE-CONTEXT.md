# Phase {N} — Context Document

**Phase**: {phase_name}
**Created**: {date}
**Status**: Draft | Reviewed | Approved

---

## Phase Overview

{Brief description of the phase from ROADMAP.md}

## Decisions Made

### Visual/UI Decisions
- Layout: {decision}
- Density: {decision}
- Interactions: {decision}
- Empty states: {decision}

### API/Backend Decisions
- Response format: {decision}
- Error handling: {decision}
- Authentication: {decision}

### Data/Model Decisions
- Schema changes: {decision}
- Relationships: {decision}
- Migrations: {decision}

### Laraxot-Specific Decisions
- Module placement: {which module}
- XotBase classes: {which base classes}
- Filament resources: {new/modified}
- Translations: {languages to update}

## Gray Areas Resolved

| Area | Decision | Rationale |
|------|----------|-----------|
| {area} | {decision} | {why} |

## Constraints

- Must follow Laraxot conventions (XotBase*, no direct Filament)
- PHPStan Level 10 compliance required
- No `->label()` in Filament components
- Translations via LangServiceProvider
- `declare(strict_types=1)` in all PHP files

## Dependencies

- Requires Phase {X} complete: {reason}
- External: {any external dependency}

---

*This document feeds into research and planning. The deeper you go here, the more the system builds what you actually want.*
