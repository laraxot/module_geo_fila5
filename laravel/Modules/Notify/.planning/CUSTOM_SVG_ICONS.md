# 🎨 CUSTOM SVG ICONS SYSTEM

**Data**: 2026-03-30  
**Status**: ✅ IMPLEMENTED  
**Priority**: HIGH

---

## 🎯 SOLUTION

Create custom SVG icons in `Modules/UI/resources/svg/brands/` and use with Filament icon component.

---

## 📁 FILE STRUCTURE

```
laravel/Modules/UI/resources/svg/brands/
├── facebook.svg    → ui-brands.facebook
├── twitter.svg     → ui-brands.twitter
├── instagram.svg   → ui-brands.instagram
├── youtube.svg     → ui-brands.youtube
├── linkedin.svg    → ui-brands.linkedin
├── telegram.svg    → ui-brands.telegram
├── whatsapp.svg    → ui-brands.whatsapp
└── rss.svg         → ui-brands.rss
```

---

## 🔧 NAMING CONVENTION

### Automatic Registration

SVG files are auto-registered with:
```
<module>-<category>.<filename>
```

**Example**:
- File: `Modules/UI/resources/svg/brands/facebook.svg`
- Registered as: `ui-brands.facebook`

---

## ✅ USAGE

### With Filament Icon Component

```blade
<x-filament::icon icon="ui-brands.facebook" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.twitter" class="w-5 h-5" />
<x-filament::icon icon="ui-brands.instagram" class="w-5 h-5" />
```

### In Social Links Component

```blade
@php
    $socialPlatforms = [
        'facebook' => [
            'name' => 'Facebook',
            'icon' => 'ui-brands.facebook',
            'color' => 'text-blue-600 hover:text-blue-700',
        ],
        'twitter' => [
            'name' => 'Twitter',
            'icon' => 'ui-brands.twitter',
            'color' => 'text-gray-900 hover:text-gray-700',
        ],
    ];
@endphp

@foreach($links as $platform => $url)
    <a href="{{ $url }}" target="_blank">
        <x-filament::icon 
            :icon="$socialPlatforms[$platform]['icon']"
            class="w-5 h-5"
        />
    </a>
@endforeach
```

---

## 📋 AVAILABLE ICONS

### Social Media Brands

| Icon Name | File | Platform |
|-----------|------|----------|
| `ui-brands.facebook` | `facebook.svg` | Facebook |
| `ui-brands.twitter` | `twitter.svg` | Twitter/X |
| `ui-brands.instagram` | `instagram.svg` | Instagram |
| `ui-brands.youtube` | `youtube.svg` | YouTube |
| `ui-brands.linkedin` | `linkedin.svg` | LinkedIn |
| `ui-brands.telegram` | `telegram.svg` | Telegram |
| `ui-brands.whatsapp` | `whatsapp.svg` | WhatsApp |
| `ui-brands.rss` | `rss.svg` | RSS Feed |

---

## 🔨 CREATING NEW ICONS

### Step 1: Create SVG File

**Location**: `Modules/UI/resources/svg/<category>/<name>.svg`

```svg
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
  <!-- Your SVG path here -->
</svg>
```

### Step 2: Use in Blade

```blade
<x-filament::icon icon="ui-<category>.<name>" class="w-5 h-5" />
```

### Example: Add TikTok

**File**: `Modules/UI/resources/svg/brands/tiktok.svg`

```svg
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
  <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93v6.16c0 2.52-1.12 4.84-2.9 6.24-1.72 1.39-3.92 1.94-6.07 1.56-2.44-.41-4.63-1.93-5.85-4.07-1.27-2.22-1.38-4.97-.3-7.28 1.03-2.22 3.08-3.88 5.47-4.39.77-.17 1.56-.26 2.35-.27v4.21c-.79.02-1.58.23-2.28.62-1.11.62-1.85 1.77-1.94 3.03-.1 1.36.53 2.67 1.64 3.47 1.16.84 2.7 1.01 4.02.43 1.37-.6 2.28-1.96 2.28-3.45V.02h-4.5z"/>
</svg>
```

**Usage**:
```blade
<x-filament::icon icon="ui-brands.tiktok" class="w-5 h-5" />
```

---

## 🧘 ADVANTAGES

### ✅ Why Custom SVGs?

1. **No External Dependencies**
   - No need for blade-heroicons package
   - No need for Filament Heroicons plugin

2. **Full Control**
   - Custom icons for brands
   - Consistent style
   - Optimized paths

3. **Auto-Registration**
   - Laravel Blade Icons auto-discovers
   - No manual registration needed

4. **Namespace Clarity**
   - `ui-brands.*` for social media
   - `ui-*` for other custom icons
   - Clear separation from Heroicons

---

## 📖 REFERENCES

### Internal
- `Modules/UI/resources/svg/brands/` - SVG files location
- `Themes/Sixteen/resources/views/components/social/social-links.blade.php` - Usage example

### External
- [Laravel Blade Icons](https://github.com/blade-ui-kit/blade-icons)
- [Heroicons](https://heroicons.com/)

---

## 🧘 DEVELOPER MANTRAS

> *"SVG in `Modules/UI/resources/svg/`. Auto-registered. Use with Filament."*

> *"ui-brands.facebook, NOT heroicon-o-facebook."*

> *"Custom icons for brands. Heroicons for UI."*

---

**Status**: ✅ IMPLEMENTED  
**Icons Created**: 8 social media brands  
**Next**: Add more as needed
