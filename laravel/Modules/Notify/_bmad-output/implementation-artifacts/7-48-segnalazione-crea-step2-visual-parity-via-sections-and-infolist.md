# Story 7-48: segnalazione-crea — step 2 visual parity via Section e Infolist

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL locale target**: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`  
**Reference parity**: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`  
**Ultimo aggiornamento**: 2026-04-14

---

## Story

Come **cittadino che compila lo step 2 del wizard di segnalazione**,  
voglio ritrovare una struttura visiva e semantica molto vicina al reference Design Comuni,  
cosi che i contenuti siano leggibili per capitoli, il carico cognitivo sia ridotto e i dati gia noti non sembrino campi da compilare di nuovo.

---

## Problema osservato

Lo step `Dati della segnalazione` nel widget unificato non ha ancora parity abbastanza alta con il reference `segnalazione-02-dati.html`.

I delta principali sono:

- i blocchi `Luogo`, `Disservizio` e `Autore della segnalazione` non emergono ancora come tre unita visive forti;
- il ritmo della pagina e troppo piatto rispetto alle card/sezioni del reference;
- il blocco autore rischia di essere percepito come form generico invece che come informazione strutturata;
- `Section` e `Infolist` non sono ancora usati con una politica esplicita di responsabilita visiva/semantica.

La story 7-43 ha gia fissato la necessita delle tre sezioni e dell'autore read-only; questa story esiste per spingere piu a fondo la **visual parity**, chiarendo **quando usare `Section`** e **quando usare `Infolist`**.

---

## Evidenza raccolta

### Reference Design Comuni

Fonte: [Segnalazione disservizio — dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)

Nel reference emergono con chiarezza:

- una prima area `Luogo`;
- una seconda area `Disservizio`;
- una terza area `Autore della segnalazione`;
- una gerarchia visiva a blocchi, non un elenco uniforme di campi;
- una resa read-only/informativa per i dati autore.

### Filament 5.x

