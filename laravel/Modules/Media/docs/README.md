# Modulo Media

## Overview

Il modulo **Media** fa parte dell'ecosistema [PROJECT_NAME] platform.

## Scopo

Gestisce le funzionalità specifiche del dominio Media.

## Cosa copre (business)
||||||| parent of 53258b2 (.)
- 🖼️ **Smart Transformations**: Generazione automatica di preview, thumbnail e formati next-gen (WebP/AVIF).
- 🎥 **Video Transcoding**: Engine FFmpeg integrato per convertire video in formati streaming-efficient (H.264/VP9).
- ☁️ **Cloud Native**: Supporto multi-disk trasparente (Local, S3, Azure) gestito dall'astrazione CloudStorage.
- 🛡️ **Safe Uploads**: Validazione rigorosa di MIME types, dimensioni e scan anti-malware integrato.
- 🎨 **Visual Library**: Interfaccia Filament per gestire migliaia di file con drag-and-drop e visualizzazione a griglia.

- **Upload & gestione file**: associazione media a record di dominio (es. avatar, documenti, allegati).
- **Integrazione UI**: componenti/risorse Filament per caricare e gestire media.
- **Policy**: regole condivise su naming, storage e sicurezza (validazioni, mime types).

## Struttura

||||||| parent of 53258b2 (.)
## ⚡ **Funzionalità Core**

### 🧩 **Lazy Conversions**
Le conversioni non bloccano la UI. Vengono processate in background tramite il modulo **Job**, garantendo un'esperienza utente fluida.

### 🧘 **Philosophical Design**
"Il file originale è sacro". Ogni trasformazione è una derivata che non altera mai la sorgente originale.

## 🚀 **Quick Start**

### 📦 **Associazione Media**
```php
$model->addMedia($file)->toMediaCollection('gallery');
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

## AI Workflows
- [AI Methodologies](./ai-methodologies.md)
||||||| parent of 53258b2 (.)
## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]
