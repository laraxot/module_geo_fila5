---
title: documentazione modulo Tenant
module: Tenant
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Tenant

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Multi-tenancy module for the Laraxot ecosystem: single application instance serving multiple tenants with data isolation.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Tenant/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Tenant`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-INDEX | [00-INDEX.md](./00-INDEX.md) |
| 00-index | [00-index.md](./00-index.md) |
| METODI_DUPLICATI_ANALISI | [METODI_DUPLICATI_ANALISI.md](./METODI_DUPLICATI_ANALISI.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PRD | [PRD.md](./PRD.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| SUSHI_TO_JSON_FIX_PLAN | [SUSHI_TO_JSON_FIX_PLAN.md](./SUSHI_TO_JSON_FIX_PLAN.md) |
| TODO | [TODO.md](./TODO.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| about | [about.md](./about.md) |
| activitylog | [activitylog.md](./activitylog.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-methodologies | [ai-methodologies.md](./ai-methodologies.md) |
| alternatives | [alternatives.md](./alternatives.md) |
| api-integration | [api-integration.md](./api-integration.md) |
| app | [app.md](./app.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| arr-first-vs-collect-first-decision | [arr-first-vs-collect-first-decision.md](./arr-first-vs-collect-first-decision.md) |
| arr-first-vs-collect-first-ision | [arr-first-vs-collect-first-ision.md](./arr-first-vs-collect-first-ision.md) |
| auth | [auth.md](./auth.md) |
| best-practices | [best-practices.md](./best-practices.md) |
| business-logic-deep-dive | [business-logic-deep-dive.md](./business-logic-deep-dive.md) |
| case-sensitivity-rules | [case-sensitivity-rules.md](./case-sensitivity-rules.md) |
| chaos-monkey-tenant-isolation-checklist | [chaos-monkey-tenant-isolation-checklist.md](./chaos-monkey-tenant-isolation-checklist.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| codex-error-fix | [codex-error-fix.md](./codex-error-fix.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| configuration-logic-analysis | [configuration-logic-analysis.md](./configuration-logic-analysis.md) |
| configuration | [configuration.md](./configuration.md) |
| conflict-resolution-fixes | [conflict-resolution-fixes.md](./conflict-resolution-fixes.md) |
| conflict-resolution | [conflict-resolution.md](./conflict-resolution.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.

---

## ✅ PHPStan Status — Verifica 2026-07-01

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/Tenant --level=max --memory-limit=512M
# [OK] No errors
```

Modulo conforme alle regole Laraxot:
- Classi Filament estendono XotBase (mai direttamente Filament)
- Nessun label/placeholder/tooltip hardcoded
- Nessun BadgeColumn (usa TextColumn::make()->badge())
- Actions usano QueueableAction pattern
- Nessun Service tradizionale

## Audit qualità — 2026-07-01 (PHPStan / PHPMD / PHPInsights)

Sessione di audit completa (`phpstan`, `phpmd`, `phpinsights`), fix applicati mantenendo il codice funzionalmente invariato:

- **PHPStan** (`level: max`, `--memory-limit=4G`): 0 errori prima e dopo l'audit.
- **PHPMD** (`cleancode,codesize,design,naming,unusedcode,controversial`): risolte le violazioni naming/unused ragionevoli:
  - `ResolveTenantConfigValueAction::execute()`: parametro `$_default` → `$default`.
  - `GetTenantNameAction::execute()`: variabili snake_case (`$server_name`, `$config_file`, `$shortened_parts`, `$default_path`) → camelCase.
  - `DomainPolicy`: parametri `$_domain` → `$domain` (restano `UnusedFormalParameter` per contratto Policy Laravel: non riducibile senza rompere la firma richiesta da `Gate`/Filament).
  - `TenantBasePolicy::before()`: rimossa variabile locale morta `$xotData` (chiamata a `XotData::make()` senza uso) e rinominato `$_ability` → `$ability`.
  - `SushiToJsons.php`: import mancante di `ReflectionObject`, rimossa variabile `$id`/`$type` inutilizzate nei `foreach`.
  - `SushiToJson.php`: rimossa variabile `$_type` inutilizzata.
  - `TenantServiceProvider`: rimossa variabile morta `$upperName` (usata solo in codice commentato) e `$tmp` non utilizzata in `mergeConfigs()`.
  - `StandardConfigResolver::handleMissingConfig()`: rimossi parametri/variabili morti (`$group`, `$extraConf`, `$default`, `Arr::set()` senza effetto) — il metodo lancia comunque l'eccezione, la logica non cambia.
  - Non toccati: `StaticAccess` (uso idiomatico delle Facade Laravel, centinaia di occorrenze — refactor a DI sarebbe eccessivo/rischioso), `CyclomaticComplexity`/`NPathComplexity`/`ExcessiveMethodLength` sui metodi `boot*()` dei trait Sushi (refactor architetturale non richiesto), proprietà `$module_dir`/`$module_ns` in snake_case (convenzione condivisa in tutti i moduli via `Xot\Providers\XotBaseServiceProvider`, non modificabile isolatamente).
- **PHPInsights** (`tools/phpinsights.sh analyse Modules/Tenant/app`): punteggio 86.0 Code / 82.3 Complexity / 76.5 Architecture / 88.0 Style. Applicato `--fix` per gli style fix automatici sicuri (PSR brace style, ordered imports, tab→spazi, `new Class()` con parentesi, doc-comment spacing). **Attenzione**: il flag `--fix` ha introdotto in automatico native type hint `array` su due proprietà `$fillable` (`Tenant.php`, `TestSushiModel.php`) che violavano la regola PHPStan `property.extraNativeType` (la property del genitore Eloquent `$fillable` non ha tipo nativo); il type hint nativo è stato rimosso mantenendo il tag `@var list<string>`. **Verificare sempre PHPStan dopo ogni `phpinsights --fix`.**
- **Pest**: nessun test esistente in `Modules/Tenant/tests/` copriva i file modificati con logica di business alterabile (i cambi sono naming/dead-code, comportamento invariato); non sono stati creati nuovi test per non introdurre rischio senza reale copertura di regressione aggiuntiva. Nessun comando distruttivo sul DB eseguito.

Nota: durante l'audit il working tree del repo (livello `/var/www/_bases/base_ptvx_fila5`) presentava numerose modifiche non relative a questo task in altri moduli (es. `Ptv`), presumibilmente da altra sessione/agente concorrente attivo sullo stesso repository. Non sono stati toccati file fuori da `Modules/Tenant`.
