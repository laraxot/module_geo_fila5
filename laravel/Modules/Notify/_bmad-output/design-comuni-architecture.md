# 🏗️ Design Comuni Italia - Architecture Design

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔄 **In Progress**
**Priority:** 🔴 **CRITICAL**
**Version:** 1.0

---

## 📋 Executive Summary

Questo documento definisce l'architettura tecnica per replicare le **38 pagine statiche** di Design Comuni Italia nel tema Sixteen di FixCity, garantendo:

- ✅ **Separation of Concerns** - Layout, Components, Content separati
- ✅ **Reusability** - Blocchi universali, NON page-specific
- ✅ **Maintainability** - JSON content, facile aggiornamento
- ✅ **Performance** - Tailwind CSS purged, lazy loading
- ✅ **Scalability** - Pattern estendibile a nuove pagine

---

## 🎯 Architectural Goals

### Primary Goals

1. **Single Point of Entry** - Unico `[slug].blade.php` per TUTTE le pagine
2. **Content Abstraction** - JSON blocks separano dati da view
3. **Component Reusability** - Blocchi universali riusabili
4. **Layout Consistency** - Header/Footer centralizzati
5. **Theme Detection** - Automatico da APP_URL

### Quality Attributes

| Attribute | Target | Measurement |
|-----------|--------|-------------|
| **Maintainability** | High | Cyclomatic complexity <10 |
| **Testability** | High | 80%+ Pest coverage |
| **Performance** | High | Lighthouse >90 |
| **Accessibility** | WCAG 2.1 AA | Automated audit |
| **Scalability** | High | Add page = add JSON only |

---

## 🏛️ System Architecture

### High-Level Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                         FixCity Fila5                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                    Presentation Layer                     │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐   │   │
│  │  │   Folio      │  │    Volt      │  │   Blade      │   │   │
│  │  │   Routes     │  │  Components  │  │  Components  │   │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                             │                                     │
│                             ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                     Business Logic Layer                  │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐   │   │
│  │  │    Actions   │  │    Models    │  │  Repositories│   │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                             │                                     │
│                             ▼                                     │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │                      Data Layer                           │   │
│  │  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐   │   │
│  │  │    MySQL     │  │  JSON Files  │  │    Cache     │   │   │
│  │  └──────────────┘  └──────────────┘  └──────────────┘   │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

### Layer Breakdown

#### 1. Presentation Layer

**Responsibilities:**
- Routing (Folio)
- Component rendering (Volt + Blade)
- Layout composition
- Block rendering

**Technologies:**
- Laravel Folio (file-based routing)
- Livewire Volt (single-file components)
- Blade components (reusable blocks)
- Tailwind CSS (styling via @apply)

#### 2. Business Logic Layer

**Responsibilities:**
- Content retrieval
- Block rendering logic
- Form processing
- Data validation

**Technologies:**
- Spatie QueueableAction (business logic)
- Eloquent Models (data access)
- Repository Pattern (data abstraction)

#### 3. Data Layer

**Responsibilities:**
- Content storage (JSON files)
- Database persistence
- Caching

**Technologies:**
- MySQL (database)
- JSON files (content blocks)
- Redis (cache)

---

## 🗂️ Directory Structure

### Theme Structure

