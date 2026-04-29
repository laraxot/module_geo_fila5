# Design Comuni Replication - Multi-Agent Plan

## Project Status
**Theme**: Sixteen (pub_theme configuration)  
**Repository**: laraxot/base_fixcity_fila5  
**Base URL**: http://fixcity.local  
**Config Path**: local/fixcity  

## Critical Issues Identified

### 1. ✅ FIXED: Folio Route Pattern
**Problem**: Multiple specific blade files (homepage.blade.php, amministrazione.blade.php, etc.)  
**Solution**: Single `[slug].blade.php` with dynamic loading  
**Status**: ✅ COMPLETED  
**Files Fixed**:
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- `laravel/Themes/Sixteen/resources/views/pages/tests/index.blade.php`

### 2. ⚠️ IN PROGRESS: Header/Footer HTML Structure
**Problem**: Header and footer don't match Design Comuni HTML structure  
**Current**: Uses `<x-bootstrap-italia.header />` component  
**Required**: Pure Tailwind + Alpine implementation matching:
```html
<header class="it-header-wrapper">
  <div class="it-header-slim-wrapper">
    ...
  </div>
  ...
</header>
```

**Solution Path**:
1. Audit current header implementation
2. Compare with https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
3. Create screenshot comparisons
4. Implement Tailwind @apply in style-apply.css
5. Test all header variants (slim, main, navbar)

### 3. ⚠️ IN PROGRESS: Block Type Organization
**Problem**: Some JSON files reference incorrect view paths  
**Correct Pattern**: `pub_theme::components.blocks.<type>.<variant>`  
**Examples**:
- ✅ `pub_theme::components.blocks.hero.homepage`
- ✅ `pub_theme::components.blocks.topics.grid`
- ❌ `pub_theme::components.blocks.tests.argomenti.topics-grid` (tests.argomenti is NOT a type)

**Block Types** (from Flowbite, Tailwind UI, DaisyUI):
- `hero` - Hero sections
- `topics` - Topic/topic cards
- `events` - Event listings
- `news` - News cards
- `services` - Service cards
- `governance` - Government/people cards
- `feedback` - Rating/feedback forms
- `contact` - Contact information
- `links` - Link lists
- `navigation` - Headers, footers, breadcrumbs
- `forms` - Form elements
- `cards` - Generic cards
- `content` - Content sections

### 4. ⚠️ IN PROGRESS: Vite Configuration
**Problem**: Assets not loading correctly  
**Correct Pattern**:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Sixteen')
```
**Status**: ✅ FIXED in layout

### 5. ⚠️ IN PROGRESS: Bootstrap Italia → Tailwind
**Problem**: Relying on Bootstrap Italia CDN  
**Solution**: Use Tailwind @apply in `style-apply.css`  
**Reference File**: `laravel/Themes/Sixteen/Main_files/five/src/style-apply.css`

**Build Process**:
```bash
cd laravel/Themes/Sixteen
composer update -W
npm install
npm run build
npm run copy
```

## Architecture Overview

### Component System
```
Sections (called with <x-section>):
├── header → components/sections/header.blade.php
│   └── Renders: components/blocks/header/main.blade.php
├── footer → components/sections/footer.blade.php
│   ├── tpl="full" → components/blocks/footer/full.blade.php
│   └── tpl="slim" → components/blocks/footer/slim.blade.php

Blocks (reusable, organized by type):
├── components/blocks/
│   ├── hero/
│   │   ├── homepage.blade.php
│   │   └── default.blade.php
│   ├── topics/
│   │   ├── grid.blade.php
│   │   ├── featured.blade.php
│   │   └── highlight.blade.php
│   ├── events/
│   │   └── calendar.blade.php
│   ├── news/
│   │   └── cards/
│   ├── governance/
│   │   └── cards.blade.php
│   ├── feedback/
│   │   └── rating.blade.php
│   ├── contact/
│   │   └── info.blade.php
│   ├── links/
│   │   └── useful.blade.php
│   ├── navigation/
│   │   ├── header/
│   │   ├── footer/
│   │   └── breadcrumbs/
│   └── forms/
```

### JSON Content Structure
```json
{
  "slug": "tests.homepage",
  "title": "Homepage",
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "data": {
          "view": "pub_theme::components.blocks.hero.homepage",
          "title": "Nome del Comune",
          "subtitle": "Contenuti in evidenza"
        }
      }
    ]
  }
}
```

### Page Rendering Flow
```
1. Request: /it/tests/homepage
2. Folio Route: pages/tests/[slug].blade.php
3. Mount: $slug = 'homepage', $pageSlug = 'tests.homepage'
4. Load JSON: config/local/fixcity/database/content/pages/tests.homepage.json
5. Render:
   - <x-section slug="header" />
   - <x-page side="content" :slug="$pageSlug" :data="$data" />
     → Loops through content_blocks
     → @includeIf($block['data']['view'])
   - <x-section slug="footer" tpl="full" />
