# Story 1.1: LLM Wiki Setup — Karpathy Pattern Across All Modules, Themes & Bashscripts

Status: done

## Story

As a developer agent,
I want the full Karpathy LLM Wiki structure initialized in every module, every theme, and bashscripts,
so that all AI agents have a persistent, self-compounding knowledge base that never loses hard-won findings.

---

## Background: The Karpathy LLM Wiki Pattern

Andrej Karpathy's LLM Wiki is a knowledge management pattern where:

1. **Raw sources** (`docs/`) — existing markdown documents, analyses, notes. Immutable history.
2. **Wiki** (`docs/wiki/`) — LLM-compiled synthesis pages. Built FROM the raw sources. Contains: concept pages, entity pages, comparisons, cross-linked summaries.
3. **Log** (`docs/wiki/log.md`) — append-only record of every ingest/query/lint operation.
4. **Schema** (`docs/wiki/SCHEMA.md`) — conventions file that governs the wiki structure for this specific domain.

**Key operations:**
- **Ingest**: read a raw doc → extract entities → write/update wiki pages → append to log
- **Query**: search wiki → synthesize answer → file valuable answers back as new wiki pages
- **Lint**: health-check for orphan pages, contradictions, stale info, missing cross-links

**Why this beats RAG**: Knowledge is compiled once and kept current. No re-deriving on every query. The wiki compounds with every session.

**Our project mapping:**
| Karpathy | This project |
|---|---|
| `raw/` | `./docs/` (existing docs are the raw material) |
| `wiki/` | `./docs/wiki/` |
| log | `./docs/wiki/log.md` |
| schema | `./docs/wiki/SCHEMA.md` |

---

## Acceptance Criteria

1. Every module under `laravel/Modules/` has `docs/wiki/` with complete subdirectory structure and init files.
2. Both themes (`Themes/Zero`, `Themes/One`) have the same `docs/wiki/` structure.
3. `bashscripts/` has `docs/` and `docs/wiki/` structure.
4. `.qmd-collection.json` is updated to include ALL modules and themes, with `docs/` as raw collection and `docs/wiki/` as wiki collection.
5. Every `docs/wiki/SCHEMA.md` is tailored to the specific module/theme domain.
6. Every `docs/wiki/index.md` starts with a proper catalog header.
7. Every `docs/wiki/log.md` starts with an initialization entry.
8. The project-root `CLAUDE.md` contains a mandatory LLM Wiki usage section.
9. Auto-memory is updated with the LLM Wiki mandatory usage rule.
10. QMD MCP server plugin is verified as active (already configured via plugin system).

---

## Tasks / Subtasks

