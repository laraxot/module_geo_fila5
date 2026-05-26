---
name: context-safe-tool-usage
description: Tool selection hierarchy to prevent autocompact thrashing — prioritize context-mode MCP tools to keep large output in sandbox
metadata:
  type: rule
  enforced: automatic via TRIGGER_MAP
---

# Context-Safe Tool Usage

**Automatic enforcement:** Load on any task involving file reads, API calls, data processing, or multiple commands.

## Tool Selection Hierarchy

**Priority 1: Context-Mode MCP Tools** (output stays in sandbox, only summaries enter context)
- `ctx_batch_execute(commands, queries)` — Primary research tool. One call replaces many Bash+Read loops. Auto-indexes, enables follow-up searching.
- `ctx_execute_file(path, language, code)` — Process files without loading content into context. Use for log analysis, data processing, parsing.
- `ctx_fetch_and_index(url)` — Fetch web pages, auto-convert to markdown, index for searching. Replace WebFetch.

**Priority 2: Native Tools** (controlled output, small scope)
- `Read` — Files <4KB only, or files you intend to Edit. Never for analysis.
- `Edit` — Modify existing files with line-range precision.
- `Write` — Create new files. Use immediately when file needs to exist.
- `Bash` — Git operations, navigation (mkdir/rm/mv), **not** output processing.

**Priority 3: Avoid** (context-unsafe)
- ~~`Bash` for analyzing output >20 lines~~ → Use `ctx_batch_execute` or `ctx_execute`
- ~~`Read` for files >10KB or analysis~~ → Use `ctx_execute_file`
- ~~`WebFetch`~~ → Use `ctx_fetch_and_index`

## Decision Tree

### I need to run a command and see large output

```
→ Use ctx_batch_execute
  (Indexes output, allows follow-up searching)
  
Only if output is guaranteed <20 lines AND contains data you need immediately in context:
  → Bash (accept context cost)
```

### I need to read a file and process/analyze it

```
→ Is file in memory/context already?
  ├─ YES → Use Edit for modifications, Read only if <4KB
  └─ NO → ctx_execute_file (process without loading)
```

### I need to search or fetch from web

```
→ Use ctx_fetch_and_index (auto-conversion, searchable)
  Not: WebFetch (no indexing)
```

### I need to create/modify a file

```
→ Use Write (new file) or Edit (existing file)
  Not: Bash echo/heredoc, not ctx_execute
```

## Enforcement Rules

### ✅ DO
- Use `ctx_batch_execute` for research involving multiple commands
- Use `ctx_execute_file` for log analysis, parsing, data transformation
- Use `ctx_fetch_and_index` for web research
- Keep Read tool for small files (<4KB) and Edit targets
- Use Bash only for git, navigation, and file operations (rm/mkdir/mv)

### ❌ DON'T
- Use Bash for output >20 lines (use `ctx_batch_execute`)
- Use Read to analyze large files (use `ctx_execute_file`)
- Use WebFetch without indexing (use `ctx_fetch_and_index`)
- Pre-load large files without processing them immediately (keeps context clean)

## Why This Matters

**Root Cause of Autocompact Thrashing:**

1. **AGENTS.md** (204KB) loaded into context on every session → ~50K tokens burned
   - **Fix:** Reduced to 18-line stub, content loaded on-demand via wiki

2. **Tool selection not optimized** — using Bash for large output, Read for large files
   - **Effect:** Output stays in context instead of sandbox
   - **Fix:** Enforce context-mode hierarchy

3. **Missing trigger in TRIGGER_MAP** — no automatic enforcement when task demands tool selection
   - **Effect:** Each task repeats the suboptimal pattern
   - **Fix:** This document + trigger added to TRIGGER_MAP

**Result:** Context-mode discipline prevents thrashing by moving large data to sandbox, keeping context for conversation only.

## Module Implementation

Each module (Activity, Job, Media, User, Rating) should include in its docs:

```
## Context-Safe Practices
- When working with [module], prefer `ctx_batch_execute` for multi-query research
- Log analysis: use `ctx_execute_file` to keep logs out of context
- See: [[context-safe-tool-usage]]
```

## Theme Implementation

Each theme (One, Zero) should include:

```
## Context Safety
- Theme docs stored in wiki, referenced on-demand
- Use `ctx_fetch_and_index` for theme-specific web research
- See: [[context-safe-tool-usage]]
```

---

**Cross-links:** [[context-overflow-prevention]], [[context-mode-usage]], [[00-TRIGGER_MAP]]
