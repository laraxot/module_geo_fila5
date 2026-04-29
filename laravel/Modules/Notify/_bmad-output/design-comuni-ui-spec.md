# 🎨 Design Comuni Italia - UI Specification

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔄 **In Progress**
**Priority:** 🔴 **CRITICAL**
**Version:** 2.0 - Updated with Block Analysis

---

## 📋 Executive Summary

Questo documento definisce le specifiche UI per i componenti Design Comuni, con:

- ✅ **Component Specifications** - Props, slots, events
- ✅ **Visual Design** - Colors, typography, spacing
- ✅ **Accessibility** - WCAG 2.1 AA requirements
- ✅ **Responsive Design** - Mobile-first approach
- ✅ **Interaction Patterns** - Hover, focus, active states
- ✅ **47 Componenti Identificati** - Da analisi completa 38 pagine

**⚠️ IMPORTANTE:** Questo documento è stato aggiornato con i risultati dell'analisi completa dei blocchi. Vedi [Block Analysis](design-comuni-block-analysis.md) per i dettagli completi.

---

## 🧩 Component Catalog (Updated)

### Tier 1 - Fondamentali (Implementare Subito)

Questi 7 componenti appaiono nel 95%+ delle pagine:

| # | Component | Usage % | Pages | Priority |
|---|-----------|---------|-------|----------|
| 1 | `cmp-base/base` | 100% | Tutte | 🔴 Critical |
| 2 | `cmp-breadcrumbs` | 97% | Tutte tranne homepage | 🔴 Critical |
| 3 | `cmp-contacts/*` | 95% | Footer | 🔴 Critical |
| 4 | `cmp-rating` | 87% | Feedback | 🔴 Critical |
| 5 | `cmp-hero/*` | 79% | Hero sections | 🔴 Critical |
| 6 | `cmp-card/*` | 92% | Content cards | 🔴 Critical |
| 7 | `cmp-button` | 85% | Actions | 🔴 Critical |

---

### Tier 2 - Navigazione (5 componenti)

| # | Component | Usage % | Pages | Priority |
|---|-----------|---------|-------|----------|
| 8 | `cmp-navscroll` | 58% | Dettaglio, Form | 🟠 High |
| 9 | `cmp-nav-steps` | 32% | Multi-step forms | 🟠 High |
| 10 | `cmp-info-progress` | 29% | Progress indicator | 🟠 High |
| 11 | `cmp-nav-tab` | 3% | Area personale | 🟡 Medium |
| 12 | `cmp-category-list` | 13% | Category navigation | 🟡 Medium |

---

### Tier 3 - Form & Input (10 componenti)

| # | Component | Usage % | Pages | Priority |
|---|-----------|---------|-------|----------|
| 13 | `cmp-input/input` | 21% | Forms | 🟠 High |
| 14 | `cmp-select/select` | 26% | Dropdown forms | 🟠 High |
| 15 | `cmp-text-area` | 13% | Long text forms | 🟠 High |
| 16 | `cmp-input-autocomplete` | 3% | Segnalazione luogo | 🟡 Medium |
| 17 | `cmp-info-radio` | 11% | Radio selection | 🟡 Medium |
| 18 | `cmp-card-radio-list` | 3% | Appuntamento | 🟡 Medium |
| 19 | `cmp-info-button-card` | 26% | Expandable info | 🟠 High |
| 20 | `cmp-info-summary` | 21% | Summary/review | 🟠 High |
| 21 | `cmp-info-summary-no-modify` | 16% | Read-only summary | 🟡 Medium |
| 22 | `cmp-callout` | 5% | Alerts/warnings | 🟡 Medium |

---

### Tier 4 - Card & Content (12 componenti)

