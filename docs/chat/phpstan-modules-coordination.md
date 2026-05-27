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

**2026-05-27 (Auto/Composer):** `Questionari` scelto a caso → **0 errori**; esclusi `Pdnd`/`Incentivi`; issue errori solo se count > 0 → commento `provtv/module_questionari_fila5#3`. Prossimi con debito: `Sigma` (~241), `Gdpr` (~16).

**2026-05-27 — Activity:** 16 errori → fix → **0 errori**; issue [#10](https://github.com/provtv/module_activity_fila5/issues/10) chiusa.

**2026-05-27 — Media:** 0 errori (135 file); inventario ex-33 aggiornato; commento `provtv/module_media_fila5#3`.

**2026-05-27 — Notify + Lang (parallelo):** entrambi **0 errori** (412 + 134 file); Lang #11 chiusa; Notify commento #21.

**2026-05-27 — Gdpr:** 16→0 errori; issue [#9](https://github.com/provtv/module_gdpr_fila5/issues/9) chiusa; rimosso listener duplicato `Listeners/GdprRegistrationListener.php`.

**BMAD × PHPStan (canon):** vedi `bashscripts/tools/prompts/phpstan_module.txt` — install `npx bmad-method install`, epic sprint SM, per modulo: `bmad-create-story` → phpstan/gh → `bmad-dev-story` → `bmad-code-review` → wiki. Help: `bmad-help`.

## Per gli altri agenti

1. **Prima di lavorare:** `gh issue list --search "phpstan moduli" --repo provtv/base_ptv_fila5_mono`
2. **Claim modulo:** commento sull’issue meta con modulo scelto + firma agente
3. **Dopo fix:** `phpstan analyse Modules/<Name>/` → 0 errori; aggiorna `laravel/Modules/<Name>/docs/phpstan-*.md` se esiste; commento issue con prove
4. **Non** ignorare errori in `phpstan.neon`; non baseline senza decisione in issue

## Domande aperte

- ~~`static getTableColumns()`~~ — **risolto:** canon `public function` su tutte le `*Table` (2026-05-26); vedi `docs/wiki/concepts/xotbase-table-columns-enforcement.md`.
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


## Risposta - Codex GPT-5 - 2026-05-27

- Esclusi dal controllo: `Pdnd`, `Incentivi`.
- Comando usato da `laravel/`: `./vendor/bin/phpstan analyse -c phpstan.neon --level=max Modules/<Modulo> --no-progress`.
- **DbForge:** 0 errori; remote `origin` = `provtv/module_dbforge_fila5`; nessuna nuova issue errori.
- **MobilitaVolontaria:** 0 errori; issue PHPStan storica `provtv/module_mobilitavolontaria_fila5#3` gia documenta fix completato da altro agente.
- **Setting:** 0 errori; remote `origin` = `provtv/module_setting_fila5`; nessuna nuova issue errori.
- Inventario aggiornato: [`phpstan-modules-inventory.md`](../wiki/memories/phpstan-modules-inventory.md).

**Agente AI:** Codex  
**Modello:** GPT-5
