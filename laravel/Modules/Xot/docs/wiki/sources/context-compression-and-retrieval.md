---
title: "Context Compression and Retrieval"
module: "Xot"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[Xot Architecture Guardrails]]"
---

# Context Compression and Retrieval

> Xot-facing summary of the shared context-compression setup.

## Main Signals

- project-shared MCP config now includes `token-optimizer`
- the optimizer is installed locally under `bashscripts/mcp/`
- QMD remains the first retrieval layer for docs/wiki, while token optimization reduces repeated or bulky tool context

## Why Xot Cares

Xot raw docs are among the largest in the repository. The recommended path is:

1. query Xot wiki first
2. open only the specific raw cluster needed
3. rely on token optimization for repeated tooling output

## References

- [[Xot Architecture Guardrails]]
- `../../../../../docs/ai/claude/context-compression-mcp.md`
