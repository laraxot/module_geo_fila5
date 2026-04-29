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

## How-To Guides

### Search and Discovery
- [wiki-search-guide](./how-to/wiki-search-guide.md) — User guide for wiki-search CLI: keyword search, semantic search, filtering, and results formatting
- [semantic-search-and-related-pages](./how-to/semantic-search-and-related-pages.md) — Advanced: using semantic similarity to discover related concepts and cross-reference analysis
- [qmd-search-guide](./how-to/qmd-search-guide.md) — Complete guide to QMD (Query Markdown Database): installation, search commands, configuration, and performance optimization
- [qmd-indexing-manifest](./how-to/qmd-indexing-manifest.md) — Reference: current QMD indexing status, collection inventory, embedding progress, and maintenance schedule

### Documentation Development
- [module-wiki-documentation](./how-to/module-wiki-documentation.md) — How to create and maintain QMD-indexed documentation in module wikis
- [theme-wiki-documentation](./how-to/theme-wiki-documentation.md) — How to create and maintain QMD-indexed wikis in theme directories
- [indexing-module-documentation](./how-to/indexing-module-documentation.md) — Step-by-step guide for indexing module documentation with context-mode
- [using-wiki-templates](./how-to/using-wiki-templates.md) — How to use provided templates to create consistent documentation across all modules and themes

### Development Tools and Patterns
- [kilo-code-setup](./how-to/kilo-code-setup.md) — Installation and configuration of Kilo Code AI assistant with wiki and QMD integration
- [context-mode-overflow-prevention](./how-to/context-mode-overflow-prevention.md) — Prevent token overflow: use context-mode correctly with sandbox processing
- [wiki-search-performance](./how-to/wiki-search-performance.md) — Performance optimization: benchmarking, caching strategies, and metrics
- [wiki-search-accessibility](./how-to/wiki-search-accessibility.md) — Accessibility features: screen readers, keyboard navigation, ARIA labels, and UX improvements

## Sources

- [docs-landscape-modules-and-themes](./sources/docs-landscape-modules-and-themes.md) — summary of the current documentation landscape
- [root-architecture-docs](./sources/root-architecture-docs.md) — summary of the root architecture docs cluster
- [root-ai-docs](./sources/root-ai-docs.md) — summary of the root AI tooling docs cluster
- [root-bmad-docs](./sources/root-bmad-docs.md) — summary of the root BMAD docs cluster
- [ingest-backlog](./sources/ingest-backlog.md) — prioritized ingest backlog with token-cost estimates (Story 1-4)
- [second-brain-external-benchmarks](./sources/second-brain-external-benchmarks.md) — external benchmarks mapped to repository-local second-brain operations
- [context-compression-mcp-setup](./sources/context-compression-mcp-setup.md) — setup summary for MCP-based prompt compression in Claude Code
- [kilo-code-context-and-large-projects](./sources/kilo-code-context-and-large-projects.md) — official Kilo guidance for large-project context control, condensed for this repository
