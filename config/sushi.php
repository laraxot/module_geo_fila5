<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Sushi Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Qui puoi configurare le impostazioni per il pacchetto Sushi.
     * |
     */

    /*
     * |--------------------------------------------------------------------------
     * | Cache Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione della cache per i modelli Sushi.
     * |
     */
    'cache' => [
<<<<<<< HEAD
       'enabled' => Illuminate\Support\Env::get('SUSHI_CACHE_ENABLED', true),
=======
        'enabled' => Illuminate\Support\Env::get('SUSHI_CACHE_ENABLED', true),
>>>>>>> laraxot/dev
        'duration' => Illuminate\Support\Env::get('SUSHI_CACHE_DURATION', 60 * 24 * 7), // 7 giorni
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Database Configuration
     * |--------------------------------------------------------------------------
     * |
<<<<<<< HEAD
    * | Configurazione del database per i modelli Sushi.
=======
     * | Configurazione del database per i modelli Sushi.
>>>>>>> laraxot/dev
     * |
     * | Il default eredita dalla connessione applicativa: un modulo riusabile non
     * | puo' contenere il nome di un database di progetto, tanto meno quello di
     * | test, altrimenti in sviluppo legge dalla replica sbagliata.
     * |
     */
    'database' => [
        'connection' => Illuminate\Support\Env::get('SUSHI_DB_CONNECTION', 'mysql'),
        'database' => Illuminate\Support\Env::get('SUSHI_DB_DATABASE', Illuminate\Support\Env::get('DB_DATABASE')),
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Models Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione specifica per i modelli Sushi.
     * |
     */
    'models' => [
        'comune' => [
            'file' => 'database/content/comuni.json',
            'schema' => [
                'id' => 'integer',
                'regione' => 'string',
                'provincia' => 'string',
                'comune' => 'string',
                'cap' => 'string',
                'lat' => 'float',
                'lng' => 'float',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ],
            'casts' => [
                'lat' => 'float',
                'lng' => 'float',
                'created_at' => 'datetime',
                'updated_at' => 'datetime',
            ],
            'fillable' => [
                'regione',
                'provincia',
                'comune',
                'cap',
                'lat',
                'lng',
            ],
        ],
    ],
];
