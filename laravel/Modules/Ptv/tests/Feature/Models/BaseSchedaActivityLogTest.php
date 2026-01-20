<?php

declare(strict_types=1);

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Datas\XotData;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

/**
 * Test Activity Log per BaseScheda.
 *
 * Verifica che:
 * - Le attività vengano create correttamente
 * - Le properties contengano i cambiamenti (attributes + old)
 * - Solo i campi dirty vengano tracciati
 * - Log vuoti non vengano salvati
 * - La configurazione ->logAll() funzioni correttamente
 */
beforeEach(function () {
    // Pulisci activity log prima di ogni test
    Activity::query()->delete();
});

test('activity is created when model is updated', function () {
    $record = IndennitaResponsabilita::factory()->create();

    $record->update(['stabi' => 999]);

    $activity = Activity::latest()->first();

    expect($activity)
        ->not->toBeNull('Activity deve essere creata')
        ->and($activity->description)->toBe('updated')
        ->and($activity->subject_type)->toBe(IndennitaResponsabilita::class)
        ->and($activity->subject_id)->toBe($record->id);
});

test('activity properties contain old and new values', function () {
    $record = IndennitaResponsabilita::factory()->create([
        'stabi' => 100,
        'coordinamento' => 1,
    ]);

    $record->update([
        'stabi' => 200,
        'coordinamento' => 2,
    ]);

    $activity = Activity::latest()->first();

    expect($activity->properties)
        ->not->toBeEmpty('Properties non devono essere vuote!')
        ->toHaveKey('attributes', 'Properties devono avere chiave attributes')
        ->toHaveKey('old', 'Properties devono avere chiave old');

    expect($activity->properties['attributes'])
        ->toHaveKey('stabi')
        ->toHaveKey('coordinamento');

    expect($activity->properties['attributes']['stabi'])->toBe(200)
        ->and($activity->properties['attributes']['coordinamento'])->toBe(2);

    expect($activity->properties['old']['stabi'])->toBe(100)
        ->and($activity->properties['old']['coordinamento'])->toBe(1);
});

test('only dirty fields are logged', function () {
    $record = IndennitaResponsabilita::factory()->create([
        'stabi' => 100,
        'coordinamento' => 1,
        'responsabilita' => 5,
    ]);

    // Modifica solo stabi, non coordinamento
    $record->update(['stabi' => 200]);

    $activity = Activity::latest()->first();

    expect($activity->properties['attributes'])
        ->toHaveKey('stabi', 'stabi modificato deve essere nelle properties')
        ->not->toHaveKey('coordinamento', 'coordinamento non modificato NON deve essere nelle properties');
});

test('empty logs are not submitted', function () {
    $record = IndennitaResponsabilita::factory()->create(['stabi' => 100]);

    $countBefore = Activity::count();

    // Update con stesso valore (nessun cambiamento)
    $record->update(['stabi' => 100]);

    $countAfter = Activity::count();

    expect($countAfter)->toBe($countBefore, 'Nessuna activity deve essere creata per update senza modifiche');
});

test('activity tracks causer correctly', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    $record = IndennitaResponsabilita::factory()->create();
    $record->update(['stabi' => 999]);

    $activity = Activity::latest()->first();

    expect($activity->causer_id)->toBe($user->getKey())
        ->and($activity->causer_type)->toBe($userClass::class)
        ->and($activity->causer)->not->toBeNull();
});

test('multiple updates create multiple activities', function () {
    $record = IndennitaResponsabilita::factory()->create(['stabi' => 100]);

    $countBefore = Activity::count();

    $record->update(['stabi' => 200]);
    $record->update(['stabi' => 300]);
    $record->update(['stabi' => 400]);

    $countAfter = Activity::count();

    expect($countAfter - $countBefore)->toBe(3, 'Devono essere create 3 activities');
});

test('activity can be retrieved from model relationship', function () {
    $record = IndennitaResponsabilita::factory()->create();

    $record->update(['stabi' => 999]);
    $record->update(['coordinamento' => 5]);

    $activities = $record->activities;

    expect($activities)->toHaveCount(2, 'Il modello deve avere 2 activities')
        ->and($activities->first()->subject_id)->toBe($record->id);
});

test('activity properties can be accessed with changes method', function () {
    $record = IndennitaResponsabilita::factory()->create([
        'stabi' => 100,
        'coordinamento' => 1,
    ]);

    $record->update([
        'stabi' => 200,
        'coordinamento' => 2,
    ]);

    $activity = Activity::latest()->first();
    $changes = $activity->changes();

    expect($changes)
        ->toHaveKey('attributes')
        ->toHaveKey('old')
        ->and($changes['attributes']['stabi'])->toBe(200)
        ->and($changes['old']['stabi'])->toBe(100);
});

test('getActivitylogOptions returns correct configuration', function () {
    $record = IndennitaResponsabilita::factory()->create();
    $options = $record->getActivitylogOptions();

    expect($options)
        ->toBeInstanceOf(LogOptions::class)
        ->and($options->logAttributes)->toContain('*', 'Deve loggare tutti i campi con logAll()')
        ->and($options->submitEmptyLogs)->toBeFalse('Non deve salvare log vuoti');
});
