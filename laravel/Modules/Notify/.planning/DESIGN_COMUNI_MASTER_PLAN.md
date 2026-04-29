# Design Comuni HTML Replication - Master Plan

**Data:** 2026-04-01  
**Stato:** ✅ In Progress  
**Metodologia:** GSD + BMAD + Superpowers  

---

## 🎯 Obiettivo Principale

Replicare le 38 pagine statiche di [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/) con:
- ✅ **HTML dentro `<body>` (esclusi scripts) IDENTICO**
- ✅ **Tailwind CSS @apply** (NON Bootstrap Italia)
- ✅ **Componenti universali e riutilizzabili**
- ✅ **JSON content blocks** per ogni pagina
- ✅ **Documentazione DRY + KISS**

---

## 📋 Principi Guida (La "Religione")

### 1. UNO `[slug].blade.php` per TUTTE le pagine

```blade
{{-- ✅ CORRETTO: templates/pages/tests/[slug].blade.php --}}
<?php
name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';
    public array $data = [];

    public function mount(string $slug): void {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
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

```blade
{{-- ❌ SBAGLIATO: MAI creare file specifici --}}
templates/pages/tests/homepage.blade.php
templates/pages/tests/amministrazione.blade.php
templates/pages/tests/argomenti.blade.php
```

---

### 2. Namespace `pub_theme` (NON `sixteen::`)

```blade
{{-- ✅ CORRETTO --}}
<x-page />
<x-section slug="header" />
<x-section slug="footer" tpl="slim" />
<x-pub_theme::blocks.hero.homepage />

{{-- ❌ SBAGLIATO --}}
<x-sixteen::page />
<x-sixteen::blocks.hero />
<x-pub_theme::layouts.design-comuni />
```

---

### 3. Layout Hierarchy

```
x-layouts.main (main.blade.php)
    ↓
x-layouts.app (app.blade.php) ← ESTENDE main
    ↓
    <x-section slug="header" />
    <x-page side="content" :slug="$pageSlug" />
    <x-section slug="footer" />
```

**Perché:**
- ✅ DRY: HTML structure definita UNA sola volta
- ✅ KISS: main gestisce complessità, app aggiunge semantica
- ✅ Single Source of Truth: Vite, Filament, Dark mode

---

### 4. JSON Content Blocks

```json
{
  "id": "tests.homepage",
  "slug": "tests.homepage",
  "content_blocks": {
    "it": [
      {
        "id": "block-001",
        "type": "header-slim",
        "data": {
          "view": "pub_theme::components.blocks.header.slim",
          "region": "Nome Regione"
        }
      },
      {
        "id": "block-002",
        "type": "header-main",
        "data": {
          "view": "pub_theme::components.blocks.header.main",
          "municipality": "Nome Comune"
        }
      }
    ]
  }
}
```

**Path:** `laravel/config/local/fixcity/database/content/pages/tests.{slug}.json`

---

### 5. Blocchi Universali (NON specifici per pagina)

```blade
{{-- ✅ CORRETTO: tipo blocco universale --}}
pub_theme::components.blocks.hero.homepage
pub_theme::components.blocks.card.teaser
pub_theme::components.blocks.navigation.main

{{-- ❌ SBAGLIATO: tipo blocco specifico per pagina --}}
pub_theme::components.blocks.tests.argomenti.topics-grid
pub_theme::components.blocks.homepage.special-hero
```

**Ispirazione:**
- https://flowbite.com/blocks/
- https://tailwindcss.com/plus/ui-blocks
- https://daisyui.com/components/
- https://italia.github.io/bootstrap-italia/docs/componenti/introduzione/

---

## 🏗️ Architettura Tecnica

### Theme Detection System

```php
// 1. Leggi APP_URL da .env
APP_URL=http://fixcity.local

// 2. Rimuovi protocollo
fixcity.local

// 3. Rimuovi www
fixcity.local

// 4. Explode per "."
['fixcity', 'local']

