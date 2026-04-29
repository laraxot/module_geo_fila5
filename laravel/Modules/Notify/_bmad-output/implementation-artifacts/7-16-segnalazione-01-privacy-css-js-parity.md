# Story 7.16: CSS/JS Parity — segnalazione-01-privacy

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-01-privacy`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-6** (HTML Parity — segnalazione-01-privacy) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html" "http://127.0.0.1:8000/it/tests/segnalazione-01-privacy" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-01-privacy"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-01-privacy
- **Nota**: questa è la pagina **step 1/4** del flusso segnalazione — informativa privacy con checkbox consenso
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-01-privacy/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-6 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Stepper visivo**: step 1/4 evidenziato correttamente nello stepper di navigazione
4. **Checkbox consenso**: stile custom checkbox identico al riferimento (check verde AGID)
5. **Bottone Avanti**: stile, colore, hover identici al riferimento
6. **Bootstrap class names mantenute**: classi stilate via @apply
7. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
8. **Alpine.js**: validazione checkbox (abilita/disabilita bottone "Avanti")
9. **Font Titillium Web**: font corretto
10. **Responsive**: layout 320px / 768px / 1200px+
11. **Nessuna regressione**: altre pagine `tests/*` non degradate

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥ 80%
- [ ] Fare screenshot baseline: riferimento e locale attuale
- [ ] Analizzare differenze visive: stepper, testo privacy, checkbox, bottone Avanti
- [ ] Implementare stili stepper wizard (step 1 attivo, step 2-4 inattivi)
- [ ] Implementare stile checkbox consenso (custom checkbox verde AGID)
- [ ] Implementare stile bottone Avanti (primario, disabled state, hover)
- [ ] Implementare Alpine.js: abilitare "Avanti" solo quando checkbox è spuntata
- [ ] Verificare tipografia del testo privacy (dimensioni, peso, line-height)
- [ ] Verificare font Titillium Web
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
| `<x-layouts.design-comuni>` | `<x-layouts.app>` |
| Creare `pages/tests/segnalazione-01-privacy.blade.php` | SOLO `pages/tests/[slug].blade.php` |

### Stepper wizard CSS

```css
/* Stepper: step 1 di 4 */
.stepper-step.active { @apply font-bold text-blue-700 border-b-2 border-blue-700; }
.stepper-step.completed { @apply text-green-700; }
.stepper-step.pending { @apply text-gray-400; }
```

### Alpine.js: abilita bottone Avanti

```javascript
// x-data sul form
x-data="{ privacyAccepted: false }"

// checkbox
x-model="privacyAccepted"

// bottone Avanti
:disabled="!privacyAccepted"
:class="{ 'opacity-50 cursor-not-allowed': !privacyAccepted }"
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
