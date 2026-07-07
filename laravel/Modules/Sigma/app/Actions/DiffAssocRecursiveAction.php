<?php

declare(strict_types=1);

namespace Modules\Sigma\Actions;

/**
 * Action for performing recursive array_diff_assoc operations.
 * Used for comparing configuration arrays and data structures.
 */
class DiffAssocRecursiveAction
{
    /**
     * Execute recursive array_diff_assoc operation.
     *
     * @param  array  $array1
     * @param  array  $array2
     * @return array<string, mixed>
     */
    public function execute(array<string, mixed> $array1, array $array2): array
    {
        return $this->arrayDiffAssocRecursive($array1, $array2);
    }

    /**
     * Recursive array_diff_assoc implementation.
     *
     * @param  array  $array1
     * @param  array  $array2
     * @return array<string, mixed>
     */
    private function arrayDiffAssocRecursive(array<string, mixed> $array1, array $array2): array
    {
        $difference = [];

        foreach ($array1 as $key => $value) {
            if (is_array($value)) {
                if (! isset($array2[$key]) || ! is_array($array2[$key])) {
                    $difference[$key] = $value;
                } else {
                    /** @var array<string, mixed> $value */
                    /** @var array<string, mixed> $array2Value */
                    $array2Value = $array2[$key];
                    $newDiff = $this->arrayDiffAssocRecursive($value, $array2Value);
                    if (! empty($newDiff)) {
                        $difference[$key] = $newDiff;
                    }
                }
            } elseif (! array_key_exists($key, $array2) || $array2[$key] !== $value) {
                $difference[$key] = $value;
            }
        }

        return $difference;
    }
}
