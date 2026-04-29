# Rating & Feedback Block Analysis

**Analysis Date:** 2026-04-08

## Executive Summary

This document analyzes the rating/feedback block implementation patterns for the Design Comuni replication project. The `cmp-rating` component is identified as a **Tier 1 critical component** (87% page coverage — 33 of 38 pages). This analysis covers the required patterns, what NOT to use, and how to handle translations.

---

## Component Overview

### cmp-rating (Rating Block)

| Attribute | Value |
|-----------|-------|
| **Component ID** | R01 |
| **Handlebars Partial** | `{{>cmp-rating/cmp-rating}}` |
| **Usage** | 33/38 pages (87%) |
| **Category** | Feedback & Contatti |
| **Priority** | 🔴 Critical |
| **Description** | Star rating ("stelline") for page feedback |

### Required Props (from Handlebars source)

| Prop | Type | Description |
|------|------|-------------|
| `id-title` | string | Unique ID for accessibility (e.g., `rating-homepage`) |
| `public-template` | boolean | Whether to use the public template variant |

### Pages Using cmp-rating

Appears in almost every page pattern:
- **Pattern 1 (Lista)**: breadcrumbs → hero → cards → button → **rating** → contacts
- **Pattern 2 (Dettaglio)**: breadcrumbs → title → tags → navscroll → content → carousel → **rating** → contacts
- **Pattern 5 (Conferma)**: breadcrumbs → hero (check icon) → confirmation message → **rating** → contacts

---

## What NOT to Use (Bootstrap Italia)

### ❌ Bootstrap Classes to AVOID

The original Design Comuni templates use Bootstrap Italia. These MUST NOT be replicated:

```html
<!-- DON'T USE THESE -->
<div class="container">           <!-- Bootstrap grid -->
<div class="row">                 <!-- Bootstrap row -->
<div class="col-12 col-md-6">     <!-- Bootstrap columns -->
<span class="form-check">         <!-- Bootstrap form elements -->
<svg class="icon icon-sm">        <!-- Bootstrap Italia icon system -->
<use href="/svg/sprites.svg#..."> <!-- Sprite-based icons -->
<div class="rating-wrapper">      <!-- Bootstrap Italia rating component -->
```

### ❌ Handlebars Partials (NOT Blade)

```handlebars
<!-- DON'T USE - Handlebars syntax from upstream -->
{{>cmp-rating}}
{{>cmp-breadcrumbs}}
{{>cmp-contacts}}
```

### ❌ Bootstrap Italia JavaScript

- No `bootstrap-italia.js`
- No jQuery (Bootstrap Italia dependency)
- No `bootstrap.bundle.min.js`

---

## What TO Use (Tailwind CSS + Alpine.js)

### ✅ Tailwind CSS Patterns

**Wrapper Structure:**
```blade
<section class="py-8 border-t border-gray-200">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Rating content -->
        </div>
    </div>
</section>
```

**Star Rating (Tailwind):**
```blade
<div class="flex items-center gap-1" role="radiogroup" aria-label="{{ __('cms::rating.label') }}">
    @foreach(range(1, 5) as $star)
    <button
        type="button"
        class="w-8 h-8 text-gray-300 hover:text-yellow-400 focus:text-yellow-400 transition-colors"
        aria-label="{{ trans_choice('cms::rating.stars', $star) }}"
    >
        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
    </button>
    @endforeach
</div>
```

**Color Tokens (from design system):**
| Purpose | Tailwind Class | Hex |
|---------|---------------|-----|
| Star empty | `text-gray-300` | `#DDE1E3` |
| Star filled | `text-yellow-400` | `#FFC107` (or `text-it-primary` `#0066CC`) |
| Star hover | `hover:text-yellow-400` | - |
| Border | `border-gray-200` | `#DDE1E3` |
| Background | `bg-gray-50` | `#F7F8F9` |

### ✅ Alpine.js Patterns

**Interactive Star Rating (Alpine.js):**
```blade
<div x-data="{ rating: 0, hoverRating: 0, submitted: false }"
     @submit.prevent="submitRating()">
    <div class="flex items-center gap-1" role="radiogroup">
        @foreach(range(1, 5) as $star)
        <button
            type="button"
            @click="rating = {{ $star }}"
            @mouseenter="hoverRating = {{ $star }}"
            @mouseleave="hoverRating = 0"
            :class="(hoverRating || rating) >= {{ $star }} ? 'text-yellow-400' : 'text-gray-300'"
            :aria-checked="rating === {{ $star }}"
            role="radio"
            class="w-8 h-8 transition-colors cursor-pointer"
        >
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </button>
        @endforeach
    </div>

    {{-- Thank you message after submission --}}
    <div x-show="submitted" x-cloak class="mt-4 text-it-gray-700">
        <p>{{ __('cms::rating.thank_you') }}</p>
    </div>
</div>
```