```
laravel/Themes/Sixteen/
├── resources/
│   ├── css/
│   │   └── app.css                    # Tailwind @apply rules
│   ├── js/
│   │   └── app.js                     # Alpine.js components
│   └── views/
│       ├── components/
│       │   ├── layouts/
│       │   │   ├── main.blade.php     # Base HTML structure
│       │   │   └── app.blade.php      # Extends main, adds semantics
│       │   ├── blocks/                # Universal reusable blocks
│       │   │   ├── hero/
│       │   │   │   └── default.blade.php
│       │   │   ├── topics-grid/
│       │   │   │   └── default.blade.php
│       │   │   ├── card/
│       │   │   │   ├── default.blade.php
│       │   │   │   ├── with-image.blade.php
│       │   │   │   └── with-icon.blade.php
│       │   │   ├── news-section/
│       │   │   │   └── default.blade.php
│       │   │   ├── governance-section/
│       │   │   │   └── default.blade.php
│       │   │   ├── events-list/
│       │   │   │   └── default.blade.php
│       │   │   ├── search-form/
│       │   │   │   └── default.blade.php
│       │   │   └── feedback-form/
│       │   │       └── default.blade.php
│       │   └── sections/
│       │       ├── header/
│       │       │   └── default.blade.php
│       │       └── footer/
│       │           └── default.blade.php
│       └── pages/
│           └── tests/
│               ├── [slug].blade.php   # ALL pages use this
│               └── index.blade.php    # Listing page
├── Main_files/
│   └── five/
│       ├── src/
│       │   ├── style-apply.css        # Tailwind @apply (Bootstrap Italia)
│       │   └── app1.js                # Alpine.js components
│       └── ...
└── docs/
    ├── design-comuni/
    │   ├── architecture.md            # THIS FILE
    │   ├── replication-plan.md
    │   ├── screenshots/
    │   └── analysis/
    └── ...
```

### Module Structure (Content Management)

```
laravel/Modules/Cms/
├── Actions/
│   ├── Content/
│   │   ├── GetContentAction.php
│   │   ├── StoreContentAction.php
│   │   └── UpdateContentAction.php
│   └── Block/
│       ├── RenderBlockAction.php
│       └── ValidateBlockAction.php
├── Models/
│   └── Content.php
├── Repositories/
│   └── ContentRepository.php
└── docs/
    └── design-comuni-integration.md
```

### JSON Content Structure

```
laravel/config/local/fixcity/database/content/
├── pages/
│   ├── tests.homepage.json
│   ├── tests.argomenti.json
│   ├── tests.amministrazione.json
│   ├── tests.novita.json
│   ├── tests.servizi.json
│   ├── tests.eventi.json
│   ├── tests.appuntamento-ufficio.json
│   ├── tests.appuntamento-luogo.json
│   ├── tests.appuntamento-data-orario.json
│   ├── tests.appuntamento-dettagli.json
│   ├── tests.appuntamento-richiedente.json
│   ├── tests.appuntamento-richiedente-auth.json
│   ├── tests.appuntamento-riepilogo.json
│   ├── tests.appuntamento-conferma.json
│   ├── tests.assistenza-dati.json
│   ├── tests.assistenza-conferma.json
│   ├── tests.segnalazione-dettaglio.json
│   ├── tests.segnalazione-privacy.json
│   ├── tests.segnalazione-dati.json
│   ├── tests.segnalazione-riepilogo.json
│   ├── tests.segnalazione-conferma.json
│   ├── tests.segnalazione-area-personale.json
│   └── tests.segnalazioni-elenco.json
└── blocks/
    ├── hero/
    │   └── default.json
    ├── topics-grid/
    │   └── default.json
    └── card/
        └── default.json
```

---

## 🔌 Component Architecture

### Component Hierarchy

```
<x-layouts.app>
  │
  ├─ <x-section slug="header" />
  │    │
  │    └─ <x-pub_theme::components.sections.header.default>
  │         ├─ Skip links
  │         ├─ Top bar
  │         ├─ Header branding
  │         └─ Navigation bar
  │
  ├─ @volt('tests.view')
  │    │
  │    └─ <x-page side="content" :slug="$pageSlug" :data="$data" />
  │         │
  │         └─ @foreach($data['blocks'] as $block)
  │              └─ <x-pub_theme::components.blocks.{{ $block['type'] }}.default :data="$block['data']" />
  │                   ├─ hero/default
  │                   ├─ topics-grid/default
  │                   ├─ card/default
  │                   ├─ news-section/default
  │                   ├─ governance-section/default
  │                   ├─ events-list/default
  │                   ├─ search-form/default
  │                   └─ feedback-form/default
  │
  └─ <x-section slug="footer" />
       │
       └─ <x-pub_theme::components.sections.footer.default>
            ├─ Footer columns
            └─ Legal bar
```

### Component Types

#### 1. Layout Components

**Purpose:** Define HTML structure and semantics

