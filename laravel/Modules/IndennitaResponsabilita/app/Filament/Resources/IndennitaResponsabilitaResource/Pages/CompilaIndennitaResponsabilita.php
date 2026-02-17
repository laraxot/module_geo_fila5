<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Pages\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Gate;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

/**
 * Page for filling out Indennita Responsabilita ratings.
 *
 * @property IndennitaResponsabilita $record
 * @property array<string, mixed> $data
 */
class CompilaIndennitaResponsabilita extends XotBasePage
{
    public static ?string $model = IndennitaResponsabilita::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    public ?string $previousUrl = null;

    public function mount(int|string $record): void
    {
        $resolved = IndennitaResponsabilita::find($record);
        if ($resolved === null) {
            abort(404);
        }

        $this->record = $resolved;
        $this->authorizeAccess();
        $this->previousUrl = (string) url()->previous();
        $this->fillFormWithInitialData();
    }

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

    protected function authorizeAccess(): void
    {
        Gate::authorize('update', $this->record);
    }

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

    protected function getRatingsSchema(): array
    {
        $ratings = $this->getRatingsForYear();

        $schema = [];
        foreach ($ratings as $rating) {
            $fieldname = 'ratings.'.$rating->id.'.pivot.value';

            $item = TextInput::make($fieldname)
                ->label($rating->txt)
                ->rules($rating->rules ?? '')
                ->columns(2);

            if ((bool) ($rating->is_readonly ?? false)) {
                $item->readOnly()
                    ->extraInputAttributes([
                        'class' => 'bg-gray-100 border-gray-300 text-gray-600 cursor-not-allowed',
                        'readonly' => true,
                    ]);
            }

            $schema[] = $item;
        }

        return $schema;
    }

    protected function getRatingsForYear(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->record->ratings()
            ->where('extra_attributes->anno', $this->record->anno)
            ->get();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->model($this->getModel())
            ->statePath('data')
            ->columns(2);
    }

    public function getModel(): string
    {
        return static::$model ?? IndennitaResponsabilita::class;
    }

    public function save(): void
    {
        $this->validate();

        $data = $this->form->getState();

        $this->record->update(collect($data)->only(['dal', 'al', 'note']));

        $ratings = collect($this->data['ratings'] ?? []);
        foreach ($ratings as $id => $ratingData) {
            $value = $ratingData['pivot']['value'] ?? 0;
            $this->record->ratings()->updateExistingPivot($id, ['value' => $value]);
        }

        Notification::make()
            ->title('Dati salvati')
            ->success()
            ->send();
    }

    public function back(): void
    {
        if ($this->previousUrl) {
            $this->redirect($this->previousUrl);
        } else {
            $this->redirect('/indennitaresponsabilita/admin/indennita-responsabilitas');
        }
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Indietro')
                ->icon('heroicon-o-arrow-left')
                ->action(function (): void { $this->back(); }),
        ];
    }
}
