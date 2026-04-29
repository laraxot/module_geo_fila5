# Story: Location Button Spinner UX

## Status: ✅ Completed
## Priority: High
## Type: UX Improvement
## Module: Geo (AddressInput component)
## Theme: Sixteen
## Date: 2026-04-14

---

## As A User
When I click "Use your position" on the address input during ticket creation, I want to see a loading spinner so I understand the system is processing my request and not broken.

## Acceptance Criteria

- [ ] Clicking "Use your position" shows an immediate spinner/loading state
- [ ] Spinner remains visible while geolocation is being resolved
- [ ] Spinner disappears when geolocation succeeds OR fails
- [ ] Spinner is visible on both mobile and desktop
- [ ] Spinner follows Design Comuni/Italian design system patterns
- [ ] No regression in existing geolocation functionality

## Technical Notes

- `AddressInput` component (Geo module) is the target
- Likely needs Filament `wire:loading` or Alpine.js spinner
- Check existing patterns in `Modules/Geo/Filament/Forms/Components/AddressInput.php`
- Check existing spinner/loading patterns in Design Comuni

## Philosophy

This is a **micro-interaction UX gap**: user clicks → nothing visible → user thinks it's broken → clicks again → double requests → bad UX.

**Zen principle**: "Don't leave the user wondering." Always show state.

**Design Comuni compliance**: Use native Bootstrap Italia spinner patterns, not custom animations.

## Verification

1. Go to `/it/tests/segnalazione-crea`
2. Fill step 1 (privacy)
3. Go to step 2, find address field
4. Click "Use your position"
5. **PASS**: Spinner appears immediately, stays visible until result
6. **FAIL**: Button clicks with no visual feedback

## Related
- Epic: Ticket Creation Wizard
- Previous stories: 001 (privacy), 002 (data form), 003 (summary), 004 (submit)
