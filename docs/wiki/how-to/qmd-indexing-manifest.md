---
name: QMD Indexing Manifest
description: Complete inventory of wiki collections and indexing status for QMD search
type: reference
created: 2026-04-29
---

# QMD Indexing Manifest

Complete inventory of wiki documentation indexed for semantic and keyword search via QMD system.

## Indexing Status Summary

**Last Updated:** 2026-04-29  
**Index Size:** 203.7 MB  
**Total Indexed Files:** 14,827  
**Embedded Vectors:** 96 (semantic search enabled)  
**Pending Embedding:** 9,641 (run `qmd embed` to index)

### Performance Target
- Keyword search: < 2 seconds
- Semantic search: < 2 seconds (with vectors cached)
- Index update frequency: automatic (22h cycles)

---

## Primary Collections for PTVX

### Collectioni PTVX (da registrare)

Il mono `base_ptvx_fila5` non ha ancora collection QMD dedicate. Dalla root progetto:

```bash
cd /var/www/_bases/base_ptvx_fila5
qmd collection add ptvx-wiki docs/wiki
qmd collection add ptvx-mod-ui laravel/Modules/UI/docs
qmd collection add ptvx-mod-ptv laravel/Modules/Ptv/docs
qmd collection add ptvx-mod-xot laravel/Modules/Xot/docs
qmd update -c ptvx-wiki -c ptvx-mod-ui -c ptvx-mod-ptv -c ptvx-mod-xot
```

Verificare con `qmd collection show ptvx-wiki` che il path punti a `docs/wiki`, non a una cartella vuota omonima.

**Ultimo ingest wiki (2026-06-15):** pagine `block-rendering-and-optional-services`, `phpstan-scheda-actions`, `has-relationship-model-class`; pattern root `phpstan-optional-contracts`.

### Collection: `wiki` (qmd://wiki/)
**Purpose:** Root project wiki and cross-cutting concepts  
**Pattern:** `docs/wiki/**/*.md`  
**Files Indexed:** 93  
**Last Updated:** 21h ago

**Coverage:**
- `docs/wiki/index.md` — Project entry point
- `docs/wiki/concepts/` — Architecture patterns, design concepts
- `docs/wiki/how-to/` — Implementation guides (including QMD, context-mode, Kilo Code)
- `docs/wiki/sources/` — Documentation summaries and artifacts
- `docs/wiki/log.md` — Activity log

**Example Queries:**
```bash
qmd search "actions over services" -c wiki
qmd search "second brain" -c wiki --semantic
```

### Collection: `modules-docs` (qmd://modules-docs/)
**Purpose:** Module-level documentation (all Laravel modules)  
**Pattern:** `laravel/Modules/*/docs/wiki/**/*.md`  
**Files Indexed:** 446  
**Last Updated:** 22h ago

**Coverage:** 
- Activity module: 22 files
- Gdpr module: 22 files
- All other modules: ~400 files

**Example Queries:**
```bash
qmd search "gdpr consent" -c modules-docs
qmd search "activity tracking" -c modules-docs --semantic
```

### Collection: `main_docs` (qmd://main_docs/)
**Purpose:** Primary documentation repository  
**Pattern:** Various  
**Files Indexed:** 740  
**Last Updated:** 21h ago

### Collection: `bashscripts_docs` (qmd://bashscripts_docs/)
**Purpose:** Bash script documentation  
**Pattern:** `bashscripts/*/docs/**/*.md`  
**Files Indexed:** 655  
**Last Updated:** 22h ago

---

## Module Collections (Individual per Module)

Each module has its own dedicated QMD collection for targeted searches:

| Module | Collection | Files | Last Updated |
|--------|-----------|-------|---------------|
| Badge | `module_Badge` | 22 | 14d ago |
| CertFisc | `module_CertFisc` | 22 | 14d ago |
| ContoAnnuale | `module_ContoAnnuale` | 29 | 14d ago |
| DbForge | `module_DbForge` | 46 | 22h ago |
| Europa | `module_Europa` | (see status) | (see status) |
| ... | ... | ... | ... |

