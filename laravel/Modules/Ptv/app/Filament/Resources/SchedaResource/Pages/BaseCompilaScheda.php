<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;
use Override;

// class CompilaCondizioniLavoro extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord {
/**
 * Custom form implementation for compiling evaluation sheets
 * Uses data array for Livewire wire:model binding
 */
abstract class BaseCompilaScheda extends XotBasePage
{
    /* implements HasFormActions */
    // use HasRecordBreadcrumb;
    use HasRelationManagers;
    use InteractsWithRecord;
    // use UsesResourceForm; // Not needed - using custom data implementation

    public static string $resource = SchedaResource::class;

    protected string $view = 'ptv::scheda.pages.compila';

    /** @var array<string, mixed> */
    public array $data = [];

    public bool $excellence = false;

    public float $totale = 0.0;

    public string $previousUrl = '#';

    /** @var array<string, string> */
    protected array $rules = [];

    public function mount(int|string $record): void
    {
        $record = $this->resolveRecord($record);
        $this->record = $record;

        /*
        $recordClass = \get_class($this->record);
        $resourceClass = Str::of($recordClass)
            ->replace('Models\\', 'Filament\\Resources\\')
            ->append('Resource')
            ->toString();
        static::$resource = $resourceClass;
        */
        $view = app(GetViewByModelClassAction::class)->execute($this->record::class, '.pages.compila');

        $this->view = $view;
        $this->authorizeAccess();
        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    private function authorizeAccess(): void
    {
        // Check if user can access the resource
        $resource = static::$resource;
        if (! $resource::canEdit($this->getRecord())) {
            abort(403);
        }

        // Check specific permission for compiling
        if (! Gate::allows('compila', $this->record)) {
            abort(403);
        }
    }

    private function fillForm(): void
    {
        $this->beforeFill();

        //$data = $this->getRecord()->attributesToArray();
        $data = $this->getRecord()->getAttributes();

        $data = $this->mutateFormDataBeforeFill($data);

        // Store form data directly without using Filament form
        /* @var array<string, mixed> $data */
        $this->data = $data;
        
        // Initialize excellence and totale if they exist
        $this->excellence = (bool) ($this->getRecord()->excellence ?? false);
        $this->totale = (float) ($this->getRecord()->totale_punteggio ?? 0.0);

        // Hook for after filling form data
        $this->afterFill();
    }

    #[Override]
    protected function getViewData(): array
    {
        return [
            'view' => $this->view,
            'record' => $this->getRecord(),
            'data' => $this->data,
            'excellence' => $this->excellence,
            'totale' => $this->totale,
        ];
    }

    private function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    /**
     * Hook called before filling form data.
     */
    protected function beforeFill(): void
    {
        // Override in child classes if needed
    }

    /**
     * Hook called after filling form data.
     */
    protected function afterFill(): void
    {
        // Override in child classes if needed
    }

    public function save(): void
    {
        $this->validate();
        
        $data = $this->data;
        $data['excellence'] = $this->excellence;
        $data['totale_punteggio'] = $this->totale;
        
        $this->getRecord()->update($data);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function recalculate(): void
    {
        $tot = 0.0;

        $criteri_valutazione = $this->record->criteriValutazione ?? collect();
        foreach ($criteri_valutazione as $v) {
            $nome = $v->getAttribute('nome');
            if (is_string($nome)) {
                $dataValue = $this->data[$nome] ?? 0;
                if (is_numeric($dataValue)) {
                    $value = floatval($dataValue);
                    $peso = method_exists($this->record, 'getPeso') ? $this->record->getPeso($nome) : 1.0;
                    $tot += $peso * $value;
                }
            }
        }

        $tot /= 4;

        $this->totale = $tot;
    }

    public function updatedData(): void
    {
        $this->recalculate();
    }

    public function back(): void
    {
        /** @var string|null $url */
        $url = static::$resource::getUrl('index');
        redirect($url ?? '');
    }
}
