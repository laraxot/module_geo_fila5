# Story: Header Responsive Parity — Segnalazione 02 Dati

**Epic**: Phase 1.1 — Global Component & Data Parity  
**Story ID**: 1.1.1-HEADER-RESPONSIVE  
**Status**: Draft  
**Priority**: P0 (Blocking visual parity)  
**Created**: 2026-04-10  

---

## User Story

Come sviluppatore front-end,
voglio che l'header della pagina `/it/tests/segnalazione-02-dati` sia identico al riferimento Bootstrap Italia su **tutti i breakpoint** (desktop, tablet, mobile),
in modo che l'utente abbia un'esperienza visiva e funzionale coerente con il design system Design Comuni.

---

## Acceptance Criteria

### AC1: Desktop Header Parity (≥ 992px)
**Given** la pagina `/it/tests/segnalazione-02-dati` aperta su viewport ≥ 992px  
**When** l'utente visualizza la pagina  
**Then** l'header deve essere identico al riferimento https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html in:
- Struttura DOM (3 wrapper: slim, center, navbar)
- Posizionamento elementi (logo, social, nav links)
- Tipografia, colori, spacing
- Link "Accedi all'area personale" visibile e funzionante

### AC2: Tablet Header Parity (768px – 991px)
**Given** la pagina aperta su viewport 768px–991px  
**When** l'utente visualizza la pagina  
**Then** l'header deve mostrare:
- Slim wrapper visibile (Nome della Regione, ITA, icona utente)
- Center wrapper con hamburger menu (sinistra), logo + brand (centro), ricerca (destra)
- Navbar **nascosta** (sostituita da hamburger)
- Nessun social icon visibile

### AC3: Mobile Header Parity (≤ 767px)
**Given** la pagina aperta su viewport ≤ 767px  
**When** l'utente visualizza la pagina  
**Then** l'header deve mostrare:
- Slim wrapper visibile ma compatto
- Center wrapper con hamburger (sinistra), logo + brand (centro), search (destra)
- Nessun social icon, nessun nav link visibile
- Layout identico al riferimento

### AC4: Mobile Menu Apertura/Chiusura
**Given** viewport ≤ 991px  
**When** l'utente clicca l'hamburger menu  
**Then**:
- Il menu mobile si apre con overlay scuro
- Il menu mostra: logo comune, links di navigazione (Amministrazione, Novità, Servizi, Vivere il Comune, Iscrizioni, Estate in città, Polizia locale, Tutti gli argomenti)
- Social icons in fondo al menu
- Click su X o overlay chiude il menu
- Il body riceve classe `nav-open`

### AC5: Slim Wrapper Tablet/Mobile
**Given** viewport ≤ 991px  
**When** l'utente visualizza l'header  
**Then** lo slim wrapper deve essere:
- Completamente visibile (non tagliato)
- Con "Nome della Regione" a sinistra
- "ITA" dropdown al centro
- Icona utente a destra
- Altezza coerente con il riferimento

---

## Dev Technical Guidance

### Current State Analysis (Screenshot Comparison)

#### ✅ Desktop (1920px) — PASS
| Elemento | Riferimento | Nostra Implementazione | Status |
|----------|------------|----------------------|--------|
| Slim wrapper | ✅ Visible, corretto | ✅ Visible, corretto | ✅ OK |
| Center wrapper | ✅ Logo + brand + social + search | ✅ Logo + brand + social + search | ✅ OK |
| Navbar | ✅ Links visibili | ✅ Links visibili | ✅ OK |
| Accedi area personale | ✅ Bottone visibile | ✅ Bottone visibile | ✅ OK |

#### ⚠️ Tablet (768px) — FAIL
| Elemento | Riferimento | Nostra Implementazione | Issue |
|----------|------------|----------------------|-------|
| Slim wrapper | ✅ Completo, visibile | ⚠️ **Parzialmente tagliato** (dark bar superiore troncata) | ❌ CSS overflow/clipping |
| Center wrapper | ✅ Hamburger + logo + search | ✅ Hamburger + logo + search | ✅ OK |
| Navbar | ✅ **Nascosta** | ✅ **Nascosta** | ✅ OK |
| Social icons | ✅ **Nascosti** | ✅ **Nascosti** | ✅ OK |

