# Design Comuni Replication Project - FixCity

## Project Overview
Replicate the Italian Design Comuni template (https://italia.github.io/design-comuni-pagine-statiche/) using Tailwind CSS + Alpine.js in the Sixteen theme, following DRY + KISS principles.

## Core Philosophy
- **DRY (Don't Repeat Yourself)**: Universal reusable blocks, no page-specific components
- **KISS (Keep It Simple, Stupid)**: Simple JSON-driven content, clean Blade templates
- **One Dynamic Route**: Single `[slug].blade.php` for ALL test pages
- **JSON for Content**: All page content stored in JSON files with block structures
- **Tailwind CSS**: No Bootstrap Italia CDN - replicate design with Tailwind @apply

## Technical Stack
- **Framework**: Laravel 12 + Folio (file-based routing) + Volt (Livewire)
- **Frontend**: Tailwind CSS v4 + Alpine.js
- **Design System**: DaisyUI + Custom Bootstrap Italia design tokens
- **Block System**: Filament Forms Builder-compatible JSON blocks
- **Theme**: Sixteen (pub_theme configuration)

## Target Pages (Design Comuni)
### General Pages
- homepage
- argomenti (topics list)
- amministrazione (administration)
- documenti-dati (documents & data)
- novita (news list)
- novita-dettaglio (news detail)
- servizi (services)
- servizio-dettaglio (service detail)
- eventi (events)
- evento-dettaglio (event detail)

### Appointment Booking Flow
- appuntamento-01-ufficio
- appuntamento-01-ufficio-luogo
- appuntamento-02-data-orario
- appuntamento-03-dettagli
- appuntamento-04-richiedente
- appuntamento-04-richiedente-autenticato
- appuntamento-05-riepilogo
- appuntamento-06-conferma

### Assistance Request Flow
- assistenza-01-dati
- assistenza-02-conferma

### Service Disruption Report Flow
- segnalazione-dettaglio
- segnalazione-01-privacy
- segnalazione-02-dati
- segnalazione-03-riepilogo
- segnalazione-04-conferma
- segnalazione-area-personale
- segnalazioni-elenco

## Block Types (Universal, Reusable)
Based on Flowbite, Tailwind UI, DaisyUI, and Bootstrap Italia:

### Layout Blocks
- `hero` - Full-width hero section with title and background
- `content-section` - Standard content section with heading and body
- `grid-layout` - Multi-column grid for cards
- `sidebar-content` - Content with sidebar navigation

### Content Blocks
- `news-card` - News article card with date, title, description
- `event-card` - Event card with date and location
- `service-card` - Service card with icon and description
- `topic-card` - Topic/tag card
- `person-card` - Person/governance card with role
- `link-card` - Simple link card

### Navigation Blocks
- `header-main` - Main header with branding and navigation
- `header-slim` - Slim header variant
- `footer-full` - Complete footer with all sections
- `footer-slim` - Minimal footer
- `breadcrumbs` - Breadcrumb navigation
- `tabs` - Tab navigation
- `pagination` - Pagination controls

### Interactive Blocks
- `search-bar` - Search input with button
- `filter-panel` - Filter options panel
- `feedback-form` - Rating and feedback form
- `appointment-form` - Multi-step appointment booking
- `contact-form` - Contact/assistance form

### Data Display Blocks
- `data-table` - Tabular data display
- `info-list` - List of information items
- `calendar-view` - Calendar/month view
- `map-view` - Map with markers

## Architecture Principles

### Component Naming Convention
```
pub_theme::components.blocks.<type>.<variant>
Examples:
- pub_theme::components.blocks.hero.basic
- pub_theme::components.blocks.news-card.standard
- pub_theme::components.blocks.navigation.header-main
```

### Section System
```blade
<x-section slug="header" />
<x-section slug="footer" tpl="full" />
<x-section slug="footer" tpl="slim" />
```

### JSON Content Structure
```json
{
  "slug": "tests.homepage",
  "title": "Homepage",
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "data": {
          "view": "pub_theme::components.blocks.hero.basic",
          "title": "Nome del Comune",
          "subtitle": "Contenuti in evidenza"
        }
      },
      {
        "type": "news-card",
        "data": {
          "view": "pub_theme::components.blocks.news-card.standard",
          "date": "2024-01-15",
          "title": "Estate in città",
          "description": "..."
        }
      }
    ]
  }
}
```

### Folio + Volt Pattern (CORRECT)
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
        <x-section slug="header" />
        <main id="main-container">
            <x-page side="content" :slug="$pageSlug" :data="$data" />
        </main>
        <x-section slug="footer" tpl="full" />
    </div>
    @endvolt
</x-layouts.app>
```

## Configuration Path
- APP_URL: http://fixcity.local
- Domain: fixcity.local → local/fixcity
- Config: `laravel/config/local/fixcity/xra.php`
- pub_theme: `Sixteen`
- Theme Path: `laravel/Themes/Sixteen/`
- Content Path: `laravel/config/local/fixcity/database/content/pages/`

## Vite Configuration (CORRECT)
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Sixteen')
```

## Build Process
```bash
cd laravel/Themes/Sixteen
composer update -W
npm install
npm run build
npm run copy
```

## Documentation Standards
- All docs in `docs/` folders (modules and themes)
- Markdown filenames: lowercase kebab-case
- No temporal strings in docs (use git for history)
- Screenshots with analysis in `docs/screenshots/`
- Block documentation in `docs/blocks/`
- Index files for navigation

## Multi-Agent Coordination
- Check GitHub Issues before starting work
- Document all changes in commits
- Small, frequent commits with pushes
- Communicate progress every 10-15 minutes
- Use GitHub Discussions for decisions

## Success Criteria
1. ✅ HTML inside `<body>` matches Design Comuni template
2. ✅ Visual appearance matches Design Comuni
3. ✅ All pages accessible via `/it/tests/[slug]`
4. ✅ Header/Footer as sections (`<x-section slug="header" />`)
5. ✅ Universal block types (no page-specific blocks)
6. ✅ JSON-driven content structure
7. ✅ Tailwind CSS (no Bootstrap Italia CDN)
8. ✅ Comprehensive documentation
9. ✅ Screenshot comparisons with analysis
10. ✅ DRY + KISS compliance verified

## Tools & Skills to Install
- UI/UX Pro Max Skill
- Taste Skill
- Superpowers
- BMAD Method
- GSD (Get Shit Done)
- Ralph Loop
- OpenViking
- NotebookLM MCP

## References
- Design Comuni: https://italia.github.io/design-comuni-pagine-statiche/
- Flowbite Blocks: https://flowbite.com/blocks/
- Tailwind UI: https://tailwindcss.com/plus/ui-blocks
- DaisyUI: https://daisyui.com/components/
- Bootstrap Italia: https://italia.github.io/bootstrap-italia/docs/componenti/introduzione/
- Filament v5: https://filamentphp.com/docs/5.x
