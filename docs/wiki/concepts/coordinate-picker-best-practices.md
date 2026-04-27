---
title: CoordinatePicker Best Practices
---

## Overview
`CoordinatePicker` è il componente principale per la selezione geografica in Filament.

## Best Practices
- **Reuse logic via `HasCoordinatePicker` trait** to keep state handling consistent across components.
- **Default centre coordinates** (lat 41.9028, lng 12.4964) should be defined as class properties and can be overridden via `center()`.
- **Lazy state hydration**: use `afterStateHydrated` to populate coordinates from the model or defaults.
- **Expose configuration methods** (`latitudeColumn()`, `longitudeColumn()`, `zoom()`, `height()`, `showSearch()`, etc.) returning `$this` for chaining.
- **Avoid direct DB queries** in the component; rely on the model passed via `$this->getRecord()`.
- **Keep UI logic in JS** (Leaflet map) and only expose simple PHP setters.

## Bad Practices
- Duplicating state properties in both the trait and the component.
- Hard‑coding map container IDs in Blade; use component IDs instead.
- Performing API calls (e.g., Nominatim) synchronously in the PHP component.

## False Friends
- Using `$this->native(true)` after configuring options – this disables the TOM‑Select HTML rendering needed for icons.
- Assuming `$this->enumClass` will always be a string; always evaluate with `$this->evaluate()` to support closures.
- Relying on `public` properties for configuration; use fluent setters instead.

## References
- `docs/wiki/concepts/leaflet-wizard-step-invalidate-size.md`
- `memory/feedback_leaflet_wizard_invalidate_size.md`
