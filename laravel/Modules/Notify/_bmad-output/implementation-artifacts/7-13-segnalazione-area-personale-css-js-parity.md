# Story 7.13: CSS/JS Parity — segnalazione-area-personale

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-area-personale`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-3** (HTML Parity — segnalazione-area-personale) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-area-personale.html" "http://127.0.0.1:8000/it/tests/segnalazione-area-personale" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-area-personale"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-area-personale.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-area-personale
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-3 rimane ≥ 80% — NESSUNA modifica a blade/JSON in questa story
2. **Parità visiva ≥ 90%**: screenshot comparison mostra ≥90% di visual parity con il riferimento
3. **Bootstrap class names mantenute**: le classi Bootstrap nell'HTML (row, col-12, btn, card, ecc.) continuano a esistere e vengono stilate via @apply
4. **TailwindCSS @apply**: tutti gli stili applicati tramite `@apply` in `style-apply.css` (mai caricare Bootstrap CSS/JS)
5. **Alpine.js interactions**: tutti i comportamenti JS implementati con Alpine.js (nessun file Bootstrap JS)
6. **Font Titillium Web**: font caricato e applicato correttamente con i pesi giusti
7. **Responsive corretto**: layout funziona a 320px (mobile), 768px (tablet), 1200px+ (desktop)
8. **Nessuna regressione**: le altre pagine `tests/*` non sono degradate visivamente
9. **Screenshot aggiornati**: salvati in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/`

## Tasks / Subtasks

- [ ] Verificare prerequisito: eseguire script confronto HTML e confermare parity ≥ 80%
- [ ] Fare screenshot del riferimento (fullpage + viewport) per baseline visiva
- [ ] Fare screenshot del locale attuale per confronto iniziale
- [ ] Analizzare differenze: layout, colori, tipografia, spaziatura, icone
- [ ] Identificare classi Bootstrap usate nel riferimento che mancano di stile
- [ ] Implementare `@apply` per le classi mancanti in `style-apply.css`
- [ ] Verificare font Titillium Web (famiglia, pesi 400/600/700, line-height)
- [ ] Verificare palette colori (verde AGID #007a52, blu #0066cc, neutral tones)
- [ ] Controllare layout responsive (320px, 768px, 1200px)
- [ ] Verificare stati interattivi (hover, focus, active) con Alpine.js
- [ ] `npm run build && npm run copy` per pubblicare CSS/JS
- [ ] Fare screenshot confronto finale (fullpage + viewport)
- [ ] Verificare che HTML parity non sia scesa (rieseguire script confronto)
- [ ] Aggiornare `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/`

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
| Modificare blade o JSON in questa fase | Solo CSS e JS — HTML è congelato |
| Caricare `bootstrap-italia.min.css` (file o CDN) | TailwindCSS `@apply` in `style-apply.css` |
| Caricare `bootstrap-italia.bundle.min.js` (file o CDN) | Alpine.js |
| Rimuovere classi Bootstrap dall'HTML | Mantenerle — servono per HTML parity |
| Usare CDN Bootstrap: `cdn.jsdelivr.net/npm/bootstrap-italia` | MAI CDN Bootstrap |
| Hardcode colori hex nel CSS senza design token | Usare variabili CSS/design tokens |

### Pattern @apply per Bootstrap classes (stile DaisyUI)

```css
/* style-apply.css */
.row { @apply flex flex-wrap; }
.col-12 { @apply w-full; }
.col-md-8 { @apply md:w-2/3; }
.col-md-4 { @apply md:w-1/3; }
.card { @apply bg-white rounded shadow-sm border border-gray-200; }
.btn { @apply inline-flex items-center justify-center px-4 py-2 rounded font-semibold; }
.btn-primary { @apply bg-blue-600 text-white hover:bg-blue-700; }
```

### Font Titillium Web

```css
/* Verificare in app.css o layout */
font-family: 'Titillium Web', sans-serif;
/* Pesi usati nel riferimento: 400 (regular), 600 (semibold), 700 (bold) */
```

### Screenshot workflow

```bash
# Fare screenshot con playwright o browser DevTools
# Salvare in:
laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/local-full.png
laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/local-viewport.png
```

### Workflow compilazione

```bash
cd laravel/Themes/Sixteen
npm run build   # compila CSS/JS con Vite
npm run copy    # copia nell'public del Laravel
```

### bashscripts è agnostico

Lo script `bashscripts/html/compare-html.sh` non conosce il progetto. L'output va in `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-area-personale/`.

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
