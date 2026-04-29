# Story 7.17: CSS/JS Parity — segnalazione-02-dati

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-02-dati`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-9** (HTML Parity — segnalazione-02-dati) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html" "http://127.0.0.1:8000/it/tests/segnalazione-02-dati" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-02-dati
- **Nota**: questa è la pagina **step 2/4** del flusso — inserimento dati segnalazione (form principale)
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-02-dati/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-9 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Stepper visivo**: step 2/4 evidenziato correttamente (step 1 completato, step 2 attivo, 3-4 inattivi)
4. **Form fields**: stile input, label, select, textarea identici al riferimento
5. **Bootstrap class names mantenute**: classi form-group, form-control, ecc. stilate via @apply
6. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
7. **Alpine.js**: validazione form, character counter, condizionali (mostra/nascondi campi)
8. **Bottoni Indietro/Avanti**: stile identico al riferimento
9. **Font Titillium Web**: font corretto
10. **Responsive**: layout 320px / 768px / 1200px+
11. **Nessuna regressione**: altre pagine `tests/*` non degradate

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥ 80%
- [ ] Fare screenshot baseline: riferimento e locale attuale
- [ ] Analizzare differenze visive: stepper, form fields, bottoni, layout
- [ ] Implementare stile stepper (step 2 attivo, step 1 completato con check, 3-4 inattivi)
- [ ] Implementare stile form fields: input, label float, select custom, textarea
- [ ] Implementare stile focus states (outline blu AGID, non `outline: none`)
- [ ] Implementare stile error states (bordo rosso, messaggio errore)
- [ ] Implementare stile bottoni Indietro (secondary) e Avanti (primary)
- [ ] Implementare Alpine.js: validazione, character counter (se presente), campo condizionale
- [ ] Verificare font e tipografia dei campi
- [ ] Verificare palette colori (focus blu #0066cc, errore rosso, success verde)
- [ ] Controllare responsive (form mobile-first)
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
| `outline: none` su focus | Focus visibile (WCAG AA: 4.5:1 contrasto) |

### Form field CSS @apply

```css
/* style-apply.css */
.form-group { @apply mb-6; }
.form-control { @apply w-full border border-gray-300 rounded px-3 py-2 text-base focus:border-blue-600 focus:ring-1 focus:ring-blue-600; }
.form-label { @apply block text-sm font-semibold text-gray-700 mb-1; }
.is-invalid .form-control { @apply border-red-500; }
.invalid-feedback { @apply text-red-600 text-sm mt-1; }
```

### Stepper step 2

```css
.stepper-step.active { @apply font-bold text-blue-700 border-b-2 border-blue-700; }
.stepper-step.completed { @apply text-green-700 after:content-['✓']; }
.stepper-step.pending { @apply text-gray-400; }
```

### Alpine.js form patterns

```javascript
x-data="{ 
  formData: {},
  errors: {},
  validate(field) { /* ... */ }
}"
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
