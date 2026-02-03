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
- **Rule**: Every module MUST have exactly one `.code-workspace` file named `_<module_name_in_snake_case>.code-workspace`.
- **Rule**: Every module MUST have Semantic Versioning configured (`.releaserc.json` + workflows).
- **Rule**: GIT HEALTH - Always check for shallow clones (`git rev-parse --is-shallow-repository`) before pushing. Unshallow using `git fetch --unshallow` if needed.
- **Rule**: DOCS STANDARD - `docs/` filenames must be lowercase and date-free. Exception: `README.md`, `CHANGELOG.md` must be UPPERCASE. Use `standardize_docs.py` to fix.
- **Rule**: REGRESSION PREVENTION - Do not remove specialized columns/actions (e.g., `WorkerColumn`) without explicit instruction. Always check existing logic before refactoring.

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