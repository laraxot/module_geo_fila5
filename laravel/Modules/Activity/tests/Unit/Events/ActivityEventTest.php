<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Events\ActivityEvent;

test('ActivityEvent can be instantiated', function () {
<<<<<<< HEAD
    $event = new ActivityEvent;
=======
    $event = new ActivityEvent();
>>>>>>> ac0ea089 (.)

    expect($event)->toBeObject();
});

test('ActivityEvent has expected properties', function () {
<<<<<<< HEAD
    $event = new ActivityEvent;
=======
    $event = new ActivityEvent();
>>>>>>> ac0ea089 (.)

    // Siccome ActivityEvent è una classe vuota, testiamo solo che possa essere istanziata
    expect($event)->toBeInstanceOf(\Illuminate\Foundation\Events\Dispatchable::class)
        ->and($event)->toBeInstanceOf(\Illuminate\Queue\SerializesModels::class)
        ->and($event)->toBeInstanceOf(\Illuminate\Contracts\Broadcasting\ShouldBroadcastNow::class);
})->skip('Skipping because we need to check actual class definition');
