---
status: verifying
trigger: "Debug and fix critical database issue - fixcity_data.sqlite missing + ModelContract getKey() signature incompatibility"
created: 2026-04-09T12:00:00Z
updated: 2026-04-09T12:15:00Z
---

## Current Focus

hypothesis: CONFIRMED AND FIXED - ModelContract had incompatible method signatures
test: Verified all migrations ran, test pages return 200
expecting: All clear
next_action: "Archive session and commit"

## Symptoms

expected: Database exists, migrations run successfully, CMS pages load from DB, test pages return HTTP 200
actual: fixcity_data.sqlite doesn't exist, migrations fail with getKey() signature incompatibility, all pages return HTTP 500
errors: "Declaration of Illuminate\Database\Eloquent\Model::getKey() must be compatible with Modules\Xot\Contracts\ModelContract::getKey(): mixed"
reproduction: "curl http://127.0.0.1:8000/it/tests/segnalazione-crea returns 500; php artisan migrate fails"
started: Database file was never created or was deleted; contract signature is wrong

## Eliminated

- hypothesis: Database file doesn't exist
  evidence: File exists at laravel/database/fixcity_data.sqlite (12KB, created today at 12:17)
  timestamp: 2026-04-09T12:05:00Z

## Evidence

- timestamp: 2026-04-09T12:02:00Z
  checked: laravel/.env
  found: DB_CONNECTION=sqlite, DB_DATABASE=fixcity_data
  implication: Database path resolves to database_path('fixcity_data.sqlite') = laravel/database/fixcity_data.sqlite

- timestamp: 2026-04-09T12:02:00Z
  checked: laravel/config/database.php
  found: sqlite connection uses database_path(env('DB_DATABASE', 'database').'.sqlite')
  implication: Path resolution confirmed

- timestamp: 2026-04-09T12:03:00Z
  checked: Modules/Xot/app/Contracts/ModelContract.php
  found: Interface declares `public function getKey(): mixed;` and `public function getRelationValue(string $key): mixed;` with merge conflict markers (<<<<<<< HEAD / ======= / >>>>>>> 9506daa5)
  implication: These methods conflict with Laravel Model which has different signatures. Also has leftover git merge conflict markers in PHPDoc.

- timestamp: 2026-04-09T12:03:00Z
  checked: Modules/Xot/app/Models/XotBaseModel.php
  found: extends Eloquent Model, does NOT implement ModelContract directly. Has $connection = 'xot'
  implication: Models extending XotBaseModel use 'xot' connection which is not defined in database.php

- timestamp: 2026-04-09T12:04:00Z
  checked: Modules/Cms/app/Models/BaseModel.php
  found: extends XotBaseModel, overrides $connection = 'cms'
  implication: CMS models use 'cms' connection which is also not defined in database.php

- timestamp: 2026-04-09T12:04:00Z
  checked: Modules/Cms/app/Models/Page.php
  found: extends BaseModelLang -> BaseModel -> XotBaseModel. Uses SushiToJsons trait (Sushi pattern - loads from array, not DB)
  implication: Page model uses Sushi pattern - data comes from getRows() method, not from database table

- timestamp: 2026-04-09T12:05:00Z
  checked: php artisan migrate:status
  found: ALL migrations are Pending - no tables exist yet
  implication: Database file exists but is empty (no schema)

- timestamp: 2026-04-09T12:08:00Z
  checked: php artisan migrate --force
  found: Confirms error: "Declaration of Illuminate\Database\Eloquent\Model::getKey() must be compatible with Modules\Xot\Contracts\ModelContract::getKey(): mixed"
  implication: This is the blocking error preventing all database operations

- timestamp: 2026-04-09T12:10:00Z
  checked: ReflectionMethod on Model::getKey() and Model::getRelationValue()
  found: Both methods have NO return type declarations in Laravel Model
  implication: Interface declaring `: mixed` is incompatible - PHP sees it as a stricter contract than Model provides

- timestamp: 2026-04-09T12:12:00Z
  checked: php artisan migrate --force (after removing getKey() from interface)
  found: Still fails: "Declaration of ... getRelationValue($key) must be compatible with ... getRelationValue(string $key): mixed"
  implication: getRelationValue also needs to be removed

- timestamp: 2026-04-09T12:13:00Z
  checked: php artisan migrate --force (after removing getRelationValue too)
  found: ALL migrations ran successfully
  implication: Root cause fixed

- timestamp: 2026-04-09T12:15:00Z
  checked: curl test pages
  found: segnalazione-crea=200, homepage=200, segnalazione-dettaglio=200
  implication: All test pages working

## Resolution

root_cause: "Modules\\Xot\\Contracts\\ModelContract interface declared getKey(): mixed and getRelationValue(string $key): mixed which are incompatible with Laravel's Model methods that have no return type declarations. Also contained leftover git merge conflict markers in PHPDoc."
fix: "Removed getKey(): mixed and getRelationValue(string $key): mixed from ModelContract interface. Cleaned up merge conflict markers (<<<<<<< HEAD / ======= / >>>>>>> 9506daa5) from PHPDoc. Removed unused Pivot import."
verification: "All migrations ran successfully. Test pages return HTTP 200: segnalazione-crea, homepage, segnalazione-dettaglio."
files_changed: ["laravel/Modules/Xot/app/Contracts/ModelContract.php"]
