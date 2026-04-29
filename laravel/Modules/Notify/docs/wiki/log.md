# Wiki Log

> Status: append-only
> Updated: 2026-04-15

Recommended format:

```md
## [YYYY-MM-DD] type | title
- sources:
- pages:
- summary:
- next:
```

## [2026-04-15] decision | align fixcity llm wiki to docs/wiki
- sources:
  - Karpathy `llm-wiki.md`
  - `tobi/qmd` README
  - existing FixCity docs under `docs/project/`
- pages:
  - `docs/wiki/README.md`
  - `docs/wiki/index.md`
  - `docs/wiki/log.md`
  - `docs/wiki/concepts/llm-wiki-governance.md`
- summary:
  - fixed the repository mapping to use `docs/` as the raw corpus and `docs/wiki/` as the compiled wiki layer
  - kept the historical `docs/project/llm-wiki-*` files as compatibility shims
  - linked module and theme documentation indexes to the canonical wiki location
- next:
  - create the first reusable module and theme synthesis pages
  - install and verify QMD locally when the package installation completes

## [2026-04-15] ingest | core modules + themes — first compiled overviews
- sources:
  - `laravel/Modules/Cms/docs/content-blocks-system.md`
  - `laravel/Modules/Cms/docs/folio-routing-locale.md`
  - `laravel/Modules/Cms/docs/business-logic-overview.md`
  - `laravel/Modules/UI/docs/module-ui.md`
  - `laravel/Modules/UI/docs/philosophy.md`
  - `laravel/Modules/UI/docs/design-system.md`
  - `laravel/Modules/Lang/docs/translations-system.md`
  - `laravel/Modules/Lang/docs/filosofia-modulo-lang.md`
  - `laravel/Modules/Lang/docs/mcamara-laravel-localization-governance.md`
  - `laravel/Themes/Sixteen/docs/design_comuni_italia_integration.md`
  - `laravel/Themes/Sixteen/docs/design-comuni-compliance.md`
  - `laravel/Themes/TwentyOne/docs/ZEN_ARCHITECTURE_PHILOSOPHY.md`
  - `laravel/Themes/TwentyOne/docs/KINETIC_WEB_DESIGN_SPEC.md`
  - `laravel/Themes/TwentyOne/docs/HOMEPAGE_ARCHITECTURE.md`
- pages:
  - `laravel/Modules/Cms/docs/wiki/overviews/cms-module.md`
  - `laravel/Modules/UI/docs/wiki/overviews/ui-module.md`
  - `laravel/Modules/Lang/docs/wiki/overviews/lang-module.md`
  - `laravel/Themes/Sixteen/docs/wiki/overviews/sixteen-theme.md`
  - `laravel/Themes/TwentyOne/docs/wiki/overviews/twentyone-theme.md`
- summary:
  - Cms: content_blocks JSON system, BlockData rendering, Folio locale routing, mcamara rules
  - UI: design system tokens, component library, Filament AdminPanel, agnostic provider
  - Lang: AutoLabelAction auto-discovery, LangBase classes, mcamara routing governance
  - Sixteen: Bootstrap Italia, AGID compliance, Design Comuni Italia mapping
  - TwentyOne: Zen agnostic container, kinetic web design, GSAP, CMS-driven homepage
- next:
  - compile User, Fixcity, Geo modules
  - compile remaining modules (Media, Seo, Tenant, Blog, Activity, Comment, Rating, Notify, Job, Gdpr)
  - update docs/wiki/overview.md compiled page count

## [2026-04-15] ingest | AI module first compiled pages
- sources:
  - `laravel/Modules/AI/docs/README.md`
  - `laravel/Modules/AI/docs/structure.md`
  - `laravel/Modules/AI/docs/mcp.md`
  - `laravel/Modules/AI/docs/mcp/mcp-integration-overview.md`
  - `laravel/Modules/AI/docs/ollama-strategy.md`
  - `laravel/Modules/AI/docs/tools.md`
- pages:
  - `laravel/Modules/AI/docs/wiki/overviews/ai-module.md`
  - `laravel/Modules/AI/docs/wiki/concepts/ai-mcp-governance.md`
  - `laravel/Modules/AI/docs/wiki/concepts/local-first-ollama-strategy.md`
  - `docs/wiki/modules/ai-module.md`
- summary:
  - compiled the first reusable AI module syntheses in the local module wiki
  - added a root wiki module page so project-wide discovery reaches the local AI wiki
- next:
  - compile Sixteen theme docs into its local wiki
  - keep root wiki overview counts aligned with new module pages

## [2026-04-15] ingest | Karpathy LLM Wiki — adozione moduli/temi
- Fonte: https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f
- Mapping adottato: `docs/` = raw layer, `docs/wiki/` = wiki layer, `docs/.schema/WIKI_SCHEMA.md` = schema
- Creato: `docs/project/llm-wiki-module-adoption.md` — guida completa per moduli e temi
- Creato: `wiki/log.md` in 18 moduli/temi mancanti (Activity, Blog, Cms, Comment, Fixcity, Gdpr, Geo, Job, Lang, Media, Notify, Rating, Seo, Tenant, UI, User, Xot, TwentyOne)
- Aggiornato: `raw/index.md` in tutti i moduli/temi con mapping corretto
- Aggiornato: `docs/wiki/index.md` — tabella moduli/temi con link wiki

## [2026-04-15] ingest | qmd vector embeddings setup
- sources:
  - qmd documentation
  - embedding model: hf_ggml-org/embeddinggemma-300M-GGUF
- pages:
  - bashscripts/docs/wiki/index.md (bootstrap)
  - bashscripts/docs/wiki/log.md (bootstrap)
- summary:
  - created bashscripts wiki structure (separate git repo)
  - bashscripts wiki created with concepts/, entities/, summaries/, comparisons/, overviews/
  - updated root wiki index.md with bashscripts reference
  - qmd embed started (downloading 328MB embeddinggemma-300M model)
  - embedding model downloaded to ~/.cache/qmd/models/
- next:
  - run qmd embed again to complete vector indexing (model ready)
  - document bashscripts scripts (backup, sync, dev automation)

## [2026-04-15] decision | qmd installato e MCP configurato
- sources:
  - https://github.com/tobi/qmd
  - docs/project/qmd-local-docs-search.md
- pages:
  - laravel/.mcp.json (aggiunto server qmd)
  - docs/MCP_SERVERS.md (aggiunta sezione qmd)
- summary:
  - npm install -g qmd completato (v2.1.0)
  - MCP server aggiunto: `"qmd": { "command": "qmd", "args": ["mcp"] }`
  - Collezioni create: fixcity-wiki, fixcity-docs, fixcity-modules, fixcity-themes
  - qmd search testato con successo su corpus markdown
- next:
  - eseguire `qmd embed` per generare embeddings vettoriali
  - aggiornare docs/wiki/index.md con nuovo tool
