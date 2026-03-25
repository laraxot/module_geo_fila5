# PTVX AI Guidelines - Super Mucca & Laraxot Zen

> **Version 4.0** - Super Mucca Methodology Activation 🐄✨
> **Last Updated**: February 2026

## 🐄 Metodologia "Super Mucca" (Level 3 Confidence)
- **Autonomia Totale**: L'Agente decide autonomamente ordine, priorità e pattern.
- **Critical Reasoning**: "Litiga" con te stesso per trovare la soluzione migliore (Sintesi > Tesi).
- **Proattività**: Migliora costantemente regole, documentazione e prompt.
- **Deep Understanding**: Comprendi il "Perché" (Filosofia) prima del "Come" (Codice).

## 📚 Modular Documentation Structure

This documentation follows strict DRY (Don't Repeat Yourself) and KISS (Keep It Simple, Stupid) principles through complete modular reorganization.

## 🎯 Fundamentals
- [Overview](fundamentals/overview.md) - Project overview and technology stack
- [Architecture Rules](fundamentals/architecture-rules.md) - Critical rules ⚠️ (READ FIRST)
- [Module Structure](fundamentals/module-structure.md) - Module organization
- [Module List](fundamentals/module-list.md) - Complete module inventory

## 💻 Development
- [Development Tasks](development/tasks.md) - Common development operations
- [Code Conventions](development/conventions.md) - Coding standards
- [Common Pitfalls](development/pitfalls.md) - Mistakes to avoid ⚠️
- [SOLID Principles](development/solid.md) - Clean architecture
- [DRY + KISS Patterns](development/dry-kiss.md) - Best practices

## 🏗️ Framework & Tools
- [Framework Specifics](framework/specifics.md) - Filament, Livewire, Tailwind
- [Laravel Boost](framework/laravel-boost.md) - Laravel optimizations
- [Eloquent Properties](framework/eloquent-properties.md) - Model best practices ⚠️
- [Schemaless Attributes](framework/schemaless-attributes.md) - Spatie schemaless ⚠️
- [Agent Skills](.cursor/skills) - Cursor/Windsurf dynamic skills 🚀

## ✅ Quality Assurance
- [Code Quality](quality/code-quality.md) - PHPStan, PHPMD, PHP Insights
- [Testing](quality/testing.md) - Testing strategies and patterns
- [Documentation Policy](quality/documentation.md) - Documentation standards

## 🔧 Patterns & Architecture
- [Design Patterns](patterns/design-patterns.md) - Repository, Service, Action, DTO
- [Database Patterns](patterns/database.md) - Migrations, Models, Relationships
- [UI Patterns](patterns/ui.md) - Components, Forms, Tables

---

## 📋 Reorganization Summary

**Previous Structure**: 1 large file (2000+ lines)  
**New Structure**: 17 focused files (300-500 lines each)  
**DRY Compliance**: ✅ Eliminated all redundancy  
**KISS Compliance**: ✅ Single responsibility per file  
**Maintainability**: 🚀 Significantly improved  

See [Reorganization Summary](REORGANIZATION-SUMMARY.md) for complete details.

---

## ⚠️ **CRITICAL LARAXOT FILAMENT RULES** - NEVER BREAK THESE

### 🚨 **RULE #1: NEVER Extend Filament Classes Directly**

**IN LARAXOT È ASSOLUTAMENTE VIETATO ESTENDERE CLASSI FILAMENT DIRETTAMENTE**

**MAI estendere classi Filament direttamente - usare sempre classi XotBase con prefisso:**

```php
// ❌ WRONG - VIETATO
class MyPage extends Filament\Resources\Pages\CreateRecord
class MyPage extends Filament\Resources\Pages\EditRecord  
class MyPage extends Filament\Resources\Pages\ListRecords
class MyPage extends Filament\Resources\Pages\Page
class MyResource extends Filament\Resources\Resource

// ✅ CORRECT - OBBLIGATORIO
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBasePage
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
```

**Mapping obbligatorio:**

| Filament Class | XotBase Class |
|----------------|---------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBasePage` |

### 🚨 **RULE #2: XotBaseResource Restrictions**

**Le classi che estendono XotBaseResource NON devono avere getTableColumns()**

```php
class MyResource extends XotBaseResource
{
    // ✅ OK - Ha getFormSchema()
    public static function getFormSchema(): array { /* ... */ }
    
    // ❌ VIETATO ASSOLUTAMENTE - NON avere getTableColumns()
    // public function getTableColumns(): array { /* ... */ } // ERRORE GRAVE
}
```

### 🚨 **RULE #3: XotBasePage Restrictions**

**Le classi che estendono XotBasePage NON devono avere:**

```php
class MyPage extends XotBasePage
{
    // ❌ VIETATO - Queste proprietà sono gestite automaticamente
    // protected static ?string $navigationIcon = 'heroicon-o-star';
    // protected static ?string $title = 'My Title';  
    // protected static ?string $navigationLabel = 'My Label';
    
    // ✅ OK - Solo proprietà specifiche
    protected static string $resource = MyResource::class;
}
```

### 🚨 **RULE #7: METODI TAB - Dove Implementarli**

**I metodi getTableColumns(), getTableFilters(), getTableActions(), getTableBulkActions() DEVONO essere implementati SOLO nelle pagine List (es. ListImportiCategorias.php) e MAI nelle classi Resource (es. ImportiCategoriaResource.php). Questo vale per TUTTI i moduli.**

```php
// ❌ ERRATO - Nelle classi Resource
class MyResource extends XotBaseResource
{
    // ❌ VIETATO - Non mettere qui
    public function getTableColumns(): array { /* ... */ }
    public function getTableFilters(): array { /* ... */ }
    public function getTableActions(): array { /* ... */ }
    public function getTableBulkActions(): array { /* ... */ }
}

// ✅ CORRETTO - Nelle pagine List
class ListMyModels extends XotBaseListRecords
{
    // ✅ OBBLIGATORIO - Metodi qui
    public function getTableColumns(): array { /* ... */ }
    public function getTableFilters(): array { /* ... */ }
    public function getTableActions(): array { /* ... */ }
    public function getTableBulkActions(): array { /* ... */ }
}
```

### 🚨 **RULE #4: NO Services - Only Queueable Actions**

```php
// ❌ WRONG - VIETATO
class UserService
{
    public function create(array $data): User
    {
        // Business logic qui
    }
}

// ✅ CORRECT - OBBLIGATORIO
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;
    
    public function execute(UserData $data): User
    {
        // Business logic qui
    }
}

