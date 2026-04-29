# Story 4.2: lista-risorse-template

Status: ready-for-dev

## Story

As a Cittadino / Utente,
I want visualizzare un elenco di risorse (notizie, avvisi, comunicati) organizzate in una lista con risorse in evidenza,
so that trovare facilmente i contenuti di interesse.

## Acceptance Criteria

1. **Breadcrumb**: Percorso navigabile Home > [Categoria] (es. Novità).
2. **Page Header**: Titolo H1 e sommario (lead text) conformi al reference Design Comuni.
3. **Sezione "In evidenza"**: Horizontal cards per le risorse principali con immagine, categoria, data, titolo e descrizione.
4. **Lista Risorse**: Griglia di cards verticali con immagine (se presente), categoria, data, titolo e descrizione.
5. **Paginazione**: Componente di paginazione presente a fine lista.
6. **Visual Parity**: Margini, padding, font e colori identici al reference Design Comuni (target >98%).

## Tasks / Subtasks

- [ ] Preparare i componenti dei blocchi per il listing (AC: 2, 3, 4)
  - [ ] Implementare `pub_theme::components.blocks.listing.page-header`
  - [ ] Implementare `pub_theme::components.blocks.listing.featured-cards`
  - [ ] Implementare `pub_theme::components.blocks.listing.items` (o simili nel JSON)
- [ ] Configurare il caricamento dati dal JSON (AC: 1-5)
  - [ ] Verificare mapping in `laravel/config/local/fixcity/database/content/pages/tests.lista-risorse.json`
- [ ] Refinement CSS per Visual Parity (AC: 6)
  - [ ] Applicare scoping CSS in `laravel/Themes/Sixteen/resources/css/app.css` o file dedicato
  - [ ] Verificare breakpoint mobile/tablet

## Dev Notes

- **Architettura**: Utilizzare il sistema JSON blocks gestito dal componente Volt `[slug].blade.php`.
- **Dati**: Il contenuto è guidato dal file `laravel/config/local/fixcity/database/content/pages/tests.lista-risorse.json`.
- **Reference**: 
  - HTML Reference: `laravel/Themes/Sixteen/docs/design-comuni/batch-body-parity/lista-risorse-reference-body.html`
  - Analysis: `laravel/Themes/Sixteen/docs/design-comuni/css-js-pass-2026-04-04.md`

### Project Structure Notes

- Il template deve risiedere all'interno del tema `Sixteen`.
- Evitare l'uso di Bootstrap Italia JS; preferire Alpine.js per eventuali interazioni (sebbene non richieste esplicitamente per questa story).

### References

- [Source: _bmad-output/design-comuni-block-analysis.md#Section 1.1]
- [Source: laravel/Themes/Sixteen/docs/design-comuni/pages-census.md#1.6]

## Dev Agent Record

### Agent Model Used

Gemini 2.0 Flash

### Debug Log References

### Completion Notes List

### File List
- `_bmad-output/implementation-artifacts/4-2-lista-risorse-template.md`
