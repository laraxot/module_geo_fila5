# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | User |
| **Repository** | laraxot/module_user_fila5 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo User è il sistema centrale per la gestione dell'identità nell'ecosistema Laraxot. Gestisce autenticazione, autorizzazione, ruoli, team, tenant e integrazioni OAuth. È il modulo fondamentale su cui si basano tutti gli altri moduli per l'accesso e i permessi.

### Visione
Fornire un sistema di identity management completo, sicuro e flessibile per applicazioni Laravel/Filament multi-tenant, con supporto nativo per OAuth e autenticazione a più fattori.

### Target Users
- **Amministratori**: gestione utenti, ruoli, permessi
- **Utenti finali**: autenticazione, gestione profilo
- **Sviluppatori**: integrazione con altri moduli

---

## 2. Problema

### Problema Risolto
La gestione dell'autenticazione e autorizzazione in applicazioni Laravel/Filament richiede spesso integrazione manuale di multiple librerie. Questo modulo unifica:

1. **Autenticazione**: Login, logout, reset password, remember me
2. **Autorizzazione**: Ruoli e permessi tramite Spatie
3. **OAuth**: Integrazione con provider esterni (Microsoft, Google, GitHub)
4. **Multi-tenancy**: Identificazione e gestione contesto utente

### Pain Points Attuali
- Frammentazione delle soluzioni di autenticazione
- Difficoltà nell'integrazione OAuth
- Mancanza di standard per gestione ruoli
- Complessità nel supporto multi-tenant
- Assenza di 2FA nativo

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Amministratore | creare nuovi utenti | permettere accesso all'applicazione |
| Amministratore | assegnare ruoli agli utenti | controllare cosa possono fare |
| Utente finale | fare login con account Microsoft | non dover creare nuove credenziali |
| Utente finale | abilitare 2FA | aumentare la sicurezza del mio account |
| Sviluppatore | verificare se un utente ha un permesso | controllare l'accesso a funzionalità |
| Amministratore | gestire team di utenti | organizzare utenti per dipartimento |
| Sistema | identificare il tenant corrente | filtrare i dati per tenant |

---

## 3. Stakeholder

| Ruolo | Nome | Responsabilità |
|-------|------|----------------|
| Product Owner | Marco Sottana | Decisioni feature, priorità |
| Tech Lead | | Architettura, decisioni tecniche |
| Backend Developer | | Implementazione API, auth |
| Frontend Developer | | UI Filament, form |
| Security Expert | | Review sicurezza, 2FA |

---

## 4. Soluzione Proposta

### Approccio Architetturale
Il modulo User segue il pattern **Service-Based** con:
- **BaseUser**: Modello Eloquent base con trait per soft deletes, timestamps
- **UserService**: Logica di business per operazioni CRUD
- **AuthService**: Gestione autenticazione e sessioni
- **RoleService**: Gestione ruoli e permessi

### Funzionalità Core

#### 4.1 Autenticazione
- [x] Login con email/password
- [x] Logout
- [x] Reset password via email
- [x] Remember me
- [x] Session management
- [x] Protezione CSRF

#### 4.2 Autorizzazione (Spatie)
- [x] Ruoli (Role)
- [x] Permessi (Permission)
- [x] Direttive Blade (@can, @role)
- [x] Middleware (roles, permissions)
- [x] Model HasRoles trait

#### 4.3 OAuth (Laravel Passport + Socialite)
- [x] Microsoft Azure AD
- [x] Google
- [x] GitHub
- [x] Auth0 (configurabile)
- [x] Token API management

#### 4.4 Two-Factor Authentication
- [x] TOTP (Google Authenticator)
- [x] Backup codes
- [x] QR code setup

#### 4.5 Gestione Team
- [x] Creazione team
- [x] Inviti utenti
- [x] Ruoli a livello team
- [x] Scope team

#### 4.6 Gestione Tenant
- [x] Identificazione tenant da utente
- [x] Scope automatico query
- [x] Middleware tenant

### Flussi Utente

#### Flusso: Login Standard
```
1. Utente accede /login
2. In + password
3.serisce email Sistema valida credenziali
4. Sistema crea sessione
5. Redirect a dashboard
```

#### Flusso: Login OAuth Microsoft
```
1. Utente clicca "Accedi con Microsoft"
2. Redirect a Azure AD
3. Utente autorizza app
4. Callback con code
5. Sistema scambia code per token
6. Crea/aggiorna utente locale
7. Login completato
```

#### Flusso: Assegnazione Ruolo
```
1. Admin accede a User Management
2. Seleziona utente
3. Clicca "Assegna Ruolo"
4. Seleziona ruolo da dropdown
5. Sistema salva relazione
6. Notifica utente (opzionale)
```

---

## 5. Scope

