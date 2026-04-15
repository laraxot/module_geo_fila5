# Claude Context Central

Primary context loader for the **Claude** AI agent.

## 🔗 Shared Mandates (SOLID)
Every agent MUST follow the standards in `.agents/docs/ai-agents/shared/`:
- [[Core Mandates]]: R-R-S-U sequence and quality gates.
- [[LLM Wiki Mandate]]: Karpathy pattern and QMD search.
- [[Directory Standards]]: Organization and naming.
- [[GSD & BMAD Methodologies]]: Development frameworks.

---

## Mandate: LLM Wiki
Claude MUST always follow the Karpathy LLM Wiki pattern for knowledge management. Query the wiki via `qmd_search` before research and compile findings into `docs/wiki/`.
