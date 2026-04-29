# Story 7.9: segnalazione-02-dati — Completamento checklist HTML + visual parity

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio **completare e verificare** la HTML parity e la visual parity della pagina test `segnalazione-02-dati` rispetto al riferimento Design Comuni,
così che **tutti gli item rimasti nella checklist siano corretti** e documentati come verificati.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento ufficiale:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Blade:** `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- **CSS §27:** `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (righe ~3105-3370)
- **Checklist corrente:** `laravel/Themes/Sixteen/docs/css-js-parity.md` (sezione "Segnalazione-02-Dati")

### Storie precedenti su questa pagina

| Story | Status | Contributo |
|---|---|---|
| 7-3 | review | §27 CSS allineata ai selettori reali del Blade; HTML parity al 97% |
| 7-7 | review | Stepper responsivo su mobile (<992px) |

---

## Gap da risolvere

### 1. HTML parity — Blade: `textarea rows="2"` → `rows="5"`

Nel blade (`riga ~192`) la textarea per i dettagli ha `rows="2"`, mentre il riferimento Design Comuni usa **`rows="5"`**. Questo riduce visivamente l'area di testo e non corrisponde all'HTML reference.

```blade
{{-- PRIMA (attuale, SBAGLIATO) --}}
<textarea class="text-area" id="details" rows="2" required></textarea>

{{-- DOPO (corretto, match reference) --}}
<textarea class="text-area" id="details" rows="5" required></textarea>
```

### 2. CSS parity — Border color input: `#5d7083` → `#5c6f82`

In §27.1 (`segnalazione-parity.css`, riga ~3118):
```css
/* PRIMA */
border-bottom: 1px solid #5d7083 !important;

/* DOPO — valore Design Comuni esatto */
border-bottom: 1px solid #5c6f82 !important;
```

Il valore `#5c6f82` è il colore ufficiale `--italia-gray-700` presente nei design token del progetto (vedi `css-js-parity.md`, sezione Design Tokens).

### 3. CSS parity — Select dropdown: freccia/icona personalizzata

Il reference Design Comuni mostra il select con una freccia SVG personalizzata. Attualmente §27 non aggiunge il custom arrow al `.select-wrapper select`. Aggiungere in §27 dopo la regola §27.1:

```css
/* 27.1b Select wrapper — freccia personalizzata */
body.page-tests-segnalazione-02-dati .select-wrapper select {
  appearance: none !important;
  -webkit-appearance: none !important;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'%3E%3Cpath fill='%235c6f82' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") !important;
  background-repeat: no-repeat !important;
  background-position: right 12px center !important;
  padding-right: 36px !important;
}
```

### 4. Verifica checklist `css-js-parity.md` e aggiornamento

I seguenti item della checklist nella sezione "Segnalazione-02-Dati" sono ancora `[ ]` non verificati:
```
- [ ] Form inputs: border #5c6f82, focus ring #007a52
- [ ] Select dropdown: wrapper con icona freccia
- [ ] Textarea: rows 5, resize none
```

Dopo i fix ai punti 1-3, aggiornare la checklist a `[x]`:
```
- [x] Form inputs: border #5c6f82, focus ring #007a52
- [x] Select dropdown: wrapper con icona freccia
- [x] Textarea: rows 5, resize none
```

---

## Acceptance Criteria

1. **AC1 — Textarea rows:** il campo `#details` nel blade ha `rows="5"`; in browser il campo mostra 5 righe visibili senza CSS.
2. **AC2 — Border color esatto:** in devtools computed styles, `border-bottom-color` su `input[type="text"]`, `input[type="search"]`, `textarea`, `select` scoped a `body.page-tests-segnalazione-02-dati` è `rgb(92, 111, 130)` = `#5c6f82`.
3. **AC3 — Focus ring:** su focus, `border-bottom-color` diventa `rgb(0, 122, 82)` = `#007a52`.
4. **AC4 — Select freccia:** il select `#inefficiency` mostra una freccia personalizzata (chevron SVG); non mostra la freccia nativa del browser.
5. **AC5 — Textarea resize none:** il campo `#details` non è ridimensionabile dall'utente (`resize: none` in CSS).
6. **AC6 — Checklist aggiornata:** le 3 righe nella checklist di `css-js-parity.md` sono marcate `[x]`.
7. **AC7 — Build:** `npm run build` in `laravel/Themes/Sixteen` completato senza errori; manifest sincronizzato in `public_html/`.
8. **AC8 — Nessuna regressione:** le altre pagine segnalazione non sono impattate; modifiche scoped a `body.page-tests-segnalazione-02-dati`.

---

## Tasks / Subtasks

