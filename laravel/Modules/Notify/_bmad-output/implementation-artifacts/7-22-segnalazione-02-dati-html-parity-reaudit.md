# Story 7.22: segnalazione-02-dati — HTML parity re-audit

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio riallineare la **HTML parity** della pagina `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` al riferimento ufficiale Design Comuni,
così che la struttura DOM, i wrapper semantici e gli elementi chiave della pagina siano coerenti con `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento ufficiale:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Report HTML più recente:** `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/report_20260412_181446.md`
- **Diff strutturale:** `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/diff_20260412_181446.txt`
- **Blade principale:** `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

## Evidenze raccolte (aggiornate 2026-04-12)

| Metrica | Valore |
|---------|--------|
| Similarità strutturale | **65.1%** |
| Righe struttura reference | 1103 |
| Righe struttura locale | 1154 |
| Righe solo in reference | 368 |
| Righe solo in locale | 419 |
| Blocchi class-based | 4 / 4 (pari) |
| ID semantici mancanti in locale | `#calendario`, `#head-section`, `#rating` |

### Gap strutturali — analisi diff (32 hunks, hunk principale 386 righe)

#### GAP 1 — `tests-view-wrapper` (CRITICO — causa cascata)

```diff
-  <div class="container" id="main-container">       ← reference
+  <div class="tests-view-wrapper">                  ← locale: wrapper extra
+    <div class="container" id="main-container">
```

**Impatto**: tutto il contenuto sotto `<main>` è indentato un livello in più nel locale. Questo genera la quasi totalità delle 419 righe "extra" nel locale. Rimuovere questo wrapper da solo può portare la similarity da 65.1% a ~80-85%.

**File da modificare**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` — verificare se `tests-view-wrapper` è richiesto da Alpine/Volt o è eliminabile.

**Nota**: Precedenti sessioni hanno aggiunto il wrapper per risolvere un `MultipleRootElementsDetectedException` su `@volt`. Se il `@volt` è stato rimosso, il wrapper è eliminabile.

#### GAP 2 — Nav-link `active` su "Servizi"

```diff
-  <a class="nav-link active" href="../sito/servizi.html" data-element="all-services">   ← reference
+  <a class="nav-link" href="/it/tests/servizi" data-element="all-services">             ← locale (manca active)
```

**File**: `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — la logica `active` della top nav deve evidenziare "Servizi" sulle pagine di tipo segnalazione.

#### GAP 3 — Steppers navigation: `<button>` vs `<a>`

```diff
-  <button type="button" class="btn btn-sm steppers-btn-prev p-0">         ← reference
+  <a href=".../segnalazione-01-privacy" class="btn btn-sm steppers-btn-prev p-0">  ← locale

-  <button type="button" class="btn btn-primary btn-sm steppers-btn-confirm">  ← reference
+  <a href=".../segnalazione-03-riepilogo" class="btn btn-primary btn-sm steppers-btn-confirm">  ← locale
```

**Impatto parity**: semanticamente diverso. Il reference usa `<button>` (azione JS), locale usa `<a>` (link). Per parity HTML stretta, usare `<button>` con `x-on:click` o `onclick`.

**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

#### GAP 4 — `alert-message` visibilità iniziale

```diff
-  <div id="alert-message" class="alert alert-success cmp-disclaimer rounded d-none" ...>  ← reference (nascosto)
+  <div id="alert-message" class="alert alert-success cmp-disclaimer rounded" ...>          ← locale (visibile)
```

Il locale non ha `d-none` sull'alert di conferma salvataggio — l'alert appare visibile di default.

**File**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

#### GAP 5 — `steppers-nav` aria-label

```diff
-  <nav class="steppers-nav" aria-label="Step">                           ← reference
+  <nav class="steppers-nav" aria-label="Passi del wizard segnalazione">  ← locale (descrittivo ma diverso)
```

Valore reference: `"Step"`. Locale: `"Passi del wizard segnalazione"`. Il locale è più accessibile ma diverge dalla parity HTML.

#### GAP 6 — `navscroll` aria-label capitalizzazione

```diff
-  <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="INFORMAZIONI RICHIESTE">  ← reference
+  <nav class="navbar it-navscroll-wrapper navbar-expand-lg" aria-label="Informazioni richieste">   ← locale
```

Minore. Il reference usa maiuscole, locale usa normale. Mantenere locale (più leggibile), non è un problema funzionale.

#### GAP 7 — `label-input active` su autocomplete

```diff
-  <label class="label-input d-none mb-2" for="autocomplete-regioni">          ← reference
+  <label class="label-input active d-none mb-2" for="autocomplete-regioni">   ← locale (classe extra)
```

Locale aggiunge classe `active` su una label nascosta — probabilmente residuo di interazione Alpine.

#### GAP 8 — `cmp-page-index-mobile` posizionamento

Il locale include `<nav class="cmp-page-index-mobile d-lg-none" ...>` in posizione diversa rispetto al reference. Strutturalmente presente in entrambi ma con nesting diverso (causato dal GAP 1).

#### Gap NON prioritari (cosmetic/environment)

| Gap | Reference | Locale | Azione |
|-----|-----------|--------|--------|
| Asset paths SVG | `../assets/bootstrap-italia/...` | `/themes/Sixteen/design-comuni/...` | ✅ Accettabile (path diverso per ambiente) |
| href breadcrumb, nav | URL statici reference | URL Laravel locale | ✅ Accettabile |
| `aria-label="breadcrumb"` vs `"Percorso di navigazione"` | breadcrumb | Percorso di navigazione | ✅ Locale migliore |
| `#calendario`, `#head-section`, `#rating` | Presenti nel reference | Assenti locale | ⬜ Non pertinenti a questa pagina |

