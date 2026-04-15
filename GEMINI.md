# Gemini Context Central

This file is the primary context loader for the **Gemini** AI agent.

## 🔗 Fast Links
- [[Gemini Index]]: Abstract and agent-specific links.
- [[Shared Core Mandates]]: The fundamental rules (Mandatory Sequence, PHPStan).
- [[LLM Wiki Mandate]]: Karpathy pattern and QMD usage.
- [[Directory Standards]]: Repository conventions.
- [[GSD & BMAD Methodologies]]: Project workflows.

---

# Gemini Added Memories
- I MUST always use the Karpathy LLM Wiki pattern for knowledge management. At the start of every task, I MUST query the module's wiki using 'qmd_search' to load compiled context. I MUST proactively compile new findings into 'docs/wiki/' pages instead of leaving them in session logs.
- When approaching complex tasks, break them down and orchestrate existing skills as specialized 'sub-agents' following the 'Agent Teams and Skill Orchestration' guidelines documented in AGENTS.md.
- PRD STANDARD: Every module and theme must have a `PRD.md` in its `docs/` folder.
- PRD STRUCTURE: A standard PRD must include: Executive Summary, Target Personas (including Internal Developers), Functional Requirements, Service Interface (The Contract), System Architecture & Dependencies, Non-Functional Requirements (SLA, Observability, Security), and Release Criteria.
- PRD FOR MODULAR SYSTEMS: Focus on Service Boundaries (Domain-Driven Design), Data Ownership (Source of Truth), and "Contract-First" requirements (API/Event schemas).
- NEVER use 'git remote set-url'. This command is reserved for the project owner only.
- Always follow a forward-only Git workflow. Never revert or reset old versions; study logs for context.
- When calling Spatie Queueable Actions, always use 'app(ActionClass::class)->execute()' instead of direct method calls like 'createPersonalAccessClient()'.
- Avoid constructor Dependency Injection in Actions and Services. Prefer using the 'app()' container resolution (e.g., 'app(Dependency::class)') for dependencies.
- CRITICAL: Never replace domain-specific components like 'WorkerColumn' with generic Filament components (e.g., 'TextColumn'). Always preserve existing specialized logic, fields, and actions. This aligns with the 'Never Simplify Domain' principle.
- When invoking actions from Filament components, ensure return types and parameter passing strictly adhere to the action's signature. For actions returning StreamedResponse, explicitly return the result of the action call.
- LARAVEL BOOST & SKILLS: Use `php artisan boost:add-skill <owner/repo>` to install skills from https://skills.laravel.cloud/.
- **Rule**: PHPSTAN LEVEL 10 DYNAMIC RELATIONSHIPS - When defining dynamic Eloquent relationships (like `scheda()` in `Ptv` module), always resolve the model class string with a fallback to the base model (e.g., `Modules\Progressioni\Models\Scheda`) and use `Webmozart\Assert\Assert::classExists($modelClass)` for type narrowing.
- **Rule**: ISSUE & DISCUSSION COORDINATION - Track all PHPStan Level 10 fixes via module-specific GitHub Issues (IDs #85-100) and link them to the central coordination Discussion #84. Every commit must reference the relevant issue.
- **Rule**: Every module and theme MUST have exactly one `.code-workspace` file named `_<module_name_in_snake_case>.code-workspace` (e.g., `laravel/Modules/Xot/_xot.code-workspace`). Any misplaced files (like `_activity.code-workspace` in `Xot`) must be deleted immediately.
- **Rule**: BASH SCRIPTS ORGANIZATION - All `.sh` scripts MUST be placed in a subfolder of `bashscripts/` (e.g., `bashscripts/ai/`), NEVER in the root. Every script must be documented in `bashscripts/docs/`.
- **Rule**: JUNCTION/SYMLINK RULE - Centralize AI agent configuration folders (like `.qwen`) in `bashscripts/ai/` and create symbolic links (junctions) to the project root and `laravel/` folder to ensure multi-agent synchronization.
- **Rule**: COMMIT & PUSH - When functionality is verified, always perform `git commit` and `git push` to synchronize changes globally.
- **Rule**: ENVIRONMENT-AWARE SCRIPTS - All synchronization and deployment scripts (especially `sync_remote_repo.sh`) MUST detect the environment (`CLI` vs. `GitHub Actions`) and adapt their behavior (e.g., skip interactive prompts, use tokens instead of SSH, skip local backups in CI). Coordination is managed via Issue #109.
- YOLO MODE: Persistence and autonomy are prioritized. Complete all sub-tasks through an iterative Plan -> Act -> Validate cycle without intermediate confirmation for atomic steps.
