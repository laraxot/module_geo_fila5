---
qmd: "documentation sprawl"
issues: []
discussions: []
title: "Documentation Sprawl Analysis — Geo Module"
type: comparison
tags: [geo, documentation, redundancy, sprawl, dry]
created: "2026-05-25"
updated: "2026-05-25"
status: draft
---

# Documentation Sprawl Analysis — Geo Module

## Overview

The `laravel/Modules/Geo/docs` directory contains over 200 files in its root, exhibiting extreme redundancy and fragmentation. This sprawl makes it difficult for developers and AI agents to find the Single Source of Truth (SSoT).

## Identified Redundancy Patterns

### 1. Snake-case vs. Kebab-case Duplicates
Many files exist with both naming conventions and nearly identical content:
- `address-autocomplete.md` vs `address-autocomplete.md`
- `address-implementation.md` vs `address-implementation.md`
- `address-migration-guide.md` vs `address-migration.md` / `address_migration.md`
- `address-model-italian.md` vs `address-model-italian.md`
- `address-relationships.md` vs `address-relationships.md`

### 2. Fragmentation by Detail
Topics are split into too many small files that should be consolidated:
- **Address Resource**: `address-resource.md`, `address-resource-risorsa-filament.md`, `address-resource-analysis.md`, `address-resource-improvements.md`, `address-resource-summary.md`, `address-resource-sumy.md`, `addressresource.md`, etc.
- **Comune Model**: `comune-model.md`, `comune-model.md`, `comune-sushi-analisi.md`, `comune-sushi-conversion.md`, `comune-sushi-implementation.md`, `comune-sushi-analysis.md`, etc.

### 3. Duplicate Analysis and Summaries
Multiple files exist for "Implementation Summary" and "Consolidated Business Logic":
- `implementation-summary.md`, `implementation-summary.md`, `implementation-summary.md`, `implementation-sumy.md`
- `business-logic-analysis.md`, `business-logic-consolidated.md`, `business-logic-overview.md`

### 4. Placeholder and Empty Files
- `sushi-command.md` (1 byte)
- `tomtom-com.md` / `tomtom_com.txt` (0 bytes)
- `qmd-setup.md` (0 bytes)

## Recommended Actions

1. **Consolidate by Topic**: Merge all "Address" related files into a single `wiki/concepts/address-master-guide.md`.
2. **Standardize Naming**: Adopt Kebab-case (`-`) as the standard and remove Snake-case (`_`) duplicates.
3. **Move to Wiki Structure**: Migrate valuable content to `docs/wiki/concepts/`, `docs/wiki/troubleshooting/`, etc., and delete the root `docs/` files.
4. **Remove Placeholders**: Delete 0-byte and 1-byte files.

## Impact

Reducing the file count from 200+ to ~20 well-structured wiki pages will:
- Improve search accuracy for QMD.
- Reduce cognitive load for developers.
- Prevent "stale documentation" where one version is updated but the duplicate isn't.
