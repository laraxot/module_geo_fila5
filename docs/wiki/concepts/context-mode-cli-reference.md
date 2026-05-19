---
name: Context-Mode CLI Reference
description: Quick reference for all context-mode commands and their usage
type: guide
related:
  - ./context-mode-plugin.md
  - ../index.md
---

# Context-Mode CLI Reference

Quick command reference for context-mode v1.0.103 in Claude Code.

## Statistics & Monitoring

### `/ctx-stats`
Display context usage and compression metrics.

```bash
/ctx-stats
```

**Output includes:**
- Total bytes returned to context
- Breakdown by tool (Read, Bash, Write, etc.)
- Number of calls per tool
- Estimated token usage
- **Savings ratio** (target: 60%+)

**When to use:** 
- Weekly health checks
- Before/after indexing to measure improvement
- Troubleshooting why context is still growing

---

### `/ctx-doctor`
Run diagnostic checks on context-mode installation.

```bash
/ctx-doctor
```

**Verifies:**
- ✅ Server initialization
- ✅ FTS5 / SQLite functionality
- ✅ Available JavaScript runtimes
- ✅ Hook script configuration
- ✅ Plugin registration
- ✅ Version compatibility

**When to use:**
- After installation or upgrade
- If experiencing errors
- Before reporting issues

---

### `/ctx-insight`
Open interactive analytics dashboard.

```bash
/ctx-insight
```

**Shows:**
- Sessions per day (chart)
- Average tokens per session
- Compression effectiveness ratio
- Tool usage breakdown (pie chart)
- Knowledge base size
- Historical trends

**When to use:**
- Project retrospectives
- Analyzing usage patterns
- Optimizing compression strategy

---

## Indexing & Search

### `/ctx-index`
Index files or directories into the knowledge base.

```bash
# Index a folder
/ctx-index --path "docs/wiki/" --source "Project Wiki"

# Index a single file
/ctx-index --file docs/architecture.md --source "Architecture Docs"

# Index with descriptive source label
/ctx-index --path "laravel/Modules/Xot/docs/wiki/" --source "Xot Module Core"
```

**Parameters:**
- `--path` — Folder or file path to index
- `--source` — Label for the indexed content (appears in search results)

**Best practices:**
- Index once, search many times
- Use descriptive `--source` labels for easy identification
- Index stable documentation (not frequently changing files)
- Don't index `node_modules/`, `.git/`, `build/`

**When to use:**
- Initial project setup
- After major documentation updates
- When onboarding new knowledge to the system

---

### `/ctx-search`
Query the indexed knowledge base.

```bash
/ctx-search "authentication middleware patterns"
/ctx-search "database transaction handling"
/ctx-search "error handling in services"
```

**Returns:**
- Top results ranked by relevance (BM25)
- Source and document type for each result
- Short excerpt from matching document

**When to use:**
- Before writing similar code (check existing patterns)
- During implementation (find related examples)
- Researching unfamiliar architecture areas

---

## Batch Execution

### `ctx_batch_execute`
Run multiple commands and queries in one call.

```javascript
ctx_batch_execute({
  commands: [
    { label: "Module List", command: "ls laravel/Modules" },
    { label: "Git Recent", command: "git log --oneline | head -10" },
    { label: "Test Status", command: "npm test --listTests 2>&1 | wc -l" }
  ],
  queries: [
    "database migration patterns",
    "error handling in middleware",
    "service layer architecture"
  ]
})
```

**Benefits:**
- Replaces 5-10 individual tool calls
- Only summaries enter context (raw output in sandbox)
- Commands execute sequentially, all results indexed
- Automatic search on all queries

**When to use:**
- Research phase with multiple angles
- Exploring unfamiliar code sections
- Preparing context for complex implementation

---

## File Analysis (Sandbox Processing)

### `ctx_execute_file`
Analyze large files without loading full content into context.

```javascript
ctx_execute_file({
  path: "large-log.txt",
  language: "javascript",
  code: `
    const lines = FILE_CONTENT.split('\n');
    const errors = lines.filter(l => l.includes('ERROR'));
    const warnings = lines.filter(l => l.includes('WARN'));
    console.log(\`Errors: \${errors.length}, Warnings: \${warnings.length}\`);
  `
})
```

**Why use it:**
- Process files >1000 lines
- Extract specific information from large datasets
- Avoid loading raw data into conversation

**When to use:**
- Analyzing log files
- Processing CSV/JSON data
- Counting occurrences in large codebase

---

## Cleanup & Reset

### `/ctx-purge`
⚠️ **IRREVERSIBLE** — Delete all indexed knowledge and session data.

```bash
/ctx-purge --confirm
```

**Warning:** This deletes:
- All indexed documentation (FTS5 database)
- All session events and analytics
- All cached knowledge

**Use only when:**
- Knowledge base becomes corrupted
- Need to start completely fresh
- Removing sensitive information from indexes

**Recovery:** Re-index documentation with `/ctx-index` afterwards

---

## Upgrade

### `/ctx-upgrade`
Update context-mode to the latest version.

```bash
/ctx-upgrade
```

**Automated steps:**
1. Downloads latest from GitHub
2. Compiles new version
3. Updates in-place
4. Syncs dependencies
5. Rebuilds native addons
6. Configures hook scripts
7. Runs verification

**When to use:**
- New version available (check with `/ctx-doctor`)
- Experiencing bugs fixed in newer versions
- Major feature updates needed

---

## Troubleshooting Commands

### Check Hook Configuration
```bash
/ctx-doctor
# Look for "Hook script: PASS"
```

### Verify FTS5 Availability
```bash
/ctx-doctor
# Look for "FTS5 / SQLite: PASS"
```

### Rebuild Native Modules
```bash
npm rebuild better-sqlite3 --global
/ctx-doctor
```

### Check Knowledge Base Size
```bash
ls -lh ~/.claude/context-mode/knowledge.db
# If >500MB, consider /ctx-purge and selective re-indexing
```

---

## Integration with Projects

### Add to `CLAUDE.md`
```yaml
# Context Management

Use context-mode for large projects:

1. Index stable documentation once:
   /ctx-index --path "docs/" --source "Project Docs"

2. Search before implementation:
   /ctx-search "relevant topic"

3. Use batch execution for research:
   ctx_batch_execute(commands: [...], queries: [...])

4. Monitor weekly:
   /ctx-stats
```

---

## See Also

- [Context-Mode Plugin](context-mode-plugin.md) — Detailed concept documentation
- `/ctx-stats` — Check current savings ratio
- `/ctx-doctor` — Verify installation health

---

**Last Updated**: 2026-04-29  
**Version**: 1.0.103
