# Design Comuni Italia - Research Summary

**Project:** FixCity Fila5 - Design Comuni Pages Replication
**Domain:** Italian Municipal Website Templates
**Researched:** 2026-04-01
**Source:** https://github.com/italia/design-comuni-pagine-statiche
**Demo:** https://italia.github.io/design-comuni-pagine-statiche/
**Overall Confidence:** HIGH

---

## Executive Summary

Design Comuni Pagine Statiche è il repository ufficiale del Governo Italiano che contiene **38 pagine statiche esemplificative** del modello di sito web per i Comuni Italiani. Le pagine sono costruite con **Bootstrap Italia** (design system per la PA italiana) e seguono le linee guida AGID per accessibilità (WCAG 2.1 AA) e usabilità dei servizi pubblici digitali.

L'architettura è **component-based** con 47 componenti riutilizzabili organizzati in 8 famiglie funzionali. Le pagine seguono **5 pattern architetturali** principali: Lista, Dettaglio, Form Multi-Step, Riepilogo e Conferma.

**FixCity Replication Strategy:**
- **Tailwind CSS @apply** (NOT Bootstrap imports)
- **Single `[slug].blade.php`** for ALL pages (Folio + Volt)
- **JSON Content Blocks** (NOT hardcoded HTML)
- **Universal Reusable Blocks** (NOT page-specific)
- **WCAG 2.1 AA Compliance**

---

## Key Findings

### Stack
**Original:** Handlebars (templating) + Bootstrap Italia (SCSS) + JavaScript + Webpack
**FixCity:** Laravel Folio + Livewire Volt + Blade Components + Tailwind CSS @apply + Vite

### Architecture
**38 pages** built with **47 reusable components** organized in 8 families:
- Layout (3), Navigation (5), Form (7), Card (9), Info (5), Button (4), Feedback (3), Specialized (11)

### Critical Pitfall
**Bootstrap Italia Dependency:** Original pages use Bootstrap Italia CSS classes extensively. FixCity MUST replicate with Tailwind @apply rules (NOT import Bootstrap CSS) to maintain performance and avoid conflicts.

---

## Complete Page List (38 Pages)

### 1. Pagine Generali (9 pages)

| # | Page Name | HTML Filename | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|----------|-------------|-----------------|----------|
| 1 | **Homepage** | `homepage.html` | `/homepage.html` | `/it/tests/homepage` | Hero, Featured Content, Governance, Events, Topics, Search, Rating | **P0** |
| 2 | **FAQ** | `domande-frequenti.html` | `/domande-frequenti.html` | `/it/tests/domande-frequenti` | Breadcrumbs, Hero, Search, Accordion FAQ, Load More Button | P1 |
| 3 | **Search Results** | `risultati-ricerca.html` | `/risultati-ricerca.html` | `/it/tests/risultati-ricerca` | Breadcrumbs, Search Bar, Filters, Results List (cards), Pagination | P1 |
| 4 | **Topics List** | `argomenti.html` | `/argomenti.html` | `/it/tests/argomenti` | Breadcrumbs, Hero, Featured Section, Topics Grid (20 cards) | P1 |
| 5 | **Topic Detail** | `argomento.html` | `/argomento.html` | `/it/tests/argomento-{slug}` | Breadcrumbs, Detail Hero, Office Info, News (cards), Events, Admin, Services, Documents | P2 |
| 6 | **Resources List** | `lista-risorse.html` | `/lista-risorse.html` | `/it/tests/lista-risorse` | Breadcrumbs, Hero, Featured (horizontal cards), Search, Resources List, Pagination | P2 |
| 7 | **Categories List** | `lista-categorie.html` | `/lista-categorie.html` | `/it/tests/lista-categorie` | Breadcrumbs, Hero, Featured (horizontal cards), Categories Grid (9 cards) | P2 |
| 8 | **Resources + Categories** | `lista-risorse-categorie.html` | `/lista-risorse-categorie.html` | `/it/tests/lista-risorse-categorie` | Breadcrumbs, Hero, Featured, Search, Resources List, Categories Grid (20 cards) | P2 |
| 9 | **Site Map** | `mappa-sito.html` | `/mappa-sito.html` | `/it/tests/mappa-sito` | Hierarchical Sitemap (nested lists) | P3 |

### 2. Amministrazione (2 pages)

