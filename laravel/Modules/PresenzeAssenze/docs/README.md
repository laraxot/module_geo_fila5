# Modulo PresenzeAssenze - Documentazione

## Panoramica

Il modulo PresenzeAssenze è progettato per gestire il sistema completo di rilevazione presenze e gestione assenze per il personale dell'organizzazione. Implementa funzionalità per il controllo degli accessi, la registrazione delle presenze e la gestione delle assenze con integrazioni ai sistemi di performance.

## Business Logic

### Sistema di Rilevazione Presenze
Il modulo implementa un sistema completo per la gestione delle presenze:

#### 1. Rilevazione Presenze
- **Timbratura Ingresso/Uscita**: Registrazione automatica degli orari
- **Badge RFID**: Integrazione con sistemi di riconoscimento
- **App Mobile**: Timbratura tramite dispositivi mobili
- **Geolocalizzazione**: Controllo posizione per telelavoro

#### 2. Gestione Assenze
- **Tipologie Assenze**: Ferie, permessi, malattia, congedi
- **Flussi Approvazione**: Workflow per autorizzazione assenze
- **Calcolo Residui**: Gestione automatica giorni disponibili
- **Integrazione Buste Paga**: Export dati per elaborazione stipendi

#### 3. Report e Analytics
- **Dashboard Manageriali**: Visualizzazione aggregata presenze
- **Report Individuali**: Storico personale del dipendente
- **Anomalie**: Rilevazione automatica discrepanze
- **Export Multi-Formato**: PDF, Excel per elaborazioni esterne

## Componenti Principali

### Dashboard
- **Dashboard Filament**: Interfaccia di gestione presenze
- **Widget Statistiche**: Visualizzazione KPI presenze
- **Calendario Presenze**: Vista calendario interattiva

### Integrazione Performance
- **Collegamento Performance**: Impatto assenze su valutazioni
- **Calcolo Decurtazioni**: Penalizzazioni automatiche per assenze
- **Integrazione Modulo Performance**: Collegamento diretto al sistema di valutazione

## Architettura Tecnica

### Pattern Implementati
- **Observer Pattern**: Per reattività ai cambi di stato
- **Strategy Pattern**: Per diverse logiche di calcolo
- **Repository Pattern**: Per gestione dati presenze
- **Event-Driven**: Per notifiche e audit

### Integrazione con Altri Moduli
- **User**: Collegamento a utenti del sistema
- **Performance**: Impatto assenze su performance
- **Activity**: Tracciamento modifiche presenze
- **Lang**: Sistema traduzioni completo

## Configurazione

### File di Configurazione
- `config/presenzeassenze.php`: Configurazioni principali
- Variabili ambiente per parametri timbratura

### Traduzioni
Struttura completa in:
- `lang/it/`: Italiano (principale)
- `lang/en/`: Inglese
- `lang/de/`: Tedesco

## Funzionalità Pianificate

### Rilevazione Presenze
- [ ] Sistema timbratura con badge RFID
- [ ] App mobile per timbratura remota
- [ ] Integrazione sistemi biometrici
- [ ] Controllo geolocalizzazione

### Gestione Assenze
- [ ] Flussi approvazione multi-livello
- [ ] Calendario ferie condiviso
- [ ] Gestione congedi parentali
- [ ] Integrazione certificati medici

### Analytics
- [ ] Dashboard presenze real-time
- [ ] Report anomalie automatiche
- [ ] Predizioni assenteismo
- [ ] KPI per management

## Collegamenti

### Documentazione Interna
- [Dashboard Implementation](./dashboard.md)
- [Integration with Performance Module](./performance-integration.md)

### Documentazione Moduli Correlati
- [Modulo Xot Service Provider Architecture](../xot/docs/service-provider-architecture.md)
- [Modulo Performance Evaluation System](../performance/docs/README.md)
- [Modulo User Authentication System](../user/docs/README.md)

### Documentazione Esterna
- [Laravel Presence Management](https://laravel.com/docs/queues)
- [Filament Dashboard Widgets](https://filamentphp.com/docs)

*Ultimo aggiornamento: Sistema di documentazione automatica*

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT
