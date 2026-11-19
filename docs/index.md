---
title: "index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "index"
issues: []
discussions: []
---

# PTVX - Documentazione Completa

> Sistema Modulare per la Gestione della Pubblica Amministrazione

## 🚀 Quick Start

- **[Introduzione](./README.md)** - Panoramica del progetto
- **[Getting Started](./getting-started/)** - Setup e primi passi
- **[Installation](./installation.md)** - Guida installazione completa

## 🏗️ Architettura

### Fondamenti
- **[Architecture Overview](./architecture/)** - Architettura generale del sistema
<<<<<<< HEAD
- **[Directory Structure](./directory-structure.md)** - Struttura cartelle e organizzazione
=======
- **[Directory Structure](raw/history/directory-structure.md)** - Struttura cartelle e organizzazione
>>>>>>> laraxot/dev
- **[Module System](./development/module-development.md)** - Sistema modulare
- **[Dependency Management](./dependencies.md)** - Gestione dipendenze

### Moduli Core
- **[Xot Module](../../Xot/docs/README.md)** - Framework base
- **[User Module](../../User/docs/README.md)** - Autenticazione e autorizzazione
- **[UI Module](../../UI/docs/README.md)** - Componenti interfaccia
- **[Tenant Module](../../Tenant/docs/README.md)** - Multi-tenancy
- **[Lang Module](../../Lang/docs/README.md)** - Gestione traduzioni

### Design Patterns
<<<<<<< HEAD
- **[Service Providers](./service-provider-best-practices.md)** - Pattern service providers
- **[Data Transfer Objects](./best-practices/dto-pattern.md)** - DTO con Spatie Laravel Data
- **[Actions Pattern](./actions.md)** - Spatie QueueableActions
=======
- **[Service Providers](raw/history/service-provider-best-practices.md)** - Pattern service providers
- **[Data Transfer Objects](./best-practices/dto-pattern.md)** - DTO con Spatie Laravel Data
- **[Actions Pattern](raw/history/actions.md)** - Spatie QueueableActions
>>>>>>> laraxot/dev
- **[Event Sourcing](../../Activity/docs/event-sourcing.md)** - Event sourcing pattern

## 💻 Sviluppo

### Guide per Sviluppatori
- **[Development Guide](./development/)** - Guida completa sviluppo
- **[Module Development](./development/module-development.md)** - Creare nuovi moduli
- **[Coding Conventions](./conventions/)** - Convenzioni di codice
- **[Best Practices](./best-practices/)** - Best practices raccomandate

### Framework e Stack
- **[Laravel](./core/laravel.md)** - Framework Laravel
- **[Filament](./filament/)** - Admin panel Filament
<<<<<<< HEAD
- **[Livewire](./core/livewire.md)** - Componenti reattivi
- **[Blade Components](./blade-components.md)** - Componenti Blade

### Database
- **[Migrations](./database-migrations.md)** - Sistema migrazioni
- **[Models](./core/models.md)** - Eloquent models
- **[Repositories](./repositories.md)** - Pattern repository
- **[EAV System](./eav-system.md)** - Entity-Attribute-Value
=======
- **[Livewire](features/livewire.md)** - Componenti reattivi
- **[Blade Components](raw/history/blade-components.md)** - Componenti Blade

### Database
- **[Migrations](raw/history/database-migrations.md)** - Sistema migrazioni
- **[Models](architecture/models.md)** - Eloquent models
- **[Repositories](raw/history/repositories.md)** - Pattern repository
- **[EAV System](raw/history/eav-system.md)** - Entity-Attribute-Value
>>>>>>> laraxot/dev

## 🎨 Frontend

### UI/UX
- **[UI Components](./ui_components/)** - Componenti UI custom
- **[Theme System](./themes/)** - Sistema di temi
<<<<<<< HEAD
- **[Blade Components](./blade-components.md)** - Componenti Blade
- **[Forms](./filament/forms.md)** - Form builder
=======
- **[Blade Components](raw/history/blade-components.md)** - Componenti Blade
- **[Forms](features/forms.md)** - Form builder
>>>>>>> laraxot/dev

### Filament
- **[Resources](./filament/resources.md)** - Filament Resources
- **[Pages](./filament/pages.md)** - Custom pages
- **[Widgets](./filament/widgets.md)** - Dashboard widgets
<<<<<<< HEAD
- **[Actions](./filament/actions.md)** - Custom actions
=======
- **[Actions](raw/history/actions.md)** - Custom actions
>>>>>>> laraxot/dev
- **[Relation Managers](./filament/relation-managers.md)** - Gestione relazioni

