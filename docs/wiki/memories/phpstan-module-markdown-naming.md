---
title: naming file md report phpstan modulo
type: memory
tags: [phpstan, markdown, naming, agent]
created: 2026-05-27
updated: 2026-05-27
related:
  - ../rules/markdown-documentation-standard.md
  - ../rules/naming-conventions-markdown.md
  - ../../bashscripts/tools/prompts/phpstan_module.txt
---

# Report PHPStan in `Modules/*/docs/` — naming

## Regola

- **Vietato** date nel filename: `phpstan-analysis-2026-05-27.md`, `fixes-january.md`, ecc.
- **Consentito:** `phpstan-fixes-activity.md`, `phpstan-analysis-gdpr.md`, `phpstan-scan-report.md`
- Data del run → campo YAML `updated:` + issue GitHub `[PHPStan] N errori — scan YYYY-MM-DD`
- Prima di creare file: `Glob` / `grep` se esiste già `phpstan*.md` sullo stesso argomento → **aggiornare**, non duplicare

## Eccezioni filename

Solo: `README.md`, `INDEX.md`, `CHANGELOG.md`, `00-TRIGGER_MAP.md` (vedi [standard markdown](../rules/markdown-documentation-standard.md)).

## Esempi corretti (Activity)

| Errato | Corretto |
|--------|----------|
| `phpstan-analysis-2026-05-27.md` | contenuto in `phpstan-fixes-activity.md` |
| nuovo file per ogni scan | sezione «Ultimo scan» nel doc esistente |

## Trigger

Caricare con: edit `.md` post-PHPStan, nuovo report modulo, prompt `phpstan_module.txt`.
