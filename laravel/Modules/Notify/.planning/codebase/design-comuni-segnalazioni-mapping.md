# Design Comuni - Segnalazioni Mapping

**Analysis Date:** 2026-04-07
**Focus:** 8-page Segnalazione Disservizio flow (privacy → dati → riepilogo → conferma + area personale + elenco + dettaglio)

---

## Page Inventory

| # | Page | Slug | JSON File | Status |
|---|------|------|-----------|--------|
| 1 | Segnalazione Disservizio (landing) | `tests.segnalazione-disservizio` | `tests.segnalazione-disservizio.json` | ✅ Rich data |
| 2 | Step 1 - Privacy | `tests.segnalazione-01-privacy` | `tests.segnalazione-01-privacy.json` | ⚠️ Placeholder blocks |
| 3 | Step 2 - Dati | `tests.segnalazione-02-dati` | `tests.segnalazione-02-dati.json` | ⚠️ Placeholder blocks |
| 4 | Step 3 - Riepilogo | `tests.segnalazione-03-riepilogo` | `tests.segnalazione-03-riepilogo.json` | ⚠️ Placeholder blocks |
| 5 | Step 4 - Conferma | `tests.segnalazione-04-conferma` | `tests.segnalazione-04-conferma.json` | ✅ Real blocks |
| 6 | Area Personale | `tests.segnalazione-area-personale` | `tests.segnalazione-area-personale.json` | ✅ Real blocks |
| 7 | Elenco Segnalazioni | `tests.segnalazioni-elenco` | `tests.segnalazioni-elenco.json` | ✅ Rich data |
| 8 | Dettaglio Segnalazione | `tests.segnalazione-dettaglio` | `tests.segnalazione-dettaglio.json` | ✅ Rich data |

**Reference URLs:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-{page}.html`

---

## 1. Blade Template Architecture

### Entry Point: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```php
name('tests.view');
middleware(PageSlugMiddleware::class);

$pageSlug = 'tests.'.$slug;
$data = ['slug' => $slug];
```

**Structure:**
```blade
<x-layouts.app>
    <x-page side="content" :slug="$pageSlug" :data="$data" />
