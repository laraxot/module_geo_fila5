---
name: Module Wiki Documentation Guide
description: Step-by-step guide for creating and maintaining QMD-indexed documentation in module wikis
type: how-to
created: 2026-04-29
updated: 2026-04-29
related: [qmd-search-guide.md, indexing-module-documentation.md]
references:
  - type: tooling
    module: Xot
    path: laravel/Modules/Xot/docs/wiki/index.md
  - type: example
    module: Gdpr
    path: laravel/Modules/Gdpr/docs/wiki/index.md
  - type: example
    module: Activity
    path: laravel/Modules/Activity/docs/wiki/index.md
---

# Module Wiki Documentation Guide

Each Laravel module maintains its own wiki at `laravel/Modules/{ModuleName}/docs/wiki/`. This guide explains structure, indexing with QMD, and best practices.

## Module Wiki Structure

Standard layout for all modules:

```
laravel/Modules/MyModule/docs/wiki/
├── index.md                    # Module overview and navigation
├── concepts/
│   ├── core-patterns.md       # Core business logic patterns
│   ├── models.md              # Data models and relationships
│   └── architecture.md        # Module architecture
├── guides/
│   ├── getting-started.md     # How to use this module
│   ├── common-tasks.md        # How to accomplish X, Y, Z
│   └── troubleshooting.md     # Common issues and fixes
├── api/
│   ├── actions.md             # Available actions/services
│   ├── models.md              # Model reference
│   └── events.md              # Module events
├── database/
│   ├── migrations.md          # Migration reference
│   └── schema.md              # Database schema
└── examples/
    └── feature-workflow.md    # End-to-end examples
```

## Creating a Module Wiki

### Step 1: Create Root Index

Create `laravel/Modules/MyModule/docs/wiki/index.md`:

```markdown
---
qmd: "my-module, core-concepts, patterns, models"
---

# MyModule Wiki

Overview of MyModule and quick navigation.

## Quick Links
- [Core Concepts](./concepts/core-patterns.md)
- [Getting Started](./guides/getting-started.md)
- [API Reference](./api/)

## What This Module Does
[Describe module purpose and responsibilities]

## Key Features
- [Feature 1]
- [Feature 2]
```

### Step 2: Create Concept Pages

Document core concepts in `concepts/` directory:

```markdown
---
qmd: "my-module, concept-name, related-concept"
related: [other-concept.md, ../api/models.md]
---

# Concept Name

[Explanation of concept and why it matters]

## Pattern Implementation

[Code examples or references]

## Related Concepts
- [Related Concept 1](./related.md)
- [Related Concept 2](qmd://module_OtherModule/concepts.md)
```

### Step 3: Register Collection with QMD

```bash
# Register the module's wiki
qmd collection add module_MyModule laravel/Modules/MyModule/docs/wiki

# Verify
qmd ls module_MyModule

# Force initial embedding
qmd embed --collection module_MyModule
```

## QMD Integration in Modules

### Searching Module-Specific Content

```bash
# Search only within this module
qmd search "pattern name" -c module_MyModule

# Search across all modules
qmd search "pattern name" -c modules-docs
```

### Cross-Module References

Link to other modules' wikis:

```markdown
[User Permissions](qmd://module_User/concepts/permissions.md)
[Event Handling](qmd://module_Notify/api/events.md)
```

### Querying from Code

Within module code, document with wiki links:

```php
/**
 * See: {@link qmd://module_MyModule/concepts/core-patterns.md}
 * Related: {@link qmd://module_Activity/concepts/event-sourcing.md}
 */
public function handleSomething(): void
{
    // implementation
}
```

## Documentation Workflow

### When Adding a New Feature

1. **Document first** — Add concept or guide to wiki
2. **Reference in code** — Link to wiki docs in docblocks
3. **Update index** — Add to module index.md
4. **Embed** — Run `qmd embed --collection module_MyModule`
5. **Test search** — Verify discovery with QMD

Example:

```bash
# 1. Create guide
cat > laravel/Modules/MyModule/docs/wiki/guides/new-feature.md << 'EOF'
---
qmd: "my-module, new-feature, how-to"
---

# New Feature Guide

[Documentation...]
EOF

# 2. Update index.md (add link)
# 3. Embed
qmd embed --collection module_MyModule

# 4. Test
qmd search "new feature" -c module_MyModule
```

## Frontmatter Specification

All module wiki files should include:

