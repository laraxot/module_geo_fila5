# Story 8.11: segnalazione-crea step 2 — mobile-first data entry con mappa a coordinate e governance Filament

**Status**: ready-for-dev  
**Epic**: 8 — Tooling & Developer Experience  
**Story ID**: 8-11  
**Story Key**: 8-11-segnalazione-crea-mobile-first-data-entry-with-map-coordinates-and-filament-governance  
**Data creazione**: 2026-04-15  
**Dipendenze**: 7-29, 7-51, 7-52, 8-7, 8-8, 8-9, 8-10

---

## Story

Come **cittadino che compila dal cellulare lo step 2 della segnalazione**,
voglio una UI/UX mobile-first chiara, stabile e veloce per inserire i dati della segnalazione,
con mappa e coordinate sempre sincronizzate,
così da poter indicare il luogo del disservizio e completare il form senza che la visualizzazione si rompa.

URL target:
- `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`

Reference UX:
- `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`

Differenza funzionale voluta rispetto al reference:
- il reference usa un **indirizzo**;
- il nostro flusso usa una **mappa** e salva **coordinate** (`latitude` / `longitude`) al posto dell’indirizzo testuale.

---

## Comprensione funzionale corretta della pagina

Questa pagina **non è una demo grafica**.  
È il passo reale in cui l’utente inserisce i dati essenziali della segnalazione:

1. **Luogo del disservizio**  
   con mappa interattiva e coordinate persistite;
2. **Tipo e dettagli del disservizio**  
   con campi Filament validati;
3. **Autore della segnalazione**  
   con blocchi read-only e pochi input necessari.

Poiché il caso d’uso reale è **mobile-first** e “nel 90% dei casi da cellulare”, la priorità UX è:
- densità corretta;
- controlli grandi e chiari;
- stepper leggibile;
- mappa robusta alle interazioni touch;
- nessun refresh distruttivo;
- nessuna perdita di contesto.

---

## Vincolo architetturale non negoziabile

Wizard, stepper, form, grid e infolist restano **Filament-first**.

Questo non è un dettaglio tecnico, è la regola di prodotto/architettura:
- `Wizard` / `Step` = macchina a stati del flusso;
- `Section`, `Grid`, `Text`, `Infolist` = semantica dei contenuti;
- Blade = shell/editorial parity layer;
- Geo custom field = comportamento mappa.

Quindi:
- **non** si torna a un wizard Blade custom;
- **non** si reinventa lo stepper fuori da Filament come source of truth;
- **non** si scaricano workaround UX dentro il dominio Fixcity se il problema è nel field Geo o nel CSS del tema.

---

## Problema consolidato

La segnalazione utente attuale è chiara:

> “hai capito cosa deve fare questa pagina? qui si mettono i dati di una segnalazione, quasi sempre da cellulare… la differenza è che noi usiamo una mappa e salviamo coordinate… ora appena sposta la mappa si spacca tutta la visualizzazione.”

Questa frase implica quattro failure critiche:

1. la pagina non sta rispettando il suo vero uso **mobile-first**;
2. la mappa non è trattata come il centro del task `Luogo`;
3. la parity col reference è solo parziale e non guidata dallo scopo reale;
4. spostando la mappa/marker **si rompe la visualizzazione**, quindi il flusso principale fallisce.

---

## Regola / Visione / Filosofia / Religione / Politica / Zen

### Regola
- lo step 2 è una **pagina di inserimento dati mobile-first**;
- la parity visuale va subordinata alla robustezza del flusso;
- il wizard resta governato da Filament;
- la mappa è un field Geo, non un widget casuale nel mezzo della pagina.

### Visione
- Design Comuni è il riferimento per gerarchia, ritmo e affordance;
- Filament è il riferimento per struttura e strumenti;
- il nostro valore aggiunto è l’uso delle **coordinate** invece dell’indirizzo.

### Scopo
- permettere all’utente di completare rapidamente il luogo del disservizio da smartphone;
- rendere la UI istituzionale ma pratica;
- evitare qualsiasi rottura della visualizzazione durante l’interazione con la mappa.

### Filosofia
- parity dove migliora comprensione;
- customizzazione dove serve al dominio;
- niente doppie verità tra markup, JS locale e stato Livewire.

### Religione tecnica
- Filament per struttura e flusso;
- Geo per la mappa;
- Theme Sixteen per parity e breakpoint;
- Docs canoniche come memoria viva, non file duplicati.

### Politica
- niente fix opportunistici che fanno “sembrare” giusta la pagina ma la lasciano fragile;
- niente regressioni desktop mentre si corregge mobile;
- niente workaround che aggirano Filament invece di integrarsi bene con esso.

### Zen
- il compito dell’utente è semplice: scegliere il luogo, inserire il disservizio, confermare;
- ogni elemento che rompe questo flusso è rumore da eliminare.

---

## Acceptance Criteria

