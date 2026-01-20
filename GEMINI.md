# Gemini Context

## Project Context

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Guidelines for Gemini

- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all 34 modules are now 100% compliant.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.
- **Rule**: Every change MUST be verified with PHPStan lvl10, PHPMD, and PHPInsights.

## Documentation Locations

- Project docs: `docs/`
- Module docs: `laravel/Modules/{Module}/docs/`
- MCP configuration: `laravel/.mcp.json`

## Links

- [Gemini Setup Guide](./.gemini/docs/context.md)
- [Overview](./.gemini/docs/overview.md)
- [Workflow](./.gemini/docs/workflow.md)
- [PHPStan Guide](./.gemini/docs/phpstan.md)
- [Filament Guide](./.gemini/docs/filament.md)
- [MCP Guide](./.gemini/docs/mcp.md)