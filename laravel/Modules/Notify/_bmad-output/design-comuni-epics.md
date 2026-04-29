# 📋 Design Comuni Italia - Epics & Stories

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** 🔄 **In Progress**
**Priority:** 🔴 **CRITICAL**
**Version:** 1.0

---

## 📊 Epic Overview

| Epic ID | Epic Name | Stories | Priority | Status |
|---------|-----------|---------|----------|--------|
| **EPIC-1** | Foundation Setup | 5 | 🔴 Critical | ⏳ Pending |
| **EPIC-2** | Header & Footer | 4 | 🔴 Critical | ⏳ Pending |
| **EPIC-3** | Block Components | 10 | 🔴 Critical | ⏳ Pending |
| **EPIC-4** | Homepage Replication | 3 | 🔴 Critical | ⏳ Pending |
| **EPIC-5** | Argomenti & Navigation | 3 | 🟠 High | ⏳ Pending |
| **EPIC-6** | Amministrazione | 3 | 🟠 High | ⏳ Pending |
| **EPIC-7** | Novità & Eventi | 4 | 🟠 High | ⏳ Pending |
| **EPIC-8** | Servizi | 4 | 🟠 High | ⏳ Pending |
| **EPIC-9** | Appuntamento Wizard | 8 | 🟠 High | ⏳ Pending |
| **EPIC-10** | Assistenza & Segnalazione | 9 | 🟡 Medium | ⏳ Pending |
| **EPIC-11** | Testing & QA | 5 | 🔴 Critical | ⏳ Pending |
| **EPIC-12** | Documentation | 4 | 🟡 Medium | ⏳ Pending |

**Total Stories:** 62

---

## 🎯 EPIC-1: Foundation Setup

**Description:** Setup architettura base, routing Folio, componenti Volt, e sistema JSON blocks

**Priority:** 🔴 Critical
**Estimated Effort:** 5 stories
**Acceptance Criteria:**
- [ ] `[slug].blade.php` creato e funzionante
- [ ] JSON content structure definita
- [ ] Block rendering system implementato
- [ ] Theme detection funzionante
- [ ] Vite build configurato

---

### STORY-1.1: Create Single [slug].blade.php

**Description:** Creare il file Folio `[slug].blade.php` che gestisce TUTTE le pagine tests

**Acceptance Criteria:**
- [ ] File creato in `resources/views/pages/tests/[slug].blade.php`
- [ ] Volt component con mount(string $slug)
- [ ] pageSlug = 'tests.' . $slug
- [ ] Carica JSON content da config path
- [ ] Renderizza blocks con loop @foreach

