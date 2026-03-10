# Modulo Sigma

## Overview

Il modulo **Sigma** gestisce l'integrazione con il sistema esterno Sigma.

## Funzionalità

- API integration
- Data synchronization
- Webhook handling
- Import/Export dati

## Configurazione

```php
// Configurazione Sigma
'sigma' => [
    'api_url' => env('SIGMA_API_URL'),
    'api_key' => env('SIGMA_API_KEY'),
    'timeout' => 30,
]
```

## Services

```php
// Sigma API client
Sigma\Services\SigmaClient

// Data sync
Sigma\Services\DataSynchronizer
```

## Collegamenti

- [Documentazione Root](../../../docs/SIGMA_MODULE.md)
- [Xot Base](../Xot/docs/)
- [Notify Module](../Notify/docs/)

## Backlinks

- [API Integration](./api/)
- [Sync Config](./sync/)
