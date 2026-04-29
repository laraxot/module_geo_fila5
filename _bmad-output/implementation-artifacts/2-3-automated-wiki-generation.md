# Story 2.3: Automated Wiki Generation

**Status:** ready-for-dev  
**Epic:** 2 - Wiki Integration and Search  
**Priority:** High (completes Epic 2)  
**Created:** 2026-04-29

---

## Story

As a **developer**,  
I want **automated wiki generation from source code comments**,  
so that **documentation stays up-to-date with minimal manual effort**.

---

## Acceptance Criteria

1. **Given** I add comments to source code files  
   **When** I commit changes to the repository  
   **Then** the system generates wiki pages from the documentation comments  
   **And** the wiki includes API explanations and usage examples  
   **And** the generated wiki pages are linked to the source code

---

## Developer Context

### Epic Overview
**Epic 2: Wiki Integration and Search**

Goal: Enhance the wiki system with QMD search integration to enable efficient searching and cross-referencing of documentation.

This story completes Epic 2 by automating documentation generation from source code comments, using the search and cross-referencing infrastructure from Stories 2.1 and 2.2.

### Dependencies & Foundation

**Story 2.1: QMD Search Integration**
- Provides QMD search interface for wiki queries
- Enables semantic similarity search
- Establishes performance baseline (< 2 seconds)

**Story 2.2: Bidirectional Cross-Referencing**
- Provides bidirectional link infrastructure
- Enables wiki ↔ code documentation navigation
- Establishes link graph and resolution patterns

**This Story (2.3):**
- Automates wiki generation from code comments
- Leverages bidirectional links to connect generated docs
- Uses QMD search to maintain index of generated pages

### Current Project Structure

**Documentation Sources:**
```
laravel/Modules/{Module}/
├── app/
│   ├── Models/            # Model documentation via comments
│   ├── Services/          # Service documentation via comments
│   ├── Http/Requests/     # Request/validation documentation
│   └── ...
├── database/migrations/   # Migration documentation via comments
├── routes/                # Route/API documentation via comments
└── docs/wiki/             # Generated wiki output

laravel/Themes/{Theme}/
├── Components/            # Component documentation via comments
├── Views/                 # View template documentation
├── Config/                # Theme configuration documentation
└── docs/wiki/             # Generated wiki output
```

**Wiki Structure (from Stories 2.1-2.2):**
- QMD search operational via `./docs/scripts/wiki/wiki-search`
- Bidirectional links established in module/theme wikis
- Cache system in place for performance optimization
- YAML frontmatter pattern for page metadata

### Documentation Comment Patterns

**PHP DocBlock Pattern (Laravel):**
```php
/**
 * User model for authentication and profile management
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * 
 * @see UserPolicy
 * @see UserController
 */
class User extends Model
{
    /**
     * Get the user's posts relationship
     * 
     * Returns all posts authored by this user,
     * ordered by creation date descending.
     * 
     * @return HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
```

**Markdown Docblock Pattern (optional):**
```php
/**
 * # User Model
 * 
 * Handles user authentication, profiles, and relationships.
 * 
 * ## Database Schema
 * - id: Primary key
 * - name: User display name
 * - email: User email address
 * 
 * ## Relationships
 * - posts: HasMany relationship to Post model
 */
```

**Migration Documentation:**
```php
/**
 * Create users table for authentication
 * 
 * Columns:
 * - id: Auto-increment primary key
 * - name: User full name
 * - email: Unique email for login
 * - password: Bcrypt hashed password
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // ...
        });
    }
};
```

### Key Technical Requirements

**From PRD [Source: _bmad-output/planning-artifacts/prd.md]:**
- NFR1: Wiki generation must not block development workflows
- NFR2: Generated documentation easily updatable by developers
- FR3: Automated wiki generation from source code comments
- FR1: Standardized documentation templates

