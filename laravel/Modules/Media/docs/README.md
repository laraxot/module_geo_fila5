<<<<<<< .merge_file_AlOWhV
# 🎞️ **Media Module** - High-Performance Asset Management

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHPStan level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![Visual Engine](https://img.shields.io/badge/Engine-FFmpeg%20%7C%20Imagick%20%7C%20LibVips-blueviolet.svg)](https://ffmpeg.org/)

> **🚀 Modulo Media**: Il centro di comando per le risorse digitali di Laraxot. Non è un semplice uploader: è una pipeline di trasformazione che gestisce compressione, transcoding video, ottimizzazione immagini e storage distribuito (S3/Cloud).

## 📋 **Panoramica**

Il modulo **Media** automatizza il ciclo di vita di ogni byte multimediale caricato.

- 🖼️ **Smart Transformations**: Generazione automatica di preview, thumbnail e formati next-gen (WebP/AVIF).
- 🎥 **Video Transcoding**: Engine FFmpeg integrato per convertire video in formati streaming-efficient (H.264/VP9).
- ☁️ **Cloud Native**: Supporto multi-disk trasparente (Local, S3, Azure) gestito dall'astrazione CloudStorage.
- 🛡️ **Safe Uploads**: Validazione rigorosa di MIME types, dimensioni e scan anti-malware integrato.
- 🎨 **Visual Library**: Interfaccia Filament per gestire migliaia di file con drag-and-drop e visualizzazione a griglia.

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

### ⚙️ **Recupero URL Ottimizzata**
```php
echo $model->getFirstMediaUrl('gallery', 'webp-compressed');
```

## 📚 **Documentazione Centrale**

- 📖 **[Indice Documentazione](./00-index.md)** - Mappa navigazione completa.
- 🙏 **[Filosofia Media](./philosophy.md)** - La gestione degli asset digitali.
- 🎥 **[FFmpeg Guide](./ffmpeg-integration.md)** - Come scaliamo il processing video.
- ☁️ **[Storage Strategy](./file-management.md)** - Dove e come salviamo i dati.

---

**🔄 Ultimo aggiornamento**: 31 Gennaio 2026
**📦 Versione**: 3.2.0
**✅ PHPStan level 10**: Compliance nativa garantita

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT
=======
# Module Documentation

This directory contains the documentation for the Media module.

## Purpose

The purpose of this documentation is to provide comprehensive information about the Media's functionality, architecture, and usage. It aims to:
- Explain key features and their implementation details.
- Guide developers on how to use, extend, and maintain the module.
- Ensure consistency with Laraxot architectural principles and coding standards.

## Structure

- `README.md`: This overview file.
- Other Markdown files will detail specific aspects of the module, such as:
    - `installation.md`
    - `usage.md`
    - `architecture.md`
    - `troubleshooting.md`

## Contribution

Developers are encouraged to contribute to this documentation to keep it accurate and up-to-date.
>>>>>>> .merge_file_1CMdxT