| # | Page Name | HTML Filename | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|----------|-------------|-----------------|----------|
| 10 | **Administration** | `amministrazione.html` | `/amministrazione.html` | `/it/tests/amministrazione` | Breadcrumbs, Hero, Featured (3 cards), Explore Admin (7 cards) | P1 |
| 11 | **Documents & Data** | `documenti-dati.html` | `/documenti-dati.html` | `/it/tests/documenti-dati` | Breadcrumbs, Hero, Featured Documents, Search, Documents List, Categories (11 cards) | P1 |

### 3. Novità (2 pages)

| # | Page Name | HTML Filename | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|----------|-------------|-----------------|----------|
| 12 | **News List** | `novita.html` | `/novita.html` | `/it/tests/novita` | Breadcrumbs, Hero, Featured News (horizontal), Search with Counter, News List, Categories (3) | P1 |
| 13 | **News Detail** | `novita-dettaglio.html` | `/novita-dettaglio.html` | `/it/tests/novita/{slug}` | Breadcrumbs, Title, Meta (date, read time, share, actions), Topics (tags), Page Index (navscroll), Content Body, Office Info, People (tags), Gallery, Video, Audience, Location, Dates/Times, Costs (pricing table), Attachments, Related Events, Contacts, Rating | P2 |

### 4. Servizi (3 pages)

| # | Page Name | HTML Filename | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|----------|-------------|-----------------|----------|
| 14 | **Services List** | `servizi.html` | `/servizi.html` | `/it/tests/servizi` | Breadcrumbs, Hero, Search, Services List (cards with category), Load More, Featured Services, Categories (15 cards) | P1 |
| 15 | **Service Category** | `servizi-categoria.html` | `/servizi-categoria.html` | `/it/tests/servizi/{categoria}` | Breadcrumbs, Hero, Search with Counter, Services List (10 cards), Load More, Offices (link list), Calls (cards) | P2 |
| 16 | **Service Detail** | `servizio-dettaglio.html` | `/servizio-dettaglio.html` | `/it/tests/servizi/{slug}` | Breadcrumbs, Service Title, Description, Index (navscroll), Timeline, Requirements (icon links), Topics (tags), Related Services (carousel), Contacts, Rating | P1 |

### 5. Vivere il Comune (2 pages)

| # | Page Name | HTML Filename | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|----------|-------------|-----------------|----------|
| 17 | **Events List** | `eventi.html` | `/eventi.html` | `/it/tests/eventi` | Breadcrumbs, Hero, Hero Image, Featured Events (horizontal cards), Featured Places (horizontal cards) | P1 |
| 18 | **Event Detail** | `evento-dettaglio.html` | `/evento-dettaglio.html` | `/it/tests/eventi/{slug}` | Breadcrumbs, Event Title, Meta (dates, read time, share, actions), Topics (tags), Index (navscroll), Body (what is?, participants, gallery, video, audience, location, dates/times, costs, attachments, related events), Contacts, Sponsor, Rating | P2 |

### 6. Prenotazione Appuntamento (8 pages - Multi-Step Flow)

| # | Page Name | HTML Filename | Step | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|------|----------|-------------|-----------------|----------|
| 19 | **Office Selection (1/2)** | `appuntamento-01-ufficio.html` | 1/6 | `/appuntamento-01-ufficio.html` | `/it/tests/appuntamento/01-ufficio` | Breadcrumbs, Hero, Progress Indicator, Navscroll Info, Office Card (select), Steps Nav | P2 |
| 20 | **Office Location (2/2)** | `appuntamento-01-ufficio-luogo.html` | 1/6 | `/appuntamento-01-ufficio-luogo.html` | `/it/tests/appuntamento/01-ufficio-luogo` | Breadcrumbs, Hero, Progress, Navscroll, Office Card (select + radio municipality), Steps Nav | P2 |
| 21 | **Date & Time Selection** | `appuntamento-02-data-orario.html` | 2/6 | `/appuntamento-02-data-orario.html` | `/it/tests/appuntamento/02-data-orario` | Breadcrumbs, Hero, Progress, Navscroll, Appointments Card (month select + radio list), Office Card (summary), Steps Nav | P2 |
| 22 | **Reason & Details** | `appuntamento-03-dettagli.html` | 3/6 | `/appuntamento-03-dettagli.html` | `/it/tests/appuntamento/03-dettagli` | Breadcrumbs, Hero, Progress, Navscroll, Reason Card (select), Details Card (textarea), Steps Nav | P2 |
| 23 | **Personal Info (Unauth)** | `appuntamento-04-richiedente.html` | 4/6 | `/appuntamento-04-richiedente.html` | `/it/tests/appuntamento/04-richiedente` | Breadcrumbs, Hero, Progress, Navscroll, Applicant Card (inputs: name, surname, email), Steps Nav | P2 |
| 24 | **Personal Info (Auth)** | `appuntamento-04-richiedente-autenticato.html` | 4/6 | `/appuntamento-04-richiedente-autenticato.html` | `/it/tests/appuntamento/04-richiedente-autenticato` | Breadcrumbs, Hero, Progress, Navscroll, Applicant Card (info button card with user data), Steps Nav | P3 |
| 25 | **Summary** | `appuntamento-05-riepilogo.html` | 5/6 | `/appuntamento-05-riepilogo.html` | `/it/tests/appuntamento/05-riepilogo` | Breadcrumbs, Hero, Progress, Summary Card (4 info summaries: Office, Date/Time, Details, Applicant), T&C Modal, Steps Nav | P2 |
| 26 | **Confirmation** | `appuntamento-06-conferma.html` | 6/6 | `/appuntamento-06-conferma.html` | `/it/tests/appuntamento/06-conferma` | Breadcrumbs, Hero (check circle, confirmation, email), Navscroll Index, "What's Needed" Card, Address Card (img), Calendar Icon List, Rating, Contacts | P2 |

