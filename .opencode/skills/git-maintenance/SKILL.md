---
name: git-maintenance
description: Essential commands and scripts for maintaining Git repository health, including fixing shallow clones.
---

# Git Maintenance & Troubleshooting

## Fixing Shallow Repositories

If `git push` fails with `fatal: did not receive expected object`, the repository is likely a **shallow clone**.

### Diagnosis
```bash
git rev-parse --is-shallow-repository
# Output: true (if shallow)
```

### Fix (Unshallow)
To restore full history and enable pushing:

```bash
# Preferred: Fetch form original source (e.g. laraxot)
git fetch --unshallow laraxot

# Fallback: Fetch from origin
git fetch --unshallow origin
```

## Routine Maintenance

```bash
# Prune deleted remote branches
git fetch -p --all

# Garbage collect
git gc --prune=now
```
