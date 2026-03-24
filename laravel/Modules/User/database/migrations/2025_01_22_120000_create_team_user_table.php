<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Migrazione per team_user con id autoincrement.
 * Gestisce sia la creazione che l'aggiornamento della tabella.
 */
return new class extends XotBaseMigration {
    protected string $table_name = 'team_user';

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id');
            $table->uuid('user_id')->nullable()->index();
            $table->string('role')->nullable();
            $table->unique(['team_id', 'user_id']);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $connection = $this->getConn()->getConnection();
            $database = $connection->getDatabaseName();

            /** @var array{EXTRA?: string, DATA_TYPE?: string}|object{EXTRA?: string, DATA_TYPE?: string}|null $columnInfo */
            $columnInfo = $connection->selectOne(
                "SELECT EXTRA, DATA_TYPE FROM information_schema.columns WHERE table_schema = ? AND table_name = ? AND column_name = 'id'",
                [$database, $this->table_name]
            );

            $isAutoIncrement = false;
            $columnType = null;

            if (is_array($columnInfo)) {
                $isAutoIncrement = isset($columnInfo['EXTRA']) && str_contains((string) $columnInfo['EXTRA'], 'auto_increment');
                $columnType = $columnInfo['DATA_TYPE'] ?? null;
            } elseif (is_object($columnInfo)) {
                $isAutoIncrement = isset($columnInfo->EXTRA) && str_contains((string) $columnInfo->EXTRA, 'auto_increment');
                $columnType = $columnInfo->DATA_TYPE ?? null;
            }

            $typeIsBigint = null !== $columnType && str_contains((string) $columnType, 'bigint');

            $needsConversion = $this->hasColumn('id') && null !== $columnInfo && ! $typeIsBigint && ! $isAutoIncrement;

            if ($needsConversion) {
                // Rimuoviamo la PRIMARY KEY esistente
                $this->dropPrimaryKey();

                // Se non esiste già, rinominiamo id a uuid per preservare i dati
                if (! $this->hasColumn('uuid')) {
                    $this->renameColumn('id', 'uuid');
                }

                // Aggiungiamo la nuova colonna id come bigint autoincrement
                if (! $this->hasColumn('id')) {
                    $table->id()->first();
                }

                // Impostiamo la nuova PRIMARY KEY su id
                $this->query('ALTER TABLE `'.$this->table_name.'` ADD PRIMARY KEY (`id`)');
            }

            $this->updateTimestamps(table: $table, hasSoftDeletes: true);
        });
    }
};
