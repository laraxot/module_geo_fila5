# Story 7.29: segnalazione-crea - stepper responsive, hamburger, search, language selector fixes

Status: ready-for-dev

## Story

Come **sviluppatore del tema Sixteen**,
voglio correggere header e stepper di `segnalazione-crea` per allinearli al reference Design Comuni,
cosi da garantire parity visiva, responsive e funzionale su tutti i breakpoint, con disciplina esplicita su token-efficiency, indici e anti-duplicazione documentale.

## Contesto

### Sorgenti confrontate

- Locale (segnalazione-crea): `http://127.0.0.1:8000/it/tests/segnalazione-crea`
- Reference esterno: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`

### Problemi segnalati dall'utente

1. **Stepper non responsive**: Lo stepper di `segnalazione-crea` non e responsive come quello del reference
2. **Hamburger allineato in alto**: L'hamburger menu (`custom-navbar-toggler`) e allineato in alto invece che centrato verticalmente nel navbar
3. **Scritta "Cerca" non visibile**: Il testo "Cerca" non appare a fianco della lente di ingrandimento (presente in HTML ma nascosto da CSS)
4. **Selezione lingue non funziona**: Il dropdown delle lingue non si apre correttamente
5. **Icona lingua sfondo diverso**: L'icona a destra del language selector ha uno sfondo/colore diverso dal reference
6. **Molti altri errori**: Audit visuale richiesto per identificare discrepanze aggiuntive

### Analisi tecnica dettagliata

#### 1. Stepper non responsive

Il stepper HTML e strutturalmente corretto:
```html
<div class="steppers">
    <div class="steppers-header">
        <ul>
            <li class="active">Informativa sulla privacy</li>
            <li class="">Dati di segnalazione</li>
            <li class="">Riepilogo</li>
        </ul>
        <span class="steppers-index">1/3</span>
    </div>
</div>
```

Ma il CSS mobile-first aggiunto per `segnalazione-02-dati` (story 7.28) in `segnalazione-parity.css` usa selettori scoped a `.tests-view-wrapper` che potrebbero non applicarsi a `segnalazione-crea` se il wrapper e diverso.

**Fix**: Estendere i selettori mobile-first per coprire anche `segnalazione-crea`.

#### 2. Hamburger allineato in alto

HTML corrente:
```html
<button class="custom-navbar-toggler" type="button" ...>
    <svg class="icon"><use href="...#it-burger"></use></svg>
</button>
```

Il bottone `.custom-navbar-toggler` non ha `align-items: center` nel container `.navbar`. Nel reference Bootstrap Italia il navbar ha `align-items: center` per centrare verticalmente il toggle.

**Fix**: Aggiungere al CSS:
```css
.navbar .custom-navbar-toggler {
    align-self: center;
    display: flex;
    align-items: center;
}
```

#### 3. Scritta "Cerca" non visibile

HTML presente e corretto:
```html
<div class="it-search-wrapper d-flex align-items-center">
    <span class="search-label me-2">Cerca</span>
    <button class="search-link rounded-icon" ...>...</button>
