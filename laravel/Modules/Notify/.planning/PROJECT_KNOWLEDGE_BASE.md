# 🧠 PROJECT KNOWLEDGE BASE - COMPLETE UPDATE

**Data**: 2026-03-30  
**Status**: ✅ CRITICAL KNOWLEDGE  
**Priority**: MAXIMUM

---

## 🎯 THEME DETECTION LOGIC

### Algorithm

```
APP_URL → Domain → Reverse → Config Path → Theme
```

### Step-by-Step

1. **Read APP_URL** from `.env`
   ```
   APP_URL=http://fixcity.local
   ```

2. **Extract Domain**
   ```bash
   # Remove protocol
   fixcity.local
   
   # Remove www. (if present)
   fixcity.local
   ```

3. **Reverse Explode**
   ```php
   $domain = 'fixcity.local';
   $parts = array_reverse(explode('.', $domain));
   // ['local', 'fixcity']
   ```

4. **Build Config Path**
   ```
   base_path('config/local/fixcity/xra.php')
   ```

5. **Read Theme**
   ```php
   // config/local/fixcity/xra.php
   return [
       'pub_theme' => 'Sixteen',  // ← THEME NAME
   ];
   ```

6. **Theme Folder**
   ```
   laravel/Themes/Sixteen/
   ```

---

## 📁 COMPOSER ARCHITECTURE

### Root composer.json (MINIMAL)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0"
    },
    "extra": {
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ]
        }
    }
}
```

### ⚠️ CRITICAL: Themes NOT in merge-plugin

**WHY**:
- Themes are **isolated**, live on their own
- Themes have **independent** build process
- Themes use **Vite** independently
- Modules share dependencies via merge
- Themes should NOT affect root dependencies

**CORRECT**:
```json
"merge-plugin": {
    "include": [
        "Modules/*/composer.json"  // ✅ Only modules
    ]
}
```

**WRONG**:
```json
"merge-plugin": {
    "include": [
        "Modules/*/composer.json",
        "Themes/*/composer.json"  // ❌ Themes isolated!
    ]
}
```

---

## 🎨 BLOCK NAMING CONVENTION

### Universal Pattern

```
pub_theme::components.blocks.<TYPE>.<VIEW>
```

### Examples

```blade
✅ CORRECT:
<x-pub_theme::components.blocks.hero.homepage />
<x-pub_theme::components.blocks.card.featured />
<x-pub_theme::components.blocks.topics.grid />

❌ WRONG:
<x-pub_theme::components.blocks.tests.argomenti.topics-grid />  <!-- tests.argomenti is not a type! -->
<x-pub_theme::components.blocks.fixcity.ticket-form />  <!-- fixcity is project-specific -->
```

### Block Types (Universal, Reusable)

| Type | Purpose | Views |
|------|---------|-------|
| `hero` | Hero sections | `homepage`, `landing`, `minimal` |
| `card` | Content cards | `basic`, `featured`, `event`, `article` |
| `topics` | Topic grids | `grid`, `list`, `featured` |
| `features` | Features list | `grid`, `list`, `alternating` |
| `cta` | Call-to-action | `simple`, `banner`, `form` |
| `content` | Text content | `single`, `multi-column` |
| `gallery` | Image galleries | `grid`, `carousel`, `masonry` |
| `form` | Forms | `contact`, `newsletter`, `booking` |
| `testimonial` | Testimonials | `single`, `grid`, `carousel` |
| `pricing` | Pricing tables | `single`, `comparison` |
| `faq` | FAQs | `accordion`, `list` |
| `team` | Team members | `grid`, `list` |
| `contact` | Contact info | `with-map`, `cards` |
| `footer` | Footers | `default`, `slim`, `multi-column` |
| `header` | Headers | `default`, `minimal`, `mega-menu` |
| `nav` | Navigation | `horizontal`, `vertical`, `breadcrumb` |

---

## 🏛️ SECTION SYSTEM

### Header & Footer are Sections

```blade
{{-- Header --}}
<x-section slug="header" />

