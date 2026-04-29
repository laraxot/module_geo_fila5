# Theme Context

## Current Active Theme

**Theme**: Sixteen  
**Domain**: fixcity.local  
**Config File**: `laravel/config/localhost/xra.php`  
**Config Key**: `pub_theme`  
**Document Root**: `public_html/`

## Theme Detection Logic

### Configuration Flow

```
Domain Request → Config Lookup → Theme Resolution
     ↓                ↓                ↓
fixcity.local  →  localhost/     →  Sixteen
                   xra.php
```

### Config File Structure

**Location**: `laravel/config/localhost/xra.php`

```php
<?php

declare(strict_types=1);

return [
    'pub_theme' => 'Sixteen',        // ✅ Active public theme
    'adm_theme' => 'AdminLTE',       // ⚠️ Legacy (not used)
    'main_module' => 'Fixcity',
    'primary_lang' => 'it',
    // ... other config
];
```

### Theme Resolution Process

1. **Domain Parsing**:
   - Extract domain from request (`fixcity.local`)
   - Map to config directory (`localhost/`)

2. **Config Loading**:
   - Load `laravel/config/{domain}/xra.php`
   - Read `pub_theme` key

3. **Theme Activation**:
   - Theme name from config (`Sixteen`)
   - Assets from `laravel/Themes/Sixteen/`
   - Build output to `public_html/themes/Sixteen/`

## Theme Paths

### Source Code
```
laravel/Themes/Sixteen/
├── resources/     # Source files
├── app/           # PHP components
└── docs/          # Documentation
```

### Build Output
```
public_html/themes/Sixteen/
├── assets/        # Compiled CSS/JS
└── manifest.json  # Vite manifest
```

### Entry Point
```
public_html/index.php
```

## Available Themes

| Theme | Status | Purpose | Config Path |
|-------|--------|---------|-------------|
| **Sixteen** | ✅ ACTIVE | AGID/Bootstrap Italia compliant | `localhost/xra.php` |
| **TwentyOne** | 📦 AVAILABLE | Modern Tailwind theme | (configurable) |

## Configuration Changes

### Switch Theme

To change the active theme:

1. Edit config file:
   ```bash
   nano laravel/config/localhost/xra.php
   ```

2. Update `pub_theme`:
   ```php
   'pub_theme' => 'TwentyOne',  // Change theme name
   ```

3. Build theme assets:
   ```bash
   cd laravel/Themes/TwentyOne
   npm run build
   npm run copy
   ```

4. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

## Domain to Config Mapping

| Domain | Config Directory | Config File |
|--------|-----------------|-------------|
| `fixcity.local` | `localhost/` | `laravel/config/localhost/xra.php` |
| `*.fixcity.local` | `localhost/` | (wildcard) |

## Related Documentation

- **Modules Index**: [laravel/Modules/docs/README.md](../Modules/docs/README.md)
- **Themes Index**: [laravel/Themes/docs/README.md](../Themes/docs/README.md)
- **Sixteen Theme**: [laravel/Themes/Sixteen/docs/README.md](../Themes/Sixteen/docs/README.md)
- **TwentyOne Theme**: [laravel/Themes/TwentyOne/docs/README.md](../Themes/TwentyOne/docs/README.md)

---

**Analysis Date**: March 30, 2026  
**Purpose**: Single source of truth for theme configuration and detection
