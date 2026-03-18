# GSD (Get Shit Done) - Project Configuration

This directory contains GSD spec-driven development artifacts adapted for Laraxot PTVX.

## Structure

```
.gsd/
├── README.md              # This file
├── templates/             # Document templates
│   ├── PHASE-CONTEXT.md   # Discussion output template
│   ├── PHASE-PLAN.md      # Plan template (XML tasks)
│   ├── PHASE-SUMMARY.md   # Execution summary template
│   ├── PHASE-UAT.md       # Verification template
│   └── QUICK-TASK.md      # Quick mode template
├── examples/              # Usage walkthroughs
│   └── laraxot-phase.md   # Laraxot-specific example
└── adapters/              # Agent-specific enhancements
    ├── WINDSURF.md         # Windsurf/Cascade adapter
    └── CURSOR.md           # Cursor adapter
```

## Quick Start

1. Check `.planning/STATE.md` for current project state
2. Check `.planning/config.json` for workflow configuration
3. Use the workflow commands from your AI agent

## Relationship to .planning/

- `.gsd/` = Templates, adapters, configuration reference
- `.planning/` = Live project artifacts (PROJECT, REQUIREMENTS, ROADMAP, STATE, research, phases)

## Documentation

- [GSD Methodology](../docs/project/gsd-methodology.md)
- [AGENTS.md](../AGENTS.md)
