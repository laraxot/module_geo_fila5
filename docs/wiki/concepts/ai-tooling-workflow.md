---
title: "AI Tooling Workflow"
module: "ptvx-project"
type: concept
created: "2026-04-28T00:00:00Z"
updated: "2026-04-29T09:18:00Z"
qmd: "AI tooling, Claude, Gemini, Qwen, shared workflow, MCP servers, agents"
related:
  - "../ProjectHome.md"
  - "bmad-operating-model.md"
  - "second-brain-operating-model.md"
---

# AI Tooling Workflow

> Shared operating rules distilled from the root `docs/ai/` cluster.

## Shared Workflow

Across Claude Code, Gemini Code Assist, and iFlow CLI, the repeated workflow is:

1. study docs before changing code
2. work module by module
3. verify continuously with quality tools
4. update documentation after significant changes

The tools differ in interaction model, but the expected engineering behavior is the same.

## Stable Rules

### Docs First

- Read root docs and module docs before implementation.
- Understand business logic and architecture before proposing changes.
- The AI tool is expected to consume project context, not improvise from framework defaults.

### Module-by-Module Execution

- Complete one module cleanly before moving to the next.
- Use module-local docs to track roadmaps, fixes, and rationale.
- Avoid broad repo-wide edits when the problem is module-scoped.

### Continuous Verification

- PHPStan is a primary verification step.
- Additional quality tools such as PHPMD and related checks are part of the expected workflow.
- Verification is not a final afterthought; it is repeated during the change cycle.

### Documentation Is Part of the Work

- Important fixes must update docs, not just code.
- AI sessions should leave durable traces in the repository.
- This aligns directly with the second-brain model: chat is transient, wiki is persistent.

## Tool-Specific Differences

### Claude Code

- positioned for deep code analysis, guided refactoring, and MCP-assisted workflows

### Gemini Code Assist

- adds agent-mode planning, context-drawer scoping, and custom-command ergonomics

### iFlow CLI

- emphasizes terminal execution modes and automation-oriented workflows

## Practical Consequence

The project should maintain shared workflow rules at the wiki layer, while tool-specific docs remain implementation detail and operator guidance.

## References

- [Second Brain Operating Model](second-brain-operating-model.md)
- `../sources/root-ai-docs.md`