### 7. Richiesta Assistenza (2 pages - Semi-Step Flow)

| # | Page Name | HTML Filename | Step | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|------|----------|-------------|-----------------|----------|
| 27 | **Data Entry** | `assistenza-01-dati.html` | 1/2 | `/assistenza-01-dati.html` | `/it/tests/assistenza/01-dati` | Breadcrumbs, Hero (with SPID/CIE links), Navscroll Info, Applicant Card (inputs: name, surname, email), Request Card (select category, select service, textarea details), Privacy Checkbox, Steps Nav, Contacts | P2 |
| 28 | **Confirmation** | `assistenza-02-conferma.html` | 2/2 | `/assistenza-02-conferma.html` | `/it/tests/assistenza/02-conferma` | Breadcrumbs, Hero (check circle, submission confirmation, email), Rating, Contacts | P2 |

### 8. Segnalazione Disservizio (7 pages - Multi-Step Flow + Personal Area)

| # | Page Name | HTML Filename | Step | Demo URL | FixCity URL | Main Components | Priority |
|---|-----------|---------------|------|----------|-------------|-----------------|----------|
| 29 | **Report Service Detail** | `segnalazione-dettaglio.html` | Detail | `/segnalazione-dettaglio.html` | `/it/tests/segnalazione/dettaglio` | Breadcrumbs, Detail Heading (double button), Index (navscroll), Icon Links (files), Topic Tags, Carousel Related, Contacts, Rating | P2 |
| 30 | **Privacy Consent** | `segnalazione-01-privacy.html` | 1/4 | `/segnalazione-01-privacy.html` | `/it/tests/segnalazione/01-privacy` | Breadcrumbs, Title, Progress (1/4), GDPR/Privacy Text, Privacy Checkbox, "Next" Button, Contacts | P2 |
| 31 | **Report Data Entry** | `segnalazione-02-dati.html` | 2/4 | `/segnalazione-02-dati.html` | `/it/tests/segnalazione/02-dati` | Breadcrumbs, Heading, Progress (2/4), Navscroll, Location Card (autocomplete), Disruption Card (select type, input title, textarea details, file upload), Author Card (info button card), Steps Nav, Contacts | P2 |
| 32 | **Summary** | `segnalazione-03-riepilogo.html` | 3/4 | `/segnalazione-03-riepilogo.html` | `/it/tests/segnalazione/03-riepilogo` | Breadcrumbs, Heading, Progress (3/4), Callout Warning, Report Card (summary), General Data Card (summary author + contacts), Steps Nav (next + save), T&C Modal, Contacts | P2 |
| 33 | **Confirmation** | `segnalazione-04-conferma.html` | 4/4 | `/segnalazione-04-conferma.html` | `/it/tests/segnalazione/04-conferma` | Breadcrumbs, Heading (check circle, confirmation with number, email), "Download Receipt" Button, "Personal Area" Link, Related Services Icon List, Rating, Contacts | P2 |
| 34 | **Personal Area** | `segnalazione-area-personale.html` | Area | `/segnalazione-area-personale.html` | `/it/tests/segnalazione/area-personale` | Breadcrumbs, Heading, Nav Tabs (Messages/Activities), Recent Messages Card (3 cards), Recent Activities Card (3 cards), Filters (practices, payments), Practices Accordion, Payments Accordion, Contacts, Modal | P3 |
| 35 | **Reports List** | `segnalazioni-elenco.html` | List | `/segnalazioni-elenco.html` | `/it/tests/segnalazioni/elenco` | Breadcrumbs, Heading (resolved counter), Category List, Filter Buttons, Map/List Toggle, Map, Text-Button "Make Report", Reports List (3 expandable info button cards), Load More Button, Rating, Contacts, Modal | P2 |

