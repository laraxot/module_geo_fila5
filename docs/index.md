# Geo — Indice della documentazione

Indice di navigazione per `Modules/Geo/docs/`. Aggiornato 2026-09-03 nell'ambito di un audit BMAD (vedi `docs/stories/docs-index-audit.story.md`).

**Policy di questo indice**

- Nessun file `.md` esistente e' stato rinominato, spostato o cancellato per produrre questo indice.
- I file con contenuto duplicato (stesso testo, nome diverso per maiuscole/minuscole o `-`/`_`) sono collegati una sola volta nelle sezioni per argomento; le copie identiche sono elencate in "Storico / da consolidare" cosi' restano tracciate senza sparire dalla navigazione.
- Le cartelle gia' dotate di un proprio `index.md`/`README.md` sono linkate come punto d'ingresso invece di elencare ogni file al loro interno.

## Panoramica numerica

- File `.md` totali sotto `docs/`: **1969**
- File `.md` sciolti direttamente in `docs/` (root): **563**
  - di cui **373** con contenuto unico e **92 gruppi di duplicati esatti** (98 file doppioni, stesso contenuto)
- Sottocartelle sotto `docs/`: **103** (vedi tabella sotto)

## Documentazione principale evidenziata

Punti di partenza consigliati, con link ai file canonici (nome minuscolo con trattini, dove esisteva un duplicato):

