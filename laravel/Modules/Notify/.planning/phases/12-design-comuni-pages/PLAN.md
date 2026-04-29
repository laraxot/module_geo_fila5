# GSD Phase: Design Comuni Pages Creation

**Phase ID**: 12-design-comuni-pages  
**Status**: 🟡 In Progress  
**Created**: 2026-03-30  
**Owner**: Multi-Agent Team (Amelia + Ralph Loop)

---

## 🎯 Goal

Create all 29 missing Design Comuni pages using multi-agent workflow.

---

## 📋 Pages to Create (29 total)

### Wave 1: Appointment Booking (7 pages)
- [ ] appuntamento-01-ufficio
- [ ] appuntamento-01-ufficio-luogo
- [ ] appuntamento-02-data-orario
- [ ] appuntamento-03-dettagli
- [ ] appuntamento-04-richiedente
- [ ] appuntamento-04-richiedente-autenticato
- [ ] appuntamento-05-riepilogo

### Wave 2: Assistenza + Segnalazione (9 pages)
- [ ] assistenza-01-dati
- [ ] assistenza-02-conferma
- [ ] segnalazione-dettaglio
- [ ] segnalazione-01-privacy
- [ ] segnalazione-02-dati
- [ ] segnalazione-03-riepilogo
- [ ] segnalazione-04-conferma
- [ ] segnalazione-area-personale
- [ ] segnalazioni-elenco

### Wave 3: General Pages (7 pages)
- [ ] domande-frequenti
- [ ] risultati-ricerca
- [ ] lista-risorse
- [ ] lista-categorie
- [ ] lista-risorse-categorie
- [ ] mappa-sito
- [ ] argomento

### Wave 4: Services (6 pages)
- [ ] servizi-categoria
- [ ] servizio-dettaglio
- [ ] documenti-dati
- [ ] novita-dettaglio
- [ ] evento-dettaglio
- [ ] vivere-il-comune

---

## 🔧 Standard Page Template

```php
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.{page_name}');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $pageSlug = 'tests.{page_name}';
    public array $data = [];
};
?>

<x-layouts.app>
    @volt('tests.{page_name}')
    <div class="{page_name}-wrapper">
        <a class="skiplinks" href="#main">Vai al contenuto principale</a>
        <x-section slug="header" :data="$headerData ?? []" />
        <main class="container" id="main">
            {{-- Page content with Filament 5 icons --}}
        </main>
        <x-section slug="footer" :data="$footerData ?? []" tpl="full" />
    </div>
    @endvolt
</x-layouts.app>
```

---

## 🤖 Agent Assignment

### Wave 1: Appointment (Ralph Loop)
**Agent**: Ralph Loop (autonomous)  
**ETA**: 1 hour  
**Command**:
```bash
ralph-loop run \
  --task="Create 7 appointment booking pages" \
  --pattern="appuntamento-*" \
  --until="All 7 pages created"
```

### Wave 2: Assistenza + Segnalazione (Amelia)
**Agent**: Amelia (BMAD Dev)  
**ETA**: 1 hour  
**Tasks**: 9 pages

### Wave 3: General (Amelia + Ralph)
**Agent**: Amelia + Ralph Loop  
**ETA**: 1 hour  
**Tasks**: 7 pages

### Wave 4: Services (Amelia)
**Agent**: Amelia  
**ETA**: 1 hour  
**Tasks**: 6 pages

---

## ✅ Quality Gates

### Before Commit
- [ ] Single root element in @volt
- [ ] `<x-filament::icon>` for icons (NOT `<x-icon>`)
- [ ] `ui-brands.{name}` for social icons
- [ ] `heroicon-o-{name}` or `heroicon-s-{name}` for Heroicons
- [ ] Skip links present
- [ ] Header section included
- [ ] Footer section included
- [ ] AGID compliant structure

### After Commit
- [ ] Test page loads without errors
- [ ] Icons render correctly
- [ ] Responsive on mobile/tablet/desktop
- [ ] Visual match with upstream >90%

---

## 📊 Progress Tracking

| Wave | Pages | Created | Status |
|------|-------|---------|--------|
| **Wave 1** | Appointment (7) | 0/7 | ⏳ Pending |
| **Wave 2** | Assistenza+Segnalazione (9) | 0/9 | ⏳ Pending |
| **Wave 3** | General (7) | 0/7 | ⏳ Pending |
| **Wave 4** | Services (6) | 0/6 | ⏳ Pending |

**Total**: 0/29 (0%)

---

## 🤖 OpenViking Context

```bash
openviking add-memory "GSD Phase 12: Creating 29 Design Comuni pages. 4 waves: Appointment (7), Assistenza+Segnalazione (9), General (7), Services (6). Pattern: Folio + Volt, Filament 5 icons."
```

---

## 📚 Related Documentation

- [BMAD Thread](../../../_bmad/threads/design-comuni-pages-creation.md)
- [Test Pages Status](../TEST_PAGES_IMPLEMENTATION_STATUS.md)
- [SVG Icon Convention](../SVG_ICON_CONVENTION.md)
- [Theme Architecture](../THEME_ARCHITECTURE_OUTFIT.md)

---

**Last Updated**: 2026-03-30  
**Next Action**: Execute Wave 1 (Appointment Booking)  
**Owner**: Multi-Agent Team (Amelia + Ralph Loop)
