# Story 4.3: lista-categorie-template

Status: ready-for-dev

<!-- Note: Validation is optional. Run validate-create-story for quality check before dev-story. -->

## Story

As a citizen browsing the municipal portal,
I want to see a "Lista Categorie" page that shows a hero header, optional featured-resource cards, and an "Esplora per categoria" grid of category cards,
so that I can quickly understand and navigate the available categories of content in visual parity with the Design Comuni reference.

## Acceptance Criteria

1. **Breadcrumb**: Percorso navigabile `Home > [Sezione]` visibile e conforme al reference Design Comuni (`data-element="breadcrumb"`).
2. **Page Header**: Titolo H1 (`data-element="page-name"`) e sommario (lead text) presenti e conformi al reference.
3. **Sezione "In evidenza"** *(opzionale se dati presenti)*: Horizontal cards con immagine, categoria, data, titolo e descrizione — stessa struttura di `lista-risorse`.
4. **Sezione "Esplora per categoria"**: `<div id="argomento">` con H2 "Esplora per categoria" e griglia `row g-4` di `cmp-card-simple` (layout `col-md-6 col-xl-4`). Ogni card mostra: titolo H3 con link (`t-primary title-xlarge`) e descrizione (`text-secondary`).
5. **Dati JSON**: Il contenuto è guidato dal file `laravel/config/local/fixcity/database/content/pages/tests.lista-categorie.json`; il mapping dei blocchi funziona tramite il componente Volt `[slug].blade.php`.
6. **Visual Parity**: Margini, padding, font, colori e breakpoint identici al reference HTML (target ≥ 98%); verificare su mobile (375px), tablet (768px) e desktop (1280px).
7. **Accessibilità**: Nessun errore Lighthouse/axe critico; `aria-label` presenti sui link di categoria; struttura heading corretta (H1 → H2 → H3).

## Tasks / Subtasks

- [ ] Creare il file JSON dei dati di test per lista-categorie (AC: 5)
  - [ ] Creare `laravel/config/local/fixcity/database/content/pages/tests.lista-categorie.json`
  - [ ] Definire blocchi: `page-header`, `featured-cards` (opzionale), `category-cards` / `argomento`
  - [ ] Mappare correttamente i campi (titolo, descrizione, link) per le cards categoria

- [ ] Implementare il componente Blade di pagina (AC: 1–4)
  - [ ] Creare `laravel/Themes/Sixteen/resources/views/components/blocks/lista-categorie.blade.php`
  - [ ] Implementare breadcrumb con `cmp-breadcrumbs` e `data-element="breadcrumb"`
  - [ ] Implementare hero section (`it-hero-wrapper bg-white`) con H1 `data-element="page-name"` e sommario
  - [ ] Implementare sezione "Esplora per categoria" (`<div id="argomento" class="container py-5">`)
    - [ ] H2 `title-xxlarge mb-4` con testo "Esplora per categoria"
    - [ ] Griglia `row g-4` con celle `col-md-6 col-xl-4`
    - [ ] Ogni cella: `cmp-card-simple card-wrapper pb-0 rounded border border-light` → `card shadow-sm rounded` → `card-body` → link H3 + `<p class="text-secondary mb-0 description">`

- [ ] Riusare / registrare il blocco listing.featured-cards (AC: 3)
  - [ ] Verificare se `pub_theme::components.blocks.listing.featured-cards` esiste (creato in story 4-2)
  - [ ] Se non esiste, implementarlo seguendo il pattern di `lista-risorse`

- [ ] CSS e Visual Parity (AC: 6)
  - [ ] Verificare che il CSS esistente in `laravel/Themes/Sixteen/resources/css/app.css` copra `cmp-card-simple`
  - [ ] Aggiungere scoping CSS dedicato se necessario (es. `lista-categorie.css`)
  - [ ] Eseguire `npm run build && npm run copy` dopo ogni modifica CSS
  - [ ] Confrontare `bashscripts/output/local_lista-categorie.html` con `bashscripts/output/ref_lista-categorie.html`
  - [ ] Verificare breakpoint mobile (375px), tablet (768px), desktop (1280px)

- [ ] Accessibilità e test (AC: 7)
  - [ ] Verificare struttura heading H1 → H2 → H3 nel DOM
  - [ ] Aggiungere `aria-label` descrittivi sui link categoria
  - [ ] Eseguire Lighthouse / axe e correggere errori critici

## Dev Notes

- **Architettura**: Identica a story 4-2. Utilizzare il sistema JSON blocks gestito dal componente Volt `[slug].blade.php`. Il blade della pagina va registrato come blocco nel tema Sixteen.
- **Differenza chiave rispetto a lista-risorse**: La sezione centrale è "Esplora per categoria" con `cmp-card-simple` (non cards con immagine). La struttura HTML usa `id="argomento"` come ancora.
- **cmp-card-simple layout**: `col-md-6 col-xl-4` → 3 colonne su desktop, 2 su tablet, 1 su mobile. Ogni card: solo titolo (link) + descrizione breve, nessuna immagine.
- **CSS Build**: dopo ogni modifica CSS eseguire `npm run build && npm run copy` dalla root del tema `Sixteen`.
- **Test con file locale**: aprire `bashscripts/output/local_lista-categorie.html` nel browser e confrontare con `bashscripts/output/ref_lista-categorie.html`.
- **NON usare Bootstrap Italia JS** per le interazioni: preferire Alpine.js se necessario.

### Previous Story Intelligence (da story 4-2)

- Il sistema JSON blocks gestito da `[slug].blade.php` è confermato funzionante; seguire lo stesso mapping.
- Il componente `pub_theme::components.blocks.listing.featured-cards` potrebbe già esistere dopo story 4-2 — verificare prima di ricreare.
- Il build `npm run build && npm run copy` è obbligatorio dopo ogni CSS change.
- Evitare Bootstrap Italia JS; usare Alpine.js per interazioni dinamiche.
- Testare su dispositivi reali (non solo browser devtools).

### Project Structure Notes

- Tema: `laravel/Themes/Sixteen`
- Views: `resources/views/components/blocks/lista-categorie.blade.php`
- CSS: `resources/css/` (estendere `app.css` o creare `lista-categorie.css`)
- JSON dati: `laravel/config/local/fixcity/database/content/pages/tests.lista-categorie.json`
- HTML reference: `bashscripts/output/ref_lista-categorie.html`
- HTML locale (output): `bashscripts/output/local_lista-categorie.html`

### References

- [Source: bashscripts/output/ref_lista-categorie.html#main-container] — struttura completa HTML reference Design Comuni
- [Source: laravel/Modules/Notify/_bmad-output/implementation-artifacts/4-2-lista-risorse-template.md] — pattern architettura e dev notes story precedente
- [Source: laravel/Modules/Notify/_bmad-output/implementation-artifacts/4-1-homepage-template.md#Dev Notes] — code conventions, build pipeline
- [Source: laravel/Modules/Notify/_bmad-output/planning-artifacts/prd.md#MVP] — lista-categorie in scope MVP
- [Source: laravel/Modules/Notify/_bmad-output/planning-artifacts/architecture.md#Project Structure] — struttura cartelle tema Sixteen

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

### Completion Notes List

### File List
