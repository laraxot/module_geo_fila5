<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\Xot\Filament\Pages\XotBasePage;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Rating\Enums\RuleEnum; // Import RuleEnum

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Uses spatie/laravel-schemaless-attributes for anno filtering.
 * Ratings are queried via withExtraAttributes(), NOT via wherePivot() —
 * anno is stored in extra_attributes JSON.
 *
 * @see https://github.com/spatie/laravel-schemaless-attributes
 * @see /Modules/IndennitaResponsabilita/docs/rating-hydration-pattern.md
 * @see /Modules/IndennitaResponsabilita/docs/ui-ux-readonly-fields.md
 * @see /Modules/Rating/docs/schemaless-attributes.md
 *
 * @property array<string, mixed> $data
 * @property \Filament\Forms\Form $form
 * @property IndennitaResponsabilita $record
 */
class CompilaIndennitaResponsabilita2 extends XotBasePage
{
    use HasRelationManagers;
    use InteractsWithRecord;

    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public array $form_data = []; // Kept this as it's used with statePath('form_data')

    /**
     * @var array<string, array<mixed>>
     */
    public array $rules = [];

    public ?string $previousUrl = null;

    /**
     * Mount the page — resolves {record} from URL, authorizes, fills form.
     *
     * @param int|string $record
     */
    public function mount(int|string $record): void
    {
        // InteractsWithRecord trait's mount method resolves $this->record and fills $this->form
        parent::mount($record);

        $this->authorizeAccess();

        $this->previousUrl = (string) url()->previous();

        // Custom initialization for ratings, overriding default form fill for 'ratings' key
        $preparedFormData = $this->getPreparedFormData();
        $this->form->fill($preparedFormData); // Fill the form with prepared data

        $this->rules = $this->getRules(); // Initialize rules here
    }

    /**
     * Prepare initial form data including ratings and computed values.
     *
     * @return array<string, mixed>
     */
    protected function getPreparedFormData(): array
    {
        /** @var IndennitaResponsabilita $rec */
        $rec = $this->record;
        $modelData = $rec->attributesToArray();

        // CRITICAL: Get ratings for the current year using schemaless attributes, not wherePivot.
        // @see /Modules/IndennitaResponsabilita/docs/rating-hydration-pattern.md
        // @see /docs/claude/schemaless-attributes.md
        $ratingsForYear = Rating::withExtraAttributes(['anno' => $rec->anno])->get();

        // Ensure these ratings are attached to the current record's pivot table.
        // syncWithoutDetaching ensures existing pivot data (like 'value') is preserved.
        $rec->ratings()->syncWithoutDetaching($ratingsForYear->pluck('id'));

        // Get the fresh, hydrated relationship data for the current year's ratings,
        // ensuring 'pivot' data (like 'value') is correctly loaded.
        // Use wherePivotIn to filter by the relevant rating IDs for the year.
        $hydratedRatings = $rec->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();

        /** @var array<int|string, array<string, mixed>> $ratingsKeyed */
        $ratingsKeyed = $hydratedRatings->keyBy('id')->toArray();

        // Pre-calculate initial totals for readonly fields
        /** @var array<int, string> $readonlyTitles */
        $readonlyTitles = ['tot', 'importo mensile calcolato', 'importo mensile attribuito', 'importo annuale attribuito'];

        $tot = 0;
        foreach ($ratingsKeyed as $rData) {
            /** @var array{title?: string, pivot?: array{value?: mixed}} $rData */
            if (! in_array((string) ($rData['title'] ?? ''), $readonlyTitles, true)) {
                $tot += (int) ($rData['pivot']['value'] ?? 0);
            }
        }

        $perc = (float) ($rec->perc_p_time_year ?? 1.0);
        $importoMensileCalcolato = (float) $tot * 10.0;
        $importoMensileAttribuito = $importoMensileCalcolato * $perc;
        $importoAnnualeAttribuito = $importoMensileAttribuito * 12.0;

        // Write computed values into the ratings data before fill
        foreach ($ratingsKeyed as &$rData) {
            /** @var array{title?: string, pivot: array{value: mixed}} $rData */
            $title = (string) ($rData['title'] ?? '');
            if ($title === 'tot') {
                $rData['pivot']['value'] = $tot;
            } elseif ($title === 'importo mensile calcolato') {
                $rData['pivot']['value'] = $importoMensileCalcolato;
            } elseif ($title === 'importo mensile attribuito') {
                $rData['pivot']['value'] = $importoMensileAttribuito;
            } elseif ($title === 'importo annuale attribuito') {
                $rData['pivot']['value'] = $importoAnnualeAttribuito;
            }
        }
        unset($rData);

        $modelData['ratings'] = $ratingsKeyed;

        $anno = isset($rec->anno) && is_int($rec->anno) ? $rec->anno : (int) date('Y');

        if (! isset($modelData['dal'])) {
            $modelData['dal'] = Carbon::parse((string) $anno.'-01-01');
        }
        if (is_string($modelData['dal'])) {
            $dal = Carbon::parse($modelData['dal']);
            if ($dal->year !== $anno) {
                $dal = Carbon::parse((string) $anno.'-01-01');
            }
            $modelData['dal'] = $dal;
        }

        if (! isset($modelData['al'])) {
            $modelData['al'] = Carbon::parse((string) $anno.'-12-31');
        }

        if (is_string($modelData['al'])) {
            $al = Carbon::parse($modelData['al']);
            if ($al->year !== $anno) {
                $al = Carbon::parse((string) $anno.'-12-31');
            }
            $modelData['al'] = $al;
        }

        return $modelData;
    }

