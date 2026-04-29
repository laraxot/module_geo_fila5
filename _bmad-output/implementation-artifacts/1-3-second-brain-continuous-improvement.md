# Story 1.3: Second Brain Continuous Improvement Across Modules and Themes

Status: drafted

## Story

As a developer agent,
I want a repeatable second-brain maintenance workflow for module and theme documentation,
so that every task continuously improves the repository knowledge base instead of leaving `docs/` folders inconsistent, stale, or hard to query.

## Context

Story 1.1 established the Karpathy-style wiki structure. Story 1.2 started ingesting high-value root documentation into the project wiki.

The next bottleneck is operational discipline. The repository still has many module and theme `docs/` trees with uneven quality, mixed naming, duplicate topics, and unclear routing between raw documentation and compiled wiki knowledge.

Without a continuous maintenance rule, agents will keep rediscovering the same context from scratch and raw docs will continue to grow faster than curated knowledge.

This story turns "study the second brain, use the second brain, improve the second brain" into a standing implementation rule for everyday work.

## Acceptance Criteria

1. A root wiki page documents the continuous-improvement workflow for `docs/` and `docs/wiki/` across project, module, and theme scopes.
2. The project second-brain operating model includes explicit principles for actionability, progressive compression, and discoverability.
3. The story defines routing rules for when knowledge belongs in root wiki, module wiki, or theme wiki.
4. The story defines minimum quality checks for stale, duplicate, orphaned, and non-indexed documentation.
5. The story requires every non-trivial engineering task touching documentation or cross-cutting knowledge to leave wiki and log updates behind.
6. A prioritized rollout list exists for applying this loop to high-value module and theme documentation clusters.

## Tasks / Subtasks

- [x] Add a root wiki concept page for continuous improvement.
- [x] Update the root second-brain operating model with external second-brain principles adapted to repository work.
- [x] Update root `docs/wiki/index.md` and `docs/wiki/log.md`.
- [ ] Build a prioritized rollout backlog for module docs:
  - [x] `laravel/Modules/Xot/docs/`
  - [x] `laravel/Modules/UI/docs/`
  - [x] `laravel/Modules/User/docs/`
  - [x] `laravel/Modules/Activity/docs/`
- [ ] Build a prioritized rollout backlog for theme docs:
  - [x] `laravel/Themes/One/docs/`
  - [x] `laravel/Themes/Zero/docs/`
- [x] Add at least one module-level ingest/update following the new loop.
- [x] Add at least one theme-level ingest/update following the new loop.
- [x] Document any reusable lint or audit checks that can be automated later.

## Developer Notes

### External Research Incorporated

- Karpathy's April 4, 2026 `llm-wiki.md` reframes repository memory as accumulated synthesis rather than fresh retrieval on every query.
- Tiago Forte's PARA guidance reinforces organizing information by actionability and active work, not by abstract taxonomy alone.
- Tiago Forte's progressive summarization principles reinforce opportunistic compression, discoverability, and leaving stronger cues for future reuse.

### Working Rule

For any meaningful task that uncovers durable knowledge:

1. Query the nearest wiki first.
2. Read the minimum raw docs needed.
3. Persist conclusions into the nearest useful wiki.
4. Update `index.md`.
5. Append to `log.md`.

If this loop is skipped, the second brain does not improve.

### Known Risks

- Some module `docs/` trees contain generated or legacy material that should not be promoted blindly.
- The repository has mixed naming conventions, which can hide semantic duplicates.
- Root, module, and theme scopes may drift if routing rules are not applied consistently.

## Initial Priority Order

1. High-impact architectural modules
2. Themes with rich product and frontend documentation
3. Modules with dense historical analysis but weak wiki summaries
4. Lower-signal legacy or archival material

## Progress Notes

- Root continuous-improvement policy documented in `docs/wiki/concepts/second-brain-continuous-improvement.md`
- Root operating model updated to include actionability, progressive compression, and continuous maintenance loop
- Xot wiki now includes a guardrails concept page and a source summary for core architecture docs
- Theme One wiki now includes an operating-focus concept page and a product/roadmap source summary
- UI wiki now includes an operating model and source summary for shared component and Filament architecture
- User wiki now includes an operating focus page and a source summary for identity architecture and strategy
- Activity wiki now includes a domain focus page and a source summary for audit/event-history documentation
- Theme Zero wiki now includes an operating focus page and a strategic source summary
- Root wiki now includes reusable audit checks and the repository now exposes `bashscripts/tools/second_brain_audit.php`

## References

- `docs/wiki/concepts/second-brain-operating-model.md`
- `docs/wiki/concepts/second-brain-continuous-improvement.md`
- `_bmad-output/implementation-artifacts/1-2-second-brain-docs-ingestion.md`
