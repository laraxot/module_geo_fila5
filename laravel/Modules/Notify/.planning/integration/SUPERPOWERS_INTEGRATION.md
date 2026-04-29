# 🤖 Superpowers Integration Guide

**Date**: 2026-03-30  
**Framework**: Superpowers for AI Agents  
**NOT a Laravel Package**

---

## 📋 What Is Superpowers?

**Superpowers** is **NOT** a Laravel package - it's an **AI agent workflow framework** that works with AI coding assistants like:
- Claude Code
- Cursor
- Codex
- OpenCode

**Key Concept**: Instead of jumping straight into code, the agent:
1. Asks what you're really trying to build
2. Creates a spec in digestible chunks
3. Builds an implementation plan (2-5 minute tasks)
4. Executes via subagent-driven development with reviews

---

## 🎯 Installation (For AI Agents)

### Claude Code (Official)
```bash
/plugin install superpowers@claude-plugins-official
```

### Cursor
```bash
/add-plugin superpowers
# Or search "superpowers" in marketplace
```

### Codex
```bash
# Fetch instructions from:
https://raw.githubusercontent.com/obra/superpowers/refs/heads/main/.codex/INSTALL.md
```

### OpenCode
```bash
# Fetch instructions from:
https://raw.githubusercontent.com/obra/superpowers/refs/heads/main/.opencode/INSTALL.md
```

### Verify Installation
Ask the agent: "help me plan this feature"

The agent should automatically invoke relevant skills.

---

## 🔧 Using Superpowers for Laravel Blade Development

### Workflow for Blade Component Development

When working on Laravel/Blade projects with Superpowers:

```
1. Agent creates design spec for your Blade component
2. Agent writes Pest tests first (tests/Feature/Components/)
3. Agent creates Blade component (resources/views/components/)
4. Agent runs tests (php artisan test)
5. Agent requests code review before merging
```

### Example Session Flow

**You**: "Help me create a reusable alert component for Laravel Blade"

**Agent (with Superpowers)**:
1. Asks clarifying questions (types, styles, dismissible?)
2. Presents design spec for approval
3. Creates implementation plan with specific file paths
4. Executes tasks with TDD (tests → Blade → CSS)
5. Reviews code before completion

---

## 🎨 Skills Library

### Testing Skills
- **test-driven-development** - RED-GREEN-REFACTOR cycle
- Write Pest/PHPUnit tests first, then implement

### Debugging Skills
- **systematic-debugging** - Process over guessing
- **verification-before-completion** - Verify before declaring success

### Collaboration Skills
- **brainstorming** - Refine component design through questions
- **writing-plans** - Break component work into tasks
- **executing-plans** - Execute planned tasks
- **dispatching-parallel-agents** - Multiple agents working simultaneously
- **requesting-code-review** - Review Blade components against Laravel best practices
- **using-git-worktrees** - Work on components in isolated branches

### Meta Skills
- **writing-skills** - Create new skills
- **using-superpowers** - Use Superpowers itself

---

## 📐 Core Philosophy

| Principle | Description |
|-----------|-------------|
| **Test-Driven Development** | Write tests first, always |
| **Systematic over ad-hoc** | Process over guessing |
| **Complexity reduction** | Simplicity as primary goal |
| **Evidence over claims** | Verify before declaring success |

---

## 🚀 Integration with FixCity Project

### How to Use

1. **Install Superpowers** for your AI agent platform
2. **Start a new session** in your chosen platform
3. **Skills trigger automatically** when relevant
4. **Agent follows the workflow** without special commands

### Example: Creating Homepage Components

**You**: "Create homepage components matching Design Comuni"

**Agent with Superpowers**:

#### Step 1: Brainstorming
```
Questions:
- Which sections from Design Comuni do you want?
- Do you need Top Bar, Header, Navigation?
- Should we include Government Bodies section?
- What about Feedback and Contact sections?
```

#### Step 2: Design Spec
```markdown
## Homepage Components Spec

### Components to Create
1. Top Bar (region + language)
2. Header Enhanced (logo + search + social + login)
3. Main Navigation (menu with submenus)
4. Government Bodies (3 cards)
5. Thematic Sites (3 cards)
6. Feedback Section (5-star rating)
7. Contact Section (options + links)

### File Structure
- resources/views/components/blocks/top-bar.blade.php
- resources/views/components/blocks/header-enhanced.blade.php
...
```

#### Step 3: Implementation Plan
```markdown
## Tasks

1. Create `top-bar.blade.php` (5 min)
   - Region name display
   - Language switcher (ITA/ENG)
   - Bootstrap Italia styling

2. Create `header-enhanced.blade.php` (10 min)
   - Logo + City name + Tagline
   - Search bar
   - Social links
   - Login button

... (more tasks)
```

#### Step 4: Execution with TDD
```bash
# For each component:
1. Write Pest test
2. Create Blade component
3. Run tests
4. Fix issues
5. Review
```

#### Step 5: Code Review
```markdown
## Code Review Checklist

- [ ] Component follows Laravel Blade conventions
- [ ] Uses Bootstrap Italia classes
- [ ] Responsive design implemented
- [ ] Accessibility (ARIA labels)
- [ ] Tests passing
```

---

## 📚 Repository Structure

```
obra/superpowers/
├── skills/          # All skill definitions
├── commands/        # Agent commands
├── docs/            # Documentation
├── tests/           # Skill tests
└── .cursor-plugin/  # Platform-specific configs
```

---

## 🔗 Quick Reference

| Action | Command |
|--------|---------|
| Install (Claude) | `/plugin install superpowers@claude-plugins-official` |
| Install (Cursor) | `/add-plugin superpowers` |
| Update | `/plugin update superpowers` |
| Verify | Ask "help me plan this feature" |
| Community | [Discord](https://discord.gg) |
| Issues | https://github.com/obra/superpowers/issues |

---

## ✅ Benefits for FixCity

### With Superpowers

- ✅ **Structured approach** to component creation
- ✅ **Test-driven development** for all components
- ✅ **Code review** before completion
- ✅ **Parallel agents** for faster development
- ✅ **Clear documentation** of decisions

### Without Superpowers

- ❌ Ad-hoc development
- ❌ No systematic testing
- ❌ No formal review process
- ❌ Sequential work only

---

## 🎯 Next Steps

1. **Install Superpowers** for your AI agent
2. **Start session** with "Help me improve the FixCity homepage"
3. **Follow the workflow** (spec → plan → execute → review)
4. **Enjoy structured development**!

---

**Status**: ✅ **DOCUMENTED**  
**Type**: AI Agent Framework (NOT Laravel package)  
**Integration**: Automatic via AI agent plugins

**Superpowers guide complete! 🤖🚀**
