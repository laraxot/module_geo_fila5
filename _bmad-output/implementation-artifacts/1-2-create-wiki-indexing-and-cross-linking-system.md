# Story 1.2: Create Wiki Indexing and Cross-Linking System

**Status:** ready-for-dev  
**Epic:** 1 — Second Brain Foundation & Structure  
**Priority:** High (unblocks Stories 1.3, 2.1, 2.2, 2.3)  
**Created:** 2026-05-05

---

## Story

As a **developer**,  
I want **wiki pages indexed in QMD with bidirectional cross-linking**,  
so that **I can discover related documentation and navigate seamlessly between wiki pages and code documentation**.

---

## Acceptance Criteria

1. **Given** wiki pages exist across root, modules, and themes  
   **When** I search for a concept or topic  
   **Then** QMD returns relevant wiki pages with metadata (title, path, description)  
   **And** search completes within 2 seconds  
   **And** all wiki directories (`docs/wiki/`, `laravel/Modules/*/docs/wiki/`, `laravel/Themes/*/docs/wiki/`) are searchable

2. **Given** I am viewing a wiki page  
   **When** I look for related documentation  
   **Then** the system displays related wiki pages based on content similarity  
   **And** the system displays related module/theme documentation  
   **And** similarity links are bidirectional (wiki ↔ module, wiki ↔ theme, module ↔ theme)

3. **Given** a wiki page references a module or theme  
   **When** the page is indexed  
   **Then** the system automatically identifies the cross-reference  
   **And** the target module/theme documentation shows a backlink to the wiki page  
   **And** cross-references are discovered via both explicit links (`[[WikiLink]]` style) and semantic similarity

---

## Developer Context

### Epic Overview

**Epic 1: Module Documentation Foundation**

Goal: Establish standardized documentation templates and processes for all Laravel modules to ensure consistency and completeness across the codebase.

This story (1.2) creates the indexing infrastructure for all wikis established in Story 1.1, enabling Stories 1.3, 2.1, 2.2, and 2.3 to build upon a searchable knowledge base.

### Story 1.1 Foundation

Story 1.1 (Initialize Wiki Directory Structure) established:
- Root project wiki: `docs/wiki/` with index.md, log.md, patterns.md
- Module wikis: 37+ modules in `laravel/Modules/{Module}/docs/wiki/` with standardized index.md
- Theme wikis: 3 themes in `laravel/Themes/{Theme}/docs/wiki/` with standardized index.md
- Bash scripts wiki: `bashscripts/docs/wiki/` with index.md
- Standardized YAML frontmatter: name, description, type, related (array of paths)

This story (1.2) adds indexing, cross-reference discovery, and bidirectional navigation on top of Story 1.1's structure.

### Current Project State

**Wiki Structure:**
- Root wiki: `docs/wiki/` with 34+ files organized in subdirectories (_templates, concepts, how-to, sources, themes)
- Module wikis: Each module has `docs/wiki/` with standardized index.md (Story 1.1 completed)
- Theme wikis: `laravel/Themes/{Theme}/docs/wiki/` with standardized index.md (Story 1.1 completed)
- Total markdown documents: 14,897 across 45+ QMD collections
- Context-mode installed: v1.0.103 with FTS5 semantic search capability

**QMD Collections Available:**
- `base-modules-wiki` (12 docs) — Root wiki index
- `wiki` (97 docs) — Full root wiki
- `module_*` (37+ collections) — Individual module wikis
- `theme_*` (3 collections) — Theme wikis
- `bashscripts_docs` (655 docs) — Script documentation
- `main_docs`, `fixcity-docs`, `modules-docs` — Supporting documentation

**Existing Patterns:**
- YAML frontmatter in all wiki pages: name, description, type, related
- Cross-links use relative paths: `./related-concept.md` or `../../Module/docs/wiki/`
- Log updates: `docs/wiki/log.md` appended with [OPERATION] timestamp
- Git version control: All wiki changes committed

### Key Technical Requirements

