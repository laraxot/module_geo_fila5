---
title: installazione mariadb locale e gitignore
type: memory
tags: [mariadb, gitignore, ops]
created: 2026-05-21
updated: 2026-05-21
related:
  - "../how-to/module-docs-deduplication.md"
  - "../../../bashscripts/tools/lamp/README.md"
---

# `.local/mariadb-install` non va in git

## Perché

~125MB di `.deb` estratti e binari sotto `.local/mariadb-install/` sono artefatti **solo WSL locale**, non parte del monorepo.

## Cosa fare

- Install: `sudo bash bashscripts/tools/lamp/install-mariadb.sh` (cartella `bashscripts/` è gitignored nel repo; esiste solo su disco).
- Opzionale offline: copiare i `.deb` in `.local/mariadb-install/` — restano ignorati da `.local/` in root `.gitignore`.

## Mai committare

Se compaiono in `git status`, eseguire:

```bash
git rm -r --cached .local/mariadb-install
```

Issue correlate: #132 (MySQL/MariaDB datadir).
