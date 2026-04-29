# Story 8.10: segnalazione-crea step 2 — sync bidirezionale mappa/input e stop refresh distruttivo al drag marker

**Status**: review  
**Epic**: 8 — Tooling & Developer Experience  
**Story ID**: 8-10  
**Story Key**: 8-10-segnalazione-crea-map-bidirectional-sync-and-no-refresh-on-marker-drag  
**Data creazione**: 2026-04-15  
**Dipendenze**: 8-5, 8-6, 8-7, 8-8, 8-9

---

## Story

Come **utente che usa la mappa nello step 2 del wizard Filament pubblico**,
voglio che lo spostamento del marker non provochi refresh distruttivi della pagina,
che mappa, marker e input `latitudine` / `longitudine` siano sempre sincronizzati,
e che modificando manualmente le coordinate la mappa si ricentri su quei valori,
così da poter scegliere e correggere la posizione senza perdere il contesto visivo.

URL target:
- `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`

---

## Problema consolidato

L'analisi utente segnala tre regressioni UX/runtime strettamente collegate:

1. **appena sposti il marker si refresha la pagina**;
2. dopo il refresh distruttivo **non si vede più né la mappa né il marker**;
3. all'apertura e durante l'editing non esiste un vero **sync bidirezionale** tra:
   - posizione corrente della mappa,
   - marker,
   - input `latitudine` / `longitudine`.

In particolare:
- all'apertura, marker e input devono rappresentare **la stessa posizione corrente**;
- al drag/click/geolocalizzazione, input e marker devono aggiornarsi insieme;
- se l'utente modifica manualmente `latitudine` o `longitudine`, la mappa deve **ricentrarsi** e il marker deve spostarsi su quelle coordinate.

---

## Causa probabile da verificare

Il componente attuale `LatitudeLongitudeInput` combina:
- `wire:model.live` sui campi input;
- aggiornamenti JS via `wire.set()` / `$set()` durante drag e click;
- reattività Livewire/Filament nello stesso field render path.

Questa combinazione può generare:
- **re-render Livewire troppo aggressivo** del componente;
- perdita dell'istanza Leaflet o del DOM `wire:ignore` se il wrapper cambia;
- doppio source of truth tra JS locale e stato Livewire;
- assenza di listener inverso input → mappa, quindi i campi testuali non guidano la mappa.

Questa story esiste per chiudere il problema alla radice, non solo per attenuarne i sintomi.

---

## Regola / Visione / Filosofia / Zen

- La mappa è un **custom field Geo-owned** che vive dentro un wizard Filament: deve essere **reattivo ma non distruttivo**.
- `wire:ignore` protegge la shell mappa, ma non basta se il protocollo di sync è progettato male.
- Il componente deve avere **una strategia chiara di sincronizzazione**:
  - inizializzazione coerente,
  - push JS → Livewire,
  - pull input → mappa,
  - reinit idempotente se Livewire tocca il parent.
- Nessun workaround che scarichi la colpa sul wizard: il problema è nel contratto di integrazione field ↔ Livewire ↔ Leaflet.

In sintesi:
- **regola**: un solo protocollo di sync, non eventi ridondanti in conflitto;
- **visione**: la mappa è parte del form, non un iframe decorativo;
- **politica**: niente refresh distruttivi su interazioni locali del marker;
- **zen**: marker, input e center devono raccontare la stessa verità.

---

## Acceptance Criteria

### AC1 — Nessun refresh distruttivo al drag marker
**Given** l'utente trascina il marker sulla mappa  
**When** il drag termina o mentre il marker si muove  
**Then** la pagina non effettua refresh distruttivi o re-render che nascondono mappa e marker  
**And** l'istanza Leaflet rimane visibile e usabile.

### AC2 — Stato iniziale coerente all'apertura
**Given** la mappa viene aperta nello step 2  
**When** il componente viene inizializzato  
**Then** marker, center mappa e input `latitudine` / `longitudine` rappresentano la stessa posizione iniziale  
**And** se lo stato Livewire contiene coordinate, queste hanno precedenza sul default center.

### AC3 — Sync mappa → input
**Given** l'utente clicca la mappa, trascina il marker o usa la geolocalizzazione  
**When** l'interazione termina  
**Then** gli input `latitudine` / `longitudine` si aggiornano correttamente  
**And** il valore persistito nello stato Livewire corrisponde al marker finale.

### AC4 — Sync input → mappa
**Given** l'utente modifica manualmente `latitudine` o `longitudine`  
**When** i valori diventano validi numericamente  
**Then** la mappa si ricentra su quelle coordinate  
**And** il marker si sposta nella nuova posizione  
**And** non avviene alcun refresh distruttivo.

### AC5 — Idempotenza su re-render Livewire
**Given** il parent Livewire/Filament viene aggiornato  
**When** il field viene rivalutato  
**Then** il componente mappa non perde stato inutilmente  
**And** eventuale re-init è idempotente, senza doppie istanze o shell vuote.

### AC6 — Documentazione anti-regressione
**Given** la patch conclusa  
**When** aggiorno i docs canonici  
**Then** viene chiarita la regola di sync bidirezionale del `LatitudeLongitudeInput`  
**And** viene documentato il motivo per cui il drag marker non deve usare un protocollo che forza re-render distruttivi.

---

## Tasks / Subtasks

### [x] 1. Diagnosi protocollo di sync
- [x] 1.1. Analizzare il mix `wire:model.live` + `wire.set()` + `wire:ignore`
- [x] 1.2. Capire se il refresh nasce da update troppo frequenti (`drag`) o da re-render del field wrapper
- [x] 1.3. Identificare il source of truth corretto per marker, center e input

