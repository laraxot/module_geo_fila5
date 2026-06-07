# Geo Module Documentation Index

**Last Update**: 18 Dicembre 2025
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.0

## 📚 Quick Navigation

### 🎯 Essential Reading
1. [README.md](./README.md) - Overview completo del modulo
2. [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md) - Compliance status

### 🏗️ Architecture & Patterns
- [Geo Architecture](./geo-architecture.md) - Struttura architetturale del modulo
- [Coordinate Management](./coordinate-management.md) - Gestione coordinate e geolocalizzazione
- [Address Data Processing](./address-data-processing.md) - Elaborazione dati indirizzi
- [Geocoding Services Integration](./geocoding-services-integration.md) - Integrazione servizi geocoding

### 🧩 Core Components
- [Place Model](../../app/Models/Place.php) - Modello principale Place
- [Address Model](../../app/Models/Address.php) - Modello indirizzo
- [Filament Actions](../../app/Filament/Actions/) - Azioni Filament per geolocalizzazione

### 🔧 Implementation Guides
- [Update Coordinates Action](./update-coordinates-action.md) - Azione per aggiornamento coordinate
- [Bulk Coordinate Updates](./bulk-coordinate-updates.md) - Aggiornamento coordinate in blocco
- [Geocoding Best Practices](./geocoding-best-practices.md) - Best practice geocoding

### 🧪 Testing
- [Test Suite](../../tests/) - Suite di test per il modulo Geo
- [Feature Tests](../../tests/Feature/) - Test funzionali
- [Integration Tests](../../tests/Integration/) - Test di integrazione
- [Unit Tests](../../tests/Unit/) - Test unitari

### 🐛 Troubleshooting & Fixes
- [Common Issues](./common-issues.md) - Problemi comuni e soluzioni
- [Geocoding Troubleshooting](./geocoding-troubleshooting.md) - Risoluzione problemi geocoding

### 📊 Code Quality
- [PHPStan Analysis](./phpstan-analysis.md) - PHPStan reports
- [Code Quality Metrics](./quality-metrics.md) - Metriche di qualità

### 🚀 Deployment
- [Geo Module Deployment](./deployment.md) - Linee guida per deploy
- [Geocoding Service Configuration](./geocoding-config.md) - Configurazione servizi geocoding

## 📈 Module Statistics

- **Total Docs**: 8 files
- **PHPStan Compliance**: ✅ Level 10
- **Architecture**: XotBase compliant
- **Type Safety**: 100%

## 🔗 Related Modules

- [Xot](../../Xot/docs/README.md) - Core framework
- [TechPlanner](../../TechPlanner/docs/README.md) - Business logic
- [Client Resource](../../TechPlanner/app/Filament/Resources/ClientResource/) - Integration examples

## 🎯 Quick Start

1. Leggi [README.md](./README.md) per overview
2. Studia [geo-architecture.md](./geo-architecture.md)
3. Consulta [coordinate-management.md](./coordinate-management.md)
4. Verifica [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md)

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
# Geo Module Documentation Index

**Last Update**: 18 Dicembre 2025
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 1.0

## 📚 Quick Navigation

### 🎯 Essential Reading
1. [README.md](./README.md) - Overview completo del modulo
2. [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md) - Compliance status

### 🏗️ Architecture & Patterns
- [Geo Architecture](./geo-architecture.md) - Struttura architetturale del modulo
- [Coordinate Management](./coordinate-management.md) - Gestione coordinate e geolocalizzazione
- [Address Data Processing](./address-data-processing.md) - Elaborazione dati indirizzi
- [Geocoding Services Integration](./geocoding-services-integration.md) - Integrazione servizi geocoding

### 🧩 Core Components
- [Place Model](../../app/Models/Place.php) - Modello principale Place
- [Address Model](../../app/Models/Address.php) - Modello indirizzo
- [Filament Actions](../../app/Filament/Actions/) - Azioni Filament per geolocalizzazione

### 🔧 Implementation Guides
- [Update Coordinates Action](./update-coordinates-action.md) - Azione per aggiornamento coordinate
- [Bulk Coordinate Updates](./bulk-coordinate-updates.md) - Aggiornamento coordinate in blocco
- [Geocoding Best Practices](./geocoding-best-practices.md) - Best practice geocoding

### 🧪 Testing
- [Test Suite](../../tests/) - Suite di test per il modulo Geo
- [Feature Tests](../../tests/Feature/) - Test funzionali
- [Integration Tests](../../tests/Integration/) - Test di integrazione
- [Unit Tests](../../tests/Unit/) - Test unitari

### 🐛 Troubleshooting & Fixes
- [Common Issues](./common-issues.md) - Problemi comuni e soluzioni
- [Geocoding Troubleshooting](./geocoding-troubleshooting.md) - Risoluzione problemi geocoding

### 📊 Code Quality
- [PHPStan Analysis](./phpstan-analysis.md) - PHPStan reports
- [Code Quality Metrics](./quality-metrics.md) - Metriche di qualità

### 🚀 Deployment
- [Geo Module Deployment](./deployment.md) - Linee guida per deploy
- [Geocoding Service Configuration](./geocoding-config.md) - Configurazione servizi geocoding

## 📈 Module Statistics

- **Total Docs**: 8 files
- **PHPStan Compliance**: ✅ Level 10
- **Architecture**: XotBase compliant
- **Type Safety**: 100%

