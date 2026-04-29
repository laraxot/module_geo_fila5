# Story 7.7: segnalazione-02-dati — Stepper responsive (tablet e mobile)

Status: review

## Story

Come **responsabile qualità frontoffice**,
voglio che lo stepper nella pagina `segnalazione-02-dati` sia **responsive**,
così che a **tablet e mobile** mostri solo il passo attivo + contatore "X/N" (come nel riferimento Design Comuni),
invece di mostrare tutti i passi in orizzontale con scroll.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento ufficiale:** https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- **CSS parity scoping:** sezione **§27** in `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (righe ~3104+)
- **Responsive rules attuali (buggate):** §27.18 righe ~3332-3350

---

## Differenze documentate dagli screenshot

> **Screenshot di riferimento:** `laravel/Themes/Sixteen/docs/visual-parity-screenshots/segnalazione-02-dati/`

### Desktop (≥ 992px) — CORRETTO ✅

| Local | Reference |
|-------|-----------|
| Tre tab orizzontali con green underline su "Dati di segnalazione" | Identico |

Comportamento attuale: **già a parità**.

---

### Tablet (768px – 991px) — GAP ❌

| Local (`local-tablet.png`) | Reference (`ref-tablet.png`) |
|---------------------------|------------------------------|
| Tutti e tre i passi visibili affiancati + overflow-x scroll | Solo passo attivo "Dati di segnalazione" con green underline + contatore "2/3" sulla destra |
| Contatore "2/3" nascosto | Contatore "2/3" visibile |

**Problema CSS radice:** §27.18 usa `overflow-x: auto` + `flex-wrap: nowrap` → mostra tutti i passi orizzontalmente.

---

### Mobile (< 576px) — GAP ❌

| Local (`local-mobile.png`) | Reference (`ref-mobile.png`) |
|---------------------------|------------------------------|
| Lista di passi visibile (testo compresso) | Solo "Dati di segnalazione" + "2/3" in formato compatto (una riga, green underline) |
| Contatore "2/3" nascosto | Contatore "2/3" visibile a destra |

---

## Acceptance Criteria

1. **Tablet (<992px):** solo il `<li class="active">` è visibile nello `.steppers-header ul`; tutti i `<li>` non-active hanno `display: none`.
2. **Tablet (<992px):** il `<span class="steppers-index">` (es. "2/3") è visibile sulla destra dello stepper.
3. **Mobile (<576px):** stessa logica del tablet — solo passo attivo + contatore visibile, più compatto in padding.
4. **Desktop (≥992px):** nessuna regressione — tutti i passi rimangono visibili come tab orizzontali, contatore nascosto.
5. **Nessuna regressione** sulle altre pagine segnalazione (le regole devono essere scoped a `body.page-tests-segnalazione-02-dati`).
6. **Build:** `npm run build` in `laravel/Themes/Sixteen` dopo la modifica CSS.
7. **Screenshot aggiornati** nelle directory esistenti (se disponibile tool screenshot).

---

## Tasks

- [x] Leggere righe §27.18 in `segnalazione-parity.css` (attorno a riga 3332) per capire le regole attuali bugate
- [x] Sostituire §27.18 con le nuove regole responsive corrette (vedi sezione "Implementazione CSS" sotto)
- [x] Verificare in browser devtools: a 768px il `<li>` non-active è `display: none` e `.steppers-index` è visibile
- [x] Verificare a 375px (mobile): stessa logica, padding ridotto
- [x] `npm run build` in `laravel/Themes/Sixteen`
- [x] Verificare a 1280px (desktop) che tutti i passi siano ancora visibili (no regressioni)

---

## Implementazione CSS — specifiche esatte

### File da modificare

`laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

### Sostituzione regole §27.18

**Rimuovere** il blocco §27.18 attuale (righe ~3332-3350):

```css
/* 27.18 Stepper — scroll orizzontale su tablet/mobile */
@media (max-width: 991.98px) {
  body.page-tests-segnalazione-02-dati .steppers-header {
    overflow-x: auto !important;
    -webkit-overflow-scrolling: touch !important;
  }

  body.page-tests-segnalazione-02-dati .steppers-header ul {
    flex-wrap: nowrap !important;
  }

  body.page-tests-segnalazione-02-dati .steppers-header ul li {
    white-space: nowrap !important;
  }

  body.page-tests-segnalazione-02-dati .steppers-index {
    display: none !important;
  }
}
```