| # | Component | Usage % | Pages | Priority |
|---|-----------|---------|-------|----------|
| 23 | `cmp-card-simple` | 70%+ | Lists, categories | 🔴 Critical |
| 24 | `cmp-card-latest-messages` | 53% | Dynamic lists | 🟠 High |
| 25 | `cmp-card-teaser` | 24% | Previews | 🟠 High |
| 26 | `cmp-card-content-box` | 66% | Form containers | 🟠 High |
| 27 | `cmp-card-img` | 13% | Image cards | 🟡 Medium |
| 28 | `cmp-list-card-img-hr` | 21% | Horizontal lists | 🟠 High |
| 29 | `cmp-list-card-img` | 13% | Vertical lists | 🟡 Medium |
| 30 | `cmp-list-card-docs` | 5% | Document lists | 🟡 Medium |
| 31 | `cmp-ul-list` | 8% | Bullet lists | 🟡 Medium |
| 32 | `cmp-icon-link` | 11% | Icon links | 🟡 Medium |
| 33 | `cmp-icon-list` | 11% | Icon lists | 🟡 Medium |
| 34 | `cmp-tag` | 39% | Tags/topics | 🟠 High |

---

### Tier 5 - Specialized (13 componenti)

| # | Component | Usage % | Pages | Priority |
|---|-----------|---------|-------|----------|
| 35 | `cmp-accordion` | 11% | FAQ, expandable | 🟡 Medium |
| 36 | `cmp-accordion-faq` | 3% | FAQ page | 🟡 Medium |
| 37 | `cmp-filter` | 5% | Filters | 🟡 Medium |
| 38 | `cmp-modal/*` | 21% | Modals | 🟠 High |
| 39 | `cmp-carousel` | 13% | Related content | 🟡 Medium |
| 40 | `cmp-timeline` | 3% | Service timeline | 🟡 Medium |
| 41 | `cmp-map` | 5% | Maps | 🟡 Medium |
| 42 | `cmp-heading/*` | 26% | Page headers | 🟠 High |
| 43 | `cmp-heading-detail` | 11% | Detail headers | 🟡 Medium |
| 44 | `cmp-text-button` | 8% | Text CTAs | 🟡 Medium |
| 45 | `cmp-hero-img-small` | 5% | Small hero images | 🟡 Medium |
| 46 | `cmp-input-search` | 18% | Search inputs | 🟠 High |
| 47 | `cmp-data-element` | 40%+ | Data attributes | 🟠 High |

---

## 📊 Component Implementation Priority

### Phase 1: Foundation (Sprint 1-2)

**7 componenti fondamentali** (appartengono al 95%+ pagine)

```
1. cmp-base/base         → Layout wrapper (x-layouts.app)
2. cmp-breadcrumbs       → Navigation helper
3. cmp-contacts/*        → Footer contacts
4. cmp-rating            → Feedback component
5. cmp-hero/*            → Hero sections
6. cmp-card/*            → Base card component
7. cmp-button            → Action buttons
```

### Phase 2: Navigation (Sprint 2-3)

**5 componenti navigazione**

```
8. cmp-navscroll         → Page index/navigation
9. cmp-nav-steps         → Multi-step progress
10. cmp-info-progress    → Progress indicator
11. cmp-nav-tab          → Tab navigation
12. cmp-category-list    → Category navigation
```

### Phase 3: Forms (Sprint 3-4)

**10 componenti form**

```
13. cmp-input/input       → Text inputs
14. cmp-select/select     → Dropdown selects
15. cmp-text-area         → Textarea inputs
16. cmp-info-button-card  → Expandable info
17. cmp-info-summary      → Summary cards
18. [altri form components]
```

### Phase 4: Content Cards (Sprint 4-5)

**12 componenti card**

```
23. cmp-card-simple          → Simple cards
24. cmp-card-latest-messages → Dynamic cards
25. cmp-card-teaser          → Teaser cards
26. cmp-list-card-img-hr     → Horizontal lists
[etc...]
```

### Phase 5: Specialized (Sprint 5-6)

**13 componenti specializzati**

```
38. cmp-modal/*         → Modal dialogs
39. cmp-carousel        → Content carousel
41. cmp-map             → Map integration
[etc...]
```

---

## 🎨 Design Tokens

### Color Palette

#### Primary Colors

