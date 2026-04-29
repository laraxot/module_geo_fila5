# Story 7.37: segnalazione-02-dati — Fix upload section e wrapper HTML parity (97.63% → 99%+)

Status: ready-for-dev

## Story

Come **responsabile parity del tema Sixteen**,
voglio ridurre i mismatch strutturali residui tra la pagina locale `segnalazione-02-dati` e il reference Design Comuni,
eliminando i nodi HTML in eccesso nella sezione upload e documentando i constraint architetturali non rimovibili,
così da portare la parity dall'attuale `97.63%` (run6, 2026-04-10) al `99%` o superiore.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Snapshot corrente verificato

Run6 eseguito il `2026-04-10`:

```bash
bash bashscripts/html/html-structure-compare.sh \
  https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html \
  http://127.0.0.1:8000/it/tests/segnalazione-02-dati \
  laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run6
```

- HTTP locale: `200`
- Score HTML parity: **97.63%**
- Report: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run6/report.md`

### Nota: regressione da run4

Nelle run precedenti (run4: `99.24%`), la sezione upload era strutturata diversamente.
La regressione a `97.63%` è probabilmente dovuta alla ristrutturazione dell'upload con Alpine.js `x-for`.

### Mismatch attuali (tutti "Extra locale")

Dal report run6:

| # | Elemento extra (locale) | Causa | Rimovibile? |
|---|------------------------|-------|-------------|
| 1 | `div.content.page-content` | wrapper in `[slug].blade.php` | ⚠️ Rischio alto |
| 2 | `template` (x-if empty state) | Alpine.js x-if wrapper | ❌ No (constraint Alpine) |
| 3 | `template` (x-for loop) | Alpine.js x-for wrapper | ❌ No (constraint Alpine) |
| 4 | `div` (container x-for) | struttura x-for body | ✅ Ristrutturabile |
| 5 | `div.upload-wrapper` (x-for) | upload file per iteration | ✅ Ristrutturabile |
| 6 | `template` (x-if file.preview) | Alpine.js conditional | ❌ No |
| 7 | `img.img` (x-for) | immagine anteprima | ✅ Ristrutturabile |
| 8 | `template` (x-if !file.preview) | Alpine.js conditional | ❌ No |
| 9 | `svg.icon.icon-primary` | icona file (x-for) | ✅ Ristrutturabile |
| 10 | `use` | SVG use (x-for) | ✅ Ristrutturabile |
| 11 | `span.fw-bold.ms-2.t-primary.w-100` | nome file (x-for) | ✅ Ristrutturabile |
| 12 | `a.align-self-center` | link rimozione (x-for) | ✅ Ristrutturabile |
| 13 | `svg.icon.icon-primary.icon-sm.mb-1` | icona chiudi (x-for) | ✅ Ristrutturabile |
| 14 | `use` | SVG use chiudi | ✅ Ristrutturabile |
| 15 | `hr` | separatore (x-for) | ✅ Ristrutturabile |
| 16 | `input#file-upload-attachments.d-none` | input file upload | ❌ No (necessità funzionale) |
| 17-19 | `link` (×3) | CSS Livewire/Alpine injection | ❌ No (constraint framework) |

**Conteggio rimovibili**: ~10 su 19 → target realistico `99%+`.

### Analisi della sezione upload

Il blade locale usa due blocchi Alpine.js:

```blade
<!-- Stato VUOTO (x-if) — mostra upload-wrapper statico -->
<template x-if="files.length === 0">
    <div class="align-items-center d-flex justify-content-between upload-wrapper">
        <!-- img + span + a + svg + use -->
    </div>
</template>
<hr>

<!-- PER OGNI FILE caricato (x-for) — genera body template nel DOM statico -->
<template x-for="(file, index) in files" :key="index">
    <div>
        <div class="align-items-center d-flex justify-content-between upload-wrapper">
            <template x-if="file.preview"><img ...></template>
            <template x-if="!file.preview"><svg ...></template>
            <span x-text="file.name">...</span>
            <a @click="removeFile(index)">...</a>
            <hr>
        </div>
    </div>
</template>

<input type="file" id="file-upload-attachments" ...>
```

**Il problema**: anche se `files` è vuoto (`x-for` con 0 iterazioni), il contenuto del `<template x-for>` rimane nel DOM come nodi HTML puri. Il comparatore li legge come elementi extra rispetto al reference statico.

**La soluzione**: ristrutturare l'upload in modo che il corpo dell'`x-for` non duplichi elementi già matchati dal riferimento. Il riferimento mostra UN solo `upload-wrapper` (file già caricato). La nostra implementazione dovrà mantenere la funzionalità Alpine ma ridurre i nodi extra visibili al parser HTML statico.

### File primario

- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
  - Sezione upload: righe ~168–210
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
  - Wrapper `div.content.page-content`: riga ~36

## Acceptance Criteria

