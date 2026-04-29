---
name: Semantic Search and Related Pages Guide
description: How to use semantic search for wiki pages and discover related documentation through similarity matching and cross-references
type: how-to
related: [wiki-search-guide.md, qmd-indexing-manifest.md]
---

# Semantic Search and Related Pages Guide

Discover connected documentation through semantic similarity and cross-reference analysis. This guide covers finding related wiki pages, understanding semantic search, and leveraging the knowledge graph structure.

## Quick Start

### Find Related Pages
```bash
# Show pages that link to this document
wiki-search --related docs/wiki/concepts/actions-over-services.md

# View pages with semantic similarity
wiki-search --semantic "user permissions and access control"

# Combine searches
wiki-search --related docs/wiki/concepts/actions-over-services.md
wiki-search --semantic "actions pattern"
```

---

## Understanding Semantic Search

### What is Semantic Search?

Semantic search finds pages based on **meaning and concept similarity**, not just keyword matching.

| Search Type | Method | Speed | Use Case |
|-------------|--------|-------|----------|
| **Keyword** | Exact term matching | Fast (<500ms) | Known terms, specific topics |
| **Semantic** | Concept similarity via embeddings | Slower (< 2000ms) | Related concepts, exploration |

### How It Works

1. **Embeddings**: Each wiki page is converted to a vector (semantic fingerprint)
2. **Similarity Matching**: Query is compared to all page vectors
3. **Ranking**: Pages sorted by semantic closeness to query
4. **Results**: Most similar pages ranked first

### Example: Semantic vs Keyword

**Keyword Search:** `"access control"`
```
Results: Pages containing "access control" literally
- Might miss: "user permissions", "authorization", "role-based security"
```

**Semantic Search:** `"user permissions and access control"`
```
Results: Pages about related concepts
- Includes: Authorization patterns, permission systems, security controls
- Discovers: Unexpected connections (e.g., "GDPR consent" relates to "access control")
```

---

## Searching for Related Pages

### Using --related Flag

Find pages that explicitly link to or from a given document:

```bash
wiki-search --related docs/wiki/concepts/actions-over-services.md
```

Output shows:
- **Pages Linking TO This Document** (backlinks/references)
- **Pages Linked FROM This Document** (outgoing links)

### Backlinks: Pages Referencing You

When viewing a wiki page, backlinks show which other pages discuss or reference it:

```bash
wiki-search --related docs/wiki/concepts/actions-over-services.md
```

This reveals:
- What patterns depend on Actions
- Where this concept is applied
- Related implementations

### Outgoing Links: External References

Pages this document links to:

```bash
wiki-search --related docs/wiki/how-to/qmd-search-guide.md
```

Shows:
- Prerequisites and dependencies
- Related concepts
- Implementation guides

---

## Advanced Semantic Queries

### Exploring by Topic

Find pages discussing a broad topic:

```bash
# Find pages about performance optimization
wiki-search --semantic "performance optimization caching"

# Find pages about testing strategies
wiki-search --semantic "testing test coverage quality assurance"

# Find pages about API design
wiki-search --semantic "api endpoint design rest"
```

### Concept Discovery

Use semantic search to discover unexpected connections:

```bash
# Find what relates to "context switching"
wiki-search --semantic "context switching performance overhead"

# Results might include:
# - Context-mode token optimization
# - Database query optimization
# - Memory management patterns
```

### Cross-Domain Connections

Find how concepts from different domains relate:

```bash
# Connect GDPR to architecture
wiki-search --semantic "GDPR data privacy architecture design"

# Finds:
# - GDPR module documentation
# - Privacy patterns
# - Data handling architectures
```

---

## Analyzing Page Relationships

### Relationship Graph

Pages form a knowledge graph through links and semantic similarity:

```
┌─────────────────────────────────────┐
│  Actions Over Services Pattern      │
└──────────────┬──────────────────────┘
               │
       ┌───────┼───────┬────────────────┐
       ▼       ▼       ▼                ▼
   Activity  GDPR   Event         Module
   Module    Module Sourcing       Patterns
       │       │       │                │
       └───────┼───────┼────────────────┘
               │
        ┌──────▼──────┐
        │ Context-Mode│
        │ Performance │
        └─────────────┘
```