**From Architecture [Source: _bmad-output/planning-artifacts/architecture.md]:**
- Document-as-Code: Documentation stored alongside code
- CI/CD integration: Pre-commit hooks and build pipeline
- Automated generation: From code comments via tooling
- Knowledge graph: Generated docs linked to related resources

**From Story 2.1 & 2.2 Learnings:**
- Performance critical: < 2 seconds for search/navigation
- Semantic linking: Use QMD for cross-reference discovery
- Accessibility: WCAG 2.1 AA compliance required
- Caching: Cache generated wiki for performance

---

## Tasks / Subtasks

### Task 1: Audit Code Comment Coverage (AC: #1)
- [ ] Scan all Laravel modules for existing documentation comments
  - [ ] Check Models, Services, Controllers, Requests
  - [ ] Identify patterns (PHPDoc, Markdown, custom)
  - [ ] Document coverage % per module
- [ ] Scan themes for component and view documentation
  - [ ] Check Components, Views, Layouts
  - [ ] Identify existing documentation patterns
  - [ ] Note missing or sparse documentation areas
- [ ] Create comment inventory
  - [ ] List all documented entities (classes, methods, functions)
  - [ ] Flag undocumented critical components
  - [ ] Identify documentation gaps by priority
- [ ] Establish documentation standards
  - [ ] Define minimum comment requirements
  - [ ] Create templates for different entity types
  - [ ] Document @see, @property, @return conventions

### Task 2: Build Comment Parser & Extractor (AC: #1)
- [ ] Create PHP DocBlock parser
  - [ ] Extract class/function documentation
  - [ ] Parse @param, @return, @property, @see annotations
  - [ ] Handle multi-line descriptions with examples
  - [ ] Support both PHPDoc and Markdown formats
- [ ] Create migration comment parser
  - [ ] Extract table and column documentation
  - [ ] Parse relationships from comments
  - [ ] Identify index and constraint information
- [ ] Create route documentation parser
  - [ ] Extract route descriptions
  - [ ] Parse request/response format from comments
  - [ ] Identify authentication and authorization requirements
- [ ] Support component/view documentation
  - [ ] Parse component prop documentation
  - [ ] Extract layout and slot information
  - [ ] Identify style/theme variables

### Task 3: Build Wiki Generation Engine (AC: #1)
- [ ] Create wiki page generation from parsed comments
  - [ ] Generate markdown pages from extracted documentation
  - [ ] Apply standardized wiki template format
  - [ ] Add YAML frontmatter (name, type, related)
- [ ] Organize generated pages by type
  - [ ] Model documentation → `docs/wiki/models/`
  - [ ] Service documentation → `docs/wiki/services/`
  - [ ] Component documentation → `docs/wiki/components/`
  - [ ] API/Route documentation → `docs/wiki/api/`
- [ ] Generate index pages per type
  - [ ] `docs/wiki/models/index.md` — all models
  - [ ] `docs/wiki/services/index.md` — all services
  - [ ] Link to individual entity pages
- [ ] Support code snippets in generated docs
  - [ ] Include usage examples from comments
  - [ ] Link to source file on GitHub/GitLab
  - [ ] Show method signatures and return types

### Task 4: Implement Bidirectional Linking (AC: #1)
- [ ] Link generated docs to source code
  - [ ] Add source file path to generated wiki frontmatter
  - [ ] Example: `source: laravel/Modules/User/app/Models/User.php:25`
  - [ ] Support direct link to source in generated pages
- [ ] Link generated docs to related wiki pages
  - [ ] Use semantic similarity from Story 2.1 (QMD search)
  - [ ] Add "Related Pages" section to generated docs
  - [ ] Link to manually-written guides that reference this entity
- [ ] Create backlinks from manual pages
  - [ ] When manual page mentions a model/service, link to generated doc
  - [ ] Use keyword matching + semantic similarity
  - [ ] Update backlinks when generated docs change
- [ ] Support @see references
  - [ ] Parse @see annotations from code comments
  - [ ] Resolve to related wiki pages or source files
  - [ ] Display as "See Also" section in generated docs

