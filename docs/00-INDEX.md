# 📚 Geo Module - Documentation Index

**Path**: `laravel/Modules/Geo/docs/`  
**Modulo**: @Modules/Geo

## 🎯 Scopo

Gestisce tutto ciò che riguarda la geolocalizzazione: geocoding multi-provider (9 provider), database ANPR italiano (8000+ comuni), query spaziali, widget mappa interattivi per Filament.

## 📦 Struttura

```
docs/
├── 00-INDEX.md          # Questo indice
├── README.md            # Panoramica modulo
├── README.md.cleaned    # Versione pulita
└── [categoria]/         # Sottocartelle tematiche
```

## 📄 Documenti

### Quick Reference
| File | Scopo |
|------|-------|
| README.md | Panoramica, modelli, azioni, widget |
| README.md.cleaned | Documentazione pulita |

### Address & Location
| File | Scopo |
|------|-------|
| address-implementation.md | Implementazione indirizzi |
| address-resource.md | Filament Resource |
| address-column-implementation.md | Colonne geografiche |

### Geocoding
| File | Scopo |
|------|-------|
| geocoding-implementation.md | Geocoding multi-provider |
| provider-integration.md | Integrazione provider |

### Database ANPR
| File | Scopo |
|------|-------|
| comune-model.md | Modello Comune ANPR |
| region-province-model.md | Modelli territoriali |

## 🔗 Riferimenti

- [Xot Module](../Xot/docs/00-INDEX.md) - Base classes
- [AGENTS.md](../../../../AGENTS.md) - Project guidelines

## 📊 Metriche Modulo

| Aspetto | Valore |
|---------|--------|
| Modelli | 13 |
| Azioni | 51 |
| Provider Geocoding | 9 |
| Widget Filament | 6 |
| Comuni ANPR | 8000+ |
| PHPStan Level | 10 |

---

**Ultimo Aggiornamento**: 2026-03-24
