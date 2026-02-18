---
name: larastan-workflow
description: Gestisce workflow Larastan/PHPStan per Laravel: installazione, configurazione, esecuzione e risoluzione errori. Usare quando l’utente menziona errori larastan/phpstan, analisi statica o quality gates.
---

# Larastan Workflow

## Scopo
Checklist operativa per installare, configurare, eseguire e risolvere errori Larastan/PHPStan in progetti Laravel.

## Checklist rapida
- [ ] Individua la root Laravel e la root repo
- [ ] Verifica che Larastan sia presente (composer.json + vendor)
- [ ] Verifica config PHPStan (phpstan.neon o phpstan.neon.dist)
- [ ] Esegui analisi mirata sul modulo/file coinvolto
- [ ] Correggi errori rispettando le regole del progetto
- [ ] Riesegui l’analisi con lo stesso scope

## Workflow

### 1) Individua contesto
- Root repo: percorso workspace
- Root Laravel: in genere `laravel/`
- Modulo o file con errore: restringi lo scope

### 2) Verifica installazione
- Dipendenza dev: `larastan/larastan`
- File config: `phpstan.neon` o `phpstan.neon.dist`
- Include obbligatorio: `vendor/larastan/larastan/extension.neon`

### 3) Esecuzione analisi
Usa il comando minimo necessario, partendo da file/modulo:
- File singolo: `./vendor/bin/phpstan analyse path/to/file.php --level=10`
- Modulo: `./vendor/bin/phpstan analyse Modules/Modulo --level=10`
- Memoria: aggiungi `--memory-limit=2G` se necessario

### 4) Correzione errori (pattern)
- Tipi espliciti: parametri e return type
- PHPDoc con shape per array complessi
- Evita `mixed` non necessario
- Preferisci metodi/relazioni Eloquent tipizzati
- Se la regola del progetto vieta pattern, adegua il codice

### 5) Verifica finale
- Riesegui lo stesso comando di analisi
- Non cambiare configurazioni per “silenziare” errori

## Anti-pattern
- Ignorare errori con `@phpstan-ignore*` senza motivo
- Allargare il livello o ridurre le regole per “far passare”
- Analisi full-scan quando basta un file/modulo

## Risorse aggiuntive
- Esempi pratici: `examples.md`
- Note di riferimento: `reference.md`
