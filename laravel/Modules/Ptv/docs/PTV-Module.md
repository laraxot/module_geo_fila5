# PTV Module Documentation

## Overview

The PTV (Performance Valutation) module handles employee performance evaluation, including scheduling, evaluation forms, and reporting.

## Core Features

### Evaluation Management
- **Schede (Evaluation Forms)**: Performance evaluation forms
- **Valutatori (Evaluators)**: Manager/staff who conduct evaluations  
- **Criteri di Esclusione**: Exclusion criteria for evaluations
- **Report Generation**: PDF reports and analytics

### Data Models

#### Primary Models
- **Scheda**: Main evaluation form
- **Valutatore**: Evaluator/staff information
- **StabiDirigente**: Stable management positions
- **Repart**: Department/organizational structure

#### Supporting Models
- **Profile**: Employee profiles
- **Cateco**: Job categories
- **Worker**: Worker information

## Filament Components

### Custom Columns

#### ValutatoreColumn
**Location:** `app/Filament/Tables/Columns/ValutatoreColumn.php`
```php
// Usage in table schema
ValutatoreColumn::make('evaluator')
    ->label('Valutatore')
```

Displays evaluator information with:
- `valutatore.nome_diri` (Evaluator name)
- `valutatore.nome_diri_plus` (Full name)

#### WorkerColumn  
**Location:** `app/Filament/Tables/Columns/WorkerColumn.php`
```php
WorkerColumn::make('worker')
    ->label('Lavoratore')
```

Displays worker information:
- `matr` (Employee ID)
- `cognome` (Surname)
- `nome` (Name)  
- `email`

#### Other Custom Columns
- **PeriodoColumn**: Time period information
- **QuaColumn**: Qualification/category
- **RepartoColumn**: Department information
- **RepColumn**: Repart/department code

### Form Components

#### SelectValutatore
**Location:** `app/Filament/Forms/Components/SelectValutatore.php`
Custom select component for choosing evaluators with dynamic options based on context.

## Actions & Business Logic

### Evaluation Actions
- **PrepareEvaluationDataAction**: Prepares data for evaluation forms
- **MakePdfByRecordAction**: Generates PDF reports
- **GetValutatoriOptions**: Retrieves evaluator options

### Data Processing Actions
- **MergeDoubleRowCatecoByModelClassYearAction**: Merges duplicate category records
- **FixValutatoreIdByAnno**: Fixes evaluator IDs by year
- **Populate**: Populates evaluation data

### Cessati (Terminated) Actions
- **GetCessatiRecords**: Retrieves terminated employee records
- **GetCessatiRecordsCount**: Counts terminated employees
- **GetCessatiRecordsPreview**: Previews terminated records

### Exclusion Criteria Actions
- **MinGgPosiz1InSede**: Minimum days in position at site
- **MinGgAnno**: Minimum days per year
- **MaxGgAssenzaAnno**: Maximum absence days per year
- **PresentiIlGiorno**: Present on specific date

## Database Relationships

### Key Relationships
```php
// Scheda relationships
public function valutatore(): BelongsTo
public function lavoratore(): BelongsTo  
public function repart(): BelongsTo
public function profile(): BelongsTo

// Valutatore relationships  
public function repart(): HasOne
public function schede(): HasMany
```

## Performance Features

### Search Optimization
- Custom searchable columns for all major fields
- Relationship-based search support
- Optimized queries with proper eager loading

### Memory Management
- Efficient data loading strategies
- Pagination for large datasets
- Cached evaluator options

## Testing

### Test Coverage
- Model relationships
- Business logic actions
- Filament components
- PDF generation
- Search functionality

### Factory Classes
- **SchedaFactory**: Creates evaluation forms
- **ValutatoreFactory**: Creates evaluators
- **ProfileFactory**: Creates employee profiles

## Integration Points

### External Systems
- **Generale Database**: Employee data (`ana10f` table)
- **Sigma Module**: Department and organizational data
- **UI Module**: Shared components and theming

### Module Dependencies
- **Xot**: Base functionality and utilities
- **UI**: Filament components and themes
- **Sigma**: Organizational structure data

## Configuration

### Evaluation Periods
- Annual evaluation cycles
- Quadrimester (4-month) periods
- Year-based configuration

### Evaluator Assignment
- Automatic evaluator assignment based on organizational structure
- Manual override capabilities
- Historical tracking of changes

## File Structure

```
Modules/Ptv/
├── app/
│   ├── Actions/           # Business logic actions
│   │   ├── Cessati/       # Terminated employee actions
│   │   ├── CriteriEsclusione/  # Exclusion criteria
│   │   ├── Pdf/           # PDF generation
│   │   └── Scheda/        # Evaluation form actions
│   ├── Filament/
│   │   ├── Columns/       # Custom table columns
│   │   ├── Forms/         # Custom form components
│   │   └── Resources/     # Filament resources
│   ├── Http/
│   │   └── Livewire/      # Livewire components
│   └── Models/            # Eloquent models
├── database/
│   ├── factories/         # Test data factories
│   └── migrations/        # Database migrations
├── resources/
│   └── lang/it/           # Italian translations
└── tests/                 # Test suites
```

## Best Practices

### Performance
- Always preload relationships when using custom columns
- Use cached options for dropdown selects
- Implement proper pagination for large datasets

### Data Integrity  
- Validate evaluator assignments
- Check exclusion criteria before evaluations
- Maintain audit trails for changes

### User Experience
- Provide clear labels and translations
- Implement progressive disclosure for complex forms
- Use consistent column patterns across tables