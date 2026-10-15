---
title: "00 index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "00 index"
issues: []
discussions: []
status: draft
---

> **Superseded: vedi [INDEX.md](./INDEX.md).** Questo file resta per cronologia e non viene aggiornato.

# 📚 **Indice Documentazione Modulo Geo**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Scopo**

Gestisce tutto ciò che riguarda la geolocalizzazione: geocoding multi-provider (9 provider), database ANPR italiano (8000+ comuni), query spaziali, widget mappa interattivi per Filament.

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica completa, Multi-API e Comuni Italiani.
2. [roadmap.md](./roadmap.md) - Obiettivi 2026 e miglioramenti geocoding.
3. [philosophy.md](./philosophy.md) - Visione architetturale dei dati geografici.

## 🏗️ **Geocoding & Indirizzi**
- 🏠 **[Address Implementation](./address-implementation.md)** - Guida al modello Address e ai trait.
- 🎯 **Geocoding Services** _(target mancante, verificato 2026-10-14: `geocoding-services-integration.md` non esiste)_ - Google Maps, Mapbox, Here.
- 🚚 **[Bulk Actions](./bulk-coordinate-updates.md)** - Aggiornamento massivo di coordinate.

## 🇮🇹 **Dati Italiani (Anpr/Sushi)**
- 🍕 **[Comuni Sushi](./comune-sushi-analysis.md)** - Gestione database comuni italiani in-memory.
- 🗺️ **[Polygon Data](./polygon-integration.md)** - Gestione coordinate poligonali e MySQL Spatial.

## 🎨 **Filament & UI Components**
- 📍 **[Location Selector](./location-select.md)** - Componenti di selezione visiva della mappa.
- 🛠️ **[Address Field](./address-field.md)** - Form field personalizzati per indirizzi.

## 🧪 **Qualità e Sviluppo**
- ✅ **PHPStan Level 10** _(target mancante, verificato 2026-10-14: `phpstan-level10-compliance.md` non esiste)_ - Conformità e fix specifici per Geo.
- 🔬 **[Testing Guidelines](./testing-guidelines.md)** - Strategie di test geografico.
- 🧹 **[PHPMD & Complexity](./cyclomatic-complexity-report.md)** - Analisi della pulizia del codice.

## 📦 **Pacchetti Composer**
- Riferimento pacchetti e inventario 312 pacchetti _(target mancanti, verificato 2026-10-14: `docs/composer-packages-reference.md` e `docs/architecture/composer-packages-full-inventory.md` non esistono alla radice)_ - Nessuna dipendenza diretta; usa Xot, Sushi (via Xot)

## 📄 Documenti Aggiuntivi

### Address & Location
| File | Scopo |
|------|-------|
| [address-resource.md](./address-resource.md) | Filament Resource |
| [address-column-implementation.md](./address-column-implementation.md) | Colonne geografiche |

### Geocoding
| File | Scopo |
|------|-------|
| geocoding-implementation.md _(target mancante, verificato 2026-10-14)_ | Geocoding multi-provider |
| provider-integration.md _(target mancante, verificato 2026-10-14)_ | Integrazione provider |

### Database ANPR
| File | Scopo |
|------|-------|
| [comune-model.md](./comune-model.md) | Modello Comune ANPR |
| region-province-model.md _(target mancante, verificato 2026-10-14)_ | Modelli territoriali |

## 📊 Metriche Modulo

| Aspetto | Valore |
|---------|--------|
| Modelli | 13 |
| Azioni | 51 _(misura del 2026-10-14: 77 file `.php` in `app/Actions/`)_ |
| Provider Geocoding | 9 |
| Widget Filament | 6 _(misura del 2026-10-14: 7 classi `.php` in `app/Filament/Widgets/`)_ |
| Comuni ANPR | 8000+ |
| PHPStan Level | 10 |

## 🔗 Riferimenti

- [AGENTS.md](../../../../AGENTS.md) - Project guidelines

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Core framework e Base Models.
- [UI](../../UI/docs/README.md) - Componenti grafici e widget mappa.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
<<<<<<< HEAD

--- BMAD + Second Brain ---
- Scopo: documentazione tecnica del modulo.
- Utilità: riferimento sviluppatori/audit.
- Funzionalità: struttura, dipendenze, convenzioni (no date .md, git avanti).
=======
>>>>>>> laraxot/dev
