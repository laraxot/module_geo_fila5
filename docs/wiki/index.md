---
qmd: "ptvx-project, wiki, second brain, Karpathy pattern, QMD search, architecture, modules, themes"
---

# PTVX Wiki Entry Point

## Core Pages

- [[Project Home]] — entry page for the project wiki
- [[Second Brain Operating Model]] — how raw docs, wiki pages, schema, and logs work together

## Concepts

- [module-structure](./concepts/module-structure.md) — standard module layout and responsibilities
- [actions-over-services](./concepts/actions-over-services.md) — preferred business logic pattern
- [accessor-auto-persistence](./concepts/accessor-auto-persistence.md) — persistence pattern for computed values
- [architecture-guardrails](./concepts/architecture-guardrails.md) — stable architectural rules and document trust boundaries
- [ai-tooling-workflow](./concepts/ai-tooling-workflow.md) — shared agent workflow across Claude, Gemini, and iFlow
- [bmad-operating-model](./concepts/bmad-operating-model.md) — when and how BMAD should be used in this repository
- [second-brain-operating-model](./concepts/second-brain-operating-model.md) — operational model for project memory
- [second-brain-continuous-improvement](./concepts/second-brain-continuous-improvement.md) — continuous maintenance loop for root, module, and theme docs
- [second-brain-audit-checks](./concepts/second-brain-audit-checks.md) — reusable lint checks for wiki health and retrieval quality
- [context-mode-plugin](./concepts/context-mode-plugin.md) — FTS5-based context compression for managing token overflow in large projects
- [context-mode-cli-reference](./concepts/context-mode-cli-reference.md) — Quick reference for all context-mode commands and usage patterns

## Sources

- [docs-landscape-modules-and-themes](./sources/docs-landscape-modules-and-themes.md) — summary of the current documentation landscape
- [root-architecture-docs](./sources/root-architecture-docs.md) — summary of the root architecture docs cluster
- [root-ai-docs](./sources/root-ai-docs.md) — summary of the root AI tooling docs cluster
- [root-bmad-docs](./sources/root-bmad-docs.md) — summary of the root BMAD docs cluster
- [ingest-backlog](./sources/ingest-backlog.md) — prioritized ingest backlog with token-cost estimates (Story 1-4)
- [second-brain-external-benchmarks](./sources/second-brain-external-benchmarks.md) — external benchmarks mapped to repository-local second-brain operations
- [context-compression-mcp-setup](./sources/context-compression-mcp-setup.md) — setup summary for MCP-based prompt compression in Claude Code
