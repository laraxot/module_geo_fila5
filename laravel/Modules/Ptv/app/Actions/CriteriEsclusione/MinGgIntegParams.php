<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\CriteriEsclusione;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Sigma\Models\Integparam;
use Spatie\QueueableAction\QueueableAction;

class MinGgIntegParams
{
    use QueueableAction;

    public function execute(Model $scheda, string $value, Collection $criteriOption): string
    {
        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        $ente = isset($scheda->ente) ? $scheda->ente : null;
        $matr = isset($scheda->matr) ? $scheda->matr : null;
        $last_integ = Integparam::where('ente', $ente)
            ->where('matr', $matr)
            ->latest('anv2ka')
            ->first();
        if ($last_integ == null) {
            return '';
        }

        $value = intval($value);
        $data_presenza_al = $criteriOption->get('data_presenza_al');
        // aggiornare campo con il valore minimo ..
        // dddx(['rows'=>$rows,'data_presenza_al'=>$data_presenza_al]);

        $data_presenza_al_value = $data_presenza_al;
        if (! ($data_presenza_al_value instanceof Carbon)) {
            return '';
        }
        $days = $last_integ->anv2kd->diffInDays($data_presenza_al_value, true);
        $scheda = tap($scheda)->update(['gg_integ_params' => $days]);
        // dddx([$scheda,$days]);
        if ($days < $value) {
            return 'no min gg_integ_params [my:'.$days.'][min:'.$value.']';
        }

        return '';
    }
}
