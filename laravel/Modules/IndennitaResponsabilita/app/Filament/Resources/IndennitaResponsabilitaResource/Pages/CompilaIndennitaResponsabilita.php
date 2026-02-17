<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use LogicException;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Collection;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Uses the "Super Mucca" methodology:
 * - Study first, then implement with confidence
 * - Follow Laraxot patterns (XotBase*, DRY+KISS+SOLID)
 * - Always document decisions in docs/
 *
 * @property IndennitaResponsabilita $record
 * @property array<string, mixed> $data
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    use InteractsWithRecord;

    protected static string $resource = IndennitaResponsabilitaResource::class;

    public static ?string $model = IndennitaResponsabilita::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public ?string $previousUrl = null;

    /**
     * Mount page - resolves {record} from URL, authorizes, fills form.
     */
    public function mount(int|string $record): void
    {
        /** @var IndennitaResponsabilita $resolvedRecord */
        $resolvedRecord = $this->resolveRecord($record);
        $this->record = $resolvedRecord;

        if (! $this->record instanceof IndennitaResponsabilita) {
            abort(404);
        }

        $this->authorizeAccess();

        $this->previousUrl = (string) url()->previous();

        $this->fillFormWithInitialData();
    }

    /**
     * Type-safe record getter.
     * Use explicit type narrowing for PHPStan Level 10.
     */
    public function getSpecificRecord(): IndennitaResponsabilita
    {
        $record = $this->record;
        if (! $record instanceof IndennitaResponsabilita) {
            throw new LogicException('Record must be an instance of IndennitaResponsabilita.');
        }

        return $record;
    }

    /**
     * Fill form with initial data from record.
     * Solo campi editabili, le informazioni generali sono in Infolist.
     */
    protected function fillFormWithInitialData(): void
    {
        $record = $this->getSpecificRecord();
        $data=$record->load('ratings')->attributesToArray();
        $ratings=$record->ratings->pluck('pivot.value','id')->toArray();
        foreach($ratings as $id=>$value){
            $data['ratings'][$id]['pivot']['value']=$value;
        }
        
        // Solo campi editabili, le informazioni generali sono visualizzate via Infolist
        $this->form->fill($data);
    }

    /**
     * Authorize access to this page.
     */
    protected function authorizeAccess(): void
    {
        Gate::authorize('update', $this->getSpecificRecord());
    }

    /**
     * Infolist per visualizzare le Informazioni Generali in sola lettura.
     * Separazione di responsabilità: Infolist per view, Form per input editabili.
     * In Filament v5, infolist uses Schema but entries are from Infolists.
     */
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->getSpecificRecord())
            ->components([
                Section::make('Informazioni Generali')
                    ->label('')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('matr')
                            ->label('Matricola'),
                        TextEntry::make('cognome')
                            ->label('Cognome'),
                        TextEntry::make('nome')
                            ->label('Nome'),
                        TextEntry::make('perc_p_time_year')
                            ->label('P.Time %')
                            ->formatStateUsing(fn (?float $state): string => number_format(($state ?? 0) * 100, 2).' %'),
                    ]),
            ]);
    }

    /**
     * Build form schema SOLO per campi editabili.
     * Le Informazioni Generali e il Riepilogo sono gestiti dall'Infolist.
     */
    protected function getFormSchema(): array
    {
        $record = $this->getSpecificRecord();

        return [
            DatePicker::make('dal'),
            DatePicker::make('al'),
            Textarea::make('note')->columnSpanFull(),
            ...$this->getRatingsSchema(),
        ];
    }

    /**
     * Get the form schema for ratings section.
     *
     * @return list<TextInput>
     */
    protected function getRatingsSchema(): array
    {
        $ratings = $this->getRatingsForYear();
        $readonlyFields=$ratings->where('is_readonly', true);

        $schema = [];
        
        
        /** @var Rating $rating */
        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';
            $label=strip_tags((string) ($rating->txt ?? $rating->title));
            $readOnly=(bool) ($rating->is_readonly ?? false);
            if(!$readOnly){
                //dddx($rating);
                $item = TextInput::make($fieldname)
                    ->label($label)
                    ->numeric()->nullable()
                    ->columns(2)
                    ->inlineLabel()
                    ->live(onBlur: true)
                    ->rules($rating->rule->value ?? '')
                    ->helperText('')
                    ->afterStateUpdated(function (Set $set, Get $get) use ($readonlyFields): void {
                        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
                    });;
            }

       

            if ($readOnly) {
               
                $item=TextEntry::make($fieldname)
                        ->label($label)
                        //->rules($rating->rule->value ?? '')
                        ->inlineLabel();
                /*
                $item->readOnly()
                    ->extraInputAttributes(['class' => 'bg-gray-100 cursor-not-allowed'])
                    ->afterStateHydrated(function (TextInput $component, Get $get) use ($rating, $readonlyFields): void {
                        $method = 'get'.Str::studly((string) $rating->title);
                        if (method_exists($this, $method)) {
                            // Fix type mismatch for method call
                            $result = (string) $this->$method($get, $readonlyFields);
                            $component->state($result);
                        }
                    });
                */
            } 

            $schema[] = $item;
        }

        

        return $schema;
    }

    /**
     * Get ratings for the current year using schemaless attributes.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Rating>
     */
    protected function getRatingsForYear(): \Illuminate\Database\Eloquent\Collection
    {
        $record = $this->getSpecificRecord();
        /** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $ratings */
        $ratings = $record->ratings()
            ->where('extra_attributes->anno', $record->anno)
            ->get();

        return $ratings;
    }

    /**
     * Get the form model.
     */
    public function getModel(): string
    {
        return static::$model ?? IndennitaResponsabilita::class;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    protected function recalculateReadonlyFields(Set $set, Get $get, Collection $readonlyFields): void
    {
        
        foreach ($readonlyFields as $rf) {
            $method = 'get'.Str::studly($rf->title);
            $fieldname = 'ratings.'.$rf->id.'.pivot.value';
            if (method_exists($this, $method)) {
                $set($fieldname, $this->$method($get, $readonlyFields));
            }
        }
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getTot(Get $get, Collection $readonlyFields ): int
    {
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratings */
        $ratings = (array) ($get('ratings') ?? []);

        $tot = 0;
        foreach ($ratings as $id => $rating) {
            $value = $rating['pivot']['value'] ?? 0;
            $tot += is_numeric($value) ? (int) $value : 0;
        }

        return $tot;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoMensileCalcolato(Get $get, Collection $readonlyFields ): float
    {
        return (float) $this->getTot($get, $readonlyFields) * 10.0;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoMensileAttribuito(Get $get, Collection $readonlyFields): float
    {
        $record = $this->getSpecificRecord();
        $perc = (float) ($record->perc_p_time_year ?? 1.0);

        return $this->getImportoMensileCalcolato($get, $readonlyFields) * $perc;
    }

    /**
     * @param  array<int, array{title: string, path: string}>  $readonlyFields
     */
    public function getImportoAnnualeAttribuito(Get $get, Collection $readonlyFields): float
    {
        return (float) $this->getImportoMensileAttribuito($get, $readonlyFields) * 12.0;
    }

    /**
     * @return array<string, Action|\Filament\Actions\ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'back' => Action::make('back')
                ->label('Back')
                ->color('gray')
                ->url(function (): string {
                    $url = static::$resource::getUrl('index');

                    return is_string($url) ? $url : '';
                }),
        ];
    }

    public function back(): \Illuminate\Http\RedirectResponse
    {
        /** @var string $url */
        $url = static::$resource::getUrl('index');

        return redirect()->to($url);
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        //$rules = $this->getRules();
        
        //$validatedData = $this->validate($rules);
        



        $this->form->validate();
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();
        $data=$this->data;

        $record = $this->getSpecificRecord();

        // Update record standard fields
        /** @var array<string, mixed> $dataToUpdate */
        $dataToUpdate = collect($data)->only(['dal', 'al', 'note'])->toArray();
        $record->update($dataToUpdate);

        // Update pivot ratings
        /** @var array<int|string, array{pivot: array{value: mixed}}> $ratingsData */
        $ratingsData = (array) ($state['ratings'] ?? []);
        foreach ($ratingsData as $id => $rating) {
            $value = $rating['pivot']['value'];
            $record->ratings()->updateExistingPivot($id, [
                'value' => is_numeric($value) ? $value : 0,
            ]);
        }

        if ($shouldSendSavedNotification) {
            Notification::make()->title('Saved successfully')->success()->send();
        }
    }
}
