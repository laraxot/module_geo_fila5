# ✅ DRY Correction - Single File Pattern

**Date**: 2026-03-30  
**Correction**: All pages use SINGLE file `[slug].blade.php`

---

## ❌ Wrong Approach (Before)

```
pages/tests/
├── amministrazione.blade.php          ❌ Duplicate
├── documenti-dati.blade.php           ❌ Duplicate
├── novita-dettaglio.blade.php         ❌ Duplicate
├── segnalazione-area-personale.blade.php  ❌ Duplicate
└── segnalazioni-elenco.blade.php      ❌ Duplicate
```

**Problem**: Violates DRY principle - 5 separate files for same pattern!

---

## ✅ Correct Approach (After)

```
pages/tests/
└── [slug].blade.php  ✅ SINGLE FILE
```

**Solution**: ONE dynamic file handles ALL pages!

---

## 🎯 How It Works

### File: `pages/tests/[slug].blade.php`

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
    public string $pageSlug = '';
    public array $data = [];

    public function mount(string $slug = ''): void
    {
        $this->pageSlug = 'tests.' . $slug;
        $this->data = ['slug' => $slug];
    }
};
?>

<x-layouts.app>
    @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## 🔄 Flow

```
URL: /it/tests/amministrazione
    ↓
Folio: Matches pages/tests/[slug].blade.php
    ↓
Parameter: slug = 'amministrazione'
    ↓
Component: mount('amministrazione')
    ↓
Sets: pageSlug = 'tests.amministrazione'
    ↓
Renders: <x-page side="content" :slug="tests.amministrazione" />
    ↓
JSON: laravel/config/local/fixcity/database/content/pages/tests.amministrazione.json
    ↓
Blocks: Loaded from JSON and rendered
```

---

## 📊 Pages Handled by Single File

All 23 pages use the SAME file:

### P0 (12 pages)
- `/it/tests/homepage` → `[slug].blade.php` with slug='homepage'
- `/it/tests/argomenti` → `[slug].blade.php` with slug='argomenti'
- `/it/tests/servizi` → `[slug].blade.php` with slug='servizi'
- `/it/tests/eventi` → `[slug].blade.php` with slug='eventi'
- `/it/tests/novita` → `[slug].blade.php` with slug='novita'
- `/it/tests/appuntamento-01-ufficio` → `[slug].blade.php` with slug='appuntamento-01-ufficio'
- ... (6 more appuntamento pages)

### P1 (11 pages)
- `/it/tests/assistenza-01-dati` → `[slug].blade.php` with slug='assistenza-01-dati'
- `/it/tests/assistenza-02-conferma` → `[slug].blade.php` with slug='assistenza-02-conferma'
- `/it/tests/segnalazione-dettaglio` → `[slug].blade.php` with slug='segnalazione-dettaglio'
- `/it/tests/segnalazione-01-privacy` → `[slug].blade.php` with slug='segnalazione-01-privacy'
- `/it/tests/segnalazione-02-dati` → `[slug].blade.php` with slug='segnalazione-02-dati'
- `/it/tests/segnalazione-03-riepilogo` → `[slug].blade.php` with slug='segnalazione-03-riepilogo'
- `/it/tests/segnalazione-04-conferma` → `[slug].blade.php` with slug='segnalazione-04-conferma'
- `/it/tests/segnalazione-area-personale` → `[slug].blade.php` with slug='segnalazione-area-personale'
- `/it/tests/segnalazioni-elenco` → `[slug].blade.php` with slug='segnalazioni-elenco'
- `/it/tests/amministrazione` → `[slug].blade.php` with slug='amministrazione'
- `/it/tests/documenti-dati` → `[slug].blade.php` with slug='documenti-dati'
- `/it/tests/novita-dettaglio` → `[slug].blade.php` with slug='novita-dettaglio'

---

## ✅ Benefits

### DRY (Don't Repeat Yourself)
- ✅ **1 file** instead of 23 files
- ✅ **Single source of truth**
- ✅ **Easy to maintain**
- ✅ **No code duplication**

### KISS (Keep It Simple, Stupid)
- ✅ **Simple pattern**: `[slug].blade.php`
- ✅ **Clear flow**: slug → mount → <x-page>
- ✅ **Easy to understand**
- ✅ **Scalable**: Add new page = add JSON, no new blade file

---

## 📚 Related Files

### Blade Template
- `pages/tests/[slug].blade.php` - Single dynamic file

### JSON Configs (23 files)
- `laravel/config/local/fixcity/database/content/pages/tests.homepage.json`
- `laravel/config/local/fixcity/database/content/pages/tests.argomenti.json`
- ... (21 more)

### Block Components
- `components/blocks/hero/hero.blade.php`
- `components/blocks/card/card.blade.php`
- `components/blocks/steps/steps.blade.php`
- ... (all block components)

---

## ✅ Checklist

- [x] Removed duplicate blade files (5 files)
- [x] Single `[slug].blade.php` file exists
- [x] Mount method handles all slugs
- [x] <x-page> component renders content
- [x] JSON configs exist for all pages
- [x] OpenViking updated
- [x] Documentation updated

---

**Status**: ✅ **CORRECTED**  
**Pattern**: Single `[slug].blade.php` for ALL pages  
**DRY**: Respected!  
**Files**: 1 blade file + 23 JSON configs

**DRY principle restored! 🎉**
