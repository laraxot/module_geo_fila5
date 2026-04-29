# Story 7.21: segnalazione-02-dati — header cross-breakpoint parity (desktop, tablet, mobile)

Status: ready-for-dev

## Story

Come **responsabile qualità frontoffice**,
voglio che l'header della pagina `http://127.0.0.1:8000/it/tests/segnalazione-02-dati` sia allineato al riferimento Design Comuni su **desktop, tablet e mobile**,
così che logo, slim bar, navbar, hamburger, search e overlay mobile risultino coerenti in tutti i breakpoint principali.

## Contesto

- **Pagina locale:** `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- **Riferimento ufficiale:** `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- **Header blade reale:** `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- **CSS global header:** `laravel/Themes/Sixteen/resources/css/app.css`
- **CSS parity page-scoped:** `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`

## Evidenze usate per creare la story

### Screenshot desktop

- **Locale:** `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-desktop.png`
- **Reference:** `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-desktop.png`

### Screenshot mobile

- **Locale:** `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png`
- **Reference:** `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png`

### Nota sul tablet

Al momento del drafting non risulta presente un set tablet dedicato per `segnalazione-02-dati` nelle cartelle screenshot standard. La story richiede quindi esplicitamente di **catturare e verificare il breakpoint tablet** oltre ai breakpoint già documentati.

## Differenze osservate

### Desktop — gap header critico

Dal confronto screenshot desktop:

- il **reference** mostra slim bar, header verde completo, brand “Il mio Comune”, search e navbar orizzontale correttamente stilizzati;
- il **locale** non è ancora a parity visiva sul blocco alto pagina: l'header risulta gravemente degradato / non correttamente stilizzato rispetto al reference;
- questo indica che il problema non è solo il menu mobile, ma l'intero blocco header nei breakpoint ampi.

### Mobile — gap header critico

Dal confronto screenshot mobile:

- il **reference** mostra slim bar compatta, brand leggibile, hamburger, search e blocco header coerente col design system;
- il **locale** risulta ancora fuori parity visiva e strutturale nel blocco header, con resa non coerente rispetto al reference;
- i fix page-scoped esistenti non sono sufficienti a garantire una resa responsive affidabile.

### Tablet — gap da verificare formalmente

Poiché manca uno screenshot tablet di baseline, il rischio è che:

- desktop e mobile siano stati trattati in modo divergente;
- il breakpoint intermedio `768px–991px` abbia problemi di stacking, overflow, centratura del brand o comportamento dell'overlay;
- l'header sembri corretto a un estremo ma rompa nel breakpoint intermedio.

## Root cause probabile

L'header ha una combinazione fragile di:

- regole globali in `app.css`;
- override page-scoped in `segnalazione-parity.css`;
- logica Alpine già presente in `header.blade.php`;
- fix incrementali precedenti su hamburger, z-index, grid overlay e menu mobile.

Il risultato è una soluzione parziale che non garantisce ancora parity consistente nei tre breakpoint chiave.

## Acceptance Criteria

1. **Desktop parity header:** a `>= 992px` slim bar, brand, social, search e navbar orizzontale risultano visivamente coerenti con il reference `segnalazione-02-dati.html`.
2. **Tablet parity header:** tra `768px` e `991px` l'header mantiene allineamento, spaziature, stacking e comportamento responsive coerenti col reference, senza overlap né elementi fuori asse.
3. **Mobile parity header:** a `< 768px` hamburger, logo, search e menu mobile risultano coerenti col reference, senza layout rotto o blocchi visivamente degradati.
4. **Overlay mobile/tablet funzionante:** il pulsante hamburger apre e chiude correttamente il pannello mobile su tablet e mobile; close button e backdrop funzionano.
5. **No hidden mobile panel bug:** nessun override page-scoped nasconde in modo permanente `.navbar-collapsable`, `.menu-wrapper` o `.close-div` quando Alpine dovrebbe mostrarli.
6. **No horizontal overflow:** nessuno scroll orizzontale nell'header a `320px`, `375px`, `576px`, `768px`, `991px`, `992px`, `1280px`.
7. **Brand responsive:** il blocco brand resta leggibile e non collide con hamburger o search; eventuale truncation è controllata e non rompe il layout.
8. **Desktop no-regression:** i fix responsive non degradano il comportamento del menu desktop già presente.
9. **Screenshot verification:** vengono prodotti o aggiornati screenshot locale/reference necessari per confermare desktop, tablet e mobile.
10. **Build finale:** eseguire `npm run build` e `npm run copy` in `laravel/Themes/Sixteen`.

## Tasks / Subtasks

- [ ] Analizzare `header.blade.php`, `app.css` e `segnalazione-parity.css` limitatamente al blocco header.
- [ ] Confrontare il blocco header locale con il reference usando gli screenshot desktop/mobile già presenti.
- [ ] Catturare o aggiornare uno screenshot **tablet** per `segnalazione-02-dati` locale e reference.
- [ ] Identificare i conflitti CSS tra regole globali e page-scoped che degradano l'header.
- [ ] Correggere i problemi di layout desktop del blocco header (slim bar, brand row, navbar row, search, allineamenti).
- [ ] Correggere i problemi di layout tablet del blocco header.
- [ ] Correggere i problemi di layout mobile del blocco header.
- [ ] Verificare e correggere il comportamento del menu overlay su tablet/mobile se ancora incoerente.
- [ ] Testare manualmente i breakpoint `1280px`, `992px`, `768px`, `576px`, `375px`, `320px`.
- [ ] Eseguire `npm run build` e `npm run copy`.
- [ ] Salvare o aggiornare le evidenze screenshot usate per la review finale.

## Dev Notes

### File primari coinvolti

| File | Motivo |
|------|--------|
| `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php` | Struttura reale del header e logica Alpine del menu mobile |
| `laravel/Themes/Sixteen/resources/css/app.css` | Regole globali del header |
| `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css` | Override page-scoped di `segnalazione-02-dati` |

### Screenshot / artefatti da usare

| Tipo | Path |
|------|------|
| Desktop locale | `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-desktop.png` |
| Desktop reference | `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-desktop.png` |
| Mobile locale | `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png` |
| Mobile reference | `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png` |
| Tablet | da catturare / aggiornare durante l'implementazione |

### Guardrail

- Non limitare il fix al solo hamburger: il requisito utente copre l'intero header desktop/tablet/mobile.
- Non introdurre Bootstrap Italia JS runtime; usare la logica Alpine già presente se sufficiente.
- Prima di aggiungere nuove regole, rimuovere o consolidare quelle in conflitto.
- I fix specifici di `segnalazione-02-dati` devono rimanere scoped se non esiste evidenza che il problema sia globale.
- Non considerare la story chiusa senza verifica esplicita del breakpoint tablet.

### Riferimenti alle story precedenti

- `7-8-header-hamburger-mobile-parity.md`
- `7-10-header-mobile-tablet-overlay-parity.md`
- `7-20-segnalazione-02-dati-header-responsive-refinement.md`
- `7-17-segnalazione-02-dati-css-js-parity.md`

## Dev Agent Record

### Agent Model Used

### Debug Log References

### Completion Notes List

### File List

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-11 | Creata story 7.21 con evidenze screenshot e focus esplicito su header desktop, tablet e mobile per `segnalazione-02-dati`. |
