---
title: "Mappa di sola lettura (point-map e CoordinatePicker readOnly)"
tags: [geo, map, lit, leaflet, readonly, a11y, wizard]
created: 2026-10-13
updated: 2026-10-13
qmd: "point-map readonly mappa sola lettura coordinate-picker-lit readOnly riepilogo wizard"
issues: []
discussions: []
name: point-map-readonly
description: Come mostrare un punto su mappa senza poterlo modificare (riepilogo del wizard segnalazioni)
type: concept
story: laravel/Modules/Fixcity/docs/stories/dcp-33-tickets-create-riepilogo-design-comuni-mappa.story.md
status: draft
---

# Mappa di sola lettura

Il `CoordinatePicker` del passo dati resta l'**unico editor** del punto. Dove serve solo *mostrare* il punto
(riepilogo, scheda ticket) si usa una mappa di sola lettura: stesso web component `coordinate-picker-lit`, attributo `readonly`.

## Due modi, un solo meccanismo

| Uso | Come |
|---|---|
| Vista Blade (tema, widget) | `<x-geo::point-map :latitude="$lat" :longitude="$lng" :address="$address" />` |
| Schema Filament (back office) | `CoordinatePicker::make('location')->readOnly()` (anche `->disabled()` o schema disabilitato) |

Entrambi emettono `<coordinate-picker-lit readonly ...>`. Il Lit applica `readonly`; il Blade del campo lo passa quando
`CoordinatePicker::isMapReadonly()` e' vero (`isDisabled() || isReadOnly()`). Prima di DCP-33 il Blade ignorava `disabled`.

## `<x-geo::point-map>`

Classe `Modules\Geo\View\Components\PointMap`, vista `geo::components.point-map`.

| Prop | Default | Note |
|---|---|---|
| `latitude`, `longitude` | `null` | numeri o stringhe numeriche; fuori intervallo o non numerici = nessun punto. `0` e' valido |
| `address` | `null` | solo testo (escapato) |
| `zoom` | `16` | 1-19 |
| `height` | `16rem` | solo `NNpx/rem/em/vh/%`, altrimenti il default (finisce in uno stile inline) |
| `label` | "Posizione sulla mappa" (lang `geo::point-map.default_label`) | nome della regione |
| `id` | casuale `geo-point-map-xxxxxxxx` | due istanze nella stessa pagina non collidono |

Altri attributi (`class`, `data-element`, ...) vanno sul contenitore. Esempio nel riepilogo, con il nodo che il gate di
parity nasconde:

```blade
<div data-element="ticket-review-map">
    <x-geo::point-map :latitude="$report['location']['latitude']" :longitude="$report['location']['longitude']"
        :address="$report['location']['address']" label="{{ __('...') }}" />
</div>
```

### Cosa emette

- Con punto: `div#id[role=region][aria-label="<label>: <indirizzo>"]` (senza indirizzo: coordinate) che contiene
  `div[wire:ignore]` con il web component e una didascalia testuale **visibile**: indirizzo, latitudine, longitudine,
  link "Apri in OpenStreetMap" (`target=_blank rel="noopener noreferrer"`, con avviso "nuova scheda" nel testo) e
  attribuzione `© OpenStreetMap`. La didascalia c'e' anche senza JS e per i lettori di schermo.
