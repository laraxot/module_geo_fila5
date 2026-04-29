# Story 7.14: CSS/JS Parity — segnalazioni-elenco

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazioni-elenco`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-4** (HTML Parity — segnalazioni-elenco) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html" "http://127.0.0.1:8000/it/tests/segnalazioni-elenco" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazioni-elenco
- **Parity HTML attuale**: 77.8% (603/775 elementi) — da aggiornare dopo story 7-4
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazioni-elenco/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-4 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Bootstrap class names mantenute**: classi (row, col-12, btn, card, tab-list, ecc.) stilate via @apply
4. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
5. **Alpine.js**: tab switching, accordion, filtri checkbox implementati con Alpine.js
6. **Font Titillium Web**: font corretto con pesi 400/600/700
7. **Responsive**: layout 320px / 768px / 1200px+
8. **Nessuna regressione**: altre pagine `tests/*` non degradate
9. **Screenshot aggiornati**: in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazioni-elenco/`

## Tasks / Subtasks

- [ ] Verificare prerequisito: parity HTML ≥ 80% (rieseguire script se necessario)
- [ ] Fare screenshot baseline: riferimento (fullpage + viewport) e locale attuale
- [ ] Analizzare differenze visive: hero section, tab navigation, sidebar filtri, cards grid, CTA section
- [ ] Implementare stili hero section (background, overlay, tipografia 40px desktop / 28px mobile)
- [ ] Implementare tab navigation con stati active/inactive e transizioni
- [ ] Implementare sidebar filtri (checkbox, categorie, gerarchia)
- [ ] Implementare cards grid (shadow, hover, transizioni, responsive 1/2/3 colonne)
- [ ] Implementare CTA section e contacts section
- [ ] Implementare Alpine.js: tab switching (Arrow keys + Enter), accordion toggle, checkbox filtri
- [ ] Verificare font Titillium Web (pesi, dimensioni, line-height)
- [ ] Verificare palette colori AGID (verde #007a52, blu #0066cc)
- [ ] Controllare responsive (320px, 768px, 1200px)
- [ ] `npm run build && npm run copy`
- [ ] Fare screenshot confronto finale
- [ ] Verificare HTML parity non sia scesa (rieseguire script)

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
| Rimuovere classi Bootstrap dall'HTML | Mantenerle per parity |
| NO Bootstrap class names | ✅ Bootstrap class names SI nell'HTML, CSS Bootstrap NO |

### Componenti chiave di segnalazioni-elenco

```
- Hero section: titolo pagina + descrizione + metadati
- Tab navigation: "Tutte le segnalazioni" / "Le mie segnalazioni"
- Sidebar filtri: checkbox categorie con gerarchia
- Cards grid: elenco segnalazioni responsive (1/2/3 col)
- Accordion dentro le cards
- CTA section + Contacts section
```

### Alpine.js patterns da implementare

```javascript
// Tab switching
x-data="{ activeTab: 'all' }"
@click="activeTab = 'mine'"

// Accordion
x-data="{ open: false }"
@click="open = !open"
x-show="open" x-transition

// Filtri checkbox
x-data="{ filters: [] }"
@change="toggleFilter($event.target.value)"
```

### Pattern @apply (stile DaisyUI)

```css
/* style-apply.css */
.tab-list { @apply flex border-b border-gray-200; }
.tab-item { @apply px-6 py-3 font-semibold cursor-pointer; }
.tab-item.active { @apply border-b-2 border-green-700 text-green-700 bg-green-50; }
.card { @apply bg-white rounded border border-gray-200 shadow-sm hover:shadow-md transition-shadow; }
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