</div>
```

Il testo "Cerca" c'e nell'HTML ma e probabilmente nascosto da:
- `display: none` su `.search-label` in alcuni breakpoint
- Colore del testo uguale allo sfondo
- Overflow nascosto

**Fix**: Verificare e correggere il CSS di `.search-label`.

#### 4. Language selector non funziona

HTML:
```html
<button type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" ...>
```

Usa `data-bs-toggle="dropdown"` di Bootstrap Italia. Se Bootstrap JS non e caricato nel frontoffice, il dropdown non funziona.

**Fix**: Se Bootstrap JS non e disponibile, sostituire con Alpine.js:
```html
<button type="button" class="nav-link dropdown-toggle" @click="langOpen = !langOpen" ...>
<div class="dropdown-menu" x-show="langOpen" ...>
```

#### 5. Icona lingua sfondo diverso

L'icona `<svg class="icon"><use href="...#it-expand"></use></svg>` potrebbe avere:
- `background-color` diverso
- `color` diverso
- Padding/margin che creano un effetto visivo diverso

**Fix**: Allineare CSS dell'icona al reference.

### Vincoli non negoziabili

1. **Body tag puro**: `<body>` senza classi o ID — gia verificato OK
2. **Mobile first**: CSS mobile-first (base 375px → tablet 768px → desktop 1024px)
3. **Multilingua**: Zero hardcoded Italian — tutto con `__('fixcity::segnalazione.*')` 5 livelli
4. **HTML parity**: Mantenere struttura HTML identica al reference
5. **Screenshot verification**: Verifica a 375px, 768px, 1280px

### Componenti coinvolti

- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` — header condiviso
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` — CSS parity
- `laravel/Themes/Sixteen/resources/css/design-comuni-global.css` — CSS globali
- `laravel/Themes/Sixteen/resources/css/design-comuni-global-fixes.css` — fix globali
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` — page template

## Acceptance Criteria

1. **Stepper responsive**: Su 375px lo stepper e compatto e leggibile, su 768px e 1024px scala correttamente
2. **Hamburger centrato**: L'hamburger e allineato verticalmente al centro del navbar
3. **Search visibile**: "Cerca" appare a fianco dell'icona lente su tutti i breakpoint
4. **Language selector funzionante**: Il dropdown si apre e le opzioni sono selezionabili
5. **Icona lingua coerente**: L'icona ha lo stesso stile/colore del reference
6. **Zero regressioni**: Tutte le altre pagine tests (segnalazione-01-privacy, 02-dati, ecc.) continuano a funzionare
7. **Build finale**: `npm run build` + `npm run copy` senza errori
8. **Screenshot verification**: Screenshot post-fix per 375px, 768px, 1280px
9. **Documentazione aggiornata**: Module docs, theme docs, QWEN.md, indici con bidirectional links
10. **Token-efficiency documentata**: l'implementazione riusa indici canonici, evita letture massive inutili e aggiorna eventuali rules/skills/memories toccati per ridurre contesto e duplicati nei pass successivi

## Tasks / Subtasks

### Task 1 - Stepper responsive per segnalazione-crea (AC: 1)
- [ ] Verificare se il CSS mobile-first di story 7.28 copre segnalazione-crea
- [ ] Se necessario, estendere selettori da `.tests-view-wrapper` a includere anche segnalazione-crea
- [ ] Aggiungere CSS specifico se la struttura wrapper e diversa
- [ ] Verificare breakpoint 375/768/1024

### Task 2 - Hamburger vertical centering (AC: 2)
- [ ] Aggiungere CSS per centrare verticalmente `.custom-navbar-toggler`
- [ ] Verificare che non rompa altre pagine
- [ ] Testare su mobile/tablet/desktop

### Task 3 - Search label visibility (AC: 3)
- [ ] Identificare perche `.search-label` non e visibile
- [ ] Correggere CSS (display, color, visibility)
- [ ] Verificare su tutti i breakpoint

### Task 4 - Language selector fix (AC: 4)
- [ ] Verificare se Bootstrap JS e caricato nel frontoffice
- [ ] Se no, implementare dropdown con Alpine.js
- [ ] Se Bootstrap JS e caricato, debuggare perche non funziona
- [ ] Testare apertura/chiusura dropdown

### Task 5 - Language icon style fix (AC: 5)
- [ ] Confrontare CSS dell'icona expand tra locale e reference
- [ ] Correggere background-color, color, padding
- [ ] Verificare parity visiva

### Task 6 - Audit visuale aggiuntivo (AC: 6)
- [ ] Confrontare screenshot locale vs reference desktop/tablet/mobile
- [ ] Identificare e correggere ulteriori discrepanze visive
- [ ] Documentare i fix

### Task 7 - Build e verifica (AC: 7, 8, 9)
- [ ] `npm run build` + `npm run copy`
- [ ] Verificare `200` response su tutte le pagine tests
- [ ] Screenshot mobile/tablet/desktop
- [ ] Aggiornare documentazione con bidirectional links

