# Story 7.18: CSS/JS Parity — segnalazione-03-riepilogo

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-03-riepilogo`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.11** (HTML Parity — segnalazione-03-riepilogo).

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-03-riepilogo.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-03-riepilogo
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- **Nota**: questa è la pagina **step 3** del flusso segnalazione (riepilogo dati prima della conferma)

## Acceptance Criteria

1. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90%)
2. **NO modifica HTML**: struttura HTML/Blade/JSON invariata
3. **Bootstrap class names**: stilizzate con `@apply` Tailwind
4. **Stepper**: step 3 attivo, step 1-2 completati
5. **Riepilogo dati** (`<dl>/<dt>/<dd>`): stilizzato identicamente al riferimento
6. **Sezioni riepilogo**: layout card/list con dati della segnalazione
7. **Bottoni Indietro/Conferma**: stilizzati con colori AGID
8. **Font e colori AGID**: applicati correttamente
9. **Responsive**: mobile (320px), tablet (768px), desktop (1200px+)
10. **NO Bootstrap CSS/JS**: mai caricare i file Bootstrap Italia
11. **HTML parity mantenuta**: `compare-html.sh` resta ≥80%

## Tasks / Subtasks

- [ ] Verificare che story 7.11 abbia portato HTML parity a ≥80%
- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: stepper, riepilogo dati, layout sezioni, bottoni
- [ ] Stilizzare `<dl>/<dt>/<dd>` per il riepilogo dati
- [ ] Stilizzare stepper (step 3 attivo)
- [ ] Stilizzare sezioni card/box del riepilogo
- [ ] Stilizzare bottoni Indietro/Conferma
- [ ] Aggiornare `bootstrap-italia-classes.css`
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot iterativamente
- [ ] Verificare responsive
- [ ] Verificare HTML parity mantenuta
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-03-riepilogo/`

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
| `resources/css/style-apply.css` | Stili personalizzati |

### Definition List Styling

```css
/* Riepilogo dati con dl/dt/dd */
.summary-list dt {
  @apply text-sm font-semibold text-[#455b71] uppercase tracking-wide;
}
.summary-list dd {
  @apply text-base text-[#191919] mb-4;
}
```

### Regole ASSOLUTE

| ❌ VIETATO | ✅ CORRETTO |
|-----------|------------|
| Modificare HTML/Blade/JSON | Solo CSS e JS |
| `<link … bootstrap-italia.min.css>` | MAI |
| `<script … bootstrap-italia.bundle.min.js>` | MAI |

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
