# 🧘 The Zen of Folio + Volt Pages

**Date**: 2026-03-30  
**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: File-based routing + Reactive components + JSON blocks

---

## 🎯 The Philosophy (The Zen)

### Core Principle: Convention Over Configuration

**WRONG** ❌:
```blade
{{-- 38 separate files --}}
pages/tests/argomenti.blade.php
pages/tests/appuntamento-06-conferma.blade.php
pages/tests/homepage.blade.php
// Violates DRY!
```

**CORRECT** ✅:
```blade
{{-- Single file handles ALL 38 pages --}}
pages/tests/[slug].blade.php
// DRY + KISS!
```

**Why?**
- ✅ **DRY**: Single file for all pages
- ✅ **KISS**: Simple pattern
- ✅ **Folio**: File path = route
- ✅ **Volt**: Reactive Livewire
- ✅ **CMS**: JSON blocks from database

---

## 📁 File Structure

### Pages Directory

```
laravel/Themes/Sixteen/resources/views/pages/
├── tests/
│   ├── [slug].blade.php          ✅ Dynamic: /it/tests/{slug}
│   └── index.blade.php            ✅ Index: /it/tests
├── [container0]/
│   ├── index.blade.php            ✅ /{container0}
│   └── [slug0]/
│       └── index.blade.php        ✅ /{container0}/{slug0}
└── index.blade.php                ✅ Homepage: /
```

### Route Mapping

| File | Route | Example |
|------|-------|---------|
| `tests/[slug].blade.php` | `/it/tests/{slug}` | `/it/tests/argomenti` |
| `tests/index.blade.php` | `/it/tests` | `/it/tests` |
| `[container0]/index.blade.php` | `/{container0}` | `/predicts` |
| `[container0]/[slug0]/index.blade.php` | `/{container0}/{slug0}` | `/predicts/1` |

---

## 🔄 The Flow

### Request: `/it/tests/argomenti`

```
1. Folio Routing
   Matches: pages/tests/[slug].blade.php
   Parameter: slug = 'argomenti'
   ↓
2. Volt Component
   mount(string $slug)
   ↓
3. Middleware
   PageSlugMiddleware validates slug
   ↓
4. Component State
   $this->slug = 'argomenti'
   $this->pageSlug = 'tests.argomenti'
   $this->data = ['slug' => 'argomenti']
   ↓
5. Page Component
   <x-page side="content" :slug="$pageSlug" :data="$data" />
   ↓
6. BlockData
   Loads JSON: tests.argomenti.json
   ↓
7. JSON File
   laravel/config/local/fixcity/database/content/pages/tests.argomenti.json
   ↓
8. Blocks
   hero, search, topics_grid, info
   ↓
9. Blade Views
   components/blocks/hero/hero.blade.php
   components/blocks/search/search.blade.php
   components/blocks/topics_grid/topics_grid.blade.php
   components/blocks/info/info.blade.php
   ↓
10. HTML Output
    Browser renders complete page
```

---

## 📄 Complete Implementation

### 1. Dynamic Page: `tests/[slug].blade.php`

```php
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

// Route name
name('tests.view');

// Middleware validates slug and loads page
middleware(PageSlugMiddleware::class);

// Volt reactive component
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
        {{-- Renders blocks from JSON --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### 2. Index Page: `tests/index.blade.php`

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

### 3. JSON File: `tests.argomenti.json`

```json
{
    "id": "tests.argomenti",
    "title": {
        "it": "Argomenti",
        "en": "Topics"
    },
    "slug": "tests.argomenti",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Esplora tutti gli argomenti",
                    "subtitle": "Naviga per categoria"
                }
            },
            {
                "type": "search",
                "data": {
                    "placeholder": "Cerca argomento...",
                    "live": true
                }
            },
            {
                "type": "topics_grid",
                "data": {
                    "title": "Tutti gli argomenti",
                    "topics": [...]
                }
            },
            {
                "type": "info",
                "data": {
                    "title": "Non trovi quello che cerchi?",
                    "content": "<p>Usa la ricerca o contatta l'URPG.</p>"
                }
            }
        ]
    }
}
```

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single file**: `[slug].blade.php` handles ALL 38 pages  
✅ **Single component**: `<x-page>` renders ALL pages  
✅ **Single middleware**: `PageSlugMiddleware` validates ALL slugs  
✅ **Single pattern**: Folio + Volt for ALL routes

### KISS (Keep It Simple, Stupid)

✅ **Simple routing**: File path = route  
✅ **Simple component**: Volt class with mount()  
✅ **Simple rendering**: `<x-page>` does everything  
✅ **Simple data**: Array passed to component

---

## 📊 Comparison

### Before (WRONG)

```
pages/tests/
├── argomenti.blade.php          ❌ Duplicate code
├── appuntamento-06-conferma.blade.php  ❌ Duplicate code
├── homepage.blade.php           ❌ Duplicate code
└── ... (35 more files)          ❌ Violates DRY!
```

**Problems**:
- ❌ 38 files with same code
- ❌ Hard to maintain
- ❌ Changes in 38 places
- ❌ Not scalable

### After (CORRECT)

```
pages/tests/
├── [slug].blade.php             ✅ Single file
└── index.blade.php              ✅ Index page
```

**Benefits**:
- ✅ 1 file for all pages
- ✅ Easy to maintain
- ✅ Changes in 1 place
- ✅ Scalable

---

## 🔄 Multi-Agent Collaboration

### Agent A (Frontend Specialist)
- [ ] Create `[slug].blade.php`
- [ ] Create `index.blade.php`
- [ ] Configure Folio routing
- **ETA**: 1h

### Agent B (Backend Developer)
- [ ] Create `PageSlugMiddleware`
- [ ] Configure JSON loading
- [ ] Test block rendering
- **ETA**: 2h

### Agent C (QA Specialist)
- [ ] Test all 38 pages
- [ ] Verify routing
- [ ] Check middleware
- **ETA**: 2h

### Agent D (Documentation)
- [ ] Document philosophy
- [ ] Create usage guide
- [ ] Update OpenViking
- **ETA**: 1h

**Total ETA**: 6h (parallel work)

---

## ✅ Checklist

### Files Created
- [x] `pages/tests/[slug].blade.php`
- [x] `pages/tests/index.blade.php`
- [ ] `pages/[container0]/index.blade.php`
- [ ] `pages/[container0]/[slug0]/index.blade.php`

### Configuration
- [x] Folio routing configured
- [x] Volt components created
- [x] Middleware registered
- [ ] All JSON files valid

### Testing
- [ ] Test `/it/tests/argomenti`
- [ ] Test `/it/tests/appuntamento-06-conferma`
- [ ] Test `/it/tests/homepage`
- [ ] Test all 38 pages

### Documentation
- [x] Philosophy documented
- [x] Examples provided
- [x] OpenViking updated

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Block Taxonomy** | `.planning/improvements/BLOCK_TAXONOMY_COMPLETE.md` |
| **Block View Convention** | `docs/blocks/view-naming-philosophy.md` |
| **JSON Block System** | `docs/blocks/json-block-system.md` |
| **Folio Documentation** | `laravel/docs/folio.md` |
| **Volt Documentation** | `laravel/docs/volt.md` |

---

**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: `[slug].blade.php` for ALL pages  
**DRY + KISS**: Single file, simple convention  
**Next**: Test all 38 pages

**The Zen of Folio + Volt Pages! 🧘**
