# Story 7.25: Segnalazione 02 Dati - visual parity CSS/JS header e top chrome cross-breakpoint

Status: ready-for-dev

## Story

Come **sviluppatore frontoffice del tema Sixteen**,
voglio aumentare la visual parity della pagina `segnalazione-02-dati` rispetto al reference Design Comuni intervenendo solo su CSS/JS e comportamento responsive,
così da correggere i difetti visivi residui dell'header e del top chrome senza rompere la HTML parity già raggiunta.

## Contesto

### Sorgenti confrontate

- Locale: `http://127.0.0.1:8000/it/tests/segnalazione-02-dati`
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

### Vincolo esplicito utente

L'utente ha richiesto esplicitamente che il lavoro di parity visuale:
- sia guidato da screenshot
- possa usare e installare strumenti di supporto se utile
- **rispetti la HTML parity**
- quindi si concentri su **CSS/JS**, layout, allineamenti, responsive behavior e micro-interazioni, non su refactor strutturali gratuiti del markup

### Evidenze screenshot già disponibili

Sono già presenti numerose evidenze locali/reference utili, tra cui:

- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/segnalazione-02-dati-mobile.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-desktop.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-tablet.png`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/segnalazione-02-dati-mobile.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/local_header_desktop.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/local_header_tablet.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/local_header_mobile.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/ref_header_desktop.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/ref_header_tablet.png`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/ref_header_mobile.png`

### Stato parity HTML da preservare

La pagina ha già raggiunto una HTML parity molto alta (`98.60%`) nel report più recente.
Questo significa che i prossimi fix devono privilegiare:
- CSS page-scoped o globali già esistenti
- JS/Alpine behavior già presente
- micro-adjustments di positioning, order, spacing, visibility, icon treatment e responsive behavior

Story HTML collegata:
- `_bmad-output/implementation-artifacts/7-24-segnalazione-02-dati-html-parity-final-residuals.md`

### Problemi visivi esplicitamente segnalati dall'utente

L'utente ha già identificato questi problemi da tradurre in requisiti implementativi:

1. **Hamburger a sinistra del logo**
   - il menu hamburger deve stare a sinistra del logo nel comportamento/header responsive previsto dal reference

2. **Slogan sotto il logo**
   - sotto il logo/brand deve comparire correttamente lo slogan, con stack verticale coerente col reference

3. **Language selector con una sola freccia**
   - nella scelta lingua deve esserci una sola freccia/chevron visibile
   - eventuali doppie icone o caret duplicati sono un bug visivo

4. **Lente di ingrandimento spostata a destra**
   - il search trigger deve stare nella posizione coerente col reference, sul lato destro del blocco header

5. **Altri errori visivi**
   - la story deve includere un pass di audit visuale guidato da screenshot per intercettare ulteriori discrepanze visive residue su desktop, tablet e mobile

### Root cause probabile

I difetti residui sono verosimilmente dovuti a una combinazione di:
- `header.blade.php` già corretto in più iterazioni ma ancora fragile nei breakpoint intermedi
- regole globali in `laravel/Themes/Sixteen/resources/css/app.css`
- override page-scoped in `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- comportamento Alpine/menu responsive che può alterare ordine, posizione o visibilità degli elementi
- eventuale styling del selettore lingua e del search trigger non ancora allineato al design system reference

### File primari coinvolti

- `laravel/Themes/Sixteen/resources/views/components/bootstrap-italia/header.blade.php`
- `laravel/Themes/Sixteen/resources/css/app.css`
- `laravel/Themes/Sixteen/resources/css/segnalazione-parity.css`
- eventuale JS/Alpine già collegato all'header nel bundle tema

---

## Acceptance Criteria

1. **Hamburger positioning parity**: a mobile e tablet l'hamburger è visivamente posizionato a sinistra del logo/brand come nel reference.
2. **Brand stack parity**: il brand mostra titolo e slogan in disposizione verticale corretta, con slogan sotto il logo/titolo e non fuori asse o nascosto impropriamente.
3. **Language selector parity**: il selettore lingua mostra una sola freccia/chevron visibile, senza duplicazioni iconografiche.
4. **Search icon parity**: la lente/search trigger è posizionata sul lato destro del blocco header in modo coerente con il reference nei breakpoint rilevanti.
5. **Cross-breakpoint header parity**: desktop, tablet e mobile mostrano ordine, spaziatura, allineamenti e priorità visive del top bar/header coerenti col reference.
6. **No HTML parity regressions by design**: l'intervento è concentrato su CSS/JS e non introduce modifiche strutturali superflue al markup che peggiorino la parity HTML.
7. **Screenshot-based verification**: vengono prodotti o aggiornati screenshot locale desktop/tablet/mobile dopo il fix e confrontati con il reference.
8. **Residual visual audit**: vengono corretti anche eventuali altri errori visivi evidenti emersi dal confronto screenshot durante l'implementazione, purché rientrino nello scope CSS/JS e non rompano la HTML parity.
9. **Build finale obbligatoria**: eseguire `npm run build` e `npm run copy` in `laravel/Themes/Sixteen` dopo le modifiche.
10. **Tooling consentito**: è consentito installare/configurare strumenti di supporto per screenshot/comparazione se servono davvero alla verifica, ma l'output finale deve restare tracciabile nel repository tramite screenshot e note di verifica.

