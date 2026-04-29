---
title: "Cross-Reference Inventory"
story: "2.2-bidirectional-cross-referencing"
date: "2026-04-29"
task: "Task 1: Analyze Cross-Reference Patterns"
---

# Cross-Reference Inventory — Story 2.2

**Purpose:** Document existing wiki ↔ code documentation cross-references to inform bidirectional linking implementation.

**Date Analyzed:** 2026-04-29  
**Status:** Task 1 Analysis Complete

---

## Summary

| Metric | Count |
|--------|-------|
| Modules with wiki directories | 30+ (active) |
| Themes with wiki directories | 2 (Zero, One) |
| Module/Theme refs in root wiki | 15 (explicit) |
| Root wiki refs in module docs | 10 files |
| Root wiki refs in theme docs | 2 files |
| Existing bidirectional links | 0 (to be created) |

---

## Cross-Reference Patterns Found

### Pattern A: Root Wiki → Module Documentation

**Type:** Concept linking  
**Direction:** One-way (currently)  
**Frequency:** 15+ explicit references

**Examples:**
- `docs/wiki/concepts/module-structure.md` → Module wiki pages
- `docs/wiki/how-to/module-wiki-documentation.md` → Module wiki layout references
- `docs/wiki/how-to/theme-wiki-documentation.md` → Theme wiki layout references
- Root wiki guides reference `laravel/Modules/{ModuleName}/docs/wiki/`

**Content:**
- References use explicit module names: `Modules/User`, `Modules/Gdpr`, `Modules/Activity`, `Modules/Notify`, `Modules/Performance`, `Modules/Xot`, `Modules/UI`, etc.
- References appear in code blocks (examples), prose descriptions, and path documentation
- Some references are template placeholders: `Modules/MyModule`, `Modules/YourModule`, `Themes/MyTheme`

**Relationship Types Identified:**
- `concept` — Root wiki explains module structure; module wiki implements it
- `implementation` — Root wiki how-to guides; modules follow the patterns
- `example` — Root wiki shows template; modules instantiate it

---

### Pattern B: Module Documentation → Root Wiki

**Type:** Cross-reference backlink  
**Direction:** One-way (currently)  
**Frequency:** 10 files actively reference root

**Modules with Root References:**
- `Lang` (bmad-method.md, concepts, schema.md, templates)
- `User` (overviews/user-module.md, context-compression.md)
- Others mentioned in documentation

**Content:**
- Module wikis use relative paths: `../../../docs/wiki/`
- References appear in README.md, AGENTS.md, method documentation
- Pattern: Module-specific wiki links back to root architecture and tooling docs

**Relationship Types:**
- `architecture` — Module doc → Root BMAD/architecture concepts
- `tooling` — Module doc → Root ai-tooling docs
- `methodology` — Module doc → Root workflow methodology

---

### Pattern C: Theme Documentation → Root Wiki

**Type:** Cross-reference backlink  
**Direction:** One-way (currently)  
**Frequency:** 2 files

**Themes with Root References:**
- `Theme/Zero/docs/wiki/concepts/theme-zero-operating-focus.md`
- `Theme/One/docs/wiki/concepts/theme-one-operating-focus.md`

**Content:**
- Similar to module pattern but theme-specific
- Link to root wiki concepts and architecture guidelines

**Relationship Type:**
- `architecture` — Theme doc → Root architecture guardrails

---

## Relationship Type Classification

| Type | Direction | Example | Priority |
|------|-----------|---------|----------|
| **concept** | Root → Module | Architecture concept applied in module | High |
| **implementation** | Root → Module | How-to guide followed by modules | High |
| **example** | Root → Module | Template example in modules | Medium |
| **architecture** | Module/Theme → Root | Module doc references root architecture | High |
| **tooling** | Module/Theme → Root | Module references BMAD/AI docs | Medium |
| **methodology** | Module/Theme → Root | Module references process docs | Low |

---

## Active Modules with Wiki Directories

**Total:** 30+ modules

**Key Modules (actively maintained):**
- User
- Lang
- Gdpr
- Activity
- Notify
- Xot
- Media
- Geo
- Cms
- Blog
- Job
- UI
- Performance
- Tenant
- Rating
- Comment

**Secondary Modules (with wiki but less active):**
- Seo
- MobilitaVolontaria
- Sindacati
- Fixcity
- AI
- Setting
- Sigma
- IndennitaCondizioniLavoro
- Mensa
- Incentivi
- Ptv
- CertFisc
- Prenotazioni
- DbForge
- Europa
- Legge109
- ContoAnnuale
- Badge
- Inail
- Questionari
- Legge104
- Pdnd
- Progressioni
- PresenzeAssenze
- IndennitaResponsabilita

---

## Active Themes with Wiki Directories

**Total:** 2 themes