## 🔒 Sicurezza

### Autenticazione e Autorizzazione
- **[Authentication](./core/authentication.md)** - Sistema autenticazione
<<<<<<< HEAD
- **[Authorization](./authorization.md)** - Autorizzazione e permessi
- **[Roles & Permissions](../../User/docs/roles-permissions.md)** - Gestione ruoli
- **[Teams](./teams.md)** - Gestione team

### Sicurezza Dati
- **[Security Best Practices](./security.md)** - Sicurezza applicazione
- **[GDPR Compliance](./gdpr-compliance.md)** - Conformità GDPR
=======
- **[Authorization](raw/history/authorization.md)** - Autorizzazione e permessi
- **[Roles & Permissions](../../User/docs/roles-permissions.md)** - Gestione ruoli
- **[Teams](raw/history/teams.md)** - Gestione team

### Sicurezza Dati
- **[Security Best Practices](./security.md)** - Sicurezza applicazione
- **[GDPR Compliance](raw/history/gdpr-compliance.md)** - Conformità GDPR
>>>>>>> laraxot/dev
- **[Audit Log](../../Activity/docs/README.md)** - Logging attività

## 🧪 Testing

### Strategia di Testing
- **[Testing Strategy](./testing/)** - Strategia generale
- **[Unit Testing](./testing/unit-testing.md)** - Test unitari
- **[Feature Testing](./testing/feature-testing.md)** - Test funzionali
- **[Integration Testing](./testing/integration-testing.md)** - Test di integrazione

### Qualità del Codice
- **[PHPStan](./best-practices/phpstan.md)** - Analisi statica
- **[Code Quality](./best-practices/code-quality.md)** - Qualità del codice
<<<<<<< HEAD
- **[Testing Guidelines](./testing/guidelines.md)** - Linee guida testing
=======
- **[Testing Guidelines](claude/architecture/guidelines.md)** - Linee guida testing
>>>>>>> laraxot/dev

## 📊 Performance
## 🗺️ Geo Filament Components

### Filosofia e Regole
- [**Filament Geo Pickers Philosophy**](filament-geo-pickers-philosophy.md) - Filosofia, visione e regole per i componenti Geo picker
- [**Map Picker Prompt**](/prompts/map-picker.txt) - Prompt per implementazione MapPicker

### Pickers Components
- CoordinatePicker - Il maestro Zen
- MapPicker / LocationPicker - Alias backward-compatible
- LatitudeLongitudeInput - Le viscere grezze
- PlacePicker - La guida al specifico
- MapPositioner - Il righello di prospettiva
- MapLocationInput - Input nascosto sincronizzato
- LeafletMarkerMapInput - L'amarker con memoria
- GeopointPicker - Il punto geografico puro

## 📋 Convenzioni e Standard

### Ottimizzazione
- **[Performance Optimization](./performance-optimization.md)** - Ottimizzazione generale
<<<<<<< HEAD
- **[Cache Management](./cache-management.md)** - Gestione cache
- **[Queue Management](./queue-management.md)** - Code e job
- **[Database Optimization](./performance/database.md)** - Ottimizzazione DB

### Monitoring
- **[Metrics Dashboard](./metrics-dashboard.md)** - Dashboard metriche
- **[Performance Monitoring](./performance/monitoring.md)** - Monitoraggio performance
=======
- **[Cache Management](raw/history/cache-management.md)** - Gestione cache
- **[Queue Management](raw/history/queue-management.md)** - Code e job
- **[Database Optimization](./performance/database.md)** - Ottimizzazione DB

### Monitoring
- **[Metrics Dashboard](raw/history/metrics-dashboard.md)** - Dashboard metriche
- **[Performance Monitoring](roadmap/monitoring.md)** - Monitoraggio performance
>>>>>>> laraxot/dev

## 🌐 Internazionalizzazione

### Traduzioni
- **[Lang Service](../../Lang/docs/README.md)** - Sistema traduzioni
- **[Translation Guidelines](./conventions/translations.md)** - Linee guida traduzioni
- **[Multi-language Support](./core/i18n.md)** - Supporto multilingua

## 🔧 Configurazione

