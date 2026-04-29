---
title: "Architecture Guardrails"
module: "ptvx-project"
type: concept
created: "2026-04-28T00:00:00Z"
updated: "2026-04-28T00:00:00Z"
related:
  - "[[Project Home]]"
  - "[[Module Structure]]"
  - "[[Actions Over Services]]"
  - "[[Second Brain Operating Model]]"
---

# Architecture Guardrails

> Stable architectural rules extracted from the root `docs/architecture/` cluster.

## Core Model

The project is a Laravel modular monolith organized around explicit modules and shared base abstractions. The root architecture docs and project context align on these points:

- modular separation is mandatory
- module interfaces and conventions must stay consistent
- Xot base abstractions govern framework integration
- DTOs and queueable actions are preferred over loose arrays and broad service classes

## Guardrails

### Modular Boundaries

- Functionality belongs inside modules, not in ad hoc shared folders.
- Each module should expose a predictable structure for actions, datas, models, routes, resources, and documentation.
- Cross-module work should preserve local ownership instead of collapsing everything into global helpers.

### Actions Over Services

- New business logic should be implemented as focused actions.
- Legacy services are tolerated only as migration residue.
- Parameters should move through typed data objects when practical.
- The calling style should remain container-friendly and queue-compatible.

### Filament Integration

- Filament resources and pages must follow the Xot wrapper layer.
- Shared conventions matter more than local shortcuts.
- Documentation repeatedly reinforces that Filament customization should flow through project standards, especially for labels, resource methods, and table schemas.

### DTO and Type Discipline

- Spatie Laravel Data is part of the intended architecture, not an optional embellishment.
- Strict typing and predictable signatures are part of maintainability, testing, and static analysis readiness.

## Documentation Risk

The root architecture docs are useful but uneven. In particular:

- `docs/architecture/overview.md` contains broad guidance that is directionally valid
- `docs/architecture/actions-over-services.md` is actionable and aligned with current conventions
- `docs/architecture/modules.md` mixes general rules with module-specific examples
- `docs/architecture/patterns.md` is not a trustworthy source page because it contains unresolved external placeholders

This means agents should prefer synthesized wiki guidance over direct reuse of every raw architecture file.

## Use

Consult this page before:

- adding a new service layer
- introducing a new module structure variant
- bypassing Xot base abstractions
- writing broad cross-module helpers

## References

- [[Actions Over Services]]
- [[Module Structure]]
- `../sources/root-architecture-docs.md`
