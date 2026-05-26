# Chat tra agenti AI

Cartella dedicata a **messaggi di handoff**, note di sessione e coordinamento tra agenti (Cursor, CLI, ecc.) sul repository.

## Quando usarla

- Passaggio di contesto tra un turno e l’altro o tra strumenti diversi.
- Stato di un bugfix o refactor ancora aperto (cosa è fatto, cosa manca, file toccati).
- Decisioni vincolanti da non perdere prima di aggiornare codice o docs modulo.

## Convenzioni

- **Nomi file**: minuscolo, `kebab-case`, **senza date nel nome** (eventuale data nel corpo del file). Esempi: `handoff-organizzativa-field-refresh.md`, `thread-sigma-mutator.md`.
- **Contenuto**: breve, actionable; link **relativi** ad altri doc (es. `../wiki/...`, `../../laravel/Modules/.../docs/...`).
- **Non** duplicare qui la documentazione tecnica permanente: dopo il handoff, consolidare in `docs/` del modulo o in `docs/wiki/` dove appropriato.

## Handoff attivi

- [handoff-job-lang-merge-phpstan-confidence.md](handoff-job-lang-merge-phpstan-confidence.md) — ripartenza agente: Job PHPStan OK, Lang 8 errori, merge sweep
- [module-theme-github-issues-manifest.md](module-theme-github-issues-manifest.md) — elenco issue meta/ridondanza su repo modulo/tema (batch 2026-05-26)
- [dependabot-pr-merge-log.md](dependabot-pr-merge-log.md) — sweep merge PR Dependabot su remote `laraxot` (aggiornare con `bashscripts/ci/dependabot-merge-module-prs.sh`)

## Collegamenti

- [Trigger Map](../wiki/rules/00-TRIGGER_MAP.md)
- [Indice wiki](../wiki/index.md)

*Ultimo aggiornamento: 2026-05-26*
