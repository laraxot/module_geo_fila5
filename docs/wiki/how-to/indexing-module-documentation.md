---
name: How to Index Module Documentation with Context-Mode
description: Step-by-step guide for indexing module docs and making them searchable
type: guide
related:
  - ../concepts/context-mode-plugin.md
  - ../concepts/context-mode-cli-reference.md
  - ../index.md
---

# Indexing Module Documentation with Context-Mode

Guide for making your module's documentation discoverable through context-mode semantic search.

## Overview

Module documentation becomes searchable and reusable when indexed into the context-mode knowledge base. This makes it easy for:
- Other developers to find patterns from your module
- AI agents to understand your module's architecture
- Continuous documentation maintenance to identify gaps

## Step 1: Organize Your Module's Wiki

Each module should have this structure:

```
laravel/Modules/{ModuleName}/
├── docs/
│   ├── raw/                    # Existing raw documentation
│   └── wiki/
│       ├── index.md            # Module overview
│       ├── core-concepts.md    # Key entities and patterns
│       ├── architecture.md     # Design decisions
│       ├── models.md           # Data model documentation
│       └── patterns.md         # Implementation patterns
```

**See also:** Story 1.1 — Initialize Wiki Directory Structure

## Step 2: Create Module index.md

Each module wiki starts with an index:

```markdown
---
name: {Module Name} Wiki
description: Documentation for the {Module Name} module
type: guide
related:
  - ../../index.md
---

# {Module Name} Module

Brief description of what this module does.

## Pages

- [Core Concepts](./core-concepts.md)
- [Architecture](./architecture.md)
- [Models](./models.md)
- [Patterns](./patterns.md)
```

## Step 3: Index Your Module Documentation

Once your wiki pages exist, index them for semantic search:

```bash
/ctx-index \
  --path "laravel/Modules/{ModuleName}/docs/wiki/" \
  --source "{ModuleName} Module Docs"
```

**Example:**
```bash
/ctx-index \
  --path "laravel/Modules/Activity/docs/wiki/" \
  --source "Activity Module"
```

## Step 4: Search & Verify

Test that your documentation is searchable:

```bash
/ctx-search "activity tracking event recording"
/ctx-search "activity module implementation"
```

You should see your module's pages in the results.

## Step 5: Link Documentation Across Modules

When your module uses or relates to other modules, add cross-references:

```markdown
---
name: Core Concepts
description: Key concepts in the Activity module
type: concept
related:
  - ../../../Audit/docs/wiki/index.md
  - ../../../Notification/docs/wiki/index.md
---

# Core Concepts

...content...

See also:
- [[Audit Module]] — Related auditing functionality
- [[Notification Module]] — For event notifications
```

## Best Practices

### 1. Document as You Code
Add wiki pages when implementing major features:
```
Feature Implementation → Wiki Documentation → Commit together
```

### 2. Keep Examples in Code, Links in Wiki
```markdown
# Service Pattern

Services in this module follow the Action pattern.

See: `app/Services/ActivityRecorder.php` for implementation example
```

Instead of copying code into wiki, link to the source.

### 3. Update Wiki When Changing Architecture
When refactoring:
```
Refactor → Update relevant wiki pages → Run lint check
```

### 4. Regular Indexing Maintenance
Every 2-4 weeks:
```bash
# Re-index all modules to pick up recent changes
/ctx-index --path "laravel/Modules/" --source "All Modules"

# Or just your module
/ctx-index --path "laravel/Modules/{YourModule}/docs/wiki/" --source "{YourModule}"
```

## Full Example: Activity Module

### Create `laravel/Modules/Activity/docs/wiki/index.md`
```markdown
---
name: Activity Module Wiki
description: Documentation for the Activity module
type: guide
---

# Activity Module

Tracks and records user activities, providing audit trails and activity history.

## Pages

- [Core Concepts](./core-concepts.md)
- [Architecture](./architecture.md)
- [Models](./models.md)
```

### Create `laravel/Modules/Activity/docs/wiki/core-concepts.md`
```markdown
---
name: Activity Module Core Concepts
description: Key concepts for understanding activity tracking
type: concept
related:
  - ./architecture.md
---

# Core Concepts

## Activities
An Activity record represents a single user action...

## Event Recording
Events are captured through...

See `app/Models/Activity.php` for the data model.
```

### Index the Module
```bash
/ctx-index --path "laravel/Modules/Activity/docs/wiki/" --source "Activity Module"
```

### Verify It Works
```bash
/ctx-search "activity tracking user action"
```

Result should include your Activity module pages.

## Integration with CI/CD

Add to pre-commit hook or CI pipeline:

```bash
#!/bin/bash
# Validate module wiki exists
for module in laravel/Modules/*/; do
  if [ ! -d "$module/docs/wiki/" ]; then
    echo "❌ Missing wiki in: $module"
    exit 1
  fi
done

# Re-index after major changes
if git diff --name-only | grep -q "docs/wiki/"; then
  /ctx-index --path "laravel/Modules/" --source "All Modules Updated"
fi
```

## Troubleshooting

### "My module isn't appearing in search results"

**Step 1:** Check if wiki directory exists
```bash
ls -la laravel/Modules/{ModuleName}/docs/wiki/
```

**Step 2:** Verify index.md has proper frontmatter
```bash
head -10 laravel/Modules/{ModuleName}/docs/wiki/index.md
```

**Step 3:** Re-index explicitly
```bash
/ctx-index --path "laravel/Modules/{ModuleName}/docs/wiki/" \
           --source "{ModuleName} Debug"
```

**Step 4:** Check if knowledge base is full
```bash
ls -lh ~/.claude/context-mode/knowledge.db
# If >500MB, might need selective indexing
```

### "Too many modules, how do I manage this?"

Index at the parent level:
```bash
# Index all modules at once (runs once, then search is fast)
/ctx-index --path "laravel/Modules/" --source "All Modules"

# Then search across all modules
/ctx-search "my query"
```

## Maintenance Routine

**Weekly:**
```bash
/ctx-stats  # Check compression ratio
```

**Monthly:**
```bash
# Re-index if significant documentation changes
/ctx-index --path "laravel/Modules/" --source "All Modules"
/ctx-search "test your common queries"
```

**Quarterly:**
```bash
/ctx-doctor  # Verify health
/ctx-insight # Review usage trends
```

## See Also

- [[Context-Mode Plugin]] — How context-mode works
- [[Context-Mode CLI Reference]] — Command reference
- [[Second Brain Operating Model]] — Documentation philosophy
- Story 1.1 — Initialize Wiki Directory Structure

---

**Last Updated**: 2026-04-29  
**Applies to**: All modules and themes
