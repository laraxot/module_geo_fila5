# Story 2.1: QMD Search Integration

**Status:** ready-for-dev  
**Epic:** 2 - Wiki Integration and Search  
**Priority:** High (blocks Epic 2 progression)  
**Created:** 2026-04-29

---

## Story

As a **developer**,  
I want **QMD search integrated with the wiki**,  
so that **I can quickly find relevant documentation using keyword and semantic search**.

---

## Acceptance Criteria

1. **Given** wiki pages exist in the system  
   **When** I search for a term using the search interface  
   **Then** QMD search processes the query and returns relevant results  
   **And** search results include documentation from the wiki  
   **And** search queries complete within 2 seconds

2. **Given** I am viewing a wiki page  
   **When** I use the search function  
   **Then** related wiki pages are returned based on content similarity  
   **And** cross-references to the current page are identified

---

## Developer Context

### Epic Overview
**Epic 2: Wiki Integration and Search**

Goal: Enhance the wiki system with QMD search integration to enable efficient searching and cross-referencing of documentation.

This story is the foundation of Epic 2 and enables Stories 2.2 and 2.3.

### Current Wiki Status

From the project, wiki structure exists:
- Root wiki: `docs/wiki/` with index.md and multiple concept pages
- Module wikis: `laravel/Modules/{Module}/docs/wiki/` (Activity, Gdpr, etc.)
- Theme wikis: `laravel/Themes/{Theme}/docs/wiki/` (One, Zero, etc.)
- Context-mode integration: Already installed (v1.0.103) for semantic search [Source: .context-mode.json, docs/wiki/how-to/context-mode-overflow-prevention.md]

### QMD System Status

QMD (Query Markdown Database) is available in the project:
- Commands: `qmd query`, `qmd get`, `qmd multi_get`, `qmd status`
- MCP server: `mcp__plugin_qmd_qmd__*` tools
- Collections available: multiple indexed sources
- Status check available: `qmd status`

### Key Technical Requirements

**From PRD [Source: _bmad-output/planning-artifacts/prd.md]:**
- NFR1: Search queries must complete within **2 seconds**
- NFR3: Search results must be accessible to screen readers
- FR4: Semantic search for related concepts
- FR4: Filtering by module, theme, and document type

**From Architecture [Source: _bmad-output/planning-artifacts/architecture.md]:**
- Technical Stack: QMD (Quick Markdown Database) for efficient indexing
- Architecture Pattern: Knowledge Graph with semantic relationships
- Integration Points: Maintain existing wiki structure while enhancing search
- Performance: Lazy loading, caching of frequently accessed pages

---

## Tasks / Subtasks

### Task 1: Analyze Current QMD Setup and Wiki Coverage (AC: #1)
- [ ] Check QMD system health: run `qmd status`
- [ ] List all QMD collections currently indexed
- [ ] Verify all wiki directories are discoverable by QMD
  - [ ] `docs/wiki/` (root)
  - [ ] All `laravel/Modules/*/docs/wiki/` directories
  - [ ] All `laravel/Themes/*/docs/wiki/` directories
- [ ] Document current coverage gaps (if any)
- [ ] Create QMD indexing manifest documenting what's indexed and why

### Task 2: Implement Wiki Search Interface (AC: #1, #2)
- [ ] Create search endpoint or CLI interface for wiki queries
  - [ ] If using API: Create endpoint like `GET /api/wiki/search?q=:query`
  - [ ] If using CLI: Create command like `qmd query "search term"`
- [ ] Implement query parameter: support keyword search
- [ ] Implement response format: return results with title, path, snippet
- [ ] Ensure < 2 second response time [Requirement: NFR1 - Performance]
- [ ] Add metadata to results: last update date, document type (wiki, module docs, etc.)

### Task 3: Implement Semantic Search (AC: #2)
- [ ] Configure QMD semantic search for "related wiki pages"
  - [ ] Use context-mode FTS5 backend for similarity matching
  - [ ] Test semantic similarity: search for concept A should return pages with related concepts
- [ ] Implement "related pages" sidebar or section
  - [ ] Show 3-5 most relevant related pages
  - [ ] Display similarity score or confidence
  - [ ] Display bidirectional links (pages that link back)
- [ ] Cross-reference identification
  - [ ] Extract wiki cross-references and backlinks
  - [ ] Mark pages that reference current page
  - [ ] Update cross-reference display when searching

