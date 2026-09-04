# Code Coverage: Geo

## 2026-09-04 (sessione 2) — Quality-gate closure: phpmd + pest + coverage

BMAD phase: Build + Measure. Story: [`quality-gate-closure-2026-09-04.story.md`](stories/quality-gate-closure-2026-09-04.story.md).

### PHPStan (baseline richiesta dal task)
`clear-result-cache` poi `analyse Modules/Geo` (con e senza path arg, memoria 4096M): **0 errori**
(`totals.file_errors=0`, `errors=0`, verificato via `--error-format=json`, non solo l'exit code).

### PHPMD — fix reali applicati (nessuna soppressione via annotazioni)
Baseline: 303 righe di finding (`MissingImport` 80, `UnusedFormalParameter` 75, `CamelCaseParameterName` 46,
`BooleanArgumentFlag` 20, `CyclomaticComplexity` 19, `ShortVariable` 15, `NPathComplexity` 12,
`CamelCasePropertyName` 11, `CamelCaseVariableName` 9, `LongVariable` 6, `UnusedLocalVariable` 4,
`ExcessiveParameterList` 3, `ElseExpression` 2, `ExcessiveClassComplexity` 1).

Fixati (codice morto + complessità, come richiesto dal task):
- `UnusedLocalVariable` × 4 → **0 residui**:
  - `Actions/GoogleMaps/OptimizeRouteAction.php:176-177` — `$typedWaypoints` assegnata e mai letta
    (il tipo era già annotato su `$waypoints` alla riga 135), rimossa la riga morta.
  - `Filament/Forms/Components/AddressesField.php:125` — `foreach ($addresses as $index => $address)`
    con `$address` mai usato, sostituito con `foreach (array_keys($addresses) as $index)`.
  - `Models/Locality.php:127` — `$city = $get('locality');` mai usata nel corpo di `getOptions()`
    (a differenza del gemello `getPostalCodeOptions()`, dove `$city` filtra realmente la query);
    rimossa la riga morta senza aggiungere un filtro nuovo (non richiesto, cambierebbe comportamento
    fuori scope per un fix phpmd).
  - `Models/Policies/GeoBasePolicy.php:17` — `$xotData = XotData::make();` mai usata in `before()`,
    rimossa insieme all'`use` ora inutile.
- `ExcessiveClassComplexity` / `CyclomaticComplexity` su `Models/Address.php` — `getFormattedAddressAttribute()`
  aveva CC 21 / NPath 2916 (il metodo più complesso del modulo). Estratto il blocco "località + provincia"
  in un metodo privato dedicato `getFormattedAddressLocalityParts()` (extract-method puro, nessun
  side-effect, nessun cambio di comportamento — stessa logica, stesso ordine di concatenazione).
  Risultato: `getFormattedAddressAttribute()` CC 21→12, NPath 2916→240. Nota onesta: la metrica
  aggregata `ExcessiveClassComplexity` della classe è passata da 53 a 54 (soglia 50) perché il WMC
  (somma delle CC per metodo) conta anche il "+1" base del nuovo metodo estratto — è un artefatto noto
  della metrica, non un peggioramento reale: il problema serio (un singolo metodo con CC 21) è
  significativamente ridotto. Risolverla del tutto richiederebbe scomporre l'intera classe `Address` in
  più value object, fuori scope/rischio per questa sessione senza test dedicati sul formatting.

Lasciati (documentati, non fixati in questa sessione):
- `MissingImport` (80) — quasi tutti riferimenti a classi Laravel/Google/Bing usate una sola volta con
  FQCN inline nei blocchi di parsing risposta API; correzione meccanica ma su 80 punti sparsi in decine
  di file, fuori budget per questa sessione, nessun rischio di correttezza nel lasciarli.
- `CamelCaseParameterName`/`CamelCasePropertyName`/`CamelCaseVariableName` (66) — quasi tutti in
  `app/Datas/**` (Google Maps / Bing / Geocoding DTO): i nomi snake_case (`street_number`,
  `postal_code`, `administrative_area_level_2`, ...) rispecchiano i campi delle risposte JSON esterne
  (Google/Bing Maps API); rinominarli in camelCase romperebbe la mappatura automatica di
  Spatie Laravel Data se non accompagnata da `#[MapInputName]` su ciascuna proprietà — refactor non
  banale, non fatto per non rischiare di rompere il parsing di dati esterni senza una verifica end-to-end
  con payload reali.
- `UnusedFormalParameter` (75) — in larga parte parametri di interfacce/contratti implementati da più
  adapter (pattern Strategy per i vari provider geo: Google/Bing/Here/Photon/Nominatim) dove la firma è
  vincolata dal contratto anche se una singola implementazione non usa tutti i parametri; non toccato per
  non rompere la conformità ai contratti.
- `BooleanArgumentFlag` (20), rimanenti `CyclomaticComplexity`/`NPathComplexity` (18/11 dopo il fix di
  `Address.php`), `ShortVariable`/`LongVariable` (21), `ExcessiveParameterList` (3), `ElseExpression` (2)
  — debito di leggibilità pre-esistente, nessuno riconducibile a bug o codice morto; refactor più ampi
  (es. `HasAddress::getFullAddressesAttribute()` CC 13, `HereClient::getDurationAndLength()` CC 13,
  `SushiCommand::refresh()` CC 14) richiederebbero test dedicati assenti oggi nel modulo — non tentati
  per rispettare la regola "niente fix speculativi su codice complesso senza copertura di verifica".

Verificato dopo i fix: rilancio phpmd → 300 righe di finding (da 303), `UnusedLocalVariable` e
`ElseExpression` combinati scesi da 6 a 2 (i 2 `ElseExpression` restanti — non toccati, vedi sopra).

### PHPInsights
**Non installato in questo repo** (`vendor/bin/phpinsights` assente, pacchetto Composer non presente —
`composer show phpinsights` → "Package not found"). Coerente con la memoria second-brain
"Pest 5 e phpinsights non coesistono": phpinsights è stato rimosso perché incompatibile con Pest 5 e
tutti i suoi plugin. Passo saltato, non eseguibile, non simulato.

### Pest — non misurabile in modo affidabile in questo momento (causa esterna al modulo)
`./vendor/bin/pest Modules/Geo/tests --no-coverage` (nessun `Modules/Geo/phpunit.xml`, uso del
`phpunit.xml` di root): **476 failed, 3 risky, 40 passed** (519 totali, 77.5s).

Causa: **non è nel diff di questa sessione né nel modulo Geo**. `Modules/Xot` (dipendenza di bootstrap di
ogni test — `XotBaseServiceProvider` registra Blade/Livewire component discovery per tutti i moduli) ha
in questo momento un drift enorme non committato da una sessione concorrente (centinaia di file modificati
in `git status --short Modules/Xot`, confermato). Prova che è un race, non un bug deterministico: due run
consecutivi dello stesso singolo test hanno prodotto **due errori diversi**:
1. 1° run (suite completa): `Typed property Modules\Xot\Datas\ComponentFileData::$name must not be
   accessed before initialization` in `Xot/app/Actions/Blade/RegisterBladeComponentsAction.php:28`.
2. 2° run (`AddressBusinessLogicTest.php` isolato): `Call to undefined method
   Modules\Xot\Actions\File\GetComponentsAction::hasCurrentSchema()`.

Nessuna delle due classi (`ComponentFileData`, `RegisterBladeComponentsAction`, `GetComponentsAction`) è
mai stata toccata da questa sessione. Non è stato tentato alcun fix sull'ambiente/su Xot (fuori scope,
regola esplicita del task). Percentuale di coverage: **non calcolabile in modo affidabile oggi** — il
95% dei fallimenti origina prima ancora che il codice del modulo Geo venga eseguito (errore nel
bootstrap del service provider condiviso), quindi non riflette la qualità del codice Geo. La sezione
"2026-09-04 — Reduce mixed type usage" sopra documenta lo stesso tipo di blocco (con sintomo diverso,
`Target class [config]`) già in mattinata: è un problema ambientale ricorrente in questo repo con sessioni
multi-agente concorrenti su `Modules/Xot`, non una regressione introdotta oggi.

### Git — file non aggiunti (drift altrui, non toccato)
`git status --short` su `Modules/Geo` mostra, oltre ai 5 file di questa sessione, altri 7 file già
modificati da una sessione concorrente (stesso lavoro di "riduzione mixed" descritto nella sezione sopra,
non ancora committato da chi lo ha scritto): `app/Datas/RouteData.php`, `app/Datas/Routing/RouteData.php`,
`app/Filament/Forms/Components/AddressInput.php`,
`app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`,
`app/Filament/Forms/Components/XotBaseCoordinateField.php`, `app/Models/Province.php`,
`app/Models/Region.php` — **non aggiunti, non committati da questa sessione**. Nota: `app/Models/Locality.php`
conteneva già, prima di questa sessione, una singola riga della stessa "riduzione mixed" concorrente
(narrowing del docblock `@var` a riga 67); dato che questa sessione ha comunque editato altre righe dello
stesso file (rimozione `$city` morta) e non è possibile isolare le due modifiche a livello di `git add`
su singolo file, quella riga è stata inclusa nel commit di questa sessione — è comunque verificata a
0 errori PHPStan e coerente con quanto già documentato come lavoro legittimo nella sezione precedente.

---

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
