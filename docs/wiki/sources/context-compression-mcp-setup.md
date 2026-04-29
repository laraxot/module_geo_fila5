---
title: "Context Compression MCP Setup"
module: "ptvx-project"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
qmd: "context compression mcp, token optimizer, claude mcp, prompt compaction, token limit fix"
related:
  - "[[Second Brain Operating Model]]"
  - "[[AI Tooling Workflow]]"
---

# Context Compression MCP Setup

> Source summary for the project-level installation and configuration of MCP-based context compression.

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

- [[Second Brain Operating Model]]
- [[AI Tooling Workflow]]
- `../../ai/claude/context-compression-mcp.md`
