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

## WorkerColumn - Cosa è Realmente

**WorkerColumn è una GroupColumn, NON una relazione!**

WorkerColumn estende `GroupColumn` da `Modules\UI\Filament\Tables\Columns\GroupColumn`. Questo significa che:
- Raggruppa campi dello **stesso record** (matr, cognome, nome, email)
- Non è una relazione a un altro modello
- È puramente un pattern UI/UX per DRY e KISS

### Ereditarietà
```
WorkerColumn → GroupColumn → Column
```

### Funzionamento
```php
// WorkerColumn mostra campi dello STESSO record:
// - matr (dal record corrente)
// - cognome (dal record corrente)  
// - nome (dal record corrente)
// - email (dal record corrente)
```

### Vantaggi DRY + KISS
- **DRY**: Definisco una volta come mostrare i dati del lavoratore, riutilizzo ovunque
- **KISS**: Una colonna invece di 3-4, codice più pulito e leggibile
- **Coerenza**: Stesso layout visivo in tutte le tabelle
- **Manutenibilità**: Modifico il formato in un solo punto

### Anti-pattern da Evitare
```php
// ❌ SBAGLIATO - Violazione DRY/KISS
TextColumn::make('matr'),
TextColumn::make('cognome'),
TextColumn::make('nome'),

// ✅ CORRETTO - DRY + KISS
WorkerColumn::make('lavoratore'), // Raggruppa matr+cognome+nome+email
```

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
