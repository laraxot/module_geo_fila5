# IndennitaResponsabilita Module - Roadmap

## Visione

Sistema per la gestione di indennità con criteri configurabili, calcolo automatico e validazione.
Progettato per essere riutilizzabile in diversi contesti (PA, aziende private).

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%

### Struttura Test
```
Modules/IndennitaResponsabilita/tests/
├── Unit/
│   ├── Models/
│   │   └── IndennitaResponsabilitaTest.php
│   └── Services/
├── Feature/
│   ├── Filament/
│   │   └── IndennitaResponsabilitaResourceTest.php
│   └── Pages/
│       └── CompilaIndennitaResponsabilitaTest.php
├── Pest.php
└── TestCase.php
```

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Notification)
- [ ] Test naming descrittivo
- [ ] Test validazione form

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/IndennitaResponsabilita/tests

# Test con coverage
./vendor/bin/pest Modules/IndennitaResponsabilita/tests --coverage --min=80
```

## Current State

### ✅ Completed
- [x] PHPStan Level 10 Compliance
- [x] Compila Page con form unificato
- [x] Sistema validazione criteri
- [x] Traduzioni IT/EN/DE

### 🔄 In Progress
- [ ] Test Coverage miglioramento
- [ ] Refactoring page class

### ❌ Pending
- [ ] Analytics dashboard
- [ ] Export PDF
- [ ] Storicizzazione

## Roadmap

### Phase 1: Code Quality
- [x] PHPStan Level 10
- [ ] Test Coverage 80%+

### Phase 2: Features
- [ ] Export PDF
- [ ] Storicizzazione valutazioni

### Phase 3: Analytics
- [ ] Dashboard analitiche
- [ ] Reportistica

## Dipendenze Opzionali

Il modulo può integrarsi (se presenti) con:
- **Rating**: Criteri di valutazione
- **Activity**: Audit trail
- **User**: Autenticazione

Queste sono dipendenze opzionali - il modulo funziona anche senza di esse.

---

**Last Updated**: 2026-02-24
**Status**: Active Development
