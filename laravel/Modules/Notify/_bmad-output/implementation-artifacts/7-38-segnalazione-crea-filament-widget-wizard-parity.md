# Story 7.38: segnalazione-crea - Filament Widget/Wizard parity completion

Status: ready-for-dev

## Story

Come **sviluppatore frontoffice Fixcity**,
voglio che `http://127.0.0.1:8000/it/tests/segnalazione-crea` usi in modo rigoroso il pattern ufficiale **Filament 5 Widget + Schemas Wizard**,
cosi da mantenere il wizard dentro `CreateTicketWizardWidget` secondo le docs ufficiali e massimizzare, per quanto possibile, la **HTML parity** e la **visual parity** con il reference Design Comuni senza rompere il dominio Laraxot.

## Contesto

### Richiesta utente consolidata

- Il wizard deve essere fatto con:
  - `https://filamentphp.com/docs/5.x/schemas/wizards`
  - `https://filamentphp.com/docs/5.x/widgets/overview`
- La pagina target e `http://127.0.0.1:8000/it/tests/segnalazione-crea`
- Obiettivo secondario ma vincolante: cercare la massima **HTML parity** e **visual parity** possibile.

### Stato corrente del repository

- `CreateTicketWizardWidget` esiste ed e gia nel perimetro Filament v5.
- La base architetturale corretta e stata chiarita in story [7-36](./7-36-create-ticket-wizard-xotbasewizardwidget-architecture-rule.md):
  - i widget multi-step devono estendere `Modules\Xot\Filament\Widgets\XotBaseWizardWidget`
- La migrazione a `Wizard::make()` e `Step::make()` e stata affrontata in [7-34](./7-34-create-ticket-wizard-filament-schema-wizard-refactor.md).
- L’audit “Filament way” e stato affrontato in [7-35](./7-35-segnalazione-crea-filament-wizard-way-audit-and-refactor.md).
- Restano pero incoerenze pratiche possibili fra:
  - widget Filament
  - wrapper Blade
  - CSS/JS di parity
  - runtime reale della pagina `segnalazione-crea`

### Principio guida

La pagina deve essere **Filament-first per la logica wizard** e **theme-first per la parity visuale**:

- `CreateTicketWizardWidget` governa stato, step, validazione, submit e query-step.
- La view Blade resta un wrapper sottile (`{{ $this->form }}` + contenitore editoriale).
- HTML parity e visual parity si recuperano con CSS/JS page-scoped e con configurazione del wizard, **non** con reintroduzione di wizard HTML hardcoded in Blade.

## Fonti ufficiali

### 1. Filament Schemas - Wizards

Fonte primaria:
- `https://filamentphp.com/docs/5.x/schemas/wizards`

Uso atteso nella story:
- `Wizard::make([...])`
- `Step::make(...)`
- `startOnStep()`
- `persistStepInQueryString()`
- `nextAction()` / `previousAction()`
- `submitAction()`

### 2. Filament Widgets - Overview

Fonte primaria:
- `https://filamentphp.com/docs/5.x/widgets/overview`

Uso atteso nella story:
- il wizard deve restare incapsulato nel widget Filament, non “uscire” in una pagina Blade che replica stato e step manualmente;
- il widget deve mantenere responsabilita chiare di rendering e stato, coerenti con la base Xot/Laraxot;
- il wrapper frontoffice deve consumare il widget, non sostituirne il ruolo.

## Acceptance Criteria

1. `CreateTicketWizardWidget` resta il source of truth del wizard e usa il pattern ufficiale Filament 5 `Widget + Schemas\Wizard`.
2. La pagina `tests/segnalazione-crea` non reintroduce gestione manuale step in Blade (`$currentStep`, `nextStep()`, `prevStep()` o markup stepper hardcoded come fonte primaria del flusso).
3. La view `ticket-create-wizard.blade.php` resta un wrapper leggero e non duplica responsabilita del wizard Filament.
4. Tutto cio che riguarda parity HTML/visuale viene implementato principalmente nel tema (`css/js`) o tramite configurazione Filament del wizard, preservando l’architettura widget-first.
5. La parity viene valutata contro il reference Design Comuni della segnalazione:
   - stepper
   - CTA
   - header/hamburger/search/language area
   - struttura e ritmo visivo dello step corrente
