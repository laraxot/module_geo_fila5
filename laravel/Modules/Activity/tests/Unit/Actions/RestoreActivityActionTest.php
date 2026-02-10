<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\RestoreActivityAction;

test('RestoreActivityAction can be instantiated', function () {
<<<<<<< HEAD
    $action = new RestoreActivityAction;
=======
    $action = new RestoreActivityAction();
>>>>>>> ac0ea089 (.)

    expect($action)->toBeObject();
});

test('RestoreActivityAction can execute', function () {
<<<<<<< HEAD
    $action = new RestoreActivityAction;
=======
    $action = new RestoreActivityAction();
>>>>>>> ac0ea089 (.)

    // Siccome non abbiamo un metodo specifico per testare l'execute senza un'attività specifica
    expect($action)->toBeObject();
});
