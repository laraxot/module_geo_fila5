# Design Comuni Codebase Exploration

**Analysis Date:** 2026-04-07
**Focus:** Homepage visual parity, CMS architecture, theme structure, build pipeline

---

## 1. CMS Module Page Component Architecture

### How Pages Work

The system uses a **CMS-driven page** architecture where content is defined in JSON files and rendered through Blade components.

### Request Flow

```
GET /it/tests/homepage
  → Laravel Folio: pages/tests/[slug].blade.php
  → PageSlugMiddleware
  → $pageSlug = 'tests.homepage'
  → <x-page side="content" slug="tests.homepage" :data="$data" />
    → Modules/Cms/View/Components/Page.php
      → PageModel::getBlocksBySlug('tests.homepage', 'content')
      → Loads JSON: config/local/fixcity/database/content/pages/tests.homepage.json
      → Creates BlockData objects for each block
    → renders: cms::components.page view
      → Theme's components/page.blade.php
        → Loops blocks, @include($block->view, $block->data)
          → Each block view: pub_theme::components.blocks.* 
```

### Key Files

| File | Purpose |
|------|---------|
| `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` | Folio entry point for `/it/tests/*` routes |
| `Modules/Cms/View/Components/Page.php` | CMS page component - loads blocks from JSON |
| `Modules/Cms/Datas/BlockData.php` | Data object for each content block |
| `Themes/Sixteen/resources/views/components/page.blade.php` | Theme's page renderer - loops blocks |
| `config/local/fixcity/database/content/pages/tests.homepage.json` | Homepage content data |

### BlockData Structure

Each block in the JSON has:
- `id` - Unique identifier
- `type` - Block type (e.g., `hero-homepage`, `governance-calendario`)
- `weight` - Sort order
- `active` - Whether to render
- `data.view` - Blade view path (e.g., `pub_theme::components.blocks.hero.homepage`)
- `data.*` - Block-specific content data

### Page Component (`components/page.blade.php`)

```blade
@foreach ($blocks as $block)
    @if ($block->active)
        @include($block->view, array_merge($data, $block->data, ['data' => $block->data]))
    @endif
@endforeach
```

Simple: loops active blocks, includes their views with merged data.

---

## 2. Theme Structure (Sixteen)

### Directory Layout

```
laravel/Themes/Sixteen/
├── resources/
│   ├── css/                          # 24 CSS files
│   │   ├── app.css                   # Entry point (2512 lines)
│   │   ├── tailwind-bootstrap-mapping.css  # Bootstrap→Tailwind mappings (739 lines)
│   │   ├── style-apply.css           # Bootstrap Italia @apply rules
│   │   ├── components/               # Component-specific CSS
│   │   │   ├── header-footer-colors.css
│   │   │   ├── bootstrap-italia-classes.css
│   │   │   ├── design-comuni.css
│   │   │   └── ...
│   │   └── overrides/                # Page-specific overrides
│   │       └── homepage-parity.css
│   │
│   ├── js/
│   │   ├── app.js                    # Entry point - Alpine.js components
│   │   └── components/
│   │       ├── dropdown.js           # Dropdown toggle
│   │       ├── modal.js              # Modal dialog
│   │       ├── mobile-menu.js        # Responsive menu
│   │       └── carousel.js           # Splide carousel
│   │
│   └── views/
│       ├── pages/tests/
│       │   ├── [slug].blade.php      # Dynamic page handler
│       │   └── index.blade.php
│       ├── components/
│       │   ├── blocks/               # 79 block types
│       │   │   ├── hero/
│       │   │   ├── governance/
│       │   │   ├── topics/
│       │   │   ├── search/
│       │   │   ├── feedback/
│       │   │   ├── contact/
│       │   │   └── ...
│       │   ├── page.blade.php        # Page renderer
│       │   └── ...
│       ├── layouts/
│       └── design-comuni/pages/
│
├── layouts/
│   └── app.blade.php                 # Main layout (uses Bootstrap Italia CDN!)
│
├── components/
│   ├── header-comune.blade.php
│   └── footer-comune.blade.php
│
├── pages/comune/
│   └── homepage.blade.php            # OLD homepage (not used for tests)
│
├── vite.config.js                    # Build config
├── tailwind.config.js                # Tailwind config
├── package.json                      # Dependencies
└── docs/                             # 318+ documentation files
```

### Important Distinction: Two Homepages

1. **OLD Homepage** (`pages/comune/homepage.blade.php`):
   - Extends `sixteen::layouts.app`
   - Hardcoded Bootstrap Italia cards
   - Uses CDN Bootstrap Italia CSS + JS
   - NOT the Design Comuni parity page

2. **TEST Homepage** (`pages/tests/[slug].blade.php`):
   - Uses `<x-layouts.app>` (theme layout)
   - CMS-driven from JSON content
   - Uses Vite-built CSS (Tailwind + Bootstrap mappings)
   - Alpine.js for interactivity
   - **This is the Design Comuni parity page**

