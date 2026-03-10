# Esecuzione di PHPStan nel Progetto PTVX

## Comandi di Esecuzione

PHPStan deve essere **sempre** eseguito dalla directory principale di Laravel utilizzando il comando:

```bash
cd laravel
./vendor/bin/phpstan analyse -l 9 [percorso/al/modulo]
```

## Livelli di Analisi

Il progetto PTVX richiede il livello 9 di PHPStan (massimo rigore). I livelli sono progressivi:

- Livello 0: controlli di base
- Livello 9: tutti i controlli possibili

## Opzioni Utili per l'Esecuzione

### Memoria

Per analisi di moduli complessi o multipli, aumentare la memoria:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse -l 9 Modules/Rating
```

### Formato dell'Output

Per un output più leggibile:

```bash
./vendor/bin/phpstan analyse -l 9 --error-format=table Modules/Rating
```

### Debug

Per informazioni di debug dettagliate:

```bash
./vendor/bin/phpstan analyse -l 9 --debug Modules/Rating
```

## Analisi di Moduli Multipli

```bash
./vendor/bin/phpstan analyse -l 9 Modules/Rating Modules/User Modules/Notify
```

## Analisi di Tutti i Moduli

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse -l 9 Modules/*
```

## Automazione

Per l'integrazione nei sistemi CI/CD, utilizzare:

```bash
./vendor/bin/phpstan analyse -l 9 --no-progress --error-format=github Modules/*
```

## Gestione degli Errori

### Errori di Memoria

Se si verificano errori di memoria:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse -l 9 Modules/Rating
```

### Nessun File Trovato

Se PHPStan riporta "No files found to analyse":

1. Verificare di essere nella directory Laravel
2. Controllare il percorso al modulo
3. Verificare che il modulo contenga file PHP
4. Controllare la configurazione di PHP e PHPStan

### Problemi di Namespace

Se ci sono errori di classe non trovata o namespace non trovato:

1. Correggere i namespace (sempre `Modules\NomeModulo\...` senza segmento `app`)
2. Verificare le importazioni
3. Controllare la configurazione autoload in composer.json

## Configurazione Personalizzata

Il file `phpstan.neon` nella directory Laravel contiene configurazioni specifiche del progetto che possono essere estese secondo necessità.

## Raccomandazioni per i Sviluppatori

1. Eseguire PHPStan **localmente** prima di ogni commit
2. Correggere immediatamente gli errori rilevati
3. Documentare le soluzioni trovate per problemi complessi
4. Aggiornare questo documento con nuove informazioni utili
