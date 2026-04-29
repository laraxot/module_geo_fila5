# Story 7.19: CSS/JS Parity — segnalazione-04-conferma

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-04-conferma`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.12** (HTML Parity — segnalazione-04-confirma).

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-04-conferma.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-04-conferma
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- **Nota**: pagina di **conferma finale** — pagina separata con redirect post-submit (non uno step inline del wizard)

## Acceptance Criteria

1. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90%)
2. **NO modifica HTML**: struttura HTML/Blade/JSON invariata
3. **Bootstrap class names**: stilizzate con `@apply` Tailwind
4. **Icona successo**: stilizzata identicamente al riferimento (icona verde, dimensione, posizione)
5. **Titolo conferma**: tipografia corretta (dimensione, colore, peso)
6. **Testo descrittivo**: colore e stile corretti
7. **CTA buttons**: stilizzati con colori AGID, hover state
8. **Font e colori AGID**: applicati correttamente
9. **Responsive**: mobile (320px), tablet (768px), desktop (1200px+)
10. **NO Bootstrap CSS/JS**: mai caricare i file Bootstrap Italia
11. **HTML parity mantenuta**: `compare-html.sh` resta ≥80%

## Tasks / Subtasks

- [ ] Verificare che story 7.12 abbia portato HTML parity a ≥80%
- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: icona successo, titolo, testo, CTA, layout centrato
- [ ] Stilizzare sezione conferma (`.it-hero-wrapper` o equivalente per success page)
- [ ] Stilizzare icona successo (colore #007a52 o verde AGID, dimensione)
- [ ] Stilizzare bottoni CTA (torna alla home, vai alle segnalazioni)
- [ ] Aggiornare `bootstrap-italia-classes.css`
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot iterativamente
- [ ] Verificare responsive
- [ ] Verificare HTML parity mantenuta
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-04-conferma/`

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

### Success Page Pattern

```css
/* Pagina di conferma - messaggio centrato */
.it-success-wrapper {
  @apply text-center py-16;
}
.it-success-icon {
  @apply w-20 h-20 text-[#007a52] mx-auto mb-6;
}
.it-success-title {
  @apply text-[32px] font-bold text-[#191919] mb-4;
}
```

### Pagina separata (non step wizard)

Questa pagina è uno **standalone** — raggiunta via redirect dal controller dopo il submit del form. Non è uno step del wizard inline.

### Regole ASSOLUTE

| ❌ VIETATO | ✅ CORRETTO |
|-----------|------------|
| Modificare HTML/Blade/JSON | Solo CSS e JS |
| `<link … bootstrap-italia.min.css>` | MAI |
| `<script … bootstrap-italia.bundle.min.js>` | MAI |
| Inline wizard confirm step | Pagina separata con redirect |

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
