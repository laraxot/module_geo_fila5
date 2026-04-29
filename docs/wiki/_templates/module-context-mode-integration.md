---
name: "{Module/Theme Name} — Context-Mode Integration"
description: How this module/theme uses context-mode for documentation discovery
type: guide
related:
  - ../../index.md
  - ../concepts/context-mode-plugin.md
  - ../concepts/context-mode-cli-reference.md
---

# {Module/Theme Name} — Context-Mode Integration

This guide explains how context-mode is used for documentation and knowledge discovery in the {Module/Theme Name} module/theme.

## What Is Context-Mode?

Context-mode is the project-wide tool for making documentation searchable through semantic (meaning-based) search rather than just keyword matching. It helps developers quickly find patterns, architectural decisions, and examples from your module.

**See also:** [[Context-Mode Plugin]] for detailed documentation.

## Your Module's Documentation Structure

Documentation for {Module/Theme Name} is organized as follows:

```
laravel/Modules/{Module}/docs/
├── raw/                       # Raw documentation (existing)
└── wiki/
    ├── index.md              # Module overview (lists all pages)
    ├── core-concepts.md      # Key entities and patterns
    ├── architecture.md       # Design decisions and structure
    ├── models.md             # Data models and relationships
    └── patterns.md           # Implementation patterns
```

## Making Your Documentation Searchable

### Initial Setup (One Time)

When your module documentation is ready, index it:

```bash
cd /var/www/_bases/base_ptvx_fila5

/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" \
           --source "{Module} Module"
```

**Example for Activity module:**
```bash
/ctx-index --path "laravel/Modules/Activity/docs/wiki/" \
           --source "Activity Module"
```

### Verify Indexing Worked

Search for content from your module:

```bash
/ctx-search "{module-specific-keyword}"
```

**Example:**
```bash
/ctx-search "activity event tracking"
```

You should see your module's pages in the results.

## Using Context-Mode for Your Module Development

### Before Writing Code
Check if similar patterns already exist in your module:

```bash
/ctx-search "{your-module} {feature-name}"
```

Example:
```bash
/ctx-search "Activity module event recording"
```

### During Implementation
Reference your module's documented patterns:

```bash
/ctx-search "{your-module} {pattern-name}"
```

Example:
```bash
/ctx-search "Activity service pattern"
```

### After Implementing Features
Update your module's wiki pages to document the new feature, then re-index:

```bash
/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" \
           --source "{Module} Module Updated"
```

## Module Documentation Checklist

Before indexing, ensure your module has:

- [ ] `docs/wiki/index.md` with module overview and links to all pages
- [ ] `docs/wiki/core-concepts.md` explaining key entities
- [ ] `docs/wiki/architecture.md` describing design decisions
- [ ] `docs/wiki/models.md` documenting data models
- [ ] All wiki pages have proper YAML frontmatter (name, description, type, related)
- [ ] All internal links use relative paths: `./core-concepts.md`
- [ ] All external links use relative paths to other modules: `../../AnotherModule/docs/wiki/index.md`

**See also:** Story 1.1 — Initialize Wiki Directory Structure

## Common Workflows

### Workflow 1: Adding a New Pattern

1. Implement the pattern in your module
2. Document it in `docs/wiki/patterns.md`
3. Re-index: `/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" --source "{Module} Updated"`
4. Commit documentation with code

### Workflow 2: Finding Related Patterns from Other Modules

1. Search for the pattern: `/ctx-search "pattern-name"`
2. Review documentation from other modules
3. Adapt or reference those patterns in your implementation

### Workflow 3: Documenting Architecture Decisions

1. Add decision to `docs/wiki/architecture.md` with context and rationale
2. Reference related decisions from other modules
3. Re-index to make it discoverable

## Integration with Other Modules

{Module/Theme Name} integrates with other modules. When documenting these relationships, add cross-references:

```markdown
## Integration with Other Modules

This module integrates with:

- [[Module A Module]] — Description of integration
- [[Module B Module]] — Description of integration

See:
- `../../../ModuleA/docs/wiki/integration.md`
- `../../../ModuleB/docs/wiki/integration.md`
```

## Maintenance

### Monthly (2-4 weeks)
If you make significant documentation changes, re-index:

```bash
/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" \
           --source "{Module} Module"
```

### Quarterly
Check overall project documentation health:

```bash
/ctx-doctor     # Verify everything works
/ctx-stats      # Check compression ratio
```

## Troubleshooting

### "My module's documentation isn't showing up in search results"

**Step 1:** Verify wiki directory exists
```bash
ls -la laravel/Modules/{Module}/docs/wiki/
```

**Step 2:** Check index.md exists and has proper frontmatter
```bash
head -15 laravel/Modules/{Module}/docs/wiki/index.md
```

**Step 3:** Re-index explicitly
```bash
/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" \
           --source "{Module} Debug"
```

**Step 4:** Search for specific terms from your documentation
```bash
/ctx-search "exact term from your docs"
```

### "The search results are not relevant"

Context-mode uses semantic search, which means:
- It matches meaning, not just keywords
- Be specific with search terms: "Activity event tracking" vs just "activity"
- Include domain context: "Laravel service pattern" vs just "service"

### "I get 'FTS5 not available' error"

Verify context-mode health:
```bash
/ctx-doctor
```

If FTS5 shows as failing, rebuild:
```bash
npm rebuild better-sqlite3 --global
/ctx-doctor
```

## Commands Reference

| Task | Command |
|------|---------|
| Index this module | `/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" --source "{Module}"` |
| Search documentation | `/ctx-search "your query"` |
| Check system health | `/ctx-doctor` |
| View compression stats | `/ctx-stats` |
| View analytics dashboard | `/ctx-insight` |

## See Also

- [[Context-Mode Plugin]] — Detailed concept documentation
- [[Context-Mode CLI Reference]] — Full command reference
- [[How to Index Module Documentation]] — Comprehensive indexing guide
- [[Second Brain Operating Model]] — Project documentation philosophy

---

**Created**: 2026-04-29  
**For Module/Theme**: {Module/Theme Name}  
**Status**: Template — Customize and place in your module/theme docs/wiki/ directory

---

## How to Use This Template

1. Copy this file to `laravel/Modules/{YourModule}/docs/wiki/context-mode-integration.md`
2. Replace all instances of `{Module}` with your module name
3. Replace all instances of `{Module/Theme Name}` with appropriate names
4. Add module-specific integration examples in the "Integration with Other Modules" section
5. Commit the customized file with your module's documentation

**Example:**
```bash
cp docs/wiki/_templates/module-context-mode-integration.md \
   laravel/Modules/Activity/docs/wiki/context-mode-integration.md

# Then edit to customize for Activity module
```
