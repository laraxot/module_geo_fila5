# Story 7.23: segnalazione-02-dati — HTML parity residual fixes (95.19% → 98%+)

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio chiudere le differenze strutturali HTML residue tra `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` e `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`,
così da portare la parity da 95.19% a ≥98%, eliminando i delta rilevati dallo script di confronto.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Script usato:** `bashscripts/html/html-structure-compare.sh`
- **Report completo:** `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report.md`
- **Score attuale:** 95.19% (2026-04-12)
- **Story precedente:** `7-9-segnalazione-02-dati-final-html-visual-parity` (in-progress)
- **Blade:** `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- **JSON:** `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json`

### Gap rilevati dallo script (delta 4.81%)

#### ❌ Extra nel local (non nel reference)

| # | Elemento extra nel local | Causa probabile | Priorità |
|---|--------------------------|-----------------|----------|
| 1 | `div.tests-view-wrapper` | Vincolo Livewire Volt: single root element | 🟡 Bassa — architetturale |
| 2 | `nav.cmp-page-index-mobile.d-lg-none` + `ul` + 3x `li` + 3x `a` | Mobile page index aggiuntivo nel JSON/blade | 🔴 Alta |
| 3 | 2x `option` extra nel `select#inefficiency` | Opzioni extra nel JSON (contenuto) | 🟡 Media |
| 4 | 2x `<template>` Alpine.js (upload preview) | Alpine `x-if`/`x-for` templates nel blade | 🟡 Media |
| 5 | `div` + `div.align-items-center.d-flex.justify-content-between.upload-wrapper` (e nested) | Secondo slot upload duplicato | 🔴 Alta |
| 6 | `input#file-upload-attachments.d-none` | Input file upload nel local, assente nel reference | 🟡 Media |

#### ❌ Differenze (stesso elemento, classi diverse)

| # | Reference | Local | Differenza | Priorità |
|---|-----------|-------|------------|----------|
| 7 | `label.d-none.label-input.mb-2` | `label.active.d-none.label-input.mb-2` | Classe `active` extra nel local | 🟡 Media |
| 8 | `button.btn.btn-sm.p-0.steppers-btn-prev` | `a.btn.btn-sm.p-0.steppers-btn-prev` | `button` nel ref, `a` nel local | 🔴 Alta |
| 9 | `button.btn.btn-primary.btn-sm.steppers-btn-confirm` | `a.btn.btn-primary.btn-sm.steppers-btn-confirm` | `button` nel ref, `a` nel local | 🔴 Alta |
| 10 | `div#alert-message.alert.alert-success.cmp-disclaimer.d-none.rounded` | `div#alert-message.alert.alert-success.cmp-disclaimer.rounded` | Classe `d-none` mancante nel local | 🔴 Alta |

#### ❌ Mancanti nel local (presenti nel reference)

| # | Elemento mancante | Sezione | Priorità |
|---|-------------------|---------|----------|
| 11 | `a.d-none.text-decoration-none` | Card author → edit link | 🟡 Media |
| 12 | `span.t-primary.text-button-sm-semi` | Card author → edit link text | 🟡 Media |

## Acceptance Criteria

