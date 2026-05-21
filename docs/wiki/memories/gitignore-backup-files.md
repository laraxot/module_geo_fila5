---
title: gitignore file backup
type: memory
tags: [gitignore, backup, git-policy]
created: 2026-05-21
updated: 2026-05-21
---

# File `.backup` fuori da Git

## Scopo

Gli script di risoluzione conflitti (es. Xot) creano copie `file.ext.backup`. Non vanno mai nell’index: la history è in Git, non in file paralleli.

## Pattern obbligatori

Ripetere in root `.gitignore`, `laravel/.gitignore`, ogni `laravel/Modules/<Name>/.gitignore`, `laravel/Themes/<Name>/.gitignore`, e nei rispettivi `docs/.gitignore`:

```gitignore
*.bak
*.backup
*.backup.*
```

Root: anche `analysis/` per snapshot locali di analisi conflitti.

## Se già tracciati

```bash
git ls-files '*.backup' '*.backup.*'
git rm --cached -- 'path/to/file.backup'   # oppure glob dopo verifica
```

## Riferimenti

- [llm-wiki §7.1](../../bashscripts/tools/prompts/llm-wiki.txt) (blocco canonico)
- [module directory structure](../../../laravel/Modules/Xot/docs/module-directory-structure-rule.md)
- [script risoluzione conflitti](../../../laravel/Modules/Xot/docs/script-risoluzione-conflitti-1.md)
