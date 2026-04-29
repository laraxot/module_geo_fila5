# Story 7.13: CSS/JS Parity — segnalazione-area-personale

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazione-area-personale`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.3** (HTML Parity — segnalazione-area-personale).

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-area-personale.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazione-area-personale
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`

## Acceptance Criteria

1. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90% match percettivo)
2. **NO modifica HTML**: struttura HTML/Blade/JSON invariata rispetto alla story 7.3
3. **Bootstrap class names in HTML**: classi usate come selettori CSS, stilizzate con `@apply` Tailwind
4. **Font Titillium Web**: applicato correttamente come il riferimento
5. **Colori AGID**: palette ufficiale (#007a52, #0066cc, ecc.) applicata tramite variabili CSS
6. **Lista segnalazioni**: card/lista dell'area personale stilizzata identicamente al riferimento
7. **Responsive**: funziona su mobile (320px), tablet (768px), desktop (1200px+)
8. **NO Bootstrap CSS/JS**: mai `bootstrap-italia.min.css` o `bootstrap-italia.bundle.min.js`
9. **HTML parity mantenuta**: `compare-html.sh` resta ≥80% dopo le modifiche CSS/JS

## Tasks / Subtasks

- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: layout area personale, card segnalazioni, header sezione, colori, spaziature
- [ ] Aggiornare `bootstrap-italia-classes.css` con `@apply` per classi specifiche di questa pagina
- [ ] Aggiungere stili per componenti area personale (lista, card, badge stato segnalazione)
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot dopo ogni round di modifiche
- [ ] Verificare responsive su tutti i breakpoint
- [ ] Verificare che HTML parity non sia diminuita (eseguire `compare-html.sh`)
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/`

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
| `resources/css/bootstrap-italia-classes.css` | `@apply` per classi Bootstrap (principale da modificare) |
| `resources/css/style-apply.css` | Stili personalizzati aggiuntivi |

### Approccio DaisyUI-style

Come DaisyUI (https://daisyui.com/docs/install), usiamo Bootstrap class names nell'HTML come selettori, e li stilizziamo con `@apply` in Tailwind:

```css
/* bootstrap-italia-classes.css */
.card {
  @apply bg-white rounded-lg shadow-sm border border-gray-200;
}
.card-title {
  @apply text-lg font-semibold text-gray-900;
}
```

### Regole ASSOLUTE

| ❌ VIETATO | ✅ CORRETTO |
|-----------|------------|
| Modificare HTML/Blade/JSON | Solo CSS e JS |
| `<link … bootstrap-italia.min.css>` | MAI |
| `<script … bootstrap-italia.bundle.min.js>` | MAI |
| CDN Bootstrap Italia | MAI |
| Colori hardcoded nel CSS | Usare `var(--bs-primary)` o variabili CSS del tema |
| Bootstrap CSS caricato | TailwindCSS @apply |

### Variabili colori AGID

```css
--bs-primary: #0066cc;
--bs-primary-dark: #0059b3;
--bs-success: #007a52;
--bs-danger: #d9364f;
--bs-warning: #f7b800;
--bs-light: #f5f6f7;
```

### Font

Il font Titillium Web è già configurato nel tema. Verificare che sia correttamente applicato ai titoli e al body.

### Screenshots

Salvare screenshot confronto in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-area-personale/` con nomi `local-full.png` e `local-viewport.png`.

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