**From PRD:**
- **NFR1 (Performance):** Search queries must complete within 2 seconds; related pages lookup < 2 seconds
- **NFR2 (Maintainability):** Documentation easily updatable; templates modular; changes propagate automatically
- **NFR3 (Accessibility):** WCAG 2.1 AA standards; screen reader compatible; keyboard navigable
- **NFR4 (Security):** Respects existing authentication; no sensitive data exposure; wiki editing follows permission models

**From Architecture:**
- **Pattern:** Document-as-Code with documentation stored in Git alongside source
- **Pattern:** Knowledge Graph with semantic relationships between documents
- **Pattern:** Automatic cross-linking based on content similarity
- **Technical Stack:** QMD (Quick Markdown Database) for efficient indexing and semantic search
- **Performance:** Caching of frequently accessed pages, lazy loading for related pages

**From Story 1.1:**
- Wiki structure is standardized across all modules and themes
- Frontmatter schema is consistent: name, description, type, related
- All relative linking follows established patterns
- Activity logged to docs/wiki/log.md

### Dependencies & Constraints

**Story Dependencies:**
- **Depends on:** Story 1.1 (wiki directory structure) — COMPLETED
- **Blocks:** Story 1.3 (Cross-Module Documentation Standards) — needs searchable wikis
- **Blocks:** Story 2.1 (QMD Search Integration) — builds on indexed content
- **Blocks:** Story 2.2 (Bidirectional Cross-Referencing) — uses cross-reference metadata
- **Blocks:** Story 2.3 (Automated Wiki Generation) — needs cross-reference graph

**Technical Constraints:**
- Must use QMD and context-mode for indexing (not custom solution)
- Must respect existing wiki directory structure (no reorganization)
- Must not modify core application code (documentation-only changes)
- Must maintain Git version control for all changes
- Must complete search queries within 2-second SLA

**Architectural Constraints:**
- Cross-references must be bidirectional (wiki ↔ code)
- Explicit links take precedence over semantic discovery
- Cache invalidation must happen on file changes
- Accessibility must not degrade performance

---

## Tasks / Subtasks

### Task 1: Analyze Current QMD Indexing Coverage (AC: #1)
- [ ] Check QMD system health: `qmd status`
- [ ] List all QMD collections currently indexed
- [ ] Verify all wiki directories are indexed
  - [ ] `docs/wiki/` (root wiki)
  - [ ] All `laravel/Modules/*/docs/wiki/` (37+ module wikis)
  - [ ] All `laravel/Themes/*/docs/wiki/` (3 theme wikis)
  - [ ] `bashscripts/docs/wiki/` (scripts wiki)
- [ ] Identify indexing gaps (if any collections missing)
- [ ] Document current collection sizes and document counts
- [ ] Create QMD indexing manifest: `docs/wiki/how-to/qmd-indexing-manifest.md`

### Task 2: Implement Wiki Page Metadata Extraction (AC: #1)
- [ ] Create metadata extraction tool
  - [ ] Parse YAML frontmatter from all wiki pages
  - [ ] Extract: name, description, type, related, file_path, last_modified
  - [ ] Store metadata in searchable format (JSON or database)
- [ ] Validate frontmatter schema
  - [ ] Ensure all required fields present (name, description, type)
  - [ ] Verify related paths are valid (point to existing files)
  - [ ] Flag pages with incomplete or invalid metadata
- [ ] Create cross-reference inventory
  - [ ] Build map: source_page → [explicit_links]
  - [ ] Build map: source_page → [mentioned_modules/themes]
  - [ ] Store in `.cache/wiki-cross-references.json`

### Task 3: Build Bidirectional Cross-Reference Graph (AC: #2, #3)
- [ ] Create cross-reference graph structure
  - [ ] Node: wiki page or module/theme
  - [ ] Edge: relationship type (concept, implementation, example, related)
  - [ ] Metadata: confidence_score, link_type (explicit, semantic, mention)
- [ ] Implement explicit link discovery
  - [ ] Parse `[[WikiLink]]` style links
  - [ ] Parse `[text](relative-path.md)` markdown links
  - [ ] Extract all links from wiki frontmatter `related:` field
- [ ] Implement semantic link discovery
  - [ ] Use QMD semantic search to find related pages
  - [ ] Calculate similarity scores (0-1 confidence)
  - [ ] Filter results with threshold (default: 0.7)
