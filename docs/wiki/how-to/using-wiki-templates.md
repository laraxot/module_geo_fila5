---
name: Using Wiki Templates for Modules and Themes
description: How to use provided templates to create consistent documentation across all modules and themes
type: guide
related:
  - ../concepts/context-mode-plugin.md
  - ../index.md
---

# Using Wiki Templates for Modules and Themes

This guide explains how to use the documentation templates provided in `docs/wiki/_templates/` to create consistent, discoverable documentation across all modules and themes.

## Available Templates

### 1. Module Context-Mode Integration Template
**File:** `docs/wiki/_templates/module-context-mode-integration.md`

**Purpose:** Explains how a specific module uses context-mode for documentation discovery and semantic search.

**Who should use it:** Every module that has a wiki in `laravel/Modules/{Module}/docs/wiki/`

**How to use:**
```bash
# Copy to your module
cp docs/wiki/_templates/module-context-mode-integration.md \
   laravel/Modules/{YourModule}/docs/wiki/context-mode-integration.md

# Edit the file to customize for your module
# Replace {Module} placeholders with your module name
# Add module-specific integration examples
```

**Example for Activity module:**
```bash
cp docs/wiki/_templates/module-context-mode-integration.md \
   laravel/Modules/Activity/docs/wiki/context-mode-integration.md

# Then customize: change {Module} → Activity, add Activity-specific examples
```

---

## Template Customization Checklist

When customizing a template for your module/theme:

- [ ] Replace all `{Module}` with your module name
- [ ] Replace all `{Module/Theme Name}` with appropriate display name
- [ ] Add module-specific examples in code blocks
- [ ] Update "Integration with Other Modules" section with your actual integrations
- [ ] Verify all relative links are correct (test in wiki viewer)
- [ ] Add module-specific troubleshooting if relevant

---

## Standard Module Wiki Structure

All modules should follow this structure:

```
laravel/Modules/{Module}/docs/wiki/
├── index.md                          # Module overview and index
├── core-concepts.md                  # Key entities and patterns
├── architecture.md                   # Design decisions
├── models.md                         # Data models
├── patterns.md                       # Implementation patterns
└── context-mode-integration.md       # [Optional] Context-mode usage guide
```

**See also:** Story 1.1 — Initialize Wiki Directory Structure

---

## Workflow: Set Up Module Documentation

### Step 1: Create Wiki Directory Structure
```bash
mkdir -p laravel/Modules/{Module}/docs/wiki
```

### Step 2: Create Core Documentation Files

#### index.md
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

## Pages

- [Core Concepts](./core-concepts.md)
- [Architecture](./architecture.md)
- [Models](./models.md)
- [Patterns](./patterns.md)
```

#### core-concepts.md, architecture.md, models.md, patterns.md
Create these with relevant content for your module.

### Step 3 (Optional): Add Context-Mode Integration Guide
```bash
cp docs/wiki/_templates/module-context-mode-integration.md \
   laravel/Modules/{Module}/docs/wiki/context-mode-integration.md

# Customize it for your module
```

### Step 4: Index Your Documentation
```bash
/ctx-index --path "laravel/Modules/{Module}/docs/wiki/" \
           --source "{Module} Module"
```

### Step 5: Verify and Commit
```bash
# Test search
/ctx-search "{module-keyword}"

# Commit documentation
git add laravel/Modules/{Module}/docs/wiki/
git commit -m "docs: Add wiki documentation for {Module} module"
```

---

## Bulk Setup for All Modules

To quickly set up context-mode integration guides for all modules:

```bash
#!/bin/bash
# Create context-mode-integration.md in all modules

for module in laravel/Modules/*/; do
  module_name=$(basename "$module")
  template_path="$module/docs/wiki/context-mode-integration.md"
  
  if [ ! -f "$template_path" ]; then
    cp docs/wiki/_templates/module-context-mode-integration.md "$template_path"
    
    # Customize the template (replace {Module} with actual module name)
    sed -i "s/{Module}/$module_name/g" "$template_path"
    sed -i "s/{Module\/Theme Name}/$module_name Module/g" "$template_path"
    
    echo "✅ Created: $template_path"
  fi
done

# Re-index all modules
/ctx-index --path "laravel/Modules/" --source "All Modules"

echo "✅ All modules indexed and searchable"
```

Save this script as `bashscripts/setup-module-context-mode.sh` and run it.

---

## Theme Documentation

Themes follow the same pattern as modules:

```
laravel/Themes/{Theme}/docs/wiki/
├── index.md
├── components.md
├── styling.md
├── customization.md
└── context-mode-integration.md
```

Use the same template, replacing `{Module}` with theme name.

---

## Template Maintenance

### When to Update Templates

Templates are in `docs/wiki/_templates/` and should be updated when:
- New best practices emerge
- Context-mode gets new features
- Project-wide documentation standards change

### How to Update All Modules

If you update a template and want existing modules to adopt changes:

```bash
#!/bin/bash
# Update all existing context-mode-integration.md files

for file in laravel/Modules/*/docs/wiki/context-mode-integration.md; do
  if [ -f "$file" ]; then
    # Re-copy template and customize
    module=$(basename "$(dirname "$file")/.." | cut -d'/' -f3)
    cp docs/wiki/_templates/module-context-mode-integration.md "$file"
    sed -i "s/{Module}/$module/g" "$file"
    sed -i "s/{Module\/Theme Name}/$module Module/g" "$file"
    echo "Updated: $file"
  fi
done
```

---

## Quality Checklist

After setting up documentation from templates, verify:

- [ ] All frontmatter fields are present (name, description, type, related)
- [ ] All relative links are correct
- [ ] No broken [[wiki-style links]]
- [ ] File names follow: lowercase-with-hyphens.md
- [ ] No hardcoded absolute paths
- [ ] UTF-8 encoding, LF line endings

Check with:
```bash
/ctx-doctor    # Verify system health
/ctx-stats     # Check compression
```

---

## See Also

- [[Context-Mode Plugin]] — Detailed concept documentation
- [[How to Index Module Documentation]] — Indexing workflow
- Story 1.1 — Initialize Wiki Directory Structure
- `docs/wiki/_templates/module-context-mode-integration.md` — The template itself

---

**Last Updated**: 2026-04-29  
**Applies to**: All modules and themes in the project
