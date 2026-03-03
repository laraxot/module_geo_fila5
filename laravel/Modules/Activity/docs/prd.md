# PRD: Activity

## Document metadata

| Field | Value |
|---|---|
| Module | `Activity` |
| Connection | `activity` |
| Status | Implemented |
| Last updated | 2026-03-03 |

---

## 1. Module overview

### Purpose
Il modulo Activity fornisce un'infrastruttura completa di audit trail e event sourcing per PTVX. Traccia ogni azione utente e ogni evento di dominio tramite i pacchetti `spatie/laravel-activitylog` e `spatie/laravel-event-sourcing`, esponendo i dati attraverso tre risorse Filament dedicate.

### Module type
- [ ] Core infrastructure
- [x] Shared service
- [ ] Domain module
- [ ] Integration module
- [ ] Stub / planned

### Position in PTVX ecosystem
Il modulo Activity e' un servizio trasversale consumato da tutti gli altri moduli di dominio. Ogni modulo che richiede audit log o event sourcing dipende da questo. Il modulo dipende da `Xot` (base classes) e `User` (autenticazione).

---

## 2. Business goals

1. Garantire la tracciabilita' completa di ogni azione utente e di sistema per conformita' normativa e sicurezza.
2. Abilitare il pattern event sourcing per la ricostruzione dello stato del sistema in qualsiasi momento passato.
3. Fornire una dashboard Filament per la consultazione, ricerca e analisi dei log da parte degli amministratori.
4. Supportare la conformita' GDPR tracciando le operazioni sui dati sensibili.

---

## 3. Target users

| Role | Access level |
|---|---|
| System Administrator | Full read access, export |
| HR Administrator | Read-only, filtrato per modulo |
| Auditor / Compliance | Read-only, export report |
| Developer | Full access (ambiente non-production) |

---

## 4. User stories

- US-01: As a System Administrator, I want to see a chronological list of all user actions so that I can investigate anomalies.
- US-02: As a Compliance Officer, I want to filter activity logs by user, date range, and subject type so that I can produce audit reports.
- US-03: As a Developer, I want to replay stored events so that I can reconstruct the aggregate state at any point in time.
- US-04: As an HR Administrator, I want to see who modified a specific record and what changed so that I can verify data integrity.
- US-05: As a System Administrator, I want to view snapshots of aggregate state so that I can verify event sourcing consistency.

---

## 5. Functional requirements

| ID | Requirement | Priority |
|---|---|---|
| FR-01 | Tracciamento automatico di create/update/delete su modelli Eloquent tramite `LogsActivity` trait | Must have |
| FR-02 | Logging manuale di eventi custom (email inviate, PDF generati, export eseguiti) | Must have |
| FR-03 | Storico eventi di dominio su tabella `stored_events` con versioning aggregato | Must have |
| FR-04 | Snapshot dello stato aggregato per ottimizzare il replay degli eventi | Must have |
| FR-05 | Filament resource `ActivityResource` con lista, filtri per log_name/event/causer/date | Must have |
| FR-06 | Filament resource `StoredEventResource` con visualizzazione event_class e properties JSON | Must have |
| FR-07 | Filament resource `SnapshotResource` con visualizzazione stato aggregato | Must have |
| FR-08 | Action `ListLogActivitiesAction` utilizzabile da qualsiasi altra risorsa Filament | Must have |
| FR-09 | Retention policy configurabile per eliminazione log scaduti (GDPR) | Should have |
| FR-10 | Export CSV/Excel dei log di attivita' | Should have |
| FR-11 | Dashboard widget con trend attivita' per periodo | Could have |
| FR-12 | Notifiche real-time per eventi critici | Could have |

---

## 6. Non-functional requirements

- PHPStan Level 10 — zero errors
- Filament v5 + XotBase patterns (never extend Filament directly)
- Laravel 12 + Laraxot conventions
- Short array syntax `[]` everywhere
- No constructor DI — use `app(ActionClass::class)->execute()`
- All labels via `trans()` — never hardcoded
- PestPHP v4, MySQL (no SQLite), DatabaseTransactions trait
- 80% test coverage minimum
- Connessione database dedicata `activity` — non usare la connessione `mysql` di default
- `$connectionsToTransact` nei test deve includere `'activity'`

