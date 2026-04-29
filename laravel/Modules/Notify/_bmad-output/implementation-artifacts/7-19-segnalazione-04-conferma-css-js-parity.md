# Story 7.19: CSS/JS Parity — segnalazione-04-conferma

Status: backlog

## Story

Come **sviluppatore** che ha raggiunto ≥80% HTML parity per `segnalazione-04-conferma`,
voglio ottenere la **parità visiva completa** rispetto al riferimento Design Comuni,
lavorando SOLO su CSS/JS senza toccare l'HTML.

## Prerequisiti

- Story **7-12** (HTML Parity — segnalazione-04-conferma) deve essere `done` con parity ≥ 80% (preferibilmente ≥ 90%)
- Verificare con: `./bashscripts/html/compare-html.sh "https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-04-conferma.html" "http://127.0.0.1:8000/it/tests/segnalazione-04-conferma" "laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-04-conferma"`
- **NOTA ARCHITETTURALE**: questa è una **pagina separata** (redirect post-submit), NON uno step inline del wizard

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-04-conferma.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-04-conferma
- **Nota**: pagina di **conferma finale** (step 4/4) — mostra messaggio di successo dopo l'invio della segnalazione
- **CSS/JS location**: `laravel/Themes/Sixteen/resources/`
- **Build**: `npm run build` → `npm run copy` (dalla cartella `laravel/Themes/Sixteen/`)
- **Screenshot output**: `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-04-conferma/`

## Acceptance Criteria

1. **HTML non modificato**: HTML parity dalla story 7-12 rimane ≥ 80% — NESSUNA modifica a blade/JSON
2. **Parità visiva ≥ 90%**: screenshot comparison ≥90% visual parity con il riferimento
3. **Messaggio successo**: icona ✓, titolo, descrizione centrati — layout identico al riferimento
4. **CTA buttons**: stile bottoni "Torna alle segnalazioni" / "Vai alla home" identico al riferimento
5. **Bootstrap class names mantenute**: classi stilate via @apply
6. **TailwindCSS @apply**: stili via `@apply` in `style-apply.css` (mai Bootstrap CSS/JS)
7. **Font Titillium Web**: font corretto
8. **Responsive**: layout 320px / 768px / 1200px+
9. **Nessuna regressione**: altre pagine `tests/*` non degradate

## Tasks / Subtasks

- [ ] Verificare prerequisito: HTML parity ≥ 80%
- [ ] Fare screenshot baseline: riferimento e locale attuale
- [ ] Analizzare differenze visive: messaggio conferma, icona, bottoni CTA
- [ ] Implementare stile messaggio successo (layout centrato, icona verde, dimensioni titolo)
- [ ] Implementare stile icona conferma (cerchio verde con check)
- [ ] Implementare stile bottoni CTA (primary + secondary/outline)
- [ ] Verificare font e tipografia (titolo grande, testo descrittivo)
- [ ] Verificare palette colori (verde successo AGID)
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
| Fare del wizard step 4 un inline step | È una **pagina separata** (redirect) — story 7-12 e questa story lavorano su `/it/tests/segnalazione-04-conferma` |

### Stile messaggio conferma

```css
/* style-apply.css */
.confirm-icon { @apply w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6; }
.confirm-title { @apply text-2xl font-bold text-gray-900 text-center mb-4; }
.confirm-text { @apply text-gray-600 text-center mb-8; }
.confirm-actions { @apply flex flex-col sm:flex-row gap-4 justify-center; }
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