// Usage
$result = app(CreateUserAction::class)->execute($data);
```

### 🚨 **RULE #5: NO ->label(), ->placeholder(), ->tooltip()**

```php
// ❌ WRONG - VIETATO
TextInput::make('name')
    ->label('Nome')           // VIETATO
    ->placeholder('Inserisci nome') // VIETATO
    ->tooltip('Testo aiuto')  // VIETATO

// ✅ CORRECT - Traduzioni automatiche via LangServiceProvider
TextInput::make('name') // OK
```

### 🚨 **RULE #6: BadgeColumn Deprecated**

```php
// ❌ WRONG - DEPRECATED
TextColumn::make('status')->badge()
```

### 🚨 **RULE #8: Model Casting and Quality Verification**

**È obbligatorio usare il nuovo sistema di casting di Laravel e verificare ogni modifica con i tool di qualità.**

*   **NO `protected $casts`**: Usare `protected function casts(): array` con return type hint.
*   **NO `property_exists()`**: Usare `??`, `isset()`, o `getAttribute()` su modelli Eloquent.
*   **VALIDATE**: Ogni modifica PHP deve passare **PHPStan lvl10 + PHPMD + PHPInsights** prima del commit.
*   **ROADMAP**: Aggiornare sempre i roadmap in `docs/` prima di risolvere problemi strutturali.
*   **STABILIZATION**: Mantenere il 100% di compliance PHPStan Level 10 su tutti i moduli (34/34 completati in Phase 6).

```php
// ❌ WRONG
protected $casts = ['email_verified_at' => 'datetime'];

