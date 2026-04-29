# Story: Token-Efficient Coding Agent Setup

## Status: Draft

## Epic
**Epic 0**: Project Infrastructure

## Story
As a developer using AI coding agents,
I want token-efficient project configuration, precise rules, and indexed documentation,
so that the agent consumes fewer tokens, works faster, and avoids redundant research.

---

## Acceptance Criteria

### AC1: QWEN.md Token-Efficient Format
- **Given** the QWEN.md file at project root
- **When** I read it
- **Then** it uses explicit decisions (not vague descriptions)
- **And** it pins critical file paths
- **And** it sets hard boundaries (DO NOT touch X)
- **And** it enforces conventions with file references
- **And** it is under 500 lines (NOT 2000+)

### AC2: CLAUDE.md Token-Efficient Format
- **Given** the CLAUDE.md file at project root
- **When** I read it
- **Then** it mirrors QWEN.md structure
- **And** it references exact files needed for common tasks
- **And** it is under 300 lines

### AC3: Docs Deduplicated and Indexed
- **Given** the docs folders in modules and themes
- **When** I search for any topic
- **Then** I find ONE authoritative source
- **And** cross-references use relative links to the source
- **And** no duplicate content exists across module/theme docs

### AC4: Rules Files Consolidated
- **Given** the rules in QWEN.md, AGENTS.md, .agents/docs/
- **When** I look for a project rule
- **Then** I find it in ONE place
- **And** other files link to it (not duplicate it)

---

## Dev Technical Guidance

### Token Reduction Strategies Applied

1. **Decisions over descriptions**: QWEN.md uses `MUST/NEVER` with exact file paths, NOT vague summaries
2. **Pinpoint critical files**: Each rule references exact files (e.g., `Themes/Sixteen/resources/views/components/layouts/main.blade.php`)
3. **Hard boundaries**: `DO NOT touch X`, `ALWAYS use Y`
4. **Eliminate exploratory queries**: Agent is given exact files, no grep needed
5. **Deduplicate docs**: Single source of truth per topic, linked from everywhere else

### QWEN.md Optimization

**Current state**: Modular, references sub-docs — good structure.
**Needed**: Ensure sub-docs are token-efficient (no duplication, explicit paths).

### CLAUDE.md Optimization

**Current state**: Mirror of QWEN.md.
**Needed**: Same optimizations — decisions, paths, boundaries.

### Docs Deduplication Plan

| Topic | Authoritative Source | Duplicate Sources (remove/link) |
|---|---|---|
| HTML Body Parity | `Themes/Sixteen/docs/html-parity-body-policy.md` | Link from module docs, don't duplicate |
| Stepper Responsive | `.planning/stories/1-3-*.md` | Link from docs, don't re-explain |
| Header Parity | `.planning/stories/1-4-*.md` | Link from docs |
| Geolocation | `.planning/stories/1-5-*.md` | Link from docs |
| Wizard Refactor | `.planning/stories/1-6-*.md` | Link from docs |
| Translation Rules | `Modules/Fixcity/docs/html-body-parity-rule.md` | Consolidate with QWEN.md |

### Rules Consolidation Plan

| Rule | Current Location | Action |
|---|---|---|
| Body Plain | QWEN.md, .agents/qwen-critical-rules.md | Keep in QWEN.md, link from .agents |
| NO Filament Schemas Wizard | QWEN.md, .agents/qwen-critical-rules.md | Keep in QWEN.md, link from .agents |
| Translation 5-level | QWEN.md, .agents/qwen-critical-rules.md | Keep in QWEN.md, link from .agents |
| HTML Structural Parity | QWEN.md, .agents/qwen-critical-rules.md | Keep in QWEN.md, link from .agents |

### Implementation Steps

#### Step 1: Consolidate Rules in QWEN.md (Single Source)

Keep QWEN.md as the SINGLE authoritative source for critical rules. All other files (CLAUDE.md, .agents/docs/) should LINK to QWEN.md sections, not duplicate content.

#### Step 2: Deduplicate Module/Theme Docs

For each doc in `Modules/*/docs/` and `Themes/*/docs/`:
- If content duplicates QWEN.md rule → delete and link to QWEN.md
- If content has unique module-specific info → keep, but reference QWEN.md for general rules
- Ensure bidirectional links use relative paths

#### Step 3: Create Rules Index

Create `docs/project/rules-index.md` that maps every rule to its authoritative source:
```markdown
# Rules Index

| Rule | Authoritative Source |
|------|---------------------|
| Body Plain | [QWEN.md#body-plain](../../../QWEN.md) |
| NO Filament Schemas Wizard | [QWEN.md#no-filament-schemas](../../../QWEN.md) |
| Translation 5-Level | [QWEN.md#translation-format](../../../QWEN.md) |
| HTML Structural Parity | [QWEN.md#html-parity](../../../QWEN.md) |
| Geolocation Pattern | [Story 1-5](../../../.planning/stories/1-5-*.md) |
| Wizard Refactor Pattern | [Story 1-6](../../../.planning/stories/1-6-*.md) |
```

#### Step 4: Clean Up Redundant Files

Files to consolidate/remove:
- `_bmad-output/implementation-artifacts/` — hundreds of old story files, archive or delete
- `docs/ai-agents/` — 150+ files, many duplicates of QWEN.md rules
- Duplicate rule files in modules/themes docs

---

## Tasks / Subtasks

### Task 1: Create Rules Index (AC: 3, 4)
- [ ] Create `docs/project/rules-index.md`
- [ ] Map all rules to authoritative sources
- [ ] Add bidirectional links from QWEN.md to index
- [ ] Add bidirectional links from CLAUDE.md to index

### Task 2: Deduplicate QWEN.md / CLAUDE.md / .agents (AC: 1, 2)
- [ ] Read QWEN.md — identify duplicate content with CLAUDE.md and .agents
- [ ] Keep ONE authoritative version in QWEN.md
- [ ] Replace duplicates in CLAUDE.md with links to QWEN.md
- [ ] Replace duplicates in .agents with links to QWEN.md
- [ ] Verify QWEN.md is under 500 lines

### Task 3: Deduplicate Module/Theme Docs (AC: 3)
- [ ] Scan `Modules/*/docs/` for content that duplicates QWEN.md rules
- [ ] Replace duplicates with links to authoritative sources
- [ ] Scan `Themes/*/docs/` for same
- [ ] Verify each topic has ONE authoritative source

### Task 4: Archive Old Implementation Artifacts (AC: 3, 4)
- [ ] Review `_bmad-output/implementation-artifacts/` for old story files
- [ ] Archive or consolidate redundant files
- [ ] Keep only the latest version of each story/plan

---

## Risk Assessment

### Risks
- **Breaking existing links**: When consolidating docs, old links may break
- **Mitigation**: Use relative paths, test links after changes
- **Losing context**: Removing duplicate docs might remove unique nuances
- **Mitigation**: Before deleting, check if content has unique info worth preserving

---

## Definition of Done

- [ ] QWEN.md is under 500 lines with explicit decisions and paths
- [ ] CLAUDE.md links to QWEN.md instead of duplicating rules
- [ ] .agents/docs links to QWEN.md instead of duplicating rules
- [ ] No duplicate rule content across any doc files
- [ ] `docs/project/rules-index.md` exists with complete mapping
- [ ] Each topic has ONE authoritative source with links from everywhere else
