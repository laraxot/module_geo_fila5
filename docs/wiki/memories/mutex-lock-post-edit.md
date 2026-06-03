---
title: "Mutex lock and post-edit validation"
type: "memory"
tags: [agents, phpstan, lock]
created: 2026-05-19
updated: 2026-05-19
sources:
  - docs/wiki/rules/validation-post-edit-rule.md
---

# Mutex lock and post-edit validation

Per edited path: companion `file.ext.lock` only if absent; remove after edit. PHP in `laravel/`: PHPStan L10 + `laravel/tools/phpmd.sh` + `laravel/tools/phpinsights.sh` + pest (tentativo) + smoke HTTP/playwright/puppeteer se UI. **Mai** «dovrebbe» senza output — [agent-verification-mandatory-no-dovrebbe](agent-verification-mandatory-no-dovrebbe.md).

- [validation-post-edit-rule](../rules/validation-post-edit-rule.md)
- [file-locking in chat](../../chat/file-locking-pattern.md)
