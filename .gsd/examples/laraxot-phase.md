# Esempio GSD Phase per Laraxot (brownfield)

## Scopo

Mostrare un esempio minimale di fase GSD applicata a una codebase Laraxot già esistente, mantenendo DRY + KISS e con verifiche esplicite.

## Prerequisiti

- Esiste `.planning/` (o lo creerà la fase `new-project`).
- Hai identificato il modulo di competenza (no “nuovi moduli” per workaround).

## Fase tipo (outline)

### Discuss phase (contesto)

Template: `.gsd/templates/PHASE-CONTEXT.md`

Raccogli decisioni che spesso vanno perse:
- confine modulo (dove vive la logica),
- vincoli Filament/XotBase,
- impatto su traduzioni e docs,
- test attesi e criteri di done.

Output consigliato: `.planning/phases/01-CONTEXT.md`

### Plan phase (piani atomici)

Template: `.gsd/templates/PHASE-PLAN.md`

Scrivi 2–5 task “piccoli e verificabili”, ognuno con:
- file target,
- azione (cosa cambiare e perché),
- verify (come provare che funziona),
- done (condizione di chiusura).

Output consigliato: `.planning/phases/01-01-PLAN.md`, `.planning/phases/01-02-PLAN.md`, ...

### Execute phase (esecuzione + commit atomici)

Template: `.gsd/templates/PHASE-SUMMARY.md`

Regola pratica: **un piano = un commit** (quando richiesto esplicitamente), per rendere facile il bisect in caso di regressione.

Output consigliato: `.planning/phases/01-01-SUMMARY.md`, ...

### Verify work (UAT + fix loop)

Template: `.gsd/templates/PHASE-UAT.md`

Checklist tipica Laraxot:
- PHPStan sul perimetro toccato (da `laravel/` con `laravel/phpstan.neon`)
- Pint su file modificati
- test Pest mirati (quando sensato)
- nessun `Log::*` introdotto
- nessun `->label()/->placeholder()/->helperText()` introdotto

Output consigliato: `.planning/phases/01-UAT.md`

# GSD Example: Laraxot Phase Execution

## Scenario

Adding a new feature to the `Performance` module: Audit Trail for all evaluation actions.

---

## Phase Context (from discuss)

```markdown
# Phase 3 — Context Document

**Phase**: Audit Trail Implementation
**Module**: Performance

## Decisions Made

### Data/Model Decisions
- New model: `AuditLog` in Performance module, extends BaseModel
- Fields: user_id, action, record_type, record_id, old_values (json), new_values (json), ip_address
- Migration extends XotBaseMigration, no down() method

### Laraxot-Specific
- Module: Modules/Performance
- XotBase: XotBaseListRecords for Filament listing
- Translations: it/en/de for audit_log resource
- No ->label() anywhere — all via LangServiceProvider
```

---

## Plan (XML format)

```xml
<plan>
  <metadata>
    <phase>3</phase>
    <plan_number>1</plan_number>
    <wave>1</wave>
    <dependencies>none</dependencies>
  </metadata>

  <task type="auto">
    <name>Create AuditLog model and migration</name>
    <files>
      laravel/Modules/Performance/app/Models/AuditLog.php,
      laravel/Modules/Performance/database/migrations/2026_03_18_000001_create_audit_logs_table.php
    </files>
    <action>
      1. Create AuditLog model extending Performance\Models\BaseModel
      2. Add declare(strict_types=1)
      3. Define $fillable with @var list&lt;string&gt; annotation
      4. Implement casts() method (not $casts property)
      5. Add @property PHPDoc for all columns
      6. Create migration extending XotBaseMigration with anonymous class
      7. NO down() method in migration
      8. Add Schema::hasTable check before create
    </action>
    <verify>
      Run: cd laravel && ./vendor/bin/phpstan analyse Modules/Performance/app/Models/AuditLog.php --level=10
      Expect: 0 errors
    </verify>
    <done>Model and migration exist, PHPStan passes at level 10</done>
  </task>

  <task type="auto">
    <name>Create Filament resource for AuditLog</name>
    <files>
      laravel/Modules/Performance/app/Filament/Resources/AuditLogResource.php,
      laravel/Modules/Performance/app/Filament/Resources/AuditLogResource/Pages/ListAuditLogs.php
    </files>
    <action>
      1. Resource extends XotBaseResource
      2. ListAuditLogs extends XotBaseListRecords
      3. Implement getTableColumns() with string keys (array&lt;string, Column&gt;)
      4. NO ->label() on any column or field
      5. All translations via lang files
      6. Add declare(strict_types=1)
    </action>
    <verify>
      Run: cd laravel && ./vendor/bin/phpstan analyse Modules/Performance/app/Filament/Resources/AuditLogResource.php --level=10
      Expect: 0 errors
    </verify>
    <done>Resource renders in admin panel, PHPStan passes</done>
  </task>

  <task type="auto">
    <name>Create translation files</name>
    <files>
      laravel/Modules/Performance/lang/it/audit_log.php,
      laravel/Modules/Performance/lang/en/audit_log.php,
      laravel/Modules/Performance/lang/de/audit_log.php
    </files>
    <action>
      1. Use expanded structure with fields.{name}.label, .placeholder, .help
      2. Use short array syntax []
      3. Add declare(strict_types=1)
      4. Include navigation, page, fields, actions sections
    </action>
    <verify>Check all three language files have identical key structure</verify>
    <done>All three language files exist with expanded structure</done>
  </task>
</plan>
```

---

## Git Commits (after execution)

```
abc123f feat(phase-3): create AuditLog model and migration
def456g feat(phase-3): create AuditLog Filament resource
hij789k feat(phase-3): add audit_log translations (it/en/de)
```

---

## Quality Gate Results

- PHPStan Level 10: ✅ 0 errors on Performance module
- Pint: ✅ All files formatted
- No ->label(): ✅ Verified
- Translations: ✅ Expanded structure in 3 languages
- XotBase: ✅ All classes extend XotBase*
- strict_types: ✅ All new files have declare(strict_types=1)