---

## Acceptance Criteria

1. **Similarity target**: ≥ 80% (preferito ≥ 85%) dopo rimozione/neutralizzazione `tests-view-wrapper`.
2. **`tests-view-wrapper`**: rimosso o reso trasparente (es. `<div class="tests-view-wrapper" style="display:contents">`) se Alpine/Volt lo richiede ancora.
3. **Nav `active`**: il link "Servizi" nella top nav ha classe `active` sulle pagine segnalazione.
4. **Steppers buttons**: `steppers-btn-prev` e `steppers-btn-confirm` sono `<button>` (non `<a>`), con comportamento Alpine per la navigazione.
5. **`alert-message d-none`**: l'alert salvataggio è nascosto di default (`d-none`), visibile solo dopo salvataggio.
6. **`label-input` senza `active`**: la label `autocomplete-regioni` non ha classe `active` se non è stata attivata.
7. **No regression form**: i form `#report-place`, `#report-info`, `#report-author` rimangono funzionali.
8. **No visual regression**: nessuna regressione CSS dopo il cleanup HTML.
9. **Build**: `npm run build && npm run copy` da `laravel/Themes/Sixteen/` senza errori.
10. **Report aggiornato**: rieseguire `bashscripts/html/compare-html.sh` e documentare la nuova similarity.

---

## Tasks / Subtasks

- [ ] **Task 1 — Rimuovi `tests-view-wrapper`** (CRITICO — +~15% similarity stimata)
  - [ ] Verificare se il blade usa `@volt` con blocco singolo o no
  - [ ] Se `@volt` assente: rimuovere `<div class="tests-view-wrapper">` e relativo `</div>`
  - [ ] Se `@volt` presente con root singolo: rimuovere `tests-view-wrapper`, mantieni root esistente
  - [ ] Testare che la pagina carichi correttamente

- [ ] **Task 2 — Fix nav active su "Servizi"**
  - [ ] In `header.blade.php`: aggiungere logica che aggiunge `active` al link `data-element="all-services"` sulle pagine `page-tests-segnalazione-*`
  - [ ] Verificare che non rompa altri contesti

- [ ] **Task 3 — Fix steppers: `<a>` → `<button>` con Alpine**
  - [ ] In `segnalazione-02-dati.blade.php`: sostituire `<a href="...">` su `steppers-btn-prev` e `steppers-btn-confirm` con `<button type="button">` + `x-on:click="window.location.href='...'"` o link `<a>` wrappato

- [ ] **Task 4 — Fix `alert-message d-none`**
  - [ ] Aggiungere `d-none` alla classe iniziale dell'alert `#alert-message`
  - [ ] Verificare che Alpine aggiunga/rimuova `d-none` al click "Salva"

- [ ] **Task 5 — Fix `label-input active`**
  - [ ] Rimuovere classe `active` statica da `label-input d-none mb-2` per `autocomplete-regioni`

- [ ] **Task 6 — Riesegui comparison e verifica target**
  - [ ] `cd /var/www/_bases/base_fixcity_fila5 && bash bashscripts/html/compare-html.sh http://127.0.0.1:8000/it/tests/segnalazione-02-dati https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
  - [ ] Verificare similarity ≥ 80%

- [ ] **Task 7 — Build**
  - [ ] `cd laravel/Themes/Sixteen && npm run build && npm run copy`

---

## Dev Notes

### File primari da modificare

| File | Task |
|------|------|
| `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php` | Task 1, 3, 4, 5 |
| `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` | Task 2 |

### Guardrail

- ❌ Non riscrivere il blade da zero — solo interventi chirurgici
- ❌ Non rimuovere `tests-view-wrapper` senza verificare `@volt` / root singolo
- ✅ La similarity del 65.1% è dominata dal GAP 1 (wrapper extra): risolvere quello prima
- ✅ Testare la pagina dopo ogni task prima di procedere
- ✅ Gli SVG path diversi (ambiente) NON sono da correggere

### Stima impatto per task

| Task | Delta similarity stimata |
|------|--------------------------|
| Task 1 (tests-view-wrapper) | +~15-18% |
| Task 2 (nav active) | +~0.5% |
| Task 3 (buttons vs links) | +~1% |
| Task 4 (alert d-none) | +~0.5% |
| Task 5 (label active) | +~0.3% |
| **Totale stimato** | **~82-85%** |

### Precedenti sessioni correlate

- `_bmad-output/implementation-artifacts/7-9-segnalazione-02-dati-final-html-visual-parity.md` — fix precedenti
- `_bmad-output/implementation-artifacts/7-20-segnalazione-02-dati-header-responsive-refinement.md` — header responsive

### Comando rieseguire comparison

```bash
bash bashscripts/html/compare-html.sh \
  http://127.0.0.1:8000/it/tests/segnalazione-02-dati \
  https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
```

---

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- Diff generato il 2026-04-12 18:14:46: `diff_20260412_181446.txt` (32 hunks, 1102 righe)
- Confronto precedente (2026-04-10): similarity 64.2% → 65.1% attuale

### Completion Notes List

### File List

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-10 | Creata story 7.22 sulla base del re-audit HTML parity (64.2%) |
| 2026-04-12 | Aggiornata con analisi diff fresca (65.1%). Identificati 7 gap specifici con file e righe esatte. Stime impatto per prioritizzazione. |
