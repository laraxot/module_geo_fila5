# Story 7.9: segnalazione-02-dati — Chiusura definitiva html + visual parity

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio che la pagina `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` abbia **piena html parity e visual parity** con il riferimento `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`,
così che ogni elemento visibile — header, stepper, form sezioni, sidebar navscroll, pulsanti wizard, footer contatti — sia indistinguibile dal modello Design Comuni.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento ufficiale:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Story precedenti completate:**
  - 7-3: CSS §27 corretto, i18n, 97% HTML parity → review
  - 7-7: Stepper responsive (solo passo attivo su mobile/tablet) → review
  - 7-8: Header hamburger mobile (aggiungere `position: relative` a `.it-nav-wrapper`) → ready-for-dev
- **Screenshot attuali:** `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/`
- **Snapshot HTML:** `laravel/Themes/Sixteen/docs/visual-comparison/structure-analysis/segnalazione-02-dati-{reference,local}-body.html`

---

## Risultati HTML Comparison Report (2026-04-10)

**Tool:** `bashscripts/html/compare-html-body.py`  
**Report:** `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/body-structure-comparison/segnalazione-02-dati-comparison-report.md`

| Metrica | Valore |
|---------|--------|
| **Parity score** | **88.96% ✅ PASS** (soglia: 80%) |
| Tag parity | 100% |
| ID parity | 100% |
| Class parity | 99.09% |
| Elementi reference | 559 |
| Elementi local | 575 |
| Identici | 467 |
| Con differenze | 89 |
| Mancanti | 3 |
| Extra local | 19 |

### Differenze principali

| Tipo | Causa | Impatto visivo |
|------|-------|---------------|
| SVG `<use>` href (≈60+ occorrenze) | Reference usa `../assets/.../sprites.svg#icon`, locale usa `/themes/Sixteen/.../sprites.svg#icon` | Nessuno: stesso file, path diverso |
| Logo `<image>` attributes | Attributi SVG image diversi (xlink:href / href) | Da verificare: logo potrebbe non renderizzare |
| `<header>` attributes | Attributi extra (Alpine x-data, class) | Nessuno: struttura identica |
| Nav `<a>` class `active` | Link[3] locale ha classe `active nav-link` vs reference `nav-link` | Cosmetics: evidenzia nav item attivo |
| Extra `#file-upload-attachments` | ID aggiunto per Alpine.js upload | Funzionale, non presente in reference |
| 19 extra local | Alpine.js: backdrop, overlay, x-data elements | Funzionali per Alpine, non nel reference statico |

---

## Gap noti da chiudere (analisi screenshot + codice)

### 1. Header mobile — hamburger posizione [CRITICO — story 7-8]

**Stato:** story 7-8 identifica il fix ma non è ancora implementata.

**Bug:** In `app.css` esiste il CSS per posizionare il hamburger in `position: absolute` (riga 237), ma manca `position: relative` sull'antenato `.it-nav-wrapper` (riga 226). Risultato: hamburger appare sotto il logo anziché a sinistra.

**Fix (1 riga):** aggiungere `position: relative !important;` alla regola `.it-nav-wrapper` in `app.css`.

```css
/* PRIMA */
.it-nav-wrapper {
  background: transparent !important;
}

/* DOPO */
.it-nav-wrapper {
  background: transparent !important;
  position: relative !important;
}
```

---

### 2. Header — icone social "Seguici su" [VERIFICARE]

**Stato:** in `app.css:623-629` c'è l'hotfix per `fill: currentColor`. Il blade `header.blade.php` contiene il markup corretto con SVG `<use href="/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg#it-twitter">`.

**Da fare:** verificare in devtools che le icone siano visibili su desktop (classe `d-none d-lg-flex`). Se le icone non appaiono, probabilmente il file sprites.svg non esiste nel path dichiarato.

**Verifica:** `ls laravel/Themes/Sixteen/public/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg` (o il path corrispondente nella public root).

---

### 3. Header — logo SVG rendering [VERIFICARE]

**Stato:** `app.css:638-655` applica LOGO PARITY HOTFIX:
- Nasconde il `<svg>` originale con `display: none`
- Usa `::before` con `background-image: url('/themes/Sixteen/design-comuni/assets/images/logo-comune.svg')`