### In Scope (Inclusi)
- [x] Autenticazione email/password
- [x] Reset password
- [x] Ruoli e permessi Spatie
- [x] OAuth Microsoft, Google, GitHub
- [x] Laravel Passport API tokens
- [x] Two-Factor Authentication
- [x] Gestione team
- [x] Gestione profilo utente
- [x] Import/Export utenti

### Out of Scope (Esclusi)
- [ ] LDAP/Active Directory integration
- [ ] SAML SSO
- [ ] Gestione billing
- [ ] Notifiche push

### Non-Goals
- Sistema di login sociale consumer (solo OAuth enterprise)
- Multi-factor con SMS (solo TOTP)
- Single Sign-On esterno

---

## 6. Metriche di Successo

### KPI Tecnici
| KPI | Target | Misura |
|-----|--------|--------|
| PHPStan Level | 10 (0 errori) | `./vendor/bin/phpstan analyse` |
| Test Coverage | >70% | `pest --coverage` |
| Response Time Login | <500ms | Laravel Debugbar |

### KPI Funzionali
| KPI | Target | Misura |
|-----|--------|--------|
| Uptime | 99.9% | Monitoring |
| Failed Login Attempts | <1% | Log analisi |
| 2FA Adoption | >50% entro Q2 | User stats |

### Metriche Qualitative
- Feedback utente su semplicità login
- Ticket supporto per auth issues

---

## 7. Timeline e Milestone

### Milestone
| Milestone | Data Prevista | Deliverable |
|-----------|---------------|--------------|
| M1: Core Auth | Settimana 1-2 | Login, logout, reset password |
| M2: OAuth | Settimana 3-4 | Microsoft, Google, GitHub |
| M3: Roles/Permissions | Settimana 5-6 | CRUD ruoli, middleware |
| M4: 2FA | Settimana 7 | TOTP setup, verifica |
| M5: Teams | Settimana 8 | Gestione team |
| M6: Testing | Settimana 9 | Test coverage >70% |
| M7: Launch | Settimana 10 | Release v1.0 |

### Stima Effort
- Sviluppo: 6-8 settimane
- Testing: 2 settimane
- Buffer: 2 settimane
- **Totale**: ~10 settimane

---

## 8. Dipendenze

### Dipendenze Esterne
| Pacchetto | Versione | Scopo |
|-----------|----------|-------|
| laravel/passport | * | API OAuth |
| spatie/laravel-permission | * | Ruoli e permessi |
| socialiteproviders/microsoft | ^4.8 | OAuth Microsoft |
| socialiteproviders/google | * | OAuth Google |
| socialiteproviders/github | * | OAuth GitHub |
| socialiteproviders/auth0 | * | OAuth Auth0 |
| jenssegers/agent | * | Device detection |
| flowframe/laravel-trend | * | Analytics |

### Dipendenze Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende (classi base) |
| Tenant | Dipende (scope tenant) |
| UI | Dipende (componenti) |

### Conflitti Potenziali
- Con moduli che usano auth diversa
- Con altri sistemi di ruoli

---

## 9. Risk e Assunzioni

### Rischi
| Rischio | Probabilità | Impatto | Mitigazione |
|---------|-------------|---------|-------------|
| OAuth provider down | Bassa | Alto | Fallback a login standard |
| Token theft | Bassa | Alto | HTTPS only, expiry |
| 2FA lost | Media | Medio | Backup codes |
| Performance con molti ruoli | Media | Basso | Cache, ottimizzazione query |

### Assunzioni
- Utenti hanno accesso a email per reset
- Microsoft Graph API disponibile
- TLS/HTTPS configurato
- PHP 8.2+ disponibile

---

## 10. Domande Aperte

- [ ] Supporto LDAP/AD? (Q2 2026)
- [ ] Implementare SAML? 
- [ ] Notifiche push per login?
- [ ] Login con SPID/CIE?

---

## 11. Appendici

### Riferimenti Tecnici
- [Laravel Passport Docs](https://laravel.com/docs/passport)
- [Spatie Permissions](https://spatie.be/docs/laravel-permission)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [OAuth 2.0 Microsoft](https://docs.microsoft.com/en-us/azure/active-directory/develop/)

### Glossario
| Termine | Definizione |
|---------|-------------|
| OAuth | Protocollo per autorizzazione |
| 2FA | Autenticazione a due fattori |
| TOTP | Time-based One-Time Password |
| Tenant | Singola istanza nell'app multi-tenant |
| Role | Gruppo di permessi |
| Permission | Singolo permesso |

### Database Schema
```
users
├── id
├── name
├── email
├── password
├── tenant_id (nullable)
├── email_verified_at
├── two_factor_secret
├── two_factor_recovery_codes
└── timestamps

model_has_roles
├── role_id
├── model_type
└── model_id

model_has_permissions
├── permission_id
├── model_type
└── model_id
```

---

## 12. Changelog

| Version | Data | Autore | Modifiche |
|---------|------|--------|------------|
| 1.0.0 | 2026-03-03 | | Initial PRD |