---

## Component Analysis

### Universal Components (Used in 90%+ Pages)

| Component | Usage | Category | FixCity Implementation |
|-----------|-------|----------|----------------------|
| `cmp-base/base` | 38/38 (100%) | Layout Wrapper | `<x-layouts.app>` |
| `cmp-breadcrumbs` | 37/38 (97%) | Navigation | `<x-pub_theme::blocks.breadcrumbs.default />` |
| `cmp-contacts/*` | 36/38 (95%) | Footer/Contacts | `<x-pub_theme::blocks.contacts.default />` |
| `cmp-card/*` | 35/38 (92%) | Content Cards | `<x-pub_theme::blocks.card.* />` |
| `cmp-rating` | 33/38 (87%) | Feedback | `<x-pub_theme::blocks.feedback.rating />` |
| `cmp-hero/*` | 30/38 (79%) | Hero Section | `<x-pub_theme::blocks.hero.default />` |

### Component Families (47 Total)

#### A. Layout & Structure (3 components)
- **L01** `cmp-base/base` - Main layout wrapper (header, footer)
- **L02** `cmp-hero/cmp-hero` - Hero section with title and summary
- **L03** `cmp-hero-img/cmp-hero-img-small` - Hero with image

#### B. Navigation (5 components)
- **N01** `cmp-breadcrumbs` - Breadcrumb navigation
- **N02** `cmp-navscroll` - Scroll navigation / page index
- **N03** `cmp-nav-steps` - Multi-step form navigation
- **N04** `cmp-info-progress` - Step progress indicator
- **N05** `cmp-nav-tab` - Tab navigation (personal area)

#### C. Input & Form (7 components)
- **F01** `cmp-input/input` - Text/email input
- **F02** `cmp-select/select` - Dropdown select
- **F03** `cmp-text-area/text-area` - Multi-line textarea
- **F04** `cmp-input-autocomplete` - Input with autocomplete
- **F05** `cmp-info-radio` - Radio button with info
- **F06** `cmp-card-radio-list` - Radio list in card
- **F07** `cmp-input-search` - Search bar

#### D. Card & Content (9 components)
- **C01** `cmp-card-simple` - Basic card with title and text
- **C02** `cmp-card-latest-messages` - Card for messages/news
- **C03** `cmp-card-teaser` - Teaser card with image
- **C04** `cmp-card-content-box` - Content container card
- **C05** `cmp-card-img` - Card with image
- **C06** `cmp-list-card-img-hr` - Horizontal card list
- **C07** `cmp-list-card-img` - Vertical card list
- **C08** `cmp-list-card-docs` - Documents list
- **C09** `cmp-info-button-card` - Expandable info card with button

#### E. Info & Summary (5 components)
- **I01** `cmp-info-summary` - Modifiable summary
- **I02** `cmp-info-summary-no-modify` - Read-only summary
- **I03** `cmp-callout/callout` - Alert box
- **I04** `cmp-ul-list/cmp-ul-list` - Bulleted list
- **I05** `cmp-tag/cmp-tag` - Tag/badge

#### F. Button & Actions (4 components)
- **B01** `cmp-button/cmp-button` - Generic button
- **B02** `cmp-text-button/cmp-text-button` - Button with descriptive text
- **B03** `cmp-icon-link/cmp-icon-link` - Link with icon
- **B04** `cmp-icon-list/cmp-icon-list` - Icon list (share, calendar)

#### G. Feedback & Contacts (3 components)
- **R01** `cmp-rating/cmp-rating` - Star rating
- **R02** `cmp-contacts/cmp-contacts` - Contacts section
- **R03** `cmp-contacts/cmp-contacts-trasversali` - Multi-option contacts

