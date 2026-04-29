---
title: "Second Brain Audit Checks"
module: "ptvx-project"
type: concept
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
qmd: "second brain audit, wiki lint, orphan pages, unindexed pages, docs health, raw docs coverage"
related:
  - "[[Second Brain Continuous Improvement]]"
  - "[[Second Brain Operating Model]]"
---

# Second Brain Audit Checks

> Reusable health checks for keeping `docs/wiki/` usable as a retrieval layer instead of a passive archive.

## Current Audit Tool

Run:

```bash
php bashscripts/tools/second_brain_audit.php
```

Current checks:

- missing `docs/wiki/index.md`
- missing `docs/wiki/log.md`
- wiki pages not referenced from `index.md`
- wiki pages without visible related links
- docs trees with raw markdown but no `wiki/sources/` summaries

## Why These Checks First

- unindexed pages are effectively invisible
- orphan pages weaken graph navigation
- missing source summaries force agents back into raw docs
- missing logs remove auditability

## Next Checks To Add

- duplicate-topic detection across raw filenames
- stale-claim detection from date-heavy pages
- oversized wiki page detection for token-budget control
- mismatch detection between `docs-health.md` snapshots and current docs state

## References

- [[Second Brain Continuous Improvement]]
- [[Second Brain Operating Model]]
