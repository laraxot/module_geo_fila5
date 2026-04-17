# PTVX Fila5 Mono - Project Context for BMAD

**Generated**: 2026-03-18  
**Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
**Stack**: Laravel 12.47 | Filament v5 | Pest v4 | PHPStan Level 10 | PHP 8.3+  
**Architecture**: Laraxot Modular Monolith  
**Modules**: 42+ active modules  
**Language**: Italian (primary), English (secondary)

---

## 🎯 Project Overview

**PTVX** is a modular enterprise HR & performance evaluation system for Italian Public Administrations. It automates:

- **Personnel evaluations** with configurable criteria and automatic calculations
- **Indemnity management** with defined formulas and complete audit trails
- **Career progression** with standardized workflows and approval chains
- **Documentation generation** including PDF exports and version control

### Business Domain

| Domain | Description |
|--------|-------------|
| **Performance Management** | Continuous evaluation cycles, 360° feedback, competency frameworks |
| **Compensation** | Indemnities, bonuses, salary progression, budget tracking |
| **Career Development** | Promotions, transfers, skill matrices, training paths |
| **Compliance** | Italian public administration regulations, audit trails, GDPR |

---

## 🏗️ Architecture Overview

### Modular Monolith Pattern

```
base_ptvx_fila5_mono/
├── laravel/                    # Main application
│   ├── Modules/                # 42+ modular components
│   │   ├── Xot/               # Core module (base for all others)
│   │   ├── Activity/          # Activity tracking
│   │   ├── Performance/       # Performance evaluations
│   │   ├── Ptv/               # Main PTV functionality
│   │   ├── User/              # User management
│   │   ├── Role/              # Roles & permissions
│   │   └── ...                # 38+ other modules
│   ├── app/                   # Core application code
│   ├── config/                # Configuration
│   └── database/              # Migrations, seeders
├── bashscripts/               # All .sh scripts (centralized)
├── docs/                      # Project documentation
└── _bmad/                     # BMAD-METHOD configuration
```

### Module Structure (Standard)

Every module follows this pattern:

```
Modules/{ModuleName}/
├── app/                    # ALL PHP classes go here
│   ├── Actions/           # Business logic (Spatie QueueableAction)
│   ├── Datas/             # Data objects (Spatie Laravel Data)
│   ├── Enums/             # PHP 8.3 backed enums
│   ├── Filament/          # Filament resources, pages, widgets
│   ├── Models/            # Eloquent models
│   ├── Providers/         # Service providers
│   └── Services/          # Services (minimal, prefer Actions)
├── config/                # Module configuration
├── database/              # Migrations, factories, seeders
├── docs/                  # Module documentation (REQUIRED)
│   ├── README.md
│   ├── architecture/
│   ├── guides/
│   ├── references/
│   └── troubleshooting/
├── lang/                  # Translations (Italian + English)
├── resources/             # Views, assets
├── routes/                # Module routes
├── tests/                 # Pest tests
├── composer.json          # Module dependencies
└── module.json            # Module metadata
```

**Exception**: Only Xot core module can have special folders in root (`helpers/`, `Datas/`, `Services/`, `Filament/`) for legacy reasons.

---

## 🔴 CRITICAL RULES (Must Follow)

### 1. Code Quality Gates

```yaml
PHPStan: Level 10 (strict)
  - No ignores allowed
  - declare(strict_types=1) in every file
  - No property_exists() on Eloquent models - use isset()

Pint: PSR-12 compliance
  - Run after every code change
  - Command: ./vendor/bin/pint

Testing: Pest v4
  - TDD Red-Green-Refactor
  - DatabaseTransactions trait (NEVER RefreshDatabase)
  - Coverage target: 100%
```

### 2. Architecture Patterns

```php
// ✅ CORRECT - XotBase extension
class MyPage extends Modules\Xot\Filament\Pages\XotBasePage

// ❌ NEVER - Direct Filament extension
class MyPage extends Filament\Pages\Page

// ✅ CORRECT - Action resolution
app(CreateClientAction::class)->execute($data);

// ❌ NEVER - Direct method call
CreateClientAction::execute($data);

// ✅ CORRECT - Short array syntax
$data = ['key' => 'value'];

// ❌ NEVER - Long array syntax
$data = array('key' => 'value');
```

### 3. Database Patterns

```php
// ✅ CORRECT - Model naming
class Scheda extends BaseModel  // Singular class name

// Table name is plural automatically
protected $table = 'schede';

// ✅ CORRECT - Factory usage (inherited from BaseModel)
Scheda::factory()->create([...]);

// ❌ NEVER - RefreshDatabase in tests
// Use DatabaseTransactions instead
```

### 4. Translation Rules

```php
// ✅ CORRECT - Auto-translated (no hardcoded strings)
TextInput::make('name')
  ->label('name')  // Will auto-translate from lang files

// ❌ NEVER - Hardcoded strings
TextInput::make('name')
  ->label('Nome')  // Hardcoded Italian
```

