<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

<<<<<<< .merge_file_aWzrl0
use Modules\Geo\Tests\Fixtures\Traits\HasAddressTestModel;

/**
 * Alias fixture per HasAddressTestModel (legacy path).
 */
<<<<<<< .merge_file_wX2NW0
class TestModel extends HasAddressTestModel {}
=======
class TestModel extends HasAddressTestModel
{
}
>>>>>>> .merge_file_J3Dyy1
=======
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress.
 */
class TestModel extends Model
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    /**
     * Bootstrap this model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (): void {
            if (! app()->environment('testing')) {
                throw new \Exception('TestModel should only be used in tests.');
            }
        });
    }
}
>>>>>>> .merge_file_WvIRqc
