# Pattern di Migrazione in healthcare_app

## Pattern XotBaseMigration

In questo progetto, le migrazioni seguono un pattern evolutivo basato su `XotBaseMigration`, non il pattern standard di Laravel. È **FONDAMENTALE** comprendere questa differenza per evitare errori nella gestione del database.

### Caratteristiche Principali

1. **Un solo file di migrazione per tabella**: Tutta la struttura e l'evoluzione di una tabella sono contenute in un unico file di migrazione.

2. **Due sezioni fondamentali**:
   - `tableCreate`: Definisce la struttura iniziale della tabella
   - `tableUpdate`: Contiene tutte le modifiche evolutive alla tabella

3. **Verifica delle colonne**: Prima di ogni modifica, si verifica se la colonna esiste:
   ```php
   if(!$this->hasColumn('column_name')) {
       $table->string('column_name')->nullable();
   }
   ```

### Approccio Corretto

✅ **SEMPRE** modificare il file originale di migrazione quando si aggiungono nuove colonne:
1. Modificare la **stessa** migrazione `create_{table}_table.php`
2. **Aggiornare il timestamp** nel nome del file (es. da `2018_10_10_000001` a `2026_02_22_000000`)

```php
// File: 2026_02_22_000000_create_example_table.php

$this->tableCreate(function (Blueprint $table) {
    // ... campi esistenti + nuovi
    $table->string('new_column')->nullable();
});

$this->tableUpdate(function (Blueprint $table) {
    if(!$this->hasColumn('new_column')) {
        $table->string('new_column')->nullable();
    }
});
```

### Approccio Errato

❌ **MAI** creare un nuovo file di migrazione per aggiungere campi:
```php
// ERRORE: Non creare 2023_01_01_000001_add_column_to_table.php
// ERRORE: Non creare migrazioni separate per modifiche schema
```

## Metodo convertIdFromUuidToBigintIfNeeded

Per tabelle legacy con id UUID, usare `XotBaseMigration::convertIdFromUuidToBigintIfNeeded()` (documentato in `Modules/Xot/docs/database/convert-id-uuid-to-bigint.md`).

## Main-module dependency

Modelli strettamente dipendenti dal main_module (es. Profile): migrazione nel modulo main (TechPlanner), NON in User.

## Motivazione

Questo pattern offre diversi vantaggi:
1. Riduce la frammentazione dello schema del database
2. Mantiene la cronologia completa di una tabella in un unico file
3. Semplifica i rollback e le migrazioni
4. Evita conflitti tra migrazioni

## Procedura di Verifica

Prima di proporre modifiche allo schema:

1. Verificare se la tabella ha già un file di migrazione
2. Esaminare come sono implementate altre modifiche nelle migrazioni esistenti
3. Modificare il file di migrazione originale, non crearne uno nuovo
4. Aggiungere il campo sia in `tableCreate` che in `tableUpdate` con verifica di esistenza