### Task 5: Implement Generation Trigger (AC: #1)
- [ ] Create pre-commit hook for documentation generation
  - [ ] Detect code file changes that may affect docs
  - [ ] Run parser on modified files only (performance)
  - [ ] Generate/update wiki pages
  - [ ] Stage generated wiki changes in git
- [ ] Support manual trigger via CLI
  - [ ] Command: `php artisan wiki:generate` or similar
  - [ ] Support `--module ModuleName` to generate for single module
  - [ ] Support `--full` flag to regenerate all documentation
  - [ ] Show progress and summary of generated pages
- [ ] Support CI/CD pipeline integration
  - [ ] Post-commit hook: rebuild QMD search indexes
  - [ ] GitHub Actions / GitLab CI: Run generation on merge
  - [ ] Validate generated documentation before merge
- [ ] Handle conflicts gracefully
  - [ ] Detect when manual wiki page exists with same name
  - [ ] Offer merge option (preserve manual additions)
  - [ ] Log conflicts for manual review

### Task 6: Implement Cache & Performance Optimization (AC: #1)
- [ ] Cache parsed documentation
  - [ ] Store AST (abstract syntax tree) of parsed comments
  - [ ] Invalidate cache when source file changes
  - [ ] Reuse cache for non-changed files
- [ ] Optimize wiki generation
  - [ ] Only regenerate changed pages (incremental)
  - [ ] Parallel processing for multiple modules
  - [ ] Benchmark generation time (target: < 5 seconds full run)
- [ ] Update search indexes efficiently
  - [ ] Rebuild only affected QMD collections
  - [ ] Use cache for frequently accessed documentation
  - [ ] Implement cache warming for common queries

### Task 7: Add Documentation Quality Checks (AC: #1)
- [ ] Implement comment quality lint rules
  - [ ] Require documentation for public methods
  - [ ] Check for @param/@return on all methods
  - [ ] Validate example code syntax
  - [ ] Flag missing descriptions or vague documentation
- [ ] Create pre-commit validation
  - [ ] Check comment quality before allowing commit
  - [ ] Provide suggestions for improvement
  - [ ] Support --no-verify flag for overrides
- [ ] Generate documentation coverage report
  - [ ] Show % of documented entities per module
  - [ ] Flag undocumented critical components
  - [ ] Track documentation quality metrics over time

### Task 8: Testing (AC: #1)
- [ ] Unit tests: Comment parser
  - [ ] Test PHPDoc parsing for various formats
  - [ ] Test annotation extraction (@param, @return, @see)
  - [ ] Test markdown docblock parsing
- [ ] Unit tests: Wiki generation
  - [ ] Test markdown page generation from comments
  - [ ] Test YAML frontmatter creation
  - [ ] Test code snippet extraction
- [ ] Integration tests: Generation pipeline
  - [ ] Test pre-commit hook triggers correctly
  - [ ] Test CLI command generates expected pages
  - [ ] Test bidirectional link creation
  - [ ] Test QMD index updates after generation
- [ ] Integration tests: Source linking
  - [ ] Test generated pages link back to source
  - [ ] Test @see reference resolution
  - [ ] Test bidirectional links work correctly
- [ ] Performance tests
  - [ ] Measure generation time for single module
  - [ ] Measure generation time for full repository
  - [ ] Verify < 5 seconds full regeneration
  - [ ] Test incremental generation (< 1 second)
- [ ] Acceptance tests: AC #1
  - [ ] Add comments to sample code
  - [ ] Commit changes
  - [ ] Verify wiki pages generated
  - [ ] Verify pages include API explanations and examples
  - [ ] Verify pages are linked to source code

### Task 9: Documentation & Integration (AC: General)
- [ ] Create wiki generation guide in docs/wiki/how-to/
  - [ ] How to write documentation comments
  - [ ] Comment format and structure requirements
  - [ ] Supported documentation patterns
  - [ ] Examples for different entity types
