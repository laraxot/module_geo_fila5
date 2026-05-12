<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class ShowMailSendedAt
{
    use QueueableAction;

    /**
     * Get the formatted mail sent dates for a given model.
     *
     * @param  Scheda  $model  The model to get mail sent dates for
     * @return string HTML formatted string containing mail sent dates
     */
    public function execute(SchedaContract $model): string
    {
        $dates = ($model->myLogs()->where('act', 'sendMail')->pluck('created_at')->toArray());
        $html = '';
        foreach ($dates as $date) {
            $formattedDate = $date->format('d/m/Y H:i:s') ?? '';
            $html .= $formattedDate.'<br/>';
        }

        return $html;
    }
}
