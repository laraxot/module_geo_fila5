# 🧘 CMS JSON Philosophy - Sushi ORM

**Date**: 2026-03-30  
**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: File-based CMS with Sushi ORM + Blocks

---

## 🎯 The Philosophy (The Zen)

### Core Principle: Files ARE Database

**Traditional**:
```
Database (MySQL/PostgreSQL)
    ↓
Eloquent Model
    ↓
Blade View
```

**FixCity CMS (Sushi ORM)**:
```
JSON Files (laravel/config/local/fixcity/database/content/pages/)
    ↓
Sushi Trait (SushiToJsons)
    ↓
Eloquent Model (Page)
    ↓
Blade Component (<x-page>)
```

**Why Files?**
- ✅ No database migrations for content
- ✅ Version control friendly (Git)
- ✅ Easy backup (copy files)
- ✅ Multi-tenant (different config folders)
- ✅ Fast for read-heavy content

---

## 📁 File Structure

### JSON Content Location

```
laravel/config/{environment}/fixcity/database/content/pages/
├── 1.json                              # Homepage
├── 2.json                              # About page
├── tests.appuntamento-06-conferma.json # Test page
└── ...
```

### Example JSON File

**File**: `laravel/config/local/fixcity/database/content/pages/tests.appuntamento-06-conferma.json`

```json
{
    "id": "1",
    "title": {
        "it": "Conferma Appuntamento",
        "en": "Appointment Confirmation"
    },
    "slug": "tests.appuntamento-06-conferma",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "ticket_list",
                "data": {
                    "title": "Segnalazioni dal territorio",
                    "sub_title": "Problemi aperti",
                    "method": "latest_public_tickets",
                    "limit": 5,
                    "view": "fixcity::components.blocks.ticket_list.agid"
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": [],
        "en": []
    },
    "footer_blocks": {
        "it": ""
    },
    "created_at": "2024-12-09T16:46:21.000000Z",
    "updated_at": "2024-12-09T17:08:25.000000Z",
    "created_by": "uuid",
    "updated_by": "uuid"
}
```

---

## 🔄 Data Flow

### Request Lifecycle

```
1. Request: /it/tests/appuntamento-06-conferma
    ↓
2. Folio Route: pages/tests/[slug].blade.php
    ↓
3. Volt Component: mount($slug='appuntamento-06-conferma')
    ↓
4. Middleware: PageSlugMiddleware validates
    ↓
5. CMS Component: <x-page side="content" :slug="$pageSlug" :data="$data" />
    ↓
6. PageModel::getBlocksBySlug('tests.appuntamento-06-conferma')
    ↓
7. Sushi ORM: Loads JSON file
    ↓
8. HasBlocks Trait: Parses content_blocks, sidebar_blocks, footer_blocks
    ↓
9. BlockData Objects: Created for each block
    ↓
10. Blade View: Renders blocks with correct view
```

---

## 🧩 Key Components

### 1. Page Model

**File**: `laravel/Modules/Cms/app/Models/Page.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Tenant\Models\Traits\SushiToJsons;

class Page extends BaseModelLang
{
    use HasBlocks;      // Block management
    use SushiToJsons;   // JSON file ORM

    /**
     * Schema definition for JSON files
     */
    public array $schema = [
        'id' => 'string',
        'title' => 'array',
        'slug' => 'string',
        'content' => 'nullable',
        'content_blocks' => 'array',
        'sidebar_blocks' => 'array',
        'footer_blocks' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

### 2. HasBlocks Trait

**File**: `laravel/Modules/Cms/app/Models/Traits/HasBlocks.php`

**Key Methods**:

```php
/**
 * Get blocks for a record by slug
 */
public static function getBlocksBySlug(string $slug, ?string $side = null): array
{
    try {
        // Load page from JSON files via Sushi ORM
        $record = static::query()->where('slug', $slug)->sole();
    } catch (ModelNotFoundException) {
        return []; // Page not found
    }

    // Get blocks (content_blocks, sidebar_blocks, or footer_blocks)
    return $record->getBlocks($side);
}

/**
 * Get blocks for this record
 */
public function getBlocks(?string $side = null): array
{
    $field = 'blocks';
    if ($side) {
        $field = $side.'_blocks';
    }
    
    $blocks = $this->{$field};
    
    // Create BlockData instances
    $blockDataInstances = [];
    foreach ($blocks as $key => $block) {
        $blockDataInstances[$key] = new BlockData(
            type: $block['type'],
            data: $block['data'],
            slug: $block['slug'] ?? null
        );
    }
    
    return $blockDataInstances;
}
```

### 3. SushiToJsons Trait

**File**: `laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php`

**Key Methods**:

```php
/**
 * Get JSON file path for this model
 */
public function getJsonFile(): string
{
    $tbl = $this->getTable();        // 'pages'
    $id = $this->getKey();           // 'tests.appuntamento-06-conferma'
    
    $filename = 'database/content/'.$tbl.'/'.$id.'.json';
    
    return TenantService::filePath($filename);
    // Returns: laravel/config/local/fixcity/database/content/pages/tests.appuntamento-06-conferma.json
}

/**
 * Load all JSON files as "database rows"
 */
