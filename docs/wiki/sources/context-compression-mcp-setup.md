---
title: "Context Compression MCP Setup"
module: "ptvx-project"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-05-20T00:00:00Z"
qmd: "context compression mcp, token optimizer, claude mcp, prompt compaction, token limit fix"
related:
  - "../concepts/second-brain-operating-model.md"
  - "../concepts/ai-tooling-workflow.md"
  - "../how-to/api-context-length-exceeded-131072.md"
---

# Context Compression MCP Setup

> Source summary for the project-level installation and configuration of MCP-based context compression.

## Segnale aggiuntivo (2026-05): errore «131072 maximum context length»

Alcuni endpoint espongono **131072** token massimi mentre il client invia payload **multiplo** (es. ~700k+ *text input* + *tool input* + riserva *output*). Il messaggio suggerisce esplicitamente un plugin di compressione: nel monorepo il playbook è [`../how-to/api-context-length-exceeded-131072.md`](../how-to/api-context-length-exceeded-131072.md) e la disciplina tool è [`bashscripts/ai/rules/context-compression-discipline.md`](../../../bashscripts/ai/rules/context-compression-discipline.md).

## Main Signals

- The repository already used QMD as a retrieval optimizer, but not a dedicated context-compression MCP in the main project config.
- A local installation of `@ooples/token-optimizer-mcp` was added under `bashscripts/mcp/`.
- Shared MCP configuration now exists at project root via `.mcp.json`.
- Compatibility configuration was also added to `.claude/mcp_servers.json`.

## Why It Was Added

- a real API failure exceeded `262144` tokens
- the request attempted about `422920` tokens
- the error explicitly suggested a context-compression plugin

## Retrieval Value

This setup reduces prompt pressure by compressing or caching bulky tool outputs instead of repeatedly injecting them into the live context window.

## References

- [API context length 131072 playbook](../how-to/api-context-length-exceeded-131072.md)
- [Second Brain Operating Model](../concepts/second-brain-operating-model.md)
- [AI Tooling Workflow](../concepts/ai-tooling-workflow.md)
- `../../ai/claude/context-compression-mcp.md`
