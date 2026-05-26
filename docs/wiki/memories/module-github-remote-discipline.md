---
title: disciplina link GitHub nei docs modulo
type: memory
tags: [github, modules, documentation, dry]
created: 2026-05-26
updated: 2026-05-26
related:
  - ../how-to/github-issue-agent-discipline.md
  - ../../chat/handoff-job-lang-merge-phpstan-confidence.md
---

# Disciplina link GitHub nei docs modulo

## Regola

Nei file sotto `laravel/Modules/<Nome>/docs/**` e `laravel/Themes/<Nome>/docs/**`:

- **Non** hardcodare URL tipo `https://github.com/<org>/module_*` o nomi org fissi (`provtv`, `laraxot`) nel corpo o nei link markdown.
- Per issue e PR del **repo modulo**: indicare solo numero (`#12`) e istruire di aprire il remote con:

```bash
cd laravel/Modules/<Nome>
git remote -v
```

## Eccezione

- Wiki **root** `docs/wiki/` e handoff `docs/chat/`: possono riferire il mono tramite `git remote -v` in root; issue mono seguono [github-issue-agent-discipline.md](../how-to/github-issue-agent-discipline.md).

## Motivo

Fork e mirror (`origin` vs `laraxot`) cambiano; la doc modulo deve restare portabile.

## Operatività `gh`

How-to: [`../how-to/module-theme-github-issues.md`](../how-to/module-theme-github-issues.md). Manifest batch: [`../../chat/module-theme-github-issues-manifest.md`](../../chat/module-theme-github-issues-manifest.md).

## Origine

Correzione su `laravel/Modules/Job/docs/wiki/log.md` (2026-05-26).
