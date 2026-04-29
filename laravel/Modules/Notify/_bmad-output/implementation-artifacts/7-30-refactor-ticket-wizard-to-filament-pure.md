# Story 7.30: Refactor segnalazione-crea wizard a Filament Wizard + Widget way con HTML/Visual parity

Status: ready-for-dev

## Story

Come **sviluppatore frontoffice del tema Sixteen**,
voglio rifare il wizard di `segnalazione-crea` usando ESCLUSIVAMENTE Filament v5 Wizards (`Wizard::make([...])` con `Step::make(...)`) e Filament Widgets (`XotBaseWizardWidget`),
cosi da eliminare HTML hardcoded, seguire la "Filament way" e ottenere HTML/visual parity con il reference Design Comuni.

## Contesto

### Sorgenti confrontate

- Locale (segnalazione-crea): `http://127.0.0.1:8000/it/tests/segnalazione-crea`
- Reference (segnalazione-01-privacy): `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`

### Stato attuale del widget

**Classe PHP (`CreateTicketWizardWidget.php`)**:
- ✅ Gia estende `XotBaseWizardWidget` (NON `XotBaseWidget`)
- ✅ Gia usa `Wizard::make([...])` con `Step::make(...)` — Filament way corretto
- ✅ 3 step definiti: Privacy, Dati, Riepilogo
- ✅ Traduzioni tramite `__('fixcity::segnalazione.*')`

**Blade view (`ticket-create-wizard.blade.php`)**:
- ❌ Contiene HTML Design Comuni hardcoded:
  - Wrapper `container`, `cmp-heading`, `ticket-wizard-root`
  - Sezione contatti `bg-grey-card shadow-contacts`
  - Form wrapping `<x-filament-widgets::widget>`
- ❌ Non segue il pattern Filament Widget minimale

### Cosa chiede l'utente

1. **Filament Wizards**: Usare `Wizard::make([...])` + `Step::make([...])` — GIA fatto in PHP ✅
2. **Filament Widgets**: Estendere `XotBaseWizardWidget` — GIA fatto in PHP ✅
3. **HTML parity**: Allineare struttura HTML al reference Design Comuni
4. **Visual parity**: Allineare resa visiva al reference

### Problema da risolvere

Il widget PHP e corretto. Il problema e la **blade view** che ha troppo HTML hardcoded invece di affidarsi a Filament per il rendering.

Target blade view:
```blade
<div class="ticket-wizard-root">
    <form wire:submit="submit">
        {{ $this->form }}
    </form>
    <x-filament-actions::modals />
</div>
```

Tutto il Design Comuni (titolo, stepper, contatti) deve essere gestito via:
1. **Filament Section/Placeholder** nello schema PHP per contenuto strutturato
2. **CSS scoped** a `.ticket-wizard-root` per styling Design Comuni
3. **NO HTML blade hardcoded**

### Reference Filament

- Wizards: https://filamentphp.com/docs/5.x/schemas/wizards
- Widgets: https://filamentphp.com/docs/5.x/widgets/overview

### File coinvolti

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` — wizard PHP (già corretto nella struttura)
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` — blade view (DA SEMPLIFICARE)
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` — CSS parity esistente
- `laravel/Themes/Sixteen/resources/css/ticket-wizard-filament.css` — NUOVO CSS scoped per wizard styling

## Acceptance Criteria

1. **Wizard 100% Filament**: Tutti gli step definiti con `Wizard::make([...])` + `Step::make([...])` in PHP
2. **Widget estende XotBaseWizardWidget**: Confermato (gia corretto)
3. **Blade minimale**: La blade contiene SOLO wrapper minimale + `{{ $this->form }}` + `<form wire:submit="submit">` + modals
4. **HTML parity**: La struttura HTML del wizard (stepper, campi, bottoni) matcha il reference Design Comuni
5. **Visual parity**: La resa visiva e allineata al reference su desktop/tablet/mobile
6. **Funzionalita preservata**: Privacy checkbox, form fields, file upload, submit, redirect funzionano come prima
7. **Zero regressioni**: La pagina `/it/tests/segnalazione-crea` continua a funzionare (HTTP 200)
8. **Build finale**: `npm run build` + `npm run copy` senza errori
9. **Documentazione aggiornata**: Module docs, theme docs, QWEN.md con bidirectional links

## Tasks / Subtasks

### Task 1 - Semplificare blade a Filament-only (AC: 3)
- [ ] Rimuovere TUTTO l'HTML hardcoded da `ticket-create-wizard.blade.php`
- [ ] Mantenere SOLO: `<div class="ticket-wizard-root">` + `<form wire:submit="submit">` + `{{ $this->form }}` + `<x-filament-actions::modals />`
- [ ] Rimuovere sezione contatti hardcoded dalla blade

### Task 2 - Estendere wizard Filament con Design Comuni (AC: 1, 2, 4)
- [ ] Verificare che `Wizard::make([...])` contenga tutti e 3 gli step corretti
- [ ] Verificare che ogni `Step::make(...)` abbia i componenti Filament corretti
- [ ] Aggiungere `Section::make()` o `Placeholder::make()` per titolo pagina se necessario
- [ ] Verificare che la chiave dello schema matchi `getWizardSchemaWrapperKey()` (default `'wizard'`)
- [ ] Tutte le traduzioni tramite `__('fixcity::segnalazione.*')`

### Task 3 - CSS scoped per Design Comuni styling (AC: 5)
- [ ] Creare `laravel/Themes/Sixteen/resources/css/ticket-wizard-filament.css`
- [ ] Scoped a `.ticket-wizard-root` per non confliggere con altri wizard
- [ ] Stili per titolo, stepper, sezioni, contatti via CSS, NON blade HTML
- [ ] Mobile-first: base 375px → tablet 768px → desktop 1024px
- [ ] Allineare stepper styling al reference Design Comuni

### Task 4 - Verifica funzionalita (AC: 6, 7)
- [ ] Testare step 1: privacy checkbox
- [ ] Testare step 2: form fields (indirizzo, tipo, titolo, dettagli, email, immagini, contatti)
- [ ] Testare step 3: riepilogo + submit
- [ ] Testare file upload
- [ ] Testare wizard navigation (avanti/indietro)
- [ ] Testare redirect dopo submit

### Task 5 - Build e documentazione (AC: 8, 9)
- [ ] `npm run build` + `npm run copy`
- [ ] Verificare HTTP 200 su `/it/tests/segnalazione-crea`
- [ ] Aggiornare module docs con nuova architettura
- [ ] Aggiornare theme docs
- [ ] Aggiornare QWEN.md con nuova regola
- [ ] Aggiornare indici con bidirectional links

## Dev Notes

### Pattern Filament Wizard v5

```php
// CreateTicketWizardWidget.php — getFormSchema()
public function getFormSchema(): array
{
    $wizard = Wizard::make([
        Step::make('privacy')
            ->label(__('fixcity::segnalazione.steps.privacy.label'))
            ->schema([/* Checkbox privacy */]),
        Step::make('data')
            ->label(__('fixcity::segnalazione.steps.data.label'))
            ->schema([/* TextInput, Select, Textarea, FileUpload */]),
        Step::make('summary')
            ->label(__('fixcity::segnalazione.steps.summary.label'))
            ->schema([/* Placeholder riepilogo */]),
    ])
        ->startOnStep(fn() => $this->wizardStartStep)
        ->nextAction(fn(Action $a) => $a->label(__('fixcity::segnalazione.actions.next.label')))
        ->previousAction(fn(Action $a) => $a->label(__('fixcity::segnalazione.actions.back.label')))
        ->columnSpanFull();

    if ($this->queryStepOverrideAllowed()) {
        $wizard->persistStepInQueryString('step');
    }

    return ['wizard' => $wizard];  // Chiave 'wizard' matcha getWizardSchemaWrapperKey()
}
```

### Blade minimale target

```blade
{{-- ticket-create-wizard.blade.php — SOLO questo —}}
<div class="ticket-wizard-root">
    <form wire:submit="submit">
        {{ $this->form }}
    </form>
    <x-filament-actions::modals />