**Root cause tablet**: Lo slim wrapper ha un overflow o posizionamento che lo taglia parzialmente. Probabile causa: `position: fixed` o `overflow: hidden` su un container parent, oppure altezza insufficiente dello slim wrapper a 768px.

#### ⚠️ Mobile (375px) — FAIL
| Elemento | Riferimento | Nostra Implementazione | Issue |
|----------|------------|----------------------|-------|
| Slim wrapper | ✅ Completo, compatto | ⚠️ **Parzialmente tagliato** (solo metà visibile) | ❌ CSS overflow/clipping |
| Center wrapper | ✅ Hamburger + logo + search | ✅ Hamburger + logo + search | ✅ OK |
| "Seguici su" + social | ✅ **Nascosti** | ✅ **Nascosti** | ✅ OK |

**Root cause mobile**: Stesso problema del tablet — lo slim wrapper è tagliato superiormente.

#### ❌ Mobile Menu (375px, click hamburger) — FAIL
| Elemento | Riferimento | Nostra Implementazione | Issue |
|----------|------------|----------------------|-------|
| Menu apertura | ✅ Si apre con overlay | ❌ **Non si apre affatto** | ❌ Alpine.js @click non funziona |
| Menu contenuto | ✅ Links + social | ❌ N/A (non si apre) | ❌ |
| Overlay scuro | ✅ Presente | ❌ N/A | ❌ |
| Classe `nav-open` su body | ✅ Aggiunta | ❌ N/A | ❌ |

**Root cause mobile menu**: L'evento `@click` di Alpine.js sul pulsante `.custom-navbar-toggler` non viene triggerato. Possibili cause:
1. Alpine.js non è caricato correttamente nella pagina
2. Il componente header è renderizzato fuori dal contesto Alpine
3. Conflitto con Livewire/Volt che interferisce con Alpine
4. Il `x-data` sul navbar wrapper non è inizializzato

### Files to Modify

1. **Header CSS** — Fix slim wrapper clipping su tablet/mobile:
   - `laravel/Themes/Sixteen/resources/css/app.css` (o file Tailwind/apply correlato)
   - Cercare regole CSS relative a `.it-header-slim-wrapper` con media query per tablet/mobile

2. **Header Blade** — Fix Alpine.js mobile menu:
   - `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
   - Verificare che `x-data="{ mobileNavOpen: false }"` sia sul elemento corretto
   - Verificare che `@click` handler sia correttamente registrato

3. **Layout/Context** — Verificare Alpine.js initialization:
   - `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php`
   - `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php`
   - Verificare che Alpine.js sia caricato PRIMA dell'header

### Reference Header Structure

```html
<header class="it-header-wrapper" data-bs-target="#header-nav-wrapper">
  <!-- 1. Slim Wrapper (regione + lingua + login) -->
  <div class="it-header-slim-wrapper">...</div>

  <!-- 2. Nav Wrapper (contiene center + navbar) -->
  <div class="it-nav-wrapper">
    <!-- 2a. Center Wrapper (logo + social + search) -->
    <div class="it-header-center-wrapper">...</div>

    <!-- 2b. Navbar Wrapper (menu navigazione) -->
    <div class="it-header-navbar-wrapper" id="header-nav-wrapper" x-data="{ mobileNavOpen: false }">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="navbar navbar-expand-lg has-megamenu">
              <!-- Hamburger button con @click -->
              <button class="custom-navbar-toggler" @click="mobileNavOpen = !mobileNavOpen; ...">
              <!-- Mobile overlay -->
              <div x-show="mobileNavOpen" @click.self="mobileNavOpen = false; ...">
              <!-- Mobile menu panel -->
              <div x-show="mobileNavOpen" x-transition:...>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
