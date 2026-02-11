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
use Webmozart\Assert\Assert;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Modules\IndennitaResponsabilita\Models\Rating;
use Illuminate\Database\Eloquent\Model;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;

/**
 * @property \Filament\Schemas\Schema $form
 * @property IndennitaResponsabilita $record
 */
class CompilaIndennitaResponsabilita
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    /**
     * Mounts page - resolves {record} from URL, authorizes, fills form.
     */
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();
        $this->previousUrl = url()->previous();

        // Fill form from model attributes + ratings pivot data
        $rec = $this->record;
        $modelData = $rec->attributesToArray();

        // Get ratings for current year using standard Eloquent relationship
        $r = $rec->ratings()->wherePivot('anno', $rec->anno)->get();
        $modelData['ratings'] = $r->keyBy('id')->toArray();

        $this->form->fill($modelData);
    }

    /**
     * Build form schema with reactive fields.
     */
    protected function getFormSchema(): array
    {
        $schema = [
            DatePicker::make('dal'),
            DatePicker::make('al'),
            Textarea::make('note')->columnSpanFull(),
        ];

        $currRecord = $this->record;
        $ratings = $currRecord->ratings()->wherePivot('anno', $currRecord->anno)->get();

        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';
            $item = TextInput::make($fieldname)
                ->label(strip_tags($rating->txt))
                ->rules($rating->rules ?? '')
                ->numeric()
                ->reactive()
                ->live(onBlur: true)
                ->columns(2);

            if ($rating->is_readonly ?? false) {
                // Readonly computed field: afterStateHydrated sets initial computed value
                // readOnly prevents user editing, recalculation is triggered by non-readonly fields via $set
                $item->readOnly()
                    ->extraInputAttributes(['class' => 'bg-gray-100'])
                    ->afterStateHydrated(function (TextInput $component, Get $get) use ($rating): void {
                        $method = 'get' . Str::studly((string)$rating->title);
                        if (method_exists($this, $method)) {
                            $component->state($this->$method($get));
                        }
                    });
            } else {
                // Editable field: live updates, on change, recalculate ALL readonly fields
                $item->afterStateUpdated(function (Set $set, Get $get): void {
                    $this->recalculateReadonlyFields($set, $get);
                });
            }

            $schema[] = $item;
        }

        return $schema;
    }

    public function getTot(Get $get): int
    {
        $ratings = $get('ratings') ?? [];
        if (!is_array($ratings)) {
            $ratings = [];
        }

        $tot = 0;
        foreach ($ratings as $rating) {
            $value = $rating['pivot']['value'] ?? 0;
            if (!in_array(($rating['title'] ?? ''), ['tot', 'importo mensile calcolato', 'importo mensile attribuito', 'importo annuale attribuito'])) {
                $tot += (int) ($value ?? 0);
            }
        }

        return (int) $tot;
    }

    public function getImportoMensileCalcolato(Get $get): float
    {
        return (float) ($this->getTot($get)) * 10;
    }

    public function getImportoMensileAttribuito(Get $get): float
    {
        $perc = (float) ($this->record->perc_p_time_year ?? 1);
        return $this->getImportoMensileCalcolato($get) * $perc;
    }

    public function getImportoAnnualeAttribuito(Get $get): float
    {
        return $this->getImportoMensileAttribuito($get) * 12;
    }

    private function recalculateReadonlyFields(): void
    {
        $readonlyFieldMap = [];
        $currRecord = $this->record;
        $ratings = $currRecord->ratings()->wherePivot('anno', $currRecord->anno)->get();

        foreach ($ratings as $rating) {
            if ($rating->is_readonly ?? false) {
                $readonlyFieldMap[(string)$rating->title] = 'ratings.' . $rating->id . '.pivot.value';
            }
        }

        foreach ($readonlyFieldMap as $title => $fieldPath) {
            $method = 'get' . Str::studly($title);
            if (method_exists($this, $method)) {
                $this->form->set($fieldPath, $this->$method());
            }
        }
    }

    private function authorizeAccess(): void
    {
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    public function save(): void
    {
        $record = $this->getRecord();

        // Filament form components handle their own validation via ->rules()
        $this->form->validate();

        $up = collect($this->form->getState())->only(['dal', 'al', 'note'])->toArray();
        $record->update($up);

        $ratingsData = $this->form->getState('ratings');
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
        $this->redirect($this->previousUrl ?? static::$resource::getUrl('index'));
    }

    /**
     * Resolve record from route parameter.
     */
    private function resolveRecord(int|string $record): IndennitaResponsabilita
    {
        return IndennitaResponsabilita::findOrFail($record);
    }
}