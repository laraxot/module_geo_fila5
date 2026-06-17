<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class UsersTable extends XotBaseResourceTable
{
    public function getTableActions(): array
    {
        return [
            'change_password' => ChangePasswordAction::make()->tooltip('Cambio Password')->iconButton(),
            ...parent::getTableActions(),
            'deactivate' => Action::make('deactivate')
                ->tooltip(__('filament-actions::delete.single.label'))
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->action(static fn (UserContract $user) => $user->delete()),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
            'export' => ExportBulkAction::make(),
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
            'first_name' => TextColumn::make('first_name')->searchable(),
            'last_name' => TextColumn::make('last_name')->searchable(),
            'email' => TextColumn::make('email')->searchable(),
            'email_verified_at' => TextColumn::make('email_verified_at')->dateTime(),
            'is_active' => TextColumn::make('is_active')->badge(),
            'is_otp' => TextColumn::make('is_otp')->badge(),
            'lang' => TextColumn::make('lang'),
            'current_team_id' => TextColumn::make('current_team_id'),
            'type' => TextColumn::make('type'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
