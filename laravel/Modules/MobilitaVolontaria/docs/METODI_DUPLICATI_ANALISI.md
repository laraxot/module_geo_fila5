---
module: MobilitaVolontaria
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi MobilitaVolontaria

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **MobilitaVolontaria**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `getDescription` (12 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Notify, Pdnd, Seo, UI, Xot

**File in MobilitaVolontaria:**

- `./laravel/Modules/MobilitaVolontaria/app/Models/Panels/_ModulePanel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConnectionName` (5 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Tenant, User, Xot

**File in MobilitaVolontaria:**

- `./laravel/Modules/MobilitaVolontaria/app/Models/BaseModel.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Riflessioni per MobilitaVolontaria

- **Totale metodi duplicati che coinvolgono MobilitaVolontaria:** 2
- **Di cui cross-modulo:** 2
- **Di cui interni al modulo:** 0

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 2 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 4 metodi in comune
- **Pdnd:** 3 metodi in comune
- **UI:** 3 metodi in comune
- **Seo:** 2 metodi in comune
- **Notify:** 1 metodi in comune
- **Tenant:** 1 metodi in comune
- **User:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
