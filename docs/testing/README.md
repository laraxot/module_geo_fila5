---
title: "Script di Testing"
type: documentation
tags: [geo, documentation, testing]
created: 2026-07-20
updated: 2026-07-20
qmd: "geo module documentation testing README frontmatter naming wiki"
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

# Script di Testing

## Descrizione
Questa cartella contiene gli script per i test del sistema, inclusi:
- Esecuzione dei test
- Analisi del codice
- Verifica della qualità

## Script Disponibili

### 1. run_tests.sh
Esegue i test con:
- Test unitari
- Test di integrazione
- Test di funzionalità

### 2. analyze_code.sh
Analizza il codice con:
- PHPStan
- PHPCS
- PHPMD

### 3. check_quality.sh
Verifica la qualità con:
- Controllo coverage
- Analisi complessità
- Verifica standard

## Utilizzo

```bash

# Esegui tutti i test
./run_tests.sh

# Analisi codice
./analyze_code.sh --level=9

# Verifica qualità
./check_quality.sh --coverage
```

## Best Practices
- Eseguire test regolarmente
- Mantenere coverage alto
- Seguire gli standard di codice 
