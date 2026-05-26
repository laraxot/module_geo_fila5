---
title: "GitHub issue: creazione proattiva senza chiedere conferma"
type: memory
tags: [github, gh, agent, second-brain]
created: 2026-05-21
updated: 2026-05-26
related:
  - ../how-to/github-issue-agent-discipline.md
  - ../concepts/second-brain-operating-model.md
---

# GitHub issue proattive

## Regola

Quando lavori su un argomento (bug, policy, tooling, ops):

1. `git remote -v` → `gh issue list --search "<argomento>" --state all`
2. Se **nessuna** issue copre il tema → **`gh issue create`** subito (titolo `[DOCS]` / `[OPS]` / `[CI]` + body con scopo, path wiki, checklist).
3. Se esiste → commenta stato / chiudi quando la checklist è soddisfatta.
4. **Non** chiedere all’utente «vuoi che crei/chiuda un’issue?» — è parte del flusso standard.

5. **Nessuna eccezione “solo wiki / solo `.md`”:** se modifichi solo `docs/**/*.md`, la disciplina resta identica (evita audit trail vuoto).

## Dove è canonico

- How-to: [`github-issue-agent-discipline.md`](../how-to/github-issue-agent-discipline.md)
- Rule Cursor sempre attiva: `.cursor/rules/cursor-context-discipline.mdc` (blocco GitHub Issues)
- Prompt: `bashscripts/tools/prompts/llm-wiki.txt` § «GitHub & Issue Synchronization»

## Repo

`provtv/base_ptv_fila5_mono` (`git@github.com:provtv/base_ptv_fila5_mono.git`)
