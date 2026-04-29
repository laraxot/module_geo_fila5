# Story 7.26: segnalazione-02-dati - visual parity last mile su CSS/JS

Status: in-progress

## Story

Come **responsabile visual parity del tema Sixteen**,
voglio allineare la resa visiva della pagina `segnalazione-02-dati` al reference Design Comuni lavorando **solo su CSS/JS e comportamento responsive**,
cosi da correggere i residui su header, hamburger, brand, lingua, search e altri dettagli emersi dagli screenshot senza degradare la HTML parity gia raggiunta.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Vincolo non negoziabile

Questa story e **visual parity**, non HTML parity.
Il lavoro deve essere concentrato su:

- CSS
- JS / Alpine.js
- comportamento responsive
- screenshot verification

e deve **mantenere** la parity HTML gia alta, senza introdurre wrapper, riordini DOM gratuiti o markup divergente.

### Evidenze usate per il drafting

Screenshot esistenti:

- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png`

Screenshot fresh acquisiti durante il drafting:

- `/tmp/segn02-local-desktop.png`
- `/tmp/segn02-ref-desktop.png`
- `/tmp/segn02-local-tablet.png`
- `/tmp/segn02-ref-tablet.png`

### Stato corrente utile come guardrail

- La pagina locale risponde `200`
- La HTML parity e gia stata portata al `99.24%`
- I residui HTML sono ormai minimi e non devono essere riaperti durante questo pass

## Differenze visive confermate

### Header / brand / navbar

Dagli screenshot tablet e mobile emergono questi problemi ad alto segnale:

1. **Hamburger non in parity rispetto al reference**
   - deve stare **a sinistra del logo**
   - non deve scivolare sotto il blocco brand
   - deve mantenere posizione coerente tra tablet e mobile

2. **Gerarchia brand non corretta**
   - il reference mostra il logo con lo slogan sotto il nome
   - nel locale la relazione logo / titolo / tagline non e ancora coerente ai breakpoint stretti

3. **Selettore lingua con affordance incoerente**
   - deve restare **una sola freccia**
   - il blocco non deve occupare spazio o allineamento errato nella slim bar

4. **Search icon / lente non posizionata correttamente**
   - nel reference l’azione di ricerca e chiaramente allineata a destra
   - nel locale la posizione relativa a hamburger e brand non e ancora stabile

### Residui visuali extra da screenshot

Oltre ai punti espliciti richiesti dall’utente, gli screenshot suggeriscono anche altri controlli necessari:

5. **Distribuzione orizzontale degli elementi header**
   - slim bar e center header non mantengono la stessa composizione del reference

6. **Spaziature e stacking del blocco brand su tablet/mobile**
   - titolo, slogan, logo e controlli laterali hanno ancora una gerarchia visiva fragile

7. **Coerenza complessiva del top-of-page**
   - il blocco alto della pagina deve apparire come un unico sistema coerente, non come somma di fix isolati

## Acceptance Criteria

1. A mobile e tablet l’hamburger e posizionato **a sinistra del logo**, con allineamento coerente al reference.
2. Il blocco brand mostra correttamente **logo, nome e slogan**, con lo slogan sotto il nome dove previsto dal reference.
3. Il selettore lingua mostra **una sola freccia** e mantiene allineamento e spaziatura coerenti.
4. La lente di ricerca e **spostata a destra** e resta coerente ai breakpoint desktop, tablet e mobile.
5. Il layout dell’header non presenta overlap, elementi che scendono sotto il brand o stacking incoerente a `375px`, `768px`, `992px` e desktop ampio.
6. Il menu mobile/tablet continua a funzionare: hamburger, overlay, close e backdrop restano operativi.
7. Eventuali altri errori visuali emersi dagli screenshot vengono corretti nello stesso pass, purché realizzati via CSS/JS senza rompere HTML parity.
8. La pagina mantiene risposta `200` e la HTML parity non scende sotto il valore attuale di riferimento (`99.24%`).
9. Vengono prodotti screenshot aggiornati locale/reference per desktop, tablet e mobile, utili a review finale.
10. Build finale completata con `npm run build` e `npm run copy` nel tema Sixteen.

## Tasks / Subtasks

- [x] **Task 1 - Baseline visuale e tooling screenshot** (AC: 7, 9)
  - [x] Consolidare gli screenshot baseline desktop / tablet / mobile locali e reference
  - [x] Se utile, installare o completare la configurazione del tooling screenshot necessario per confronti ripetibili
  - [x] Annotare eventuali limiti dell’ambiente locale per device emulation

- [x] **Task 2 - Correggere header mobile/tablet** (AC: 1, 4, 5, 6)
  - [x] Riallineare l’hamburger a sinistra del logo
  - [x] Garantire che non scenda sotto il brand
  - [x] Riposizionare la search icon a destra
  - [x] Verificare z-index, flex alignment e spacing ai breakpoint stretti

- [x] **Task 3 - Correggere blocco brand** (AC: 2, 5)
  - [x] Rendere coerente la composizione logo / titolo / slogan
  - [x] Assicurare che lo slogan stia sotto il nome dove richiesto dal reference
  - [x] Verificare che il brand non collida con hamburger o search

- [x] **Task 4 - Correggere lingua / slim bar** (AC: 3, 5)
  - [x] Eliminare affordance doppie o icone duplicate sul selettore lingua
  - [x] Mantenere una sola freccia
  - [x] Rifinire allineamento orizzontale e spaziature nella slim bar

- [x] **Task 5 - Rifinire altri residui visuali emersi dagli screenshot** (AC: 7)
  - [x] Correggere eventuali mismatch visuali aggiuntivi del top-of-page rilevati durante il confronto
  - [x] Limitare le correzioni a CSS/JS e comportamento responsive

- [ ] **Task 6 - Verifica finale** (AC: 8, 9, 10)
  - [x] Eseguire `npm run build`
  - [x] Eseguire `npm run copy`
  - [x] Verificare `200` con `curl`
  - [x] Rilanciare un controllo di HTML parity per assicurarsi che non sia regredita
  - [ ] Salvare screenshot finali aggiornati per review

## Dev Notes

### File primari coinvolti

- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

### Artefatti di verifica

- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png`

