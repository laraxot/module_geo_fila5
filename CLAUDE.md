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

## Links

- [Claude Setup Guide](./.claude/docs/context.md)
- [Overview](./.claude/docs/overview.md)
- [Workflow](./.claude/docs/workflow.md)
- [PHPStan Guide](./.claude/docs/phpstan.md)
- [Filament Guide](./.claude/docs/filament.md)
- [MCP Guide](./.claude/docs/mcp.md)
