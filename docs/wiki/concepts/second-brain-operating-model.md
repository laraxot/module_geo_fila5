---
title: "Second Brain Operating Model"
module: "ptvx-project"
type: concept
created: "2026-04-28T00:00:00Z"
updated: "2026-05-21T12:00:00Z"
qmd: "second brain, Karpathy wiki, LLM wiki, docs/wiki, raw docs, QMD search strategy, token efficiency"
related:
  - "../ProjectHome.md"
  - "module-structure.md"
  - "actions-over-services.md"
  - "second-brain-continuous-improvement.md"
  - "markdown-note-minimum-standard.md"
---

# Second Brain Operating Model

> A practical operating model for turning the repository documentation into a durable, queryable project memory.

## Definition

In this project, a "second brain" is not just a notes folder. It is the combination of:

- raw documentation in `docs/` folders
- compiled wiki knowledge in adjacent `docs/wiki/` folders
- append-only operational history in `docs/wiki/log.md`
- schema rules in `docs/wiki/SCHEMA.md`

This follows the Karpathy-style LLM wiki pattern already initialized by Story 1.1.

## Why It Exists

The repository contains a large amount of useful documentation across root, modules, and themes, but it is uneven:

- some areas are curated and current
- some areas contain duplicate files with different naming conventions
- some areas mix roadmap, troubleshooting, architecture, and temporary analysis notes

The second brain exists to compile those scattered materials into stable knowledge pages that agents can query before changing code.

## Reality Discipline

The wiki must not invent permanence or permissions. Raw docs are source evidence and should be changed only with care, but they are not assumed immutable or read-only unless the filesystem or repository policy proves it.

## Repository Mapping

| Layer | Purpose | Primary Paths |
|---|---|---|
| Raw docs | Source evidence to treat conservatively; not guaranteed read-only | `docs/`, `laravel/Modules/*/docs/`, `laravel/Themes/*/docs/` |
| Compiled wiki | Synthesized knowledge for fast reuse | `docs/wiki/`, `laravel/Modules/*/docs/wiki/`, `laravel/Themes/*/docs/wiki/` |
| Log | Operational audit trail | `**/docs/wiki/log.md` |
| GitHub issues (complementare) | Thread decisionali navigabili; non sostituiscono la wiki | [`github-issue-agent-discipline.md`](../how-to/github-issue-agent-discipline.md) |
| Schema | Local documentation conventions | `**/docs/wiki/SCHEMA.md` |

## Operating Rules

1. Read the relevant wiki first before exploring raw docs.
2. Use raw docs as sources, not as the final answer surface.
3. Persist any non-trivial conclusion back into a wiki page.
4. Update the nearest wiki:
   - project-wide knowledge goes in `docs/wiki/`
   - module-specific knowledge goes in `laravel/Modules/{Module}/docs/wiki/`
   - theme-specific knowledge goes in `laravel/Themes/{Theme}/docs/wiki/`
5. Treat duplicate raw documents as a signal to synthesize, not to copy. Batch dedup: [`module-docs-deduplication.md`](../how-to/module-docs-deduplication.md).
6. **GitHub issues (proattivo):** prima di implementare, cercare issue esistenti (`gh issue list --search`); se l’argomento non è coperto, **creare** l’issue senza chiedere permesso all’utente; a fine lavoro commentare o chiudere. Policy: [`github-issue-agent-discipline.md`](../how-to/github-issue-agent-discipline.md).
7. **Git branch (agenti):** non creare né cambiare ramo — solo l’utente; lavorare su `dev` (o branch indicato). [`git-branch-policy-agents.md`](../memories/git-branch-policy-agents.md).

## External Principles Adopted

The current project model keeps the Karpathy LLM Wiki as the core persistence layer and adopts three complementary principles from broader second-brain practice:

- organize by actionability, not by abstract subject alone
- compress notes opportunistically every time they are touched
- optimize for discoverability and future reuse instead of exhaustive raw accumulation

For this repository, that means `docs/wiki/` is not a passive archive. It is a maintained working surface that should make the next engineering task faster.

Letteratura esterna, tutorial Obsidian/Karpathy e link curati (orientamento, non policy): [`../sources/second-brain-external-benchmarks.md`](../sources/second-brain-external-benchmarks.md).

## QMD Search Strategy (2026 Optimization)

Every agent MUST follow this search hierarchy:

| Task | Command | Speed | When to use |
|------|----------|-------|------------|
| Known identifiers | `qmd search "exact phrase"` | <1s | File names, class names, exact keywords |
| Concept search | `qmd query "topic" --json -n 10` | ~5s | Semantic understanding, "how does X work" |
| Batch retrieve | `qmd multi-get "path/*.md"` | instant | Already know which files |
| Verify index | `qmd status` | instant | Before large research tasks |

**Critical:** Use `--json` flag for snippet-only results. Full document retrieval only when snippet confirms relevance. Saves 80-95% tokens.

**QMD Context Descriptions:** Every collection in `.qmd-collection.json` MUST have a `description` field with:
- What the collection contains
- Key topics covered
- Typical query patterns

Run `qmd embed` after updating context descriptions to re-index with improved semantic matching.

## Excellence Standard

**Formato file:** ogni nuova o revisione sostanziale di `.md` nella wiki segue il [Markdown Note Minimum Standard](./markdown-note-minimum-standard.md) (YAML front matter + atomicità + link motivati), allineato a HackerNoon *AI Coding Tip 020*.

"Perfect" documentation in this repository means operationally excellent, not verbose. A page is excellent when it is:

- **Findable**: reachable from trigger map, index, or QMD query.
- **Scoped**: root, module, theme, or tooling ownership is clear.
- **Atomic**: one durable idea or workflow per page.
- **Actionable**: states what to do, when to do it, and how to verify it.
- **Auditable**: source paths and `log.md` entry exist.
- **Low-token**: examples are trimmed unless they are essential to correctness.

## Continuous Maintenance Loop

Each meaningful documentation pass should follow this loop:

1. query the nearest relevant wiki before opening raw docs
2. inspect the raw `docs/` cluster that is most relevant to the active task
3. distill the useful result into a concept, source, or module/theme summary page
4. update `index.md` so the new knowledge is discoverable
5. append the operation to `log.md`
6. leave behind a tighter structure than the one that was found
7. verify new or changed links with filesystem checks or QMD retrieval
8. update QMD after structural wiki changes

This is the minimum cycle required to keep the second brain compounding instead of decaying.

## Current Findings

- Root `docs/` is broad and historically layered, containing architecture, AI workflows, PHPStan guidance, scripts, backups, and duplicated filename variants.
- Module docs are inconsistent in maturity; some modules contain extensive analysis archives while others mainly expose base scaffolding.
- Theme docs are richer than average and already include wiki bootstrap pages, but still show mixed naming and repeated topics.

## Next Actions

- Build source-summary pages for the highest-value docs clusters.
- Normalize recurring concepts into stable wiki pages instead of leaving them only in raw markdown.
- Promote repeated chat/prompt workflows into skill pages with verification steps.
- Keep `00-TRIGGER_MAP.md` aligned with new cross-cutting rules and skills.
- Add recurring health checks for stale, duplicate, orphaned, oversized, and non-indexed documentation nodes.
- Apply the same maintenance loop to module and theme `docs/` trees, not only to root documentation.

## References

- [Markdown Note Minimum Standard](./markdown-note-minimum-standard.md)
- [Project Home](../ProjectHome.md)
- [Module Structure](module-structure.md)
- [Second Brain Continuous Improvement](second-brain-continuous-improvement.md)
- `../sources/docs-landscape-modules-and-themes.md`