```

## Multi-Agent Coordination

### Agent Roles
1. **Documentation Agent**: Update all docs folders
2. **Frontend Agent**: Implement Tailwind components
3. **Backend Agent**: Fix JSON structures and routes
4. **QA Agent**: Screenshot comparisons and validation
5. **Integration Agent**: Ensure all pieces work together

### Communication Protocol
- Check GitHub Issues before starting work
- Update coordination log after each task
- Small commits with frequent pushes
- Document all decisions in docs/

## Documentation Updates Required

### Module Docs
- [ ] Update `Modules/Cms/docs/` with page rendering flow
- [ ] Document JSON content block structure
- [ ] Add block type reference guide

### Theme Docs
- [ ] Update `Themes/Sixteen/docs/` with component architecture
- [ ] Document Tailwind @apply patterns
- [ ] Create block development guide
- [ ] Screenshot comparisons with analysis

### AI Rules & Memories
- [ ] Update `.qwen/rules/` with component naming conventions
- [ ] Document Folio + Volt patterns
- [ ] Add DRY + KISS guidelines
- [ ] Create troubleshooting guides

## Success Metrics

### Visual Accuracy
- [ ] Header matches Design Comuni 100%
- [ ] Footer matches Design Comuni 100%
- [ ] All pages pass screenshot comparison
- [ ] Responsive design works on all breakpoints

### Technical Accuracy
- [ ] HTML inside `<body>` matches template
- [ ] No Bootstrap Italia CDN dependencies
- [ ] All blocks use correct type.variant pattern
- [ ] JSON files properly structured
- [ ] Vite assets load correctly

### Documentation Quality
- [ ] All blocks documented with examples
- [ ] Screenshot comparisons with analysis
- [ ] Troubleshooting guides complete
- [ ] Index files for navigation
- [ ] DRY + KISS compliance verified

## Next Steps

### Immediate (This Session)
1. ✅ Fix [slug].blade.php pattern
2. ✅ Fix index.blade.php pattern
3. ⚠️ Fix header HTML structure
4. ⚠️ Fix footer HTML structure
5. ⚠️ Create screenshot comparisons
6. ⚠️ Update documentation

### Short Term (Next Session)
1. Create all missing JSON files
2. Implement missing block types
3. Complete Tailwind @apply styles
4. Test all pages end-to-end

### Long Term
1. Install UI/UX Pro Max skill
2. Configure NotebookLM MCP
3. Create comprehensive block library
4. Document all components

## References

### Design Resources
- Design Comuni: https://italia.github.io/design-comuni-pagine-statiche/
- Bootstrap Italia: https://italia.github.io/bootstrap-italia/
- Flowbite Blocks: https://flowbite.com/blocks/
- Tailwind UI: https://tailwindcss.com/plus/ui-blocks
- DaisyUI: https://daisyui.com/components/

### Technical Resources
- Laravel Folio: https://laravel.com/docs/11.x/folio
- Livewire Volt: https://laravel.com/docs/11.x/volt
- Filament v5: https://filamentphp.com/docs/5.x
- Tailwind CSS v4: https://tailwindcss.com/docs

### Multi-Agent Resources
- BMAD Method: https://github.com/bmad-code-org/BMAD-METHOD
- GSD: https://github.com/gsd-build/get-shit-done
- Ralph Loop: https://github.com/snarktank/ralph
- OpenViking: https://github.com/volcengine/OpenViking
