# CertFisc Module

## 📖 Scopo

Il modulo CertFisc gestisce le certificazioni fiscali e documenti correlati per il personale.

## 🎯 Funzionalità Principali

- Generazione certificati fiscali
- Gestione CU (Certificazione Unica)
- Storico certificazioni
- Export per commercialista

## 🚀 Quick Start

### Modelli Principali

- `CertificazioneFiscale` - Certificazioni generate
- `CU` - Certificazione Unica annuale

## 📂 Struttura

```
Modules/CertFisc/
├── app/
│   ├── Models/              # Modelli certificazioni
│   ├── Filament/Resources/  # Gestione via admin
│   └── Actions/             # Generazione PDF
├── database/migrations/     # Migrazioni
├── lang/                    # Traduzioni
└── docs/                    # Questa documentazione
```

## 🔗 Moduli Correlati

- [User](../User/docs/README.md) - Dati anagrafici dipendenti
- [ContoAnnuale](../ContoAnnuale/docs/README.md) - Dati retributivi
- [Xot](../Xot/docs/README.md) - Framework core

---

**Ultimo aggiornamento**: Gennaio 2025  
**Status**: Active