1. **AC1 — nav.cmp-page-index-mobile rimossa:** il `nav.cmp-page-index-mobile` extra (con lista di anchor link mobile) viene rimosso dal blade/JSON se non presente nel reference.
2. **AC2 — Stepper buttons → button:** `steppers-btn-prev` e `steppers-btn-confirm` usano tag `<button>` (non `<a>`) come nel reference.
3. **AC3 — Alert d-none:** `div#alert-message` ha classe `d-none` per default come nel reference.
4. **AC4 — Upload wrapper deduplicato:** il secondo `div.upload-wrapper` (duplicato Alpine) non genera elementi extra nel DOM statico.
5. **AC5 — Label autocomplete:** `label.label-input` non ha classe `active` per default (solo quando l'input ha focus/valore).
6. **AC6 — Edit link author:** `a.d-none.text-decoration-none` + `span.t-primary.text-button-sm-semi` presenti nella card author come nel reference.
7. **AC7 — Score ≥98%:** rieseguendo `bashscripts/html/html-structure-compare.sh` il parity score è ≥98%.
8. **AC8 — No regressioni:** le altre pagine segnalazione non subiscono cambiamenti strutturali.

## Tasks / Subtasks

- [ ] **Task 1 — Rimuovere nav.cmp-page-index-mobile extra** (AC1)
  - [ ] Verificare nel JSON `tests.segnalazione-02-dati.json` se è presente un blocco `cmp-page-index-mobile`
  - [ ] Se extra rispetto al reference, rimuovere dal JSON
  - [ ] Verificare nel blade/view se il componente è incluso condizionalmente

- [ ] **Task 2 — Fix tag stepper buttons: a → button** (AC2)
  - [ ] Nel blade/JSON per `steppers-btn-prev`: cambiare `<a ...>` in `<button type="button" ...>`
  - [ ] Nel blade/JSON per `steppers-btn-confirm`: cambiare `<a ...>` in `<button type="button" ...>`
  - [ ] Verificare che Alpine.js handlers rimangano funzionanti

- [ ] **Task 3 — Fix alert-message d-none** (AC3)
  - [ ] Nel blade/JSON per `#alert-message`: aggiungere classe `d-none` di default
  - [ ] L'alert deve mostrarsi solo su evento JavaScript (Alpine.js `x-show` o rimozione `d-none`)

- [ ] **Task 4 — Deduplicare Alpine upload preview** (AC4)
  - [ ] Nel blade della sezione upload: verificare che i `<template>` Alpine.js non generino nodi DOM visibili nel render statico
  - [ ] Usare `x-if` invece di elementi nascosti con `display:none` per la preview
  - [ ] Il DOM statico deve mostrare solo la struttura del reference (1x `upload-wrapper`, non 2x)

- [ ] **Task 5 — Fix label autocomplete active** (AC5)
  - [ ] Nel blade `cmp-input-autocomplete`: rimuovere la classe `active` dall'attributo `class` statico del `<label>`
  - [ ] La classe `active` deve essere aggiunta solo via JS/Alpine quando l'input ha focus o valore

- [ ] **Task 6 — Aggiungere edit link card author** (AC6)
  - [ ] Nel blade/JSON della sezione `report-author`: aggiungere `<a class="d-none text-decoration-none">` con `<span class="t-primary text-button-sm-semi">`
  - [ ] Identificare la traduzione corretta per il testo del link: `fixcity::segnalazione.actions.edit.label`

- [ ] **Task 7 — Verifica e report finale** (AC7)
  - [ ] Rieseguire `bashscripts/html/html-structure-compare.sh` sulle due URL
  - [ ] Verificare score ≥98%
  - [ ] Salvare report aggiornato in `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/`

## Dev Notes

### File primari coinvolti

| File | Tipo | Azione |
|------|------|--------|
| `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-02-dati.json` | JSON content | Rimuovere nav-mobile extra, fix tag buttons, fix classi |
| `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` | Blade | Solo se la nav-mobile è nel blade, non nel JSON |
| Views/components per i blocchi della pagina | Blade components | Fix upload Alpine, label active, alert d-none |

### Struttura JSON per trovare i blocchi

Il JSON `tests.segnalazione-02-dati.json` ha struttura:
```json
{
  "it": {
    "content": [
      { "view": "...", "data": {...} },
      ...
    ]
  }
}
```
Cercare il blocco con `view` contenente `page-index-mobile` o simile per il Task 1.

### Script di verifica

```bash
# Da root del progetto
bash bashscripts/html/html-structure-compare.sh \
  "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html" \
  "http://127.0.0.1:8000/it/tests/segnalazione-02-dati" \
  "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati"
```

### Note architetturali

- **`div.tests-view-wrapper`** (gap #1): è un vincolo Livewire/Volt. Non rimuovere — causerebbe `MultipleRootElementsDetectedException`. Questo 1 elemento abbassa la parity di ~0.4%. Accettabile.
- **`<template>` Alpine.js**: i tag `<template>` sono invisibili nel DOM renderizzato ma contano come nodi nel parser HTML. Usare `x-if` riduce questo impatto.
- **Stepper buttons**: il reference usa `<button>` per semantica corretta (azione, non navigazione). Il local usa `<a>` probabilmente per routing Laravel. Se i pulsanti non navigano a URL ma eseguono azioni Alpine/Livewire, usare `<button>` è corretto.

### Guardrail

- ✅ Traduzioni a 5 livelli: `fixcity::segnalazione.<context>.<collection>.<key>.<type>`
- ✅ Zero hardcoded strings in italiano
- ✅ No Bootstrap CSS/JS — solo Bootstrap class names nell'HTML
- ❌ Non toccare `div.tests-view-wrapper` (vincolo Livewire)
- ❌ Non aggiungere nuovi wrapper div
- ❌ Commit solo a task completato

### Story precedenti rilevanti

- `7-3`: CSS fix + i18n + primo 97% HTML parity
- `7-9`: fix generali HTML+visual parity (in-progress)
- `7-20`: fix header responsive (hamburger, slim bar, ITA)

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- Score ottenuto con: `bash bashscripts/html/html-structure-compare.sh` (2026-04-12)
- Report: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report.md`

### Completion Notes List

### File List

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.21 basata su analisi parity score 95.19%. Identifica 12 gap specifici: 6 elementi extra, 4 differenze di classe/tag, 2 elementi mancanti. |