public function getSushiRows(): array
{
    $tbl = $this->getTable();
    $path = TenantService::filePath('database/content/'.$tbl);
    
    $files = File::glob($path.'/*.json');
    $rows = [];
    
    foreach ($files as $file) {
        $json = File::json($file);
        $rows[] = $json;
    }
    
    return $rows;
}
```

### 4. Page Component

**File**: `laravel/Modules/Cms/app/View/Components/Page.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\View\Component;
use Modules\Cms\Models\Page as PageModel;

final class Page extends Component
{
    public string $side;      // 'content', 'sidebar', 'footer'
    public string $slug;      // 'tests.appuntamento-06-conferma'
    public array $blocks;     // Array of BlockData objects
    public array $data = [];  // Additional data

    public function __construct(
        array $data = [],
        string $side = 'content',
        ?string $slug = null,
    ) {
        $this->side = $side;
        $this->data = $data;
        
        // Resolve slug
        if (null === $slug && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }
        $this->slug = $slug;
        
        // Load blocks from JSON file
        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
    }

    public function render(): ViewContract
    {
        return view('cms::components.page', [
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
        ]);
    }
}
```

### 5. BlockData Class

**File**: `laravel/Modules/Cms/Datas/BlockData.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class BlockData extends Data
{
    public function __construct(
        public string $type,           // 'ticket_list', 'hero', 'text', etc.
        public array $data,            // Block configuration
        public ?string $slug = null,   // Optional block slug
    ) {}
    
    /**
     * Get the view for this block
     */
    public function getView(): string
    {
        return $this->data['view'] ?? 'cms::blocks.'.$this->type;
    }
}
```

---

## 📊 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single source**: JSON files are the database  
✅ **Single component**: `<x-page>` renders ALL pages  
✅ **Single trait**: `SushiToJsons` for all JSON-based models  
✅ **Single method**: `getBlocksBySlug()` for all block loading

### KISS (Keep It Simple, Stupid)

✅ **Simple structure**: JSON files in folders  
✅ **Simple loading**: Sushi ORM handles everything  
✅ **Simple rendering**: `<x-page>` does all the work  
✅ **Simple editing**: Edit JSON files directly

---

## 🎯 Why NOT @includeIf?

### WRONG Approach ❌

```blade
@includeIf('pub_theme::design-comuni.pages.'.$slug)
```

**Problems**:
- ❌ Hardcoded HTML (not dynamic)
- ❌ No database/blocks system
- ❌ No content management
- ❌ No multi-language support
- ❌ No version control friendly

### CORRECT Approach ✅

```blade
<x-page side="content" :slug="$pageSlug" :data="$data" />
```

**Benefits**:
- ✅ Dynamic content from JSON files
- ✅ Blocks system (content, sidebar, footer)
- ✅ Multi-language support
- ✅ Version control friendly (Git)
- ✅ Easy to edit (JSON files)

---

## 📁 Complete Example

### Request: `/it/tests/appuntamento-06-conferma`

**1. Folio Route** (`pages/tests/[slug].blade.php`):
```php
name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(string $slug): void {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = ['slug' => $slug];
    }
};
```

**2. Volt Component**:
```blade
<x-layouts.app>
    @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

**3. Page Component**:
```php
// Loads: laravel/config/local/fixcity/database/content/pages/tests.appuntamento-06-conferma.json
$blocks = PageModel::getBlocksBySlug('tests.appuntamento-06-conferma', 'content');
```

**4. JSON File**:
```json
{
    "slug": "tests.appuntamento-06-conferma",
    "content_blocks": {
        "it": [
            {
                "type": "ticket_list",
                "data": {
                    "title": "Segnalazioni dal territorio",
                    "view": "fixcity::components.blocks.ticket_list.agid"
                }
            }
        ]
    }
}
```

**5. Rendered Output**:
```blade
@foreach($blocks as $block)
    @include($block->getView(), ['data' => $block->data])
@endforeach
```

---

## ✅ Checklist

### Understanding

- [x] JSON files ARE the database
- [x] Sushi ORM loads JSON as "rows"
- [x] HasBlocks parses content_blocks, sidebar_blocks, footer_blocks
- [x] PageComponent renders blocks
- [x] BlockData holds block type, data, view

### Implementation

- [x] `pages/tests/[slug].blade.php` uses Folio + Volt
- [x] `<x-page>` component loads blocks from JSON
- [x] JSON files have correct structure
- [x] `slug` field matches route slug
- [x] Blocks have `type`, `data`, `view`

### Documentation

- [x] Philosophy documented
- [x] Data flow documented
- [x] Examples provided
- [x] DRY + KISS compliant

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Folio + Volt** | `.planning/improvements/FOLIO_VOLT_PHILOSOPHY.md` |
| **Sushi ORM** | `laravel/Modules/Tenant/docs/sushi-orm.md` |
| **Blocks System** | `laravel/Modules/Cms/docs/blocks.md` |
| **JSON Content** | `laravel/Modules/Cms/docs/json-content.md` |

---

**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: JSON Files + Sushi ORM + Blocks  
**DRY + KISS**: Single source, simple structure, file-based CMS

**The Zen of JSON-based CMS! 🧘**
