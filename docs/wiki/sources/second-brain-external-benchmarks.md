---
title: "Second Brain External Benchmarks"
module: "ptvx-project"
type: source
created: "2026-04-29T09:19:00Z"
updated: "2026-05-19T18:30:00Z"
qmd: "second brain, llm wiki, karpathy, obsidian, qmd, wiki lint, knowledge compounding, module docs, theme docs"
related:
  - "../concepts/second-brain-operating-model.md"
  - "../concepts/second-brain-continuous-improvement.md"
  - "../concepts/llm-wiki-operational-discipline.md"
  - "../concepts/markdown-note-minimum-standard.md"
---

# Second Brain External Benchmarks

> Verified external references distilled into repository-local operating rules. Do not copy source prose into the wiki; map useful claims to local checks and workflows.

## Verified Sources Consulted

| Source | Verified takeaway for this repo |
|---|---|
| `https://github.com/NicholasSpisak/second-brain` | Useful minimal schema: `raw/`, `wiki/`, `sources/`, `concepts/`, `synthesis/`, `index.md`, `log.md`, plus ingest/query/lint skills. |
| `https://aimaker.substack.com/p/llm-wiki-obsidian-knowledge-base-andrej-karphaty` | Good framing: raw collection becomes useful only when the agent builds crosslinks and concept pages; maintenance burden should move from human bookkeeping to explicit agent workflow. |
| `https://www.mindstudio.ai/blog/andrej-karpathy-llm-wiki-obsidian-codeex-second-brain` | Warns against over-generated scaffolds; keep the architecture minimal and behavior controlled by readable markdown instructions. |
| `https://ivgraph.com/journal/second-brain-llm-notion-claude-code/` | Graph/network thinking is useful as diagnostics: isolated pages, duplicate topics, and weak links indicate wiki health problems. |
| `https://alirezarezvani.github.io/claude-skills/skills/engineering/llm-wiki/` | Treat LLM wiki work as skills: setup, ingest, query, lint, and skill chaining; add local retrieval only when the wiki grows. |
| `https://bitsofchris.com/p/an-llm-wiki-wont-compound-your-knowledge` | Important criticism: agent-written summaries do not guarantee human learning. The repo wiki must optimize operational reuse, not pretend to replace human understanding. |
| `https://techstrong.ai/features/karpathys-instructions-for-building-an-ai-driven-second-brain/` | Markdown wiki reduces repeated token cost versus rereading raw sources; open files and LLM-managed indexing are the value. |
| `https://apify.com/openclawai/second-brain-builder/api/openapi` | External automation exists, but this repo should prefer local, versioned docs/wiki + QMD unless a task explicitly needs external scraping/actors. |
| `https://hackernoon.com/ai-coding-tip-020-create-a-second-brain` | YAML front matter on every note; atomic Zettel-style pages; `related` metadata and explicit links for retrieval; local Markdown as external LLM memory — mapped locally to [`markdown-note-minimum-standard.md`](../concepts/markdown-note-minimum-standard.md). |

## Local Operating Rules

1. Keep root, module, and theme wikis small, linked, and auditable.
2. Treat `docs/raw/` as source evidence, not as an immutable/read-only fact.
3. Move durable conclusions into `docs/wiki/`; do not leave them only in chat, prompt files, or raw sources.
4. For each module/theme, keep local wiki pages scoped to that package and link back to root trigger map.
5. Use QMD for retrieval; use graph-like health checks conceptually: orphan pages, duplicate topics, stale claims, and missing source summaries.
6. Add or tighten skills when a workflow repeats; keep rules separate from procedures.
7. Do not over-generate scaffolds. A small verified wiki beats a large unmaintained one.
8. Preserve human judgment: agent synthesis is a starting point; code changes and rules still need empirical verification.

## Module/Theme Mapping

Every module/theme docs wiki should expose a compact local discipline page that points to root:

- root trigger map: `docs/wiki/rules/00-TRIGGER_MAP.md`
- on-demand rule: `docs/wiki/rules/on-demand-pattern.md`
- second brain model: `docs/wiki/concepts/second-brain-operating-model.md`
- continuous improvement: `docs/wiki/concepts/second-brain-continuous-improvement.md`
- this benchmark summary: `docs/wiki/sources/second-brain-external-benchmarks.md`

## Non-Goals

- Do not clone external templates wholesale.
- Do not add CRM/journal/productivity folders unless the repo has a concrete local workflow for them.
- Do not state that raw sources are physically immutable or read-only.
- Do not equate a dense wiki with correctness; every actionable claim still needs tests, commands, or source verification.

## References

- [Second Brain Operating Model](../concepts/second-brain-operating-model.md)
- [Second Brain Continuous Improvement](../concepts/second-brain-continuous-improvement.md)
- [LLM Wiki Operational Discipline](../concepts/llm-wiki-operational-discipline.md)
- [Markdown Note Minimum Standard](../concepts/markdown-note-minimum-standard.md)
