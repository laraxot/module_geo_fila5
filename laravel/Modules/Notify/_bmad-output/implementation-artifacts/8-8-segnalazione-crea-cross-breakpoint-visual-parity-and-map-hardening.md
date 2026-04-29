# Story 8.8: segnalazione-crea — visual parity cross-breakpoint e hardening mappa step 2

**Status**: ready-for-dev
**Epic**: 8 — Tooling & Developer Experience
**Story ID**: 8-8
**Story Key**: 8-8-segnalazione-crea-cross-breakpoint-visual-parity-and-map-hardening
**Data creazione**: 2026-04-15
**Dipendenze**: 7-29, 7-51, 7-52, 8-6, 8-7

---

## Story

Come **cittadino che compila il wizard pubblico multilingua di segnalazione**,
voglio che la pagina reale `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
raggiunga una parity visuale alta rispetto al reference Design Comuni su **desktop, tablet e mobile**,
con header leggibile, stepper responsive, sidebar coerente, mappa usabile e stato `latitude` / `longitude` sempre aggiornato,
cosi da poter compilare lo step 2 senza attrito, rumore visivo o regressioni UX.

Riferimento principale:
- `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

URL target locale:
- `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`

---

## Contesto consolidato

La richiesta utente unisce problemi gia emersi in story diverse ma non ancora chiusi in modo sistemico:

1. **stepper non responsive**;
2. **sidebar "Informazioni richieste" da nascondere su mobile**;
3. **troppo spazio bianco** sotto "Indica il luogo del servizio";
4. **mappa con fullscreen non percepibile / da verificare**;
5. **marker map → campi latitudine/longitudine non affidabili lato UX**;
6. **header leggibile male**;
7. **altri errori visivi e UI/UX residuali** da chiudere con un audit guidato da screenshot.

Le story precedenti hanno gia fissato guardrail importanti:
- nessun selettore fragile come `.page-content[data-slug="tests.segnalazione-crea"]` introdotto come scorciatoia nuova;
- no hardcode runtime UI in italiano;
- wizard Filament puro, senza rollback a Blade custom pesante;
- docs-first e anti-regressione sul render path della vista.

Questa story serve quindi da **consolidamento finale operativo**: un solo scope, una sola checklist, un solo quality gate.

---

## Problemi da risolvere

| # | Problema | Impatto | Direzione fix |
|---|---|---|---|
| 1 | Stepper poco responsive su mobile/tablet | orientamento scarso, wrapping brutto, parity bassa | rifare comportamento cross-breakpoint nella view del wizard e nel CSS del tema |
| 2 | Sidebar "Informazioni richieste" visibile male o fuori contesto su mobile | rumore e compressione layout | nasconderla su mobile e tablet stretti, mantenendo fallback chiaro |
| 3 | Spazio bianco eccessivo sotto la sezione Luogo | percezione di form spezzato | densificare ritmo verticale tra description, mappa e campi successivi |
| 4 | Mappa: fullscreen da rendere davvero visibile/usabile | task UX incompleto | verificare overlay, contrasto, z-index, shell fullscreen, responsive resize |
| 5 | Mappa: drag marker non sincronizza sempre lat/lng in modo verificabile | rischio dato errato | hardening binding `wire.set()` / path / campi di stato |
| 6 | Header/top chrome con leggibilita scarsa | parity istituzionale bassa | pulizia CSS header, hamburger, area personale, lingua, cerca |
| 7 | Residuali visual/UI/UX non ancora enumerati | rischio di fix parziali | audit screenshot-driven desktop/tablet/mobile e chiusura backlog residuo |
| 8 | Multilingua da preservare | regressione in locale diverso da `it` | verificare chiavi it/en e lunghezze etichette |

---

## Regole tecniche non negoziabili

- Wizard Filament puro: `XotBaseWizardWidget` + `Wizard` + `Step` + `Section` + `Grid`.
- Nessun ritorno a selettori fragili basati su slug hardcoded nel CSS.
- Nessun `->label()`, `->placeholder()`, `->tooltip()` runtime come toppa visuale.
- Testi utente da traduzioni modulo/tema, non hardcoded.
- Fix CSS su wrapper/classi stabili del wizard o del tema.
- Nessuna regressione su desktop mentre si corregge mobile.
- La mappa resta componente **Geo-owned**: non duplicare logica dominio nel widget Fixcity.
- Se un fix richiede JS, deve essere minimo, idempotente e compatibile con Livewire/Filament.