**Key Alpine.js directives used:**
| Directive | Purpose |
|-----------|---------|
| `x-data` | Component state (rating value, hover state, submitted flag) |
| `@click` | Star selection |
| `@mouseenter` / `@mouseleave` | Hover preview effect |
| `:class` | Dynamic filled/empty star styling |
| `x-show` | Show/hide thank you message |
| `x-cloak` | Hide element until Alpine is ready |
| `@submit.prevent` | Form submission handling |

### ✅ Blade Component Structure

**File location:** `resources/views/components/blocks/rating/default.blade.php`

```blade
@props([
    'data' => [],
])

@php
    $idTitle = $data['id-title'] ?? 'rating-' . Str::random(8);
    $actionUrl = $data['actionUrl'] ?? route('rating.store');
@endphp

<section class="py-8 border-t border-gray-200" aria-labelledby="{{ $idTitle }}">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <h2 id="{{ $idTitle }}" class="text-xl font-semibold text-it-gray-900 mb-4">
                {{ __('cms::rating.title') }}
            </h2>

            <form x-data="{ rating: 0, hoverRating: 0, submitted: false }"
                  x-init="
                      @if(session('rating_submitted')) submitted = true; @endif
                  "
                  action="{{ $actionUrl }}"
                  method="POST"
                  @submit.prevent="
                      $el.querySelector('[name=value]').value = rating;
                      submitted = true;
                      // Optionally: fetch/axios POST here
                  ">
                @csrf
                <input type="hidden" name="value" value="">
                <input type="hidden" name="page_slug" value="{{ request()->path() }}">

                {{-- Stars --}}
                <div class="flex items-center gap-1 mb-4" role="radiogroup"
                     aria-label="{{ __('cms::rating.label') }}">
                    @foreach(range(1, 5) as $star)
                    <button
                        type="button"
                        @click="rating = {{ $star }}"
                        @mouseenter="hoverRating = {{ $star }}"
                        @mouseleave="hoverRating = 0"
                        :class="(hoverRating || rating) >= {{ $star }} ? 'text-yellow-400' : 'text-gray-300'"
                        :aria-checked="rating === {{ $star }}"
                        role="radio"
                        class="w-8 h-8 transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-it-primary focus:ring-offset-2"
                    >
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <span class="sr-only">{{ trans_choice('cms::rating.stars', $star) }}</span>
                    </button>
                    @endforeach
                </div>

                {{-- Submit Button --}}
                <div x-show="rating > 0 && !submitted" x-cloak>
                    <button type="submit"
                            class="px-6 py-2 bg-it-primary text-white rounded-md hover:bg-it-primary-dark transition-colors">
                        {{ __('cms::rating.submit') }}
                    </button>
                </div>

                {{-- Thank you message --}}
                <div x-show="submitted" x-cloak class="mt-4 text-it-gray-700">
                    <p class="text-lg">{{ __('cms::rating.thank_you') }}</p>
                </div>
            </form>
        </div>
    </div>
</section>
```

---

## Translation / Multilingual Patterns

### ❌ DO NOT Hardcode Italian Strings

The original Handlebars templates have hardcoded Italian text. This MUST NOT be replicated.

### ✅ Use Laravel Translation Keys

**Translation file location:** `Modules/Cms/lang/en/rating.php` (and `lang/it/rating.php`)

**Translation keys pattern:**
```php
// Modules/Cms/lang/en/rating.php
return [
    'title' => 'Rate this page',
    'label' => 'Page rating',
    'stars' => '{0} 0 stars|{1} 1 star|{2} 2 stars|{3} 3 stars|{4} 4 stars|{5} 5 stars',
    'submit' => 'Submit rating',
    'thank_you' => 'Thank you for your feedback!',
    'aria_labels' => [
        'select_rating' => 'Select :count star rating',
    ],
];

// Modules/Cms/lang/it/rating.php
return [
    'title' => 'Valuta questa pagina',
    'label' => 'Valutazione pagina',
    'stars' => '{0} 0 stelle|{1} 1 stella|{2} 2 stelle|{3} 3 stelle|{4} 4 stelle|{5} 5 stelle',
    'submit' => 'Invia valutazione',
    'thank_you' => 'Grazie per il tuo feedback!',
    'aria_labels' => [
        'select_rating' => 'Seleziona valutazione :count stelle',
    ],
];
```

### ✅ Usage in Blade

```blade
{{-- Correct: Use translation helper --}}
{{ __('cms::rating.title') }}
{{ trans_choice('cms::rating.stars', $star) }}
{{ __('cms::rating.aria_labels.select_rating', ['count' => $star]) }}

{{-- WRONG: Hardcoded Italian --}}
Valuta questa pagina    <!-- DON'T DO THIS -->
Grazie per il feedback! <!-- DON'T DO THIS -->
```