### Guardrail

- Non usare questa story per reintrodurre modifiche HTML/Blade non necessarie
- Prima correggere layout e comportamento, poi micro-dettagli estetici
- I fix devono preferibilmente essere scoped e non degradare altre pagine segnalazione
- L’header deve essere trattato come sistema unico: hamburger, brand, lingua, search, overlay
- Se serve installare tooling aggiuntivo per screenshot o confronto, e ammesso da questa story

### Relazione con story precedenti

- `7-17-segnalazione-02-dati-css-js.md`
- `7-20-segnalazione-02-dati-header-responsive-refinement.md`
- `7-21-segnalazione-02-dati-header-cross-breakpoint-parity.md`
- `7-25-segnalazione-02-dati-html-parity-last-mile.md`

Questa story e il pass successivo: non ripete la CSS parity generica, ma chiude i residui visuali rimasti con focus screenshot-driven e guardrail esplicito su HTML parity.

### References

- [Source: `_bmad-output/implementation-artifacts/7-17-segnalazione-02-dati-css-js.md`]
- [Source: `_bmad-output/implementation-artifacts/7-20-segnalazione-02-dati-header-responsive-refinement.md`]
- [Source: `_bmad-output/implementation-artifacts/7-21-segnalazione-02-dati-header-cross-breakpoint-parity.md`]
- [Source: `_bmad-output/implementation-artifacts/7-25-segnalazione-02-dati-html-parity-last-mile.md`]
- [Source: `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`]
- [Source: `laravel/Themes/Sixteen/resources/css/app.css`]
- [Source: `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`]

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- Screenshot review manuale effettuata su desktop, tablet e mobile
- Baseline screenshots fresh acquisiti durante il drafting
- Vincolo HTML parity confermato come guardrail di story
- `npm run build` eseguito in `laravel/Themes/Sixteen`
- `npm run copy` eseguito in `laravel/Themes/Sixteen`
- `curl` sulla pagina locale: `200`
- `html-structure-compare.sh` rilanciato su `segnalazione-02-dati-run5`

### Completion Notes List

- Story creata con focus esplicito su CSS/JS parity e screenshot-driven review
- Inclusi i difetti nominati dall’utente: hamburger, slogan, lingua, search
- Scope esteso ai residui visuali coerenti emersi dagli screenshot
- Aggiunto un blocco finale di override in `segnalazione-parity.css` per stabilizzare hamburger, brand, lingua e search ai breakpoint `<992px`
- Lo slogan ora resta forzato sotto il nome su tablet, mentre su mobile resta nascosto per evitare collisioni nel layout stretto
- Il selettore lingua e stato normalizzato a una sola freccia via CSS
- La lente e stata consolidata nel right zone con allineamento esplicito a destra
- Il salvataggio degli screenshot finali via `npx playwright screenshot` in questa sessione e risultato non affidabile: il comando naviga e dichiara il capture, ma non persiste i file nel path atteso

### File List

- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- `_bmad-output/implementation-artifacts/7-26-segnalazione-02-dati-visual-parity-last-mile.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.26 per chiudere la visual parity di `segnalazione-02-dati` via CSS/JS, con baseline screenshot e guardrail di HTML parity. |
| 2026-04-13 | Implementato un pass CSS finale su header/slim bar/search/hamburger e completate build + copy + verifica HTTP. Rimane aperto solo il salvataggio affidabile degli screenshot finali dalla CLI. |
