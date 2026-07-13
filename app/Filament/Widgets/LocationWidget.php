<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Geo\Filament\Forms\LocationForm;
<<<<<<< HEAD
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;
=======
use Modules\Xot\Filament\Widgets\XotBaseWidget;
>>>>>>> laraxot/dev

/**
 * Widget per la selezione della località.
 *
 * Questo widget fornisce un form per la selezione della località utilizzando
 * il form LocationForm.
 *
 * @see \Modules\Geo\docs\json-database.md
 */
<<<<<<< HEAD
class LocationWidget extends XotBaseSchemaWidget
{
    /**
     * Dati del widget.
=======
class LocationWidget extends XotBaseWidget
{
    /**
     * Dati del widget.
     *
     * @var array<string, mixed>|null
>>>>>>> laraxot/dev
     */
    public ?array $data = [];

    /**
     * Titolo del widget.
     */
    public string $title = 'geo::widgets.location.title';

    /**
     * Icona del widget.
     */
    public string $icon = 'heroicon-o-map-pin';

    /**
     * Ordine di visualizzazione del widget.
     */
    protected static ?int $sort = 1;

    /**
     * Numero di colonne occupate dal widget.
     */
    protected int|string|array $columnSpan = 'full';

    /**
     * Vista del widget.
     */
    protected string $view = 'geo::filament.widgets.location';

    /**
     * Form per la selezione della località.
     */
    private LocationForm $locationForm;

    /**
     * Costruttore.
     */
    public function __construct()
    {
        $this->locationForm = new LocationForm();
    }

    /**
     * Inizializza il widget.
     */
    public function mount(): void
    {
        $this->form->fill();
    }

    /**
     * Ottiene lo schema del form.
     *
     * @return array<int, Component>
     */
<<<<<<< HEAD
=======
    #[\Override]
>>>>>>> laraxot/dev
    public function getFormSchema(): array
    {
        return $this->locationForm->getSchema();
    }

    /**
     * Gestisce l'invio del form.
     */
    public function submit(): void
    {
        $data = $this->form->getState();

        $this->dispatch('location-selected', $data);

        // Utilizzo metodo Livewire per notifiche
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => __('geo::widgets.location.messages.success'),
        ]);
    }

    /**
     * Verifica se il widget può essere visualizzato.
     */
    public static function canView(): bool
    {
        return true;
    }
}
