# Architettura, Filosofia, Religione, Politica e Zen del Progetto PTVX

## Scopo del Progetto

PTVX è un sistema di gestione integrato basato su Laravel con architettura modulare Laraxot. Il sistema è composto da **35 moduli indipendenti** che gestiscono diverse aree funzionali dell'organizzazione. L'obiettivo principale è fornire un framework modulare, scalabile e mantenibile per lo sviluppo di applicazioni enterprise con particolare attenzione a sicurezza avanzata, performance ottimizzate e supporto multilingua.

## Logica e Business Logic

### Architettura Modulare
- Ogni modulo rappresenta un'area funzionale indipendente
- I moduli comunicano tra loro attraverso contratti ben definiti
- Ogni modulo ha la propria struttura completa (Models, Views, Controllers, Filament Resources)
- I moduli possono essere abilitati/disabilitati in modo indipendente

### Componenti Chiave
1. **Xot**: Framework base che fornisce le classi astratte e i servizi comuni
2. **Filament 4**: Admin panel moderno per l'interfaccia utente
3. **Laraxot**: Architettura modulare personalizzata basata su nwidart/laravel-modules
4. **Spatie Packages**: Tool di qualità per permissioni, activity log, ecc.

### Pattern di Sviluppo
- Uso di Spatie QueueableAction invece di servizi tradizionali
- Estensione di classi XotBase invece di classi Filament dirette
- Gestione automatica delle traduzioni senza hardcoded
- Configurazione centralizzata dei componenti Filament

## Filosofia del Codice

### Principi Fondamentali
1. **DRY (Don't Repeat Yourself)**: Evitare duplicazioni di codice attraverso classi astratte e trait
2. **KISS (Keep It Simple, Stupid)**: Soluzioni semplici e dirette ai problemi complessi
3. **SOLID**: Rispetto dei principi SOLID attraverso architettura modulare e astrazioni

### Regole Critiche Laraxot
1. **Mai estendere classi Filament direttamente**, sempre usare XotBase equivalenti
2. **Mai usare label o traduzioni hardcoded**, lasciare che il framework gestisca automaticamente
3. **Evitare componenti deprecati** come BadgeColumn, usare alternative moderne
4. **Usare Spatie QueueableAction** invece di servizi tradizionali

### Approccio alle Traduzioni
- Sistema di traduzioni automatico basato sul nome del campo
- Nessuna stringa hardcoded nei componenti Filament
- Supporto multilingua completo (Italiano, Inglese, Tedesco)

## Religione del Codice

La "religione" del codice PTVX è incarnata dai **Service Provider** e dai **XotBase**:
- Ogni modulo ha un proprio ServiceProvider che estende XotBaseServiceProvider
- I Panel Provider estendono XotBasePanelProvider per garantire coerenza
- I percorsi e le configurazioni sono gestiti automaticamente dal framework
- Il framework gestisce automaticamente le dipendenze e i componenti

## Politica del Codice

La politica del codice è rappresentata dalle **convenzioni e regole di sviluppo**:
- Conformità a PSR-12 per lo stile del codice
- PHPStan livello 9+ per qualità del codice
- Naming convention specifici per ogni tipo di componente
- Standardizzazione dei nomi di file e directory

## Zen del Codice

Lo zen del codice PTVX è raggiunto attraverso:
- **Auto-discovery**: I componenti vengono automaticamente rilevati e registrati
- **Convenzioni intelligenti**: Il framework assume comportamenti standard, riducendo la configurazione
- **Estensibilità**: Ogni componente può essere esteso senza modificare il core
- **Consistenza**: Tutti i moduli seguono gli stessi pattern e convenzioni

## Componenti Principali

### XotBaseServiceProvider
Classe astratta che fornisce la base per tutti i service provider dei moduli:
- Registrazione automatica di views, traduzioni, migrations
- Configurazione dei componenti Blade e Livewire
- Gestione dei percorsi dei moduli

### XotBasePanelProvider
Classe astratta per i panel Filament:
- Configurazione automatica dei percorsi del panel
- Discovery automatico di resources, pages, widgets
- Gestione della navigazione e delle impostazioni comuni

### Struttura dei Moduli
Ogni modulo contiene:
- Datas: Oggetti dati per la gestione delle informazioni
- Actions: Azioni eseguibili basate su Spatie QueueableAction
- Filament: Resources, Pages, Widgets per l'interfaccia admin
- Models: Modelli Eloquent per la gestione dei dati
- Providers: Service provider per la registrazione dei componenti
- Traits: Funzionalità riutilizzabili attraverso i moduli

## Sicurezza e Compliance
- Autenticazione multi-tipo (Doctor, Patient, Admin)
- Role-Based Access Control con Spatie Permission
- GDPR Compliance completa
- Audit Trail per tutte le operazioni
- Multi-Tenancy per isolamento studi

## Performance Ottimizzate
- Database connections dedicate per moduli specifici
- Caching intelligente per dati frequenti
- Queue system per operazioni pesanti
- PHPStan livello 9+ per qualità codice

## Multilingua Completo
- Italiano (principale)
- Inglese (internazionalizzazione)
- Tedesco (supporto multilingua)
- Struttura traduzioni espansa per tutti i componenti