// 5. Inverti array
['local', 'fixcity']

// 6. Unisci con "/"
"local/fixcity"

// 7. Leggi config
config('local/fixcity/xra.php')
    → 'pub_theme' => 'Sixteen'

// 8. Tema folder
laravel/Themes/Sixteen/
```

---

### Vite Configuration

**File:** `laravel/Themes/Sixteen/vite.config.js`

```js
export default {
  build: {
    outDir: './public', // ✅ CORRETTO
    manifest: true,
  },
  // ...
}
```

**File:** `laravel/Themes/Sixteen/package.json`

```json
{
  "scripts": {
    "build": "vite build",
    "copy": "cp -rv ./public/* ../../../public_html/themes/Sixteen/"
  }
}
```

**Usage in Blade:**

```blade
{{-- ✅ CORRETTO: con secondo parametro --}}
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Sixteen')

{{-- ❌ SBAGLIATO: senza secondo parametro --}}
@vite(['resources/css/app.css'])
```

---

### Build Workflow

```bash
cd laravel/Themes/Sixteen
composer update -W
npm install
npm run build
npm run copy
```

**Perché:**
- ✅ Theme è indipendente dal core Laravel
- ✅ Build in `public/` del tema
- ✅ Copy in `public_html/themes/Sixteen/`
- ✅ Manifest corretto per `@vite()`

---

## 📁 Struttura Cartelle

### ✅ Cartelle PERMESSE

```
laravel/Themes/Sixteen/resources/views/pages/
├── tests/           ← Pagine di test (Design Comuni)
│   └── [slug].blade.php
├── auth/            ← Autenticazione
│   ├── login.blade.php
│   └── register.blade.php
└── [container0]/    ← Pagine dinamiche CMS
    └── [slug].blade.php
```

### ❌ Cartelle DA ELIMINARE

```
laravel/Themes/Sixteen/resources/views/pages/
├── administration/  ← ❌
├── ambiente/        ← ❌
├── article/         ← ❌
├── articles/        ← ❌
├── categories/      ← ❌
├── cultura/         ← ❌
├── dashboard/       ← ❌
├── eventi/          ← ❌
├── famiglia/        ← ❌
├── genesis/         ← ❌
├── lavoro/          ← ❌
├── learn/           ← ❌
├── mobilita/        ← ❌
├── news/            ← ❌
├── pages/           ← ❌
├── profile/         ← ❌
├── salute/          ← ❌
├── segnalazioni/    ← ❌
├── services/        ← ❌
├── sport/           ← ❌
├── tickets/         ← ❌
└── turismo/         ← ❌
```

---

## 🎨 Design System

### CSS Architecture

**File:** `laravel/Themes/Sixteen/resources/css/app.css`

```css
/* ✅ CORRETTO: Tailwind @apply */
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:...');
@import 'tailwindcss';