</div>
```

### CSS scoping example

```css
/* ticket-wizard-filament.css */
.ticket-wizard-root {
    /* Design Comuni wrapper styling */
}

.ticket-wizard-root .fi-wizard-step {
    /* Step styling per parity con Design Comuni stepper */
}

.ticket-wizard-root .fi-input-wrp {
    /* Input wrapper styling per parity */
}
```

### Assets gia presenti

Il layout `main.blade.php` include gia:
```blade
@filamentStyles  {{-- nel <head> --}}
@filamentScripts  {{-- prima di </body> --}}
```

Quindi NON serve aggiungere assets manualmente.

### XotBaseWizardWidget — Perche estendere questa classe

`CreateTicketWizardWidget` DEVE estendere `XotBaseWizardWidget` per:
1. **`resolveInitialStepFromQuery()`** — legge `?step=` in sicurezza
2. **`normalizeWizardFormState()`** — appiattisce stato annidato
3. **`queryStepOverrideAllowed()`** — policy sicurezza uniforme

Filosofia completa: `laravel/Modules/Xot/docs/filament/widgets/xot-base-wizard-widget-philosophy.md`

### Relazione con story precedenti

- `7-28-segnalazione-02-dati-stepper-responsive-multilingual.md` — stepper responsive + i18n
- `7-29-segnalazione-crea-header-stepper-responsive-multilingual.md` — header/stepper crea fix
- `7-34-create-ticket-wizard-filament-schema-wizard-refactor.md` (done) — Wizard Filament v5 Schema

Questa story completa il refactor per usare SOLO Filament, eliminando blade hardcoded, con HTML/visual parity.

### References

- [Source: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`]
- [Source: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`]
- [Source: `https://filamentphp.com/docs/5.x/schemas/wizards`]
- [Source: `https://filamentphp.com/docs/5.x/widgets/overview`]
- [Source: `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`]
- [Source: `laravel/Modules/Xot/docs/filament/widgets/xot-base-wizard-widget-philosophy.md`]
- [Source: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`]

## Dev Agent Record

### Agent Model Used

qwen-code (Qwen Code CLI)

### Debug Log References

- Richiesta utente: "il wizard va fatto con Filament Wizards + Widgets, HTML parity + visual parity"
- Widget PHP gia corretto: estende `XotBaseWizardWidget`, usa `Wizard::make()`
- Blade view ha HTML Design Comuni hardcoded da semplificare
- Filament styles/scripts gia caricati nel layout main.blade.php

### Completion Notes List

- Story creata per refactoring completo a Filament Wizard + Widget way
- Blade deve diventare minimale: solo `{{ $this->form }}` + modals
- HTML/visual parity con reference Design Comuni
- Design Comuni styling via CSS scoped, NON HTML blade
- Previsto aggiornamento documentazione con bidirectional links

### File List

- `_bmad-output/implementation-artifacts/7-30-refactor-ticket-wizard-to-filament-pure.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.30 per refactoring ticket-create-wizard a Filament Wizard puro: blade minimale, wizard 100% Filament PHP con `Wizard::make()` + `Step::make()`, widget estende `XotBaseWizardWidget`, HTML/visual parity con Design Comuni via CSS scoped. |
