# Modulo Pdnd - Documentazione

## Panoramica
Il modulo Pdnd gestisce l'integrazione con la Piattaforma Digitale Nazionale Dati (PDND) per l'accesso ai servizi ANPR (Anagrafe Nazionale della Popolazione Residente).

## Componenti Principali

### 1. Servizi ANPR
Il modulo implementa diversi servizi di interrogazione ANPR:

#### C003 - Verifica Dichiarazione Generalità
- **Classe**: `C003Service`
- **Scopo**: Verifica la corrispondenza tra generalità dichiarate e quelle registrate in ANPR
- **Metodi principali**:
  - `verificaPerIdAnpr(string $idAnpr, TipoGeneralita $generalita)`: Verifica per ID ANPR
- **Pagine Filament**:
  - `ServizioVerificaDichGeneralita` (ambiente test)
  - `ServizioVerificaDichGeneralitaPROD` (ambiente produzione)

#### C030 - Accertamento ID Unico Nazionale
- **Classe**: `C030Service`
- **Scopo**: Ricerca soggetto per codice fiscale e ottiene ID ANPR
- **Metodi principali**:
  - `cercaPerCodiceFiscale(string $codiceFiscale)`: Cerca per codice fiscale
- **Pagine Filament**:
  - `ServizioAccertamentoIdUnicoNazionalePage` (ambiente test)
  - `ServizioAccertamentoIdUnicoNazionalePagePROD` (ambiente produzione)

### 2. Client PDND
- **Classe**: `PdndClientService`
- **Scopo**: Gestione autenticazione e comunicazione con PDND
- **Funzionalità**:
  - Generazione token OAuth2
  - Gestione certificati client
  - Configurazione ambiente (test/produzione)

### 3. Pagine Test
- **CurlProxyPage**: Test connessione proxy con cURL
- **GuzzleProxyPage**: Test connessione proxy con Guzzle

## Struttura Dati

### Modelli Request/Response
Il modulo utilizza Data Transfer Objects (DTO) per strutturare le richieste e risposte:

- `RichiestaE002`: Richiesta base per servizi ANPR
- `RispostaE002OK`: Risposta successo
- `RispostaKO`: Risposta errore
- `TipoGeneralita`: Dati anagrafici completi
- `TipoLuogoEvento`: Dati luogo nascita/residenza
- `TipoCodiceFiscale`: Wrapper per codice fiscale

### Enumerazioni
- `ServizioAnprEnum`: Elenco servizi ANPR disponibili
- `SessoEnum`: Valori ammessi per sesso (M/F)
- `TipoErroreEnum`: Tipologie di errori ANPR

## Flusso di Lavoro

### 1. Verifica Generalità (C003)
```
1. Utente inserisce dati anagrafici nel form
2. Sistema cerca ID ANPR tramite C030Service
3. Sistema verifica generalità tramite C003Service  
4. Risultato visualizzato all'utente
```

### 2. Accertamento ID (C030)
```
1. Utente inserisce codice fiscale
2. Sistema interroga ANPR via C030Service
3. Risposta contiene ID ANPR del soggetto
4. ID visualizzato all'utente
```

## Configurazione

### File di configurazione
- `config/pdnd.php`: Configurazione generale modulo
- Variabili ambiente richieste:
  - `PDND_CLIENT_ID`: ID client PDND
  - `PDND_CLIENT_SECRET`: Secret client
  - `PDND_CERTIFICATE_PATH`: Percorso certificato client
  - `PDND_KEY_PATH`: Percorso chiave privata
  - `PDND_ENVIRONMENT`: test|prod

### Traduzioni
File di traduzione in `lang/it/`:
- `pdnd.php`: Traduzioni generali modulo
- `servizio_verifica_dich_generalita.php`: Traduzioni C003
- `servizio_accertamento_id_unico_nazionale.php`: Traduzioni C030

## Best Practices

### Filament 4
Il modulo segue rigorosamente le best practice Filament 4 documentate in:
- [filament-best-practices.md](./filament-best-practices.md)

Regole chiave:
- ✅ Estensione di `XotBasePage` (mai classi Filament dirette)
- ✅ Nessun uso di `->label()`, `->placeholder()`, `->tooltip()`
- ✅ Import ordinati alfabeticamente
- ✅ Nessuna proprietà `$navigationIcon`, `$title`, `$navigationLabel`

### Gestione Errori
- Tutte le chiamate ai servizi ANPR sono wrappate in `try-catch`
- Log degli errori in `storage/logs/laravel.log`
- Notifiche utente tramite Filament Notifications
- Sanitizzazione dati in output per sicurezza Livewire

## Testing

### Test Proxy
- **CurlProxyPage**: Interfaccia per testare connessioni proxy
- **GuzzleProxyPage**: Test con libreria Guzzle

### Test Funzionali
```bash
php artisan test --filter=PdndPanelTest
```

## Troubleshooting

### Problema: Errore autenticazione PDND
**Causa**: Token OAuth2 scaduto o certificati non validi
**Soluzione**: Verificare configurazione in `.env` e validità certificati

### Problema: Timeout connessione
**Causa**: Proxy non configurato o non raggiungibile
**Soluzione**: Verificare configurazione proxy in `config/pdnd.php`

### Problema: PHPStan cache errors
**Causa**: Permessi directory `/tmp/phpstan/cache/`
**Soluzione**: Vedere [phpstan-fixes.md](./phpstan-fixes.md)

## Sicurezza

### Dati Sensibili
- I dati anagrafici sono gestiti solo in memoria (proprietà Livewire pubbliche)
- Nessun salvataggio automatico su database
- Log sanitizzati (nessun dato personale nei log)

### Autenticazione
- Token OAuth2 con JWT Bearer
- Certificati client per autenticazione mTLS
- Validazione response ANPR

## Performance

### Ottimizzazioni
- Lazy loading dei servizi ANPR
- Cache token OAuth2 (durata: configurabile)
- Timeout richieste configurabile

## Sviluppi Futuri

### Migrazione da Services a Actions
Conversione prevista seguendo pattern Spatie QueueableAction:
- [ ] `PdndClientService` → `PdndClientAction`
- [ ] `C003Service` → `VerificaGeneralitaAction`
- [ ] `C030Service` → `CercaPerCodiceFiscaleAction`

Documentazione pattern: [filament-best-practices.md](./filament-best-practices.md#6-architettura-actions-invece-di-services)

## Collegamenti

### Documentazione Interna
- [Best Practices Filament](./filament-best-practices.md)
- [Fix PHPStan Completi](./phpstan-complete-fixes.md)
- [Safe Functions Best Practices](./safe-functions-best-practices.md)
- [Fix PHPStan Storici](./phpstan-fixes.md)
- [Architettura Servizi](./services-architecture.md)
- [Struttura Traduzioni](./translations-structure.md)
- [Pulizia Import](./import-cleanup.md)
- [Changelog](./changelog.md)

### Documentazione Modulo Xot
- [XotBasePage Fix](../xot/docs/xotbasepage-getmodel-fix.md)
- [Service Provider Architecture](../xot/docs/service-provider-architecture.md)

### Documentazione Esterna
- [PDND Interoperabilità](https://docs.pagopa.it/interoperabilita-1/)
- [ANPR Servizi](https://www.anpr.interno.it/)
- [Filament 4 Docs](https://filamentphp.com/docs/4.x)
- [Spatie Queueable Actions](https://github.com/spatie/laravel-queueable-action)

*Ultimo aggiornamento: Sistema di documentazione automatica*

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Nicola Storgato <storgatonicola@provincia.treviso.it>

**License:** MIT
