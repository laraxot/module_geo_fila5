<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;

test('Snapshot model can be instantiated', function () {
<<<<<<< HEAD
    $snapshot = new Snapshot;
=======
    $snapshot = new Snapshot();
>>>>>>> ac0ea089 (.)

    expect($snapshot)->toBeInstanceOf(Snapshot::class);
});

test('StoredEvent model can be instantiated', function () {
<<<<<<< HEAD
    $storedEvent = new StoredEvent;
=======
    $storedEvent = new StoredEvent();
>>>>>>> ac0ea089 (.)

    expect($storedEvent)->toBeInstanceOf(StoredEvent::class);
});

test('BaseModel model can be instantiated', function () {
<<<<<<< HEAD
    $baseModel = new BaseModel;
=======
    $baseModel = new BaseModel();
>>>>>>> ac0ea089 (.)

    expect($baseModel)->toBeInstanceOf(BaseModel::class);
});

test('Snapshot model has correct connection', function () {
<<<<<<< HEAD
    $snapshot = new Snapshot;
=======
    $snapshot = new Snapshot();
>>>>>>> ac0ea089 (.)

    expect($snapshot->getConnectionName())->toBeString();
});

test('StoredEvent model has correct connection', function () {
<<<<<<< HEAD
    $storedEvent = new StoredEvent;
=======
    $storedEvent = new StoredEvent();
>>>>>>> ac0ea089 (.)

    expect($storedEvent->getConnectionName())->toBeString();
});

test('BaseModel model has correct connection', function () {
<<<<<<< HEAD
    $baseModel = new BaseModel;
=======
    $baseModel = new BaseModel();
>>>>>>> ac0ea089 (.)

    expect($baseModel->getConnectionName())->toBeString();
});
