---
module: Rating
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi Rating

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **Rating**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `user` (10 occorrenze)

**Moduli coinvolti:** Activity, Job, Rating, User, Xot

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/RatingMorph.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getActions` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Progressioni, Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Filament/Resources/RatingMorphResource/Pages/EditRatingMorph.php`
- `./laravel/Modules/Rating/app/Filament/Resources/RatingMorphResource/Pages/ListRatingMorphs.php`
- `./laravel/Modules/Rating/app/Filament/Resources/RatingResource/Pages/EditRating.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `profile` (5 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/RatingMorph.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getStats` (5 occorrenze)

**Moduli coinvolti:** Rating, UI, User, Xot

**File in Rating:**

- `./laravel/Modules/Rating/app/Filament/Resources/HasRatingResource/Widgets/StatsOverview.php`
- `./laravel/Modules/Rating/app/Filament/Widgets/StatsOverview.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `ratings` (4 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Contracts/HasRatingContract.php`
- `./laravel/Modules/Rating/app/Models/Traits/HasRating.php`
- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getSlugOptions` (4 occorrenze)

**Moduli coinvolti:** Lang, Notify, Rating, User

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/BaseRating.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `scopeWithExtraAttributes` (3 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/BaseRating.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `fromString` (3 occorrenze)

**Moduli coinvolti:** Pdnd, Rating, Xot

**File in Rating:**

- `./laravel/Modules/Rating/app/Enums/SupportedLocale.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `setMyRatingAttribute` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `scopeWithRating` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `registerMediaConversions` (2 occorrenze)

**Moduli coinvolti:** Media, Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/BaseRating.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ratingObjectives` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `ratingAvgHtml` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `myRatings` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `model` (2 occorrenze)

**Moduli coinvolti:** Rating, Tenant

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/RatingMorph.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `likedBy` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Contracts/HasLikeContract.php`
- `./laravel/Modules/Rating/app/Models/Traits/HasLikes.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isLikedBy` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Contracts/HasLikeContract.php`
- `./laravel/Modules/Rating/app/Models/Traits/HasLikes.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRatingsCountAttribute` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRatingsAvgAttribute` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getMyRatingAttribute` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Models/Traits/HasRatingsTrait.php`
- `./laravel/Modules/Rating/app/Models/Traits/RatingTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `dislikedBy` (2 occorrenze)

**Moduli coinvolti:** Rating

**File in Rating:**

- `./laravel/Modules/Rating/app/Contracts/HasLikeContract.php`
- `./laravel/Modules/Rating/app/Models/Traits/HasLikes.php`

[Riflessione: Duplicato interno al modulo Rating — valutare estrazione in trait di modulo o classe base]

---

## Riflessioni per Rating

- **Totale metodi duplicati che coinvolgono Rating:** 21
- **Di cui cross-modulo:** 9
- **Di cui interni al modulo:** 12

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 19 metodi
- **altro:** 2 metodi

### Moduli con maggiori duplicazioni incrociate

- **User:** 10 metodi in comune
- **Xot:** 7 metodi in comune
- **Job:** 3 metodi in comune
- **IndennitaResponsabilita:** 3 metodi in comune
- **Activity:** 1 metodi in comune
- **Progressioni:** 1 metodi in comune
- **UI:** 1 metodi in comune
- **Lang:** 1 metodi in comune
- **Notify:** 1 metodi in comune
- **Pdnd:** 1 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
