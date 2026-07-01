<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Models\Policies\CondizioniLavoroAdmPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\CondizioniLavoroPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\IndennitaTipoPolicy;
use Modules\IndennitaCondizioniLavoro\Models\Policies\StabiDirigentePolicy;
use Modules\Xot\Contracts\UserContract;

/*
|--------------------------------------------------------------------------
| Policies unit tests (no DB access)
|--------------------------------------------------------------------------
|
| Le Policy di questo modulo non toccano il DB (ritornano booleani statici),
| quindi i test qui usano un mock di UserContract per evitare qualunque
| dipendenza da una connessione DB reale (User::factory() richiederebbe
| l'app container completo per Hash/Faker, non disponibile in questo TestCase).
*/

test('CondizioniLavoroPolicy returns expected static authorization decisions', function (): void {
    $policy = new CondizioniLavoroPolicy();
    $user = Mockery::mock(UserContract::class);

    expect($policy->compila())->toBeTrue();
    expect($policy->viewAny($user))->toBeTrue();
    expect($policy->view())->toBeFalse();
    expect($policy->create())->toBeFalse();
    expect($policy->update())->toBeFalse();
    expect($policy->delete())->toBeFalse();
    expect($policy->restore())->toBeFalse();
    expect($policy->forceDelete())->toBeFalse();
});

test('CondizioniLavoroAdmPolicy returns expected static authorization decisions', function (): void {
    $policy = new CondizioniLavoroAdmPolicy();
    $user = Mockery::mock(UserContract::class);

    expect($policy->compila())->toBeTrue();
    expect($policy->viewAny($user))->toBeFalse();
    expect($policy->view())->toBeFalse();
    expect($policy->create())->toBeFalse();
    expect($policy->update())->toBeFalse();
    expect($policy->delete())->toBeFalse();
    expect($policy->restore())->toBeFalse();
    expect($policy->forceDelete())->toBeFalse();
});

test('IndennitaTipoPolicy returns expected static authorization decisions', function (): void {
    $policy = new IndennitaTipoPolicy();
    $user = Mockery::mock(UserContract::class);

    expect($policy->compila())->toBeTrue();
    expect($policy->viewAny($user))->toBeFalse();
    expect($policy->view())->toBeFalse();
    expect($policy->create())->toBeFalse();
    expect($policy->update())->toBeTrue();
    expect($policy->delete())->toBeFalse();
    expect($policy->restore())->toBeFalse();
    expect($policy->forceDelete())->toBeFalse();
});

test('StabiDirigentePolicy returns expected static authorization decisions', function (): void {
    $policy = new StabiDirigentePolicy();
    $user = Mockery::mock(UserContract::class);

    expect($policy->compila())->toBeTrue();
    expect($policy->viewAny($user))->toBeFalse();
    expect($policy->view())->toBeFalse();
    expect($policy->create())->toBeFalse();
    expect($policy->update())->toBeTrue();
    expect($policy->delete())->toBeFalse();
    expect($policy->restore())->toBeFalse();
    expect($policy->forceDelete())->toBeFalse();
});
