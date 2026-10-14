---
title: "INDEX"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "INDEX"
issues: []
discussions: []
status: draft
---

# Geo Module Documentation Index

<!-- p4-docs-geo: ingresso unico -->
**Punto d'ingresso unico della documentazione del modulo Geo.** `00-INDEX.md` e `00-index.md` sono superseded da questo file (restano per cronologia, non vengono aggiornati).

> Nota 2026-10-14 (studio degli ingressi): il contratto `bmad-output/docs-architecture/module-theme-docs-contract.md` indica `00-INDEX.md` come indice canonico dei moduli, mentre la decisione del [decision-log](./decision-log.md) (2026-10-14) fa di questo `INDEX.md` l'ingresso unico e lascia `00-INDEX.md` e `00-index.md` come superseded. Le due regole divergono: non e' stato rinominato nulla, resta da decidere (vedi la story `2026-10-14-studio-docs-geo-ingressi-verificati.story.md`). `00-INDEX.md` e `00-index.md` sono anche due nomi che differiscono solo per le maiuscole (collisione su filesystem insensibili alle maiuscole).

## Classificazione delle directory (verificata il 2026-10-14)

| Classe | Cartelle e file | Come usarli |
|---|---|---|
| Canonica | `stories/` (33 file), `wiki/` (238 file: `concepts/` 148 concept, `rules/`, `decisions/`, `troubleshooting/`, `memories/`), [decision-log.md](./decision-log.md), [README.md](./README.md) | Intento, regole e decisioni del modulo. Le story non si cancellano ne' si rinumerano |
| Evidence | `raw/` (477 file, immutabile), `phpstan/` (124 file di rapporti), `chat/` (86, solo passaggio di consegne), `git/`, `git-management/`, `claude/`, `prompts/` | Cronologia di un momento passato: non descrivono lo stato corrente |
| Legacy | file `.md` della radice (622 file nella radice, vedi [DOCS-MIGRATION-MAP.md](./DOCS-MIGRATION-MAP.md)), `00-INDEX.md`, `00-index.md`, `index.md` (indice PTVX, segnato `stale`), `wiki/ProjectHome.md`, `wiki/projecthome.md`, `wiki/reflective.md`, `wiki/method-name-homonym-census.md` (segnati `stale`) | Ricercabili, non attendibili finche' una story non li richiama. Molti descrivono classi che non esistono (`GeocodingService`, `MapProviderService`) |
| Non verificate in questa passata | le altre sottocartelle (`roadmap/` 72, `testing/` 39, `utils/` 41, `pdf/`, `scripts/`, `ai/`, `filament/`, `models/`, ...) | Non e' stato confrontato il contenuto con il codice |

## Navigazione rapida

- [Mappa di migrazione della radice](./DOCS-MIGRATION-MAP.md) - dove andrebbe ognuno dei 622 file della radice di `docs/` (proposta, nessuno spostamento eseguito)
- [Story BMAD](./stories/index.md) - cronologia e backlog delle story del modulo
- [Wiki del modulo](./wiki/index.md) - concept, regole e troubleshooting; indice dei concept in [wiki/concepts/INDEX.md](./wiki/concepts/INDEX.md)
- [Log del wiki](./wiki/log.md) - cronologia dei cambiamenti alla conoscenza del modulo
- [Registro decisioni](./decision-log.md) - decisioni di struttura e di allineamento
- [Panoramica del modulo](./README.md)

## Documentation Structure

### 📚 Core Documentation

- [**Architecture Overview**](./architecture.md) - Technical architecture and system design
- [**Component Analysis**](./story-map-component-analysis.md) - Deep dive on map component philosophy and best practices
- [**Project Strategy**](./PRODUCT_STRATEGY.md) - Strategic vision and roadmap
- [**Technical Implementation**](./TECHNICAL.md) - Technical guidelines and patterns

### 🚀 Features & Capabilities

- [**Address Implementation**](./address-implementation.md) - Address handling and validation
- [**Address Autocomplete**](./address-autocomplete.md) - Smart address suggestions
- [**Map Components**](./leaflet-marker-map-input.md) - Interactive map components
- [**Advanced Features**](./ADVANCED_FEATURES.md) - Power user features
- [**Product Roadmap**](./PRODUCT_ROADMAP.md) - Future development plans

### 🔧 Integration & Usage

