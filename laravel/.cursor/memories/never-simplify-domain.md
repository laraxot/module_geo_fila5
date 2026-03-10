# Memory: Domain Simplification Errors (Critical Lesson)

## What Happened

During a refactoring session, these destructive changes were made:

1. `WorkerColumn::make('lavoratore')` and `ValutatoreColumn::make('valutatore')` were replaced with basic `TextColumn` fields - destroying custom rendering
2. Year '2026' was removed from Select options - limiting operational capability
3. `$filters['quadrimestre']` was changed to `$filters[]` - losing semantic key
4. `getHeaderActions()` with `ImportValutatoriAction` was completely deleted - removing import functionality
5. `@include('ptv::pdf.header')` was replaced with inline HTML - breaking shared PDF headers
6. `HasValutatore` trait was removed from `CondizioniLavoro` model - breaking valutatore relationships

## Root Cause

Over-aggressive simplification without understanding domain context. The AI treated domain abstractions as unnecessary complexity.

## Prevention

- ALWAYS read and understand custom classes before modifying
- NEVER replace domain-specific columns/components with generic ones
- NEVER remove functionality (actions, traits, options, includes) during refactoring
- When unsure about a piece of code's purpose, ASK the user
- PHPStan fixes should ONLY change types and signatures, NEVER remove business logic
