# Story 7.20: segnalazione-02-dati — header responsive refinement

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio che l'header della pagina `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` sia **visivamente identico** al reference Design Comuni a tutti i breakpoint (desktop 1440px, tablet 768px, mobile 375px),
così che hamburger, logo, slim-bar e search risultino corretti su ogni viewport senza regressioni.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Header blade:** `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- **CSS globale:** `laravel/Themes/Sixteen/resources/css/app.css`
- **CSS parity:** `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- **Screenshot acquisiti:** `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/header/`

### Analisi Visiva da Screenshot (2026-04-12)

#### Desktop (1440px)

| Elemento | Reference | Local | Status |
|----------|-----------|-------|--------|
| Slim bar "Nome della Regione" | Testo semplice, no underline | Link sottolineato | ❌ |
| Pulsante "Accedi all'area personale" | Testo bianco + bg verde scuro | Solo icona, testo assente | ❌ |
| ITA dropdown | Singola freccia `ITA ↓` | Doppia freccia `ITA ↓ ↓` | ❌ |
| Nav links | Nessun underline | Underline su tutti i link | ❌ |
| Layout generale | Corretto | Quasi corretto | ⚠️ |

#### Tablet (768px) — aggiornato 2026-04-12

| Elemento | Reference | Local | Status |
|----------|-----------|-------|--------|
| **Hamburger (☰)** | Presente, left | Presente, left | ✅ FIXATO |
| **"Cerca" label accanto alla lente** | **Testo "Cerca" + icona** | **Solo icona (no testo)** | ❌ ALTA |
| Sottotitolo "Un comune da vivere" | Visibile | Visibile | ✅ |
| ITA dropdown | Singola freccia | Doppia freccia | ❌ |
| Slim bar link underline | Nessuno | "Nome della Regione" sottolineato | ❌ |

#### Mobile (375px) — aggiornato 2026-04-12

| Elemento | Reference | Local | Status |
|----------|-----------|-------|--------|
| **Hamburger (☰)** | Presente, left | Presente, left | ✅ FIXATO |
| Slim bar layout | Nome left \| ITA right \| icon | Nome centrato, ITA left, icon right | ❌ |
| "Nome della Regione" | Allineato left, no underline | Centrato, sottolineato | ❌ |
| ITA selector | Right, singola freccia | Left, doppia freccia | ❌ |

### Root Causes

1. **Hamburger assente**: `display: none !important` in `segnalazione-parity.css` su `.navbar-collapsable` / `.menu-wrapper` / `.close-div` blocca sia la visualizzazione che il toggle Alpine.js
2. **Link sottolineati slim bar**: CSS globale aggiunge `text-decoration: underline` su `a` nel slim header
3. **ITA doppia freccia**: icona `it-expand` (Bootstrap Italia) + chevron Tailwind duplicati
4. **"Accedi" testo mancante**: classe responsive nasconde il testo su viewport considerate non-desktop
5. **Slim bar mobile layout errato**: flexbox non si adatta correttamente a 375px — "Nome della Regione" diventa centrato

## Acceptance Criteria

1. **Desktop ≥992px:** slim bar con testo non sottolineato, "Accedi all'area personale" testo+icon, ITA singola freccia, nav links senza underline.
2. **Tablet 768px:** hamburger ☰ visibile left, logo+nome center, search right.
3. **Mobile 375px:** hamburger ☰ visibile left, logo+nome center, search right.
4. **Slim bar mobile:** "Nome della Regione" allineato left, ITA right, singola freccia.
5. **Overlay funzionante:** click hamburger → menu slide-in da sinistra (Alpine.js) su tablet e mobile.
6. **Close/backdrop:** pulsante close e backdrop chiudono l'overlay.
7. **No regressioni:** le altre 6 pagine segnalazione non cambiano comportamento header.
8. **Build:** `npm run build` + `npm run copy` da `laravel/Themes/Sixteen/` senza errori.

## Tasks / Subtasks

- [ ] **Task 1 — Fix hamburger mobile/tablet** (CRITICO)
  - [ ] In `segnalazione-parity.css`: rimuovere/sostituire regole `display: none !important` su `.navbar-collapsable`, `.menu-wrapper`, `.close-div`
  - [ ] Verificare che il button hamburger in `header.blade.php` abbia `@click="mobileNavOpen = !mobileNavOpen"`
  - [ ] A `< 992px` il button hamburger deve essere visibile e cliccabile
  - [ ] Implementare overlay Alpine.js slide-in da sinistra (vedi Dev Notes)

- [ ] **Task 2 — Fix ITA doppia freccia**
  - [ ] In `header.blade.php`, sezione slim header, trovare e rimuovere l'icona duplicata
  - [ ] Mantenere solo una freccia (preferire `it-expand` Bootstrap Italia class)

- [ ] **Task 3 — Fix slim bar link underline**
  - [ ] In `app.css`: `.it-header-slim-wrapper a { text-decoration: none; }`
  - [ ] Verificare che non rompa altri link

- [ ] **Task 4 — Fix "Accedi all'area personale" testo**
  - [ ] In `header.blade.php`: verificare classe responsive che nasconde il testo
  - [ ] Il testo deve essere visibile su ≥992px accanto all'icona

