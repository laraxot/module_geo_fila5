# Story 7-45: segnalazione-crea — render loop regression guard sul wizard frontoffice

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL incidentata**: `http://127.0.0.1:8000/it/tests/segnalazione-crea`  
**Ultimo aggiornamento documento**: 2026-04-14

---

## Story

Come **maintainer del wizard frontoffice Fixcity**,  
voglio eliminare le classi di regressione che riportano `segnalazione-crea` in timeout, 500 o loop di render,  
così il wizard resta stabile anche quando vengono rifattorizzati step, summary, model binding e parity HTML.

---

## Evidenza raccolta

### Comportamento osservato

- La pagina `http://127.0.0.1:8000/it/tests/segnalazione-crea` è tornata in timeout:
  - `curl -i --max-time 20 ...` → `curl: (28) Operation timed out after 20000 milliseconds with 0 bytes received`
- Nello stesso ciclo di modifiche è comparso anche un 500 esplicito su namespace errato:
  - `Class "Modules\Fixcity\Filament\Widgets\Section" not found`
- Dopo la correzione del namespace il 500 è sparito e una richiesta successiva ha risposto `200`, ma il pattern resta fragile e regressivo.

### Stato corrente del widget

In [CreateTicketWizardWidget.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php) oggi coesistono diversi fattori di rischio nel render path:

1. `mount()` chiama sia `initWizardState()` sia `$this->form->fill($this->defaultFormData())`
2. `getFormModel()` è tornato a `Ticket::class` anche se il record non esiste ancora
3. `getSummarySchema()` usa componenti Infolist dentro uno schema wizard ancora legato a form/create pre-submit
4. `ImageEntry` prova a visualizzare `images` su stato wizard non ancora persistito
5. il file ha già mostrato ambiguità di import/namespace su `Section`

Questa combinazione è il contrario di un render path minimale.

---

## Root Cause Analysis

### Root cause primaria

Il wizard ha perso il principio di **render path minimale e idempotente**.

Invece di restare:

- create wizard semplice
- stato semplice
- record non ancora esistente
- review semplice

è stato nuovamente caricato con:

- model binding anticipato
- fill espliciti nel mount
- componenti display avanzati su stato non persistito
- cambi frequenti di namespace/componenti

### Root cause secondarie

1. **Assenza di un protocollo anti-regressione render-path**
   - nessuna regola forte che vieti di complicare il mount e il summary di un create wizard

2. **Mancanza di smoke check runtime obbligatorio dopo ogni refactor del wizard**
   - il file compila (`php -l`) ma il render path può comunque andare in loop/timeout

3. **Confusione tra contratto Form e contratto Infolist**
   - il review step è giusto semanticamente come Infolist, ma il contesto tecnico del wizard create pre-submit non tollera qualsiasi entry senza analisi runtime

4. **Namespace fragili**
   - l'errore su `Section` dimostra che il widget è stato cambiato senza una guardia minima sul naming/import path

---

## Visione / filosofia / religione / zen

- Un create wizard frontoffice deve essere noioso nel render path.
- La noia è una virtù: mount corto, stato corto, schema prevedibile.
- Ogni componente “più elegante” introdotto sullo step di review deve prima dimostrare che non rompe il ciclo di render.
- `php -l` non basta: un widget Filament si considera sano solo se passa anche uno smoke HTTP reale.
- La semantica giusta conta, ma **la stabilità del render viene prima del virtuosismo**.

---

## Regole da fissare

### 1. Render Path Minimalism

Per i create wizard frontoffice:

- non fare model binding anticipato se il record non esiste ancora;
- evitare `form->fill()` nel `mount()` se il contratto base già governa l'inizializzazione;
- non introdurre doppia inizializzazione dello stato senza prova tecnica.

### 2. Unsaved-State Safety

Nel summary pre-submit:

- usare solo componenti che siano sicuri su stato non persistito;
- `ImageEntry` su upload non ancora persistiti è da considerare **rischio alto**;
- ogni entry che dipende da record/materializzazione reale deve essere esclusa dallo step pre-submit.

### 3. Namespace Explicitness

- sui componenti Filament più ambigui (`Section`, `Grid`, ecc.) usare import o FQCN chiarissimi;
- se lo stesso file miscela Forms, Schemas e Infolists, i namespace devono essere leggibili e non impliciti.

### 4. Runtime Smoke Gate

Dopo ogni modifica a `CreateTicketWizardWidget.php` devono essere obbligatori:

- `php -l`
- `curl -i --max-time 15 http://127.0.0.1:8000/it/tests/segnalazione-crea`

Se il secondo check non risponde `200`, il lavoro non è “finito”.

---

## Implementazione attesa

1. Ridurre il widget a un render path stabile:
   - riesaminare `mount()`
   - riesaminare `getFormModel()`
   - riesaminare `getSummarySchema()`

2. Distinguere chiaramente:
   - ciò che è semanticamente desiderabile
   - ciò che è tecnicamente sicuro nel create flow pre-submit

3. Documentare un ordine di preferenza per il summary:
   - Infolist semplice se stabile
   - fallback più semplice se l'Infolist specifico rompe il render path

4. Aggiungere guardrail documentali permanenti:
   - docs modulo
   - memory bank
   - eventuale checklist anti-regressione wizard

---

## Acceptance Criteria

```gherkin
Feature: Anti-regressione render loop su segnalazione-crea

  Scenario: Smoke HTTP del wizard
    Dato che modifico il widget CreateTicketWizardWidget
    Quando eseguo lo smoke runtime locale
    Allora la pagina /it/tests/segnalazione-crea risponde 200 entro il timeout

  Scenario: Render path minimale
    Dato che il wizard è un create flow pre-submit
    Quando analizzo mount, model binding e summary
    Allora non trovo inizializzazioni duplicate o binding anticipati non necessari

  Scenario: Summary sicuro su stato non persistito
    Dato che il record Ticket non esiste ancora
    Quando il summary mostra i dati raccolti
    Allora usa solo componenti compatibili con stato non persistito

  Scenario: Prevenzione namespace regression
    Dato che il widget usa componenti da Forms, Schemas e Infolists
    Quando il file viene modificato
    Allora i namespace dei componenti restano espliciti e non ambigui
```

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `.memory-bank/systemPatterns.md`
- eventuale checklist o rule dedicata wizard runtime

---

## Fonti

- Filament Forms overview: https://filamentphp.com/docs/5.x/forms/overview
- Filament Infolists overview: https://filamentphp.com/docs/5.x/infolists/overview

---

## Change Log

| Data | Autore | Descrizione |
|------|--------|-------------|
| 2026-04-14 | Codex | Story creata per prevenire timeout/loop/500 del wizard frontoffice |

---

## Status

ready-for-dev