### Task 8 - Token-efficiency e knowledge hygiene (AC: 9, 10)
- [ ] Riutilizzare gli indici canonici prima di aprire file lunghi o duplicati
- [ ] Se utile, aggiornare docs/rules/skills/memories con summary piu rapidi da consultare
- [ ] Se viene configurato tooling aggiuntivo, documentarlo in un indice canonico

## Dev Notes

### Header shared component

L'header (`header.blade.php`) e condiviso tra TUTTE le pagine tests. Qualsiasi modifica all'header impattera:
- segnalazione-crea
- segnalazione-01-privacy
- segnalazione-02-dati
- segnalazione-03-riepilogo
- segnalazione-04-conferma
- segnalazioni-elenco
- segnalazione-dettaglio
- segnalazione-area-personale

**IMPORTANTE**: Testare TUTTE le pagine dopo le modifiche all'header.

### CSS scoping

Per evitare regressioni, preferire selettori specifici:
```css
/* Fix globale se il problema e su tutte le pagine */
.it-header-navbar-wrapper .custom-navbar-toggler {
    align-self: center;
}

/* Fix specifico se necessario */
.page-segnalazione-crea .steppers { ... }
```

### Bootstrap JS availability

Verificare se Bootstrap JS e incluso nel layout frontoffice:
```blade
{{-- In layouts/bootstrap-italia.blade.php o simile --}}
@vite(['resources/js/app.js']) {{-- Contiene Bootstrap JS? --}}
```

Se non e incluso, usare Alpine.js per il dropdown lingue.

### Relazione con story precedenti

- `7-28-segnalazione-02-dati-stepper-responsive-multilingual.md` — Stepper mobile-first CSS (riutilizzare pattern)
- `7-27-segnalazione-02-dati-body-class-fix-and-visual-parity.md` — Body class fix
- `7-25-segnalazione-02-dati-visual-parity-css-js-header-and-topbar.md` — Header visual parity

Questa story estende il lavoro alle altre pagine segnalaizone con focus su header issues.

### References

- [Source: `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`]
- [Source: `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`]
- [Source: `laravel/Themes/Sixteen/resources/css/design-comuni-global.css`]
- [Source: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`]
- [Source: `laravel/Themes/Sixteen/docs/STEPPER_MOBILE_FIRST_RULE.md`]
- [Source: `laravel/Themes/Sixteen/docs/BODY_CLASS_RULE.md`]

## Dev Agent Record

### Agent Model Used

qwen-code (Qwen Code CLI)

### Debug Log References

- Analisi utente: stepper non responsive, hamburger allineato in alto, cerca mancante, language selector non funziona, icona colore sbagliato
- HTML verificato: stepper struttura corretta, search-label presente in HTML, hamburger usa `custom-navbar-toggler`
- Language selector usa `data-bs-toggle="dropdown"` (Bootstrap JS)

### Completion Notes List

- Story 7.29 creata per fix header/stepper di segnalazione-crea
- 7 issues identificate con analisi tecnica dettagliata
- Previsto aggiornamento documentazione con bidirectional links

### File List

- `_bmad-output/implementation-artifacts/7-29-segnalazione-crea-header-stepper-responsive-multilingual.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-13 | Aggiunti guardrail espliciti su token-efficiency, riuso di indici canonici e prevenzione duplicati documentali. |

## Riferimenti Esterni Verificati

- OpenAI Prompt Caching: `https://platform.openai.com/docs/guides/prompt-caching`
- OpenAI Responses guide: `https://platform.openai.com/docs/guides/text?api-mode=responses`
- BMAD Method repository: `https://github.com/bmad-code-org/BMAD-METHOD`
| 2026-04-12 | Creata story 7.29 per fix: stepper responsive, hamburger vertical center, search label visibility, language selector dropdown, language icon style, audit visuale aggiuntivo. |
