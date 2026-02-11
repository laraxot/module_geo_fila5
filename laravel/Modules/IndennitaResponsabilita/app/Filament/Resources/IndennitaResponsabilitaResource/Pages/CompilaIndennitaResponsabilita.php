<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Modules\IndennitaResponsabilita\Actions\PrepareCompilaDataAction;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Rating\Enums\RuleEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Override;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Extends XotBaseEditRecord to inherit robust record handling.
 *
 * @property IndennitaResponsabilita $record
 */
final class CompilaIndennitaResponsabilita extends XotBaseEditRecord
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    #[Override]
    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Fill form using dedicated action for ratings hydration
        $preparedData = app(PrepareCompilaDataAction::class)->execute($this->record);
        $this->form->fill($preparedData);
    }

    /**
     * Get the form schema.
     *
     * @return array<int, \Filament\Support\Components\Component>
     */
    #[Override]
    protected function getFormSchema(): array
    {
        $schema = [
            DatePicker::make('dal'),
            DatePicker::make('al'),
            Textarea::make('note')->columnSpanFull(),
        ];

        // Get ratings for the year to build the dynamic form
        // @var \Illuminate\Database\Eloquent\Builder<Rating> $ratingsQuery
        /** @var \Illuminate\Database\Eloquent\Builder<Rating> $ratingsQuery */
        $ratingsQuery = Rating::withExtraAttributes(['anno' => $this->record->anno]);
        $ratingsForYear = $ratingsQuery->get();
        // Hydrate from relationship to get pivot values
        /** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $ratings */
        $ratings = $this->record->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();

        /** @var array<int, array{title: string, path: string}> $readonlyFields */
        $readonlyFields = [];
        foreach ($ratings as $r) {
            if ((bool) ($r->is_readonly ?? false)) {
                $readonlyFields[] = [
                    'title' => (string) $r->title,
                    'path' => 'ratings.'.$r->id.'.pivot.value',
                ];
            }
        }

        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';
            $item = TextInput::make($fieldname)
                ->label(strip_tags((string) $rating->txt))
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
                $item->readOnly()
                    ->extraInputAttributes(['class' => 'bg-gray-100 cursor-not-allowed'])
                    ->afterStateHydrated(function (TextInput $component, Get $get) use ($rating): void {
                        $method = 'get'.Str::studly((string) $rating->title);
                        if (method_exists($this, $method)) {
                            /** @var mixed $result */
                            $result = $this->$method($get, []);
                            $component->state($result);
                        }
                    });
            } else {
                $ruleStr = $rating->rule instanceof RuleEnum ? (string) $rating->rule->value : '';
                $item->numeric()->nullable();

                if ($ruleStr !== '') {
                    $filtered = collect(explode('|', $ruleStr))
                        ->reject(fn (string $r): bool => in_array($r, ['numeric', 'nullable'], true))
                        ->implode('|');
                    if ($filtered !== '') {
                        $item->rules($filtered);
                    }
                }

                $item->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, Get $get) use ($readonlyFields): void {
                        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
                    });
            }

            $schema[] = $item;
        }

        return $schema;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    protected function recalculateReadonlyFields(Set $set, Get $get, array $readonlyFields): void
    {
        foreach ($readonlyFields as $rf) {
            $method = 'get'.Str::studly($rf['title']);
            if (method_exists($this, $method)) {
                $set($rf['path'], $this->$method($get, $readonlyFields));
            }
        }
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getTot(Get $get, array $readonlyFields = []): int
    {
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratings */
        $ratings = (array) ($get('ratings') ?? []);
        $excludePaths = array_column($readonlyFields, 'path');

        $tot = 0;
        foreach ($ratings as $id => $rating) {
            $path = "ratings.{$id}.pivot.value";
            if (in_array($path, $excludePaths, true)) {
                continue;
            }
            $value = $rating['pivot']['value'];
            $tot += is_numeric($value) ? (int) $value : 0;
        }

        return $tot;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoMensileCalcolato(Get $get, array $readonlyFields = []): float
    {
        return (float) $this->getTot($get, $readonlyFields) * 10.0;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoMensileAttribuito(Get $get, array $readonlyFields = []): float
    {
        $perc = (float) ($this->record->perc_p_time_year ?? 1.0);

        return $this->getImportoMensileCalcolato($get, $readonlyFields) * $perc;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoAnnualeAttribuito(Get $get, array $readonlyFields = []): float
    {
        return (float) $this->getImportoMensileAttribuito($get, $readonlyFields) * 12.0;
    }

    /**
     * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            'back' => Action::make('back')
                ->label('Back')
                ->color('gray')
                ->url(function (): string {
                    /** @var mixed $url */
                    $url = static::$resource::getUrl('index');

                    return is_string($url) ? $url : '';
                }),
        ];
    }

    #[Override]
    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $this->form->validate();
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();

        // Update record standard fields
        $this->record->update(collect($state)->only(['dal', 'al', 'note'])->toArray());

        // Update pivot ratings
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = (array) ($state['ratings'] ?? []);
        foreach ($ratingsData as $id => $rating) {
            $value = $rating['pivot']['value'];
            $this->record->ratings()->updateExistingPivot($id, [
                'value' => is_numeric($value) ? $value : 0,
            ]);
        }

        if ($shouldSendSavedNotification) {
            Notification::make()->title('Saved successfully')->success()->send();
        }
    }
}