**Technical Tasks:**
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
    public string $slug = '';
    public string $pageSlug = '';
    
    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = $this->getContent($this->pageSlug);
    }
    
    private function getContent(string $pageSlug): array
    {
        $filePath = config_path('local/fixcity/database/content/pages/'.$pageSlug.'.json');
        
        if (!file_exists($filePath)) {
            abort(404, 'Content not found');
        }
        
        return json_decode(file_get_contents($filePath), true);
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

**Tests:**
```php
it('loads homepage JSON content', function () {
    $response = get('/it/tests/homepage');
    $response->assertStatus(200);
});

it('returns 404 for missing JSON', function () {
    $response = get('/it/tests/nonexistent');
    $response->assertStatus(404);
});
```

---

### STORY-1.2: Define JSON Content Structure

**Description:** Definire la struttura JSON per i content blocks

**Acceptance Criteria:**
- [ ] Schema JSON definito
- [ ] Template per homepage creato
- [ ] Block types catalogati
- [ ] Validation implementata

**JSON Template:**
```json
{
  "slug": "tests.homepage",
  "title": "Homepage - Comune di FixCity",
  "meta": {
    "description": "Sito ufficiale del Comune di FixCity",
    "keywords": ["comune", "fixcity", "servizi"]
  },
  "blocks": [
    {
      "type": "hero",
      "weight": 10,
      "data": {
        "view": "pub_theme::components.blocks.hero.default",
        "title": "NOME DEL COMUNE",
        "subtitle": "CONTENUTI IN EVIDENZA",
        "backgroundImage": "/themes/sixteen/images/hero-bg.jpg"
      }
    }
  ]
}
```

---

### STORY-1.3: Implement Block Rendering System

**Description:** Creare il sistema di rendering per i block components

**Acceptance Criteria:**
- [ ] `<x-page>` component creato
- [ ] Block loop implementato
- [ ] Component resolver funzionante
- [ ] Data passing corretto

**Implementation:**
```blade
{{-- resources/views/components/page.blade.php --}}
@props(['slug', 'data'])

<div class="page-content">
    @if(isset($data['blocks']) && is_array($data['blocks']))
        @foreach($data['blocks'] as $block)
            @php
                $blockType = $block['type'] ?? null;
                $blockData = $block['data'] ?? [];
                $view = $blockData['view'] ?? null;
            @endphp
            
            @if($blockType && $view)
                @if(view()->exists($view))
                    {!! view($view, ['data' => $blockData])->render() !!}
                @else
                    {{-- Fallback: dynamic component --}}
                    <x-dynamic-component 
                        :component="'pub_theme::components.blocks.'.$blockType.'.default'" 
                        :data="$blockData" 
                    />
                @endif
            @endif
        @endforeach
    @endif
</div>
```

---

### STORY-1.4: Implement Theme Detection

**Description:** Implementare theme detection da APP_URL

**Acceptance Criteria:**
- [ ] Theme detection da APP_URL
- [ ] Config path construction
- [ ] Fallback mechanism
- [ ] Caching implementato

**Implementation:**
```php
// Cms/Actions/Theme/GetThemeAction.php

declare(strict_types=1);

namespace Modules\Cms\Actions\Theme;

use Spatie\QueueableAction\QueueableAction;

class GetThemeAction
{
    use QueueableAction;

    public function execute(): string
    {
        $appUrl = config('app.url');
        $parsed = parse_url($appUrl);
        $host = $parsed['host'] ?? 'localhost';
        $host = str_replace('www.', '', $host);
        $parts = array_reverse(explode('.', $host));
        $configPath = implode('/', $parts);
        
        $configFile = config_path("local/{$configPath}/xra.php");
        
        if (file_exists($configFile)) {
            $config = include $configFile;
            return $config['pub_theme'] ?? 'Sixteen';
        }
        
        return 'Sixteen'; // Default fallback
    }
}
```

---

### STORY-1.5: Configure Vite Build

**Description:** Configurare Vite per theme build con outDir corretto

**Acceptance Criteria:**
- [ ] vite.config.js con outDir: './public'
- [ ] package.json scripts definiti
- [ ] npm run copy configurato
- [ ] Manifest generation funzionante

**vite.config.js:**
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    build: {
        outDir: './public',
        emptyOutDir: true,
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
                style: resolve(__dirname, 'resources/css/app.css'),
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
    ],
});
```

**package.json:**
```json
{
  "scripts": {
    "build": "vite build",
    "copy": "cp -rv ./public/* ../../../public_html/themes/Sixteen/"
  }
}
```

---

## 🎯 EPIC-2: Header & Footer

**Description:** Implementare header e footer components identici a Design Comuni

**Priority:** 🔴 Critical
**Estimated Effort:** 4 stories

---

### STORY-2.1: Implement Skip Links

**Description:** Creare skip links accessibili

**Acceptance Criteria:**
- [ ] "Vai ai contenuti" link
- [ ] "Vai al footer" link
- [ ] Visually-hidden-focusable styling
- [ ] Primo elemento focusable

**Implementation:**
```blade
<a class="visually-hidden-focusable" href="#main-content">
    Vai ai contenuti
</a>
<a class="visually-hidden-focusable" href="#footer">
    Vai al footer
