<?php

declare(strict_types=1);

use Modules\IndennitaResponsabilita\Tests\TestCase;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\CompilaIndennitaResponsabilita;

uses(TestCase::class);

test('can instantiate page', function () {
    $page = new CompilaIndennitaResponsabilita();
    
    expect($page)->toBeInstanceOf(CompilaIndennitaResponsabilita::class);
});

test('has working back method', function () {
    $page = new CompilaIndennitaResponsabilita();
    
    expect(method_exists($page, 'back'))->toBeTrue();
});

test('model has anno attribute', function () {
    $record = new IndennitaResponsabilita();
    $record->anno = 2024;
    $record->cognome = 'Test';
    $record->nome = 'User';
    $record->matr = 12345;
    
    expect($record->anno)->toBe(2024);
    expect($record->cognome)->toBe('Test');
    expect($record->nome)->toBe('User');
    expect($record->matr)->toBe(12345);
});

test('attributes to array includes regular fields', function () {
    $record = new IndennitaResponsabilita();
    $record->anno = 2024;
    $record->cognome = 'Test';
    $record->nome = 'User';
    
    $attributes = $record->attributesToArray();
    
    expect($attributes)->toBeArray();
    expect($attributes['anno'])->toBe(2024);
    expect($attributes['cognome'])->toBe('Test');
    expect($attributes['nome'])->toBe('User');
});