# Story 8.6: Pulsante Fullscreen e Centra Posizione nella Mappa Leaflet

**Status**: ready-for-dev
**Epic**: 8 — Tooling & Developer Experience
**Story ID**: 8-6
**Story Key**: 8-6-leaflet-map-fullscreen-and-center-position
**Data creazione**: 2026-04-14

---

## Story

Come **utente che compila il passo 2 del wizard di segnalazione** (`/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`),
voglio vedere nella mappa interattiva un **pulsante per andare in fullscreen** e un **pulsante per centrare la mappa sulla mia posizione corrente** con aggiornamento automatico delle coordinate `latitude` / `longitude`,
così da poter identificare il luogo del disservizio in modo preciso anche su schermi piccoli, senza dover digitare le coordinate manualmente.

---

## Contesto

### Situazione attuale

- **URL di riferimento**: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
- **Componente attivo**: `CreateTicketWizardWidget` usa `LatitudeLongitudeInput::make('location')` (Geo module).
- **Vista del componente**: `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- **Secondo componente**: `LeafletMarkerMapInput` (classe PHP `laravel/Modules/Geo/app/Filament/Forms/Components/LeafletMarkerMapInput.php`, vista `leaflet-marker-map-input.blade.php`) — ha già il pulsante "Usa la tua posizione" ma **non** il fullscreen.

### Cosa manca

| Feature | Status |
|---|---|
| Pulsante **"Centra sulla mia posizione"** (geolocalizzazione) | ⚠️ Presente in `leaflet-marker-map-input.blade.php` ma **assente** in `latitude-longitude-input.blade.php` (il componente attualmente in uso nel wizard) |
| Pulsante **Fullscreen** (espande la mappa a tutto schermo) | ❌ Assente in entrambi i componenti |
| Aggiornamento `latitude` / `longitude` via mappa | ✅ Funzionante (marker drag + click su mappa in `leaflet-marker-map-input`; `wire:model.live` in `latitude-longitude-input`) |

### Quale componente modificare?

Il `CreateTicketWizardWidget` usa `LatitudeLongitudeInput` (vista `latitude-longitude-input.blade.php`). Questo componente ha **già una mappa Leaflet con marker** ma **manca** il pulsante fullscreen e il pulsante "Centra sulla posizione corrente".

> **Nota zen**: `LeafletMarkerMapInput` / `MapLocationInput` sono il componente canonico preferito per "solo mappa + aggiornamento sibling". `LatitudeLongitudeInput` è il componente che include anche i campi numerici latitude/longitude visibili. Il wizard usa `LatitudeLongitudeInput` perché mostra entrambi (mappa + campi). Aggiungere le feature mancanti su `latitude-longitude-input.blade.php`.

### Perché fullscreen è importante

Su mobile (320–600px), la mappa a 340px di altezza è troppo piccola per posizionare il marker con precisione. Il fullscreen permette all'utente di espandere la mappa a tutto schermo, posizionare il marker, e poi uscire con le coordinate aggiornate.

---

## Acceptance Criteria

### AC1 — Pulsante "Centra sulla mia posizione" presente e funzionante

**Given** il passo 2 del wizard (`Dati di segnalazione`) è caricato nel browser,
**When** l'utente visualizza la sezione Luogo con la mappa,
**Then** è visibile un pulsante "Usa la mia posizione" (o equivalente traduzione i18n `geo::address.fields.use_my_location.label`),
**And** cliccando il pulsante, il browser richiede il permesso di geolocalizzazione,
**And** se il permesso è concesso, la mappa si centra sulla posizione corrente, il marker si sposta e i campi `latitude` / `longitude` vengono aggiornati via Livewire.

### AC2 — Pulsante Fullscreen presente e funzionante

**Given** la mappa è visibile nella pagina,
**When** l'utente clicca il pulsante fullscreen (icona espandi, in sovrimpressione sulla mappa — angolo in alto a destra),
**Then** la mappa si espande a tutto schermo (fullscreen nativo del browser tramite Fullscreen API o CSS overlay),
**And** il marker e le tile OSM rimangono visibili e interagibili in fullscreen,
**And** il marker trascinato o il click sulla mappa in fullscreen aggiorna `latitude` / `longitude`,
**And** premendo Esc o il pulsante di uscita si torna alla visualizzazione normale.

### AC3 — latitude e longitude aggiornate correttamente

**Given** l'utente interagisce con la mappa (centra posizione, trascina marker, click),
**When** l'interazione termina,
**Then** i campi `latitude` (range -90/90) e `longitude` (range -180/180) nella vista sono aggiornati con i valori corretti (6 decimali),
**And** i valori si propagano al modello `Ticket` al momento del submit del wizard (step 3 riepilogo mostra `lat, lng`).

### AC4 — Feedback UX durante la geolocalizzazione

**Given** l'utente clicca "Usa la mia posizione",
**When** il browser sta acquisendo la posizione,
**Then** il pulsante mostra uno stato di loading/spinner (disabled + icona animata) per evitare doppi click,
**And** quando la posizione è ottenuta (o fallisce), il pulsante torna allo stato normale,
**And** in caso di errore compare un messaggio user-friendly (non un alert nativo) con chiave `geo::address.geolocation.error`.

### AC5 — Accessibilità e Mobile

**Given** la mappa in modalità normale e fullscreen,
**When** si usa la tastiera o screen reader,
**Then** il pulsante fullscreen ha `aria-label` traducibile (chiave i18n `geo::leaflet_map.actions.fullscreen`),
**And** il pulsante "Centra posizione" ha `aria-label` (chiave `geo::address.fields.use_my_location.label`),
**And** la mappa è responsive e non causa overflow orizzontale su viewport 320px+.

### AC6 — Nessuna regressione

**Given** le modifiche sono applicate,
**When** viene navigata la pagina `/it/tests/segnalazione-crea`,
**Then** la pagina risponde HTTP 200 senza errori Livewire in console,
**And** il wizard completa il submit creando un `Ticket` con `latitude` e `longitude` popolati,
**And** il componente non interferisce con `@once` CSS/JS di altri componenti Leaflet nella stessa pagina.

---

## Tasks / Subtasks

- [ ] **Task 1 — Analisi e scelta dell'implementazione fullscreen**
  - [ ] Valutare se usare il plugin Leaflet Fullscreen (`leaflet.fullscreen`) o l'API nativa `Element.requestFullscreen()`
  - [ ] Scegliere CSS overlay se il plugin non è disponibile su CDN senza asset pipeline
  - [ ] Decisione: preferire **Fullscreen API nativa** (`requestFullscreen` / `exitFullscreen`) per zero dipendenze aggiuntive; aggiungere un pulsante custom sopra la mappa con `position: absolute`

- [ ] **Task 2 — Aggiungere pulsante fullscreen e centra-posizione in `latitude-longitude-input.blade.php`**
  - [ ] Aggiungere i due pulsanti come overlay assoluto sulla mappa (`position: absolute; top: 8px; right: 8px; z-index: 500`)
  - [ ] Fullscreen: pulsante con icona espandi (Bootstrap Italia sprite `#it-fullscreen` oppure SVG inline)
  - [ ] Centra posizione: pulsante con icona mirino/GPS (sprite `#it-pin`) — riusa logica JS già presente in `leaflet-marker-map-input.blade.php`
  - [ ] Lo stato del `<div>` map deve avere `position: relative` per contenere l'overlay
  - [ ] Aggiungere loading state Alpine.js sul pulsante geolocalizzazione (vedi `AddressInput` spinner pattern da story `feat(geo): add spinner UX for location button in AddressInput`)

