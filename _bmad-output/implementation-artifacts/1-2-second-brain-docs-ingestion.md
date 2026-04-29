# Story 1.2: Second Brain Docs Ingestion and Consolidation

Status: in-progress

## Story

As a developer agent,
I want a disciplined ingestion workflow for root, module, and theme documentation,
so that the existing repository docs become a reliable second brain instead of an unstructured archive.

## Context

Story 1.1 initialized the Karpathy-style LLM wiki structure across the repository. The next step is not creating more empty folders; it is turning the current documentation mass into curated knowledge.

The repository already contains:

- a broad root `docs/` tree with architecture, AI workflow, BMAD, PHPStan, and historical notes
- module-level docs with very uneven density and quality
- theme-level docs with useful product, roadmap, architecture, and troubleshooting content
- recurring duplicates and mixed naming conventions

This story defines the work needed to make that material operational as a second brain.

## Acceptance Criteria

1. A project-level second-brain operating model is documented in `docs/wiki/`.
2. A source-summary page exists for the current docs landscape across modules and themes.
3. A prioritized ingest backlog exists for the most valuable raw docs clusters.
4. The ingest workflow states where project-wide, module-specific, and theme-specific knowledge must be persisted.
5. The story documents risks caused by duplicate or conflicting raw docs.

## Tasks / Subtasks

- [x] Confirm and preserve the project-wide second-brain conventions in `docs/wiki/`.
- [ ] Ingest root documentation clusters:
  - [x] `docs/architecture/`
  - [x] `docs/ai/`
  - [x] `docs/bmad/`
  - [ ] `docs/PHPStan/`
- [ ] Ingest high-value module documentation:
  - [ ] `laravel/Modules/Activity/docs/`
  - [ ] `laravel/Modules/Xot/docs/`
  - [ ] `laravel/Modules/UI/docs/`
  - [ ] `laravel/Modules/User/docs/`
- [ ] Ingest theme documentation:
  - [ ] `laravel/Themes/Zero/docs/`
  - [ ] `laravel/Themes/One/docs/`
- [ ] Create or update wiki concept/source pages from those ingests.
- [ ] Record every ingest operation in the relevant `docs/wiki/log.md`.

## Developer Notes

### Working Definition of "Second Brain"

For this repository, a second brain is:

- raw docs as evidence
- wiki pages as synthesized understanding
- schema as governance
- logs as an audit trail

### Known Risks

- Duplicate raw documents may contain conflicting advice.
- Some `docs` directories appear mirrored or nested under generated/copied trees.
- Theme and module docs use mixed file naming conventions, which can hide conceptual duplicates.

### Initial Priority Order

1. Root cross-cutting docs
2. Core modules with architectural impact
3. Themes that encode frontend and product decisions
4. Lower-signal legacy/archive material

## Progress Notes

- Project-level second-brain model documented in `docs/wiki/concepts/second-brain-operating-model.md`
- Repository docs landscape summarized in `docs/wiki/sources/docs-landscape-modules-and-themes.md`
- Root `docs/architecture/` ingested into architecture guardrails and source summary pages
- Root `docs/ai/` ingested into AI tooling workflow and source summary pages
- Root `docs/bmad/` ingested into BMAD operating model and source summary pages

## References

- `docs/wiki/concepts/second-brain-operating-model.md`
- `docs/wiki/sources/docs-landscape-modules-and-themes.md`
- `_bmad-output/implementation-artifacts/1-1-llm-wiki-setup.md`
