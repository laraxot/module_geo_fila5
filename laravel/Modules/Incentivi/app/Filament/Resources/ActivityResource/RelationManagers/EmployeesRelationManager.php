<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\RelationManagers;

use Closure;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Activity;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class EmployeesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $recordTitleAttribute = 'cognome';

    public static function getModelLabel(): string
    {
        return __('Dipendente');
    }

    #[Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('cognome')
                ->readOnly()
                ->required(),
            TextInput::make('percentuale_attivita_dipendente')
                ->required()
                ->numeric()
                ->suffix('%')
                ->live(onBlur: true)
                ->rules([
                    fn ($livewire, Model $record): Closure => function (string $attribute, $value, Closure $fail) use ($livewire, $record) {
                        // Type narrowing: ensure livewire is RelationManager
                        if (! $livewire instanceof RelationManager) {
                            return;
                        }

                        $activity = $livewire->getOwnerRecord();
                        $relationship = $livewire->getRelationship();

                        // Type narrowing: ensure activity is Activity model
                        if (! $activity instanceof Activity) {
                            return;
                        }

                        // $record is already Model type from method signature

                        // Type narrowing: ensure relationship is Builder
                        if (! $relationship instanceof Builder) {
                            return;
                        }

                        $recordId = $record->getKey();
                        $total = $relationship
                            ->where('employees.id', '<>', $recordId)
                            ->sum('activity_employee.percentuale_attivita_dipendente');
                        $total += is_numeric($value) ? (float) $value : 0.0;

                        if ($total > 100) {
                            $fail("La somma totale delle percentuali ({$total}%) supera il 100%.");

                            return;
                        }
                    },
                ])

                ->helperText(function (RelationManager $livewire): string {
                    $activity = $livewire->getOwnerRecord();
                    $totalExistingPercentage = ($activity instanceof Activity)
                        ? (float) $activity->employees()->sum('activity_employee.percentuale_attivita_dipendente')
                        : 0.0;

                    $disponibile = 100.0 - $totalExistingPercentage;

                    return "Percentuale già allocata: {$totalExistingPercentage}%. Disponibile: {$disponibile}%.";
                })
                ->afterStateUpdated(function (Get $get, Set $set, ?string $state, RelationManager $livewire): void {
                    $ownerRecord = $livewire->getOwnerRecord();
                    if ($ownerRecord instanceof Activity && isset($ownerRecord->importo)) {
                        $percentuale = $state !== null && is_numeric($state) ? (float) $state : 0.0;
                        $importo = is_numeric($ownerRecord->importo) ? (float) $ownerRecord->importo : 0.0;
                        $set('importo_attivita_dipendente', ($percentuale * $importo) / 100.0);
                    }
                }),
            TextInput::make('importo_attivita_dipendente')
                ->numeric()
                ->required()
                ->suffix('€')
                ->disabled()
                ->dehydrated(),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'cognome' => TextColumn::make('cognome'),
            'nome' => TextColumn::make('nome'),
            'percentuale_attivita_dipendente' => TextColumn::make('percentuale_attivita_dipendente')
                // ->label('Percentuale attribuita')
                ->suffix('%'),
            // ->summarize(Summarizer::make()
            //     ->label('Total')
            //     ->using(fn ($query): string => $query->count())),
            'importo_attivita_dipendente' => TextColumn::make('importo_attivita_dipendente')
                // ->label('Importo attribuito')
                ->suffix('€'),
        ];
    }

    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            AttachAction::make()
                ->icon('heroicon-o-link')
                ->recordSelectOptionsQuery(
                    function (Builder $query): Builder {
                        $ownerRecord = $this->getOwnerRecord();
                        $projectId = null;

                        if ($ownerRecord instanceof Activity) {
                            $project = $ownerRecord->project ?? null;
                            if ($project instanceof Model && isset($project->id)) {
                                $projectId = $project->id;
                            }
                        }

                        if ($projectId !== null) {
                            return $query->whereHas('projects', function (Builder $query1) use ($projectId): void {
                                $query1->where('projects.id', $projectId);
                            });
                        }

                        return $query;
                    }
                )
                ->preloadRecordSelect()
                ->recordSelectSearchColumns(['cognome', 'nome'])
                ->recordTitle(function (Model $record): string {
                    $nome = isset($record->nome) && is_string($record->nome) ? $record->nome : '';
                    $cognome = isset($record->cognome) && is_string($record->cognome) ? $record->cognome : '';

                    return trim("{$nome} {$cognome}");
                })
                ->schema(fn (AttachAction $action): array => [
                    $action->getRecordSelect(),
                    TextInput::make('project_id')
                        ->default(function (RelationManager $livewire): ?int {
                            $ownerRecord = $livewire->getOwnerRecord();

                            if ($ownerRecord instanceof Activity) {
                                $project = $ownerRecord->project ?? null;
                                if ($project instanceof Model && isset($project->id)) {
                                    return (int) $project->id;
                                }
                            }

                            return null;
                        })
                        ->disabled()
                        ->dehydrated(),
                    TextInput::make('percentuale_attivita_dipendente')
                        // ->label('Percentuale dell\'attività')
                        ->required()
                        ->numeric()
                        ->inputMode('numeric')
                        ->minValue(1)
                        ->maxValue(100)
                        ->suffix('%')
                        ->live(debounce: 600)
                        ->afterStateUpdated(function (Set $set, ?string $state, RelationManager $livewire): void {
                            $ownerRecord = $livewire->getOwnerRecord();
                            if ($ownerRecord instanceof Activity && isset($ownerRecord->importo)) {
                                $percentuale = $state !== null && is_numeric($state) ? (float) $state : 0.0;
                                $importo = is_numeric($ownerRecord->importo) ? (float) $ownerRecord->importo : 0.0;
                                $set('importo_attivita_dipendente', ($percentuale * $importo) / 100.0);
                            }
                        }),
                    TextInput::make('importo_attivita_dipendente')
                        // ->label('Importo dell\'attività')
                        ->numeric()
                        ->required()
                        ->suffix('€')
                        ->disabled()
                        ->dehydrated(),
                ]),
        ];
    }

    public function getTableActions(): array
    {
        return [
            EditAction::make()
                ->icon('heroicon-o-pencil')
                ->schema([
                    TextInput::make('percentuale_attivita_dipendente')
                        // ->label('Percentuale dell\'attività')
                        ->required()
                        ->numeric()
                        ->inputMode('numeric')
                        ->minValue(1)
                        ->maxValue(100)
                        ->suffix('%')
                        ->live(debounce: 600)
                        ->afterStateUpdated(function (Set $set, ?string $state, RelationManager $livewire): void {
                            $ownerRecord = $livewire->getOwnerRecord();
                            if ($ownerRecord instanceof Activity && isset($ownerRecord->importo)) {
                                $percentuale = $state !== null && is_numeric($state) ? (float) $state : 0.0;
                                $importo = is_numeric($ownerRecord->importo) ? (float) $ownerRecord->importo : 0.0;
                                $set('importo_attivita_dipendente', ($percentuale * $importo) / 100.0);
                            }
                        }),
                    TextInput::make('importo_attivita_dipendente')
                        // ->label('Importo dell\'attività')
                        ->numeric()
                        ->required()
                        ->suffix('€')
                        ->disabled()
                        ->dehydrated(),
                ]),

            DetachAction::make(),
        ];
    }
}