### AC1 — Mobile-first usabile davvero
**Given** uno smartphone come viewport principale  
**When** apro lo step 2  
**Then** la pagina è usabile senza pinch-zoom o letture faticose  
**And** il layout favorisce inserimento rapido dei dati.

### AC2 — Mappa come centro del task Luogo
**Given** la sezione `Luogo`  
**When** l’utente entra nello step 2  
**Then** la mappa è immediatamente visibile, stabile e comprensibile  
**And** marker, center e coordinate sono coerenti.

### AC3 — Nessuna rottura visuale al movimento mappa
**Given** l’utente trascina il marker o interagisce con la mappa  
**When** la posizione cambia  
**Then** la visualizzazione non si rompe  
**And** non spariscono né la mappa né il marker  
**And** non avviene refresh distruttivo della pagina.

### AC4 — Coordinate al posto dell’indirizzo, ma UX equivalente o migliore
**Given** il reference Design Comuni usa indirizzo testuale  
**When** adatto il flusso al nostro dominio coordinate-based  
**Then** l’esperienza resta chiara almeno quanto il reference  
**And** l’utente capisce come confermare il luogo del servizio.

### AC5 — Stepper/wizard/form/grid/infolist Filament-first
**Given** il refactor/fix dello step 2  
**When** verifico l’implementazione  
**Then** wizard, stepper, form, grid e infolist restano costruiti secondo governance Filament  
**And** Blade non reimplementa la macchina a stati.

### AC6 — Docs e indici anti-ridondanza aggiornati
**Given** la patch pronta  
**When** aggiorno la documentazione  
**Then** i docs canonici spiegano chiaramente:
- scopo mobile-first dello step 2;
- differenza coordinate vs indirizzo;
- motivazione Filament-first;
- regola anti-refresh distruttivo della mappa.

---

## Tasks / Subtasks

### [ ] 1. Allineamento story context al vero compito della pagina
- [ ] 1.1. Esplicitare che lo step 2 è un form dati di segnalazione mobile-first
- [ ] 1.2. Esplicitare che il reference guida la UX, ma il dominio salva coordinate
- [ ] 1.3. Ribadire che wizard/stepper/form/grid/infolist sono Filament-first

### [ ] 2. Mappa come failure critica del flusso
- [ ] 2.1. Trattare il “si spacca tutta la visualizzazione” come blocker P0
- [ ] 2.2. Collegare il problema al protocollo Livewire/Filament/Geo
- [ ] 2.3. Richiedere fix senza rollback a soluzioni custom Blade

### [ ] 3. UX mobile-first dello step 2
- [ ] 3.1. Valutare densità, ordine, gerarchia e affordance su smartphone
- [ ] 3.2. Verificare che `Luogo` sia un task semplice e non rumoroso
- [ ] 3.3. Garantire che i campi successivi non perdano leggibilità

### [ ] 4. Documentazione e indici
- [ ] 4.1. Aggiornare docs canonici Fixcity/Geo/Sixteen pertinenti
- [ ] 4.2. Evitare file ridondanti e rafforzare gli indici esistenti
- [ ] 4.3. Aggiornare `sprint-status.yaml`

---

## File target previsti

- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Dev Notes

### Contesto da riusare

- `_bmad-output/implementation-artifacts/8-10-segnalazione-crea-map-bidirectional-sync-and-no-refresh-on-marker-drag.md`
- `_bmad-output/implementation-artifacts/8-9-segnalazione-crea-step2-map-visibility-spacing-and-desktop-header-guard.md`
- `_bmad-output/implementation-artifacts/8-8-segnalazione-crea-cross-breakpoint-visual-parity-and-map-hardening.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`
- `laravel/Modules/Geo/docs/filament-forms-components.md`

### Guardrail specifici

- Non ridurre il problema a “fix CSS mappa”.
- Non trattare la parity col reference come copia cieca dell’indirizzo testuale.
- Non introdurre nuova logica wizard fuori Filament.
- Non aggiungere file docs doppi se il documento canonico esiste già.

---

## Definition of Done

- story context corretto sul vero uso mobile-first della pagina;
- differenza reference-vs-dominio coordinate chiarita;
- governance Filament-first esplicitata;
- bug mappa trattato come failure critica del flusso;
- docs/indici aggiornati senza ridondanze;
- story pronta per implementazione o review.

---

## Dev Agent Record

### Agent Model Used
Codex GPT-5

### Completion Notes List
- Story creata per descrivere correttamente lo step 2 come pagina mobile-first di inserimento dati segnalazione, con mappa coordinate-based e governance Filament-first.

### File List
- `_bmad-output/implementation-artifacts/8-11-segnalazione-crea-mobile-first-data-entry-with-map-coordinates-and-filament-governance.md`

### Change Log
| Data | Descrizione |
|---|---|
| 2026-04-15 | Creata story 8-11 per esplicitare il vero scopo della pagina step 2, la differenza coordinate-vs-indirizzo e il vincolo Filament-first con bug mappa come failure critica del flusso. |
