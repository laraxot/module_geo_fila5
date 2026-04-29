# Story 7.16: CSS/JS Parity — segnalazione-01-privacy

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-01-privacy`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.6** (HTML Parity — segnalazione-01-privacy).

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-01-privacy
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`
- **Nota**: questa è la pagina **step 1** del flusso segnalazione (privacy + accettazione)

## Acceptance Criteria

1. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90%)
2. **NO modifica HTML**: struttura HTML/Blade/JSON invariata
3. **Bootstrap class names**: stilizzate con `@apply` Tailwind
4. **Stepper di navigazione**: stilizzato identicamente al riferimento (indicatore step 1/N)
5. **Form privacy**: layout e stile del testo informativa privacy
6. **Checkbox accettazione**: styled custom (non default browser), identico al riferimento
7. **Bottone "Avanti"**: stilizzato con colori AGID, hover state, disabled state
8. **Font e colori AGID**: applicati correttamente
9. **Responsive**: mobile (320px), tablet (768px), desktop (1200px+)
10. **NO Bootstrap CSS/JS**: mai caricare i file Bootstrap Italia
11. **HTML parity mantenuta**: `compare-html.sh` resta ≥80%

## Tasks / Subtasks

- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: stepper, testo privacy, checkbox, bottone
- [ ] Stilizzare stepper multi-step (`.stepper`, `.it-stepper`, o classi analoghe)
- [ ] Stilizzare checkbox accettazione (`input[type=checkbox]` custom con `@apply`)
- [ ] Stilizzare bottone Avanti (`.btn-primary` con colori AGID)
- [ ] Aggiornare `bootstrap-italia-classes.css`
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot iterativamente
- [ ] Verificare responsive
- [ ] Verificare HTML parity mantenuta
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-01-privacy/`

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

### Custom Checkbox (DaisyUI-style)

```css
/* Checkbox custom styled senza Bootstrap */
.form-check-input {
  @apply w-5 h-5 rounded border-2 border-[#0066cc] cursor-pointer
         checked:bg-[#0066cc] checked:border-[#0066cc]
         focus:ring-2 focus:ring-[#0066cc] focus:ring-offset-1;
}
```

### Stepper

```css
.it-stepper .step-item {
  @apply flex items-center gap-2;
}
.it-stepper .step-item.active .step-number {
  @apply bg-[#0066cc] text-white;
}
.it-stepper .step-item.completed .step-number {
  @apply bg-[#007a52] text-white;
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
