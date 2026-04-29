# Story 7.35: segnalazione-crea - audit e refactor verso la Filament Wizard way ufficiale

Status: ready-for-dev

## Story

Come **sviluppatore del modulo Fixcity**,
voglio riallineare `CreateTicketWizardWidget` e la relativa view del wizard alla **Filament way ufficiale** per `Schemas\Wizard`,
cosi da eliminare hardcoding residui, ridurre duplicazioni fra Blade e schema, e avere un'implementazione coerente, documentata e piu manutenibile.

## Contesto

### Target segnalato dall'utente

- File target: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- Riferimento tecnico richiesto: `https://filamentphp.com/docs/5.x/schemas/wizards`

### Problema riportato

L'utente segnala che il wizard e stato implementato in modo troppo hardcoded e che si doveva usare la **Filament way**, in particolare la soluzione ufficiale basata su `Filament\Schemas\Components\Wizard`.

### Evidenze raccolte nel codice attuale

Il codice corrente mostra una situazione **ibrida**:

- In `CreateTicketWizardWidget.php` e gia presente un uso parziale della Filament way:
  - `Wizard::make([...])`
  - `Step::make(...)`
  - `startOnStep()`
  - `persistStepInQueryString()`
  - `nextAction()` / `previousAction()`
  - `submitAction(new HtmlString(...))`
- In `ticket-create-wizard.blade.php` la form viene gia renderizzata con:
  - `<form wire:submit="submit">`
  - `{{ $this->form }}`
  - `<x-filament-actions::modals />`

Quindi il task non e semplicemente “migrare da Blade hardcoded a Filament Wizard”: la story deve chiarire e chiudere i **residui hardcoded** e le **incoerenze** rispetto alla documentazione ufficiale.

### Residui / odori tecnici da auditare

1. `submitAction(new HtmlString(...))` costruisce ancora HTML inline hardcoded invece di usare un approccio Filament-consistent (ad esempio `Blade::render()` con componenti Filament o view dedicata), come documentato ufficialmente.
2. Va verificato se nel runtime reale ci siano ancora parti hardcoded fuori schema che duplicano o combattono con il wizard Filament.
3. Va verificato se la view wrapper contenga markup Design Comuni corretto ma stia ancora trattenendo responsabilita che dovrebbero stare nel layer schema / action configuration.
4. Va verificato se il widget segue davvero il pattern raccomandato per Livewire + Filament forms/schemas (`form->fill()`, `statePath`, `getState()`, render della form in Blade, azioni coerenti).
5. Va verificato se esistano file docs duplicati o disallineati che descrivono versioni precedenti del wizard e generano confusione.

## Fonti ufficiali verificate

### Filament - Wizards
Fonte ufficiale: `https://filamentphp.com/docs/5.x/schemas/wizards`

Punti rilevanti dalla documentazione:
- `Wizard::make([...])` con `Step::make(...)->schema([...])` e il pattern raccomandato per flussi cronologici multi-step.
- `submitAction()` e supportato, ma la documentazione mostra come renderizzare il bottone submit tramite **view dedicata** o tramite **Blade render + `<x-filament::button>`**, invece di HTML inline grezzo.
- `startOnStep()` e il metodo ufficiale per caricare uno step iniziale.
- `persistStepInQueryString()` e il metodo ufficiale per persistere lo step nella query string.
- `skippable()` va usato solo se si vuole navigazione libera; se il flusso e sequenziale, non va abilitato.

### Filament - Rendering a form in a Blade view
Fonte ufficiale: `https://filamentphp.com/docs/5.x/components/form`

Punti rilevanti dalla documentazione:
- In un componente Livewire la form va resa con `{{ $this->form }}` dentro `<form wire:submit="...">`.
- Serve inizializzare con `$this->form->fill()` in `mount()`.
- I dati vanno letti da `$this->form->getState()` invece di accedere direttamente allo state raw.
- `<x-filament-actions::modals />` va tenuto fuori dal `<form>` ma dentro il componente Livewire.

## Acceptance Criteria

