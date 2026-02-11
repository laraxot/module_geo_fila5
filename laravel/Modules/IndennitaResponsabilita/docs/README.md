# Modulo Indennità Responsabilità

> **Business**: Sistema valutazione e calcolo indennità dirigenziali  
> **Status**: ✅ PHPStan Level 10 Compliant  
> **Last Update**: 2025-02-11 - Reactive forms with intelligent readonly handling  
> **Philosophy**: Transparency, Automation, Audit Trail

---

## 🎯 Scopo del Modulo

### Il Problema

Le PA devono valutare annualmente il personale dirigenziale e calcolare indennità di responsabilità basate su criteri oggettivi, garantendo trasparenza e tracciabilità.

### La Soluzione

Sistema che automatizza:
- **Valutazione**: Criteri configurabili per anno
- **Calcolo**: Formula automatica (punti → €)
- **Tracciabilità**: Audit trail completo
- **Documentazione**: PDF e lettere ufficiali

**Business Logic**: [business-logic.md](./business-logic.md) - PERCHÉ e COME funziona

## 🏗️ Architecture

- [Models & Relationships](architecture/models.md) - Struttura dati e relazioni
- [Business Logic](architecture/business-logic.md) - Regole di business e workflow
- [API Structure](architecture/api.md) - Endpoint e contratti API
- [Database Schema](architecture/database.md) - Struttura tabelle e migrazioni

## 💻 Development

- [Setup & Installation](development/setup.md) - Installazione e configurazione
- [Code Standards](development/standards.md) - Convenzioni e best practices
- [Testing Guide](development/testing.md) - Strategie di testing
- [Common Issues](development/troubleshooting.md) - Problemi frequenti e soluzioni

## ✅ Quality Assurance

- [PHPStan Compliance](quality/phpstan.md) - Analisi statica e fix applicati
- [Code Quality](quality/analysis.md) - Metriche e miglioramenti
- [Performance](quality/performance.md) - Ottimizzazioni e monitoring
- [Security](quality/security.md) - Misure di sicurezza implementate

## 🚀 Features

- [Responsibility Assessment](features/assessment.md) - Sistema di valutazione
- [Communication System](features/communication.md) - Email e notifiche
- [PDF Generation](features/pdf-generation.md) - Documenti automatici
- [Rating System](features/rating-system.md) - Valutazioni polimorfiche

## 🔧 Maintenance

- [Migrations & Updates](maintenance/migrations.md) - Gestione schema database
- [Monitoring](maintenance/monitoring.md) - Logging e monitoraggio
- [Backup & Recovery](maintenance/backup.md) - Strategie di backup
- [Changelog](maintenance/changelog.md) - Cronologia modifiche

## 📊 Key Metrics

| Aspect | Status | Details |
|--------|--------|---------|
| **PHPStan Level** | ✅ 10/10 | Full compliance achieved |
| **Test Coverage** | 🔄 Pending | Unit & Feature tests |
| **Performance** | ✅ Optimized | Query optimization applied |
| **Security** | ✅ Compliant | Input validation & policies |

## 🚀 Quick Start

```bash
# Install dependencies
composer install

# Run migrations
php artisan migrate

# Generate PDFs (example)
php artisan generate:responsibility-report {user_id}
```

## 🔗 Related Documentation

- [Main Project Docs](../../docs/AI-GUIDELINES.md) - Linee guida generali
- [Architecture Rules](../../docs/fundamentals/architecture-rules.md) - Regole critiche
- [Code Conventions](../../docs/development/conventions.md) - Standard di codifica

## 📞 Support

- **Issues**: Segnalare problemi via GitHub Issues
- **Discussions**: Discussioni tecniche su GitHub Discussions
- **Documentation**: Aggiornamenti automatici via CI/CD

---

**Module Lead**: Development Team
**Architecture**: Modular, SOLID compliant
**Testing**: Pest framework
**Quality**: PHPStan Level 9+, PHPMD, PHP Insights 

## File di Traduzione

Il modulo fornisce traduzioni complete in:
- **Italiano (it)**: Lingua principale
- **Inglese (en)**: Per internazionalizzazione
- **Tedesco (de)**: Per supporto multilingua

Vedere [translations.md](./translations.md) per dettagli sulla struttura delle traduzioni.

## Pagine Custom

- **Dashboard**: Dashboard specifica del modulo
- **CompilaIndennita**: Pagina per la compilazione delle indennità
- **ImportCSV**: Importazione dati da file CSV
- **ListSchedaLogActivities**: Visualizza storico modifiche tramite Activity Log

## Integrazione con Altri Moduli

### Activity Module

Il modulo utilizza il [Modulo Activity](../activity/docs/README.md) per tracciare tutte le modifiche ai record. Ogni record di IndennitaResponsabilita ha uno storico completo delle modifiche accessibile tramite la pagina `/activities`.

**Caratteristiche**:
- Tracciamento automatico di tutte le modifiche
- Storico completo con data, ora e utente
- Possibilità di ripristinare versioni precedenti
- Audit trail completo per compliance

**Documentazione completa**: [Integrazione Activity Log](./activity-log-integration.md)

**Errori comuni**: Se si riceve l'errore "No hint path defined for [activity]", consultare la [guida alla risoluzione](../activity/docs/errori/no-hint-path-defined.md).