- [ ] **Task 5 — Fix slim bar mobile layout**
  - [ ] "Nome della Regione": `text-align: left` + no underline su mobile
  - [ ] ITA dropdown: allineato a destra su mobile
  - [ ] Flexbox slim bar: `justify-content: space-between` a tutti i breakpoint

- [ ] **Task 8 — Fix "Cerca" label mancante su tablet** (ALTA)
  - [ ] In `header.blade.php`: verificare la classe responsive che nasconde il testo "Cerca" su tablet
  - [ ] Reference tablet (768px) mostra: `Cerca` (testo label) + icona 🔍 affiancati
  - [ ] Local tablet (768px) mostra: solo icona 🔍, nessun testo
  - [ ] Il testo deve essere visibile da ≥768px (o comunque al breakpoint tablet del reference)
  - [ ] Tradurre con `fixcity::header.actions.search.label`

- [ ] **Task 6 — Testing e screenshot**
  - [ ] Verificare a 375px, 576px, 768px, 991px, 992px, 1200px, 1440px
  - [ ] Acquisire screenshot prima/dopo con `bashscripts/screenshots/`
  - [ ] Nessun overflow orizzontale

- [ ] **Task 7 — Build**
  - [ ] `npm run build` da `laravel/Themes/Sixteen/`
  - [ ] `npm run copy` da `laravel/Themes/Sixteen/`

## Dev Notes

### File primari

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` | Alpine.js hamburger toggle + fix testo "Accedi" + fix ITA freccia |
| `laravel/Themes/Sixteen/resources/css/app.css` | CSS overlay mobile + slim bar link no-underline + slim bar layout |
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | Rimuovere `display: none !important` su elementi menu mobile |

### Guardrail

- ❌ Non caricare Bootstrap Italia JS — solo Alpine.js
- ❌ Non riscrivere il blade header da zero
- ❌ Non aggiungere wrapper div che rompano HTML parity
- ✅ Fix scoped a `body.page-tests-segnalazione-02-dati` solo se necessario per non rompere altre pagine
- ✅ Prima rimuovere regole in conflitto, poi aggiungere nuove
- ✅ Evitare `display: none !important` su elementi governati da Alpine.js

### Pattern Alpine.js overlay (header.blade.php)

```blade
<div class="it-header-navbar-wrapper" x-data="{ mobileNavOpen: false }">
  {{-- Hamburger — visibile solo a < 992px via CSS --}}
  <button class="custom-navbar-toggler" type="button"
          :aria-expanded="mobileNavOpen.toString()"
          aria-label="{{ __('fixcity::header.actions.menu_toggle.aria.label') }}"
          @click="mobileNavOpen = !mobileNavOpen">
    <span class="it-list"></span>
  </button>

  {{-- Backdrop --}}
  <div x-show="mobileNavOpen"
       x-transition:enter="transition-opacity ease-out duration-300"
       x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-in duration-200"
       x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       class="navbar-overlay"
       @click.self="mobileNavOpen = false"
       @keydown.escape.window="mobileNavOpen = false"
       style="display:none;"></div>

  {{-- Menu panel slide-in --}}
  <div x-show="mobileNavOpen"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
       class="navbar-collapsable"
       @keydown.escape.window="mobileNavOpen = false"
       style="display:none;">
    <div class="close-div">
      <button @click="mobileNavOpen = false" class="btn close-menu">
        <span>{{ __('fixcity::header.actions.menu_close.label') }}</span>
      </button>
    </div>
    {{-- ... nav content ... --}}
  </div>
</div>
```

### CSS overlay (app.css)

```css
@media (max-width: 991.98px) {
  .navbar-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 1040;
  }
  .navbar-collapsable {
    position: fixed; top: 0; left: 0;
    width: 85%; max-width: 320px; height: 100vh;
    z-index: 1050; overflow-y: auto; background: #fff;
  }
  .close-div { position: relative; padding: 16px; text-align: right; }
}
.it-header-slim-wrapper a { text-decoration: none; }
```

### Story precedenti rilevanti

- `7-8`: posizionamento hamburger/logo su mobile
- `7-9`: fix HTML parity + translation keys pattern
- `7-10`: comportamento target overlay hamburger
- `7-17`: vincolo generale parity CSS/JS per segnalazione-02-dati

### Screenshot evidence

Path: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/header/`
- `reference-desktop.png` / `local-desktop.png`
- `reference-tablet.png` / `local-tablet.png`
- `reference-mobile.png` / `local-mobile.png`

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- `[slug].blade.php` aveva `@volt` senza single root element → `MultipleRootElementsDetectedException`. Fix: altro agente ha aggiunto `<div class="tests-view-wrapper">` come single root nel `@volt` block.

### Completion Notes List

### File List

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-10 | Creata story 7.20 per il consolidamento responsive dell'header |
| 2026-04-12 | Aggiornata con analisi visiva completa da screenshot desktop/tablet/mobile. Identificato: hamburger mancante su tablet/mobile (CRITICO), slim bar layout errato mobile, link underline, ITA doppia freccia, testo "Accedi" mancante. |
| 2026-04-12 | Aggiornata con screenshot freschi (responsive-check.mjs). Hamburger ✅ ora visibile mobile+tablet. Aggiunto Task 8: "Cerca" label mancante su tablet 768px — reference mostra testo + icona, local solo icona. Slim bar mobile ancora rotto. |
