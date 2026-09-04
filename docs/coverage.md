# Code Coverage: Geo

## 2026-09-04 — Reduce mixed type usage (best-effort)

### Scope
BMAD phase: Dev (targeted refactor, no new artefact folder — story below). Task: reduce native/docblock
`mixed` usage in `Modules/Geo` where a concrete type is genuinely knowable, per project convention
("dove possibile"). Module had ~363 `mixed` occurrences across 94 files at start; this is a best-effort
pass, not full coverage.

### Collision with a concurrent session (important)
`git status --short` on `Modules/Geo` showed pre-existing uncommitted changes BEFORE this session
touched anything: `app/Datas/RouteData.php`, `app/Datas/Routing/RouteData.php`, `app/Models/Address.php`,
`app/Models/Locality.php`, `app/Models/Province.php`, `app/Models/Region.php` — all `mixed → concrete type`
edits, i.e. another agent working the same task on the same nested repo in parallel. While this session
was working, that other agent kept editing live: `app/Filament/Forms/Components/AddressInput.php`,
`app/Filament/Forms/Components/Support/CoordinatePickerHelpers.php`,
`app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`,
`app/Filament/Forms/Components/XotBaseCoordinateField.php` changed under us mid-session (confirmed by
re-diffing). Per instructions, this session did not touch, revert, or commit any of those files — they
are not "my own changes". Two problems were observed in that other WIP (not fixed here, not mine to fix):
- `app/Models/Address.php:191` — `getRegione()` docblock narrowed to
  `array{codice: int|string, nome: string}|null` but the method body still returns raw `mixed` values from
  a JSON column read, so PHPStan now fails with `return.type` (1 error, present before and after this
  session's edits — verified with a full-module run at both points).
- `app/Filament/Forms/Components/XotBaseCoordinateField.php` — narrowing
  `CoordinatePickerHelpers::normalizeCoordinate()` to `float|int|string|null` without narrowing all call
  sites introduced multiple `argument.type` errors (mixed passed where the narrower union is expected).
  Full-module PHPStan went from 1 error (baseline, itself caused by the same external WIP) to 61 errors
  by the end of this session, entirely from that other agent's concurrent edits to files this session
  never touched.

### What this session changed (5 files, 6 occurrences)
- `app/Actions/GoogleMaps/GetAddressFromGoogleMapsAction.php` — `Collection::first(function (mixed
  $component) ...)` narrowed to `GoogleMapAddressComponentData $component` (the source collection is
  `DataCollection<int, GoogleMapAddressComponentData>->toCollection()`); dropped the now-redundant
  `instanceof` guard.
- `app/Datas/GeoData.php` — `@var array<mixed> $latlng` narrowed to
  `array{lat?: float|int, lng?: float|int}` (shape confirmed by every consumer in `GeoTrait.php`
  reading `$latlng['lat']` / `$latlng['lng']`).
- `app/Filament/Resources/LocationResource.php` — `getRelations()`/`getPages()` docblocks widened from
  `array<mixed>` to the exact parent contract types
  (`array<class-string<RelationManager>|RelationGroup|RelationManagerConfiguration>` and
  `array<string, PageRegistration>`), matching `Filament\Resources\Resource` /
  `Filament\Resources\Resource\Concerns\HasPages`.
- `app/Filament/Resources/Pages/ListLocations.php` — `getTableComumns(): array<int, mixed>` narrowed to
  `array<int, TextColumn>` (method body only ever returns `TextColumn::make(...)` instances; note the
  method name itself has a pre-existing typo — `getTableComumns` vs `getTableColumns` — so it never
  actually overrides the base hook; that bug is out of scope here).
- `app/Models/Traits/GeoTrait.php` — `getLatitudeAttribute(mixed $value)` narrowed to
  `getLatitudeAttribute(float|int|string|null $value)`; this is Eloquent's magic accessor for the
  `float`-cast `latitude` column (see `@property float $latitude` docblock on the trait), so the raw
  attribute value is never anything else.

### Left as mixed, with reason
- All `array<string, mixed>` return/param types on external API responses (Google/Here/Mapbox/Photon/
  Nominatim/OpenWeather actions, `GeoServiceFacade`) — genuinely heterogeneous third-party JSON payloads.
- `IsPointInPolygonAction::execute(array $polygon)` (`array<mixed>`) — each element can be an array or
  object-like structure with `lat`/`lng`; not confidently narrowable without touching call sites.
- `SushiToJsons::findIndex(mixed $id)` — compared against `Model::getKey()`, which Laravel itself types
  as `@return mixed` (no native return type in the framework); narrowing the parameter would risk a new
  `argument.type` error at every call site without fixing the actual source of the `mixed`.
- `GeoTrait::setAddressAttribute(mixed $value)` — the method genuinely accepts `string|array|null` and
  passes any other scalar straight through unmodified; `mixed` is accurate here, not a typing gap.
- Filament closures (`afterStateHydrated`, form/table builder arrays such as
  `AddressResource::getSearchStep(): array<string, mixed>`) — vendor-contract callback signatures;
  left alone in files this session touched (the concurrent session narrowed some of these in files it
  owns — see collision note above, not evaluated further here).
- Collection `->pluck(...)->filter(fn (mixed $v) => ...)` closures (`OSMMapWidget`,
  `BuildGeoMapWidgetPayloadAction`) — `pluck()` on an untyped-by-key collection resolves to
  `Collection<int, mixed>` in Larastan; the closure parameter must match.
- Model factory `definition(): array<string, mixed>` — standard `Illuminate\Database\Eloquent\Factories\
  Factory::definition()` contract shape, left as-is across all factories.

### PHPStan
- Baseline (before this session's first edit, working tree already carrying the other session's WIP):
  1 error (`app/Models/Address.php:191`, not caused by this session).
- After this session's edits, scoped to the 5 files touched: 0 errors.
- After this session's edits, full module (`analyse Modules/Geo`): 61 errors — all newly introduced by
  the concurrent session's live edits to files this session did not touch (see collision note). This
  session's own diff does not add any error.

### PHPMD
`./tools/phpmd.sh Modules/Geo text ../docs/phpmd.ruleset.xml` ran to completion (no crash). Findings are
pre-existing style/complexity debt (`CyclomaticComplexity`, `UnusedFormalParameter`, `ShortVariable`,
`CamelCase*`, `MissingImport`, `BooleanArgumentFlag`, `ExcessiveMethodLength`) unrelated to this diff;
none of the flagged lines are in the 5 files this session edited.

### Pest
No `Modules/Geo/phpunit.xml` exists, so the Pest step was skipped per instructions. The existing section
above (previous run) already documents pre-existing, diff-unrelated suite failures (98 failed / 53 passed,
`BindingResolutionException: Target class [config] does not exist` in `HasAddressTest`), consistent with
the known env/config issue for this module's test suite.

---


**Lines Coverage:** N/A (Failed to parse)
**Test Exit Code:** 2

## Output

```text
────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47

  ──────────────────────────────────────────────────────────────────────────────────────  
   FAILED  Modules\Geo\tests\Unit\Traits\HasAddressTest >…   BindingResolutionException   
  Target class [config] does not exist.

  at vendor/laravel/framework/src/Illuminate/Container/Container.php:1122
    1118▕             }
    1119▕         }
    1120▕ 
    1121▕         try {
  ➜ 1122▕             $reflector = new ReflectionClass($concrete);
    1123▕         } catch (ReflectionException $e) {
    1124▕             throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
    1125▕         }
    1126▕

      [2m+13 vendor frames [22m
  14  Modules/Geo/tests/Unit/Traits/HasAddressTest.php:47


  Tests:    98 failed, 22 warnings, 53 passed (224 assertions)
  Duration: 12.20s


```
