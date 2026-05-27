<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Xot\Filament\Actions\Form;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class FieldRefreshAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel();
        $this->icon('heroicon-o-arrow-path')
            ->label('')
            ->tooltip(__('xot::field_refresh_action.tooltip.label'))
            ->action(function ($record, Set $set): void {
                $name = $this->getName();
                if (null === $name) {
                    return;
                }

                if (! is_object($record) && ! is_string($record)) {
                    Notification::make()
                        ->title(__('xot::field_refresh_action.notifications.invalid_record.title'))
                        ->body(__('xot::field_refresh_action.notifications.invalid_record.body'))
                        ->danger()
                        ->send();

                    return;
                }

                $action = Str::of($name)->studly()->prepend('get')->toString();

                if (! is_object($record) || ! method_exists($record, $action)) {
                    Notification::make()
                        ->title(__('xot::field_refresh_action.notifications.method_missing.title'))
                        ->body(__('xot::field_refresh_action.notifications.method_missing.body'))
                        ->danger()
                        ->send();

                    return;
                }

                $value = $record->{$action}();

                $set($name, $value);

                $valueLabel = is_scalar($value) ? (string) $value : '';

                Notification::make()
                    ->title(__('xot::field_refresh_action.notifications.success.title', ['name' => $name]))
                    ->body(__('xot::field_refresh_action.notifications.success.body', [
                        'name' => $name,
                        'value' => $valueLabel,
                    ]))
                    ->success()
                    ->send();
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'field_refresh';
    }
}
