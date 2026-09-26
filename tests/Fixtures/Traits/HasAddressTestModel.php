<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress (solo fixture — i test Pest stanno in HasAddressTest.php).
 */
<<<<<<< .merge_file_wwYn3u
class HasAddressTestModel extends BaseModel
{
    /** @use HasAddress<HasAddressTestModel> */
=======
final class HasAddressTestModel extends BaseModel
{
>>>>>>> .merge_file_KsSPD5
    use HasAddress;

    /** @var list<string> */
    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    protected static function boot(): void
    {
        parent::boot();

<<<<<<< .merge_file_wwYn3u
        self::creating(static function (): void {
=======
        static::creating(static function (): void {
>>>>>>> .merge_file_KsSPD5
            if (! app()->environment('testing')) {
                throw new \Exception('HasAddressTestModel should only be used in tests.');
            }
        });
    }
}
