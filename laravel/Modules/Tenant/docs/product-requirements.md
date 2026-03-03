# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | Tenant |
| **Repository** | laraxot/module_tenant_fila3 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Tenant implementa l'architettura **multi-tenant** per l'ecosistema Laraxot. Permette a una singola istanza dell'applicazione di servire organizzazioni multiple con **isolamento dati completo**.

### Visione
Fornire un sistema di multi-tenancy trasparente che:
- Isola i dati tra tenant automaticamente
- Semplifica lo sviluppo per contesti multi-tenant
- Non richiede modifiche al codice dei moduli
- Scala_orizzontalmente

### Target Users
- **SaaS Providers**: applicazioni che servono multiple aziende
- **Admin**: gestione tenant
- **Developer**: integrazione tenant-aware

---

## 2. Problema

### Problema Risolto
Le applicazioni multi-tenant richiedono:
1. **Isolamento dati**: Query automaticamente limitate al tenant
2. **Identificazione tenant**: Determinare quale tenant sta operando
3. **Configurazione**: Ogni tenant ha impostazioni diverse
4. **Resource sharing**: Possibilità di condividere dati tra tenant

Senza un modulo dedicato, ogni modulo deve implementare la logica manualmente → errori e inconsistenza.

### Pain Points Attuali
- Query dimenticate che espongono dati di altri tenant
- Difficoltà nel gestire tenant hierarchies
- Configurazione tenant-fragmented
- Testing di scenari multi-tenant complesso

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Amministratore | creare nuovo tenant | dare accesso a nuova organizzazione |
| Utente | vedere solo i miei dati | lavorare nel mio contesto |
| Developer | fare query tenant-aware | non preoccuparmi di filtri |
| Sistema | cambiare tenant utente | impersonare un utente |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Product Owner | Feature decisioni |
| Architect | Schema database, caching |
| Developer | Integrazione moduli |

---

## 4. Soluzione Proposta

### Architettura

```
Request
    ↓
Tenant Detection (subdomain, header, user)
    ↓
Tenant Context Set
    ↓
Query Scope Applied (automatic)
    ↓
Response
```

### Strategie Multi-Tenancy

#### 4.1 Tenant by Subdomain
```
tenant1.app.com → tenant_id = 1
tenant2.app.com → tenant_id = 2
```

#### 4.2 Tenant by Header
```
X-Tenant-ID: 1
```

#### 4.3 Tenant by User
```
Utente.logged → tenant_id = user.tenant_id
```

### Funzionalità Core

#### 4.1 Tenant Identification
- [x] Subdomain resolution
- [x] Header-based detection
- [x] User-based fallback
- [x] Custom resolvers

#### 4.2 Tenant Scoping
- [x] Global query scope
- [x] Model trait automatic
- [x] Exclude models (es. settings globali)
- [x] Cross-tenant queries (admin)

#### 4.3 Tenant Management
- [x] CRUD tenant
- [x] Tenant settings
- [x] Domain management
- [x] Tenant switching (super-admin)

#### 4.4 Tenant Isolation
- [x] Database per tenant (opzionale)
- [x] Row-level isolation
- [x] File storage isolation
- [x] Cache per tenant

#### 4.5 Tenant Features
- [x] Feature flags per tenant
- [x] Usage tracking
- [x] Subscription status
- [x] Plan management

### Flussi Utente

#### Flusso: Identificazione Tenant
```
1. Request arriva
2. Sistema verifica subdomain
3. Se non trovato, verifica header X-Tenant-ID
4. Se non trovato, usa tenant dell'utente loggato
5. Imposta Tenant Context
6. Tutte le query automaticamente filtrate
```

---

## 5. Scope

### In Scope
- [x] Identificazione tenant
- [x] Query scoping automatico
- [x] Gestione tenant CRUD
- [x] Isolamento dati
- [x] Feature flags

### Out of Scope
- [ ] Billing/Subscription management
- [ ] White-labeling
- [ ] Multi-region

---

## 6. Metriche di Successo

| KPI | Target |
|-----|--------|
| Data Leakage | 0 occorrenze |
| Query Performance | <+10ms overhead |
| Tenant Switch | <100ms |

---

## 7. Dipendenze

### Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende |
| User | Dipende (tenant association) |

### Esterne
Nessuna dipendenza esterna core. Opzionali:
- Laravel-cashier (billing)
- Spatie-permission (tenant roles)

---

## 8. Appendici

### Glossario
| Termine | Definizione |
|---------|-------------|
| Tenant | Singola organizzazione/azienda |
| Tenant Context | Variabile globale tenant corrente |
| Row-Level Isolation | Filtro automatico per tenant_id |
| Feature Flag | Toggle funzionalità per tenant |

### Schema Database
```
tenants
├── id
├── name
├── slug
├── domain
├── settings (JSON)
├── is_active
└── timestamps
```
