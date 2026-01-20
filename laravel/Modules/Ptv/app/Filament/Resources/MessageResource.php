<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Forms\Components\ParentSelect;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Support\Str;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\CreateMessage;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\EditMessage;
use Modules\Ptv\Filament\Resources\MessageResource\Pages\ListMessages;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MessageResource extends XotBaseResource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'parent_id' => TextInput::make('parent_id'),
            // ParentSelect::make('parent_id'),
            'type' => Select::make('type')
                ->options(fn () => static::getTypeOptions())
                ->searchable()
                ->preload()
                ->allowHtml()
                ->createOptionForm([
                    TextInput::make('new_type')
                        ->required()
                        ->rules(['string', 'max:255', 'regex:/^[a-z0-9_\s]+$/i'])
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set): void {
                            // Type narrowing: ensure state is string
                            if (is_string($state) && $state !== '') {
                                $slugged = Str::slug($state, '_');
                                $set('new_type', $slugged);
                            }
                        }),
                ])
                ->createOptionUsing(function (array $data): string {
                    // Type narrowing: ensure new_type exists and is string
                    $newType = isset($data['new_type']) && is_string($data['new_type']) ? $data['new_type'] : '';

                    return $newType;
                })
                ->createOptionModalHeading(__('ptv::message.actions.create_type.modal.heading')),
            'title' => TextInput::make('title'),
            'anno' => TextInput::make('anno'), // ->default(fn($livewire)=>dddx($livewire->getTableFilters())),
            'txt' => RichEditor::make('txt')->columnspan('full'),
            // 'txt' => Textarea::make('txt')->columnspan('full'),
            // 'txt' => TiptapEditor::make('txt')
            //    ->columnSpan('full')
            //    ->output(TiptapOutput::Html),
        ];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMessages::route('/'),
            'create' => CreateMessage::route('/create'),
            'edit' => EditMessage::route('/{record}/edit'),
        ];
    }

    /**
     * Ottiene le opzioni per il campo type basate sui valori esistenti nel database.
     *
     * @return array<string, string>
     */
    /**
     * @return array<string, string>
     */
    protected static function getTypeOptions(): array
    {
        $model = static::getModel();
        // Ottiene i tipi esistenti dal database
        $existingTypes = $model::distinct()
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->pluck('type')
            ->sort()
            ->mapWithKeys(function ($type): array {
                // Type narrowing: ensure type is string
                if (! is_string($type)) {
                    return [];
                }

                // Converte il tipo slug in etichetta leggibile
                $label = ucfirst(str_replace('_', ' ', $type));

                return [$type => $label];
            })
            ->toArray();

        // Type narrowing: ensure return type is array<string, string>
        /** @var array<string, string> $result */
        $result = $existingTypes;

        return $result;
    }
}