**Components:**
- `<x-layouts.main>` - Base HTML5 structure
- `<x-layouts.app>` - Semantic wrapper (extends main)

**Example:**
```blade
{{-- resources/views/components/layouts/main.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FixCity' }}</title>
    @vite(['resources/css/app.css'], 'themes/Sixteen')
</head>
<body class="antialiased">
    {{ $slot }}
    @vite(['resources/js/app.js'], 'themes/Sixteen')
</body>
</html>
```

#### 2. Section Components

**Purpose:** Reusable page sections (header, footer)

**Components:**
- `<x-section slug="header" />`
- `<x-section slug="footer" />`

**Example:**
```blade
{{-- resources/views/components/sections/header/default.blade.php --}}
@props(['skipLinks' => true])

<header class="it-header-wrapper">
    @if($skipLinks)
    <a class="visually-hidden-focusable" href="#main-content">Vai ai contenuti</a>
    <a class="visually-hidden-focusable" href="#footer">Vai al footer</a>
    @endif

    {{-- Top bar --}}
    <div class="it-top-nav-wrapper">
        {{-- Top bar content --}}
    </div>

    {{-- Header branding --}}
    <div class="it-header-slim-wrapper">
        {{-- Branding content --}}
    </div>

    {{-- Navigation --}}
    <nav class="navbar navbar-expand-lg">
        {{-- Navigation menu --}}
    </nav>
</header>
```

#### 3. Block Components

**Purpose:** Universal reusable content blocks

**Characteristics:**
- **Universal** - NOT page-specific
- **Reusable** - Used across multiple pages
- **Configurable** - Data-driven via JSON
- **Typed** - `:data` prop accepts array

**Example:**
```blade
{{-- resources/views/components/blocks/hero/default.blade.php --}}
@props(['data' => []])

@php
    $title = $data['title'] ?? 'Default Title';
    $subtitle = $data['subtitle'] ?? '';
    $backgroundImage = $data['backgroundImage'] ?? null;
@endphp

<div class="it-hero-wrapper it-dark it-overlay">
    @if($backgroundImage)
    <div class="img-responsive-wrapper">
        <div class="img-responsive">
            <div class="img-wrapper">
                <img src="{{ $backgroundImage }}" alt="{{ $title }}">
            </div>
        </div>
    </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="it-hero-text-wrapper bg-dark">
                    <h1 class="no_toc">{{ $title }}</h1>
                    @if($subtitle)
                    <p class="d-none d-lg-block">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## 🔄 Data Flow

### Request Lifecycle

```
1. User Request
   GET /it/tests/homepage
   │
   ▼
2. Folio Routing
   laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
   │
   ▼
3. Volt Component Mount
   mount(string $slug = 'homepage')
   │
   ▼
4. Content Retrieval
   pageSlug = 'tests.homepage'
   JSON File = laravel/config/local/fixcity/database/content/pages/tests.homepage.json
   │
   ▼
5. Block Rendering
   @foreach($data['blocks'] as $block)
       <x-pub_theme::components.blocks.{{ $block['type'] }}.default :data="$block['data']" />
   │
   ▼
6. HTML Output
   Identical to Design Comuni (excluding scripts)
```

### Content Retrieval Flow

```
┌─────────────────────────────────────────────────────────┐
│  Volt Component: mount(string $slug)                    │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Build pageSlug: 'tests.' . $slug                       │
│  Example: 'tests.homepage'                              │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  JSON File Path:                                        │
│  laravel/config/local/fixcity/database/content/         │
│  pages/{pageSlug}.json                                  │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  File Exists?                                           │
│  ├─ YES → Parse JSON → $data                            │
│  └─ NO → Throw exception 404                            │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Validate Block Structure:                              │
│  - blocks array exists                                  │
│  - each block has 'type' and 'data'                     │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Render Blocks:                                         │
│  @foreach($data['blocks'] as $block)                    │
│      <x-block :type="$block['type']" :data="$block['data']" />  │
└─────────────────────────────────────────────────────────┘
```

---

## 🎨 Design System Architecture

### Tailwind @apply Strategy

**File:** `laravel/Themes/Sixteen/Main_files/five/src/style-apply.css`

```css
/* 
 * Bootstrap Italia → Tailwind CSS Mapping
 * DO NOT import Bootstrap Italia CSS
 * Use Tailwind @apply for replication
 */