- [ ] **Blade**: cambiare `rows="2"` → `rows="5"` su `<textarea id="details">` (riga ~192)
- [ ] **CSS §27.1**: cambiare `border-bottom: 1px solid #5d7083` → `#5c6f82`
- [ ] **CSS §27**: aggiungere regola `27.1b` per select custom arrow (vedi snippet sopra)
- [ ] **CSS §27** (se non già presente): aggiungere `resize: none` alla textarea in §27.1
- [ ] Verificare in devtools computed styles: border color, focus ring, select arrow
- [ ] `npm run build` da `laravel/Themes/Sixteen/`
- [ ] Sync: `cp -r laravel/Themes/Sixteen/public/assets/* public_html/themes/Sixteen/assets/` + manifest
- [ ] Aggiornare checklist in `laravel/Themes/Sixteen/docs/css-js-parity.md`

---

## Implementazione — dettaglio completo

### File 1: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

**Modifica: riga ~192**
```blade
{{-- PRIMA --}}
<textarea class="text-area" id="details" rows="2" required></textarea>

{{-- DOPO --}}
<textarea class="text-area" id="details" rows="5" required></textarea>
```

---

### File 2: `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

**Modifica A — §27.1 (riga ~3118): correggere colore border**
```css
/* PRIMA */
border-bottom: 1px solid #5d7083 !important;

/* DOPO */
border-bottom: 1px solid #5c6f82 !important;
```

**Modifica B — §27.1 textarea: aggiungere resize:none**
Trovare la regola §27.1 per textarea e aggiungere `resize: none !important;` nel blocco esistente:
```css
body.page-tests-segnalazione-02-dati textarea {
  /* … regole esistenti … */
  resize: none !important;
}
```
Se la regola è accorpata con input/select, aggiungere una regola separata:
```css
body.page-tests-segnalazione-02-dati textarea {
  resize: none !important;
}
```

**Modifica C — Nuova regola §27.1b (dopo §27.1): custom arrow select**
Inserire dopo il blocco §27.1:
```css
/* 27.1b Select wrapper — freccia personalizzata (Design Comuni arrow) */
body.page-tests-segnalazione-02-dati .select-wrapper select {
  appearance: none !important;
  -webkit-appearance: none !important;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'%3E%3Cpath fill='%235c6f82' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") !important;
  background-repeat: no-repeat !important;
  background-position: right 12px center !important;
  padding-right: 36px !important;
}
```

---

## Dev Notes

### ⚠️ Regola progetto: body class scoping

Tutte le regole §27 DEVONO essere prefissate con `body.page-tests-segnalazione-02-dati`. Non aggiungere regole globali.

### ⚠️ Body class: come viene iniettata

La classe `page-tests-segnalazione-02-dati` è iniettata dal layout blade. Verificare in devtools che `<body>` abbia questa classe sulla pagina locale.

### ⚠️ Build obbligatorio + sync

Dopo ogni modifica CSS:
```bash
cd laravel/Themes/Sixteen
npm run build
cp -r public/assets/* /var/www/_bases/base_fixcity_fila5/public_html/themes/Sixteen/assets/
cp public/manifest.json /var/www/_bases/base_fixcity_fila5/public_html/themes/Sixteen/manifest.json
```

### ⚠️ No Bootstrap Italia runtime

Nessun CDN, nessun bundle BI. Solo CSS puro scoped + Alpine.js.

### ⚠️ File .md: niente date nel nome

Non creare nuovi file `.md` con date nel nome. Aggiornare solo i file esistenti.

### Lezioni da story 7-3

- CSS con selettori errati non produce effetti visibili → verificare SEMPRE con devtools
- La `body` class è `page-tests-segnalazione-02-dati` (non `page-segnalazione-02-dati`)
- Le modifiche CSS non si vedono senza `npm run build`

### Lezioni da story 7-7

- `public_path()` punta a `/public_html/` non a `laravel/public/` → sync sempre dopo build
- Riavviare `php artisan serve` se il manifest non si aggiorna

### Design token di riferimento

```css
--italia-gray-700: #5c6f82   /* border inputs */
--italia-green:    #007a52   /* focus ring, link, btn primary */
```

---

## File coinvolti

| File | Azione |
|------|--------|
| `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` | **MODIFICARE** — `rows="2"` → `rows="5"` |
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | **MODIFICARE** — §27.1 border color + resize + §27.1b select arrow |
| `laravel/Themes/Sixteen/docs/css-js-parity.md` | **AGGIORNARE** — spuntare 3 item checklist |
| `laravel/Themes/Sixteen/public/manifest.json` + `public/assets/app-*.css` | Generato da `npm run build` |
| `public_html/themes/Sixteen/manifest.json` + `assets/app-*.css` | Sync dopo build |

---

## Project context reference

- Story precedente (stessa pagina): `_bmad-output/implementation-artifacts/7-3-segnalazione-02-dati-html-visual-parity.md`
- CSS §27: `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` (righe ~3105-3370)
- Blade blocco: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- Checklist: `laravel/Themes/Sixteen/docs/css-js-parity.md`
- Design tokens: `laravel/Themes/Sixteen/docs/css-js-parity.md` (sezione "Design Tokens")

---

## Story completion status

Story creata con analisi completa dei gap residui. Stato: **ready-for-dev**.

3 fix chirurgici: 1 riga nel blade (`rows`), 2 modifiche CSS (colore border, select arrow) + verifica checklist.
