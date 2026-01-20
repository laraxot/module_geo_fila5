# Module Structure Analysis

**Generated:** 2025-12-17
**Analyzer:** Super Mucca Structure Analyzer
**Principle:** DRY + KISS

## Philosophy & Architecture

### Core Principles

1. **XotBase First** - Never extend Filament classes directly, always use XotBase classes
2. **DRY + KISS** - Don't Repeat Yourself + Keep It Simple, Stupid
3. **Actions over Services** - Use Spatie Queueable Actions instead of traditional Services
4. **Type Safety** - PHPStan Level 10 mandatory, strict types everywhere
5. **No property_exists() with Eloquent** - Use hasAttribute(), isFillable(), Schema::hasColumn()
6. **Automatic Translations** - No hardcoded ->label(), use translation files
7. **Deprecated $casts** - Use casts() method instead (Laravel 11+)

### Technology Stack

- **PHP:** 8.3.27
- **Laravel:** 12
- **Filament:** 4
- **Livewire:** 3
- **PHPStan:** Level 10 (larastan/larastan v3)
- **Testing:** Pest v3

### Pattern Architecture

- **Repository Pattern**: UserRepositoryInterface → UserRepository
- **Service Layer**: Business logic in dedicated services
- **Actions**: Spatie\QueueableAction for async operations
- **DTOs**: Spatie\LaravelData for type-safe data transfer
- **Validation**: FormRequest with translation keys

## Module Statistics

### Core Modules (by documentation size)

| Module | .md Files | Status | Description |
|--------|-----------|--------|-------------|
| **Xot** | 791 | 🟢 Core | Framework core, XotBase classes |
| **Notify** | 618 | 🟢 Core | Notification system, email templates |
| **User** | 476 | 🟢 Core | User management, auth, permissions |
| **UI** | 293 | 🟢 Core | UI components, themes |
| **Lang** | 269 | 🟢 Core | Translation system, localization |
| **Media** | 128 | 🟡 Active | Media management, AWS Lambda |
| **Activity** | 111 | 🟡 Active | Activity tracking, audit logs |
| **Gdpr** | 95 | 🟡 Active | GDPR compliance |
| **Tenant** | 69 | 🟡 Active | Multi-tenancy |
| **Sigma** | 56 | 🟡 Active | Sigma integration |
| **Setting** | 35 | 🟡 Active | Application settings |
| **Ptv** | 32 | 🟡 Active | PTV system |
| **Rating** | 26 | 🟡 Active | Rating system |
| **Progressioni** | 22 | 🟡 Active | Career progressions |
| **Job** | 19 | 🟡 Active | Job queue management |
| **Pdnd** | 12 | 🟡 Active | PDND integration |
| **DbForge** | 11 | 🟡 Active | Database migrations |
| **Incentivi** | 9 | 🟡 Active | Incentive system |
| **IndennitaCondizioniLavoro** | 6 | 🟡 Active | Work conditions |
| **MobilitaVolontaria** | 4 | 🟡 Active | Voluntary mobility |
| **Badge** | 2 | 🟡 Active | Badge system |
| **CertFisc** | 2 | 🟡 Active | Tax certificates |

### Business Domain Modules

- **Europa** (5) - European projects
- **Legge109** (5) - Law 109
- **Legge104** (4) - Law 104
- **ContoAnnuale** (5) - Annual accounts
- **Inail** (5) - INAIL integration
- **Mensa** (5) - Cafeteria management
- **Prenotazioni** (5) - Reservations
- **PresenzeAssenze** (5) - Attendance/absence
- **Performance** - Performance evaluation
- **Questionari** (5) - Questionnaires
- **Sindacati** (5) - Labor unions

**Total Modules:** 34

## Documentation Issues Identified

### Critical Issues

1. **6,722 .md files with naming violations**
   - Uppercase letters in filenames
   - Underscores instead of hyphens (kebab-case)
   - Dates in filenames (YYYY-MM-DD pattern)
   - **Solution:** `/bashscripts/docs/fix-all-docs-naming.sh`

2. **Duplicate documentation structures**
   - `docs/source/docs/` (should be `docs/`)
   - `docs/documentation-source/docs/` (should be `docs/`)
   - Multiple README.md at different levels
   - **Action Required:** Consolidate into single `docs/` per module

