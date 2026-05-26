# Trigger Map: Automation and Enforcement

This document formalizes the automatic discipline wired from TRIGGER_MAP entries to scripts and CI workflows.

Goals:
- Prevent context-mode compaction thrash and token overflows
- Ensure agents always create/link GitHub issues before PRs
- Index docs/wiki safely (chunk & summarize large files)
- Make the discipline automatic via CI, hooks, and scheduled jobs

Automations:
- scripts/ai_token_guard.py -> scanned on PR by .github/workflows/ai-token-guard.yml; fails CI if risky patterns found (web_fetch without max_length, raw:true, large markdown files)
- scripts/context_index.sh + scripts/summarize_md.py -> scheduled by .github/workflows/context-index.yml daily; chunk and index docs for context-mode
- .githooks/commit-msg -> local guard requiring issue reference in commit messages
- .github/workflows/require-issue-link.yml -> CI will create an issue automatically and comment on the PR if missing

How it works:
1. On PR open/sync: ai-token-guard runs. If it finds risky calls, CI fails and author must fix.
2. If PR merges with risky/large files, scheduled context-index will detect large files and create summaries (prevents future thrash).
3. Autocompact thrash detection: agents should consult `docs/wiki/how-to/autocompact-thrashing-recovery.md` and call `scripts/ai_token_guard.py` preflight before heavy reads.

Maintainers: assign a human reviewer for auto-created issues; review frequency: weekly.

Appendix: see `docs/wiki/rules/context-overflow-prevention.md` for best practices and examples.
