# 🚀 Sixteen Theme - Tailwind + Vite Migration Plan (CORRECTED)

**Date**: 2026-03-30  
**Status**: 🔴 **NEEDS CORRECTION**  
**Priority**: CRITICAL

---

## ❌ Errors Identified

### 1. WRONG: Bootstrap Italia CDN
```blade
❌ <script src="{{ asset('design-comuni/assets/bootstrap-italia/dist/js/bootstrap-italia.bundle.min.js') }}"></script>
```

**WHY WRONG**: We're using **Tailwind CSS + Vite**, NOT Bootstrap Italia!

### 2. WRONG: Component Namespace
```blade
❌ <x-sixteen::blocks.navigation.header-main>
```

**WHY WRONG**: Theme namespace is `pub_theme`, NOT `sixteen`!

### 3. WRONG: Direct Component Calls for Header/Footer
```blade
❌ <x-pub_theme::blocks.navigation.header-main>
```

**WHY WRONG**: Header/Footer are **sections**, should use `<x-section>`!

---

## ✅ CORRECT Patterns

### 1. CORRECT: Tailwind + Vite Assets
```blade
✅ @vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Source**: `laravel/Themes/Sixteen/Main_files/five/vite.config.ts`

### 2. CORRECT: Component Namespace
```blade
✅ <x-pub_theme::card-standard :title="$title" />
✅ <x-pub_theme::button variant="primary">Click me</x-pub_theme::button>
```

**Namespace**: `pub_theme::` (registered in ServiceProvider)

### 3. CORRECT: Sections for Header/Footer
```blade
✅ <x-section slug="header" />
✅ <x-section slug="footer" />
```

**Why**: Header/Footer are **sections** (content blocks), NOT components!

---

## 📁 Source of Truth

### Main Files Location
```
laravel/Themes/Sixteen/Main_files/five/
├── src/                      # Tailwind CSS + JS source
│   ├── css/
│   │   └── app.css          # Tailwind imports
│   └── js/
│       └── app.js           # JavaScript entry
├── vite.config.ts            # Vite configuration
├── tailwind.config.js        # Tailwind configuration
├── package.json              # Dependencies
└── index.html                # Reference HTML
```

### Vite Configuration
```typescript
// laravel/Themes/Sixteen/Main_files/five/vite.config.ts
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'src/css/app.css',
        'src/js/app.js',
      ],
      refresh: true,
    }),
  ],
});
```

### Build Output
```
laravel/Themes/Sixteen/public/
├── assets/
│   ├── app-[hash].css       # Compiled Tailwind
│   └── app-[hash].js        # Bundled JavaScript
└── manifest.json             # Vite manifest
```

---

## 🏗️ Architecture (DRY + KISS)

### Component Registration

**ServiceProvider**: `Modules/Theme/Providers/ThemeServiceProvider.php`

```php
public function boot(): void
{
    // Register Blade component namespace
    Blade::componentNamespace('Themes\\Sixteen\\Components', 'pub_theme');
    
    // Register sections (header, footer, etc.)
    $this->registerSections();
}

