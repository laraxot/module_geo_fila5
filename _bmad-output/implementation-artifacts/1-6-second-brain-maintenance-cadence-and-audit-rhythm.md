# Story 1.6: second brain maintenance cadence and audit rhythm

Status: ready-for-dev

## Story

As a developer agent,
I want a predictable cadence and trigger-based protocol for second-brain maintenance,
so that root, module, and theme docs remain reliable over time with low operational overhead.

## Acceptance Criteria

1. A root wiki concept page defines daily/weekly/monthly cadence, trigger conditions, and done criteria for documentation maintenance.
2. Root wiki index links the cadence page explicitly.
3. The cadence model is aligned with existing second-brain loop pages and does not duplicate existing guidance.
4. The story artifact defines concrete tasks for root/module/theme execution rhythm.
5. All links are relative, filenames are lowercase (except `README.md`), and guidance follows DRY + KISS.

## Tasks / Subtasks

- [ ] Formalizzare cadence root (AC: 1, 3)
  - [ ] Definire ritmo daily/weekly/monthly minimale e sostenibile.
  - [ ] Definire trigger operativi per avviare maintenance pass extra.
  - [ ] Definire DoD del cadence pass.
- [ ] Rendere discoverable la cadence (AC: 2)
  - [ ] Collegare la nuova pagina in `docs/wiki/index.md`.
  - [ ] Verificare assenza di pagine orfane sul topic second brain.
- [ ] Allineare execution rhythm a livello federato (AC: 3, 4)
  - [ ] Verificare compatibilita' con loop locale User.
  - [ ] Verificare compatibilita' con loop locale Theme One.
  - [ ] Definire escalation policy root/module/theme.
- [ ] Quality check documentale (AC: 5)
  - [ ] Verificare naming e link relativi.
  - [ ] Verificare assenza duplicazioni tematiche.

## Dev Notes

- Obiettivo business: ridurre regressioni e tempi di recupero contesto causati da docs stale.
- Strategia: maintenance basata su task reali + pass periodici leggeri.
- Vincolo: evitare creazione di nuovi topic quando gia' presenti; consolidare invece di proliferare.

### Project Structure Notes

- Root protocol: `docs/wiki/concepts/second-brain-maintenance-cadence.md`
- Root index: `docs/wiki/index.md`
- Local loops: `laravel/Modules/User/docs/wiki/concepts/user-module-operating-focus.md`, `laravel/Themes/One/docs/wiki/concepts/theme-one-operating-focus.md`

### References

- [second brain continuous improvement](../../docs/wiki/concepts/second-brain-continuous-improvement.md)
- [second brain operating model](../../docs/wiki/concepts/second-brain-operating-model.md)
- [second brain audit checks](../../docs/wiki/concepts/second-brain-audit-checks.md)
- [user module operating focus](../../laravel/Modules/User/docs/wiki/concepts/user-module-operating-focus.md)
- [theme one operating focus](../../laravel/Themes/One/docs/wiki/concepts/theme-one-operating-focus.md)

## Dev Agent Record

### Agent Model Used

codex-5.3

### Debug Log References

- created maintenance cadence story skeleton

### Completion Notes List

- ready-for-dev story created for second-brain rhythm execution

### File List

- `_bmad-output/implementation-artifacts/1-6-second-brain-maintenance-cadence-and-audit-rhythm.md`