{{-- Footer --}}
<x-section slug="footer" />

{{-- Footer Slim --}}
<x-section slug="footer" tpl="slim" />
```

### NOT Direct Component Calls

```blade
❌ WRONG:
<x-sixteen::blocks.navigation.header-main />
<x-pub_theme::components.footer.default />

✅ CORRECT:
<x-section slug="header" />
<x-section slug="footer" tpl="default" />
```

---

## 📄 CMS-DRIVEN PAGES

### JSON Configuration

**Path**: `laravel/config/local/fixcity/database/content/pages/`

**File**: `tests.argomenti.json`

```json
{
    "id": "tests.argomenti",
    "slug": "tests.argomenti",
    "title": {
        "it": "Argomenti",
        "en": "Topics"
    },
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.argomenti",
                    "title": "Argomenti"
                }
            },
            {
                "type": "topics",
                "data": {
                    "view": "pub_theme::components.blocks.topics.grid",
                    "items": [...]
                }
            }
        ]
    }
}
```

### Page Routing

```
URL: /it/tests/argomenti
↓
Folio Route: pages/tests/[slug].blade.php
↓
Volt Component: tests.view
↓
CMS Reads: config/local/fixcity/database/content/pages/tests.argomenti.json
↓
Renders Blocks: pub_theme::components.blocks.*
```

---

## 🎯 FOLIO + VOLT PATTERN

### Dynamic Slug Page

**File**: `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = ['slug' => $slug];
    }
};
?>

<x-layouts.app>
    @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### Index Page

**File**: `Themes/Sixteen/resources/views/pages/tests/index.blade.php`

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.index');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $pageSlug = '';
    public array $data = [];

    public function mount(): void
    {
        $this->pageSlug = 'tests.index';
        $this->data = [];
    }
};
?>

<x-layouts.app>
    @volt('tests.index')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## 🎨 ICON SYSTEM

### Filament 5 Way

```blade
{{-- Use Filament icon component --}}
<x-filament::icon 
    icon="heroicon-o-check-circle" 
    class="w-5 h-5 text-green-600" 
    aria-hidden="true" 
/>

{{-- Icon button --}}
<x-filament::icon-button 
    icon="heroicon-o-arrow-right" 
    label="Go" 
/>
```

### NOT

```blade
❌ <x-icon name="check" />  <!-- Deprecated -->
❌ <svg>...</svg>  <!-- Use Filament component -->
```

### SVG Icons Location

```
laravel/Modules/UI/resources/svg/brands/facebook.svg
↓
Register automatically
↓
Use: ui-brands.facebook
```

---

## 🏗️ VITE BUILD SYSTEM

### Theme Build Process

```bash
cd laravel/Themes/Sixteen

# Install dependencies
composer update -W  # Theme has its own composer.json
npm install

# Build assets
npm run build    # Compiles CSS/JS with Vite
npm run copy     # Copies to public/themes/Sixteen/
```

### Vite Manifest Error

**Error**: `Vite manifest not found at: public_html/themes/<theme>/manifest.json`

**Solution**:
```bash
cd laravel/Themes/<theme-name>
composer update -W
npm install
npm run build
npm run copy
```

### style-apply.css

**Location**: `Themes/Sixteen/Main_files/five/src/style-apply.css`

**Purpose**: Bootstrap Italia → Tailwind @apply conversion

**Key Features**:
- Uses `@apply` for Tailwind utilities
- Bootstrap Italia classes mapped to Tailwind
- Titillium Web font (official Design Comuni font)
- CSS custom properties for colors
- Responsive grid system

### app1.js

**Location**: `Themes/Sixteen/Main_files/five/src/app1.js`

**Purpose**: Alpine.js + Bootstrap Italia interactions

**Features**:
- Language dropdown (Alpine.js)
- Hamburger menu toggle
- Mobile navigation
- Overlay handling

---

## 📚 DOCUMENTATION RULES

### Agnostic Documentation

**Modules/Themes docs MUST be project-agnostic**

