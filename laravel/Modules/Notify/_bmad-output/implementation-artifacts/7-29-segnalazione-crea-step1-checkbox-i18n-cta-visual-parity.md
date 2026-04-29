# Story 7.29: segnalazione-crea step1 - checkbox, i18n CTA e visual parity last mile

Status: ready-for-dev

## Story

Come **utente** della pagina pubblica di creazione segnalazione,
voglio che lo **step 1 privacy** di `segnalazione-crea` abbia checkbox visibile, traduzioni corrette e CTA coerente col reference Design Comuni,
cosi da completare il primo step con una resa visiva e testuale affidabile, senza regressioni sul wizard esistente.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8001/it/tests/segnalazione-crea`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-01-privacy.html`

### Problemi confermati dal brief

1. **Il checkbox privacy non si vede ancora correttamente**
   - il controllo deve risultare visibile, leggibile e coerente col reference
   - non basta che l’input sia cliccabile: deve essere anche correttamente percepibile

2. **Mancano traduzioni runtime nello step 1**
   - `fixcity::segnalazione.steps.privacy.label`
   - `fixcity::segnalazione.actions.next.label`
   - non devono comparire chiavi raw in UI

3. **La CTA “Avanti” non e in parity tipografica/visiva**
   - il testo del pulsante non deve risultare nero
   - il font non deve divergere dal pattern del reference / design system locale
   - la gerarchia visiva della CTA deve risultare coerente con Bootstrap Italia / Design Comuni

4. **La visual parity dello step 1 richiede un nuovo pass screenshot-driven**
   - il confronto va fatto contro la pagina statica ufficiale `segnalazione-01-privacy`
   - il controllo deve coprire almeno desktop, tablet e mobile

### Relazione con lavoro precedente

- La story `7-2-segnalazione-crea-step1-parity-checkbox-navigation` ha gia affrontato checkbox parity, stepper non cliccabile e `?step=`
- Questa story e un **follow-up last mile**: chiude residui reali ancora presenti su `8001`, con focus su checkbox effettivamente visibile, i18n mancante, CTA e resa visuale complessiva dello step 1
- Va preservato il wizard attuale (`CreateTicketWizardWidget`) senza reintrodurre regressioni funzionali o markup divergente non necessario

## Guardrail

- Lavorare in priorita su CSS, traduzioni, asset del tema e vista/widget gia esistenti
- Non introdurre nuove classi PHP con “Segnalazione” nel nome
- Non rompere la navigazione del wizard e il comportamento step-based gia esistente
- Mantenere coerenza con la policy documentata di parity / body class / scoping CSS
- Ogni modifica deve aggiornare anche la documentazione rilevante in modulo e tema, con **link relativi bidirezionali** e **indici aggiornati**
- Se durante l’implementazione vengono toccate rules, skills o memories locali usate dal team, vanno aggiornate e reindicizzate nello stesso pass

## Acceptance Criteria

1. Nella pagina `/{locale}/tests/segnalazione-crea` il checkbox privacy dello step 1 e chiaramente visibile, con bordo, dimensione, contrasto e stato checked coerenti al reference.
2. La label privacy usa correttamente una traduzione risolta e non mostra la chiave raw `fixcity::segnalazione.steps.privacy.label`.
3. La CTA primaria dello step 1 usa correttamente una traduzione risolta e non mostra la chiave raw `fixcity::segnalazione.actions.next.label`.
4. Il testo del pulsante “Avanti” non appare nero e non usa un font incongruente rispetto alla UI di riferimento; colore, peso e famiglia risultano coerenti con il design system locale/reference.
5. La pagina locale migliora la visual parity rispetto a `segnalazione-01-privacy.html` su desktop, tablet e mobile, con verifica tramite screenshot comparativi.
6. Lo stepper, il flusso Livewire e la navigazione avanti/indietro continuano a funzionare senza regressioni.
7. Non vengono introdotti regressioni evidenti su HTML structure parity o wrapper non necessari solo per styling.
8. La documentazione rilevante viene aggiornata in `Modules/Fixcity/docs` e `Themes/Sixteen/docs`, con relativi indici mantenuti coerenti.
9. Eventuali aggiornamenti a rules / skills / memories locali usati durante il fix vengono documentati e collegati tramite indice o riferimento relativo dove applicabile.
10. Build finale completata con `npm run build` e `npm run copy`, con verifica HTTP della pagina locale.

## Tasks / Subtasks

