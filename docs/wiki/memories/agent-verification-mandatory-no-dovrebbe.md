---
title: "Verifica obbligatoria post-edit — vietato «dovrebbe»"
type: memory
tags: [agents, phpstan, phpmd, phpinsights, pest, playwright, puppeteer, quality]
created: 2026-06-03
updated: 2026-06-03
related:
  - ../rules/validation-post-edit-rule.md
  - mutex-lock-post-edit.md
---

# Verifica obbligatoria — mai «dovrebbe»

## Regola

Dopo **ogni** modifica a file PHP (e prima di dichiarare chiuso un task UI):

1. Eseguire i controlli — non supporre l’esito.
2. Riportare **output osservato** (exit code, HTTP status, conteggio test).
3. **Vietato** chiudere con «dovrebbe funzionare», «probabilmente OK», «ricarica e verifica».

## Pipeline PHP (cwd `laravel/`)

```bash
./vendor/bin/phpstan analyse <path> --level=10 --memory-limit=2G
./tools/phpmd.sh <path> text phpmd-ruleset.xml
./tools/phpinsights.sh analyse <path> --no-interaction --min-quality=0 --min-complexity=0 --min-architecture=0 --min-style=0
php artisan test <path-testsuite-o-cartella>   # se esiste; documentare se bloccato da altro errore repo
```

## Pipeline UI

```bash
curl -s -o /dev/null -w "HTTP %{http_code}\n" -H "Host: ptvx.local" http://127.0.0.1/
# Playwright/Puppeteer: test E2E del progetto o smoke MCP quando configurati
```

Se Pest fallisce per **errori preesistenti** nel modulo (es. test `static`), indicarlo esplicitamente con path e messaggio — non omettere il tentativo.

## Mutex

`touch file.lock` → edit → `rm -f file.lock` sempre.

## Vedi anche

- [validation-post-edit-rule](../rules/validation-post-edit-rule.md)
- [llm-wiki.txt](../../../bashscripts/tools/prompts/llm-wiki.txt) §4
