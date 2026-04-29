# 🧱 Block Taxonomy - DRY + KISS Architecture

**Date**: 2026-03-30  
**Status**: ✅ **COMPLETE TAXONOMY**  
**Principle**: type → pub_theme::components.blocks.{type}.{type}

---

## 🎯 The Problem

**WRONG** ❌:
```json
{
    "type": "tests.argomenti",  // ❌ NOT a block type!
    "data": {
        "view": "pub_theme::components.blocks.tests.argomenti.topics-grid"  // ❌ Wrong convention!
    }
}
```

**Why Wrong**:
- `tests.argomenti` is a PAGE, not a block type
- Block types must be REUSABLE patterns (hero, card, grid, etc.)
- Convention is `{type}` → `pub_theme::components.blocks.{type}.{type}`

**CORRECT** ✅:
```json
{
    "type": "topics_grid",  // ✅ Reusable block type
    "data": {
        "title": "Esplora gli argomenti",
        "topics": [...]
        // ✅ View auto-resolved: pub_theme::components.blocks.topics_grid.topics_grid
    }
}
```

---

## 📚 Block Taxonomy (Based on Flowbite + Tailwind UI + DaisyUI)

### 1. LAYOUT BLOCKS (Page Structure)

| Type | View | File | Purpose |
|------|------|------|---------|
| `hero` | `pub_theme::components.blocks.hero.hero` | `components/blocks/hero/hero.blade.php` | Page header with title/image |
| `grid` | `pub_theme::components.blocks.grid.grid` | `components/blocks/grid/grid.blade.php` | Responsive grid layout |
| `split` | `pub_theme::components.blocks.split.split` | `components/blocks/split/split.blade.php` | Two-column layout |
| `container` | `pub_theme::components.blocks.container.container` | `components/blocks/container/container.blade.php` | Content wrapper |

### 2. CONTENT BLOCKS (Information Display)

| Type | View | File | Purpose |
|------|------|------|---------|
| `paragraph` | `pub_theme::components.blocks.paragraph.paragraph` | `components/blocks/paragraph/paragraph.blade.php` | Text content |
| `topics_grid` | `pub_theme::components.blocks.topics_grid.topics_grid` | `components/blocks/topics_grid/topics_grid.blade.php` | Grid of topic cards |
| `card` | `pub_theme::components.blocks.card.card` | `components/blocks/card/card.blade.php` | Single card |
| `cards_grid` | `pub_theme::components.blocks.cards_grid.cards_grid` | `components/blocks/cards_grid/cards_grid.blade.php` | Grid of cards |
| `stats` | `pub_theme::components.blocks.stats.stats` | `components/blocks/stats/stats.blade.php` | Statistics/metrics |
| `timeline` | `pub_theme::components.blocks.timeline.timeline` | `components/blocks/timeline/timeline.blade.php` | Timeline/events |
| `faq` | `pub_theme::components.blocks.faq.faq` | `components/blocks/faq/faq.blade.php` | FAQ accordion |
| `table` | `pub_theme::components.blocks.table.table` | `components/blocks/table/table.blade.php` | Data table |

### 3. INTERACTION BLOCKS (User Actions)

| Type | View | File | Purpose |
|------|------|------|---------|
| `cta` | `pub_theme::components.blocks.cta.cta` | `components/blocks/cta/cta.blade.php` | Call-to-action |
| `search` | `pub_theme::components.blocks.search.search` | `components/blocks/search/search.blade.php` | Search bar |
| `filter` | `pub_theme::components.blocks.filter.filter` | `components/blocks/filter/filter.blade.php` | Filter controls |
| `pagination` | `pub_theme::components.blocks.pagination.pagination` | `components/blocks/pagination/pagination.blade.php` | Pagination |

### 4. NAVIGATION BLOCKS (User Navigation)

| Type | View | File | Purpose |
|------|------|------|---------|
| `quick_links` | `pub_theme::components.blocks.quick_links.quick_links` | `components/blocks/quick_links/quick_links.blade.php` | Quick links list |
| `breadcrumbs` | `pub_theme::components.blocks.breadcrumbs.breadcrumbs` | `components/blocks/breadcrumbs/breadcrumbs.blade.php` | Breadcrumb navigation |
| `tabs` | `pub_theme::components.blocks.tabs.tabs` | `components/blocks/tabs/tabs.blade.php` | Tab navigation |

### 5. FEEDBACK BLOCKS (User Feedback)

| Type | View | File | Purpose |
|------|------|------|---------|
| `alert` | `pub_theme::components.blocks.alert.alert` | `components/blocks/alert/alert.blade.php` | Alert/notification |
| `info` | `pub_theme::components.blocks.info.info` | `components/blocks/info/info.blade.php` | Information box |
| `toast` | `pub_theme::components.blocks.toast.toast` | `components/blocks/toast/toast.blade.php` | Toast notification |

### 6. FORM BLOCKS (User Input)

| Type | View | File | Purpose |
|------|------|------|---------|
| `contact` | `pub_theme::components.blocks.contact.contact` | `components/blocks/contact/contact.blade.php` | Contact form |
| `newsletter` | `pub_theme::components.blocks.newsletter.newsletter` | `components/blocks/newsletter/newsletter.blade.php` | Newsletter signup |
| `rating` | `pub_theme::components.blocks.rating.rating` | `components/blocks/rating/rating.blade.php` | Rating/review |

### 7. MEDIA BLOCKS (Rich Media)

