<?php

declare(strict_types=1);

namespace Modules\Setting\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Mockery;
use Modules\Setting\Models\DatabaseConnection;
use PDO;
use Tests\TestCase;

class DatabaseConnectionTest extends TestCase
{
    /**
     * Verifica che il modello DatabaseConnection possa essere istanziato.
     */
    public function test_database_connection_model_can_be_instantiated(): void
    {
        $connection = new DatabaseConnection;

        $this->assertInstanceOf(DatabaseConnection::class, $connection);
    }

    /**
     * Verifica che i casts siano definiti correttamente.
     */
    public function test_casts_are_configured_correctly(): void
    {
        $connection = new DatabaseConnection;

        $this->assertEquals([
            'port' => 'integer',
            'strict' => 'boolean',
            'options' => 'array',
        ], $connection->getCasts());
    }

    /**
     * Verifica che il metodo testConnection funzioni correttamente quando la connessione ha successo.
     */
    public function test_test_connection_succeeds(): void
    {
        // Mock PDO instance
        $pdoMock = Mockery::mock(PDO::class);

        // Mock DB facade
        DB::shouldReceive('connection')
            ->once()
            ->with('test_connection')
            ->andReturnSelf();

        DB::shouldReceive('getPdo')
            ->once()
            ->andReturn($pdoMock);

        // Mock Config facade
        Config::shouldReceive('set')
            ->once()
            ->with('database.connections.test_connection', Mockery::type('array'))
            ->andReturnNull();

        $connection = new DatabaseConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'port' => 3306,
            'database' => 'test_db',
            'username' => 'user',
            'password' => 'password',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => 'InnoDB',
        ]);

        $result = $connection->testConnection();

        $this->assertTrue($result);
    }

    /**
     * Verifica che il metodo testConnection ritorni false quando la connessione fallisce.
     */
    public function test_test_connection_fails(): void
    {
        // Mock DB facade per simulare un errore di connessione
        DB::shouldReceive('connection')
            ->once()
            ->with('test_connection')
            ->andReturnSelf();

        DB::shouldReceive('getPdo')
            ->once()
            ->andThrow(new Exception('Connection failed'));

        // Mock Config facade
        Config::shouldReceive('set')
            ->once()
            ->with('database.connections.test_connection', Mockery::type('array'))
            ->andReturnNull();

        $connection = new DatabaseConnection([
            'driver' => 'mysql',
            'host' => 'invalid_host',
            'port' => 3306,
            'database' => 'test_db',
            'username' => 'user',
            'password' => 'password',
        ]);

        $result = $connection->testConnection();

        $this->assertFalse($result);
    }

    /**
     * Resetta i mock dopo ogni test.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