- [ ] **Task 1 - Riprodurre e fissare baseline reale dello step 1** (AC: 1, 5)
  - [ ] Aprire `http://127.0.0.1:8001/it/tests/segnalazione-crea`
  - [ ] Acquisire screenshot locale/reference per desktop, tablet e mobile
  - [ ] Annotare differenze residue ad alto segnale su checkbox, CTA, tipografia, spaziature e stepper

- [ ] **Task 2 - Ripristinare i18n mancanti nello step 1** (AC: 2, 3)
  - [ ] Verificare il file traduzioni `fixcity::segnalazione`
  - [ ] Aggiungere/correggere `steps.privacy.label`
  - [ ] Aggiungere/correggere `actions.next.label`
  - [ ] Verificare che in UI non compaiano piu chiavi raw

- [ ] **Task 3 - Correggere checkbox privacy in parity visuale** (AC: 1, 5)
  - [ ] Verificare selector scope reale del wizard su `8001`
  - [ ] Riallineare stile checkbox, label e stato checked al reference
  - [ ] Assicurare che il fix resti stabile a tutti i breakpoint

- [ ] **Task 4 - Correggere CTA primaria dello step 1** (AC: 3, 4, 5)
  - [ ] Correggere colore del testo del pulsante
  - [ ] Correggere font / weight / line-height del testo CTA
  - [ ] Verificare padding, altezza e allineamento rispetto al reference

- [ ] **Task 5 - Rifinire parity visuale complessiva dello step 1** (AC: 5, 6, 7)
  - [ ] Confrontare layout locale/reference con screenshot
  - [ ] Correggere eventuali residui su spacing, gerarchia testi, area checkbox, CTA e stepper
  - [ ] Limitare i fix a CSS/JS/view/translations, evitando divergenze strutturali inutili

- [ ] **Task 6 - Aggiornare docs, indici e knowledge locale** (AC: 8, 9)
  - [ ] Aggiornare `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
  - [ ] Aggiornare gli indici rilevanti in `laravel/Themes/Sixteen/docs/` e/o `laravel/Modules/Fixcity/docs/`
  - [ ] Se toccate, aggiornare rules / skills / memories locali con link relativi bidirezionali e indice coerente

- [ ] **Task 7 - Verifica finale** (AC: 5, 6, 10)
  - [ ] Eseguire `npm run build`
  - [ ] Eseguire `npm run copy`
  - [ ] Verificare risposta HTTP della pagina locale
  - [ ] Salvare screenshot finali locale/reference per review

## Dev Notes

### File candidati principali

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Modules/Fixcity/lang/it/segnalazione.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`
- `laravel/Themes/Sixteen/docs/00-INDEX.md`

### Indizi tecnici utili

- Il problema checkbox era gia stato affrontato in `7-2`, quindi prima di aggiungere nuovi fix va verificato cosa non si sta applicando davvero su `8001`
- Le chiavi traduzione richieste dal brief seguono il pattern documentato in `ticket-wizard-frontoffice.md`
- La CTA va trattata come parity visuale del componente reale del wizard, non come fix isolato solo cromatico
- La pagina reference da usare per il confronto e `segnalazione-01-privacy.html`
- L’utente ha chiesto esplicitamente di mantenere disciplina costante su docs, rules, skills, memories e relativi indici

### Story correlate

- `7-1-unified-segnalazione-crea-ticket-wizard`
- `7-2-segnalazione-crea-step1-parity-checkbox-navigation`
- `7-6-segnalazione-01-privacy-html-parity`
- `7-28-segnalazione-02-dati-stepper-responsive-multilingual`

### References

- [Source: `_bmad-output/implementation-artifacts/7-2-segnalazione-crea-step1-parity-checkbox-navigation.md`]
- [Source: `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`]
- [Source: `laravel/Themes/Sixteen/docs/00-INDEX.md`]
- [Source: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php`]

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- Brief utente su `http://127.0.0.1:8001/it/tests/segnalazione-crea`
- Story precedente `7-2` riletta come contesto
- Documentazione wizard frontoffice riletta come guardrail
- Indice docs tema Sixteen riletto per ricordare vincolo di aggiornamento indici

### Completion Notes List

- Story creata come follow-up dedicato allo step 1 privacy di `segnalazione-crea`
- Scope esplicito su checkbox visibile, i18n mancante, CTA e parity visuale screenshot-driven
- Aggiunto vincolo operativo di aggiornare docs, indici, rules, skills e memories quando toccati dall’implementazione

### File List

- `_bmad-output/implementation-artifacts/7-29-segnalazione-crea-step1-checkbox-i18n-cta-visual-parity.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-13 | Creata story 7.29 per chiudere i residui dello step 1 di `segnalazione-crea` su checkbox, traduzioni, CTA e visual parity rispetto al reference Design Comuni. |