---

## Tasks / Subtasks

- [ ] **Task 1 - Audit visuale screenshot-first**
  - [ ] Confrontare gli screenshot locali/reference già presenti per desktop, tablet e mobile
  - [ ] Annotare i difetti visivi residui dell'header e del top chrome
  - [ ] Dare priorità ai problemi esplicitamente segnalati dall'utente

- [ ] **Task 2 - Correzione layout header responsive**
  - [ ] Riallineare hamburger, logo, slogan e search trigger
  - [ ] Verificare ordine e allineamento degli elementi su mobile/tablet
  - [ ] Verificare che desktop non regredisca

- [ ] **Task 3 - Correzione language selector**
  - [ ] Eliminare l'eventuale doppia freccia/chevron del selettore lingua
  - [ ] Preservare accessibilità e affordance del dropdown

- [ ] **Task 4 - Residual visual pass**
  - [ ] Correggere altri errori visivi evidenti emersi dal confronto screenshot
  - [ ] Limitare i fix a CSS/JS / behavior layer
  - [ ] Evitare cambi markup non necessari alla visual parity

- [ ] **Task 5 - Tooling e verifica**
  - [ ] Se utile, installare o configurare tooling di screenshot/visual verification
  - [ ] Produrre screenshot aggiornati locale desktop/tablet/mobile
  - [ ] Documentare i path degli screenshot finali usati per la verifica

- [ ] **Task 6 - Build finale**
  - [ ] Eseguire `npm run build`
  - [ ] Eseguire `npm run copy`
  - [ ] Verificare la pagina locale dopo il rebuild

---

## Dev Notes

### Scope tecnico

Questa story è una **visual parity story CSS/JS**, non una HTML parity story.

Quindi:
- privilegiare `app.css` e `segnalazione-parity.css`
- sfruttare Alpine/JS esistente se il problema è di comportamento o stato
- evitare modifiche strutturali non strettamente necessarie
- coordinarsi con la story HTML residual (`7.24`) senza sovrapporsi inutilmente

### Guardrail

- Non degradare la HTML parity già alta della pagina
- Non introdurre nuove dipendenze runtime inutili se il fix è risolvibile con CSS/JS già presenti
- Se si installa tooling, farlo solo per migliorare la verifica screenshot-driven
- Non chiudere la story senza verifica esplicita di desktop, tablet e mobile

### Artefatti di confronto consigliati

- `laravel/Themes/Sixteen/docs/comparisons/screenshots/local/`
- `laravel/Themes/Sixteen/docs/comparisons/screenshots/reference/`
- `laravel/Themes/Sixteen/docs/prompts/segnalazione-02-dati/screenshots/`
- eventuale nuova cartella dedicata ai final screenshot della story

### Story correlate

- `7-17-segnalazione-02-dati-css-js.md`
- `7-20-segnalazione-02-dati-header-responsive-refinement.md`
- `7-21-segnalazione-02-dati-header-cross-breakpoint-parity.md`
- `7-24-segnalazione-02-dati-html-parity-final-residuals.md`
- `8-1-skills-mcp-inventory-and-setup.md` (se serve tooling per screenshot/MCP)

---

## Dev Agent Record

### Agent Model Used

gpt-5

### Debug Log References

- Evidenze screenshot già presenti in più cartelle `docs/.../segnalazione-02-dati`
- HTML parity già elevata e da preservare
- Richieste utente tradotte in acceptance criteria visivi specifici

### Completion Notes List

- Story creata come pass visivo CSS/JS separato dalle residual HTML stories
- Inclusi i problemi espliciti: hamburger, slogan, freccia lingua, search a destra
- Scope ampliato a ulteriori errori visivi emersi da screenshot, ma con guardrail su HTML parity

### File List

- `_bmad-output/implementation-artifacts/7-25-segnalazione-02-dati-visual-parity-css-js-header-and-topbar.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.25 per aumentare la visual parity di `segnalazione-02-dati` tramite interventi CSS/JS screenshot-driven, con focus su header, selector lingua, slogan brand e search placement, preservando la HTML parity. |