Fonte: [Filament Infolists overview](https://filamentphp.com/docs/5.x/infolists/overview)  
Fonte: [Filament Schemas overview](https://filamentphp.com/docs/5.x/schemas/overview)

La documentazione distingue chiaramente:

- **layout components** come `Section`, `Grid`, `Wizard` per strutturare l'interfaccia;
- **infolist entries** per mostrare dati read-only in formato description list;
- componenti form per i campi editabili.

### Stato locale corrente

Nel widget `CreateTicketWizardWidget` la base architetturale e gia corretta, ma la parity da alzare riguarda soprattutto:

- la forza visiva delle `Section`;
- la separazione piu netta tra dati editabili e dati solo informativi;
- la qualita del mapping tra reference e componenti Filament idiomatici.

---

## Perche / regola / visione / zen

### Regola

- usare **`Section`** come unita primaria di gerarchia visiva e cognitiva nello step 2;
- usare **`Infolist`** solo dove il contenuto e davvero **read-only strutturato**;
- non usare `Infolist` per simulare campi editabili;
- non usare `Section` come semplice wrapper tecnico senza intenzione visuale.

### Visione

La parity non e copiare il DOM del reference parola per parola.  
La parity alta nasce quando si preservano:

- il **ritmo di lettura**;
- la **segmentazione del task**;
- la **distinzione tra azione e informazione**.

### Filosofia

- `Section` risponde alla domanda: **"in quale capitolo del task mi trovo?"**
- `Infolist` risponde alla domanda: **"quali dati gia noti sto leggendo?"**
- i campi form rispondono alla domanda: **"cosa devo inserire o modificare adesso?"**

### Zen operativo

`Section = architettura percettiva`  
`Infolist = verita read-only`  
`Form fields = input utente`

Quando questi tre livelli collassano in uno solo, la pagina smette di somigliare al reference anche se usa gli stessi colori.

---

## Decisione architetturale

Per aumentare la visual parity dello step 2:

1. `getDataSchema()` deve essere composto da **tre `Section` esplicite**:
   - `Luogo`
   - `Disservizio`
   - `Autore della segnalazione`
2. la sezione `Autore della segnalazione` deve usare **Infolist o resa equivalente realmente read-only** per nome, codice fiscale, recapiti e altri dati gia noti;
3. `Luogo` e `Disservizio` restano principalmente **form-first**, perche contengono input reali;
4. le `Section` devono avere titolo, eventuale descrizione, spacing e grouping tali da avvicinare il reference sul piano visivo, non solo semantico.

---

## Acceptance Criteria

1. **GIVEN** apro `/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`  
   **WHEN** lo step 2 viene renderizzato  
   **THEN** percepisco tre blocchi distinti e ordinati: `Luogo`, `Disservizio`, `Autore della segnalazione`.

2. **GIVEN** la pagina locale viene confrontata con il reference Design Comuni  
   **WHEN** osservo il ritmo della UI  
   **THEN** titoli, separazione dei blocchi, card rhythm e gerarchia dei contenuti risultano sensibilmente piu vicini al reference rispetto allo stato attuale.

3. **GIVEN** la sezione autore mostra dati gia noti  
   **WHEN** il widget la renderizza  
   **THEN** quei dati sono presentati come informazione read-only strutturata, con preferenza per `Infolist`, e non come insieme indistinto di input editabili.

4. **GIVEN** le sezioni `Luogo` e `Disservizio` contengono input veri  
   **WHEN** si implementa la parity  
   **THEN** restano modellate come form schema Filament, senza forzare `Infolist` dove la semantica sarebbe sbagliata.

5. **GIVEN** il progetto e multilingua  
   **WHEN** si introducono titoli, descrizioni e microcopy di supporto  
   **THEN** il testo utente vive in traduzioni/config coerenti e non in stringhe italiane hardcoded nel runtime PHP.

6. **GIVEN** il wizard deve restare stabile  
   **WHEN** la story viene chiusa  
   **THEN** il render path continua a rispondere `200` sia sulla URL base sia sulla URL con `?step=` persistito.

---

## Tasks / Subtasks

- [ ] Verificare il delta visuale reale tra locale e reference sul solo step 2.
- [ ] Rafforzare `Section` come componente primario di grouping visuale.
- [ ] Introdurre o consolidare il blocco autore come resa read-only strutturata via `Infolist` o equivalente idiomatico.
- [ ] Allineare titoli/descriptions/spacing della pagina alla struttura cognitiva del reference.
- [ ] Mantenere `AddressInput` nel dominio Geo senza duplicazioni in Fixcity.
- [ ] Aggiornare docs modulo e tema con la regola `Section per grouping`, `Infolist per read-only structured data`.

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/lang/it/segnalazione.php`
- `laravel/Modules/Fixcity/lang/en/segnalazione.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Modules/Fixcity/docs/README.md`
- `laravel/Themes/Sixteen/docs/design-comuni/README.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`

---

## Guardrail tecnici

- Non reintrodurre wizard manuale Blade.
- Non usare `Infolist` come scorciatoia per tutto il blocco step 2.
- Non ridurre `Section` a mero contenitore senza impatto sulla gerarchia visiva.
- Non duplicare logica Geo dentro Fixcity.
- Mantenere smoke check reale:
  - `php -l` sui file toccati
  - `curl -i --max-time 15 http://127.0.0.1:8000/it/tests/segnalazione-crea`
  - `curl -i --max-time 15 'http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step'`

---

## Fonti

- Design Comuni statiche: [Segnalazione disservizio — dati](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html)
- Filament 5.x docs: [Infolists overview](https://filamentphp.com/docs/5.x/infolists/overview)
- Filament 5.x docs: [Schemas overview](https://filamentphp.com/docs/5.x/schemas/overview)
- Story precedente: [7-43 segnalazione-crea step2 three sections parity and author infolist](./7-43-segnalazione-crea-step2-three-sections-parity-and-author-infolist.md)
- Doc modulo: [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- Doc widget: [CreateTicketWizardWidget.md](../../laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)

---

## Dev Agent Record

### Agent Model Used

GPT-5 Codex

### Completion Notes List

- Story creata come estensione semantica e visuale della 7-43, senza sovrapporre obiettivi gia coperti.
- Formalizzata la separazione di responsabilita tra `Section` e `Infolist`.
- Allineate le fonti ufficiali Design Comuni e Filament al contesto del widget frontoffice.

### File List

- `_bmad-output/implementation-artifacts/7-48-segnalazione-crea-step2-visual-parity-via-sections-and-infolist.md`
