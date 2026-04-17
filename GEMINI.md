# Gemini Context Central

This file is the primary context loader for the **Gemini** AI agent.

## 🔗 Shared Mandates (SOLID)
Every agent MUST follow the consolidated project standards in `.agents/docs/ai-agents/shared/`:
- [[Core Mandates]]: The sacred R-R-S-U sequence and quality gates.
- [[LLM Wiki Mandate]]: Mandatory use of QMD and the Karpathy pattern.
- [[Directory Standards]]: Organization and naming conventions.
- [[GSD & BMAD Methodologies]]: Development frameworks.

---

# Gemini Added Memories
- **LLM WIKI IS THE SOURCE OF TRUTH**: I MUST always use the Karpathy LLM Wiki pattern. At the start of every task, I MUST query the module's wiki using 'qmd_search' to load compiled context.
- **PROACTIVE COMPILATION**: I MUST proactively compile new findings into 'docs/wiki/' pages.
- When approaching complex tasks, break them down and orchestrate existing skills as specialized 'sub-agents'.
- PRD STANDARD: Every module and theme must have a `PRD.md` in its `docs/` folder.
- **Rule**: BASH SCRIPTS ORGANIZATION - All `.sh` scripts MUST be placed in a subfolder of `bashscripts/`.
- **Rule**: JUNCTION/SYMLINK RULE - AI configuration folders must be symlinked to `bashscripts/ai/`.
- **Rule**: COMMIT & PUSH - When functionality is verified, always perform `git commit` and `git push`.
- YOLO MODE: Persistence and autonomy are prioritized. Complete all sub-tasks without intermediate confirmation.
