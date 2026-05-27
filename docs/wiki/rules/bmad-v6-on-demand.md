---
title: "BMAD v6 On-Demand Project Install"
type: "rule"
tags: [bmad, claude-code, on-demand, skills, commands, second-brain]
created: 2026-05-27
updated: 2026-05-27
source: "https://github.com/aj-geddes/claude-code-bmad-skills"
version: "6.0.2"
---

# BMAD v6 On-Demand Project Install

> BMAD v6 e installato a livello progetto in `.claude/`, non nella home utente.

## Installazione locale

- Source repo: `aj-geddes/claude-code-bmad-skills`.
- Commit installato: `b5c6403847b32f0facc95943a1aa837c96de31af`.
- Skills: `.claude/skills/bmad/`.
- Commands: `.claude/commands/bmad/`.
- Config/helpers/templates: `.claude/config/bmad/`.

## Regola on-demand

1. Non incollare comandi, skill o helper BMAD dentro `CLAUDE.md`, `AGENTS.md` o altri bootstrap stub.
2. Su trigger BMAD, caricare prima `docs/wiki/concepts/bmad-operating-model.md`, poi questa regola.
3. Caricare solo il comando richiesto da `.claude/commands/bmad/<command>.md`.
4. Caricare solo la skill collegata in `.claude/skills/bmad/**/SKILL.md`.
5. Usare `.claude/config/bmad/helpers.md` solo per la sezione helper citata dal comando o dalla skill.
6. Distillare nel wiki solo decisioni durevoli; lasciare artefatti operativi in `_bmad-output/` o nei path BMAD previsti.

## Mapping rapido

- Orchestrazione: `.claude/skills/bmad/core/bmad-master/SKILL.md`.
- Product discovery: `.claude/skills/bmad/bmm/analyst/SKILL.md`.
- Requirements: `.claude/skills/bmad/bmm/pm/SKILL.md`.
- Architettura: `.claude/skills/bmad/bmm/architect/SKILL.md`.
- Sprint/story: `.claude/skills/bmad/bmm/scrum-master/SKILL.md`.
- Implementazione: `.claude/skills/bmad/bmm/developer/SKILL.md`.
- UX: `.claude/skills/bmad/bmm/ux-designer/SKILL.md`.
- Builder: `.claude/skills/bmad/bmb/builder/SKILL.md`.
- Brainstorm/research: `.claude/skills/bmad/cis/creative-intelligence/SKILL.md`.

## Verifica

```bash
test -f .claude/skills/bmad/core/bmad-master/SKILL.md
test -f .claude/commands/bmad/workflow-init.md
test -f .claude/config/bmad/helpers.md
```

## Vedi anche

- [BMAD Operating Model](../concepts/bmad-operating-model.md)
- [BMAD v6 Commands](../commands/bmad-v6.md)
- [Trigger Map](./00-TRIGGER_MAP.md)