- [ ] Build bidirectional mapping
  - [ ] `get_outgoing_links(page_path)` → returns pages this page links to
  - [ ] `get_incoming_links(page_path)` → returns pages that link to this page
  - [ ] `find_related_pages(page_path, similarity_threshold=0.7)` → semantic neighbors
- [ ] Store graph in `.cache/wiki-graph.json` for fast lookup
- [ ] Implementation note: graph includes wiki→wiki, wiki→module, wiki→theme, module→theme relationships

### Task 4: Integrate QMD Search Indexing (AC: #1)
- [ ] Verify QMD collections cover all wiki directories
  - [ ] Check if existing `wiki`, `base-modules-wiki`, `module_*`, `theme_*` collections sufficient
  - [ ] If gaps exist, create new collections via QMD configuration
- [ ] Build QMD search interface
  - [ ] Create CLI command: `qmd query "search term"`
  - [ ] Or API endpoint: `GET /api/wiki/search?q=term&limit=10`
  - [ ] Support semantic search (default) + keyword search (fallback)
- [ ] Implement search result formatting
  - [ ] Return: title, path, description, type, snippet (100 chars)
  - [ ] Include metadata: last_modified, related_count, link_type
  - [ ] Add similarity score (for semantic results)
- [ ] Performance optimization
  - [ ] Benchmark current search performance
  - [ ] Implement caching for frequent queries: `.cache/wiki-search-cache.json`
  - [ ] If > 2 seconds: optimize index or query strategy
  - [ ] Load test with representative dataset
- [ ] Test searchability of all wiki directories
  - [ ] Test keyword search returns pages from docs/wiki/
  - [ ] Test module wiki search returns module-specific pages
  - [ ] Test theme wiki search returns theme-specific pages
  - [ ] Verify search completes < 2 seconds

### Task 5: Implement Related Pages Discovery (AC: #2)
- [ ] Create "Related Pages" section display logic
  - [ ] Fetch 3-5 most relevant related pages via cross-reference graph
  - [ ] Sort by relevance: explicit links first, then semantic (descending confidence)
  - [ ] Include similarity score or relevance label
- [ ] Implement "Related Module/Theme Docs" section
  - [ ] For wiki pages that mention modules/themes
  - [ ] Display links to module/theme index.md and relevant concept pages
  - [ ] Show link type: concept, implementation, example
- [ ] Implement "Referenced By" backlinks section
  - [ ] Show pages that link to current page
  - [ ] Show pages that mention current module/theme
  - [ ] Display backlink type and confidence
- [ ] Add navigation breadcrumbs
  - [ ] Show: Project > [Module/Theme] > [Wiki Page]
  - [ ] Allow back-navigation through link chain
  - [ ] Maintain navigation history for "previous page" links

### Task 6: Implement Accessibility & UX (AC: #1, #2)
- [ ] Screen reader optimization
  - [ ] ARIA labels for all cross-reference links: `aria-label="Link to {target} documentation"`
  - [ ] Descriptive link text (not "click here")
  - [ ] List of related pages announced as list to screen readers
  - [ ] Test with accessibility tools (axe, WAVE)
- [ ] Keyboard navigation
  - [ ] All links keyboard navigable (Tab key)
  - [ ] Related pages section keyboard accessible
  - [ ] Backlinks section keyboard accessible
  - [ ] No keyboard traps
- [ ] Visual accessibility
  - [ ] High contrast mode support
  - [ ] Link underlines or other visual indicators
  - [ ] Clear focus indicators for keyboard navigation
  - [ ] WCAG 2.1 AA color contrast (4.5:1 minimum)
- [ ] Test on multiple environments
  - [ ] Screen reader: NVDA, JAWS (Windows), VoiceOver (Mac)
  - [ ] Browser: Chrome, Firefox, Safari
  - [ ] Mobile: Responsive design for tablet/phone

### Task 7: Create Link Validation & Maintenance (AC: #3)
- [ ] Implement link validation
  - [ ] Validate all explicit wiki links point to existing files
  - [ ] Flag broken links (source exists, target deleted)
  - [ ] Support dry-run to preview corrections
