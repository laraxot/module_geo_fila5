# Phase {N} — Plan {M}

**Phase**: {phase_name}
**Plan**: {M} of {total}
**Wave**: {wave_number}
**Dependencies**: {list of plan dependencies or "none"}
**Created**: {date}

---

## Goal

{What this plan delivers}

## Tasks

```xml
<plan>
  <metadata>
    <phase>{N}</phase>
    <plan_number>{M}</plan_number>
    <wave>{wave_number}</wave>
    <dependencies>{comma-separated plan numbers or "none"}</dependencies>
  </metadata>

  <task type="auto">
    <name>{Task name}</name>
    <files>{file paths, comma-separated}</files>
    <action>
      {Precise implementation instructions}
      {Include Laraxot conventions: XotBase*, no ->label(), strict_types}
      {Include PHPStan Level 10 requirements}
    </action>
    <verify>{How to verify this task works}</verify>
    <done>{Definition of done}</done>
  </task>

  <task type="auto">
    <name>{Next task}</name>
    <files>{file paths}</files>
    <action>{Instructions}</action>
    <verify>{Verification}</verify>
    <done>{Done criteria}</done>
  </task>
</plan>
```

## Verification Criteria

- [ ] All tasks complete
- [ ] PHPStan Level 10 passes on affected modules
- [ ] No hardcoded strings in Filament components
- [ ] Translations updated for all languages
- [ ] Atomic git commits per task
- [ ] No `property_exists()` usage
- [ ] All models extend module's BaseModel

## Estimated Scope

- Files modified: ~{N}
- New files: ~{N}
- Modules affected: {list}
