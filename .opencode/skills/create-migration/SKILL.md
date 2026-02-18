---
name: create-migration
description: Create database migrations following Laravel 12 and Laraxot conventions. Use when adding or modifying database tables for any module.
---

# Create Migration - Database Schema Management

Create properly structured database migrations for modules.

## When to Use

- Adding new database tables
- Modifying existing table structures
- Adding indexes or foreign keys
- When creating a new model that needs a table

## Template: Create Table Migration

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('{table_name}', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('data')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('{table_name}');
    }
};
```

## Template: Modify Table Migration

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('{table_name}', function (Blueprint $table): void {
            $table->string('new_column')->nullable()->after('existing_column');
        });
    }

    public function down(): void
    {
        Schema::table('{table_name}', function (Blueprint $table): void {
            $table->dropColumn('new_column');
        });
    }
};
```

## Location

Module migrations go in:
```
Modules/{Module}/database/migrations/{date}_{description}.php
```

## Naming Convention

```
{YYYY}_{MM}_{DD}_{HHMMSS}_create_{table}_table.php
{YYYY}_{MM}_{DD}_{HHMMSS}_add_{column}_to_{table}_table.php
{YYYY}_{MM}_{DD}_{HHMMSS}_modify_{description}_in_{table}_table.php
```

## Rules

1. Use `declare(strict_types=1)` always
2. Use anonymous class syntax (`return new class extends Migration`)
3. Type all closure parameters (`function (Blueprint $table): void`)
4. Always include `down()` method for rollback capability
5. Use `foreignId()` with `constrained()` for foreign keys
6. Add proper indexes for frequently queried columns
7. Use `nullable()` appropriately - don't make everything nullable

## Running Migrations

```bash
cd laravel && php artisan migrate
cd laravel && php artisan migrate --path=Modules/{Module}/database/migrations
```
