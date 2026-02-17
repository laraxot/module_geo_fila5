<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Uses the "Super Mucca" methodology:
 * - Study first, then implement with confidence
 * - Follow Laraxot patterns (XotBase*, DRY+KISS+SOLID)
 * - Always document decisions in docs/
 *
 * @property IndennitaResponsabilita|Model|int|string|null $record
 * @property array<string, mixed> $data
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    use InteractsWithRecord;

    protected static string $resource = IndennitaResponsabilitaResource::class;

    public static ?string $model = IndennitaResponsabilita::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public int|string $recordId = 0;

    public ?string $previousUrl = null;

    /**
     * Mount page - resolves {record} from URL, authorizes, fills form.
     */
    public function mount(int|string $record): void
    {
        $this->recordId = $record;
        $this->record = $this->resolveRecord($record);

        if ($this->record === null) {
            abort(404);
        }

        $this->authorizeAccess();

        $this->previousUrl = (string) url()->previous();

        $this->fillFormWithInitialData();
    }

    /**
     * Fill form with initial data from record.
     */
    protected function fillFormWithInitialData(): void
    {
        $this->form->fill([
            'matr' => $this->record->matr,
            'cognome' => $this->record->cognome,
            'nome' => $this->record->nome,
            'dal' => $this->record->dal,
            'al' => $this->record->al,
        ]);
    }

    /**
     * Authorize access to this page.
     */
    protected function authorizeAccess(): void
    {
        Gate::authorize('update', $this->record);
    }

    /**
     * Build form schema with readonly fields for ratings.
     * Uses schemaless attributes for year filtering.
     */
    protected function getFormSchema(): array
    {
        return [
            Section::make('Informazioni Generali')
                ->columns(4)
                ->schema([
                    TextInput::make('matr')
                        ->label('Matricola')
                        ->disabled(),
                    TextInput::make('cognome')
                        ->label('Cognome')
                        ->disabled(),
                    TextInput::make('nome')
                        ->label('Nome')
                        ->disabled(),
                    TextInput::make('perc_p_time_year_display')
                        ->label('P.Time %')
                        ->formatStateUsing(fn (): string => number_format((float) ($this->record->perc_p_time_year ?? 0) * 100, 2).' %')
                        ->disabled(),
                ]),

            Section::make('Valutazioni Anno '.($this->record->anno ?? 2025))
                ->schema($this->getRatingsSchema()),

            Section::make('Riepilogo Calcoli')
                ->columns(4)
                ->schema([
                    TextInput::make('tot_score')
                        ->label('Punteggio Totale')
                        ->readOnly()
                        ->extraInputAttributes(['class' => 'bg-gray-100 font-bold text-lg']),
                    TextInput::make('mensile_calcolato')
                        ->label('Mensile Calcolato')
                        ->readOnly()
                        ->extraInputAttributes(['class' => 'bg-gray-100']),
                    TextInput::make('mensile_attribuito')
                        ->label('Mensile Attribuito')
                        ->readOnly()
                        ->extraInputAttributes(['class' => 'bg-gray-100']),
                    TextInput::make('annuale_attribuito')
                        ->label('Annuale Attribuito')
                        ->readOnly()
                        ->extraInputAttributes(['class' => 'bg-gray-100']),
                ]),
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

        $schema = [];
        /** @var array<int, array{title: string, path: string}> $readonlyFields */
        $readonlyFields = [];

        // Add summary fields to the reactivity tracker
        $readonlyFields[] = ['title' => 'Tot', 'path' => 'tot_score'];
        $readonlyFields[] = ['title' => 'ImportoMensileCalcolato', 'path' => 'mensile_calcolato'];
        $readonlyFields[] = ['title' => 'ImportoMensileAttribuito', 'path' => 'mensile_attribuito'];
        $readonlyFields[] = ['title' => 'ImportoAnnualeAttribuito', 'path' => 'annuale_attribuito'];

        /** @var Rating $rating */
        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';

            $item = TextInput::make($fieldname)
                ->label(strip_tags((string) ($rating->txt ?? $rating->title)))
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
                $readonlyFields[] = [
                    'title' => (string) $rating->title,
                    'path' => $fieldname,
                ];
                $item->readOnly()
                    ->extraInputAttributes(['class' => 'bg-gray-100 cursor-not-allowed'])
                    ->afterStateHydrated(function (TextInput $component, Get $get) use ($rating): void {
                        $method = 'get'.Str::studly((string) $rating->title);
                        if (method_exists($this, $method)) {
                            $result = $this->$method($get, []);
                            $component->state($result);
                        }
                    });
            } else {
                $item->numeric()->nullable();

                $item->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, Get $get) use (&$readonlyFields): void {
                        $this->recalculateReadonlyFields($set, $get, $readonlyFields);
                    });
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
        /** @var \Illuminate\Database\Eloquent\Collection<int, Rating> $ratings */
        $ratings = $this->record->ratings()
            ->where('extra_attributes->anno', $this->record->anno)
            ->get();

        return $ratings;
    }

    /**
     * Get the form schema for the page.
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->model($this->getModel())
            ->statePath('data')
            ->columns(2);
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
        // $excludePaths = array_column($readonlyFields, 'path');

        $tot = 0;
        foreach ($ratings as $id => $rating) {
            // $path = "ratings.{$id}.pivot.value";
            // if (in_array($path, $excludePaths, true)) {
            //     continue;
            // }
            $value = $rating['pivot']['value'] ?? 0;
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
        $this->form->validate();
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();

        // Update record standard fields
        /** @var array<string, mixed> $dataToUpdate */
        $dataToUpdate = collect($state)->only(['dal', 'al', 'note'])->toArray();
        $this->record->update($dataToUpdate);

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
