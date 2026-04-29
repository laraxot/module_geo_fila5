# ✅ [slug].blade.php - CORRECTED TO USE <x-layouts.app>

**Data**: 2026-03-31  
**Status**: ✅ **FIXED**  
**Priority**: CRITICAL

---

## ❌ ERROR FIXED

**File**: `pages/tests/[slug].blade.php`

**BEFORE (WRONG)**:
```blade
<x-pub_theme::layouts.design-comuni>
 @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-pub_theme::layouts.design-comuni>
```

**AFTER (CORRECT)**:
```blade
<x-layouts.app>
 @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## ✅ CORRECT STRUCTURE

### File: `pages/tests/[slug].blade.php`

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

---

## 🧘 MANTRAS

> *"Use <x-layouts.app>. NOT <x-pub_theme::...>"*

> *"Keep it simple. Use correct component."*

---

**Status**: ✅ **CORRECTED**  
**Next**: Clear cache, test!