### Setup e Configurazione
- **[Environment Setup](./getting-started/environment.md)** - Setup ambiente
- **[Configuration Files](./core/configuration.md)** - File di configurazione
- **[Module Configuration](./development/module-configuration.md)** - Configurazione moduli

## 🐛 Troubleshooting

### Risoluzione Problemi
- **[Common Errors](./common-errors.md)** - Errori comuni
- **[Debugging Guide](./troubleshooting/debugging.md)** - Guida al debugging
- **[Conflicts Resolution](./conflicts-resolution.md)** - Risoluzione conflitti
- **[Git Conflicts](./git-conflict-resolution.md)** - Conflitti Git

## 🚢 Deploy e Produzione

### Deployment
- **[Deployment Guide](./deployment/)** - Guida al deployment
- **[Server Configuration](./deployment/server.md)** - Configurazione server
- **[CI/CD](./deployment/ci-cd.md)** - Continuous Integration/Deployment

## 📚 Riferimenti

### API e Integrazioni
<<<<<<< HEAD
- **[API Development](./api-development.md)** - Sviluppo API
=======
- **[API Development](raw/history/api-development.md)** - Sviluppo API
>>>>>>> laraxot/dev
- **[External Integrations](./integrations/)** - Integrazioni esterne
- **[OAuth](./oauth/)** - Autenticazione OAuth

### Moduli Specifici PA
- **[Performance Module](../laravel/Modules/Performance/docs/README.md)** - Valutazioni
- **[Presenze Assenze](../laravel/Modules/PresenzeAssenze/docs/README.md)** - Timbrature
- **[Progressioni](../laravel/Modules/Progressioni/docs/README.md)** - Carriere
- **[Indennità](../laravel/Modules/IndennitaCondizioniLavoro/docs/README.md)** - Indennità

## 🗺️ Roadmap

### Sviluppo Futuro
<<<<<<< HEAD
- **[Project Roadmap](./project-roadmap.md)** - Roadmap generale
- **[Filament 4 Upgrade](./filament-4-upgrade-guide.md)** - Upgrade Filament 4
=======
- **[Project Roadmap](raw/history/project-roadmap.md)** - Roadmap generale
- **[Filament 4 Upgrade](raw/history/filament-4-upgrade-guide.md)** - Upgrade Filament 4
>>>>>>> laraxot/dev
- **[Laravel 11 Migration](./core/laravel-11-migration.md)** - Migrazione Laravel 11

## 📝 Convenzioni e Standard

### Naming e Style
- **[Documentation Conventions](./documentation-conventions.md)** - Convenzioni documentazione
- **[Naming Conventions](./conventions/naming.md)** - Convenzioni naming
- **[Code Style](./conventions/code-style.md)** - Stile del codice

### Regole Cursor/Windsurf
- **[Cursor Rules](../.cursor/rules/)** - Regole Cursor AI
- **[Windsurf Rules](../.windsurf/rules/)** - Regole Windsurf AI

## 🤝 Contribuire

### Come Contribuire
- **[Contributing Guide](./contributing/)** - Guida per contribuire
- **[Code of Conduct](./code-of-conduct.md)** - Codice di condotta
- **[Pull Request Process](./contributing/pr-process.md)** - Processo PR

## 📖 Risorse Aggiuntive

### Learning Resources
- **[Laravel Documentation](https://laravel.com/docs)** - Docs Laravel ufficiale
- **[Filament Documentation](https://filamentphp.com/docs)** - Docs Filament ufficiale
- **[PHPStan Documentation](https://phpstan.org/user-guide/)** - Guida PHPStan

### Community
- **GitHub Discussions**: [Link discussions]
- **Issues Tracker**: [Link issues]
- **Wiki**: [Link wiki]

---

title: "index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "index"
issues: []
discussions: []
## 🔍 Cerca nella Documentazione

Usa Ctrl/Cmd + F per cercare in questa pagina, oppure:
- [Cerca nei moduli](../..)
- [Cerca nelle regole AI](../.cursor/rules/)
- [Cerca negli script](../../../../bashscripts)

## 📧 Supporto

- **Email**: marco.sottana@gmail.com
- **Issues**: [GitHub Issues](link-issues)
- **Discussions**: [GitHub Discussions](link-discussions)

---

**Ultima Revisione**: 2025-01-29  
**Versione Documentazione**: 1.0.0  
**Responsabile Documentazione**: AI Assistant

**Versione**: 3.0
**Autore**: AI Assistant
**Stato**: Consolidata e Aggiornata
