# Karpathy LLM Wiki Architecture for PTVX

> **Based on Andrej Karpathy's LLM Knowledge Base pattern**  
> **Implemented: April 2026**

## Overview

This project implements Karpathy's LLM Wiki architecture across all 35+ Laravel modules and themes. The system transforms scattered documentation into a **self-maintaining knowledge base** that AI agents can query, update, and synthesize.

## Core Philosophy

```
Humans source material → LLM organizes → Wiki compounds knowledge → Git version-controls
```

### Why This Matters for PTVX

- **35 modules** × multiple projects = massive documentation debt
- **Multiple AI agents** work simultaneously → need structured knowledge
- **Cross-module patterns** need synthesis (not just scattered docs)
- **New developers** need onboarding without reading 10,000 files

---

## Three-Layer Architecture

### Layer 1: `raw/` — Immutable Source Material

**Purpose:** Permanent collection of source documents that the LLM reads but **never modifies or deletes**.

**Rules:**
- ✅ Drop articles, papers, code snippets, transcripts, notes
- ✅ Subdivide by type: `raw/articles/`, `raw/papers/`, `raw/code-examples/`, `raw/decisions/`
- ❌ NEVER delete or modify files (immutable source of truth)
- ❌ NEVER organize — that's the LLM's job

**What Goes Here:**
- Laravel documentation clippings
- Filament API references
- Architectural decision records
- Meeting transcripts
- Code patterns discovered in the wild
- Bug investigation notes

### Layer 2: `wiki/` — LLM-Generated Knowledge Graph

**Purpose:** Structured markdown files that **synthesize, cross-reference, and maintain knowledge**.

**Structure:**
```
wiki/
├── index.md              # Content catalog (replaces embedding RAG at ~100 sources)
├── log.md                # Append-only activity record (ingests, queries, lint passes)
├── overview.md           # High-level wiki summary
├── concepts/             # Topic/theme pages (e.g., "XotBase Pattern", "Migration Safety")
├── entities/             # People, organizations, modules, models (e.g., "Ptv Model", "Sigma Module")
├── sources/              # Summaries of ingested raw files
└── comparisons/          # Synthesized analyses (e.g., "Filament v4 vs v5 Migration")
```

**Page Conventions:**
Every wiki page MUST have YAML frontmatter:
```yaml
---
title: "Migration Safety Rules"
type: concept
sources:
  - raw/articles/ma-fare-migrate-refresh.md
related:
  - concepts/database-safety.md
  - entities/Activity-Module.md
created: 2026-04-15T10:00:00Z
updated: 2026-04-15T14:30:00Z
confidence: high
---
```

### Layer 3: Schema File — Persistent Instructions

**Purpose:** Root-level schema (`CLAUDE.md`, `AGENTS.md`, or `.qwen/`) that defines:
- Folder rules and conventions
- YAML frontmatter standards
- Ingest/query/lint workflows
- Module-specific constraints

**In PTVX:** This is `AGENTS.md` + `QWEN.md` + module-specific `docs/schema.md`

---

## How It Works: Three Operations

### 1. Ingest — Add Knowledge

```bash
# Human drops file in raw/
cp ~/Downloads/laravel-migration-best-practices.md docs/raw/articles/

# Tell AI to ingest
"Ingest docs/raw/articles/laravel-migration-best-practices.md"
```

**AI Does:**
1. Reads the raw file
2. Creates/updates wiki pages in `wiki/concepts/` or `wiki/entities/`
3. Creates summary in `wiki/sources/`
4. Updates `wiki/index.md` with new entries
5. Appends to `wiki/log.md` with timestamp

### 2. Query — Extract Knowledge

```bash
# Ask against wiki
"Based on the wiki, what are the migration safety rules across all modules?"
```

**AI Does:**
1. Reads `wiki/index.md` to find relevant pages
2. Reads linked `wiki/concepts/` and `wiki/entities/` files
3. Synthesizes answer with file citations
4. If high-value insight, suggests filing as `wiki/comparisons/new-page.md`

### 3. Lint — Maintain Quality

```bash
# Tell AI to lint
"Lint the wiki — find contradictions, orphans, and missing concepts"
```

**AI Does:**
1. Scans all wiki pages for broken links
2. Flags pages with no `related:` links (orphans)
3. Detects contradictions (e.g., one page says "use Actions", another says "use Services")
4. Suggests missing concepts based on `raw/` files not yet ingested
5. Updates `wiki/log.md` with lint results

---

## qmd Tool Integration

### What is qmd?

**qmd** is a local markdown search engine created by Tobi Lütke (Shopify CEO). When the wiki outgrows manual `index.md` navigation, qmd provides:

- **Hybrid search:** BM25 (keyword) + vector semantic + LLM re-ranking
- **On-device:** Runs via `node-llama-cpp` with GGUF models — no cloud API calls
- **MCP server:** AI agents connect natively without shell commands

### Setup for PTVX

```bash
# Already installed globally
npm install -g qmd

# Initialize qmd for a module's wiki
cd laravel/Modules/Activity/docs
qmd collection add ./wiki

# Search the wiki
qmd search "What are the migration safety rules?"

# Query with structured output
qmd query "List all entities related to database safety" --json
```

### MCP Server Configuration

Add to `.cursor/mcp.json` or module-specific MCP config:

