<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\MyLog;
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
    public function execute(Scheda $model): string
    {
        $a = Scheda::firstWhere(['id' => $model->getKey()]);

        if (! $a) {
            return '';
        }

        $html = '';
        // Use mailInviate() relation which returns HasMany<MyLog>
        $myLogs = $a->mailInviate()->where('act', 'sendMail')->get();
        
        /** @var MyLog $row */
        foreach ($myLogs as $row) {
            $formattedDate = $row->updated_at?->format('Y-m-d H:i:s') ?? '';
            $html .= '<br/>'.$formattedDate;
        }

        return $html;
    }
}