### Layout Architecture

The main layout `layouts/app.blade.php` currently uses **Bootstrap Italia CDN**:
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/js/bootstrap-italia.bundle.min.js"></script>
```

But the CSS build (`app.css`) converts Bootstrap classes to Tailwind via `@apply`. The CDN is a fallback.

---

## 3. How [slug].blade.php Renders JSON Content

### The Folio Page (`pages/tests/[slug].blade.php`)

```php
name('tests.view');
middleware(PageSlugMiddleware::class);

$pageSlug = 'tests.'.$slug;  // e.g., "tests.homepage"

<x-layouts.app>
    <x-page side="content" :slug="$pageSlug" :data="$data" />
</x-layouts.app>
```

### The CMS Page Component (`Modules/Cms/View/Components/Page.php`)

```php
// Constructor resolves blocks
$this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
// Loads JSON → creates BlockData[] collection

// Render
return view('cms::components.page', [
    'blocks' => $this->blocks,
    'side' => $this->side,
    'slug' => $this->slug,
]);
```

### The Theme Page Renderer (`components/page.blade.php`)

```blade
@foreach ($blocks as $block)
    @if ($block->active)
        @include($block->view, array_merge($data, $block->data))
    @endif
@endforeach
```

### JSON Content Example (`tests.homepage.json`)

The homepage JSON defines 8+ blocks:
1. **hero-homepage** → `pub_theme::components.blocks.hero.homepage`
2. **governance-calendario** → `pub_theme::components.blocks.governance.cards`
3. **topics-highlight** → `pub_theme::components.blocks.topics.highlight`
4. **useful-links** → `pub_theme::components.blocks.search.support-links`
5. **feedback-rating** → `pub_theme::components.blocks.feedback.rating`
6. **contacts-homepage** → `pub_theme::components.blocks.contact.homepage`
7. **services-homepage** → `pub_theme::components.blocks.services.homepage` (inactive)
8. **administration-homepage** → `pub_theme::components.blocks.administration.homepage` (inactive)

Each block's `data` object contains all content needed for rendering.

---

## 4. CSS/JS Build Setup

### Vite Configuration (`vite.config.js`)

```js
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [...refreshPaths, 'app/Livewire/**'],
        }),
        tailwindcss(),
    ],
    build: {
        outDir: './public',           // Build to local public/
        emptyOutDir: true,
        manifest: 'manifest.json',
        // ... chunk/asset naming
    },
});
```

### Package.json Scripts

```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build",
        "copy": "cp -rv ./public/. ../../../public_html/themes/Sixteen/ ...",
        "copy:filament": "cp -r ./public/* ../../../public_html/themes/Sixteen/"
    }
}
```

### Build Pipeline

```
1. npm run build
   → Vite compiles resources/css/app.css → public/build/assets/app-*.css
   → Vite compiles resources/js/app.js → public/build/assets/app-*.js
   → Generates public/manifest.json

2. npm run copy
   → Copies public/ → public_html/themes/Sixteen/
   → Copies SVG sprites and images from node_modules/Main_files
```

### CSS Architecture (`app.css` - 2512 lines)

```css
/* 1. Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:...');

/* 2. Tailwind Layers */
@tailwind base;
@tailwind components;
@tailwind utilities;

/* 3. Bootstrap Italia mappings */
@import './style-apply.css';
@import "./container-override.css";
@import "./footer-override.css";
@import "./bootstrap-italia.css";

/* 4. Design Comuni components */
@import './components/header-footer-colors.css';
@import './components/bootstrap-italia-classes.css';
@import './components/design-comuni.css';
@import './design-comuni-visual-fix.css';
@import './design-comuni-global.css';

/* 5. Page-specific parity fixes */
@import './faq-parity.css';
@import './argomenti-parity.css';
@import './homepage-visual-fix.css';
@import './listing-parity.css';
@import './servizi-parity-fix.css';
@import './amministrazione-parity-fix.css';

