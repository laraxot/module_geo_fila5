<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Forms\Components\TextInput;
// use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendMailIndennitaResponsabilita extends XotBasePage
{
    // use HasRelationManagers;
    // use InteractsWithRecord;
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public array $data = [];

    /** @var array<string, mixed> */
    public array $tableFilters = [];

    protected static string $resource = IndennitaResponsabilitaResource::class;

    protected string $view = 'indennitaresponsabilita::filament.resources.indennita-responsabilita.pages.send-mail';

    public function __construct()
    {
        // dddx('a');
    }

    public function mount(): void
    {
        $data = request()->all();
        if (isset($data['anno/valutatore']) && is_array($data['anno/valutatore'])) {
            // Type narrowing: ensure $data['anno/valutatore'] is array<string, mixed>
            /** @var array<string, mixed> $tableFiltersData */
            $tableFiltersData = $data['anno/valutatore'];
            $this->tableFilters = $tableFiltersData;
        }
        // dddx('b');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ])
            ->statePath('data');
    }
}
