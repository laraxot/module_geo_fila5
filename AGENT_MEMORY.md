# AI Agent Memory - Project Patterns & Best Practices

**Project**: PTVX Fila5 Mono  
**Last Updated**: 2026-03-06  
**Scope**: Development patterns, coding standards, architecture

---

## 📋 Migration Patterns

### 1. XotBaseMigration Standard
All migrations must extend `Modules\Xot\Database\Migrations\XotBaseMigration`:

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\ModuleName\Models\ModelName;

return new class extends XotBaseMigration
{
    protected ?string $model_class = ModelName::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            // Use schemalessAttributes for dynamic data
            $table->schemalessAttributes('extra_attributes');
            
            // Add common fields
            $this->updateTimestamps($table);
            $this->updateUser($table);
        });
    }
};
```

### 2. Schemaless Attributes Pattern
For dynamic data, use `schemalessAttributes()` not `json()`:

```php
// ✅ CORRECT
$table->schemalessAttributes('extra_attributes');

// ❌ WRONG
$table->json('extra_attributes');
```

### 3. Common Fields Pattern
Use built-in methods for standard fields:

```php
// Adds timestamps, created_by, updated_by
$this->updateTimestamps($table);

// Adds user tracking fields
$this->updateUser($table);
```

---

## 🏗️ Architecture Patterns

### 1. Rating Module (Agnostic)
- Rating module serves multiple modules: IndennitaResponsabilita, Performance, Progressioni
- Each module has its own Rating model extending BaseRating
- HasRatingsTrait provides shared functionality

### 2. Base Model Pattern
Models extend appropriate base classes:
- BaseRating for Rating models
- BaseScheda for schedule-like models
- XotBaseModel for general models

### 3. Trait Usage
Use traits for shared functionality:
- HasRatingsTrait for rating functionality
- RelationshipTrait for model relationships
- FunctionTrait for module-specific functions

---

## 🎨 Filament Patterns

### 1. XotBase Wrappers
Never extend Filament classes directly:

```php
// ✅ CORRECT
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
class MyPage extends XotBasePage

// ❌ WRONG
use Filament\Resources\Pages\Page;
class MyPage extends Page
```

### 2. Resource Patterns
Use XotBaseResource wrappers for consistency.

### 3. Form Components
Use Filament components with proper wire:model binding.

### 4. `InteractsWithRecord` Property Rule
When a Filament page uses `Filament\Resources\Pages\Concerns\InteractsWithRecord`:
- Never redeclare `$record` in the page class.
- Use `getRecord()` from the trait and add a typed narrowing getter (for example `getSpecificRecord(): ModuleModel`) if needed.
- Redeclaring `$record` with a narrower type causes a PHP 8.3 fatal trait composition error.

---

## 📊 Database Patterns

### 1. Schemaless Attributes
Use Spatie Schemaless Attributes for dynamic data:

```php
// Model
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

protected function casts(): array
{
    return [
        'extra_attributes' => SchemalessAttributes::class,
    ];
}

// Migration
$table->schemalessAttributes('extra_attributes');
```

### 2. Query Patterns
Use scopeWithExtraAttributes for filtering:

```php
Rating::withExtraAttributes('anno', 2024)->get();
Rating::withExtraAttributes(['anno' => 2024, 'type' => 'performance'])->get();
```

---

## 🧪 Validation Patterns

### 1. Rating Rules
Use RuleEnum for consistent validation:

```php
enum RuleEnum: string implements HasLabel
{
    case ZeroFive = 'numeric|min:0|max:5';
    case NullableNumericMin0Max25 = 'nullable|numeric|min:0|max:25';
}
```

### 2. Form Validation
Build validation rules dynamically from ratings:

```php
public function getRules(): array
{
    $rulesFromRatings = $record->getRatingsRules('form_data.ratings.', '.pivot.value');
    
    $convertedRules = [];
    foreach ($rulesFromRatings as $key => $ruleString) {
        $convertedRules[$key] = explode('|', $ruleString);
    }
    
    return $convertedRules;
}
```

---

## 📁 Module Structure

### 1. Standard Module Layout
```
Modules/ModuleName/
├── app/
│   ├── Models/
│   │   ├── BaseModel.php
│   │   └── ModelName.php
│   └── Filament/
│       └── Resources/
├── database/
│   └── migrations/
├── resources/
│   └── views/
├── docs/
│   └── *.md
└── lang/
    └── it/