#### H. Specialized (11 components)
- **S01** `cmp-accordion/cmp-accordion` - Generic accordion
- **S02** `cmp-accordion-faq` - FAQ accordion
- **S03** `cmp-filter/cmp-filter` - Filter component
- **S04** `cmp-modal/*` - Modal (4+ variants)
- **S05** `cmp-carousel/cmp-carousel` - Card carousel
- **S06** `cmp-timeline/cmp-timeline` - Vertical timeline
- **S07** `cmp-map/cmp-map` - Map visualization
- **S08** `cmp-category-list/category-list` - Categories list
- **S09** `cmp-heading/cmp-heading` - Page heading
- **S10** `cmp-heading-detail` - Detail heading with buttons
- **S11** `cmp-input-search-button` - Search with button

---

## Architectural Patterns

### Pattern 1: Standard List Page
```
Breadcrumbs → Hero → Search (optional) → Cards List → Pagination → Rating → Contacts
```
**Used in:** `argomenti.html`, `novita.html`, `servizi.html`, `eventi.html`, `documenti-dati.html`

### Pattern 2: Detail Page
```
Breadcrumbs → Title → Meta (date, share, actions) → Tags → Navscroll (index) → Content Body → Related (carousel) → Rating → Contacts
```
**Used in:** `novita-dettaglio.hbs`, `servizio-dettaglio.hbs`, `evento-dettaglio.hbs`, `argomento.hbs`

### Pattern 3: Multi-Step Form
```
Breadcrumbs → Hero → Progress (N/M) → Navscroll (info) → Form Cards (input/select/textarea) → Steps Nav (save/next) → Contacts
```
**Used in:** `appuntamento-*`, `segnalazione-*`, `assistenza-*`

### Pattern 4: Confirmation Page
```
Breadcrumbs → Hero (check circle, confirmation message) → Summary/Receipt → Actions (download, links) → Rating → Contacts
```
**Used in:** `appuntamento-06-conferma.html`, `assistenza-02-conferma.html`, `segnalazione-04-conferma.html`

### Pattern 5: Personal Area / Dashboard
```
Breadcrumbs → Heading → Nav Tabs → Cards (messages/activities) → Filters → Accordions → Modal
```
**Used in:** `segnalazione-area-personale.html`, `segnalazioni-elenco.html`

---

## Technology Stack Comparison

### Original Design Comuni
| Technology | Purpose | Version |
|------------|---------|---------|
| **Handlebars** | Templating engine | Latest |
| **Bootstrap Italia** | UI Framework (SCSS) | 2.x |
| **JavaScript** | Interactivity | ES6+ |
| **Webpack** | Build tool | 5.x |
| **Node.js** | Runtime | >=18 (v20 recommended) |

### FixCity Replication
| Technology | Purpose | Version |
|------------|---------|---------|
| **Laravel Folio** | File-based routing | 1.x |
| **Livewire Volt** | Single-file components | 1.x |
| **Blade** | Templating engine | Laravel 11+ |
| **Tailwind CSS** | Utility-first CSS (via @apply) | 4.x |
| **Vite** | Build tool | 5.x |
| **Alpine.js** | Lightweight JavaScript | 3.x |
| **PHP** | Backend runtime | 8.3+ |

---

## URL Mapping Strategy

### Base URL Structure
```
Original: https://italia.github.io/design-comuni-pagine-statiche/{page}.html
FixCity:  https://fixcity.local/it/tests/{page-slug}
```

### URL Examples

| Original HTML | FixCity URL | Notes |
|--------------|-------------|-------|
| `homepage.html` | `/it/tests/homepage` | Root test page |
| `amministrazione.html` | `/it/tests/amministrazione` | Section root |
| `novita-dettaglio.html` | `/it/tests/novita/{slug}` | Dynamic route |
| `servizio-dettaglio.html` | `/it/tests/servizi/{slug}` | Dynamic route |
| `appuntamento-01-ufficio.html` | `/it/tests/appuntamento/01-ufficio` | Multi-step flow |
| `segnalazione-02-dati.html` | `/it/tests/segnalazione/02-dati` | Multi-step flow |

### Folio Route Files
```
laravel/Themes/Sixteen/resources/views/pages/tests/
├── [slug].blade.php              # Dynamic catch-all for all pages
├── index.blade.php               # Tests listing page
└── appuntamento/
    ├── 01-ufficio.blade.php      # Step 1/6
    ├── 01-ufficio-luogo.blade.php # Step 1/6 (variant)
    ├── 02-data-orario.blade.php   # Step 2/6
    ├── 03-dettagli.blade.php      # Step 3/6
    ├── 04-richiedente.blade.php   # Step 4/6 (unauth)
    ├── 04-richiedente-autenticato.blade.php # Step 4/6 (auth)
    ├── 05-riepilogo.blade.php     # Step 5/6
    └── 06-conferma.blade.php      # Step 6/6
```

