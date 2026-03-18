<<<<<<< .merge_file_sQWTyx
<<<<<<< .merge_file_3KfvPu
=======
<<<<<<< .merge_file_7GEvnI
## Qwen Added Memories
- Test rules: Use Pest format exclusively. NEVER use migrate:fresh or database:refresh in tests. Use DatabaseTransactions trait instead for proper transactional test isolation without schema rebuilds.
=======
>>>>>>> .merge_file_AaKQa5
# QWEN.md - Project Context & Development Guide

> **Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
> **Stack**: Laravel 12.47 | Filament v5 | Pest v4 | PHPStan Level 10 | PHP 8.3+  
> **Architecture**: Laraxot Modular System  
> **AI Framework**: BMAD-METHOD v6.2.0  
> **Last Updated**: 2026-03-18

---

## 🎯 Project Overview

**PTVX** is a modular enterprise HR & Performance evaluation system for Italian Public Administrations. It automates:

- **Personnel evaluations** with configurable criteria and automatic calculations
- **Indemnity management** with defined formulas and complete audit trails
- **Career progression** with standardized workflows and approval chains
- **Documentation generation** including PDF exports and version control

### Core Technologies

| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 12.47.0 | Backend framework |
| Filament | 5.0.0 | Admin panel |
| PHP | 8.3+ | Language |
| PHPStan | Level 10 | Static analysis |
| Pest | v4 | Testing |
| Laraxot | Custom | Modular architecture |
| **BMAD-METHOD** | **v6.2.0** | **AI-driven agile development** |

### BMAD-METHOD Integration

**BMAD-METHOD v6.2.0** provides AI-driven agile development with:

- **12+ Specialized Agents**: PM, Architect, Developer, QA, UX, Tech Writer
- **34+ Workflows**: Analysis, Solutioning, Implementation, Testing, Documentation
- **Skills Architecture**: Custom Laravel/Filament development skills
- **Party Mode**: Multi-agent collaboration

**Key Workflows**:
```bash
bmad-laravel-module-dev      # Create Laravel modules
bmad-filament-page-dev       # Create Filament pages
bmad-create-architecture     # Design architecture
bmad-dev                     # Implement features
bmad-code-review             # Review code
bmad-qa-generate-e2e-tests   # Generate tests
bmad-document-project        # Generate docs
```

**Documentation**:
- **BMAD Guide**: `docs/bmad/README.md`
- **Project Context**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`
- **Laravel Skill**: `_bmad/core/skills/bmad-laravel-module-dev.md`
- **Filament Skill**: `_bmad/core/skills/bmad-filament-page-dev.md`
- **AI Coordination**: `docs/ai-agent-coordination.md`

### Project Structure

```
base_ptvx_fila5_mono/
├── laravel/                    # Main Laravel application
│   ├── Modules/                # 42+ modular components
│   │   ├── Xot/               # Core module (base for all others)
│   │   ├── Activity/          # Activity tracking
│   │   ├── Performance/       # Performance evaluations
│   │   ├── Ptv/               # Main PTV functionality
│   │   └── ...                # 38+ other modules
│   ├── app/                   # Core application code
│   ├── config/                # Configuration
│   └── database/              # Migrations, seeders
├── bashscripts/               # All .sh scripts (centralized)
│   ├── ai/                    # AI-related scripts
│   ├── maintenance/           # Maintenance scripts
│   ├── git/                   # Git operations
│   └── docs/                  # Script documentation
├── docs/                      # Project documentation
├── .qwen/                     # Qwen AI configuration (symlink)
└── AGENTS.md                  # Development guide index
```

---

## 🚀 Quick Start

### Initial Setup

```bash
# Clone and install
git clone <repository-url>
cd base_ptvx_fila5_mono/laravel
composer install
cp .env.example .env
php artisan key:generate

# Configure database in .env
php artisan migrate
php artisan db:seed

# Frontend
npm install
npm run build
```

### Essential Commands

```bash
# Complete setup (recommended)
composer go                    # Install + permissions + optimization

# Code quality
php -d memory_limit=2G ./vendor/bin/phpstan analyse   # Level 10
./vendor/bin/pint                                      # Formatting
./vendor/bin/pest                                      # Testing

# Cache clearing
bash bashscripts/maintenance/cleanup/clear_all_caches.sh
php artisan filament:optimize
```

---

## 🔴 CRITICAL RULES (Must Follow)

### 1. Commit & Push Immediately

**After completing ANY task:**

```bash
git add -A
git commit -m "type: clear description"
git push origin dev
```

**NEVER** leave work uncommitted. See: `bashscripts/docs/COMMIT_AND_PUSH_RULE.md`

### 2. File Location Rules

| File Type | Location | Never |
|-----------|----------|-------|
| **Scripts (.sh)** | `bashscripts/{category}/` | `docs/`, root |
| **Documentation (.md)** | `docs/` or module `docs/` | root |
| **AI Agent dirs** | `bashscripts/ai/.{agent}/` + symlinks | Multiple copies |
| **Module code** | `Modules/{Module}/app/` | Module root |

See: `docs/FILE_LOCATION_RULES.md`, `bashscripts/docs/script-location-rule.md`

### 3. Read → Reason → Study → Update → Improve

**Before modifying ANY file:**

1. **Read** the file completely
2. **Reason** about the change
3. **Study** related context and documentation
4. **Update** docs if needed
5. **Improve** the code

After edit: Run PHPStan + PHPMD + PHPInsights.

See: `.agents/docs/agents-first-rule.md`

### 4. Extend XotBase Classes

```php
// ❌ NEVER extend Filament directly
class MyPage extends Filament\Pages\Page

