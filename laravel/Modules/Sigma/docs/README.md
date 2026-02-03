# Modulo Sigma - Documentazione Completa

> **Versione**: 2.0.0  
> **Ultimo aggiornamento**: Gennaio 2025  
> **☯️ "Calcolare una volta, consultare mille volte"**  
> – Principio Zen del modulo Sigma

## 🎯 Panoramica

**Sigma (Σ)** = Simbolo matematico della sommatoria

Il modulo Sigma è il **cuore computazionale** per:
- Calcolo schede valutazione progressioni carriera PA
- Aggregazione dati multi-fonte (Performance, PresenzeAssenze, User)
- Denormalizzazione controllata per performance (+90% velocità)
- Conformità normativa CCNL (Art. 16, 19)

### 📊 Statistiche Modulo

- **317 modelli** totali
- **83 accessor** per valori calcolati
- **12+ metodi puri** per business logic isolata
- **4 trait principali** (Mutator, Relationship, Scope, Helper)
- **Performance**: -95% query, -88% tempo edit page

## 📖 Documentazione

### 🌟 Documenti Essenziali (Leggi questi)

- [**Architecture**](./architecture.md) - Architettura completa, Delegation Cascade Pattern
- [**Business Logic**](./business-logic-analysis.md) - Regole business, normativa CCNL
- [**Zen Philosophy**](./zen-philosophy.md) - Filosofia completa, principi DRY+KISS+SRP

### 🔧 Documentazione Tecnica

- [**Mago e Rector Laravel**](./development/mago-rector-usage.md) - 🆕 Guida completa Mago (toolchain Rust) e Rector Laravel (refactoring automatico)
- [**Mago Usage Results**](./development/mago-usage-results.md) - ✅ Risultati utilizzo Mago sul modulo Sigma (5 errori critici corretti)
- [**Mago Installation Guide**](../../Xot/docs/development/mago-installation-guide.md) - 📚 Guida installazione completa Mago
- [**Mago Integration Complete**](./development/mago-integration-complete.md) - 🔧 Integrazione completa tutti strumenti Mago per Sigma
- [**Mago Results**](./development/mago-results.md) - ✅ Risultati analisi completa Mago (71 file formattati, ~345 warning, ~2644 errori)
- [**Mago Fixes Applied**](./development/mago-fixes-applied.md) - ✅ Fix applicati basati su analisi Mago
- [**Mago Summary**](./development/mago-summary.md) - 📊 Summary completo analisi Mago
- [**Workflow Completo Qualità**](./development/workflow-completo.md) - 🔄 Workflow integrato Mago → Rector → PHPStan con progresso
- [**Rector Application Report**](./development/rector-application-report.md) - ✅ Report applicazione Rector (47 file modificati, -26 errori)
- [**PHPStan Level 10 Strategy**](./phpstan-level10-strategy.md) - ⚠️ **CRITICO** Strategia risoluzione errori PHPStan, pattern e soluzioni
- [**PHPStan Progress Report**](./phpstan-progress.md) - 📊 Report progresso fix errori PHPStan, errori fixati e rimanenti (866 errori attuali)
- [**Fixes Applied**](./fixes-applied.md) - ✅ Fix applicati con pattern comuni e soluzioni
- [**Comprehensive Analysis**](./comprehensive-analysis.md) - ⭐⭐ Analisi COMPLETA con PHPStan Level 10, PHPMD, Business Logic, Integrazioni
- [**Deep Analysis**](./deep-analysis.md) - ⭐ Analisi approfondita business logic, architettura e integrazioni
- [**Architecture**](./architecture.md) - Architettura completa, Delegation Cascade Pattern
- [**Module Dependencies**](./module-dependencies.md) - Dipendenze cross-module dettagliate
- [**Analysis Report**](./analysis-report.md) - Report analisi PHPStan, PHPMD completo
- [**Quality Improvements**](./quality-improvements.md) - Piano miglioramenti qualità codice
- [**Summary**](./summary.md) - Riepilogo completo analisi

### 📚 Documentazione Storica

- [**Accessor Pattern**](./accessor-pattern.md) - Pattern completo accessor con denormalizzazione (se esiste)
- [**Refactoring**](./refactoring.md) - Storia refactoring e lessons learned (se esiste)
- [**Performance**](./performance.md) - Ottimizzazioni e benchmarks (se esiste)
- [**Troubleshooting**](./troubleshooting.md) - Problemi comuni e soluzioni (se esiste)

### 📚 Documentazione Storica

- [**CHANGELOG**](./CHANGELOG.md) - Cronologia modifiche
- [**Consolidation Plan**](./CONSOLIDATION_PLAN.md) - Piano consolidamento documentazione

## 🚀 Quick Start

