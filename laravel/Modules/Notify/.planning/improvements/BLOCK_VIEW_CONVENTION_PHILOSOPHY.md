# 🧘 Block View Convention Philosophy - DRY + KISS

**Date**: 2026-03-30  
**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Convention**: `type` → `pub_theme::components.blocks.{type}.{blade}`

---

## 🎯 The Philosophy (The Zen)

### Core Principle: Convention Over Configuration

**Block Type**: `hero`  
**View Path**: `pub_theme::components.blocks.hero.hero`  
**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/hero/hero.blade.php`

**Block Type**: `appointment_details`  
**View Path**: `pub_theme::components.blocks.appointment_details.appointment_details`  
**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/appointment_details/appointment_details.blade.php`

**Why?**
- ✅ **DRY**: No need to specify view in JSON (auto-resolved)
- ✅ **KISS**: Simple convention, easy to understand
- ✅ **Predictable**: Always know where view is
- ✅ **Maintainable**: Change convention → all views update

---

## 📁 Directory Structure

```
laravel/Themes/Sixteen/resources/views/components/blocks/
├── hero/
│   └── hero.blade.php              # Hero block view
├── info/
│   └── info.blade.php              # Info block view
├── cta/
│   └── cta.blade.php               # CTA block view
├── steps/
│   └── steps.blade.php             # Steps block view
├── appointment_details/
│   └── appointment_details.blade.php
├── documents_list/
│   └── documents_list.blade.php
├── quick_links/
│   └── quick_links.blade.php
└── contact/
    └── contact.blade.php
```

---

## 🔄 Auto-Resolution Logic

### BlockData Class (Auto-Resolve View)

```php
class BlockData extends Data
{
    public function __construct(
        string $type,
        array $data,
        ?string $slug = null
    ) {
        $this->type = $type;
        $this->slug = $slug;
        $this->data = $data;
        
        // AUTO-RESOLVE VIEW (DRY + KISS)
        if (!isset($data['view'])) {
            // Convention: type → pub_theme::components.blocks.{type}.{type}
            $this->view = "pub_theme::components.blocks.{$type}.{$type}";
        } else {
            $this->view = $data['view'];
        }
    }
}
```

### JSON (No View Needed - Auto-Resolved)

**Before (WRONG - Verbose)**:
```json
{
    "type": "hero",
    "data": {
        "title": "Benvenuto",
        "view": "pub_theme::components.blocks.hero.hero"  // ❌ Ridondante!
    }
}
```

**After (CORRECT - DRY)**:
```json
{
    "type": "hero",
    "data": {
        "title": "Benvenuto"
        // ✅ View auto-resolved: pub_theme::components.blocks.hero.hero
    }
}
```

---

## 📊 Convention Examples

| Block Type | Auto-Resolved View | File Path |
|------------|-------------------|-----------|
| `hero` | `pub_theme::components.blocks.hero.hero` | `components/blocks/hero/hero.blade.php` |
| `info` | `pub_theme::components.blocks.info.info` | `components/blocks/info/info.blade.php` |
| `cta` | `pub_theme::components.blocks.cta.cta` | `components/blocks/cta/cta.blade.php` |
| `steps` | `pub_theme::components.blocks.steps.steps` | `components/blocks/steps/steps.blade.php` |
| `appointment_details` | `pub_theme::components.blocks.appointment_details.appointment_details` | `components/blocks/appointment_details/appointment_details.blade.php` |
| `documents_list` | `pub_theme::components.blocks.documents_list.documents_list` | `components/blocks/documents_list/documents_list.blade.php` |
| `quick_links` | `pub_theme::components.blocks.quick_links.quick_links` | `components/blocks/quick_links/quick_links.blade.php` |
| `contact` | `pub_theme::components.blocks.contact.contact` | `components/blocks/contact/contact.blade.php` |

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **View auto-resolved**: No need to specify in JSON  
✅ **Single convention**: All blocks follow same pattern  
✅ **No duplication**: View path not repeated in every JSON  
✅ **Centralized logic**: BlockData handles resolution

### KISS (Keep It Simple, Stupid)

✅ **Simple pattern**: `{type}` → `blocks.{type}.{type}`  
✅ **Easy to understand**: Obvious from type name  
✅ **Predictable**: Always know where view is  
✅ **Easy to extend**: New block = new folder + blade file

---

