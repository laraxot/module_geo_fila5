# Product Requirements Document (PRD)

## Metadata

| Campo | Valore |
|-------|--------|
| **Version** | 1.0.0 |
| **Status** | Approved |
| **Last Updated** | 2026-03-03 |
| **Owner** | Core Team |
| **Module** | Notify |
| **Repository** | laraxot/module_notify_fila3 |

---

## 1. Panoramica del Prodotto

### Descrizione Breve
Il modulo Notify fornisce un sistema di notifiche **multi-canale** unificato per l'ecosistema Laraxot. Supporta email, SMS, WhatsApp, Telegram e Firebase Cloud Messaging (FCM) con un'interfaccia comune per la gestione e l'invio.

### Visione
Semplificare le comunicazioni con gli utenti attraverso canali multipli, con:
- Unificazione dell'API di invio
- Template system flessibile
- Code asincrone per performance
- Tracking e analytics

### Target Users
- **Amministratori**: invio notifiche manuali
- **Sistema**: notifiche automatiche (event-driven)
- **Utenti**: ricezione e preferenze

---

## 2. Problema

### Problema Risolto
Ogni canale di comunicazione richiede configurazioni, SDK e logiche diverse:
- Email → Laravel Mail
- SMS → Provider multipli
- WhatsApp → API WhatsApp Business
- Telegram → Bot API
- Push → Firebase

Questo porta a:
- Codice duplicato
- Inconsistenza nei template
- Difficoltà nel monitoraggio
- Gestione preferenze utente complessa

### Pain Points Attuali
- Configurazione provider separata per ogni canale
- Nessun template unificato
- Tracking frammentato
- Rate limiting non gestito
- Fallback non implementato

### Job Stories

| Quando | Voglio | Per |
|--------|--------|-----|
| Sviluppatore | inviare notifica senza conoscere il canale | semplificare il codice |
| Admin | creare template HTML per email | mantenere consistenza |
| Utente | scegliere come ricevere notifiche | gestire preferenze |
| Sistema | retry automatico se fallisce | garantire deliverability |
| PM | vedere statistiche invio | monitorare engagement |

---

## 3. Stakeholder

| Ruolo | Responsabilità |
|-------|----------------|
| Product Owner | Priorità feature, budget provider |
| Backend Developer | Integrazione API, code |
| DevOps | Configurazione code, monitoring |

---

## 4. Soluzione Proposta

### Architettura

```
Notification
    ↓
Channel Resolver (canale preferito)
    ↓
├── Email Channel → Mailgun/SES/Postmark
├── SMS Channel → AWS SNS/Twilio
├── WhatsApp Channel → WhatsApp API
├── Telegram Channel → Bot API
└── FCM Channel → Firebase
```

### Funzionalità Core

#### 4.1 Notifiche Email
- [x] Driver multipli (Mailgun, SES, Postmark, SMTP)
- [x] Template Markdown
- [x] Code asincrone
- [x] Batching
- [x] Tracking apertura (opzionale)

#### 4.2 Notifiche SMS
- [x] AWS SNS integration
- [x] Twilio integration
- [x] Long message splitting
- [x] Delivery status webhook

#### 4.3 WhatsApp Business
- [x] WhatsApp Business API
- [x] Template messages
- [x] Media support
- [x] Session messages

#### 4.4 Telegram Bot
- [x] Bot API integration
- [x] Inline keyboards
- [x] Commands
- [x] Webhook receiver

#### 4.5 Firebase Cloud Messaging (Push)
- [x] FCM v1 API
- [x] Topic subscriptions
- [x] Data messages
- [x] Notification messages
- [x] APNs (iOS) support

#### 4.6 Template System
- [x] Database-driven templates
- [x] Variable interpolation
- [x] Multi-lingua
- [x] Versioning
- [x] Preview

#### 4.7 Preference Management
- [x] Canale preferito per utente
- [x] Opt-in/opt-out per tipo
- [x] Quiet hours
- [x] UI per gestione

#### 4.8 Queue & Retry
- [x] Laravel Queue integration
- [x] Exponential backoff
- [x] Dead letter queue
- [x] Rate limiting per provider

### Flussi Utente

#### Flusso: Invio Notifica
```
1. Developer chiama Notification::send($user, $notification)
2. Notify resolves canale preferito
3. Job creato in coda
4. Worker invia al provider
5. Result registrato
6. User riceve notifica
```

#### Flusso: Gestione Preferenze
```
1. Utente accede a Impostazioni
2. Seleziona "Notifiche"
3. Sceglie canale preferito per tipo
4. Sistema salva preferenza
5. Future notifiche usano canale selezionato
```

---

## 5. Scope

### In Scope (Inclusi)
- [x] Tutti i 5 canali (Email, SMS, WhatsApp, Telegram, FCM)
- [x] Template system
- [x] Preference management
- [x] Queue & retry
- [x] Logging
- [x] Webhook handlers

### Out of Scope (Esclusi)
- [ ] Notifiche in-app real-time (WebSocket)
- [ ] Email marketing (newsletter)
- [ ] SMS marketing

### Non-Goals
- Direct carrier billing
- Voice notifications
- Video messaging

---

## 6. Metriche di Successo

### KPI Tecnici
| KPI | Target | Misura |
|-----|--------|--------|
| Email Delivery | >99% | Provider stats |
| SMS Delivery | >98% | Provider stats |
| FCM Delivery | >95% | Console analytics |
| Retry Success | >90% | DLQ analysis |

### KPI Funzionali
| KPI | Target | Misura |
|-----|--------|--------|
| Setup Time | <30 min | Onboarding docs |
| Template Creation | <5 min | UI test |

---

## 7. Timeline e Milestone

| Milestone | Data | Deliverable |
|-----------|------|-------------|
| M1: Email Core | Settimana 1-2 | Driver email, templates |
| M2: SMS/WhatsApp | Settimana 3-4 | Provider integration |
| M3: Push/Telegram | Settimana 5-6 | FCM, Bot |
| M4: Preferences | Settimana 7-8 | UI gestione |
| M5: Testing | Settimana 9 | Coverage >70% |

---

## 8. Dipendenze

### Esterne
| Pacchetto | Scopo |
|-----------|-------|
| aws/aws-sdk-php | AWS SNS, SES |
| kreait/laravel-firebase | FCM |
| irazasyed/telegram-bot-sdk | Telegram |
| laravel-notification-channels/* | Canali vari |

### Interne
| Modulo | Relazione |
|--------|-----------|
| Xot | Dipende |
| User | Dipende (preferenze) |
| Tenant | Dipende (scope) |

---

## 9. Risk e Assunzioni

### Rischi
| Rischio | Mitigazione |
|---------|-------------|
| Provider down | Fallback ad altro canale |
| Rate limits | Backoff, queueing |
| Costi SMS/WhatsApp | Budget alert, throttling |

### Assunzioni
- Provider credentials configurati
- Queue worker attivo
- Sufficienti crediti provider

---

## 10. Appendici

### Canali Supportati
| Canale | Provider Default | Status |
|--------|------------------|--------|
| Email | Mailgun | ✅ |
| SMS | AWS SNS | ✅ |
| WhatsApp | WhatsApp Business | ✅ |
| Telegram | Bot API | ✅ |
| Push | FCM | ✅ |

### Glossario
| Termine | Definizione |
|---------|-------------|
| Channel | Canale di notifica (email, sms, etc) |
| Template | Modello di notifica riutilizzabile |
| Preference | Impostazione utente per notifiche |
| DLQ | Dead Letter Queue per retry falliti |
