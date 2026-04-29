# Story 7.8: Header — hamburger posizionato a sinistra del logo su mobile

Status: review

## Story

Come **responsabile qualità frontoffice**,
voglio che il menu hamburger compaia **a sinistra del logo** nella riga del centro header su tutti i breakpoint mobili (< 992px),
così che l'header locale corrisponda visivamente al riferimento Design Comuni
e non mostri più il pulsante hamburger in una riga separata sotto il logo.

## Contesto

- **Pagina test:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` (bug visibile anche su tutte le altre pagine `/tests/*` su viewport stretto)
- **Riferimento ufficiale:** https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- **Screenshot reference (header desktop):** `laravel/Themes/Sixteen/docs/visual-comparison/sections/01-header-reference.png`
- **Screenshot local (header desktop):** `laravel/Themes/Sixteen/docs/visual-comparison/sections/01-header-local.png`

---

## Bug diagnosticato: causa radice identificata

### Il problema

In `laravel/Themes/Sixteen/resources/css/app.css` (righe 235–252) esiste già il CSS pensato per posizionare il hamburger:

```css
/* Mobile (<992px): hamburger sovrapposto al centro header */
@media (max-width: 991.98px) {
  .it-header-wrapper .it-nav-wrapper .it-header-navbar-wrapper {
    position: absolute !important;
    z-index: 3 !important;
    left: 0 !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: auto !important;
    background: transparent !important;
  }

  .it-header-center-wrapper .it-header-center-content-wrapper .it-brand-wrapper {
    padding-left: 56px !important;
  }
}
```

### Perché non funziona

`position: absolute` posiziona l'elemento rispetto al **più vicino antenato con `position` diversa da `static`**. Nel CSS attuale:

| Elemento | `position` attuale in `app.css` |
|---|---|
| `.it-header-wrapper` | nessuna (`static` default) |
| `.it-nav-wrapper` | solo `background: transparent` → **`static`** |
| `.it-header-center-wrapper` | solo `background`, `padding`, `min-height` → **`static`** |

Nessun antenato ha `position: relative`. Risultato: `.it-header-navbar-wrapper` con `position: absolute` si posiziona rispetto al `<body>`, atterrando sotto il logo invece che sovrapposto ad esso.

### Verifica matematica del fix corretto

Con `position: relative` su `.it-nav-wrapper`:
- Altezza `.it-nav-wrapper` ≈ min-height logo (120px) + min-height navbar (54px) = **174px**
- `top: 50%` = 87px dall'inizio di `.it-nav-wrapper`
- `transform: translateY(-50%)` risale di metà altezza di `.it-header-navbar-wrapper` (≈ 27px)
- Posizione finale hamburger: **87 − 27 = 60px** = esattamente al centro dei 120px del logo ✅

---

## Acceptance Criteria

1. **AC1 — Hamburger a sinistra del logo su mobile (< 992px):** il pulsante `.custom-navbar-toggler` appare sulla stessa riga orizzontale del logo, posizionato alla sinistra di `.it-brand-wrapper`, su qualsiasi pagina `/tests/*`.
2. **AC2 — Desktop (≥ 992px): nessuna regressione:** il navbar si espande orizzontalmente come prima; il hamburger rimane nascosto (`display: none`); l'header appare identico a prima.
3. **AC3 — Spazio a sinistra del logo:** il logo ha `padding-left` sufficiente (≈ 56px) da non sovrapporsi con l'hamburger.
4. **AC4 — Hamburger visibile e cliccabile:** il pulsante ha contrasto sufficiente (`color: #fff` su sfondo verde) ed è cliccabile (z-index > contenuto).
5. **AC5 — Nessuna regressione su altre pagine:** le pagine non-test del sito non devono essere impattate; il fix è globale ma scoped al componente `it-header-wrapper` già esistente.
6. **AC6 — Build:** `npm run build` in `laravel/Themes/Sixteen` dopo ogni modifica CSS/blade.

---

## Tasks / Subtasks

- [ ] **[PRIORITÀ ALTA]** Aggiungere `position: relative` a `.it-nav-wrapper` in `app.css` (riga ~226)
- [ ] Verificare in browser devtools (viewport 375px e 768px): l'hamburger si sovrappone alla riga del logo
- [ ] Verificare che `padding-left: 56px` su `.it-brand-wrapper` eviti sovrapposizione
- [ ] Verificare desktop (≥ 992px): nessuna regressione visiva, hamburger nascosto
- [ ] Controllare gli altri gap visivi dell'header elencati nella sezione "Differenze header rimanenti"
- [ ] `npm run build` in `laravel/Themes/Sixteen`
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/`
- [ ] Aggiornare `laravel/Themes/Sixteen/docs/css-js-parity.md` con gap chiusi

---

## Implementazione CSS — fix principale

### File da modificare

`laravel/Themes/Sixteen/resources/css/app.css`

### Modifica 1 — Aggiungere `position: relative` a `.it-nav-wrapper` (riga ~226)

**Prima (righe 225-228):**
```css
/* ---- Nav Wrapper ---- */
.it-nav-wrapper {
  background: transparent !important;
}
```

**Dopo:**
```css
/* ---- Nav Wrapper ---- */
.it-nav-wrapper {
  background: transparent !important;
  position: relative !important;  /* Necessario: antenato di riferimento per it-header-navbar-wrapper in position:absolute */
}
```

### Modifica 2 — Verificare le regole del media query mobile (righe 237-252, già presenti)

Le regole esistenti sono CORRETTE e diventeranno operative con il fix precedente. **Non modificare** il blocco `@media (max-width: 991.98px)` esistente — è già scritto correttamente:

```css
@media (max-width: 991.98px) {
  .it-header-wrapper .it-nav-wrapper .it-header-navbar-wrapper {
    position: absolute !important;
    z-index: 3 !important;
    left: 0 !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    width: auto !important;
    background: transparent !important;
  }

  .it-header-center-wrapper .it-header-center-content-wrapper .it-brand-wrapper {
    padding-left: 56px !important;
  }
}
```

---

## Differenze header rimanenti (da verificare e correggere)

Comparando `01-header-local.png` vs `01-header-reference.png`:

### Logo SVG
- **Reference:** logo scudo/stemma da `logo-comune.svg` visibile come SVG inline
- **Local:** `app.css:638–649` applica LOGO PARITY HOTFIX con `::before` background-image — **verificare che funzioni a tutti i breakpoint** e che il `width: 82px; height: 82px` sia rispettato su mobile

### Icone social nel banner "Seguici su"
- **Reference:** icone SVG (X, Facebook, YouTube, Telegram, WhatsApp, RSS) affiancate
- **Local:** `app.css:623–629` applica hotfix per `fill: currentColor` — verificare che le icone siano visibili in devtools (svg `<use>` href corretto verso sprites.svg)
- Se mancanti: controllare che `href="/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg#it-twitter"` punti al file reale

### Colore hamburger
- Il pulsante hamburger deve essere `color: #fff` su sfondo verde scuro — già definito in `app.css:279-281`
- Verificare che non sia sovrascritto da regole `segnalazione-parity.css`

