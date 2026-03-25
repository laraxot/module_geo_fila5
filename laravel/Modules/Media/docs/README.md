# Modulo Media

## Overview

Il modulo **Media** fa parte dell'ecosistema Laraxot PTVX.

## Scopo

Gestisce le funzionalità specifiche del dominio Media.

## Cosa copre (business)

- **Upload & gestione file**: associazione media a record di dominio (es. avatar, documenti, allegati).
- **Integrazione UI**: componenti/risorse Filament per caricare e gestire media.
- **Policy**: regole condivise su naming, storage e sicurezza (validazioni, mime types).

## Struttura

```
Media/
├── app/
│   ├── Models/
│   ├── Filament/
│   └── ...
├── docs/
├── lang/
└── resources/
```

## Dipendenze

- [Xot Base](../Xot/docs/)
- [User Module](../User/docs/)

## Collegamenti

- [Documentazione Root](../../../docs/MEDIA_MODULE.md)

## Backlinks

- [Moduli correlati](../README.md)
