# SVG Asset Architecture — Regola Universale Moduli

## REGOLA PERMANENTE (2026-04-20)

```
OBBLIGATORIO: laravel/Modules/{NomeModulo}/resources/svg/{nome}.svg
VIETATO: resources/img/, public/images/, public/vendor/, assets/
```

Tutti gli SVG di un modulo stanno in `resources/svg/` — nessuna eccezione.

## Esempi già presenti nel progetto

```
laravel/Modules/Activity/resources/svg/icon.svg
laravel/Modules/Activity/resources/svg/loading.svg
laravel/Modules/User/resources/svg/role.svg
laravel/Modules/User/resources/svg/user-profile.svg
```

## SVG del modulo Geo

Per marker MapPicker e icone geografiche:

```
laravel/Modules/Geo/resources/svg/map-marker.svg        ← marker principale
laravel/Modules/Geo/resources/svg/map-marker-active.svg ← marker selezionato (opzionale)
```

**Non** in: ~~`resources/img/markers/`~~ ~~`public/images/`~~

## Come usarli

### 1. SVG inline in JS/Lit (preferito per marker Leaflet)

```javascript
// Importa raw con Vite
import markerSvg from '../../../svg/map-marker.svg?raw';

// Usa in L.divIcon
L.divIcon({ html: markerSvg, className: 'map-picker-marker', iconSize: [32, 45], iconAnchor: [16, 45] });
```

### 2. SVG inline in Blade

```blade
{!! file_get_contents(module_path('Geo', 'resources/svg/map-marker.svg')) !!}
```

### 3. SVG come URL pubblico (dopo vendor:publish)

```
php artisan vendor:publish --tag=geo-assets
→ public/vendor/geo/svg/map-marker.svg
```

## Naming convention

- kebab-case: `map-marker.svg`, `geo-icon.svg`, `loading-spinner.svg`
- Nessuna versione nel nome file — usa cache busting di Vite/Laravel
- Nessun prefisso modulo nel nome (già nella cartella del modulo)

## Validazione

```bash
# SVG fuori posizione nei moduli
find laravel/Modules -name "*.svg" | grep -v "/resources/svg/"
# Target: 0 risultati per SVG proprietari dei moduli

# SVG Geo esistenti
ls laravel/Modules/Geo/resources/svg/
```

## Riferimenti

- Regola globale: `bashscripts/ai/.claude/rules/svg-asset-location.md`
- Regola marker: `bashscripts/ai/.claude/rules/map-marker-custom-asset.md`
- Story 8-27: implementazione marker custom locale per MapPicker
