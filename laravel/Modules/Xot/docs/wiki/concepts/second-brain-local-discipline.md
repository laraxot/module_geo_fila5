---
title: "Second Brain Local Discipline"
type: "concept"
tags: [second-brain, llm-wiki, on-demand, local-docs]
created: 2026-05-19
updated: 2026-05-26
---

# Second Brain Local Discipline

**Pagina canonica (moduli Laraxot):** unica copia con corpo lungo dei contratti sotto questa intestazione.

Negli altri moduli il file **`second-brain-local-discipline.md`** in **`docs/wiki/concepts/`** è uno **stub** che punta qui; modifiche al contratto vanno sempre applicate prima in **Xot**, poi eventualmente estratto contesto modulo-specifico in altre pagine locali — non nel corpo boilerplate ripetuto.

> Local module/theme wiki discipline. Keep durable knowledge close to the code it explains, and route cross-cutting behavior back to the root wiki.

## Local Contract

- This wiki documents only knowledge owned by this module/theme.
- Root rules stay in `docs/wiki/rules/00-TRIGGER_MAP.md` and are linked, not copied.
- Source docs are evidence; they are not assumed immutable or technically read-only.
- Use QMD with `--limit` before opening raw docs or broad file trees.
- Add reusable local decisions to this wiki and append the nearest `log.md`.
- Prima di ingest o massicci update, verificare marcatori merge sui file sorgente; procedura root: [`../../../../../../docs/wiki/how-to/git-merge-marker-sweep.md`](../../../../../../docs/wiki/how-to/git-merge-marker-sweep.md).

## What To Store Here

- Local business rules, UI behavior, model/resource caveats, migrations, integrations.
- Source summaries that remove future rediscovery work.
- Troubleshooting notes backed by commands, errors, tests, or code references.
- Links to root rules when local behavior depends on shared Laraxot/XotBase/wiki policy.

## What Not To Store Here

- Duplicated root policy bodies.
- Merge debris, backup files, or `_archive/` wiki folders.
- Large pasted external articles.
- Claims such as "read-only" or "always" unless verified in the current tree.

## Quality Gate

Before closing a docs update in this module/theme:

1. Check root trigger map for relevant rules.
2. Search local wiki with `qmd search "<module-or-theme> <topic>" --limit 5`.
3. Update or create the smallest local page that captures the durable decision.
4. Link it from `index.md` when it should be discoverable by future agents.
5. Append `log.md` for reusable decisions.

## Root References

- `docs/wiki/rules/00-TRIGGER_MAP.md`
- `docs/wiki/rules/on-demand-pattern.md`
- `docs/wiki/concepts/second-brain-operating-model.md`
- `docs/wiki/concepts/second-brain-continuous-improvement.md`
- `docs/wiki/sources/second-brain-external-benchmarks.md`