## 📄 Complete Example

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
                    "background_color": "#f0fdf4"
                    // ✅ View auto-resolved: pub_theme::components.blocks.hero.hero
                }
            },
            {
                "type": "info",
                "data": {
                    "title": "Conferma Prenotazione",
                    "icon": "heroicon-o-check-circle",
                    "content": "<p>Il tuo appuntamento è stato prenotato con successo.</p>"
                    // ✅ View auto-resolved: pub_theme::components.blocks.info.info
                }
            },
            {
                "type": "appointment_details",
                "data": {
                    "title": "Riepilogo Appuntamento",
                    "service": "Richiesta carta d'identità elettronica",
                    "location": "Municipio, sportello servizi demografici",
                    "date": "Mercoledì 17 aprile 2026",
                    "time": "10:30",
                    "code": "FC-AP-2026-0417"
                    // ✅ View auto-resolved: pub_theme::components.blocks.appointment_details.appointment_details
                }
            },
            {
                "type": "steps",
                "data": {
                    "title": "Prossimi Passi",
                    "steps": [
                        {"number": 1, "title": "Presentati in comune", "description": "..."},
                        {"number": 2, "title": "Consegna documenti", "description": "..."},
                        {"number": 3, "title": "Ritira ricevuta", "description": "..."},
                        {"number": 4, "title": "Attendi ritiro", "description": "..."}
                    ]
                    // ✅ View auto-resolved: pub_theme::components.blocks.steps.steps
                }
            },
            {
                "type": "documents_list",
                "data": {
                    "title": "Documenti Richiesti",
                    "documents": [
                        "Documento di identità valido",
                        "Codice fiscale",
                        "2 foto tessera recenti",
                        "Permesso di soggiorno"
                    ]
                    // ✅ View auto-resolved: pub_theme::components.blocks.documents_list.documents_list
                }
            },
            {
                "type": "cta",
                "data": {
                    "title": "Hai bisogno di aiuto?",
                    "subtitle": "Contatta l'ufficio servizi demografici",
                    "button_text": "Contattaci",
                    "button_link": "/it/tests/assistenza"
                    // ✅ View auto-resolved: pub_theme::components.blocks.cta.cta
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": [
            {
                "type": "quick_links",
                "data": {
                    "title": "Link Utili",
                    "links": [
                        {"text": "I tuoi appuntamenti", "url": "..."},
                        {"text": "Documenti necessari", "url": "..."},
                        {"text": "Contatti", "url": "..."}
                    ]
                    // ✅ View auto-resolved: pub_theme::components.blocks.quick_links.quick_links
                }
            },
            {
                "type": "contact",
                "data": {
                    "title": "Contatti",
                    "phone": "02 1234 5678",
                    "email": "servizi.demografici@comune.it",
                    "hours": "Lun-Ven: 9:00-13:00"
                    // ✅ View auto-resolved: pub_theme::components.blocks.contact.contact
                }
            }
        ]
    }
}
```

**Total**: 8 blocks, **ZERO** view specifications needed!

---

## 📁 Blade View Example

### File: `laravel/Themes/Sixteen/resources/views/components/blocks/hero/hero.blade.php`

```blade
@props(['block'])

@php
    $title = $block->data['title'] ?? '';
    $subtitle = $block->data['subtitle'] ?? '';
    $bgColor = $block->data['background_color'] ?? '#ffffff';
    $textColor = $block->data['text_color'] ?? '#000000';
@endphp

<section 
    class="py-16 px-4"
    style="background-color: {{ $bgColor }}; color: {{ $textColor }}"
>
    <div class="container mx-auto max-w-6xl">
        <h1 class="text-4xl font-bold mb-4">
            {{ $title }}
        </h1>
        
        @if($subtitle)
            <p class="text-xl opacity-90">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</section>
```

---

## 🔄 Workflow

### 1. Create Block Type (Filament PHP)

```php
// laravel/Modules/Cms/app/Filament/Blocks/HeroBlock.php
class HeroBlock extends XotBaseBlock
{
    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            TextInput::make('subtitle'),
            ColorPicker::make('background_color'),
        ];
    }
}
```

### 2. Create Blade View

```bash
mkdir -p laravel/Themes/Sixteen/resources/views/components/blocks/hero
touch laravel/Themes/Sixteen/resources/views/components/blocks/hero/hero.blade.php
```

### 3. Use in JSON (No View Needed!)

```json
{
    "type": "hero",
    "data": {
        "title": "Benvenuto",
        "subtitle": "Design Comuni"
    }
}
```

### 4. Auto-Resolved at Runtime

```php
// BlockData constructor
$this->view = "pub_theme::components.blocks.hero.hero";
```

---

## ✅ Checklist

### Convention

- [x] Type → View auto-resolution documented
- [x] Directory structure defined
- [x] Examples provided
- [x] DRY + KISS compliant

### Implementation

- [x] BlockData class updated (auto-resolve view)
- [ ] Update all JSON files (remove redundant view specs)
- [ ] Create missing block views
- [ ] Test auto-resolution

### Documentation

- [x] Philosophy documented
- [x] Examples provided
- [x] Workflow explained
- [ ] OpenViking updated

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Multi-Block Philosophy** | `.planning/improvements/MULTI_BLOCK_JSON_PHILOSOPHY.md` |
| **Filament Blocks** | `.planning/improvements/FILAMENT_BLOCKS_JSON_PHILOSOPHY.md` |
| **CMS JSON** | `.planning/improvements/CMS_JSON_SUSHI_PHILOSOPHY.md` |

---

**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Convention**: `{type}` → `pub_theme::components.blocks.{type}.{type}`  
**DRY + KISS**: Auto-resolved views, no redundancy  
**Next**: Update all JSON files to remove redundant view specs

**The Zen of Block View Convention! 🧘**
