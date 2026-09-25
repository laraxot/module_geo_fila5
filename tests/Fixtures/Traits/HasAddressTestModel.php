<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress (solo fixture — i test Pest stanno in HasAddressTest.php).
 */
<<<<<<< HEAD
class HasAddressTestModel extends BaseModel
{
    /** @use HasAddress<HasAddressTestModel> */
=======
final class HasAddressTestModel extends BaseModel
{
>>>>>>> laraxot/dev
    use HasAddress;

    /** @var list<string> */
    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    protected static function boot(): void
    {
        parent::boot();

<<<<<<< HEAD
        self::creating(static function (): void {
=======
        static::creating(static function (): void {
>>>>>>> laraxot/dev
            if (! app()->environment('testing')) {
                throw new \Exception('HasAddressTestModel should only be used in tests.');
            }
        });
    }
}
