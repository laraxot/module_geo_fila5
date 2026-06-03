---
title: "Activity Log"
module: "ptvx-project"
---

# Activity Log — ptvx-project

> **Purpose:** Append-only chronological activity record tracking ingests, queries, and lint passes.

## Log Entries

[2026-05-27 18:00:00 UTC] [RULE] `docs/README.md` obbligatorio moduli/temi: creato `Themes/Three/docs/README.md`; regola `theme-module-docs-readme-mandatory.md` + `.cursor/rules/`; trigger map; issue #163.

[2026-05-27 17:30:00 UTC] [FIX] Naming `.md`: rimossi `phpstan-analysis.md` (Activity/Gdpr); memoria `phpstan-module-markdown-naming.md`; trigger map + `phpstan_module.txt`.

[2026-05-27 17:00:00 UTC] [LINT] PHPStan **Media** (135 file): 0 errori; inventario ex-33 corretto.

[2026-05-27 16:30:00 UTC] [LINT] PHPStan **Notify** (412 file) + **Lang** (134 file): già 0 errori; Lang issue #11 chiusa.

[2026-05-27 16:00:00 UTC] [FIX] PHPStan **Gdpr**: 16→0 errori; issue #9 chiusa; listener duplicato rimosso; inventario aggiornato.

[2026-05-27 15:00:00 UTC] [UPDATE] `phpstan_module.txt`: sezione BMAD per agente (install, comandi, campagna PHPStan×BMAD); template issue + chat coordinamento allineati.

[2026-05-27 14:00:00 UTC] [UPDATE] `bashscripts/tools/prompts/phpstan_module.txt`: best/bad practices, false friends, no `--level=` CLI, link verificati, blocco note duplicate rimosso.

[2026-05-27 13:00:00 UTC] [FIX] Campagna PHPStan: prompt `phpstan_module.txt` riscritto; prototipo issue `docs/wiki/_templates/phpstan-module-github-issue.md`; **Activity** 16→0 errori, issue #10 chiusa.

