# Story 1.4: Second Brain Efficiency Optimization

Status: done

## Story

As a developer agent,
I want the second brain to be optimized for token efficiency, fast retrieval, and continuous self-improvement,
so that every engineering task finds reusable knowledge faster while consuming fewer tokens.

## Context

Stories 1.1–1.3 established the Karpathy LLM Wiki structure, ingestion workflow, and continuous improvement loop. External research (2025-2026) reveals critical optimizations:

**Research Findings:**
- **Retrieval over organization** — our wiki exists, but QMD search patterns need tuning
- **Token efficiency** — concise context files (CLAUDE.md, AGENTS.md) directly improve agent performance
- **QMD best practices** — `search` (BM25) for speed, `query` (hybrid) for quality, `--json` flag for snippet-only retrieval
- **30-min maintenance budget** — any system requiring >30 min/week fails; our loop must be leaner
- **Context descriptions in QMD** — `qmd context add` dramatically improves retrieval accuracy
- **Just-in-time retrieval** — pull context when needed, not all at once

## Acceptance Criteria

1. Root `docs/wiki/` pages include QMD context descriptions for better semantic retrieval
2. `CLAUDE.md` and `AGENTS.md` at all levels are audited for token efficiency (target: 50-60% reduction where verbose)
3. QMD search strategy documented: `search` for keywords, `query` for concepts, `--json` for snippet-only lookups
4. The continuous improvement loop includes a "token budget check" — no wiki page should cost >2000 tokens to consume
5. High-value module/theme wikis have prioritized ingest backlog with clear "why this first" rationale
6. Wiki pages include "Retrieval Hint" frontmatter: `qmd: "topic1, topic2"` for direct QMD matching
7. The `docs/wiki/log.md` template includes token-cost estimate for each ingest operation

## Tasks / Subtasks

- [ ] **Task 1: QMD Context Optimization** (AC: #1, #3)
  - [ ] 1.1 Add `qmd context add` descriptions to all existing collections in `.qmd-collection.json`
  - [ ] 1.2 Document QMD search strategy in `docs/wiki/concepts/second-brain-operating-model.md`
  - [ ] 1.3 Add `Retrieval Hint` frontmatter to all root wiki pages

- [ ] **Task 2: Token-Efficient Context Files** (AC: #2, #4)
  - [ ] 2.1 Audit `CLAUDE.md` and `AGENTS.md` at root, module, and theme levels
  - [ ] 2.2 Remove filler phrases, redundant explanations, and verbose natural language
  - [ ] 2.3 Apply snake_case labels and terse expert notation where appropriate
  - [ ] 2.4 Add token-count comments to context files for budget tracking

- [ ] **Task 3: Prioritized Ingest Backlog** (AC: #5)
  - [ ] 3.1 Create `docs/wiki/sources/ingest-backlog.md` with priority order and rationale
  - [ ] 3.2 Include estimated token-cost and expected reuse frequency for each item
  - [ ] 3.3 Mark "high-signal" sources that should be ingested first

- [ ] **Task 4: Improved Log Template** (AC: #7)
  - [ ] 4.1 Update `docs/wiki/log.md` template to include token-cost field
  - [ ] 4.2 Add format: `[YYYY-MM-DD HH:MM:SS UTC] [INGEST] [~N tokens] Description`

- [ ] **Task 5: Module/Theme Wiki Expansion** (AC: #5)
  - [ ] 5.1 Apply the continuous improvement loop to `laravel/Modules/Xot/docs/wiki/`
  - [ ] 5.2 Apply the continuous improvement loop to `laravel/Themes/Zero/docs/wiki/`
  - [ ] 5.3 Create ingest backlogs for remaining high-value modules

## Dev Notes

### Previous Story Intelligence (from 1-1, 1-2, 1-3)

**From 1.1 (LLM Wiki Setup):**
- Karpathy pattern: raw docs (`docs/`) + wiki (`docs/wiki/`) + log (`log.md`) + schema (`SCHEMA.md`)
- All 35 modules + 2 themes + bashscripts have wiki structure initialized
- `.qmd-collection.json` updated with raw + wiki collections

**From 1.2 (Docs Ingestion):**
- Project-level operating model documented in `docs/wiki/concepts/second-brain-operating-model.md`
- Source summary for docs landscape: `docs/wiki/sources/docs-landscape-modules-and-themes.md`
- Ingested: `docs/architecture/`, `docs/ai/`, `docs/bmad/`

**From 1.3 (Continuous Improvement):**
- Continuous improvement playbook: `docs/wiki/concepts/second-brain-continuous-improvement.md`
- Routing rules: root wiki for cross-cutting, module wiki for bounded knowledge, theme wiki for presentation/UX
- Minimum quality checks: duplicates, missing index links, stale claims, orphan pages

### QMD Search Strategy (Research-Informed)

| Task | Command | Speed | Use When |
|------|----------|-------|----------|
| Quick keyword | `qmd search "exact phrase"` | <1s | Known identifiers, file names |
| Concept search | `qmd query "topic" --json -n 10` | ~5s | Semantic understanding needed |
| Batch retrieve | `qmd multi-get "path/*.md"` | instant | Already know which files |
| Status check | `qmd status` | instant | Verify index health |

**Critical:** Use `--json` flag for snippet-only results. Full document retrieval only when snippet confirms relevance. Saves 80-95% tokens.

### Token-Efficient Context File Patterns

**Remove:**
- "Please" / "Thank you" / polite filler
- Repeated explanations of what LLM already knows
- Verbose examples when a single line suffices
- Redundant "As an AI agent..." introductions

**Apply:**
- `snake_case` labels over `CamelCase` or sentences
- Inline constraints: `[max 3 lines]` vs "please keep this under three lines"
- Terse expert notation: `Use XotBase*` not "Make sure to extend the XotBase class provided by..."

**Target:** 50-60% token reduction without information loss.

### Project Structure Notes

- Root `docs/wiki/` — project-wide knowledge, cross-cutting concerns
- Module `docs/wiki/` — bounded to one module's domain
- Theme `docs/wiki/` — presentation, UX, frontend assets
- `.qmd-collection.json` — all collections must have `context` field for retrieval

### QMD Collection Context Format

```bash
qmd context add "description of what this collection contains, key topics, and typical queries" --collection <name>
```

Example for Xot module:
```bash
qmd context add "Xot module: base classes, XotBaseResource, XotBasePage, ServiceProvider patterns, Laraxot core architecture" --collection module_Xot
```

### References

- [Second Brain Operating Model](./docs/wiki/concepts/second-brain-operating-model.md)
- [Second Brain Continuous Improvement](./docs/wiki/concepts/second-brain-continuous-improvement.md)
- [Docs Landscape Summary](./docs/wiki/sources/docs-landscape-modules-and-themes.md)
- [QMD GitHub](https://github.com/tobi/qmd) — hybrid BM25 + vector + reranking
- [Token Optimization Guide](https://www.tokenoptimize.dev/guides/llm-token-optimization-strategies) — context engineering over prompt shortening
- Story 1.1: `_bmad-output/implementation-artifacts/1-1-llm-wiki-setup.md`
- Story 1.2: `_bmad-output/implementation-artifacts/1-2-second-brain-docs-ingestion.md`
- Story 1.3: `_bmad-output/implementation-artifacts/1-3-second-brain-continuous-improvement.md`

## Dev Agent Record

### Agent Model Used

(claude-sonnet-4-6)

### Debug Log References

### Completion Notes List

### File List