| Token | Name | Hex | RGB | Tailwind | Usage |
|-------|------|-----|-----|----------|-------|
| `--it-primary` | Italia Blue | `#0066CC` | `rgb(0, 102, 204)` | `bg-it-primary` | Primary buttons, links |
| `--it-primary-dark` | Dark Blue | `#0053A3` | `rgb(0, 83, 163)` | `bg-it-primary-dark` | Hover states |
| `--it-primary-light` | Light Blue | `#3388DD` | `rgb(51, 136, 221)` | `bg-it-primary-light` | Active states |

#### Secondary Colors

| Token | Name | Hex | RGB | Tailwind | Usage |
|-------|------|-----|-----|----------|-------|
| `--it-secondary` | Gray Dark | `#5C6670` | `rgb(92, 102, 112)` | `bg-it-secondary` | Secondary buttons |
| `--it-secondary-dark` | Charcoal | `#424950` | `rgb(66, 73, 80)` | `bg-it-secondary-dark` | Hover states |

#### Accent Colors

| Token | Name | Hex | RGB | Tailwind | Usage |
|-------|------|-----|-----|----------|-------|
| `--it-accent` | Success Green | `#00C73C` | `rgb(0, 199, 60)` | `bg-it-accent` | Success, positive |
| `--it-warning` | Warning Orange | `#FF9800` | `rgb(255, 152, 0)` | `bg-it-warning` | Warnings |
| `--it-danger` | Error Red | `#DC3545` | `rgb(220, 53, 69)` | `bg-it-danger` | Errors, alerts |
| `--it-info` | Info Blue | `#17A2B8` | `rgb(23, 162, 184)` | `bg-it-info` | Information |

#### Neutral Colors

| Token | Name | Hex | RGB | Tailwind | Usage |
|-------|------|-----|-----|----------|-------|
| `--it-gray-50` | White Smoke | `#F7F8F9` | `rgb(247, 248, 249)` | `bg-it-gray-50` | Backgrounds |
| `--it-gray-100` | Light Gray | `#EDEFF0` | `rgb(237, 239, 240)` | `bg-it-gray-100` | Borders |
| `--it-gray-200` | Silver | `#DDE1E3` | `rgb(221, 225, 227)` | `bg-it-gray-200` | Dividers |
| `--it-gray-300` | Gray | `#B1B9BE` | `rgb(177, 185, 190)` | `bg-it-gray-300` | Disabled |
| `--it-gray-500` | Dim Gray | `#5C6670` | `rgb(92, 102, 112)` | `text-it-gray-500` | Secondary text |
| `--it-gray-700` | Dark Gray | `#3D464D` | `rgb(61, 70, 77)` | `text-it-gray-700` | Body text |
| `--it-gray-900` | Black Smoke | `#1C262C` | `rgb(28, 38, 44)` | `text-it-gray-900` | Headings |

### Typography Scale

#### Font Families

```css
/* Primary Font - Titillium Web (Headings) */
--font-titillium: 'Titillium Web', sans-serif;

/* Secondary Font - Lato (Body) */
--font-lato: 'Lato', sans-serif;

/* Monospace - Roboto Mono (Code) */
--font-mono: 'Roboto Mono', monospace;
```

#### Heading Sizes

| Element | Size | Weight | Line Height | Letter Spacing | Tailwind |
|---------|------|--------|-------------|----------------|----------|
| H1 | `2.5rem` (40px) | 700 | 1.2 | -0.02em | `text-4xl` |
| H2 | `2rem` (32px) | 700 | 1.25 | -0.01em | `text-3xl` |
| H3 | `1.75rem` (28px) | 600 | 1.3 | 0 | `text-2xl` |
| H4 | `1.5rem` (24px) | 600 | 1.35 | 0 | `text-xl` |
| H5 | `1.25rem` (20px) | 600 | 1.4 | 0 | `text-lg` |
| H6 | `1rem` (16px) | 600 | 1.45 | 0 | `text-base` |

#### Body Text Sizes

