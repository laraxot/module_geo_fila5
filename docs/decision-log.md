---
type: decision-log
title: "Decision Log — Geo"
links: {github_issue: #XXX, discussion: #XXX}
---
# Decision Log — Geo

## Decisions

### 2026-10-08: Ripristino parziale dei file regrediti dal merge `10076511` del 07/10
- **Choose**: Riportare alla linea buona (`cd999d97e`, 07/10 06:37) `Models/Address`, `Models/Traits/GeoTrait` (blob `2ae1d61a`, con il fix di `7e2fb091` su `scopeWithDistance`), `Models/Traits/HasAddress`, `Adapters/HereClient`, `tests/TestCase.php`, `tests/Unit/Traits/{HasAddressTest,TraitsTest}.php`, `tests/Fixtures/Traits/HasAddressTestModel.php`; eliminare i file assenti sulla linea buona: `app/Traits/HasAddresses.php`, `tests/Unit/Traits/TestModel.php` e le fixture `*PhpstanProbe*` / `HasAddressesTestModel`.
- **Over**: Ripristinare tutto il modulo, o tenere lo stato attuale.
- **Because**: Il merge `10076511` ha preso per 113 file di codice il lato `bfd4966a`, una copia di lavoro ferma al 28/09 (tutti identici alla base `f0ca6e67`). I file scelti sono quelli dei file gravi e le loro dipendenze dirette, mai toccati dopo il merge; le fixture erano già state rimosse su linea buona da `d1cedf07` ("rimossi i probe PHPStan tornati") e da Marco il 05/10.
- **Lasciato fuori di proposito**: gli altri ~70 file ancora alla copia del 28/09 e i 23 modificati dopo il merge da Marco l'08/10 (`b112b61b`, `f9e8b556`, `e46ede56`: servizi eliminati, action `GeoData` riscritte). Il merge a tre vie dà 12 file in conflitto tra due progetti diversi della stessa parte: da decidere con Marco.
- **Verifica**: `php -l`; PHPStan su `Modules/Geo` senza errori; test prima/dopo identici.
## Open Questions

