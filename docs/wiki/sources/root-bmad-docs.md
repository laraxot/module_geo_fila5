---
title: "Root BMAD Docs"
module: "ptvx-project"
type: source
created: "2026-04-28T00:00:00Z"
updated: "2026-04-28T00:00:00Z"
related:
  - "[[BMAD Operating Model]]"
  - "[[Project Home]]"
---

# Root BMAD Docs

> Source summary for the root `docs/bmad/` documentation cluster.

## Files Read

- `docs/bmad/README.md`
- `docs/bmad/bmad-workflow-catalog.md`
- `docs/bmad/bmad-quickstart-guide.md`

## Stable Themes

- BMAD is the structured framework for complex AI-driven delivery in this repository.
- The framework is phase-based: analysis, planning, solutioning, implementation.
- Different workflows and agent roles are intended for different stages rather than being interchangeable.
- BMAD and GSD are complementary, not competing defaults.

## High-Value Takeaways

- The most important repository behavior is not the names of all workflows, but the staged artifact chain they create.
- `bmad-create-story` and related implementation workflows depend on prior planning artifacts to avoid low-context execution.
- Utility workflows such as context generation, doc indexing, document sharding, and distillation are especially relevant to large-context control.

## Operational Guidance

Use BMAD when the task needs durable structure, alignment, or traceability.

Use the wiki to preserve stable conclusions from BMAD outputs so future agents do not need to reread every planning artifact from scratch.

## References

- `../concepts/bmad-operating-model.md`
- [[Second Brain Operating Model]]