| Name | Size | Weight | Line Height | Usage | Tailwind |
|------|------|--------|-------------|-------|----------|
| Large | `1.125rem` (18px) | 400 | 1.7 | Lead text | `text-lg` |
| Base | `1rem` (16px) | 400 | 1.6 | Body copy | `text-base` |
| Small | `0.875rem` (14px) | 400 | 1.5 | Captions | `text-sm` |
| XSmall | `0.75rem` (12px) | 400 | 1.4 | Fine print | `text-xs` |

### Spacing Scale

| Name | Token | Pixels | Rem | Tailwind | Usage |
|------|-------|--------|-----|----------|-------|
| xs | `--space-1` | 4px | 0.25rem | `1` | Tight spacing |
| sm | `--space-2` | 8px | 0.5rem | `2` | Small gaps |
| md | `--space-3` | 12px | 0.75rem | `3` | Medium gaps |
| lg | `--space-4` | 16px | 1rem | `4` | Standard padding |
| xl | `--space-5` | 24px | 1.5rem | `5` | Large sections |
| 2xl | `--space-6` | 32px | 2rem | `6` | Extra large |
| 3xl | `--space-8` | 48px | 3rem | `8` | Hero sections |
| 4xl | `--space-10` | 64px | 4rem | `10` | Page sections |
| 5xl | `--space-12` | 96px | 6rem | `12` | Major sections |

### Border Radius

| Name | Value | Tailwind | Usage |
|------|-------|----------|-------|
| sm | `0.25rem` (4px) | `rounded-sm` | Small elements |
| md | `0.5rem` (8px) | `rounded-md` | Cards, buttons |
| lg | `0.75rem` (12px) | `rounded-lg` | Large cards |
| xl | `1rem` (16px) | `rounded-xl` | Hero, modals |
| 2xl | `1.5rem` (24px) | `rounded-2xl` | Extra large |
| full | `9999px` | `rounded-full` | Avatars, pills |

### Shadow System

| Name | Value | Tailwind | Usage |
|------|-------|----------|-------|
| sm | `0 1px 2px rgba(0,0,0,0.05)` | `shadow-sm` | Small cards |
| md | `0 4px 6px rgba(0,0,0,0.1)` | `shadow-md` | Cards, dropdowns |
| lg | `0 10px 15px rgba(0,0,0,0.1)` | `shadow-lg` | Modals, popovers |
| xl | `0 20px 25px rgba(0,0,0,0.15)` | `shadow-xl` | Large modals |
| 2xl | `0 25px 50px rgba(0,0,0,0.25)` | `shadow-2xl` | Hero overlays |

---

## 🧩 Component Specifications

### 1. Header Component

**File:** `resources/views/components/sections/header/default.blade.php`

#### Props

```php
@props([
    'regionName' => 'Nome della Regione',
    'comuneName' => 'Nome del Comune',
    'comuneSlogan' => 'Un comune da vivere',
    'showLanguageSelector' => true,
    'showLogin' => true,
    'socialLinks' => [],
    'menuItems' => [],
])
```

#### Structure

