# AGENT_MEMORY.md

> Index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Project**: PTVX Fila5 Mono

## Quick Reference

| Topic | Documentation |
|-------|------|
| Critical Rules | [.agents/docs/agents-guide/04-architecture/critical-rules-summary.md](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md) |
| Action Pattern | `app(ActionClass::class)->execute($data)` |
| Short array | `[]` - MAI `array()` |

## Key Rules

- **PHPStan Level 10** - no ignores
- **Actions** - Use `app(ActionClass::class)->execute()`
- **Workspace** - `_<module>.code-workspace` per module
- **Source code** - sempre in `app/`
- **Scripts** - in `bashscripts/`
- **Commit** - After every task

## PHPStan Status

| Module | Status |
|--------|--------|
| User | ✅ Complete |
| Xot | 🔄 In progress |
| Others | See GitHub issues |

## MCP

| Server | Purpose |
|--------|---------|
| filesystem | File ops |
| mysql | Database |
| playwright | Browser |
| git | Git ops |

→ [docs/mcp/mcp-overview.md](docs/mcp/mcp-overview.md)

---

*Full documentation: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)*