### Task 4: Performance Optimization (AC: #1)
- [ ] Benchmark current search performance
- [ ] Implement caching for frequent queries
- [ ] Profile QMD indexing and query time
- [ ] If > 2 seconds: optimize index or query strategy
- [ ] Load test with representative wiki dataset
- [ ] Document performance metrics in story completion notes

### Task 5: Accessibility & UX (AC: #1)
- [ ] Ensure search results are screen-reader friendly
  - [ ] Test with accessibility tools
  - [ ] Verify ARIA labels on result elements
  - [ ] Ensure keyboard navigation works [Requirement: NFR3 - Accessibility]
- [ ] Create search help/documentation
- [ ] Test search on mobile (if UI component involved)

### Task 6: Testing (AC: #1, #2)
- [ ] Unit tests: QMD query functions return expected results
- [ ] Integration tests: Wiki indexing + search query flow
- [ ] Acceptance tests: Run against AC #1 and #2
  - [ ] Test keyword search returns relevant wiki pages
  - [ ] Test semantic search returns related pages
  - [ ] Test performance < 2 seconds
  - [ ] Test cross-reference identification
- [ ] Test all wiki directories are searchable
- [ ] Test edge cases: empty query, special characters, nonexistent terms

### Task 7: Documentation (AC: General)
- [ ] Update `docs/wiki/` index with link to search feature
- [ ] Document how to use wiki search in `docs/wiki/how-to/`
- [ ] Update QMD usage guide if needed
- [ ] Add search troubleshooting tips

---

## Dev Notes

### Architecture Patterns to Follow

**Document-as-Code Pattern [Source: architecture.md]:**
- Keep wiki documentation in repository alongside code
- Wiki is version-controlled via Git
- Search index is derived from wiki source files

**Knowledge Graph Pattern [Source: architecture.md]:**
- Semantic relationships between documents enable "related pages"
- Use context-mode or QMD semantic capabilities for similarity
- Automatic cross-linking based on content similarity

**Continuous Integration Pattern [Source: architecture.md]:**
- Pre-commit hooks could validate wiki formatting (nice-to-have for future story)
- Search indexes rebuilt on documentation changes

### Project Structure Notes

**Wiki Directory Structure [Observed from repository]:**
```
docs/wiki/
├── index.md                                    # Root index
├── _templates/                                 # Wiki templates
├── concepts/                                   # Concept pages
├── how-to/                                     # How-to guides
├── sources/                                    # Source documentation
└── log.md                                      # Activity log

laravel/Modules/{Module}/docs/wiki/
├── index.md                                    # Module wiki index
├── core-concepts.md
├── architecture.md
├── models.md
├── patterns.md
└── [optional] context-mode-integration.md

laravel/Themes/{Theme}/docs/wiki/
├── Similar structure to modules
```

**Current Wiki Tool Status [Source: .context-mode.json]:**
- Context-mode installed (v1.0.103) with FTS5 for semantic search
- Available indexing commands: `/ctx-index`, `/ctx-search`
- Guideline: Index only documentation, not raw code [Requirement: prevent overflow]

**Key Files to Understand:**
- `docs/wiki/` — Root wiki organization [Source: docs/wiki/index.md]
- `_bmad-output/sprint-status.yaml` — Story progress tracking
- `.context-mode.json` — Context-mode configuration and index policy

### Dependencies & Constraints

**Story Dependencies:**
- **Blocks:** Story 2.2 (Bidirectional Cross-Referencing) and Story 2.3 (Automated Wiki Generation)
- **Depends on:** Epic 1 stories (wiki structure must exist, currently ready-for-dev)

**Technical Constraints:**
- Must use QMD or context-mode for search (not custom full-text search)
- Must respect existing wiki directory structure (no reorganization)
- Must not modify core application code (documentation-only changes)
- Must complete within performance budget: < 2 seconds per query [Requirement: NFR1]

### Testing Standards

From CLAUDE.md and project patterns:
- Use existing testing frameworks
- Integration tests preferred over unit tests for search flows
- Test coverage for critical paths
- Manual smoke tests for UX/accessibility

---

## Previous Story Intelligence

**Prior Story 1.5: Second Brain Internet Research and Federated Docs Updates**
- Established wiki indexing with context-mode
- Created overflow prevention guide (`docs/wiki/how-to/context-mode-overflow-prevention.md`)
- Configured `.context-mode.json` with selective indexing policy
- Learned: semantic search is now available via context-mode FTS5

