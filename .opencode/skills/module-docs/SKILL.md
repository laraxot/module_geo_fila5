---
name: module-docs
description: Guidelines and standards for module documentation maintenance.
---

# Module Documentation Standards

## Filename Conventions
-   **Lowercase**: All `.md` files MUST be lowercase (e.g., `troubleshooting.md`).
-   **No Dates**: Do NOT prefix files with dates (e.g., `2025-01-01-update.md` ❌ -> `update.md` ✅).
-   **Separators**: Use hyphens `-` for separators, not underscores `_` or spaces.

## Special Files
-   **README.md**: MUST be uppercase. If `readme.md` exists, it should be renamed or merged.
-   **CHANGELOG.md**: MUST be uppercase.

## Structure
Every module should have a `docs/` directory containing:
-   `README.md` (Module overview)
-   `CHANGELOG.md` (Version history)
-   `troubleshooting.md` (Common issues)
-   `roadmap.md` (Future plans)

## Maintenance Script
Use `bashscripts/maintenance/standardize_docs.py` to automatically enforce these rules.
