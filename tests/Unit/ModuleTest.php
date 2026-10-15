<?php
namespace Modules\Geo\Tests\Unit;

use Modules\Geo\Tests\TestCase;
use Modules\Geo\Models\County;

it('has main model class', function () {
    expect(class_exists(County::class))->toBeTrue();
});