- [ ] **Task 3 — Logica JS per fullscreen**
  - [ ] Implementare `requestFullscreen()` sul div mappa
  - [ ] Ascoltare `fullscreenchange` per aggiornare icona pulsante (espandi ↔ riduci)
  - [ ] Chiamare `map.invalidateSize()` dopo l'evento `fullscreenchange` per ridisegnare correttamente i tile
  - [ ] Assicurarsi che il drag marker / click mappa aggiorni `latitude` / `longitude` anche in fullscreen

- [ ] **Task 4 — Aggiornare le chiavi i18n**
  - [ ] Aggiungere `geo::leaflet_map.actions.fullscreen` e `geo::leaflet_map.actions.exit_fullscreen` in `laravel/Modules/Geo/lang/it/leaflet_map.php` e `lang/en/leaflet_map.php`
  - [ ] Verificare che `geo::address.fields.use_my_location.label` esiste (già presente in `laravel/Modules/Geo/lang/it/address.php`)

- [ ] **Task 5 — Test smoke e verifica**
  - [ ] Aprire `/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
  - [ ] Verificare visivamente che i due pulsanti siano presenti sulla mappa
  - [ ] Testare "Usa la mia posizione": la mappa si centra e i campi aggiornano
  - [ ] Testare fullscreen: la mappa si espande, interazioni funzionano, Esc esce
  - [ ] Completare il wizard step-by-step e verificare che il `Ticket` creato abbia `latitude` e `longitude`

- [ ] **Task 6 — Documentare in ticket-wizard-frontoffice.md e filament-forms-components.md**
  - [ ] Aggiornare sezione "Geolocalizzazione — mappa + coordinate (step 2)" in `ticket-wizard-frontoffice.md`
  - [ ] Aggiornare `laravel/Modules/Geo/docs/filament-forms-components.md` con nuovi pulsanti e chiavi i18n
  - [ ] Aggiornare `sprint-status.yaml` a `done` al completamento

---

## Dev Notes

### File da toccare

| File | Azione |
|---|---|
| `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php` | Aggiungere overlay pulsanti + logica JS fullscreen + geolocalizzazione spinner |
| `laravel/Modules/Geo/lang/it/leaflet_map.php` | Aggiungere chiavi `actions.fullscreen`, `actions.exit_fullscreen` |
| `laravel/Modules/Geo/lang/en/leaflet_map.php` | Stesse chiavi in inglese |
| `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` | Aggiornare sezione geolocalizzazione |
| `laravel/Modules/Geo/docs/filament-forms-components.md` | Aggiornare documentazione componente |

### File da NON toccare

- `CreateTicketWizardWidget.php` — non serve nessuna modifica PHP, la feature è interamente frontend (Blade + JS)
- `LatitudeLongitudeInput.php` (classe PHP) — non serve aggiungere metodi; i pulsanti sono UI pura nella vista
- `leaflet-marker-map-input.blade.php` — non è il componente in uso nel wizard; non toccare per non rompere altri usi

### Pattern architetturale: overlay pulsanti su mappa Leaflet

```html
<div wire:ignore id="{{ $mapId }}" class="..." style="position: relative; min-height: {{ $height }};">
    <!-- Overlay pulsanti in sovrimpressione -->
    <div style="position: absolute; top: 8px; right: 8px; z-index: 500; display: flex; flex-direction: column; gap: 4px;">
        <!-- Pulsante fullscreen -->
        <button type="button" id="{{ $fullscreenBtnId }}" aria-label="{{ __('geo::leaflet_map.actions.fullscreen') }}"
            class="btn btn-sm btn-light border shadow-sm">
            <!-- icona espandi -->
        </button>
        <!-- Pulsante centra posizione (geolocalizzazione) -->
        <button type="button" id="{{ $btnId }}" aria-label="{{ __('geo::address.fields.use_my_location.label') }}"
            class="btn btn-sm btn-light border shadow-sm">
            <!-- icona GPS/pin -->
        </button>
    </div>
