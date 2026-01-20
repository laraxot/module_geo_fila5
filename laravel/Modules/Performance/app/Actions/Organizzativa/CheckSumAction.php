<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Schede;
use Modules\Performance\Models\OrganizzativaCatCoeff as CatCoeff;
use Modules\Performance\Models\PerformanceFondo;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * ---.
 */
class CheckSumAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type): void
    {
        $tbl_categoria_coeff = app(CatCoeff::class)->getTable();
        $model = app(Schede::class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        Assert::notNull($imp = Schede::selectRaw('sum(importo_totale) as tot')
            ->where('ha_diritto', '>', 0)
            ->where('anno', $year)
            ->where('type', $type)
            ->first());
        $fondo = PerformanceFondo::firstOrCreate(['anno' => $year]);
        $quota = (float) $fondo->quota_organizzativa;
        echo '
		<table border="1">
			<tr><th>Quota :</th><th align="right">'.number_format($quota, 2).'</th></tr>
			<tr><th>Quota Distribuita :</th><th align="right">'.number_format((float) $imp->tot, 2).'</th></tr>
			<tr><th>Diff : </th><th align="right">'.number_format($quota - $imp->tot, 2).'</th></tr>;
		</table>';
    }
}
