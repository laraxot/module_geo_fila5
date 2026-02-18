---
name: git-push-pack-repair
description: Ripara errori di push Git con pack corrotti (did not receive expected object). Usare quando push fallisce con remote unpack/index-pack.
---

# Git Push Pack Repair

## Quando usare
- Errori push con:
  - `did not receive expected object`
  - `remote unpack failed: index-pack failed`

## Procedura
1. `git fsck --full`
2. `git repack -a -d`
3. `git gc --prune=now`
4. `git push -uf origin dev`

## Se fallisce ancora
- Re-clone pulito del repo e ripetere il push.
