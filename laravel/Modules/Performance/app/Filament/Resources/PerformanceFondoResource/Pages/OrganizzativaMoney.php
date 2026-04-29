<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Modules\Performance\Actions\Organizzativa as ActionsOrgaizzativa;
use Modules\Performance\Actions\UpdateHaDirittoAction;
use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Performance\Models\Organizzativa;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

class OrganizzativaMoney extends XotBasePage
{
    // use InteractsWithRecord;

    protected static string $resource = PerformanceFondoResource::class;

    /**
     * ---.
     */
    public function getView(): string
    {
        // restituisce performance::resources.performance-fondo-resource.pages.organizzativa-money
        // forse e' meglio performance::filament.
        // $view = app(GetViewAction::class)->execute();
        // dddx($view);
        // $view = 'performance::filament.resources.performance-fondo.pages.organizzativa-money';

        $view = 'performance::performance_fondo.pages.organizzativa_money';

        return $view;
    }

    /**
     * ---.
     */
    public function getViewData(): array
    {
        $year = '2024';

        app(ActionsOrgaizzativa\UpdateAssenzeAction::class)->execute($year, 'dip');
        // app(UpdateHaDirittoAction::class)->execute(Organizzativa::class, $year, 'dip');
        app(ActionsOrgaizzativa\UpdateQuotaTeoricaAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateBudgetAssegnatoAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateQuotaEffettivaAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateRestiAction::class)->execute($year, 'dip');
        // app(ActionsOrgaizzativa\UpdateTotStabiAction::class)->execute($year, 'dip');
        // app(ActionsOrgaizzativa\UpdateRestiPondAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateTotValutatoreIdAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateRestiPondByValutatoreIdAction::class)->execute($year, 'dip');

        // app(ActionsOrgaizzativa\UpdateImportoTotaleAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\UpdateImportoTotaleByValutatoreIdAction::class)->execute($year, 'dip');
        app(ActionsOrgaizzativa\CheckSumAction::class)->execute($year, 'dip');

        return [
            'title' => 'Organizzativa Money',
            'icon' => 'heroicon-o-currency-euro',
        ];
    }
}