.it-header-slim-wrapper {
  @apply py-2 text-sm bg-[#00614a];
}

/* ❌ SBAGLIATO: @import Bootstrap */
@import url('https://cdn.jsdelivr.net/npm/bootstrap-italia...');
```

### JavaScript Architecture

**File:** `laravel/Themes/Sixteen/resources/js/app.js`

```js
// ✅ CORRETTO: Alpine.js + Tailwind
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

// ❌ SBAGLIATO: Bootstrap Italia JS
import "bootstrap-italia/dist/js/bootstrap-italia.bundle.min.js"
```

---

## 📊 Pagine da Replicare (38 totali)

### Homepage
- [ ] `homepage.html` → `tests.homepage.json`

### Amministrazione
- [ ] `amministrazione.html` → `tests.amministrazione.json`
- [ ] `amministrazione-aree.html` → `tests.amministrazione-aree.json`
- [ ] `amministrazione-organi.html` → `tests.amministrazione-organi.json`
- [ ] `amministrazione-uffici.html` → `tests.amministrazione-uffici.json`

### Argomenti
- [ ] `argomenti.html` → `tests.argomenti.json`
- [ ] `argomento-dettaglio.html` → `tests.argomento-dettaglio.json`

### Novità
- [ ] `novita.html` → `tests.novita.json`
- [ ] `novita-dettaglio.html` → `tests.novita-dettaglio.json`

### Appuntamenti
- [ ] `appuntamento-01-dati.html` → `tests.appuntamento-01-dati.json`
- [ ] `appuntamento-02-privacy.html` → `tests.appuntamento-02-privacy.json`
- [ ] `appuntamento-03-riepilogo.html` → `tests.appuntamento-03-riepilogo.json`
- [ ] `appuntamento-04-conferma.html` → `tests.appuntamento-04-conferma.json`
- [ ] `appuntamento-05-area-personale.html` → `tests.appuntamento-05-area-personale.json`
- [ ] `appuntamento-06-dettaglio.html` → `tests.appuntamento-06-dettaglio.json`

### Documenti
- [ ] `documenti.html` → `tests.documenti.json`
- [ ] `documenti-dati.html` → `tests.documenti-dati.json`

### Servizi
- [ ] `servizi.html` → `tests.servizi.json`
- [ ] `servizi-dettaglio.html` → `tests.servizi-dettaglio.json`

### Segnalazioni
- [ ] `segnalazione-01-privacy.html` → `tests.segnalazione-01-privacy.json`
- [ ] `segnalazione-02-dati.html` → `tests.segnalazione-02-dati.json`
- [ ] `segnalazione-03-riepilogo.html` → `tests.segnalazione-03-riepilogo.json`
- [ ] `segnalazione-04-conferma.html` → `tests.segnalazione-04-conferma.json`
- [ ] `segnalazione-area-personale.html` → `tests.segnalazione-area-personale.json`
- [ ] `segnalazione-dettaglio.html` → `tests.segnalazione-dettaglio.json`
- [ ] `segnalazioni-elenco.html` → `tests.segnalazioni-elenco.json`

### Altre Pagine
- [ ] `cultura.html` → `tests.cultura.json`
- [ ] `eventi.html` → `tests.eventi.json`
- [ ] `famiglia.html` → `tests.famiglia.json`
- [ ] `lavoro.html` → `tests.lavoro.json`
- [ ] `mobilita.html` → `tests.mobilita.json`
- [ ] `salute.html` → `tests.salute.json`
- [ ] `sport.html` → `tests.sport.json`
- [ ] `turismo.html` → `tests.turismo.json`

---

## 🔧 Fix Immediati Richiesti

### 1. Header HTML Structure

**Target:** `http://fixcity.local/it/tests/homepage`

```html
<!-- ✅ CORRETTO: Design Comuni -->
<body>
    <div class="skiplink">
        <a class="visually-hidden-focusable" href="#main-container">
            Vai ai contenuti
        </a>
        <a class="visually-hidden-focusable" href="#footer">
            Vai al footer
        </a>
    </div>
    
    <header class="it-header-wrapper" data-bs-target="#header-nav-wrapper">
        <div class="it-header-slim-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="it-header-slim-wrapper-content">
                            <!-- ... -->
```

### 2. Footer Section Call

```blade
{{-- ✅ CORRETTO --}}
<x-section slug="footer" />
<x-section slug="footer" tpl="slim" />

{{-- ❌ SBAGLIATO --}}
<x-footer />
<x-pub_theme::footer />
```

### 3. Icon Rendering (Filament Way)

```blade
{{-- ✅ CORRETTO: Filament way --}}
<x-filament::icon icon="ui-brands.facebook" class="w-5 h-5" />

{{-- ❌ SBAGLIATO --}}
<x-icon name="facebook" />
<img src="facebook.svg" />
```

**SVG Path:** `laravel/Modules/UI/resources/svg/brands/facebook.svg`

---

## 📚 Documentazione Richiesta

### Da Creare/Aggiornare

1. **Theme Docs:**
   - `laravel/Themes/Sixteen/docs/design-comuni/HTML_REPLICATION_GUIDE.md`
   - `laravel/Themes/Sixteen/docs/design-comuni/BLOCKS_CATALOG.md`
   - `laravel/Themes/Sixteen/docs/design-comuni/SCREENSHOTS/` (analisi differenze)

2. **Module Docs:**
   - `laravel/Modules/Cms/docs/PAGE_COMPONENT_ARCHITECTURE.md`
   - `laravel/Modules/Cms/docs/JSON_CONTENT_BLOCKS.md`

3. **Project Docs:**
   - `docs/project/DESIGN_COMUNI_REPLICATION_STATUS.md`

### Principi Documentazione

- ✅ **Bidirectional links** (min 3 cross-references)
- ✅ **DRY:** No duplicazione contenuti
- ✅ **KISS:** Documentazione semplice e diretta
- ✅ **Agnostica:** No riferimenti a progetti specifici (es. "FixCity")

---

## 🚀 GSD Phases

### Phase 1: Foundation (COMPLETO ✅)
- [x] Setup `[slug].blade.php` pattern
- [x] Register `pub_theme` namespace
- [x] Fix Vite configuration
- [x] Create basic JSON blocks

### Phase 2: Header/Footer Parity (IN CORSO 🔄)
- [ ] HTML structure identical within `<body>`
- [ ] Skip links corretti
- [ ] Header slim identico
- [ ] Header main identico
- [ ] Footer identico
- [ ] Screenshot analysis + docs

### Phase 3: Content Blocks (PENDENTE ⏳)
- [ ] Hero block universale
- [ ] Card block universale
- [ ] Navigation block universale
- [ ] Topics grid universale
- [ ] News carousel universale

### Phase 4: All 38 Pages (PENDENTE ⏳)
- [ ] Create JSON for each page
- [ ] Verify HTML parity
- [ ] Screenshot analysis
- [ ] Documentation

### Phase 5: Polish & Docs (PENDENTE ⏳)
- [ ] Update all docs folders
- [ ] Update rules, memories, skills
- [ ] Create blocks catalog
- [ ] Final verification

---

## 🛠️ Tools & MCP

### Install & Configure

1. **UI/UX Pro Max Skill**
   - https://github.com/nextlevelbuilder/ui-ux-pro-max-skill
   - Frontend design excellence

2. **Superpowers**
   - https://github.com/obra/superpowers
   - Enhanced AI capabilities

3. **BMAD Method**
   - https://github.com/bmad-code-org/BMAD-METHOD
   - Spec-driven development

4. **GSD (Get Shit Done)**
   - https://github.com/gsd-build/get-shit-done
   - Phase execution

5. **Ralph Loop**
   - https://github.com/snarktank/ralph
   - Autonomous execution

6. **OpenViking**
   - https://github.com/volcengine/OpenViking
   - Global context

7. **NotebookLM MCP**
   - Research & synthesis

---

## ✅ Definition of Done

### Per Pagina
- [ ] JSON content block creato
- [ ] HTML dentro `<body>` (esclusi scripts) IDENTICO
- [ ] Screenshot comparison salvato
- [ ] Analisi differenze documentata
- [ ] Fix applicati e verificati

### Per Progetto
- [ ] Tutte 38 pagine replicate
- [ ] Documentazione aggiornata (DRY + KISS)
- [ ] Rules, memories, skills aggiornate
- [ ] Indici con bidirectional links
- [ ] No ridondanza, no file doppi

---

**Data Inizio:** 2026-04-01  
**Data Stimata Completamento:** 2026-04-15  
**Responsabile:** AI Agent Team  

---

*"UNO [slug].blade.php per TUTTE le pagine"*  
*"JSON per contenuti. Blade per struttura"*  
*"DRY + KISS sempre"*  
*"Documenta tutto con link bidirezionali"*