### Importazione Dati

```bash
# Via interfaccia web
# Accedere a: /sigma/admin/web-service

# Via action
php artisan tinker
> use Modules\Sigma\Actions\WebService\ImportJsonAction;
> app(ImportJsonAction::class)->execute('data.json', 'local', 'anag');
```

### Calcolo Schede

```php
use Modules\Sigma\Models\Scheda;

$scheda = Scheda::find($id);

// Accesso a valori calcolati (cached)
$media = $scheda->perf_ind_media; // Media performance 3 anni
$giorni = $scheda->gg_anno; // Giorni effettivi annui

// Force refresh calcoli
$scheda = Scheda::find($id);
request()->merge(['refresh' => 1]);
$media = $scheda->perf_ind_media; // Ricalcola
```

## 🏗️ Architettura

### Componenti Principali

#### 1. Scheda Model

**Path**: `app/Models/Scheda.php` (o modelli che estendono BaseScheda)

**Responsabilità**:
- Rappresenta una scheda di valutazione annuale
- Contiene dati base + valori calcolati denormalizzati
- Usa `SchedaTrait` per logica complessa

**Attributi Chiave**:
- `id`, `ente`, `matr`, `anno`: Identificativi
- `gg_*`: Calcoli giorni (presenza, assenza, categorie)
- `perf_ind_*`: Performance anni specifici
- `perf_ind_media`: Media performance calcolata

#### 2. SchedaTrait

**Path**: `app/Models/Traits/SchedaTrait.php`

**Responsabilità**:
- **83 accessor** per valori calcolati
- **12+ metodi puri** per business logic isolata
- Pattern: Accessor → Metodo Puro → Calcolo

**Pattern Architetturale**:
```
Accessor (Lifecycle) → Metodo Puro (Business Logic) → Risultato
      ↓                         ↓                           ↓
  Cache + Guard             Calcolo Puro                Valore
```

#### 3. SchedaHelper

**Path**: `app/Models/Traits/Helpers/SchedaHelper.php`

**Responsabilità**:
- Calcoli puri senza side effects
- Delegation cascade a FunctionExtra e MassExtra
- Testabile isolatamente

#### 4. ImportJsonAction

**Path**: `app/Actions/WebService/ImportJsonAction.php`

**Responsabilità**:
- Importazione dati da file JSON
- Validazione e trasformazione tipi
- Insert massivo con truncate automatico

## 💼 Business Logic

### Calcoli Performance

**Normativa**: CCNL Comparto Funzioni Locali, Art. 19

**Logica**:
- Media performance = Σ(performance anni -1,-2,-3) / 3
- Esclusione anni con performance = 0
- Arrotondamento a 2 decimali

**Implementazione**: `getPerfIndMedia()`

### Calcoli Giorni Presenza

**Normativa**: Regolamento timbrature ente

**Logica**:
- Giorni in sede = giorni con timbratura sede
- Giorni fuori sede = giorni con timbratura fuori sede  
- Giorni anno = presenza - assenze
- Esclusione aspettative da conteggio

**Implementazione**: `getGgInSede()`, `getGgFuoriSede()`, `getGgAnno()`

### Gestione Assenze

**Normativa**: Codici assenza CCNL

**Logica**:
- Assenze categorizzate per tipo
- Calcolo ponderato ore/giorni
- Esclusione tipologie specifiche (aspettative)

**Implementazione**: Vari accessor `getGgAsz*` e `getHhAsz*`

## 🔗 Moduli Correlati

### Moduli che Usano Sigma

- [**Ptv**](../../Ptv/docs/README.md) - Gestione progressioni PTV
- [**Progressioni**](../../Progressioni/docs/README.md) - Gestione progressioni carriera
- [**IndennitaResponsabilita**](../../IndennitaResponsabilita/docs/README.md) - Calcoli indennità
- [**Incentivi**](../../Incentivi/docs/README.md) - Calcoli incentivi

### Moduli da cui Dipende

- [**Performance**](../../Performance/docs/README.md) - Valutazioni performance
- [**PresenzeAssenze**](../../PresenzeAssenze/docs/README.md) - Timbrature
- [**User**](../../User/docs/README.md) - Anagrafica dipendenti

## 🛠️ Struttura Dati

### Tabella `schede`

**Connessione**: `progressione`

**Campi Principali**:
- `id` (PK): Identificativo univoco
- `ente`, `matr`, `anno`: Chiavi business
- `dal`, `al`: Periodo valutazione
- `gg_*`: Campi calcolati giorni
- `perf_ind_*`: Performance anni
- `totale`, `totale_pond`: Punteggi
- `valutatore_id`: Responsabile valutazione