**Key Learnings for This Story:**
1. Context-mode is the primary tool for semantic search (not custom implementation)
2. Wiki indexing is already set up; focus on *search interface* not indexing
3. Accessibility and performance are critical (documented in overflow prevention)
4. Use `ctx_search` and `ctx_index` for search operations

**Files Modified in Epic 1:**
- `docs/wiki/index.md` — Updated with new guides
- `docs/wiki/how-to/context-mode-overflow-prevention.md` — Performance guidance
- `.context-mode.json` — Configuration for lean indexing
- Multiple module/theme wiki files indexed

**Patterns Established:**
- Wiki pages use YAML frontmatter (name, description, type, related)
- Cross-links use relative paths: `./core-concepts.md` or `../../Module/docs/wiki/`
- Log updates in `docs/wiki/log.md` after changes

---

## Git Intelligence

**Recent Commits (from Epic 1 work):**
- `fix: Context-mode configuration and overflow prevention` — Added `.context-mode.json`, prevention guide
- `chore: Generate sprint-status.yaml for PTVX project` — Sprint tracking initialized
- Related to documentation, no code changes to workflows

**Relevant Patterns from Recent Work:**
- Documentation is wiki-first (stored in `docs/wiki/`, not inline)
- Changes update both content and index
- All wiki changes logged to `docs/wiki/log.md`
- Commits use conventional prefix: `docs:`, `feat:`, `fix:`

**Recommendations:**
- Follow wiki-first pattern: update `docs/wiki/` → update index → update log → commit
- Use `docs:` commit prefix for documentation changes

---

## Project Context Reference

**From CLAUDE.md [Project Instructions]:**
- Mandate: LLM Wiki pattern must be followed
  - Workflow: qmd query → work → document in wiki → update index
  - Update `docs/wiki/log.md` with changes
- User preference: wiki updates must persist to repository, not stay in chat
- Required use of context-mode for large searches (prevent token overflow)

**From Memory [Persistent User Preferences]:**
- Laravel accessor pattern: split into `get*Attribute()` and `get*()` methods
- LLM Wiki mandatory: always query → document → update
- Context-mode overflow prevention: use sandbox processing (ctx_batch_execute, ctx_execute_file)

**Project-Wide Standards [From architecture.md and wiki concepts]:**
- Module structure: standardized layout with docs/
- Actions over services: preferred business logic pattern
- Document-as-Code: docs live in Git, version-controlled
- Cross-linking: relative paths within wiki, absolute paths to code

---

## Acceptance Criteria Map

| AC | Implementation Task(s) |
|----|-----------------------|
| AC #1: Keyword search within 2 seconds | Tasks 2, 4, 6 |
| AC #2: Related pages + cross-references | Task 3, 6 |
| Both: Screen reader accessibility | Task 5, 6 |

---

## Implementation Notes for Developer

### What This Story Is
- **Integration task:** Connect QMD/context-mode to wiki for user-facing search
- **Not a redesign:** Existing wiki structure stays as-is
- **Performance critical:** 2-second SLA is hard requirement

### What This Story Is NOT
- Automated wiki generation (Story 2.3)
- Bidirectional code-to-wiki linking (Story 2.2)
- Search UI redesign or new components (unless absolutely minimal)
- Modifying core app code

### Definition of Done (Beyond AC)
- [ ] Search works on all wiki directories (root + modules + themes)
- [ ] Performance tested and documented (< 2 seconds)
- [ ] Accessibility verified
- [ ] All wiki search documentation updated
- [ ] `docs/wiki/log.md` appended with changes
- [ ] Story marked `done` in sprint-status.yaml (via code-review workflow)

---

## Dev Agent Record

### Agent Model Used
Claude Sonnet 4.6 (Ultimate BMAD Context Engine)

### Story Created
2026-04-29 — Comprehensive story context generated for flawless implementation

### Completion Notes (To Be Updated by Dev)
_[Developer will update this section after implementation]_

### File List (To Be Updated by Dev)
_[Developer will update this section with all files created/modified]_

---

## Questions for Clarification (Optional)

1. **Search Interface:** Should this be a CLI command (`qmd search "term"`), API endpoint, or both?
2. **Search UI:** If web-based, should it be a dedicated page or integrated into existing wiki UI?
3. **Semantic Tuning:** Any specific similarity threshold for "related pages" (e.g., >0.7 confidence)?

---

**Ready for Development Agent Execution**

This story has been crafted with comprehensive context, architecture guardrails, and learnings from prior stories. The developer has everything needed for flawless implementation. 🚀