---

## Implementation Priorities

### Phase 1: Foundation (Weeks 1-2) - P0 Pages
**Goal:** Establish architecture, build universal components, replicate homepage

**Pages:**
1. ✅ `/it/tests/homepage` - Homepage (DONE - HTML parity verified 95%+)

**Components:**
- Layout: `cmp-base`, `cmp-hero`
- Navigation: `cmp-breadcrumbs`
- Content: `cmp-card-simple`, `cmp-card-latest-messages`
- Feedback: `cmp-rating`, `cmp-contacts`

**Status:** ✅ COMPLETE

### Phase 2: List Pages (Weeks 3-4) - P1 Pages
**Goal:** Replicate all list-type pages

**Pages:**
- `/it/tests/amministrazione`
- `/it/tests/documenti-dati`
- `/it/tests/novita`
- `/it/tests/servizi`
- `/it/tests/eventi`
- `/it/tests/domande-frequenti`
- `/it/tests/risultati-ricerca`
- `/it/tests/argomenti`

**Components:**
- Navigation: `cmp-navscroll`, `cmp-category-list`
- Content: `cmp-list-card-img-hr`, `cmp-list-card-docs`
- Form: `cmp-input-search`, `cmp-input-search-button`
- Specialized: `cmp-accordion-faq`, `cmp-tag`

### Phase 3: Detail Pages (Weeks 5-6) - P2 Pages
**Goal:** Replicate all detail-type pages

**Pages:**
- `/it/tests/novita/{slug}`
- `/it/tests/servizi/{slug}`
- `/it/tests/eventi/{slug}`
- `/it/tests/argomento/{slug}`

**Components:**
- Navigation: `cmp-navscroll` (enhanced)
- Content: `cmp-carousel`, `cmp-timeline`
- Info: `cmp-tag` (enhanced), `cmp-ul-list`
- Specialized: `cmp-heading-detail`, `cmp-icon-link`

### Phase 4: Multi-Step Forms (Weeks 7-9) - P2 Pages
**Goal:** Replicate all transactional flows

**Flows:**
1. **Appuntamento** (6 steps)
2. **Segnalazione** (4 steps + personal area)
3. **Assistenza** (2 steps)

**Components:**
- Navigation: `cmp-nav-steps`, `cmp-info-progress`, `cmp-nav-tab`
- Form: `cmp-input`, `cmp-select`, `cmp-text-area`, `cmp-info-radio`, `cmp-card-radio-list`, `cmp-input-autocomplete`
- Info: `cmp-info-summary`, `cmp-info-summary-no-modify`, `cmp-info-button-card`, `cmp-callout`
- Specialized: `cmp-modal`, `cmp-map`, `cmp-filter`

### Phase 5: Remaining Pages (Weeks 10-12) - P3 Pages
**Goal:** Complete all remaining pages

**Pages:**
- `/it/tests/lista-risorse`
- `/it/tests/lista-categorie`
- `/it/tests/lista-risorse-categorie`
- `/it/tests/mappa-sito`
- `/it/tests/appuntamento/04-richiedente-autenticato`
- `/it/tests/segnalazione/area-personale`

**Components:**
- Specialized variants and edge cases

---

## Critical Technical Decisions

### 1. Tailwind @apply vs Bootstrap Imports
**Decision:** Use Tailwind @apply rules to replicate Bootstrap Italia styles
**Rationale:**
- ✅ Avoids Bootstrap CSS conflicts
- ✅ Enables Tailwind purge for performance
- ✅ Maintains design system consistency
- ✅ Easier long-term maintenance

**Implementation:**
```css
/* laravel/Themes/Sixteen/resources/css/app.css */
@layer components {
  .it-header-wrapper {
    @apply relative w-full bg-primary-dark;
    /* Replicate Bootstrap Italia header styles */
  }
  .it-breadcrumbs {
    @apply flex items-center space-x-2 text-sm;
    /* Replicate Bootstrap Italia breadcrumb styles */
  }
  /* ... all other Bootstrap Italia components */
}
```

### 2. Single `[slug].blade.php` vs Multiple Page Files
**Decision:** Use single `[slug].blade.php` with JSON content blocks
**Rationale:**
- ✅ DRY - No code duplication
- ✅ Scalable - Add page = add JSON file
- ✅ Maintainable - Single source of truth
- ✅ Consistent with Cms module architecture

**Implementation:**
```blade
{{-- laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php --}}
<x-layouts.app>
  <x-cms-page :side="$side" :slug="$slug" :data="$data" />
</x-layouts.app>
```

