# GSD Adapter — Cursor

## Overview

This adapter maps GSD commands to Cursor AI capabilities.

## Command Mapping

GSD workflow guidance is available via `.cursor/rules/gsd.mdc` which instructs the Cursor agent on GSD methodology for this repository.

| GSD Action | Cursor Instruction |
|-----------|-------------------|
| New Project | "Initialize GSD project: interview, research, requirements, roadmap" |
| Discuss Phase | "GSD discuss phase N: identify gray areas and capture decisions" |
| Plan Phase | "GSD plan phase N: research, create XML task plans, verify" |
| Execute Phase | "GSD execute phase N: wave execution with atomic commits" |
| Verify Work | "GSD verify phase N: test deliverables, diagnose failures" |
| Quick Mode | "GSD quick: {description}" |
| Map Codebase | "GSD map codebase: analyze stack, architecture, conventions" |

## Cursor-Specific Features

### Rules Integration
- `.cursor/rules/gsd.md` — GSD methodology rules
- `.cursor/memories/` — Persistent GSD state

### Quality Gates (Laraxot)
Same as Windsurf adapter — PHPStan L10, Pint, no labels, strict types.

## File References

- `.planning/STATE.md` — Current project state
- `.planning/config.json` — Workflow configuration
- `.gsd/templates/` — Document templates
- `docs/project/gsd-methodology.md` — Full methodology documentation