---

## Struttura HTML rilevante (da `header.blade.php`)

```
header.it-header-wrapper
  div.it-header-slim-wrapper        ← slim bar (top)
  div.it-nav-wrapper                ← AGGIUNGERE position:relative
    div.it-header-center-wrapper    ← logo + socials + cerca
      div.it-header-center-content-wrapper
        div.it-brand-wrapper        ← logo SVG + testo (aggiungere padding-left: 56px su mobile)
        div.it-right-zone           ← it-socials + it-search-wrapper
    div.it-header-navbar-wrapper    ← DIVENTA position:absolute su mobile
      div.navbar.navbar-expand-lg.has-megamenu
        button.custom-navbar-toggler  ← hamburger (appare a sinistra del logo)
        div.navbar-collapsable        ← menu espandibile
```

---

## Dev Notes

### ⚠️ File da modificare (solo CSS)

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/css/app.css` | Aggiungere `position: relative` a `.it-nav-wrapper` (riga ~226) |

### ⚠️ Non modificare `header.blade.php`

Il file `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` contiene la struttura HTML corretta. Il fix è CSS-only. Non spostare il bottone `custom-navbar-toggler` nel blade.

### ⚠️ No Bootstrap Italia runtime

Nessun CDN o import BI. Solo CSS puro.

### ⚠️ Build obbligatorio

Dopo ogni modifica CSS eseguire da `laravel/Themes/Sixteen/`:
```bash
npm run build
```

Il server `php artisan serve` potrebbe cachare il manifest. Riavviarlo se i cambiamenti non appaiono.

### ⚠️ Sync public_html

Dalla story 7-7 sappiamo che il public path reale è `public_html/` (non `laravel/public/`). Dopo il build sincronizzare:
```bash
cp -r laravel/Themes/Sixteen/public/assets/* public_html/themes/Sixteen/assets/
cp laravel/Themes/Sixteen/public/manifest.json public_html/themes/Sixteen/manifest.json
```

### ⚠️ Test responsività

Testare a 3 breakpoint:
- Mobile: 375px (hamburger visibile a sinistra logo ✓, nav collassata)
- Tablet: 768px (stessa logica mobile)
- Desktop: 1280px (hamburger nascosto, nav espansa)

### Lezioni da story 7-7

- `public_path()` punta a `/public_html/` non a `laravel/public/` — sincronizzare sempre dopo build
- Riavviare `php artisan serve` dopo sync del manifest

### Lezioni da story 7-3 / 7-2

- Verificare SEMPRE in devtools computed styles che le regole siano applicate
- `npm run build` è obbligatorio — le modifiche CSS non si vedono senza rebuild

### Git context (ultimi commit rilevanti)

- `css: final parity fixes - all 7 segnalazione pages verified`
- `feat(css/js): Phase 2 complete + final screenshots for all 8 pages`
- `fix: remove incompatible method signatures from ModelContract interface`

---

## File coinvolti

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/css/app.css` | **MODIFICARE** — aggiungere `position: relative` a `.it-nav-wrapper` (1 riga) |
| `laravel/Themes/Sixteen/public/manifest.json` | Aggiornato da `npm run build` |
| `laravel/Themes/Sixteen/public/assets/app-*.css` | Generato da `npm run build` |
| `public_html/themes/Sixteen/manifest.json` | Sincronizzare dopo build |
| `public_html/themes/Sixteen/assets/app-*.css` | Sincronizzare dopo build |
| `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/local-*.png` | Aggiornare screenshot |
| `laravel/Themes/Sixteen/docs/css-js-parity.md` | Documentare gap chiusi |

---

## Project context reference

- `laravel/Themes/Sixteen/docs/00-index.md`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- Story precedente: `_bmad-output/implementation-artifacts/7-7-segnalazione-02-dati-stepper-responsive.md`
- Approccio homepage come riferimento: `laravel/Themes/Sixteen/resources/css/homepage-parity-v2.css` (sezione 9, righe 512-563)

---

## Dev Agent Record

### Completion Notes

- ✅ Fix implementato: aggiunto `position: relative !important` a `.it-nav-wrapper` in `app.css` (riga 226)
- ✅ `npm run build` in `laravel/Themes/Sixteen` — build riuscito in 4.97s
- ✅ Sync `public_html/themes/Sixteen/assets/` e `manifest.json`
- ⚠️ Verifica visiva su mobile ancora da effettuare (test su browser a 375px/768px)

### Change Log

- 2026-04-10: story 7-8 — aggiunto `position: relative` a `.it-nav-wrapper` in `app.css`, build e sync.

## Story completion status

Implementazione CSS completata. Stato: **review** (verifica visiva su mobile consigliata).
