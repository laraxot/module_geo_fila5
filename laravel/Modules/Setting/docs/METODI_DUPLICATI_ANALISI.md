---
module: Setting
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Setting

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Setting**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Setting:**

- `./laravel/Modules/Setting/app/Models/Policies/SettingBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Setting:**

- `./laravel/Modules/Setting/database/factories/DatabaseConnectionFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in Setting:**

- `./laravel/Modules/Setting/app/Models/DatabaseConnection.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in Setting:**

- `./laravel/Modules/Setting/database/factories/DatabaseConnectionFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterSave` (6 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Setting, User, Xot

**File in Setting:**

- `./laravel/Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/EditDatabaseConnection.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRedirectUrl` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, User

**File in Setting:**

- `./laravel/Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/CreateDatabaseConnection.php`
- `./laravel/Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/EditDatabaseConnection.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `download` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, Xot

**File in Setting:**

- `./laravel/Modules/Setting/app/Filament/Pages/BackupMysql.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterCreate` (2 occorrenze)

**Moduli coinvolti:** Incentivi, Setting

**File in Setting:**

- `./laravel/Modules/Setting/app/Filament/Resources/DatabaseConnectionResource/Pages/CreateDatabaseConnection.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per Setting

- **Totale metodi duplicati che coinvolgono Setting:** 8
- **Di cui cross-modulo:** 8
- **Di cui interni al modulo:** 0

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 7 metodi
- **altro:** 1 metodi

### Moduli con maggiori duplicazioni incrociate

- **Tenant:** 15 metodi in comune
- **Xot:** 10 metodi in comune
- **User:** 8 metodi in comune
- **Incentivi:** 6 metodi in comune
- **Lang:** 3 metodi in comune
- **UI:** 3 metodi in comune
- **Performance:** 2 metodi in comune
- **Sigma:** 2 metodi in comune
- **DbForge:** 2 metodi in comune
- **Activity:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
