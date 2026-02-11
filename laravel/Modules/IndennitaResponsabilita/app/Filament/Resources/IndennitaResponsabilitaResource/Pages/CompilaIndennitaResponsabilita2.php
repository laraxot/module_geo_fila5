<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Exception;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Pages\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
// use Filament\Pages\Page; //route not exists
// use Filament\Pages\Contracts\HasFormActions;
// use Filament\Resources\Pages\Concerns\HasRecordBreadcrumb;
use Webmozart\Assert\Assert;
// use Filament\Resources\Pages\Concerns\UsesResourceForm;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

/**
 * @property \Filament\Schemas\Schema $form
 * @property IndennitaResponsabilita $record
 */
class CompilaIndennitaResponsabilita2 extends XotBasePage
{
    /* implements HasFormActions */
    // use HasRecordBreadcrumb;
    use HasRelationManagers;

    // use UsesResourceForm;
    use InteractsWithRecord;

    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public array $form_data = [];

    /**
     * @var array<string, array<mixed>>
     */
    public array $rules = [];

    public ?string $previousUrl = null;

    /*
    public array $rules = [
        'form_data.tot_gg' => 'numeric',
        'form_data.tot_presenza_periodo_plus_no_timbr' => 'gte:form_data.tot_gg',
        'form_data.tot_presenza_periodo_plus_no_timbr' => 'required',
        'form_data.ratings.*.pivot.value' => 'numeric|between:0,5',
    ];
    */
    
    protected function getFormSchema(): array {
        $schema= [
            DatePicker::make('dal'),
            DatePicker::make('al'),
            Textarea::make('note')->columnSpanFull(),
        ];
        /** @var IndennitaResponsabilita $currRecord */
        $currRecord = $this->record;
        $ratings = $currRecord->syncRatingsWhere(['anno' => $currRecord->anno]);
        
        
        foreach ($ratings as $rating) {
            $item = TextInput::make('ratings.' . $rating->id . '.pivot.value')
                ->label(strip_tags((string) $rating->txt))
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
                // Readonly computed field: no validation, value auto-calculated in getViewData()
                $item->readOnly()
                    ->extraInputAttributes([
                        'class' => 'bg-gray-100 dark:bg-gray-800 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
                        'aria-readonly' => 'true',
                    ]);
            } else {
                // Editable field: apply RuleEnum validation + nullable
                // Rating.rule (singular) is cast to RuleEnum, NOT $rating->rules (plural)
                $ruleStr = $rating->rule instanceof \BackedEnum
                    ? (string) $rating->rule->value
                    : '';

                $item->numeric()
                    ->nullable()
                    ->reactive();

                if ($ruleStr !== '') {
                    $filtered = collect(explode('|', $ruleStr))
                        ->reject(fn (string $r): bool => in_array($r, ['numeric', 'nullable'], true))
                        ->implode('|');
                    if ($filtered !== '') {
                        $item->rules($filtered);
                    }
                }
            }
            $schema[] = $item;
        }

