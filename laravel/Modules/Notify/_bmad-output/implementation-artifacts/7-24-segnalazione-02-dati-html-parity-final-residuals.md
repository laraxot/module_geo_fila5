# Story 7.24: Segnalazione 02 Dati - HTML parity residual finale verso 100%

Status: ready-for-dev

## Story

Come **sviluppatore del tema Sixteen**,
voglio chiudere i residui HTML strutturali rimasti tra la pagina locale `segnalazione-02-dati` e il reference Design Comuni,
così da portare la parity HTML dal livello attuale `98.60%` il più vicino possibile al `100%` senza introdurre regressioni funzionali.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Misura corrente

Confronto HTML aggiornato eseguito con:

```bash
bash bashscripts/html/html-structure-compare.sh \
  https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html \
  http://127.0.0.1:8000/it/tests/segnalazione-02-dati \
  laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run3
```

Report corrente:
- `Score: 98.60%`
- file: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run3/report.md`

### Delta residui rilevati

Dal report corrente risultano ancora questi mismatch ad alto segnale:

1. **Link "Modifica" mancante nel card header contatti**
   - Reference contiene:
     - `a.d-none.text-decoration-none`
     - `span.t-primary.text-button-sm-semi`
   - Locale: elemento assente
   - Area interessata: card riepilogo contatti dentro `#report-author`

2. **Elemento stepper prev non allineato nel tag HTML**
   - Reference: `button.btn.btn-sm.p-0.steppers-btn-prev`
   - Locale: `a.btn.btn-sm.p-0.steppers-btn-prev`
   - È un mismatch di tag, non solo di classi

3. **Elemento stepper confirm non allineato nel tag HTML**
   - Reference: `button.btn.btn-primary.btn-sm.steppers-btn-confirm`
   - Locale: `a.btn.btn-primary.btn-sm.steppers-btn-confirm`
   - Anche qui mismatch di tag HTML

4. **Alert success senza `d-none` iniziale**
   - Reference: `div#alert-message.alert.alert-success.cmp-disclaimer.d-none.rounded`
   - Locale: `div#alert-message.alert.alert-success.cmp-disclaimer.rounded`
   - Il locale parte visibile a livello strutturale/classe invece che hidden

### File candidati principali

Il file più probabile da toccare è:
- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

### Vincoli già emersi dal lavoro precedente

- Il wrapper `div.tests-view-wrapper` in `pages/tests/[slug].blade.php` non va rimosso alla cieca: in tentativi precedenti la sua eliminazione ha rotto il rendering Folio/Volt con errore runtime.
- Quindi questa story NON deve concentrarsi sul wrapper Volt/Folio, ma sui residui HTML page-body che sono già isolati e a basso rischio.
- La pagina locale attualmente risponde `200` e il Blade target passa `php -l`; il fix deve preservare questo stato.

---

## Acceptance Criteria

1. Il blocco contatti in `#report-author` contiene il link nascosto `Modifica` con struttura equivalente al reference (`a.d-none.text-decoration-none > span.text-button-sm-semi.t-primary`).
2. Il controllo stepper “Indietro” usa lo stesso tag HTML del reference (`button`) e mantiene classi e contenuto equivalenti.
3. Il controllo stepper “Avanti” usa lo stesso tag HTML del reference (`button`) e mantiene classi e contenuto equivalenti.
4. L’alert `#alert-message` include `d-none` nello stato iniziale, allineandosi al reference.
5. La pagina continua a rispondere `200` su `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` dopo le modifiche.
6. Il confronto HTML rilanciato dopo il fix mostra una percentuale superiore al `98.60%` attuale oppure documenta chiaramente l’eventuale plateau residuo.
7. Nessuna regressione visibile viene introdotta nei controlli stepper, nel blocco autore o nell’alert.

---

## Tasks / Subtasks

- [ ] **Task 1 - Riallineare il card header contatti**
  - [ ] Leggere il blocco `#report-author` nel Blade locale
  - [ ] Inserire il link `Modifica` nascosto con struttura e classi del reference
  - [ ] Verificare che non alteri il layout esistente

- [ ] **Task 2 - Riallineare i controlli stepper**
  - [ ] Convertire il controllo “Indietro” da `a` a `button` mantenendo classi e contenuto equivalenti
  - [ ] Convertire il controllo “Avanti” da `a` a `button` mantenendo classi e contenuto equivalenti
  - [ ] Verificare che il markup risultante resti semanticamente e strutturalmente vicino al reference

- [ ] **Task 3 - Riallineare l’alert success**
  - [ ] Aggiungere `d-none` al contenitore `#alert-message`
  - [ ] Verificare che la struttura class-based coincida con il reference

- [ ] **Task 4 - Verifica parity**
  - [ ] Eseguire `php -l` sul Blade modificato
  - [ ] Verificare `curl` con HTTP `200` sulla pagina locale
  - [ ] Rilanciare `html-structure-compare.sh`
  - [ ] Salvare il nuovo report in una directory dedicata

- [ ] **Task 5 - Chiusura story**
  - [ ] Aggiornare eventuali artefatti di confronto usati come evidenza
  - [ ] Aggiornare `sprint-status.yaml` quando la story sarà completata

---

## Dev Notes

### Mismatch esatti dal report corrente

Residui confermati nel report `segnalazione-02-dati-run3/report.md`:

- `❌ (Missing) a.d-none.text-decoration-none`
- `❌ (Missing) span.t-primary.text-button-sm-semi`
- `❌ button.btn.btn-sm.p-0.steppers-btn-prev | a.btn.btn-sm.p-0.steppers-btn-prev`
- `❌ button.btn.btn-primary.btn-sm.steppers-btn-confirm | a.btn.btn-primary.btn-sm.steppers-btn-confirm`
- `❌ div#alert-message.alert.alert-success.cmp-disclaimer.d-none.rounded | div#alert-message.alert.alert-success.cmp-disclaimer.rounded`

### Approccio consigliato

- Fare fix mirati e minimali nel solo `segnalazione-02-dati.blade.php`
- Non toccare il wrapper Volt/Folio page-level
- Non riaprire la parte upload/select già allineata nel lavoro precedente
- Preferire parità strutturale esatta del markup rispetto a workaround stilistici

### File di riferimento utili

- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run3/report.md`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run3/ref.html`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run3/local.html`

---

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- Confronto aggiornato eseguito il 2026-04-12
- Score corrente verificato: `98.60%`
- Pagina locale verificata precedentemente con risposta `200`
- Residui circoscritti al blocco contatti, stepper nav e alert

### Completion Notes List

- Story creata come final residual pass dopo i fix che hanno già portato la pagina a `98.60%`
- Scope ridotto a mismatch HTML chiari e a basso rischio
- Escluso esplicitamente il wrapper `tests-view-wrapper` per evitare regressioni Volt/Folio già osservate

### File List

- `_bmad-output/implementation-artifacts/7-24-segnalazione-02-dati-html-parity-final-residuals.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.24 per chiudere i residui HTML finali di `segnalazione-02-dati` dopo il raggiungimento del 98.60% di parity. |