- **Theme/Zero** — Operating focus and architecture docs
- **Theme/One** — Operating focus and architecture docs

---

## Priority Links for Implementation

### Priority 1: High Impact (Implement First)

**Root Wiki → Module/Theme Linking**
1. `docs/wiki/concepts/module-structure.md` → All module wikis
2. `docs/wiki/concepts/architecture-guardrails.md` → All module/theme wikis
3. `docs/wiki/how-to/module-wiki-documentation.md` → Module wiki index pages
4. `docs/wiki/how-to/theme-wiki-documentation.md` → Theme wiki index pages

**Module/Theme → Root Wiki Backlinks**
1. All module wikis should link back to root architecture concepts
2. Theme wikis should reference architecture guardrails
3. Module index pages should show "Related Root Wiki Pages"

### Priority 2: Medium Impact (Implement Second)

**BMAD/AI Tooling References**
1. Module documentation → `docs/wiki/concepts/bmad-operating-model.md`
2. Module documentation → `docs/wiki/concepts/ai-tooling-workflow.md`
3. Module documentation → Context-mode integration docs

**QMD Search Integration**
1. Module wikis → Root QMD search guide
2. Module wikis → Root QMD indexing manifest

### Priority 3: Low Impact (Nice to Have)

**Process Documentation**
1. Module documentation → Continuous improvement methodology
2. Module documentation → Learning workflow templates
3. Theme documentation → Theme customization patterns

---

## Current Gap Analysis

### Missing Bidirectional Links

**Wiki → Code (Expected but Not Found)**
- No explicit links FROM wiki pages TO module code/source files
- No links TO specific class documentation
- No links TO model/service definitions

**Code Comments → Wiki (Expected but Not Found)**
- No automated wiki generation from PHP DocBlocks
- No links from code comments back to related wiki pages
- *(This is Story 2.3 scope: Automated Wiki Generation)*

### Unlinked References

**In Root Wiki:**
- 15+ explicit module/theme references exist
- Currently static text (no clickable links)
- No backlink display when viewing module wikis

**In Module Wikis:**
- 10+ files reference root wiki
- Links use relative paths (brittle, not validated)
- No "Related Root Wiki" section displayed

**In Theme Wikis:**
- 2 files with root references
- Similar issues to modules

---

## Recommendations for Implementation

### Quick Wins (Task 2-3)
1. Add clickable links to explicit module references in root wiki
2. Create "Referenced Root Pages" section in module/theme wiki pages
3. Use QMD semantic similarity (from Story 2.1) for automatic backlink discovery

### Core Implementation (Task 4-6)
1. Build bidirectional link graph with caching
2. Implement link maintenance (validation, updates on moves)
3. Add ARIA labels and keyboard navigation for accessibility

### Testing Focus
1. Verify all 15+ explicit root→module links work
2. Test semantic backlink discovery (threshold: 0.7 confidence)
3. Validate cache invalidation on wiki updates
4. Performance benchmark: link resolution < 2 seconds

---

## Technical Specifications

### Link Format

**Wiki frontmatter field** (to be added by Task 2):
```yaml
references:
  - type: concept
    module: Gdpr
    path: laravel/Modules/Gdpr/docs/wiki
  - type: implementation
    module: User
    path: laravel/Modules/User/docs/wiki
```

### Semantic Discovery Thresholds

**From Story 2.1 patterns:**
- Keyword match confidence: 0.9+ (explicit match required)
- Semantic similarity threshold: 0.7 (default for related pages)
- Top results limit: 3-5 pages per direction

### Relationship Type Coverage

**Must support:**
1. **concept** — Architectural/design concepts
2. **implementation** — How-to guides and patterns
3. **example** — Template examples and samples
4. **architecture** — Guardrails and constraints
5. **tooling** — Tool integration and workflow

---

## Files for Update

After Tasks 2-7 complete, update:
- `docs/wiki/log.md` — Log implementation steps
- `docs/wiki/index.md` — Add cross-referencing guide link
- `_bmad-output/sprint-status.yaml` — Mark Story 2.2 as in-progress → done
- Multiple wiki pages — Add bidirectional link sections

---

## Task 1 Completion Checklist

- [x] Identified all existing wiki → module/theme references (15+ explicit)
- [x] Mapped relationship types (concept, implementation, example, architecture, tooling, methodology)
- [x] Created cross-reference inventory (this document)
- [x] Identified priority links (3 priority levels)
- [x] Analyzed gap: no automated wiki generation yet (Task 2.3 scope)
- [x] Documented technical specifications for bidirectional linking

**Status:** ✅ Task 1 Complete — Ready to proceed to Task 2

---

**Next Step:** Task 2 - Implement Wiki → Code Reference Resolution
- Parse wiki frontmatter for module/theme references
- Generate clickable links to associated documentation
- Test on existing wiki pages with module references
