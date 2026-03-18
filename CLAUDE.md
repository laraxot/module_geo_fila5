# Claude Context

> Full documentation index: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

## Project Context

PTVX is a modular HR & Performance evaluation system built on Laravel + Filament + Laraxot.

## Quick Start Guidelines

- **Short array syntax `[]`** ALWAYS.
- **Extend `XotBase*`** wrappers for Filament.
- **No hardcoded labels** — use translation keys.
- **Actions over Services** — use `app(Action::class)->execute()`.
- **PHPStan Level 10** — no ignores allowed.
- **Read → Reason → Study** before any edit.

## GSD (Get Shit Done)

This project uses GSD for spec-driven development with context engineering.

- **State**: `.planning/STATE.md` — read at session start
- **Config**: `.planning/config.json` — workflow configuration
- **Templates**: `.gsd/templates/` — document templates
- **Methodology**: `docs/project/gsd-methodology.md`

### GSD Commands

```
/gsd:new-project          # Initialize project
/gsd:discuss-phase N      # Discuss phase N
/gsd:plan-phase N         # Plan phase N
/gsd:execute-phase N      # Execute phase N
/gsd:verify-work N        # Verify phase N
/gsd:quick "desc"         # Quick ad-hoc task
/gsd:map-codebase         # Analyze brownfield codebase
/gsd:progress             # Show current state
```

### When to use GSD vs BMAD

| Scenario | Framework |
|----------|-----------|
| Single feature, refactoring | **GSD** |
| Complex multi-file bug fix | **GSD** |
| New complete module | **BMAD** |
| Architecture, stakeholder alignment | **BMAD** |
| Quick ad-hoc task | **GSD quick** |

## BMAD Method V6

BMAD V6.2.0 is installed in `_bmad/` with 9 specialized agents and 42 workflows.

- **Config**: `_bmad/_config/` — manifests, agents, workflows
- **Output**: `_bmad-output/` — PRD, architecture, epics, stories
- **Context**: `_bmad-output/project-context.md` — Laraxot implementation rules
- **Help**: Invoke `bmad-help` for intelligent guidance

### Key Workflows

```
bmad-help                          # What should I do next?
bmad-create-prd                    # Create Product Requirements
bmad-create-architecture           # Technical decisions
bmad-create-epics-and-stories      # Break into stories
bmad-sprint-planning               # Initialize sprint
bmad-create-story                  # Prepare next story
bmad-dev-story                     # Implement story
bmad-code-review                   # Adversarial review
bmad-quick-dev                     # Quick spec + implementation
bmad-brainstorming                 # Guided ideation
bmad-party-mode                    # Multi-agent discussion
```

## Documentation Navigation

- [Detailed Project Overview](.agents/docs/agents-guide/01-project-overview/project-overview.md)
- [Critical Rules Summary](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md)
- [Quick Commands](.agents/docs/agents-guide/02-tooling/quick-commands.md)
- [Laraxot Philosophy](.agents/docs/laraxot-philosophy.md)
- [GSD Methodology](docs/project/gsd-methodology.md)
- [BMAD Integration](docs/project/bmad-method-integration.md)

---
[Agent docs index](.agents/docs/index.md) | [Agent Teams](.agents/docs/agent-teams.md) | [Project setup](.agents/docs/project-setup.md)