### Following Relationships

1. **Explicit Links** (markdown links)
   - Author-intended connections
   - Clear semantic relationships
   - Updated with documentation changes

2. **Semantic Similarity** (embeddings)
   - Automatic concept discovery
   - No link required
   - Finds unexpected connections

3. **Bidirectional Links** (backlinks)
   - See who references you
   - Understand page impact
   - Discover dependents

---

## Using Related Pages in Workflow

### Before Implementation

```bash
# Research architectural pattern
wiki-search --related docs/wiki/concepts/actions-over-services.md

# See:
# - What modules use this pattern
# - Where it's explained in detail
# - What prerequisites exist
```

### During Implementation

```bash
# Find similar implementations
wiki-search --semantic "consent workflow user preferences storage"

# Discover:
# - How other modules handle preferences
# - Testing strategies for workflows
# - Error handling patterns
```

### Code Review

```bash
# Check if pattern is used correctly
wiki-search --related docs/wiki/concepts/event-sourcing.md

# Verify:
# - Your code matches documented pattern
# - All integration points are considered
# - Test coverage follows standards
```

---

## Cross-Reference Identification

### How Cross-References Work

The wiki system automatically detects:

1. **Markdown Links**: `[text](path/to/file.md)`
2. **Wiki References**: `@docs/wiki/concepts/pattern.md`
3. **Code References**: Documentation mentioned in comments
4. **Semantic References**: Concept mentions without explicit links

### Viewing Cross-References

```bash
# See all pages mentioning this concept
wiki-search --semantic "actions pattern"

# Shows pages that discuss Actions even without explicit links
```

### Creating Effective Cross-References

Add explicit links in your wiki pages:

```markdown
---
name: My Pattern
related: [related-concept.md, another-doc.md]
---

# My Pattern

See also: [Actions Pattern](../concepts/actions-over-services.md)
```

This ensures:
- Clear backlinks
- Discoverable relationships
- Better navigation

---

## Performance & Optimization

### Semantic Search Performance

**Factors Affecting Speed:**
- Collection size (more pages = slower search)
- Embedding quality (better embeddings = more accurate)
- Vector cache (first query slower, subsequent queries faster)

**Response Times:**
| Search Type | Target | Typical |
|------------|--------|---------|
| Keyword | < 2000ms | 200-500ms |
| Semantic (cached) | < 2000ms | 500-1500ms |
| Related pages | < 2000ms | 100-300ms |

### Improving Semantic Search

1. **Ensure vectors are embedded:**
   ```bash
   qmd embed --collection wiki
   ```

2. **Use specific queries:**
   ```bash
   # Good: Specific terms
   wiki-search --semantic "event sourcing append-only log"

   # Poor: Too vague
   wiki-search --semantic "how to code"
   ```

3. **Combine keyword + semantic:**
   ```bash
   # Get exact match first (fast)
   wiki-search "context-mode"

   # Then explore semantic (slower)
   wiki-search --semantic "token optimization performance"
   ```

---

## Troubleshooting

### Semantic Search Returns Irrelevant Results

**Problem**: Search for "database" returns pages about unrelated topics

**Causes:**
- Collection not embedded (vectors missing)
- Query is too vague
- Embedding model needs updating

**Solutions:**
```bash
# 1. Check embedding status
qmd status | grep "Pending"

# 2. Embed missing files
qmd embed --collection wiki

# 3. Make query more specific
wiki-search --semantic "database query optimization indexing"
```

### Related Pages Are Empty

**Problem**: `--related` shows no backlinks or outgoing links

**Causes:**
- File uses non-standard markdown link syntax
- Links point to non-wiki files
- File paths are incorrect

