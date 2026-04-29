# 🚀 Sixteen Theme - Pure Tailwind Migration (NO Bootstrap)

**Date**: 2026-03-30  
**Status**: 🔴 **CRITICAL MIGRATION NEEDED**  
**Priority**: HIGHEST  
**Stack**: Tailwind CSS v4.1.13 + Vite + DaisyUI + Alpine.js

---

## ⚠️ CRITICAL: NO BOOTSTRAP!

**We use TAILWIND CSS ONLY!** ❌ Bootstrap Italia is NOT used!

### Current Wrong Usage
```blade
❌ <script src="{{ asset('design-comuni/assets/bootstrap-italia/...') }}"></script>
❌ <link href="{{ asset('design-comuni/assets/bootstrap-italia/...') }}" rel="stylesheet">
```

### CORRECT Usage
```blade
✅ @vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

## 📦 Tech Stack (Confirmed)

### From `Main_files/five/package.json`

```json
{
  "devDependencies": {
    "@tailwindcss/vite": "^4.1.13",    // ✅ Tailwind v4 for Vite
    "@tailwindplus/elements": "^1.0.14", // ✅ Tailwind Plus (custom elements)
    "daisyui": "^5.1.22",               // ✅ DaisyUI components
    "tailwindcss": "^4.1.13",           // ✅ Tailwind CSS v4
    "vite": "npm:rolldown-vite@7.1.12"  // ✅ Rolldown Vite (faster)
  },
  "dependencies": {
    "alpinejs": "^3.15.0"               // ✅ Alpine.js for interactions
  }
}
```

### From `Main_files/five/vite.config.ts`

```typescript
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),  // ✅ Tailwind v4 plugin
  ],
})
```

### From `Main_files/five/tailwind.config.js`

```javascript
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  safelist: [
    'text-green-600',
    'hover:bg-gray-100',
    // ... Tailwind classes
  ],
  theme: {
    extend: {
      colors: {
        // Custom colors (NOT Bootstrap!)
        'primary': '#0066cc',
        'secondary': '#6c757d',
      },
      fontFamily: {
        'sans': ['Titillium Web', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('daisyui')  // ✅ DaisyUI plugin
  ],
}
```

---

## 🏗️ CORRECT Architecture (DRY + KISS)

### 1. Namespace: `pub_theme::`

**ALL components use this namespace!**

```blade
✅ <x-pub_theme::card-standard :title="$title" />
✅ <x-pub_theme::button variant="primary">Click</x-pub_theme::button>
✅ <x-pub_theme::input type="text" :value="$value" />
```

**NOT**:
```blade
❌ <x-sixteen::...>  // WRONG namespace!
```

### 2. Sections for Header/Footer

**Header/Footer are SECTIONS (content blocks), NOT components!**

```blade
✅ <x-section slug="header" />
✅ <x-section slug="footer" />
```

**NOT**:
```blade
❌ @include('partials.header')
❌ <x-pub_theme::blocks.navigation.header-main>
```

### 3. Tailwind + Vite for Assets

**Build system from `Main_files/five/`**

```blade
<head>
    {{-- CORRECT: Tailwind v4 + Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

**NOT**:
```blade
❌ Bootstrap Italia CDN
❌ asset('design-comuni/assets/bootstrap-italia/...')
```

---

## 📁 Source Files Structure

### Source Location
```
laravel/Themes/Sixteen/Main_files/five/
├── src/
│   ├── css/
│   │   └── app.css              # Tailwind v4 imports
│   │       @import "tailwindcss";
│   │       @plugin "daisyui";
│   │       @plugin "@tailwindplus/elements";
│   └── js/
│       └── app.js               # Alpine.js + custom JS
├── vite.config.ts               # Vite configuration
├── tailwind.config.js           # Tailwind configuration
├── package.json                 # Dependencies
└── index.html                   # Reference HTML
```

### Build Output
```
laravel/Themes/Sixteen/public/
├── assets/
│   ├── app-[hash].css           # Compiled Tailwind
│   ├── app-[hash].js            # Bundled JS
│   └── vendor-[hash].js         # Vendor bundles
└── manifest.json                 # Vite manifest
```

---

## 🔄 Migration Steps (DRY + KISS)

### Phase 1: Remove Bootstrap Italia (2h)

**Task**: Find and remove ALL Bootstrap references

```bash
# Find all Bootstrap references
grep -r "bootstrap-italia" laravel/Themes/Sixteen/resources/views/
grep -r "design-comuni/assets" laravel/Themes/Sixteen/resources/views/

# Replace with @vite()
```

**Files to Update**:
- All layout files
- All page templates
- All partials

### Phase 2: Fix Namespace (2h)

**Task**: Replace `x-sixteen::` with `x-pub_theme::`

```bash
# Find all occurrences
grep -r "x-sixteen::" laravel/Themes/Sixteen/resources/views/

# Replace
# (Use IDE find-replace)
```

### Phase 3: Fix Sections (2h)

**Task**: Replace header/footer includes with `<x-section>`

```blade
# Before
@include('partials.header')
@include('partials.footer')

# After
<x-section slug="header" />
<x-section slug="footer" />
```

### Phase 4: Build Assets (2h)

```bash
cd laravel/Themes/Sixteen/Main_files/five

# Install dependencies (if not done)
npm install

# Build for development
npm run dev

# Build for production
npm run build

# Copy to public (if needed)
npm run copy
```

### Phase 5: Documentation (3h)

**Update ALL docs**:
- Component usage guide
- Build instructions
- Section system guide
- All examples

---

## 📊 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Single namespace**: `pub_theme::` for ALL components  
✅ **Single build system**: Vite + Tailwind v4  
✅ **Single pattern**: `<x-section>` for header/footer  
✅ **Single source**: `Main_files/five/` for Tailwind config

### KISS (Keep It Simple, Stupid)

✅ **Simple namespace**: `x-pub_theme::component-name`  
✅ **Simple sections**: `<x-section slug="header" />`  
✅ **Simple build**: `npm run build`  
✅ **No Bootstrap**: Pure Tailwind only

---

## 🎯 Component Examples (CORRECT)

### Card Component

```blade
{{-- x-pub_theme::card-standard --}}
<x-pub_theme::card-standard 
    :title="'Argomento 1'"
    :text="'Description text'"
    :link="route('argomento', 'slug-1')"
    :category="'Categoria'"
    :date="'18 mag 2022'"
/>
```

### Button Component

```blade
{{-- x-pub_theme::button --}}
<x-pub_theme::button variant="primary">
    Click me
</x-pub_theme::button>

<x-pub_theme::button variant="secondary" size="sm">
    Small button
</x-pub_theme::button>
```

### Section Usage

```blade
{{-- Layout file --}}
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Header section --}}
    <x-section slug="header" />
    
    <main>
        @yield('content')
    </main>
    
    {{-- Footer section --}}
    <x-section slug="footer" />
</body>
</html>
```

---

## ✅ Checklist

### Phase 1: Remove Bootstrap

- [ ] Find all `bootstrap-italia` references
- [ ] Find all `design-comuni/assets` references
- [ ] Replace with `@vite()`
- [ ] Test all pages

### Phase 2: Fix Namespace

- [ ] Find all `x-sixteen::` usage
- [ ] Replace with `x-pub_theme::`
- [ ] Test all components
- [ ] Test all pages

### Phase 3: Fix Sections

- [ ] Create `<x-section>` component
- [ ] Register sections in database
- [ ] Replace header/footer includes
- [ ] Test all layouts

### Phase 4: Build Assets

- [ ] Install dependencies
- [ ] Build Tailwind
- [ ] Copy to public
- [ ] Test all pages

### Phase 5: Documentation

- [ ] Update component guide
- [ ] Update build guide
- [ ] Update section guide
- [ ] Update all examples

---

## 🤖 AI Tool Assignment

| Tool | Task | Timeline |
|------|------|----------|
| **OpenViking** | Context tracking | Ongoing |
| **NotebookLM** | Research Tailwind v4 patterns | 30min |
| **Ralph Loop** | Bootstrap → Tailwind migration | 4h |
| **Qwen** | Documentation update | 3h |
| **Claude** | Tailwind optimization | 2h |
| **GSD** | Phase execution | Ongoing |

---

## 📚 Related Documentation

- `.planning/improvements/SIXTEEN_TAILWIND_VITE_CORRECTION.md` - Correction plan
- `laravel/Themes/Sixteen/Main_files/five/` - Tailwind source
- `laravel/Themes/Sixteen/docs/` - Theme documentation

---

**Status**: 🔴 **READY TO MIGRATE**  
**Next**: Phase 1 - Remove Bootstrap Italia (2h)  
**ETA Complete**: 11h total

**Pure Tailwind, NO Bootstrap! 🚀**