- [ ] Create link maintenance process
  - [ ] When wiki page renamed/moved: update all backlinks
  - [ ] When module structure changes: update forward links
  - [ ] Support manual link updates via frontmatter
- [ ] Implement link health checks
  - [ ] Periodic scan for broken cross-references
  - [ ] Report missing or invalid links
  - [ ] Suggest updates based on content similarity
  - [ ] Create health report: `docs/wiki/how-to/link-health-report.md`
- [ ] Cache invalidation strategy
  - [ ] Detect file changes (git commit hook or file watcher)
  - [ ] Invalidate `.cache/wiki-cross-references.json` on changes
  - [ ] Invalidate `.cache/wiki-graph.json` on changes
  - [ ] Rebuild affected indexes on next query

### Task 8: Testing (AC: #1, #2, #3)
- [ ] Unit tests: Core indexing functions
  - [ ] `extract_frontmatter(page_path)` — parses YAML correctly
  - [ ] `parse_wiki_links(page_content)` — identifies explicit links
  - [ ] `find_semantic_links(page_path)` — returns relevant pages
  - [ ] `get_outgoing_links(page)` — correct forward links
  - [ ] `get_incoming_links(page)` — correct backlinks
- [ ] Integration tests: End-to-end workflows
  - [ ] Wiki page creation → indexing → search → discovery
  - [ ] Cross-reference detection: explicit links parsed correctly
  - [ ] Semantic discovery: related pages identified accurately
  - [ ] Bidirectional navigation: forward and back links work both directions
- [ ] Performance tests
  - [ ] Single page search < 2 seconds
  - [ ] Batch search (10+ pages) < 2 seconds
  - [ ] Related pages lookup < 1 second (from cache)
  - [ ] Cross-reference graph build < 5 seconds
- [ ] Acceptance tests: AC #1, #2, #3
  - [ ] AC #1: All wiki pages indexed and searchable
  - [ ] AC #2: Related pages discovered correctly (both explicit + semantic)
  - [ ] AC #3: Cross-references identified automatically
  - [ ] Test on representative pages: 10+ from docs/wiki/, modules, themes
- [ ] Accessibility tests
  - [ ] All links keyboard navigable
  - [ ] Links have descriptive ARIA labels
  - [ ] Screen reader announces link type and target
  - [ ] Related pages section readable by screen reader
- [ ] Edge case testing
  - [ ] Empty query handling
  - [ ] Special characters in search terms
  - [ ] Pages with no related pages
  - [ ] Circular references (A→B→A)
  - [ ] Renamed files breaking links

### Task 9: Documentation & Integration (AC: General)
- [ ] Create wiki indexing guide: `docs/wiki/how-to/wiki-indexing-guide.md`
  - [ ] How QMD indexing works
  - [ ] How to search: CLI and API patterns
  - [ ] How to add new wiki pages (they auto-index)
  - [ ] Troubleshooting search issues
- [ ] Create cross-linking guide: `docs/wiki/how-to/wiki-cross-linking.md`
  - [ ] How to create explicit wiki links
  - [ ] How to set up frontmatter `related:` field
  - [ ] How to reference modules/themes from wiki
  - [ ] When to use explicit vs. semantic links
- [ ] Update root wiki: `docs/wiki/index.md`
  - [ ] Add section: "Wiki Indexing & Search"
  - [ ] Link to new guides
  - [ ] Explain how to discover related documentation
- [ ] Update module wiki templates: `laravel/Modules/{Module}/docs/wiki/index.md`
  - [ ] Add section: "Related Documentation"
  - [ ] Explain how to navigate to wiki pages
  - [ ] Show examples of module→wiki links
- [ ] Create indexing manifest: `docs/wiki/how-to/qmd-indexing-manifest.md`
  - [ ] List all collections indexed
  - [ ] Document collection sizes
  - [ ] Explain indexing strategy
  - [ ] Show how to update indexes
- [ ] Update log: `docs/wiki/log.md`
  - [ ] Append entry: "[WIKI_INDEXING_COMPLETE] 2026-05-05 — Wiki indexing system implemented"
  - [ ] List files created/modified
  - [ ] Document key accomplishments