**Query Individual Module:**
```bash
qmd search "feature name" -c module_Activity
qmd search "workflow pattern" -c module_Gdpr --semantic
```

---

## Coverage Gaps & Opportunities

### Fully Covered ✓
- Root wiki (`docs/wiki/`) — 93 files
- Module documentation — 446 files  
- Bash scripts — 655 files

### Pending Embedding
- 9,641 files awaiting vector embedding (needed for semantic search)
- Action: Run `qmd embed` to process pending files

### Not Indexed (Intentional)
- Code files (*.php) — indexed via AST chunking only
- Vendor code — excluded (vendor/, node_modules/)
- Build artifacts — excluded

---

## Search Capabilities by Collection

### Keyword Search
Available on all collections. Examples:

```bash
# Search root wiki
qmd search "context-mode" -c wiki

# Search all modules
qmd search "event sourcing" -c modules-docs

# Search specific module
qmd search "consent workflow" -c module_Gdpr
```

### Semantic Search
Enabled for collections with embedded vectors (currently limited — see embedding status):

```bash
# Semantic search (requires vectors)
qmd search "user permissions and access control" -c wiki --semantic

# Find similar concepts
qmd search "database migration strategy" -c modules-docs --semantic
```

**Status:** Only 96 of 14,827 vectors embedded. Run `qmd embed` to enable full semantic search.

---

## Maintenance Schedule

| Task | Frequency | Command | Owner |
|------|-----------|---------|-------|
| Embed new docs | Weekly | `qmd embed --collection wiki` | Dev |
| Full re-index | Monthly | `qmd rebuild` | DevOps |
| Verify coverage | Ad-hoc | `qmd ls {collection}` | Dev |
| Archive old docs | Quarterly | Move to `_archive/` | Tech Lead |

---

## Configuration References

### QMD Configuration
- **Index Location:** `/home/zorin/.cache/qmd/index.sqlite`
- **Embedding Model:** `ggml-org/embeddinggemma-300M` (CPU-based, no GPU)
- **Performance Target:** 2000ms for search queries

### Context-Mode Integration
- **Config:** `.context-mode.json` (project root)
- **FTS5 Backend:** Provides semantic search fallback
- **Policy:** Index only documentation, exclude code

---

## Integration Points for This Story

### For Wiki Search Implementation
1. **Primary Tool:** QMD collections for keyword search
2. **Semantic Search:** Context-mode FTS5 as fallback if QMD vectors unavailable
3. **Collections to Query:** 
   - `wiki` — for root documentation
   - `modules-docs` — for module-specific docs
   - Individual `module_*` collections — for focused searches
4. **Performance Baseline:** Current index shows response times within budget

### For Cross-Reference Detection
1. Use `qmd multi_get` to fetch related documents
2. Parse frontmatter `related:` field for explicit cross-references
3. Use semantic similarity for implicit relationships

---

## Commands for Story 2.1 Implementation

**Check Embedding Status:**
```bash
qmd status | grep -A 5 "Documents"
```

**Embed Pending Files (before launching semantic search):**
```bash
qmd embed --collection wiki
qmd embed --collection modules-docs
```

**Search Root Wiki:**
```bash
qmd search "your query" -c wiki
```

**Search All Module Docs:**
```bash
qmd search "your query" -c modules-docs
```

**Search Specific Module:**
```bash
qmd search "your query" -c module_ModuleName
```

**Fetch Specific Document:**
```bash
qmd get "qmd://wiki/concepts/second-brain-operating-model.md"
```

---

## Notes for Developers

- **Stale data:** If results seem outdated, run `qmd collection update {collection}`
- **Missing docs:** If new wiki files don't appear, run `qmd embed --collection wiki`
- **Performance degradation:** If searches slow down, check index size with `qmd status`
- **Semantic search disabled:** Enable with `qmd embed` (one-time 30-50 min process depending on CPU)

---

**Prepared for:** Story 2.1 - QMD Search Integration  
**Status:** ✓ Task 1 Complete (Analysis & Manifest Created)