</div>
```

> **Attenzione**: Leaflet usa `z-index` interno per i propri controlli (es. zoom = 1000). Usare `z-index: 500` mette i pulsanti sopra i tile ma sotto i popup Leaflet nativi — comportamento corretto.

### Pattern JS fullscreen

```javascript
var fullscreenBtn = document.getElementById(fullscreenBtnId);
fullscreenBtn.addEventListener('click', function () {
    if (!document.fullscreenElement) {
        el.requestFullscreen().catch(function (err) {
            console.warn('Fullscreen non disponibile:', err);
        });
    } else {
        document.exitFullscreen();
    }
});

document.addEventListener('fullscreenchange', function () {
    var isFs = !!document.fullscreenElement;
    // aggiorna aria-label e icona del pulsante
    fullscreenBtn.setAttribute('aria-label',
        isFs ? @json(__('geo::leaflet_map.actions.exit_fullscreen'))
             : @json(__('geo::leaflet_map.actions.fullscreen'))
    );
    // CRITICO: ridisegnare la mappa dopo il cambio dimensione
    setTimeout(function () { map.invalidateSize(); }, 100);
});
```

### Pattern geolocalizzazione con spinner (da commit `4975e5f04`)

Usare Alpine.js `x-data` con stato `loading`:

```html
<button type="button" id="{{ $btnId }}"
    x-data="{ loading: false }"
    :disabled="loading"
    x-on:click="loading = true; $el.dispatchEvent(new CustomEvent('geo-locate'))">
    <span x-show="!loading"><!-- icona GPS --></span>
    <span x-show="loading" class="spinner-border spinner-border-sm" role="status"></span>
</button>
```

Il listener JS `geo-locate` chiama `navigator.geolocation.getCurrentPosition(...)` e resetta `loading = false` al termine.

### Componente attivo nel wizard

```
CreateTicketWizardWidget::getDataSchema()
  └── LatitudeLongitudeInput::make('location')
        └── vista: geo::filament.forms.components.latitude-longitude-input
              └── FILE: latitude-longitude-input.blade.php  ← qui si interviene
