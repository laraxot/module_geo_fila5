# Story: HTML Parity Refinement — Segnalazione 02 Dati

**Epic**: Phase 1.1 — Global Component & Data Parity  
**Story ID**: 1.1.1-HTML-PARITY-SIGN02-DATI  
**Status**: Draft  
**Priority**: P1 (Visual parity polish)  
**Created**: 2026-04-11  

---

## User Story

Come sviluppatore front-end,
voglio che l'HTML della pagina `/it/tests/segnalazione-02-dati` sia identico al riferimento Bootstrap Italia in ogni dettaglio strutturale (classi, attributi, testo, nesting),
in modo che la pagina sia pixel-perfect e semanticamente equivalente al Design Comuni reference.

---

## Current Status

**Overall HTML Parity: ~95%**

| Metric | Reference | Local | Status |
|--------|----------|-------|--------|
| Body lines | 938 | 904 | ⚠️ -34 lines |
| data-element attributes | 16 | 16 | ✅ All present |
| IDs | 19 | 21 (19 match + 2 extra) | ✅ All reference IDs present |
| Containers | 7 | 7 | ✅ |
| Rows | 10 | 10 | ✅ |
| Cols | 22 | 22 | ✅ |
| Cards (cmp-card) | 3 | 3 | ✅ |
| Card divs | 17 | 17 | ✅ |
| Steppers | 10 refs | 10 refs | ✅ |
| Sections | 4 | 4 | ✅ |
| Buttons | 14 | 12 | ⚠️ -2 (element type differs) |
| Footer structure | Matches | Matches | ✅ |

---

## Acceptance Criteria