```

### Bootstrap Italia CSS Dependencies

L'header dipende da queste classi Bootstrap Italia che DEVONO essere presenti:
- `.it-header-wrapper` — Container principale
- `.it-header-slim-wrapper` — Barra superiore (regione/lingua)
- `.it-header-center-wrapper` — Barra centrale (logo/social/search)
- `.it-header-navbar-wrapper` — Barra navigazione
- `.custom-navbar-toggler` — Pulsante hamburger
- `.navbar-overlay` — Overlay scuro mobile menu
- `.navbar-collapsable` — Pannello menu mobile

### Responsive Breakpoints (Bootstrap Italia)

| Breakpoint | Comportamento Header |
|-----------|---------------------|
| ≥ 992px (lg) | Navbar completa visibile, social visibili |
| 768px–991px (md) | Hamburger menu, NO social, slim wrapper completo |
| ≤ 767px (sm) | Hamburger menu, NO social, slim wrapper compatto |

### Alpine.js Integration Notes

- Alpine.js deve essere caricato **prima** che il componente header venga renderizzato
- Il `x-data` sul navbar wrapper deve essere attivo al momento del render
- Non ci devono essere conflitti con Livewire/Volt sulla gestione degli eventi
- Verificare che `x-cloak` non nasconda elementi che dovrebbero essere visibili

### Testing Requirements

- [ ] Test manuale su desktop (1920px): header identico al riferimento
- [ ] Test manuale su tablet (768px): slim wrapper visibile, hamburger funzionante
- [ ] Test manuale su mobile (375px): slim wrapper visibile, hamburger funzionante
- [ ] Test apertura/chiusura menu mobile con click hamburger
- [ ] Test overlay click-to-close
- [ ] Test tasto ESC per chiudere menu
- [ ] Verificare nessuna console error JS

---

## Tasks / Subtasks

### Task 1: Diagnostica Slim Wrapper Clipping (Tablet/Mobile)
- [ ] Ispezionare CSS di `.it-header-slim-wrapper` con DevTools a 768px e 375px
- [ ] Identificare la regola CSS che causa il clipping (overflow, position, height, z-index)
- [ ] Confrontare con il CSS del riferimento Bootstrap Italia
- [ ] Documentare la root cause nel debug log

### Task 2: Fix Slim Wrapper CSS
- [ ] Applicare fix CSS per rendere lo slim wrapper completamente visibile a tutti i breakpoint
- [ ] Verificare che il fix non rompa il layout desktop
- [ ] Test su 768px e 375px

### Task 3: Diagnostica Mobile Menu Alpine.js
- [ ] Verificare che Alpine.js sia caricato nella pagina (controllare console per `Alpine.version`)
- [ ] Verificare che il `x-data` sul navbar wrapper sia attivo
- [ ] Verificare che l'evento `@click` sul `.custom-navbar-toggler` sia registrato
- [ ] Controllare console per errori JS
- [ ] Documentare la root cause nel debug log

### Task 4: Fix Mobile Menu
- [ ] Applicare fix per far funzionare l'apertura del menu mobile
- [ ] Verificare overlay, transizioni, chiusura con X e ESC
- [ ] Verificare che `nav-open` venga aggiunta/rimossa dal body
- [ ] Test su 375px e 768px

### Task 5: Verifica Cross-Breakpoint Completa
- [ ] Screenshot comparativo desktop (1920px) vs riferimento
- [ ] Screenshot comparativo tablet (768px) vs riferimento
- [ ] Screenshot comparativo mobile (375px) vs riferimento
- [ ] Documentare qualsiasi differenza residua

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: Alpine.js potrebbe non essere compatibile con la configurazione corrente di Livewire/Volt
- **Mitigation**: Verificare la versione di Alpine.js inclusa e la configurazione di Livewire
- **Verification**: Test funzionali su tutti i breakpoint

### Rollback Plan
- I fix CSS sono reversibili (basta revertare le modifiche al file CSS)
- I fix Alpine.js sono reversibili (basta revertare il template header.blade.php)

### Safety Checks
- [ ] Verificare che la homepage `/` non sia impattata dai fix CSS
- [ ] Verificare che altre pagine Design Comuni non siano impattate
- [ ] Testare che il menu desktop (≥ 992px) continui a funzionare

---

## Dev Agent Record

### Agent Model Used
_Qwen Code_

### Debug Log References
- Screenshot riferimento desktop: `reference-desktop-header` — ✅ Header corretto
- Screenshot riferimento tablet: `reference-tablet-header` — ✅ Slim wrapper visibile, hamburger + logo + search
- Screenshot riferimento mobile: `reference-mobile-header` — ✅ Slim wrapper compatto, hamburger + logo + search
- Screenshot riferimento mobile menu aperto: `reference-mobile-menu-open` — ✅ Menu slide-in con links + social
- Screenshot nostro desktop: `our-desktop-header` — ✅ OK
- Screenshot nostro tablet: `our-tablet-header` — ⚠️ Slim wrapper parzialmente tagliato
- Screenshot nostro mobile: `our-mobile-header` — ⚠️ Slim wrapper parzialmente tagliato
- Screenshot nostro mobile menu (tentativo apertura): `our-mobile-menu-attempt` — ❌ Menu non si apre

### Completion Notes List
- Desktop: ✅ Header corretto al 100%
- Tablet: ⚠️ Slim wrapper tagliato superiormente — root cause: CSS overflow/clipping da investigare
- Mobile: ⚠️ Slim wrapper tagliato superiormente — stessa root cause del tablet
- Mobile menu: ❌ Non si apre — root cause: Alpine.js @click non triggerato
- Header blade location: `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- Layout wrapper: `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php` → `<x-layouts.main>`

