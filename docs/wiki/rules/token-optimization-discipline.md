---
title: "Token Optimization Discipline"
type: "rule"
tags: [tokens, context, optimization, context-mode, mandatory]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - "./autocompact-thrashing-discipline.md"
  - "../how-to/context-mode-setup.md"
  - "../concepts/context-overflow-prevention.md"
qmd: "token optimization discipline automatic context-mode mandatory"
---

# Token Optimization Discipline

> **MANDATORY.** This discipline ensures that the AI agent remains within the token limits and prevents context thrashing.

## Automatic Triggers

Load this rule immediately if:
- Token usage per call is perceived as "too high".
- "Autocompact is thrashing" appears.
- The context feels slow or lagging.

## Rules for Token-Efficient Execution

### 1. Processing in Sandbox (Context-Mode MCP)
- **NEVER** return raw data > 50 lines to the main context.
- Use `ctx_batch_execute` for complex analysis. Processing happens in the sandbox; only the summary returns.
- Always set `intent` in `ctx_execute_file` to filter output semantically.

### 2. Smart Reading
- Use `token-optimizer_smart_read` for files > 80 lines.
- Use `Read` with `start_line` and `end_line` for targeted analysis.
- **NEVER** read `composer.lock` or `package-lock.json` in full.

### 3. Proactive Compaction
- Use `/clear` or start a new session every 20-30 turns.
- Use `context-mode` `compress` hook before large context injections.

### 4. Lean Output
- Use silent flags (e.g., `npm install --silent`, `git status --short`).
- Redirect large command outputs to temporary files and analyze them with `ctx_execute_file`.

## Verification

```bash
context-mode doctor
qmd search "token optimization discipline"
```

---
**References:**
- [Autocompact Thrashing Discipline](./autocompact-thrashing-discipline.md)
- [Context-Mode Setup](../how-to/context-mode-setup.md)
- [Context Overflow Prevention](../concepts/context-overflow-prevention.md)
