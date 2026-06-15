<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Progressioni;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Spatie\QueueableAction\QueueableAction;

class RefreshHaDirittoAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Progressioni $record): void
    {
        $criteri_esclusione_filtered = $record->criteriEsclusione->where('value', '!=', 0)->where('value', '!=', null);
        $fields_to_resets = $criteri_esclusione_filtered->where('field_name', '!=', null);
        $up = [];
        foreach ($fields_to_resets as $field) {
            if (! in_array($field->field_name, ['propro'], false)) {
                $up[$field->field_name] = null;
            }
        }

        $up['gg_cateco_posfun'] = null;
        $up['gg_asz_cateco_posfun'] = null;
        $up['gg_cateco_posfun_in_sede'] = null;
        $up['gg_cateco_posfun_fuori_sede'] = null;
        $up['gg_asz_cateco_posfun_in_sede'] = null;
        $up['gg_asz_cateco_posfun_fuori_sede'] = null;

        $record->update($up);
        Notification::make()
            ->title('Campi Svuotati ['.implode(',', array_keys($up)).']')
            ->success()
            ->send();

        // Get the full collections for the Check action and convert to Support\Collection
        /** @var Collection<int, Model&object{name: string, value: mixed}> $criteri_esclusione */
        $criteri_esclusione = Collection::make($record->criteriEsclusione->all())->map(function ($item) {
            return (object) [
                'name' => $item->name,
                'value' => $item->value,
            ];
        });
        $criteri_option = Collection::make(
            CriteriOption::where('anno', $record->anno)->get()->all()
        );

        app(Check::class)->execute($record, $criteri_esclusione, $criteri_option);
    }
}
