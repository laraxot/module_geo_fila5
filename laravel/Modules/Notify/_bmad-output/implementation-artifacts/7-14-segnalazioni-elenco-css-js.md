# Story 7.14: CSS/JS Parity — segnalazioni-elenco

Status: ready-for-dev

## Story

Come **sviluppatore** che lavora sulla pagina `segnalazioni-elenco`,
voglio raggiungere la **parità visiva** con il riferimento Design Comuni lavorando **SOLO su CSS/JS**,
così che il sito appaia identico al riferimento senza modificare la struttura HTML.

## Prerequisito

HTML parity ≥80% verificata dalla story **7.4** (HTML Parity — segnalazioni-elenco). Parity baseline: **77.8%** — soddisfa il prerequisito ≥80% (dopo miglioramenti della story 7.4 si prevede ≥80%).

## Contesto

- **Riferimento**: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazioni-elenco.html
- **Locale**: http://127.0.0.1:8000/it/tests/segnalazioni-elenco
- **Report HTML parity**: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazioni-elenco/report.md`
- **CSS entry**: `laravel/Themes/Sixteen/resources/css/app.css`
- **Bootstrap classes CSS**: `laravel/Themes/Sixteen/resources/css/bootstrap-italia-classes.css`
- **Build**: `cd laravel/Themes/Sixteen && npm run build && npm run copy`

## Acceptance Criteria

1. **Identità visiva**: screenshot locale vs reference visivamente equivalenti (≥90% match percettivo)
2. **NO modifica HTML**: struttura HTML/Blade/JSON invariata rispetto alla story 7.4
3. **Bootstrap class names in HTML**: stilizzate con `@apply` Tailwind
4. **Hero section**: titolo + metadata con tipografia corretta (40px desktop → 28px mobile)
5. **Tab navigation**: stati active/inactive, indicatore bottom border (#007a52), bg chiaro su active
6. **Sidebar filtri**: checkbox personalizzati, categorie con gerarchia
7. **Grid card segnalazioni**: 1 colonna mobile, 2 tablet, 3 desktop; shadow su hover
8. **CTA section**: pulsante primario in evidenza
9. **Font Titillium Web**: applicato correttamente
10. **Colori AGID**: palette ufficiale applicata tramite variabili CSS
11. **Responsive**: mobile (320px), tablet (768px), desktop (1200px+)
12. **NO Bootstrap CSS/JS**: mai caricare i file Bootstrap Italia
13. **HTML parity mantenuta**: `compare-html.sh` resta ≥80%

## Tasks / Subtasks

- [ ] Eseguire screenshot reference e local per baseline visiva
- [ ] Analizzare differenze: hero, tab nav, sidebar, card grid, CTA, footer contacts
- [ ] Aggiornare `bootstrap-italia-classes.css`:
  - [ ] Hero section: `.it-hero-wrapper`, `.it-hero-text-wrapper`
  - [ ] Tab navigation: `.nav-tabs`, `.nav-link`, `.nav-item`
  - [ ] Sidebar: `.sidebar-wrapper`, `.filter-section`
  - [ ] Cards: `.card`, `.card-wrapper`, `.card-title`, `.card-text`
  - [ ] Accordion: `.accordion`, `.accordion-item`, `.accordion-button`
- [ ] Aggiungere JS Alpine.js per tab switching e accordion toggle
- [ ] Eseguire `npm run build && npm run copy`
- [ ] Confrontare screenshot iterativamente fino a parità visiva
- [ ] Verificare responsive su mobile/tablet/desktop
- [ ] Verificare che HTML parity non sia diminuita
- [ ] Aggiornare screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazioni-elenco/`

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
| `resources/css/style-apply.css` | Stili personalizzati aggiuntivi |

### Design Tokens chiave (dal PRD)

```css
/* Hero */
.it-hero-wrapper { @apply relative overflow-hidden; }
.it-hero-text-wrapper h1 { @apply text-[40px] md:text-[28px] font-bold text-[#191919]; }

/* Tab nav */
.nav-tabs .nav-link.active {
  @apply border-b-2 border-[#007a52] bg-[#e8f5e9];
}

/* Cards grid */
.it-card-list .card {
  @apply bg-[#f5f7f9] rounded-lg border border-[#d9e1e8] shadow-sm hover:shadow-md transition-shadow;
}
```

### JS Alpine.js (tab switching)

```javascript
// Nel componente Alpine, gestire tab switching
x-data="{ activeTab: 'tutte' }"
@click="activeTab = tabId"
:class="{ 'active': activeTab === tabId }"
```

### Approccio DaisyUI-style

Bootstrap class names SI nell'HTML come selettori CSS, stilizzati con `@apply` in Tailwind (come fa DaisyUI).

### Regole ASSOLUTE

| ❌ VIETATO | ✅ CORRETTO |
|-----------|------------|
| Modificare HTML/Blade/JSON | Solo CSS e JS |
| `<link … bootstrap-italia.min.css>` | MAI |
| `<script … bootstrap-italia.bundle.min.js>` | MAI |
| CDN Bootstrap Italia | MAI |

### Variabili colori AGID

```css
--bs-primary: #0066cc;
--bs-success: #007a52;
--bs-danger: #d9364f;
--bs-light: #f5f6f7;
--bs-card-bg: #f5f7f9;
```

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List