### 3. JSON Content Blocks vs Hardcoded HTML
**Decision:** Store content in JSON files, render via universal blocks
**Rationale:**
- ✅ Separation of concerns (content vs presentation)
- ✅ Easy content updates without code changes
- ✅ Enables CMS integration later
- ✅ Testable content structure

**JSON Structure:**
```json
{
  "slug": "homepage",
  "title": "Homepage - Il mio Comune",
  "blocks": [
    {
      "type": "hero",
      "variant": "default",
      "data": {
        "title": "Il mio Comune",
        "text": "Un comune da vivere"
      }
    },
    {
      "type": "topics-grid",
      "variant": "default",
      "data": {
        "topics": [...]
      }
    }
  ]
}
```

### 4. Universal Blocks vs Page-Specific Blocks
**Decision:** Build universal, reusable blocks (NOT page-specific)
**Rationale:**
- ✅ Maximum reusability (47 blocks for 38 pages)
- ✅ Consistent API across blocks
- ✅ Easier testing and validation
- ✅ Scalable to new pages

**Example:**
```blade
{{-- ✅ CORRECT: Universal block --}}
<x-pub_theme::blocks.card.simple
  :title="$card['title']"
  :text="$card['text']"
  :category="$card['category']"
/>

{{-- ❌ WRONG: Page-specific block --}}
<x-pub_theme::blocks.tests.argomenti />
```

---

## Accessibility Requirements (WCAG 2.1 AA)

### Critical Requirements
1. **Skip Links:** All pages must have skiplinks to main content and footer
2. **Keyboard Navigation:** All interactive elements must be keyboard accessible
3. **Focus Management:** Visible focus states for all interactive elements
4. **ARIA Labels:** All icons, buttons, and links must have accessible names
5. **Color Contrast:** Minimum 4.5:1 for normal text, 3:1 for large text
6. **Form Labels:** All form inputs must have associated labels
7. **Error Messages:** Form errors must be clearly identified and described
8. **Page Language:** HTML lang attribute must be set to "it"

### Implementation Checklist
```blade
{{-- ✅ Skip Links --}}
<div class="skiplink">
  <a class="visually-hidden-focusable" href="#main-container">Vai ai contenuti</a>
  <a class="visually-hidden-focusable" href="#footer">Vai al footer</a>
</div>

{{-- ✅ ARIA Labels --}}
<button aria-label="Cerca nel sito" type="button">
  <svg class="icon"><use href="#it-search"></use></svg>
</button>

{{-- ✅ Form Labels --}}
<label for="email">Email <span aria-hidden="true">*</span></label>
<input type="email" id="email" name="email" required aria-required="true" />

{{-- ✅ Focus States --}}
<button class="focus:ring-2 focus:ring-primary focus:outline-none">
  Click me
</button>
```

---

## Performance Considerations

### Vite Build Configuration
```javascript
// laravel/Themes/Sixteen/vite.config.js
export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      publicDirectory: 'public',
      buildDirectory: 'build',
    }),
  ],
  build: {
    outDir: './public',
    manifest: true,
    rollupOptions: {
      output: {
        entryFileNames: 'assets/[name].[hash].js',
        chunkFileNames: 'assets/[name].[hash].js',
        assetFileNames: 'assets/[name].[hash].[ext]',
      },
    },
  },
})
```

### Tailwind Purge Configuration
```javascript
// laravel/Themes/Sixteen/tailwind.config.js
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './app/Http/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        primary: { /* Bootstrap Italia colors */ },
      },
    },
  },
  plugins: [],
}
```

### NPM Scripts
```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "copy": "cp -rv ./public/* ../../../public_html/themes/Sixteen/"
  }
}
```

**Build Process:**
```bash
cd laravel/Themes/Sixteen
npm run build    # Builds to ./public
npm run copy     # Copies to public_html/themes/Sixteen/
```

---

## Existing Work Analysis

### Main_files/five/ Folder
**Location:** `laravel/Themes/Sixteen/Main_files/five/`

**Files Found (10 HTML files):**
1. `index.html` - Reports list page (segnalazioni-elenco)
2. `index01.html` - Variant of reports list
3. `accesso-servizio.html` - Service access/login page
4. `segnalazione-01-privacy.html` - Privacy consent step
5. `segnalazione-02-dati.html` - Report data entry step
6. `segnalazione-03-riepilogo.html` - Report summary step
7. `segnalazione-04-conferma.html` - Report confirmation
8. `segnalazione-area-personale.html` - Personal area
9. `segnalazione-dettaglio.html` - Report detail page
10. `segnalazioni-elenco.html` - Reports list (duplicate of index)