---

## Acceptance Criteria

### AC1 — Parity cross-breakpoint
**Given** lo step 2 del wizard e aperto  
**When** confronto locale e reference su desktop, tablet e mobile  
**Then** layout, densita visiva, gerarchia e navigazione risultano coerenti e credibili rispetto al reference.

### AC2 — Stepper responsive corretto
**Given** viewport mobile o tablet  
**When** osservo lo stepper  
**Then** non ci sono label spezzate in modo illegibile, overflow o compressioni anomale  
**And** il passo corrente resta chiaramente percepibile.

### AC3 — Sidebar nascosta su mobile
**Given** viewport mobile  
**When** apro lo step 2  
**Then** la sidebar "Informazioni richieste" non e visibile  
**And** su desktop resta leggibile e coerente con il reference.

### AC4 — White space sotto Luogo corretto
**Given** la sezione `Luogo`  
**When** guardo il blocco "Indica il luogo del servizio" + mappa  
**Then** il ritmo verticale e compatto e non lascia vuoti inutili.

### AC5 — Fullscreen mappa realmente usabile
**Given** la mappa dello step 2  
**When** l'utente usa il pulsante fullscreen  
**Then** il controllo e visibile, cliccabile e coerente  
**And** la mappa entra/esce da fullscreen senza glitch  
**And** `invalidateSize()` evita mappa schiacciata o vuota.

### AC6 — Latitudine e longitudine sincronizzate
**Given** l'utente clicca sulla mappa, trascina il marker o usa la geolocalizzazione  
**When** l'interazione termina  
**Then** i campi `latitude` e `longitude` nello stato Livewire sono aggiornati correttamente  
**And** il valore visibile/inviato e coerente con la posizione finale.

### AC7 — Header leggibile
**Given** desktop, tablet e mobile  
**When** verifico topbar, nav, lingua, cerca e area personale  
**Then** non ci sono overlap, contrasti errati, toggle fuori asse o elementi illeggibili.

### AC8 — Multilingua preservato
**Given** il wizard in `it` e `en`  
**When** verifico stepper, sidebar, helper text, bottoni e controlli mappa  
**Then** non compaiono chiavi raw o testo hardcoded italiano nel runtime.

### AC9 — Residual audit chiuso
**Given** il confronto screenshot-driven finale  
**When** emergono altri micro-difetti visuali o UX nello scope dello step 2  
**Then** vengono corretti nella stessa story oppure documentati esplicitamente come fuori scope.

### AC10 — Quality gate
**Given** la patch pronta  
**When** eseguo i quality checks di progetto  
**Then** passano `php -l`, `phpstan`, `phpmd` standalone `.phar`, `phpinsights`  
**And** `pest` viene eseguito o documentato con blocker reale se il limite e esterno all'intervento.

---

## Tasks / Subtasks

### [ ] 1. Audit visuale iniziale e baseline
- [ ] 1.1. Confrontare reference e locale su desktop, tablet, mobile
- [ ] 1.2. Produrre checklist screenshot-driven dei gap residui
- [ ] 1.3. Distinguere problemi di view, CSS e JS/mappa

### [ ] 2. Stepper responsive e sidebar mobile
- [ ] 2.1. Rifinire lo stepper nella view del wizard
- [ ] 2.2. Sistemare il comportamento cross-breakpoint nel CSS del tema
- [ ] 2.3. Nascondere "Informazioni richieste" su mobile senza usare selettori fragili
- [ ] 2.4. Verificare desktop/tablet/mobile con fallback coerente

### [ ] 3. Layout step 2 e spacing
- [ ] 3.1. Ridurre il vuoto sotto "Indica il luogo del servizio"
- [ ] 3.2. Riallineare sidebar, colonna centrale, card e sezioni
- [ ] 3.3. Chiudere eventuali vuoti verticali o compressioni residue

