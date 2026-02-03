# Modulo Questionari - Documentazione

## Panoramica

Il modulo Questionari è progettato per gestire il sistema completo di creazione, distribuzione e analisi di questionari per l'organizzazione. Implementa un'architettura flessibile per la creazione di survey, sondaggi e valutazioni con supporto per diversi tipi di domande e logiche di risposta.

## Business Logic

### Sistema di Questionari Completo
Il modulo implementa un sistema avanzato per la gestione dei questionari:

#### 1. Creazione Questionari
- **Questionari Dinamici**: Creazione questionari con interfaccia drag-and-drop
- **Tipi Domanda**: Supporto per multiple choice, testo libero, scale, ranking
- **Logica Condizionale**: Skip logic e ramificazioni basate su risposte
- **Template Predefiniti**: Modelli per questionari comuni

#### 2. Distribuzione e Raccolta
- **Canali Multipli**: Email, web, mobile, QR code
- **Targetizzazione**: Invio mirato per gruppi specifici
- **Tracking Risposte**: Monitoraggio in tempo reale delle risposte
- **Reminder Automatici**: Sistema di solleciti per completamento

#### 3. Analisi e Reporting
- **Dashboard Analytics**: Visualizzazione risultati in tempo reale
- **Report Avanzati**: Filtri, crosstab, trend analysis
- **Export Dati**: Formati Excel, PDF, CSV, SPSS
- **Condivisione Risultati**: Report pubblici e privati

## Componenti Principali

### Dashboard
- **Dashboard Filament**: Interfaccia di gestione questionari
- **Widget Statistiche**: KPI questionari e risposte
- **Vista Questionari**: Elenco e stato questionari attivi

### Tipi Questionario
- **Sondaggi Opinione**: Raccolta feedback su servizi
- **Valutazioni Performance**: 360° feedback e self-assessment
- **Questionari Soddisfazione**: Customer satisfaction surveys
- **Quiz Formativi**: Test di apprendimento e verifica

## Architettura Tecnica

### Pattern Implementati
- **Builder Pattern**: Per creazione dinamica questionari
- **Strategy Pattern**: Per diverse logiche di validazione
- **Observer Pattern**: Per notifiche completamento
- **Repository Pattern**: Per gestione risposte

### Integrazione con Altri Moduli
- **User**: Collegamento a utenti per risposte personalizzate
- **Performance**: Integrazione con sistema di valutazione
- **Lang**: Sistema traduzioni completo
- **Activity**: Tracciamento modifiche questionari

## Configurazione

### File di Configurazione
- `config/questionari.php`: Configurazioni principali
- Variabili ambiente per parametri questionari

### Traduzioni
Struttura completa in:
- `lang/it/`: Italiano (principale)
- `lang/en/`: Inglese
- `lang/de/`: Tedesco

## Funzionalità Pianificate

### Creazione Questionari
- [ ] Builder visuale drag-and-drop
- [ ] Libreria template avanzata
- [ ] Import/Export questionari
- [ ] Versionamento questionari

### Distribuzione
- [ ] API per integrazioni esterne
- [ ] Webhook per eventi risposta
- [ ] Sistema notifiche push
- [ ] A/B testing questionari

### Analytics
- [ ] Machine learning per pattern detection
- [ ] Sentiment analysis per risposte testuali
- [ ] Dashboard real-time avanzate
- [ ] Report automatici schedulati

## Collegamenti

### Documentazione Interna
- [Questionario Builder](./questionario-builder.md)
- [Response Analytics](./response-analytics.md)

### Documentazione Moduli Correlati
- [Modulo Xot Service Provider Architecture](../xot/docs/service-provider-architecture.md)
- [Modulo Performance Evaluation System](../performance/docs/README.md)
- [Modulo User Authentication System](../user/docs/README.md)

### Documentazione Esterna
- [Laravel Survey Package](https://github.com/laravel-survey)
- [Filament Form Builder](https://filamentphp.com/docs)

*Ultimo aggiornamento: Sistema di documentazione automatica*

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT
