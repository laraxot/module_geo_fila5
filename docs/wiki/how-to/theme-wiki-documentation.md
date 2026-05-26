---
title: "Theme Wiki Documentation Guide"
type: how-to
tags: [theme, wiki, qmd, second-brain]
module: ptvx-project
created: 2026-04-29
updated: 2026-05-26
qmd: "theme wiki documentation, laravel theme docs wiki structure"
related:
  - "qmd-search-guide.md"
  - "module-wiki-documentation.md"
  - "github-issue-agent-discipline.md"
  - "../concepts/second-brain-operating-model.md"
  - "../concepts/markdown-note-minimum-standard.md"
  - "../sources/second-brain-external-benchmarks.md"
---

# Theme Wiki Documentation Guide

Each Laravel theme maintains its own wiki at `laravel/Themes/{ThemeName}/docs/wiki/`. This guide explains structure, QMD integration, and maintenance.

## Standard minimo ogni `.md`

Come per i moduli: [Markdown Note Minimum Standard](../concepts/markdown-note-minimum-standard.md) — YAML front matter, nota atomica, link con path verificati ([Tip 020](https://hackernoon.com/ai-coding-tip-020-create-a-second-brain)).

## Second brain di tema

Come per i moduli: asset e note operative in `laravel/Themes/{ThemeName}/docs/` (non wiki); **`docs/wiki/`** del tema per sintesi UX, componenti e convenzioni frontend. Stesso ciclo *capture → distill → express* descritto nel [Second Brain Operating Model](../concepts/second-brain-operating-model.md).

- Stub locale (puntatore DRY): `laravel/Themes/<Name>/docs/second-brain.md` nella **radice** di `docs/` del tema.
- Stub **disciplina edit agent / qualità**: `laravel/Themes/<Name>/docs/agent-edit-discipline.md` — puntatori DRY alla wiki root, [issue #124](https://github.com/provtv/base_ptv_fila5_mono/issues/124), e **`autocompact-thrashing-recovery`** (messaggio IDE *thrashing*).

## Theme Wiki Structure

Standard layout for all themes:

```
laravel/Themes/MyTheme/docs/wiki/
├── index.md                    # Theme overview and usage
├── concepts/
│   ├── layout-system.md       # Theme layout architecture
│   ├── component-hierarchy.md # How components relate
│   └── styling-approach.md    # CSS/styling philosophy
├── components/
│   ├── headers.md             # Header component variations
│   ├── navigation.md          # Navigation components
│   ├── cards.md               # Card component family
│   └── forms.md               # Form components
├── guides/
│   ├── getting-started.md     # Using this theme
│   ├── customization.md       # Customization patterns
│   ├── colors-and-fonts.md    # Theme variables
│   └── responsive-design.md   # Breakpoints and responsive behavior
├── templates/
│   ├── page-layouts.md        # Standard page templates
│   └── component-slots.md     # Blade slot patterns
└── examples/
    ├── full-page.md           # Complete page example
    └── common-layouts.md      # Common layout combinations
```

## Creating a Theme Wiki

### Step 1: Theme Index

Create `laravel/Themes/MyTheme/docs/wiki/index.md`:

```markdown
---
qmd: "my-theme, ui, components, design-system"
---

# MyTheme Documentation

Visual design theme for [what this theme targets].

## Quick Navigation
- [Component Library](./components/)
- [Customization Guide](./guides/customization.md)
- [Color & Typography](./guides/colors-and-fonts.md)

## Theme Purpose
[What visual problems does this theme solve]

## Key Features
- [Feature 1]
- [Feature 2]
- [Feature 3]
```

### Step 2: Component Documentation

Document components in `components/{component}.md`:

```markdown
---
qmd: "my-theme, component-name, ui-element"
related: [../concepts/component-hierarchy.md]
---

# Component Name

Brief description of what this component displays.

## Variations
[List visual variations: sizes, colors, states]

## Usage Example
\`\`\`blade
@component('theme::components.my-component', [
    'color' => 'primary',
    'size' => 'large'
])
    Component content
@endcomponent
\`\`\`

## Slots
| Slot | Type | Purpose |
|------|------|---------|
| default | content | Main content |
| footer | content | Footer area |

## CSS Classes
- `.my-component` — Root element
- `.my-component__header` — Header section
- `.my-component--primary` — Primary variant

## Responsive Behavior
[How component changes across breakpoints]

## Accessibility
- ARIA attributes: [list]
- Keyboard navigation: [describe]
```

### Step 3: Register with QMD

```bash
# Register theme wiki
qmd collection add theme_MyTheme laravel/Themes/MyTheme/docs/wiki

# Verify
qmd ls theme_MyTheme | head

# Index immediately
qmd embed --collection theme_MyTheme
```

## QMD Integration for Themes

### Finding Components

```bash
# Search components in this theme
qmd search "button component" -c theme_MyTheme

# Search across all themes
qmd search "navigation" -c themes-docs

# Semantic search for similar patterns
qmd search "expandable containers" --semantic -c theme_MyTheme
```

### Cross-Theme References

Link between theme wikis:

```markdown
[Comparison with OtherTheme](qmd://theme_OtherTheme/index.md)
[Shared Component Patterns](qmd://theme_OtherTheme/concepts/component-hierarchy.md)
```

### Code Documentation Links

In Blade templates, document component locations:

```blade
{{-- Theme: {@link qmd://theme_MyTheme/components/card.md} --}}
<div class="card {{ $class ?? '' }}">
    {{ $slot }}
</div>
```

## Documentation Workflow

### Adding a New Component

1. **Create component file** → `resources/views/components/my-component.blade.php`
2. **Create documentation** → `docs/wiki/components/my-component.md`
3. **Document in index** → Add to `docs/wiki/components/index.md`
4. **Reference from other pages** → Link from relevant concept/guide pages
5. **Embed** → `qmd embed --collection theme_MyTheme`
6. **Test** → `qmd search "my component" -c theme_MyTheme`

Example workflow:

```bash
# 1-4. Create files (in editor)

# 5. Embed
qmd embed --collection theme_MyTheme

# 6. Test
qmd search "new component" -c theme_MyTheme
```

## Frontmatter Specification

All theme wiki files should include:

```yaml
---
name: "Page Title"
description: "One-line summary"
type: "concept|guide|component|reference|example"
theme: "MyTheme"
related:
  - ./related-page.md
  - qmd://theme_Other/page.md
qmd: "keyword1, keyword2, theme-name"
---
```

## Documentation Standards

### Component Specification Template

Always document:
1. **Visual Description** — What does it look like?
2. **Purpose** — What problem does it solve?
3. **Variations** — What options does it have?
4. **Usage** — How to use it (Blade example)
5. **Slots/Props** — Input parameters
6. **CSS Classes** — For custom styling
7. **Responsive Behavior** — Mobile/tablet/desktop
8. **Accessibility** — ARIA, keyboard navigation

### Concept Documentation Template

Always explain:
1. **Philosophy** — Why this approach?
2. **Scope** — What does this cover?
3. **Examples** — Concrete usage patterns
4. **Related Concepts** — Links to other concepts
5. **Constraints** — What are the limits?

## Component Hierarchy Documentation

Create `concepts/component-hierarchy.md` to explain structure:

```markdown
---
qmd: "my-theme, architecture, component-hierarchy"
---

# Component Hierarchy

## Base Components
- [Typography](../components/typography.md)
- [Spacing](../components/spacing.md)

## Composite Components
Built from base components:
- [Card](../components/card.md) — uses Typography, Spacing
- [Form](../components/forms.md) — uses Input, Label, Button

## Page-Level Components
Full page sections:
- [Header](../components/headers.md)
- [Sidebar](../components/sidebar.md)
```

## Theme Variables

Document theme customization in `guides/colors-and-fonts.md`:

```markdown
---
qmd: "my-theme, customization, design-tokens"
---

# Colors & Typography

## Color System

### Primary Colors
| Name | Value | Usage |
|------|-------|-------|
| `primary` | #0066cc | Primary actions |
| `secondary` | #6c757d | Secondary actions |

### How to Override
\`\`\`css
:root {
    --color-primary: #0066cc;
}
\`\`\`

## Typography

### Font Stack
- Headings: Inter, sans-serif
- Body: -apple-system, BlinkMacSystemFont, "Segoe UI"

### Sizes
| Class | Font Size |
|-------|-----------|
| `.text-xs` | 12px |
| `.text-sm` | 14px |
| `.text-base` | 16px |
```

## Using QMD with Theme Development

### Discovery Workflow

When developing UI features:

```bash
# 1. Search for similar existing components
qmd search "expandable elements" -c theme_MyTheme

# 2. Read documentation for related patterns
# 3. Check if component exists, if not create

# 4. After creating, document it
# 5. Embed to make discoverable

qmd embed --collection theme_MyTheme

# 6. Verify search works
qmd search "new component" -c theme_MyTheme
```

### Keeping Components in Sync

When components change:

1. **Update Blade file**
2. **Update documentation** — Especially variations, slots, CSS classes
3. **Run** `qmd embed --collection theme_MyTheme`
4. **Verify** other pages linking to this component still make sense

## Maintenance Schedule

| Task | Frequency | Command |
|------|-----------|---------|
| Update component docs | As needed | Edit markdown files |
| Embed changes | Weekly | `qmd embed --collection theme_MyTheme` |
| Review outdated docs | Monthly | Manual review |
| Update theme variables | Per release | Update `colors-and-fonts.md` |
| Archive old components | Yearly | Move to `_archive/` |

## Examples

### Minimal Theme Wiki

```markdown
---
qmd: "my-theme, ui-library"
---

# MyTheme

Lightweight theme with [key features].

## Components
See [components/](./components/)

## Getting Started
1. Copy theme to project
2. Include CSS: `<link href="theme.css">`
3. Use components in templates
```

### Comprehensive Theme Wiki

```markdown
---
qmd: "my-theme, design-system, accessible, components"
---

# MyTheme — Complete Reference

Enterprise design system with [description].

## Documentation
- [Component Library](./components/)
- [Design Concepts](./concepts/)
- [Customization Guides](./guides/)
- [Examples](./examples/)

## Quick Component Index
[Categorized list]

## Accessibility
WCAG 2.1 AA compliant. See [accessibility guide].

## Design Tokens
[Reference to design tokens]
```

## Theme-Specific QMD Setup

### Searching Across Themes

```bash
# Find similar components in all themes
qmd search "card layout" -c themes-docs

# Compare theme approaches
qmd search "form validation" -c theme_MyTheme
qmd search "form validation" -c theme_OtherTheme
```

### Context for Themes

```bash
qmd context add qmd://theme_MyTheme/ \
  "MyTheme provides UI components for [purpose]. Key areas: components, layout, customization"
```

## Troubleshooting

**Q: Component documentation not showing up in search**
A: Run `qmd embed --collection theme_MyTheme`

**Q: Should I document every CSS class?**
A: Document ones that users might customize; skip internal implementation details

**Q: How do I handle theme variations?**
A: Create separate pages for major variations, or document variations in one page with subsections

## References

- [QMD Search Guide](./qmd-search-guide.md)
- [Module Wiki Documentation](./module-wiki-documentation.md)
- [Component Documentation Best Practices](../concepts/)

---

**Last Updated**: 2026-04-29  
**Status**: Active  
**Related Stories**: Story 2.1 (QMD Search Integration)
