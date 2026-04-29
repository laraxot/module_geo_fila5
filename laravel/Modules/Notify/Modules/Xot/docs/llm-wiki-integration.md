# LLM Wiki Integration - Module Guide

> **Module**: Xot (Core)
> **Scope**: How to use LLM Wiki pattern within Laravel modules
> **Created**: 2026-04-15
> **Status**: Active

## Overview

Each Laravel module can have its own **isolated LLM Wiki** for module-specific knowledge, while the project-wide wiki (`./docs/wiki/`) handles cross-module concepts.

## Module Wiki Structure

```
Modules/Xot/
└── docs/
    └── llm-wiki/
        ├── index.md               # Module knowledge catalog
        ├── log.md                 # Module activity log
        ├── overview.md            # High-level module synthesis
        ├── raw/                   # Module-specific raw sources
        │   ├── decisions/         # Architecture decisions (raw)
        │   ├── patterns/          # Implementation patterns (raw)
        │   └── troubleshooting/   # Bug reports (raw)
        │
        ├── concepts/              # Module-specific concepts
        │   ├── xotbase-architecture.md
        │   ├── actions-over-services.md
        │   └── enum-trait-patterns.md
        │
        ├── patterns/              # Implementation patterns
        │   ├── resource-creation.md
        │   ├── migration-guidelines.md
        │   └── phpstan-compliance.md
        │
        ├── decisions/             # Architecture Decision Records
        │   ├── why-xotbase-wrappers.md
        │   └── why-actions-not-services.md
        │
        └── troubleshooting/       # Bug fixes, error resolutions
            ├── phpstan-level10-fixes.md
            └── filament-v5-migration-issues.md
```

## When to Use Module Wiki vs Project Wiki

### Use Module Wiki (`Modules/{Name}/docs/llm-wiki/`)

- Domain concepts unique to this module
- Module-specific implementation patterns
- Module architecture decisions
- Module troubleshooting guides
- Module test strategies

**Example**: `Modules/Fixcity/docs/llm-wiki/concepts/ticket-lifecycle.md`

### Use Project Wiki (`./docs/wiki/`)

- Architecture decisions affecting multiple modules
- Shared patterns (e.g., Filament v5, Laraxot conventions)
- Technology deep-dives (e.g., LMSR, LimeSurvey)
- Team processes (e.g., multi-agent coordination)
- Cross-module integration

**Example**: `docs/wiki/concepts/laraxot-actions-over-services.md`

## Module Wiki Agent Instructions

Create `Modules/{Name}/docs/llm-wiki/AGENTS.md` with module-specific rules:

```markdown
# Module LLM Wiki Agent Instructions

## Module: Xot

## Scope
This wiki contains Xot module-specific knowledge. Cross-module concepts belong
in the project wiki (./docs/wiki/).

## Directory Rules
- raw/ = READ-ONLY (module-specific sources)
- llm-wiki/ = WRITE-ALLOWED (your generated content)
- All pages MUST use frontmatter schema (see project AGENTS.md)

## When to Create Module Page vs Project Page

### Create Module Page If:
- Concept is unique to this module (e.g., XotBase wrappers)
- Pattern is module-specific (e.g., Xot resource creation)
- Decision only affects this module

### Reference Project Wiki If:
- Concept spans multiple modules (e.g., Actions over Services)
- Pattern is project-wide (e.g., PHPStan Level 10)
- Decision affects architecture globally

## Cross-Linking

When module wiki references project wiki:

```markdown
Related:
- Project-wide: [[docs/wiki/concepts/laraxot-architecture]]
- Module-specific: [[concepts/xotbase-architecture]]
```

## Workflows

Same as project wiki (ingest, query, lint), scoped to module directory.
```

## Ingesting Module-Specific Sources

### Example: Ingest XotBase Architecture Decision

```
User: "ingest Modules/Xot/docs/llm-wiki/raw/decisions/why-xotbase-wrappers.md"

LLM Agent Actions:
1. Read source from Modules/Xot/docs/llm-wiki/raw/decisions/
2. Extract concepts:
   - XotBase wrapper pattern
   - Why not extend Filament directly
   - Benefits of base class abstraction
3. Create pages:
   - Modules/Xot/docs/llm-wiki/concepts/xotbase-architecture.md
   - Modules/Xot/docs/llm-wiki/decisions/why-xotbase-wrappers.md (summary)
4. Update Modules/Xot/docs/llm-wiki/index.md
5. Update Modules/Xot/docs/llm-wiki/log.md
6. Cross-reference project wiki if applicable:
   - Link to docs/wiki/concepts/laraxot-architecture.md
7. Commit changes
```

## Module Wiki Templates

### Concept Page Template

