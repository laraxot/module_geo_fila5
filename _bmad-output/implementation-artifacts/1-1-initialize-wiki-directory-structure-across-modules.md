# Story 1.1: Initialize Wiki Directory Structure Across Modules

**Story ID**: 1.1  
**Epic**: 1 — Second Brain Foundation & Structure  
**Status**: ready-for-dev  
**Created**: 2026-04-29  
**Last Updated**: 2026-04-29  

---

## Story Requirements

### User Story

**As a** developer  
**I want** a consistent wiki structure in every module and theme  
**So that** knowledge is organized predictably and discoverable

### Acceptance Criteria

- [x] Each module in `laravel/Modules/*/docs/wiki/` exists with `index.md`
- [x] Each theme in `laravel/Themes/*/docs/wiki/` exists with `index.md`
- [x] Root project wiki in `docs/wiki/` established
- [x] Bash scripts wiki in `bashscripts/docs/wiki/` established
- [x] All index.md files follow consistent frontmatter format
- [x] Directory structure documented in `docs/wiki/index.md`

---

## Developer Context Section

### Architecture Compliance

**Framework**: Laravel 12.x Modular Monolith (via nwidart/laravel-modules + Laraxot)

**Module Structure**:
```
laravel/Modules/
├── Xot/                    # Core module (required)
├── Activity/               # Example module
├── Gdpr/                   # Example module
├── ... (42+ modules total)
```

**Theme Structure**:
```
laravel/Themes/
├── Zero/                   # Base theme
├── One/                    # Extended theme
```

**Project Documentation Hierarchy**:
```
docs/
├── wiki/                   # ← Root project wiki (NEW)
│   ├── index.md
│   ├── log.md             # (Already exists)
│   ├── patterns.md
│   └── ... concept pages
└── (existing raw docs)

laravel/Modules/{ModuleName}/
├── docs/
│   ├── raw/               # (Existing raw docs)
│   └── wiki/              # ← NEW: Module wiki
│       ├── index.md
│       └── ... concept pages

laravel/Themes/{ThemeName}/
├── docs/
│   ├── raw/               # (Existing raw docs)
│   └── wiki/              # ← NEW: Theme wiki
│       ├── index.md
│       └── ... concept pages

bashscripts/
├── docs/
│   └── wiki/              # ← NEW: Scripts wiki
│       ├── index.md
│       └── ... concept pages
```

### Key Constraints

1. **Preserve existing docs** - Don't delete `docs/raw/`, `docs/old/`, etc.
2. **Markdown only** - Use `.md` format exclusively in wiki directories
3. **No code duplication** - Wiki should link to, not copy, source code examples
4. **Encoding**: UTF-8, LF line endings
5. **File naming**: lowercase, hyphenated (e.g., `core-patterns.md`, not `CorePatterns.md`)

---

## Technical Requirements

### Directory Structure Template

Each `wiki/` directory should have this structure:

```
docs/wiki/
├── index.md                    # Wiki index (lists all pages)
├── log.md                      # (For root: changelog of wiki updates)
├── patterns.md                 # (Optional: patterns specific to this module/theme)
└── (other concept pages added later)
```

### Frontmatter Format (YAML Metadata)

All wiki pages MUST include frontmatter at the top:

```yaml
---
name: Page Title
description: One-line description of what this page covers
type: entity | concept | architecture | pattern | guide
related:
  - ../other-module/docs/wiki/page.md
  - ./related-concept.md
---

# Page Title

Content starts here...
```

**Frontmatter Fields**:
- `name`: Human-readable page title (max 60 chars)
- `description`: SEO-friendly summary for search/discovery (max 150 chars)
- `type`: One of: `entity`, `concept`, `architecture`, `pattern`, `guide`
- `related`: Array of relative paths to related pages (optional)

### index.md Template

Every wiki should have an `index.md` following this structure:

```markdown
---
name: {Module/Theme Name} Wiki
description: Knowledge base for {Module/Theme Name}
type: guide
---

# {Module/Theme Name} Wiki

Brief description of what this module/theme does.

## Pages

- [Core Concepts](#core-concepts)
- [Architecture](#architecture)
- [Patterns](#patterns)

## Core Concepts

- [About This Module](./about-module.md) — What the module does
- [Key Models](./models.md) — Main entities and relationships
- ...

## Architecture

- [Module Structure](./structure.md) — Folder organization
- [Key Patterns](./patterns.md) — Conventions used
- ...

## Patterns

- [Service Pattern](./service-pattern.md) — How services are implemented
- ...
```

---

## Implementation Guide

### Step 1: Create Directory Structure (Bash Script)

Create a script `bashscripts/wiki-init.sh` to automate directory creation:

```bash
#!/bin/bash
set -e

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

# Root project wiki
mkdir -p "$PROJECT_ROOT/docs/wiki"

# Module wikis
for module_dir in "$PROJECT_ROOT/laravel/Modules"/*/; do
    if [ -d "$module_dir" ]; then
        mkdir -p "$module_dir/docs/wiki"
    fi
done

# Theme wikis
for theme_dir in "$PROJECT_ROOT/laravel/Themes"/*/; do
    if [ -d "$theme_dir" ]; then
        mkdir -p "$theme_dir/docs/wiki"
    fi
done

# Bash scripts wiki
mkdir -p "$PROJECT_ROOT/bashscripts/docs/wiki"

echo "✅ Wiki directories created successfully"
```

