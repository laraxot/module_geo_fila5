<?php

declare(strict_types=1);

namespace Modules\Setting\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Sushi\Sushi;
use function Safe\json_encode;

/**
 * @property string   $name
 * @property string   $driver
 * @property string   $host
 * @property int      $port
 * @property string   $database
 * @property string   $username
 * @property string   $password
 * @property string   $charset
 * @property string   $collation
 * @property string   $prefix
 * @property bool     $strict
 * @property string   $engine
 * @property array    $options
 * @property string   $status
 * @property Carbon   $created_at
 * @property Carbon   $updated_at
 * @property int|null $id
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereCharset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereCollation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereStrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConnection whereUsername($value)
 *
 * @mixin \Eloquent
 */
class DatabaseConnection extends Model
{
    use Sushi;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'driver',
        'host',
        'port',
        'database',
        'username',
        'password',
        'charset',
        'collation',
        'prefix',
        'strict',
        'engine',
        'options',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'port' => 'integer',
            'strict' => 'boolean',
            'options' => 'array', // Laravel auto JSON encode/decode
        ];
    }

    public function getRows(): array
    {
        /** @var array<string, mixed>|mixed $connections */
        $connections = config('database.connections');

        if (! is_array($connections) || empty($connections)) {
            return [];
        }

        $rows = [];
        foreach ($connections as $key => $value) {
            if (! is_array($value)) {
                continue;
            }

            $rows[] = [
                'id' => $key,
                'name' => $key,
                'driver' => $value['driver'] ?? 'mysql',
                'database' => $value['database'] ?? '',
                'host' => $value['host'] ?? null,
                'port' => $value['port'] ?? null,
                'username' => $value['username'] ?? null,
                'password' => $value['password'] ?? null,
                'charset' => $value['charset'] ?? 'utf8mb4',
                'collation' => $value['collation'] ?? 'utf8mb4_unicode_ci',
                'prefix' => $value['prefix'] ?? '',
                'strict' => $value['strict'] ?? true,
                'engine' => $value['engine'] ?? 'InnoDB',
                'options' => isset($value['options']) && is_array($value['options']) ? json_encode($value['options']) : null,
                'status' => 'active',
            ];
        }

        return $rows;
    }

    public function testConnection(): bool
    {
        try {
            $config = [
                'driver' => $this->driver,
                'host' => $this->host,
                'port' => $this->port,
                'database' => $this->database,
                'username' => $this->username,
                'password' => $this->password,
                'charset' => $this->charset ?? 'utf8mb4',
                'collation' => $this->collation ?? 'utf8mb4_unicode_ci',
                'prefix' => $this->prefix,
                'strict' => $this->strict,
                'engine' => $this->engine,
            ];

            if (! empty($this->options)) {
                $config = array_merge($config, $this->options);
            }

            Config::set('database.connections.test_connection', $config);
            DB::connection('test_connection')->getPdo();

            return true;
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }
}
