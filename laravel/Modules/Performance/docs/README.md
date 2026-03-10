# Modulo Performance

## Overview

Il modulo **Performance** gestisce la valutazione delle performance del personale.

## Funzionalità

- Valutazioni individuali
- Valutazioni di gruppo
- Reportistica performance
- Workflow approvazione

## Modelli Principali

```php
// Valutazione individuale
Performance\Models\PerformanceIndividuale

// Valutazione gruppo
Performance\Models\PerformanceGruppo

// Totale valutatore
Performance\Models\OrganizzativaTotValutatoreId
```

## Filament Resources

- PerformanceIndividualeResource
- PerformanceGruppoResource
- OrganizzativaResource

## Collegamenti

- [Documentazione Root](../../../docs/PERFORMANCE_MODULE.md)
- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)

## Backlinks

- [Valutazioni](./valutazioni/)
- [Report](./report/)
