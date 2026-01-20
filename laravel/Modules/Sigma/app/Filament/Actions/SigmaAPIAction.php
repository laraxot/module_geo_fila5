<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Modules\Sigma\Actions\WebService\SyncModelAction;
use Modules\Xot\Contracts\UserContract;

/**
 * Action utilizzata per effetture il primo import dei dipendenti provinciali tramite API di Sigma.
 */
class SigmaAPIAction extends Action
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Popola da SIGMA')
            ->icon('heroicon-o-arrow-up-tray')
            ->schema(static function (UserContract $user, array $data, $livewire): array {
                /** @var ListRecords|CreateRecord|EditRecord $livewire */
                if (! method_exists($livewire, 'getResource')) {
                    return [];
                }
                /** @var resource $resource */
                $resource = $livewire->getResource();
                /** @var class-string<Model> $modelClass */
                $modelClass = $resource::getModel();
                /** @var Model $model */
                $model = app($modelClass);
                /** @var array<int, string> $fields */
                $fields = $model->getFillable();

                // return Arr::map($fields, function ($field) {
                //     return Checkbox::make($field);
                // });
                return [
                    CheckboxList::make('only')->options(array_combine($fields, $fields)),
                ];
            })
            // ->requiresConfirmation()
            ->visible(static function ($livewire): bool {
                /** @var ListRecords|CreateRecord|EditRecord $livewire */
                if (! method_exists($livewire, 'getResource')) {
                    return false;
                }
                /** @var resource $resource */
                $resource = $livewire->getResource();
                /** @var class-string<Model> $modelClass */
                $modelClass = $resource::getModel();
                /** @var int $count */
                $count = $modelClass::query()->count();

                return $count === 0;
            })
            ->action(static function (UserContract $user, array $data, $livewire): void {
                /** @var ListRecords|CreateRecord|EditRecord $livewire */
                if (! method_exists($livewire, 'getResource')) {
                    return;
                }
                /** @var resource $resource */
                $resource = $livewire->getResource();
                /** @var class-string<Model> $modelClass */
                $modelClass = $resource::getModel();
                /** @var Model $modelInstance */
                $modelInstance = app($modelClass);
                /** @var array<string, mixed> $only */
                $only = $data['only'] ?? [];
                app(SyncModelAction::class)->execute('ANA10F', $modelInstance, $only);

                // dddx($employees);

                Notification::make()->success()->title('Caricamento effettuato correttamente.');
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'SigmaAPIAction';
    }
}
