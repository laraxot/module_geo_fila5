<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * Uses the "Super Mucca" methodology:
 * - Study first, then implement with confidence
 * - Follow Laraxot patterns (XotBase*, DRY+KISS+SOLID)
 * - Always document decisions in docs/
 *
 * @property IndennitaResponsabilita $record
 * @property array<string, mixed>    $data
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    public static ?string $model = IndennitaResponsabilita::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public ?string $previousUrl = null;

    /**
     * Mount page - resolves {record} from URL, authorizes, fills form.
     */
    public function mount(int|string $record): void
    {
        /** @var IndennitaResponsabilita|null $resolved */
        $resolved = IndennitaResponsabilita::find($record);
        if (null === $resolved) {
            abort(404);
        }

        $this->record = $resolved;

        $this->authorizeAccess();

        $this->previousUrl = (string) url()->previous();

        // Fill form with initial data
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
                ]),

            Section::make('Valutazioni Anno '.($this->record->anno ?? 2025))
                ->schema($this->getRatingsSchema()),
        ];
    }

    /**
     * Get the form schema for ratings section.
     *
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected function getRatingsSchema(): array
    {
        $ratings = $this->getRatingsForYear();

        $schema = [];
        /** @var array<int, array{title: string, path: string}> $readonlyFields */
        $readonlyFields = []; // Needed for closure usage

        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';

            $item = TextInput::make($fieldname)
                ->label(strip_tags((string) ($rating->txt ?? $rating->title)))
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
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
                // $ruleStr = $rating->rule instanceof RuleEnum ? (string) $rating->rule->value : '';
                $item->numeric()->nullable();

                /*
                if ($ruleStr !== '') {
                    $filtered = collect(explode('|', $ruleStr))
                        ->reject(fn (string $r): bool => in_array($r, ['numeric', 'nullable'], true))
                        ->implode('|');
                    if ($filtered !== '') {
                        $item->rules($filtered);
                    }
                }
                */

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
     * Get ratings for the current year using schemaless attributes.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, mixed>
     */
    protected function getRatingsForYear(): \Illuminate\Database\Eloquent\Collection
    {
        // Use schemaless attributes for year filtering
        return $this->record->ratings()
            ->where('extra_attributes->anno', $this->record->anno)
            ->get();
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
     * @param array<int, array{title: string, path: string}> $readonlyFields
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
     * @param array<int, array{title: string, path: string}> $readonlyFields
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