/* Primary Colors */
.bg-it-primary {
    @apply bg-[#0066CC];
}

.text-it-primary {
    @apply text-[#0066CC];
}

/* Secondary Colors */
.bg-it-secondary {
    @apply bg-[#5C6670];
}

/* Accent Colors */
.bg-it-accent {
    @apply bg-[#00C73C];
}

/* Warning Colors */
.bg-it-warning {
    @apply bg-[#FF9800];
}

/* Danger Colors */
.bg-it-danger {
    @apply bg-[#DC3545];
}

/* Gray Scale */
.bg-it-gray-50 {
    @apply bg-[#F7F8F9];
}

.bg-it-gray-100 {
    @apply bg-[#EDEFF0];
}

.bg-it-gray-200 {
    @apply bg-[#DDE1E3];
}

.text-it-gray-500 {
    @apply text-[#5C6670];
}

.text-it-gray-900 {
    @apply text-[#1C262C];
}

/* Typography */
.text-h1 {
    @apply text-4xl font-bold leading-[1.2];
}

.text-h2 {
    @apply text-3xl font-bold leading-[1.25];
}

.text-h3 {
    @apply text-2xl font-semibold leading-[1.3];
}

.text-h4 {
    @apply text-xl font-semibold leading-[1.35];
}

.text-body {
    @apply text-base font-normal leading-[1.6];
}

/* Spacing */
.space-it-xs {
    @apply space-x-1;
}

.space-it-sm {
    @apply space-x-2;
}

.space-it-md {
    @apply space-x-3;
}

.space-it-lg {
    @apply space-x-4;
}

.space-it-xl {
    @apply space-x-6;
}

/* Components */
.btn-it-primary {
    @apply bg-it-primary text-white font-semibold py-3 px-6 rounded-lg 
           hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 
           transition-colors duration-200;
}

.btn-it-secondary {
    @apply bg-it-secondary text-white font-semibold py-3 px-6 rounded-lg 
           hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 
           transition-colors duration-200;
}

/* Accessibility */
.visually-hidden {
    @apply sr-only;
}

.visually-hidden-focusable {
    @apply sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 
           focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-black 
           focus:font-bold focus:rounded;
}

/* Skip Links */
.skip-link {
    @apply visually-hidden-focusable;
}
```

---

## 🔐 Security Architecture

### Content Security

#### JSON Content Validation

```php
// Cms/Actions/Content/GetContentAction.php

declare(strict_types=1);

namespace Modules\Cms\Actions\Content;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class GetContentAction
{
    use QueueableAction;

    public function execute(string $pageSlug): array
    {
        $filePath = $this->getFilePath($pageSlug);
        
        $this->validateFileExists($filePath);
        $this->validateFileType($filePath);
        
        $content = File::get($filePath);
        $data = json_decode($content, true);
        
        $this->validateJsonStructure($data);
        $this->sanitizeBlockData($data);
        
        return $data;
    }
    
    private function getFilePath(string $pageSlug): string
    {
        $basePath = config_path('local/' . $this->getTenant() . '/database/content/pages/');
        return $basePath . $pageSlug . '.json';
    }
    
    private function validateFileExists(string $filePath): void
    {
        if (!File::exists($filePath)) {
            throw new InvalidArgumentException("Content file not found: {$filePath}");
        }
    }
    
    private function validateFileType(string $filePath): void
    {
        $extension = File::extension($filePath);
        if ($extension !== 'json') {
            throw new InvalidArgumentException("Invalid file type: {$extension}");
        }
    }
    
    private function validateJsonStructure(?array $data): void
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException("Invalid JSON structure");
        }
        
        if (!isset($data['slug'])) {
            throw new InvalidArgumentException("Missing 'slug' key");
        }
        
        if (!isset($data['blocks']) || !is_array($data['blocks'])) {
            throw new InvalidArgumentException("Missing or invalid 'blocks' array");
        }
    }
    
    private function sanitizeBlockData(array &$data): void
    {
        foreach ($data['blocks'] as &$block) {
            if (isset($block['data']) && is_array($block['data'])) {
                $block['data'] = $this->sanitizeArray($block['data']);
            }
        }
    }
    
    private function sanitizeArray(array $array): array
    {
        return array_map(function ($value) {
            if (is_array($value)) {
                return $this->sanitizeArray($value);
            }
            if (is_string($value)) {
                return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            return $value;
        }, $array);
    }
    
    private function getTenant(): string
    {
        // Extract tenant from APP_URL
        $appUrl = config('app.url');
        $parsed = parse_url($appUrl);
        $host = $parsed['host'] ?? 'localhost';
        $host = str_replace('www.', '', $host);
        $parts = array_reverse(explode('.', $host));
        return implode('/', $parts);
    }
}
```

---

## ⚡ Performance Architecture

### Vite Build Optimization

**File:** `laravel/Themes/Sixteen/vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: true,
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
                style: resolve(__dirname, 'resources/css/app.css'),
            },
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },
        minify: 'esbuild',
        target: 'esnext',
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
    ],
    css: {
        postcss: './postcss.config.cjs',
    },
});
```

### Tailwind Purge Configuration

**File:** `laravel/Themes/Sixteen/tailwind.config.js`

```javascript
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './Main_files/**/*.html',
        './Main_files/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                'it-primary': '#0066CC',
                'it-secondary': '#5C6670',
                'it-accent': '#00C73C',
                'it-warning': '#FF9800',
                'it-danger': '#DC3545',
                'it-gray-50': '#F7F8F9',
                'it-gray-100': '#EDEFF0',
                'it-gray-200': '#DDE1E3',
                'it-gray-500': '#5C6670',
                'it-gray-900': '#1C262C',
            },
        },
    },
    plugins: [],
};
```

### Lazy Loading Strategy

```blade
{{-- Lazy load images in blocks --}}
<img 
    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
    data-src="{{ $imageUrl }}"
    alt="{{ $imageAlt }}"
    loading="lazy"
    class="lazy-load"
/>

<script>
// Alpine.js lazy load component
document.addEventListener('alpine:init', () => {
    Alpine.data('lazyLoad', () => ({
        init() {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        this.observer.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img.lazy-load').forEach(img => {
                this.observer.observe(img);
            });
        }
    }));
});
</script>
```

---

## 🧪 Testing Architecture

### Pest Test Structure

**File:** `laravel/Themes/Sixteen/tests/Feature/Blocks/HeroBlockTest.php`

```php
<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('renders hero block with correct HTML structure', function () {
    $data = [
        'title' => 'Test Hero',
        'subtitle' => 'Test Subtitle',
        'backgroundImage' => '/images/test.jpg',
    ];

    $html = view('pub_theme::components.blocks.hero.default', ['data' => $data])
        ->render();

    expect($html)
        ->toContain('<div class="it-hero-wrapper it-dark it-overlay">')
        ->toContain('<h1 class="no_toc">Test Hero</h1>')
        ->toContain('<p class="d-none d-lg-block">Test Subtitle</p>')
        ->toContain('<img src="/images/test.jpg"');
});

