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
- [UpdateGgPresenzaDalalAction](./action-update-gg-presenza-dalal.md)
- [UpdateGgAnnoAction](./action-update-gg-anno.md)
- [UpdatepercParttimepondDalal](./action-update-perc-parttimepond-dalal.md)

## Backlinks

- [Valutazioni](./valutazioni/)
- [Report](./report/)
- [Performance fondo record pages](./performance-fondo-record-pages.md)
- [UpdateGgPresenzaDalalAction](./action-update-gg-presenza-dalal.md)
- [UpdateGgAnnoAction](./action-update-gg-anno.md)
- [UpdatepercParttimepondDalal](./action-update-perc-parttimepond-dalal.md)
- [Model Fillable Checklist](./model-fillable-checklist.md)
- [Discrepanza Calcolo Quota](./discrepanza-calcolo-quota.md)
- [Filament Infolist Pattern](./filament-infolist-pattern.md)
