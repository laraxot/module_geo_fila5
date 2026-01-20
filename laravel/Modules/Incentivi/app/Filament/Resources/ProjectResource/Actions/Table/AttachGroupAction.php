<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions\Table;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Workgroup;

class AttachGroupAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $workgroups = Workgroup::all();

        $this->translateLabel()
            ->label('Collega Gruppo')
            ->color('primary')
            ->icon('heroicon-s-user-group')
            ->modalContent(view('incentivi::filament.actions.attach-group', ['workgroups' => $workgroups]))
            ->schema(fn (Action $action): array => [
                Select::make('workgroup_id')
                    ->label('Gruppo')
                    ->options(Workgroup::all()->pluck('denominazione', 'id'))
                    ->searchable()
                    ->required(),
            ])
            ->after(function (Action $action, array $data, HasTable $livewire) {
                /** @var Workgroup|null $workgroup */
                $workgroup = Workgroup::find($data['workgroup_id']);

                // Type guard: ensure $livewire implements ManageRelatedRecords to access getOwnerRecord()
                if (! $livewire instanceof ManageRelatedRecords) {
                    return;
                }

                $project = $livewire->getOwnerRecord(); // Ottieni il progetto corrente

                if (! ($project instanceof Project) || $workgroup === null) {
                    return;
                }

                // Collega tutti gli Employee del Workgroup selezionato al Project corrente
                $employees = $workgroup->employees; // Using documented relationship from @property-read in Workgroup model
                $employees->each(function (Employee $employee) use ($project) {
                    $employee->projects()->attach($project->id);
                });
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'AttachGroupAction';
    }
}