// ✅ CORRECT
/** @return array<string, string> */
protected function casts(): array {
    return ['email_verified_at' => 'datetime'];
}
```

### 🚨 **RULE #9: Idempotent Migrations**
...
### 🚨 **RULE #10: Project-Agnostic Prompts**

**Tutti i prompt in `bashscripts/tools/prompts` devono essere "Project-Agnostic".**

*   **NO Hardcoding**: Non inserire nomi di progetto (es. PTVX), database specifici o path locali assoluti.
*   **Placeholder**: Usa placeholder o descrizioni generiche per elementi specifici del progetto.
*   **Focus Philosophy**: I prompt devono concentrarsi sul "Perché" e sulla "Filosofia" Laraxot (DRY, KISS, SOLID, ROBUST).
*   **Self-Refining**: Ogni nuova scoperta architetturale deve essere astratta e integrata nei prompt esistenti per migliorare le performance future.

Vedi [Analisi Miglioramento Prompt](analisi_miglioramento_prompt.md) per i dettagli tecnici.

**È obbligatorio usare `XotBaseMigration` e garantire che le migrazioni siano ripetibili (idempotenti).**

*   **EXTEND**: Usare sempre `class extends XotBaseMigration`.
*   **MODEL**: Definire `protected ?string $model_class` per la connessione automatica.
*   **IDEMPOTENCY**: Usare `tableUpdate()`/`tableCreate()` e verificare l'esistenza delle colonne con `hasColumn()`.
*   **NO DROP**: Non usare `Schema::drop()` in additive migrations; sovrascrivere `down()` per rimuovere solo le colonne aggiunte.

Vedi [Database Patterns](patterns/database.md) per lo standard completo.

### 🚨 **RULE #11: Modular Database Connections**

**È ASSOLUTAMENTE VIETATO inserire connessioni database specifiche di un modulo nel file `laravel/config/database.php`.**

*   **DYANAMIC REGISTRATION**: Le connessioni dei moduli sono registrate dinamicamente da `Modules\Tenant\Providers\TenantServiceProvider`.
*   **AGNOSTICISM**: Il core (`config/database.php`) deve rimanere agnostico e contenere solo le connessioni standard (`mysql`, `sqlite`, etc.).
*   **NAMING**: La connessione deve avere lo stesso nome del modulo (snake_case).
*   **CONFIGURAZIONE**: Se un modulo necessita di un database separato, la configurazione deve risiedere nei file di configurazione del tenant (es. `laravel/config/local/<tenant>/database.php`) o essere pilotata da variabili d'ambiente (`DB_DATABASE_{MODULE_NAME}`).
*   **FALLBACK**: Se non configurata esplicitamente, la connessione del modulo clona automaticamente la connessione `mysql` di default.

Vedi [Database Architecture](Modules/Xot/docs/database-architecture.md) per lo standard completo.

---

## ⚠️ Critical Quick Rules

### NEVER Extend Filament Directly
```php
// ❌ WRONG
class MyPage extends Filament\Pages\Page

// ✅ CORRECT
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

### NEVER Hardcode Labels
```php
// ❌ WRONG
TextInput::make('name')->label('Nome')

// ✅ CORRECT
TextInput::make('name') // Translation handled automatically
```

### NEVER Use Services (Use Actions Instead)
```php
// ❌ WRONG
class UserService { ... }

// ✅ CORRECT
class CreateUserAction { use QueueableAction; ... }
```

### NEVER Use property_exists() with Eloquent Models
```php
// ❌ WRONG
if (property_exists($model, 'email')) { ... }

// ✅ CORRECT
if (isset($model->email)) { ... }
```

See [Eloquent Properties](framework/eloquent-properties.md) for complete details.

### ALWAYS Use withExtraAttributes() (Not where())
```php
// ✅ CORRECT - Use scope
$models = Model::withExtraAttributes('key', 'value')->get();

// ❌ WRONG - Direct JSON path query
$models = Model::where('extra_attributes->key', 'value')->get();
```

### ALWAYS Put Scripts in bashscripts/
```bash
# ✅ CORRECT - Categorized in bashscripts
bashscripts/analysis/analyze_code.sh

# ❌ WRONG - In laravel or docs
laravel/script.sh
```

### ALWAYS Verify with MCPs
```
# ✅ CORRECT - Use available MCPs (linters, static analysis, dry-runs) to verify every change.
# ❌ WRONG - Assuming a change works without verification.
```

### ALWAYS Decide Order and Priorities Autonomously
```
# ✅ CORRECT - The agent decides the order and priority of tasks.
# ❌ WRONG - Asking the user for order and priorities.
```

## 🚀 Getting Started

1. Read [Architecture Rules](fundamentals/architecture-rules.md) first - **CRITICAL**
2. Study [Module Structure](fundamentals/module-structure.md)
3. Follow [Code Conventions](development/conventions.md)
4. Consult [Common Pitfalls](development/pitfalls.md) to avoid mistakes
5. **NEW**: Read [Bug Fixing Guide](bug-fixing-guide.md) for systematic debugging approach

## 📝 Documentation Principles

- **DRY**: No repetition - reference other docs instead of duplicating
- **KISS**: Simple, focused files with single responsibilities
- **Modular**: Files organized by concern, not by size
- **Linked**: Cross-references between related documentation
- **Versioned**: Clear version history and change tracking

---

**Version**: 3.3 (Agent Skills Integration & Docs Audit)  
**Last Updated**: February 2026  
**Files Reorganized**: 17+ files (Modular Docs flattening)  
**Critical Rules**: 8 unbreakable rules reinforced + Hybrid Skill system  
**Maintainability**: 🚀 Maximized with 100% PHPStan Level 10 compliance and dynamic Agent Skills.
