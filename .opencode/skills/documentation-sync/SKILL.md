---
name: documentation-sync
description: Protocols for maintaining modular documentation according to DRY, KISS, and naming standards.
---

# Documentation Sync Skill

This skill ensures that all documentation within the project follows the strict PTVX/Laraxot standards for structure, naming, and content.

## 🚨 Critical Rules

### 1. Filename Standards (Rule: DOCS STANDARD)
- Files MUST be ALL lowercase.
- Files MUST be DATE-FREE (e.g., use `architecture.md`, not `2024-01-01-architecture.md`).
- **Exceptions**: `README.md` and `CHANGELOG.md` MUST be ALL uppercase.

### 2. Relative Inter-Linking
NEVER use absolute paths in `.md` files. Always use relative paths to ensure portability across environments and repository subtrees.

### 3. Project Neutrality Principle
MAI utilizzare il nome specifico del progetto (es. "SaluteOra", "PTVX") nella documentazione dei moduli. I moduli devono rimanere concettualmente indipendenti.
- **Corretto**: "il sistema", "l'applicazione", "questo modulo".
- **Errato**: Nomi di progetti, domini specifici, nomi di organizzazioni.

### 4. Modular Separation (DRY + KISS)
- Each module MUST have its own `docs/` folder.
- Avoid large monolithic files; separate by concern (e.g., `models.md`, `filament.md`, `roadmap.md`).
- Use the central `docs/ai-guidelines.md` as the primary entry point for global rules.

## 🛠️ Procedural Workflow

### Auditing a Module's Docs
1. Check for uppercase filenames (excluding README/CHANGELOG).
2. Check for dates in filenames.
3. Verify that all links are relative.
4. Check for nested `source/docs` or `documentation-source/docs` folders (must be flattened).

### Adding New Documentation
1. Choose a descriptive, lowercase, date-free filename.
2. Place it in the appropriate module's `docs/` folder.
3. Update the module's `README.md` or `roadmap.md` to link to the new file.
4. Ensure no redundant information is added (Check `ai-guidelines.md` first).