</x-layouts.app>
```

**Routing pattern:**
- URL: `/it/tests/{slug}` → matches `tests.{slug}` in JSON content
- Middleware: `PageSlugMiddleware` resolves content from `config/local/fixcity/database/content/pages/tests.{slug}.json`
- Single blade → ALL 8 pages via dynamic JSON content

### The `<x-page>` Component (Cms Module)
- Loads JSON content by slug
- Iterates `content_blocks.it[]` array
- Each block: `{ type, data: { view, ... } }`
- Renders via `@include($block['data']['view'], ['data' => $block['data']])`

---

## 2. JSON Content Structure Per Page

### 2.1 `tests.segnalazione-disservizio.json` — Service Landing Page

**Block types used:**
- `breadcrumb` → `pub_theme::components.blocks.breadcrumb.default`
- `tests` → `pub_theme::components.blocks.tests.segnalazione-dettaglio` (reuses detail component)

**Data structure:**
```json
{
  "title": "Segnalazione disservizio",
  "status": "Servizio attivo",
  "summary": "Un servizio aperto a tutti i cittadini...",
  "primary_action": { "label": "Segnala disservizio", "url": "/it/tests/segnalazione-01-privacy" },
  "secondary_action": { "label": "Tutte le segnalazioni", "url": "/it/tests/segnalazioni-elenco" },
  "share_links": [{ "label": "Facebook", "icon": "it-facebook" }, ...],
  "view_actions": [{ "label": "Stampa", "icon": "it-print" }, ...],
  "sections": [
    { "id": "who-needs", "title": "A chi è rivolto", "content": "<p>...</p>" },
    { "id": "description", "title": "Descrizione", "content": "<p>...</p>" },
    { "id": "how-to", "title": "Come fare", "content": "<p>...</p>" },
    { "id": "needed", "title": "Cosa serve", "class": "mb-30 has-bg-grey p-3", "content": "<ul>...</ul>" },
    { "id": "obtain", "title": "Cosa si ottiene", "content": "<p>...</p>" },
    { "id": "costs", "title": "Costi", "content": "<p>...</p>", "links": [...] },
    { "id": "service-access", "title": "Fai una segnalazione", "class": "mb-30 has-bg-grey p-3",
      "content": "<p>...</p>", "buttons": [
        { "label": "Segnala disservizio", "url": "/it/tests/segnalazione-01-privacy", "variant": "btn-primary" },
        { "label": "Prenota appuntamento", "variant": "btn-outline-primary t-primary bg-white" }
      ]
    },
    { "id": "conditions", "title": "Condizioni di servizio", "content": "<p>...</p>", "links": [...] }
  ],
  "contact": { "office": "Ufficio Servizio pubblico", "details": "...", "url": "#" },
  "topics": [{ "label": "Gestione rifiuti", "url": "#" }, ...],
  "updated_at": "14/04/2022"
}
```

### 2.2 `tests.segnalazione-01-privacy.json` — Step 1 (Privacy)

**Block types used (all placeholders):**
- `tests` → `pub_theme::components.blocks.tests.intro` — title/category/summary
- `tests` → `pub_theme::components.blocks.tests.body` — conversion scenario text
- `tests` → `pub_theme::components.blocks.tests.governance-note` — governance note
- `tests` → `pub_theme::components.blocks.tests.source-link` — reference URL

**⚠️ GAP:** These are meta-documentation blocks, NOT the actual Privacy step UI. The real form (stepper, checkbox, CTA) is NOT implemented in JSON/blade yet.

### 2.3 `tests.segnalazione-02-dati.json` — Step 2 (Data Entry)

**Same placeholder pattern as 01-privacy:**
- `intro`, `body`, `governance-note`, `source-link`

**⚠️ GAP:** The actual multi-section form (luogo, disservizio, autore) with file upload, geolocation, and stepper navigation is NOT implemented.

### 2.4 `tests.segnalazione-03-riepilogo.json` — Step 3 (Summary)

**Same placeholder pattern:**
- `intro`, `body`, `governance-note`, `source-link`

**⚠️ GAP:** The summary/review page with all collected data and submission button is NOT implemented.

### 2.5 `tests.segnalazione-04-conferma.json` — Step 4 (Confirmation)

**Block types used (REAL):**
- `flow-stepper` → `pub_theme::components.blocks.flow.stepper`
- `flow-conferma` → `pub_theme::components.blocks.flow.segnalazione.04-conferma`

**Data structure:**
```json
{
  "flow-stepper": {
    "title": "Segnalazione disservizio",
    "steps": [
      { "title": "Privacy", "completed": true },
      { "title": "Dati", "completed": true },
      { "title": "Dettagli", "completed": true },
      { "title": "Conferma", "completed": false }
    ],
    "currentStep": 4,
    "navigable": false
  },
  "flow-conferma": {
    "title": "Segnalazione inviata",
    "segnalazione": {
      "codice_segnalazione": "SEG-2025-005678",
      "categoria": "Illuminazione pubblica",
      "titolo": "Lampione spento in via Roma"
    }
  }
}
```

### 2.6 `tests.segnalazione-area-personale.json` — Personal Area

**Block types:**
- `breadcrumb` → `pub_theme::components.blocks.breadcrumb.default`
- `hero` → `pub_theme::components.blocks.hero.default`
- `card-list` → `pub_theme::components.blocks.card.list`

**Minimal data:**
```json
{
  "hero": { "title": "Segnalazione - Area personale", "content": "<p>Gestione delle tue segnalazioni.</p>" },
  "card-list": { "title": "Le tue segnalazioni", "items": [
    { "title": "Segnalazione 1", "excerpt": "Stato: In lavorazione", "url": "#" },
    { "title": "Segnalazione 2", "excerpt": "Stato: Completata", "url": "#" }
  ]}
}
```

### 2.7 `tests.segnalazioni-elenco.json` — Listing Page

**Block types:**
- `breadcrumb` → `pub_theme::components.blocks.breadcrumb.default`
- `heading` → `pub_theme::components.blocks.heading.default`
- `segnalazioni-layout` → `pub_theme::components.blocks.segnalazioni.layout`
- `contacts` → `pub_theme::components.blocks.contacts.faq`

**Rich data structure for segnalazioni-layout:**
```json
{
  "results_count": 645,
  "tabs": [
    { "id": "map", "label": "Mappa", "active": true },
    { "id": "list", "label": "Elenco", "active": false }
  ],
  "cta": {
    "title": "Fai una segnalazione",
    "text": "Se vuoi aggiungere una segnalazione...",
    "button_text": "Segnala disservizio"
  },
  "items": [
    {
      "title": "Buca in via Solferino",
      "type": "Verde pubblico e arredo urbano",
      "status": "In lavorazione",
      "date": "15/03/2026",
      "location": "Via Solferino, 12 - 50100 Firenze",
      "description": "Sulla strada c'è una buca...",
      "images": ["/themes/Sixteen/design-comuni/assets/images/image-disservizio.png", ...],
      "edit_url": "#"
    },
    // ... more items
  ],
  "filters": {
    "title": "categoria",
    "items": [
      { "id": "water", "label": "Acqua, allagamenti, problemi fognari", "count": 21, "value": "acqua,allagamenti,fogne" },
      // ... 10 more filter categories
    ]
  }
}
```

### 2.8 `tests.segnalazione-dettaglio.json` — Service Detail Page

**Block types:**
- `breadcrumb` → `pub_theme::components.blocks.breadcrumb.default`
- `tests` → `pub_theme::components.blocks.tests.segnalazione-dettaglio` (full component)
- `feedback` → `pub_theme::components.blocks.feedback.rating`

**Same rich data structure as `tests.segnalazione-disservizio.json` with identical `sections`, `contact`, `topics` arrays.

---

## 3. Blade Component Inventory

### `components/blocks/tests/` (5 files)

| File | Purpose | Used By |
|------|---------|---------|
| `segnalazione-dettaglio.blade.php` | Full service detail page (hero, index, sections, contacts) | segnalazione-disservizio, segnalazione-dettaglio |
| `intro.blade.php` | Simple title/category/summary header | 01-privacy, 02-dati, 03-riepilogo |
| `body.blade.php` | Generic content body section | 01-privacy, 02-dati, 03-riepilogo |
| `governance-note.blade.php` | Governance documentation note | 01-privacy, 02-dati, 03-riepilogo |
| `source-link.blade.php` | Link to reference source | 01-privacy, 02-dati, 03-riepilogo |

**`segnalazione-dettaglio.blade.php`** structure (220+ lines):
```
├── Hero section (cmp-heading): title, status chip, summary, CTA buttons, share dropdown, view actions dropdown
├── Horizontal rule separator
├── Two-column layout:
│   ├── Left col (col-lg-3): Sticky sidebar nav (navbar it-navscroll-wrapper) with page index accordion
│   └── Right col (col-lg-8): Page sections container
│       ├── sections[] (who-needs, description, how-to, needed, obtain, costs, service-access, conditions)
│       │   └── Each: h2 title, content (richtext), optional links/buttons
│       └── Contacts section (id="contacts"): office card, topics chips, updated_at
```

### `components/blocks/flow/` (1 file + 5 subdirs)

| File | Purpose | Used By |
|------|---------|---------|
| `stepper.blade.php` | Horizontal stepper with progress | 04-conferma |
| `segnalazione/01-privacy.blade.php` | Privacy consent form with 2 checkboxes | 04-conferma (conceptually) |
| `segnalazione/02-dati.blade.php` | Personal data form (nome, cognome, email, telefono, indirizzo) | Not wired |
| `segnalazione/03-riepilogo.blade.php` | Summary/review page with data display | Not wired |
| `segnalazione/03-dettaglio.blade.php` | Detail form (unused variant) | Not wired |
| `segnalazione/04-conferma.blade.php` | Confirmation/success page with rating + related services | 04-conferma |

**Key observation:** The `flow/segnalazione/` components exist and are functional BUT they are NOT wired into the JSON content for pages 01-03. The JSON for those pages uses placeholder `tests/intro` and `tests/body` blocks instead.

**`04-conferma.blade.php`** structure (150+ lines):
```
├── Container with confirmation card:
│   ├── Success icon + title
│   ├── Confirmation message with codice_segnalazione
│   ├── Download receipt button
│   └── Link to area riservata
├── Related services section (link-list)
├── Rating section (bg-primary, 5-star rating)
└── Contact section (bg-grey-card, faq/assist/phone/appointment links)
```

---

## 4. CSS Architecture

### Main Entry: `laravel/Themes/Sixteen/resources/css/app.css` (2512+ lines)

**Import chain:**
```
app.css
├── @import './style-apply.css'           — Bootstrap Italia → Tailwind @apply mappings
├── @import './container-override.css'    — Container width overrides
├── @import './footer-override.css'       — Footer style fixes
├── @import './bootstrap-italia.css'      — Bootstrap Italia component classes
├── @import './components/header-footer-colors.css'
├── @import './components/bootstrap-italia-classes.css'
├── @import './components/design-comuni.css'
├── @import './design-comuni-visual-fix.css'
├── @import './design-comuni-global.css'  — Global visual parity (ratings, cards, links, forms)
├── @import './faq-parity.css'
├── @import './argomenti-parity.css'
├── @import './homepage-visual-fix.css'
├── @import './listing-parity.css'
├── @import './servizi-parity-fix.css'
└── @import './amministrazione-parity-fix.css'
```

### `design-comuni.css` (1912 lines) — Primary Design Comuni CSS

**Sections:**
1. **@theme block** — Custom tokens: `--color-italia: #0066cc`, `--color-italia-dark: #0059b3`, fonts, spacing
2. **Google Fonts** — Titillium Web + Lora imports
3. **Layout utilities** — Bootstrap grid replication (`.container`, `.row`, `.col-*` with breakpoints at 576/768/992/1200px)
4. **Display utilities** — `.d-none`, `.d-flex`, `.d-lg-block` etc.
5. **Header** — Slim (#00402B), Center (#007A52), Navbar (#007A52) with mobile responsive
6. **Cards** — `.card`, `.card-teaser`, `.card-bg-*`, `.card-teaser-wrapper-equal`
7. **Buttons** — `.btn-primary`, `.btn-outline-primary` (green #007A52 theme)
8. **Typography** — `.title-xxlarge`, `.title-xlarge`, `.text-paragraph`, `.lora`
9. **Icons** — `.icon`, `.icon-sm/md/xs`
10. **Chips** — `.chip`, `.chip-simple`
11. **Links** — `.read-more`, `.link-list`
12. **Sections** — Padding/margin utilities (`.pt-30`, `.pb-lg-80`, etc.)
13. **Evidence sections** — Blue background (#0066cc) with white cards
14. **Carousel** — Splide integration
15. **Search/Autocomplete** — Form controls

### `design-comuni-global.css` (300+ lines) — Global overrides

**Key overrides (!important):**
- Card layout: `.card-teaser-wrapper-equal` → flex row, 3 columns
- Rating section: green background, centered white card
- Link colors: #007A52 default
- Footer: #202a2e background
- Header: #00402b slim, #007a52 center/nav
- Breadcrumbs: #007A52 links
- Form elements: border #d9e1e8, focus ring green
- Stepper: flex row, green active state
- Alert/callout boxes: left-border colored
- Badges/tags: pill shape

### Bootstrap Italia Assets
- **SVG Sprite:** `/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg`
- **Images:** `/themes/Sixteen/design-comuni/assets/images/` (logo-comune.svg, image-disservizio.png, etc.)
- **Copied via:** `npm run copy` from `node_modules/bootstrap-italia/dist/svg/sprites.svg`

---

## 5. JavaScript Architecture

### Main Entry: `laravel/Themes/Sixteen/resources/js/app.js`

**Alpine.js components registered:**
```js
Alpine.data('dropdownToggle', dropdownToggle);
Alpine.data('modal', modal);
Alpine.data('mobileMenu', mobileMenu);
Alpine.data('governanceCarousel', governanceCarousel);
Alpine.data('accordionItem', () => ({ open: false }));
Alpine.data('ratingInline', () => ({ rating: 0, hover: 0 }));
Alpine.data('segnalazioniLayout', () => ({
    activeTab: 'map',
    showModal: false,
    showFilterModal: false,
}));
```

**Vanilla JS event handlers (data-bs-* attributes):**
- `[data-bs-toggle="modal"]` — Modal open/close
- `[data-bs-toggle="dropdown"]` — Dropdown toggle
- `[data-bs-toggle="navbarcollapsible"]` — Mobile menu
- `[data-bs-toggle="collapse"]` — Accordion/collapse
- `[data-bs-dismiss="modal"]` — Modal close
- `.close-menu` — Menu close button
- Escape key handler — Closes dropdowns, modals, mobile menus

**Page detection system:**
```js
const sectionMap = {
    'live': ['segnalazione-disservizio', 'segnalazione-01-privacy', 'segnalazione-02-dati',
             'segnalazione-03-riepilogo', 'segnalazione-04-conferma', 'segnalazione-area-personale',
             'segnalazioni-elenco', 'segnalazione-dettaglio'],
    // ... other sections
};
```

**Additional JS files:**
| File | Purpose |
|------|---------|
| `agid.js` | AGID/Design Comuni utilities |
| `agid-enforcer.js` | Style enforcement |
| `flowbite.js` | Flowbite components |
| `swiper.js` | Carousel/slider |
| `cookie-consent.js` | GDPR cookie banner |
| `performance.js` | Performance optimizations |
| `pwa.js` | PWA support |
| `custom.js` | Custom utilities |
| `components/bootstrap-italia.js` | Bootstrap Italia JS compatibility |

---

## 6. Build Pipeline

### Vite Config: `laravel/Themes/Sixteen/vite.config.js`

```js
plugins: [
    laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: [...] }),
    tailwindcss(),
]
build: {
    outDir: './public',
    emptyOutDir: true,
    manifest: 'manifest.json',
    // Hashed filenames for JS, CSS, images, fonts
}
```

### NPM Scripts (package.json)

| Command | Purpose |
|---------|---------|
| `npm run dev` | Vite dev server with HMR |
| `npm run build` | Production build → `./public/` |
| `npm run copy` | Copy `./public/` → `public_html/themes/Sixteen/` + copy SVG sprite + images |
| `npm run copy:filament` | Copy public to theme (Filament mode) |

### Asset resolution in Blade
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Sixteen')
{{-- Second parameter 'themes/Sixteen' tells Laravel to look in public_html/themes/Sixteen/build/manifest.json --}}
```

### Build artifacts produced:
```
public_html/themes/Sixteen/
├── build/manifest.json
├── css/app-[hash].css
├── js/app-[hash].js
├── js/components-[hash].js
├── images/[name]-[hash].ext
├── fonts/[name]-[hash].ext
└── design-comuni/assets/
    ├── bootstrap-italia/dist/svg/sprites.svg
    └── images/
```

---

## 7. Existing Documentation State

### Design Comuni docs: `laravel/Themes/Sixteen/docs/design-comuni/`

**142 files total.** Key documents:

| Document | Relevance |
|----------|-----------|
| `00-index.md` | Master index — last verified 2026-04-03, 63.0% OK (34/54 pages) |
| `ARCHITECTURAL_DECISIONS.md` | 10 core architectural rules (DRY, KISS, Forward-Only) |
| `MASTER_IMPLEMENTATION_PLAN.md` | Complete implementation plan |
| `bootstrap-italia-tailwind-apply.md` | Tailwind @apply mappings |
| `css-js-parity-2026-04-04.md` | CSS/JS parity status |

### Segnalazione-specific docs:
| Document | Content |
|----------|---------|
| `segnalazione-dettaglio/README.md` | Implementation notes for service detail page. Created 2026-04-03. Status: route 200 OK, breadcrumb, hero, sidebar index, sections, contacts, rating all implemented. |
| `segnalazioni-elenco/README.md` | Layout mappa/elenco with Alpine tabs and filters |

### Other relevant docs:
- `SEGNALAZIONI_ELENCO_ANALISI.md` — Analysis of listing page
- `SEGNALAZIONI_ELENCO_REPORT.md` — 95.7% target reached
- `SEGNALAZIONI_ELENCO_VISUAL_ANALYSIS.md` — Visual analysis
- `SEGNALAZIONI_ELENCO_CSS_REPORT.md` — CSS fix report (+327 lines)
- `SEGNALAZIONI_ELENCO_LAYOUT_FIX.md` — Layout fix (101.1%)

---

## 8. Screenshots & Visual Verification

### Screenshot directories: `laravel/Themes/Sixteen/docs/design-comuni/screenshots/`

**295 files total.** Segnalazione-specific folders:

| Folder | Contents |
|--------|----------|
| `segnalazione-01-privacy/` | reference.png, local.png |
| `segnalazione-02-dati/` | reference.png, local.png |
| `segnalazione-03-riepilogo/` | reference.png, local.png |
| `segnalazione-04-conferma/` | reference.png, local.png |
| `segnalazione-area-personale/` | reference.png, local.png |
| `segnalazione-dettaglio/` | reference.png, local.png, README.md |
| `segnalazione-disservizio/` | reference.png, local.png |
| `segnalazioni-elenco/` | reference.png, local.png, analysis/ |

**Reference screenshots location:** `screenshots/reference/` (all 54 pages from design-comuni)
**Local screenshots location:** `screenshots/local/` and `screenshots/all-pages/`

### Screenshot capture scripts: `bashscripts/design-comuni/`
- Scripts for capturing reference and local screenshots
- Documentation: `bashscripts/docs/DESIGN_COMUNI_VISUAL_COMPARE.md`

---

## 9. Current State Assessment

### ✅ Implemented Pages
1. **segnalazione-disservizio** — Full service detail page with sections, contacts, topics, CTA buttons
2. **segnalazione-dettaglio** — Same as above (reuses same component)
3. **segnalazioni-elenco** — Full listing with map/list tabs, filters, cards, contacts
4. **segnalazione-04-conferma** — Full confirmation page with stepper, success message, rating, contacts
5. **segnalazione-area-personale** — Basic area personale with hero + card list

### ⚠️ Placeholder Pages (Need Real Implementation)
6. **segnalazione-01-privacy** — Uses `tests/intro` + `tests/body` placeholders. Real privacy form with stepper, checkbox, CTA exists in `flow/segnalazione/01-privacy.blade.php` but NOT wired to JSON.
7. **segnalazione-02-dati** — Uses placeholders. Real multi-section form exists in `flow/segnalazione/02-dati.blade.php` but NOT wired.
8. **segnalazione-03-riepilogo** — Uses placeholders. Real summary page exists in `flow/segnalazione/03-riepilogo.blade.php` but NOT wired.

### 🔗 Wiring Gap

The `flow/segnalazione/` components are functional but disconnected from the JSON content system. To wire them:

**Option A — JSON-driven:** Update JSON for 01-03 to use `flow-*` block types:
```json
// tests.segnalazione-01-privacy.json
{ "type": "flow-segnalazione-privacy", "data": { "view": "pub_theme::components.blocks.flow.segnalazione.01-privacy", ... } }
```

**Option B — Component-driven:** Create dedicated blade blocks that match the `tests/` naming convention:
```
components/blocks/tests/segnalazione-01-privacy.blade.php
```
And have them render the `flow/segnalazione/01-privacy.blade.php` component.

### 🎨 Style Consistency Issues

The `flow/segnalazione/` components use **Tailwind utility classes directly** (e.g., `bg-gray-50`, `rounded-lg`, `text-blue-600`) while the Design Comuni pages use **Bootstrap Italia-compatible class names** (e.g., `title-xxxlarge`, `subtitle-small`, `btn-primary`, `chip-simple`). This creates a visual mismatch.

The `flow/` components need to be restyled to match Design Comuni conventions:
- Replace `bg-gray-50` → `has-bg-grey p-3`
- Replace `text-blue-600` → Design Comuni green `#007A52`
- Replace `rounded-lg` → Design Comuni `rounded` or specific border-radius
- Replace Tailwind form classes → Bootstrap Italia `form-check`, `form-control` patterns
- Use Design Comuni typography: `.title-xxlarge`, `.text-paragraph`, `.subtitle-small`
- Use Design Comuni buttons: `.btn.btn-primary`, `.btn.btn-outline-primary`

---

## 10. File Index

### JSON Content Files
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-disservizio.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-01-privacy.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-03-riepilogo.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-04-conferma.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-area-personale.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazioni-elenco.json`
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-dettaglio.json`

### Blade Templates
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` — Main entry point
- `laravel/Themes/Sixteen/resources/views/pages/tests/index.blade.php` — Index page

### Block Components
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-dettaglio.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/intro.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/body.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/governance-note.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/source-link.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/stepper.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/segnalazione/01-privacy.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/segnalazione/02-dati.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/segnalazione/03-riepilogo.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/segnalazione/03-dettaglio.blade.php`
- `laravel/Themes/Sixteen/resources/views/components/blocks/flow/segnalazione/04-conferma.blade.php`

### CSS Files
- `laravel/Themes/Sixteen/resources/css/app.css` — Main entry (2512+ lines)
- `laravel/Themes/Sixteen/resources/css/design-comuni.css` — Design Comuni classes (1912 lines)
- `laravel/Themes/Sixteen/resources/css/design-comuni-global.css` — Global overrides (300+ lines)
- `laravel/Themes/Sixteen/resources/css/style-apply.css` — Bootstrap Italia → Tailwind @apply
- `laravel/Themes/Sixteen/resources/css/bootstrap-italia.css` — Bootstrap Italia component classes

### JavaScript Files
- `laravel/Themes/Sixteen/resources/js/app.js` — Main entry, Alpine.js registration, data-bs-* handlers
- `laravel/Themes/Sixteen/resources/js/components/bootstrap-italia.js` — Bootstrap Italia compatibility

### Build Config
- `laravel/Themes/Sixteen/vite.config.js` — Vite build config
- `laravel/Themes/Sixteen/package.json` — NPM scripts and dependencies

### Documentation
- `laravel/Themes/Sixteen/docs/design-comuni/00-index.md` — Master index
- `laravel/Themes/Sixteen/docs/design-comuni/ARCHITECTURAL_DECISIONS.md` — Architecture rules
- `laravel/Themes/Sixteen/docs/design-comuni/segnalazione-dettaglio/README.md` — Detail page notes
- `laravel/Themes/Sixteen/docs/design-comuni/segnalazioni-elenco/README.md` — Listing page notes
- `laravel/Themes/Sixteen/docs/design-comuni/screenshots/segnalazione-*/` — Screenshot comparisons

### Bootstrap Italia Assets
- `public_html/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg` — Icon sprite
- `public_html/themes/Sixteen/design-comuni/assets/images/image-disservizio.png` — Report image

---

*Mapping complete: 2026-04-07*
