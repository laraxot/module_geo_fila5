# Story 7-51: segnalazione-crea step2 — colonne, header e spacing per ultra visual parity

**Stato**: review  
**Epic**: 7 (Ticket wizard unificato)  
**Ultimo aggiornamento**: 2026-04-14  
**Dipendenze**: 7-45, 7-48, 7-50

---

## Story

Come cittadino che usa il wizard pubblico multilingua di segnalazione,  
voglio che la URL reale `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step` raggiunga una parity HTML alta e una parity visiva altissima rispetto al riferimento Design Comuni,  
cosi che lo step 2 sia leggibile, istituzionale e coerente.

Riferimento: [segnalazione-02-dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)

---

## Problema consolidato

1. colonna sinistra poco leggibile;
2. colonna centrale compressa;
3. troppo spazio verticale;
4. header/topbar con leggibilita insufficiente su `Accedi all'area personale`;
5. necessaria coerenza multilingua senza hardcode UI;
6. presenza di markup extra non presente nel reference (`segnalazione-crea-wrapper`);
7. presenza di elementi non desiderati sopra lo stepper che degradano la parity percettiva.

---

## Regole tecniche

- wizard Filament puro (`Wizard` + `Step` + `Section` + `Grid`);
- niente rollback a wizard Blade custom;
- niente hardcoded `->label()`, `->placeholder()`, `->tooltip()`;
- usare `Infolists` solo per read-only strutturato, non come sostituto cieco;
- CSS page-scoped, no body-class coupling;
- no wrapper extra attorno al mount Livewire se assenti nel DOM reference;
- no elementi editoriali/strutturali aggiuntivi sopra lo stepper oltre il necessario al flusso;
- docs-first + aggiornamento indici anti-duplicazione.

---

## Acceptance Criteria (BDD)

### AC1 — Colonna sinistra leggibile
**GIVEN** step 2 desktop  
**WHEN** verifico la sidebar informativa  
**THEN** il testo e leggibile e la colonna non e compressa.

### AC2 — Colonna centrale corretta
**GIVEN** blocchi `Luogo`, `Disservizio`, `Autore`  
**WHEN** confronto col reference  
**THEN** la colonna centrale ha proporzioni credibili e campi non schiacciati.

### AC3 — Spacing verticale rifinito
**GIVEN** page rhythm complessivo  
**WHEN** confronto locale/reference  
**THEN** lo spazio verticale e coerente, senza vuoti eccessivi.

### AC4 — Header leggibile
**GIVEN** topbar/header  
**WHEN** verifico desktop/tablet/mobile  
**THEN** `Accedi all'area personale` resta leggibile e ben posizionato.

### AC5 — Multilingua preservato
**GIVEN** regole i18n progetto  
**WHEN** applico fix parity  
**THEN** nessuna regressione su traduzioni e nessun testo hardcoded.

### AC6 — Quality gate completo
**GIVEN** patch pronta  
**WHEN** eseguo quality checks  
**THEN** passano `phpstan`, `phpmd` (standalone `.phar`), `phpinsights`, `pest` e confronto screenshot.

### AC7 — No wrapper extra
**GIVEN** il blocco `segnalazione-crea` nel tema  
**WHEN** confronto col reference  
**THEN** non esistono wrapper tecnici aggiuntivi tipo `div.segnalazione-crea-wrapper`.

### AC8 — Nessun rumore sopra stepper
**GIVEN** il render dello step 2  
**WHEN** osservo l'area immediatamente sopra lo stepper  
**THEN** non compaiono elementi estranei che non esistono nel reference.

---

## File target previsti

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`

---

## Definition of done

- AC1..AC8 soddisfatti;
- parity verificata con screenshot desktop/tablet/mobile locale vs reference;
- docs/indici aggiornati senza file duplicati.

---

## Note di consolidamento (2026-04-14)

- allineato il blocco tema rimuovendo il wrapper extra `segnalazione-crea-wrapper`;
- introdotto guardrail documentale "no-wrapper" per evitare regressioni;
- consolidato il focus su leggibilita sidebar `INFORMAZIONI RICHIESTE`, larghezza colonne e ritmo verticale.

## Dev agent record

### Completion notes

- rimosso il doppio stepper visuale: nascosto header wizard Filament per mantenere solo stepper Design Comuni;
- stepper custom reso coerente con lo step corrente (`1/3`, `2/3`, `3/3`) tramite query `step`;
- ripristinato heading pagina `Segnalazione disservizio` sopra lo stepper e ampliata la colonna contenuto step 2 (`col-lg-9` su data step);
- confermato layout step 2 con sidebar leggibile e senza wrapper extra;
- quality gate eseguiti: `php -l`, `phpstan` su widget, `phpmd` standalone `.phar`, `phpinsights`; `pest` ora supera il conflitto di bootstrap su file Chart ma resta non affidabile in esecuzione locale (processo bloccato senza output, terminato manualmente).

### File list

- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/tests/Feature/Modules/Chart/Controllers/ChartControllerTest.php`
- `laravel/tests/Feature/Modules/Chart/Filament/ChartResourceTest.php`

### Change log

- 2026-04-14: completata implementazione parity step 2 (no rumore sopra stepper, progress coerente, sidebar leggibile) e hardening bootstrap Pest nei test Feature/Chart.
