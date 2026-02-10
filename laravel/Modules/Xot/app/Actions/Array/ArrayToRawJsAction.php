<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use Filament\Support\RawJs;
use Spatie\QueueableAction\QueueableAction;

     * @param  array<string|mixed, mixed>  $array  Array associativo (anche annidato); valori RawJs restano raw
     */
    public function execute(array $array): RawJs
    {
        $parts = [];
        foreach ($array as $key => $value) {
            $k = $this->jsKey((string) $key);
            if ($value instanceof RawJs) {
                $parts[] = $k.': '.$value->toHtml();
            } elseif (is_array($value)) {
                $parts[] = $k.': '.$this->execute($value)->toHtml();
            } else {
                $parts[] = $k.': '.$this->jsValue($value);
            }
        }

        return RawJs::make('{'.implode(', ', $parts).'}');
    }

    /** Chiave JS sicura per attributo HTML: identificatore o 'key'. */
    private function jsKey(string $key): string
    {
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key) ? $key : "'".str_replace("'", "\\'", $key)."'";
    }

    /** Valore JS sicuro per attributo HTML: niente virgolette doppie. */
    private function jsValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_null($value)) {
            return 'null';
        }
        if (is_numeric($value)) {
            return (string) $value;
        }

        return "'".str_replace(['\\', "'"], ['\\\\', "\\'"], (string) $value)."'";
    }
}
