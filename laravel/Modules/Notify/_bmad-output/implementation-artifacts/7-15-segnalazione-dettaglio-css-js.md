# Story 7.15: CSS/JS Parity — segnalazione-dettaglio

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-dettaglio`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.5** (HTML Parity — segnalazione-dettaglio). Parity baseline: **45.5%** — richiedere che la story 7.5 porti la parity a ≥80% prima di iniziare questa story.

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-dettaglio.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-dettaglio
- **Report HTML parity**: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-dettaglio/report.md`
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`

## Acceptance Criteria

1. **Prerequisito HTML**: verificare che HTML parity story 7.5 sia ≥80% prima di iniziare
2. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90%)
3. **NO modifica HTML**: struttura HTML/Blade/JSON invariata
4. **Bootstrap class names**: stilizzate con `@apply` Tailwind
5. **Header dettaglio**: titolo, stato segnalazione, metadata (data, categoria, ecc.)
6. **Sezione dettagli**: layout a due colonne o card con informazioni della segnalazione
7. **Status badge**: badge colorato per lo stato (aperta, in lavorazione, chiusa)
8. **Timeline/History**: se presente, stilizzata identicamente al riferimento
9. **Sidebar** (se presente): dati correlati, azioni disponibili
10. **Font e colori AGID**: applicati correttamente
11. **Responsive**: mobile (320px), tablet (768px), desktop (1200px+)
12. **NO Bootstrap CSS/JS**: mai caricare i file Bootstrap Italia
13. **HTML parity mantenuta**: `compare-html.sh` resta ≥80%

## Tasks / Subtasks

- [ ] **PRIMA**: verificare che story 7.5 abbia portato HTML parity a ≥80%
- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: header dettaglio, sezione info, timeline, sidebar, badge stati
- [ ] Aggiornare `bootstrap-italia-classes.css` per componenti specifici della pagina dettaglio
- [ ] Aggiungere stili per status badge (`.badge`, `.chip`, ecc.) con colori AGID
- [ ] Stilizzare timeline se presente nel riferimento
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot iterativamente
- [ ] Verificare responsive
- [ ] Verificare HTML parity mantenuta
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-dettaglio/`

## Dev Notes

### Build Pipeline

```bash
cd /var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen
npm run build
npm run copy
```

### File CSS chiave

| File | Scopo |
|------|-------|
| `resources/css/app.css` | Entry point CSS |
| `resources/css/bootstrap-italia-classes.css` | `@apply` per classi Bootstrap |
| `resources/css/style-apply.css` | Stili aggiuntivi |

### Status Badge Colors (AGID)

```css
.badge-open    { @apply bg-[#007a52] text-white; }   /* aperta */
.badge-wip     { @apply bg-[#f7b800] text-black; }   /* in lavorazione */
.badge-closed  { @apply bg-[#455b71] text-white; }   /* chiusa */
```

### Approccio DaisyUI-style

Bootstrap class names SI nell'HTML come selettori CSS, stilizzati con `@apply` in Tailwind.

### Regole ASSOLUTE

| ❌ VIETATO | ✅ CORRETTO |
|-----------|------------|
| Modificare HTML/Blade/JSON | Solo CSS e JS |
| `<link … bootstrap-italia.min.css>` | MAI |
| `<script … bootstrap-italia.bundle.min.js>` | MAI |
| CDN Bootstrap Italia | MAI |

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
