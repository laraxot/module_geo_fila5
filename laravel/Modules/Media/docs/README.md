---
title: documentazione modulo media
module: Media
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Media

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Media management module for the Laraxot ecosystem: images, videos, FFmpeg, and Intervention Image.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)
- [Disciplina agenti](./agent-edit-discipline.md)


## Struttura tipica

```text
Media/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Media`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/)
- [Wiki progetto](../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.

## ✅ PHPStan Status

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/Media --level=max --memory-limit=512M
# [OK] No errors
```

## Fix Applicati (2026-07-01)

- Nessun fix necessario: il modulo era già conforme alle regole Laraxot
- Tutte le classi Filament estendono le classi XotBase corrispondenti
- Nessun label/placeholder hardcoded
- Nessun BadgeColumn
- Actions usano QueueableAction pattern

## Architettura Classi Principali

```
Media/
├── app/
│   ├── Actions/
│   │   ├── AttachMediaAction.php
│   │   ├── SaveAttachmentsAction.php
│   │   ├── GetAttachmentsSchemaAction.php
│   │   ├── S3/ (CloudFront, Upload, Delete, Check)
│   │   ├── Image/ (Merge, SvgExists)
│   │   └── Video/ (Convert, ConvertByData, GetDuration)
│   ├── Models/
│   │   ├── Media.php
│   │   ├── MediaConvert.php
│   │   └── TemporaryUpload.php
│   └── Filament/
│       └── Resources/ (MediaResource, TemporaryUploadResource)
└── docs/README.md (questo file)
```
