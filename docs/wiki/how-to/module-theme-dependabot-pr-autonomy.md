---
title: PR Dependabot moduli e temi — gestione autonoma agente
type: guide
tags: [dependabot, pull-requests, modules, themes, agents]
updated: 2026-05-26
related:
  - dependabot-discipline.md
  - module-theme-github-issues.md
  - ../../../bashscripts/ci/dependabot-merge-module-prs.sh
---

# PR Dependabot — gestione autonoma (moduli/temi)

## Regola

L’agente **non attende** che l’utente apra [Pull requests](https://github.com/laraxot/module_lang_fila5/pulls) o equivalenti: deve **sweep periodico** su ogni repo `laraxot/*` (remote `laraxot` da `git remote -v` nella cartella modulo/tema), merge o fix fino a chiusura.

## Trovare la repo

```bash
cd laravel/Modules/<Nome>   # o Themes/<Nome>
git remote -v               # usare remote laraxot per PR Dependabot upstream
```

## Comandi

```bash
# Elenco PR aperte Dependabot
REPO=$(git -C laravel/Modules/Lang remote get-url laraxot | sed -E 's|.*github.com[:/]([^/]+/[^/.]+)(\.git)?|\1|')
gh pr list --repo "$REPO" --author "app/dependabot" --state open

# Sweep automatico (merge amministrativo dove possibile)
bashscripts/ci/dependabot-merge-module-prs.sh

# Security (priorità)
bashscripts/ci/dependabot-security-repos.sh
```

## Ordine di lavoro

1. **Security alerts** → `dependabot-security-repos.sh`
2. **PR `github_actions/*`** → merge se `gh` ha scope `workflow`; altrimenti bump manuale dei workflow nel modulo e push su `laraxot`
3. **PR `npm_and_yarn/*`** → merge una alla volta; se conflitto: `gh pr checkout` nel clone modulo, risolvere, `npm install`, push branch
4. **Sync mono** → allineare `package.json` / lock nel tree `laravel/Modules/<Nome>/`
5. **PHPStan** → `cd laravel && ./vendor/bin/phpstan analyse Modules/<Nome>`
6. Commento issue meta modulo + voce in `docs/chat/dependabot-pr-merge-log.md`

## Blocker noti

| Blocker | Azione agente |
|---------|----------------|
| `workflow scope` mancante su token `gh` | Re-auth `gh auth refresh -s workflow` **oppure** applicare diff workflow a mano e push |
| CI rosso (phpstan/insights) | Fix nel modulo/mono prima del merge |
| Conflitto merge | Checkout branch Dependabot, risolvere, non `git checkout` di versioni vecchie |
| Major npm (vite 7, tailwind 4) | Verificare build; issue discussione se breaking |

## Firma

Ogni commento/merge: `Agente AI: Auto` · `Modello: Composer`

## Collegamenti

- [`dependabot-discipline.md`](dependabot-discipline.md)
- Log sweep: [`dependabot-pr-merge-log.md`](../../chat/dependabot-pr-merge-log.md)