    /**
     * Build the form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component|\Filament\Schemas\Components\Component>
     */
    protected function getFormSchema(): array
    {
        $schema = [
            'dal' => DatePicker::make('dal'),
            'al' => DatePicker::make('al'),
            'note' => Textarea::make('note')->columnSpanFull(),
        ];

        /** @var IndennitaResponsabilita $currRecord */
        $currRecord = $this->record;
        // CRITICAL: Get ratings for the current year using schemaless attributes, not wherePivot.
        // @see /Modules/IndennitaResponsabilita/docs/rating-hydration-pattern.md
        // @see /docs/claude/schemaless-attributes.md
        $ratingsForYear = Rating::withExtraAttributes(['anno' => $currRecord->anno])->get();
        $ratings = $currRecord->ratings()->wherePivotIn('rating_id', $ratingsForYear->pluck('id'))->get();


        // Build readonly info: captured in closures via use()
        /** @var array<int, array{title: string, path: string}> $readonlyFields */
        $readonlyFields = [];
        foreach ($ratings as $r) {
            if ((bool) ($r->is_readonly ?? false)) {
                $readonlyFields[] = [
                    'title' => (string) $r->title,
                    'path' => 'ratings.' . $r->id . '.pivot.value',
                ];
            }
        }

        foreach ($ratings as $rating) {
            $fieldname = 'ratings.' . $rating->id . '.pivot.value';
            $item = TextInput::make($fieldname)
                ->label(strip_tags((string) $rating->txt))
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
                // Readonly computed field: no validation needed, value is auto-calculated
                // readOnly prevents user editing, recalculation is triggered by non-readonly fields via $set
                $item->readOnly()
                    ->extraInputAttributes([
                        'class' => 'bg-gray-100 dark:bg-gray-800 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed', // UI/UX improvement
                        'aria-readonly' => 'true',
                    ])
                    ->afterStateHydrated(function (TextInput $component, Get $get) use ($rating): void {
                        $method = 'get' . Str::studly((string) $rating->title);
                        if (method_exists($this, $method)) {
                            /** @var mixed $result */
                            $result = $this->$method($get, []); // Pass empty array for readonlyFields
                            $component->state($result);
                        }
                    });
            } else {
                // Editable field: apply RuleEnum validation + nullable for empty states
                // Rating.rule (singular) is cast to RuleEnum, NOT $rating->rules (plural)
                $ruleStr = $rating->rule instanceof RuleEnum
                    ? (string) $rating->rule->value
                    : '';

                $item->numeric()
                    ->nullable();

                if ($ruleStr !== '') {
                    // Apply enum rules, but skip 'numeric' and 'nullable' (already set above)
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

            $schema[$fieldname] = $item;
        }

        return $schema;
    }

    /**
     * Recalculate all readonly (computed) fields.
     *
     * @param array<int, array{title: string, path: string}> $readonlyFields
     */
    protected function recalculateReadonlyFields(Set $set, Get $get, array $readonlyFields): void
    {
        foreach ($readonlyFields as $rf) {
            $method = 'get' . Str::studly($rf['title']);
            if (method_exists($this, $method)) {
                $set($rf['path'], $this->$method($get, $readonlyFields));
            }
        }
    }

    /**
     * Sum of all non-readonly rating values.
     *
     * @param array<int, array{title: string, path: string}> $readonlyFields
     */
    public function getTot(Get $get, array $readonlyFields = []): int
    {
        /** @var array<int|string, array{pivot: array{value: mixed}, title?: string}> $ratings */
        $ratings = (array) ($get('ratings') ?? []);

        $excludePaths = array_column($readonlyFields, 'path'); // This is fine if $readonlyFields passed correctly.

        $tot = 0;
        foreach ($ratings as $id => $rating) {
            $path = "ratings.{$id}.pivot.value"; // Full path in form state
            // Check if this rating's path is one of the readonly fields' paths
            if (in_array($path, $excludePaths, true)) {
                continue;
            }
            $tot += (int) ($rating['pivot']['value'] ?? 0);
        }

        return $tot;
    }

    /**
     * @param array<int, array{title: string, path: string}> $readonlyFields
     */
    public function getImportoMensileCalcolato(Get $get, array $readonlyFields = []): float
    {
        return (float) $this->getTot($get, $readonlyFields) * 10.0;
    }

    /**
     * @param array<int, array{title: string, path: string}> $readonlyFields
     */
    public function getImportoMensileAttribuito(Get $get, array $readonlyFields = []): float
    {
        $perc = (float) ($this->record->perc_p_time_year ?? 1.0);

        return $this->getImportoMensileCalcolato($get, $readonlyFields) * $perc;
    }

    /**
     * @param array<int, array{title: string, path: string}> $readonlyFields
     */
    public function getImportoAnnualeAttribuito(Get $get, array $readonlyFields = []): float
    {
        return (float) $this->getImportoMensileAttribuito($get, $readonlyFields) * 12.0;
    }

    protected function authorizeAccess(): void
    {
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    public function save(): void
    {
        $this->form->validate();

        /** @var IndennitaResponsabilita $record */
        $record = $this->getRecord();
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();

        $up = (array) collect($state)->only(['dal', 'al', 'note'])->toArray();
        $record->update($up);

        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = (array) ($state['ratings'] ?? []);
        foreach ($ratingsData as $id => $rating) {
            /** @var BelongsToMany $ratingsRel */
            $ratingsRel = $record->ratings();
            $ratingsRel->updateExistingPivot($id, [
                'value' => $rating['pivot']['value'] ?? 0,
            ]);
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function back(): void
    {
        $this->redirect($this->previousUrl ?? static::$resource::getUrl('index'));
    }
}
