# 🧘 Folio + Volt Philosophy - Sixteen Theme

**Date**: 2026-03-30  
**Status**: 🔴 **CORRECTION NEEDED**  
**Philosophy**: File-based routing with Livewire Volt

---

## ❌ Current Implementation (WRONG)

**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```blade
{{-- ❌ WRONG: No Folio, No Volt, no middleware --}}
<x-pub_theme::layouts.app>
@php
    $pageName = $slug ?? 'homepage';
    // ... manual logic
@endphp
{{-- Content --}}
</x-pub_theme::layouts.app>
```

**Problems**:
- ❌ No `use function Laravel\Folio\name;`
- ❌ No `use function Laravel\Folio\middleware;`
- ❌ No Volt component (`new class extends Component`)
- ❌ No proper routing metadata
- ❌ Manual slug handling

---

## ✅ CORRECT Implementation (Folio + Volt)

**File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```blade
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

// Route name
name('tests.view');

// Middleware for slug handling
middleware(PageSlugMiddleware::class);

// Volt component
new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = [
            'slug' => $slug
        ];
    }
};
?>

{{-- Layout --}}
<x-layouts.app>
    @volt('tests.view')
    <div>
        {{-- Use CMS page system --}}
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## 🎯 Why This Philosophy? (The Zen)

### 1. File-Based Routing (Folio)

**Philosophy**: The file path IS the route

```
pages/tests/[slug].blade.php
    ↓
Route: /it/tests/{slug}
Name: tests.view
```

**No routes/*.php needed!**

### 2. Livewire Volt (Reactive Components)

**Philosophy**: Every page is a Livewire component

```php
new class extends Component {
    public function mount(string $slug): void
    {
        // Lifecycle hook
    }
};
```

**Benefits**:
- ✅ Reactive (auto-refresh on data change)
- ✅ Type-safe properties
- ✅ Lifecycle hooks (mount, hydrate, etc.)
- ✅ Consistent pattern

### 3. Middleware (PageSlugMiddleware)

**Philosophy**: Middleware handles slug validation

```php
middleware(PageSlugMiddleware::class);
```

**What it does**:
- ✅ Validates slug exists
- ✅ Loads page data from database
- ✅ Returns 404 if not found
- ✅ Sets locale from slug

### 4. CMS Integration (x-page)

**Philosophy**: Pages are content blocks from database

```blade
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

**How it works**:
- ✅ Loads page from `pages` table
- ✅ Renders blocks (header, footer, content)
- ✅ Uses sections system
- ✅ DRY: one component for all pages

---

## 📁 File Structure (DRY + KISS)

### Pages Directory

```
laravel/Themes/Sixteen/resources/views/pages/
├── tests/
│   └── [slug].blade.php          # Dynamic route: /it/tests/{slug}
├── [container0]/
│   ├── index.blade.php            # /{container0}
│   └── [slug0]/
│       └── index.blade.php        # /{container0}/{slug0}
├── auth/
│   ├── login.blade.php            # /auth/login
│   └── register.blade.php         # /auth/register
└── index.blade.php                # Homepage: /
```

### Route Resolution

| File Pattern | Route | Example |
|--------------|-------|---------|
| `index.blade.php` | `/` | Homepage |
| `[slug].blade.php` | `/{slug}` | `/argomenti` |
| `[container0]/index.blade.php` | `/{container0}` | `/tests` |
| `[container0]/[slug0]/index.blade.php` | `/{container0}/{slug0}` | `/tests/argomenti` |

---

## 🔄 Lifecycle Flow

```
Request: /it/tests/argomenti
    ↓
Folio: Match pages/tests/[slug].blade.php
    ↓
Middleware: PageSlugMiddleware
    ↓
Volt: mount($slug='argomenti')
    ↓
Component: $this->pageSlug = 'tests.argomenti'
    ↓
CMS: Load page from database (slug='tests.argomenti')
    ↓
Blocks: Render header, content, footer sections
    ↓
Response: HTML with Tailwind CSS
```

---

## 📊 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single file**: `[slug].blade.php` handles ALL test pages  
✅ **Single component**: `<x-page>` renders ALL pages  
✅ **Single middleware**: `PageSlugMiddleware` validates ALL slugs  
✅ **Single pattern**: Folio + Volt for ALL routes

### KISS (Keep It Simple, Stupid)

✅ **Simple routing**: File path = route  
✅ **Simple component**: Volt class with mount()  
✅ **Simple rendering**: `<x-page>` does everything  
✅ **Simple data**: Array passed to component

---

## 🧘 The Philosophy (Zen)

### 1. Convention Over Configuration

**Don't**:
```php
// routes/web.php
Route::get('/it/tests/{slug}', [TestController::class, 'show'])
    ->name('tests.view')
    ->middleware(PageSlugMiddleware::class);
```

**Do**:
```blade
// pages/tests/[slug].blade.php
name('tests.view');
middleware(PageSlugMiddleware::class);
```

**Why**: File IS the route. No config needed.

### 2. Reactive by Default

**Don't**:
```php
class TestController extends Controller {
    public function show($slug) {
        return view('tests.show', compact('slug'));
    }
}
```

**Do**:
```php
new class extends Component {
    public function mount(string $slug): void {
        $this->slug = $slug;
    }
};
```

**Why**: Every page is reactive Livewire.

### 3. Database-Driven Content

**Don't**:
```blade
{{-- Hardcoded HTML --}}
<div class="container">
    <h1>Argomenti</h1>
    <!-- Static content -->
</div>
```

**Do**:
```blade
{{-- Database content --}}
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

**Why**: Content from database, not hardcoded.

### 4. Sections System

**Don't**:
```blade
@include('partials.header')
@include('partials.footer')
```

**Do**:
```blade
<x-section slug="header" />
<x-section slug="footer" />
```

**Why**: Sections are content blocks from database.

---

## 🎯 Migration Steps

### Phase 1: Add Folio + Volt (2h)

```blade
<?php
declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;

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
```

### Phase 2: Use CMS Page System (2h)

```blade
<x-layouts.app>
    @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### Phase 3: Remove Manual Logic (1h)

**Remove**:
```blade
@php
    $pageName = $slug ?? 'homepage';
    $manifestPath = base_path('...');
    $htmlPath = base_path('...');
    // ... all manual logic
@endphp
```

**Replace with**:
```php
// Handled by PageSlugMiddleware + CMS
```

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Folio Docs** | `laravel/docs/folio/` |
| **Volt Docs** | `laravel/docs/volt/` |
| **CMS Pages** | `laravel/Modules/Cms/docs/` |
| **Sections** | `laravel/Themes/Sixteen/docs/sections/` |

---

## ✅ Checklist

### File Structure

- [x] `pages/tests/[slug].blade.php` exists
- [ ] Uses Folio (`name()`, `middleware()`)
- [ ] Uses Volt (`new class extends Component`)
- [ ] Uses CMS (`<x-page>`)
- [ ] Uses sections (`<x-section>`)

### Documentation

- [ ] This philosophy documented
- [ ] Examples in docs/
- [ ] Cross-references working
- [ ] DRY + KISS compliant

---

**Status**: 🔴 **NEEDS CORRECTION**  
**Next**: Update `pages/tests/[slug].blade.php` with Folio + Volt  
**Philosophy**: File-based routing + reactive components + database content

**The Zen of Folio + Volt! 🧘**
