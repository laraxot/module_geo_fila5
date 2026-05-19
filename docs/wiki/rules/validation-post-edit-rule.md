---
title: "validazione post-modifica e mutex lock affiancato"
type: "rule"
tags: [phpstan, phpmd, phpinsights, playwright, puppeteer, agent-coordination, quality]
created: 2025-10-29
updated: 2026-05-19
---

# Validazione post-modifica e mutex `.lock` affiancato

## Filosofia

- **Lock affiancato** (`file.ext` → `file.ext.lock`): mutex economico tra agenti/processi sullo stesso asset senza server centrale. Se il lock esiste, qualcuno sta già modificando: eviti merge sporchi e regressioni incrociate.
- **Validazione statica** (PHPStan, PHPMD, PHPInsights): contratto di qualità sul codice che tocchi; riduce debito e sorprese in CI.
- **Playwright / Puppeteer (globali)**: stesso tooling riusabile tra progetti; quando cambi UI o flussi browser, verifichi comportamento reale, non solo sintassi.

Il repo ignora i lock companion con il pattern `*.lock` con eccezioni per `composer.lock`, `package-lock.json`, `yarn.lock`, `pnpm-lock.yaml` (`.gitignore`).

## 1. Mutex — ordine obbligatorio

Per ogni file da modificare alla path `PATH` (qualsiasi estensione):

1. Se **`PATH.lock` esiste** → **STOP** (non editare; ripresa quando il lock sparisce).
2. **`touch PATH.lock`**.
3. Modifica `PATH`.
4. **`rm -f PATH.lock`** (sempre, anche su errore — preferibilmente `trap 'rm -f PATH.lock' EXIT` negli script).

## 2. File PHP — controlli dopo la modifica

Lavorare da **`laravel/`** (composer root dell’app).

```bash
cd laravel

# 1) PHPStan livello 10 (sostituisci con il path reale sotto laravel/)
./vendor/bin/phpstan analyse Modules/<Module>/app/Path/File.php --level=10 --memory-limit=2G

# 2) PHPMD — wrapper repo (PHAR in laravel/tools/)
./tools/phpmd.sh Modules/<Module>/app/Path/File.php text phpmd-ruleset.xml

# 3) PHPInsights — wrapper standalone in laravel/tools/
./tools/phpinsights.sh analyse Modules/<Module>/app/Path/File.php --no-interaction --min-quality=0 --min-complexity=0 --min-architecture=0 --min-style=0
```

Aggiusta soglie `--min-*` se il modulo ha policy più strette; l’obiettivo è **vedere il report** e non introdurre violazioni nuove rispetto al baseline.

## 3. Controlli visuali / E2E (installazione globale)

Installazione tipica (una volta per macchina, riusabile tra progetti):

```bash
npm install -g playwright @playwright/test puppeteer
# Playwright richiede browser: al primo uso
npx playwright install
```

Esegui test E2E o script Puppeteer **del progetto** pertinenti alle pagine modificate (path dipende dal repo; cercare `*.spec.ts`, `tests/Browser`, ecc.).

## 4. File non PHP (es. wiki, prompt)

Niente PHPStan/PHPMD/PHPInsights obbligatori; applica comunque il **mutex lock** se più agenti possono toccare lo stesso file. Per wiki root: `bashscripts/quality-gates/verify-llm-wiki.sh` quando tocchi `docs/wiki/` o questo prompt.

## 5. Trigger

| Trigger | Carica |
|---------|--------|
| Edit PHP / qualità / lock agent | questo file |
| Disciplina prompt LLM Wiki | [`bashscripts/tools/prompts/llm-wiki.txt`](../../../bashscripts/tools/prompts/llm-wiki.txt) §2.1 |

## Vedi anche

- [GitHub issue #124 — ragionamenti disciplina agent](https://github.com/provtv/base_ptv_fila5_mono/issues/124)
- [GitHub issue come audit trail](../how-to/github-issue-agent-discipline.md)
- [`docs/wiki/rules/00-TRIGGER_MAP.md`](./00-TRIGGER_MAP.md)
- Raw storico coordinamento: [`docs/raw/history/MULTI_AGENT_COORDINATION.md`](../../raw/history/MULTI_AGENT_COORDINATION.md)