```

### 2. Documentation Standards
- All modules have comprehensive docs
- Use markdown for documentation
- Include cross-references between modules

---

## 🔧 Code Quality Standards

### 0. Short Array Syntax (CRITICAL)
**ALWAYS** use short array syntax `[]` in all PHP files. **NEVER** use `array()`.
Exception: `array()` may appear only in documentation/examples showing incorrect usage.

### 1. PHPStan Level 10
All code must pass PHPStan Level 10:

```bash
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName --level=10
```

### 2. Laravel Pint
Use Pint for code formatting:

```bash
./vendor/bin/pint Modules/ModuleName
```

### 3. Pest Testing
Write tests with Pest:

```php
test('rating_validation_works', function () {
    $record = createTestRecord();
    $rules = $record->getRatingsRules('prefix.', '.value');
    
    expect($rules)->toBeArray();
});
```

---

## 🎯 Common Issues & Solutions

### Issue 1: Migration Extends Wrong Class
```php
// ❌ WRONG
use Illuminate\Database\Migrations\Migration;

// ✅ CORRECT  
use Modules\Xot\Database\Migrations\XotBaseMigration;
```

### Issue 2: Schemaless vs JSON
```php
// ❌ WRONG
$table->json('extra_attributes');

// ✅ CORRECT
$table->schemalessAttributes('extra_attributes');
```

### Issue 3: Missing Common Fields
Always add common fields in updates:

```php
public function up(): void
{
    $this->tableUpdate(function (Blueprint $table): void {
        $table->string('new_field')->nullable();
        $this->updateTimestamps($table);
        $this->updateUser($table);
    });
}
```

---

## 🔄 Update Patterns

### 1. Fix Validation Rules
When fixing validation issues:
1. Identify problematic rule in database
2. Update RuleEnum if needed
3. Fix specific records if required

### 2. Form Enhancements
When improving forms:
1. Update controller to pass data to view
2. Update Blade template with new UI
3. Add validation attributes

### 3. Cross-Module Impact
Always consider impact on other modules:
- Rating changes affect Performance, Progressioni
- Xot changes affect all modules
- Schemaless patterns must be consistent

---

## 🚀 Action Pattern (CRITICAL)

### NEVER Use Constructor DI
```php
// ❌ WRONG - constructor DI
public function __construct(
    private readonly DatabaseManager $dbManager,
    private readonly LoggerInterface $logger,
) {}

// ✅ CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);
```

### Action Method Must Be `execute()`
```php
// ❌ WRONG - custom method name
app(CreateClientAction::class)->createPersonalAccessClient();

// ✅ CORRECT - always execute()
app(CreateClientAction::class)->execute();
```

---

## 📦 Composer & Module Dependencies

### Package Installation Rules
- **New packages → module `composer.json`**, NEVER in `laravel/composer.json`
- Run `composer go` from `laravel/` to merge via wikimedia/composer-merge-plugin
- Module composer.json gets merged automatically into root

### Git Rules
- NEVER run `git remote set-url` - only project owner does this
- Git goes forward only - never restore old versions
- Every error fix: git commit + GitHub issue + GitHub discussion

---

## 📚 Key References

### Documentation Files
- `/Modules/Xot/docs/migration-patterns.md` - Migration standards
- `/Modules/Rating/docs/rating-architecture.md` - Rating system docs
- `/Modules/Rating/docs/schemaless-attributes.md` - Schemaless patterns

### Code Locations
- Base classes: `/Modules/Xot/app/`
- Trait implementations: `/Modules/Rating/app/Models/Traits/`
- Migration examples: Various module database/migrations/

---

**Update Date**: 2026-02-11  
**Scope**: Development standards for PTVX Fila5 Mono  
**Priority**: High - Maintain consistency across modules
