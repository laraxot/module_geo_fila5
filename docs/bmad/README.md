# BMAD-METHOD Integration Guide

**Version**: 1.0.0  
**Date**: 2026-03-18  
**Status**: Active  
**BMAD Version**: v6.2.0

---

## 🎯 Overview

This document describes the integration of **BMAD-METHOD v6.2.0** into the PTVX Fila5 Mono project for AI-driven agile development.

### What is BMAD-METHOD?

**BMAD-METHOD** (Breakthrough Method for Agile AI Driven Development) is a comprehensive framework for AI-driven software development featuring:

- **12+ Specialized AI Agents** (PM, Architect, Developer, QA, UX, etc.)
- **34+ Structured Workflows** (Analysis, Solutioning, Implementation, Testing)
- **Skills Architecture** for extensible capabilities
- **Party Mode** for multi-agent collaboration
- **Scale-Domain-Adaptive Intelligence**

### Why BMAD for PTVX?

| Benefit | Description |
|---------|-------------|
| **Structured AI Collaboration** | Clear agent roles prevent conflicts and duplication |
| **Agile Workflows** | Sprint planning, retrospectives, story development |
| **Quality Assurance** | Built-in code review, testing, documentation workflows |
| **Scalability** | Adapts to project complexity (42+ modules) |
| **Documentation** | Automated documentation generation and maintenance |

---

## 📦 Installation Status

### ✅ Installed Components

```yaml
BMAD-METHOD:
  Version: 6.2.0
  Install Date: 2026-03-18
  Location: _bmad/
  
Modules:
  - core (v6.2.0) ✅
  - bmm (v6.2.0) ✅  # BMad Method Module
  
IDEs:
  - Claude Code ✅
  - Cursor ✅
  - Qwen ✅
```

### Directory Structure

```
_bmad/
├── _config/                    # BMAD configuration
│   ├── agents/                # Agent configurations
│   ├── custom/                # Custom configurations
│   ├── ides/                  # IDE-specific configs
│   ├── agent-manifest.csv     # Agent registry
│   ├── manifest.yaml          # Installation manifest
│   └── workflow-manifest.csv  # Workflow registry
├── _memory/                   # Agent memory and context
│   └── tech-writer-sidecar/
│       └── documentation-standards.md
├── bmm/                       # BMad Method Module
│   ├── agents/                # Agent definitions
│   │   ├── analyst.md         # Mary - Business Analyst
│   │   ├── architect.md       # Winston - System Architect
│   │   ├── dev.md             # Amelia - Developer
│   │   ├── pm.md              # John - Product Manager
│   │   ├── qa.md              # Quinn - QA Engineer
│   │   ├── sm.md              # Bob - Scrum Master
│   │   ├── ux-designer.md     # Sally - UX Designer
│   │   └── tech-writer/       # Paige - Technical Writer
│   ├── workflows/             # 34+ workflows
│   │   ├── 1-analysis/        # Analysis workflows
│   │   ├── 3-solutioning/     # Architecture workflows
│   │   ├── 4-implementation/  # Development workflows
│   │   ├── bmad-document-project/
│   │   └── bmad-generate-project-context/
│   ├── teams/                 # Agent teams
│   ├── data/                  # Workflow data
│   └── config.yaml            # Module config
└── core/                      # Core BMAD functionality
    ├── skills/                # Custom skills
    │   ├── bmad-laravel-module-dev.md    # NEW: Laravel modules
    │   └── bmad-filament-page-dev.md     # NEW: Filament pages
    └── tasks/                 # Task definitions
```

---

## 🤖 AI Agent Configuration

### Agent Registry

| Agent | Name | Role | Expertise |
|-------|------|------|-----------|
| **analyst** | Mary 📊 | Business Analyst | Requirements, market research |
| **architect** | Winston 🏗️ | System Architect | Distributed systems, Laravel patterns |
| **dev** | Amelia 💻 | Senior Developer | TDD, clean code, Laravel |
| **pm** | John 📋 | Product Manager | PRDs, user stories, backlog |
| **qa** | Quinn 🧪 | QA Engineer | Test automation, Pest |
| **ux-designer** | Sally 🎨 | UX Designer | User research, UI patterns |
| **sm** | Bob 🏃 | Scrum Master | Sprint planning, agile ceremonies |
| **tech-writer** | Paige 📚 | Technical Writer | Documentation, diagrams |
| **quick-flow-solo-dev** | Barry 🚀 | Quick Flow Dev | Rapid implementation |