```yaml
---
name: "Page Title"
description: "One-line summary of content"
type: "concept|guide|reference|example"
module: "MyModule"
related: 
  - ./related-page.md
  - qmd://module_Other/page.md
qmd: "keyword1, keyword2, module-slug"
---
```

## Indexing Strategy

### What to Document

✅ **DO document**:
- Core business logic patterns
- Database schemas and migrations
- Public APIs and actions
- Configuration options
- Common workflows
- Troubleshooting guides
- Architecture decisions

❌ **DON'T document**:
- Code comments (put in code instead)
- Tool output or logs
- Personal notes
- Deprecated features (archive separately)

### Content Guidelines

**For Concepts**: Explain the WHY and WHEN
```markdown
# Pattern Name

## When to Use
[Conditions where this pattern applies]

## Why This Pattern
[Benefits and rationale]

## Implementation Example
[Code example]
```

**For Guides**: Provide step-by-step HOW
```markdown
# How to [Do Something]

## Prerequisites
[What you need first]

## Steps
1. [Step 1]
2. [Step 2]

## Verification
[How to confirm it worked]

## Common Issues
[Troubleshooting]
```

**For Reference**: Clear API docs
```markdown
# Model Name

## Properties
| Property | Type | Description |
|----------|------|-------------|

## Methods
| Method | Returns | Description |

## Events
| Event | Payload | Description |
```

## Module Discoverability

### Adding Context

Help QMD understand your module:

```bash
qmd context add qmd://module_MyModule/ \
  "MyModule handles [core responsibility]. Key concepts: [concept1], [concept2]"
```

### Update Frequency

QMD updates module collections automatically every 22 hours. Force update:

```bash
qmd collection update module_MyModule
```

## Maintenance

### Regular Tasks

**Weekly**:
```bash
# Update all module collections
qmd collection update module_MyModule

# Check for embedding gaps
qmd status | grep module_MyModule
```

**Monthly**:
```bash
# Rebuild module index
qmd rebuild --collection module_MyModule

# Verify all pages are indexed
qmd ls module_MyModule | wc -l
```

### Archiving Old Content

Keep module wikis current by archiving outdated pages:

```
laravel/Modules/MyModule/docs/wiki/_archive/
├── old-pattern.md
└── deprecated-feature.md
```

QMD won't index `_archive/` by default (configure in `.qmd.json` if needed).

## Cross-Team Documentation

When multiple teams work on a module:

1. **Create a OWNERS.md** in module wiki:
   ```markdown
   # Module Ownership

   ## Core Team
   - @user1 — Lead Developer
   - @user2 — Domain Expert

   ## Documentation
   Last updated: [date]
   Next review: [date]
   ```

2. **Link to related modules**:
   ```markdown
   ## Dependent Modules
   - [Module B](qmd://module_B/index.md) — Uses our events
   - [Module C](qmd://module_C/index.md) — Extends our models
   ```

3. **Document integration points**:
   Create `api/contracts.md` documenting public interfaces.

## Examples

### Minimal Module Wiki (Getting Started)

```markdown
---
qmd: "my-module, overview"
---

# MyModule

Handles [core responsibility].

## Getting Started
See [guides/getting-started.md](./guides/getting-started.md)

## Core Concepts
- [Concept 1](./concepts/core.md)

## API Reference
- [Actions](./api/actions.md)
```

### Complete Module Wiki (Mature)

```markdown
---
qmd: "my-module, comprehensive, patterns, architecture"
type: reference
---

# MyModule — Complete Reference

[Detailed overview]

## Documentation Index
- [Concepts](./concepts/)
- [Guides](./guides/)
- [API](./api/)
- [Database](./database/)
- [Examples](./examples/)

## Quick Reference
[Cheat sheet]

## Integration Guide
[How to use in other modules]
```

## Troubleshooting

**Q: My new pages aren't appearing in QMD search**
A: Run `qmd embed --collection module_MyModule` to force indexing

**Q: QMD search is returning irrelevant results**
A: Add better `qmd` metadata to frontmatter

**Q: How do I see what's indexed?**
A: `qmd ls module_MyModule --verbose`

## References

- [QMD Search Guide](./qmd-search-guide.md)
- [Context-Mode Overflow Prevention](./context-mode-overflow-prevention.md)
- [Module Structure Concept](../concepts/module-structure.md)

---

**Last Updated**: 2026-04-29  
**Status**: Active  
**Related Stories**: Story 2.1 (QMD Search Integration)
