# Gemini Added Memories
- When approaching complex tasks, break them down and orchestrate existing skills as specialized 'sub-agents' following the 'Agent Teams and Skill Orchestration' guidelines documented in AGENTS.md.
- NEVER use 'git remote set-url'. This command is reserved for the project owner only.
- Always follow a forward-only Git workflow. Never revert or reset old versions; study logs for context.
- When calling Spatie Queueable Actions, always use 'app(ActionClass::class)->execute()' instead of direct method calls like 'createPersonalAccessClient()'.
- Avoid constructor Dependency Injection in Actions and Services. Prefer using the 'app()' container resolution (e.g., 'app(Dependency::class)') for dependencies.
- CRITICAL: Never replace domain-specific components like 'WorkerColumn' with generic Filament components (e.g., 'TextColumn'). Always preserve existing specialized logic, fields, and actions. This aligns with the 'Never Simplify Domain' principle.
- When invoking actions from Filament components, ensure return types and parameter passing strictly adhere to the action's signature. For actions returning StreamedResponse, explicitly return the result of the action call.

# Gemini Context

## Project Context

PTVX is a modular HR & Performance evaluation system based on Laravel + Filament + Laraxot.

## Guidelines for Gemini

- Do not extend Filament classes directly in application modules: use `XotBase*` wrappers.
- Translations must not be hardcoded in Filament components.
- Prefer Actions (e.g. Spatie Queueable Action) over Services.
- **CRITICAL RULE**: Before modifying ANY file, the mandatory sequence is: 1. **Read** the file; 2. **Reason**; 3. **Study** the context; 4. **Update and improve** the `docs/` folders within modules and themes. Only after these steps can code modifications begin.
- Use PHPStan Level 10 approach: "Fix, Don't Ignore" - all 34 modules are now 100% compliant.
- Follow module-per-module workflow: complete one module before moving to the next.
- Use MCP tools when encountering file access limitations.
- **Rule**: Every change MUST be verified with PHPStan lvl10, PHPMD, and PHPInsights.
- **Rule**: Every module MUST have exactly one `.code-workspace` file named `_<module_name_in_snake_case>.code-workspace`.
- **Rule**: Every module MUST have Semantic Versioning configured (`.releaserc.json` + workflows).
- **Rule**: GIT HEALTH - Always check for shallow clones (`git rev-parse --is-shallow-repository`) before pushing. Unshallow using `git fetch --unshallow` if needed.
- **Rule**: DOCS STANDARD - `docs/` filenames must be lowercase and date-free. Exception: `README.md`, `CHANGELOG.md` must be UPPERCASE. Use `standardize_docs.py` to fix.
- **Rule**: REGRESSION PREVENTION - Do not remove specialized columns/actions (e.g., `WorkerColumn`) without explicit instruction. Always check existing logic before refactoring.
- **Rule**: SHORT ARRAY SYNTAX - Always use `[]` in PHP files, never `array()`. The only exception is when explicitly demonstrating incorrect/deprecated usage in documentation.
- **Rule**: FILAMENT CUSTOM PAGES - Custom pages MUST extend `XotBase*` classes. Single-record edit pages follow the `$data` array + `form->fill()` + `form->getState()` pattern. For type-safe record access, use a `getSpecificRecord()` helper with explicit `instanceof` narrowing. See skill: `.agent/skills/filament-custom-pages/SKILL.md`.
- **Rule**: UNIFIED FORM PATTERN - Avoid manual Blade HTML on custom pages. Integrate header metadata and summary sections into a unified Filament form schema for better reactivity and consistency.
- **Rule**: INFOLIST FOR METADATA - Use Filament Infolists for read-only metadata on custom pages. This separates visualization (Infolist) from active interaction (Form), adhering to KISS and semantic UI principles.
- **Rule**: LARAVEL LOCALIZATION - `mcamara/laravel-localization` patterns must use `LaravelLocalization::setLocale()` in route groups. Module `Lang` owns all localization logic. See skill: `.agent/skills/laravel-localization/SKILL.md`.

## Documentation Locations

- Project docs: `docs/`
- Module docs: `laravel/Modules/{Module}/docs/`
- MCP configuration: `laravel/.mcp.json`
- Agent skills: `.agent/skills/`
- Agent workflows: `.agent/workflows/`
- Agent teams: `.agent/agent-teams.md`

## Links

- [Gemini Setup Guide](./.gemini/docs/context.md)
- [Overview](./.gemini/docs/overview.md)
- [Workflow](./.gemini/docs/workflow.md)
- [PHPStan Guide](./.gemini/docs/phpstan.md)
- [Filament Guide](./.gemini/docs/filament.md)
- [MCP Guide](./.gemini/docs/mcp.md)
- [Agent Teams](./.agent/agent-teams.md)