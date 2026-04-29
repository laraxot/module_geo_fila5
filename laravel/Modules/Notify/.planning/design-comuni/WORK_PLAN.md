# Design Comuni Replication - Work Plan

## ✅ Architecture Confirmed

- **Theme**: Sixteen (namespace: `pub_theme`)
- **CSS**: Tailwind CSS (NOT Bootstrap)
- **Routing**: Folio at `resources/views/pages/it/tests/`
- **File**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

### Component Pattern
```php
// laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
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

### Header/Footer Pattern
```blade
<x-section slug="header" />
<x-section slug="footer" />
```

### Blocks Pattern
```blade
<x-pub_theme::blocks.navigation.header-main .../>
<x-pub_theme::blocks.cards.card .../>
<x-pub_theme::design-comuni.page-shell .../>
```

## 📂 Data Structure

### JSON Pages Location
`laravel/config/local/fixcity/database/content/pages/`

### JSON File Naming
`tests.<page-slug>.json`

### JSON Structure
```json
{
    "id": "tests.homepage",
    "title": { "it": "Homepage", "en": "Homepage" },
    "slug": "tests.homepage",
    "content": null,
    "content_blocks": {
        "it": [
            { "type": "breadcrumb", "data": { ... } },
            { "type": "hero", "data": { ... } },
            { "type": "card_grid", "data": { ... } }
        ],
        "en": []
    },
    "sidebar_blocks": { "it": [], "en": [] },
    "footer_blocks": { "it": "", "en": "" }
}
```

## 📄 Pages Available (80+ JSON files)

All pages are in `laravel/config/local/fixcity/database/content/pages/tests.*.json`

### Verified Working Routes
- `/it/tests` - Index page ✅
- `/it/tests/homepage` ✅
- `/it/tests/argomenti` ✅
- `/it/tests/appuntamento-06-conferma` ✅

## 🎯 Key Points

1. **Pages are loaded from JSON files** in `config/local/fixcity/database/content/pages/`
2. **Slug format**: `tests.<page-name>` (e.g., `tests.homepage`)
3. **Each page should have multiple blocks** - NOT just one reference block
4. **Blocks are rendered** via `<x-page side="content" :slug="$pageSlug" />`
5. **Header/Footer**: Use `<x-section slug="header" />` and `<x-section slug="footer" />`

## 📚 Source Files

Original Design Comuni templates:
- `laravel/Themes/Sixteen/Main_files/design-comuni-pagine-statiche/src/pages/sito/`

Reference Tailwind implementation:
- `laravel/Themes/Sixteen/Main_files/five/`

## 🔗 Related Documentation

- `Themes/Sixteen/docs/design-comuni/README.md`
- `Themes/Sixteen/docs/bootstrap-italia-to-tailwind.md`