**Da fare:** verificare che il file `logo-comune.svg` esista nel path `/themes/Sixteen/design-comuni/assets/images/` accessibile dal browser. Se non esiste, usare il path corretto o copiare il file.

**Confronto reference:** il reference usa `../assets/images/logo-comune.svg` che in locale corrisponde a `laravel/Themes/Sixteen/design-comuni/assets/images/logo-comune.svg`.

---

### 4. Page content — sezioni H2 e testi [VERIFICARE]

**Stato:** gli screenshot mostrano possibili translation key raw (es. `fixcity:segnalazione.fields.place.label`) nelle intestazioni delle sezioni. Questo potrebbe essere un artifact di screenshot vecchi, o un bug reale.

**Da verificare:** 
- Aprire `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` nel browser
- Le H2 devono mostrare: **"Luogo"**, **"Disservizio segnalato"**, **"Autore della segnalazione"**
- Se mostrano i raw keys, il problema è nel caricamento delle traduzioni del modulo Fixcity

**Se le traduzioni non funzionano:**
- Controllare che il modulo Fixcity sia abilitato in `modules_statuses.json`
- Verificare la registrazione del language namespace in `Modules/Fixcity/app/Providers/FixcityServiceProvider.php`
- Oppure: sostituire le chiamate `__('fixcity::segnalazione.fields.place.label')` con stringhe dirette nel blade come fallback temporaneo

---

### 5. Visual parity — misurazioni sistematiche

Dopo aver applicato i fix sopra, eseguire una verifica visiva sistematica confrontando ogni sezione:

| Sezione | Elemento da verificare | Status |
|---------|----------------------|--------|
| Header slim | Font, colori, padding top bar | Da verificare |
| Header center | Logo, socials, cerca | Da verificare |
| Header nav | Hamburger posizione (7-8), nav link color | Da verificare |
| Breadcrumb | Font, separatori, link color | Da verificare |
| H1 "Segnalazione disservizio" | Font size `title-xxxlarge` (2.5rem), colore | Da verificare |
| Stepper | Desktop: 3 tab orizzontali; mobile: solo attivo (7-7) | Già verificato |
| Navscroll sidebar | Accordion, link color, progress bar | Da verificare |
| Section #report-place | Card grigia, H2, input autocomplete | Da verificare |
| Section #report-info | Card grigia, H2*, select, input, textarea, upload | Da verificare |
| Section #report-author | Card grigia, H2, cmp-info-button-card, accordion | Da verificare |
| Nav steps | Indietro / Salva / Avanti buttons | Da verificare |
| Footer contatti | Card bianca, link list, icone | Da verificare |

---

## Acceptance Criteria

