# 🚫 ICON SYSTEM - DEFINITIVE RULE

**Data**: 2026-03-30  
**Status**: ✅ **DEFINITIVE**  
**Priority**: CRITICAL

---

## ❌ PROBLEM

**356 occurrences** of `<x-heroicon-o-*>` in codebase but **Blade Heroicons NOT installed**!

```bash
composer show blade-heroicons
# Output: NOT INSTALLED
```

---

## ✅ DEFINITIVE SOLUTION

### We Use: `<x-filament::icon>`

**WHY**:
1. ✅ Filament 5 is **already installed** (v5.4.3)
2. ✅ No extra dependencies
3. ✅ Consistent with our stack
4. ✅ Supports ALL Heroicons

### Syntax

```blade
{{-- Outline icons --}}
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-arrow-right" class="w-5 h-5" />

{{-- Solid icons --}}
<x-filament::icon icon="heroicon-s-star" class="w-4 h-4 text-yellow-400" />
```

---

## ❌ DO NOT USE

### 1. Blade Heroicons Component Syntax

```blade
<x-heroicon-o-facebook class="w-5 h-5" />  <!-- ❌ WRONG! Requires blade-heroicons package -->
<x-heroicon-s-star class="w-4 h-4" />      <!-- ❌ WRONG! -->
```

### 2. Raw SVG

```blade
<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
  <path d="..."/>
</svg>  <!-- ❌ WRONG! Verbose, hard to maintain -->
```

### 3. Heroicon Component (without Filament namespace)

```blade
<x-heroicon name="facebook" />  <!-- ❌ WRONG! Deprecated -->
```

---

## 🔧 MIGRATION PLAN

### Step 1: Find All Occurrences

```bash
grep -r "<x-heroicon" laravel/Themes --include="*.blade.php"
```

### Step 2: Replace Pattern

**Find**:
```blade
<x-heroicon-o-facebook class="w-5 h-5" />
```

**Replace**:
```blade
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />
```

### Step 3: Automated Replacement

```bash
# Sixteen theme
find laravel/Themes/Sixteen -name "*.blade.php" -exec sed -i 's/<x-heroicon-o-\([^ ]*\)/<x-filament::icon icon="heroicon-o-\1"/g' {} \;

# TwentyOne theme
find laravel/Themes/TwentyOne -name "*.blade.php" -exec sed -i 's/<x-heroicon-o-\([^ ]*\)/<x-filament::icon icon="heroicon-o-\1"/g' {} \;

# Fix closing tag
find laravel/Themes -name "*.blade.php" -exec sed -i 's/\/>/ icon="heroicon-o-\1"/g' {} \;
```

### Step 4: Manual Review

Review all replacements to ensure:
- [ ] Correct icon name
- [ ] Classes preserved
- [ ] No syntax errors

---

## 📋 ICON REFERENCE

### Common Icons

```blade
{{-- Social --}}
<x-filament::icon icon="heroicon-o-facebook" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-twitter" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-instagram" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-youtube" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-linkedin" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-github" class="w-5 h-5" />

{{-- Navigation --}}
<x-filament::icon icon="heroicon-o-arrow-right" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-arrow-left" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-chevron-down" class="w-4 h-4" />
<x-filament::icon icon="heroicon-o-chevron-up" class="w-4 h-4" />

{{-- Actions --}}
<x-filament::icon icon="heroicon-o-search" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-plus" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-pencil" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-trash" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-download" class="w-5 h-5" />

{{-- Status --}}
<x-filament::icon icon="heroicon-o-check-circle" class="w-5 h-5 text-green-500" />
<x-filament::icon icon="heroicon-o-x-circle" class="w-5 h-5 text-red-500" />
<x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-5 h-5 text-yellow-500" />
<x-filament::icon icon="heroicon-o-information-circle" class="w-5 h-5 text-blue-500" />

{{-- UI --}}
<x-filament::icon icon="heroicon-o-menu" class="w-6 h-6" />
<x-filament::icon icon="heroicon-o-x-mark" class="w-6 h-6" />
<x-filament::icon icon="heroicon-o-bell" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-cog-6-tooth" class="w-5 h-5" />
<x-filament::icon icon="heroicon-o-user-circle" class="w-8 h-8" />
```

---

## 🧘 DEVELOPER MANTRAS

> *"SEMPRE `<x-filament::icon>`. MAI `<x-heroicon-o-*>`."*

> *"Filament è già installato. Non aggiungere dipendenze."*

> *"Icon = `heroicon-o-*` o `heroicon-s-*`."*

> *"Controlla la documentazione Filament 5 prima di usare icone."*

---

## 📖 REFERENCES

### Documentation
- [Filament 5 Icons](https://filamentphp.com/docs/5.x/forms/icon-picker)
- [Heroicons](https://heroicons.com/)

### Internal
- `.openviking/icon-system-definitive` - This rule
- `.openviking/filament-icon-convention` - Icon convention

---

## ✅ ENFORCEMENT

### Pre-commit Hook

```bash
#!/bin/bash
# Check for wrong icon usage
if grep -r "<x-heroicon-o-" laravel/Themes --include="*.blade.php" > /dev/null; then
    echo "❌ ERROR: Found <x-heroicon-o-*> usage!"
    echo "✅ Use <x-filament::icon icon=\"heroicon-o-*\" /> instead"
    exit 1
fi
```

### IDE Snippet

**VS Code User Snippet**:
```json
{
    "Filament Icon": {
        "prefix": "ficon",
        "body": "<x-filament::icon icon=\"heroicon-o-${1:facebook}\" class=\"${2:w-5 h-5}\" />"
    }
}
```

---

**Status**: ✅ **DEFINITIVE RULE**  
**Effective**: Immediately  
**Enforcement**: Mandatory
