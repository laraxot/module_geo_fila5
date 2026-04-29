# Story 7.27: rotte `/tests/*` — `<body>` senza classe pagina; parity visiva con scope CSS/JS

Status: ready-for-dev

## Story

Come **chi confronta il DOM con il reference Design Comuni**,
voglio che il markup del **`<body>`** sulle pagine Folio `tests.*` coincida con il reference (**`<body>` minimale**, senza `class="page-tests-…"`) **per l’HTML parity strutturale**,
così che **tipografia, colori e layout** restino raggiungibili tramite **CSS/JS** con selettori sul **contenuto** (wrapper / `data-*` / `:has()`), senza inquinare il tag body rispetto al modello statico.

## Contesto e filosofia

- Il reference [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/sito/) espone un `<body>` **pulito**; un attributo `class` aggiuntivo sul body **differenzia** il tree nel confronto automatico HTML.
- Oggi `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php` applica:
  ```php
  'page-tests-' . (request()->route('slug') ?? '') => $isTestsRoute
  ```
  → es. `class="page-tests-segnalazione-02-dati"`.
- La parity **visiva** non deve dipendere da questa classe sul `<body>`: va spostata su:
  - wrapper Folio `.tests-view-wrapper` con **`data-tests-slug="{{ $slug }}"`** (o equivalente), e/o
  - selettori **`body:has(.tests-view-wrapper[data-tests-slug="…"])`** per interventi che coinvolgono header/footer,
  - oppure scope solo sul **main** se l’override non tocca chrome globale.

## Acceptance Criteria

1. **HTML parity (body)**: per le rotte `tests.*`, il `<body>` nel DOM locale **non** deve contenere la classe `page-tests-{slug}` (né alias equivalente sul solo body), allineabile al reference per il diff strutturale.
2. **Scope parity**: tutte le regole che oggi usano `body.page-tests-{slug}` in `segnalazione-parity.css` (e file parity affini) sono **migrate** a selettori basati su wrapper/`data-tests-slug`/`:has()`, **senza** regressione visiva misurabile (screenshot o checklist).
3. **Rotte tests**: `resources/views/pages/tests/[slug].blade.php` espone `data-tests-slug` (o attributo documentato) sul wrapper della pagina, **stabile** e testabile.
4. **Documentazione**: policy aggiornata in tema e modulo con link incrociati; sprint e story allineati.
5. **Build**: dopo modifiche CSS, `npm run build` nel tema Sixteen e sync asset come da workflow esistente.
6. **Test**: almeno un test (Pest) che verifica assenza della classe `page-tests-` sul body per una GET `/it/tests/segnalazione-02-dati` **oppure** verifica presenza `data-tests-slug` sul wrapper (se il test HTTP non è disponibile in CI, documentare e usare test di contratto sul Blade/layout).

## Tasks / Subtasks

- [ ] Mappare tutti i file CSS/JS che referenziano `body.page-tests-` (grep nel tema Sixteen).
- [ ] Rimuovere o condizionare l’aggiunta della classe `page-tests-*` su `<body>` in `main.blade.php` (o spostare su `<html>` solo se necessario e documentato — **preferenza: no classe sul body**).
- [ ] Aggiungere `data-tests-slug` (o nome concordato) su `.tests-view-wrapper` in `[slug].blade.php` con `$slug` dalla route.
- [ ] Migrare selettori in `segnalazione-parity.css` (priorità: `segnalazione-02-dati`, poi altre pagine tests) verso i nuovi scope.
- [ ] Verificare header/footer: se gli override usavano `body.page-tests-*`, replicare con `:has([data-tests-slug=…])` o classe sul wrapper esterno documentato.
- [ ] `npm run build` + sync `laravel/public/themes/Sixteen/`.
- [ ] Aggiornare/creare test Pest e documentazione indici.

## Dev Notes

### File hot

| Area | Path |
|------|------|
| Layout body | `laravel/Themes/Sixteen/resources/views/components/layouts/main.blade.php` |
| Pagina Folio tests | `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` |
| CSS parity | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` |
| Policy | `laravel/Themes/Sixteen/docs/html-parity-body-policy.md` |

### Riferimenti

- Policy tema: [html-parity-body-policy.md](../../laravel/Themes/Sixteen/docs/html-parity-body-policy.md)
- Wizard Fixcity: [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)

## Dev Agent Record

### Agent Model Used

(da compilare in dev-story)

### Debug Log References

### Completion Notes List

### File List

## Project context reference

- [00-index.md](../../laravel/Themes/Sixteen/docs/00-index.md) — sezione “HTML parity body”

## Story completion status

Story creata con `bmad-create-story` — pronta per `bmad-dev-story`.