### 5. Git Workflow

```bash
# Forward-only workflow
git pull origin dev
# ... make changes ...
git add -A
git commit -m "type: clear description"
git push origin dev

# ❌ NEVER go backward
git reset --hard HEAD~1  # FORBIDDEN
```

---

## 📁 File Location Rules

| File Type | Location | Never |
|-----------|----------|-------|
| **Scripts (.sh)** | `bashscripts/{category}/` | `docs/`, root |
| **Documentation (.md)** | `docs/` or module `docs/` | root |
| **AI Agent dirs** | `bashscripts/ai/.{agent}/` + symlinks | Multiple copies |
| **Module code** | `Modules/{Module}/app/` | Module root |
| **Workspace files** | `_{snake_case_name}.code-workspace` | Inside modules |

---

## 🧪 Testing Strategy

### Test Pyramid

```
        E2E (Playwright)
       /                \
      /                  \
     /                    \
Integration (Feature tests)
    /                      \
   /                        \
  /                          \
Unit (Pest unit tests) --------
```

### Test Structure

```php
<?php

declare(strict_types=1);

use Modules\Xot\Models\User;
use Spatie\QueueableAction\QueuableAction;

uses(\Illuminate\Foundation\Testing\DatabaseTransactions::class);

it('can create user', function () {
    // ✅ CORRECT - No RefreshDatabase
    // ✅ CORRECT - app() resolution
    $user = app(CreateUserAction::class)->execute([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);
    
    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('Test User');
});
```

### Running Tests

```bash
# All tests
./vendor/bin/pest

# Specific test
./vendor/bin/pest --filter="test_name"

# With coverage
./vendor/bin/pest --coverage

# Module-specific
./vendor/bin/pest Modules/Xot/tests/
```

---

## 🤖 AI Agent Integration

### BMAD-METHOD v6.2.0

This project uses BMAD-METHOD for AI-driven agile development:

- **12+ Specialized Agents**: PM, Architect, Developer, QA, UX, etc.
- **34+ Workflows**: Analysis, Solutioning, Implementation, Testing
- **Skills Architecture**: Extensible agent capabilities
- **Party Mode**: Multi-agent collaboration sessions

### Agent Roles

| Agent | Role | Expertise |
|-------|------|-----------|
| **Mary (Analyst)** | Business Analyst | Requirements, market research |
| **Winston (Architect)** | System Architect | Distributed systems, Laravel patterns |
| **Amelia (Developer)** | Senior Engineer | TDD, clean code, Laravel |
| **John (PM)** | Product Manager | PRDs, user stories, backlog |
| **Quinn (QA)** | QA Engineer | Test automation, Pest |
| **Sally (UX)** | UX Designer | User research, UI patterns |
| **Bob (SM)** | Scrum Master | Sprint planning, agile ceremonies |
| **Paige (Tech Writer)** | Technical Writer | Documentation, diagrams |

### Invoking BMAD Workflows

```bash
# Get help
bmad-help

# Start architecture workflow
bmad-create-architecture

# Generate project context
bmad-generate-project-context

# Document project
bmad-document-project
```

### Existing AI Agent Coordination

Multiple AI agents work on this codebase (Qwen, Gemini, Claude):

1. **Check** `docs/ai-agent-coordination.md` before acting
2. **Update** coordination doc after tasks
3. **Use** GitHub Issues for tracking
4. **Commit & Push** immediately after work

---

## 📚 Documentation Standards

### Module Documentation Structure

Every module MUST have:

```
Modules/{Module}/docs/
├── README.md              # Module overview
├── architecture/          # Architecture decisions
│   ├── decisions/        # ADRs
│   └── patterns/         # Design patterns
├── guides/               # How-to guides
│   ├── installation.md
│   ├── usage.md
│   └── advanced/
├── references/           # API references
│   ├── models.md
│   ├── actions.md
│   └── api.md
├── best-practices.md     # Module-specific best practices
└── troubleshooting.md    # Common issues and solutions
```

### Documentation Naming

- **Lowercase kebab-case**: `user-authentication.md` (NOT `UserAuthentication.md`)
- **No dates in filenames**: Use dates in content body only
- **Git for temporal tracking**: Commit history shows updates

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

# Check BMAD workflows
bmad-help
```

### 2. During Work

- Follow **Read → Reason → Study → Update → Improve**
- Keep changes **atomic and focused**
- **Test** as you go (TDD)
- **Document** decisions (ADRs)

### 3. Complete Work

```bash
# Review changes
git status && git diff

# Stage all
git add -A

# Commit with clear message
git commit -m "type: description"

# Push immediately
git push origin dev

# Verify
git status  # Should show "working tree clean"
```

### 4. Quality Gates

```bash
# PHPStan Level 10
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# Pint formatting
./vendor/bin/pint

# Pest tests
./vendor/bin/pest