- [ ] Update module/theme wiki templates
  - [ ] Add section for auto-generated documentation
  - [ ] Document when/how generation occurs
  - [ ] Note how to update generated docs (via source comments)
- [ ] Create troubleshooting guide
  - [ ] Common parsing issues
  - [ ] How to fix documentation comments
  - [ ] Performance tuning
- [ ] Update docs/wiki/log.md and sprint status
  - [ ] Log Story 2.3 completion
  - [ ] Update sprint-status.yaml (2.3 marked done)
  - [ ] Mark Epic 2 as done

---

## Dev Notes

### Architecture Patterns to Follow

**Document-as-Code Pattern [Source: architecture.md]:**
- Documentation lives in code comments alongside implementation
- Wiki is generated from authoritative source (code comments)
- Changes to code automatically update documentation
- Version control tracks both code and generated docs

**CI/CD Integration Pattern [Source: architecture.md]:**
- Pre-commit hooks validate and generate documentation
- Build pipeline rebuilds search indexes
- Generated pages are staged alongside code changes
- Automated checks ensure documentation quality

**Knowledge Graph Pattern [Source: architecture.md]:**
- Generated docs are nodes in the semantic graph
- Bidirectional links created automatically
- Cross-references enable discovery of related resources
- QMD search indexes generated docs for discoverability

### Project Structure Notes

**Generation Targets:**
- Models → `laravel/Modules/{Module}/docs/wiki/models/`
- Services → `laravel/Modules/{Module}/docs/wiki/services/`
- Controllers → `laravel/Modules/{Module}/docs/wiki/controllers/`
- Components → `laravel/Themes/{Theme}/docs/wiki/components/`
- Routes → `laravel/Modules/{Module}/docs/wiki/api/`

**Key Integration Points:**
- Pre-commit hook location: `.git/hooks/pre-commit`
- CLI command location: `app/Console/Commands/GenerateWiki.php` (Laravel)
- Cache location: `.cache/wiki-generation/` (parallel with Story 2.1 cache)
- Index update: Use `qmd index` command from Story 2.1

**Files to Update:**
- Create: `_bmad-output/doc-generation-spec.md` — Full generation specification
- Update: `docs/wiki/log.md` — Log generation implementation
- Update: `_bmad-output/sprint-status.yaml` — Mark 2.3 as done
- Create: `docs/wiki/how-to/generating-wiki-from-comments.md` — User guide

### Dependencies & Constraints

**Story Dependencies:**
- **Depends on:** Story 2.1 (QMD search) and Story 2.2 (bidirectional links)
- **Enables:** Epic 3 stories (advanced search) and Epic 4 (automation workflows)
- **Completes:** Epic 2 (Wiki Integration and Search)

**Technical Constraints:**
- Must not block development workflow (generation < 5 seconds)
- Must support PHP DocBlock comments (Laravel standard)
- Must generate markdown compatible with QMD search
- Must maintain backward compatibility with manual wiki pages
- Must handle conflicts gracefully (manual vs. auto-generated)

**Legacy Considerations:**
- Some modules may have sparse or no documentation comments
- Support gradual adoption (not all modules at once)
- Allow manual wiki pages to coexist with generated pages
- Preserve manually-written documentation when regenerating

### Testing Standards

From CLAUDE.md and project patterns:
- Unit tests for parser components
- Integration tests for full generation pipeline
- Performance benchmarks (< 5 seconds target)
- Manual validation of generated markdown quality
- Accessibility testing for generated pages

---

## Previous Story Intelligence

**Story 2.1: QMD Search Integration**
- QMD search interface is operational
- Semantic similarity search established
- Performance baseline: < 2 seconds
- Accessibility verified (WCAG 2.1 AA)

**Story 2.2: Bidirectional Cross-Referencing**
- Wiki ↔ code documentation linking established
- Backlink discovery via semantic similarity
- Link graph structure implemented
- Link cache in place for performance