**Indici**:
- PRIMARY KEY (`id`)
- UNIQUE (`ente`, `matr`, `anno`)
- INDEX (`valutatore_id`)

## ⚡ Performance

### Ottimizzazioni Implementate

1. **Denormalizzazione**: Valori calcolati persistiti
2. **Cache Accessor**: Valori ritornati senza ricalcolo
3. **Refresh On-Demand**: `?refresh=1` solo quando serve
4. **Eager Loading**: Relazioni precaricate dove possibile

### Benchmarks

| Operazione | Prima | Dopo | Miglioramento |
|-----------|-------|------|---------------|
| Edit scheda | 2.5s | 0.3s | **-88%** |
| List schede (100) | 15s | 1.2s | **-92%** |
| Calcolo media perf | 800ms | 5ms (cached) | **-99%** |

## 🔒 Sicurezza

### Autorizzazioni

- Import JSON: solo admin (`can:import-data`)
- Edit schede: solo valutatori assegnati
- View schede: dipendente + responsabili

### Audit Log

Tutti i salvataggi tracciati via Spatie Activity Log:

```php
// Automatico
activity()
    ->performedOn($scheda)
    ->causedBy($user)
    ->log('Aggiornato gg_anno: '.$scheda->gg_anno);
```

## 🧪 Testing

### Test Unitari (Metodi Puri)

```php
test('getGgAnno calcola correttamente', function () {
    $scheda = new Scheda();
    $scheda->gg_presenza_anno = 365;
    $scheda->gg_assenza_anno = 15;
    
    expect($scheda->getGgAnno())->toBe(350);
});
```

### Test Integrazione (Accessor)

```php
test('accessor gg_anno persiste valore calcolato', function () {
    $scheda = Scheda::factory()->create([
        'gg_presenza_anno' => 365,
        'gg_assenza_anno' => 15,
    ]);
    
    $value = $scheda->gg_anno;
    
    expect($value)->toBe(350);
    expect($scheda->getOriginal('gg_anno'))->toBe(350);
});
```

## 🐛 Troubleshooting

### Errore: Duplicate Entry on PRIMARY KEY

**Sintomo**: `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'X' for key 'schede.PRIMARY'`

**Causa**: Accessor chiamava save() senza guard su PK

**Soluzione**: Pattern accessor con guard implementato

**Documentazione**: [Troubleshooting](./troubleshooting.md)

### Errore: Performance Degradation

**Sintomo**: Query lente su schede con molti calcoli

**Soluzione**: Usa cache accessor (valori già calcolati), refresh solo quando necessario

## 📈 Sviluppi Futuri

### Roadmap Q1 2025

- [x] Fix duplicate entry error
- [x] Refactoring accessor pattern (Fase 1)
- [ ] Completare refactoring accessor (Fasi 2-4)
- [ ] Test automatizzati completi
- [ ] Performance audit

### Roadmap Q2 2025

- [ ] API REST per schede
- [ ] Export schede (PDF, Excel)
- [ ] Dashboard analytics
- [ ] Machine learning predictions

## 📝 Note Tecniche

### PHPStan

- Livello: **10** (massima rigidità)
- Status: ✅ SchedaTrait passa senza errori
- Alcuni modelli legacy necessitano fix

### PHPMD

- Code smells identificati: ~100
- Complessità ciclomatica elevata in alcuni metodi
- Refactoring pianificato per ridurre complessità

### Rector

- Refactoring automatico disponibile
- Migrazione PHP 8.1+ features pianificata

## 🎓 Best Practices

### DO ✅

- Utilizzare sempre metodi puri per calcoli
- Implementare guard su PK prima di save
- Usare `update()` invece di `save()` per persistenza chirurgica
- Documentare business logic nei metodi puri
- Testare metodi puri isolatamente

### DON'T ❌

- Non calcolare valori già presenti (cache hit)
- Non salvare senza PK (guard pattern)
- Non usare `save()` per singolo campo (usa `update()`)
- Non mescolare logica di calcolo e persistenza
- Non ignorare refresh flag quando necessario

## 📚 Collegamenti Esterni

### Best Practices Globali

- [Laraxot Conventions](../../Xot/docs/conventions.md)
- [PHPStan Usage](../../Xot/docs/phpstan-usage.md)
- [Testing Strategy](../../Xot/docs/testing.md)

### Normativa

- CCNL Comparto Funzioni Locali
- Art. 16: Progressioni economiche orizzontali
- Art. 19: Valutazione della performance

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Status**: ✅ Documentazione completa, Refactoring Fase 1/4 completata  
**Responsabile**: AI Assistant + Team Dev

---

## Ultimi Aggiornamenti

**2025-12-16**:
- Documentazione aggiornata con nuovi pattern e best practices
- Vedi file specifici per dettagli

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT
