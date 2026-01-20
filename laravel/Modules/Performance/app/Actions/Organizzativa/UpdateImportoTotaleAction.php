<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Schede;
use Modules\Performance\Models\OrganizzativaCatCoeff as CatCoeff;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateImportoTotaleAction
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

        $sql = 'update '.$tbl.' as A set importo_totale=0 where anno="'.$year.'" and type = "'.$type.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl.' as A set importo_totale=quota_effettiva+resti_pond
            where  ha_diritto>0  and anno="'.$year.'" and type = "'.$type.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