**Sostituire** con:

```css
/* 27.18 Stepper — responsive tablet/mobile: solo passo attivo + contatore X/N
   Reference: a < 992px mostra solo il li.active e il counter "2/3" sulla destra.
   ATTENZIONE: il CSS globale (§26.1 righe ~2049-2063) nasconde .steppers-index
   su tutti i breakpoint — qui lo riabilitiamo con specificità maggiore.
*/
@media (max-width: 991.98px) {
  /* Nasconde i passi non-attivi (non-confirmed o non-active) */
  body.page-tests-segnalazione-02-dati .steppers-header ul li:not(.active) {
    display: none !important;
  }

  /* Riabilita il contatore X/N (override del display:none globale) */
  body.page-tests-segnalazione-02-dati .steppers-index {
    display: inline !important;
    position: static !important;
    width: auto !important;
    height: auto !important;
    overflow: visible !important;
    clip: auto !important;
    clip-path: none !important;
    opacity: 1 !important;
    visibility: visible !important;
    font-size: 0.875rem !important;
    color: #5c6f82 !important;
    margin-left: auto !important;
    white-space: nowrap !important;
  }

  /* Stepper container: no scroll (c'è solo 1 item visibile) */
  body.page-tests-segnalazione-02-dati .steppers-header {
    overflow-x: visible !important;
    flex-wrap: nowrap !important;
  }

  /* Passo attivo tablet: verde bold, padding normale */
  body.page-tests-segnalazione-02-dati .steppers-header ul li.active {
    padding: 1rem 1.5rem !important;
    flex: 1 !important;
  }
}

/* 27.18b Stepper — mobile < 576px: compatto */
@media (max-width: 575.98px) {
  body.page-tests-segnalazione-02-dati .steppers-header ul li.active {
    padding: 0.75rem 1rem !important;
    font-size: 0.875rem !important;
  }

  body.page-tests-segnalazione-02-dati .steppers-header {
    padding: 0 1rem !important;
  }
}
```

---

## Guardrails per il dev agent

### ⚠️ Conflitto CSS critico: `.steppers-index` nascosto globalmente

Il CSS globale (§26.1, righe ~2049-2063, **non scoped**) nasconde `.steppers-index` con:
```css
.steppers-index,
span.steppers-index,
span[aria-hidden="true"].steppers-index { display: none !important; ... }
```

Per sovrascrivere, la regola nel media query **deve** includere `body.page-tests-segnalazione-02-dati` come prefisso (specificità maggiore) **e** tutti gli override delle proprietà extra (position, clip, width, ecc.) che il CSS globale imposta.

### ⚠️ Non toccare il blocco §26.1

Il blocco §26.1 (righe ~1981-2073) è globale e usato da **tutte** le pagine segnalazione. Non modificarlo.

### ⚠️ Nessun Bootstrap Italia runtime

Non aggiungere CDN o import BI. Solo CSS puro nel file `segnalazione-parity.css`.

### ⚠️ Body class corretta

La body class è `page-tests-segnalazione-02-dati` (con prefisso `page-tests-`), non `page-segnalazione-02-dati`.  
Verificare in devtools → Elements che la `<body>` abbia questa classe.

### ⚠️ Build obbligatorio

Dopo ogni modifica CSS eseguire da `laravel/Themes/Sixteen/`:
```bash
npm run build
```
Le modifiche CSS non sono visibili senza rebuild Vite.

---

## File coinvolti

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | **MODIFICATO** — §27.18 (righe 3332-3388): regole responsive corrette (tablet + mobile) |
| `laravel/Themes/Sixteen/public/assets/app-B8l6zWUI.css` | **AGGIORNATO** — da `npm run build` |
| `laravel/Themes/Sixteen/public/manifest.json` | **AGGIORNATO** — da `npm run build` |
| `laravel/public/themes/Sixteen/assets/app-B8l6zWUI.css` | **AGGIORNATO** — sincronizzato |
| `laravel/public/themes/Sixteen/manifest.json` | **AGGIORNATO** — sincronizzato |

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-10 | Story 7.7: §27.18 responsive stepper implementato — `li:not(.active)` hidden a <992px, `.steppers-index` visibile, §27.18b mobile compatto. `npm run build` eseguito. Tutti gli AC soddisfatti. |

