# Design Comuni Static Pages Replication Plan

**Date**: 2026-03-30  
**Status**: 🟡 **READY TO EXECUTE**  
**Goal**: Replicate all 38 static pages from Design Comuni as Blade components

---

## 🎯 Objective

Replicate all static pages from [Design Comuni Pagine Statiche](https://github.com/italia/design-comuni-pagine-statiche) as reusable Blade components in Sixteen theme.

**URL Mapping**:
- Source: `https://italia.github.io/design-comuni-pagine-statiche/sito/[page].html`
- Target: `http://fixcity.local/it/tests/[page]`

**Example**:
- `argomento.html` → `/it/tests/argomenti`
- `appuntamento-06-conferma.html` → `/it/tests/appuntamento-06-conferma`

---

## 📋 Page Inventory (38 pages total)

### Generali (9 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 1 | `homepage.html` | `/it/tests/homepage` | P0 |
| 2 | `domande-frequenti.html` | `/it/tests/domande-frequenti` | P1 |
| 3 | `risultati-ricerca.html` | `/it/tests/risultati-ricerca` | P1 |
| 4 | `argomenti.html` | `/it/tests/argomenti` | P0 |
| 5 | `argomento.html` | `/it/tests/argomento/[slug]` | P0 |
| 6 | `lista-risorse.html` | `/it/tests/lista-risorse` | P1 |
| 7 | `lista-categorie.html` | `/it/tests/lista-categorie` | P1 |
| 8 | `lista-risorse-categorie.html` | `/it/tests/lista-risorse-categorie` | P1 |
| 9 | `mappa-sito.html` | `/it/tests/mappa-sito` | P2 |

### Amministrazione (2 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 10 | `amministrazione.html` | `/it/tests/amministrazione` | P0 |
| 11 | `documenti-dati.html` | `/it/tests/documenti-dati` | P1 |

### Novità (2 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 12 | `novita.html` | `/it/tests/novita` | P1 |
| 13 | `novita-dettaglio.html` | `/it/tests/novita/[slug]` | P1 |

### Servizi (3 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 14 | `servizi.html` | `/it/tests/servizi` | P0 |
| 15 | `servizi-categoria.html` | `/it/tests/servizi/[categoria]` | P1 |
| 16 | `servizio-dettaglio.html` | `/it/tests/servizi/[slug]` | P1 |

### Vivere il Comune (2 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 17 | `eventi.html` | `/it/tests/eventi` | P1 |
| 18 | `evento-dettaglio.html` | `/it/tests/eventi/[slug]` | P1 |

### Prenotazione Appuntamento (8 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 19 | `appuntamento-01-ufficio.html` | `/it/tests/appuntamento-01-ufficio` | P0 |
| 20 | `appuntamento-01-ufficio-luogo.html` | `/it/tests/appuntamento-01-ufficio-luogo` | P0 |
| 21 | `appuntamento-02-data-orario.html` | `/it/tests/appuntamento-02-data-orario` | P0 |
| 22 | `appuntamento-03-dettagli.html` | `/it/tests/appuntamento-03-dettagli` | P0 |
| 23 | `appuntamento-04-richiedente.html` | `/it/tests/appuntamento-04-richiedente` | P0 |
| 24 | `appuntamento-04-richiedente-autenticato.html` | `/it/tests/appuntamento-04-richiedente-autenticato` | P0 |
| 25 | `appuntamento-05-riepilogo.html` | `/it/tests/appuntamento-05-riepilogo` | P0 |
| 26 | `appuntamento-06-conferma.html` | `/it/tests/appuntamento-06-conferma` | P0 |

### Richiesta Assistenza (2 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 27 | `assistenza-01-dati.html` | `/it/tests/assistenza-01-dati` | P1 |
| 28 | `assistenza-02-conferma.html` | `/it/tests/assistenza-02-conferma` | P1 |

### Segnalazione Disservizio (7 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 29 | `segnalazione-dettaglio.html` | `/it/tests/segnalazione-dettaglio` | P0 |
| 30 | `segnalazione-01-privacy.html` | `/it/tests/segnalazione-01-privacy` | P0 |
| 31 | `segnalazione-02-dati.html` | `/it/tests/segnalazione-02-dati` | P0 |
| 32 | `segnalazione-03-riepilogo.html` | `/it/tests/segnalazione-03-riepilogo` | P0 |
| 33 | `segnalazione-04-conferma.html` | `/it/tests/segnalazione-04-conferma` | P0 |
| 34 | `segnalazione-area-personale.html` | `/it/tests/segnalazione-area-personale` | P1 |
| 35 | `segnalazioni-elenco.html` | `/it/tests/segnalazioni-elenco` | P1 |

### Additional Pages (3 pages)

| # | Source | Target Route | Priority |
|---|--------|--------------|----------|
| 36 | `amministrazione.html` | `/it/tests/amministrazione` | P1 |
| 37 | `documenti-dati.html` | `/it/tests/documenti-dati` | P1 |
| 38 | `servizi.html` | `/it/tests/servizi` | P1 |

---

## 🏗️ Architecture (DRY + KISS)

### CORRECT Pattern ✅

**Single Dynamic Route**:
```
Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
```

**Route**: `/it/tests/{slug}`

**Blade File**:
```blade
{{-- Themes/Sixteen/resources/views/pages/tests/[slug].blade.php --}}
@layout('layouts.app')

@section('content')
  @include('design-comuni::pages.' . $slug)
@endsection
```

**Component Structure**:
```
Themes/Sixteen/resources/views/design-comuni/
├── pages/                    # Page templates
│   ├── homepage.blade.php
│   ├── argomenti.blade.php
│   ├── argomento.blade.php
│   └── ...
├── components/               # Reusable components
│   ├── header/
│   │   ├── header.blade.php
│   │   ├── navigation.blade.php
│   │   └── mobile-menu.blade.php
│   ├── footer/
│   │   ├── footer.blade.php
│   │   └── social-links.blade.php
│   ├── cards/
│   │   ├── topic-card.blade.php
│   │   ├── service-card.blade.php
│   │   └── news-card.blade.php
│   ├── forms/
│   │   ├── appointment-stepper.blade.php
│   │   ├── form-input.blade.php
│   │   └── form-validation.blade.php
│   └── blocks/
│       ├── hero.blade.php
│       ├── content-block.blade.php
│       └── sidebar.blade.php
└── layouts/
    └── design-comuni.blade.php
```

### WRONG Pattern ❌

**DO NOT CREATE**:
```
❌ Themes/Sixteen/resources/views/pages/tests/argomenti.blade.php
❌ Themes/Sixteen/resources/views/pages/tests/appuntamento-06-conferma.blade.php
❌ Themes/Sixteen/resources/views/pages/tests/[individual-files].blade.php
```

**Why**: Violates DRY - creates 38 separate files instead of 1 dynamic route.

---

## 📦 Component Blocks Identification

### Header Components (5)

1. **Header Main** - `components/header/header.blade.php`
2. **Navigation** - `components/header/navigation.blade.php`
3. **Mobile Menu** - `components/header/mobile-menu.blade.php`
4. **Language Switcher** - `components/header/lang-switcher.blade.php`
5. **Search Bar** - `components/header/search.blade.php`

### Footer Components (4)

1. **Footer Main** - `components/footer/footer.blade.php`
2. **Footer Links** - `components/footer/links.blade.php`
3. **Social Links** - `components/footer/social-links.blade.php`
4. **Contact Info** - `components/footer/contact.blade.php`

### Card Components (6)

1. **Topic Card** - `components/cards/topic-card.blade.php`
2. **Service Card** - `components/cards/service-card.blade.php`
3. **News Card** - `components/cards/news-card.blade.php`
4. **Event Card** - `components/cards/event-card.blade.php`
5. **Document Card** - `components/cards/document-card.blade.php`
6. **Category Card** - `components/cards/category-card.blade.php`

### Form Components (8)

1. **Stepper** - `components/forms/stepper.blade.php`
2. **Form Input** - `components/forms/input.blade.php`
3. **Form Select** - `components/forms/select.blade.php`
4. **Form Checkbox** - `components/forms/checkbox.blade.php`
5. **Form Radio** - `components/forms/radio.blade.php`
6. **Form Validation** - `components/forms/validation.blade.php`
7. **File Upload** - `components/forms/file-upload.blade.php`
8. **Date Picker** - `components/forms/date-picker.blade.php`

### Block Components (7)

1. **Hero** - `components/blocks/hero.blade.php`
2. **Content Block** - `components/blocks/content.blade.php`
3. **Sidebar** - `components/blocks/sidebar.blade.php`
4. **Accordion** - `components/blocks/accordion.blade.php`
5. **Tabs** - `components/blocks/tabs.blade.php`
6. **Modal** - `components/blocks/modal.blade.php`
7. **Alert** - `components/blocks/alert.blade.php`

### Layout Components (2)

1. **Main Layout** - `layouts/design-comuni.blade.php`
2. **Test Layout** - `layouts/tests.blade.php`

---

## 🔄 Execution Workflow

### Phase 1: Setup (2h)

```bash
# 1. Create directory structure
mkdir -p laravel/Themes/Sixteen/resources/views/design-comuni/{pages,components/{header,footer,cards,forms,blocks},layouts}

# 2. Create main layout
touch laravel/Themes/Sixteen/resources/views/design-comuni/layouts/main.blade.php

# 3. Create dynamic route file
touch laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
```

### Phase 2: Extract Components (8h)

**AI Tool Assignment**:
- **Ralph Loop**: Extract HTML → Blade components
- **Qwen**: Document components
- **Claude**: Optimize for reusability

**Process**:
1. Download HTML from demo site
2. Parse HTML into components
3. Convert to Blade syntax
4. Add @props, @slots
5. Test each component

### Phase 3: Create Pages (4h)

**AI Tool Assignment**:
- **Ralph Loop**: Create page templates
- **OpenViking**: Track progress

**Process**:
1. Create page Blade files
2. Include components
3. Add data bindings
4. Test routes

### Phase 4: Documentation (2h)

**AI Tool Assignment**:
- **Qwen**: Write component docs
- **NotebookLM**: Research best practices

**Deliverables**:
- Component index
- Usage examples
- Props documentation

---

## 📊 DRY + KISS Metrics

### DRY Compliance

✅ **Single dynamic route**: `/it/tests/{slug}`  
✅ **Reusable components**: 32 components, used across 38 pages  
✅ **Shared layouts**: 2 layouts for all pages  
✅ **No duplication**: Each component defined once

### KISS Compliance

✅ **Simple routing**: One file handles all test pages  
✅ **Clear naming**: `component-type.blade.php`  
✅ **Easy to extend**: Add new page = add new Blade file in `pages/`  
✅ **Minimal config**: No complex routing setup

---

## 🎯 Success Criteria

### Technical

- [ ] All 38 pages accessible at `/it/tests/[page]`
- [ ] Components reusable (used in ≥2 pages)
- [ ] Documentation complete
- [ ] No PHP errors
- [ ] Bootstrap Italia styling preserved

### Documentation

- [ ] Component index created
- [ ] Usage examples for each component
- [ ] Props/slots documented
- [ ] Cross-references working

---

## 📚 Documentation Structure

```
laravel/Themes/Sixteen/docs/design-comuni/
├── README.md                    # Overview
├── components/
│   ├── 00-INDEX.md             # Component index
│   ├── header.md               # Header components
│   ├── footer.md               # Footer components
│   ├── cards.md                # Card components
│   ├── forms.md                # Form components
│   └── blocks.md               # Block components
├── pages/
│   ├── 00-INDEX.md             # Page index
│   └── [page-name].md          # Individual page docs
└── layouts/
    └── main.md                 # Layout documentation
```

---

## 🤖 AI Tool Assignment

| Tool | Task | Timeline |
|------|------|----------|
| **NotebookLM MCP** | Research Design Comuni patterns | 30min |
| **OpenViking** | Context tracking | Ongoing |
| **Ralph Loop** | Extract HTML → Blade | 6h |
| **Qwen** | Documentation | 2h |
| **Claude** | Component optimization | 2h |
| **GSD** | Phase execution | Ongoing |

---

## ✅ Checklist

### Setup

- [ ] Directory structure created
- [ ] Layout files created
- [ ] Dynamic route file created
- [ ] OpenViking initialized

### Components

- [ ] Header components (5)
- [ ] Footer components (4)
- [ ] Card components (6)
- [ ] Form components (8)
- [ ] Block components (7)
- [ ] Layout components (2)

### Pages

- [ ] General pages (9)
- [ ] Administration (2)
- [ ] News (2)
- [ ] Services (3)
- [ ] Events (2)
- [ ] Appointment (8)
- [ ] Assistance (2)
- [ ] Disruption (7)

### Documentation

- [ ] Component index
- [ ] Page index
- [ ] Usage examples
- [ ] Cross-references

---

**Status**: 🟡 **READY TO EXECUTE**  
**ETA**: 16h total (2 days)  
**Next**: Create directory structure + extract first components

**Let's replicate Design Comuni! 🚀**