```markdown
---
title: "XotBase Architecture Pattern"
type: concept
sources: ["raw/decisions/why-xotbase-wrappers.md"]
confidence: high
created: 2026-04-15
updated: 2026-04-15
tags: [xot, architecture, base-classes, filament, wrappers]
related:
  - concepts/xotbase-resource-pattern.md
  - patterns/resource-creation.md
  - ../../../../docs/wiki/concepts/laraxot-architecture.md
---

# XotBase Architecture Pattern

## Summary

One-sentence description of this concept.

## Context

Why this concept exists, what problem it solves.

## Implementation

How it works in this module, with code examples.

## Benefits

- Benefit 1
- Benefit 2

## Related Patterns

- [[patterns/resource-creation]]
- [[concepts/xotbase-resource-pattern]]
```

### Decision Record Template

```markdown
---
title: "Use XotBase Wrappers Instead of Direct Filament Extension"
type: decision
sources: ["raw/decisions/why-xotbase-wrappers.md"]
confidence: high
created: 2026-04-15
updated: 2026-04-15
tags: [decision, xotbase, filament, architecture]
related:
  - concepts/xotbase-architecture.md
  - ../../../../docs/wiki/decisions/use-base-classes.md
---

# Decision: Use XotBase Wrappers

## Date

2026-04-15

## Status

Accepted

## Context

What problem led to this decision.

## Decision

What was decided.

## Consequences

- Positive: Easier to upgrade Filament
- Positive: Consistent module patterns
- Negative: Slightly more abstraction to learn

## Alternatives Considered

- Extend Filament directly (rejected: harder upgrades)
- Mix approaches (rejected: inconsistent patterns)
```

## Cross-Module Wiki Coordination

### Shared Concepts

When a concept spans multiple modules (e.g., "Actions over Services"):

1. **Create ONE page in project wiki**: `docs/wiki/concepts/actions-over-services.md`
2. **Module wikis reference it**, don't duplicate:
   ```markdown
   # In Modules/Xot/docs/llm-wiki/concepts/xot-actions.md

   This module follows the project-wide
   [Actions over Services](../../../../docs/wiki/concepts/actions-over-services.md)
   pattern.
   ```

### Module-Specific Implementations

When a module implements a project concept differently:

1. **Project wiki**: Document the general pattern
2. **Module wiki**: Document the module-specific implementation
3. **Cross-link both ways**

## Module Wiki Linting

Same as project wiki lint, but scoped to module:

```
User: "lint Modules/Xot/docs/llm-wiki/"

LLM Agent:
1. Scan all Modules/Xot/docs/llm-wiki/**/*.md
2. Check for contradictions within module wiki
3. Check for broken cross-references to project wiki
4. Validate frontmatter
5. Report findings
6. Apply fixes (if approved)
7. Commit
```

## Best Practices

### 1. Keep Module Wiki Focused

- Only module-specific knowledge
- Link to project wiki for general patterns
- Don't duplicate project wiki content

### 2. Cross-Link Heavily

- Module wiki ↔ Project wiki
- Module wiki ↔ Other module wikis (if relevant)
- Use relative paths for links

### 3. Module-Specific raw/ Directory

- Store module-specific decisions, patterns, troubleshooting reports
- Keep raw/ small (module wiki is smaller than project wiki)
- Consider using project raw/ for shared sources

### 4. Commit Frequently

- Module wiki changes affect only module directory
- Use atomic commits: `docs: ingest Xot architecture decision`
- Push to remote for other AI agents to see

## Integration with Project Wiki

### Index.md Cross-References

In module `index.md`, include section for project wiki links:

```markdown
# Module Xot Wiki Index

## Module Concepts

- [[xotbase-architecture]] - XotBase wrapper pattern
- [[enum-trait-patterns]] - EnumTrait usage in Xot

## Module Patterns

- [[resource-creation]] - How to create Xot resources
- [[migration-guidelines]] - Xot migration conventions

## Project-Wiki Cross-References

### Related Project Concepts

- [[docs/wiki/concepts/laraxot-architecture]] - Overall Laraxot architecture
- [[docs/wiki/concepts/actions-over-services]] - Project-wide action pattern
- [[docs/wiki/concepts/phpstan-level10]] - PHPStan compliance

### Module's Role in Project

Xot provides core base classes and patterns used by all modules.
See [project wiki](../../../../docs/wiki/index.md) for cross-module integration.
```

## Related Documentation

- [Project Wiki Integration Guide](../../../../docs/wiki/README.md)
- [Project Wiki Agent Instructions](../../../../docs/wiki/AGENTS.md)
- [Xot Module Documentation](../README.md)
- [Laraxot Core Rules](../../../Xot/docs/README.md)
