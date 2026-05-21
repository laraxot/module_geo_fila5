---
title: "git branch policy per agenti AI"
type: "memory"
tags: [git, branch, agents, policy, second-brain]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../rules/git-atomic-operations.md
  - ../concepts/llm-wiki-operational-discipline.md
  - ../how-to/github-issue-agent-discipline.md
---

# Git branch policy per agenti AI

## Regola assoluta

**Solo l'utente umano** può:

- creare branch (`git checkout -b`, `git branch`, `git switch -c`)
- cambiare branch (`git checkout`, `git switch`)
- eliminare branch locali/remoti

**Gli agenti AI non devono mai:**

- aprire branch di lavoro non richiesti esplicitamente
- spostarsi su un altro branch senza istruzione esplicita dell'utente
- fare push su branch creati autonomamente

## Cosa possono fare gli agenti

- Lavorare sul **branch già attivo** quando la sessione parte (verificare con `git branch --show-current`)
- Modificare file, eseguire test, aggiornare wiki
- **`git stash`** solo se l'utente chiede di spostare modifiche su un altro branch che **lui** seleziona
- Dopo `git checkout dev` **esplicito dall'utente**: `git cherry-pick` / `git stash pop` per portare il lavoro su `dev`

## Branch di riferimento

| Branch | Uso |
|--------|-----|
| `dev` | integrazione sviluppo (default per fix condivisi) |
| `master` / `develop` | come da policy team — non toccare senza istruzione |

## Se un agente ha creato un branch per errore

1. L'utente fa checkout su `dev` (o branch corretto).
2. Portare commit con `git cherry-pick <hash>` oppure modifiche con `git stash` → `stash pop` su `dev`.
3. L'utente elimina il branch spurio (`git branch -d nome`).

Esempio reale (2026-05-21): branch `fix/phpstan-indennita-conditions-20260521` creato senza richiesta → lavoro riportato su `dev` con cherry-pick + stash.

## Verifica all'avvio sessione

```bash
git remote -v
git branch --show-current
git status --short | head
```

Se il branch non è quello atteso, **fermarsi** e chiedere all'utente prima di continuare (non cambiare branch autonomamente).

## Vedi anche

- [git-atomic-operations.md](../rules/git-atomic-operations.md)
- [github-issue-agent-discipline.md](../how-to/github-issue-agent-discipline.md)