```json
{
  "mcpServers": {
    "qmd-activity": {
      "command": "qmd",
      "args": ["mcp"],
      "cwd": "/var/www/_bases/base_ptvx_fila5/laravel/Modules/Activity/docs",
      "disabled": false
    }
  }
}
```

**One MCP server per module wiki** — allows agents to query specific module knowledge without loading entire codebase.

---

## Implementation Across PTVX

### Modules (35 total)

Each module in `laravel/Modules/{Module}/docs/` now has:

```
docs/
├── wiki/
│   ├── index.md
│   ├── log.md
│   ├── overview.md
│   ├── concepts/
│   ├── entities/
│   ├── sources/
│   └── comparisons/
├── raw/
│   ├── articles/
│   ├── papers/
│   ├── code-examples/
│   └── decisions/
└── schema.md          # Module-specific schema file
```

### bashscripts/

```
bashscripts/docs/
├── wiki/
│   ├── index.md
│   ├── log.md
│   ├── overview.md
│   ├── concepts/      # Script patterns, automation strategies
│   ├── entities/      # Individual scripts as entities
│   ├── sources/
│   └── comparisons/
├── raw/
│   ├── articles/      # Blog posts about automation
│   ├── scripts/       # Raw script snippets
│   └── decisions/     # Why we chose bash over alternatives
└── schema.md
```

### Root-Level docs/

```
docs/
├── wiki/              # Project-wide knowledge
│   ├── concepts/      # Cross-module patterns
│   ├── entities/      # Modules, themes, key decisions
│   └── comparisons/   # Architecture comparisons
└── raw/
    ├── articles/      # External research
    ├── papers/        # Academic papers
    └── decisions/     # Architectural decisions
```

---

## AI Agent Workflows

### For Claude Code / Cursor / Windsurf

**When researching a module:**
1. Check if `docs/wiki/` exists
2. Read `docs/wiki/index.md` for overview
3. Query relevant `docs/wiki/concepts/` files
4. If knowledge is scattered, suggest: "Should I ingest scattered docs into the wiki?"
5. When ingesting, update `index.md` and `log.md`

**When documenting new patterns:**
1. Drop raw notes in `docs/raw/articles/`
2. Tell AI: "Ingest docs/raw/articles/{filename}"
3. AI creates wiki pages with frontmatter
4. AI updates `index.md` and `log.md`
5. Commit changes

**When onboarding:**
1. New developer/AI agent reads `docs/wiki/overview.md`
2. Browses `docs/wiki/index.md` for topics
3. Queries via qmd MCP: `qmd search "How do XotBase wrappers work?"`
4. Gets synthesized answers in seconds, not hours

---

## Git Integration

The entire wiki structure is version-controlled:

```bash
# After each ingest
git add docs/wiki/
git commit -m "[WIKI] Ingest migration safety article → Activity module wiki"

# Track knowledge evolution
git log --oneline docs/wiki/concepts/migration-safety.md

# Branch for experimental organization
git checkout -b wiki-restructure
# Reorganize wiki/concepts/ → wiki/topics/
# Test with AI queries
git checkout main
# Merge if better, discard if not
```

---

## Scaling Strategy

### Phase 1: Manual (Now — 100 sources per module)
- Direct file reading by AI agents
- `index.md` for navigation
- No qmd needed yet

### Phase 2: qmd Search (100-500 sources per module)
- Initialize qmd collections
- Use `qmd search` for semantic queries
- MCP servers for agent integration

### Phase 3: Cross-Module Synthesis (500+ sources)
- Root-level wiki aggregates cross-module patterns
- qmd queries across all module collections
- Automated lint reports for contradictions

---

## Rules & Constraints

### ✅ DO
- Drop raw knowledge liberally in `raw/`
- Let AI organize into `wiki/`
- Use YAML frontmatter consistently
- Link related pages (`related:` in frontmatter)
- Commit after each ingest/query/lint
- Use `wiki/log.md` to track activity

### ❌ NEVER
- Delete or modify files in `raw/`
- Skip YAML frontmatter
- Create files directly in `wiki/` without ingesting from `raw/` first
- Let wiki pages become orphans (no `related:` links)
- Commit without updating `index.md` and `log.md`

---

## Quick Reference

| Action | Command |
|--------|---------|
| Ingest raw doc | `"Ingest docs/raw/articles/{filename}"` |
| Query wiki | `"Based on the wiki, {question}"` |
| Lint wiki | `"Lint the wiki — find contradictions and orphans"` |
| Search with qmd | `qmd search "{query}"` (in docs/ folder) |
| Start MCP server | `qmd mcp` (in docs/ folder) |
| Add qmd collection | `qmd collection add ./wiki` (in docs/ folder) |

---

## Sources

- [Karpathy's LLM Wiki Idea File](https://gist.github.com/karpathy)
- [VentureBeat: Karpathy's Architecture](https://venturebeat.com/data/karpathy-shares-llm-knowledge-base-architecture-that-bypasses-rag-with-an)
- [MindStudio: Complete Guide](https://www.mindstudio.ai/blog/andrej-karpathy-llm-wiki-knowledge-base-claude-code/)
- [AntiGravity: Idea File Breakdown](https://antigravity.codes/blog/karpathy-llm-wiki-idea-file)

---

**Status:** ✅ Implemented across all 35 modules + bashscripts + root docs  
**Next:** Ingest existing scattered documentation into wiki structure  
**Maintained By:** All AI agents working on PTVX