</a>
```

**CSS:**
```css
.visually-hidden-focusable {
    @apply sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 
           focus:z-50 focus:px-4 focus:py-2 focus:bg-white focus:text-black 
           focus:font-bold focus:rounded;
}
```

---

### STORY-2.2: Implement Top Bar

**Description:** Creare top bar con region name, language selector, login

**Acceptance Criteria:**
- [ ] Region name visible
- [ ] Language selector (ITA/ENG)
- [ ] Login button con icona
- [ ] Responsive behavior

---

### STORY-2.3: Implement Header Branding

**Description:** Creare header con stemma, nome comune, slogan

**Acceptance Criteria:**
- [ ] Stemma comunale
- [ ] Nome comune (H1)
- [ ] Slogan (opzionale)
- [ ] Social links

---

### STORY-2.4: Implement Footer

**Description:** Creare footer multi-colonna con legal bar

**Acceptance Criteria:**
- [ ] 6 colonne (Branding, Amministrazione, Servizi, Novità, Vivere, Contatti)
- [ ] Social links
- [ ] Legal bar con link
- [ ] Responsive stacking

---

## 🎯 EPIC-3: Block Components

**Description:** Implementare tutti i block types universali e riutilizzabili

**Priority:** 🔴 Critical
**Estimated Effort:** 10 stories

---

### STORY-3.1: Hero Block

**Description:** Implementare hero block con varianti

**Acceptance Criteria:**
- [ ] Hero con background image
- [ ] Hero senza image
- [ ] Overlay option
- [ ] Theme (dark/light)

**File:** `resources/views/components/blocks/hero/default.blade.php`

---

### STORY-3.2: Topics Grid Block

**Description:** Implementare griglia argomenti con icone

**Acceptance Criteria:**
- [ ] Grid responsive (1/2/3 colonne)
- [ ] Card con icona
- [ ] Title, description, url
- [ ] "Mostra tutti" button

---

### STORY-3.3: Card Block

**Description:** Implementare card component con varianti

**Acceptance Criteria:**
- [ ] Variant: default
- [ ] Variant: with-image
- [ ] Variant: with-icon
- [ ] Category badge
- [ ] Date display

---

### STORY-3.4: News Section Block

**Description:** Implementare sezione notizie

**Acceptance Criteria:**
- [ ] Title sezione
- [ ] Grid 3 colonne
- [ ] Card news
- [ ] "Tutte le novità" link

---

### STORY-3.5: Governance Section Block

**Description:** Implementare sezione organi di governo

**Acceptance Criteria:**
- [ ] Title sezione
- [ ] Card per organo
- [ ] Nome, ruolo, descrizione
- [ ] "Vai alla pagina" button

---

### STORY-3.6: Events List Block

**Description:** Implementare lista eventi

**Acceptance Criteria:**
- [ ] Title + mese
- [ ] Lista verticale
- [ ] Data (giorno/mese)
- [ ] Titolo, orario, link

---

### STORY-3.7: Search Form Block

**Description:** Implementare form di ricerca

**Acceptance Criteria:**
- [ ] Input field
- [ ] Submit button
- [ ] Placeholder text
- [ ] Accessibility labels

---

### STORY-3.8: Feedback Form Block

**Description:** Implementare form feedback utenti

**Acceptance Criteria:**
- [ ] Rating stars (1-5)
- [ ] Checklist aspetti preferiti
- [ ] Checklist difficoltà
- [ ] Text area dettagli

---

### STORY-3.9: Services Grid Block

**Description:** Implementare griglia servizi

**Acceptance Criteria:**
- [ ] Grid responsive
- [ ] Card servizio
- [ ] Icona, titolo, descrizione
- [ ] Categoria

---

### STORY-3.10: Appointment Wizard Block

**Description:** Implementare wizard prenotazione appuntamenti

**Acceptance Criteria:**
- [ ] Multi-step form (8 steps)
- [ ] Progress indicator
- [ ] Validation
- [ ] Summary step

---

## 🎯 EPIC-4: Homepage Replication

**Description:** Replicare homepage Design Comuni con JSON content

**Priority:** 🔴 Critical
**Estimated Effort:** 3 stories

---

### STORY-4.1: Create Homepage JSON

**Description:** Creare JSON content per homepage

**Acceptance Criteria:**
- [ ] File: `tests.homepage.json`
- [ ] Blocks: hero, news, governance, events, topics, search, feedback
- [ ] Data strutturato
- [ ] Validation passata

---

### STORY-4.2: Implement Homepage HTML

**Description:** Implementare struttura HTML homepage

**Acceptance Criteria:**
- [ ] HTML identico a Design Comuni
- [ ] CSS classes corrette
- [ ] Data attributes presenti
- [ ] Scripts esclusi

---

### STORY-4.3: Visual Parity Check

**Description:** Verificare identità visiva homepage

**Acceptance Criteria:**
- [ ] Screenshot comparison
- [ ] Colors match
- [ ] Spacing match
- [ ] Typography match

---

## 🎯 EPIC-5: Argomenti & Navigation

**Description:** Replicare pagina Argomenti e navigazione

**Priority:** 🟠 High
**Estimated Effort:** 3 stories

---

### STORY-5.1: Create Argomenti JSON

**Description:** Creare JSON content per pagina Argomenti

---

### STORY-5.2: Implement Argomenti HTML

**Description:** Implementare struttura HTML pagina Argomenti

---

### STORY-5.3: Implement Mega Menu

**Description:** Implementare mega menu per navigazione

---

## 🎯 EPIC-6: Amministrazione

**Description:** Replicare pagine Amministrazione

**Priority:** 🟠 High
**Estimated Effort:** 3 stories

---

### STORY-6.1: Create Amministrazione JSON

**Description:** Creare JSON content per pagina Amministrazione

---

### STORY-6.2: Implement Amministrazione HTML

**Description:** Implementare struttura HTML pagina Amministrazione

---

### STORY-6.3: Implement Documenti e Dati

**Description:** Replicare pagina Documenti e Dati

---

## 🎯 EPIC-7: Novità & Eventi

**Description:** Replicare pagine Novità ed Eventi

**Priority:** 🟠 High
**Estimated Effort:** 4 stories

---

### STORY-7.1: Create Novità JSON

**Description:** Creare JSON content per pagina Novità

---

### STORY-7.2: Implement Novità HTML

**Description:** Implementare struttura HTML pagina Novità

---

### STORY-7.3: Create Eventi JSON

**Description:** Creare JSON content per pagina Eventi

---

### STORY-7.4: Implement Eventi HTML

**Description:** Implementare struttura HTML pagina Eventi

---

## 🎯 EPIC-8: Servizi

**Description:** Replicare pagine Servizi

**Priority:** 🟠 High
**Estimated Effort:** 4 stories

---

### STORY-8.1: Create Servizi JSON

**Description:** Creare JSON content per pagina Servizi

---

### STORY-8.2: Implement Servizi HTML

**Description:** Implementare struttura HTML pagina Servizi

---

### STORY-8.3: Create Servizio Dettaglio JSON

**Description:** Creare JSON content per dettaglio servizio

---

### STORY-8.4: Implement Servizio Dettaglio HTML

**Description:** Implementare struttura HTML dettaglio servizio

---

## 🎯 EPIC-9: Appuntamento Wizard

**Description:** Implementare wizard prenotazione appuntamento (8 steps)

**Priority:** 🟠 High
**Estimated Effort:** 8 stories

---

### STORY-9.1: Step 1 - Ufficio

**Description:** Implementare step selezione ufficio

---

### STORY-9.2: Step 1 - Luogo

**Description:** Implementare step selezione luogo ufficio

---

### STORY-9.3: Step 2 - Data/Ora

**Description:** Implementare step selezione data e ora

---

### STORY-9.4: Step 3 - Dettagli

**Description:** Implementare step inserimento dettagli

---

### STORY-9.5: Step 4 - Richiedente (Non Auth)

**Description:** Implementare step dati richiedente (non autenticato)

---

### STORY-9.6: Step 4 - Richiedente (Auth)

**Description:** Implementare step dati richiedente (autenticato)

---

### STORY-9.7: Step 5 - Riepilogo

**Description:** Implementare step riepilogo

---

### STORY-9.8: Step 6 - Conferma

**Description:** Implementare step conferma

---

## 🎯 EPIC-10: Assistenza & Segnalazione

**Description:** Implementare flussi assistenza e segnalazione disservizio

**Priority:** 🟡 Medium
**Estimated Effort:** 9 stories

---

### STORY-10.1: Assistenza - Step 1 Dati

**Description:** Implementare step inserimento dati assistenza

---

### STORY-10.2: Assistenza - Step 2 Conferma

**Description:** Implementare step conferma assistenza

---

### STORY-10.3: Segnalazione - Dettaglio Servizio

**Description:** Implementare scheda servizio segnalazione

---

### STORY-10.4: Segnalazione - Step 1 Privacy

**Description:** Implementare step consenso privacy

---

### STORY-10.5: Segnalazione - Step 2 Dati

**Description:** Implementare step inserimento dati segnalazione

---

### STORY-10.6: Segnalazione - Step 3 Riepilogo

**Description:** Implementare step riepilogo segnalazione

---

### STORY-10.7: Segnalazione - Step 4 Conferma

**Description:** Implementare step conferma segnalazione

---

### STORY-10.8: Segnalazione - Area Personale

**Description:** Implementare area personale segnalazioni

---

### STORY-10.9: Segnalazione - Elenco

**Description:** Implementare elenco segnalazioni con mappa

---

## 🎯 EPIC-11: Testing & QA

**Description:** Implementare test suite e quality assurance

**Priority:** 🔴 Critical
**Estimated Effort:** 5 stories

---

### STORY-11.1: Pest Tests for Components

**Description:** Scrivere Pest tests per block components

**Acceptance Criteria:**
- [ ] Hero block tests
- [ ] Card block tests
- [ ] Topics grid tests
- [ ] 80%+ coverage

---

### STORY-11.2: Accessibility Audit

**Description:** Eseguire accessibility audit WCAG 2.1 AA

**Acceptance Criteria:**
- [ ] Automated testing (axe-core)
- [ ] Manual keyboard testing
- [ ] Screen reader testing
- [ ] Report completo

---

### STORY-11.3: Performance Audit

**Description:** Eseguire performance audit Lighthouse

**Acceptance Criteria:**
- [ ] Lighthouse score >90
- [ ] FCP <1.5s
- [ ] TTI <3.0s
- [ ] CLS <0.1

---

### STORY-11.4: Cross-Browser Testing

**Description:** Testare cross-browser compatibility

**Acceptance Criteria:**
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge

---

### STORY-11.5: Mobile Responsiveness Testing

**Description:** Testare responsive design

**Acceptance Criteria:**
- [ ] Mobile (<768px)
- [ ] Tablet (768px-991px)
- [ ] Desktop (≥992px)

---

## 🎯 EPIC-12: Documentation

**Description:** Creare documentazione completa con bidirectional links

**Priority:** 🟡 Medium
**Estimated Effort:** 4 stories

---

### STORY-12.1: Screenshot Analysis

**Description:** Creare screenshot analysis per ogni pagina

**Acceptance Criteria:**
- [ ] Screenshot Design Comuni
- [ ] Screenshot FixCity
- [ ] Comparison side-by-side
- [ ] Gap analysis

---

### STORY-12.2: Block Usage Guide

**Description:** Creare guida all'uso dei block components

**Acceptance Criteria:**
- [ ] Catalogo block types
- [ ] Esempi di utilizzo
- [ ] Props documentation
- [ ] Best practices

---

### STORY-12.3: JSON Content Guide

**Description:** Creare guida alla creazione di JSON content

**Acceptance Criteria:**
- [ ] Schema documentation
- [ ] Esempi completi
- [ ] Validation rules
- [ ] Editing tools

---

### STORY-12.4: Update Master Index

**Description:** Aggiornare Master Index con bidirectional links

**Acceptance Criteria:**
- [ ] Link da Master Index a BMad docs
- [ ] Link da BMad docs a Master Index
- [ ] Min 3 cross-references per doc
- [ ] Index aggiornato

---

## 📊 Sprint Allocation

### Sprint 1 (Week 1-2): Foundation

- EPIC-1: Foundation Setup (5 stories)
- EPIC-2: Header & Footer (4 stories)

**Total:** 9 stories

---

### Sprint 2 (Week 3-4): Block Components

- EPIC-3: Block Components (10 stories)

**Total:** 10 stories

---

### Sprint 3 (Week 5-6): Core Pages

- EPIC-4: Homepage (3 stories)
- EPIC-5: Argomenti (3 stories)
- EPIC-6: Amministrazione (3 stories)

**Total:** 9 stories

---

### Sprint 4 (Week 7-8): Content Pages

- EPIC-7: Novità & Eventi (4 stories)
- EPIC-8: Servizi (4 stories)

**Total:** 8 stories

---

### Sprint 5 (Week 9-10): Wizards

- EPIC-9: Appuntamento (8 stories)
- EPIC-10: Assistenza & Segnalazione (9 stories)

**Total:** 17 stories

---

### Sprint 6 (Week 11-12): QA & Docs

- EPIC-11: Testing & QA (5 stories)
- EPIC-12: Documentation (4 stories)

**Total:** 9 stories

---

## 🔗 Cross-References

### Internal Documents

- → [PRD](_bmad-output/design-comuni-prd.md) - Product requirements
- → [Architecture](_bmad-output/design-comuni-architecture.md) - System architecture
- → [UI Spec](_bmad-output/design-comuni-ui-spec.md) - Component specifications
- → [Sprint Plan](_bmad-output/design-comuni-sprint-plan.md) - Timeline

### Project Documentation

- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation
- → [Theme Docs Index](laravel/Themes/Sixteen/docs/00-index.md) - Theme documentation
- → [Replication Master Plan](laravel/Themes/Sixteen/docs/design-comuni/REPLICATION_MASTER_PLAN.md) - Technical guide

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Next Review:** Sprint Planning
**🎯 Status:** Ready for Implementation

🐮 **Epics & Stories Complete - Ready for next BMad phase!**
