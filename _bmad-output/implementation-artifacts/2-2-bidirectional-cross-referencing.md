# Story 2.2: Bidirectional Cross-Referencing

**Status:** ready-for-dev  
**Epic:** 2 - Wiki Integration and Search  
**Priority:** High (builds on Story 2.1, enables Story 2.3)  
**Created:** 2026-04-29

---

## Story

As a **knowledge manager**,  
I want **bidirectional cross-referencing between wiki and code documentation**,  
so that **I can navigate seamlessly between related documentation**.

---

## Acceptance Criteria

1. **Given** a wiki page references a module or theme  
   **When** I view the wiki page  
   **Then** I can click the reference to navigate to the associated code documentation  
   **And** code documentation pages show links to related wiki pages

2. **Given** I am viewing code documentation for a module  
   **When** I look for related wiki pages  
   **Then** the system displays links to relevant wiki documentation  
   **And** the links are bidirectional (wiki → code and code → wiki)

---

## Developer Context

### Epic Overview
**Epic 2: Wiki Integration and Search**

Goal: Enhance the wiki system with QMD search integration to enable efficient searching and cross-referencing of documentation.

This story builds directly on Story 2.1 (QMD Search Integration) and enables Story 2.3 (Automated Wiki Generation).

### Story 2.1 Dependency & Foundation

Story 2.1 provided:
- QMD search interface for wiki queries
- Semantic similarity search for "related pages"
- Cross-reference identification via backlinks
- Performance optimization (< 2 seconds)
- Accessibility compliance (WCAG 2.1 AA)

This story extends that foundation by:
- Creating explicit bidirectional links between wiki and code docs
- Implementing reference resolution (wiki page → module docs navigation)
- Adding backlink display (module docs → related wiki pages)
- Automating link discovery via semantic similarity + keyword matching

### Current Project Structure

**Wiki Structure [Established in Epic 1]:**
```
docs/wiki/
├── index.md                          # Root wiki entry
├── concepts/                         # Architecture concepts
├── how-to/                           # Implementation guides
├── sources/                          # Reference documentation
└── log.md                            # Activity log

laravel/Modules/{Module}/docs/wiki/
├── index.md                          # Module wiki index
├── core-concepts.md
├── architecture.md
├── models.md
├── patterns.md
└── context-mode-integration.md (optional)

laravel/Themes/{Theme}/docs/wiki/
├── Similar structure
```

**Documentation Pattern [From Story 2.1]:**
- YAML frontmatter: name, description, type, related
- Cross-links use relative paths
- Activity logged in docs/wiki/log.md
- Context-mode FTS5 for semantic search

### Key Technical Requirements

**From PRD [Source: _bmad-output/planning-artifacts/prd.md]:**
- NFR1: Cross-reference resolution must complete within 2 seconds
- NFR3: Links must be accessible via keyboard and screen readers
- FR3: Automated cross-referencing between wiki and code documentation
- Knowledge graph: Semantic relationships enable bidirectional navigation

**From Architecture [Source: _bmad-output/planning-artifacts/architecture.md]:**
- Pattern: Knowledge Graph with semantic relationships
- Document-as-Code: Documentation lives in Git alongside code
- Automatic cross-linking based on content similarity
- IDE integration for documentation preview

**From Story 2.1 Learnings:**
- Use QMD and context-mode for semantic link discovery
- Performance is critical: cache frequently accessed links
- Accessibility: ARIA labels on all link elements
- Log all changes to docs/wiki/log.md

---

## Tasks / Subtasks

### Task 1: Analyze Cross-Reference Patterns (AC: Both)
- [ ] Identify all existing wiki → module/theme references
  - [ ] Search docs/wiki/ for module names or [[wiki links]]
  - [ ] Search module/theme wikis for references to root docs/wiki/
  - [ ] Document current manual cross-reference patterns
- [ ] Map relationship types
  - [ ] Wiki concept → Module API documentation
  - [ ] Wiki how-to guide → Theme component documentation
  - [ ] Module patterns → Related wiki pages
- [ ] Create cross-reference inventory documenting:
  - [ ] Source → Target pairs
  - [ ] Relationship type (concept, implementation, example)
  - [ ] Directionality (one-way, bidirectional existing)
- [ ] Identify priority links to implement first

### Task 2: Implement Wiki → Code Reference Resolution (AC: #1)
- [ ] Create reference detection in wiki pages
  - [ ] Parse wiki frontmatter for module/theme references
  - [ ] Scan wiki content for [[WikiLink]] patterns that reference modules
  - [ ] Extract module name, document type from context
