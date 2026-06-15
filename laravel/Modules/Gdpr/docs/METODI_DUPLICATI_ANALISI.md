---
module: Gdpr
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Gdpr

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Gdpr**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Models/Policies/GdprBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `canView` (7 occorrenze)

**Moduli coinvolti:** Gdpr, Lang, UI, User, Xot

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `booted` (6 occorrenze)

**Moduli coinvolti:** Gdpr, Incentivi, Sigma, User

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Models/Consent.php`
- `./laravel/Modules/Gdpr/app/Models/Event.php`
- `./laravel/Modules/Gdpr/app/Models/Treatment.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `submit` (5 occorrenze)

**Moduli coinvolti:** Gdpr, IndennitaResponsabilita, User, Xot

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `registerMyMiddleware` (2 occorrenze)

**Moduli coinvolti:** Gdpr, Xot

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Providers/GdprServiceProvider.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `logRegistrationAttempt` (2 occorrenze)

**Moduli coinvolti:** Gdpr

**File in Gdpr:**

- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/GdprConsentForm.php`
- `./laravel/Modules/Gdpr/app/Filament/Widgets/Auth/RegisterWidget.php`

[Riflessione: Duplicato interno al modulo Gdpr — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isRequired` (2 occorrenze)

**Moduli coinvolti:** Gdpr

**File in Gdpr:**

- `./laravel/Modules/Gdpr/Enums/ConsentType.php`
- `./laravel/Modules/Gdpr/app/Enums/ConsentType.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRequiredConsentTypes` (2 occorrenze)

**Moduli coinvolti:** Gdpr

**File in Gdpr:**

- `./laravel/Modules/Gdpr/Enums/ConsentType.php`
- `./laravel/Modules/Gdpr/app/Enums/ConsentType.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getOptionalConsentTypes` (2 occorrenze)

**Moduli coinvolti:** Gdpr

**File in Gdpr:**

- `./laravel/Modules/Gdpr/Enums/ConsentType.php`
- `./laravel/Modules/Gdpr/app/Enums/ConsentType.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Riflessioni per Gdpr

- **Totale metodi duplicati che coinvolgono Gdpr:** 9
- **Di cui cross-modulo:** 5
- **Di cui interni al modulo:** 4

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 8 metodi
- **altro:** 1 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 5 metodi in comune
- **User:** 4 metodi in comune
- **Lang:** 2 metodi in comune
- **Performance:** 2 metodi in comune
- **Sigma:** 2 metodi in comune
- **UI:** 2 metodi in comune
- **Activity:** 1 metodi in comune
- **Job:** 1 metodi in comune
- **Media:** 1 metodi in comune
- **Progressioni:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
