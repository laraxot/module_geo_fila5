# Regola CRITICA: Validazione Obbligatoria Post-Modifica

## Regola Fondamentale

**Dopo OGNI modifica a un file PHP, DEVI SEMPRE eseguire la validazione con:**

1. **PHPStan livello 10** - Analisi statica rigorosa
2. **PHPMD** - PHP Mess Detector per code quality  
3. **PHPInsights** - Analisi completa qualità codice

## Workflow Obbligatorio

```bash
# Dopo ogni modifica di file PHP
cd /var/www/_bases/base_ptvx_fila5_mono/laravel

# 1. PHPStan livello 10
./vendor/bin/phpstan analyze [file-path] --level=10 --memory-limit=2G

# 2. PHPMD
./vendor/bin/phpmd [file-path] text cleancode,codesize,controversial,design,naming,unusedcode

# 3. PHPInsights
php artisan insights [file-path] --min-quality=90 --min-complexity=90 --min-architecture=90 --min-style=90
```

## Quando Applicare

- ✅ SEMPRE dopo `edit` o `multi_edit` di file PHP
- ✅ SEMPRE dopo refactoring
- ✅ SEMPRE prima di considerare completato un task
- ✅ SEMPRE prima di passare al file successivo

## Cosa Fare se Fallisce

1. Correggere TUTTI gli errori trovati
2. Ri-eseguire la validazione
3. Ripetere fino a passare tutti i controlli
4. Solo DOPO procedere con il file successivo

## Eccezioni

**NESSUNA**. Questa regola vale SEMPRE per OGNI file PHP modificato.

## Script di Validazione Automatica

È disponibile lo script `validate-modified-files.php` per validare tutti i file modificati in batch:

```bash
cd /var/www/_bases/base_ptvx_fila5_mono/laravel
php validate-modified-files.php
```

## Scopo

- Garantire qualità del codice
- Prevenire regressioni
- Mantenere standard PHPStan livello 10
- Assicurare best practices
- Evitare introduzione di nuovi errori

## Note Importanti

- Gli errori PHPStan potrebbero essere **pre-esistenti**
- Verificare che le PROPRIE modifiche non abbiano introdotto NUOVI errori
- Confrontare gli errori prima e dopo la modifica
- Documentare eventuali errori pre-esistenti che non possono essere corretti immediatamente

*Ultimo aggiornamento: 29 Ottobre 2025*
