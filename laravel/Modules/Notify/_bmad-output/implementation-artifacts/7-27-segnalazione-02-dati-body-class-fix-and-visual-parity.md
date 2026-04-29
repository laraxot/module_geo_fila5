# Story 7.27: segnalazione-02-dati - body class fix e visual parity CSS/JS last mile con HTML structure enforcement

Status: ready-for-dev

## Story

Come **responsabile HTML parity del tema Sixteen**,
voglio correggere la struttura del `<body>` tag passando da `<body class="page-tests-segnalazione-02-dati">` a `<body>` puro e lavorare solo su CSS/JS per la visual parity,
cosi da rispettare la HTML parity al 100% con il reference Design Comuni e memorizzare questa regola in tutta la documentazione.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Problema critico identificato

L'utente ha esplicitamente segnalato che:

```html
<!-- SBAGLIATO - corrente -->
<body class="page-tests-segnalazione-02-dati">

<!-- CORRETTO - reference -->
<body>
```

Il reference Design Comuni usa **SOLO** `<body>` senza classi. La pagina locale aggiunge una classe custom che rompe la HTML parity.

### Vincolo non negoziabile - REGOLA FONDAMENTALE

**HTML parity richiede che `<body>` sia ESATTAMENTE `<body>` senza classi custom.**
Tutta la visual parity deve essere ottenuta tramite:
- CSS selettivi (scoped a wrapper o componenti specifici)
- JS / Alpine.js
- comportamento responsive
- screenshot verification

**NON** tramite body classes custom.

### Evidenze HTML structure

Dal body-structure-comparison esistente:

- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/local.html` riga 212: `<body class="page-tests-segnalazione-02-dati">`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/local_raw.html` riga 212: `<body class="page-tests-segnalazione-02-dati">`
- Reference HTML: `<body>` (nessuna classe)

### Pagine affette dallo stesso problema

Le seguenti pagine condividono lo stesso problema (body class custom invece di `<body>` puro):

- segnalazione-02-dati: `page-tests-segnalazione-02-dati`
- segnalazione-01-privacy: `page-tests-segnalazione-01-privacy`
- segnalazione-03-riepilogo: `page-tests-segnalazione-03-riepilogo`
- segnalazione-04-conferma: `page-tests-segnalazione-04-conferma`
- segnalazione-area-personale: `page-tests-segnalazione-area-personale`
- segnalazioni-elenco: `page-tests-segnalazioni-elenco`

### Dove nasce il problema

Il layout `bootstrap-italia.blade.php` usa:
```blade
<body class="@yield('body_class')">
```

Ma nessuna delle pagine tests definisce esplicitamente `@section('body_class')`, quindi la classe viene iniettata da qualche parte nel sistema CMS o nel routing Folio.

### Visual parity issues da correggere (oltre al body class)

Oltre al fix del body class, restano da correggere via CSS/JS:

1. **Hamburger a sinistra del logo** - il menu hamburger deve stare a sinistra del logo
2. **Slogan sotto il logo** - sotto il logo deve esserci lo slogan correttamente impilato
3. **Language selector - una sola freccia** - il selettore lingua deve mostrare una sola freccia/chevron
4. **Lente d'ingrandimento a destra** - il search trigger deve essere posizionato a destra
5. **Altri errori visivi** - audit visuale screenshot-driven per residui

## Acceptance Criteria

1. **Body tag parity**: Il `<body>` tag e esattamente `<body>` senza classi custom (ne `page-tests-*`, ne altre)
2. **HTML parity score**: La pagina mantiene o supera il 99.24% HTML parity (body fix migliora il punteggio)
3. **Visual parity preservata**: Tutte le correzioni visuali sono ottenute tramite CSS/JS, NON body classes
4. **Hamburger positioning**: L'hamburger menu e posizionato a sinistra del logo come nel reference
5. **Brand stack**: Logo, nome e slogan sono impilati correttamente con slogan sotto il nome
6. **Language selector**: Una sola freccia/chevron visibile, nessuna duplicazione iconografica
7. **Search icon placement**: La lente di ricerca e posizionata a destra coerentemente col reference
8. **Cross-breakpoint consistency**: Desktop, tablet e mobile mostrano layout coerenti col reference
9. **Regola documentata ovunque**: La regola "body senza classi custom" e documentata in:
   - Module docs (Modules/*/docs/)
   - Theme docs (Themes/*/docs/)
   - Index files
   - QWEN.md (memories)
   - AGENTS.md (rules)
   - Skills rilevanti
   - Coding standards
10. **Build finale**: Eseguire `npm run build` e `npm run copy` in `laravel/Themes/Sixteen`
11. **Screenshot verification**: Produrre screenshot aggiornati post-fix per desktop/tablet/mobile

## Tasks / Subtasks