it('renders hero block without background image', function () {
    $data = [
        'title' => 'Test Hero',
        'subtitle' => 'Test Subtitle',
    ];

    $html = view('pub_theme::components.blocks.hero.default', ['data' => $data])
        ->render();

    expect($html)
        ->toContain('<div class="it-hero-wrapper it-dark it-overlay">')
        ->not->toContain('<img');
});
```

### Accessibility Tests

**File:** `laravel/Themes/Sixteen/tests/Feature/Accessibility/HomepageAccessibilityTest.php`

```php
<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('has skip links', function () {
    $response = get('/it/tests/homepage');
    
    $response->assertSee('Vai ai contenuti', escape: false);
    $response->assertSee('Vai al footer', escape: false);
});

it('has proper heading hierarchy', function () {
    $response = get('/it/tests/homepage');
    
    $html = $response->content();
    
    // Check H1 exists
    expect($html)->toContain('<h1');
    
    // Check H1 comes before H2
    $h1Position = strpos($html, '<h1');
    $h2Position = strpos($html, '<h2');
    expect($h1Position)->toBeLessThan($h2Position);
});

it('has ARIA labels on navigation', function () {
    $response = get('/it/tests/homepage');
    
    $response->assertSee('aria-label="navigation"', escape: false);
    $response->assertSee('aria-label="breadcrumb"', escape: false);
});
```

---

## 📊 Database Schema

### Content Management Tables

```sql
-- Content pages (for dynamic content)
CREATE TABLE cms_content_pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    meta_title VARCHAR(255),
    meta_description TEXT,
    json_content JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Block templates (reusable block definitions)
