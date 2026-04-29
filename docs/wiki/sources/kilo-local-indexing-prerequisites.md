---
title: "Kilo Local Indexing Prerequisites"
module: "ptvx-project"
type: source
created: "2026-04-29T00:00:00Z"
updated: "2026-04-29T00:00:00Z"
related:
  - "[[Second Brain Operating Model]]"
---

# Kilo Local Indexing Prerequisites

> Concrete local prerequisites prepared for Kilo codebase indexing in this repository.

## Installed Components

- Ollama available locally: `0.17.7`
- local embedding model installed: `nomic-embed-text:latest`
- local Qdrant installed inside the repository from the official `1.17.1` release

## Local Paths

- Qdrant binary: `/.tools/qdrant/usr/bin/qdrant`
- Qdrant config: `/.local/qdrant/config.yaml`
- Qdrant storage: `/.local/qdrant/storage`
- Qdrant snapshots: `/.local/qdrant/snapshots`
- bootstrap script: `/bashscripts/tools/kilo_local_indexing_bootstrap.sh`

## Runtime Status

Validated during setup:

- `pgrep -af qdrant` shows the local process running
- `curl -s http://127.0.0.1:6333/` returns the Qdrant version payload

## Operational Command

```bash
bashscripts/tools/kilo_local_indexing_bootstrap.sh
```

The script:

1. checks `nomic-embed-text`
2. starts Qdrant in detached mode if needed
3. verifies the local HTTP endpoint

## Policy Boundary

The repository is now ready for local indexing prerequisites, but managed indexing remains disabled in `/.kilocode/config.json` until the team explicitly chooses an indexing mode.

## References

- `../../ai/kilo/kilo-large-projects.md`
- `../../../bashscripts/tools/kilo_local_indexing_bootstrap.sh`
- https://kilo.ai/docs/features/codebase-indexing
- https://kilo.ai/docs/deploy-secure/managed-indexing
