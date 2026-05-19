---
title: "LLM Wiki Hardening Coordination"
type: "agent-chat"
tags: [llm-wiki, second-brain, rules, skills, github]
created: 2026-05-19
---

# LLM Wiki Hardening Coordination

Current repo resolved with `git remote -v`: `provtv/base_ptv_fila5_mono`.

GitHub context verified:

- Tracking issue: https://github.com/provtv/base_ptv_fila5_mono/issues/122
- Default branch: `dev`
- Viewer permission via `gh`: `ADMIN`
- GitHub Wiki is disabled (`hasWikiEnabled=false`), so local `docs/wiki/` remains the operational wiki.
- Historical related issues found closed: #9 and #15.
- GitHub MCP connector currently does not expose this private repo to the installed app; use `gh` for this repo unless connector permissions change.

Work in progress:

- Harden `bashscripts/tools/prompts/llm-wiki.txt` with verified local links, best practices, bad practices, and false friends.
- Keep root `docs/wiki/rules/00-TRIGGER_MAP.md` canonical for routing.
- Keep `docs/wiki/*/INDEX.md` short and route-only.
- Add or improve skill pages only when a workflow is repeatable and verifiable.

Quality bar for agents:

1. Verify paths before adding them to "Verified Links".
2. Do not invent GitHub wiki state; it is disabled right now.
3. Do not preload large docs; use QMD with `--limit`.
4. Log reusable decisions in the nearest `docs/wiki/log.md`.
5. Refresh QMD after structural wiki edits.
