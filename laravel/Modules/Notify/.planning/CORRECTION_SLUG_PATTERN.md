# 🚫 CORRECTION: Using [slug].blade.php Pattern

**Data**: 2026-03-31  
**Status**: ✅ **CORRECTED**  
**Priority**: CRITICAL

---

## ❌ ERROR MADE

Created `homepage.blade.php` as specific file:
```
pages/tests/homepage.blade.php  ❌ WRONG!
```

**WHY IT'S WRONG**:
- ❌ Violates CMS-driven architecture
- ❌ Breaks DRY principle
- ❌ Hardcoded pages
- ❌ Not scalable

---

## ✅ CORRECT PATTERN

### Single Dynamic File

```
pages/tests/[slug].blade.php  ← ONLY THIS!
```

**Correct Code**:
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

## 🧩 HOW IT WORKS

### Dynamic Routing

```
/it/tests/homepage
  ↓
[slug].blade.php (mount slug='homepage')
  ↓
pageSlug = 'tests.homepage'
  ↓
CMS reads: tests.homepage.json
  ↓
Renders blocks from JSON
```

### All Pages Use Same File

| URL | Slug | JSON Config |
|-----|------|-------------|
| `/it/tests/homepage` | `homepage` | `tests.homepage.json` |
| `/it/tests/argomenti` | `argomenti` | `tests.argomenti.json` |
| `/it/tests/notizia` | `notizia` | `tests.notizia.json` |
| `/it/tests/evento` | `evento` | `tests.evento.json` |

---

## 🔧 CORRECTION APPLIED

### Files Removed
- ❌ `pages/tests/homepage.blade.php` → DELETED

### Files Corrected
- ✅ `pages/tests/[slug].blade.php` → CORRECTED

---

## 🧘 DEVELOPER MANTRAS

> *"UNO [slug].blade.php per TUTTE le pagine."*

> *"MAI file specifici. SEMPRE dinamico."*

> *"JSON per contenuti. Blade per struttura."*

> *"DRY: Don't Repeat Yourself."*

---

## 📖 REFERENCES

### Internal
- `pages/tests/[slug].blade.php` - Dynamic page handler
- `config/local/fixcity/database/content/pages/` - JSON configs

### External
- [Laravel Folio](https://laravel.com/docs/folio)
- [Livewire Volt](https://livewire.laravel.com/docs/volt)
- [Superpowers](https://github.com/obra/superpowers)

---

**Status**: ✅ **CORRECTED**  
**Next**: Use ONLY `[slug].blade.php` for ALL pages!
