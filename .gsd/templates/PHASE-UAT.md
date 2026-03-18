# Phase {N} — User Acceptance Testing

**Phase**: {phase_name}
**Tested**: {date}
**Tester**: {human/automated}

---

## Deliverables to Test

| # | Deliverable | Test | Result | Notes |
|---|------------|------|--------|-------|
| 1 | {feature} | {how to test} | ✅/❌ | {notes} |
| 2 | {feature} | {how to test} | ✅/❌ | {notes} |

## Automated Checks

| Check | Command | Result |
|-------|---------|--------|
| PHPStan | `./vendor/bin/phpstan analyse Modules/{X} --level=10` | ✅/❌ |
| Pest Tests | `./vendor/bin/pest Modules/{X}` | ✅/❌ |
| Pint | `./vendor/bin/pint --test` | ✅/❌ |

## Issues Found

### Issue 1: {title}
- **Severity**: Critical / High / Medium / Low
- **Description**: {what's wrong}
- **Expected**: {what should happen}
- **Actual**: {what happens}
- **Fix Plan**: {reference to fix plan or description}

## Verdict

- [ ] All deliverables verified
- [ ] All automated checks pass
- [ ] No critical/high issues remaining
- [ ] Phase ready for completion

**Decision**: PASS / FAIL / CONDITIONAL PASS (with fix plans)
