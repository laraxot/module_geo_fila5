<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * BaseModel per il modulo Sigma che gestisce l'integrazione con sistemi esterni.
 * Estende Model direttamente per compatibilità con sistemi legacy.
 */
abstract class BaseModel extends XotBaseModel
{
    /**
     * Connessione database da utilizzare.
     * Utilizza la connessione 'generale' per compatibilità con sistemi esterni.
     *
     * @var string
     */
    protected $connection = 'generale';

    /**
     * Gli attributi che dovrebbero essere convertiti in tipi nativi.
     *
     * @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            // Cast specifici per il modulo Sigma
            'anv2kd' => 'date',
            'anv2ka' => 'date',
            'anvist' => 'integer',
            'anvimp' => 'decimal:5',
            'anvqta' => 'decimal:2',
        ];
    }
}