## 📊 Code Quality

> **Status**: Refactoring needed  
> **PHPStan**: Level 9 (91 errors remaining)  
> **Priority**: Improve maintainability

### Key Issues

- God Class pattern (CompilaIndennitaResponsabilita: 457 lines)
- Missing Service Layer
- No DTO pattern
- Hardcoded strings in views

### Documentation

- [Code Quality Analysis](./code-quality-analysis.md) - Detailed analysis
- [Refactoring Plan](./refactoring-action-plan.md) - Action items
- [Best Practices](./best-practices.md) - Implementation guide
- [DRY+KISS Violations](./dry-kiss-violations-analysis.md) - Architectural issues

### Improvements Needed

| Area | Current | Target |
|------|---------|--------|
| PHPStan | Level 9 (91 errors) | Level 10 (0 errors) |
| Complexity | High (NPath 8192) | Low (<200) |
| Test Coverage | Partial | >85% |
| Service Layer | Missing | Implemented |

## Collegamenti

### Documentazione Tecnica
- [Struttura Traduzioni](./translations.md)
- [Integrazione Activity Log](./activity-log-integration.md)
- [Analisi Codice DRY/KISS/SOLID](./code-analysis-dry-kiss-solid.md)
- [Analisi Violazioni DRY/KISS](./dry-kiss-violations-analysis.md)
- [Business Logic Analysis](./business-logic-analysis.md)
- [Troubleshooting](./troubleshooting.md)

### Moduli Correlati

- [Modulo Activity - README](../activity/docs/README.md)
- [Modulo Xot - Base](../Xot/docs/README.md)
- [Modulo User](../User/docs/README.md)

### Best Practices & Guidelines

- **[Schemaless Attributes - PTVX Guide](../../../docs/claude/schemaless-attributes.md)** - ✅ Complete guide with correct usage patterns
- **[Rating Functions Refactoring](./refactoring-rating-functions.md)** - 🔴 **HIGH PRIORITY**: DRY+SOLID violations to fix
- **[HasRatingsTrait Best Practices](../../Rating/docs/has-ratings-trait-best-practices.md)** - ✅ Correct usage patterns

**✅ CORRECT PATTERNS** (tutti e tre sono validi):
```php
// Pattern 1: Array parameter (RACCOMANDATO)
$ratings = Rating::withExtraAttributes(['anno' => $anno])->get();

// Pattern 2: String + value parameters
$ratings = Rating::withExtraAttributes('anno', $anno)->get();

// Pattern 3: Direct JSON query (per query complesse)
$ratings = Rating::where('extra_attributes->anno', $anno)->get();
```

**Nota PHPStan**: Se PHPStan segnala errori su `withExtraAttributes()`, è un false positive. Vedi [guida schemaless](../../../docs/claude/schemaless-attributes.md) per le soluzioni.

### Troubleshooting
- [Troubleshooting Guide](./troubleshooting.md)

## 🚀 Quick Start

**New to this module?** Start here: [Quick Start Guide](./QUICK-START.md) (15 minutes)

## 🛠️ Development

### Convenzioni

- Seguire le [Regole Laraxot](../../Xot/docs/laraxot-conventions.md)
- Leggere [Best Practices](./best-practices.md) del modulo
- Estendere sempre `XotBaseResource` per le risorse Filament
- Utilizzare la struttura espansa per le traduzioni
- Non utilizzare mai `->label()` nei componenti Filament

### Testing

```bash
# Eseguire i test del modulo
php artisan test Modules/IndennitaResponsabilita/Tests

# Eseguire PHPStan livello 10
./vendor/bin/phpstan analyze Modules/IndennitaResponsabilita --level=10

# PHPMD
./vendor/bin/phpmd Modules/IndennitaResponsabilita text cleancode,codesize,design

# Format code
./vendor/bin/pint Modules/IndennitaResponsabilita
```

### Refactoring Status

**Analisi Completata**: 2025-01-02  
**Violations Identified**: 41  
**Critical Fixes**: 2 (implemented)  
**Refactoring Plan**: ✅ Ready ([View Plan](./refactoring-action-plan.md))

## 📖 Complete Documentation Index

### Analysis & Planning
- [📊 Analysis Summary](./analysis-summary-2025.md) - Executive summary & metrics
- [📋 Refactoring Action Plan](./refactoring-action-plan.md) - 18 tasks, 4 phases
- [🔍 Code Quality Analysis](./code-quality-analysis.md) - 37 violations detailed
- [❓ Why getRatings Should Move](./why-getratings-should-move.md) - Trait responsibility

### Implementation Guides
- [✅ Best Practices](./best-practices.md) - DO/DON'T patterns
- [🚀 Quick Start](./QUICK-START.md) - Fast onboarding
- [🧬 Rating Schemaless Usage](./rating-schemaless-usage.md) - Schemaless in this module
- [🏗️ Trait Responsibility](./trait-responsibility-violation.md) - DRY fix needed

## Ultimo Aggiornamento

**Versione**: 2.0  
**Data**: 2025-01-02  
**Autore**: Development Team  
**Status**: ✅ Analysis complete, refactoring planned



---

## Ultimi Aggiornamenti

**2025-12-16**:
- Documentazione aggiornata con nuovi pattern e best practices
- Vedi file specifici per dettagli

