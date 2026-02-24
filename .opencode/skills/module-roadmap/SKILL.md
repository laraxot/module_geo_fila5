---
name: module-roadmap
description: Create and update module roadmaps tracking progress, technical debt, and planned improvements. Use after completing tasks, fixing bugs, or when the user asks about module status.
---

# Module Roadmap - Progress Tracking

Maintain and update roadmaps for module development tracking.

## When to Use

- After completing significant work on a module
- After PHPStan error fixes
- When the user asks about module status
- When planning future module work
- After every coding session

## Roadmap Location

`laravel/Modules/{Module}/docs/roadmap.md`
`laravel/Themes/{Theme}/docs/roadmap.md`

## Template

```markdown
# {Module} Module - Roadmap

> Last Updated: {YYYY-MM-DD}

## Current Status

| Metric | Value |
|--------|-------|
| PHPStan Level 10 | {X} errors |
| Test Coverage | {X}% |
| Documentation | {Complete/Partial/Minimal} |
| XotBase Compliance | {Yes/No} |
| Translation Compliance | {Yes/No} |

## Recently Completed

- [x] {Task description} ({date})
- [x] {Task description} ({date})

## In Progress

- [ ] {Current task description}
- [ ] {Current task description}

## Planned

### High Priority
- [ ] {Task description}

### Medium Priority
- [ ] {Task description}

### Low Priority
- [ ] {Task description}

## Technical Debt

| Issue | Severity | Module Area |
|-------|----------|-------------|
| {Description} | {High/Medium/Low} | {Area} |

## PHPStan Progress

| Date | Errors | Fixed | Remaining |
|------|--------|-------|-----------|
| {Date} | {N} | {N} | {N} |

## Notes

{Any important observations or decisions}
```

## Update Rules

1. **Always update after work sessions** - Record what was done
2. **Be specific** - "Fixed 12 PHPStan errors in Models/" not "Fixed some errors"
3. **Track metrics** - PHPStan error count, test coverage
4. **Date everything** - Every entry should have a date
5. **Keep history** - Move completed items to "Recently Completed", don't delete

## After Updating

1. Commit the roadmap update with the related code changes
2. If significant milestone reached, note it in the module's `00-index.md`
