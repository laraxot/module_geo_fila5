<?php

declare(strict_types=1);

namespace Modules\Legge104\Models;

// ---------- traits
// //use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'legge104'; // this will use the specified database connection
}
