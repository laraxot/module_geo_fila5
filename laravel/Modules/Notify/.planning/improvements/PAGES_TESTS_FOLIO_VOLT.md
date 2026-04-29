# ✅ Pages Tests - Folio + Volt Implementation

**Date**: 2026-03-30  
**Status**: ✅ **CORRECTED**  
**Philosophy**: File-based routing + Livewire Volt + CMS blocks

---

## 🎯 Implementation

### File: `pages/tests/[slug].blade.php`

```blade
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

// Route name
name('tests.view');

// Middleware for slug validation
middleware(PageSlugMiddleware::class);

// Volt component - reactive page
new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';

    /** @var array<string, mixed> */
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
        {{-- CMS page system --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## 🧘 Philosophy (The Zen)

### 1. File-Based Routing (Folio)

**The Path IS the Route**:
```
pages/tests/[slug].blade.php
    ↓
Route: /it/tests/{slug}
```

**No routes/*.php needed!**

### 2. Reactive Components (Volt)

**Every Page is Livewire**:
```php
new class extends Component {
    public function mount(string $slug): void {
        // Lifecycle hook
    }
};
```

**Benefits**:
- ✅ Reactive (auto-refresh)
- ✅ Type-safe
- ✅ Lifecycle hooks
- ✅ Consistent pattern

### 3. Middleware Validation

**Slug Validation**:
```php
middleware(PageSlugMiddleware::class);
```

**What it does**:
- ✅ Validates slug exists
- ✅ Loads page data
- ✅ Returns 404 if not found
- ✅ Sets locale

### 4. CMS Blocks

**Database Content**:
```blade
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

**How it works**:
- ✅ Loads from `pages` table
- ✅ Renders blocks (header, content, footer)
- ✅ Uses sections system
- ✅ DRY: one component for all

---

## 📊 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single file**: `[slug].blade.php` handles ALL test pages  
✅ **Single component**: `<x-page>` renders ALL pages  
✅ **Single middleware**: `PageSlugMiddleware` validates ALL slugs  
✅ **Single pattern**: Folio + Volt for ALL routes

### KISS (Keep It Simple, Stupid)

✅ **Simple routing**: File path = route  
✅ **Simple component**: Volt with mount()  
✅ **Simple rendering**: `<x-page>` does everything  
✅ **Simple data**: Array passed to component

---

## 🔄 Lifecycle Flow

```
Request: /it/tests/argomenti
    ↓
Folio: Match pages/tests/[slug].blade.php
    ↓
Middleware: PageSlugMiddleware validates slug
    ↓
Volt: mount($slug='argomenti')
    ↓
Component: $this->pageSlug = 'tests.argomenti'
    ↓
CMS: Load page from database (slug='tests.argomenti')
    ↓
Blocks: Render header, content, footer from database
    ↓
Response: HTML with Tailwind CSS
```

---

## 📁 File Structure

```
laravel/Themes/Sixteen/resources/views/pages/
├── tests/
│   └── [slug].blade.php          # ✅ Dynamic: /it/tests/{slug}
├── [container0]/
│   ├── index.blade.php            # /{container0}
│   └── [slug0]/
│       └── index.blade.php        # /{container0}/{slug0}
├── auth/
│   ├── login.blade.php            # /auth/login
│   └── register.blade.php         # /auth/register
└── index.blade.php                # Homepage: /
```

---

## 🎯 Route Examples

| File | Route | Example |
|------|-------|---------|
| `tests/[slug].blade.php` | `/it/tests/{slug}` | `/it/tests/argomenti` |
| `tests/index.blade.php` | `/it/tests` | `/it/tests` |
| `[container0]/index.blade.php` | `/{container0}` | `/predicts` |
| `[container0]/[slug0]/index.blade.php` | `/{container0}/{slug0}` | `/predicts/1` |

---

## ✅ Checklist

### Folio + Volt

- [x] `use function Laravel\Folio\name;`
- [x] `use function Laravel\Folio\middleware;`
- [x] `new class extends Component`
- [x] `public function mount(): void`
- [x] `@volt('component.name')`
- [x] `@endvolt`

### CMS Integration

- [x] `<x-page side="content" :slug="$pageSlug" :data="$data" />`
- [x] PageSlugMiddleware registered
- [x] Blocks loaded from database
- [x] Sections system used

### Documentation

- [x] Philosophy documented
- [x] Examples in docs/
- [x] Cross-references working
- [x] DRY + KISS compliant

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Folio Philosophy** | `.planning/improvements/FOLIO_VOLT_PHILOSOPHY.md` |
| **CMS Pages** | `laravel/Modules/Cms/docs/` |
| **Sections** | `laravel/Themes/Sixteen/docs/sections/` |
| **Tailwind** | `.planning/improvements/SIXTEEN_PURE_TAILWIND_MIGRATION.md` |

---

**Status**: ✅ **CORRECTED**  
**Pattern**: Folio + Volt + CMS  
**DRY + KISS**: Single file, reactive, database-driven

**The Zen of Folio + Volt! 🧘**
