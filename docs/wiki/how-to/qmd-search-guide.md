---
name: QMD Search Complete Guide
description: Comprehensive guide to using QMD (Query Markdown Database) for wiki search and documentation discovery
type: how-to
related: [context-mode-overflow-prevention.md, indexing-module-documentation.md]
---

# QMD Search Complete Guide

QMD (Query Markdown Database) is a powerful semantic search system for markdown documentation. This guide covers installation, configuration, usage, and best practices across all project wikis.

## What is QMD?

QMD is a full-text and semantic search database that indexes markdown files across your codebase. It provides:
- **Keyword search** — Find documents by exact terms
- **Semantic search** — Find related concepts using embeddings
- **Cross-collection search** — Query multiple wiki directories simultaneously
- **Performance optimized** — < 2 second response times

## Installation & Setup

### System Requirements

- Node.js 18+
- npm or yarn
- ~200 MB disk space for embeddings cache

### Global Installation

```bash
npm install -g @kilocode/qmd
```

Verify installation:
```bash
qmd status
```

## Core Collections

The project maintains these indexed collections:

| Collection | Path | Files | Updated |
|------------|------|-------|---------|
| `wiki` | `docs/wiki/` | 93 | Last 21h |
| `modules-docs` | `laravel/Modules/*/docs/` | 446 | Last 22h |
| `fixcity-docs` | External docs | 1542 | Last 21h |
| `module_*` | Per-module wikis | Variable | Per-module |

### Adding New Collections

```bash
# Add a new module's wiki to QMD
qmd collection add module_YourModule laravel/Modules/YourModule/docs/wiki

# List all collections
qmd ls
```

## Search Commands

### Basic Keyword Search

```bash
# Search across all collections
qmd search "authentication patterns"

# Search within a specific collection
qmd search "auth" -c module_Gdpr

# Limit results
qmd search "models" -c wiki --limit 5
```

### Semantic Search

```bash
# Find related concepts
qmd search "user permissions" --semantic

# Combine keyword + semantic
qmd search "GDPR compliance" -c module_Gdpr --semantic
```

### Get Specific Document

```bash
# Fetch a known document
qmd get qmd://wiki/concepts/actions-over-services.md

# Extract from specific collection
qmd get qmd://module_Gdpr/models.md
```

### Batch Operations

```bash
# Multi-get for multiple documents
qmd multi_get qmd://wiki/index.md qmd://module_Gdpr/index.md
```

## Configuration

### .qmd.json Setup

Create `.qmd.json` in project root for persistent configuration:

```json
{
  "collections": [
    {
      "name": "wiki",
      "pattern": "docs/wiki/**/*.md",
      "description": "Root project wiki"
    },
    {
      "name": "module_Activity",
      "pattern": "laravel/Modules/Activity/docs/wiki/**/*.md",
      "description": "Activity module documentation"
    }
  ],
  "embeddings": {
    "model": "gemma-300m",
    "batchSize": 32
  },
  "performance": {
    "maxResults": 10,
    "timeout": 2000
  }
}
```

### Embedding Models

Current setup uses:
- **Embedding**: `ggml-org/embedding-gemma-300M-GGUF` (300M parameters)
- **Reranking**: `ggml-org/Qwen3-Reranker-0.6B-Q8_0-GGUF`
- **Generation**: `tobil/qmd-query-expansion-1.7B-gguf`

Models are cached locally at: `~/.cache/qmd/models/`

## Workflow: Using QMD in Development

### Before Starting a Task

```bash
# Query existing documentation
qmd search "your feature topic"

# Example: Adding GDPR consent
qmd search "consent workflow" -c module_Gdpr --semantic

# Review all related pages
qmd search "GDPR consent" --semantic --limit 10
```

### After Implementing

1. **Document findings** in appropriate wiki
2. **Update index** (automatic if QMD is monitoring)
3. **Add cross-references** using QMD collection links
4. **Test search** to verify discoverability

### Search-Driven Documentation Flow

```
START feature work
  → qmd search "related concepts"
  → read returned wiki pages
  → implement feature
  → document results in docs/wiki/{module}/
  → update docs/wiki/log.md with changes
  → qmd embed (if needed for immediate indexing)
END
```