1. **AC1 — Hamburger mobile:** il pulsante hamburger appare a SINISTRA del logo nella riga centro header, non sotto. Verificare a 375px e 768px.
2. **AC2 — Logo visibile:** il logo del comune (scudo/stemma) è visibile nel header center wrapper con dimensioni 82x82px.
3. **AC3 — Social icons:** le icone social "Seguici su" sono visibili su desktop (d-lg-flex), correttamente colorate (#fff).
4. **AC4 — Traduzioni:** le sezioni mostrano "Luogo", "Disservizio segnalato", "Autore della segnalazione" (non raw translation keys).
5. **AC5 — Visual match ≥95%:** ogni sezione della pagina è visivamente comparabile al reference (font, colori, spaziature, bordi).
6. **AC6 — Nessuna regressione** sulle pagine segnalazione-01, segnalazione-03, segnalazione-04, area-personale, elenco, dettaglio.
7. **AC7 — Build:** `npm run build` in `laravel/Themes/Sixteen` + sync `public_html/themes/Sixteen/`.
8. **AC8 — Screenshot aggiornati:** scattare nuovi screenshot local-full.png, local-viewport.png dopo i fix.

---

## Tasks

- [ ] **[PRIORITÀ MASSIMA]** Applicare fix story 7-8: aggiungere `position: relative !important` a `.it-nav-wrapper` in `app.css` (riga ~226)
- [ ] Verificare logo e icone social in devtools (path del file SVG corretto)
- [ ] Verificare che le traduzioni rendano testo italiano (non raw keys)
- [ ] Confronto visivo sistematico pagina locale vs reference (vedi tabella sezione 5)
- [ ] Aggiungere CSS scoped se necessario in `segnalazione-parity.css` (sezione §27)
- [ ] `npm run build` in `laravel/Themes/Sixteen`
- [ ] Sync `public_html/themes/Sixteen/` (da story 7-7: `public_path()` → `public_html/`)
- [ ] Riavviare `php artisan serve` dopo sync
- [ ] Scattare nuovi screenshot: `local-full.png`, `local-viewport.png`
- [ ] Aggiornare `laravel/Themes/Sixteen/docs/css-js-parity.md` con gap chiusi

---

## Dev Notes

### File hot

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/css/app.css` | Fix hamburger (riga ~226: add `position: relative`) |
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | Eventuali fix §27 aggiuntivi |
| `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` | Solo se serve correggere path SVG/logo |
| `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` | Solo se serve fix traduzioni |
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | Traduzioni (già complete, non modificare) |

### ⚠️ Regole di progetto

- **No Bootstrap Italia runtime**: niente CDN o bundle BI; Tailwind + Alpine + CSS custom.
- **Scoping CSS**: modifiche a `segnalazione-parity.css` devono stare sotto `body.page-tests-segnalazione-02-dati` (o globali se necessario per header).
- **No file .md con date nel nome.**
- **Build obbligatorio** dopo ogni cambio CSS.

### ⚠️ Struttura HTML header (reference = locale, identici)

La struttura HTML del header nel reference e nel locale è **identica** (confermata da snapshot 2026-04-06). Il problema hamburger è solo **CSS**: manca `position: relative` su `.it-nav-wrapper`.

### ⚠️ Body class per scoping segnalazione-02-dati

La body class è `page-tests-segnalazione-02-dati` (con prefisso `page-tests-`).  
Verificare con devtools → Elements → body.

### ⚠️ Sync public_html (da story 7-7)

Il `public_path()` in questo progetto punta a `public_html/` non a `laravel/public/`.  
Dopo ogni build:
```bash
cp -r laravel/Themes/Sixteen/public/assets/* public_html/themes/Sixteen/assets/
cp laravel/Themes/Sixteen/public/manifest.json public_html/themes/Sixteen/manifest.json
```
E riavviare `php artisan serve` per svuotare la cache del manifest.

### ⚠️ CSS hamburger — fix minimo da applicare (story 7-8)

```css
/* In app.css, modifica riga ~226 */
.it-nav-wrapper {
  background: transparent !important;
  position: relative !important; /* ← AGGIUNGERE */
}
```

Verificare poi in devtools a 375px che:
- `.it-header-navbar-wrapper` abbia `position: absolute; left: 0; top: 50%`
- La `transform: translateY(-50%)` sia applicata
- Il pulsante hamburger appaia sovrapposto alla riga del logo (non sotto)

### Contesto CSS hamburger (sezione app.css)

```
.it-nav-wrapper               ← AGGIUNGERE position:relative
  .it-header-center-wrapper   ← logo row (min-height: 120px)
  .it-header-navbar-wrapper   ← position:absolute su mobile → si sovrappone a logo row
    .custom-navbar-toggler    ← hamburger (left: 0, vertically centered)
```

Con `it-nav-wrapper: position:relative` (alt ≈ 174px):
- `top: 50%` = 87px
- `translateY(-50%)` − 27px = **60px** = centro esatto dei 120px logo ✅

---

## Project context reference

- `laravel/Themes/Sixteen/docs/00-index.md`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Themes/Sixteen/docs/visual-comparison/structure-analysis/segnalazione-02-dati-html-comparison.md`
- Story 7-8: `_bmad-output/implementation-artifacts/7-8-header-hamburger-mobile-parity.md`
- Story 7-7: `_bmad-output/implementation-artifacts/7-7-segnalazione-02-dati-stepper-responsive.md`
- Story 7-3: `_bmad-output/implementation-artifacts/7-3-segnalazione-02-dati-html-visual-parity.md`

## Story completion status

Story creata con analisi completa dei gap rimasti. Stato: **ready-for-dev**.

Il fix critico (hamburger) è una modifica di 1 riga. Il resto richiede verifica sistematica e fix CSS mirati.
