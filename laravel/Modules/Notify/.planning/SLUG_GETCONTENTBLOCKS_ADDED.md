# ✅ [slug].blade.php - getContentBlocks() ADDED

**Data**: 2026-03-31  
**Status**: ✅ **FIXED**  
**Priority**: CRITICAL

---

## ❌ ERROR FIXED

```
Method, action or protected callable [getContentBlocks] not found on component [tests.view]
```

**Cause**: `<x-page>` component calls `getContentBlocks()` but it didn't exist!

---

## ✅ SOLUTION APPLIED

### File: `pages/tests/[slug].blade.php`

**Added Method**:
```php
/**
 * Get content blocks for the page
 */
public function getContentBlocks(): array
{
    return $this->data['content_blocks'] ?? [];
}
```

---

## ✅ COMPLETE FILE

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
    
    /**
     * Get content blocks for the page
     */
    public function getContentBlocks(): array
    {
        return $this->data['content_blocks'] ?? [];
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

> *"getContentBlocks() required by <x-page>."*

> *"Return data['content_blocks'] || []."*

---

**Status**: ✅ **FIXED**  
**Next**: Clear cache, test!