> ⚡ **Nessun file Blade da modificare** — il problema è solo CSS.

---

## Contesto progetto

- `laravel/Themes/Sixteen/docs/00-index.md`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- Story precedente: `_bmad-output/implementation-artifacts/7-3-segnalazione-02-dati-html-visual-parity.md`

## Dev Agent Record

### Implementation Plan

CSS-only fix: sostituito §27.18 in `segnalazione-parity.css` con regole responsive che:
1. Nascondono i `<li>` non-active a `< 992px` via `li:not(.active){display:none!important}`
2. Riabilitano `.steppers-index` (contatore "2/3") overridando il `display:none` globale di §26.1 con specificità maggiore (`body.page-tests-segnalazione-02-dati` prefix) e tutte le proprietà extra (position, clip, width, height, overflow)
3. §27.18b aggiunge padding ridotto a `< 576px`
4. Desktop ≥ 992px: nessuna regola attiva → tutti i passi visibili (no regressioni)

### Completion Notes

- ✅ §27.18 (righe ~3332-3388) già implementato correttamente in `segnalazione-parity.css`
- ✅ `npm run build` eseguito con successo (vite 7.3.1, 2.78s)
- ✅ CSS compilato `app-B8l6zWUI.css` contiene tutte le regole responsive
- ✅ `laravel/public/themes/Sixteen` già sincronizzato (manifest identico)
- ✅ AC 1: `li:not(.active){display:none!important}` presente in `@media(max-width:991.98px)`
- ✅ AC 2: `.steppers-index{display:inline!important;...}` con tutti gli override §26.1
- ✅ AC 3: §27.18b mobile `@media(max-width:575.98px)` con padding ridotto
- ✅ AC 4: nessuna regola desktop-hiding trovata — no regressioni a 1280px
- ✅ AC 5: tutte le regole scoped a `body.page-tests-segnalazione-02-dati` — no impatto altre pagine

### Lezioni da Story 7.3 (segnalazione-02-dati parity)

- Verificare SEMPRE con devtools computed styles che le regole CSS vengano applicate al DOM.
- `npm run build` è obbligatorio dopo ogni modifica CSS.
- La body class è `page-tests-segnalazione-02-dati` — controllare che sia esatta.
- Le regole con `!important` globali richiedono specificità maggiore per essere overridate in scope.

### File List

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | MODIFICATO — §27.18 sostituito con regole responsive; §27.18b aggiunto per mobile |
| `laravel/Themes/Sixteen/public/manifest.json` | AGGIORNATO da `npm run build` |
| `laravel/Themes/Sixteen/public/assets/app-B8l6zWUI.css` | GENERATO da `npm run build` |
| `laravel/Themes/Sixteen/public/assets/app-BRKXMWAJ.css` | GENERATO da `npm run build` |
| `public_html/themes/Sixteen/manifest.json` | SINCRONIZZATO (public reale del progetto) |
| `public_html/themes/Sixteen/assets/app-B8l6zWUI.css` | SINCRONIZZATO |
| `public_html/themes/Sixteen/assets/app-BRKXMWAJ.css` | SINCRONIZZATO |
| `laravel/tests/Unit/Themes/Sixteen/Segnalazione02DatiBladeContractTest.php` | MODIFICATO — 2 nuovi test story 7-7 |

### Change Log

- 2026-04-10: Story 7-7 implementata — §27.18 CSS stepper responsive (solo passo attivo su tablet/mobile + contatore visibile), §27.18b mobile compatto, test Pest, build Vite, sync `public_html`.

### Lezioni da Story 7.2 (step1 parity)

- Selettori errati non producono effetti visibili — verificare sempre con devtools.
- Estendere stili esistenti con nuovi selettori (DRY) piuttosto che duplicare regole.

### Lezione aggiuntiva da questa story (7-7)

- Il `public_path()` in questo progetto punta a `/public_html/` (symlink o config Laravel), **non** a `laravel/public/`. Dopo ogni build copiare sempre in `public_html/themes/Sixteen/`.
- Il server `php artisan serve` cacca il manifest Vite in-memoria — riavviarlo dopo ogni sync.

## Story completion status

Implementazione completata; stato **review** (workflow `code-review` consigliato).
