---
name: Context-Mode Compression Plugin
description: FTS5-based context compression for managing token overflow in large projects
type: concept
related:
  - ../concepts/second-brain-operating-model.md
  - ../sources/context-compression-mcp-setup.md
  - ../index.md
---

# Context-Mode Compression Plugin

**Version**: 1.0.103  
**Status**: Production Ready  

## What Is Context-Mode?

Context-mode is the official context compression plugin for Claude Code. It solves the token overflow problem by:

- **Indexing knowledge** into a separate FTS5 database instead of keeping everything in the conversation context
- **Maintaining session efficiency** by loading only relevant documentation snippets on demand
- **Preventing token overflow** when working with large codebases (40+ modules, enterprise projects)

## The Problem It Solves

```
Error: This endpoint's maximum context length is 262144 tokens.
However, you requested about 419940 tokens...
Please use the context-compression plugin.
```

This error occurs when:
- Multiple large files are read into context
- Tool output exceeds 20 lines without processing
- Documentation is loaded entirely instead of selectively
- Sessions span long conversations with accumulated context

## How It Works

```
User Question
    ↓
Hook: PreToolUse
    ├─→ Check which tools will execute
    ├─→ Index metadata about called tool
    └─→ Load relevant knowledge snippets (not full files)
    ↓
Tool Execution (Bash, Read, Browser, etc.)
    ↓
Hook: SessionStart
    ├─→ Register session event
    ├─→ Update analytics
    └─→ Prepare compression for next iteration
    ↓
Compressed Context to Claude
```

## Key Benefits

### 1. Token Savings Ratio
- **75% savings** = 4:1 compression (4 tokens saved per 1 token used)
- **50% savings** = 2:1 compression
- **25% savings** = 1.33:1 compression
- **Target for large projects**: 60–75% savings ratio

### 2. Automatic Hook Integration
No manual configuration needed. Context-mode automatically:
- Runs before every tool call (PreToolUse hook)
- Registers session start (SessionStart hook)
- Maintains the knowledge base in `.claude/context-mode/`

### 3. BM25 + Semantic Search
Not just keyword matching—context-mode uses:
- **Full-text search** (FTS5) for exact term matching
- **Semantic ranking** for conceptual similarity
- **Chunking by headings** to keep related content together

## Usage Pattern

### Check Health
```bash
/ctx-stats           # Shows compression ratio and savings
/ctx-doctor          # Verifies all components working
```

### Index Documentation
```bash
# Index a stable documentation folder
/ctx-index --path "docs/wiki/" --source "Project Wiki"

# Index module-specific documentation
/ctx-index --path "laravel/Modules/Xot/docs/wiki/" --source "Xot Module"
```

### Search Knowledge Base
```bash
# Query the indexed knowledge
/ctx-search "authentication middleware patterns"
```

### Batch Execution (Efficient for Multiple Queries)
```javascript
// One call replaces many: instead of 5 Read + 5 Bash commands
ctx_batch_execute({
  commands: [
    { label: "Module List", command: "ls laravel/Modules" },
    { label: "Git Log", command: "git log --oneline | head -20" }
  ],
  queries: [
    "database transaction patterns",
    "error handling in middleware"
  ]
})
// Only summaries enter context—raw output stays in sandbox
```

## When to Use Context-Mode Tools

| Scenario | Use | Avoid |
|----------|-----|-------|
| Analyze log file (>100 lines) | `ctx_execute_file` | `Read` |
| Search codebase for patterns | `ctx_batch_execute` + query | `Bash grep` |
| Process JSON/CSV data | `ctx_execute` (code) | `Bash` + context |
| Multiple independent operations | `ctx_batch_execute` | Multiple Bash calls |

## Best Practices

### 1. Index Stable Documentation Once
```bash
# Do this once per major documentation change
/ctx-index --path "docs/architecture/" --source "Architecture"
/ctx-index --path "laravel/Modules/" --source "All Modules"

# Then use /ctx-search for repeated queries
```

### 2. Use Batch Execution for Research
Instead of:
```bash
Read file1
Read file2
Bash command1
Bash command2
```

Use one call:
```javascript
ctx_batch_execute({
  commands: [
    { label: "File 1", command: "cat file1" },
    { label: "File 2", command: "cat file2" }
  ],
  queries: ["search topic 1", "search topic 2"]
})
```

### 3. Process Large Files in Sandbox
```javascript
// ✅ CORRECT: Only summary enters context
ctx_execute_file(path: "large-log.txt", code: `
  const data = FILE_CONTENT;
  const errors = data.split('\n').filter(l => l.includes('ERROR'));
  console.log(\`Found \${errors.length} errors\`);
`)

// ❌ WRONG: Entire log enters context
Read(file_path: "large-log.txt")
```

## Configuration

Add to `CLAUDE.md` for project-wide settings:

```yaml
context-mode:
  enabled: true
  auto-index: true
  knowledge-base: .claude/context-mode/knowledge.db
  compression-level: 2  # 1=fast, 2=balanced, 3=aggressive
```

## Monitoring

### Check Context Usage
```bash
/ctx-stats
```

Returns:
- Total bytes returned to context
- Breakdown by tool
- Estimated token usage
- **Savings ratio** (target: 60%+)

### View Analytics Dashboard
```bash
/ctx-insight
```

Shows:
- Sessions per day
- Average tokens per session
- Compression effectiveness
- Tool usage breakdown
- Knowledge base size

## Troubleshooting

### "FTS5 not available"
```bash
ctx-doctor           # Verify installation
npm rebuild better-sqlite3 --global  # Rebuild if needed
```

### "Knowledge base too large" (>500MB)
```bash
/ctx-purge --confirm              # ⚠️ IRREVERSIBLE
/ctx-index --path docs/ --source "Documentation"  # Re-index strategically
```

### "Hooks not configured"
```bash
/ctx-upgrade  # Reinstalls and configures automatically
```

### Context still growing despite context-mode
Likely causes:
- Using `Read` on files >1000 lines (use `ctx_execute_file` instead)
- Running `Bash` with output >20 lines (use `ctx_batch_execute` instead)
- Not indexing stable documentation
- Large binary files in git history

## Technical Details

### Architecture
```
context-mode v1.0.103
├── Core: FTS5 full-text search engine
├── Indexer: Markdown document ingestion + chunking
├── Search: BM25 relevance ranking
├── Hook Scripts: PreToolUse + SessionStart hooks
├── CLI: ctx-stats, ctx-doctor, ctx-search
└── Cache: .claude/context-mode/
    ├── knowledge.db       (FTS5 database)
    ├── session-events.db  (analytics)
    └── settings.json      (configuration)
```

### Data Flow
1. Documentation is chunked by heading level
2. Each chunk indexed with metadata (source, type, keywords)
3. Queries use BM25 ranking + semantic similarity
4. Results cached in session-events.db
5. Hooks automatically trigger pre/post tool execution

## See Also

- [Second Brain Operating Model](second-brain-operating-model.md) — How to structure documentation for best retrieval
- [Context Compression MCP Setup](../sources/context-compression-mcp-setup.md) — Original setup summary
- `../../context-mode-guide.md` — Detailed reference guide

---

**Last Updated**: 2026-04-29  
**Maintenance**: Monitor with `/ctx-stats` weekly; re-index when major documentation changes
