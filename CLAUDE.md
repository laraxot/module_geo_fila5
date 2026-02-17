# Claude Context

## Project Context

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Guidelines for Claude

- **ALWAYS use short array syntax `[]`** - NEVER use `array()` in PHP files.
- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services - call via `app(ActionClass::class)->execute()`.
- **NEVER use constructor DI** - use `app(ActionClass::class)->execute()` pattern instead.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all errors must be resolved.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.
- **New packages go in module `composer.json`**, never in `laravel/composer.json`. Run `composer go` from `laravel/` to merge.
- **NEVER run `git remote set-url`** - only the project owner does this.
- **Git goes forward only** - never restore old versions. Study git logs, but don't revert.

## Documentation Locations

- Project docs: `docs/`
- Module docs: `laravel/Modules/{Module}/docs/`
- **Bashscripts docs: `bashscripts/docs/`** (centralized - NEVER create docs/ subfolders inside bashscripts subdirectories)
- MCP configuration: `laravel/.mcp.json`
- GitHub workflows: `.github/workflows/`

## Agent Teams (Experimental - Opus 4.6)

Agent Teams coordinate multiple Claude Code instances working together. One session acts as the **team lead** (coordinates, assigns tasks, synthesizes results) while **teammates** work independently in their own context windows and communicate directly with each other.

### How to Enable

Add to `.claude/settings.local.json`:
```json
{
  "env": {
    "CLAUDE_CODE_EXPERIMENTAL_AGENT_TEAMS": "1"
  }
}
```

### Display Modes

- **in-process** (default): all teammates run inside main terminal. Use `Shift+Up/Down` to select teammates.
- **split-pane**: each teammate gets its own tmux/iTerm2 pane. Set `"teammateMode": "tmux"` in settings.

### Delegate Mode

Press `Shift+Tab` to enable delegate mode: the lead only coordinates (spawn, message, manage tasks) without touching code directly.

### Hooks for Quality Gates

- **`TeammateIdle`**: runs when a teammate is about to go idle. Exit code 2 sends feedback and keeps teammate working.
- **`TaskCompleted`**: runs when a task is being marked complete. Exit code 2 prevents completion with feedback.

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

**Localization Team** (2 teammates):
- Translation Validator: checks all modules have complete lang files (it/en/de)
- Route Localizer: verifies mcamara/laravel-localization integration in routes

**Custom Pages Team** (2 teammates):
- Page Implementer: creates custom Filament pages extending XotBasePage
- View Builder: creates Blade views with `filament-panels::page` components

### Best Practices

- **Size tasks appropriately**: 5-6 tasks per teammate keeps everyone productive
- **Avoid file conflicts**: break work so each teammate owns different files
- **Give enough context**: teammates don't inherit lead's conversation history
- **Start with research**: begin with review/research tasks before implementation
- **Wait for teammates**: tell lead "Wait for your teammates to complete their tasks before proceeding"

### Limitations

- No session resumption with in-process teammates (`/resume` won't restore them)
- One team per session, no nested teams
- Teammates cannot spawn their own teams
- Split panes require tmux or iTerm2

### Important Rules for Teammates
- Each teammate respects module boundaries
- Use XotBase wrappers, never extend Filament directly
- All PHPStan errors must be fixed (Level 10)
- Coordinate via git to avoid file conflicts
- Translations never hardcoded - use `trans()` keys

## Links

- [Claude Setup Guide](./.claude/docs/context.md)
- [Overview](./.claude/docs/overview.md)
- [Workflow](./.claude/docs/workflow.md)
- [PHPStan Guide](./.claude/docs/phpstan.md)
- [Filament Guide](./.claude/docs/filament.md)
- [MCP Guide](./.claude/docs/mcp.md)
- [Agent Teams Guide](./docs/agent-teams-guide.md)