### Task 1 - Body class fix (CRITICAL - AC: 1, 2, 9)
- [ ] Identificare dove viene iniettata la classe `page-tests-segnalazione-02-dati` nel body
- [ ] Rimuovere l'iniezione della classe custom dal body
- [ ] Verificare che il body tag sia esattamente `<body>` senza attributi class
- [ ] Verificare che nessuna pagina tests abbia body classes custom
- [ ] Documentare la root cause e il fix

### Task 2 - CSS refactoring per visual parity (AC: 3, 4, 5, 6, 7, 8)
- [ ] Refactoring CSS per usare wrapper/componenti specifici invece del body selector
- [ ] Correggere hamburger positioning via CSS/JS
- [ ] Correggere brand stack (logo + slogan) via CSS
- [ ] Correggere language selector (una sola freccia) via CSS
- [ ] Correggere search icon placement via CSS
- [ ] Verificare cross-breakpoint consistency

### Task 3 - Documentation update (AC: 9)
- [ ] Aggiornare module docs con regola body class
- [ ] Aggiornare theme docs con regola body class
- [ ] Aggiornare coding standards
- [ ] Aggiornare QWEN.md con memory permanente
- [ ] Aggiornare AGENTS.md con regola
- [ ] Aggiornare skills rilevanti (design-comuni, parity, html-audit)
- [ ] Aggiornare indici docs con cross-reference
- [ ] Creare o aggiornare DESIGN_COMUNI_INDEX.md

### Task 4 - Verification e build (AC: 10, 11)
- [ ] Eseguire `npm run build` in `laravel/Themes/Sixteen`
- [ ] Eseguire `npm run copy` in `laravel/Themes/Sixteen`
- [ ] Verificare pagina locale `200` response
- [ ] Produrre screenshot aggiornati desktop/tablet/mobile
- [ ] Verificare HTML parity non regredita

## Dev Notes

### Root cause analysis

La classe body `page-tests-segnalazione-02-dati` probabilmente viene da:
1. Un middleware o page model del modulo Cms che genera body_class dinamicamente
2. Una convenzione di naming basata sullo slug della pagina
3. Possibile configurazione nel Page model `Modules/Cms/Models/Page.php`

### Files da investigare

- `laravel/Modules/Cms/Models/Page.php` - verificare se genera body_class
- `laravel/Themes/Sixteen/resources/views/layouts/bootstrap-italia.blade.php` - layout con `@yield('body_class')`
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` - page template
- Eventuali middleware di routing Folio
- Eventuali componenti Volt che impostano layout data

### Approccio CSS refactoring

Invece di:
```css
body.page-tests-segnalazione-02-dati .header { ... }
```

Usare:
```css
.segnalazione-02-dati-page .header { ... }
/* oppure */
[data-page="segnalazione-02-dati"] .header { ... }
```

O meglio ancora, usare wrapper a livello di componente/page-specific.

### Guardrail

- **MAI** aggiungere classi custom al body per visual parity
- **SEMPRE** usare wrapper o data attributes per scope CSS
- **PRESERVARE** HTML parity esistente
- **DOCUMENTARE** ogni decisione in module e theme docs

### Relazione con story precedenti

- `7-17-segnalazione-02-dati-css-js.md` - CSS parity base
- `7-20-segnalazione-02-dati-header-responsive-refinement.md` - header responsive
- `7-21-segnalazione-02-dati-header-cross-breakpoint-parity.md` - cross-breakpoint
- `7-24-segnalazione-02-dati-html-parity-final-residuals.md` - HTML parity residual
- `7-25-segnalazione-02-dati-visual-parity-css-js-header-and-topbar.md` - visual parity header
- `7-26-segnalazione-02-dati-visual-parity-last-mile.md` - visual parity last mile

Questa story e la correzione definitiva del body class + enforcement della regola.

### References

- [Source: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati/local.html`]
- [Source: `laravel/Themes/Sixteen/resources/views/layouts/bootstrap-italia.blade.php`]
- [Source: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`]
- [Source: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`]

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- Segnalazione utente esplicita: body class sbagliato, deve essere solo `<body>`
- Body structure comparison files mostrano `page-tests-*` classes in 6+ pagine
- Reference HTML usa body senza classi

### Completion Notes List

- Story creata per correggere body class e documentare regola permanentemente
- Inclusi fix visual parity CSS/JS (hamburger, slogan, lingua, search)
- Prevista documentazione completa in module docs, theme docs, QWEN.md, AGENTS.md, skills, indici

### File List

- `_bmad-output/implementation-artifacts/7-27-segnalazione-02-dati-body-class-fix-and-visual-parity.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.27 per correggere body class da `page-tests-segnalazione-02-dati` a `<body>` puro, refactoring CSS/JS per visual parity senza body classes, e documentazione permanente della regola in tutti i docs, rules, memories, skills e indici. |
