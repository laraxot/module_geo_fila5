# Claude Context

## Project Context

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Guidelines for Claude

- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all errors must be resolved.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.

## Documentation Locations

- Project docs: `docs/`
- Module docs: `laravel/Modules/{Module}/docs/`
- **Bashscripts docs: `bashscripts/docs/`** (centralized - NEVER create docs/ subfolders inside bashscripts subdirectories)
- MCP configuration: `laravel/.mcp.json`
- GitHub workflows: `.github/workflows/`

<<<<<<< HEAD
=======
## Agent Teams (Experimental - Opus 4.6)

Agent Teams allows multiple Claude Code instances to work in parallel on different tasks within the same project.

### How to Enable
Enabled via `CLAUDE_CODE_EXPERIMENTAL_AGENT_TEAMS=1` in `.claude/settings.local.json` env.

### Recommended Team Structures for PTVX

**Quality Team** (3 teammates):
- PHPStan Specialist: `phpstan analyse Modules/{Module} --level=10`
- Test Runner: `./vendor/bin/pest Modules/{Module}/tests`
- Code Formatter: `./vendor/bin/pint Modules/{Module}`

**Module Development Team** (3 teammates):
- Code Lead: implements features following XotBase patterns
- Test Writer: writes Pest tests for new functionality
- Docs Updater: updates module `docs/` after changes

**Review Team** (3 teammates):
- Security Reviewer: checks OWASP, SQL injection, XSS
- Performance Reviewer: queries, N+1, caching
- Test Reviewer: coverage, edge cases

### Usage
```bash
# Start with agent teams enabled
claude --agent-teams

# Or use worktree mode for parallel git operations
claude --worktree
```

### Important Rules for Teammates
- Each teammate respects module boundaries
- Use XotBase wrappers, never extend Filament directly
- All PHPStan errors must be fixed (Level 10)
- Coordinate via git to avoid file conflicts

>>>>>>> ac0ea089 (.)
## Links

- [Claude Setup Guide](./.claude/docs/context.md)
- [Overview](./.claude/docs/overview.md)
- [Workflow](./.claude/docs/workflow.md)
- [PHPStan Guide](./.claude/docs/phpstan.md)
- [Filament Guide](./.claude/docs/filament.md)
- [MCP Guide](./.claude/docs/mcp.md)
<<<<<<< HEAD
=======
- [Agent Teams Guide](./docs/agent-teams-guide.md)
>>>>>>> ac0ea089 (.)