protected function registerSections(): void
{
    // Sections are content blocks stored in database
    // Loaded via <x-section slug="header" />
}
```

### Component Structure

```
Themes/Sixteen/resources/views/components/
├── card-standard.blade.php       # ✅ pub_theme::card-standard
├── card-teaser.blade.php         # ✅ pub_theme::card-teaser
├── button.blade.php              # ✅ pub_theme::button
├── input.blade.php               # ✅ pub_theme::input
└── ...
```

### Section Structure

```
Themes/Sixteen/resources/views/sections/
├── header.blade.php              # ✅ <x-section slug="header" />
├── footer.blade.php              # ✅ <x-section slug="footer" />
├── hero.blade.php                # ✅ <x-section slug="hero" />
└── sidebar.blade.php             # ✅ <x-section slug="sidebar" />
```

### Layout Usage

```blade
{{-- Themes/Sixteen/resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    
    {{-- CORRECT: Tailwind + Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- CORRECT: Sections for header/footer --}}
    <x-section slug="header" />
    
    <main>
        @yield('content')
    </main>
    
    <x-section slug="footer" />
</body>
</html>
```

### Page Usage

```blade
{{-- Themes/Sixteen/resources/views/pages/tests/argomenti.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Argomenti</h1>
    
    {{-- CORRECT: pub_theme namespace --}}
    <x-pub_theme::card-standard 
        :title="'Argomento 1'"
        :text="'Description'"
        :link="route('argomento', 'slug-1')"
    />
    
    <x-pub_theme::card-standard 
        :title="'Argomento 2'"
        :text="'Description'"
        :link="route('argomento', 'slug-2')"
    />
</div>
@endsection
```

---

## 🔄 Migration Steps

### Phase 1: Fix Namespace (2h)

**Task**: Replace all `x-sixteen::` with `x-pub_theme::`

```bash
# Find all occurrences
grep -r "x-sixteen::" laravel/Themes/Sixteen/resources/views/

# Replace with correct namespace
# (Use IDE or sed)
```

**Files to Update**:
- All Blade files in `resources/views/`
- Documentation files

### Phase 2: Fix Sections (2h)

**Task**: Replace direct header/footer calls with `<x-section>`

```blade
# Before
@include('partials.header')
@include('partials.footer')

# After
<x-section slug="header" />
<x-section slug="footer" />
```

### Phase 3: Remove Bootstrap Italia (4h)

**Task**: Replace Bootstrap Italia with Tailwind

```blade
# Before
<script src="{{ asset('design-comuni/assets/bootstrap-italia/...') }}"></script>
<link href="{{ asset('design-comuni/assets/bootstrap-italia/...') }}" rel="stylesheet">

# After
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

**Source**: Use `Main_files/five/src/` as reference

### Phase 4: Build Assets (1h)

```bash
cd laravel/Themes/Sixteen/Main_files/five

# Install dependencies
npm install

# Build for development
npm run dev

# Build for production
npm run build

# Copy to public
npm run copy
```

### Phase 5: Documentation (2h)

**Update**:
- Component usage guide
- Section system documentation
- Build instructions
- All examples in docs/

---

## 📊 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single namespace**: `pub_theme::` for all theme components  
✅ **Sections system**: Header/footer defined once, reused everywhere  
✅ **Tailwind config**: Single source of truth (`tailwind.config.js`)  
✅ **Vite build**: One build process for all assets

### KISS (Keep It Simple, Stupid)

✅ **Simple namespace**: `pub_theme::component-name`  
✅ **Simple sections**: `<x-section slug="header" />`  
✅ **Simple build**: `npm run build`  
✅ **Clear structure**: Components vs Sections separated

---

## 🎯 Success Criteria

### Technical

- [ ] Zero `x-sixteen::` namespace usage
- [ ] All header/footer calls use `<x-section>`
- [ ] Zero Bootstrap Italia CDN references
- [ ] All pages use `@vite()` for assets
- [ ] Build completes without errors
- [ ] All pages load correctly

### Documentation

- [ ] All docs updated with correct namespace
- [ ] Examples use `<x-section>`
- [ ] Build instructions clear
- [ ] DRY + KISS principles documented

---

## 🤖 AI Tool Assignment

| Tool | Task | Timeline |
|------|------|----------|
| **OpenViking** | Context tracking | Ongoing |
| **NotebookLM** | Research Tailwind patterns | 30min |
| **Ralph Loop** | Namespace replacement | 2h |
| **Qwen** | Documentation update | 2h |
| **Claude** | Tailwind optimization | 2h |
| **GSD** | Phase execution | Ongoing |

---

## ✅ Checklist

### Phase 1: Namespace Fix

- [ ] Find all `x-sixteen::` occurrences
- [ ] Replace with `x-pub_theme::`
- [ ] Test all pages
- [ ] Commit changes

### Phase 2: Sections

- [ ] Create `<x-section>` component
- [ ] Register sections in database
- [ ] Replace header/footer includes
- [ ] Test all pages

### Phase 3: Tailwind + Vite

- [ ] Remove Bootstrap Italia references
- [ ] Add `@vite()` to layouts
- [ ] Build assets from `Main_files/five/`
- [ ] Test all pages

### Phase 4: Documentation

- [ ] Update component guide
- [ ] Update section guide
- [ ] Update build guide
- [ ] Update all examples

---

**Status**: 🔴 **READY TO EXECUTE**  
**Next**: Phase 1 - Fix namespace (2h)  
**ETA Complete**: 11h total

**Let's fix the namespace and use Tailwind correctly! 🚀**