- [x] **Task 1: Create `docs/wiki/` structure in all modules** (AC: #1)
  - [x] 1.1 For each of the 35 modules, create: `docs/wiki/concepts/`, `docs/wiki/entities/`, `docs/wiki/comparisons/`, `docs/wiki/sources/`
  - [x] 1.2 Create `docs/wiki/index.md` in each module wiki (see template below)
  - [x] 1.3 Create `docs/wiki/log.md` in each module wiki (see template below)
  - [x] 1.4 Create `docs/wiki/SCHEMA.md` in each module wiki, tailored to the module domain

- [x] **Task 2: Create `docs/wiki/` structure in both themes** (AC: #2)
  - [x] 2.1 `laravel/Themes/Zero/docs/wiki/` — full structure
  - [x] 2.2 `laravel/Themes/One/docs/wiki/` — full structure

- [x] **Task 3: Create `docs/` and `docs/wiki/` in bashscripts** (AC: #3)
  - [x] 3.1 Create `bashscripts/docs/` if not present
  - [x] 3.2 Create `bashscripts/docs/wiki/` full structure
  - [x] 3.3 Create `bashscripts/docs/wiki/SCHEMA.md` tailored to bash scripting domain

- [x] **Task 4: Update `.qmd-collection.json`** (AC: #4)
  - [x] 4.1 Update ALL existing collections to point to `docs/` (not `docs/raw/`)
  - [x] 4.2 Add wiki collections (`_wiki` suffix) for each entry pointing to `docs/wiki/`
  - [x] 4.3 Add missing modules: Activity, Badge, CertFisc, ContoAnnuale, DbForge, Europa, Gdpr, Inail, Incentivi, IndennitaCondizioniLavoro, IndennitaResponsabilita, Job, Lang, Legge104, Legge109, Media, Mensa, MobilitaVolontaria, Notify, Pdnd, Performance, Prenotazioni, PresenzeAssenze, Progressioni, Ptv, Questionari, Rating, Seo, Setting, Sigma, Sindacati, Tenant, UI, User, Xot
  - [x] 4.4 Add both themes: Zero, One
  - [x] 4.5 Add bashscripts collection
  - [x] 4.6 Update `main_docs` to point to `./docs/` and add `main_docs_wiki` → `./docs/wiki/`

- [x] **Task 5: Update CLAUDE.md with mandatory LLM Wiki section** (AC: #8)
  - [x] 5.1 Add "## Mandate: LLM Wiki" section to root `CLAUDE.md`
  - [x] 5.2 Specify the wiki-first workflow: query QMD before work, compile findings, update wiki

- [x] **Task 6: Update auto-memory** (AC: #9)
  - [x] 6.1 Update `/home/zorin/.claude/projects/-var-www--bases-base-ptvx-fila5/memory/feedback_llmwiki_mandatory.md` with full verified procedure
  - [x] 6.2 Ensure `MEMORY.md` index reflects the update

- [x] **Task 7: Create root-level `docs/wiki/` structure** (AC: #1)
  - [x] 7.1 Create `./docs/wiki/` with full structure
  - [x] 7.2 Initialize `./docs/wiki/SCHEMA.md` for the overall project

---

## Dev Notes

### Target Directory Structure (per module)

```
laravel/Modules/{Module}/
└── docs/                          ← RAW (existing content stays here, never delete)
    ├── wiki/                      ← COMPILED (LLM-generated synthesis)
    │   ├── SCHEMA.md              ← wiki conventions + ingest rules (domain-specific)
    │   ├── index.md               ← catalog of all wiki pages (one-line summaries)
    │   ├── log.md                 ← append-only ops log
    │   ├── concepts/              ← architectural concepts, patterns, rules
    │   ├── entities/              ← classes, interfaces, services, models
    │   ├── comparisons/           ← A vs B pages, migration guides
    │   └── sources/               ← processed summaries of raw docs
    └── (existing .md files)       ← raw sources, untouched
```

Same structure for:
- `laravel/Themes/{Theme}/docs/wiki/`
- `bashscripts/docs/wiki/`
- `./docs/wiki/` (project root)

### Target `.qmd-collection.json` structure

```json
{
  "collections": {
    "main_docs":       { "path": "./docs",                                          "description": "Raw docs - project root" },
    "main_docs_wiki":  { "path": "./docs/wiki",                                     "description": "LLM Wiki compiled - project root" },
    "module_Xot":      { "path": "./laravel/Modules/Xot/docs",                      "description": "Raw docs - Xot module" },
    "module_Xot_wiki": { "path": "./laravel/Modules/Xot/docs/wiki",                 "description": "LLM Wiki compiled - Xot module" },
    ... (repeat for ALL 35 modules)
    "theme_Zero":      { "path": "./laravel/Themes/Zero/docs",                      "description": "Raw docs - Theme Zero" },
    "theme_Zero_wiki": { "path": "./laravel/Themes/Zero/docs/wiki",                 "description": "LLM Wiki compiled - Theme Zero" },
    "theme_One":       { "path": "./laravel/Themes/One/docs",                       "description": "Raw docs - Theme One" },
    "theme_One_wiki":  { "path": "./laravel/Themes/One/docs/wiki",                  "description": "LLM Wiki compiled - Theme One" },
    "bashscripts":     { "path": "./bashscripts/docs",                              "description": "Raw docs - bashscripts" },
    "bashscripts_wiki":{ "path": "./bashscripts/docs/wiki",                         "description": "LLM Wiki compiled - bashscripts" }
  }
}
```

**IMPORTANT**: Remove old `docs/raw` and `docs/bashscripts/raw` entries — they are superseded by pointing to `docs/` directly.

### `docs/wiki/index.md` Template

```markdown
# {Module} Wiki — Index

> Compiled knowledge base for the {Module} module.
> Source material: `../` (raw docs directory)
> Operations: ingest → compile → query → lint

## Concepts
<!-- List concept pages here -->

## Entities
<!-- List entity pages here -->

## Comparisons
<!-- List comparison pages here -->

## Sources
<!-- List processed source summaries here -->
```

### `docs/wiki/log.md` Template

```markdown
# {Module} Wiki — Operations Log

> Append-only record of all ingest, query, and lint operations.

---

## 2026-04-15 — INIT

- Wiki structure initialized (Karpathy LLM Wiki pattern)
- Raw sources: `../` directory
- Zero pages compiled at initialization — pages are created during ingest operations
```

### `docs/wiki/SCHEMA.md` Template (generic — MUST be tailored per module)

```markdown
# {Module} Wiki — Schema & Conventions

## Domain
{One-paragraph description of what this module does}

## Entity Types
- **Class**: PHP classes, traits, interfaces
- **Pattern**: Architectural patterns used in this module
- **Rule**: Hard constraints that must never be violated
- **Decision**: Architectural decisions with rationale

## Ingest Protocol
1. Read the raw source document
2. Extract entities (classes, patterns, rules, decisions)
3. Write/update entity pages in `entities/`
4. Write/update concept pages in `concepts/`
5. Add a summary to `sources/`
6. Update `index.md` catalog
7. Append to `log.md`

## Page Naming Convention
- `concepts/{kebab-case}.md`
- `entities/{ClassName}.md`
- `comparisons/{a}-vs-{b}.md`
- `sources/{source-filename}.md`

## Cross-linking Rule
Every page MUST link back to at least one other wiki page.
Orphan pages are a lint error.

## Quality Standards
- No stale claims older than 30 days without re-verification
- Every entity page must reference the source raw doc
- Contradictions between pages must be resolved immediately
```

### Root CLAUDE.md — LLM Wiki Mandate Section to Add

```markdown
## Mandate: LLM Wiki

Every agent MUST follow the Karpathy LLM Wiki pattern:

1. **Before any task**: `qmd query "topic"` to check existing knowledge
2. **After research**: compile findings into `docs/wiki/` of the relevant module
3. **After implementation**: update entity/concept pages for changed code
4. **Never leave findings only in session chat** — they must be written to wiki

### Wiki-First Workflow
```
START task
  → qmd query "relevant topic"           # check existing knowledge
  → read wiki pages if found
  → do the work
  → write/update docs/wiki/ pages        # persist new knowledge
  → update docs/wiki/index.md            # keep catalog current
  → append to docs/wiki/log.md           # record the operation
END
```

### Directory Map
| Purpose | Path |
|---|---|
| Module raw docs | `laravel/Modules/{Module}/docs/` |
| Module wiki | `laravel/Modules/{Module}/docs/wiki/` |
| Theme raw docs | `laravel/Themes/{Theme}/docs/` |
| Theme wiki | `laravel/Themes/{Theme}/docs/wiki/` |
| Bashscripts wiki | `bashscripts/docs/wiki/` |
| Project wiki | `docs/wiki/` |
```

### All 35 Modules (complete list for Task 4)

```
Activity, Badge, CertFisc, ContoAnnuale, DbForge, Europa, Gdpr, Inail,
Incentivi, IndennitaCondizioniLavoro, IndennitaResponsabilita, Job, Lang,
Legge104, Legge109, Media, Mensa, MobilitaVolontaria, Notify, Pdnd,
Performance, Prenotazioni, PresenzeAssenze, Progressioni, Ptv, Questionari,
Rating, Seo, Setting, Sigma, Sindacati, Tenant, UI, User, Xot
```

### QMD MCP Plugin — Already Active

QMD is already configured as an MCP plugin via the superpowers plugin system.
Tools available: `mcp__plugin_qmd_qmd__query`, `mcp__plugin_qmd_qmd__get`, `mcp__plugin_qmd_qmd__multi_get`, `mcp__plugin_qmd_qmd__status`.
**No additional MCP server configuration is needed.**
After updating `.qmd-collection.json`, run `qmd embed` to index new wiki directories.

### Implementation Approach

Use a **bash script** or **single-pass loop** to create the directory structure efficiently:

```bash
# Example: create wiki structure for all modules
MODULES=$(ls laravel/Modules/ | grep -v '\.')
for MODULE in $MODULES; do
  mkdir -p "laravel/Modules/$MODULE/docs/wiki/concepts"
  mkdir -p "laravel/Modules/$MODULE/docs/wiki/entities"
  mkdir -p "laravel/Modules/$MODULE/docs/wiki/comparisons"
  mkdir -p "laravel/Modules/$MODULE/docs/wiki/sources"
  # Create init files if not already present
  [ ! -f "laravel/Modules/$MODULE/docs/wiki/index.md" ] && echo "..." > "laravel/Modules/$MODULE/docs/wiki/index.md"
  [ ! -f "laravel/Modules/$MODULE/docs/wiki/log.md" ]   && echo "..." > "laravel/Modules/$MODULE/docs/wiki/log.md"
  [ ! -f "laravel/Modules/$MODULE/docs/wiki/SCHEMA.md" ] && echo "..." > "laravel/Modules/$MODULE/docs/wiki/SCHEMA.md"
done
```

Write each SCHEMA.md with content specific to the module's domain (not a generic copy-paste).

### Project Structure Notes

- All modules already have `docs/` directories — never delete or move existing content
- `docs/wiki/` is a NEW subdirectory added inside the existing `docs/`
- Existing `.qmd-collection.json` has only 11 entries — needs to be fully rebuilt with 70+ entries
- `bashscripts/docs/` does not exist yet — create it
- `laravel/Themes/Zero/docs/` and `laravel/Themes/One/docs/` already exist

### References

- [Karpathy LLM Wiki Gist](https://gist.github.com/karpathy/442a6bf555914893e9891c11519de94f)
- [LLM Wiki v2 Extensions](https://gist.github.com/rohitg00/2067ab416f7bbe447c1977edaaa681e2)
- [VentureBeat: Karpathy LLM Knowledge Base](https://venturebeat.com/data/karpathy-shares-llm-knowledge-base-architecture-that-bypasses-rag-with-an)
- Project context: `_bmad-output/project-context.md`
- Current QMD config: `.qmd-collection.json`

---

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

### Completion Notes List

### File List