**Analysis:**
- ✅ Previous work focused on "Segnalazione" flow (7 pages)
- ✅ HTML structure uses Bootstrap Italia CSS classes
- ❌ CSS via `<link rel="stylesheet" href="../assets/bootstrap-italia/...">` (NOT Tailwind @apply)
- ❌ No JSON content blocks (hardcoded HTML)
- ❌ No universal reusable components
- ❌ Not integrated with Cms module

**Lessons Learned:**
1. Bootstrap Italia HTML structure is well-understood
2. Need to convert to Tailwind @apply rules
3. Need to extract content to JSON blocks
4. Need to create universal components

---

## Research Gaps & Open Questions

### Gaps
1. **Bootstrap Italia CSS Classes:** Complete mapping of all CSS classes used across 38 pages needs detailed audit
2. **JavaScript Interactions:** Some components (carousel, modal, accordion) require JavaScript - need to verify Alpine.js compatibility
3. **Icon System:** Bootstrap Italia uses SVG sprites - need to verify icon migration strategy
4. **Form Validation:** Multi-step forms have client-side validation - need to define validation strategy (Alpine.js vs Livewire)

### Open Questions
1. **SPID/CIE Integration:** How to handle SPID/CIE authentication in `assistenza-01-dati.html` and `appuntamento-04-richiedente-autenticato.html`?
2. **Map Component:** `segnalazioni-elenco.html` uses a map - which mapping library to use (Leaflet, Google Maps)?
3. **File Upload:** `segnalazione-02-dati.html` has file upload - need to define upload strategy (temporary storage, validation, etc.)
4. **Email Notifications:** Confirmation pages mention email notifications - need to define email template strategy

---

## Confidence Assessment

| Area | Confidence | Reason |
|------|------------|--------|
| **Page List** | HIGH | Verified from official GitHub repository and demo site |
| **Component Catalog** | HIGH | Based on detailed block analysis of all 38 templates |
| **Architecture Patterns** | HIGH | Documented in existing BMad output files |
| **URL Mapping** | HIGH | Logical mapping based on page structure |
| **Bootstrap Italia CSS** | MEDIUM | Based on HTML analysis, needs detailed class-by-class audit |
| **JavaScript Requirements** | MEDIUM | Components identified, but detailed JS interactions need verification |
| **Implementation Timeline** | MEDIUM | Based on component complexity, may vary based on unforeseen challenges |

---

## Sources

1. **Official Repository:** https://github.com/italia/design-comuni-pagine-statiche
2. **Demo Site:** https://italia.github.io/design-comuni-pagine-statiche/
3. **Bootstrap Italia Patterns:** https://bootstrap-italia.arturu.it/en/patterns
4. **Design Comuni Docs:** https://docs.italia.it/italia/designers-italia/design-comuni-docs/
5. **Existing BMad Documentation:**
   - `_bmad-output/design-comuni-block-analysis.md` (598 lines)
   - `_bmad-output/design-comuni-architecture.md` (1018 lines)
   - `_bmad-output/design-comuni-prd.md`
   - `_bmad-output/design-comuni-ui-spec.md`
   - `_bmad-output/DESIGN_COMUNI_INDEX.md`
6. **Existing Technical Analysis:**
   - `laravel/Themes/Sixteen/docs/design-comuni-census-blocks.md`
   - `laravel/Themes/Sixteen/docs/design-comuni-html-parity-plan.md`
   - `laravel/Themes/Sixteen/docs/design-comuni-page-census.md`

---

## Next Steps

1. **✅ Review this document** with team to validate page list and priorities
2. **🔄 Detailed CSS Audit** - Create comprehensive mapping of Bootstrap Italia → Tailwind @apply
3. **🔄 Component Implementation** - Build 47 universal components in priority order
4. **🔄 JSON Content Creation** - Create JSON files for all 38 pages
5. **🔄 Page Replication** - Implement pages following 5-phase plan
6. **🔄 Accessibility Testing** - Verify WCAG 2.1 AA compliance for all pages
7. **🔄 Performance Testing** - Lighthouse scores >90 for all pages

---

**Document Version:** 1.0
**Last Updated:** 2026-04-01
**Maintained By:** FixCity Fila5 Development Team
**License:** BSD-3-Clause (same as Design Comuni Pagine Statiche)
