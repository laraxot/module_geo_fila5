# AI Agents Central Hub

Entry point for all AI agents on PTVX. Docs follow **SOLID**: modular, non-redundant, interlinked.

## Abstract
PTVX uses multiple AI agents (Gemini, Claude, Qwen). All share core mandates for consistency across modular architecture.

## Shared Knowledge Base
Every agent MUST follow:
- [[Core Mandates]]: R-R-S-U, PHPStan, XotBase
- [[LLM Wiki Mandate]]: Karpathy pattern, QMD search
- [[Directory Standards]]: Organization, naming
- [[GSD & BMAD Methodologies]]: Dev frameworks

## Agent Entry Points
- [[Gemini]]: Senior engineer, strategic orchestrator
- [[Claude]]: Precision coding, refactoring
- [[Qwen]]: Local analysis, high-performance

## QMD Search (all agents)
- `qmd search "phrase"` — keyword (<1s)
- `qmd query "topic" --json` — semantic (~5s)
- `qmd multi-get "path/*.md"` — batch retrieve

Use `--json` for snippet-only. Full doc only when snippet confirms relevance.

---
**Full Index**: [[00-INDEX]]
