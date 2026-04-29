# 🤖 Superpowers Plugin Installation

**Date**: 2026-03-30  
**Platform**: AI Agent (Claude Code / Cursor)  
**Status**: 🟡 INSTALLING

---

## 📋 What is Superpowers?

Superpowers is an AI agent workflow framework that provides:
- Structured planning
- Test-driven development
- Code review automation
- Subagent-driven development

**Repository**: https://github.com/obra/superpowers

---

## 🔧 Installation Steps

### For Claude Code

```bash
/plugin install superpowers@claude-plugins-official
```

### For Cursor

```bash
/add-plugin superpowers
```

### Verification

After installation, ask the agent:
```
"Help me plan a feature"
```

The agent should automatically invoke Superpowers skills.

---

## 🎯 Skills Available

| Skill | Purpose |
|-------|---------|
| **brainstorming** | Refine requirements through questions |
| **writing-plans** | Create implementation plans |
| **test-driven-development** | RED-GREEN-REFACTOR cycle |
| **systematic-debugging** | Process-driven debugging |
| **requesting-code-review** | Automated code review |
| **using-git-worktrees** | Isolated development branches |
| **subagent-driven-development** | Parallel agent execution |

---

## 📐 Integration with FixCity

### Workflow Example

```
User: "Complete homepage matching to 100%"

Superpowers Flow:
1. Brainstorming - Ask clarifying questions
   - What sections are missing?
   - What visual differences exist?
   - What accessibility requirements?

2. Writing Plans - Create implementation plan
   - Task 1: Capture screenshots
   - Task 2: Compare layouts
   - Task 3: Fix differences
   - Task 4: Accessibility audit
   - Task 5: Performance test

3. Test-Driven Development
   - Write visual regression tests
   - Implement fixes
   - Run tests
   - Refactor

4. Code Review
   - Review CSS changes
   - Review component changes
   - Verify accessibility
   - Approve merge

5. Completion
   - Update documentation
   - Store in OpenViking
   - Mark tasks complete
```

---

## ✅ Installation Checklist

- [ ] Install Superpowers plugin
- [ ] Verify installation
- [ ] Test with simple task
- [ ] Configure for FixCity project
- [ ] Integrate with OpenViking
- [ ] Document workflow

---

## 🔗 Related Tools

| Tool | Status | Integration |
|------|--------|-------------|
| **OpenViking** | ✅ Installed | Context storage |
| **BMAD** | ✅ Cloned | Architecture |
| **GSD** | ✅ Cloned | Phase execution |
| **Ralph Loop** | ✅ Cloned | Implementation |
| **NotebookLM MCP** | ⚪ Pending | Research |

---

**Next**: Install plugin and verify