// ✅ ALWAYS use XotBase wrappers
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage
```

### 5. No Hardcoded Strings

```php
// ❌ NEVER
TextInput::make('name')->label('Nome')

// ✅ ALWAYS (auto-translated)
TextInput::make('name')
```

### 6. Forward-Only Git

```bash
// ❌ NEVER go backward
git reset --hard HEAD~1

// ✅ ALWAYS go forward
git commit -m "fix: correct issue"
```

### 7. PHPStan Level 10

- **No ignores** allowed
- **declare(strict_types=1)** in every file
- **Short array syntax `[]`** always, never `array()`
- **No `property_exists()`** on Eloquent models - use `isset()`

---

## 📁 AI Agent Coordination

### .qwen Directory Structure

```
.qwen/                        # Root symlink -> bashscripts/ai/.qwen
  -> bashscripts/ai/.qwen

laravel/.qwen/                # Laravel symlink
  -> ../bashscripts/ai/.qwen

bashscripts/ai/.qwen/         # Source of truth
├── commands/
├── skills/
└── rules/
```

**All AI agents share the same centralized configuration via symlinks.**

See: `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md`, `docs/conventions/qwen-directory-structure.md`

### Before You Act

1. **Read** `docs/ai-agent-coordination.md`
2. **Check** for concurrent agents working on same files
3. **Review** recent commits: `git log -n 10 --oneline`
4. **Pull** latest changes: `git pull origin dev`

### After You Act

1. **Commit** with clear message
2. **Push** to remote
3. **Update** coordination document
4. **Create** GitHub Issue/Discussion if needed

---

## 🏗️ Architecture Patterns

### Module Structure

Every module follows this pattern:

```
Modules/{ModuleName}/
├── app/                    # ALL PHP classes go here
│   ├── Actions/           # Business logic
│   ├── Datas/             # Data objects (Spatie Laravel Data)
│   ├── Filament/          # Filament resources, pages, widgets
│   ├── Models/            # Eloquent models
│   ├── Providers/         # Service providers
│   └── Services/          # Services
├── config/                # Module configuration
├── database/              # Migrations, factories, seeders
├── docs/                  # Module documentation
├── lang/                  # Translations
├── resources/             # Views, assets
├── routes/                # Module routes
├── tests/                 # Tests
├── composer.json          # Module dependencies
└── module.json            # Module metadata
```

**Exceptions**: Only Xot module can have special folders in root (`helpers/`, `Datas/`, `Services/`, `Filament/`) for legacy reasons.

See: `laravel/Modules/Xot/docs/module-directory-structure-rule.md`

### Action Pattern

```php
// ✅ CORRECT - Spatie QueueableAction + app() resolution
app(CreateClientAction::class)->execute($data);

// ❌ WRONG - Direct method call
CreateClientAction::execute($data);

// ❌ WRONG - Constructor DI in Actions
new CreateClientAction($dependency)
```

See: `.agents/docs/agents-guide/13-references/project-patterns.md`

### Database Patterns

- **No RefreshDatabase** in tests
- Use **HasXotFactory** trait (inherited from BaseModel)
- **Model classes MUST be singular** (e.g., `Scheda`, not `Schede`)
- Table names stay plural

See: `.agents/docs/database-patterns.md`, `.agents/docs/laraxot-model-rules.md`

---

## 🧪 Testing

### Running Tests

```bash
# All tests
./vendor/bin/pest

# Specific test
./vendor/bin/pest --filter="test_name"

# With coverage
./vendor/bin/pest --coverage
```

### Test Structure

```php
<?php

declare(strict_types=1);

it('can create user', function () {
    // ✅ CORRECT - No RefreshDatabase
    // ✅ CORRECT - app() resolution
    $user = app(CreateUserAction::class)->execute([...]);
    
    expect($user)->toBeInstanceOf(User::class);
});
```

See: `.agents/docs/agents-guide/08-testing/`

---

## 📝 Commit Message Format

```
type: Short summary (50 chars or less)

Detailed description (optional, wrap at 72 chars)

- List of key changes
- Related issues
- Breaking changes (if any)
```

**Types:**
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation only
- `refactor:` Code refactoring
- `test:` Adding tests
- `chore:` Maintenance tasks

**Example:**
```
feat: AI agent junction structure, file location rules, and cleanup