## Performance Optimization

### Current Status

```
Device:        4 math cores (CPU only, no GPU)
Documents:     14827 files indexed
Vectors:       96 embedded (~0.6%)
Pending:       9641 need embedding
Index Size:    203.7 MB
Update Cycle:  21 hours
```

### Accelerating Embeddings

GPU acceleration would improve speed 10-50x:

**CUDA** (NVIDIA):
```bash
export GGML_CUDA=1
qmd embed
```

**Vulkan** (AMD/Intel):
```bash
export GGML_VULKAN=1
qmd embed
```

**Metal** (Apple):
```bash
export GGML_METAL=1
qmd embed
```

### Embedding New Files

Force immediate indexing:
```bash
qmd embed --collection wiki
qmd embed --collection module_Gdpr
```

## Integration with Context-Mode

QMD works alongside context-mode for comprehensive search:

- **QMD** — Fast semantic/keyword search across all wikis
- **Context-Mode FTS5** — Token-efficient sandbox search for code analysis

### Using Both

```bash
# Step 1: Quick discovery with QMD
qmd search "audit logging patterns" -c module_Activity

# Step 2: Deep analysis with context-mode
ctx_batch_execute [
  {label: "Audit Code", command: "grep -r 'audit' laravel/Modules/Activity/app/"}
]
```

## Adding Context to Collections

Help QMD understand collection purpose:

```bash
# Add context descriptions
qmd context add qmd://wiki/ "Root project wiki with concepts, guides, and sources"
qmd context add qmd://module_Gdpr/ "GDPR compliance module: consent, data processing, deletion workflows"
qmd context add qmd://module_Activity/ "Activity/audit logging module: events, snapshots, policies"

# Verify
qmd status --verbose
```

## Troubleshooting

### No Results for Valid Terms

**Issue**: Search returns nothing for documented concepts

**Solution**:
```bash
# Check if collection is indexed
qmd ls module_Gdpr | head

# Verify file exists
find laravel/Modules/Gdpr/docs/wiki -name "*.md"

# Force re-index
qmd collection update module_Gdpr
qmd embed --collection module_Gdpr
```

### Slow Searches

**Issue**: Searches take > 2 seconds

**Solution**:
1. Check GPU status: `qmd status`
2. If CPU-only, enable GPU acceleration (see above)
3. Limit results: `qmd search "term" --limit 5`

### Missing Files

**Issue**: Recent documentation not appearing in results

**Solution**:
```bash
# Check update time
qmd status | grep "Updated:"

# Force refresh collection
qmd collection update module_Gdpr

# Embed new documents
qmd embed --collection module_Gdpr
```

## Best Practices

### Documentation Frontmatter

Include QMD metadata in all wiki files:

```markdown
---
qmd: "keyword1, keyword2, concept-slug, module-name"
related: [other-page.md, ../concept.md]
---
```

### Collection Naming

Use consistent naming for module collections:
- Single module: `module_ModuleName`
- Theme: `theme_ThemeName`
- Feature area: `area_FeatureName`

### Cross-Referencing

Link between wikis using collection notation:
```markdown
[Consent Workflow](qmd://module_Gdpr/consent-workflows.md)
[User Model Pattern](qmd://module_User/models.md)
```

### Search Queries

Effective search patterns:
- **Broad**: `"authentication"` (returns 50+ results)
- **Specific**: `"JWT token validation patterns"` (5-10 results)
- **Semantic**: `"how do we handle permissions"` (related concepts)

## Maintenance Schedule

| Task | Frequency | Command |
|------|-----------|---------|
| Update all collections | Daily | `qmd collection update --all` |
| Embed new vectors | Weekly | `qmd embed --collection wiki` |
| Verify index health | Weekly | `qmd status` |
| Rebuild index | Monthly | `qmd rebuild` |
| Prune old documents | Monthly | `qmd collection prune` |

## References

- [Kilo.ai Documentation](https://kilo.ai/docs/)
- [QMD GitHub Repository](https://github.com/Kilo-Org/qmd)
- [Project QMD Collections](../.qmd.json)

---

**Last Updated**: 2026-04-29  
**Status**: Active  
**Related Stories**: Story 2.1 (QMD Search Integration)
