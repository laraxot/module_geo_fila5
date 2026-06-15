---
module: UI
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi UI

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **UI**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Models/Policies/UiBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Pages/Dashboard.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/database/factories/BaseModelFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getDescription` (12 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Notify, Pdnd, Seo, UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Enums/FieldTypeEnum.php`
- `./laravel/Modules/UI/app/Enums/TableLayoutEnum.php`
- `./laravel/Modules/UI/app/Filament/Widgets/TestChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getType` (10 occorrenze)

**Moduli coinvolti:** Performance, Seo, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/TestChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in UI:**

- `./laravel/Modules/UI/app/Rules/OpeningHoursRule.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/database/factories/BaseModelFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getData` (8 occorrenze)

**Moduli coinvolti:** Lang, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/StatWithIconWidget.php`
- `./laravel/Modules/UI/app/Filament/Widgets/TestChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `options` (7 occorrenze)

**Moduli coinvolti:** Notify, Performance, UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Forms/Components/RadioCollection.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getColumns` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Progressioni, UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/HeroWidget.php`
- `./laravel/Modules/UI/app/Filament/Widgets/RowWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `canView` (7 occorrenze)

**Moduli coinvolti:** Gdpr, Lang, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/RedirectWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getStats` (5 occorrenze)

**Moduli coinvolti:** Rating, UI, User, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/HeroWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCards` (5 occorrenze)

**Moduli coinvolti:** Job, Ptv, UI

**File in UI:**

- `./laravel/Modules/UI/app/Forms/Components/RadioCardSelector.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `cards` (4 occorrenze)

**Moduli coinvolti:** Performance, UI

**File in UI:**

- `./laravel/Modules/UI/app/Forms/Components/RadioCardSelector.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateFilters` (3 occorrenze)

**Moduli coinvolti:** Ptv, UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `setTableLayout` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Actions/Table/HasTableLayout.php`
- `./laravel/Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`
- `./laravel/Modules/UI/app/Traits/TableLayoutTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `normalizeFormSchema` (3 occorrenze)

**Moduli coinvolti:** UI, User

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/UserCalendarWidget.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getTableLayout` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Actions/Table/HasTableLayout.php`
- `./laravel/Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`
- `./laravel/Modules/UI/app/Traits/TableLayoutTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSuggestions` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Contracts/GeocodingServiceContract.php`
- `./laravel/Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`
- `./laravel/Modules/UI/app/Services/Map/NullGeocodingService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRatios` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Blocks/Image.php`
- `./laravel/Modules/UI/app/Filament/Blocks/ImagesGallery.php`
- `./laravel/Modules/UI/app/Filament/Blocks/VideoSpatie.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRatioClass` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Blocks/Image.php`
- `./laravel/Modules/UI/app/Filament/Blocks/ImagesGallery.php`
- `./laravel/Modules/UI/app/Filament/Blocks/VideoSpatie.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `exportData` (3 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Contracts/MapServiceContract.php`
- `./laravel/Modules/UI/app/Livewire/Components/Map/InteractiveMap.php`
- `./laravel/Modules/UI/app/Services/Map/NullMapService.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `toggle` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Enums/TableLayout.php`
- `./laravel/Modules/UI/app/Enums/TableLayoutEnum.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `toggleDarkMode` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Widgets/DarkModeSwitcherWidget.php`
- `./laravel/Modules/UI/app/Http/Livewire/DarkModeSwitcher.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `stateClass` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Tables/Columns/IconStateGroupColumn.php`
- `./laravel/Modules/UI/app/Filament/Tables/Columns/IconStateSplitColumn.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `saveLayout` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Actions/Table/HasTableLayout.php`
- `./laravel/Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resetLayout` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Actions/Table/HasTableLayout.php`
- `./laravel/Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `normalizeViewData` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Actions/Block/ResolveLocalizedBlockDataAction.php`
- `./laravel/Modules/UI/app/View/Components/Render/Block.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `metatag` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/View/Composers/ThemeComposer.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getMarkers` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Contracts/MapServiceContract.php`
- `./laravel/Modules/UI/app/Services/Map/NullMapService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getMapStats` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Contracts/MapServiceContract.php`
- `./laravel/Modules/UI/app/Services/Map/NullMapService.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHelperText` (2 occorrenze)

**Moduli coinvolti:** UI, User

**File in UI:**

- `./laravel/Modules/UI/app/Enums/TableLayoutEnum.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getDefaultChildComponents` (2 occorrenze)

**Moduli coinvolti:** Lang, UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCurrentLayout` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Actions/Table/HasTableLayout.php`
- `./laravel/Modules/UI/app/Filament/Actions/Table/TableLayoutTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getBlockSchema` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Blocks/Navigation.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `geocodeAddress` (2 occorrenze)

**Moduli coinvolti:** UI

**File in UI:**

- `./laravel/Modules/UI/app/Contracts/GeocodingServiceContract.php`
- `./laravel/Modules/UI/app/Services/Map/NullGeocodingService.php`

[Riflessione: Duplicato interno al modulo UI — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `custom` (2 occorrenze)

**Moduli coinvolti:** Activity, UI

**File in UI:**

- `./laravel/Modules/UI/app/Filament/Components/SpatieDocumentUpload.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `asset` (2 occorrenze)

**Moduli coinvolti:** UI, Xot

**File in UI:**

- `./laravel/Modules/UI/app/Services/UIService.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per UI

- **Totale metodi duplicati che coinvolgono UI:** 38
- **Di cui cross-modulo:** 22
- **Di cui interni al modulo:** 16

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 33 metodi
- **altro:** 5 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 24 metodi in comune
- **User:** 17 metodi in comune
- **Tenant:** 11 metodi in comune
- **Job:** 8 metodi in comune
- **Performance:** 8 metodi in comune
- **Pdnd:** 7 metodi in comune
- **Notify:** 5 metodi in comune
- **Lang:** 4 metodi in comune
- **Progressioni:** 4 metodi in comune
- **Ptv:** 4 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