- Add AI agent junction rule for .qwen directory
- Create symlinks: .qwen -> bashscripts/ai/.qwen
- Add file location rules documentation
- Update AGENT_MEMORY.md with new rules
- Remove temp/backup files from root
```

---

## 🔧 Development Workflow

### 1. Start Work

```bash
# Pull latest changes
git pull origin dev

# Check recent commits
git log -n 10 --oneline

# Read coordination doc
cat docs/ai-agent-coordination.md
```

### 2. During Work

- Follow **Read → Reason → Study → Update → Improve**
- Keep changes **atomic and focused**
- **Test** as you go
- **Document** decisions

### 3. Complete Work

```bash
# Review changes
git status
git diff

# Stage all
git add -A

# Commit with clear message
git commit -m "type: description"

# Push immediately
git push origin dev

# Verify
git status  # Should show "working tree clean"
```

---

## 📚 Key Documentation

### Core Rules

| Document | Path |
|----------|------|
| **Critical Rules** | `.agents/docs/agents-guide/04-architecture/critical-rules-summary.md` |
| **First Rule** | `.agents/docs/agents-first-rule.md` |
| **File Location** | `docs/FILE_LOCATION_RULES.md` |
| **Script Location** | `bashscripts/docs/script-location-rule.md` |
| **Commit & Push** | `bashscripts/docs/COMMIT_AND_PUSH_RULE.md` |
| **AI Junction** | `bashscripts/docs/AI_AGENT_JUNCTION_RULE.md` |

### Architecture

| Document | Path |
|----------|------|
| **Project Patterns** | `.agents/docs/agents-guide/13-references/project-patterns.md` |
| **Database Patterns** | `.agents/docs/database-patterns.md` |
| **Model Rules** | `.agents/docs/laraxot-model-rules.md` |
| **Migration Patterns** | `.agents/docs/migration-patterns.md` |
| **Filament Patterns** | `.agents/docs/filament-patterns.md` |

### Module Documentation

| Document | Path |
|----------|------|
| **Module Structure** | `laravel/Modules/Xot/docs/module-directory-structure-rule.md` |
| **Workspace Naming** | `laravel/Modules/Xot/docs/workspace-file-rule.md` |
| **Backup Files** | `laravel/Modules/Xot/docs/backup-copy-files-cleanup-rule.md` |

---

## 🤝 Multi-Agent Coordination

### GitHub

- **Repository**: `github.com/provtv/base_ptv_fila5_mono`
- **Branch**: `dev`
- **Issues**: Track specific tasks
- **Discussions**: Coordinate decisions

### Other AI Agents

- **Gemini**: Works on `base_fixcity_fila5`
- **Claude**: Works on `base_quaeris_fila5`
- **You**: Work on `base_ptvx_fila5`

**Sync changes** across bases when useful. Use GitHub Discussions to coordinate.

---

## 🚨 Common Pitfalls

### ❌ Don't Do This

```php
// Wrong: Direct Filament extension
class MyPage extends Filament\Pages\Page

// Wrong: Hardcoded label
TextInput::make('name')->label('Nome')

// Wrong: property_exists on model
if (property_exists($model, 'attribute'))

// Wrong: Constructor DI in Actions
new CreateAction($dependency)

// Wrong: array() syntax
$data = array('key' => 'value')
```

### ✅ Do This Instead

```php
// Correct: XotBase extension
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage

// Correct: Auto-translated
TextInput::make('name')

// Correct: isset()
if (isset($model->attribute))

// Correct: app() resolution
app(CreateAction::class)->execute($data)

// Correct: Short array syntax
$data = ['key' => 'value']
```

---

## 📊 Project Status

### Current State

- **42+ Modules** installed and active
- **PHPStan Level 10** achieved across all modules
- **100% Test Coverage** goal in progress
- **AI Agent Coordination** active (Qwen, Gemini, Claude)

### Recent Changes

```
8cbf25df docs: Add COMMIT_AND_PUSH_RULE and update AGENT_MEMORY
13f51baf feat: AI agent junction structure, file location rules, and cleanup
e4a54bda feat: Add new module documentation for planning and strategy
```

---

## 🔗 Quick Links

- **Laravel Docs**: https://laravel.com/docs
- **Filament Docs**: https://filamentphp.com/docs
- **PHPStan**: https://phpstan.org/user-guide
- **Pest**: https://pestphp.com/docs
- **Spatie Data**: https://spatie.be/docs/laravel-data

---

*This QWEN.md is auto-generated context for AI agents. Always verify with actual files and documentation.*
<<<<<<< .merge_file_sQWTyx
=======
## Qwen Added Memories
- Test rules: Use Pest format exclusively. NEVER use migrate:fresh or database:refresh in tests. Use DatabaseTransactions trait instead for proper transactional test isolation without schema rebuilds.
>>>>>>> .merge_file_t4ccTz
=======
>>>>>>> .merge_file_1KHqaZ
>>>>>>> .merge_file_AaKQa5
