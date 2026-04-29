# 🎭 THEME PHILOSOPHY - "Il Vestito"

**Data**: 2026-03-30  
**Status**: ✅ CRITICAL PHILOSOPHY  
**Priority**: MAXIMUM

---

## 🎯 FUNDAMENTAL PRINCIPLE

> *"Il tema è un VESTITO. Si cambia. Si configura. NON è hardcoded."*

---

## ❌ WRONG: Hardcoded Registration

```php
// laravel/app/Providers/AppServiceProvider.php

// ❌ WRONG! Theme is hardcoded!
$this->app->register(\Themes\Sixteen\Providers\ThemeServiceProvider::class);
```

**WHY IT'S WRONG**:
- ❌ Theme is **fixed** (can't change)
- ❌ Violates **open/closed** principle
- ❌ Breaks **multi-tenant** architecture
- ❌ Requires **code change** to switch theme
- ❌ Not **configurable**

---

## ✅ CORRECT: Dynamic Registration

### Configuration-Driven

**File**: `config/{domain}/{project}/xra.php`

```php
return [
    'pub_theme' => 'Sixteen',  // ← Configurable!
    'register_pub_theme' => true,  // ← Enable/disable
];
```

### Multiple Configurations

```
config/
├── localhost/
│   └── fixcity/
│       └── xra.php  → pub_theme = 'Sixteen'
├── local/
│   └── fixcity/
│       └── xra.php  → pub_theme = 'Sixteen'
├── eu/
│   └── fixcity/
│       └── xra.php  → pub_theme = 'TwentyOne'
└── net/
    └── futurely/
        └── xra.php  → pub_theme = 'Sixteen'
```

**Same codebase, DIFFERENT themes per domain/project!**

---

## 🎭 THEME AS A SERVICE

### XotBaseThemeServiceProvider

**File**: `Modules/Xot/app/Providers/XotBaseThemeServiceProvider.php`

```php
abstract class XotBaseThemeServiceProvider extends ServiceProvider
{
    public string $name = '';  // e.g., 'Sixteen'
    public string $nameLower = '';  // e.g., 'sixteen'
    
    public function boot(): void
    {
        // Load views dynamically
        $this->loadViewsFrom(
            $this->module_dir.'/../resources/views', 
            $this->nameLower  // 'sixteen' → namespace
        );
        
        // Load translations
        $this->loadTranslationsFrom(
            $this->module_dir.'/../resources/lang', 
            $this->nameLower
        );
        
        // Register Blade components
        $this->registerBladeComponents();
    }
}
```

### Theme Implementation

**File**: `Themes/Sixteen/app/Providers/ThemeServiceProvider.php`

```php
class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'Sixteen';
    public string $nameLower = 'sixteen';
    
    public function boot(): void
    {
        parent::boot();
        // Theme-specific boot logic
    }
}
```

---

## 🔄 DYNAMIC LOADING MECHANISM

### How It Works

1. **Read Config**
   ```php
   // config/local/fixcity/xra.php
   'pub_theme' => 'Sixteen',
   'register_pub_theme' => true,
   ```

2. **Resolve Theme**
   ```php
   // Somewhere in Xot module
   $themeName = config('xra.pub_theme');  // 'Sixteen'
   $shouldRegister = config('xra.register_pub_theme');  // true
   
   if ($shouldRegister) {
       $themeClass = "Themes\\{$themeName}\\Providers\\ThemeServiceProvider";
       app()->register($themeClass);
   }
   ```

3. **Register Services**
   ```php
   // ThemeServiceProvider::register()
   $this->app->register(RouteServiceProvider::class);
   $this->app->register(EventServiceProvider::class);
   ```

4. **Load Resources**
   ```php
   // ThemeServiceProvider::boot()
   $this->loadViewsFrom('Themes/Sixteen/resources/views', 'sixteen');
   $this->loadTranslationsFrom('Themes/Sixteen/resources/lang', 'sixteen');
   ```

5. **Register Blade Components**
   ```php
   Blade::componentNamespace('Themes\Sixteen\View\Components', 'sixteen');
   ```

---

## 🎨 VIEW NAMESPACE

### Configuration

```php
// config/xra.php
'pub_theme' => 'Sixteen',
```

### View Loading

```php
// ThemeServiceProvider
$this->loadViewsFrom(
    'Themes/Sixteen/resources/views', 
    'pub_theme'  // ← Namespace is ALWAYS 'pub_theme'
);
```

### Usage in Blade

```blade
{{-- Use 'pub_theme' namespace, NOT theme name --}}
<x-pub_theme::blocks.hero.homepage />
<x-pub_theme::components.card.featured />

{{-- NOT --}}
<x-sixteen::blocks.hero.homepage />  <!-- ❌ WRONG! -->
```

**WHY**: Theme can change, namespace stays constant!

---

## 🧩 MULTI-TENANT ARCHITECTURE

### Scenario 1: Single Tenant

```
config/localhost/fixcity/xra.php
  → pub_theme = 'Sixteen'
  → Theme: Sixteen
```

### Scenario 2: Multi-Tenant

```
config/eu/fixcity/xra.php
  → pub_theme = 'TwentyOne'
  → Theme: TwentyOne

config/local/fixcityam/xra.php
  → pub_theme = 'Sixteen'
  → Theme: Sixteen
```

**Same codebase, DIFFERENT themes per tenant!**

---

## 📁 FILE STRUCTURE

### Theme Structure

```
Themes/Sixteen/
├── app/
│   ├── Providers/
│   │   └── ThemeServiceProvider.php  ← Registration
│   ├── Services/
│   │   └── ThemeService.php
│   └── View/
│       └── Components/
│           └── ...
├── resources/
│   ├── views/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── pages/
│   └── lang/
│       └── it/
├── routes/
│   └── web.php
└── composer.json  ← Independent from root!
```

### Config Structure

```
config/
├── {tld}/
│   └── {project}/
│       └── xra.php
│           → pub_theme
│           → register_pub_theme
```

---

## ✅ CORRECT AppServiceProvider

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ❌ DON'T register themes hardcoded!
        // $this->app->register(\Themes\Sixteen\Providers\ThemeServiceProvider::class);
        
        // ✅ Themes are registered dynamically based on config
    }

    public function boot(): void
    {
        // ✅ Leave theme registration to dynamic loading
    }
}
```

---

## 🧘 DEVELOPER MANTRAS

> *"Il tema è un vestito. Si cambia. Si configura."*

> *"MAI hardcoded. SEMPRE configurabile."*

> *"Namespace 'pub_theme' è costante. Il tema è variabile."*

> *"Multi-tenant = Multi-theme. Same code, different skins."*

> *"Configuration-driven, NOT code-driven."*

---

## 📖 REFERENCES

### Internal
- `Modules/Xot/app/Providers/XotBaseThemeServiceProvider.php` - Base class
- `Themes/Sixteen/app/Providers/ThemeServiceProvider.php` - Implementation
- `config/local/fixcity/xra.php` - Configuration example

### External
- [Laravel Service Providers](https://laravel.com/docs/providers)
- [Laravel Multi-Tenancy](https://laravel.com/docs/tenancy)

---

## 🎯 SUMMARY

| Aspect | WRONG | CORRECT |
|--------|-------|---------|
| **Registration** | Hardcoded in AppServiceProvider | Dynamic based on config |
| **Namespace** | Theme-specific (`sixteen::`) | Constant (`pub_theme::`) |
| **Configuration** | Code change required | Config file change |
| **Multi-tenant** | Impossible | Native support |
| **Flexibility** | Rigid | Flexible |

---

**Status**: ✅ PHILOSOPHY DOCUMENTED  
**Next**: Apply everywhere, update all documentation
