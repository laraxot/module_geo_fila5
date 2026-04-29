# 🧘 Filament Blocks + JSON CMS Philosophy

**Date**: 2026-03-30  
**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: Filament Forms Builder → JSON Blocks → Blade Views

---

## 🎯 The Philosophy (The Zen)

### Core Principle: Blocks are Building Blocks

**Traditional CMS**:
```
Database → WYSIWYG Editor → HTML Output
```

**FixCity CMS (Filament + JSON)**:
```
Filament Forms Builder
    ↓
Block Schema (PHP)
    ↓
JSON Data (laravel/config/.../pages/{slug}.json)
    ↓
BlockData Class
    ↓
Blade View
```

**Why Blocks?**
- ✅ Reusable components (DRY)
- ✅ Type-safe data (PHPStan Level 10)
- ✅ Filament Forms Builder integration
- ✅ JSON-based (Git-friendly)
- ✅ Multi-language support
- ✅ Easy to extend

---

## 📦 Block Architecture

### 1. Filament Block Class (PHP)

**File**: `laravel/Modules/Cms/app/Filament/Blocks/HeroBlock.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class HeroBlock extends XotBaseBlock
{
    #[\Override]
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('subtitle'),
            FileUpload::make('image')->image()->directory('hero-images'),
            TextInput::make('cta_text'),
            TextInput::make('cta_link'),
            ColorPicker::make('background_color')->default('#ffffff'),
            ColorPicker::make('text_color')->default('#000000'),
            ColorPicker::make('cta_color')->default('#4f46e5'),
        ];
    }
}
```

**Purpose**: Defines the form schema for editing blocks in Filament admin panel.

---

### 2. JSON Block Data

**File**: `laravel/config/local/fixcity/database/content/pages/tests.homepage.json`

```json
{
    "slug": "tests.homepage",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Benvenuto nel Comune",
                    "subtitle": "Design Comuni Pagine Statiche",
                    "cta_text": "Scopri i servizi",
                    "cta_link": "/it/tests/servizi",
                    "background_color": "#ffffff",
                    "text_color": "#000000",
                    "cta_color": "#4f46e5",
                    "view": "cms::components.blocks.hero"
                }
            },
            {
                "type": "features",
                "data": {
                    "title": "I nostri servizi",
                    "features": [
                        {
                            "icon": "heroicon-o-document-text",
                            "title": "Certificati",
                            "description": "Richiedi certificati online"
                        },
                        {
                            "icon": "heroicon-o-calendar",
                            "title": "Appuntamenti",
                            "description": "Prenota appuntamenti"
                        }
                    ],
                    "view": "cms::components.blocks.features"
                }
            },
            {
                "type": "cta",
                "data": {
                    "title": "Hai bisogno di aiuto?",
                    "subtitle": "Contatta l'ufficio relazioni con il pubblico",
                    "button_text": "Contattaci",
                    "button_link": "/it/tests/assistenza",
                    "view": "cms::components.blocks.cta"
                }
            }
        ]
    }
}
```

**Purpose**: Stores block data in JSON format (Git-friendly, version control).

---

### 3. BlockData Class

**File**: `laravel/Modules/Cms/app/Datas/BlockData.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

class BlockData extends Data
{
    public string $type;           // 'hero', 'features', 'cta', etc.
    public ?string $slug = null;   // Optional block identifier
    public array $data;            // Block data from JSON
    public string $view;           // Blade view path
    public bool $livewire = false; // Is it a Livewire component?
    
    public function __construct(
        string $type,
        array $data,
        ?string $slug = null
    ) {
        $this->type = $type;
        $this->slug = $slug;
        $this->data = $data;
        
        // Resolve view
        $this->view = $data['view'] ?? 'cms::blocks.'.$type;
        
        // Detect Livewire
        $this->livewire = $this->detectLivewire($this->view);
    }
}
```

**Purpose**: Type-safe data transfer object for blocks.

---

### 4. Blade View

**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/hero.blade.php`

```blade
@props(['block'])

<section 
    class="hero"
    style="background-color: {{ $block->data['background_color'] ?? '#ffffff' }}"
>
    <div class="container mx-auto py-12">
        <h1 
            class="text-4xl font-bold mb-4"
            style="color: {{ $block->data['text_color'] ?? '#000000' }}"
        >
            {{ $block->data['title'] }}
        </h1>
        
        @if($block->data['subtitle'] ?? null)
            <p class="text-xl mb-8">
                {{ $block->data['subtitle'] }}
            </p>
        @endif
        
        @if($block->data['cta_text'] ?? null)
            <a 
                href="{{ $block->data['cta_link'] ?? '#' }}"
                class="btn btn-primary"
                style="background-color: {{ $block->data['cta_color'] ?? '#4f46e5' }}"
            >
                {{ $block->data['cta_text'] }}
            </a>
        @endif
    </div>
</section>
```

**Purpose**: Renders the block with Tailwind CSS.

---

## 🔄 Data Flow

```
1. Filament Admin Panel
   ↓ (Editor creates block)
2. Filament Block Class (HeroBlock::getBlockSchema())
   ↓ (Form data saved)
3. JSON File (tests.homepage.json)
   ↓ (Page request)
4. PageModel::getBlocksBySlug('tests.homepage')
   ↓ (Loads JSON via Sushi ORM)
5. HasBlocks Trait → getBlocks()
   ↓ (Creates BlockData instances)
6. BlockData Class
   ↓ (Renders view)
