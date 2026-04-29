---
name: Wiki Search Guide
description: How to use the wiki search interface for finding documentation
type: how-to
related: [qmd-search-guide.md, qmd-indexing-manifest.md]
---

# Wiki Search Guide

Find relevant documentation quickly using the wiki search CLI powered by QMD (Query Markdown Database).

## Quick Start

```bash
# Search root wiki
wiki-search "context-mode"

# Search module documentation
wiki-search --module gdpr "consent workflow"

# Semantic search (find related concepts)
wiki-search --semantic "user permissions and access control"
```

---

## Search Interface

### CLI Command: `wiki-search`

The `wiki-search` command provides a simple interface to search PTVX documentation.

**Location:** `docs/scripts/wiki/wiki-search`

**Installation:**
```bash
# Add to PATH for easy access
export PATH="$PATH:docs/scripts/wiki"

# Then use directly:
wiki-search "your query"

# Or use full path:
./docs/scripts/wiki/wiki-search "your query"
```

---

## Usage Examples

### Keyword Search (Fast - < 500ms)

Search for specific terms across documentation:

```bash
# Search root wiki
wiki-search "actions over services"
wiki-search "second brain operating model"

# Search all module docs
wiki-search "context-mode"
wiki-search "gdpr consent"
```

### Module-Specific Search

Focus search on a specific module's documentation:

```bash
# Syntax: wiki-search --module MODULE "query"

wiki-search --module gdpr "consent workflow"
wiki-search --module activity "event tracking"
wiki-search --module europa "integration patterns"
```

### Semantic Search (Contextual - < 2000ms)

Find related concepts and similar documentation:

```bash
# Find pages related to user permissions
wiki-search --semantic "user permissions and access control"

# Find pages about caching strategies
wiki-search --semantic "caching performance optimization"

# Find architectural patterns
wiki-search --semantic "design patterns and architecture"
```

**Note:** Semantic search requires QMD vector embeddings. If unavailable, falls back to keyword search.

### Related Pages and Cross-References

Discover pages that reference or relate to a specific document:

```bash
# Show pages linking TO this document (backlinks)
wiki-search --related docs/wiki/concepts/actions-over-services.md

# Shows:
# - Pages that explicitly link to this document
# - Pages with semantic similarity
# - Related concepts and implementations
```

See [Semantic Search and Related Pages Guide](./semantic-search-and-related-pages.md) for detailed examples.

### Filter by Document Type

Search for specific types of documentation:

```bash
# Find concept pages
wiki-search --type concept "design patterns"

# Find how-to guides
wiki-search --type guide "module documentation"

# Find reference pages
wiki-search --type reference "api"
```

### Control Result Count

```bash
# Get more results
wiki-search --limit 20 "testing"

# Get fewer results (default is 10)
wiki-search --limit 5 "workflow"
```

### Change Output Format

```bash
# Table format (default)
wiki-search "query"

# JSON format
wiki-search --format json "query"

# CSV format
wiki-search --format csv "query"
```

---

## Search Results

### Result Fields

Each result includes:

| Field | Description |
|-------|-------------|
| **Title** | Document name from frontmatter |
| **Path** | Relative path to file |
| **Type** | Document type (concept, guide, reference, example) |
| **Updated** | Last modification date |

### Example Output

```
Search Results:

Title                                   Path                                              Type
─────────────────────────────────────────────────────────────────────────────────────────────
Second Brain Operating Model            docs/wiki/concepts/second-brain-operating-model.md   concept
Context-Mode Overflow Prevention        docs/wiki/how-to/context-mode-overflow-prevention.md  how-to
QMD Search Guide                        docs/wiki/how-to/qmd-search-guide.md                 how-to

Performance: 342ms
✓ Within performance target (< 2000ms)
```

---

## Search Collections

### Available Collections

| Collection | Content | Usage |
|-----------|---------|-------|
| `wiki` | Root wiki (docs/wiki/) | General searches |
| `modules-docs` | All module documentation | Cross-module searches |
| `module_NAME` | Specific module docs | Focused module searches |

### Explicit Collection Selection

```bash
# Search specific collection
wiki-search --collection modules-docs "gdpr"
wiki-search --collection module_Activity "event sourcing"
```

---

## Advanced Queries

### Boolean Search (if supported by QMD)

```bash
# AND query
wiki-search "context-mode AND performance"

# OR query
wiki-search "testing OR quality assurance"

# NOT query
wiki-search "gdpr NOT deprecated"
```

### Phrase Search

```bash
# Search exact phrase (quotes required)
wiki-search '"second brain operating model"'
wiki-search '"context-mode overflow prevention"'
```

### Wildcard Search

```bash
# Wildcard patterns
wiki-search "context*"
wiki-search "gdpr*"
```

---

## Performance & SLA

### Response Time Targets

