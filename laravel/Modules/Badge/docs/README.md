# Badge Module

## 📖 Scopo

Il modulo Badge gestisce il sistema di badge e riconoscimenti per gli utenti del sistema.

## 🎯 Funzionalità Principali

- Creazione e gestione badge
- Assegnazione badge agli utenti
- Visualizzazione badge utente
- Sistema di achievement/gamification

## 🚀 Quick Start

### Modelli Principali

- `Badge` - Definizione badge disponibili
- `UserBadge` - Relazione badge-utente (pivot)

### Usage Example

```php
use Modules\Badge\Models\Badge;

// Assegna badge a utente
$user->badges()->attach($badge->id, [
    'awarded_at' => now(),
    'reason' => 'Achievement completed'
]);

// Ottieni badge utente
$badges = $user->badges;
```

## 📂 Struttura

```
Modules/Badge/
├── app/
│   ├── Models/              # Badge, UserBadge
│   ├── Filament/Resources/  # Badge management
│   └── Actions/             # Award logic
├── database/migrations/     # Migrazioni
├── lang/                    # Traduzioni
└── docs/                    # Questa documentazione
```

## 🔗 Moduli Correlati

- [User](../User/docs/README.md) - Integrazione utenti
- [Xot](../Xot/docs/README.md) - Framework core

---

**Ultimo aggiornamento**: Gennaio 2025  
**Status**: Active