**Solutions:**
```bash
# Verify file links use markdown syntax
# ✓ Correct: [text](../concepts/file.md)
# ✗ Wrong: @docs/wiki/concepts/file.md

# Check if target files exist
ls -la docs/wiki/concepts/

# Ensure relative paths work
cd docs/wiki/concepts/ && ls -la ../other-file.md
```

### Slow Semantic Searches

**Problem**: Semantic search takes > 2 seconds

**Causes:**
- Large collection (many pages)
- Vectors not cached
- System resources limited

**Solutions:**
```bash
# Use keyword search for known terms
wiki-search "your search term"

# Limit results to reduce processing
wiki-search --semantic --limit 5 "your search"

# Search specific collection instead of all
wiki-search --module gdpr --semantic "consent"

# For large searches, use offline analysis:
qmd search "topic" -c wiki --semantic > results.json
```

---

## Best Practices

### ✓ DO

- **Use semantic search to explore** topics you're learning about
- **Combine keyword + semantic** for comprehensive understanding
- **Check backlinks** when implementing a pattern (see where it's used)
- **Add explicit links** in wiki pages (helps both humans and tools)
- **Follow related pages** from documentation (builds mental model)
- **Use --related** to understand page impact and dependencies

### ✗ DON'T

- **Rely only on keyword search** (misses related concepts)
- **Ignore semantic results** without reviewing them
- **Create documentation in isolation** (add cross-references)
- **Use outdated embeddings** (run `qmd embed` periodically)
- **Search entire repository** for generic terms (be specific)
- **Assume backlinks are complete** (some references may not be detected)

---

## Integration with Development Tools

### Kilo Code Integration

Use Kilo to leverage semantic search:

```bash
kilo chat
> Search the wiki for pages related to "event sourcing"
> Using @docs/wiki/concepts/actions-over-services.md explain this pattern
```

Kilo automatically:
- Performs semantic searches
- Retrieves related pages
- Cross-references documents
- Generates context-aware suggestions

### IDE Workflow

In VS Code with Kilo:

1. Open command palette (Ctrl+Shift+P)
2. "Kilo: Find Related Documentation"
3. Select file or topic
4. See related pages in sidebar

### CI/CD Integration

Verify documentation completeness:

```bash
#!/bin/bash
# Check all changed files have proper cross-references
for file in $(git diff --name-only main | grep .md); do
    wiki-search --related "$file" | grep -q "Pages Linking" || \
        echo "Warning: $file may be orphaned"
done
```

---

## Examples

### Example 1: Learning a New Pattern

```bash
# 1. Find the concept page
wiki-search "actions pattern"

# 2. Check who uses it
wiki-search --related docs/wiki/concepts/actions-over-services.md

# 3. Explore similar patterns
wiki-search --semantic "business logic organization architecture"

# Result: Deep understanding of pattern, usage, and variations
```

### Example 2: Implementing a Feature

```bash
# 1. Find relevant examples
wiki-search --semantic "user consent preferences GDPR"

# 2. Check implementation pattern
wiki-search --related docs/wiki/modules/gdpr-consent-workflow.md

# 3. Verify testing approach
wiki-search --semantic "consent workflow testing"

# Result: Implementation following established patterns and tests
```

### Example 3: Code Review

```bash
# 1. Understand what pattern was intended
wiki-search "event sourcing pattern"

# 2. Check if module documentation matches code
wiki-search --related docs/wiki/modules/activity-event-sourcing.md

# 3. Find tests and examples
wiki-search --semantic "event sourcing unit integration tests"

# Result: Thorough review against documented patterns
```

---

## See Also

- [Wiki Search Guide](./wiki-search-guide.md) — General search usage
- [QMD Indexing Manifest](./qmd-indexing-manifest.md) — What's indexed and embedding status
- [QMD Search Guide](./qmd-search-guide.md) — Low-level QMD commands
- [Module Wiki Documentation](./module-wiki-documentation.md) — Creating searchable docs

---

**Last Updated:** 2026-04-29  
**Status:** Active  
**Performance Target:** < 2 seconds per query  
**Related Story:** Story 2.1 (QMD Search Integration)
