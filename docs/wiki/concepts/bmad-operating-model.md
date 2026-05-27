---
title: "BMAD Operating Model"
module: "ptvx-project"
type: concept
created: "2026-04-28T00:00:00Z"
updated: "2026-04-29T09:18:00Z"
qmd: "BMAD method, BMAD operating model, GSD, Ralph, project management, agile"
related:
  - "../ProjectHome.md"
  - "second-brain-operating-model.md"
  - "ai-tooling-workflow.md"
---

# BMAD Operating Model

> Project-level synthesis of how BMAD is meant to be used in this repository.

## Purpose

BMAD exists to make AI-driven development repeatable on a large modular codebase by:

- making planning artifacts explicit
- separating analysis, planning, solutioning, and implementation
- assigning specialized roles to different agent types
- producing durable artifacts that survive across sessions

In this repository, BMAD is not an optional theory layer. It is the structured path for complex, multi-step work.

## When to Use BMAD

Prefer BMAD for:

- new modules
- complex features spanning multiple files or modules
- architecture work
- epics, stories, sprint planning
- research and structured discovery

Prefer GSD or quick-dev style execution for:

- isolated bug fixes
- small refactors
- fast, well-bounded tasks

## Four-Phase Model

### Analysis

Use research and brainstorming workflows to understand the problem space before solution design.

### Planning

Create and validate PRD and UX artifacts to define what should be built and for whom.

### Solutioning

Create architecture and epics/stories to decide how the solution should be implemented.

### Implementation

Execute one story at a time through sprint planning, story creation, development, review, and optional QA automation.

## Practical Rule

The repository expects a document chain, not ad hoc execution:

`brief/research -> PRD/UX -> architecture -> epics/stories -> story context -> implementation/review`

That chain matters because each artifact becomes context for the next one.

## Relationship to the Second Brain

BMAD artifacts are not the same thing as the wiki:

- BMAD artifacts drive delivery
- wiki pages preserve stable project knowledge

When BMAD produces durable conclusions, they should be distilled into the wiki rather than left only in `_bmad-output/`.

## Claude Code (progetto, on-demand)

- **Stub skill** (leggeri): `.claude/skills/bmad/*/SKILL.md` → router [bmad-on-demand-routing](../skills/bmad-on-demand-routing.md)
- **Corpo completo** (solo se serve): `bmad-skills/bmad-v6/skills/...`
- **Slash** (solo su invocazione): `.claude/commands/bmad/` → [bmad-slash-commands](../commands/bmad-slash-commands.md)
- Reinstall: `bashscripts/tools/install-bmad-v6-project.sh`
- Dettaglio: [bmad-method-integration](../../project/bmad-method-integration.md)

## References

- [Second Brain Operating Model](second-brain-operating-model.md)
- [BMAD method integration (progetto)](../../project/bmad-method-integration.md)
- `../sources/root-bmad-docs.md`