- Senza punto: `<p class="geo-point-map geo-point-map--empty">Posizione non indicata</p>` (nessun web component, nessun errore).
- `wire:key` = hash del contenuto (stabile tra i render Livewire, cambia solo se cambia il punto, cosi' la mappa si rimonta
  nel punto nuovo; `wire:ignore` impedirebbe l'aggiornamento degli attributi). Due istanze con lo **stesso** punto nello
  stesso componente Livewire devono avere `id` esplicito (`wire:key` = `id`).
- Nessuno stile per slug di pagina: solo stili inline minimi e classi `geo-point-map*`. Nessuna build CSS richiesta per il PHP/Blade.

## Contratto `readonly` del Lit (`coordinate-picker-lit`)

| Cosa | In `readonly` |
|---|---|
| Stato / evento `coords-changed` | mai scritto: `handleMapInteraction` esce subito (unico punto di scrittura: click, drag, ricerca, geolocalizzazione) |
| Marker | `draggable:false`, `interactive:false`, `keyboard:false` (niente `role=button`/`tabindex`) |
| Click sulla mappa | nessun handler registrato |
| Ricerca, geolocalizzazione, fullscreen, cambio livello | non resi; nessuna geolocalizzazione automatica se mancano le coordinate |
| Tastiera | `keyboard:false` sulla mappa (niente tab stop sul contenitore Leaflet) |
| Rotella | `scrollWheelZoom:false` (la mappa non cattura lo scroll della pagina) |
| Pan, doppio click, pinch, pulsanti +/- | attivi |
| Reverse geocoding | mai chiamato (nessuna richiesta a Nominatim) |

`readonly` va impostato prima del primo render (come attributo). Un cambio di stato dall'esterno (`state`) riposiziona
marker e vista come nel picker normale.

## Accessibilita'

- Regione con `aria-label` che include indirizzo (o coordinate); la mappa Leaflet non ha testo, l'alternativa e' la didascalia.
- Nessuna trappola di focus: gli unici controlli focalizzabili sono i due pulsanti zoom (con `aria-label` tradotti) e i link.
- Non usare `role="img"` sul contenitore: i pulsanti zoom sono interattivi e diventerebbero figli presentazionali.

## Come si verifica

1. Pest (contratto PHP/Blade): `cd laravel && APP_ENV=testing DB_CONNECTION=sqlite APP_CONFIG_CACHE=/tmp/xxx-nonexistent.php ./vendor/bin/pest Modules/Geo/tests/Unit/View/Components/PointMapTest.php Modules/Geo/tests/Unit/Filament/Forms/Components/CoordinatePickerReadOnlyTest.php`
   (la config cache farebbe ignorare `.env.testing`: vedi memoria `pest-hits-dev-db-config-cache`). I test usano
   `Blade::render(..., deleteCachedView: true)` perche' il template stringa compilato resta in `storage/framework/views`.
2. Browser (comportamento JS, non testabile con Pest): su una pagina con la mappa gia' compilata verificare con Playwright o DevTools:
   - `el.readonly === true`, `el._marker.dragging` assente (`.leaflet-marker-draggable` e `.leaflet-interactive` assenti, niente `tabindex`/`role` sul marker);
   - click e drag sul marker/mappa: `el.state` identico, nessun `coords-changed`, nessuna richiesta a `nominatim.openstreetmap.org`;
   - doppio click e pulsante `+` aumentano lo zoom; trascinando la mappa cambia il centro ma non il marker; la rotella non zooma;
   - solo 2 `.ctrl-btn`, nessun `input`, nessun `[tabindex]` sul `.leaflet-container`;
   - nessun messaggio console `error`/`warning`; nessun id duplicato con due istanze.
   Prova del 2026-10-13 con il sorgente impacchettato in uno scratchpad (`esbuild`, plugin `?raw`, loader png dataurl, tile e
   Nominatim intercettati) e un controllo non `readonly` nella stessa pagina (marker `draggable`, click che scrive lo stato:
   `coords-changed` x2 e una richiesta Nominatim): tutti i punti sopra verificati sul componente `readonly`.

## Build richieste dopo la modifica del Lit

Il sorgente `resources/js/components/coordinate-picker-lit.js` (e `map/*`) ha due consumatori, ciascuno con la sua build:

| Dove | Build | Note |
|---|---|---|
| Front office (wizard `/it/tickets/create`, riepilogo) | **tema Sixteen**: `cd Themes/Sixteen && npm run build` (poi `view:clear`) | il bundle del tema importa il sorgente Geo con l'alias `@modules` (`resources/js/app.js`) |
| Back office Filament (`CoordinatePicker->readOnly()`/`disabled()`) | **Geo**: `cd Modules/Geo && npm run build && npm run copy` | `AdminPanelProvider` carica `public_html/assets/geo` (`Vite::asset(..., 'assets/geo')`); il modulo Geo oggi non ha `node_modules` |

Il Blade/PHP (`point-map`, `isMapReadonly()`) non richiede build, solo `view:clear` per i Blade compilati. Senza la build il
web component vecchio ignora `readonly`: la mappa resta modificabile (il Blade nuovo non rompe nulla, ma non e' ancora di sola lettura).

## Registrazione del namespace Blade (nota di architettura)

`XotBaseServiceProvider::register()` deriva `$module_ns` dal proprio namespace: `GeoServiceProvider` non lo ridefinisce
(a differenza di Fixcity, Cms, User, ...), quindi la base registrava `geo` -> `Modules\Xot\View\Components`.
`GeoServiceProvider::boot()` ora chiama `Blade::componentNamespace('Modules\Geo\View\Components', 'geo')`, necessario a
`<x-geo::point-map>` per trovare la classe. Stesso difetto per altri moduli senza `$module_ns` (AI, Activity, Mobile): fuori scope.

## Limiti noti

- `readonly` non e' reattivo dopo il primo render.
- Il Lit ha `min-height: 200px`: sotto `12.5rem` l'altezza non scende.
- Pan con un dito su mobile cattura lo scroll dentro la mappa (16rem): se disturba, `dragging: !L.Browser.mobile` in `initMap` per `readonly`.
- Le tile sono quelle OSM (`tile.openstreetmap.org`); `attributionControl` resta spento nel Lit, l'attribuzione e' nella didascalia.