- [ ] Implement link generation for wiki pages
  - [ ] Generate clickable links to associated module/theme documentation
  - [ ] Example: Wiki page → Module core-concepts.md, architecture.md
  - [ ] Support relative and absolute path resolution
- [ ] Add reference context to wiki frontmatter
  - [ ] New field: `references: [module1, module2, theme1]`
  - [ ] Optional: `reference_type: [concept, implementation, example]`
- [ ] Test on existing wiki pages with module references
  - [ ] docs/wiki/concepts/module-structure.md → laravel/Modules/*/docs/wiki/
  - [ ] docs/wiki/concepts/architecture-guardrails.md → Architecture docs

### Task 3: Implement Code → Wiki Backlink Resolution (AC: #2)
- [ ] Create backlink discovery for module/theme documentation
  - [ ] Scan wiki pages to identify which link back to current module
  - [ ] Use semantic similarity from Story 2.1 to find related wiki pages
  - [ ] Use keyword matching for explicit [[module-name]] references
- [ ] Implement "Related Wiki Pages" section in module docs
  - [ ] Display 3-5 most relevant related wiki pages
  - [ ] Show link type (concept, implementation, example)
  - [ ] Include similarity score or confidence
  - [ ] Make links clickable (navigate to wiki page)
- [ ] Support both explicit and semantic link discovery
  - [ ] Explicit: Parse [[WikilinkStyle]] references
  - [ ] Semantic: Use context-mode similarity search
  - [ ] Combine results: explicit links first, semantic second
- [ ] Test backlink generation
  - [ ] Module core-concepts.md shows related wiki pages
  - [ ] Theme documentation shows related theme guides in wiki

### Task 4: Create Bidirectional Link Graph (AC: Both)
- [ ] Build cross-reference graph structure
  - [ ] Map all source → target pairs bidirectionally
  - [ ] Store: source_path, target_path, relationship_type, confidence_score
  - [ ] Support queries: "what wiki pages link to module X?"
- [ ] Implement link resolution functions
  - [ ] `get_outgoing_links(page_path)` — wiki → code
  - [ ] `get_incoming_links(page_path)` — code ← wiki
  - [ ] `find_related_pages(page_path, threshold=0.7)` — semantic similarity
- [ ] Cache frequently accessed link relationships
  - [ ] Use .cache/wiki-search/ for bidirectional link cache
  - [ ] Invalidate cache on wiki or code documentation changes
  - [ ] Support manual cache refresh
- [ ] Performance target: Link resolution < 2 seconds (AC requirement)

### Task 5: Add UI/Display Elements for Bidirectional Links (AC: Both)
- [ ] Create link display templates
  - [ ] "Referenced Modules" section in wiki pages
  - [ ] "Related Wiki Pages" section in module/theme docs
  - [ ] Include link type badge (concept, implementation, example)
  - [ ] Show last update date for target document
- [ ] Implement accessibility features
  - [ ] ARIA labels: `aria-label="Link to module documentation for GDPR"`
  - [ ] Keyboard navigation: Tab through all links
  - [ ] Screen reader optimization: descriptive link text
  - [ ] High contrast mode support
- [ ] Add navigation breadcrumbs
  - [ ] Show current doc type and module/theme
  - [ ] Allow quick navigation back through link chain
  - [ ] Example: "Docs > Modules > GDPR > core-concepts.md"
- [ ] Test on representative pages
  - [ ] Root wiki pages (with module references)
  - [ ] Module-specific wiki pages
  - [ ] Theme-specific wiki pages

### Task 6: Implement Link Maintenance & Updates (AC: Both)
- [ ] Create link validation process
  - [ ] Validate all cross-references point to existing documents
  - [ ] Flag broken links (source exists but target deleted)
  - [ ] Support dry-run to preview link corrections
- [ ] Implement link update workflow
  - [ ] When wiki page moves/renames, update backlinks
  - [ ] When module structure changes, update forward links
  - [ ] Log all link changes to docs/wiki/log.md
- [ ] Add link health checks
  - [ ] Periodic scan for broken cross-references
  - [ ] Report missing or invalid links
  - [ ] Suggest updates based on content similarity

### Task 7: Testing (AC: Both)
- [ ] Unit tests: Link resolution functions
  - [ ] `get_outgoing_links()` returns correct wiki → code paths
  - [ ] `get_incoming_links()` returns correct code ← wiki paths
  - [ ] Link cache works and invalidates correctly
- [ ] Integration tests: Cross-reference discovery
  - [ ] Wiki page references module correctly
  - [ ] Module page shows related wiki pages
  - [ ] Bidirectional links work both directions
  - [ ] Semantic similarity link discovery
- [ ] Acceptance tests: AC #1 and #2
  - [ ] AC #1: Wiki page can reference and link to module docs
  - [ ] AC #2: Module docs show backlinks to wiki pages
  - [ ] Bidirectional navigation works end-to-end
- [ ] Performance tests: Link resolution < 2 seconds
  - [ ] Single link lookup
  - [ ] Batch link lookup (multiple pages)
  - [ ] Semantic similarity search with link discovery
- [ ] Accessibility tests
  - [ ] All links are keyboard navigable
  - [ ] Links have descriptive ARIA labels
  - [ ] Screen reader announces link type and target

### Task 8: Documentation & Integration (AC: General)
- [ ] Create cross-referencing guide in docs/wiki/how-to/
  - [ ] How to create wiki ↔ code documentation links
  - [ ] When to use explicit vs. semantic linking
  - [ ] Troubleshooting broken links
  - [ ] Performance considerations
- [ ] Update relevant wiki pages
  - [ ] docs/wiki/index.md — add reference to cross-referencing
  - [ ] docs/wiki/concepts/module-structure.md — document linking pattern
  - [ ] docs/wiki/how-to/module-wiki-documentation.md — add cross-ref guidance
- [ ] Update log and sprint status
  - [ ] Append entry to docs/wiki/log.md
  - [ ] Mark Story 2.2 as done in _bmad-output/sprint-status.yaml
  - [ ] Add completion notes to this story file

---

## Dev Notes

### Architecture Patterns to Follow

**Knowledge Graph Pattern [Source: architecture.md]:**
- Bidirectional links form a semantic graph
- Use content similarity + explicit references for link discovery
- Cache frequently accessed link relationships
- Performance-critical: optimize for common queries

**Document-as-Code Pattern [Source: architecture.md]:**
- All cross-references stored in Git alongside documentation
- Links updated via code changes (git commit)
- Wiki pages use standardized YAML frontmatter
- Cross-link format: relative paths or explicit [[WikiLink]] style

**Continuous Integration Pattern [Source: architecture.md]:**
- Link validation in pre-commit hooks (future enhancement)
- Search indexes updated when links change
- Cross-reference graph rebuilt on documentation changes

### Project Structure Notes

**Key Integration Points:**
- `docs/wiki/` — Root wiki with module/theme references
- `laravel/Modules/{Module}/docs/wiki/` — Module-specific docs
- `laravel/Themes/{Theme}/docs/wiki/` — Theme-specific docs
- `.cache/wiki-search/` — Link cache location (from Story 2.1)

**Existing Patterns:**
- Wiki YAML frontmatter: name, description, type, related
- Cross-links use relative paths: `../../Module/docs/wiki/core-concepts.md`
- Explicit wiki links: `[[Page Name]]` or `[Text](./relative-path.md)`
- Activity logged: docs/wiki/log.md appended with [OPERATION] timestamp

**Files to Update:**
- `docs/wiki/index.md` — Add cross-referencing guide link
- `docs/wiki/log.md` — Log cross-reference implementation
- `_bmad-output/sprint-status.yaml` — Mark 2.2 as done
- Multiple wiki pages — Add bidirectional link sections

### Dependencies & Constraints

**Story Dependencies:**
- **Depends on:** Story 2.1 (QMD Search Integration) — provides semantic link discovery
- **Enables:** Story 2.3 (Automated Wiki Generation) — uses cross-ref graph
- **Impacts:** Epic 3 and Epic 4 stories — rely on bidirectional linking

**Technical Constraints:**
- Must use QMD/context-mode for semantic link discovery (not custom)
- Must respect existing wiki directory structure
- Must not modify core application code
- Must complete link resolution within 2-second SLA [Requirement: NFR1]
- Must be accessible (WCAG 2.1 AA) [Requirement: NFR3]

**Legacy Compatibility:**
- Existing wiki pages may not have frontmatter references
- Handle both explicit [[WikiLink]] style and semantic discovery
- Support graceful degradation: show semantic links if explicit missing

### Testing Standards

From CLAUDE.md and project patterns:
- Use QMD and context-mode tools for testing (not custom test data)
- Integration tests for link discovery and resolution flows
- Performance benchmarking with real documentation
- Manual smoke tests for UI/UX and accessibility

---

## Previous Story Intelligence

**Story 2.1: QMD Search Integration**
- Implemented QMD query interface for wiki
- Created semantic similarity search
- Established cross-reference identification via backlinks
- Performance optimized to < 2 seconds
- Accessible output for screen readers

**Key Learnings for This Story:**
1. Semantic similarity is reliable for link discovery (< 2 second resolution)
2. Context-mode FTS5 backend is the standard search tool
3. YAML frontmatter is the pattern for page metadata
4. Cache is critical for performance (use .cache/wiki-search/)
5. Accessibility testing must include keyboard navigation + ARIA labels

**Files Created/Modified in Story 2.1:**
- `docs/scripts/wiki/wiki-search` — CLI search tool
- `docs/scripts/wiki/wiki-relations` — Relationship analysis helper
- `docs/scripts/wiki/cache-manager.sh` — Cache management
- `docs/wiki/how-to/wiki-search-guide.md` — User guide
- `docs/wiki/how-to/semantic-search-and-related-pages.md` — Advanced guide
- `docs/wiki/how-to/qmd-indexing-manifest.md` — QMD status reference

**Patterns Established:**
- Wiki search via CLI: `./docs/scripts/wiki/wiki-search "query"`
- Related pages discovery: `./docs/scripts/wiki/wiki-search "query" --related`
- Performance benchmarking: `./docs/scripts/wiki/benchmark-search.sh`
- Link caching: `./docs/scripts/wiki/cache-manager.sh`

---

## Implementation Roadmap

### Phase 1: Analysis & Design (Days 1-2)
- [ ] Audit existing wiki ↔ code cross-references
- [ ] Design link graph structure
- [ ] Create detailed cross-reference inventory

### Phase 2: Core Implementation (Days 3-5)
- [ ] Implement wiki → code reference resolution
- [ ] Implement code ← wiki backlink resolution
- [ ] Create bidirectional link graph

### Phase 3: UI & UX (Days 6-7)
- [ ] Add link display templates
- [ ] Implement accessibility features
- [ ] Add breadcrumb navigation

### Phase 4: Testing & Validation (Days 8-9)
- [ ] Unit + integration tests
- [ ] Acceptance testing against AC
- [ ] Performance & accessibility testing

### Phase 5: Documentation & Finalization (Day 10)
- [ ] Create cross-referencing guide
- [ ] Update wiki and sprint status
- [ ] Completion notes and file list

---

## Acceptance Criteria Map

| AC | Implementation Task(s) |
|----|------------------------|
| AC #1: Wiki → code navigation | Tasks 2, 5, 6, 7 |
| AC #2: Code → wiki backlinks | Tasks 3, 4, 5, 7 |
| Both: Performance < 2 seconds | Tasks 4, 7 |
| Both: Keyboard accessible | Tasks 5, 7 |

---

## Definition of Done (Beyond AC)

- [ ] Bidirectional links resolve correctly (test with 10+ pages)
- [ ] Performance tested and documented (< 2 seconds)
- [ ] Accessibility verified (keyboard + screen reader)
- [ ] All link types tested (explicit + semantic)
- [ ] Link cache working and invalidating correctly
- [ ] Broken link detection implemented
- [ ] Cross-referencing guide in docs/wiki/how-to/
- [ ] docs/wiki/log.md appended with changes
- [ ] Sprint status updated (2.2 marked done)
- [ ] Story marked done in implementation-artifacts

---

## Dev Agent Record

### Agent Model Used
Claude Haiku 4.5 (Continuation from previous session)

### Story Created
2026-04-29 — Comprehensive bidirectional cross-referencing context prepared

### Completion Notes (To Be Updated by Dev)
_[Developer will update this section after implementation]_

### File List (To Be Updated by Dev)
_[Developer will update this section with all files created/modified]_

---

## Questions for Clarification (Optional)

1. **Link Discovery Strategy:** Should semantic linking use pure similarity (>0.7 confidence) or include keyword-based matching as fallback?
2. **Link Display:** Should bidirectional links be displayed inline (during page load) or lazy-loaded on-demand for performance?
3. **Link Types:** Beyond concept/implementation/example, are there other relationship types needed?
4. **Wiki Link Syntax:** Use [[WikiLink]] style or `[Text](relative-path.md)` or both?

---

**Ready for Development Agent Execution**

This story builds on the QMD search foundation and extends it with bidirectional cross-referencing. The developer has comprehensive context, proven patterns from Story 2.1, and clear acceptance criteria. 🚀
