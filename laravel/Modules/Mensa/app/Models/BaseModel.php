<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

// ---------- traits
// //use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'mensa'; // this will use the specified database connection
}
