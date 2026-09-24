---
title: HasAddresses — rimosso (usa HasAddress)
type: concept
tags: [geo, trait, deprecated, has-address]
updated_at: '2026-09-24'
qmd: hasaddresses removed dead hasaddress canon
---

# HasAddresses rimosso

`Modules\Geo\Traits\HasAddresses` era un duplicato **senza consumer** di
[`HasAddress`](../has-address-trait.md) (`Models\Traits`), tenuto in vita solo da
`@phpstan-ignore trait.unused` e da un test `trait_exists`.

**Canon:** `Modules\Geo\Models\Traits\HasAddress` + fixture `HasAddressTestModel`.

Relazioni tipizzate (`homeAddress` / `workAddress` / …) non erano usate in produzione;
se servono, vanno aggiunte a `HasAddress` con consumer reale (niente probe).

Vedi anche: [no-phpstan-probe-policy.md](../no-phpstan-probe-policy.md) · [geo-trait.md](./geo-trait.md)