### AC1: Accordion Button Attributes Parity
**Given** la sidebar "Informazioni richieste"  
**When** l'utente ispeziona l'accordion button  
**Then** gli attributi devono corrispondere:
- Reference: `data-bs-toggle="collapse" data-bs-target="#collapse-one"`
- Local deve usare gli stessi attributi Bootstrap (Alpine.js @click è funzionale ma l'HTML parity richiede attributi BS)

### AC2: Accordion Label Text Parity
**Given** la sidebar  
**When** l'utente visualizza il titolo accordion  
**Then** il testo deve essere `INFORMAZIONI RICHIESTE` (uppercase come reference), non "Informazioni richieste"

### AC3: Sidebar Nav Links Text Parity
**Given** la lista link nella sidebar  
**When** l'utente visualizza i link  
**Then** il testo deve corrispondere:
- Reference: "Luogo", "Disservizio", "Autore della segnalazione"
- Local attuale: "Luogo", "Disservizio segnalato", "Informazioni su di te"
- Fix: allineare testo alle traduzioni reference

### AC4: Stepper Buttons Element Type Parity
**Given** i bottoni prev/save/confirm nello stepper  
**When** l'utente ispeziona l'HTML  
**Then**:
- `steppers-btn-prev`: Reference usa `<button>`, local usa `<a href>` → usare `<button>` con handler
- `steppers-btn-confirm`: Reference usa `<button>`, local usa `<a href>` → usare `<button>` con handler
- `steppers-btn-save`: Reference usa `<button>`, local ha solo la classe senza tag button completo

### AC5: Autocomplete data-bs-autocomplete Attribute
**Given** il campo "Cerca un luogo"  
**When** l'utente ispeziona l'input  
**Then** l'attributo `data-bs-autocomplete` con la lista regioni deve essere presente come nel reference

### AC6: Required Field Indicators
**Given** i campi obbligatori  
**When** l'utente visualizza le label  
**Then** l'asterisco `*` deve essere presente:
- `Cerca un luogo*` (non `Cerca un luogo`)
- Label dei campi required devono avere `*`

### AC7: Subtitle Text Parity
**Given** la sezione "Luogo"  
**When** l'utente visualizza la subtitle  
**Then** il testo deve essere `Indica il luogo del disservizio` (come reference), non "Cerca l'indirizzo o il punto in cui si verifica il disservizio"

### AC8: Disservizio Section Title
**Given** la sezione disservizio  
**When** l'utente visualizza il titolo H2  
**Then** il testo deve essere `Disservizio` (come reference), non "Disservizio segnalato"

### AC9: Upload Button Text
**Given** il pulsante di upload  
**When** l'utente visualizza il testo del button  
**Then** lo spazio/whitespace deve corrispondere (reference ha whitespace extra tra span, local no — dettaglio minore)

---

## Dev Technical Guidance

### Files to Modify

1. **Content JSON** — Testi e label:
   - `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json`
   - Aggiornare testi per corrispondere al reference

2. **Blade Component** — Struttura HTML:
   - `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
   - Accordion button attributes
   - Stepper button element types
   - Autocomplete data attribute

3. **Translations** — Testi i18n:
   - `laravel/Modules/Fixcity/lang/it/segnalazione.php`
   - Aggiornare label per parity con reference

### Detailed Changes

#### 1. Accordion Button (sidebar)
**Current (local):**
```blade
<button class="accordion-button pb-10 px-3" type="button"
        @click="accordionOpen = !accordionOpen"
        aria-expanded="true" aria-controls="collapse-one">
    Informazioni richieste
```

**Target (reference):**
```blade
<button class="accordion-button pb-10 px-3" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse-one"
        aria-expanded="true" aria-controls="collapse-one">
    INFORMAZIONI RICHIESTE
```

**Note**: Mantenere sia `data-bs-toggle` che `@click` per compatibilità Alpine.js + Bootstrap Italia CSS classes.

#### 2. Sidebar Nav Links
**Reference texts:**
- "Luogo"
- "Disservizio"  
- "Autore della segnalazione"

**Local current:**
- "Luogo" ✅
- "Disservizio segnalato" ❌
- "Informazioni su di te" ❌

#### 3. Stepper Buttons
**Reference:**
```html
<button type="button" class="btn btn-sm steppers-btn-prev p-0">
  <svg>...</svg>
  <span>Indietro</span>
</button>
<button type="button" class="btn btn-primary btn-sm steppers-btn-confirm" data-bs-toggle="modal" data-bs-target="#">
  <span>Conferma e invia</span>
</button>
```

**Local current:**
```blade
<a href="{{ $prevUrl }}" class="btn btn-sm steppers-btn-prev p-0">
  <svg>...</svg>
  <span>Indietro</span>
</a>
<a href="{{ $nextUrl }}" class="btn btn-primary btn-sm steppers-btn-confirm">
  <span>Conferma e invia</span>
</a>
```

**Fix**: Usare `<button>` con Alpine.js `@click` per navigazione, mantenere link funzionali.

#### 4. Autocomplete data attribute
**Reference:**
```html
<input type="search" class="autocomplete" placeholder="Cerca un luogo*"
       id="autocomplete-regioni" name="autocomplete-regioni" required
       data-bs-autocomplete='[{"text":"Abruzzo","link":"#"},...'>
```

**Local:**
```html
<input type="search" class="autocomplete" placeholder="Cerca un luogo"
       id="autocomplete-regioni" name="autocomplete-regioni" required>
```

**Fix**: Aggiungere `data-bs-autocomplete` con lista regioni e `*` nel placeholder.

#### 5. Required field asterisks
- `Cerca un luogo` → `Cerca un luogo*`
- Verificare tutti i campi required abbiano `*` nelle label

#### 6. Subtitle text
- Current: "Cerca l'indirizzo o il punto in cui si verifica il disservizio"
- Reference: "Indica il luogo del disservizio"

#### 7. Section title
- Current: "Disservizio segnalato"
- Reference: "Disservizio"

### Reference HTML Key Sections

```html
<!-- Sidebar accordion -->
<button class="accordion-button pb-10 px-3" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse-one"
        aria-expanded="true" aria-controls="collapse-one">
  INFORMAZIONI RICHIESTE
  <svg class="icon icon-xs right">
    <use href="../assets/bootstrap-italia/dist/svg/sprites.svg#it-expand"></use>
  </svg>
</button>

<!-- Sidebar nav links -->
<ul class="link-list" data-element="page-index">
  <li class="nav-item"><a class="nav-link" href="#report-place"><span>Luogo</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#report-info"><span>Disservizio</span></a></li>
  <li class="nav-item"><a class="nav-link" href="#report-author"><span>Autore della segnalazione</span></a></li>
</ul>

<!-- Stepper buttons -->
<button type="button" class="btn btn-sm steppers-btn-prev p-0">
  <svg class="icon icon-primary icon-sm" aria-hidden="true">
    <use href="../assets/bootstrap-italia/dist/svg/sprites.svg#it-chevron-left"></use>
  </svg>
  <span class="text-button-sm t-primary">Indietro</span>
</button>

<button type="button" class="btn btn-primary btn-sm steppers-btn-confirm" data-bs-toggle="modal" data-bs-target="#">
  <span>Conferma e invia</span>
</button>

<!-- Autocomplete with data attribute -->
<input type="search" class="autocomplete" placeholder="Cerca un luogo*"
       id="autocomplete-regioni" name="autocomplete-regioni" required
       data-bs-autocomplete='[{"text":"Abruzzo","link":"#"},...]'>
```

### Testing Requirements

- [ ] Verificare che accordion sidebar si apra/chiuda correttamente (Alpine.js)
- [ ] Verificare che stepper prev/confirm navigano correttamente
- [ ] Verificare che autocomplete mostri suggerimenti (se implementato)
- [ ] Screenshot comparativo vs reference per ogni sezione modificata
- [ ] Verificare nessun regression su altre pagine segnalazione

---

## Tasks / Subtasks

### Task 1: Accordion Button Attributes + Text
- [ ] Aggiornare accordion button con `data-bs-toggle="collapse" data-bs-target="#collapse-one"`
- [ ] Cambiare testo da "Informazioni richieste" a "INFORMAZIONI RICHIESTE"
- [ ] Mantenere `@click` Alpine.js per compatibilità

### Task 2: Sidebar Nav Links Text
- [ ] Aggiornare "Disservizio segnalato" → "Disservizio"
- [ ] Aggiornare "Informazioni su di te" → "Autore della segnalazione"
- [ ] Aggiornare file di traduzione Fixcity

### Task 3: Stepper Buttons Element Type
- [ ] Cambiare `<a href>` → `<button type="button">` per steppers-btn-prev
- [ ] Cambiare `<a href>` → `<button type="button">` per steppers-btn-confirm
- [ ] Aggiungere Alpine.js @click handlers per navigazione
- [ ] Verificare che steppers-btn-save sia un `<button>` completo

### Task 4: Autocomplete data-bs-autocomplete
- [ ] Aggiungere attributo `data-bs-autocomplete` con lista regioni
- [ ] Aggiungere `*` al placeholder: `Cerca un luogo*`

### Task 5: Required Field Asterisks
- [ ] Verificare e aggiungere `*` a tutte le label dei campi required

### Task 6: Section Texts Parity
- [ ] Aggiornare subtitle "Luogo": "Indica il luogo del disservizio"
- [ ] Aggiornare titolo sezione: "Disservizio" (non "Disservizio segnalato")

### Task 7: Verification
- [ ] Screenshot comparativo desktop/tablet/mobile
- [ ] Verificare HTML parity >98%
- [ ] Verificare nessun regression funzionale

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: Cambiare `<a>` → `<button>` per stepper potrebbe richiedere Alpine.js handlers per navigazione
- **Mitigation**: Usare `@click` con `window.location` o router Livewire
- **Verification**: Test navigazione prev/next dopo modifiche

### Rollback Plan
- I fix sono reversibili (testi, attributi HTML)
- Commit atomico per ogni task permette rollback selettivo

### Safety Checks
- [ ] Verificare che accordion sidebar continui a funzionare
- [ ] Verificare che navigazione stepper prev/next funzioni
- [ ] Verificare che autocomplete continui a funzionare (se implementato)
- [ ] Test su tutte le pagine segnalazione (01-privacy, 03-riepilogo, 04-conferma)

---

## Dev Agent Record

### Agent Model Used
_Qwen Code_

### HTML Parity Analysis Results

**Analysis date**: 2026-04-11  
**Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html (953 lines)  
**Local**: http://127.0.0.1:8000/it/tests/segnalazione-02-dati (1116 lines)

**Element-by-element comparison:**
- All 19 reference IDs present in local ✅
- All 16 data-element attributes match ✅
- Container/row/col structure identical (7/10/22) ✅
- Card count identical (17) ✅
- Stepper structure identical ✅
- Footer structure matches ✅

**Gaps identified:**
1. Accordion button: `data-bs-toggle` vs `@click` (functional difference)
2. Accordion label: "INFORMAZIONI RICHIESTE" vs "Informazioni richieste"
3. Sidebar links: 2/3 texts differ
4. Stepper prev/confirm: `<button>` vs `<a>` element type
5. Autocomplete: missing `data-bs-autocomplete` attribute + `*` in placeholder
6. Section texts: 2 texts differ from reference

**HTML Parity Score: ~95%** (structural parity 100%, attribute/text parity ~90%)

### Debug Log References
- Reference HTML saved: `/tmp/reference-sign02-dati.html`
- Local HTML saved: `/tmp/local-sign02-dati.html`
- Body-only comparison: `/tmp/reference-body.html` vs `/tmp/local-body.html`
- Screenshot analysis: reference-desktop-header, our-desktop-header (previous session)

### Completion Notes List
- Analisi HTML completa eseguita con grep/comm comparativo
- Tutti gli elementi strutturali corrispondono (container, row, col, card, stepper, footer)
- Gaps sono principalmente: attributi button, testi label, tipo elemento stepper
- Nessun gap strutturale critico — parity già molto alta

### File List
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` — Template principale
- `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json` — Content JSON
- `laravel/Modules/Fixcity/lang/it/segnalazione.php` — Traduzioni

### Change Log
| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-11 | 1.0 | HTML parity analysis completa — 95% parity, 6 gap identificati | Qwen |

---

## Status: Draft

**Ready for**: Dev agent implementation  
**Estimated Effort**: 3-5 ore  
**Dependencies**: Nessuna  

---

## Notes

- Questa story è il follow-up della story HEADER-RESPONSIVE-PARITY-STORY.md (header fix già completato)
- L'header è già al 100% parity dopo i fix del 2026-04-10
- Questa story copre il content area (steppers, sidebar, form, footer)
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- Local: http://127.0.0.1:8000/it/tests/segnalazione-02-dati
- I file HTML grezzi sono salvati in `/tmp/reference-sign02-dati.html` e `/tmp/local-sign02-dati.html`