1. Il confronto HTML rilanciato dopo le modifiche mostra score `≥ 99%`.
2. La pagina locale risponde `200` dopo le modifiche.
3. La funzionalità upload (aggiungere/rimuovere file) continua a funzionare correttamente.
4. I mismatch riducibili (#4–15 nella tabella sopra) vengono eliminati o ridotti ristrutturando il template `x-for` della sezione upload.
5. I constraint architetturali non rimovibili (#2, #3, #6, #8, #16, #17-19) sono documentati nel Dev Notes della story come "plateau accettato".
6. Il wrapper `div.content.page-content` in `[slug].blade.php` viene analizzato:
   - Se rimuovibile senza regressioni: eliminato
   - Se non rimuovibile: documentato come constraint con motivazione tecnica
7. Il report finale viene salvato in `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run7/`.

## Tasks / Subtasks

- [ ] **Task 1 - Ristruttura upload section per ridurre template x-for** (AC: 1, 3, 4)
  - [ ] Leggere l'intero file `segnalazione-02-dati.blade.php` (righe 160-215)
  - [ ] Analizzare come il reference HTML struttura la sezione upload (confronta `run6/report.md` righe 107-115)
  - [ ] Valutare se spostare il contenuto del `x-for` body fuori dal template (es: un unico wrapper che varia contenuto con `:class`/`:src`)
  - [ ] In alternativa: usare `x-html` o `x-show` invece di `x-if`/`x-for` per ridurre i nodi `<template>` nel DOM
  - [ ] Modificare la sezione upload preservando funzionalità Alpine (aggiungi/rimuovi file)
  - [ ] Verificare che la pagina risponda `200` (`curl http://127.0.0.1:8000/it/tests/segnalazione-02-dati`)

- [ ] **Task 2 - Analizza wrapper div.content.page-content** (AC: 6)
  - [ ] Leggere `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
  - [ ] Verificare se il wrapper viene usato da JS per settare la body class (`page-tests-<slug>`)
  - [ ] Se il wrapper NON è necessario: rimuoverlo e testare che la pagina renderizzi correttamente
  - [ ] Se il wrapper È necessario: documentare il motivo nel Dev Notes

- [ ] **Task 3 - Verifica parity** (AC: 1, 2, 7)
  - [ ] `curl -o /dev/null -w '%{http_code}\n' http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
  - [ ] Eseguire confronto HTML run7:
    ```bash
    bash bashscripts/html/html-structure-compare.sh \
      https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html \
      http://127.0.0.1:8000/it/tests/segnalazione-02-dati \
      laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run7
    ```
  - [ ] Verificare score `≥ 99%`

- [ ] **Task 4 - Documenta constraint e chiudi story** (AC: 5, 7)
  - [ ] Aggiornare Dev Notes con i constraint architetturali residui
  - [ ] Aggiornare `sprint-status.yaml` con nuovo status quando completata

## Dev Notes

### File da leggere prima di iniziare

```
laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php
laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php
laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run6/report.md
```

### Approccio suggerito per upload section

**Problema**: `x-for` con 0 iterazioni genera body template nel DOM statico.

**Opzione A — `x-show` invece di `x-for`** (NON applicabile per liste dinamiche).

**Opzione B — Un singolo contenitore con `template x-if/x-else`** (riduce i template interni):
```html
<!-- Stato con file: usa x-if solo al livello container -->
<div x-show="files.length > 0">
  <!-- list items qui, senza template annidati -->
</div>
```

**Opzione C — Refactoring strutturale** (più impattante):
Eliminare `x-for` e usare una struttura simile al reference con variabili Alpine fisse:
```html
<div class="upload-wrapper ...">
  <img :src="currentFile.preview || '/path/placeholder.png'" class="img">
  <span class="fw-bold ms-2 t-primary w-100" x-text="currentFile.name || 'placeholder.jpg'"></span>
  <a ...>...</a>
</div>
<hr>
```

**GUARDRAIL**: Non rimuovere la funzionalità di upload multiple file. Il refactoring deve mantenere la capacità di aggiungere/rimuovere file.

### Constraint architetturali (plateau accettato)

Questi mismatch NON devono essere corretti perché sono intrinseci al framework:

1. **`template` (Alpine.js x-if)**: Alpine.js usa `<template>` per i condizionali → sempre presente nel DOM raw
2. **`template` (Alpine.js x-for)**: idem per i loop → sempre presente nel DOM raw
3. **`template` (Alpine.js x-if nested)**: idem per condizionali annidati
4. **`input#file-upload-attachments.d-none`**: necessario per il funzionamento del file upload
5. **`link` (×3)**: Livewire inietta CSS stylesheet links dinamicamente

### Body class e wrapper [slug].blade.php

Il file `[slug].blade.php` attualmente emette:
```blade
<div class="page-content content" data-slug="{{ $pageSlug }}" data-side="content">
```

Questo wrapper NON è necessario per settare la body class (che viene settata da JS su `document.body` leggendo l'URL o il `data-slug`). Potrebbe essere rimovibile se:
- Il JS che setta `page-tests-<slug>` sulla body legge l'URL e non dipende da questo div
- Nessun altro componente usa `.page-content` come selettore CSS critico

Verificare in `app.js` o nei CSS prima di rimuovere.

### Story precedenti correlate

- `7-25-segnalazione-02-dati-html-parity-last-mile.md` (run4: 99.24%, wrapper e link d-none)
- `7-24-segnalazione-02-dati-html-parity-final-residuals.md` (run3: 98.60%)

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- Run6 eseguito il 2026-04-10: score `97.63%`, 19 mismatch
- Report: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run6/report.md`

### Completion Notes List

- Story creata basandosi su run6 con score reale `97.63%` (regressione da run4 `99.24%`)
- La regressione è dovuta alla ristrutturazione upload con `x-for` che aggiunge ~13 nodi extra nel DOM statico
- Approcci alternativi documentati nel Dev Notes per evitare template x-for nidificati

### File List

- `_bmad-output/implementation-artifacts/7-37-segnalazione-02-dati-html-parity-upload-wrapper-fix.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-10 | Creata story 7.36 per fix mismatch upload section e wrapper, basata su run6 (97.63%). |
