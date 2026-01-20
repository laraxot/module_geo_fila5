<?php

declare(strict_types=1);

namespace Modules\Prenotazioni\Models;

// ---------- traits
// //use Laravel\Scout\Searchable;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'prenotazioni';
}
