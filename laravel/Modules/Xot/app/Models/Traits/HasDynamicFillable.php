<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

/**
 * Extends the model's fillable list with the values of one or more backed enums.
 *
 * Consumers declare which enums contribute fillable field names by
 * implementing {@see self::getDynamicFillableEnums()}, returning an array
 * of backed enum class-strings. Each case's scalar value is treated as a
 * column/attribute name and merged into the static `$fillable` array.
 */
trait HasDynamicFillable
{
    /**
     * @return array<int, class-string<\UnitEnum>>
     */
    protected function getDynamicFillableEnums(): array
    {
        return [];
    }

    /**
     * @return array<int, string>
     */
    public function getFillable(): array
    {
        $fillable = parent::getFillable();

        foreach ($this->getDynamicFillableEnums() as $enumClass) {
            foreach ($enumClass::cases() as $case) {
                if ($case instanceof \BackedEnum) {
                    $fillable[] = (string) $case->value;
                }
            }
        }

        return array_values(array_unique($fillable));
    }
}
