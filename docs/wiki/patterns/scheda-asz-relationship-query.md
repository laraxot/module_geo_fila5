---
title: "Pattern query ASZ via relazione scheda"
type: pattern
tags: [asz, scheda, sigma, progressioni, ptv, eloquent]
created: 2026-06-15
updated: 2026-06-15
qmd: "scheda asz ofRangeDate ListaAszTipCodEsclusoSubito ProgressioniFunctionTrait"
related:
  - ../rules/eloquent-relationship-encapsulation.md
  - ../memories/eloquent-relationships-dry-kiss.md
  - ../../../laravel/Modules/Ptv/app/Actions/CriteriEsclusione/ListaAszTipCodEsclusoSubito.php
  - ../../../laravel/Modules/Progressioni/app/Models/Traits/ProgressioniFunctionTrait.php
---

# Pattern query ASZ via relazione scheda

## Scopo business

Criteri esclusione progressioni: verificare se il dipendente ha codici ASZ (tipo-codice) in un intervallo date che comportano esclusione immediata.

## Catena canonica

```php
$tmp = $scheda->asz()
    ->ofRangeDate($asz_dal, $asz_al)
    ->select('asztip', 'aszcod')
    ->distinct()
    ->get()
    ->toArray();
```

## Cosa incapsula `asz()` (non ripetere in action)

Da `BaseScheda::asz()` (fonte unica DRY):

- `hasMany(Asz00k1::class, 'matr', 'matr')`
- `where($tbl.'.ente', $this->ente)`
- `where($tbl.'.aszann', '')`

Scope `ofRangeDate` è su **Asz00k1** (`@method static Builder|Asz00k1 ofRangeDate(int, int)`).

## Consumer

| File | Ruolo |
|------|-------|
| `ListaAszTipCodEsclusoSubito` | Action Ptv criteri esclusione |
| `ProgressioniFunctionTrait` | Stessa logica su `$this->asz()` |

## Tipo contratto

`SchedaContract` con `@method HasMany<Asz00k1, Model> asz()` — Larastan inoltra scope `ofRangeDate` da `Asz00k1`.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Ptv/app/Actions/CriteriEsclusione/ListaAszTipCodEsclusoSubito.php
```