CREATE TABLE cms_block_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    schema_json JSON NOT NULL,
    example_json JSON NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default block templates
INSERT INTO cms_block_templates (type, name, description, schema_json, example_json) VALUES
('hero', 'Hero Section', 'Hero section with title, subtitle, and background image', 
 '{"type": "object", "properties": {"title": {"type": "string"}, "subtitle": {"type": "string"}, "backgroundImage": {"type": "string"}}}',
 '{"title": "NOME DEL COMUNE", "subtitle": "CONTENUTI IN EVIDENZA", "backgroundImage": "/images/hero.jpg"}'),

('topics-grid', 'Topics Grid', 'Grid of topic cards with icons', 
 '{"type": "object", "properties": {"topics": {"type": "array", "items": {"type": "object", "properties": {"title": {"type": "string"}, "icon": {"type": "string"}, "url": {"type": "string"}}}}}}',
 '{"topics": [{"title": "Cultura", "icon": "it-culture", "url": "/it/cultura"}]}'),

('card', 'Card Component', 'Generic card with image, title, description', 
 '{"type": "object", "properties": {"title": {"type": "string"}, "description": {"type": "string"}, "image": {"type": "string"}, "url": {"type": "string"}}}',
 '{"title": "Card Title", "description": "Card description", "image": "/images/card.jpg", "url": "/it/page"}');
```

---

## 🔗 Cross-References

### Internal Documents

- → [PRD](_bmad-output/design-comuni-prd.md) - Product requirements
- → [UI Specification](_bmad-output/design-comuni-ui-spec.md) - Component specs
- → [Epics & Stories](_bmad-output/design-comuni-epics.md) - Implementation tasks
- → [Sprint Plan](_bmad-output/design-comuni-sprint-plan.md) - Timeline
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide

### Project Documentation

- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md) - Theme documentation
- → [Layout Architecture](laravel/Themes/Sixteen/docs/layout-architecture.md) - Layout system
- → [Vite Build System](laravel/Themes/Sixteen/docs/VITE_MANIFEST_FIX_COMPLETE.md) - Build process

### External Resources

- → [Design Comuni Pagine Statiche](https://italia.github.io/design-comuni-pagine-statiche/)
- → [Bootstrap Italia Documentation](https://italia.github.io/bootstrap-italia/)
- → [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- → [Laravel Folio Documentation](https://laravel.com/docs/folio)
- → [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)

---

## 📋 Decision Log

### Architectural Decisions

| ID | Decision | Rationale | Consequences |
|----|----------|-----------|--------------|
| AD-1 | Single `[slug].blade.php` | DRY, KISS, maintainability | All pages use same file |
| AD-2 | JSON Content Blocks | Separation of concerns | Easy content updates |
| AD-3 | Universal Blocks | Reusability, no duplication | Blocks NOT page-specific |
| AD-4 | Tailwind @apply | Performance, no Bootstrap CSS | Smaller bundle size |
| AD-5 | Alpine.js | Lightweight, no Bootstrap JS | Better performance |
| AD-6 | `<x-layouts.app>` | Consistency, DRY | Single layout system |
| AD-7 | `<x-section>` components | Reusability | Header/Footer centralized |

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Next Review:** UI Specification
**🎯 Status:** Ready for UI Spec

🐮 **Architecture Design Complete - Ready for next BMad phase!**
