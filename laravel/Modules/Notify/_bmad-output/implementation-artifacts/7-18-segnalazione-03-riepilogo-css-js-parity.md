# Story 7.18: CSS/JS Parity — segnalazione-03-riepilogo

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-03-riepilogo`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-11** (HTML Parity — segnalazione-03-riepilogo) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-03-riepilogo.html" "http://127.0.0.1:8000/it/tests/segnalazione-03-riepilogo" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-03-riepilogo"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-03-riepilogo.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-03-riepilogo
- **Nota**: questa è la pagina **step 3/4** del flusso — riepilogo dati inseriti prima della conferma finale
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-03-riepilogo/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-11 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Stepper visivo**: step 3/4 evidenziato correttamente (step 1-2 completati, step 3 attivo, step 4 inattivo)
4. **Riepilogo dati (dl/dt/dd)**: stile definition list identico al riferimento
5. **Bottoni Indietro/Conferma**: stile identico al riferimento (secondary + primary CTA)
6. **Bootstrap class names mantenute**: classi stilate via @apply
7. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
8. **Alpine.js**: eventuali interazioni (edit inline, accordion) con Alpine.js
9. **Font Titillium Web**: font corretto
10. **Responsive**: layout 320px / 768px / 1200px+
11. **Nessuna regressione**: altre pagine `tests/*` non degradate

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥ 80%
- [ ] Fare screenshot baseline: riferimento e locale attuale
- [ ] Analizzare differenze visive: stepper, riepilogo dl/dt/dd, bottoni
- [ ] Implementare stile stepper (step 3 attivo, step 1-2 completati con check, step 4 inattivo)
- [ ] Implementare stile riepilogo `<dl>/<dt>/<dd>` (label/valore in griglia)
- [ ] Implementare stile sezione riepilogo (card/box con bordo, sfondo neutro)
- [ ] Implementare stile bottone Indietro (secondary/outline) e Confirma (primary CTA)
- [ ] Verificare font e tipografia
- [ ] Verificare palette colori
- [ ] Controllare responsive
- [ ] `npm run build && npm run copy`
- [ ] Fare screenshot confronto finale
- [ ] Verificare HTML parity non sia scesa

## Dev Notes

### File da modificare (SOLO questi in questa fase)

| Area | Path |
|------|------|
| CSS classi Bootstrap | `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css` |
| CSS @apply | `laravel/Themes/Sixteen/resources/css/style-apply.css` |
| CSS principale | `laravel/Themes/Sixteen/resources/css/app.css` |
| JS Alpine.js | `laravel/Themes/Sixteen/resources/js/app.js` |
| Build + deploy | `cd laravel/Themes/Sixteen && npm run build && npm run copy` |

### ⛔ Regole CRITICHE — errori del passato da NON ripetere

| ❌ SBAGLIATO | ✅ CORRETTO |
|-------------|------------|
| Modificare blade o JSON in questa fase | Solo CSS e JS — HTML congelato |
| `bootstrap-italia.min.css` o CDN | TailwindCSS `@apply` |
| `bootstrap-italia.bundle.min.js` o CDN | Alpine.js |
| Usare `<div>` al posto di `<dl>/<dt>/<dd>` (tocca HTML) | Solo CSS su struttura dl/dt/dd esistente |

### Stile definition list (riepilogo dati)

```css
/* style-apply.css */
.summary-dl { @apply grid grid-cols-3 gap-y-4 bg-gray-50 p-6 rounded border; }
.summary-dt { @apply col-span-1 font-semibold text-gray-600 text-sm; }
.summary-dd { @apply col-span-2 text-gray-900; }
```

### Stepper step 3

```css
.stepper-step.active { @apply font-bold text-blue-700 border-b-2 border-blue-700; }
.stepper-step.completed { @apply text-green-700; }
.stepper-step.pending { @apply text-gray-400; }
```

### Workflow compilazione

```bash
cd laravel/Themes/Sixteen
npm run build
npm run copy
```

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