1. Il wizard di `segnalazione-crea` rispetta in modo esplicito e documentato il pattern ufficiale Filament 5 per `Schemas\Wizard` e Livewire form rendering.
2. Ogni hardcoding non necessario del layer wizard viene eliminato o ridotto, in particolare per submit/action rendering, step configuration e responsabilita duplicate fra widget e Blade.
3. Se si mantiene un hardcoding motivato per parity Design Comuni, esso viene limitato al minimo necessario, documentato e isolato in modo chiaro.
4. Il `submitAction()` non usa piu HTML inline grezzo se esiste un'alternativa Filament-consistent migliore secondo docs ufficiali.
5. La view `ticket-create-wizard.blade.php` resta un wrapper leggero: titolo, container/layout e render del form; la logica del wizard deve stare principalmente nello schema/widget.
6. Il refactor non rompe il comportamento esistente del flusso (`startOnStep`, `persistStepInQueryString`, validazione step, submit finale).
7. La documentazione di modulo e tema viene aggiornata per spiegare la Filament way adottata e prevenire futuri refactor duplicati o regressivi.
8. Gli indici docs vengono aggiornati con link relativi bidirezionali verso:
   - story BMAD
   - widget
   - view wrapper
   - docs del wizard
   - eventuale regola nuova su Filament Wizard usage

## Tasks / Subtasks

### Task 1 - Audit architetturale del wizard corrente (AC: 1, 2, 3)
- [ ] Analizzare `CreateTicketWizardWidget.php` e `ticket-create-wizard.blade.php` rispetto alle docs ufficiali Filament.
- [ ] Elencare cosa e gia corretto secondo la Filament way e cosa invece e ancora hardcoded o ibrido.
- [ ] Verificare se il runtime reale usa davvero questa implementazione o se esistono residui/stale asset/versioni vecchie.

### Task 2 - Refactor verso la Filament way completa (AC: 2, 3, 4, 5, 6)
- [ ] Ridurre l'HTML inline residuo nel `submitAction()` e usare un approccio Filament-consistent documentato.
- [ ] Spostare nel widget/schema tutto cio che non deve stare nella Blade wrapper.
- [ ] Mantenere la Blade come wrapper Design Comuni leggero con `{{ $this->form }}` e modals, senza ricadere in wizard HTML custom.
- [ ] Verificare coerenza con `statePath`, `form->fill()`, `form->getState()` e submit handler.

### Task 3 - Parity e comportamento del flusso (AC: 3, 6)
- [ ] Verificare che il refactor non rompa styling/parity del wizard frontoffice.
- [ ] Verificare step order, query string step, validazione step-by-step e submit finale.
- [ ] Se serve CSS/JS di supporto per parity Design Comuni, mantenerlo fuori dalla logica del wizard e documentarlo.

### Task 4 - Documentazione e indici (AC: 7, 8)
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` con la Filament way effettivamente adottata.
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` per evitare descrizioni obsolete o parziali.
- [ ] Aggiornare `laravel/Modules/Fixcity/docs/README.md` con un riferimento esplicito alla regola del wizard Filament.
- [ ] Aggiornare la documentazione tema pertinente in `laravel/Themes/Sixteen/docs/` se il wrapper frontoffice cambia responsabilita o convenzioni.
- [ ] Aggiornare gli indici con collegamenti relativi bidirezionali per prevenire file doppi, docs divergenti e ricerca lenta.

## Dev Notes

### File principali

| Area | Path |
|------|------|
| Widget | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| View wrapper | `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` |
| Doc wizard | `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` |
| Doc widget | `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` |
| Doc index modulo | `laravel/Modules/Fixcity/docs/README.md` |
| Doc index tema | `laravel/Themes/Sixteen/docs/design-comuni/README.md` |

### Guardrail importanti

- Non fare un refactor “al contrario”: il file corrente usa gia `Wizard::make()` e `Step::make()`, quindi bisogna rifinire e consolidare, non ripartire da zero ignorando il codice esistente.
- La parity Design Comuni resta un vincolo, ma va gestita come **wrapper/styling**, non come giustificazione per abbandonare il pattern Filament ufficiale.
- Se una parte deve restare custom per parity, documentare il motivo preciso e il perimetro della deviazione.
- Evitare file docs duplicati con messaggi diversi sullo stesso wizard.

### Verifica minima richiesta

- `php -l` sui file PHP toccati
- eventuali test Livewire/Pest esistenti sul widget
- verifica manuale del wizard frontoffice
- build/copy tema se cambiano assets di parity

## Project context reference

- [Story 7.30](./7-30-segnalazione-crea-privacy-step-runtime-i18n-visual-parity.md)
- [Ticket Wizard Frontoffice](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [CreateTicketWizardWidget Docs](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)
- [Fixcity Docs README](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/README.md)
