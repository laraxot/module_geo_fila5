<<<<<<< HEAD
# Geo - Product Requirements Document (PRD)

> Documento vivente. Modulo servizi geografici.

## 1. Purpose & Vision

Il modulo **Geo** fornisce geocoding, mappe e gestione posizioni. Integra provider esterni per coordinate, indirizzi e visualizzazione mappe.

**Visione**: Funzionalità geografiche riutilizzabili per eventi, contatti, sedi.

## 2. Problem Statement

Senza Geo:
- Nessun geocoding per indirizzi
- Mappe hardcoded o duplicate
- Dati geografici (comuni, province) non centralizzati

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Utente finale** | Visualizza mappe | Vedere sedi eventi, contatti |
| **Admin** | Configurazione | Gestire comuni, province |
| **Sviluppatore** | Integrazione | API geocoding, componenti mappa |

## 4. Scope

### In Scope
- Modello Comune (Sushi) con dati comuni italiani
- Geocoding e reverse geocoding
- Componenti mappa (solo free tier: OpenStreetMap, Leaflet)
- Integrazione con pagine contatti e eventi

### Out of Scope
- Google Maps a pagamento
- Routing e navigazione
- Dati geografici fuori Italia (estensione futura)

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Dati comuni italiani (JSON/Sushi)
- **FR-002**: Geocoding indirizzo → coordinate
- **FR-003**: Componente mappa per pagine contatti/eventi

### P1: Enhancement
- **FR-004**: Admin Filament per province/regioni
- **FR-005**: Cache per richieste geocoding

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Solo mappe free (OpenStreetMap, Leaflet)
- **NFR-003**: Nessuna API key obbligatoria per funzionamento base

## 7. Technical Architecture

- **Dipendenze**: Xot
- **Dati**: comuni.json, modelli Comune, Provincia
- **Provider**: OpenStreetMap Nominatim (o simile)

## 8. Risks & Assumptions

- Assunzione: uso free tier sufficiente per progetto
- Rischio: rate limit Nominatim → cache aggressiva

## 9. Testing & Coverage

Il modulo Geo segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

## 10. References

- [PRD Progetto](../../../../docs/prd.md)
- [Free Maps Only](../../../../.cursor/memories/free-maps-only.md)

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

=======
# PRD: PTVX Modular Ecosystem

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Draft
- **Target Release:** Q2 2026

## ❓ Problem Statement
Building large-scale HR systems for Public Administration leads to monolithic, unmaintainable codebases with duplicated logic across different departments (Performance, Presenze, etc.).

## 🎯 Goals & Success Metrics
- **Goal 1:** Modular Isolation -> **Metric:** 100% decoupling between domain modules.
- **Goal 2:** Type Safety -> **Metric:** Zero PHPStan Level 10 errors.
- **Goal 3:** Developer Productivity -> **Metric:** < 1 hour to scaffold a new compliant module.

## 👤 User Stories
- As a **Developer**, I want to extend `XotBaseModel` so that I get automatic multi-tenancy and activity logging.
- As a **System Admin**, I want to toggle modules independently to minimize attack surface.

## 🛠️ Functional Requirements
1. **Module Registry:** Centralized tracking of all installed and active modules.
2. **Standardized UI:** Uniform Filament resources across all modules using `XotBaseResource`.
3. **Queueable Actions:** Business logic encapsulated in Spatie Queueable Actions.

## 🎨 Design & User Experience
Follows Filament v5 standards with "Super Mucca" UI enhancements for accessibility and clarity.

## 🚫 Out of Scope
- Direct Database manipulation without Eloquent/XotBase.
- Hardcoded localized strings.
>>>>>>> laraxot/dev
