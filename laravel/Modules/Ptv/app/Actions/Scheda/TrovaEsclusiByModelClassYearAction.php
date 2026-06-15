<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Spatie\QueueableAction\QueueableAction;

class TrovaEsclusiByModelClassYearAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(string $modelClass, string $fieldName, int $year): void
    {
        if (! class_exists($modelClass)) {
            return;
        }

        /** @var class-string<Model> $validatedModelClass */
        $validatedModelClass = $modelClass;

        $query = $validatedModelClass::query()
            ->where($fieldName, $year)
            ->inRandomOrder();

        $rows = $query->get();

        if (! ($rows instanceof EloquentCollection)) {
            return;
        }

        $module_name = Str::between($modelClass, 'Modules\\', '\Models\\');
        if (! is_string($module_name) || $module_name === '') {
            return;
        }

        $criteri_esclusione_class = '\Modules\\'.$module_name.'\Models\CriteriEsclusione';
        $criteri_option_class = '\Modules\\'.$module_name.'\Models\CriteriOption';

        if (! class_exists($criteri_esclusione_class) || ! class_exists($criteri_option_class)) {
            return;
        }

        /** @var class-string<Model> $criteriEsclusioneClass */
        $criteriEsclusioneClass = $criteri_esclusione_class;

        /** @var class-string<Model> $criteriOptionClass */
        $criteriOptionClass = $criteri_option_class;

        $criteriEsclusioneQuery = $criteriEsclusioneClass::query()
            ->where($fieldName, $year)
            ->where('value', '!=', 0);

        $criteri_esclusione = $criteriEsclusioneQuery->get();

        if (! ($criteri_esclusione instanceof EloquentCollection)) {
            return;
        }

        $criteriOptionQuery = $criteriOptionClass::query()
            ->where($fieldName, $year);

        $criteriOptionCollection = $criteriOptionQuery->get();

        $criteri_option = $criteriOptionCollection
            ->map(function (Model $item): Model {
                $value = '';
                $type = isset($item->type) && is_string($item->type) ? $item->type : '';
                $itemValue = isset($item->value) ? $item->value : null;

                switch ($type) {
                    case 'list':
                        $value = is_string($itemValue) ? explode(',', $itemValue) : [];
                        break;
                    case 'int':
                        $value = is_numeric($itemValue) ? intval((string) $itemValue) : 0;
                        break;
                    case 'date':
                        $value = $itemValue;
                        if ($value !== null && is_string($value)) {
                            try {
                                $value = Carbon::parse($value);
                            } catch (Exception $e) {
                                $value = null;
                            }
                        }
                        break;
                    default:
                        // Skip unknown types
                        break;
                }

                $item->setAttribute('value_real', $value);

                return $item;
            })
            ->filter()
            ->pluck('value_real', 'name');

        foreach ($rows as $row) {
            app(Check::class)->execute($row, $criteri_esclusione, $criteri_option);
        }
    }
}
