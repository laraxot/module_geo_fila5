# Project Context — Laraxot PTVX

> This file ensures all AI agents follow project conventions throughout all BMAD workflows.
> Referenced by: bmad-dev-story, bmad-quick-dev, bmad-create-architecture, bmad-code-review

---

## Stack

| Technology | Version | Purpose |
|-----------|---------|---------|
| PHP | 8.3+ | Backend language |
| Laravel | 12.x | Framework |
| Filament | v5 | Admin panel |
| Pest | v4 | Testing |
| PHPStan | Level 10 | Static analysis |
| Laraxot | Latest | Modular monolith framework |
| Spatie Laravel Data | Latest | DTOs |
| Spatie QueueableAction | Latest | Business logic actions |
| Tailwind CSS | v4 | Styling |
| Livewire | v4 | Reactivity |

## Architecture

- **Pattern**: Modular Monolith via nwidart/laravel-modules + Laraxot
- **Modules**: 42+ in `laravel/Modules/`
- **Themes**: `laravel/Themes/` (Zero, One)
- **Base Classes**: All Filament classes MUST extend `XotBase*` wrappers from `Modules/Xot`

## Critical Implementation Rules

### PHP Standards
- `declare(strict_types=1)` in EVERY PHP file
- Short array syntax `[]` ALWAYS — never `array()`
- PSR-12 code style enforced via Laravel Pint
- PHPStan Level 10 — no ignores, no baseline exceptions

### Models
- MUST extend module's own `BaseModel` — NEVER `Illuminate\Database\Eloquent\Model` directly
- NEVER extend `Modules\Xot\Models\XotBaseModel` directly
- Use `casts()` method — NEVER `$casts` property
- `$fillable` annotated with `/** @var list<string> */`
- Full `@property` PHPDoc for all columns
- NEVER use `property_exists()` — use `??` operator instead

### Filament
- ALL resources extend `XotBaseResource`
- ALL list pages extend `XotBaseListRecords`
- ALL relation managers extend `XotBaseRelationManager`
- NEVER use `->label()`, `->placeholder()`, `->helperText()` — translations are automatic via LangServiceProvider
- `getTableColumns()` MUST return `array<string, Column>` with explicit string keys
- Custom actions override `setUp()` for configuration

### Migrations
- Anonymous classes extending `XotBaseMigration`
- NEVER implement `down()` method
- Always check `Schema::hasTable()` / `Schema::hasColumn()` before create/add
- Use `$table->foreignIdFor()` for foreign keys

### Translations
- Expanded structure: `fields.{name}.label`, `.placeholder`, `.help`
- Files in `Modules/{Module}/lang/{locale}/`
- Short array syntax with `declare(strict_types=1)`
- NEVER hardcode strings in Filament components

### Actions over Services
- Use `app(ActionClass::class)->execute()` — NEVER constructor DI
- Spatie QueueableAction for business logic
- Spatie Laravel Data for DTOs

### Git
- Forward-only workflow — NEVER revert, reset, or checkout old commits
- Atomic commits per task
- Conventional commit format: `feat(module): description`

### Testing
- Pest v4 exclusively
- PascalCase test filenames
- NEVER use `migrate:fresh` in tests — use `DatabaseTransactions`
- AAA pattern (Arrange-Act-Assert)

### Documentation
- Lowercase filenames (exception: `README.md`, `CHANGELOG.md`)
- No dates in filenames
- Bidirectional links between module docs and root docs
- Project-agnostic — no external project name references

## Module Structure

```
Modules/{ModuleName}/
├── app/
│   ├── Actions/           # Business logic (QueueableAction)
│   ├── Datas/             # Spatie Laravel Data DTOs
│   ├── Filament/
│   │   ├── Resources/     # XotBaseResource subclasses
│   │   ├── Pages/         # XotBasePage subclasses
│   │   └── Widgets/       # XotBaseWidget subclasses
│   ├── Models/
│   │   ├── BaseModel.php  # Module's own base (extends XotBaseModel)
│   │   └── ...
│   └── Providers/
├── config/
├── database/migrations/
├── docs/                  # Module documentation
├── lang/{locale}/         # Translation files
├── resources/views/
├── routes/
└── tests/
```

## Quality Gates

After EVERY code change:
1. `./vendor/bin/phpstan analyse Modules/{affected} --level=10`
2. `./vendor/bin/pint Modules/{affected}`
3. `./vendor/bin/pest Modules/{affected}/tests` (if tests exist)
4. Verify no `->label()` in Filament components
5. Verify `declare(strict_types=1)` in all new PHP files

## Key Modules

| Module | Purpose |
|--------|---------|
| **Xot** | Core framework — XotBase classes, migrations, traits |
| **User** | Authentication, roles, permissions |
| **Tenant** | Multi-tenancy |
| **UI** | Shared Blade/Filament components |
| **Lang** | Localization, LangServiceProvider |
| **Cms** | Content management |
| **Notify** | Notifications |

## References

- `AGENTS.md` — Central agent reference
- `.planning/STATE.md` — GSD project state
- `docs/project/gsd-methodology.md` — GSD workflow
- `docs/project/bmad-method-integration.md` — BMAD integration