---

## Dev Notes

### Architecture Patterns to Follow

**Document-as-Code Pattern:**
- Wiki documentation lives in Git alongside source code
- All wikis version-controlled, indexed, searchable
- Changes tracked in `docs/wiki/log.md`
- Search index derived from wiki source files

**Knowledge Graph Pattern:**
- Semantic relationships between documents enable discovery
- Bidirectional links form a graph structure
- Use QMD FTS5 for similarity calculation
- Automatic cross-linking based on content similarity

**Continuous Integration Pattern:**
- Pre-commit hooks validate wiki formatting (future enhancement)
- Search indexes rebuilt on documentation changes
- Cache invalidation on file changes
- Deployment pipeline updates search indexes

### Project Structure Notes

**Wiki Directory Organization:**
```
docs/wiki/                          # Root wiki
  ├── index.md                      # Navigation hub
  ├── log.md                        # Activity tracking
  ├── _templates/                   # Page templates
  ├── concepts/                     # Concept pages
  ├── how-to/                       # How-to guides
  ├── sources/                      # Reference docs
  └── themes/                       # Theme docs

laravel/Modules/{Module}/docs/wiki/ # Module wiki (37+ modules)
  ├── index.md                      # Module index
  ├── core-concepts.md
  ├── architecture.md
  ├── models.md
  ├── patterns.md
  └── [other concept pages]

laravel/Themes/{Theme}/docs/wiki/   # Theme wiki (3 themes)
  ├── index.md
  └── [component, styling pages]

bashscripts/docs/wiki/              # Scripts documentation
  └── index.md
```

**Frontmatter Standard (Story 1.1):**
```yaml
---
name: Page Title (max 60 chars)
description: One-line summary for search (max 150 chars)
type: entity | concept | architecture | pattern | guide
related:
  - ../other-page.md
  - ../../Module/docs/wiki/page.md
---

# Page Title
Content...
```

**Cache Storage:**
- `.cache/wiki-cross-references.json` — Explicit link inventory
- `.cache/wiki-graph.json` — Bidirectional reference graph
- `.cache/wiki-search-cache.json` — Frequent search results (LRU, 100 entries)
- `.cache/wiki-health-report.md` — Link validation report

**Files Modified in Story 1.1 (context):**
- All `*/docs/wiki/index.md` files created with standardized frontmatter
- `docs/wiki/index.md` created as root index
- `docs/wiki/log.md` exists (activity tracking)

**Key Files to Reference:**
- `CLAUDE.md` — Project mandate for LLM Wiki pattern
- `.context-mode.json` — Configuration for context-mode FTS5
- `_bmad-output/planning-artifacts/prd.md` — Functional requirements
- `_bmad-output/planning-artifacts/architecture.md` — Technical architecture

### Testing Standards

From CLAUDE.md and project patterns:
- Use QMD and context-mode for integration tests (not mock data)
- Integration tests preferred for search/discovery workflows
- Performance benchmarking with real wiki dataset (14,897 documents)
- Manual smoke tests for accessibility (keyboard + screen reader)
- Edge cases: circular references, moved files, empty results

### Dependencies & Block Relationships

**Critical Dependencies:**
- Story 1.1 must be COMPLETED (wiki structure exists)
- Context-mode v1.0.103+ must be installed (for FTS5 semantic search)
- QMD collections must exist (base-modules-wiki, wiki, module_*, theme_*)

**Blocks These Stories:**
- Story 1.3: Needs indexed/searchable wiki to validate cross-module standards
- Story 2.1: Needs cross-reference metadata to implement search integration
- Story 2.2: Needs graph structure to implement bidirectional linking
- Story 2.3: Needs cross-reference data for automated wiki generation

---

## Previous Story Intelligence

**Story 1.1: Initialize Wiki Directory Structure**
- Established wiki structure for all modules, themes, and root
- Created standardized YAML frontmatter format
- Set up directory layout across 37+ modules and 3 themes
- Context-mode already installed for semantic search