- [README.md](./README.md) — panoramica del modulo
- [architecture.md](./architecture.md) e [architectural-philosophy.md](./architectural-philosophy.md) — architettura e principi
- [technical.md](./technical.md) — linee guida tecniche (duplicato storico: `TECHNICAL.md`)
- [product_strategy.md](./product_strategy.md) — visione di prodotto (duplicato storico: `PRODUCT_STRATEGY.md`; vedi anche `product-strategy.md`, versione distinta non duplicata)
- [product_roadmap.md](./product_roadmap.md) — roadmap di prodotto (duplicato storico: `PRODUCT_ROADMAP.md`; vedi anche `product-roadmap.md`, versione distinta non duplicata)
- [prd.md](./prd.md) — product requirements (duplicato storico: `PRD.md`)
- [filament-forms-components.md](./filament-forms-components.md) — componenti Filament/Lit.dev
- [filament-extension-rules.md](./filament-extension-rules.md) — regole estensione Filament
- [coordinate-picker-purpose.md](./coordinate-picker-purpose.md) — scopo e architettura del componente mappa
- [story-map-component-analysis.md](./story-map-component-analysis.md) — analisi component mappa
- [leaflet-marker-map-input.md](./leaflet-marker-map-input.md) — input mappa con marker draggable
- [address-implementation.md](./address-implementation.md) — gestione indirizzi (duplicato storico: `address_implementation.md`)
- [mcp_server_recommended.md](./mcp_server_recommended.md) — server MCP raccomandati (duplicato storico: `MCP_SERVER_RECOMMENDED.md`; vedi anche `mcp-server-recommended.md`, versione distinta non duplicata)
- [phpstan-fixes.md](./phpstan-fixes.md) — stato fix PHPStan (nota: `phpstan_fixes.md`/`PHPSTAN_FIXES.md` sono un file distinto piu' corto, duplicato tra loro)
- [project.md](./project.md) — project management (duplicati storici: `PROJECT.md`, `project_backup.md`)
- [sprint_planning.md](./sprint_planning.md) — sprint planning (duplicato storico: `SPRINT_PLANNING.md`; vedi anche `sprint-planning.md`, versione distinta non duplicata)
- [user_research.md](./user_research.md) — ricerca utente (duplicato storico: `USER_RESEARCH.md`; vedi anche `user-research.md`, versione distinta non duplicata)
- [../../../../docs/wiki/rules/no-controllers-rule.md](../../../../docs/wiki/rules/no-controllers-rule.md) — regola architetturale: no `Http/Controllers/`, Folio + Actions + Filament

Note su link gia' presenti nella versione precedente dell'indice risultati non risolvibili e corretti qui: `FILAMENT_EXTENSION_RULES.md` non esiste (file corretto: `filament-extension-rules.md`); `leaflet_marker_map_input.md` non esiste (file corretto: `leaflet-marker-map-input.md`).

## Documentazione per area (sottocartelle)

Elenco di tutte le 103 sottocartelle di `docs/`. Dove esiste gia' un `index.md`/`README.md` locale, l'indice punta li'; altrimenti il link porta alla cartella stessa.

| Cartella | File .md | Punto d'ingresso | Note |
|---|---|---|---|
| `.github/` | 1 | [`.github/`](./.github/) |  |
| `_integration/` | 24 | [`_integration/`](./_integration/) | vedi Storico / da consolidare |
| `actions/` | 1 | [`actions/`](./actions/) |  |
| `activity/` | 5 | [`activity/`](./activity/) |  |
| `ai/` | 25 | [ai/README.md](./ai/README.md) |  |
| `ai-agent-teams/` | 1 | [`ai-agent-teams/`](./ai-agent-teams/) |  |
| `amministrazione/` | 1 | [`amministrazione/`](./amministrazione/) |  |
| `analysis/` | 3 | [`analysis/`](./analysis/) |  |
| `architecture/` | 11 | [`architecture/`](./architecture/) |  |
| `base/` | 4 | [`base/`](./base/) |  |
| `best-practices/` | 7 | [`best-practices/`](./best-practices/) |  |
| `bmad/` | 5 | [bmad/README.md](./bmad/README.md) |  |
| `charts/` | 2 | [`charts/`](./charts/) |  |
| `chat/` | 64 | [chat/README.md](./chat/README.md) |  |
| `ci/` | 11 | [`ci/`](./ci/) |  |
| `claude/` | 43 | [claude/README.md](./claude/README.md) | guida sviluppo condivisa di progetto (PTVX), non specifica del modulo Geo |
| `components/` | 4 | [components/index.md](./components/index.md) |  |
| `concepts/` | 3 | [`concepts/`](./concepts/) |  |
| `CONCEPTS/` | 1 | [`CONCEPTS/`](./CONCEPTS/) |  |
| `config/` | 1 | [`config/`](./config/) |  |
| `console/` | 1 | [`console/`](./console/) |  |
| `conventions/` | 10 | [`conventions/`](./conventions/) |  |
| `core/` | 1 | [`core/`](./core/) |  |
| `data/` | 2 | [`data/`](./data/) |  |
| `database/` | 6 | [`database/`](./database/) |  |
| `development/` | 20 | [`development/`](./development/) |  |
| `docker/` | 2 | [docker/README.md](./docker/README.md) |  |
| `docs/` | 11 | [docs/README.md](./docs/README.md) |  |
| `docs_project/` | 1 | [docs_project/index.md](./docs_project/index.md) |  |
| `documentation/` | 4 | [documentation/README.md](./documentation/README.md) |  |
| `en/` | 2 | [`en/`](./en/) |  |
| `enums/` | 1 | [`enums/`](./enums/) |  |
| `extras/` | 1 | [`extras/`](./extras/) |  |
| `features/` | 5 | [`features/`](./features/) |  |
| `filament/` | 22 | [`filament/`](./filament/) |  |
| `framework/` | 1 | [`framework/`](./framework/) |  |
| `fundamentals/` | 4 | [`fundamentals/`](./fundamentals/) |  |
| `gdpr/` | 7 | [`gdpr/`](./gdpr/) |  |
| `getting-started/` | 1 | [`getting-started/`](./getting-started/) |  |
| `git-conflicts/` | 3 | [`git-conflicts/`](./git-conflicts/) |  |
| `git-management/` | 11 | [`git-management/`](./git-management/) |  |
| `github/` | 2 | [`github/`](./github/) |  |
| `google-maps/` | 1 | [`google-maps/`](./google-maps/) |  |
| `gsd/` | 6 | [gsd/README.md](./gsd/README.md) |  |
| `includes/` | 4 | [includes/README.md](./includes/README.md) |  |
| `index/` | 1 | [`index/`](./index/) |  |
| `install/` | 9 | [`install/`](./install/) |  |
| `integrations/` | 1 | [`integrations/`](./integrations/) |  |
| `introduction/` | 1 | [`introduction/`](./introduction/) |  |
| `it/` | 24 | [it/README.md](./it/README.md) | toolkit automazione Git generico, non specifico del modulo Geo |
| `laragon/` | 3 | [`laragon/`](./laragon/) |  |
| `laravel-13-upgrade/` | 11 | [`laravel-13-upgrade/`](./laravel-13-upgrade/) |  |
| `laraxot/` | 4 | [`laraxot/`](./laraxot/) |  |
| `lib/` | 1 | [lib/README.md](./lib/README.md) |  |
| `links/` | 3 | [`links/`](./links/) |  |
| `llm-wiki/` | 5 | [llm-wiki/index.md](./llm-wiki/index.md) |  |
| `maintenance/` | 4 | [maintenance/README.md](./maintenance/README.md) |  |
| `mcp/` | 2 | [`mcp/`](./mcp/) |  |
| `model/` | 5 | [`model/`](./model/) |  |
| `models/` | 5 | [`models/`](./models/) |  |
| `modules/` | 7 | [`modules/`](./modules/) |  |
| `navigation/` | 2 | [`navigation/`](./navigation/) |  |
| `no_console/` | 1 | [`no_console/`](./no_console/) |  |
| `oauth/` | 3 | [`oauth/`](./oauth/) |  |
| `open_sources/` | 1 | [`open_sources/`](./open_sources/) |  |
| `outputs/` | 1 | [outputs/README.md](./outputs/README.md) |  |
| `patterns/` | 9 | [patterns/README.md](./patterns/README.md) |  |
| `pdf/` | 16 | [pdf/README.md](./pdf/README.md) |  |
| `performance/` | 17 | [`performance/`](./performance/) |  |
| `presenze-assenze/` | 7 | [`presenze-assenze/`](./presenze-assenze/) |  |
| `prompts/` | 31 | [`prompts/`](./prompts/) | vedi Storico / da consolidare |
| `quality-assurance/` | 2 | [`quality-assurance/`](./quality-assurance/) |  |
| `questionari/` | 7 | [`questionari/`](./questionari/) |  |
| `quick-reference/` | 1 | [`quick-reference/`](./quick-reference/) |  |
| `raw/` | 442 | [raw/README.md](./raw/README.md) |  |
| `readme/` | 1 | [`readme/`](./readme/) |  |
| `refactoring/` | 1 | [`refactoring/`](./refactoring/) |  |
| `roadmap/` | 70 | [roadmap/00-INDEX.md](./roadmap/00-INDEX.md) | stub che rimanda a doc condivisa Themes, verificare pertinenza specifica Geo |
| `root-md-files/` | 38 | [`root-md-files/`](./root-md-files/) | vedi Storico / da consolidare |
| `root-txt-files/` | 4 | [`root-txt-files/`](./root-txt-files/) | vedi Storico / da consolidare |
| `rules/` | 15 | [rules/00-index.md](./rules/00-index.md) |  |
| `schema/` | 2 | [`schema/`](./schema/) |  |
| `service/` | 3 | [`service/`](./service/) |  |
| `services/` | 1 | [`services/`](./services/) |  |
| `setup/` | 2 | [setup/README.md](./setup/README.md) |  |
| `source/` | 5 | [`source/`](./source/) |  |
| `staudenmeir/` | 1 | [`staudenmeir/`](./staudenmeir/) |  |
| `stories/` | 13 | [stories/index.md](./stories/index.md) |  |
| `system/` | 1 | [system/README.md](./system/README.md) |  |
| `tasks/` | 7 | [`tasks/`](./tasks/) |  |
| `templates/` | 18 | [templates/README.md](./templates/README.md) |  |
| `test-plans/` | 3 | [`test-plans/`](./test-plans/) |  |
| `testing/` | 8 | [testing/README.md](./testing/README.md) |  |
| `tooling/` | 1 | [`tooling/`](./tooling/) |  |
| `tools/` | 1 | [`tools/`](./tools/) |  |
| `traits/` | 9 | [`traits/`](./traits/) |  |
| `translations/` | 1 | [`translations/`](./translations/) |  |
| `troubleshooting/` | 5 | [`troubleshooting/`](./troubleshooting/) |  |
| `ubuntu/` | 2 | [`ubuntu/`](./ubuntu/) |  |
| `ui_components/` | 1 | [`ui_components/`](./ui_components/) |  |
| `widgets/` | 1 | [`widgets/`](./widgets/) |  |
| `wiki/` | 218 | [wiki/README.md](./wiki/README.md) |  |
| `wsl/` | 2 | [`wsl/`](./wsl/) |  |

## File in root — per argomento

I 563 file `.md` sciolti nella root di `docs/` sono raggruppati qui per argomento. Ogni gruppo elenca i file con contenuto unico o il rappresentante canonico di un gruppo di duplicati esatti (la lista completa dei duplicati e' in "Storico / da consolidare" piu' sotto). Attenzione: file con nome simile ma separatore diverso (`-` vs `_`) o maiuscole diverse **non sono automaticamente lo stesso contenuto** — vedi la sezione duplicati per la mappatura verificata via hash.

### Address, geocoding, autocomplete (51)

- [address-autocomplete-integration.md](./address-autocomplete-integration.md)
- [address-autocomplete.md](./address-autocomplete.md)
- [address-column-implementation-complete.md](./address-column-implementation-complete.md)
- [address-column-implementation.md](./address-column-implementation.md)
- [address-field-component.md](./address-field-component.md)
- [address-field.md](./address-field.md)
- [address-implementation.md](./address-implementation.md)
- [address-input-component.md](./address-input-component.md)
- [address-input-implementation-summary.md](./address-input-implementation-summary.md)
- [address-item-enum-guide.md](./address-item-enum-guide.md)
- [address-migration-guide.md](./address-migration-guide.md)
- [address-migration.md](./address-migration.md)
- [address-model-italian.md](./address-model-italian.md)
- [address-relationships.md](./address-relationships.md)
- [address-resource-analysis.md](./address-resource-analysis.md)
- [address-resource-improvements.md](./address-resource-improvements.md)
- [address-resource-summary.md](./address-resource-summary.md)
- [address-resource.md](./address-resource.md)
- [address-translation-fixes-.md](./address-translation-fixes-.md)
- [address-translation-fixes-1.md](./address-translation-fixes-1.md)
- [address-translation-fixes.md](./address-translation-fixes.md)
- [address-translationes.md](./address-translationes.md)
- [address_autocomplete.md](./address_autocomplete.md)
- [address_resource.md](./address_resource.md)
- [addressitemenum-translations-complete.md](./addressitemenum-translations-complete.md)
- [addressresource-analysis.md](./addressresource-analysis.md)
- [addressresource-improvements.md](./addressresource-improvements.md)
- [addressresource-summary.md](./addressresource-summary.md)
- [addressresource.md](./addressresource.md)
- [addressresource_analysis.md](./addressresource_analysis.md)
- [addressresource_improvements.md](./addressresource_improvements.md)
- [addressresource_summary.md](./addressresource_summary.md)
- [addresssection-philosophy.md](./addresssection-philosophy.md)
- [autocomplete-integration.md](./autocomplete-integration.md)
- [autocomplete.md](./autocomplete.md)
- [geocode-result-dto-archived.md](./geocode-result-dto-archived.md)
- [google-maps-service-provider-error.md](./google-maps-service-provider-error.md)
- [has-address-trait.md](./has-address-trait.md)
- [has_address_trait.md](./has_address_trait.md)
- [here-com-integration.md](./here-com-integration.md)
- [here-com.md](./here-com.md)
- [here-integration.md](./here-integration.md)
- [here.md](./here.md)
- [link2-integration.md](./link2-integration.md)
- [link2.md](./link2.md)
- [link3-integration.md](./link3-integration.md)
- [link3.md](./link3.md)
- [place-address-schemaorg.md](./place-address-schemaorg.md)
- [start-here.md](./start-here.md)
- [tomtom-com.md](./tomtom-com.md)
- [tomtom_com.md](./tomtom_com.md)

### Comune, GeoJSON, Sushi models (43)

- [comune-implementation.md](./comune-implementation.md)
- [comune-model.md](./comune-model.md)
- [comune-sushi-analisi.md](./comune-sushi-analisi.md)
- [comune-sushi-analysis.md](./comune-sushi-analysis.md)
- [comune-sushi-conversion.md](./comune-sushi-conversion.md)
- [comune-sushi-implementation.md](./comune-sushi-implementation.md)
- [comune-sushi-implementazione.md](./comune-sushi-implementazione.md)
- [comune-unification-analysis.md](./comune-unification-analysis.md)
- [comune-unificazione-analisi.md](./comune-unificazione-analisi.md)
- [comune-unificazione-analysis.md](./comune-unificazione-analysis.md)
- [comune_sushi_implementation.md](./comune_sushi_implementation.md)
- [geo-actions-summary.md](./geo-actions-summary.md)
- [geo-actions.md](./geo-actions.md)
- [geo-entities.md](./geo-entities.md)
- [geo-json-model.md](./geo-json-model.md)
- [geo-json-vs-sushi-comparison.md](./geo-json-vs-sushi-comparison.md)
- [geo-models-domain-analysis.md](./geo-models-domain-analysis.md)
- [geo-sushi-comparison-1.md](./geo-sushi-comparison-1.md)
- [geo-sushi-comparison.md](./geo-sushi-comparison.md)
- [geo_json_model.md](./geo_json_model.md)
- [geographic-data-management-compendium.md](./geographic-data-management-compendium.md)
- [geographic-models-consolidation.md](./geographic-models-consolidation.md)
- [geojson-model-vs-sushi.md](./geojson-model-vs-sushi.md)
- [geojson-vs-sushi-comparison.md](./geojson-vs-sushi-comparison.md)
- [geojsonmodel-vs-sushi.md](./geojsonmodel-vs-sushi.md)
- [laravel-sushi-analysis.md](./laravel-sushi-analysis.md)
- [laravel-sushi-guide.md](./laravel-sushi-guide.md)
- [laravel-sushi.md](./laravel-sushi.md)
- [phpstan-sushitojson-contract.md](./phpstan-sushitojson-contract.md)
- [poligon.md](./poligon.md)
- [sushi-command.md](./sushi-command.md)
- [sushi-configuration.md](./sushi-configuration.md)
- [sushi-implementation-analysis.md](./sushi-implementation-analysis.md)
- [sushi-implementation-guide.md](./sushi-implementation-guide.md)
- [sushi-implementation.md](./sushi-implementation.md)
- [sushi-models-dependency-cycle-fix.md](./sushi-models-dependency-cycle-fix.md)
- [sushi-modelsependency-cycle.md](./sushi-modelsependency-cycle.md)
- [sushi-to-jsons-analysis.md](./sushi-to-jsons-analysis.md)
- [sushi-to-jsons.md](./sushi-to-jsons.md)
- [sushi_command.md](./sushi_command.md)
- [sushi_implementation.md](./sushi_implementation.md)
- [unified-comune-model-analysis.md](./unified-comune-model-analysis.md)
- [unified-comune-model.md](./unified-comune-model.md)

### PHPStan (48)

- [correzioni-phpstan-multiple-completate.md](./correzioni-phpstan-multiple-completate.md)
- [correzioni_phpstan_multiple_completate.md](./correzioni_phpstan_multiple_completate.md)
- [factory-phpstan-fixes.md](./factory-phpstan-fixes.md)
- [no-phpstan-probe-policy.md](./no-phpstan-probe-policy.md)
- [phpstan-activity-fixes-complete.md](./phpstan-activity-fixes-complete.md)
- [phpstan-activity-fixes-completed.md](./phpstan-activity-fixes-completed.md)
- [phpstan-activityesd.md](./phpstan-activityesd.md)
- [phpstan-analysis-business-logic.md](./phpstan-analysis-business-logic.md)
- [phpstan-analysis-geo.md](./phpstan-analysis-geo.md)
- [phpstan-analysis-pattern.md](./phpstan-analysis-pattern.md)
- [phpstan-bing-maps-action-fix-completion.md](./phpstan-bing-maps-action-fix-completion.md)
- [phpstan-bing-maps-action-fix-roadmap.md](./phpstan-bing-maps-action-fix-roadmap.md)
- [phpstan-class-references-fix.md](./phpstan-class-references-fix.md)
- [phpstan-compliance-status.md](./phpstan-compliance-status.md)
- [phpstan-compliance.md](./phpstan-compliance.md)
- [phpstan-corrections.md](./phpstan-corrections.md)
- [phpstan-critical-rule.md](./phpstan-critical-rule.md)
- [phpstan-error-resolution-roadmap.md](./phpstan-error-resolution-roadmap.md)
- [phpstan-error-resolution.md](./phpstan-error-resolution.md)
- [phpstan-errors-resolution-roadmap.md](./phpstan-errors-resolution-roadmap.md)
- [phpstan-errors-roadmap-.md](./phpstan-errors-roadmap-.md)
- [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md)
- [phpstan-errors.md](./phpstan-errors.md)
- [phpstan-fixes-.md](./phpstan-fixes-.md)
- [phpstan-fixes-2.md](./phpstan-fixes-2.md)
- [phpstan-fixes-3.md](./phpstan-fixes-3.md)
- [phpstan-fixes-gennaio-2025.md](./phpstan-fixes-gennaio-2025.md)
- [phpstan-fixes-gennaio.md](./phpstan-fixes-gennaio.md)
- [phpstan-fixes-january.md](./phpstan-fixes-january.md)
- [phpstan-fixes-notify-module.md](./phpstan-fixes-notify-module.md)
- [phpstan-fixes-renamed.md](./phpstan-fixes-renamed.md)
- [phpstan-fixes-roadmap.md](./phpstan-fixes-roadmap.md)
- [phpstan-fixes-saluteora.md](./phpstan-fixes-saluteora.md)
- [phpstan-fixes-uppercase.md](./phpstan-fixes-uppercase.md)
- [phpstan-fixes.md](./phpstan-fixes.md)
- [phpstan-immediate-fixes.md](./phpstan-immediate-fixes.md)
- [phpstan-multiple-corrections-complete.md](./phpstan-multiple-corrections-complete.md)
- [phpstan-return-type-errors.md](./phpstan-return-type-errors.md)
- [phpstan-return-types.md](./phpstan-return-types.md)
- [phpstan-roadmap-geo.md](./phpstan-roadmap-geo.md)
- [phpstan-roadmap.md](./phpstan-roadmap.md)
- [phpstan-session-4-5-fixes-complete.md](./phpstan-session-4-5-fixes-complete.md)
- [phpstan-stabilization.md](./phpstan-stabilization.md)
- [phpstan-standards.md](./phpstan-standards.md)
- [phpstan.md](./phpstan.md)
- [phpstan_fixes.md](./phpstan_fixes.md)
- [phpstanes-uppercase.md](./phpstanes-uppercase.md)
- [phpstanes.md](./phpstanes.md)

### Filament e componenti form/UI (23)

- [daisyui.md](./daisyui.md)
- [deprecated-form-method-upgrade.md](./deprecated-form-method-upgrade.md)
- [filament-4x-compatibility.md](./filament-4x-compatibility.md)
- [filament-5x-compatibility.md](./filament-5x-compatibility.md)
- [filament-extension-rules.md](./filament-extension-rules.md)
- [filament-forms-components.md](./filament-forms-components.md)
- [filament-geo-pickers-philosophy.md](./filament-geo-pickers-philosophy.md)
- [filament-integration.md](./filament-integration.md)
- [filament-v4-upgrade-notes.md](./filament-v4-upgrade-notes.md)
- [filament-view-record-implementation.md](./filament-view-record-implementation.md)
- [filament.md](./filament.md)
- [filament_4x_compatibility.md](./filament_4x_compatibility.md)
- [filament_extension_rules.md](./filament_extension_rules.md)
- [form-schema-reuse.md](./form-schema-reuse.md)
- [helper-text-normalization-fix-.md](./helper-text-normalization-fix-.md)
- [helper-text-normalization-fix.md](./helper-text-normalization-fix.md)
- [helper-text-normalization.md](./helper-text-normalization.md)
- [location-select.md](./location-select.md)
- [location-spinner-ux.md](./location-spinner-ux.md)
- [nested-resources.md](./nested-resources.md)
- [visual-tools.md](./visual-tools.md)
- [vite-build-configuration.md](./vite-build-configuration.md)
- [wizard-location-data-flow.md](./wizard-location-data-flow.md)

### Model, Eloquent, relazioni, migrations (37)

- [--eloquent.md](./--eloquent.md)
- [__eloquent.md](./__eloquent.md)
- [audit-relazioni-duplicate-sigma.md](./audit-relazioni-duplicate-sigma.md)
- [cast-actions-centralized.md](./cast-actions-centralized.md)
- [casting-actions-usage.md](./casting-actions-usage.md)
- [complete-models-factory-seeder.md](./complete-models-factory-seeder.md)
- [duplicate-relationship-methods.md](./duplicate-relationship-methods.md)
- [elenco-relazioni-metodi-duplicate.md](./elenco-relazioni-metodi-duplicate.md)
- [eloquent-integration.md](./eloquent-integration.md)
- [eloquent.md](./eloquent.md)
- [inheritance-analysis-rule.md](./inheritance-analysis-rule.md)
- [inheritance-violationsed.md](./inheritance-violationsed.md)
- [inheritance_violations_fixed.md](./inheritance_violations_fixed.md)
- [laraxot-migration-principles-uuid-polymorphism.md](./laraxot-migration-principles-uuid-polymorphism.md)
- [metodi-relazione-duplicati.md](./metodi-relazione-duplicati.md)
- [migration-guide.md](./migration-guide.md)
- [migration-morphs-strategy.md](./migration-morphs-strategy.md)
- [migration-naming-pattern.md](./migration-naming-pattern.md)
- [migration-naming.md](./migration-naming.md)
- [migration.md](./migration.md)
- [migration_naming_pattern.md](./migration_naming_pattern.md)
- [model-analysis.md](./model-analysis.md)
- [model-casting-fix.md](./model-casting-fix.md)
- [model-classification.md](./model-classification.md)
- [model-factory-seeder-audit.md](./model-factory-seeder-audit.md)
- [model-inheritance-pattern.md](./model-inheritance-pattern.md)
- [model-inheritance.md](./model-inheritance.md)
- [model-testing-philosophy.md](./model-testing-philosophy.md)
- [modelli-factory-seeder-analisi.md](./modelli-factory-seeder-analisi.md)
- [models-analysis.md](./models-analysis.md)
- [models-factory-seeder-analysis.md](./models-factory-seeder-analysis.md)
- [models-migrations-status.md](./models-migrations-status.md)
- [morphs-relationship-patterns.md](./morphs-relationship-patterns.md)
- [morphs-relationships.md](./morphs-relationships.md)
- [nestedset-migration-best-practices.md](./nestedset-migration-best-practices.md)
- [relationship_methods_duplicate_list.md](./relationship_methods_duplicate_list.md)
- [relazioni-duplicati.md](./relazioni-duplicati.md)

### Factory, Seeder, Database (18)

- [analisi-completa-modelli-factory-seeder.md](./analisi-completa-modelli-factory-seeder.md)
- [business-logic-factory-seeder-audit.md](./business-logic-factory-seeder-audit.md)
- [comuni-json-usage.md](./comuni-json-usage.md)
- [database-population-guide.md](./database-population-guide.md)
- [database-seeding.md](./database-seeding.md)
- [databases.md](./databases.md)
- [factory-best-practices.md](./factory-best-practices.md)
- [factory-creation-geo-module.md](./factory-creation-geo-module.md)
- [factory-email-rule.md](./factory-email-rule.md)
- [factory-seeder-consolidated.md](./factory-seeder-consolidated.md)
- [json-database.md](./json-database.md)
- [json-usage-1.md](./json-usage-1.md)
- [json-usage.md](./json-usage.md)
- [jsonatabase.md](./jsonatabase.md)
- [modules-factory-seeder-analysis.md](./modules-factory-seeder-analysis.md)
- [modules-factory-seeder.md](./modules-factory-seeder.md)
- [refactoring-bashscriptsatabase-seeding.md](./refactoring-bashscriptsatabase-seeding.md)
- [testing-testcase-database-connection-fix.md](./testing-testcase-database-connection-fix.md)

### BMAD, Git conflicts, merge (15)

- [conflict-resolution-1.md](./conflict-resolution-1.md)
- [conflict-resolution.md](./conflict-resolution.md)
- [conflict-resolutiones.md](./conflict-resolutiones.md)
- [conflict_resolution.md](./conflict_resolution.md)
- [git-conflict-resolution-2026-07-31.md](./git-conflict-resolution-2026-07-31.md)
- [git-conflicts-report.md](./git-conflicts-report.md)
- [git-conflicts-resolution-guide.md](./git-conflicts-resolution-guide.md)
- [merge-conflict-files-list.md](./merge-conflict-files-list.md)
- [merge-conflict-marker-cleanup.md](./merge-conflict-marker-cleanup.md)
- [merge-conflicts-analysis.md](./merge-conflicts-analysis.md)
- [merge-conflicts-list.md](./merge-conflicts-list.md)
- [merge-conflicts-resolution.md](./merge-conflicts-resolution.md)
- [merge_conflicts_resolution.md](./merge_conflicts_resolution.md)
- [merges-resolution.md](./merges-resolution.md)
- [merges.md](./merges.md)

### Duplicati, analisi metodi, redundancy, audit (19)

- [copilot-redundancy-audit-2026-05-25.md](./copilot-redundancy-audit-2026-05-25.md)
- [duplicate-analysis.md](./duplicate-analysis.md)
- [duplicate-methods-analysis.md](./duplicate-methods-analysis.md)
- [duplicate_methods_report.md](./duplicate_methods_report.md)
- [metodi-duplicati-analisi.md](./metodi-duplicati-analisi.md)
- [metodi-duplicati-report.md](./metodi-duplicati-report.md)
- [metodi_duplicati_analisi.md](./metodi_duplicati_analisi.md)
- [metodiuplicati-analisi.md](./metodiuplicati-analisi.md)
- [missing-factories-audit.md](./missing-factories-audit.md)
- [modularity-audit-summary.md](./modularity-audit-summary.md)
- [modularity-audit-sumy.md](./modularity-audit-sumy.md)
- [ponytail-audit-2026-07-02.md](./ponytail-audit-2026-07-02.md)
- [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md)
- [ponytail-audit-plan.md](./ponytail-audit-plan.md)
- [ponytail-audit-report.md](./ponytail-audit-report.md)
- [redundancy-audit-2026-05-21.md](./redundancy-audit-2026-05-21.md)
- [redundancy-report.md](./redundancy-report.md)
- [redundancy_analysis.md](./redundancy_analysis.md)
- [redundancy_report.md](./redundancy_report.md)

### Roadmap, Product, PRD, Sprint (14)

- [prd.md](./prd.md)
- [product-launch-plan.md](./product-launch-plan.md)
- [product-roadmap.md](./product-roadmap.md)
- [product-strategy.md](./product-strategy.md)
- [product_launch_plan.md](./product_launch_plan.md)
- [product_roadmap.md](./product_roadmap.md)
- [product_strategy.md](./product_strategy.md)
- [roadmap-and-issues.md](./roadmap-and-issues.md)
- [roadmap-vision.md](./roadmap-vision.md)
- [roadmap.md](./roadmap.md)
- [sprint-planning.md](./sprint-planning.md)
- [sprint.md](./sprint.md)
- [sprint_planning.md](./sprint_planning.md)
- [stabilization-roadmap.md](./stabilization-roadmap.md)

### Ottimizzazione, performance, complexity (13)

- [complexity-refactoring-plan.md](./complexity-refactoring-plan.md)
- [cyclomatic-complexity-report.md](./cyclomatic-complexity-report.md)
- [logging-performance.md](./logging-performance.md)
- [module-analysis-and-optimization-plan.md](./module-analysis-and-optimization-plan.md)
- [modules-analysis-and-optimization.md](./modules-analysis-and-optimization.md)
- [modules-optimization-index.md](./modules-optimization-index.md)
- [modules-optimization-summary.md](./modules-optimization-summary.md)
- [optimization-analysis.md](./optimization-analysis.md)
- [optimization-recommendations.md](./optimization-recommendations.md)
- [optimization-sumy-report.md](./optimization-sumy-report.md)
- [performance-optimization.md](./performance-optimization.md)
- [session_summary_refactoring.md](./session_summary_refactoring.md)
- [update-coordinates-refactoring-completed.md](./update-coordinates-refactoring-completed.md)

### Analisi modulo, modularita (13)

- [analisi-moduli-completata.md](./analisi-moduli-completata.md)
- [analisi-moduli-ottimizzazioni.md](./analisi-moduli-ottimizzazioni.md)
- [modularity-hardcoded-names.md](./modularity-hardcoded-names.md)
- [module-analysis-complete.md](./module-analysis-complete.md)
- [module-analysis.md](./module-analysis.md)
- [module-geo-1.md](./module-geo-1.md)
- [module-geo.md](./module-geo.md)
- [module-reusability-guidelines.md](./module-reusability-guidelines.md)
- [module-reusability-implementation-plan.md](./module-reusability-implementation-plan.md)
- [module-testing-analysis.md](./module-testing-analysis.md)
- [module.md](./module.md)
- [module_analysis.md](./module_analysis.md)
- [testing-strategy-modules.md](./testing-strategy-modules.md)

### Traduzioni, i18n, enum (6)

- [enums-implementation.md](./enums-implementation.md)
- [enums.md](./enums.md)
- [navigation-translations-fixes.md](./navigation-translations-fixes.md)
- [translation-structure-expanded.md](./translation-structure-expanded.md)
- [translation.md](./translation.md)
- [windsurf-enums.md](./windsurf-enums.md)

### Naming conventions, file naming, case (7)

- [case-conflicts.md](./case-conflicts.md)
- [contracts-naming.md](./contracts-naming.md)
- [file-naming-rules.md](./file-naming-rules.md)
- [naming-conventions.md](./naming-conventions.md)
- [sintassi-array-correzione-.md](./sintassi-array-correzione-.md)
- [sintassi-array-correzione.md](./sintassi-array-correzione.md)
- [syntax-array-correction.md](./syntax-array-correction.md)

### Architettura, principi, DRY-KISS (18)

- [anti-patterns.md](./anti-patterns.md)
- [architectural-philosophy.md](./architectural-philosophy.md)
- [architectural-violation-fix-plan.md](./architectural-violation-fix-plan.md)
- [architecture-testing-env.md](./architecture-testing-env.md)
- [architecture.md](./architecture.md)
- [boy-scout-rule.md](./boy-scout-rule.md)
- [dependencies.md](./dependencies.md)
- [dependency-intelligence.md](./dependency-intelligence.md)
- [dry-kiss-analysis.md](./dry-kiss-analysis.md)
- [dry-kiss-improvements.md](./dry-kiss-improvements.md)
- [false_friends.md](./false_friends.md)
- [homepage-architecture-overview.md](./homepage-architecture-overview.md)
- [laraxot-architecture-principles.md](./laraxot-architecture-principles.md)
- [philosophy.md](./philosophy.md)
- [principi-migrazioni-laraxot-uuid-polimorfismo.md](./principi-migrazioni-laraxot-uuid-polimorfismo.md)
- [research-farmshops-architecture.md](./research-farmshops-architecture.md)
- [reusable-components-philosophy.md](./reusable-components-philosophy.md)
- [testing-architecture-overview.md](./testing-architecture-overview.md)

### Mappe, polygon, coordinate, leaflet (21)

- [bulk-coordinate-updates.md](./bulk-coordinate-updates.md)
- [coordinate-picker-blade-fix.md](./coordinate-picker-blade-fix.md)
- [coordinate-picker-purpose.md](./coordinate-picker-purpose.md)
- [geo-map-widget.md](./geo-map-widget.md)
- [leaflet-marker-map-input.md](./leaflet-marker-map-input.md)
- [map-lit-lessons-learned.md](./map-lit-lessons-learned.md)
- [map-picker-lit.md](./map-picker-lit.md)
- [map-positioner.md](./map-positioner.md)
- [map-test-integration.md](./map-test-integration.md)
- [map-test.md](./map-test.md)
- [map_test.md](./map_test.md)
- [mappe-integrazione.md](./mappe-integrazione.md)
- [mappe-solo-gratuite.md](./mappe-solo-gratuite.md)
- [polygon-integration.md](./polygon-integration.md)
- [polygon-mysql-integration.md](./polygon-mysql-integration.md)
- [polygon-mysql.md](./polygon-mysql.md)
- [polygon.md](./polygon.md)
- [polygon_mysql.md](./polygon_mysql.md)
- [static-map-clickable-implementation.md](./static-map-clickable-implementation.md)
- [story-map-component-analysis.md](./story-map-component-analysis.md)
- [update-coordinates-bulk-action.md](./update-coordinates-bulk-action.md)

### Code quality, standards, best practices (10)

- [bad_practices.md](./bad_practices.md)
- [best_practices.md](./best_practices.md)
- [code-quality-analysis.md](./code-quality-analysis.md)
- [code-quality-improvement-report.md](./code-quality-improvement-report.md)
- [code-quality-report.md](./code-quality-report.md)
- [code-quality.md](./code-quality.md)
- [folio-volt-best-practices.md](./folio-volt-best-practices.md)
- [quality-improvements.md](./quality-improvements.md)
- [testing-best-practices.md](./testing-best-practices.md)
- [testing-psr4-standards.md](./testing-psr4-standards.md)

### Meta-documentazione, indice, readme, license, governance (19)

- [00-index.md](./00-index.md)
- [INDEX.md](./INDEX.md)
- [README.md](./README.md)
- [changelog.md](./changelog.md)
- [docs-health.md](./docs-health.md)
- [documentation-index.md](./documentation-index.md)
- [forbidden-docs-directories-rule.md](./forbidden-docs-directories-rule.md)
- [index.md](./index.md)
- [indice-documentazione.md](./indice-documentazione.md)
- [indiceocumentazione.md](./indiceocumentazione.md)
- [license.md](./license.md)
- [no-ai-tool-scaffold-dirs.md](./no-ai-tool-scaffold-dirs.md)
- [on-demand-pattern.md](./on-demand-pattern.md)
- [readme-en.md](./readme-en.md)
- [root-file-policy.md](./root-file-policy.md)
- [root-files-hygiene.md](./root-files-hygiene.md)
- [rules-index.md](./rules-index.md)
- [rules-testing-no-migrate-fresh.md](./rules-testing-no-migrate-fresh.md)
- [scripts-location-convention.md](./scripts-location-convention.md)

### MCP, AI tooling, agenti (8)

- [ai-methodologies.md](./ai-methodologies.md)
- [codex-error-fix.md](./codex-error-fix.md)
- [mcp-server-recommended-uppercase.md](./mcp-server-recommended-uppercase.md)
- [mcp-server-recommended.md](./mcp-server-recommended.md)
- [mcp_server_recommended.md](./mcp_server_recommended.md)
- [mcp_server_recommended_uppercase.md](./mcp_server_recommended_uppercase.md)
- [mcp_tools_integration.md](./mcp_tools_integration.md)
- [qmd-setup.md](./qmd-setup.md)

### GitHub, CI, dependabot (6)

- [consolidamento-modelli-geografici.md](./consolidamento-modelli-geografici.md)
- [dependabot-security-policy.md](./dependabot-security-policy.md)
- [gestione-dati-geografici-compendio.md](./gestione-dati-geografici-compendio.md)
- [gestioneati-geografici-compendio.md](./gestioneati-geografici-compendio.md)
- [github-actions-setup.md](./github-actions-setup.md)
- [github_interaction_log.md](./github_interaction_log.md)

### Implementation summary, project status (8)

- [implementation-summary-1.md](./implementation-summary-1.md)
- [implementation-summary.md](./implementation-summary.md)
- [implementation.md](./implementation.md)
- [implementation_sumy.md](./implementation_sumy.md)
- [project-backup.md](./project-backup.md)
- [project-structure.md](./project-structure.md)
- [project.md](./project.md)
- [testing-implementation-complete.md](./testing-implementation-complete.md)

### Business logic (3)

- [business-logic-analysis.md](./business-logic-analysis.md)
- [business-logic-consolidated.md](./business-logic-consolidated.md)
- [business-logic-overview.md](./business-logic-overview.md)

### Farmshops integration (3)

- [farmshops-analysis.md](./farmshops-analysis.md)
- [farmshops-integration-analysis.md](./farmshops-integration-analysis.md)
- [farmshops-integration.md](./farmshops-integration.md)

### Fix vari, class-not-found, errori (3)

- [class-not-found-errors.md](./class-not-found-errors.md)
- [class-not-founds.md](./class-not-founds.md)
- [class_not_found_errors.md](./class_not_found_errors.md)

### Script organization, launch (2)

- [launch.md](./launch.md)
- [script-organization.md](./script-organization.md)

### Testing (15)

- [basemodel-testing-lessons-learned.md](./basemodel-testing-lessons-learned.md)
- [queueable-action-testing.md](./queueable-action-testing.md)
- [queueable-actions.md](./queueable-actions.md)
- [test.md](./test.md)
- [test_27_02_2024.md](./test_27_02_2024.md)
- [testatabase-elimination-strategy.md](./testatabase-elimination-strategy.md)
- [testing-business-behavior-supreme-rule.md](./testing-business-behavior-supreme-rule.md)
- [testing-guide.md](./testing-guide.md)
- [testing-guidelines.md](./testing-guidelines.md)
- [testing-principles.md](./testing-principles.md)
- [testing-priority-rule.md](./testing-priority-rule.md)
- [testing-resolution.md](./testing-resolution.md)
- [testing-rules.md](./testing-rules.md)
- [testing-supreme-index.md](./testing-supreme-index.md)
- [testing.md](./testing.md)

### Integrazioni esterne varie (10)

- [app-integration.md](./app-integration.md)
- [app.md](./app.md)
- [laravel-packages-integration.md](./laravel-packages-integration.md)
- [laravel-packages.md](./laravel-packages.md)
- [laravel_packages.md](./laravel_packages.md)
- [squire-integration-1.md](./squire-integration-1.md)
- [squire-integration.md](./squire-integration.md)
- [tips-and-links-integration.md](./tips-and-links-integration.md)
- [tips-and-links.md](./tips-and-links.md)
- [tips_and_links.md](./tips_and_links.md)

### Report comprehensive, coverage, verifica (16)

- [advanced-features-backup.md](./advanced-features-backup.md)
- [advanced-features.md](./advanced-features.md)
- [advanced_features.md](./advanced_features.md)
- [advanced_features_backup.md](./advanced_features_backup.md)
- [comprehensive-backup.md](./comprehensive-backup.md)
- [comprehensive-guide-backup.md](./comprehensive-guide-backup.md)
- [comprehensive-guide.md](./comprehensive-guide.md)
- [comprehensive.md](./comprehensive.md)
- [comprehensive_guide.md](./comprehensive_guide.md)
- [comprehensive_guide_backup.md](./comprehensive_guide_backup.md)
- [coverage-full.md](./coverage-full.md)
- [coverage.md](./coverage.md)
- [coverage_clean.md](./coverage_clean.md)
- [coverage_full.md](./coverage_full.md)
- [verification-report.md](./verification-report.md)
- [verification_report.md](./verification_report.md)

### Varie / da classificare (16)

- [.md](./.md)
- [about.md](./about.md)
- [analisi-modelli-doppi.md](./analisi-modelli-doppi.md)
- [data-consolidation-2026-06-30.md](./data-consolidation-2026-06-30.md)
- [here_com.md](./here_com.md)
- [icon-design.md](./icon-design.md)
- [research.md](./research.md)
- [strategy.md](./strategy.md)
- [structure.md](./structure.md)
- [technical.md](./technical.md)
- [todo.md](./todo.md)
- [tutorial.md](./tutorial.md)
- [user-research.md](./user-research.md)
- [user_research.md](./user_research.md)
- [windsurf-rules-update.md](./windsurf-rules-update.md)
- [windsurf.md](./windsurf.md)

## Storico / da consolidare

Nessuno di questi file e' stato toccato: sono elencati qui solo per rendere visibile la duplicazione e facilitare un futuro consolidamento manuale (fuori dallo scope di questo task).

### Duplicati esatti in root (stesso contenuto, hash identico)

92 gruppi, 98 file doppioni rispetto al rappresentante canonico gia' linkato nelle sezioni per argomento sopra.

- `00-index.md` — contenuto identico anche in: `00-INDEX.md`
- `address-implementation.md` — contenuto identico anche in: `address_implementation.md`
- `address-migration-guide.md` — contenuto identico anche in: `address_migration_guide.md`
- `address-model-italian.md` — contenuto identico anche in: `address_model_italian.md`
- `address-relationships.md` — contenuto identico anche in: `address_relationships.md`
- `address-resource-summary.md` — contenuto identico anche in: `address-resource-sumy.md`
- `address_resource.md` — contenuto identico anche in: `address-resource-1.md`
- `addressresource_summary.md` — contenuto identico anche in: `addressresource-sumy.md`
- `advanced_features.md` — contenuto identico anche in: `ADVANCED_FEATURES.md`
- `bad_practices.md` — contenuto identico anche in: `BAD_PRACTICES.md`
- `best_practices.md` — contenuto identico anche in: `BEST_PRACTICES.md`
- `changelog.md` — contenuto identico anche in: `CHANGELOG.md`
- `comprehensive_guide.md` — contenuto identico anche in: `COMPREHENSIVE_GUIDE.md`
- `comune-implementation.md` — contenuto identico anche in: `comune_implementation.md`
- `comune-model.md` — contenuto identico anche in: `comune_model.md`
- `comune-sushi-analisi.md` — contenuto identico anche in: `comune_sushi_analisi.md`
- `comune-sushi-conversion.md` — contenuto identico anche in: `comune_sushi_conversion.md`
- `comune-sushi-implementazione.md` — contenuto identico anche in: `comune_sushi_implementazione.md`
- `comune-unificazione-analisi.md` — contenuto identico anche in: `comune_unificazione_analisi.md`
- `comune_sushi_implementation.md` — contenuto identico anche in: `comune-sushi-implementation-1.md`
- `comuni-json-usage.md` — contenuto identico anche in: `comuni_json_usage.md`
- `conflict-resolutiones.md` — contenuto identico anche in: `conflict-resolution-fixes.md`, `conflict_resolution_fixes.md`
- `consolidamento-modelli-geografici.md` — contenuto identico anche in: `consolidamento_modelli_geografici.md`
- `correzioni_phpstan_multiple_completate.md` — contenuto identico anche in: `CORREZIONI_PHPSTAN_MULTIPLE_COMPLETATE.md`
- `daisyui.md` — contenuto identico anche in: `DAISYUI.md`
- `data-consolidation-2026-06-30.md` — contenuto identico anche in: `DATA-CONSOLIDATION-2026-06-30.md`
- `enums-implementation.md` — contenuto identico anche in: `enums_implementation.md`
- `false_friends.md` — contenuto identico anche in: `FALSE_FRIENDS.md`
- `filament-integration.md` — contenuto identico anche in: `filament_integration.md`
- `form-schema-reuse.md` — contenuto identico anche in: `form_schema_reuse.md`
- `geo-actions-summary.md` — contenuto identico anche in: `geo-actions-sumy.md`
- `geo-entities.md` — contenuto identico anche in: `geo_entities.md`
- `geo-json-vs-sushi-comparison.md` — contenuto identico anche in: `geo_json_vs_sushi_comparison.md`
- `geo-sushi-comparison.md` — contenuto identico anche in: `geo_sushi_comparison.md`
- `geo_json_model.md` — contenuto identico anche in: `geo-json-model-1.md`
- `geojsonmodel-vs-sushi.md` — contenuto identico anche in: `geojsonmodel_vs_sushi.md`
- `gestione-dati-geografici-compendio.md` — contenuto identico anche in: `gestione_dati_geografici_compendio.md`
- `github_interaction_log.md` — contenuto identico anche in: `GITHUB_INTERACTION_LOG.md`
- `implementation_sumy.md` — contenuto identico anche in: `implementation_summary.md`, `implementation-sumy.md`
- `indice-documentazione.md` — contenuto identico anche in: `indice_documentazione.md`
- `inheritance_violations_fixed.md` — contenuto identico anche in: `inheritance-violations-fixed.md`
- `json-database.md` — contenuto identico anche in: `json_database.md`
- `json-usage.md` — contenuto identico anche in: `json_usage.md`
- `laravel-sushi-analysis.md` — contenuto identico anche in: `laravel_sushi_analysis.md`
- `laravel-sushi-guide.md` — contenuto identico anche in: `laravel_sushi_guide.md`
- `license.md` — contenuto identico anche in: `LICENSE.md`
- `location-select.md` — contenuto identico anche in: `location_select.md`
- `mcp_server_recommended.md` — contenuto identico anche in: `MCP_SERVER_RECOMMENDED.md`
- `mcp_tools_integration.md` — contenuto identico anche in: `MCP_TOOLS_INTEGRATION.md`
- `merge-conflicts-analysis.md` — contenuto identico anche in: `merge_conflicts_analysis.md`
- `metodi_duplicati_analisi.md` — contenuto identico anche in: `METODI_DUPLICATI_ANALISI.md`
- `migration-guide.md` — contenuto identico anche in: `migration_guide.md`
- `migration_naming_pattern.md` — contenuto identico anche in: `migration-naming-pattern-1.md`
- `model-inheritance-pattern.md` — contenuto identico anche in: `model_inheritance_pattern.md`
- `modelli-factory-seeder-analisi.md` — contenuto identico anche in: `modelli_factory_seeder_analisi.md`
- `module-geo.md` — contenuto identico anche in: `module_geo.md`
- `modules-optimization-summary.md` — contenuto identico anche in: `modules-optimization-sumy.md`
- `morphs-relationship-patterns.md` — contenuto identico anche in: `morphs_relationship_patterns.md`
- `naming-conventions.md` — contenuto identico anche in: `naming_conventions.md`
- `on-demand-pattern.md` — contenuto identico anche in: `ON-DEMAND-PATTERN.md`
- `optimization-recommendations.md` — contenuto identico anche in: `optimization_recommendations.md`
- `optimization-sumy-report.md` — contenuto identico anche in: `optimization-summary-report.md`
- `performance-optimization.md` — contenuto identico anche in: `PERFORMANCE-OPTIMIZATION.md`
- `phpstan-activity-fixes-completed.md` — contenuto identico anche in: `phpstan_activity_fixes_completed.md`
- `phpstan-errors-roadmap.md` — contenuto identico anche in: `phpstan-errors-roadmap-2026-01-12.md`
- `phpstan-return-type-errors.md` — contenuto identico anche in: `phpstan_return_type_errors.md`
- `phpstan_fixes.md` — contenuto identico anche in: `PHPSTAN_FIXES.md`
- `phpstanes.md` — contenuto identico anche in: `phpstan_fixes_uppercase.md`
- `place-address-schemaorg.md` — contenuto identico anche in: `place_address_schemaorg.md`
- `prd.md` — contenuto identico anche in: `PRD.md`
- `product_launch_plan.md` — contenuto identico anche in: `PRODUCT_LAUNCH_PLAN.md`
- `product_roadmap.md` — contenuto identico anche in: `PRODUCT_ROADMAP.md`
- `product_strategy.md` — contenuto identico anche in: `PRODUCT_STRATEGY.md`
- `project-structure.md` — contenuto identico anche in: `PROJECT-STRUCTURE.md`
- `project.md` — contenuto identico anche in: `project_backup.md`, `PROJECT.md`
- `qmd-setup.md` — contenuto identico anche in: `QMD-SETUP.md`
- `redundancy_analysis.md` — contenuto identico anche in: `REDUNDANCY_ANALYSIS.md`
- `relationship_methods_duplicate_list.md` — contenuto identico anche in: `RELATIONSHIP_METHODS_DUPLICATE_LIST.md`
- `roadmap.md` — contenuto identico anche in: `ROADMAP.md`
- `scripts-location-convention.md` — contenuto identico anche in: `scripts_location_convention.md`
- `session_summary_refactoring.md` — contenuto identico anche in: `SESSION_SUMMARY_REFACTORING.md`
- `sprint_planning.md` — contenuto identico anche in: `SPRINT_PLANNING.md`
- `squire-integration.md` — contenuto identico anche in: `squire_integration.md`
- `sushi-configuration.md` — contenuto identico anche in: `sushi_configuration.md`
- `sushi-implementation-analysis.md` — contenuto identico anche in: `sushi_implementation_analysis.md`
- `sushi-implementation-guide.md` — contenuto identico anche in: `sushi_implementation_guide.md`
- `sushi-models-dependency-cycle-fix.md` — contenuto identico anche in: `sushi_models_dependency_cycle_fix.md`
- `sushi-to-jsons-analysis.md` — contenuto identico anche in: `sushi_to_jsons_analysis.md`
- `technical.md` — contenuto identico anche in: `TECHNICAL.md`
- `test.md` — contenuto identico anche in: `test1.md`, `test-27-02-2024.md`, `agent_guide.md`, `AGENT_GUIDE.md` (nota: sono tutti file vuoti/0 byte, "identici" solo perche' privi di contenuto, non correlati per argomento)
- `unified-comune-model-analysis.md` — contenuto identico anche in: `unified_comune_model_analysis.md`
- `user_research.md` — contenuto identico anche in: `USER_RESEARCH.md`

### Cartelle da consolidare (accumulo di sessioni/duplicati strutturali)

- [`root-md-files/`](./root-md-files/) — 38 file, in gran parte varianti maiuscole/minuscole/underscore degli stessi contenuti (es. `agent-guide.md` / `agent_guide.md` / `AGENT_GUIDE.md`, `agents-policy.md` / `agents_policy.md` / `AGENTS_POLICY.md`, `changelog.md` / `CHANGELOG.md`, `license.md` / `LICENSE.md`).
- [`_integration/`](./_integration/) — 24 file, quasi tutti duplicati (per nome/argomento) dei file address/eloquent/filament/here/polygon gia' presenti in root (es. `address-autocomplete.md` / `address_autocomplete.md`, `here-com.md` / `here_com.md` / `here.md`, `polygon.md` / `polygon-mysql.md` / `polygon_mysql.md`).
- [`prompts/`](./prompts/) — 31 file, prompt e note libere di sessione (es. `bugfix.md`, `collision.md`, `docs1.md`..`docs4.md`), utili come log ma non normativi.
- [`root-txt-files/`](./root-txt-files/) — 4 file, area di raccolta per contenuti fuori standard.

### File di log/coordinamento (non duplicati, ma non normativi)

- [`chat/README.md`](./chat/README.md) — 64 file di handoff/coordinamento tra agenti AI. Consultabile come storico decisioni, non come fonte di verita' architetturale.

### Aree con contenuto probabilmente condiviso tra piu' moduli (verificare pertinenza a Geo)

- [`roadmap/00-INDEX.md`](./roadmap/00-INDEX.md) — l'indice stesso e' uno stub che rimanda a `Themes/docs/shared-components/00-index-Modules.md`; molti dei 70 file numerati (`01-*.md`..`06-*.md`) seguono un template generico di progetto.
- [`claude/README.md`](./claude/README.md) — guida di sviluppo "PTVX" condivisa a livello di progetto, non specifica del modulo Geo.
- [`it/README.md`](./it/README.md) — toolkit di automazione Git generico, non specifico del modulo Geo.

## Manutenzione futura (fuori scope di questo audit)

- Consolidare i 92 gruppi di duplicati esatti in root eliminando le copie non canoniche (richiede approvazione esplicita, questo task non cancella nulla).
- Valutare lo spostamento di `root-md-files/`, `_integration/`, `prompts/` verso `docs/raw/` (che secondo `raw/index.md` e' il layer designato per dump grezzi) o la loro rimozione dopo revisione.
- Verificare se `roadmap/`, `claude/`, `it/` contengono davvero materiale specifico di Geo o sono copie di boilerplate condiviso da disallineare/rimuovere.