```markdown
✅ CORRECT:
# Pages Content Blocks
Use `[PROJECT_NAME]` as placeholder.

❌ WRONG:
# FixCity Pages Content Blocks
This is for FixCity platform.
```

### File Naming

```markdown
✅ CORRECT:
- `pages-content-blocks.md`
- `module-integration.md`

❌ WRONG:
- `fixcity-pages-content-blocks.md`
- `project-name-setup.md`
```

---

## 🎯 DESIGN COMUNI REPLICATION

### Target Pages

| Design Comuni URL | Our URL | Status |
|-------------------|---------|--------|
| `/sito/homepage.html` | `/it/tests/homepage` | 🟡 In Progress |
| `/sito/argomenti.html` | `/it/tests/argomenti` | 🟡 In Progress |
| `/sito/appuntamento-06-conferma.html` | `/it/tests/appuntamento-06-conferma` | 🟡 To Do |

### Strategy

1. **Study** Design Comuni HTML structure
2. **Replicate** using Tailwind @apply (NOT Bootstrap)
3. **Create** reusable blocks (NOT page-specific)
4. **Document** in docs/ folders (agnostic)
5. **Test** visual match with screenshots

### DO NOT

```blade
❌ Don't save raw HTML from Design Comuni
❌ Don't use <script src="bootstrap-italia.bundle.js">
❌ Don't create page-specific components
❌ Don't use Bootstrap (we use Tailwind)
```

### DO

```blade
✅ Use existing style-apply.css (Bootstrap → Tailwind)
✅ Use existing app1.js (Alpine interactions)
✅ Create universal block types
✅ Use <x-section slug="header" />
✅ Use <x-section slug="footer" />
✅ Use <x-filament::icon>
✅ Use CMS-driven JSON pages
```

---

## 🔗 GITHUB WORKFLOW

### Check Current Repo

```bash
cd laravel/Themes/Sixteen
git remote -v
```

### Create Issues

For each Design Comuni page:
1. Create GitHub Issue
2. Link to reference URL
3. Define block types needed
4. Mark as "Design Comuni Replication"

### Create Discussions

For architecture decisions:
1. Block type naming
2. Reusability patterns
3. Documentation structure

---

## 📊 DRY + KISS CHECKLIST

### Before Creating Anything

- [ ] Does this already exist?
- [ ] Can I reuse an existing block?
- [ ] Is this generic enough?
- [ ] Am I following conventions?
- [ ] Is documentation agnostic?

### File Structure

- [ ] No duplicate files
- [ ] Proper naming (kebab-case)
- [ ] In correct directory
- [ ] Documented in index.md

### Code Quality

- [ ] DRY (no repetition)
- [ ] KISS (keep it simple)
- [ ] SOLID principles
- [ ] Follows conventions

---

## 🧘 DEVELOPER MANTRAS

> *"La vista segue il tipo, come l'ombra segue la forma."*

> *"Bootstrap Italia design, Tailwind implementation."*

> *"Root composer.json minimale. Dipendenze nei moduli. Temi isolati."*

> *"Sempre Filament 5. Sempre <x-filament::icon>."*

> *"Documentazione agnostica. No project-specific names."*

> *"Blocchi universali, riutilizzabili, non specifici per pagina."*

> *"Git forward-only. Studiare il passato, migliorare il futuro."*

---

## 📖 REFERENCES

### Internal
- `laravel/Themes/Sixteen/Main_files/five/src/style-apply.css`
- `laravel/Themes/Sixteen/Main_files/five/src/app1.js`
- `laravel/config/local/fixcity/xra.php`
- `laravel/.env`

### External
- [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/)
- [Flowbite Blocks](https://flowbite.com/blocks/)
- [Tailwind Plus UI](https://tailwindcss.com/plus/ui-blocks)
- [DaisyUI](https://daisyui.com/components/)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)
- [Filament 5 Docs](https://filamentphp.com/docs/5.x)

---

**Status**: ✅ KNOWLEDGE BASE COMPLETE  
**Next**: Apply to all documentation, create GitHub issues
