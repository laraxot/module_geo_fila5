<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Gate;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

/**
 * Pagina SEMPLIFICATA per compilazione indennità
 * Focus solo su dati essenziali di valutazione
 */
class CompilaIndennitaResponsabilitaSemplificata extends XotBasePage
{
    protected static string $resource = IndennitaResponsabilitaResource::class;
    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.compila';

    /**
     * Mount della pagina - setup iniziale semplificato
     */
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        $this->authorizeAccess();
        $this->previousUrl = url()->previous();

        // ✅ Solo dati base
        $this->form->fill($this->record->only(['dal', 'al', 'note']));
    }

    /**
     * Schema semplificato - solo campi di valutazione base
     */
    protected function getFormSchema(): array
    {
        return [
            Forms\Section::make('dati_anagrafici')
                ->schema([
                    Forms\TextInput::make('matr')
                        ->label('Matricola')
                        ->required(),
                    Forms\TextInput::make('cognome')
                        ->label('Cognome')
                        ->required(),
                    Forms\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),
                ]),
            
            Forms\Section::make('valutazione')
                ->schema([
                    Forms\TextInput::make('responsabilita_di_spesa')
                        ->label('Responsabilità di spesa')
                        ->numeric()
                        ->required(),
                    Forms\TextInput::make('realizzazione_piani_programmi')
                        ->label('Realizzazione piani e programmi')
                        ->numeric()
                        ->required(),
                    Forms\TextInput::make('supporto_decisioni_dirigente')
                        ->label('Supporto decisioni del Dirigente')
                        ->numeric()
                        ->required(),
                ]),
            
            Forms\Section::make('note')
                ->schema([
                    Forms\Textarea::make('note')
                        ->label('Note')
                        ->rows(5),
                ]),
        ];
    }

    /**
     * Salva solo i dati essenziali
     */
    public function save(): void
    {
        $record = $this->getRecord();
        
        // ✅ VALIDAZIONE SEMPLIFICATA
        $this->validate([
            'matr' => 'required|string|max:6',
            'cognome' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'responsabilita_di_spesa' => 'required|numeric|between:0,5',
            'realizzazione_piani_programmi' => 'required|numeric|between:0,5',
            'supporto_decisioni_dirigente' => 'required|numeric|between:0,5',
            'note' => 'nullable|string|max:1000',
        ]);

        // ✅ SALVATAGGIO SOLO DATI BASE
        $record->update($this->form->getState());

        // ✅ EVENTO PER LOGICA AUTOMATICA
        event(new DatiSalvati($record));
        
        Notification::make()
            ->title('Indennità Salvate Correttamente')
            ->success()
            ->send();
    }

    /**
     * Authorizzazione accessi
     */
    private function authorizeAccess(): void
    {
        if (! Gate::allows('compila-semplice', $this->record)) {
            abort(403);
        }
    }

    /**
     * Resolve record dal parametro route
     */
    private function resolveRecord(int|string $record): IndennitaResponsabilita
    {
        return IndennitaResponsabilita::findOrFail($record);
    }
}