```blade
<header class="it-header-wrapper" role="banner">
    {{-- Skip Links --}}
    <a class="visually-hidden-focusable" href="#main-content">Vai ai contenuti</a>
    <a class="visually-hidden-focusable" href="#footer">Vai al footer</a>

    {{-- Top Bar --}}
    <div class="it-top-nav-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-3">
                    <span class="top-nav-region">{{ $regionName }}</span>
                </div>
                <div class="col-6 col-md-3 offset-md-6 text-right">
                    @if($showLanguageSelector)
                    <select class="form-control form-control-sm" aria-label="Seleziona lingua">
                        <option value="it" selected>ITA</option>
                        <option value="en">ENG</option>
                    </select>
                    @endif
                    
                    @if($showLogin)
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                        <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-user"></use></svg>
                        Accedi all'area personale
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Header Slim --}}
    <div class="it-header-slim-wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3 col-md-2">
                    <div class="it-header-slim-logo">
                        <img src="/images/stem.svg" alt="Stemma del Comune">
                    </div>
                </div>
                <div class="col-9 col-md-8">
                    <div class="it-header-slim-content">
                        <h1 class="it-header-slim-title">{{ $comuneName }}</h1>
                        @if($comuneSlogan)
                        <p class="it-header-slim-slogan">{{ $comuneSlogan }}</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="it-header-slim-social">
                        @foreach($socialLinks as $link)
                        <a href="{{ $link['url'] }}" class="btn btn-sm" aria-label="{{ $link['label'] }}">
                            <svg class="icon icon-sm"><use href="/svg/sprites.svg#{{ $link['icon'] }}"></use></svg>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="navbar navbar-expand-lg" role="navigation" aria-label="Navigazione principale">
        <div class="container">
            <button class="custom-navbar-toggler" type="button" aria-controls="nav10" aria-expanded="false" aria-label="Toggle navigation">
                <svg class="icon"><use href="/svg/sprites.svg#it-burger"></use></svg>
            </button>
            
            <div class="navbar-collapsable" id="nav10">
                <div class="overlay"></div>
                <div class="close-div sr-only">
                    <button class="btn close-menu" type="button"><span class="it-close"></span>close</button>
                </div>
                
                <div class="menu-wrapper">
                    <ul class="navbar-nav">
                        @foreach($menuItems as $item)
                        <li class="nav-item @if($item['children']) dropdown @endif">
                            <a class="nav-link @if($item['active']) active @endif" 
                               href="{{ $item['url'] }}"
                               @if($item['children']) aria-haspopup="true" aria-expanded="false" @endif>
                                <span>{{ $item['label'] }}</span>
                                @if($item['children'])
                                <svg class="icon icon-xs"><use href="/svg/sprites.svg#it-expand"></use></svg>
                                @endif
                            </a>
                            
                            @if($item['children'])
                            <div class="dropdown-menu">
                                <div class="link-list-wrapper">
                                    <ul class="link-list">
                                        @foreach($item['children'] as $child)
                                        <li>
                                            <a href="{{ $child['url'] }}">
                                                <span>{{ $child['label'] }}</span>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
```

#### Accessibility Requirements

- ✅ **Skip Links** - First focusable elements
- ✅ **ARIA Labels** - `role="banner"`, `aria-label` su navigation
- ✅ **Keyboard Navigation** - Tab order logica
- ✅ **Focus Indicators** - Visibili e chiari
- ✅ **Screen Reader** - Testi descrittivi per icone

#### Responsive Behavior

| Breakpoint | Behavior |
|------------|----------|
| Mobile (<768px) | Hamburger menu, logo ridotto |
| Tablet (768px-991px) | Menu esteso parziale |
| Desktop (≥992px) | Menu completo, tutti gli elementi |

---

### 2. Hero Component

**File:** `resources/views/components/blocks/hero/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $title = $data['title'] ?? 'Default Title';
    $subtitle = $data['subtitle'] ?? '';
    $backgroundImage = $data['backgroundImage'] ?? null;
    $overlay = $data['overlay'] ?? true;
    $theme = $data['theme'] ?? 'dark';
@endphp
```

#### Structure

```blade
<div class="it-hero-wrapper it-{{ $theme }} @if($overlay) it-overlay @endif">
    @if($backgroundImage)
    <div class="img-responsive-wrapper">
        <div class="img-responsive">
            <div class="img-wrapper">
                <img 
                    src="{{ $backgroundImage }}" 
                    alt="{{ $title }}"
                    loading="lazy"
                >
            </div>
        </div>
    </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="it-hero-text-wrapper bg-{{ $theme }}">
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

#### Variants

```blade
{{-- Hero with Image --}}
<x-pub_theme::components.blocks.hero.default 
    :data="[
        'title' => 'NOME DEL COMUNE',
        'subtitle' => 'CONTENUTI IN EVIDENZA',
        'backgroundImage' => '/themes/sixteen/images/hero-bg.jpg',
        'theme' => 'dark',
        'overlay' => true
    ]" 