- [**Coordinate Picker Purpose & Architecture**](./coordinate-picker-purpose.md) - Scopo, utilità e implementazione del componente mappa per wizard ticket
- [**Mappa di sola lettura (`<x-geo::point-map>`, `CoordinatePicker::readOnly()`)**](./wiki/concepts/point-map-readonly.md) - Mostrare un punto senza poterlo modificare (riepilogo wizard, DCP-33)
- [**SVG Icon Architecture**](./coordinate-picker-purpose.md#-svg-icon-architecture-no-hardcoded-svg) - Regola DRY: SVG separati in `resources/svg/`, no inline hardcoded
- [**Filament Components**](./filament-forms-components.md) - Filament forms components, web components (Lit.dev), and integration patterns
- [**Filament Integration**](./filament_extension_rules.md) - Filament PHP integration patterns

### 🎨 Assets & Icons

**SVG Icons (resources/svg/)**:
- `magnifying-glass.svg` - Search icon for address input
- `location.svg` - Geolocation button
- `layer.svg` - Layer switcher (street/satellite/topo)
- `crosshair.svg` - Center map crosshair
- `arrows-pointing-out.svg` / `arrows-pointing-in.svg` - Fullscreen toggle
- `map-icon-plus.svg` / `map-icon-minus.svg` - Zoom controls
- [**Web Components & Build Architecture**](./filament-forms-components.md#web-components--litdev) - Lit.dev web component pattern, module vs theme asset separation
- [**MCP Servers**](./MCP_SERVER_RECOMMENDED.md) - Recommended Model Context Protocol servers
- [**App Integration**](./app-integration.md) - Integration with main application
- [**Address Migration**](./address_migration_guide.md) - Migration guides and patterns

### 📊 Analysis & Research

- [**Model Analysis**](./analisi-modelli-doppi.md) - Duplicate models analysis and recommendations
- [**Code Quality Analysis**](./analysis/code-quality-analysis.md) - Code quality metrics and improvements
- [**User Research**](./USER_RESEARCH.md) - User experience research findings
- [**Domain Research**](./_integration/here-com.md) - Geographic domain research _(link corretto il 2026-10-14: `_integration/archive/` non esiste, il file e' in `_integration/`)_

### 🛠️ Development & Tools

- [**Sprint Planning**](./SPRINT_PLANNING.md) - Sprint planning and tracking
- [**Project Management**](./PROJECT.md) - Project management documentation
- [**PHPStan Fixes**](./PHPSTAN_FIXES.md) - Code quality fixes and improvements
- [**Vite Build Configuration**](./vite-build-configuration.md) - Vite 7.x + Tailwind 4.x setup per moduli
- [**Configuration**](../config/config.php) - Module configuration

### 📁 Stories & Tasks

- Map Component Enhancement Story - Enhanced map component for ticket wizard _(target mancante, verificato 2026-10-14: la cartella `_bmad/` non esiste nel repo; le story attuali del modulo sono in [stories/index.md](./stories/index.md))_
- Address Input Story - Address input implementation _(target mancante, verificato 2026-10-14: stessa causa)_

### 📋 Guidelines & Best Practices

- [**Design Rules**](./filament_extension_rules.md) - Filament component design rules
- [**Consolidation Analysis**](./analisi-moduli-ottimizzazioni.md) - Module consolidation guidelines
- [**Performance Guidelines**](./TECHNICAL.md#performance) - Performance optimization patterns

### 🔗 Related Modules

- **Fixcity Module** - Main application module using Geo components
  - [Ticket Wizard Implementation](../../Fixcity/docs/ticket-wizard-frontoffice.md)
  - Address Integration _(target mancante, verificato 2026-10-14: `Fixcity/docs/address-implementation.md` non esiste; il documento omonimo di questo modulo e' [address-implementation.md](./address-implementation.md))_

## Quick Reference

| Topic | File | Status |
|-------|------|--------|
| **AddressInput Component** | [address-input-component.md](./address-input-component.md) | ✅ Active |
| **Location Spinner UX** | [location-spinner-ux.md](./location-spinner-ux.md) | ✅ Active |
| AddressField Component (legacy) | [address-field-component.md](./address-field-component.md) | ⚠️ Legacy |
| AddressResource | [address-resource.md](./filament/address-resource.md) | ✅ Active |
| Module Boundary Philosophy | [../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md](../../Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md) | ✅ Active |
| README / Overview | [README.md](./README.md) | ✅ Active |

## Filament Components

### Forms
- **AddressInput** — Single address input with geolocation → [address-input-component.md](./address-input-component.md)
- **AddressField** (Forms/Components) — Full address section with cascading selects
- **AddressesField** — Repeater for multiple addresses
- **LeafletMarkerMapInput** — Interactive map with draggable marker → [story-map-component-analysis.md](./story-map-component-analysis.md)

### Resources
- **AddressResource** — CRUD for addresses → `./filament/address-resource.md`
- **LocationResource** — CRUD for locations

### Widgets
- **LocationWidget** — Map display widget
- **LocationMapTableWidget** — Table with map integration

## Architecture

- [README.md](./README.md) — Module overview
- [architectural-philosophy.md](./architectural-philosophy.md) — Architecture patterns
- [00-index.md](./00-index.md) — Legacy index

## Actions (Geocoding)

| Action | File |
|--------|------|
| GetCoordinatesByAddressAction | `app/Actions/GetCoordinatesByAddressAction.php` _(nome classe corretto il 2026-10-14: prima `GetCoordinatesFromAddressAction`, che non esiste)_ |
| GetAddressFromNominatimAction | `app/Actions/Nominatim/GetAddressFromNominatimAction.php` |
| GetAddressFromGoogleMapsAction | `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php` |
| GetAddressFromMapboxAction | `app/Actions/Mapbox/GetAddressFromMapboxAction.php` |
| CalculateDistanceAction | `app/Actions/CalculateDistanceAction.php` |

## Models

- **Address** — `app/Models/Address.php`
- **Location** — `app/Models/Location.php`
- **Locality** — `app/Models/Locality.php`
- **Province** — `app/Models/Province.php`
- **Region** — `app/Models/Region.php`
- **ComuneJson** — `app/Models/ComuneJson.php` (preferred over Comune)
- **Place** — `app/Models/Place.php` (enhanced with geolocation)

## Translations

- Italian: `lang/it/address.php`
- English: `lang/en/address.php`

---
## 📋 DEDUPLICATION NOTICE

This module has many duplicate files in docs/. Key actions taken:

> Nota 2026-10-14: questa sezione e' del 2026-06 e non e' piu' vera nei fatti. Nessun file `*backup.md` o `*--*.md` e' stato cancellato (la policy vieta di cancellare) e la radice di `docs/` ha 622 file, di cui 62 copie byte-identiche (misura in [DOCS-MIGRATION-MAP.md](./DOCS-MIGRATION-MAP.md)). Le azioni "Delete (git preserves)" della tabella sotto sono da leggere come proposte non eseguite.

### Consolidated Documents
- ✅ **Model Analysis** - [analisi-modelli-doppi.md](./analisi-modelli-doppi.md) - Single source of truth
- ✅ **Map Component Analysis** - [story-map-component-analysis.md](./story-map-component-analysis.md) - Comprehensive guide
- ✅ **Technical Guidelines** - [TECHNICAL.md](./TECHNICAL.md) - Single reference

### Categories to Clean Up
| Pattern | Count | Action |
|---------|-------|--------|
| `*sumy.md`, `*-summary.md`, `*summary.md` | ~20 | Consolidated into main docs |
| `*backup.md`, `*-backup.md`, `*_BACKUP.md` | ~15 | Delete (git preserves) |
| `*--*.md`, `*.md` (empty name) | ~5 | Delete |
| Multiple address-resource-*.md | ~30 | Consolidated into one |
| Multiple address-implementation*.md | ~15 | Consolidated into one |

### 📖 Quick Start

1. **Architecture**: Start with [architecture overview](./architecture.md)
2. **Components**: Learn about [address components](./address-implementation.md) and [map components](./story-map-component-analysis.md)
3. **Integration**: Follow [Filament integration guide](./filament_extension_rules.md)
4. **Examples**: Check [app integration](./app-integration.md)

### 🤝 Contributing

- Follow the BMad methodology for development _(target mancante, verificato 2026-10-14: `_bmad/README.md` non esiste; vedi [BMad Method](../../../../docs/wiki/concepts/bmad-method.md))_
- Maintain design system compliance _(target mancante, verificato 2026-10-14: il modulo `DesignComuni` non esiste in `laravel/Modules/`; il tema e' [Sixteen](../../../Themes/Sixteen/docs/README.md))_
- Ensure [accessibility standards](./USER_RESEARCH.md#accessibility) are met
- Run quality checks with [PHPStan](./PHPSTAN_FIXES.md)

### 📞 Support

- For technical questions: Check [architecture](./architecture.md) and [technical docs](./TECHNICAL.md)
- For implementation issues: Review [code quality analysis](./analysis/code-quality-analysis.md)
- For integration help: See [app integration](./app-integration.md) and [Filament rules](./filament_extension_rules.md)
---

## ⚠️ Architectural Rules

- **[No Http Controllers — Folio + Actions + Filament](../../../../docs/wiki/rules/no-controllers-rule.md)** — Absolute rule: no `Http/Controllers/` in app/ or modules. Geo uses Folio for API endpoints and Actions for business logic.
