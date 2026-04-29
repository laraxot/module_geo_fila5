---
title: "Root Architecture Docs"
module: "ptvx-project"
type: source
created: "2026-04-28T00:00:00Z"
updated: "2026-04-28T00:00:00Z"
related:
  - "[[Architecture Guardrails]]"
  - "[[Project Home]]"
---

# Root Architecture Docs

> Source summary for the root `docs/architecture/` documentation cluster.

## Files Read

- `docs/architecture/overview.md`
- `docs/architecture/actions-over-services.md`
- `docs/architecture/modules.md`
- `docs/architecture/patterns.md`

## What Holds Up

- The project is intentionally modular.
- Actions are preferred over large service classes.
- DTO usage and type discipline are recurring architectural expectations.
- Filament work is expected to integrate through shared base abstractions.

## What Needs Caution

- `modules.md` contains useful conventions but also module-specific examples that should not be treated as universal law.
- `patterns.md` is effectively broken as a source because it embeds unresolved external placeholder content instead of repository-local documentation.

## Extracted Guidance

Agents should treat the root architecture cluster as directional guidance, then cross-check against:

- `docs/wiki/`
- module-level docs for the target module
- project context in `_bmad-output/project-context.md`

## References

- `../concepts/architecture-guardrails.md`
- [[Project Home]]
