---
title: "project backup"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "project backup"
issues: []
discussions: []
status: draft
---

## Modifiche Recenti

### Uso di Spatie Queable Actions

Nel progetto Geo, abbiamo sostituito l'uso dei servizi con Spatie Queable Actions per una gestione più efficiente delle azioni asincrone. Questo approccio ci consente di eseguire azioni in coda, migliorando la scalabilità e la manutenibilità del codice.

#### Esempio di Implementazione

Abbiamo creato l'azione `GetCoordinatesAction` per gestire il recupero delle coordinate geografiche utilizzando l'API di Google Maps. Questa azione sostituisce il precedente servizio `GoogleMapsService`.

```php
use Modules\Geo\Actions\GetCoordinatesAction;

$action = new GetCoordinatesAction();
$coordinates = $action->execute('1600 Amphitheatre Parkway, Mountain View, CA');
```

<<<<<<< HEAD
Questa modifica è stata applicata anche in `UpdateCoordinatesAction`, dove ora utilizziamo `GetCoordinatesAction` per aggiornare le coordinate di un luogo. 
--- BMAD + Second Brain ---
- Scopo: documentazione tecnica del modulo.
- Utilità: riferimento sviluppatori/audit.
- Funzionalità: struttura, dipendenze, convenzioni (no date .md, git avanti).
=======
Questa modifica è stata applicata anche in `UpdateCoordinatesAction`, dove ora utilizziamo `GetCoordinatesAction` per aggiornare le coordinate di un luogo. 
>>>>>>> laraxot/dev
