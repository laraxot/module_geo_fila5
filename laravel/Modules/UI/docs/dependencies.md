# Dependencies (Module UI)

Canonical dependency map:

- [../../../../docs/dependencies.md](../../../../docs/dependencies.md)

Module/theme specific notes:

<<<<<<< HEAD
- UI è un modulo infrastrutturale: **non deve mai dipendere da moduli dominio** (GEO, Ptv, Sigma, ecc.)
- I moduli dominio possono dipendere da UI, mai il contrario.
- Questa regola previene dipendenze circolari e mantiene UI agnostica rispetto al dominio applicativo.
- Violazione nota e corretta: `InteractiveMap.php` (rimosso, apparteneva a GEO).
=======
- (add notes here when a dependency is directly used by this module/theme)
>>>>>>> laraxot/dev

Installed packages index:

- [../../../../docs/packages/index.md](../../../../docs/packages/index.md)
