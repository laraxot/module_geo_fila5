---
title: "Notify Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-06-05
---

# Modulo Notify

## Overview

Il modulo **Notify** gestisce il sistema di notifiche dell'applicazione.

## Funzionalità

- Mail notifications
- Database notifications
- Template management
- Queue integration

## Modelli Principali

```php
// Mail Template
Notify\Models\MailTemplate

// Mail Template Version
Notify\Models\MailTemplateVersion

// Notification
Notify\Models\Notification
```

## Trait

```php
use Modules\Notify\Models\Traits\HasNotify;
```

## Collegamenti

- [Documentazione Root](../../../docs/NOTIFY_MODULE.md)
- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)

## Backlinks

- [Filament Resources](./filament/)
- [PHPStan Config](./phpstan/)

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout

## ✅ PHPStan Status

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/Notify --level=max --memory-limit=512M
# [OK] No errors
```

## Fix Applicati (2026-07-01)

- Nessun fix necessario: il modulo era già conforme alle regole Laraxot
- Actions correttamente implementate con pattern Spatie QueueableAction
- Nessun label hardcoded nei campi Filament

## Architettura Classi Principali

```
Notify/
├── app/
│   ├── Actions/
│   │   ├── BuildMailMessageAction.php
│   │   ├── SendNotificationAction.php
│   │   ├── SendNotificationToRecipientAction.php
│   │   ├── SendRecordNotificationAction.php
│   │   ├── SendRecordsNotificationAction.php
│   │   ├── EsendexSendAction.php
│   │   ├── NetfunSendAction.php
│   │   ├── NormalizePhoneNumberAction.php
│   │   ├── Mail/GetMailLayoutAction.php
│   │   └── SMS/ (FormatSmsMessage, NormalizePhone)
│   ├── Models/
│   │   ├── MailTemplate.php
│   │   ├── MailTemplateVersion.php
│   │   └── Notification.php
│   └── Filament/Resources/
└── docs/README.md (questo file)
```