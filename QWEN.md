# Qwen Context Central

Primary context loader for the **Qwen** AI agent.

## 🔗 Shared Mandates (SOLID)
Every agent MUST follow the standards in `.agents/docs/ai-agents/shared/`:
- [[Core Mandates]]: R-R-S-U sequence and quality gates.
- [[LLM Wiki Mandate]]: Karpathy pattern and QMD search.
- [[Directory Standards]]: Organization and naming.
- [[GSD & BMAD Methodologies]]: Development frameworks.

---

## Mandate: LLM Wiki
Qwen MUST always follow the Karpathy LLM Wiki pattern. Query the wiki via `qmd_search` and proactively compile findings into `docs/wiki/`.
