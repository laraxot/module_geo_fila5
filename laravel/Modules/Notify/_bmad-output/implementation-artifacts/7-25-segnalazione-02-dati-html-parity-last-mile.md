# Story 7.25: segnalazione-02-dati - HTML parity last mile (99.24% -> 100%)

Status: ready-for-dev

## Story

Come **responsabile parity del tema Sixteen**,
voglio chiudere gli ultimi mismatch HTML rimasti tra la pagina locale `segnalazione-02-dati` e il reference Design Comuni,
cosi da portare la parity dal `99.24%` attuale al `100%` oppure fermarmi a un plateau esplicitamente documentato se il wrapper Volt/Folio non puo essere rimosso senza regressioni.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Snapshot corrente verificato

Verifica eseguita il `2026-04-12`:

```bash
curl -s -o /tmp/segnalazione02.html -w '%{http_code}\n' \
  http://127.0.0.1:8000/it/tests/segnalazione-02-dati

bash bashscripts/html/html-structure-compare.sh \
  https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html \
  http://127.0.0.1:8000/it/tests/segnalazione-02-dati \
  laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run4
```

Esito corrente:

- HTTP locale: `200`
- Score HTML parity: `99.24%`
- Report: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run4/report.md`

### Delta residui effettivi

Dal report `run4` rimangono solo questi mismatch:

1. **Classe mancante sul link Modifica dei contatti**
   - Reference: `a.d-none.text-decoration-none`
   - Locale: `a.text-decoration-none`
   - File candidato: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`

2. **Wrapper page-level extra**
   - Extra locale: `div.tests-view-wrapper`
   - Origine: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
   - Questo wrapper nasce dal render Volt/Folio attuale e va trattato come fix ad alto rischio, non come semplice cleanup cosmetico.

### Stato del markup locale rilevante

- I pulsanti stepper sono gia allineati come `button`
- `#alert-message` include gia `d-none`
- Il blocco `report-author` e ormai quasi allineato
- Il rendering locale e funzionante ma il file page-level usa ancora:

```blade
@volt('tests.view')
<div class="tests-view-wrapper">
    @foreach($blocks as $block)
        @include($block->view, array_merge($data, ['data' => $block->data]))
    @endforeach
</div>
@endvolt
```

### Story precedenti correlate

- `7-23-segnalazione-02-dati-html-parity-residual.md`
- `7-24-segnalazione-02-dati-html-parity-final-residuals.md`

Questa story le segue come ultimo pass, basato sullo stato reale del codice e sul report `run4`.

## Acceptance Criteria

1. Il link `Modifica` dentro il blocco contatti usa la stessa struttura del reference, inclusa la classe `d-none` su `<a>`.
2. La pagina locale continua a rispondere `200` dopo il fix del link contatti.
3. Viene valutata esplicitamente la rimozione del wrapper `div.tests-view-wrapper` in `pages/tests/[slug].blade.php`.
4. Se il wrapper puo essere rimosso senza rompere il rendering Volt/Folio, viene eliminato e la parity HTML aumenta rispetto al `99.24%`.
5. Se il wrapper non puo essere rimosso in sicurezza, la story documenta chiaramente il motivo tecnico e mantiene la pagina stabile, senza regressioni.
6. Il confronto HTML viene rilanciato dopo le modifiche e il report finale viene salvato in una directory dedicata.
7. Il risultato finale mostra uno di questi due esiti validi:
   - parity `100%`, oppure
   - parity superiore al `99.24%` con plateau residuo spiegato e circoscritto al wrapper Volt/Folio.

## Tasks / Subtasks

- [ ] **Task 1 - Allineare il link contatti "Modifica"** (AC: 1, 2)
  - [ ] Aggiornare `report-author` in `segnalazione-02-dati.blade.php`
  - [ ] Aggiungere la classe `d-none` al tag `<a>` del link `Modifica`
  - [ ] Verificare che il markup resti identico o equivalente al reference

- [ ] **Task 2 - Analizzare il wrapper Volt/Folio** (AC: 3, 4, 5)
  - [ ] Ispezionare `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
  - [ ] Valutare se il wrapper `div.tests-view-wrapper` e necessario per il single-root di Volt
  - [ ] Tentare una rimozione solo se il template resta valido e la pagina continua a renderizzare correttamente
  - [ ] Se non sicuro, fermarsi e documentare il vincolo invece di introdurre regressioni

- [ ] **Task 3 - Verifica tecnica** (AC: 2, 6, 7)
  - [ ] Eseguire `php -l` sui Blade toccati
  - [ ] Verificare risposta `200` con `curl`
  - [ ] Rieseguire `bashscripts/html/html-structure-compare.sh`
  - [ ] Salvare il confronto in una nuova directory di report

- [ ] **Task 4 - Chiusura story** (AC: 6, 7)
  - [ ] Annotare nel file story l'esito del tentativo sul wrapper
  - [ ] Aggiornare `sprint-status.yaml` quando il lavoro sara completato

## Dev Notes

### File primari da leggere/toccare

- `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`
- `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run4/report.md`

### Mismatch confermati dal report corrente

- `❌ a.d-none.text-decoration-none | a.text-decoration-none`
- `❌ (Extra) NONE | div.tests-view-wrapper`

### Guardrail

- Non riaprire fix gia risolti in stepper, alert, sidebar o upload
- Non peggiorare il rendering locale per inseguire il `100%`
- Se il wrapper `tests-view-wrapper` serve al vincolo single-root di Volt, trattarlo come limite architetturale esplicito
- Preferire una decisione ben documentata a un fix fragile

### Esito atteso piu probabile

Il fix del link `Modifica` dovrebbe essere immediato e portare la parity oltre `99.24%`.
Il passaggio a `100%` dipende dalla possibilita di eliminare in sicurezza il wrapper Volt/Folio.

### References

- [Source: `_bmad-output/implementation-artifacts/7-24-segnalazione-02-dati-html-parity-final-residuals.md`]
- [Source: `laravel/Themes/Sixteen/docs/body-structure-comparison/segnalazione-02-dati-run4/report.md`]
- [Source: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`]
- [Source: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-02-dati.blade.php`]

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- `curl` locale verificato con HTTP `200` il `2026-04-12`
- `html-structure-compare.sh` eseguito su `segnalazione-02-dati-run4`
- Score corrente confermato: `99.24%`

### Completion Notes List

- Story creata sullo stato reale del branch, non sul report precedente `98.60%`
- Scope ridotto agli ultimi due mismatch effettivi
- Wrapper Volt/Folio trattato come rischio architetturale esplicito

### File List

- `_bmad-output/implementation-artifacts/7-25-segnalazione-02-dati-html-parity-last-mile.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.25 per l'ultimo pass di HTML parity su `segnalazione-02-dati`, basata sul report reale `run4` con score `99.24%`. |