/>

{{-- Hero without Image --}}
<x-pub_theme::components.blocks.hero.default 
    :data="[
        'title' => 'Benvenuto',
        'subtitle' => 'Scopri i servizi del comune',
        'theme' => 'light'
    ]" 
/>
```

---

### 3. Topics Grid Component

**File:** `resources/views/components/blocks/topics-grid/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $title = $data['title'] ?? 'Argomenti';
    $topics = $data['topics'] ?? [];
    $showAllUrl = $data['showAllUrl'] ?? '/it/argomenti';
@endphp
```

#### Structure

```blade
<section class="py-5">
    <div class="container">
        @if($title)
        <h2 class="mb-4">{{ $title }}</h2>
        @endif

        <div class="row g-4">
            @foreach($topics as $topic)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-teaser shadow p-4 rounded border border-light">
                    <svg class="icon">
                        <use href="/svg/sprites.svg#{{ $topic['icon'] }}"></use>
                    </svg>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ $topic['url'] }}">{{ $topic['title'] }}</a>
                        </h5>
                        
                        @if($topic['description'])
                        <p class="card-text">{{ $topic['description'] }}</p>
                        @endif

                        @if($topic['list'] ?? false)
                        <ul class="link-list">
                            @foreach($topic['list'] as $item)
                            <li>
                                <a href="{{ $item['url'] }}">
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($showAllUrl)
        <div class="text-center mt-5">
            <a href="{{ $showAllUrl }}" class="btn btn-primary">
                Mostra tutti
                <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-arrow-right"></use></svg>
            </a>
        </div>
        @endif
    </div>
</section>
```

---

### 4. Card Component

**File:** `resources/views/components/blocks/card/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $variant = $data['variant'] ?? 'default'; // default, with-image, with-icon
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    $image = $data['image'] ?? null;
    $icon = $data['icon'] ?? null;
    $url = $data['url'] ?? '#';
    $date = $data['date'] ?? null;
    $category = $data['category'] ?? null;
@endphp
```

#### Structure (Default Variant)

```blade
<div class="card card-teaser shadow p-4 rounded border border-light">
    @if($icon)
    <svg class="icon">
        <use href="/svg/sprites.svg#{{ $icon }}"></use>
    </svg>
    @endif

    @if($image)
    <div class="img-responsive mb-3">
        <div class="img-wrapper">
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy">
        </div>
    </div>
    @endif

    <div class="card-body">
        @if($category)
        <div class="category-top mb-2">
            <span class="badge badge-pill badge-outline-primary">{{ $category }}</span>
        </div>
        @endif

        <h5 class="card-title">
            <a href="{{ $url }}">{{ $title }}</a>
        </h5>

        @if($date)
        <p class="card-text text-muted small">
            <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-calendar"></use></svg>
            {{ $date }}
        </p>
        @endif

        @if($description)
        <p class="card-text">{{ $description }}</p>
        @endif
    </div>
</div>
```

---

### 5. News Section Component

**File:** `resources/views/components/blocks/news-section/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $title = $data['title'] ?? 'Notizie';
    $items = $data['items'] ?? [];
    $viewAllUrl = $data['viewAllUrl'] ?? '/it/novita';
@endphp
```

#### Structure

```blade
<section class="py-5 bg-it-gray-50">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-3">{{ $title }}</h2>
            </div>
        </div>

        <div class="row g-4">
            @foreach($items as $item)
            <div class="col-12 col-md-6 col-lg-4">
                <x-pub_theme::components.blocks.card.default 
                    :data="[
                        'variant' => 'with-image',
                        'title' => $item['title'],
                        'description' => $item['description'],
                        'image' => $item['image'] ?? null,
                        'date' => $item['date'] ?? null,
                        'url' => $item['url'] ?? '#'
                    ]" 
                />
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ $viewAllUrl }}" class="btn btn-primary">
                Tutte le novità
                <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-arrow-right"></use></svg>
            </a>
        </div>
    </div>
</section>
```

---

### 6. Governance Section Component

**File:** `resources/views/components/blocks/governance-section/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $title = $data['title'] ?? 'Organi di governo';
    $cards = $data['cards'] ?? [];
@endphp
```

#### Structure

```blade
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">{{ $title }}</h2>

        <div class="row g-4">
            @foreach($cards as $card)
            <div class="col-12 col-md-4">
                <div class="card card-teaser shadow p-4 rounded border border-light h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $card['title'] }}</h5>
                        <p class="card-text text-muted">{{ $card['role'] }}</p>
                        
                        @if($card['description'])
                        <p class="card-text">{{ $card['description'] }}</p>
                        @endif

                        <a href="{{ $card['url'] }}" class="btn btn-outline-primary mt-3">
                            Vai alla pagina
                            <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-arrow-right"></use></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
```

---

### 7. Events List Component

**File:** `resources/views/components/blocks/events-list/default.blade.php`

#### Props

```php
@props([
    'data' => [],
])

@php
    $title = $data['title'] ?? 'Eventi';
    $month = $data['month'] ?? '';
    $events = $data['events'] ?? [];
    $viewAllUrl = $data['viewAllUrl'] ?? '/it/eventi';
@endphp
```

#### Structure

```blade
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-3">{{ $title }}</h2>
                @if($month)
                <h4 class="text-muted">{{ $month }}</h4>
                @endif
            </div>
        </div>

        <div class="calendar-wrapper">
            <div class="row g-3">
                @foreach($events as $event)
                <div class="col-12">
                    <div class="card card-teaser shadow-sm p-3 rounded border border-light">
                        <div class="card-body d-flex align-items-center">
                            <div class="event-date me-4 text-center">
                                <span class="day d-block h3 mb-0">{{ $event['day'] }}</span>
                                <span class="month text-uppercase small">{{ $event['month'] }}</span>
                            </div>
                            <div class="event-info">
                                <h5 class="mb-1">
                                    <a href="{{ $event['url'] }}">{{ $event['title'] }}</a>
                                </h5>
                                @if($event['time'])
                                <p class="text-muted small mb-0">
                                    <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-time"></use></svg>
                                    {{ $event['time'] }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ $viewAllUrl }}" class="btn btn-primary">
                Tutti gli eventi
                <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-arrow-right"></use></svg>
            </a>
        </div>
    </div>
</section>
```

---

### 8. Footer Component

**File:** `resources/views/components/sections/footer/default.blade.php`

#### Props

```php
@props([
    'comuneName' => 'NOME DEL COMUNE',
    'address' => '',
    'vatId' => '',
    'taxCode' => '',
    'phone' => '',
    'email' => '',
    'pec' => '',
    'socialLinks' => [],
    'footerLinks' => [],
])
```

#### Structure

```blade
<footer id="footer" class="it-footer" role="contentinfo">
    <div class="it-footer-main">
        <div class="container">
            <div class="row g-4">
                {{-- Branding --}}
                <div class="col-12 col-md-4">
                    <div class="it-brand-wrapper">
                        <div class="it-brand-text">
                            <h2 class="no_toc">{{ $comuneName }}</h2>
                        </div>
                    </div>
                </div>

                {{-- Column 1: Amministrazione --}}
                <div class="col-12 col-md-4 col-lg-2">
                    <h4 class="no_toc">Amministrazione</h4>
                    <ul class="link-list">
                        @foreach($footerLinks['amministrazione'] ?? [] as $link)
                        <li>
                            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Column 2: Servizi --}}
                <div class="col-12 col-md-4 col-lg-2">
                    <h4 class="no_toc">Servizi</h4>
                    <ul class="link-list">
                        @foreach($footerLinks['servizi'] ?? [] as $link)
                        <li>
                            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Column 3: Novità --}}
                <div class="col-12 col-md-4 col-lg-2">
                    <h4 class="no_toc">Novità</h4>
                    <ul class="link-list">
                        @foreach($footerLinks['novita'] ?? [] as $link)
                        <li>
                            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Column 4: Contatti --}}
                <div class="col-12 col-md-4 col-lg-2">
                    <h4 class="no_toc">Contatti</h4>
                    <div class="contact-info">
                        @if($address)
                        <p><svg class="icon icon-sm"><use href="/svg/sprites.svg#it-map-marker"></use></svg> {{ $address }}</p>
                        @endif
                        
                        @if($phone)
                        <p>
                            <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-telephone"></use></svg>
                            <a href="tel:{{ $phone }}">{{ $phone }}</a>
                        </p>
                        @endif

                        @if($email)
                        <p>
                            <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-mail"></use></svg>
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </p>
                        @endif

                        @if($pec)
                        <p>
                            <svg class="icon icon-sm"><use href="/svg/sprites.svg#it-certification"></use></svg>
                            <a href="mailto:{{ $pec }}">{{ $pec }}</a>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Legal Bar --}}
    <div class="it-footer-small-prints">
        <div class="container">
            <ul class="list-inline text-center">
                @foreach($footerLinks['legal'] ?? [] as $link)
                <li class="list-inline-item">
                    <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</footer>
```

---

## 🎯 Accessibility Requirements

### WCAG 2.1 Level AA Compliance

#### 1. Perceivable

- ✅ **Text Alternatives** - Alt text per tutte le immagini
- ✅ **Time-based Media** - Transcript per video
- ✅ **Adaptable** - Content riorganizzabile
- ✅ **Distinguishable** - Contrasto minimo 4.5:1

#### 2. Operable

- ✅ **Keyboard Accessible** - Tutte le funzioni da tastiera
- ✅ **Enough Time** - Tempo sufficiente per lettura
- ✅ **Seizures** - No contenuti lampeggianti
- ✅ **Navigable** - Breadcrumbs, skip links, focus order

#### 3. Understandable

- ✅ **Readable** - Linguaggio chiaro e semplice
- ✅ **Predictable** - Comportamento consistente
- ✅ **Input Assistance** - Errori form chiari

#### 4. Robust

- ✅ **Compatible** - Screen reader, browser, device
- ✅ **Valid HTML** - Markup semantico corretto
- ✅ **ARIA** - Ruoli, stati, proprietà corretti

---

## 📱 Responsive Design

### Breakpoints

| Name | Min Width | Max Width | Usage |
|------|-----------|-----------|-------|
| xs | 0px | 575px | Mobile extra small |
| sm | 576px | 767px | Mobile large |
| md | 768px | 991px | Tablet |
| lg | 992px | 1199px | Desktop small |
| xl | 1200px | 1399px | Desktop |
| 2xl | 1400px | ∞ | Desktop large |

### Mobile-First Approach

```blade
{{-- Mobile first, then desktop --}}
<div class="col-12 col-md-6 col-lg-4">
    {{-- Mobile: 100% width --}}
    {{-- Tablet: 50% width --}}
    {{-- Desktop: 33.33% width --}}
</div>
```

---

## 🔗 Cross-References

### Internal Documents

- → [PRD](_bmad-output/design-comuni-prd.md) - Product requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System architecture
- → [Epics & Stories](_bmad-output/design-comuni-epics.md) - Implementation tasks
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide

### Project Documentation

- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md) - Theme documentation
- → [Layout Architecture](laravel/Themes/Sixteen/docs/layout-architecture.md) - Layout system
- → [Tailwind @apply](laravel/Themes/Sixteen/docs/TAILWIND_DESIGN_COMUNI_COMPLETE.md) - Styling guide

### External Resources

- → [Design Comuni Pagine Statiche](https://italia.github.io/design-comuni-pagine-statiche/)
- → [Bootstrap Italia Documentation](https://italia.github.io/bootstrap-italia/)
- → [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- → [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Next Review:** Epics & Stories
**🎯 Status:** Ready for Implementation

🐮 **UI Specification Complete - Ready for next BMad phase!**
