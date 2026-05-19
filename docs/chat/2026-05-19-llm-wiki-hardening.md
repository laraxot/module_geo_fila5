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


## Update: Forbidden Residues

Verified absent locally:

- `laravel/Modules/Notify/.agent~HEAD`
- `laravel/Modules/Notify/.ai-context~HEAD`
- `laravel/Modules/Notify/.ai~HEAD`
- `laravel/Modules/Notify/.clauderules~HEAD`
- `laravel/Modules/Notify/.claude~HEAD`
- `laravel/Modules/Notify/.cursor~HEAD`
- `laravel/Modules/Notify/.iflow~HEAD`
- `laravel/Modules/Notify/.junie~HEAD`
- `laravel/Modules/Notify/.phive~HEAD`
- `laravel/Modules/Notify/.windsurf~HEAD`
- `laravel/Modules/Notify/.zai~HEAD`
- `laravel/Modules/Media/docs/wiki/_archive/`

General rule added to prompt: no merge residue files (`*~HEAD`, `*~BASE`, `*~LOCAL`, `*~REMOTE`, `.orig`, `.rej`) and no wiki archive folders. Use git history for the past and active wiki pages for current knowledge.
