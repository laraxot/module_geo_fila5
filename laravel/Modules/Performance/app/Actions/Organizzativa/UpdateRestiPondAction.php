<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Organizzativa as Schede;
use Modules\Performance\Models\OrganizzativaCatCoeff as CatCoeff;
use Modules\Performance\Models\OrganizzativaTotStabi as TotStabi;
use Spatie\QueueableAction\QueueableAction;

/**
 * ---.
 */
class UpdateRestiPondAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $year, string $type): void
    {
        $tbl_categoria_coeff = app(CatCoeff::class)->getTable();
        $tbl_tot_stabi = app(TotStabi::class)->getTable();
        $model = app(Schede::class);
        $tbl = $model->getTable();
        $conn = $model->getConnection();

        $sql = 'update '.$tbl.' as A
			set resti_pond=0
            where A.anno="'.$year.'" and type="'.$type.'"';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);

        $sql = 'update '.$tbl.' as A
		set resti_pond=A.quota_effettiva*
		(
			select delta_min_punteggio
			from '.$tbl_tot_stabi.' as B
			where A.stabi=B.stabi and A.anno=B.anno
		)
		where A.anno="'.$year.'" and A.type="'.$type.'"
		and A.ha_diritto>0
		';
        echo '['.__LINE__.']<pre>'.$sql.'</pre>';
        $conn->statement($sql);
    }
}
