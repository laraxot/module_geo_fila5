---
title: prototipo issue phpstan modulo
type: template
tags: [phpstan, github, modules, agent]
updated: 2026-05-27
related:
  - ../how-to/module-theme-github-issues.md
  - ../memories/phpstan-modules-inventory.md
  - ../../bashscripts/tools/prompts/phpstan_module.txt
---

# Prototipo issue — `[PHPStan] N errori — scan YYYY-MM-DD`

> **Una issue per modulo** con tutti gli errori del run. Non aprire issue per singolo errore.

## Titolo

```text
[PHPStan] {N} errori — scan {YYYY-MM-DD} (level max)
```

## Corpo (copia in `gh issue create`)

```markdown
## Contesto

| Campo | Valore |
|-------|--------|
| Path mono | `laravel/Modules/{Modulo}` |
| Remote | `{owner}/{repo}` da `git remote -v` in cartella modulo |
| Comando | `cd laravel && ./vendor/bin/phpstan analyse Modules/{Modulo} --memory-limit=2G` |
| Config | `laravel/phpstan.neon` (`level: max`) — **non modificare** |
| Esclusi globali | `Pdnd`, `Incentivi` (non analizzare) |

## Riepilogo

| # | File | Identificatore PHPStan | N |
|---|------|------------------------|---|
| 1 | `path/to/File.php` | `argument.type` | 1 |

## Dettaglio + fix proposto

### 1. `path/to/File.php` — riga X

**Errore:** …

**Fix proposto:** … (pattern: Job / Xot / `phpstan-fixes-*.md`)

**Riferimenti:** link doc modulo, issue correlate

## Ordine fix consigliato

1. …
2. …

## Quality gate post-fix

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/{Modulo} --memory-limit=2G
./vendor/bin/pint --dirty Modules/{Modulo}
```

## Dependabot / PR (pre-flight)

- `gh pr list --repo {owner}/{repo} --state open`
- Alert security: `gh api repos/{owner}/{repo}/dependabot/alerts` o dashboard GitHub

## Checklist chiusura

- [ ] PHPStan 0 errori
- [ ] Pint su file toccati
- [ ] `Modules/{Modulo}/docs/phpstan*.md` aggiornato (kebab-case, **senza date** nel nome — vedi [`phpstan-module-markdown-naming.md`](../memories/phpstan-module-markdown-naming.md))
- [ ] Inventario [`phpstan-modules-inventory.md`](../memories/phpstan-modules-inventory.md)
- [ ] Commento mono #136

## Firma agente

```text
**Agente AI:** Auto (Cursor agent router)
**Modello:** Composer
```

## BMAD (se campagna attiva)

- Story: `_bmad-output/implementation-artifacts/stories/phpstan-zero-<modulo>.md`
- Workflow: `bashscripts/tools/prompts/phpstan_module.txt` (sezione BMAD × PHPStan)
- Post-fix: `bmad-code-review` + aggiornamento inventario wiki

## Collegamenti

- Coordinamento modulo: issue `[AI] PHPStan e confidenza agenti` se esiste
- Mono: provtv/base_ptv_fila5_mono#136
```

## Esempio reale

- [module_activity_fila5#10](https://github.com/provtv/module_activity_fila5/issues/10) — audit 16 errori
- Chiusura dopo fix: commento con output ` [OK] No errors `