        return $schema;
    }

    public function getTot(){
        //dddx($this->form->getState());
        return 15;
    }

    public function getImportoMensileCalcolato(){
        return 15;
    }

    public function getImportoMensileAttribuito(){
        return 15;
    }

    public function getImportoAnnualeAttribuito (){
        return time();
    }
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())->columns(2)
            ->statePath('form_data');
    }

    /**
     * @return array<string, array<string>>
     */
    public function getRules(): array
    {
        /** @var IndennitaResponsabilita $record */
        $record = $this->record;
        // Assert::isInstanceOf($record, IndennitaResponsabilita::class, 'Record must be IndennitaResponsabilita'); // Removed redundant assertion

        /** @var array<string, string> $rulesFromRatings */
        $rulesFromRatings = $record->getRatingsRules('form_data.ratings.', '.pivot.value');
        
        
        Assert::isArray($rulesFromRatings, 'getRatingsRules must return array');

        // Convert string rules to array of strings
        /** @var array<string, array<string>> $convertedRules */
        $convertedRules = [];
        foreach ($rulesFromRatings as $key => $ruleString) {
            $convertedRules[$key] = explode('|', $ruleString); // Convert "rule1|rule2" to ["rule1", "rule2"]
        }

        $convertedRules['form_data.dal'] = ['date'];
        $convertedRules['form_data.al'] = ['date'];
        $convertedRules['form_data.note'] = ['nullable', 'string'];

        return $convertedRules;
    }

    public array $messages = [
        // 'form_data.tot_presenza_periodo_plus_no_timbr.gte' => ':attribute: DEVONO ESSERE MAGGIORNI DELLA SOMMA DEI GIORNI DEI PERIODI',
    ];

    /*
    public array $validationAttributes = [
        // 'form_data.tot_presenza_periodo_plus_no_timbr' => 'Giorni Complessivi',
        'form_data.ratings.3.pivot.value' => 'zibibbo',
    ];
    */
    /**
     * @return array<string, string>
     */
    public function getValidationAttributes(): array
    {
        /** @var IndennitaResponsabilita $record */
        $record = $this->record;
        // Assert::isInstanceOf($record, IndennitaResponsabilita::class, 'Record must be IndennitaResponsabilita'); // Removed redundant assertion

        /** @var array<string, string> $validationAttributes */
        $validationAttributes = $record->getRatingsValidationAttributes('form_data.ratings.', '.pivot.value');
        
        Assert::isArray($validationAttributes, 'getRatingsValidationAttributes must return array');

        return $validationAttributes;
    }

    

    /*
    protected function getActions(): array {
        return [
            Actions\DeleteAction::make(),
        ];
    }*/
    public function mount(int|string|IndennitaResponsabilita $record): void
    {
        $recordKey = is_int($record) || is_string($record) ? $record : $record->getKey();
        Assert::notNull($recordKey, 'Record key must not be null');

        /** @var int|string $recordKeyTyped */
        $recordKeyTyped = is_int($recordKey) ? $recordKey : (string) $recordKey;
        $resolvedRecord = $this->resolveRecord($recordKeyTyped);
        Assert::isInstanceOf($resolvedRecord, IndennitaResponsabilita::class, 'Record must be IndennitaResponsabilita');
        $this->record = $resolvedRecord;

        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
        $this->view = $this->getView();

        // $this->rules= $this->getRecord()->getRatingsRules('form_data.ratings.');
        // $this->rules = $this->getRecord()->getRatingsRules('form_data.ratings.', '.pivot.value');
        $this->rules = $this->getRules();
    }

    private function authorizeAccess(): void
    {
        // static::authorizeResourceAccess(); // Temporarily disabled for debugging
        // dddx(Filament::auth()->user());
        // abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    private function fillForm(): void
    {
        $this->callHook('beforeFill');

        /** @var IndennitaResponsabilita $record */
        $record = $this->record;

        $data = $this->record->attributesToArray();
        Assert::isArray($data, 'attributesToArray must return array');

        $anno = isset($this->record->anno) && is_int($this->record->anno) ? $this->record->anno : (int) date('Y');

        // dddx($this->getRecord());

        if (! isset($data['dal'])) {
            $data['dal'] = Carbon::parse((string) $anno.'-01-01');
        }
        if (is_string($data['dal'])) {
            $dal = Carbon::parse($data['dal']);
            if ($dal->year !== $anno) {
                $dal = Carbon::parse((string) $anno.'-01-01');
            }
            $data['dal'] = $dal;
        }

        if (! isset($data['al'])) {
            $data['al'] = Carbon::parse((string) $anno.'-12-31');
        }

        if (is_string($data['al'])) {
            $al = Carbon::parse($data['al']);
            if ($al->year !== $anno) {
                $al = Carbon::parse((string) $anno.'-12-31');
            }
            $data['al'] = $al;
        }

        /*
        if ($record->anno >= 2023) {
            $q = $record->quadrimestre;
            $dal = Carbon::parse($record->anno.'-01-01')->addMonths(4 * ($q - 1));
            $al = Carbon::parse($record->anno.'-01-01')->addMonths(4 * $q)->subDays(1);
            $res = tap($record)->update(['dal' => $dal, 'al' => $al]);
            // dddx($res);
        }
        */
        $data = $this->mutateFormDataBeforeFill($data);

        /** @var array<string, mixed> $dataTyped */
        $dataTyped = [];
        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $dataTyped[$key] = $value;
            }
        }

        $this->form->fill($dataTyped);

        $this->callHook('afterFill');

        $record = $this->getRecord();
        // Assert::isInstanceOf($record, IndennitaResponsabilita::class, 'Record must be IndennitaResponsabilita'); // Removed redundant assertion

        /** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $ratings */
        /** @var IndennitaResponsabilita $record */ // Added explicit cast
        $ratings = $record->syncRatingsWhere(['anno' => $record->anno]);
        
        
        // Assert::isInstanceOf($ratings, \Illuminate\Database\Eloquent\Collection::class, 'getRatings must return Collection'); // Redundant

        /** @var array<string, mixed> $ratingsArray */
        $ratingsArray = $ratings->toArray();
        Assert::isArray($ratingsArray, 'toArray must return array');

        $this->form_data['ratings'] = $ratingsArray;

        // $this->form_data['dettaglio'] = $this->getRecord()->indennitaTipoDettaglio?->keyBy('id')->toArray();
        // $this->form_data['tot_presenza_periodo_plus_no_timbr'] = $this->getRecord()->tot_presenza_periodo_plus_no_timbr;
    }

    protected function getViewData(): array
    {
        /*
        $this->form_data['tot_gg'] = collect($this->form_data['dettaglio'])
        ->filter(function ($item) {
            // return is_numeric($item);
            return true;
        })
        ->sum('pivot.gg');
        */
        /*
        $this->form_data['tot_gg'] = collect($this->form_data['dettaglio'])
              ->reduce(static fn ($tot_gg, $item): float|int => $tot_gg + (int) $item['pivot']['gg'], 0);
        $this->form_data['tot_euro'] = collect($this->form_data['dettaglio'])
            ->reduce(static fn ($tot_euro, $item): float|int => $tot_euro + ($item['euro_giorno'] * (int) $item['pivot']['gg']), 0);
        */
        /** @var IndennitaResponsabilita $record */
        $record = $this->record;
        $anno = $record->anno;

        // Query per filtrare ratings per anno usando extra_attributes
        $rows = Rating::query()
            ->where('extra_attributes->anno', $anno)
            ->get();

        $tot = $rows
            ->where('is_disabled', '!=', true)
            ->where('is_readonly', '!=', true)
            ->reduce(
                function ($tot, $row) {
                    $fieldname = 'ratings.'.$row->id.'.pivot.value';
                    $value = Arr::get($this->form_data, $fieldname, 0);

                    return $tot += (int) $value;
                }, 0
            );

        $tot_id = $rows->firstWhere('title', 'tot')?->id;

        Arr::set($this->form_data, 'ratings.'.$tot_id.'.pivot.value', $tot);
        
        
        // --------------------------------------------------------------------------------------------------------
        $imp_mese_calcolato_id = $rows->firstWhere('title', 'importo mensile calcolato')?->id;

        $imp_mese_calcolato = $tot * 10;

        Arr::set($this->form_data, 'ratings.'.$imp_mese_calcolato_id.'.pivot.value', $imp_mese_calcolato);
        // ---------------------------------------------------------------------------------------------------------

        $imp_mese_attribuito_id = $rows->firstWhere('title', 'importo mensile attribuito')?->id;

        $imp_mese_attribuito = $imp_mese_calcolato * $record->perc_p_time_year;

        Arr::set($this->form_data, 'ratings.'.$imp_mese_attribuito_id.'.pivot.value', $imp_mese_attribuito);
        // -----------------------------------------------------------------------------------------------------------

        $imp_anno_attribuito_id = $rows->firstWhere('title', 'importo annuale attribuito')?->id;
        // dddx(get_class($record));
        $anno = $record->anno;
        /** @var IndennitaResponsabilita $record */
        $record = $this->record; // Explicitly assign from $this->record
        /** @var Carbon|string|null $dal */
        $dal = $record->dal;
        /** @var Carbon|string|null $al */
        $al = $record->al;

        // Handle $dal
        if ($dal instanceof Carbon) {
            // $dal is already a Carbon instance, do nothing
        } elseif (is_string($dal)) {
            $parsedDal = Carbon::parse($dal);
            if ($parsedDal->year !== $anno) {
                $dal = Carbon::parse((string) $anno.'-01-01');
            } else {
                $dal = $parsedDal;
            }
        } else { // $dal is null
            $dal = Carbon::parse((string) $anno.'-01-01');
        }

        // Handle $al
        if ($al instanceof Carbon) {
            // $al is already a Carbon instance, do nothing
        } elseif (is_string($al)) {
            $parsedAl = Carbon::parse($al);
            if ($parsedAl->year !== $anno) {
                $al = Carbon::parse((string) $anno.'-12-31');
            } else {
                $al = $parsedAl;
            }
        } else { // $al is null
            $al = Carbon::parse((string) $anno.'-12-31');
        }

        /** @var Carbon $finalDal */
        $finalDal = $dal;
        /** @var Carbon $finalAl */
        $finalAl = $al;

        $days = $finalDal->daysInYear;
        $perc = ($finalDal->diffInDays($finalAl, true) + 1) / $days;

        $imp_anno_attribuito = $imp_mese_attribuito * 12 * $perc;

        Arr::set($this->form_data, 'ratings.'.$imp_anno_attribuito_id.'.pivot.value', $imp_anno_attribuito);

        // $this->form_data['ratings.9.pivot.value']=99;
        // dddx($this->form_data);
        
        // Return total to view for display
        return ['tot' => $tot];
    }

    private function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function save(): void
    {
        /** @var IndennitaResponsabilita $record */
        $record = $this->getRecord();

        $rules = $this->getRules();

        $validatedData = $this->validate($rules);

        /** @var array<string, mixed> $up */
        $up = collect($this->form_data)->only(['dal', 'al', 'note'])->toArray();

        $record->update($up);

        /** @var array<array{id: int, pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = $this->form_data['ratings'];
        foreach ($ratingsData as $rating) {
            $pivot_id = $rating['id'];
            $pivot_data = collect($rating['pivot'])->only(['value'])->toArray();
            $record->ratings()->updateExistingPivot($pivot_id, $pivot_data);
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function back(): void
    {
        $this->redirect(static::$resource::getUrl('index'));
    }
}
