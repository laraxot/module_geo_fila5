# Regola: WorkerColumn - Colonne Custom Filament

## ⚠️ REGOLA CRITICA

**MAI sostituire colonne custom/generic (come WorkerColumn) con colonne individuali di base (TextColumn, ecc.).**

## Contesto

Nel progetto Laraxot/PTVX utilizziamo colonne custom per raggruppare logicamente i dati. La `WorkerColumn` è un esempio fondamentale che raggruppa le informazioni del lavoratore (matricola, cognome, nome, email) in una singola colonna riutilizzabile.

## ❌ ANTI-PATTERN (Vietato)

```php
// NON FARE MAI QUESTO
public function getTableColumns(): array
{
    return [
        TextColumn::make('matr')->searchable(),      // ❌
        TextColumn::make('cognome')->searchable(),   // ❌
        TextColumn::make('nome')->searchable(),      // ❌
        TextColumn::make('email')->searchable(),     // ❌
        // ...
    ];
}
```

## ✅ PATTERN CORRETTO

```php
use Modules\Ptv\Filament\Columns\WorkerColumn;

public function getTableColumns(): array
{
    return [
        'lavoratore' => WorkerColumn::make('lavoratore'),  // ✅
        TextColumn::make('stabi')->searchable(),
        TextColumn::make('repar')->searchable(),
        // ...
    ];
}
```

## Perché è Importante

### 1. DRY (Don't Repeat Yourself)
La logica di visualizzazione è centralizzata nella colonna custom. Se cambia il formato, si modifica in un solo punto.

### 2. Coerenza UI/UX
Tutte le tabelle mostrano le informazioni del lavoratore nello stesso modo, con lo stesso stile e layout.

### 3. Manutenibilità
- Una modifica al formato del lavoratore richiede un cambiamento in un solo file
- Non è necessario cercare e sostituire in tutte le risorse
- Il codice è più pulito e leggibile

### 4. Performance
- Una colonna invece di 3-4 riduce il carico di rendering
- Meno query al database se la colonna ottimizza le relazioni
- Migliore gestione del caching

### 5. Type Safety
La colonna custom può definire tipi precisi e validazioni specifiche per il dominio.

## Altre Colonne Custom nel Progetto

- `WorkerColumn` - Informazioni lavoratore (matr, cognome, nome, email)
- `ValutatoreColumn` - Informazioni valutatore
- `PeriodoColumn` - Periodo dal/al con formattazione
- `ImportoColumn` - Importi con formattazione valuta

## Implementazione

### File di Riferimento
- **WorkerColumn**: `Modules/Ptv/app/Filament/Columns/WorkerColumn.php`
- **Namespace**: `Modules\Ptv\Filament\Columns\WorkerColumn`

### Ereditarietà
Le colonne custom estendono `GroupColumn` da `Modules\UI\Filament\Tables\Columns\GroupColumn`.

## Checklist per Code Review

- [ ] Se la risorsa ha un "lavoratore", usa `WorkerColumn`
- [ ] Non sostituire mai colonne custom con colonne base individuali
- [ ] Verificare che l'import sia corretto: `use Modules\Ptv\Filament\Columns\WorkerColumn;`
- [ ] La chiave dell'array deve essere stringa: `'lavoratore' => WorkerColumn::make('lavoratore')`

## Correlazioni

- [Filament Best Practices](./FILAMENT-BEST-PRACTICES.md)
- [UI Components](./UI-COMPONENTS.md)
- [Module: IndennitaCondizioniLavoro WorkerColumn Rule](../laravel/Modules/IndennitaCondizioniLavoro/docs/workercolumn-rule.md)

---
**Ultimo aggiornamento**: 2025-02-17  
**Priorità**: Alta  
**Violazione**: Critica