6. Il runtime reale di `http://127.0.0.1:8000/it/tests/segnalazione-crea` viene verificato con screenshot mobile/tablet/desktop o strumenti equivalenti.
7. Se compaiono artefatti runtime anomali nel DOM (es. marker di cache/debug), il workflow prevede prima pulizia cache (`view:clear`, `optimize:clear`) e solo dopo analisi parity.
8. La documentazione di modulo, tema e Xot viene aggiornata in modo coerente, con indici e link bidirezionali, per prevenire regressioni documentali e file ridondanti.

## Tasks / Subtasks

### Task 1 - Audit runtime e architetturale (AC: 1, 2, 3, 6, 7)
- [ ] Verificare il runtime reale di `segnalazione-crea` su `127.0.0.1:8000`.
- [ ] Confrontare widget, wrapper Blade e DOM renderizzato con le docs ufficiali Filament Widget/Wizard.
- [ ] Confermare che il wizard viva davvero nel widget Filament e che la Blade non stia duplicando lo stato.
- [ ] Se il DOM contiene artefatti sporchi o cache residue, pulire `view:clear` e `optimize:clear` prima della diagnosi.

### Task 2 - Riallineamento Filament-first del wizard (AC: 1, 2, 3)
- [ ] Verificare che `CreateTicketWizardWidget` estenda `XotBaseWizardWidget` e che le responsabilita wizard-specifiche restino li.
- [ ] Verificare l’uso corretto di `Wizard::make`, `Step::make`, `startOnStep`, `persistStepInQueryString`, `nextAction`, `previousAction`, `submitAction`.
- [ ] Rimuovere eventuali residui hardcoded non necessari che violano il pattern Filament Widget/Wizard.
- [ ] Mantenere il wrapper Blade sottile e coerente con `Widgets Overview`.

### Task 3 - HTML parity e visual parity (AC: 4, 5, 6)
- [ ] Confrontare la pagina locale con il reference Design Comuni pertinente.
- [ ] Migliorare lo stepper e le CTA usando CSS/JS page-scoped e hook runtime stabili.
- [ ] Migliorare header mobile/tablet/desktop senza introdurre classi su `<body>`.
- [ ] Documentare chiaramente il limite: HTML parity massima possibile compatibile con `Filament Widget + Wizard`.

### Task 4 - Docs, indici, regole, memorie (AC: 8)
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`.
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`.
- [ ] Aggiornare docs tema pertinenti in `laravel/Themes/Sixteen/docs/`.
- [ ] Aggiornare docs Xot se emerge una regola ulteriore su `XotBaseWizardWidget`.
- [ ] Aggiornare indici e collegamenti relativi bidirezionali.
- [ ] Aggiornare memory/rules/skills locali se emergono nuove regole operative stabili.

## Dev Notes

### File principali

| Area | Path |
|------|------|
| Widget | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| Base class | `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php` |
| View wrapper | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| Theme CSS | `laravel/Themes/Sixteen/resources/css/app.css` |
| Theme parity CSS | `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` |
| Page route | `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php` |

### Guardrail implementativi

- Non usare il task per “tornare indietro” a wizard Blade custom.
- Non aggiungere classi al `<body>` per scoping parity.
- Preferire hook runtime reali:
  - `div.page-content[data-slug="tests.segnalazione-crea"]`
  - `.ticket-wizard-root`
  - `.fi-sc-wizard-*`
  - hook header `it-header-*`
- Se la parity richiede markup piu vicino al reference, provare prima:
  - configurazione Wizard
  - CSS/JS theme-scoped
  - eventuali componenti/view Filament mirati
  prima di duplicare HTML.

### Riferimenti interni obbligatori

- [7-34 create ticket wizard filament schema wizard refactor](./7-34-create-ticket-wizard-filament-schema-wizard-refactor.md)
- [7-35 segnalazione-crea filament wizard way audit and refactor](./7-35-segnalazione-crea-filament-wizard-way-audit-and-refactor.md)
- [7-36 create ticket wizard xotbasewizardwidget architecture rule](./7-36-create-ticket-wizard-xotbasewizardwidget-architecture-rule.md)
- [Ticket Wizard Frontoffice](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [CreateTicketWizardWidget docs](../../laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)
- [XotBaseWizardWidget docs](../../laravel/Modules/Xot/docs/filament/widgets/xot-base-wizard-widget.md)

## Testing

- `php -l` sui file PHP toccati
- eventuali test Pest/Livewire esistenti sul widget
- `npm run build` e `npm run copy` se cambiano asset tema
- screenshot mobile/tablet/desktop della pagina locale

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-13 | SM | Story creata per consolidare `segnalazione-crea` sul pattern ufficiale Filament Widget + Wizard con parity HTML/visuale |