**Key Learnings for Story 1.2:**
1. Wiki structure is complete and standardized (no reorganization needed)
2. Frontmatter schema is consistent (simplifies metadata extraction)
3. Context-mode FTS5 is available for semantic similarity calculations
4. QMD collections already include wiki directories
5. Git version control tracks all wiki changes

**Patterns Established in Story 1.1:**
- All index.md files follow identical structure
- Cross-links use relative paths: `./` for same directory, `../../` for modules
- Logging pattern: append to `docs/wiki/log.md` with [OPERATION] timestamp
- File naming: lowercase, hyphenated (e.g., core-concepts.md)

---

## Implementation Roadmap

### Phase 1: Analysis & Metadata (Days 1-2)
- [ ] Analyze QMD coverage and wiki structure
- [ ] Extract frontmatter from all wiki pages
- [ ] Create cross-reference inventory
- [ ] Identify gaps or issues

### Phase 2: Core Indexing (Days 3-4)
- [ ] Implement metadata extraction tool
- [ ] Build cross-reference graph structure
- [ ] Integrate with QMD search
- [ ] Test searchability

### Phase 3: Bidirectional Navigation (Days 5-6)
- [ ] Implement related pages discovery
- [ ] Create backlink generation
- [ ] Add breadcrumb navigation
- [ ] Integrate accessibility features

### Phase 4: Performance & Validation (Days 7-8)
- [ ] Performance testing and optimization
- [ ] Link validation and health checks
- [ ] Accessibility testing
- [ ] Edge case handling

### Phase 5: Testing & Documentation (Days 9-10)
- [ ] Unit + integration tests
- [ ] Acceptance testing against AC
- [ ] Create user guides
- [ ] Update wiki index and log

---

## Acceptance Criteria Map

| AC | Implementation Task(s) |
|----|-----------------------|
| AC #1: Searchable indexed wiki | Tasks 1, 2, 4, 8 |
| AC #2: Related pages discovery | Tasks 3, 5, 8 |
| AC #3: Auto cross-references | Tasks 2, 3, 7, 8 |
| All: Performance < 2 seconds | Tasks 4, 7, 8 |
| All: Accessibility WCAG AA | Tasks 6, 8 |

---

## Definition of Done (Beyond AC)

- [ ] All wiki pages indexed in QMD (14,897+ documents)
- [ ] Cross-reference graph built and cached
- [ ] Bidirectional navigation working (wiki ↔ module ↔ theme)
- [ ] Search performance tested (< 2 seconds confirmed)
- [ ] Accessibility verified (keyboard + screen reader tested)
- [ ] Related pages discovery working (semantic + explicit)
- [ ] Link validation implemented (broken links detected)
- [ ] Cache invalidation working (updates on file changes)
- [ ] All guides created (indexing, cross-linking, health)
- [ ] docs/wiki/index.md updated with indexing system docs
- [ ] docs/wiki/log.md appended with completion entry
- [ ] Sprint status updated (Story 1.2 marked done)
- [ ] All tests passing (unit + integration + acceptance)

---

## Dev Agent Record

### Agent Model Used
Claude Haiku 4.5 (Continuation from BMAD workflow)

### Story Created
2026-05-05 — Comprehensive wiki indexing context prepared for implementation

### Completion Notes (To Be Updated by Dev)
_[Developer will update this section after implementation]_

### File List (To Be Updated by Dev)
_[Developer will update this section with all files created/modified]_

---

## Questions for Clarification (Optional)

1. **Search Interface:** Should wiki search be CLI-based (`qmd query "term"`) or integrated into a web interface? Or both?
2. **Similarity Threshold:** What confidence threshold for semantic links (default 0.7)? Should this be configurable?
3. **Related Pages Count:** Show 3-5 related pages? Any limit on displayed backlinks?
4. **Link Types:** Beyond concept/implementation/example, are other relationship types needed (e.g., prerequisite, depends-on)?
5. **Cache Strategy:** How often should cross-reference graph be rebuilt? On every commit or manually?

---

**Ready for Development Agent Execution**

This story builds the indexing and cross-linking foundation for the entire second brain system. The developer has comprehensive context from Story 1.1, proven patterns from Stories 2.1-2.2, and clear acceptance criteria. 🚀
