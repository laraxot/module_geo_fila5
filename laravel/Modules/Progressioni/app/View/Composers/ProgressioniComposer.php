<?php

declare(strict_types=1);

namespace Modules\Progressioni\View\Composers;

use Modules\Progressioni\Models\Schede;

class ProgressioniComposer
{
    /**
     * Undocumented function.
     */
    public function schedeCount(int $year): int
    {
        return Schede::where('anno', $year)
            // ->where('ha_diritto', '>', 0)
            // ->get()
            ->count();
    }
}
