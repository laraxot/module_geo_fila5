---
title: "Laravel bootstrap — stub not monolith"
type: memory
tags: [context, agents, laravel]
created: 2026-05-20
updated: 2026-05-20
sources:
  - laravel/AGENTS.embedded-rules.FULL.md.bak
---

# Laravel bootstrap — stub not monolith

`laravel/AGENTS.md` and `laravel/CLAUDE.md` must stay ≤50 lines. Full `.ai` rules live in `*.embedded-rules.FULL.md.bak` (gitignored) or wiki on-demand.

Prevents API error: 131072 max vs ~796k requested (~722k text input).

- [api-context-length-exceeded-131072](../how-to/api-context-length-exceeded-131072.md)