### File List
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — ✅ Fixato: Alpine component `headerMobileNav` invece di inline `x-data`
- `laravel/Themes/Sixteen/resources/views/components/layouts/app.blade.php` — Layout wrapper
- `laravel/Themes/Sixteen/resources/css/app.css` — ✅ Fixato: rimosso `height: 48px` fisso, solo `min-height`
- `laravel/Themes/Sixteen/resources/js/app.js` — ✅ Aggiunto: Alpine component `headerMobileNav`

### Fix Applicati (2026-04-10)

**Fix 1: Slim Wrapper Clipping**
- Root cause: `height: 48px !important` su `.it-header-slim-wrapper` e content (linea 940-945 di app.css)
- Fix: cambiato in `min-height: 48px` senza `height` fisso
- File: `laravel/Themes/Sixteen/resources/css/app.css`
- Build: `npm run build && npm run copy` completato

**Fix 2: Mobile Menu Alpine.js**
- Root cause: inline `x-data="{ mobileNavOpen: false }"` non processato correttamente da Livewire/Alpine
- Fix: registrato Alpine component `headerMobileNav` in app.js, usato `x-data="headerMobileNav"` nel template
- File: `laravel/Themes/Sixteen/resources/js/app.js` + `header.blade.php`
- Build: completato

### Change Log
| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-04-10 | 1.0 | Story creata con analisi screenshot desktop/tablet/mobile | Qwen |
| 2026-04-10 | 1.1 | Fix CSS slim wrapper (rimosso height fisso) + Alpine component headerMobileNav | Qwen |

---

## Status: Ready for Verification

**Fixes Applied**: CSS slim wrapper + Alpine mobile menu component  
**Build**: ✅ CSS/JS built and copied to public_html  
**Next**: Manual verification on desktop/tablet/mobile breakpoints

**Ready for**: Dev agent implementation  
**Estimated Effort**: 2-4 ore  
**Dependencies**: Nessuna  

---

## Notes

- Questa story fa parte di **Phase 1.1: Global Component & Data Parity** (Task 1: Header Alignment)
- La roadmap è documentata in `.planning/ROADMAP.md`
- Il riferimento Bootstrap Italia è: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- La nostra implementazione è: http://127.0.0.1:8000/it/tests/segnalazione-02-dati
- Tutti gli screenshot comparativi sono stati catturati durante l'analisi
