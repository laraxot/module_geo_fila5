# Ptv Module - Roadmap

## Visione

Modulo per la gestione del ciclo di valutazione del personale: schede valutazione, valutatori, criteri e anni.
Progettato per essere agnostico e riutilizzabile in diversi contesti (PA, aziende private).

## Overview
**Purpose**: Personnel evaluation and assessment management system
**Status**: Active Development
**Dependencies**: Xot (core), User (authentication)

## 🧪 Testing e TDD

### Principi TDD
- **Red-Green-Refactor**: Test che fallisce → Codice minimo → Refactor
- **AAA Pattern**: Arrange → Act → Assert
- **Test Coverage**: Minimo 80%

### Struttura Test
```
Modules/Ptv/tests/
├── Unit/
│   ├── Actions/
│   ├── Models/
│   └── Services/
├── Feature/
│   ├── Filament/
│   │   └── {Resource}Test.php
│   └── Pages/
│       └── {Page}Test.php
├── Pest.php
└── TestCase.php
```

### Best Practices
- [ ] Usare `RefreshDatabase` per test database
- [ ] Fake servizi esterni (Mail, Queue)
- [ ] Test naming descrittivo
- [ ] Dataset per multiple scenarios

### Comandi
```bash
# Test modulo
./vendor/bin/pest Modules/Ptv/tests

# Test con coverage
./vendor/bin/pest Modules/Ptv/tests --coverage --min=80
```

## Current State

### ✅ Completed
- [x] Base Filament resources for personnel evaluation
- [x] Database schema for tracking
- [x] Integration with Rating module (se presente)
- [x] Basic CRUD operations
- [x] Translation files (IT, EN, DE)

### 🔄 In Progress
- [x] PHPStan Level 10 compliance
- [x] Resolved Cross-Module relationship leaks (Base Model + Local Wrapper pattern)
- [x] Implemented Modular Database Connection rules (No hardcoding in root config)
- [ ] Test coverage improvement
- [ ] Advanced filtering and reporting

### ❌ ] Analytics and insights Pending
- [
- [ ] Automated reports
- [ ] History tracking
- [ ] Multi-year comparison
- [ ] Export (PDF, Excel)
- [ ] Notifications

## Roadmap

### Phase 1: Code Quality (Q1 2026)
**Priority**: High
**Tasks**:
- [ ] Complete PHPStan Level 10 compliance
- [ ] Achieve 80%+ test coverage
- [ ] Documentation completion
- [ ] Refactoring for best practices

### Phase 2: Core Features (Q1-Q2 2026)
**Priority**: High
**Tasks**:
- [ ] Advanced filtering and search
- [ ] History view
- [ ] Bulk operations

### Phase 3: Reporting & Analytics (Q2 2026)
**Priority**: Medium
**Tasks**:
- [ ] Reports
- [ ] Analytics and insights
- [ ] Export functionality (PDF, Excel)
- [ ] Scheduled reports

### Phase 4: Integration (Q3 2026)
**Priority**: Medium
**Tasks**:
- [ ] Integration with User module
- [ ] Integration with other modules (se presenti)
- [ ] API endpoints for external systems

## Dipendenze Opzionali

Il modulo può integrarsi (se presenti) con:
- **Rating**: Criteri di valutazione
- **Activity**: Audit trail
- **User**: Autenticazione

Queste sono dipendenze opzionali - il modulo funziona anche senza di esse.

## Technical Debt
- [ ] PHPStan Level 10 compliance
- [ ] Test coverage improvement (target 80%+)
- [ ] Documentation completion
- [ ] Refactoring legacy code

## Success Criteria
- [ ] PHPStan Level 10 compliance
- [ ] 80%+ test coverage
- [ ] Complete dashboard
- [ ] Export functionality working
- [ ] Full documentation
- [ ] All translations complete (IT, EN, DE)

---

**Last Updated**: 2026-02-24
**Status**: Active Development