---

## 7. Architecture

### Module structure

```
Modules/Activity/
  app/
    Models/
      Activity.php         # Estende Spatie\Activitylog\Models\Activity
      StoredEvent.php      # Estende Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent
      Snapshot.php         # Estende Spatie\EventSourcing\Snapshots\EloquentSnapshot
      BaseModel.php        # Classe base astratta (non usata dai modelli Spatie)
    Filament/
      Actions/
        ListLogActivitiesAction.php
      Pages/
        ListLogActivities.php
      Resources/
        ActivityResource.php
        StoredEventResource.php
        SnapshotResource.php
    Providers/
      ActivityServiceProvider.php
      Filament/AdminPanelProvider.php
  database/migrations/
  lang/it/ en/ de/
  docs/
```

### Database connection
`activity` — configurata dinamicamente da TenantServiceProvider a partire dalla connessione `mysql` di default.

---

## 8. Data model

| Model | Table | Description |
|---|---|---|
| `Activity` | `activity_log` | Log azioni utente: causer, subject, properties JSON, event type |
| `StoredEvent` | `stored_events` | Eventi di dominio con aggregate_uuid, versioning e meta_data schemaless |
| `Snapshot` | `snapshots` | Snapshot dello stato aggregato per ottimizzare il replay eventi |

### Campi chiave di `activity_log`

| Campo | Tipo | Note |
|---|---|---|
| `log_name` | varchar | Canale di log (es. `default`, `badge`, `gdpr`) |
| `description` | text | Descrizione leggibile dell'azione |
| `subject_type` / `subject_id` | morphs | Record su cui e' stata eseguita l'azione |
| `causer_type` / `causer_id` | morphs | Utente che ha eseguito l'azione |
| `properties` | json | Dati strutturati: `old`, `attributes`, custom data |
| `event` | varchar | Tipo evento: `created`, `updated`, `deleted`, custom |
| `batch_uuid` | char(36) | Raggruppa azioni nella stessa transazione |

---

## 9. Filament resources

| Resource | Pages | Notes |
|---|---|---|
| `ActivityResource` | List | Filtri per log_name, event, causer, date range |
| `StoredEventResource` | List | Visualizzazione event_class, aggregate_uuid, properties JSON |
| `SnapshotResource` | List | Visualizzazione aggregate_uuid, version, state |

---

## 10. Integration points

| Module | Type | Description |
|---|---|---|
| Xot | Base classes | `HasXotFactory` trait usato su `StoredEvent` e `Snapshot` |
| User | Authentication | `causedBy($user)` collega ogni log all'utente autenticato |
| Tenant | Multi-tenancy | Connessione `activity` gestita da TenantServiceProvider |
| Gdpr | Compliance | I log di Activity supportano l'audit GDPR per i trattamenti dati |
| Spatie activitylog | Package | `spatie/laravel-activitylog` — base per il model `Activity` |
| Spatie event-sourcing | Package | `spatie/laravel-event-sourcing` — base per `StoredEvent` e `Snapshot` |

---

## 11. Out of scope

- Gestione delle policy di retention (GDPR) — pianificata, non ancora implementata
- Dashboard analytics con grafici e trend — pianificata
- API REST pubblica per i log — fuori scope
- Integrazione con sistemi di log esterni (Elasticsearch, Datadog) — fuori scope
- Notifiche real-time su eventi critici — fuori scope nella versione attuale

---

## 12. Technical constraints

- PHP ^8.3, Laravel 12, Filament v5, nwidart/laravel-modules
- Nuovi pacchetti nel `composer.json` del modulo, poi `composer go` da `laravel/`
- Tutti gli errori PHPStan Level 10 devono essere risolti prima del commit
- I modelli `Activity`, `StoredEvent`, `Snapshot` estendono classi Spatie, non `XotBaseModel` — usare `@method` PHPDoc annotations anziche' override di metodi statici per evitare conflitti return type con PHPStan
- `$connection = 'activity'` obbligatorio su tutti i modelli del modulo
