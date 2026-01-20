# Modulo IndennitaResponsabilita - Gestione Indennità di Responsabilità

> **Version**: 3.1 - Filament 4.x Upgrade Complete
> **Status**: Production Ready
> **Last Updated**: December 2025

## Descrizione

Il modulo **IndennitaResponsabilita** gestisce il sistema completo di calcolo e gestione delle indennità di responsabilità per il personale dell'organizzazione. Include workflow di valutazione, calcolo automatico degli importi e generazione di report dettagliati.

## Funzionalità Principali

### 1. Gestione Indennità di Responsabilità
- **Modello principale**: `IndennitaResponsabilita`
- **Campi di valutazione**: complessità (0-40), coordinamento (0-30), responsabilità (0-30)
- **Calcolo automatico** del totale e del valore economico
- **Validazione** dei dati inseriti

### 2. Sistema di Comunicazioni
- **LettF**: Lettere di tipo F per comunicazioni formali
- **LettI**: Lettere di tipo I per comunicazioni interne
- **Email automatiche** con allegati PDF generati dinamicamente

### 3. Sistema di Rating
- **Rating**: Valutazioni standard
- **RatingMorph**: Valutazioni polimorfiche per diversi tipi di entità
- **Message**: Sistema di messaggistica integrato

### 4. Gestione Dati di Riferimento
- **StabiDirigente**: Anagrafica stabilimenti dirigenti
- **ImportiCategoria**: Configurazione importi per categoria

## Struttura del Modulo

```
app/
├── Actions/           # Azioni per PDF e invio email
├── Emails/           # Classi per l'invio email
├── Filament/         # Interfaccia amministrativa Filament
├── Http/             # Controller e middleware
├── Models/           # Modelli Eloquent
└── Providers/        # Service provider del modulo

database/
├── factories/        # Factory per testing
├── migrations/       # Migrazioni database
└── seeders/         # Seeder per dati iniziali

resources/
├── lang/            # File di localizzazione
└── views/           # Template Blade

tests/               # Test suite
```

## Modelli Principali

### IndennitaResponsabilita
Modello principale per la gestione delle indennità.

**Campi principali**:
- `complessita` (0-40): Livello di complessità del ruolo
- `coordinamento` (0-30): Livello di coordinamento richiesto
- `responsabilita` (0-30): Livello di responsabilità
- `valore_economico_calcolato`: Calcolato automaticamente
- `valore_economico_attribuito`: Valore finale assegnato

### LettF / LettI
Modelli per la gestione delle comunicazioni formali e interne.

### Rating / RatingMorph
Sistema di valutazione flessibile con supporto per relazioni polimorfiche.

## Interfaccia Filament

Il modulo utilizza **Filament v3** per l'interfaccia amministrativa con:

- **Resource**: CRUD completo per tutti i modelli
- **Pages**: Pagine personalizzate per operazioni specifiche
- **Actions**: Azioni per generazione PDF e invio email
- **Dashboard**: Pannello di controllo dedicato

## Configurazione

Il modulo è configurabile tramite:
- `config/config.php`: Configurazione generale
- File di localizzazione in `lang/it/`
- Variabili d'ambiente per email e PDF

## Dipendenze

- **Laravel Framework 11.x**
- **Filament 3.x**
- **Moduli Sigma**: Per integrazione anagrafica
- **Moduli Xot**: Per funzionalità comuni

## Installazione e Setup

1. Il modulo si attiva automaticamente tramite il service provider
2. Eseguire le migrazioni: `php artisan migrate`
3. Configurare le email in `.env`
4. Impostare i parametri specifici nel pannello amministrativo

## Testing

Il modulo include test completi:
- **Unit test** per i modelli
- **Feature test** per le interfacce Filament
- **Factory** per la generazione di dati di test

Eseguire i test con: `php artisan test`

## Sicurezza

- **Policy** implementate per tutti i modelli
- **Validazione** su tutti i form
- **Middleware** personalizzato per l'accesso Filament

## Manutenzione

### Analisi Statica del Codice
- **PHPStan**: Livello 9 (91 errori rimanenti su 148 file analizzati)
- **Ultimo fix**: 10 dicembre 2025 - Riduzione errori da 100 a 91
- **PHP CS Fixer** per standard di codifica
- **Psalm** per ulteriore analisi statica

#### Miglioramenti Recenti
- ✅ Correzione tipi di ritorno per `getFormSchema()` nei Resource
- ✅ Fix import mancanti per componenti Filament
- ✅ Correzione strutture array per compatibilità PHPStan
- ✅ Aggiornamento policy con namespace corretti

Vedi: [PHPStan Fixes Applied](docs/phpstan-fixes-applied-2025-12-10.md)