### Translation Namespace Convention

| Namespace | Location | Purpose |
|-----------|----------|---------|
| `cms::rating.*` | `Modules/Cms/lang/{locale}/rating.php` | Rating block strings |
| `cms::contacts.*` | `Modules/Cms/lang/{locale}/contacts.php` | Contacts block strings |
| `cms::breadcrumbs.*` | `Modules/Cms/lang/{locale}/breadcrumbs.php` | Breadcrumb strings |
| `notify::mail.*` | `Modules/Notify/lang/{locale}/*.php` | Already used pattern |

---

## Accessibility Requirements (WCAG 2.1 AA)

| Requirement | Implementation |
|-------------|----------------|
| **Role** | `role="radiogroup"` on star container, `role="radio"` on each star |
| **aria-checked** | `:aria-checked="rating === N"` on each star |
| **aria-label** | On radiogroup: `{{ __('cms::rating.label') }}` |
| **Screen reader text** | `<span class="sr-only">` with star count |
| **Keyboard navigation** | Tab order through stars, Enter/Space to select |
| **Focus indicators** | `focus:ring-2 focus:ring-it-primary focus:ring-offset-2` |
| **Heading association** | `aria-labelledby` on section, matching `id` on heading |
| **Unique IDs** | `id-title` prop → `id="{{ $idTitle }}"` on heading |

---

## Integration with CMS/JSON System

### JSON Content Block Structure

```json
{
    "slug": "rating",
    "type": "rating",
    "data": {
        "id-title": "rating-homepage",
        "showOnPage": true
    }
}
```

### Blade Invocation

```blade
{{-- From CMS-driven [slug].blade.php --}}
<x-cms::blocks.rating :data="$block['data']" />

{{-- Or with pub_theme namespace (theme component) --}}
<x-pub_theme::components.blocks.rating.default :data="$block['data']" />
```

---

## Backend: Rating Module

The project has a dedicated **Rating module** (`Modules/Rating/`) with:

### Models

| Model | Purpose |
|-------|---------|
| `Rating` | Core rating entity (title, description, active flag) |
| `RatingMorph` | Polymorphic pivot — connects ratings to any model |

### RatingMorph Properties
- `model_id` / `model_type` — Polymorphic relation to rated entity
- `rating_id` — FK to Rating definition
- `user_id` — Who rated
- `value` — Numeric rating value (1-5)
- `note` — Optional feedback text
- `is_winner` — Boolean for winning/comparative ratings
- `reward` — Associated reward

### Filament Blocks

| Class | Purpose |
|-------|---------|
| `Modules/Rating/app/Filament/Blocks/Rating.php` | Admin block for embedding rating in pages |

### Filament Resources

| Class | Purpose |
|-------|---------|
| `RatingResource` | CRUD for rating definitions |
| `RatingMorphResource` | CRUD for individual ratings on entities |

---

## File Paths Reference

| Purpose | Path |
|---------|------|
| **Component (to create)** | `resources/views/components/blocks/rating/default.blade.php` |
| **Translations (EN)** | `Modules/Cms/lang/en/rating.php` |
| **Translations (IT)** | `Modules/Cms/lang/it/rating.php` |
| **Rating Model** | `Modules/Rating/app/Models/RatingMorph.php` |
| **Rating Filament Block** | `Modules/Rating/app/Filament/Blocks/Rating.php` |
| **Block Analysis Doc** | `_bmad-output/design-comuni-block-analysis.md` |
| **UI Spec Doc** | `_bmad-output/design-comuni-ui-spec.md` |
| **Master Index** | `docs/design-comuni/MASTER_INDEX.md` |

---

## Summary: Rules to Follow

### ✅ DO
1. Use **Tailwind CSS** utility classes (`py-8`, `text-yellow-400`, `flex`, `gap-1`, etc.)
2. Use **Alpine.js** for interactivity (`x-data`, `@click`, `:class`, `x-show`)
3. Use **`__('cms::rating.key')`** for ALL user-facing strings
4. Include **WCAG 2.1 AA** accessibility (roles, aria-labels, focus rings)
5. Follow the **`x-pub_theme::components.blocks.*`** namespace convention
6. Accept **`$data` array prop** for JSON-driven content
7. Generate **unique IDs** from `id-title` prop

### ❌ DO NOT
1. Use **Bootstrap Italia** classes (`container`, `row`, `col-*`, `btn`, `form-check`)
2. Use **jQuery** or `bootstrap-italia.js`
3. Use **Handlebars** syntax (`{{>partial}}`, `{{#>layout}}`)
4. **Hardcode Italian** text in Blade templates
5. Use **sprite-based icons** (`<use href="/svg/sprites.svg#...">`)
6. Drop **accessibility** attributes (roles, aria-labels, sr-only text)

---

*Rating block analysis: 2026-04-08*
