# Modulo Notify

## Overview

Il modulo **Notify** gestisce il sistema di notifiche dell'applicazione.

## Scopo (business)

- **Comunicazioni**: invio email/notifiche (e, dove previsto, altri canali)
- **Template**: gestione template e versioning (quando abilitato)
- **Asincrono**: integrazione con queue per invii massivi o costosi

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
