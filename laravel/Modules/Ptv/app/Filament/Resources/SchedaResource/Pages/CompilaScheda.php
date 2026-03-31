<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

// class CompilaCondizioniLavoro extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord {
/**
 * Custom form implementation for compiling evaluation sheets
 * Uses form_data array instead of Filament form component
 */
class CompilaScheda extends XotBasePage
{
    /* implements HasFormActions */
    // use HasRecordBreadcrumb;
    use HasRelationManagers;
    use InteractsWithRecord;
    // use UsesResourceForm; // Not needed - using custom form_data implementation

    public static string $resource = SchedaResource::class;

    protected string $view = 'ptv::scheda.pages.compila';

    /** @var array<string, mixed> */
    public array $form_data = [];

    public string $previousUrl = '#';

   
    public function mount(int|string $record): void
    {
        

        $record = $this->resolveRecord($record);
        $this->record = $record;
        $recordClass=get_class($this->record);
        $resourceClass=Str::of($recordClass)
            ->replace('Models\\','Filament\\Resources\\')
            ->append('Resource')
            ->toString();
        static::$resource=$resourceClass;

        $this->authorizeAccess();
        $view=app(GetViewByModelClassAction::class)->execute($recordClass,'.pages.compila');

        $this->view=$view;

        //$this->fillForm();

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

        $data = $this->getRecord()->attributesToArray();

       
        $data = $this->mutateFormDataBeforeFill($data);

        // Store form data directly without using Filament form
        /** @var array<string, mixed> $data */
        $this->form_data = $data;

        // Hook for after filling form data
        $this->afterFill();

    }

    protected function getViewData(): array
    {
        return [
            'view' => $this->view,
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
        // dddx($this->form_data['benificiario_progressione']);
        // dddx($this->form_data['punt_progressione']);
        $this->getRecord()->update($this->form_data);

        // dddx($this->getRecord()->benificiario_progressione);
        /*
        $this->getRecord()->update([
            'tot_presenza_periodo_plus_no_timbr' => $this->form_data['tot_presenza_periodo_plus_no_timbr'],
            'tot' => $this->form_data['tot_euro'],
        ]);
        foreach ($this->form_data['dettaglio'] as $pivot_id => $dettaglio) {
            $pivot_data = ['gg' => $dettaglio['pivot']['gg']];
            $this->getRecord()->indennitaTipoDettaglio()->updateExistingPivot($pivot_id, $pivot_data);
        }
        */
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function back(): void
    {
        /** @var string|null $url */
        $url = static::$resource::getUrl('index');
        redirect($url ?? '');
    }
}