## 🔗 Related Modules

- [Xot](../../Xot/docs/README.md) - Core framework
- [TechPlanner](../../TechPlanner/docs/README.md) - Business logic
- [Client Resource](../../TechPlanner/app/Filament/Resources/ClientResource/) - Integration examples

## 🎯 Quick Start

1. Leggi [README.md](./README.md) per overview
2. Studia [geo-architecture.md](./geo-architecture.md)
3. Consulta [coordinate-management.md](./coordinate-management.md)
4. Verifica [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md)

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
# Geo Module — Documentation Index

## Architecture

| Documento | Descrizione |
|-----------|-------------|
| [Filament Forms Components](./filament-forms-components.md) | **Guida principale** per componenti form: AddressInput, AddressSection, MapInput, ecc. |
| [Module Philosophy](./module-philosophy.md) | Perché Geo possiede la geolocalizzazione e come i moduli la consumano |

## Components

| Componente | Tipo | Path | Descrizione |
|-----------|------|------|-------------|
| **AddressInput** | Filament Field | `app/Filament/Forms/Components/AddressInput.php` | ✅ Campo indirizzo con pulsante geolocalizzazione |
| **AddressSection** | Filament Section | `app/Filament/Forms/Components/AddressSection.php` | Sezione campi indirizzo separati (via, civico, città, CAP) |
| **LatitudeLongitudeInput** | Filament Field | `app/Filament/Forms/Components/LatitudeLongitudeInput.php` | Coppia input testuali lat/lng (schema interno; mappa opzionale futura) |
| **LeafletMarkerMapInput** | Filament Field | `app/Filament/Forms/Components/LeafletMarkerMapInput.php` | Mappa Leaflet OSM, marker trascinabile, sync su due campi sibling lat/lng |
| AddressField | Filament Field | `app/Filament/Forms/Components/AddressField.php` | Legacy (verificare se deprecare) |
| AddressesField | Filament Field | `app/Filament/Forms/Components/AddressesField.php` | Multi-indirizzo (repeater-like) |

## Actions

| Action | Path | Descrizione |
|--------|------|-------------|
| GetCoordinatesAction | `app/Actions/GetCoordinatesAction.php` | Geocoding indirizzo → coordinate |
| ReverseGeocodeAction | `app/Actions/Nominatim/ReverseGeocodeAction.php` | Coordinate → indirizzo (Nominatim) |
| SearchPlacesAction | `app/Actions/Nominatim/SearchPlacesAction.php` | Ricerca luoghi (Nominatim) |

## Models

| Documento | Descrizione |
|-----------|-------------|
| [Analisi dominio modelli (sovrapposizioni, raccomandazioni)](./geo-models-domain-analysis.md) | **Partenza consigliata**: Address vs Location vs Place, Comune vs ComuneJson, IT vs US |

| Modello | Path | Descrizione breve |
|---------|------|-------------------|
| Address | `app/Models/Address.php` | Indirizzo PostalAddress persistito, morph, integrazione comuni IT |
| Location | `app/Models/Location.php` | Punto + campi testo semplificati (legacy/leggero) |
| Place | `app/Models/Place.php` | Snapshot geocoding / Places |
| Comune | `app/Models/Comune.php` | Comuni IT (Sushi + JSON) |

## Enums

| Enum | Path | Descrizione |
|------|------|-------------|
| AddressItemType | `app/Enums/AddressItemType.php` | Tipi di indirizzo (home, work, etc.) |

## Translations

| Lingua | Path | Namespace |
|--------|------|-----------|
| Italiano | `lang/it/address.php` | `geo::address.*` |
| English | `lang/en/address.php` | `geo::address.*` |
| Geolocation | `lang/it/geolocation.php` | `geo::geolocation.*` |

## Widgets

| Widget | Path | Descrizione |
|--------|------|-------------|
| LocationWidget | `app/Filament/Widgets/LocationWidget.php` | Widget mappa per admin panel |
| OSMMapWidget | `app/Filament/Widgets/OSMMapWidget.php` | Widget OpenStreetMap |

## Frontend & UI

| Documento | Descrizione |
|-----------|-------------|
| **[DAISYUI.md](./DAISYUI.md)** | DaisyUI nel modulo Geo: perché non è installato, pro/contro, metriche |
| **[Sixteen/docs/DAISYUI-APPLY.md](../Sixteen/docs/DAISYUI-APPLY.md)** | DaisyUI + `@apply` nel tema Sixteen: guida pratica, percentuali, opinione |

---

## Zen: Domain-Driven Design

**Geo possiede tutto ciò che è geo-spaziale.** I moduli consumatori (Fixcity, Municipal, User, etc.) importano i componenti da Geo.

### Nota UX geolocalizzazione

`AddressInput` espone stato di caricamento durante "use my location" (spinner + stato accessibile), per evitare click ripetuti e incertezza utente.

```php
// ✅ CORRETTO: importa da Geo
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label('Indirizzo')
    ->required()

// ❌ SBAGLIATO: reinventare geolocalizzazione nel modulo dominio
Placeholder::make('address')
    ->content(new HtmlString(\Blade::render('...')))
```

**Perché**:
- **Single Responsibility**: Geo = posizione, Fixcity = ticket
- **DRY**: Un solo componente, molti consumatori
- **Consistency**: Stesso comportamento in tutti i moduli
- **Maintainability**: Fix in un posto, beneficio ovunque