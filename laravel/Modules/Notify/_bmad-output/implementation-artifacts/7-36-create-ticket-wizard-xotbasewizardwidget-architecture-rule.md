# Story 7.36: CreateTicketWizardWidget - introdurre o formalizzare XotBaseWizardWidget come regola architetturale

Status: done

## Story

Come **architetto/sviluppatore Laraxot**,
voglio chiarire e implementare la regola per cui `CreateTicketWizardWidget` deve estendere `XotBaseWizardWidget` invece di `XotBaseWidget`,
cosi da codificare in una base class dedicata la filosofia wizard-first del progetto, evitare logica duplicata nei widget multi-step e allineare codice, docs e regole.

## Contesto

### Stato reale del repository

- `CreateTicketWizardWidget` oggi estende `Modules\Xot\Filament\Widgets\XotBaseWidget`.
- Una classe `XotBaseWizardWidget` **non risulta presente** nel repository.
- `XotBaseWidget` pero contiene gia indizi chiari di una direzione wizard-aware:
  - `getWizardSubmitAction()`
  - helper basati su `Filament\Schemas\Components\Wizard\Step`
  - gestione centralizzata del `form(Schema $schema)` con `statePath('data')`
- Esiste gia una story storica, [_7-34-create-ticket-wizard-filament-schema-wizard-refactor.md_](/var/www/_bases/base_fixcity_fila5/_bmad-output/implementation-artifacts/7-34-create-ticket-wizard-filament-schema-wizard-refactor.md), che ha portato il widget verso la Filament way, ma fissando come base `XotBaseWidget`.

### Problema architetturale

La richiesta utente implica che la visione corretta non e semplicemente “usare Filament Wizard”, ma **separare semanticamente i widget wizard dagli altri widget Filament**.

Questo apre una decisione architetturale vera:

1. **Opzione A - Introdurre `XotBaseWizardWidget`**
   - `CreateTicketWizardWidget` e altri wizard futuri estendono una base specializzata.
   - La base incapsula convenzioni wizard comuni: submit action, step query persistence, step bootstrap, helper su action label, eventuale parity wrapper/view dedicata.

2. **Opzione B - Non introdurla**
   - Si resta su `XotBaseWidget` e si documenta che la specializzazione wizard e solo comportamentale, non tipologica.

La story parte dal presupposto dell'utente che **la direzione desiderata e A**, ma impone di dimostrarne il senso tecnico e di codificarlo bene, non come rename cosmetico.

## Visione / filosofia da esplicitare

La richiesta dell'utente va tradotta in regola tecnica verificabile:

- **Scopo**: distinguere un widget generico da un widget con semantica di flusso multi-step.
- **Filosofia**: se il progetto ha piu wizard pubblici o amministrativi, il comportamento condiviso non deve vivere duplicato nei singoli widget.
- **Zen Laraxot**: le astrazioni esistono per assorbire convenzioni stabili, non per creare nomi in piu.
- **Politica architetturale**: una base class dedicata ha senso solo se riduce entropia, onboarding cost e regressioni documentali.
- **Religione del repo**: codice, docs e regole devono dire la stessa cosa; oggi non lo fanno ancora sul tema wizard/base class.

## Fonti e riferimenti da considerare

### Fonti locali

