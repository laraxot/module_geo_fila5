# Story 7.15: CSS/JS Parity — segnalazione-dettaglio

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-dettaglio`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-5** (HTML Parity — segnalazione-dettaglio) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-dettaglio.html" "http://127.0.0.1:8000/it/tests/segnalazione-dettaglio" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-dettaglio"`

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-dettaglio.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-dettaglio
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-dettaglio/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-5 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Bootstrap class names mantenute**: classi Bootstrap stilate via @apply
4. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
5. **Alpine.js**: interazioni (gallery, accordion, tabs) implementate con Alpine.js
6. **Font Titillium Web**: font corretto con pesi 400/600/700
7. **Responsive**: layout 320px / 768px / 1200px+
8. **Nessuna regressione**: altre pagine `tests/*` non degradate
9. **Screenshot aggiornati**: in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-dettaglio/`

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥ 80%
- [ ] Fare screenshot baseline: riferimento e locale attuale
- [ ] Analizzare differenze visive: header dettaglio, stato badge, sezione dati, timeline, allegati, commenti
- [ ] Implementare stili per la pagina dettaglio (layout 2 colonne: sidebar + main)
- [ ] Implementare badge stato segnalazione (colori semantici per stato: aperta, in lavorazione, chiusa)
- [ ] Implementare sezione dati (dl/dt/dd grid layout)
- [ ] Implementare timeline degli aggiornamenti
- [ ] Implementare Alpine.js per accordion, gallery
- [ ] Verificare font Titillium Web
- [ ] Verificare palette colori AGID
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
| Rimuovere classi Bootstrap dall'HTML | Mantenerle per parity |

### Componenti chiave di segnalazione-dettaglio

```
- Breadcrumb
- Header dettaglio con badge stato
- Sezione metadati (data, categoria, protocollo)
- Descrizione principale
- Sezione allegati
- Timeline stati/aggiornamenti
- Sidebar info (ufficio responsabile, contatti)
- Sezione commenti/feedback
```

### Badge stati colori semantici

```css
/* Stilare con @apply i badge stato */
.badge-aperta { @apply bg-blue-100 text-blue-800; }
.badge-in-lavorazione { @apply bg-yellow-100 text-yellow-800; }
.badge-chiusa { @apply bg-green-100 text-green-800; }
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