7. Blade View (blocks/hero.blade.php)
   ↓ (HTML output)
8. Browser
```

---

## 📊 Available Block Types

### Core Blocks (Cms Module)

| Block | Purpose | Fields |
|-------|---------|--------|
| **HeroBlock** | Hero section | title, subtitle, image, cta_text, cta_link, colors |
| **ParagraphBlock** | Text content | title, content, alignment |
| **CtaBlock** | Call-to-action | title, subtitle, button_text, button_link |
| **FeaturesBlock** | Feature grid | title, features[] (icon, title, description) |
| **InfoBlock** | Information | title, content, icon |
| **LinksBlock** | Link list | title, links[] (text, url, icon) |
| **QuickLinksBlock** | Quick navigation | title, links[] |
| **ContactBlock** | Contact info | address, phone, email, map |
| **SocialBlock** | Social media | platforms[] (name, url, icon) |
| **SocialLinksBlock** | Social links | links[] |
| **LogoBlock** | Logo display | logo, alt_text |
| **NewsletterBlock** | Newsletter signup | title, description, form_action |
| **StatsBlock** | Statistics | stats[] (label, value, icon) |
| **ActionsBlock** | Action buttons | actions[] (label, url, icon) |
| **NavigationBlock** | Navigation | menu_items[] |

### Custom Blocks (Theme/Module)

Can be added by themes or modules:
- `fixcity::blocks.ticket_list`
- `fixcity::blocks.map`
- `fixcity::blocks.timeline`

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single BlockData class** for all block types  
✅ **Single getBlocksBySlug()** method for all pages  
✅ **Reusable block views** across pages  
✅ **Filament schema** defined once per block type

### KISS (Keep It Simple, Stupid)

✅ **Simple JSON structure**: type + data array  
✅ **Simple Blade views**: Props-based rendering  
✅ **Simple Filament schema**: Array of form fields  
✅ **Easy to extend**: Add new block type = new PHP class + view

---

## 📁 Example: Complete Page with Multiple Blocks

### JSON File: `tests.appuntamento-06-conferma.json`

```json
{
    "slug": "tests.appuntamento-06-conferma",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Appuntamento Confermato",
                    "subtitle": "La tua prenotazione è stata registrata",
                    "background_color": "#f0fdf4",
                    "text_color": "#166534",
                    "view": "cms::components.blocks.hero"
                }
            },
            {
                "type": "info",
                "data": {
                    "title": "Dettagli Appuntamento",
                    "icon": "heroicon-o-check-circle",
                    "content": "<p>Il tuo appuntamento è stato prenotato con successo.</p>",
                    "view": "cms::components.blocks.info"
                }
            },
            {
                "type": "appointment_details",
                "data": {
                    "title": "Riepilogo",
                    "service": "Richiesta carta d'identità elettronica",
                    "location": "Municipio, sportello servizi demografici",
                    "date": "Mercoledì 17 aprile 2026",
                    "time": "10:30",
                    "code": "FC-AP-2026-0417",
                    "view": "fixcity::blocks.appointment-details"
                }
            },
            {
                "type": "steps",
                "data": {
                    "title": "Prossimi Passi",
                    "steps": [
                        {
                            "number": 1,
                            "title": "Presentati in comune",
                            "description": "Arriva 10 minuti prima con i documenti richiesti"
                        },
                        {
                            "number": 2,
                            "title": "Consegna documenti",
                            "description": "Consegna la documentazione necessaria"
                        },
                        {
                            "number": 3,
                            "title": "Ritira ricevuta",
                            "description": "Ritira la ricevuta di richiesta"
                        }
                    ],
                    "view": "cms::components.blocks.steps"
                }
            },
            {
                "type": "cta",
                "data": {
                    "title": "Hai bisogno di aiuto?",
                    "subtitle": "Contatta l'ufficio servizi demografici",
                    "button_text": "Contattaci",
                    "button_link": "/it/tests/assistenza",
                    "view": "cms::components.blocks.cta"
                }
            }
        ]
    }
}
```

**Blocks Used**: 5 (hero, info, appointment_details, steps, cta)

---

## ✅ Checklist for Creating New Blocks

### 1. Create Filament Block Class

```bash
php artisan make:filament-block CustomBlock
```

**File**: `laravel/Modules/Cms/app/Filament/Blocks/CustomBlock.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Blocks;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Blocks\XotBaseBlock;

class CustomBlock extends XotBaseBlock
{
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            // ... more fields
        ];
    }
}
```

### 2. Create Blade View

**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/custom.blade.php`

```blade
@props(['block'])

<div class="custom-block">
    <h2>{{ $block->data['title'] }}</h2>
    {{-- More content --}}
</div>
```

### 3. Add to JSON

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "custom",
                "data": {
                    "title": "My Custom Block",
                    "view": "pub_theme::components.blocks.custom"
                }
            }
        ]
    }
}
```

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **CMS JSON Philosophy** | `.planning/improvements/CMS_JSON_SUSHI_PHILOSOPHY.md` |
| **Folio + Volt** | `.planning/improvements/FOLIO_VOLT_PHILOSOPHY.md` |
| **Filament Blocks** | `laravel/Modules/Cms/docs/filament-blocks.md` |
| **BlockData** | `laravel/Modules/Cms/docs/block-data.md` |

---

**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Pattern**: Filament Forms → JSON → BlockData → Blade  
**DRY + KISS**: Single BlockData, reusable views, simple structure

**The Zen of Filament Blocks! 🧘**
