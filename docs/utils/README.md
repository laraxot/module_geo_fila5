---
title: "Script di Utilità"
type: documentation
tags: [geo, documentation, utils]
created: 2026-07-20
updated: 2026-07-20
qmd: "geo module documentation utils README frontmatter naming wiki"
issues:
  - "https://github.com/laraxot/base_quaeris_fila5/issues/125"
discussions:
  - "https://github.com/laraxot/base_quaeris_fila5/discussions/126"
related:
  - ../README.md
  - ../wiki/README.md
  - ../docs/README.md
  - ../index.md
  - ../wiki/index.md
---

# Script di Utilità

## Descrizione
Questa cartella contiene script di utilità per lo sviluppo, inclusi:
- Script di supporto
- Funzioni comuni
- Helper per lo sviluppo

## Script Disponibili

### 1. check_system.sh
Verifica i requisiti di sistema con:
- Controllo versione PHP
- Controllo estensioni
- Verifica permessi

### 2. generate_docs.sh
Genera la documentazione con:
- Generazione API docs
- Aggiornamento README
- Creazione changelog

### 3. development_helper.sh
Assiste nello sviluppo con:
- Creazione moduli
- Generazione codice
- Verifica stile

## Utilizzo

```bash

# Verifica sistema
./check_system.sh

# Genera documentazione
./generate_docs.sh

# Helper sviluppo
./development_helper.sh --create-module
```

## Best Practices
- Mantenere gli script aggiornati
- Documentare le funzionalità
- Verificare la compatibilità 