```

Il componente ha due `wire:model.live` sui campi `latitude` e `longitude`:
- `wire:model.live="{{ $statePath }}.latitude"`
- `wire:model.live="{{ $statePath }}.longitude"`

Questi aggiornano direttamente il Livewire state. La logica JS deve usare la stessa tecnica o il metodo `$wire.set()` per consistenza con il drag marker già implementato.

### Stato `location` vs `latitude` / `longitude`

In `prepareTicketData()`:
```php
if (isset($state['location']) && is_array($state['location'])) {
    // Estrae latitude/longitude dal nested array
}
```

Il `LatitudeLongitudeInput` è `dehydrated(false)` ma ha figli `latitude` e `longitude` nello schema: queste vengono salvate in `data.wizard.location.latitude` e `data.wizard.location.longitude`. Il `prepareTicketData()` le estrae correttamente. Non modificare questa logica.

### i18n — nuove chiavi necessarie

In `laravel/Modules/Geo/lang/it/leaflet_map.php`:
```php
'actions' => [
    'fullscreen' => 'Espandi mappa a tutto schermo',
    'exit_fullscreen' => 'Riduci mappa',
],
```

In `laravel/Modules/Geo/lang/en/leaflet_map.php`:
```php
'actions' => [
    'fullscreen' => 'Expand map to fullscreen',
    'exit_fullscreen' => 'Exit fullscreen',
],
```

### Dipendenze

- **Leaflet.js 1.9.4** — già caricato via CDN nel `@once` del blade (con SRI integrity)
- **Fullscreen API** — nativa nei browser moderni (`requestFullscreen` / `exitFullscreen`); nessun plugin aggiuntivo necessario
- **Alpine.js** — già disponibile tramite Filament/Livewire; usare per spinner geolocalizzazione
- **Bootstrap Italia sprites** — già disponibili; usare `#it-fullscreen` o SVG inline per le icone
- **Nessun npm install aggiuntivo richiesto**

### Guardrail anti-regressione

1. Il div mappa ha `wire:ignore` — il codice JS NON deve rimuovere o rimpiazzare il div; solo aggiungere il div overlay pulsanti prima della chiusura.
2. `@once` Leaflet CSS/JS deve rimanere per evitare doppio caricamento se due componenti mappa sono in pagina.
3. Il flag `data-geo-leaflet-ready='1'` è già presente in `leaflet-marker-map-input.blade.php`; verificare se è presente anche in `latitude-longitude-input.blade.php` (non risulta dal codice letto — aggiungerlo per idempotenza su `livewire:navigated`).
4. Chiamare `map.invalidateSize()` dopo `fullscreenchange` è **obbligatorio** — senza di esso i tile non coprono la nuova dimensione.

---

## Dev Agent Record

### Agent Model Used

claude-sonnet-4-6

### Debug Log References

- URL reale con mappa: `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=form.dati-della-segnalazione%3A%3Adata%3A%3Awizard-step`
- Componente PHP attivo: `LatitudeLongitudeInput` (non `LeafletMarkerMapInput`)
- Vista attiva: `latitude-longitude-input.blade.php` — ha mappa + campi lat/lng ma manca fullscreen e il pulsante centra-posizione è presente solo nell'altro blade
- `leaflet-marker-map-input.blade.php` ha il pulsante "Usa la tua posizione" ma **non** il fullscreen
- `Ticket::$fillable` include `latitude` e `longitude` (stringhe)
- `latitude_longitude_input.php` lang ha chiavi vuote (`'label' => 'latitude'`) — non usarle, usare `geo::address.*` e `geo::coordinates.*`

### Completion Notes List

(da compilare durante l'implementazione)

### File List

- `laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input.blade.php`
- `laravel/Modules/Geo/lang/it/leaflet_map.php`
- `laravel/Modules/Geo/lang/en/leaflet_map.php`
- `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md`
- `laravel/Modules/Geo/docs/filament-forms-components.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

---

## Change Log

| Data | Descrizione |
|---|---|
| 2026-04-14 | Story 8-6 creata per aggiungere pulsante fullscreen e centra-posizione alla mappa Leaflet nel wizard segnalazione-crea (step 2). Analisi completa di LatitudeLongitudeInput, LeafletMarkerMapInput e ticket-wizard-frontoffice.md. |
