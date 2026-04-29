# Story 7.10: Header mobile/tablet — hamburger menu overlay parity

Status: draft

## Story

Come **responsabile qualità frontoffice**,
voglio che l'header della pagina `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` (e tutte le pagine segnalazione) abbia **hamburger menu funzionante con overlay** su viewport tablet (≤991px) e mobile (≤575px),
così che la navigazione mobile sia indistinguibile dal riferimento Design Comuni: hamburger apre un **overlay laterale** con menu compattato, non una lista verticale che esplode sotto l'header.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Screenshot mobile locale:** `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png` — evidenzia header che si espande in un **lungo scroll verticale** invece di overlay laterale.
- **Header blade:** `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`

### Root cause identificata

Il markup header usa `data-bs-toggle="navbarcollapsible"` (attributo Bootstrap Italia) per il comportamento hamburger → overlay.
**Bootstrap Italia JS NON è caricato** nel frontoffice → `navbarcollapsible` non fa nulla → il `<div class="navbar-collapsable">` è sempre visibile → tutto il menu (nav primario + secondario + social + search) si renderizza in-line come lista verticale sotto l'header.

### Cosa si vede nello screenshot mobile (evidence)

1. **Slim wrapper** → "Nome della Regione", lingua ITA, bottone "Accedi" → OK
2. **Center wrapper** → logo Sixteen, link "Il mio Comune", "Seguici su" con social icons → OK ma social sono duplicati poi sotto
3. **Navbar** → hamburger burger icon presente, MA sotto si espande TUTTO il menu:
   - "Nascondi la navigazione" (close button visible but non-functional)
   - Logo hamburger + "Nome del Comune"
   - Nav principale: Amministrazione, Novità, Servizi, Vivere il Comune
   - Nav secondaria: Iscrizioni, Estate in città, Polizia locale, Tutti gli argomenti
   - Social icons (Twitter, Facebook, YouTube, Telegram, Whatsapp, RSS) — DUPLICATI (esistono già nel center wrapper)
   - Il tutto si scrolla come lista infinita → **NON è un overlay laterale come il reference**

## Acceptance Criteria

1. **AC1 — Hamburger overlay:** a ≤991px, cliccando il pulsante hamburger si apre un **overlay laterale** (slide-in da sinistra) che copre il contenuto della pagina, non una lista inline sotto l'header.
2. **AC2 — Overlay contenuto:** l'overlay contiene SOLO: logo hamburger + "Nome del Comune", nav principale (4 link), nav secondaria (4 link). I social icons del menu hamburger sono nascosti (già presenti nel center wrapper desktop).
3. **AC3 — Close button funzionante:** il pulsante "Nascondi la navigazione" (X) chiude l'overlay. Cliccare fuori dall'overlay (sul backdrop/overlay scuro) lo chiude anch'esso.
4. **AC4 — Body scroll bloccato:** quando l'overlay è aperto, lo scroll della pagina sottostante è bloccato (`overflow: hidden` sul body).
5. **AC5 — Animazione smooth:** l'overlay si apre con transizione `transform: translateX` (slide da sinistra a destra) in 300ms, non hard cut.
6. **AC6 — Focus trap:** quando l'overlay è aperto, il focus è intrappolato dentro l'overlay (Tab cicla solo gli elementi del menu).
7. **AC7 — Nessun impatto desktop:** su viewport ≥992px il comportamento header rimane identico (navbar orizzontale, nessun hamburger).
8. **AC8 — Nessuna regressione** sulle altre 6 pagine segnalazione (01-privacy, 03-riepilogo, 04-conferma, elenco, dettaglio, area-personale).
9. **AC9 — Build:** `npm run build` in `laravel/Themes/Sixteen`.

## Tasks / Subtasks

- [ ] **1. Implementare Alpine.js overlay per hamburger menu** (no Bootstrap Italia JS)
  - [ ] Convertire `navbar-collapsable` da Bootstrap toggle a componente Alpine.js (`x-data="{ open: false }"`)
  - [ ] Hamburger button: `@click="open = true"`, `:aria-expanded="open.toString()"`
  - [ ] Overlay backdrop: `<div x-show="open" @click.self="open = false" class="overlay"></div>` con transizione opacity
  - [ ] Menu panel: `<div x-show="open" class="navbar-collapsable">` con transizione `transform: translateX(-100%)` → `translateX(0)`
  - [ ] Close button: `@click="open = false"`
  - [ ] Body scroll lock: `x-effect` che aggiunge/rimuove `overflow: hidden` al body quando `open` cambia
  - [ ] Focus trap: `x-trap="open"` sulla navbar-collapsable (o implementazione manuale con `@keydown.tab`)

- [ ] **2. CSS per overlay mobile** (scoped in `segnalazione-parity.css` o `app.css`)
  - [ ] `.navbar-collapsable` a ≤991px: `position: fixed; top: 0; left: 0; width: 85%; max-width: 320px; height: 100vh; z-index: 1050; overflow-y: auto; background: #fff; transform: translateX(-100%); transition: transform 0.3s ease;`
  - [ ] Overlay backdrop: `position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1040; opacity: 0; transition: opacity 0.3s;`
  - [ ] Stati active: `.navbar-collapsable.open { transform: translateX(0); }`, `.overlay.open { opacity: 1; }`
  - [ ] Nascondere social nel mobile menu (`.menu-wrapper .it-socials { display: none; }` a ≤991px) — sono già nel center wrapper
  - [ ] Close button: `position: absolute; top: 16px; right: 16px;`

