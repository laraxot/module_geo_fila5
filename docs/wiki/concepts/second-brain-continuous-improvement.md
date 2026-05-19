---
title: "Second Brain Continuous Improvement"
module: "ptvx-project"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T10:32:00Z"
qmd: "continuous improvement, wiki maintenance, docs ingest, token efficiency, actionability, progressive compression"
related:
  - "second-brain-operating-model.md"
  - "bmad-operating-model.md"
  - "ai-tooling-workflow.md"
  - "second-brain-maintenance-cadence.md"
---

# Second Brain Continuous Improvement

> A maintenance playbook for keeping repository knowledge useful, current, and easy to retrieve.

## Purpose

The project already has a Karpathy-style wiki scaffold. The next maturity step is not more scaffolding, but a repeatable loop that improves signal density every time an agent touches documentation.

This page defines that loop for root, module, and theme `docs/` trees.

## Principles

- Actionability first: organize and summarize knowledge so it helps the current or next project move.
- Progressive compression: every pass should reduce ambiguity, duplication, or retrieval cost.
- Local ownership: persist knowledge in the nearest useful wiki, then escalate to the project wiki only when the concept is cross-cutting.
- Auditability: every non-trivial documentation action leaves a trace in `docs/wiki/log.md`.

## Operating Loop

1. Start from the relevant `docs/wiki/` page if it exists.
2. Read only the raw `docs/` cluster needed for the task.
3. Extract durable knowledge:
   - concepts and rules
   - source summaries
   - module or theme specific caveats
   - unresolved questions worth tracking
4. Update or create the nearest wiki page.
5. Update that wiki's `index.md`.
6. Append an entry to that wiki's `log.md`.
7. If the finding is cross-module or cross-theme, also persist it in the root `docs/wiki/`.

## `/bmad-create-story` Integration Rule

When a request triggers story creation, the sequence is:

1. retrieve from nearest wiki node first (root/module/theme)
2. ingest only missing evidence from raw docs and external benchmark sources
3. distill to one story artifact in `_bmad-output/implementation-artifacts/`
4. back-propagate durable conclusions to wiki pages
5. append operation in relevant `log.md` files

This keeps BMAD delivery and second-brain memory synchronized.

## Execution Checkpoints

Before starting implementation work:

1. open nearest wiki node (root/module/theme)
2. verify whether an equivalent topic already exists
3. collect only missing evidence from raw docs and external sources

After completing implementation work:

1. update nearest wiki concept/source page
2. update nearest `index.md`
3. append nearest `log.md`
4. promote only cross-cutting findings to root wiki

This enforces continuous update/study/improvement of module and theme `docs` without creating redundant documents.

## External Benchmark Policy

External research is allowed only if converted into repository-local rules with explicit mapping:

- **CODE** -> capture selective insights, organize by actionability, distill on touch, express as delivery artifacts
- **Progressive summarization** -> compress touched pages to lower retrieval cost
- **LLM wiki compounding** -> favor incremental curated wiki growth over repeated ad hoc rediscovery

Reference page: `../sources/second-brain-external-benchmarks.md`.

## Routing Rules

Use the root wiki when the finding affects repository-wide architecture, AI workflow, BMAD process, or documentation governance.

Use module wiki pages when the knowledge is bounded to one module's code, APIs, business rules, or implementation constraints.

Use theme wiki pages when the knowledge is bounded to presentation, UX, frontend assets, view composition, or product-copy behavior inside one theme.

## Federated Pilot Anchors

Active pilot pages that implement the same loop locally:

- User module: `../../../laravel/Modules/User/docs/wiki/concepts/user-module-operating-focus.md`
- Theme One: `../../../laravel/Themes/One/docs/wiki/concepts/theme-one-operating-focus.md`

These anchors make root-to-local traversal explicit and reduce repeated discovery cost.

## Minimum Quality Checks

Every documentation improvement pass should check for these failure modes:

- duplicated topics with diverging guidance
- pages present in `docs/` but absent from the nearest wiki summaries
- wiki pages not linked from `index.md`
- stale claims that should be re-verified before reuse
- temporary analyses that should either be promoted to stable knowledge or left clearly archival

## Skill And Rule Improvement Loop

When improving on-demand rules or skills:

1. Search first with `qmd search "rule:<topic>" --limit 5` or `qmd search "skill:<topic>" --limit 5`.
2. Tighten existing pages before creating new ones.
3. Separate constraints from procedures: rules say what must hold; skills say how to act.
4. Keep indexes short and route-only.
5. Add verification steps to skills and failure modes to rules.
6. Promote only cross-cutting triggers to the root trigger map.
7. Log the decision in the nearest `docs/wiki/log.md`.

## Definition of Done for a Good Ingest

An ingest is good enough when:

- the next agent can find the result from `index.md`
- the result states where the source truth came from
- the result removes at least one retrieval or interpretation step for future work
- the operation is visible in `log.md`
- rule/skill routing is updated when a new reusable behavior is introduced
- every added "verified link" was checked as an existing local path or retrievable QMD document

## References

- [Second Brain Operating Model](second-brain-operating-model.md)
- [BMAD Operating Model](bmad-operating-model.md)
- [AI Tooling Workflow](ai-tooling-workflow.md)
- [Second Brain Maintenance Cadence](second-brain-maintenance-cadence.md)
