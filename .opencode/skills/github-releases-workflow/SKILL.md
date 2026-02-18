---
name: github-releases-workflow
description: Crea workflow di release GitHub basati su tag per moduli/temi. Usare quando si richiede gestione release o tag v*.
---

# GitHub Releases Workflow

## Quando usare
- Richiesta di release automation
- Moduli/temi con tag semantici `v*`

## Workflow standard
- Trigger: `push` su tag `v*` + `workflow_dispatch`
- Permessi: `contents: write`
- Action: `softprops/action-gh-release@v2` con `generate_release_notes: true`