# PHPInsights (optional)
./vendor/bin/phpinsights analyze
```

---

## 📊 Module Status

### Core Modules

| Module | Status | PHPStan | Tests | Docs |
|--------|--------|---------|-------|------|
| **Xot** | ✅ Active | Level 10 | 85% | ✅ Complete |
| **User** | ✅ Active | Level 10 | 90% | ✅ Complete |
| **Role** | ✅ Active | Level 10 | 88% | ✅ Complete |
| **Performance** | ✅ Active | Level 10 | 75% | 🟡 In Progress |
| **Ptv** | ✅ Active | Level 10 | 70% | 🟡 In Progress |

### All 42+ Modules

See: `laravel/modules_statuses.json` for complete status matrix.

---

## 🎯 BMAD Integration Points

### For New Module Development

1. **Analysis Phase** (Mary - Analyst)
   - Market research
   - Requirements gathering
   - Domain analysis

2. **Solutioning Phase** (Winston - Architect)
   - Architecture decisions
   - Technology selection
   - API design

3. **Implementation Phase** (Amelia - Developer)
   - TDD with Pest
   - Clean code
   - PHPStan Level 10

4. **Testing Phase** (Quinn - QA)
   - Unit tests
   - Integration tests
   - E2E tests

5. **Documentation Phase** (Paige - Tech Writer)
   - Module README
   - Architecture docs
   - Usage guides

### For Existing Module Improvements

1. **Discovery** (All Agents)
   - Code audit
   - Technical debt analysis
   - Performance profiling

2. **Planning** (John - PM)
   - Prioritization
   - Sprint planning
   - Story creation

3. **Execution** (Amelia + Quinn)
   - Refactoring
   - Test coverage
   - Quality improvements

4. **Validation** (Bob - SM)
   - Sprint review
   - Retrospective
   - Continuous improvement

---

## 🔗 Quick Links

### Internal Documentation

- **AI Agent Coordination**: `docs/ai-agent-coordination.md`
- **Critical Rules**: `.agents/docs/agents-guide/04-architecture/critical-rules-summary.md`
- **File Location Rules**: `docs/FILE_LOCATION_RULES.md`
- **Commit & Push Rule**: `bashscripts/docs/COMMIT_AND_PUSH_RULE.md`
- **Database Patterns**: `.agents/docs/database-patterns.md`
- **Model Rules**: `.agents/docs/laraxot-model-rules.md`

### External Resources

- **Laravel Docs**: https://laravel.com/docs
- **Filament Docs**: https://filamentphp.com/docs
- **PHPStan**: https://phpstan.org/user-guide
- **Pest**: https://pestphp.com/docs
- **BMAD-METHOD**: https://docs.bmad-method.org
- **Spatie Data**: https://spatie.be/docs/laravel-data

---

## 📈 Project Health Metrics

### Code Quality

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| PHPStan Level | 10 | 10 | ✅ |
| Test Coverage | 100% | 82% | 🟡 |
| Pint Compliance | 100% | 98% | 🟡 |
| Documentation Coverage | 100% | 75% | 🟡 |

### Development Velocity

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Sprint Velocity | 50 pts | 45 pts | 🟡 |
| Cycle Time | 3 days | 4 days | 🟡 |
| Bug Rate | <5% | 3% | ✅ |
| Technical Debt | <10% | 15% | 🔴 |

---

## 🚀 Getting Started with BMAD

### First-Time Setup

1. **Read BMAD Documentation**
   ```bash
   cat _bmad/bmm/workflows/bmad-generate-project-context/workflow.md
   ```

2. **Generate Project Context** (if needed)
   ```bash
   bmad-generate-project-context
   ```

3. **Choose Workflow**
   - New feature: `bmad-create-architecture`
   - Bug fix: `bmad-dev`
   - Documentation: `bmad-document-project`
   - Testing: `bmad-qa-generate-e2e-tests`

4. **Invoke Agent**
   ```bash
   # Example: Start architecture workflow
   bmad-create-architecture
   ```

### Common Workflows

| Workflow | Purpose | When to Use |
|----------|---------|-------------|
| `bmad-create-architecture` | Design system architecture | New modules, major features |
| `bmad-dev` | Implement features | Story execution, bug fixes |
| `bmad-qa-generate-e2e-tests` | Generate E2E tests | After implementation |
| `bmad-document-project` | Generate documentation | Module docs, guides |
| `bmad-code-review` | Review code changes | PR reviews, quality checks |
| `bmad-sprint-planning` | Plan sprint backlog | Sprint start |
| `bmad-retrospective` | Sprint retrospective | Sprint end |

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
- `bmad:` BMAD workflow integration

**Example:**
```
bmad: Integrate BMAD-METHOD v6.2.0 for AI-driven development

- Add project context for BMAD agents
- Configure workflows for Laravel module development
- Create custom skills for Filament patterns
- Update AI agent coordination with BMAD roles
- Add BMAD documentation and guides

Related: #123, #124
```

---

*This project context is auto-generated for BMAD-METHOD integration.  
Always verify with actual files and documentation.  
Last updated: 2026-03-18*
