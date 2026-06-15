---
title: "CanComment ritirato — placement errato"
type: rule
module: User
tags: [can-comment, models-contracts, retired]
created: 2026-06-10
updated: 2026-06-10
qmd: "User CanComment app Contracts wrong Models Contracts retired"
---

# CanComment — non più in User

`CanComment` era capability **solo Model** ma finì in `app/Contracts/` — viola [models-contracts-placement](../../../../docs/wiki/rules/models-contracts-placement.md).

- Ritirato: `app/Models/Contracts/CanComment.php.old`
- SSOT: `Modules\Comment\Models\Contracts\CanComment`
- `BaseUser implements Comment\Models\Contracts\CanComment`

Non reintrodurre alias attivi in User.