/* 6. :root variables and global overrides */
:root { --dc-green: #007a52; ... }

/* 7. Component-specific overrides (2000+ more lines) */
```

### Key CSS Files

| File | Purpose |
|------|---------|
| `tailwind-bootstrap-mapping.css` | 739 lines of Bootstrap→Tailwind @apply mappings |
| `style-apply.css` | Bootstrap Italia component styles via @apply |
| `homepage-visual-fix.css` | Homepage-specific visual adjustments |
| `design-comuni-visual-fix.css` | Global Design Comuni visual fixes |
| `components/bootstrap-italia-classes.css` | Bootstrap class equivalents |

### JavaScript Architecture (`app.js`)

```js
import Alpine from 'alpinejs';
import { dropdownToggle } from './components/dropdown';
import { modal } from './components/modal';
import { mobileMenu } from './components/mobile-menu';
import { governanceCarousel } from './components/carousel';

window.Alpine = Alpine;
Alpine.data('dropdownToggle', dropdownToggle);
Alpine.data('modal', modal);
Alpine.data('mobileMenu', mobileMenu);
Alpine.data('governanceCarousel', governanceCarousel);
Alpine.start();

// Plus vanilla JS for:
// - Modal open/close via data-bs-* attributes
// - Dropdown toggles
// - Navbar collapsible
// - FAQ search
// - Test page body classes
// - Image fallbacks
// - Active nav link management
```

### Dependencies

**Production:**
- `alpinejs` ^3.15.9 - Reactivity
- `bootstrap-italia` ^2.18.0 - NOT imported in CSS, but SVG sprites used
- `@popperjs/core` ^2.11.8 - Tooltip positioning
- `leaflet` ^1.9.4 - Maps
- `chart.js` ^4.5.1 - Charts
- `swiper` ^11.1.10 - Carousel (but Splide also used)

**Build:**
- `tailwindcss` ^4.1.13
- `@tailwindcss/vite` ^4.1.13
- `vite` ^7.0.7
- `laravel-vite-plugin` ^2.0.0

---

## 5. Existing Documentation About Visual Replication

### Master Documentation

| Document | Location | Purpose |
|----------|----------|---------|
| `00-HOMEPAGE-REPLICATION-INDEX.md` | `Themes/Sixteen/docs/` | Master index for homepage project |
| `00-IMPLEMENTATION-STATUS.md` | `Themes/Sixteen/docs/` | Current status, what works, next steps |
| `00-CSS-JS-VISUAL-FIX-PLAN.md` | `Themes/Sixteen/docs/` | Implementation strategy |
| `ALPINE-JS-COMPONENTS.md` | `Themes/Sixteen/docs/` | Alpine.js component docs |
| `CSS-MAPPING-ANALYSIS-REPORT.md` | `Themes/Sixteen/docs/` | Unmapped Bootstrap classes |

### Design Comuni Workspace

| Document | Location | Purpose |
|----------|----------|---------|
| `design-comuni/00-index.md` | `Themes/Sixteen/docs/` | Design Comuni workspace index |
| `design-comuni/ALL_PAGES_ANALYSIS.md` | `Themes/Sixteen/docs/` | 54-page analysis |
| `design-comuni/PROGRESS_REPORT.md` | `Themes/Sixteen/docs/` | Progress: 63% OK (34/54 pages) |
| `design-comuni/work-plan.md` | `Themes/Sixteen/docs/` | BMAD+GSD work plan |
| `design-comuni/bmad-gsd-status-2026-04-03.md` | `Themes/Sixteen/docs/` | Latest loop status |

### CMS Module Docs

| Document | Location | Purpose |
|----------|----------|---------|
| `design-comuni-homepage.md` | `Modules/Cms/docs/` | CMS coordination for homepage parity |
| `architecture/homepage-structure.md` | `Modules/Cms/docs/` | Runtime architecture flow |

### Visual Comparison Reports

- `visual-comparison/homepage-visual-report-2026-04-03.md`
- `VISUAL-PARITY-STATUS-2026-04-03.md`
- `FINAL-VISUAL-PARITY-REPORT.md`
- `screenshots/` folder with reference + local screenshots

---

## 6. Current Status Summary

### What's Working
- ✅ HTML structure: 99.8% parity with reference
- ✅ CSS mapping: 219+/299 Bootstrap classes (73%)
- ✅ Build pipeline: Tailwind 4 + Vite 7 working
- ✅ Zero Bootstrap Italia CSS imports in build
- ✅ Alpine.js components: dropdown, modal, mobile-menu, carousel
- ✅ 34/54 pages pass structural parity (≥70%)

### Architecture Decisions
- **CMS drives content** - JSON files define blocks and data
- **Theme drives presentation** - CSS/JS handle visual parity
- **Blade templates are thin** - `<x-page>` component delegates to block views
- **Bootstrap classes kept in HTML** - mapped to Tailwind via `@apply` (no HTML changes needed)

### Key Insight for Visual Work

Per the documented architecture:
> "Se il problema e' visivo, lavorare nel tema e documentare i risultati anche qui."
> "Se la differenza riguarda la **resa visiva**, lavorare in `Themes/Sixteen/resources/css/app.css`"

**Visual changes should go in:**
1. `resources/css/app.css` - for global fixes
2. `resources/css/homepage-visual-fix.css` - for homepage-specific
3. `resources/css/components/*` - for component-level
4. `resources/js/app.js` - for interactivity

**DO NOT change:**
- Blade templates (HTML is already 99.8% identical)
- JSON content files (unless structure is wrong)
- Bootstrap Italia CDN imports

---

*Analysis date: 2026-04-07*