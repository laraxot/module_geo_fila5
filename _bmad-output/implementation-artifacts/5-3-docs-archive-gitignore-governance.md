# Story 5.3: Docs Archive Gitignore Governance

Status: done

## User Story

As a maintainer of the modular Laravel codebase, I want every module and theme to treat `docs/legacy/` as local-only scratch history, so stale duplicate documentation does not pollute Git status, QMD ingestion, or canonical documentation.

## Context

`docs/legacy/` is not canonical documentation. It is historical scratch space created by migrations, duplicate cleanup, or local agent work. If it appears in `git status`, it creates noise and can make stale notes look like current module knowledge.

Canonical documentation must live in:

- `docs/*.md`
- `docs/wiki/**`
- precise topical subdirectories outside `legacy`

## Acceptance Criteria

1. Every existing `laravel/Modules/*/docs/.gitignore` contains `legacy/` (ignored local scratch).
2. Every existing `laravel/Themes/*/docs/.gitignore` contains `legacy/`.
3. Every module/theme docs folder has `docs-archive-policy.md` (nome file storico; contenuto punta a `docs/legacy/`).
4. `git status --short --untracked-files=all | rg 'docs/legacy/'` returns no rows for contenuti solo-locali non voluti.
5. Useful superseded knowledge must be promoted into live docs before it is linked or ingested as authoritative context.

## Implementation Notes

- Added missing `docs-archive-policy.md` files in modules that only had the ignore rule.
- Existing theme and high-noise module policies were preserved.
- Cartelle tracciate rinominata da `archive`/`archived`/`backup*` a `legacy`/`superseded`/`snapshot*` per allinearsi al gate `verify-llm-wiki.sh` e alla disciplina nomi cartella.

## Verification

Run:

```bash
rg -n "legacy/" laravel/Modules/*/docs/.gitignore laravel/Themes/*/docs/.gitignore
git status --short --untracked-files=all | rg 'docs/legacy/'
bash bashscripts/quality-gates/verify-llm-wiki.sh
```

Expected result:

- First command lists each module/theme docs ignore file.
- Second command returns no output.
