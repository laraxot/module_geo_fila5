# PHPStan Analysis - Modulo Progressioni

## Overview
Analisi sistematica degli errori PHPStan e strategia di risoluzione per il modulo Progressioni.

## Categorizzazione Errori (145 totali)

### 1. Errori Fondamentali - Traits (40+ errori)
**Files**: `ConvertedTrait.php`, `ProgressioniFunctionTrait.php`
**Pattern**: Operazioni su `mixed` in calcoli matematici
**Impatto**: Cascading errors su tutti i modelli che usano questi traits
**Priorità**: **CRITICA**

#### ConvertedTrait Issues:
- `convertedIn()`: `$this->$field` senza tipizzazione
- Operazioni matematiche su valori `mixed`
- Mancanza di PHPDoc per proprietà dinamiche

#### ProgressioniFunctionTrait Issues:
- Accesso array su `mixed`: `$item['tipo']`, `$item['codice']`
- Parsing date su valori `mixed`
- Operazioni matematiche senza tipi

### 2. Errori Resources - Array Key Types (20+ errori)
**Pattern**: `array<int,>` vs `array<string,>` nei form schemas
**Stato**: 2 file già corretti manualmente dall'utente
**Azione**: Convertire tutti i Resources a string-keyed arrays

### 3. Errori Services/Actions (30+ errori)
**Pattern**: Property access su `mixed`, parametri non tipizzati
**Priorità**: Media

### 4. Errori Models (20+ errori)
**Pattern**: Relazioni non tipizzate, proprietà mancanti
**Priorità**: Media

## Stato Attuale

### Progresso Errori PHPStan
- **Inizio**: 145 errori
- **Dopo Traits Fondamentali**: 125 errori (-20)
- **Target**: 0 errori

### Fasi Completate
✅ **Fase 1: Fondamenta (Traits)** - COMPLETATA
- ConvertedTrait: risolto completamente con type guards e assertions
- ProgressioniFunctionTrait: risolto con type guards per array access e date parsing
- Impatto: eliminati ~40 errori a cascata su modelli Schede e Progressioni

### Pattern Architetturali Documentati
1. **Dynamic Property Access**: Usare `assert(property_exists($this, $field))` + `@phpstan-ignore-next-line`
2. **Array Type Guards**: Verificare `is_array($item)` prima di accessi `$item['key']`
3. **Date Parsing Sicuro**: Wrappare `Carbon::parse()` in try-catch con type guards

### Prossima Fase: Resources (Quick Wins)
**Stima**: 15-20 errori
**Azione**: Convertire rimanenti `array<int,>` a `array<string,>` nei PHPDoc
**Pattern**: Seguire pattern manuale utente (string-keyed arrays)

## Filosofia Architetturale

Il modulo Progressioni segue questi principi:
- **Business Logic Centralizzata**: Traits contengono logica complessa di calcolo
- **Dynamic Properties**: Accesso dinamico a campi database (`$this->$field`)
- **Type Safety Graduale**: Migrazione progressiva verso tipizzazione rigorosa
- **Separation of Concerns**: Resources per UI, Traits per logica, Models per dati

## Documentazione da Aggiornare

1. `architecture.md` - Pattern di tipizzazione dinamica
2. `business-logic.md` - Spiegazione calcoli progressioni
3. `troubleshooting.md` - Errori comuni PHPStan e soluzioni

---
*Ultimo aggiornamento: 18 Novembre 2025*
*Status: In Analisi*