- [ ] **3. Aggiornare header.blade.php**
  - [ ] Aggiungere `x-data="{ mobileNavOpen: false }"` sulla navbar
  - [ ] Hamburger button: `@click="mobileNavOpen = !mobileNavOpen"`
  - [ ] Rimuovere attributi Bootstrap Italia non funzionali (`data-bs-toggle="navbarcollapsible"`, `data-bs-target`)
  - [ ] Overlay div con `x-show="mobileNavOpen"`, `x-transition`
  - [ ] Menu panel con `x-show="mobileNavOpen"`, `x-transition:enter`, `x-transition:leave`
  - [ ] Body lock con `x-effect` (aggiungere/rimuovere classe `nav-open` sul body)

- [ ] **4. Focus trap e accessibilità**
  - [ ] Quando overlay si apre, focus va al primo link del menu
  - [ ] Tab cicla dentro il menu, non esce
  - [ ] Escape chiude l'overlay
  - [ ] `aria-expanded` aggiornato dinamicamente

- [ ] **5. Testing**
  - [ ] Verificare a 375px (mobile): hamburger → overlay → navigare → close
  - [ ] Verificare a 768px (tablet): stesso comportamento
  - [ ] Verificare a 1024px (desktop): hamburger nascosto, navbar orizzontale
  - [ ] Screenshot mobile prima/dopo
  - [ ] `npm run build` in `laravel/Themes/Sixteen`

- [ ] **6. Documentazione**
  - [ ] Aggiornare `laravel/Themes/Sixteen/docs/header-mobile-overlay.md` con architettura Alpine.js
  - [ ] Aggiornare `laravel/Themes/Sixteen/docs/visual-comparison/structure-analysis/segnalazione-02-dati-html-comparison.md`

## Dev Notes

### File hot

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` | Aggiungere Alpine.js overlay al posto di Bootstrap Italia toggle |
| `laravel/Themes/Sixteen/resources/css/app.css` | CSS per overlay mobile (position fixed, transform, backdrop) |
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | Eventuali fix scoped `body.page-tests-segnalazione-*` |

### Architettura proposta: Alpine.js vs Bootstrap Italia JS

**Non caricare Bootstrap Italia JS** (pesante, conflitti con Tailwind). Invece:

```blade
{{-- Hamburger button --}}
<button class="custom-navbar-toggler"
        type="button"
        aria-controls="nav4"
        :aria-expanded="mobileNavOpen.toString()"
        aria-label="Mostra/Nascondi la navigazione"
        @click="mobileNavOpen = !mobileNavOpen">

{{-- Overlay backdrop --}}
<div x-show="mobileNavOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="navbar-overlay"
     @click.self="mobileNavOpen = false"
     style="display: none;">

{{-- Menu panel --}}
<div x-show="mobileNavOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-x-[-100%]"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-[-100%]"
     class="navbar-collapsable"
     @keydown.escape.window="mobileNavOpen = false"
     style="display: none;">
```

### CSS overlay (da aggiungere in app.css)

```css
/* Mobile/tablet: hamburger overlay menu */
@media (max-width: 991.98px) {
  .navbar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
  }

  .navbar-collapsable {
    position: fixed;
    top: 0;
    left: 0;
    width: 85%;
    max-width: 320px;
    height: 100vh;
    z-index: 1050;
    overflow-y: auto;
    background: #fff;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }

  .navbar-collapsable[aria-expanded="true"] {
    transform: translateX(0);
  }

  /* Hide socials inside mobile menu (already in center wrapper) */
  .navbar-collapsable .menu-wrapper .it-socials {
    display: none;
  }

  /* Close button */
  .navbar-collapsable .close-div {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 1060;
  }
}

/* Body scroll lock when nav open */
body.nav-open {
  overflow: hidden;
}
```

### Bootstrap Italia data-bs-* rimossi

Questi attributi NON funzionano senza Bootstrap Italia JS e vanno rimossi/sostituiti:

- `data-bs-toggle="navbarcollapsible"` → sostituito con `@click` Alpine.js
- `data-bs-target="#nav4"` → sostituito con `x-show` sullo stesso elemento
- `data-bs-toggle="modal"` su search → mantenere solo se il modal search usa Alpine.js (verificare)

### Reference behavior (Design Comuni)

Sul reference (https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html):
- A ≤991px: hamburger apre **overlay laterale da sinistra** con sfondo scuro
- Overlay contiene: logo + nome comune, nav principale, nav secondaria
- Click su X o sul backdrop scuro chiude l'overlay
- Body scroll bloccato durante overlay aperto
- Transizione smooth slide-in

### Lezioni da Story 7-9 (fix traduzione)

- `fixcity::segnalazione.fields.details.placeholder` → chiave errata, usare `fixcity::segnalazione.create.details.placeholder`
- `fixcity::segnalazione.buttons.delete_image.aria.label` → chiave errata, usare `fixcity::segnalazione.actions.delete_image.aria.label`
- **Pattern**: sempre verificare che le chiavi di traduzione nel blade corrispondano alla struttura del file lang

## Project context reference

- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png`
- `laravel/Themes/Sixteen/docs/visual-comparison/structure-analysis/segnalazione-02-dati-html-comparison.md`
- Story 7-9: `_bmad-output/implementation-artifacts/7-9-segnalazione-02-dati-final-html-visual-parity.md`
- Story 7-8: `_bmad-output/implementation-artifacts/7-8-header-hamburger-mobile-parity.md`
