<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\Role;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Webmozart\Assert\Assert;

class PermissionsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'guard_name' => SelectFilter::make('guard_name')
                ->options([
                    'web' => 'Web',
                    'api' => 'API',
                    'sanctum' => 'Sanctum',
                ])
                ->multiple(),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        Assert::classExists($roleModel = config('permission.models.role'));

        return [
            'delete' => DeleteBulkAction::make(),
            'attach_role' => BulkAction::make('Attach Role')
                ->action(static function (Collection $collection, array $data): void {
                    foreach ($collection as $record) {
                        // Verifichiamo che $record sia un'istanza di Model prima di procedere
                        // This check is redundant as $record is already an instance of Model
                        // Assert::isInstanceOf($record, Model::class, '['.__LINE__.']['.__CLASS__.']');

                        // Poi verifichiamo che il modello abbia il metodo roles() prima di chiamarlo
                        if (method_exists($record, 'roles')) {
                            /** @var BelongsToMany<Role, \Modules\User\Models\Permission> $rolesRelation */
                            $rolesRelation = $record->roles();
                            $roleData = $data['role'];
                            if (is_array($roleData) || is_int($roleData) || is_string($roleData)) {
                                $syncData = is_array($roleData) ? $roleData : [$roleData];
                                $rolesRelation->sync($syncData);
                                $record->save();
                            }
                        }
                    }
                })
                ->schema([
                    Select::make('role')->options(function () use ($roleModel): array {
                        /** @var Builder<Role> $query */
                        $query = $roleModel::query();

                        return $query->pluck('name', 'id')
                            ->mapWithKeys(static fn (mixed $name, mixed $id): array => is_string($name) || is_int($name) ? [(string) $id => (string) $name] : [])
                            ->all();
                    })->required(),
                ])
                ->deselectRecordsAfterCompletion(),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'guard_name' => TextColumn::make('guard_name'),
            'display_name' => TextColumn::make('display_name'),
            'description' => TextColumn::make('description'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
