# Story 5.3: Docs Archive Gitignore Governance

Status: done

## User Story

As a maintainer of the modular Laravel codebase, I want every module and theme to treat `docs/archive/` as local-only scratch history, so stale duplicate documentation does not pollute Git status, QMD ingestion, or canonical documentation.

## Context

`docs/archive/` is not canonical documentation. It is historical scratch space created by migrations, duplicate cleanup, or local agent work. If it appears in `git status`, it creates noise and can make stale notes look like current module knowledge.

Canonical documentation must live in:

- `docs/*.md`
- `docs/wiki/**`
- precise topical subdirectories outside `archive`

## Acceptance Criteria

1. Every existing `laravel/Modules/*/docs/.gitignore` contains `archive/`.
2. Every existing `laravel/Themes/*/docs/.gitignore` contains `archive/`.
3. Every module/theme docs folder has `docs-archive-policy.md`.
4. `git status --short --untracked-files=all | rg 'docs/archive/'` returns no rows.
5. Useful archived knowledge must be promoted into live docs before it is linked or ingested as authoritative context.

## Implementation Notes

- Added missing `docs-archive-policy.md` files in modules that only had the ignore rule.
- Existing theme and high-noise module policies were preserved.
- No tracked archive content was deleted in this story; tracked historical archive cleanup should be handled separately because `.gitignore` intentionally does not affect files already in Git.

## Verification

Run:

```bash
rg -n "archive/" laravel/Modules/*/docs/.gitignore laravel/Themes/*/docs/.gitignore
git status --short --untracked-files=all | rg 'docs/archive/'
```

Expected result:

- First command lists each module/theme docs ignore file.
- Second command returns no output.