- [CreateTicketWizardWidget.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php)
- [XotBaseWidget.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php)
- [ticket-wizard-frontoffice.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- [CreateTicketWizardWidget.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)
- [7-34-create-ticket-wizard-filament-schema-wizard-refactor.md](/var/www/_bases/base_fixcity_fila5/_bmad-output/implementation-artifacts/7-34-create-ticket-wizard-filament-schema-wizard-refactor.md)

### Fonti ufficiali esterne

- Filament Wizards: `https://filamentphp.com/docs/5.x/schemas/wizards`
- Filament form rendering in Blade/Livewire: `https://filamentphp.com/docs/5.x/components/form`

Nota: le docs Filament non parleranno di `XotBaseWizardWidget`, che e un'astrazione locale Laraxot. Le fonti ufficiali servono per chiarire **quali responsabilita sono davvero comuni ai wizard** e quindi meritano di stare in una base class dedicata.

## Acceptance Criteria

1. Viene stabilito con chiarezza se `XotBaseWizardWidget` deve esistere come nuova base class Laraxot oppure se la richiesta va respinta motivatamente.
2. Se la risposta e **si**, viene introdotta `Modules\Xot\Filament\Widgets\XotBaseWizardWidget` con responsabilita reali e non decorative.
3. `CreateTicketWizardWidget` estende la nuova base class solo se essa assorbe davvero convenzioni condivise e riduce duplicazione.
4. Le responsabilita tra `XotBaseWidget` e `XotBaseWizardWidget` risultano documentate in modo netto.
5. Le docs esistenti del wizard vengono aggiornate per evitare messaggi contraddittori sul fatto che la base corretta sia `XotBaseWidget` oppure `XotBaseWizardWidget`.
6. Le rules docs / indici / memorie operative vengono aggiornate per rendere ricercabile e stabile la regola architetturale.
7. Nessuna regressione sul wizard attuale: form schema, submit action, query step, rendering frontoffice e parity restano funzionanti.

## Tasks / Subtasks

### Task 1 - RCA architetturale (AC: 1)
- [ ] Analizzare `XotBaseWidget` per capire quali responsabilita wizard ha gia assorbito e quali no.
- [ ] Analizzare `CreateTicketWizardWidget` per identificare cio che oggi resterebbe duplicato in altri wizard futuri.
- [ ] Determinare se il nuovo livello di astrazione e giustificato da codice reale e roadmap, non solo da naming preference.

### Task 2 - Decisione e implementazione base class (AC: 2, 3, 4)
- [ ] Se giustificato, creare `XotBaseWizardWidget` in `Modules/Xot/app/Filament/Widgets/`.
- [ ] Spostare nella nuova base solo responsabilita wizard condivise.
- [ ] Lasciare in `XotBaseWidget` cio che resta generico per tutti i widget.
- [ ] Rifare `CreateTicketWizardWidget extends XotBaseWizardWidget`.
- [ ] Verificare che la nuova gerarchia non introduca trait conflict, visibilita errate o duplicazioni di `form()` / `statePath()`.

### Task 3 - Verifica funzionale (AC: 7)
- [ ] Verificare che `CreateTicketWizardWidget` continui a renderizzare il wizard Filament correttamente.
- [ ] Verificare submit, validazione per step, query string step e rendering view wrapper.
- [ ] Eseguire quality checks PHP richiesti sui file toccati.

### Task 4 - Documentazione, regole, indici (AC: 5, 6)
- [ ] Aggiornare docs Xot per la nuova base class o per la decisione architetturale contraria.
- [ ] Aggiornare docs Fixcity del wizard.
- [ ] Aggiornare README/index di `laravel/Modules/Xot/docs/` e `laravel/Modules/Fixcity/docs/` con link bidirezionali.
- [ ] Aggiornare la doc tema pertinente se la convenzione del wrapper wizard cambia o va chiarita.
- [ ] Consolidare eventuali docs duplicate o contraddittorie sul wizard e sulla base class.

## Dev Notes

### Segnali gia presenti in XotBaseWidget

`XotBaseWidget` oggi non e neutro rispetto ai wizard: espone gia `getWizardSubmitAction()` e helper legati a `Step`. Questo suggerisce una tensione architetturale:
- o quelle responsabilita restano li e si documenta che `XotBaseWidget` e gia sufficientemente wizard-aware;
- oppure si estrae una base dedicata per evitare contaminazione semantica del widget generico.

### Criterio di accettazione architetturale forte

`XotBaseWizardWidget` va introdotta solo se contiene **almeno una di queste categorie di riuso concreto**:
- submit action standard dei wizard
- convenzioni query string / active step bootstrap
- helper comuni per `Wizard::make()` / `Step`
- view/layout convention comune ai wizard
- test helper / hooks comuni

Se nessuno di questi punti regge, la base class sarebbe solo nomenclatura e va evitata.

## Project context reference

- [7-34 create ticket wizard filament schema wizard refactor](/var/www/_bases/base_fixcity_fila5/_bmad-output/implementation-artifacts/7-34-create-ticket-wizard-filament-schema-wizard-refactor.md)
- [7-35 segnalazione-crea filament wizard way audit and refactor](/var/www/_bases/base_fixcity_fila5/_bmad-output/implementation-artifacts/7-35-segnalazione-crea-filament-wizard-way-audit-and-refactor.md)
- [CreateTicketWizardWidget docs](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)
- [Ticket wizard frontoffice](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
