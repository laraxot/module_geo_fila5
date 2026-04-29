# Story 7-47: segnalazione-crea — step 1 privacy notice parity Design Comuni

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — `tests.segnalazione-crea`)  
**URL locale target**: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.privacy-e-condizioni::data::wizard-step`  
**Ultimo aggiornamento**: 2026-04-14

---

## Story

Come **cittadino che apre il wizard di segnalazione**,  
voglio trovare nello **step 1** lo stesso contenuto informativo privacy del reference Design Comuni,  
cosi che il consenso sia consapevole, la pagina sia semanticamente corretta e la parity non si riduca a un semplice checkbox isolato.

---

## Problema osservato

Nel wizard unificato `tests/segnalazione-crea` il primo step oggi espone di fatto il solo controllo `privacyAccepted`, mentre nel reference ufficiale Design Comuni lo step contiene anche un blocco informativo GDPR esplicito, con:

- testo introduttivo sul trattamento dati del Comune;
- link all'`informativa sulla privacy`;
- checkbox finale `Ho letto e compreso l’informativa sulla privacy`;
- CTA `Avanti`.

La mancanza del testo:

- riduce la **parity visiva**;
- rompe la **parity semantica**;
- indebolisce il senso del checkbox, che senza contesto resta un atto formale ma non informato.

---

## Evidenza raccolta

### Reference Design Comuni

Fonte: [Segnalazione disservizio — privacy](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html)

Contenuto chiave osservato nel reference:

- `Il Comune di Firenze gestisce i dati personali forniti e liberamente comunicati...`
- `Per i dettagli sul trattamento dei dati personali consulta l’informativa sulla privacy.`
- `Ho letto e compreso l’informativa sulla privacy`

### Stato locale attuale

Nel widget `CreateTicketWizardWidget` lo step privacy e oggi modellato in modo minimale:

- `Checkbox::make('privacyAccepted')`
- nessun blocco editoriale/read-only esplicito dedicato all'informativa
- nessuna sezione che renda il testo GDPR first-class content

Questo spiega il delta osservato dall'utente.

---

## Domanda architetturale: Infolist o no?

L'utente ha giustamente suggerito di ragionare su [Filament Infolists overview](https://filamentphp.com/docs/5.x/infolists/overview).

### Conclusione

**Per lo step 1 privacy il componente principale NON deve essere scelto per imitazione del summary step.**

La regola corretta e:

- **Infolist** quando il contenuto e un insieme di **dati read-only strutturati in forma label/value o description list**;
- **Form Schema read-only / schema prime content / view dedicata** quando il contenuto e **editoriale, legale o introduttivo** dentro un `Wizard` che resta un **Form schema**.

### Perché

Secondo la documentazione Filament, le Infolists sono pensate per mostrare dati in formato **description list** / read-only entries; sono perfette per riepiloghi, anagrafiche e review data-oriented.  
Il testo privacy dello step 1 invece non e un dataset di campi: e **copy editoriale/legale** che introduce il checkbox.

### Filosofia / visione / zen

- Lo **step 1** non e un "record viewer": e una **soglia di consenso informato**.
- Il checkbox senza testo e tecnicamente valido ma **semanticamente povero**.
- La parity vera non copia solo classi CSS: ripristina il **ruolo del contenuto**.
- Lo zen corretto e:  
  `summary data -> Infolist`  
  `privacy legal copy inside form wizard -> content block read-only nel Form schema`

### Regola proposta

Nel wizard Fixcity:

1. usare **Infolist** per step di review / riepilogo o card autore read-only;
2. usare **Section + content read-only / Placeholder / custom schema view** per blocchi editoriali o legali interni al `Form Wizard`;
3. non introdurre `TextEntry` o `ImageEntry` nel privacy step solo per "uniformita", se il contenuto non e strutturato come entry di dato.

---

## Acceptance Criteria

1. **GIVEN** l'utente apre `/it/tests/segnalazione-crea?step=form.privacy-e-condizioni::data::wizard-step`  
   **WHEN** il primo step viene renderizzato  
   **THEN** compare un blocco informativo privacy equivalente al reference Design Comuni, non il solo checkbox isolato.

2. **GIVEN** il contenuto GDPR e read-only  
   **WHEN** si ispeziona il widget  
   **THEN** la soluzione usa un pattern coerente con un `Form Wizard` Filament (es. `Section` + contenuto read-only o view schema dedicata), non una Infolist impropria per testo editoriale.

3. **GIVEN** la parity con il reference  
   **WHEN** si confrontano locale e reference  
   **THEN** sono presenti almeno:
   - testo introduttivo GDPR,
   - link a informativa privacy,
   - checkbox con copy corretta,
   - CTA `Avanti`.

4. **GIVEN** il progetto e multilingua  
   **WHEN** si implementa il contenuto privacy  
   **THEN** il testo utente vive in traduzioni/config/CMS coerenti, non hardcoded nel runtime PHP senza motivazione.

5. **GIVEN** la stabilita del wizard frontoffice  
   **WHEN** si chiude la story  
   **THEN** il render path continua a rispondere `200` sia su URL base sia con query `?step=` persistita.

---

## Tasks / Subtasks

- [ ] Mappare il delta tra locale e reference sul solo step 1 privacy.
- [ ] Introdurre un blocco read-only per il testo GDPR nello schema dello step privacy.
- [ ] Collegare il link `informativa sulla privacy` a sorgente coerente (traduzione/config/CMS) senza hardcode fragile.
- [ ] Verificare che il checkbox resti l'ultimo elemento decisionale dello step.
- [ ] Verificare che il CTA `Avanti` mantenga comportamento e parity visuale.
- [ ] Aggiornare docs modulo e tema con la regola di scelta componente (`Infolist` vs contenuto editoriale read-only).

---

## File candidati

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/lang/it/segnalazione.php`
- `laravel/Modules/Fixcity/lang/en/segnalazione.php`
- `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/design-comuni/README.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`

---

## Guardrail tecnici

- Non reintrodurre wizard manuale Blade.
- Non spostare il contenuto privacy nel solo helper text del checkbox.
- Non usare Infolist come riflesso automatico: giustificare il componente in base alla semantica del contenuto.
- Mantenere smoke check reale:
  - `php -l` sui file toccati
  - `curl -i --max-time 15 http://127.0.0.1:8000/it/tests/segnalazione-crea`
  - `curl -i --max-time 15 'http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.privacy-e-condizioni%3A%3Adata%3A%3Awizard-step'`

---

## Fonti

- Design Comuni statiche: [Segnalazione disservizio — privacy](https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html)
- Filament 5.x docs: [Infolists overview](https://filamentphp.com/docs/5.x/infolists/overview)
- Doc modulo: [ticket-wizard-frontoffice.md](../../laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md)
- Doc widget: [CreateTicketWizardWidget.md](../../laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md)

---

## Dev Agent Record

### Agent Model Used

GPT-5 Codex

### Completion Notes List

- Story creata da evidenza runtime + confronto con reference esterna.
- Formalizzata regola di scelta tra Infolist e contenuto editoriale read-only nello step privacy.

### File List

- `_bmad-output/implementation-artifacts/7-47-segnalazione-crea-step1-privacy-notice-design-comuni-parity.md`

