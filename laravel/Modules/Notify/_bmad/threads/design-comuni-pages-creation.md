# 🧵 BMAD Thread: Design Comuni Pages Creation

**Created**: 2026-03-30  
**Status**: 🟡 In Progress  
**Priority**: 🔴 Critical  
**Owner**: Multi-Agent Team

---

## 🎯 Goal

Creare tutte le pagine Design Comuni mancanti usando approccio multi-agente.

---

## 📋 Pages Status

### ✅ Created (9 pages)
- [x] homepage
- [x] argomenti
- [x] amministrazione
- [x] servizi
- [x] novita
- [x] eventi
- [x] appuntamento-06-conferma
- [x] [slug] (dynamic route)
- [x] index

### ⏳ Pending (29 pages)

#### Appointment Booking (7 pages)
- [ ] appuntamento-01-ufficio
- [ ] appuntamento-01-ufficio-luogo
- [ ] appuntamento-02-data-orario
- [ ] appuntamento-03-dettagli
- [ ] appuntamento-04-richiedente
- [ ] appuntamento-04-richiedente-autenticato
- [ ] appuntamento-05-riepilogo

#### Assistenza (2 pages)
- [ ] assistenza-01-dati
- [ ] assistenza-02-conferma

#### Segnalazione (7 pages)
- [ ] segnalazione-dettaglio
- [ ] segnalazione-01-privacy
- [ ] segnalazione-02-dati
- [ ] segnalazione-03-riepilogo
- [ ] segnalazione-04-conferma
- [ ] segnalazione-area-personale
- [ ] segnalazioni-elenco

#### General Pages (7 pages)
- [ ] domande-frequenti
- [ ] risultati-ricerca
- [ ] lista-risorse
- [ ] lista-categorie
- [ ] lista-risorse-categorie
- [ ] mappa-sito
- [ ] argomento

#### Services (6 pages)
- [ ] servizi-categoria
- [ ] servizio-dettaglio
- [ ] documenti-dati
- [ ] novita-dettaglio
- [ ] evento-dettaglio
- [ ] vivie-il-comune

---

## 🤖 Multi-Agent Assignment

### BMAD Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **John (PM)** | Requirements | PRD per ogni pagina |
| **Winston (Architect)** | Architecture | Pattern consistency |
| **Sally (UX)** | UX Design | AGID compliance |
| **Paige (Tech Writer)** | Documentation | Page docs |
| **Amelia (Dev)** | Implementation | Blade templates |

### GSD Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **gsd-planner** | Planning | Phase breakdown |
| **gsd-executor** | Execution | Create pages |
| **gsd-verifier** | Verification | Test pages |
| **gsd-codebase-mapper** | Analysis | Code structure |

### Other Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **Ralph Loop** | Automation | Batch creation |
| **NotebookLM** | Research | Source-grounded info |
| **OpenViking** | Context | Memory preservation |

---

## 📐 Architecture Pattern

### Standard Page Template

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
    
    // Page-specific methods
};
?>

<x-layouts.app>
    @volt('tests.{page_name}')
    <div class="{page_name}-wrapper">
        <a class="skiplinks" href="#main">Vai al contenuto principale</a>
        <x-section slug="header" :data="$headerData ?? []" />
        <main class="container" id="main">
            {{-- Page content --}}
        </main>
        <x-section slug="footer" :data="$footerData ?? []" tpl="full" />
    </div>
    @endvolt
</x-layouts.app>
```

### Icon Usage (Filament 5)

```blade
{{-- Social Icons --}}
<x-filament::icon icon="ui-brands.facebook" class="w-6 h-6" />
<x-filament::icon icon="ui-brands.twitter" class="w-6 h-6" />

{{-- Heroicons --}}
<x-filament::icon icon="heroicon-o-arrow-right" class="w-6 h-6" />
<x-filament::icon icon="heroicon-s-star" class="w-6 h-6" />
```

---

## 🔄 Execution Workflow

### Phase 1: Appointment Booking (7 pages)
**Owner**: Amelia + Ralph Loop  
**ETA**: 1 hour

1. Create `appuntamento-01-ufficio.blade.php`
2. Create `appuntamento-01-ufficio-luogo.blade.php`
3. Create `appuntamento-02-data-orario.blade.php`
4. Create `appuntamento-03-dettagli.blade.php`
5. Create `appuntamento-04-richiedente.blade.php`
6. Create `appuntamento-04-richiedente-autenticato.blade.php`
7. Create `appuntamento-05-riepilogo.blade.php`

### Phase 2: Assistenza (2 pages)
**Owner**: Amelia  
**ETA**: 30 min

1. Create `assistenza-01-dati.blade.php`
2. Create `assistenza-02-conferma.blade.php`

### Phase 3: Segnalazione (7 pages)
**Owner**: Amelia + Ralph Loop  
**ETA**: 1 hour

1. Create `segnalazione-dettaglio.blade.php`
2. Create `segnalazione-01-privacy.blade.php`
3. Create `segnalazione-02-dati.blade.php`
4. Create `segnalazione-03-riepilogo.blade.php`
5. Create `segnalazione-04-conferma.blade.php`
6. Create `segnalazione-area-personale.blade.php`
7. Create `segnalazioni-elenco.blade.php`

### Phase 4: General Pages (7 pages)
**Owner**: Amelia  
**ETA**: 1 hour

1. Create `domande-frequenti.blade.php`
2. Create `risultati-ricerca.blade.php`
3. Create `lista-risorse.blade.php`
4. Create `lista-categorie.blade.php`
5. Create `lista-risorse-categorie.blade.php`
6. Create `mappa-sito.blade.php`
7. Create `argomento.blade.php`

### Phase 5: Services (6 pages)
**Owner**: Amelia  
**ETA**: 1 hour

1. Create `servizi-categoria.blade.php`
2. Create `servizio-dettaglio.blade.php`
3. Create `documenti-dati.blade.php`
4. Create `novita-dettaglio.blade.php`
5. Create `evento-dettaglio.blade.php`
6. Create `vivere-il-comune.blade.php`

---

## 📊 Progress Tracking

| Phase | Pages | Status | ETA |
|-------|-------|--------|-----|
| **Phase 1** | Appointment (7) | ⏳ Pending | 1h |
| **Phase 2** | Assistenza (2) | ⏳ Pending | 30m |
| **Phase 3** | Segnalazione (7) | ⏳ Pending | 1h |
| **Phase 4** | General (7) | ⏳ Pending | 1h |
| **Phase 5** | Services (6) | ⏳ Pending | 1h |

**Total**: 29 pages  
**Total ETA**: 4.5 hours

---

## 🤖 OpenViking Context

```bash
openviking add-memory "Design Comuni pages: 9 created, 29 pending. Using multi-agent: BMAD (requirements), GSD (execution), Ralph (automation), NotebookLM (research). Pattern: Folio + Volt, Filament 5 icons, ui-brands for social."
```

---

## 📚 Related Documentation

- [Test Pages Implementation Status](../TEST_PAGES_IMPLEMENTATION_STATUS.md)
- [SVG Icon Convention](../SVG_ICON_CONVENTION.md)
- [Filament 5 Icons](https://filamentphp.com/docs/5.x/support/icons)
- [Design Comuni Pages](https://italia.github.io/design-comuni-pagine-statiche/)

---

**Last Updated**: 2026-03-30  
**Next Action**: Execute Phase 1 (Appointment Booking)  
**Owner**: Multi-Agent Team
