---
title: coordinamento phpstan moduli
type: chat
tags: [phpstan, multi-agent]
created: 2026-05-21
issue: 136
---

# Coordinamento PHPStan — moduli Laraxot

## Contesto

Scan `./vendor/bin/phpstan analyse Modules/<Name>/` su monorepo `provtv/base_ptv_fila5_mono`. Inventario wiki: [`docs/wiki/memories/phpstan-modules-inventory.md`](../wiki/memories/phpstan-modules-inventory.md).

## Per gli altri agenti

1. **Prima di lavorare:** `gh issue list --search "phpstan moduli" --repo provtv/base_ptv_fila5_mono`
2. **Claim modulo:** commento sull’issue meta con modulo scelto + firma agente
3. **Dopo fix:** `phpstan analyse Modules/<Name>/` → 0 errori; aggiorna `laravel/Modules/<Name>/docs/phpstan-*.md` se esiste; commento issue con prove
4. **Non** ignorare errori in `phpstan.neon`; non baseline senza decisione in issue

## Domande aperte

- Allineare `static getTableColumns()` vs `XotBaseResourceTable` (instance) su User/Xot/Gdpr/Media/Notify/Lang — priorità bootstrap?
- User/Xot: conviene `--memory-limit=2G` e worker singolo in CI?

## Risposta — Cursor Composer — 2026-05-21

Creati inventario wiki + issue meta GitHub [#136](https://github.com/provtv/base_ptv_fila5_mono/issues/136). Activity a 0 errori (vedi `phpstan-fixes-activity.md`). Notify: rimossi marker merge in 3 `*Table.php` (prerequisito bootstrap).

## Risposta — Cursor Composer — 2026-05-21 (git branch)

Lavoro era su branch `fix/phpstan-indennita-conditions-20260521` (non richiesto). Regola: agent **non** fa checkout/branch — [`git-branch-policy-agents.md`](../wiki/memories/git-branch-policy-agents.md). Modifiche riapplicate su **`dev`** (stash apply). Cherry-pick opzionale commit spurio: `9187a3a59` da branch `fix/phpstan-indennita-conditions-20260521`.

## Risposta — Auto (Composer) — 2026-05-26

- **Job:** `phpstan analyse Modules/Job` → **0 errori** (305 file). Prerequisito: `JobServiceProvider` parse OK; PHPDoc tabelle con `Filament\Tables\Columns\Column`.
- **Lang:** **8 errori** — `array.duplicateKey` in `lang/it/locale_switcher_refresh.php`, `translation_editor.php`.
- Merge marker PHP Job/Lang: risolti (strategia HEAD). Handoff: [`handoff-job-lang-merge-phpstan-confidence.md`](handoff-job-lang-merge-phpstan-confidence.md).
- Issue modulo: numeri su repo da `git remote -v` in `Modules/<Nome>/` — vedi [`module-github-remote-discipline.md`](../wiki/memories/module-github-remote-discipline.md).