**Key Learnings for This Story:**
1. Search performance is critical — keep generation fast (< 5 seconds)
2. Bidirectional links are essential — generated docs must link back
3. Semantic linking enables discovery — leverage QMD for related pages
4. Caching matters — parallel with existing cache system
5. Accessibility is mandatory — verify generated markdown is accessible

**Patterns Established in Prior Stories:**
- Wiki YAML frontmatter: name, description, type, related
- Cross-links: relative paths + QMD semantic discovery
- Performance metrics: documented and tracked
- Accessibility: ARIA labels and keyboard navigation
- Activity logging: docs/wiki/log.md appended after changes

---

## Implementation Roadmap

### Phase 1: Analysis & Design (Days 1-2)
- [ ] Audit existing code comment coverage
- [ ] Document comment patterns and standards
- [ ] Design parser architecture

### Phase 2: Parser & Extraction (Days 3-4)
- [ ] Implement PHP DocBlock parser
- [ ] Implement migration/route/component parsers
- [ ] Test parser with real code

### Phase 3: Generation Engine (Days 5-6)
- [ ] Implement wiki page generation
- [ ] Implement bidirectional linking
- [ ] Test generation with sample modules

### Phase 4: Automation & Triggers (Days 7-8)
- [ ] Implement pre-commit hook
- [ ] Implement CLI command
- [ ] Implement CI/CD integration

### Phase 5: Testing & Optimization (Days 9-10)
- [ ] Unit + integration tests
- [ ] Performance benchmarking
- [ ] Quality checks and linting

### Phase 6: Documentation & Finalization (Day 11)
- [ ] Create generation guide
- [ ] Update wiki and sprint status
- [ ] Mark Epic 2 as complete

---

## Acceptance Criteria Map

| AC | Implementation Task(s) |
|----|------------------------|
| AC #1: Wiki generation from comments | Tasks 1-5, 9 |
| AC #1: API explanations + examples | Tasks 2-3, 9 |
| AC #1: Links to source code | Tasks 4, 8, 9 |

---

## Definition of Done (Beyond AC)

- [ ] All public methods have documentation comments
- [ ] Generated wiki pages cover all modules and themes
- [ ] Generation completes in < 5 seconds (full run)
- [ ] Incremental generation in < 1 second
- [ ] All generated pages include YAML frontmatter
- [ ] Bidirectional links created and tested
- [ ] QMD search indexes include generated pages
- [ ] Pre-commit hook working and tested
- [ ] CLI command working and documented
- [ ] Documentation quality metrics tracked
- [ ] All tests passing (unit, integration, performance)
- [ ] Accessibility verified (generated pages WCAG 2.1 AA)
- [ ] Generation guide in docs/wiki/how-to/
- [ ] docs/wiki/log.md appended with changes
- [ ] Sprint status updated (2.3 marked done, Epic 2 marked done)
- [ ] Story marked done in implementation-artifacts

---

## Dev Agent Record

### Agent Model Used
Claude Haiku 4.5 (Continuation from previous session)

### Story Created
2026-04-29 — Comprehensive automated wiki generation context prepared

### Completion Notes (To Be Updated by Dev)
_[Developer will update this section after implementation]_

### File List (To Be Updated by Dev)
_[Developer will update this section with all files created/modified]_

---

## Questions for Clarification (Optional)

1. **Comment Format:** Should we enforce PHPDoc only, or support Markdown docblocks as well?
2. **Coverage Requirement:** Should all public methods require documentation comments, or just classes/primary methods?
3. **Generation Scope:** Should generation include all code or specific directories (e.g., app/ only)?
4. **Conflict Resolution:** For conflicting manual/auto-generated pages, should we auto-merge, preserve manual, or ask?
5. **Performance Threshold:** Is < 5 seconds for full generation acceptable, or should we target faster?

---

**Ready for Development Agent Execution**

This story completes Epic 2 by automating documentation generation from source code. It builds on the search and linking infrastructure from Stories 2.1 and 2.2, enabling teams to keep documentation synchronized with code automatically. 🚀