| Type | View | File | Purpose |
|------|------|------|---------|
| `image` | `pub_theme::components.blocks.image.image` | `components/blocks/image/image.blade.php` | Image display |
| `gallery` | `pub_theme::components.blocks.gallery.gallery` | `components/blocks/gallery/gallery.blade.php` | Image gallery |
| `video` | `pub_theme::components.blocks.video.video` | `components/blocks/video/video.blade.php` | Video embed |
| `carousel` | `pub_theme::components.blocks.carousel.carousel` | `components/blocks/carousel/carousel.blade.php` | Image carousel |

### 8. SPECIALIZED BLOCKS (Domain-Specific)

| Type | View | File | Purpose |
|------|------|------|---------|
| `appointment_details` | `pub_theme::components.blocks.appointment_details.appointment_details` | `components/blocks/appointment_details/appointment_details.blade.php` | Appointment summary |
| `steps` | `pub_theme::components.blocks.steps.steps` | `components/blocks/steps/steps.blade.php` | Step-by-step guide |
| `documents_list` | `pub_theme::components.blocks.documents_list.documents_list` | `components/blocks/documents_list/documents_list.blade.php` | Documents checklist |
| `service_card` | `pub_theme::components.blocks.service_card.service_card` | `components/blocks/service_card/service_card.blade.php` | Service card |
| `news_card` | `pub_theme::components.blocks.news_card.news_card` | `components/blocks/news_card/news_card.blade.php` | News card |
| `event_card` | `pub_theme::components.blocks.event_card.event_card` | `components/blocks/event_card/event_card.blade.php` | Event card |

---

## 🔄 How It Works

### 1. JSON Defines Block Type

```json
{
    "type": "topics_grid",
    "data": {
        "title": "Esplora gli argomenti",
        "topics": [
            {
                "icon": "culture",
                "title": "Cultura",
                "description": "Eventi e informazioni culturali",
                "link": "/it/cultura"
            }
        ]
    }
}
```

### 2. BlockData Auto-Resolves View

```php
// laravel/Modules/Cms/app/Datas/BlockData.php
public function __construct(string $type, array $data, ?string $slug = null)
{
    $this->type = $type;
    $this->data = $data;
    
    // Auto-resolve: 'topics_grid' → 'pub_theme::components.blocks.topics_grid.topics_grid'
    $view = $data['view'] ?? "pub_theme::components.blocks.{$type}.{$type}";
    
    $this->view = $view;
}
```

### 3. Blade View Renders

```blade
{{-- components/blocks/topics_grid/topics_grid.blade.php --}}
@props(['block'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($block->data['topics'] as $topic)
        <x-card.topic :topic="$topic" />
    @endforeach
</div>
```

---

## 📊 Block Usage by Page Type

### Argomenti Page

```json
{
    "content_blocks": {
        "it": [
            {"type": "hero", "data": {...}},
            {"type": "search", "data": {...}},
            {"type": "topics_grid", "data": {...}},
            {"type": "info", "data": {...}}
        ]
    }
}
```

### Appuntamento-06-Conferma Page

```json
{
    "content_blocks": {
        "it": [
            {"type": "hero", "data": {...}},
            {"type": "info", "data": {...}},
            {"type": "appointment_details", "data": {...}},
            {"type": "steps", "data": {...}},
            {"type": "documents_list", "data": {...}},
            {"type": "cta", "data": {...}}
        ]
    }
}
```

### Homepage

```json
{
    "content_blocks": {
        "it": [
            {"type": "hero", "data": {...}},
            {"type": "stats", "data": {...}},
            {"type": "services_grid", "data": {...}},
            {"type": "news_cards", "data": {...}},
            {"type": "cta", "data": {...}}
        ]
    }
}
```

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Reusable types**: `topics_grid` used in multiple pages  
✅ **Single convention**: All blocks follow same pattern  
✅ **Auto-resolve views**: No manual view specs  
✅ **Shared components**: Cards, grids, etc. reused

### KISS (Keep It Simple, Stupid)

✅ **Simple naming**: Descriptive type names  
✅ **Predictable**: type → view convention  
✅ **Easy to extend**: Add new type = new folder + blade  
✅ **Clear categories**: 8 logical groups

---

## ✅ Implementation Checklist

### Create Block Views

- [ ] `hero/hero.blade.php`
- [ ] `topics_grid/topics_grid.blade.php`
- [ ] `grid/grid.blade.php`
- [ ] `card/card.blade.php`
- [ ] `cards_grid/cards_grid.blade.php`
- [ ] `cta/cta.blade.php`
- [ ] `info/info.blade.php`
- [ ] `steps/steps.blade.php`
- [ ] `search/search.blade.php`
- [ ] `filter/filter.blade.php`
- [ ] ... (all 40+ types)

### Update JSON Files

- [ ] Remove invalid types (e.g., `tests.argomenti`)
- [ ] Use valid block types (e.g., `topics_grid`)
- [ ] Remove manual view specs (auto-resolve)

### Documentation

- [x] Block taxonomy documented
- [ ] Usage examples for each type
- [ ] Component documentation
- [ ] OpenViking updated

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Block View Convention** | `docs/blocks/view-naming-philosophy.md` |
| **BlockData Auto-Resolve** | `docs/blocks/auto-resolve-implementation.md` |
| **Flowbite Reference** | `docs/references/flowbite-blocks.md` |
| **Tailwind UI Reference** | `docs/references/tailwind-ui-blocks.md` |
| **DaisyUI Reference** | `docs/references/daisyui-components.md` |

---

**Status**: ✅ **TAXONOMY COMPLETE**  
**Block Types**: 40+ reusable types  
**Convention**: type → pub_theme::components.blocks.{type}.{type}  
**Next**: Create all block views + update JSON files

**Block taxonomy complete! 🧱**