[2026-05-27 12:30:00 UTC] [LINT] PHPStan **Activity** (demo): 16 errori / 129 file; issue [`provtv/module_activity_fila5#10`](https://github.com/provtv/module_activity_fila5/issues/10); inventario aggiornato (non più OK).

[2026-05-27 12:00:00 UTC] [LINT] PHPStan **Questionari** (modulo a caso): 0 errori / 10 file; commento `provtv/module_questionari_fila5#3`, mono #136; inventario [`phpstan-modules-inventory.md`](memories/phpstan-modules-inventory.md).

[2026-05-27 00:00:00 UTC] [UPDATE] PHPStan moduli: verificati `DbForge`, `MobilitaVolontaria`, `Setting` con `phpstan.neon` + `--level=max`, tutti 0 errori; esclusi `Pdnd` e `Incentivi`; aggiornati inventario e chat coordinamento.

[2026-05-26 12:30:00 UTC] [PROCESS] GitHub issue sync: commenti su mono #143 #157-159 #148 #155, Job/Lang/Notify/temi; creata provtv/module_notify_fila5#21.

[2026-05-26 25:00:00 UTC] [UPDATE] Canon Filament `getTableColumns`: solo `public function` (mai static); concept [`xotbase-table-columns-enforcement.md`](concepts/xotbase-table-columns-enforcement.md), §21b `llm-wiki.txt`, `check-get-table-columns-instance.sh`; PHP Job+Notify OK.

[2026-05-26 24:45:00 UTC] [FIX] Git collision **Notify**: 13 SVG (HEAD vs LFS), 6 `*Table.php` (corpo HEAD + `getTableColumns` instance), rimossi `*.php.up`; PHPStan Notify OK; memorie [`merge-collision-filament-table-signature.md`](memories/merge-collision-filament-table-signature.md), [`Notify/.../merge-collision-notify-lessons.md`](../laravel/Modules/Notify/docs/wiki/memories/merge-collision-notify-lessons.md).

[2026-05-26 24:15:00 UTC] [PROCESS] PR Dependabot autonome moduli/temi: §22 `llm-wiki.txt`, how-to [`module-theme-dependabot-pr-autonomy.md`](how-to/module-theme-dependabot-pr-autonomy.md), script `bashscripts/ci/dependabot-merge-module-prs.sh` — sweep ~52 merge OK, ~39 fail (workflow scope / conflitti); Lang vite #10 mergiata su laraxot.

[2026-05-26 23:45:00 UTC] [PROCESS] Issue GitHub moduli/temi: batch 32 meta + 34 discussione ridondanza (`git remote -v`); commenti Job/Lang/Xot; how-to [`module-theme-github-issues.md`](how-to/module-theme-github-issues.md), manifest chat, §21 `llm-wiki.txt`.

[2026-05-26 23:00:00 UTC] [UPDATE] Second brain checkpoint sessione Job/Lang: handoff [`docs/chat/handoff-job-lang-merge-phpstan-confidence.md`](../chat/handoff-job-lang-merge-phpstan-confidence.md), memoria [`module-github-remote-discipline.md`](memories/module-github-remote-discipline.md), inventario PHPStan aggiornato; Job `wiki/memories/session-confidence-checkpoint.md`.

[2026-05-26 22:15:00 UTC] [UPDATE] Git collision PHP Job/Lang: 14 file risolti con strategia HEAD/current; `git grep` su `*.php` pulito; issue [#143](https://github.com/provtv/base_ptv_fila5_mono/issues/143).

[2026-05-26 00:50:00 UTC] [UPDATE] Standard release moduli/temi: propagati semantic-release workflow, releaserc, changelog, README marketing e docs locali; issue #153.

[2026-05-26 00:45:00 UTC] [UPDATE] Protocollo massima confidenza agente: regola root, memoria, trigger map e stub nei docs di moduli/temi.

[2026-05-26 00:40:00 UTC] [UPDATE] Regola stile agenti: risposte sempre in italiano, sintetiche e concise; aggiornata trigger map, memoria e stub agenti.

[2026-05-26 21:30:00 UTC] [PROCESS] **Git merge debris / collisioni**: sweep `docs/raw/history/*.md`, ripristino `docs/.php_cs.dist.php`, `docs/phpstan.neon.dist`, `docs/phpunit.xml.dist`; consolidamento `Modules/Xot/docs/filament/infinite-loop-getstepbyname-fix*.md`; how-to [`git-merge-marker-sweep`](how-to/git-merge-marker-sweep.md); Trigger Map + second brain operating model aggiornati.

[2026-05-26 18:00:00 UTC] [UPDATE] Trigger Map: riga canonica **BOOTSTRAP SESSIONE AGENTE**, «Contratto automatico», Enforcement rinforzato; stub `AGENTS.md`/`CLAUDE.md`; INDEX rules; disciplina autocompact agganciata al routing.

[2026-05-26 00:20:00 UTC] [UPDATE] MCP portability: rimossi path assoluti workspace da `.cursor/mcp.json` e `.mcp.json`; aggiunto trigger map per config MCP non portabile e regola `${workspaceFolder}` in context-mode setup.

[2026-05-26 16:45:00 UTC] [PROCESS] Autocompact thrashing: how-to unificato `docs/wiki/how-to/autocompact-thrashing-recovery.md`, redirect `kilo-autocompact-…`, stub `agent-edit-discipline` (39 pacchetti), rule `cursor-context-discipline.mdc`, trigger map; fonti esterne forum Cursor + vexp. [UPDATE] Autocompact thrashing: creata issue #138, aggiunto playbook root, trigger map, memoria compaction, guardrail GitHub issue e puntatori DRY negli `agent-edit-discipline.md` di moduli e temi.

[2026-05-26 15:30:00 UTC] [PROCESS] Rafforzata disciplina **issue GitHub obbligatoria** (anche task solo-docs): blocchi in `.cursor/rules/cursor-context-discipline.mdc`, `.cursor/rules/markdown-documentation-standard.mdc`; link in `AGENTS.md`/`CLAUDE.md`; how-to aggiornato; audit comment su issue `#124`; regola Markdown checklist `gh`.

[2026-05-21 14:00:00 UTC] [UPDATE] Rimosso `.local/mariadb-install/` dall’indice git (~125MB deb/binari); aggiunto `.local/` a `.gitignore`. Install offline: `bashscripts/tools/lamp/`.

[2026-05-26 10:00:00 UTC] [UPDATE] Finalizzato e reso **MANDATORIO** lo standard `markdown-documentation-standard.md` (HackerNoon Tip 020). Applicata rinomina file non conformi (`philosophy-and-ethics.md`), aggiornato `GEMINI.md` root. Audit trail: **issue #139**.

[2026-05-21 23:00:00 UTC] [DOCS] Filament **v5** canonico: `filament-version-policy.md`, `filament-version.md` in ogni modulo/tema, second-brain aggiornati, llm-wiki false friend, trigger map; doc v4 etichettati storico.

[2026-05-21 22:00:00 UTC] [UPDATE] Policy git branch agenti: `docs/wiki/memories/git-branch-policy-agents.md`; lavoro PHPStan/docs riportato su `dev` da branch spurio `fix/phpstan-indennita-conditions-20260521` (cherry-pick + stash pop).

[2026-05-21 12:00:00 UTC] [LINT] Campagna deduplica docs moduli/temi: script `bashscripts/tools/dedup_module_docs.py` — ~2807 delete, ~349 stub html2pdf/wiki, canonici Media (html2pdf) e Xot (wiki/concepts). How-to: `docs/wiki/how-to/module-docs-deduplication.md`. Issue #124.

### Format

```text
[YYYY-MM-DD HH:MM:SS UTC] [OPERATION] Description
```

**Operations:**

- `INGEST` — Added raw document to wiki
- `QUERY` — Answered question from wiki
- `LINT` — Maintained wiki quality
- `UPDATE` — Modified existing wiki page
- `CREATE` — Created new wiki structure or tool

---

[2026-04-15 00:00:00 UTC] [INGEST] Added module structure documentation
[2026-04-15 00:00:00 UTC] [INGEST] Added actions over services documentation
[2026-04-15 00:00:00 UTC] [INGEST] Added accessor auto-persistence pattern
[2026-04-28 00:00:00 UTC] [INGEST] Added second brain operating model for project-level documentation
[2026-04-28 00:00:00 UTC] [INGEST] Added source summary for docs landscape across modules and themes
[2026-04-28 00:00:00 UTC] [INGEST] Added architecture guardrails from root docs/architecture sources
[2026-04-28 00:00:00 UTC] [INGEST] Added AI tooling workflow from root docs/ai sources
[2026-04-28 00:00:00 UTC] [INGEST] Added BMAD operating model from root docs/bmad sources
[2026-04-29 00:00:00 UTC] [UPDATE] Refined second brain operating model with actionability, compression, and discoverability rules
[2026-04-29 00:00:00 UTC] [INGEST] Added continuous-improvement playbook for root, module, and theme documentation maintenance
[2026-04-29 09:09:00 UTC] [CREATE] Story 1-4: second-brain-efficiency-optimization
[2026-04-29 00:00:00 UTC] [INGEST] Added reusable second-brain audit checks concept and local audit tool for wiki health
[2026-04-29 09:19:00 UTC] [RESEARCH] Ingested external second-brain benchmarks and mapped them to repository operations
[2026-04-29 09:19:00 UTC] [CREATE] Story 1-5: second-brain-internet-research-and-federated-docs-updates
[2026-04-29 09:19:00 UTC] [UPDATE] Extended continuous-improvement model with /bmad-create-story integration and external benchmark policy
[2026-04-29 09:44:00 UTC] [UPDATE] Added execution checkpoints to enforce continuous docs improvement across root/module/theme
[2026-04-29 10:32:00 UTC] [UPDATE] Closed Story 1-5 as done and added federated pilot anchors
[2026-04-29 10:33:00 UTC] [INGEST] Added second-brain maintenance cadence concept with daily/weekly/monthly rhythm
[2026-04-29 10:33:00 UTC] [CREATE] Story 1-6: second-brain-maintenance-cadence-and-audit-rhythm
[2026-04-29 10:33:00 UTC] [UPDATE] Linked cadence concept into continuous-improvement and audit-checks pages
[2026-04-29 11:55:00 UTC] [INGEST] Installed and configured Token Optimizer MCP
[2026-04-29 12:15:00 UTC] [INGEST] Added context-mode-plugin concept documentation
[2026-04-29 12:18:00 UTC] [INGEST] Added context-mode-cli-reference guide
[2026-04-29 12:20:00 UTC] [INGEST] Added how-to guide for indexing module documentation
[2026-04-29 12:22:00 UTC] [INGEST] Created module-context-mode-integration.md template
[2026-04-29 12:25:00 UTC] [INGEST] Added how-to guide for using wiki templates
[2026-04-29 13:05:00 UTC] [INGEST] Documented official Kilo large-project guidance
[2026-04-29 13:18:00 UTC] [UPDATE] Added explicit repository policy to disable Kilo managed indexing
[2026-04-29 14:00:00 UTC] [CREATE] Story 2.1: QMD Search Integration
[2026-04-29 14:15:00 UTC] [INGEST] Added qmd-indexing-manifest.md
[2026-04-29 14:30:00 UTC] [CREATE] bashscripts/wiki-search CLI tool
[2026-04-29 14:45:00 UTC] [INGEST] Added wiki-search-guide.md
[2026-04-29 15:00:00 UTC] [CREATE] bashscripts/wiki-relations helper script
[2026-04-29 15:15:00 UTC] [INGEST] Added semantic-search-and-related-pages.md
[2026-04-29 15:30:00 UTC] [UPDATE] Enhanced wiki-search with --related flag
[2026-04-29 15:45:00 UTC] [UPDATE] Reorganized wiki/index.md with categorized how-to guides
[2026-04-29 16:00:00 UTC] [CREATE] Task 4: Performance Optimization
[2026-04-29 16:15:00 UTC] [CREATE] docs/scripts/wiki/benchmark-search.sh
[2026-04-29 16:30:00 UTC] [CREATE] docs/scripts/wiki/cache-manager.sh
[2026-04-29 16:45:00 UTC] [INGEST] Added wiki-search-performance.md
[2026-04-29 17:00:00 UTC] [UPDATE] Updated wiki/index.md with performance guide
[2026-04-29 17:15:00 UTC] [CREATE] Task 5: Accessibility & UX
[2026-04-29 17:30:00 UTC] [CREATE] docs/scripts/wiki/accessible-search.sh
[2026-04-29 17:45:00 UTC] [INGEST] Added wiki-search-accessibility.md
[2026-04-29 18:00:00 UTC] [UPDATE] Updated wiki/index.md with accessibility guide
[2026-04-29 18:15:00 UTC] [CREATE] Task 6: Testing Suite
[2026-04-29 18:30:00 UTC] [CREATE] docs/scripts/wiki/test-suite.sh
[2026-04-29 18:45:00 UTC] [CREATE] Task 7: Documentation and Finalization
[2026-04-29 19:00:00 UTC] [CREATE] docs/wiki/how-to/wiki-search-troubleshooting.md
[2026-04-29 19:15:00 UTC] [UPDATE] Updated wiki/index.md with troubleshooting guide
[2026-04-29 19:30:00 UTC] [INGEST] Prepared Kilo local indexing prerequisites
[2026-04-29 19:35:00 UTC] [CREATE] Story 2.2: Bidirectional Cross-Referencing
[2026-04-29 19:35:00 UTC] [UPDATE] Updated sprint-status.yaml for Story 2.2
[2026-04-29 19:40:00 UTC] [CREATE] Story 2.3: Automated Wiki Generation
[2026-04-29 19:40:00 UTC] [UPDATE] Updated sprint-status.yaml for Story 2.3
[2026-04-29 20:00:00 UTC] [CREATE] Task 2 Execution - Story 2.2: Wiki → Code Reference Resolution
[2026-04-29 20:05:00 UTC] [CREATE] docs/scripts/wiki/wiki-reference-generator.sh
[2026-04-29 20:10:00 UTC] [UPDATE] Added references field to concept pages
[2026-04-29 20:15:00 UTC] [UPDATE] Documented Kilo indexing boundary
[2026-04-29 20:25:00 UTC] [CREATE] docs/scripts/wiki/wiki-link-renderer.sh
[2026-04-29 20:30:00 UTC] [UPDATE] Fixed YAML parser in wiki-link-renderer.sh
[2026-04-29 20:35:00 UTC] [UPDATE] Fixed malformed frontmatter in actions-over-services.md
[2026-04-29 20:40:00 UTC] [UPDATE] Added module references to module-wiki-documentation.md
[2026-04-29 20:45:00 UTC] [VALIDATION] Tested wiki-link-renderer.sh on all Priority 1 pages
[2026-05-12 00:00:00 UTC] [UPDATE] Aligned wiki to LLM Wiki On-Demand Knowledge Pattern — created rules/, skills/, commands/, memories/, agents/ directories with INDEX files and 00-TRIGGER_MAP.md; resolved merge conflicts in index.md and log.md
[2026-05-12 09:18:00 UTC] [CREATE] docs/wiki/concepts/llm-wiki-operational-discipline.md — canonical operational rules for LLM wiki pattern (token budget, cache discipline, git policy, bad practices)
[2026-05-12 09:18:00 UTC] [UPDATE] docs/wiki/concepts/INDEX.md — added llm-wiki-operational-discipline entry
[2026-05-12 09:18:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — added triggers: llm-wiki discipline, git policy, cache discipline, bootstrap stub size, Laravel upgrade, accessor/mutator
[2026-05-12 09:18:00 UTC] [CREATE] bashscripts/docs/wiki/{rules,skills,commands,memories,concepts}/INDEX.md — tooling wiki INDEX files per §8 of on-demand pattern
[2026-05-12 09:18:00 UTC] [UPDATE] CLAUDE.md — replaced embedded rules with ≤50-line stub-only pointing to wiki (on-demand pattern compliant)

[2026-05-12 09:31:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — aggiunto trigger Filament ->label()/traduzioni, Filament class extension/XotBase, Filament resource/page/widget
[2026-05-12 09:31:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — aggiunto filament-rules-summary, xotbase-critical-rules, schema-conventions, ai-guidelines

**Last Activity:** 2026-05-12 10:32:00 UTC  
[2026-05-12 09:58:00 UTC] [CREATE] docs/wiki/rules/filament-resource-property.md — regola `$resource` è `protected static string` non `public static`; auto-resolve in XotBaseListRecords via namespace
[2026-05-12 09:58:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — aggiunto trigger `$resource property`, `XotBaseListRecords auto-resolve`, `skill crea filament page`
[2026-05-12 09:58:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — aggiunto filament-resource-property
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Xot/docs/wiki/rules/INDEX.md — upgrade frontmatter + link regole Filament
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Activity/docs/wiki/rules/INDEX.md — upgrade frontmatter + link xotbase-resource-zen-pattern
[2026-05-12 09:58:00 UTC] [CREATE] laravel/Modules/Xot/docs/wiki/skills/filament-page-creation.md — skill on-demand: crea ListRecords/Create/Edit/View con XotBase
[2026-05-12 09:58:00 UTC] [UPDATE] laravel/Modules/Xot/docs/wiki/skills/INDEX.md — upgrade frontmatter + aggiunto filament-page-creation skill
[2026-05-12 10:15:00 UTC] [LINT] Corretto `protected static string $resource` nella documentazione modulo/tema, risolti marker di merge nel wiki Theme One e aggiunti ingressi on-demand a rules/skills per i temi
[2026-05-12 10:19:00 UTC] [UPDATE] Migliorata l'indicizzazione on-demand dei moduli core: `User` e `Lang` ora espongono regole/skill reali; `Activity` e `Rating` mostrano meglio pattern locali e skill condivise; `docs/wiki/rules/00-TRIGGER_MAP.md` collegato ai nuovi entrypoint modulo-specifici
[2026-05-12 10:32:00 UTC] [UPDATE] Hardening definitivo del contesto OpenCode: installato plugin globale `@tarquinen/opencode-dcp@latest`, aggiunto `opencode.json` al git root con compaction esplicita e watcher ignore, documentato il fix in bashscripts/Xot/temi e corretta la memoria che indicava erroneamente `laravel/opencode.json`
**Total Operations:** 78
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/context-budget.md — max lines per tool response, never-read file list
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/no-bulk-reads.md — forbidden bulk read patterns
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/tool-output-compression.md — PHPStan/git/composer output compression
[2026-05-12 10:24:00 UTC] [CREATE] .windsurf/rules/session-discipline.md — bootstrap, overflow recovery, session split protocol
[2026-05-12 10:24:00 UTC] [CREATE] docs/wiki/rules/context-overflow-prevention.md — canonical rule 262K token prevention
[2026-05-12 10:24:00 UTC] [UPDATE] docs/wiki/rules/00-TRIGGER_MAP.md — context overflow triggers
[2026-05-12 10:24:00 UTC] [UPDATE] docs/wiki/rules/INDEX.md — context-overflow-prevention entry
[2026-05-12 10:24:00 UTC] [UPDATE] 12× module/theme wiki/rules/INDEX.md — context-overflow-prevention propagated
[2026-05-12 10:24:00 UTC] [UPDATE] .gitignore — !.windsurf/rules/*.md tracked

[2026-05-12 10:35:00 UTC] [LINT] Verified workspace against LLM Wiki on-demand pattern. Removed forbidden .cache/ and redundant node_modules in .agents/. Renamed root .md files and docs/ folders to comply with lowercase kebab-case standards. Updated docs/roadmap.md.

**Total Operations:** 88

[2026-05-19 12:00:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — estesi best/bad practices e false friends; tabella link verificati ripartita per sezione; rimosso riferimento a `compression-levels.md` inesistente (mirror in `llm-wiki-operational-discipline.md` / `on-demand-pattern.md`); check stub include `AGENTS.md`; trigger namespace allineato a `docs/wiki/rules/laraxot-module-namespace.md`

**Total Operations:** 89

[2026-05-19 11:35:00 UTC] [LINT] Ripristino integrità `bashscripts/tools/prompts/llm-wiki.txt` (rimosso prefisso tabellare accidentale e coda spuria); link verificati corretti (`bashscripts/ai/rules/context-compression-discipline.md`); bad/false friends estesi; check QMD cache allineato a `~/.cache/qmd` OR `qmd-cache`; rimosso `bashscripts/ai/.agents/node_modules`, aggiunto `node_modules/` a `.agents/.gitignore`; `verify-llm-wiki.sh`: stub `AGENTS.md` ≤50 righe, gate QMD cache duale — verify **0 failed**

**Total Operations:** 90

[2026-05-19 14:30:00 UTC] [LINT] Normalized wiki naming convention to kebab-case; renamed duplicates in rules/ to .old.
[2026-05-19 14:35:00 UTC] [UPDATE] Moved root wiki files to concepts/ and how-to/ subdirectories; updated main index.md.
[2026-05-19 14:40:00 UTC] [UPDATE] Refactored 00-TRIGGER_MAP.md with categorized triggers and improved discoverability.

[2026-05-19 12:15:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — workflow GitHub (`gh` + repo `provtv/base_ptv_fila5_mono`, `has_wiki=false` verificato via API), `./docs/chat/` operativo, cache QMD duale, tab deep-link Filament/context-mode; §17 privata di path non presenti nel tree; nuove §18–§20 troubleshooting/routing/health; checklist chiusura task; allineamento issue #122/#123

[2026-05-19 13:10:00 UTC] [LINT] Rimossi da git file debris merge/sync (`*.md~head` in Notify e Media docs, `Notify/.phive~laraxot_dev`); aggiunti ignore `*~HEAD` e `*~head` in `.gitignore` root e `laravel/Modules/Notify/.gitignore`; `laravel/Modules/Media/docs/.gitignore` ignora `wiki/_archive/`; aggiornato `bashscripts/tools/prompts/llm-wiki.txt` (§7 debris + vietato `_archive` sotto `docs/wiki/`, §11–§12, §14 find).

[2026-05-19 15:10:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — rimosso prefisso tabellare orfano; §3.1 «Reality discipline»: nessun read-only assoluto, convenzioni ≠ invarianti; workflow chiarito (subset QMD); §11 riga `docs/raw/`; §12 nuove false friends (raw read-only, agent isole, reverifica); §15 iterazione prompt; `docs/wiki/concepts/llm-wiki-operational-discipline.md` mirror breve + link relativo al prompt.

[2026-05-19 16:30:00 UTC] [LINT] Blocco ignore debris merge (`*~HEAD`, `*~BASE`, …, `*~head`) in ogni `laravel/Modules/<Name>/.gitignore` e `laravel/Themes/<Name>/.gitignore`, più `laravel/.gitignore`; header Notify allineato al commento canonico; `bashscripts/tools/prompts/llm-wiki.txt` §7 (policy + perché duplicare), §11, §12 false friend, §15 nuovi package.

[2026-05-19 17:00:00 UTC] [LINT] `bashscripts/tools/prompts/llm-wiki.txt` — rimossa coda spuria (messaggio utente incollato dopo footer); aggiunta §7.1 blocco `.gitignore` canonico copiabile; checklist §20 per nuovi package; verifica: tutti i `laravel/Modules/*/.gitignore` e `laravel/Themes/*/.gitignore` contengono già il blocco debris.

[2026-05-19 18:15:00 UTC] [UPDATE] Second brain: espanso `sources/second-brain-external-benchmarks.md` (link esterni Karpathy / Obsidian / PARA / IT / critiche / tooling); aggiornati `concepts/second-brain-operating-model.md`, `how-to/module-wiki-documentation.md`, `how-to/theme-wiki-documentation.md`, `concepts/second-brain.md`; `bashscripts/tools/prompts/llm-wiki.txt` §1.1 tre strati, verified links, false friend Obsidian; rimossa altra coda spuria dal prompt.

[2026-05-19 19:00:00 UTC] [CREATE] `docs/second-brain.md` puntatore in ogni `laravel/Modules/<Name>/docs/` e `laravel/Themes/<Name>/docs/` (link relativi alla wiki root); rimossi 48 stub erronei creati sotto path `docs` annidati/non canonici; benchmark esterni: secondo articolo MindStudio (`codeex`); how-to modulo/tema aggiornati.

**Total Operations:** 98

[2026-05-19 20:30:00 UTC] [UPDATE] Cursor/OpenCode compaction: aggiunta `.cursor/rules/compaction-recovery.mdc` (recovery + prevenzione); sezione wiki «Compaction exhausted» in `docs/wiki/concepts/context-overflow-prevention.md`; trigger map e `docs/wiki/rules/context-overflow-prevention.md` puntano alla narrativa canonica; `opencode.json` `compaction.reserved` 40000→56000; `npm install -g context-mode@latest` eseguito sul workspace host.

**Total Operations:** 99

[2026-05-19 21:45:00 UTC] [UPDATE] Disciplina edit: mutex `file.ext.lock` affiancato + pipeline PHPStan / PHPMD (`laravel/tools/phpmd.sh`) / PHPInsights (`laravel/tools/phpinsights.sh`) / Playwright+Puppeteer globali per UI — `docs/wiki/rules/validation-post-edit-rule.md`; `.cursor/rules/file-locking-mandatory.mdc`; `bashscripts/tools/prompts/llm-wiki.txt` §2.1; `docs/wiki/concepts/llm-wiki-operational-discipline.md`; trigger map; `.gitignore` eccezione `!.cursor/rules/**` per versionare le `.mdc`.

**Total Operations:** 100

[2026-05-19 22:30:00 UTC] [UPDATE] GitHub issue `https://github.com/provtv/base_ptv_fila5_mono/issues/124` come audit trail (ragionamenti agent); how-to `docs/wiki/how-to/github-issue-agent-discipline.md`; stub `agent-edit-discipline.md` in 39 cartelle `docs` modulo/tema (+ `Legge104/app/docs`); aggiornati `validation-post-edit-rule.md`, `second-brain-operating-model.md`, how-to modulo/tema, `laravel/Modules/Xot/docs/file-locking-pattern.md` con puntatore canonico; trigger map; commento `gh` su MCP; `llm-wiki.txt` verified link.

**Total Operations:** 101

[2026-05-19 10:40:00 UTC] [CREATE] `docs/chat/2026-05-19-agent-edit-discipline-confronto.md` — confronto obbligatorio tra agenti (anchor `#124`); `llm-wiki.txt` §10 Inter-Agent Collaboration reso esplicito (lettura chat ad avvio task + scrittura dopo decisioni condivise); commento `gh` su #124.

**Total Operations:** 102

[2026-05-19 23:15:00 UTC] [CREATE] FASE 3–5 (issue #123): +9 trigger in `00-TRIGGER_MAP.md`; atomic pages `git-atomic-operations`, `rule-atomicity`, `memory-system-usage`, `skill-discovery`; riscritto `concepts/context-mode-usage.md`; `skills/INDEX.md` strutturato (process/implementation/domain/maintenance); fix wikilink in `memories/environment-verification.md`; rimosso debris `bashscripts/ai/.agents/settings.json.orig` (untracked).

**Total Operations:** 102

[2026-05-19 23:45:00 UTC] [UPDATE] `docs/chat/`: naming **`slug-argomento.md`** (kebab-case); file `agent-edit-discipline.md`, `llm-wiki-hardening.md` (merge ex `cursor-sync`), `gemini-cli.md`; rimossi `2026-05-19-*.md`; `llm-wiki.txt` §10 + checklist §20; `github-issue-agent-discipline.md`; commento `gh` su #124.

**Total Operations:** 103

[2026-05-20 00:10:00 UTC] [UPDATE] `bashscripts/tools/prompts/llm-wiki.txt` — § GitHub (commento issue + path `docs/chat/<slug>.md`); nuova sottosezione «Inter-Agent + GitHub — integrazione»; false friend issue-vs-chat; troubleshooting multi-agente.

**Total Operations:** 104

[2026-05-20 00:35:00 UTC] [CREATE] FASE 6–8 (#123): 12 memories root + INDEX; `llm-wiki.txt` +9 false friends, verified links, bad practices; `how-to/wikilink-cross-reference.md`; trigger map (compaction, wikilink); `docs/chat/llm-wiki-hardening.md`; puntatore Xot memories → root.

**Total Operations:** 105

[2026-05-20 01:00:00 UTC] [UPDATE] Wikilink batch: cluster second-brain + ProjectHome + sources chiave → path relativi; rimosso `bashscripts/ai/.agents/node_modules` (gate); chiusura issue #122/#123.

**Total Operations:** 106

[2026-05-20 00:45:00 UTC] [FIX] Cursor compaction: `laravel/.cursor/rules/laravel-boost.mdc` monolite ~143k righe → stub + backup `laravel/.cursor/laravel-boost-guidelines.FULL.mdc.bak`; `.cursor/rules/cursor-context-discipline.mdc` (merge compaction + lock); wiki/memories/trigger/llm-wiki/Xot/Sigma aggiornati.

**Total Operations:** 106

[2026-05-20 12:00:00 UTC] [CREATE] Standard minimo `.md` da HackerNoon Tip 020: `docs/wiki/concepts/markdown-note-minimum-standard.md`; integrati `second-brain-operating-model.md`, benchmarks esterni, trigger map, `llm-wiki.txt` §1.2 + checklist + quick ref; ripulito prompt da righe spurie in coda.

**Total Operations:** 107

[2026-05-20 13:00:00 UTC] [UPDATE] Rafforzato Tip 020: PARA mapping, good/bad table, checklist agent; frontmatter how-to modulo/tema; memory `markdown-hackernoon-tip-020`; audit checks; `docs-template-standard` YAML header; `llm-wiki.txt` §10 + false friends.

**Total Operations:** 108

[2026-05-20 14:00:00 UTC] [FIX] API 131072 overflow: `laravel/AGENTS.md`/`CLAUDE.md` monoliti → stub; backup `*.embedded-rules.FULL.md.bak`; gate laravel stubs; `context-mode` in `.mcp.json`; wiki/how-to aggiornato; `llm-wiki.txt` §17.

**Total Operations:** 109

[2026-05-20 14:30:00 UTC] [CREATE] Playbook errore API limite **131072** token vs payload (~796k): `docs/wiki/how-to/api-context-length-exceeded-131072.md`; `context-overflow-prevention.md` + `context-compression-mcp-setup.md` + trigger map; `docs/chat/context-api-131072-overflow.md`; issue GitHub dedicata; ampliato `llm-wiki.txt` §5/§17/§18.

**Total Operations:** 110

[2026-05-20 15:00:00 UTC] [CREATE] MCP minimum stack obbligatorio (5): `.mcp.json`, `.cursor/mcp.json`, `docs/wiki/_templates/mcp-minimum-stack.json`, `how-to/mcp-minimum-stack.md`; gate `verify-llm-wiki.sh` sezione MCP; `llm-wiki.txt` §17 + checklist §20.

**Total Operations:** 111

[2026-05-21 00:00:00 UTC] [UPDATE] MCP stack: `laravel-boost` usa `php` su PATH (non path fisso php8.3) in `.mcp.json`, `.cursor/mcp.json`, template, `laravel/.mcp.json`; gate `verify-llm-wiki.sh` controlla `php`; `llm-wiki.txt` §17 + quick ref MCP.

**Total Operations:** 112

[2026-05-19 11:02:00 UTC] [UPDATE] `llm-wiki.txt`: fix typo `npm install -g context-mode playwright /test puppeteer` → `@playwright/test`; §13 verified links aggiunto MCP minimum stack (`how-to/mcp-minimum-stack.md` + template); §17 `laravel-boost` label semplificato, `php laravel/artisan list`; §20 checklist voce MCP minimi. Gate verify-llm-wiki.sh: 39/39 ✅.

[2026-05-19 13:09:00 UTC] [LINT] Housekeeping `docs/wiki/`: rimossi 7 orphan `.lock` (crash agent precedenti) e 9 file `.old` stale (SCHEMA, CONTEXT_MODE_SETUP, second-brain-implementation, second_brain, laravel-13-upgrade-*, namespace-rules, namespace_conventions, naming_conventions). Git history preserva i contenuti. Gate `verify-llm-wiki.sh` 39/39 ✅.

**Total Operations:** 114

[2026-05-21 12:00:00 UTC] [UPDATE] GitHub issue proattive: policy in `docs/wiki/how-to/github-issue-agent-discipline.md`, memory `docs/wiki/memories/github-issues-proactive.md`, `second-brain-operating-model.md` regola 6, trigger map, `llm-wiki.txt` § GitHub + bad practice + checklist §20; issue #129 (CI lock orfani), #130 (pre-commit PHP); chiusa #128 (compaction/context-mode).

**Total Operations:** 115

[2026-05-21 14:00:00 UTC] [FIX] `spatie/laravel-model-states` 2.14.1 in `Modules/Xot` + `php ^8.4` root/Xot; runtime `php8.4` (8.4 già su host, ext=allineate); PHPStan OK `XotBaseTransition`; memory `spatie-model-states-php84.md`; playbook `llm-wiki.txt`; matrix Xot aggiornata; issue #131.

**Total Operations:** 116

[2026-05-21 15:00:00 UTC] [UPDATE] Passaggio MySQL→MariaDB: `bashscripts/mysql/switch-to-mariadb.sh`, how-to `docs/wiki/how-to/switch-mysql-to-mariadb.md`; `XotBaseMigration` accetta driver `mariadb`; `.env.example` blocco locale; trigger map.

**Total Operations:** 117

[2026-05-21 16:00:00 UTC] [CREATE] LAMP MariaDB: `bashscripts/tools/lamp/` (install-mariadb, check-mariadb, php extensions, laravel-env example); `bashscripts/docs/mariadb-laravel.md`, `ubuntu/lamp.md`; `install-mariadb-system.sh` crea DB Laravel; `db/check_mariadb.sh`; wsl/setup banner MariaDB.

**Total Operations:** 118

## [2026-05-27] bmad | BMAD Method v6 project-level on-demand install
- Installato BMAD Method v6.0.2 da `aj-geddes/claude-code-bmad-skills` commit `b5c6403847b32f0facc95943a1aa837c96de31af`.
- Installazione locale progetto: `.claude/skills/bmad/`, `.claude/commands/bmad/`, `.claude/config/bmad/`.
- Aggiunti routing wiki on-demand: `docs/wiki/rules/bmad-v6-on-demand.md`, `docs/wiki/commands/bmad-v6.md`, `docs/wiki/skills/INDEX.md`.
- Aggiornati `docs/wiki/rules/00-TRIGGER_MAP.md`, `docs/wiki/rules/INDEX.md`, `docs/wiki/commands/INDEX.md`.