| Search Type | Target | Typical |
|------------|--------|---------|
| Keyword search | < 2000ms | 200-500ms |
| Semantic search | < 2000ms | 500-1500ms |
| Module-specific | < 1000ms | 100-300ms |

Each result includes performance metrics:

```
Performance: 342ms
✓ Within performance target (< 2000ms)
```

---

## Related Pages & Cross-References

### Finding Related Content

Semantic search returns related pages based on content similarity:

```bash
# Find pages discussing similar topics
wiki-search --semantic "caching strategies"

# Results include pages about:
# - Performance optimization
# - Database indexing
# - Query optimization
# - Memory management
```

### Cross-Reference Detection

Pages that explicitly reference each other appear in results:

```bash
# When searching for a topic, related pages are ranked by:
# 1. Content similarity (semantic)
# 2. Explicit cross-references (via qmd: field)
# 3. Keyword match frequency
```

---

## Troubleshooting

### No Results Found

**Problem:** Search returns no results

**Solutions:**
1. Check query syntax — use exact terms or phrases
2. Try broader search — simplify query
3. Verify collection exists — use `--collection` flag
4. Update index — run `qmd collection update wiki`

```bash
# Example: Try simpler query
wiki-search "gdpr"  # Instead of "gdpr complex workflow implementation"
```

### Slow Search (> 2 seconds)

**Problem:** Search takes longer than 2 seconds

**Causes:**
- Semantic search on large dataset
- Slow system resources
- Index not fully embedded

**Solutions:**
```bash
# Use keyword search instead of semantic
wiki-search "term"  # Instead of --semantic

# Limit results
wiki-search --limit 5 "term"

# Search specific module instead of all docs
wiki-search --module gdpr "term"
```

### Semantic Search Not Working

**Problem:** `--semantic` flag has no effect

**Solutions:**
1. Check embedding status: `qmd status | grep "Pending"`
2. Embed vectors: `qmd embed --collection wiki`
3. Fall back to keyword search

### Wrong Results

**Problem:** Results are irrelevant to query

**Causes:**
- Query too broad
- Multiple meanings of terms
- Poor index coverage

**Solutions:**
1. Make query more specific
2. Use `--type` filter
3. Use module-specific search
4. Try exact phrase search: `"exact phrase"`

---

## Integration with Development Workflow

### Before Starting a Feature

```bash
# Search for existing patterns
wiki-search "your feature type"

# Search module docs
wiki-search --module your_module "related concepts"

# Find similar implementations
wiki-search --semantic "similar problem domain"
```

### During Implementation

```bash
# Find architecture guidelines
wiki-search --type concept "pattern name"

# Find related modules
wiki-search --module other_module "shared patterns"

# Check for known issues
wiki-search "issue you're solving"
```

### For Code Review

```bash
# Find implementation standards
wiki-search "code quality standards"

# Find testing requirements
wiki-search --type guide "testing"

# Verify architectural compliance
wiki-search "architecture guardrails"
```

---

## Updating Search Index

### Automatic Updates

The QMD index updates automatically every 22 hours. Manual updates available:

```bash
# Update specific collection
qmd collection update wiki
qmd collection update modules-docs
qmd collection update module_Gdpr

# Rebuild entire index (slow)
qmd rebuild
```

### Embedding Vectors (Semantic Search)

Enable semantic search by embedding vectors:

```bash
# Embed wiki documents
qmd embed --collection wiki

# Embed module documentation
qmd embed --collection modules-docs

# Full embedding (all collections)
qmd embed
```

**Note:** Initial embedding may take 30-50 minutes depending on system resources.

---

## Search Best Practices

### ✓ DO

- **Use specific terms** — `gdpr consent workflow` instead of `workflow`
- **Search when stuck** — saves time finding patterns
- **Combine keyword + semantic** — keyword for exact matches, semantic for related concepts
- **Use module filters** — narrow search scope for focused results
- **Review top results** — usually most relevant

### ✗ DON'T

- **Over-broad queries** — `documentation` returns too many results
- **Query entire sentences** — breaks keyword matching
- **Mix unrelated terms** — `gdpr testing database` may not work
- **Ignore performance metrics** — if > 2000ms, simplify query
- **Assume results are complete** — reindex periodically

---

## See Also

- [QMD Search Guide](./qmd-search-guide.md) — Lower-level QMD commands
- [QMD Indexing Manifest](./qmd-indexing-manifest.md) — What's indexed and why
- [Module Wiki Documentation](./module-wiki-documentation.md) — Creating searchable docs
- [Theme Wiki Documentation](./theme-wiki-documentation.md) — Theme documentation

---

**Last Updated:** 2026-04-29  
**Status:** Active  
**Performance Target:** < 2 seconds per query  
**Related Story:** Story 2.1 (QMD Search Integration)