### Step 2: Create Root index.md

Create `/var/www/_bases/base_ptvx_fila5/docs/wiki/index.md`:

```markdown
---
name: Project Wiki
description: Central knowledge base for Laraxot Base PTVX
type: guide
---

# Project Wiki — Laraxot Base PTVX

This is the Second Brain system — the single source of truth for project knowledge, architecture, and patterns.

## How to Navigate

- **Modules**: Each module has its own wiki in `laravel/Modules/{Module}/docs/wiki/`
- **Themes**: Theme wikis in `laravel/Themes/{Theme}/docs/wiki/`
- **Scripts**: Bash script documentation in `bashscripts/docs/wiki/`
- **Patterns**: Cross-module patterns documented here

## Module Index

The following modules have wikis:

| Module | Purpose | Wiki |
|--------|---------|------|
| Xot | Core framework utilities | [→](../laravel/Modules/Xot/docs/wiki/index.md) |
| Activity | Activity tracking | [→](../laravel/Modules/Activity/docs/wiki/index.md) |
| ... | ... | ... |

## Quick Links

- [Documentation Patterns](./patterns.md) — How to write wiki pages
- [Architecture Overview](./architecture.md) — System design (TBD)
- [Contributing Guide](../CONTRIBUTING.md) — How to contribute to wiki

---

**Last Updated**: 2026-04-29
```

### Step 3: Create Module index.md Templates

For each module, create `laravel/Modules/{Module}/docs/wiki/index.md`:

```markdown
---
name: {Module Name} Wiki
description: Documentation for the {Module Name} module
type: guide
related:
  - ../../index.md
---

# {Module Name} Module

One-sentence description of what this module does.

## Overview

Brief description (2-3 sentences) explaining the module's purpose and main responsibilities.

## Pages

- [Core Concepts](#core-concepts)
- [Architecture](#architecture)
- [Models](#models)

## Core Concepts

List concept pages once created in Story 2.2.

## Architecture

Module structure and key design decisions.

## Models

Main models and their relationships.

---

**Module Location**: `laravel/Modules/{Module}`  
**Last Updated**: 2026-04-29
```

### Step 4: Create Theme index.md Templates

For each theme, create `laravel/Themes/{Theme}/docs/wiki/index.md`:

```markdown
---
name: {Theme Name} Wiki
description: Documentation for the {Theme Name} theme
type: guide
related:
  - ../../index.md
---

# {Theme Name} Theme

Brief description of the theme's purpose and scope.

## Pages

As pages are created, list them here.

---

**Theme Location**: `laravel/Themes/{Theme}`  
**Last Updated**: 2026-04-29
```

### Step 5: Create Bash Scripts Wiki index.md

Create `bashscripts/docs/wiki/index.md`:

```markdown
---
name: Bash Scripts Wiki
description: Documentation for utility scripts
type: guide
related:
  - ../../docs/wiki/index.md
---

# Bash Scripts Documentation

Collection of utility scripts and their documentation.

## Scripts

- [wiki-init.sh](./wiki-init.sh.md) — Initialize wiki structure
- ... (other scripts)

---

**Location**: `bashscripts/`  
**Last Updated**: 2026-04-29
```

---

## Previous Story Intelligence

**N/A** — This is the first story in Epic 1.

---

## File Structure to Create

```
docs/wiki/
├── index.md                    # ✅ Root project wiki index
├── log.md                      # (Already exists)
└── patterns.md                 # (To be created in Story 1.3)

laravel/Modules/*/docs/wiki/
├── index.md                    # ✅ For each module

laravel/Themes/*/docs/wiki/
├── index.md                    # ✅ For each theme

bashscripts/docs/wiki/
└── index.md                    # ✅ Scripts wiki index
```

---

## Success Verification Checklist

- [ ] All `docs/wiki/` directories exist
- [ ] All `index.md` files created with correct frontmatter
- [ ] All relative links in index files are valid
- [ ] Directory structure matches the templates provided
- [ ] No hardcoded absolute paths used
- [ ] File encoding is UTF-8
- [ ] Line endings are LF (Unix style)
- [ ] All markdown is valid (no broken syntax)

---

## Story Completion Status

**Status**: ready-for-dev  
**Estimated Points**: 3  
**Implementation Notes**:
- This story is the foundation for all subsequent documentation work
- Once completed, the wiki structure can be populated in Stories 1.2 and 1.3
- The structure established here should remain stable through the rest of Epic 1

---

## Related Documentation

- **Next Story**: 1-2-create-wiki-indexing-and-cross-linking-system
- **Epic Overview**: Epic 1 — Second Brain Foundation & Structure
- **Project Mandate**: LLM Wiki pattern (see CLAUDE.md)

---

*Story generated by bmad-create-story at 2026-04-29*