### [x] 2. Stop refresh distruttivo
- [x] 2.1. Ridurre o ridefinire gli update Livewire durante il drag
- [x] 2.2. Applicare sync locale durante `drag` e sync persistente su `dragend` se necessario
- [x] 2.3. Garantire che la shell `wire:ignore` non venga invalidata da update evitabili

### [x] 3. Stato iniziale coerente
- [x] 3.1. Allineare center iniziale, marker iniziale e input iniziali
- [x] 3.2. Dare priorità alle coordinate già presenti nello stato Livewire
- [x] 3.3. Evitare fallback incoerenti tra default center e valori input

### [x] 4. Sync bidirezionale completo
- [x] 4.1. Mappa/marker → input + Livewire
- [x] 4.2. Input → marker + center mappa
- [x] 4.3. Validazione minima su coordinate numeriche e range validi

### [x] 5. Verifica runtime e docs
- [x] 5.1. Test sulla URL reale con drag marker, click mappa, geolocalizzazione, modifica input
- [x] 5.2. Aggiornare docs Geo e Fixcity pertinenti
- [x] 5.3. Aggiornare `sprint-status.yaml`

---

## File target previsti

- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md`
- `laravel/Themes/Sixteen/docs/design-comuni/TICKET-CREATION-WIZARD.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Dev Notes

### Contesto da riusare

- `_bmad-output/implementation-artifacts/8-5-add-lat-lon-map-component.md`
- `_bmad-output/implementation-artifacts/8-6-leaflet-map-fullscreen-and-center-position.md`
- `_bmad-output/implementation-artifacts/8-7-segnalazione-crea-map-ux-fix-satellite-lat-lng.md`
- `_bmad-output/implementation-artifacts/8-8-segnalazione-crea-cross-breakpoint-visual-parity-and-map-hardening.md`
- `_bmad-output/implementation-artifacts/8-9-segnalazione-crea-step2-map-visibility-spacing-and-desktop-header-guard.md`
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`

### Guardrail specifici

- Non spostare logica Geo nel widget Fixcity.
- Non sostituire il wizard Filament con JS custom di navigazione.
- Non risolvere il problema disattivando brutalmente la reattività degli input senza ripristinare il sync bidirezionale.
- Non introdurre doppi source of truth non documentati.

### Note implementative da tenere presenti

- `drag` e `dragend` non devono avere lo stesso peso sul protocollo di persistenza.
- Se l'update Livewire durante `drag` distrugge il field, il sync continuo deve restare locale e quello persistente va spostato su evento più stabile.
- Gli input numerici devono essere ascoltati anche in direzione inversa per centrare la mappa.

---

## Definition of Done

- nessun refresh distruttivo su drag marker;
- mappa, marker e input sempre allineati all'apertura;
- input → mappa funzionante;
- docs canoniche aggiornate;
- story pronta per implementazione o review.

---

## Dev Agent Record

### Agent Model Used
Claude Haiku 4.5

### Completion Notes List
- ✅ **AC1**: Nessun refresh distruttivo al drag marker — implementato via change event dispatch invece di wire.set() diretto
- ✅ **AC2**: Stato iniziale coerente — coordinate Livewire hanno precedenza su default, commit solo se defaults usati
- ✅ **AC3**: Sync mappa/marker → input — throttling 200ms durante drag, full sync su dragend via commitCoordinates()
- ✅ **AC4**: Sync input → mappa — listeners su change event ricentrano mappa e spostano marker, nessun refresh distruttivo
- ✅ **AC5**: Idempotenza su re-render — global instance registry, wire:ignore shell, isProgrammaticInputUpdate flag prevengono doppie inizializzazioni
- ✅ **AC6**: Documentazione anti-regressione — updated filament-forms-components.md e ticket-wizard-frontoffice.md con technical rules e sync protocol

### Implementation Details
**File modificato principale**: `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- **Lines 282-289**: Initial state handling — prioritizes Livewire state over defaults, only commits if defaults used
- **Lines 331-357**: Throttled drag handling — 200ms throttle on DOM updates during drag, full sync on dragend
- **Lines 547-575**: setInputValues() method — uses isProgrammaticInputUpdate flag to prevent circular sync
- **Lines 577-597**: commitCoordinates() method — dispatches change events on inputs instead of wire.set() calls
- **Lines 361-406**: Input change listeners — syncMapFromInputs() with 160ms throttle for input preview

**Protocollo Tecnico**:
- Marker drag → currentLat/currentLng (memory) → throttled setInputValues() (DOM) → dragend → commitCoordinates() (change event) → wire:model.change (Livewire)
- Input change → syncMapFromInputs() → marker.setLatLng() + map.setView() → commitCoordinates() (if commit=true)
- Initialization → parse Livewire state, set marker/map center, sync inputs, commit only if using defaults

### File List
- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php` (MODIFIED)
- `laravel/Modules/Geo/docs/filament-forms-components.md` (MODIFIED — section 3 LatitudeLongitudeInput enhanced with anti-regression rules)
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` (MODIFIED — "Regola mappa step 2" section updated with story 8-10 reference and technical rules)
- `_bmad-output/implementation-artifacts/sprint-status.yaml` (MODIFIED — 8-10 status changed to review)

### Change Log
| Data | Descrizione |
|---|---|
| 2026-04-15 | Creata story 8-10 focalizzata su refresh al drag marker, stato iniziale coerente e sync bidirezionale mappa/input nello step 2 del wizard. |
| 2026-04-15 | Implementazione completata: risolto refresh distruttivo via change event protocol, stato iniziale coerente, sync bidirezionale marker/input/Livewire verificato, documentazione anti-regressione aggiornata. |
