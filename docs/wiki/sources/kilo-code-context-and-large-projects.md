---
title: "Kilo Code Context and Large Projects"
module: "ptvx-project"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[Second Brain Operating Model]]"
---

# Kilo Code Context and Large Projects

> Summary of the official Kilo docs most relevant to context overflows in this repository.

## Main Signals

- root `AGENTS.md` is the preferred persistent instruction source
- `instructions` in `kilo.jsonc` should stay short because each extra instruction file increases the system prompt
- `compaction` supports `auto`, `prune`, and `reserved`; invalid keys cause the config to be ignored
- `.kilocodeignore` still works and is migrated into deny rules for read/edit
- `watcher.ignore` is separate from file access and should exclude noisy runtime folders
- MCP servers add tools and context overhead, so large repos should keep only the necessary ones enabled
- Codebase Indexing can help large repos, but only after excluding caches, generated folders, and dependency trees
- managed indexing is a separate cloud feature and should be opted into deliberately, not left implicit

## Applied to PTVX

- project Kilo config was reduced to a valid minimal shape
- MCP was reduced to `qmd` and `token-optimizer`
- global Kilo compaction was enabled with a larger reserve
- project and global setup now treat `AGENTS.md` as durable context and session history as compactable context
- repository-level managed indexing was explicitly disabled pending an intentional indexing decision

## References

- `../../ai/kilo/kilo-large-projects.md`
- https://kilo.ai/docs/customize/context/large-projects
- https://kilo.ai/docs/customize/context/context-condensing
- https://kilo.ai/docs/customize/agents-md
- https://kilo.ai/docs/customize/custom-instructions
- https://kilo.ai/docs/customize/context/kilocodeignore
- https://kilo.ai/docs/features/codebase-indexing
- https://kilo.ai/docs/deploy-secure/managed-indexing
- https://kilo.ai/docs/automate/mcp/using-in-cli
