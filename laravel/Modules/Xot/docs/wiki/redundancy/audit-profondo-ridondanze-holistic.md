---
title: "audit olistico ridondanze — codice, nomi file, Markdown"
type: redundancy
owner: Modules/Xot
severity: informational
confidence: medium
created: 2026-05-25
updated: 2026-05-25
tags: [redundancy, documentation-debt, static-analysis, dry]
related:
  - ../concepts/ridondanze-cross-cutting-codebase.md
  - ../concepts/redundancy-catalog.md
  - ./byte-identical-files-static-scan.md
  - ../../../../../Themes/Sixteen/docs/wiki/redundancy/duplicated-blade-blocks.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/90"
---

# Audit olistico ridondanze (second brain ↔ codice)

## Scopo di business

Ridondanza non è solo “righe ripetute”: è **moltiplicatore del costo del cambio** (bugfix, compliance, onboarding). Qui si classificano osservabilità trasversali del monorepo `laravel/Modules/*` + `laravel/Themes/*` per guidare refactoring **prioritizzati**, senza falsi positivi dovuti alla sola nomenclatura (es. `auth.php` i18n uguale in ogni lingua).

Questa pagina **non** duplica gli inventari per-class; rimanda alla tabella delle schede atomiche in [`redundancy-catalog.md`](../concepts/redundancy-catalog.md).

## 1. File identici (SHA256): riesame 2026-05-25

**Metodo** (riproducibile): hash SHA256 contenuto-file; raggruppamento chiave `(size, hash)`; path sotto `laravel/Modules/*` e `laravel/Themes/*`; esclusi `vendor/`, `node_modules/`, **`/tests/`**.

| Estensione | Definizione | Gruppi con ≥2 file identici | Gruppi cross-owner* |
|-----------|-------------|----------------------------|---------------------|
| `.php` (senza `.blade`) | Solo PHP backend non-Blade | **247** | **17** |
| `.blade.php` | Sole viste Blade | **179** | **53** |

\* *cross-owner*: almeno due owner distinti (nome modulo Laravel o nome tema).

**Interpretazione**:

- **`53` gruppi Blade cross-owner** coincidono con la baseline pubblicata nel 2026-05-23 in [`byte-identical-files-static-scan.md`](./byte-identical-files-static-scan.md) — segnale che la porzione Blade più “critica” (copy tra moduli/temi) è **stabile** nel tempo mentre il tree evolve.
- I **numeri pubblicati come `431` gruppi `.php`** storici includevano probabilmente anche file non più presenti nel tree o uno script con criterio leggermente diverso; con la definizione attuale *`.php` esclusi Blade* otteniamo **`247`** (vedi anche tabella storica nella pagina dello scan per confronto trasparente).

Per pattern concreti (route stub Filament dashboard, toolchain `phpstan_constants.php`, clock widget Job/Geo/Xot, placeholder tema Sixteen↔TwentyOne): [`byte-identical-files-static-scan.md`](./byte-identical-files-static-scan.md).

## 2. Omonimi file ad alto volume (“rumore nominale” vs “vera” ridondanza)

Conteggio basename ripetuti su **PHP + Blade**, esclusi test/vendor/node_modules (`find … | awk` su `NF`):

- `auth.php`, `validation.php`, `pagination.php`: decine/hundreds di occorrenze — nella maggior parte dei casi **scaffold lingua** Laravel per locale; ripetizione *attesa*.
- **`dashboard.blade.php`**, **`item.blade.php`**, **`v1.blade.php`**, **`.php-cs-fixer*.php`**, **`phpstan_constants.php`**: alta frequenza; solo una parte è byte-identica — combinare sempre con **checksum** prima di proporre refactor.

Serve per evitare allarmi ingest QMD/memorie basati sul solo nomefile.

## 3. Debito sintattico: marker Git dentro Markdown (`<<<<<<<`)

I file `.md` con conflitto non mergiato sono **documentation-killer**: tooling markdown, ingestion automatica wiki e fuzzy search restituiscono **duplice verità incompilabile**.

Situazione osservata 2026-05-25 (ordine decrescente per numero di blocchi **`<<<<<<<` per file**, limite sintetico):

| Modulo / area | Esempi (non esaustivi) |
|---------------|------------------------|
| **Activity/docs** | `filament-5-nested-resources-complete-guide.md`, `anti-pattern-model-env-hack.md`, più file archive/roadmap/guide |
| **Xot/docs/wiki** | **Ripuliti**: `ridondanze-cross-cutting-codebase.md`, `redundancy-catalog.md`, `log.md` durante questo audit |
| **UI/docs** | `wiki/index.md`, `structure.md`, `architecture/structure.md`, `raw/index.md` |
| Altri | Notify `docs/redundancy-report.md`, Lang `wiki/README.md`, … |

**Azione suggerita (modulo-owner):** triage modulo-per-modulo, scegliere versione prose “viva”, eliminare marker, poi `qmd`/ingest ripetibile. Non è refactoring codice PHP ma **igiene del second brain**.

## 4. Ridondanza *semantica* (stesso comportamento, file diversi)

Esempi già schedulati (linkare, non ricopiare qui):

| Area | Lettura canonica |
|------|-------------------|
| Fixcity ticket | [`fixcity-cross-module-duplicate-surfaces.md`](../../../../Fixcity/docs/wiki/redundancy/fixcity-cross-module-duplicate-surfaces.md) · [`duplicated-comments-relation-manager.md`](../../../../Fixcity/docs/wiki/redundancy/duplicated-comments-relation-manager.md) · [`Fixcity/docs/redundancy-report.md`](../../../../Fixcity/docs/redundancy-report.md) |
| Block Blade cross-moduli | [`duplicated-blade-blocks.md`](../../../../../Themes/Sixteen/docs/wiki/redundancy/duplicated-blade-blocks.md) |
| Wizard doc slice Sixteen↔Fixcity↔Xot | [`ridondanze-documentazione-wizard.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md) → map [`wizard-parity-documentation-map.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md) |
| Passport / widget auth multipli modulo User | vedi catalogo |

## 5. Principi anti-rimozione falsi positivi

- **Scaffold toolchain** ripetuto (Rector/PHPStan bridge) può essere *accettabile* se la policy cambia sempre in modo **atomico** su tutti i moduli documentato in root/bashscripts — altrimenti è debito da symlinks o codegen.
- **Doc many-small-files** wizard/parity può essere *intenzionale slicing* (“una domanda grep-friendly”) — decidere fusione solo dopo confronto heading e tag frontmatter [`ridondanze-documentazione-wizard.md`](../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md).

## Tracker

Issues principali [#89](https://github.com/laraxot/base_fixcity_fila5/issues/89) · [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90) · consolidamento docs [#107](https://github.com/laraxot/base_fixcity_fila5/issues/107).