### [ ] 4. Mappa: fullscreen, marker, lat/lng
- [ ] 4.1. Verificare il pulsante fullscreen gia previsto nel componente Geo
- [ ] 4.2. Correggere visibilita, contrasto, icona, z-index o shell se necessario
- [ ] 4.3. Verificare drag marker, click mappa e geolocalizzazione
- [ ] 4.4. Assicurare sincronizzazione affidabile `latitude` / `longitude`
- [ ] 4.5. Verificare resize su cambio step, ritorno allo step e fullscreen

### [ ] 5. Header e top chrome
- [ ] 5.1. Ripulire CSS header desktop/tablet/mobile
- [ ] 5.2. Correggere hamburger, cerca, lingua, area personale e allineamenti
- [ ] 5.3. Verificare che i fix non rompano le altre pagine test

### [ ] 6. Multilingua
- [ ] 6.1. Verificare chiavi it/en per stepper, sidebar, helper text e mappa
- [ ] 6.2. Controllare overflow o wrapping problematico in inglese
- [ ] 6.3. Eliminare eventuali stringhe hardcoded residue nello scope

### [ ] 7. Verifica finale e docs
- [ ] 7.1. Eseguire smoke test sulla URL target
- [ ] 7.2. Verificare screenshot finali desktop/tablet/mobile
- [ ] 7.3. Aggiornare documentazione modulo/tema anti-regressione
- [ ] 7.4. Aggiornare `sprint-status.yaml` a `review` o `done` a lavoro completato

---

## File target previsti

- `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/leaflet-marker-map-input.blade.php`
- `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css`
- `laravel/Themes/Sixteen/resources/css/header-fix.css`
- `laravel/Themes/Sixteen/resources/css/mobile-header-fix.css`
- `laravel/Themes/Sixteen/resources/css/mobile-map-fix.css`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Dev Notes

### Sorgenti gia studiate e da riusare

- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `_bmad-output/implementation-artifacts/7-29-segnalazione-crea-header-stepper-responsive-multilingual.md`
- `_bmad-output/implementation-artifacts/7-51-segnalazione-crea-step2-columns-header-ultra-parity.md`
- `_bmad-output/implementation-artifacts/7-52-segnalazione-crea-wizard-ultra-parity.md`
- `_bmad-output/implementation-artifacts/8-7-segnalazione-crea-map-ux-fix-satellite-lat-lng.md`
- `laravel/Themes/Sixteen/storage/visual-parity/segnalazione-crea/analysis.json`
- screenshot in `laravel/Themes/Sixteen/docs/screenshots/segnalazione-pages/segnalazione-crea/`

### Guardrail specifici

- Non reintrodurre selettori tipo `.page-content[data-slug="tests.segnalazione-crea"]`.
- Non duplicare logica mappa in Fixcity se il componente corretto vive nel modulo Geo.
- Non forzare un fix solo mobile che degrada desktop.
- Se il fullscreen esiste gia ma "non si vede", trattarlo come problema di UX/CSS/stacking, non come feature da reinventare.
- Se lat/lng risultano gia settati nel codice, verificare runtime reale e percezione utente prima di cambiare contratto.

### Strategia di implementazione raccomandata

1. Screenshot audit.
2. Stepper/sidebar responsive.
3. Spacing step 2.
4. Mappa fullscreen + lat/lng.
5. Header.
6. Multilingua.
7. Quality gate e docs.

---

## Definition of Done

- AC1..AC10 soddisfatti.
- Parity verificata su desktop, tablet e mobile.
- Nessun selettore fragile introdotto.
- Mappa fullscreen e lat/lng funzionanti sulla URL reale del wizard.
- Docs aggiornate con regole anti-regressione.

---

## Dev Agent Record

### Agent Model Used
Codex GPT-5

### Completion Notes List
- Story creata per consolidare parity cross-breakpoint + mappa step 2 in un unico scope operativo.
- Le story precedenti restano fonti di contesto, ma questa diventa la checklist unica di esecuzione.

### File List
- `_bmad-output/implementation-artifacts/8-8-segnalazione-crea-cross-breakpoint-visual-parity-and-map-hardening.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

### Change Log
| Data | Descrizione |
|---|---|
| 2026-04-15 | Creata story 8-8 di consolidamento per parity cross-breakpoint, mappa, header, stepper, multilingua e residual audit dello step 2. |