3. **23 scripts misplaced in /docs/**
   - **Fixed:** Moved to appropriate bashscripts/ subdirectories
   - Quality scripts → `bashscripts/quality/`
   - Git scripts → `bashscripts/git/conflict_resolution/`
   - Docs scripts → `bashscripts/docs/`

### Documentation Standards

✅ **Allowed in docs/:**
- README.md (uppercase allowed)
- CHANGELOG.md (uppercase allowed)
- All other files: kebab-case, no dates, no underscores

❌ **Not Allowed:**
- `phpstan-level9-fixes.md` → use `phpstan-fixes.md`
- `fixes-lang-module-phpstan.md` → use `phpstan-fixes.md`
- `translation-audit-completion-2025.md` → use `translation-audit.md`
- `MCAMARA-IMPLEMENTATION-GUIDE.md` → use `mcamara-implementation-guide.md`

## Bash Scripts Organization

### Directory Structure

```
bashscripts/
├── quality/           # Quality analysis (phpstan, phpmd, phpinsights)
├── docs/             # Documentation management
├── git/
│   └── conflict_resolution/  # Git conflict tools
├── composer/         # Composer operations
├── testing/          # Test runners
└── deployment/       # Deployment scripts
```

### Script Requirements

- **Naming:** kebab-case (e.g., `analyze-module-quality.sh`)
- **Dry-run:** Always provide `--dry-run` option
- **Output:** Clear summary of actions taken
- **Idempotent:** Safe to run multiple times
- **Header:** Clear usage instructions in comments

## Quality Tools Available

### PHPStan Analysis

```bash
# Analyze single module
./vendor/bin/phpstan analyse Modules/Xot --level=10

# Analyze all modules
./bashscripts/quality/analyze-all-modules-quality.sh
```

### PHPMD (PHP Mess Detector)

```bash
./vendor/bin/phpmd Modules/Xot text cleancode,codesize,design,naming
```

### PHPInsights

```bash
./vendor/bin/phpinsights analyse Modules/Xot
```

### Fix Docs Naming

```bash
# Dry run first
./bashscripts/docs/fix-all-docs-naming.sh --dry-run

# Apply fixes
./bashscripts/docs/fix-all-docs-naming.sh
```

## Recommended Actions

### Immediate (Priority 1)

- [ ] Fix all 6,722 .md naming violations
- [ ] Consolidate duplicate docs/ structures
- [ ] Run PHPStan level 10 on core modules (Xot, User, Notify, Lang, UI)
- [ ] Document PHPStan errors per module

### Short Term (Priority 2)

- [ ] Create module-specific quality reports
- [ ] Fix critical PHPStan errors (>500 per module)
- [ ] Update module README.md files
- [ ] Consolidate duplicate documentation

### Long Term (Priority 3)

- [ ] Achieve PHPStan level 10 on all modules
- [ ] Create comprehensive test suites
- [ ] Document all business logic
- [ ] Create architecture decision records (ADRs)

## Tools Created

### Quality Analysis

- `bashscripts/quality/analyze-all-modules-quality.sh` - Full quality report
- `bashscripts/quality/analyze-core-modules-quick.sh` - Quick core modules check
- `bashscripts/quality/module_quality_audit.sh` - Legacy quality audit

### Documentation Fixes

- `bashscripts/docs/fix-all-docs-naming.sh` - Fix all naming violations (6722 files)
- `bashscripts/docs/cleanup-docs.sh` - Remove duplicates
- `bashscripts/docs/analyze_docs_structure.sh` - Structure analysis

### Git Tools

- `bashscripts/git/conflict_resolution/resolve_conflicts_current_change_v6.sh` - Auto-resolve conflicts

## Next Steps

1. **Run naming fixes**:
   ```bash
   cd /var/www/_bases/base_ptvx_fila4_mono
   ./bashscripts/docs/fix-all-docs-naming.sh --dry-run
   # Review output
   ./bashscripts/docs/fix-all-docs-naming.sh
   ```

2. **Generate quality reports**:
   ```bash
   ./bashscripts/quality/analyze-all-modules-quality.sh
   ```

3. **Review and document**:
   - Study generated reports
   - Create fix plans
   - Update module docs

---

**Generated with Super Mucca Powers** 🐄⚡

**Philosophy:** DRY + KISS + Type Safety + Business Logic Focus