### Agent Communication Style

All BMAD agents communicate in **Italian** (project's primary language) with:

- Clear, structured responses
- Citation of sources (file paths, AC IDs)
- Actionable recommendations
- Respect for project conventions

---

## 🔄 BMAD Workflows

### Workflow Categories

#### 1. Analysis Workflows

```yaml
bmad-technical-research:
  Purpose: Research technical solutions
  Agent: Mary (Analyst)
  Output: Technical research report

bmad-domain-research:
  Purpose: Understand business domain
  Agent: Mary (Analyst)
  Output: Domain model, requirements

bmad-market-research:
  Purpose: Competitive analysis
  Agent: Mary (Analyst)
  Output: Market analysis report
```

#### 2. Solutioning Workflows

```yaml
bmad-create-architecture:
  Purpose: Design system architecture
  Agent: Winston (Architect)
  Output: ADRs, architecture diagrams
  Steps:
    - step-01-init.md
    - step-02-context.md
    - step-03-starter.md
    - step-04-decisions.md
    - step-05-patterns.md
    - step-06-structure.md
    - step-07-validation.md
    - step-08-complete.md

bmad-create-epics-and-stories:
  Purpose: Create epics and user stories
  Agent: John (PM) + Winston (Architect)
  Output: Epic documents, user stories
```

#### 3. Implementation Workflows

```yaml
bmad-dev:
  Purpose: Implement features
  Agent: Amelia (Developer)
  Output: Working code, tests
  Steps:
    - step-01-mode-detection.md
    - step-02-context-gathering.md
    - step-03-execute.md
    - step-04-self-check.md
    - step-05-adversarial-review.md
    - step-06-resolve-findings.md

bmad-code-review:
  Purpose: Review code changes
  Agent: Amelia + Quinn
  Output: Code review report

bmad-create-story:
  Purpose: Create user story implementation
  Agent: Amelia (Developer)
  Output: Implemented story
```

#### 4. Testing Workflows

```yaml
bmad-qa-generate-e2e-tests:
  Purpose: Generate E2E tests
  Agent: Quinn (QA)
  Output: E2E test suite
  Checklist: checklist.md

bmad-sprint-status:
  Purpose: Track sprint progress
  Agent: Bob (SM) + Quinn (QA)
  Output: Sprint status report
```

#### 5. Documentation Workflows

```yaml
bmad-document-project:
  Purpose: Generate project documentation
  Agent: Paige (Tech Writer)
  Output: Complete documentation
  Workflows:
    - full-scan-workflow.md
    - deep-dive-workflow.md

bmad-generate-project-context:
  Purpose: Generate BMAD project context
  Agent: Paige (Tech Writer)
  Output: project-context-ptvx.md ✅
```

---

## 🎯 Custom Skills for Laravel Development

### Skill 1: bmad-laravel-module-dev

**Purpose**: Guide AI agents through Laravel module development

**Workflow**:

```
1. Analysis (Mary)
   - Requirements gathering
   - Domain modeling
   - Integration mapping

2. Architecture (Winston)
   - Database schema design
   - API contract definition
   - ADR creation

3. Implementation (Amelia)
   - Model creation (PHPStan L10)
   - Migration generation
   - Action classes
   - Filament resources

4. Testing (Quinn)
   - Unit tests (Pest)
   - Integration tests
   - E2E tests

5. Documentation (Paige)
   - Module README
   - Architecture docs
   - Usage guides
```

**Usage**:
```bash
# Invoke via BMAD
bmad-laravel-module-dev --module=Scheda

# Reference in agent conversation
@dev Use bmad-laravel-module-dev skill
```

**Location**: `_bmad/core/skills/bmad-laravel-module-dev.md`

---

### Skill 2: bmad-filament-page-dev

**Purpose**: Guide AI agents through Filament v5 page development

**Page Types**:
- Simple custom pages
- Dashboard pages with widgets
- Multi-tab pages
- Pages with tables

**Rules**:
```yaml
Extension: XotBasePage (NEVER Filament\Pages\Page)
Translations: Auto-translated (NO hardcoded strings)
Methods: Public getTable*() methods
Override: NO table() override
```

**Location**: `_bmad/core/skills/bmad-filament-page-dev.md`

---

## 📚 Project Context

### BMAD Project Context File

**Location**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`

**Contents**:
- Project overview
- Architecture patterns
- Critical rules
- File location rules
- Testing strategy
- Documentation standards
- Module status
- Quick links

### Context Sharding

For large codebases (42+ modules), BMAD uses **document sharding**:

```
_bmad/bmm/workflows/bmad-generate-project-context/
├── project-context-ptvx.md          # Main context
├── module-contexts/                 # Per-module context
│   ├── xot-context.md
│   ├── user-context.md
│   ├── performance-context.md
│   └── ...
└── shard-index.yaml                 # Shard mapping
```

---

## 🔄 Integration with Existing AI Agents

### Current AI Agent Setup

PTVX already has multi-agent coordination:
- **Qwen** (primary)
- **Gemini** (secondary)
- **Claude** (tertiary)

### BMAD Integration

BMAD agents work **alongside** existing AI agents:

```
┌─────────────────────────────────────┐
│  Human Developer                    │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│  BMAD Orchestrator                  │
│  (Workflow Management)              │
└──────────────┬──────────────────────┘
               │
       ┌───────┴────────┐
       │                │
       ▼                ▼
┌─────────────┐  ┌─────────────┐
│ BMAD Agents │  │ Qwen/Gemini │
│ (Specialists)│  │ (Generalists)│
└─────────────┘  └─────────────┘
       │                │
       └────────┬───────┘
                │
                ▼
        ┌───────────────┐
        │  Codebase     │
        │  + Docs       │
        └───────────────┘
```

### Coordination Rules

1. **BMAD agents** handle specialized workflows (architecture, testing, docs)
2. **Qwen/Gemini** handle general development tasks
3. **All agents** follow same conventions (Laraxot, PHPStan L10)
4. **Coordination doc** updated after major tasks

---

## 🧪 Using BMAD Workflows

### Getting Started

#### 1. Read Project Context

```bash
cat _bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md
```

#### 2. Choose Workflow

Based on your task:

| Task | Workflow |
|------|----------|
| New module | `bmad-laravel-module-dev` |
| New feature | `bmad-create-architecture` → `bmad-dev` |
| Bug fix | `bmad-dev` (bug fix mode) |
| Code review | `bmad-code-review` |
| Tests | `bmad-qa-generate-e2e-tests` |
| Documentation | `bmad-document-project` |
| Sprint planning | `bmad-sprint-planning` |

#### 3. Invoke Workflow

```bash
# Example: Start architecture workflow
bmad-create-architecture

# Example: Start module development
bmad-laravel-module-dev --module=MyModule

# Example: Get help
bmad-help
```

#### 4. Follow Workflow Steps

BMAD workflows use **micro-file architecture**:

```
step-01-init.md → step-02-context.md → step-03-execute.md → ...
```

Each step:
- Self-contained instructions
- Embedded rules
- User approval required to continue
- Document state in frontmatter

---

## 📋 Workflow Examples

### Example 1: Create New Module

```bash
# 1. Start module development workflow
bmad-laravel-module-dev --module=Scheda

# 2. Mary (Analyst) gathers requirements
# Output: requirements.md

# 3. Winston (Architect) designs architecture
# Output: architecture-decisions.md, schema.sql

# 4. Amelia (Developer) implements
# - Model: Scheda.php
# - Migration: create_schede_table.php
# - Action: CreateSchedaAction.php
# - Resource: SchedaResource.php

# 5. Quinn (QA) creates tests
# Output: SchedaTest.php

# 6. Paige (Tech Writer) documents
# Output: Modules/Scheda/docs/README.md

# 7. Quality gates
phpstan analyse Modules/Scheda
./vendor/bin/pint Modules/Scheda
./vendor/bin/pest Modules/Scheda/tests/
```

### Example 2: Implement Feature

```bash
# 1. Create architecture
bmad-create-architecture

# 2. Define epics and stories
bmad-create-epics-and-stories

# 3. Implement story
bmad-dev --story="USER-123"

# 4. Code review
bmad-code-review --pr=456

# 5. Generate tests
bmad-qa-generate-e2e-tests --feature="scheda-management"
```

### Example 3: Documentation Sprint

```bash
# 1. Full scan of codebase
bmad-document-project --workflow=full-scan

# 2. Deep dive into specific modules
bmad-document-project --workflow=deep-dive --module=Performance

# 3. Generate architecture docs
bmad-document-project --target=architecture

# 4. Generate API references
bmad-document-project --target=api
```

---

## 🔧 Configuration

### BMAD Config File

**Location**: `_bmad/bmm/config.yaml`

```yaml
project_name: "PTVX Fila5 Mono"
output_folder: "_bmad/output"
planning_artifacts: true
user_name: "Development Team"
communication_language: "Italian"
document_output_language: "Italian"
user_skill_level: "Expert"
date: "2026-03-18"
```

### Customizing Agents

Agents can be customized in:

```
_bmad/_config/agents/
├── custom-dev.md       # Custom developer agent
├── custom-qa.md        # Custom QA agent
└── ...
```

### IDE Integration

BMAD works with:
- **Claude Code** ✅
- **Cursor** ✅
- **Qwen** ✅

Configuration in:
```
_bmad/_config/ides/
├── claude-code.yaml
├── cursor.yaml
└── qwen.yaml
```

---

## 📊 Quality Gates

### Pre-Commit Checklist

```markdown
## Code Quality
- [ ] PHPStan Level 10 passing
- [ ] Pint formatting applied
- [ ] No PHPMD violations

## Testing
- [ ] All tests passing (Pest)
- [ ] Coverage > 90%
- [ ] TDD followed

## Documentation
- [ ] Module README updated
- [ ] ADRs created (if needed)
- [ ] API docs updated

## BMAD Workflow
- [ ] Workflow steps completed
- [ ] Agent outputs saved
- [ ] Coordination doc updated
```

### Running Quality Gates

```bash
# PHPStan
php -d memory_limit=2G ./vendor/bin/phpstan analyse

# Pint
./vendor/bin/pint

# Tests
./vendor/bin/pest

# PHPInsights
./vendor/bin/phpinsights analyze
```

---

## 📈 Metrics & Monitoring

### Workflow Metrics

| Metric | Target | Current |
|--------|--------|---------|
| Workflow Completion Rate | 100% | - |
| Agent Response Time | < 30s | - |
| Documentation Coverage | 100% | 75% |
| Test Coverage | 100% | 82% |

### Agent Performance

Tracked in: `_bmad/_memory/agent-metrics.yaml`

---

## 🔗 References

### Internal Documentation

- **Project Context**: `_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md`
- **Laravel Skill**: `_bmad/core/skills/bmad-laravel-module-dev.md`
- **Filament Skill**: `_bmad/core/skills/bmad-filament-page-dev.md`
- **AI Coordination**: `docs/ai-agent-coordination.md`
- **Critical Rules**: `.agents/docs/agents-guide/04-architecture/critical-rules-summary.md`

### External Resources

- **BMAD-METHOD Docs**: https://docs.bmad-method.org
- **BMAD GitHub**: https://github.com/bmad-code-org/BMAD-METHOD
- **BMAD Discord**: https://discord.gg/bmad
- **Full Text Docs**: https://docs.bmad-method.org/llms-full.txt

---

## 🚀 Getting Help

### BMAD Help Skill

```bash
# General help
bmad-help

# Workflow-specific help
bmad-help "I just finished the architecture, what do I do next?"

# Laravel-specific help
bmad-help "How do I create a Laravel module?"
```

### BMAD Community

- **Discord**: Get help, share ideas, collaborate
- **GitHub Issues**: Bug reports and feature requests
- **GitHub Discussions**: Community conversations
- **YouTube**: Tutorials and masterclasses (launching Feb 2025)

---

## 📝 Changelog

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | 2026-03-18 | Initial BMAD-METHOD v6.2.0 integration |
| - | - | - Added project context file |
| - | - | - Created Laravel module dev skill |
| - | - | - Created Filament page dev skill |
| - | - | - Integrated with existing AI agents |
| - | - | - Configured workflows for PTVX |

---

*BMAD-METHOD Integration Guide v1.0.0*  
*Last Updated: 2026-03-18*
