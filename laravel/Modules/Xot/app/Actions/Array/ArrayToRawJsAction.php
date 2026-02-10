<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use Filament\Support\RawJs;
use Spatie\QueueableAction\QueueableAction;

<<<<<<< HEAD
=======
use function Safe\preg_match;

>>>>>>> ac0ea089 (.)
/**
 * Converte un array PHP in RawJs (oggetto JavaScript) sicuro per attributi HTML.
 *
 * Usa virgolette singole per stringhe e chiavi non-identificatore, così l'output
 * può essere usato dentro x-data="..." senza spezzare l'attributo.
 * I valori RawJs vengono emessi raw (es. formatter function per Chart.js).
 */
class ArrayToRawJsAction
{
    use QueueableAction;

    /**
     * Converte l'array in una stringa JavaScript (oggetto letterale) e restituisce RawJs.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $array  Array associativo (anche annidato); valori RawJs restano raw
=======
     * @param  array<string|mixed, mixed>  $array  Array associativo (anche annidato); valori RawJs restano raw
>>>>>>> ac0ea089 (.)
     */
    public function execute(array $array): RawJs
    {
        $parts = [];
        foreach ($array as $key => $value) {
            $k = $this->jsKey((string) $key);
            if ($value instanceof RawJs) {
<<<<<<< HEAD
                $parts[] = $k . ': ' . $value->toHtml();
            } elseif (is_array($value)) {
                $parts[] = $k . ': ' . $this->execute($value)->toHtml();
            } else {
                $parts[] = $k . ': ' . $this->jsValue($value);
            }
        }

        return RawJs::make('{' . implode(', ', $parts) . '}');
=======
                $parts[] = $k.': '.$value->toHtml();
            } elseif (is_array($value)) {
                $parts[] = $k.': '.$this->execute($value)->toHtml();
            } else {
                $parts[] = $k.': '.$this->jsValue($value);
            }
        }

        return RawJs::make('{'.implode(', ', $parts).'}');
>>>>>>> ac0ea089 (.)
    }

    /** Chiave JS sicura per attributo HTML: identificatore o 'key'. */
    private function jsKey(string $key): string
    {
<<<<<<< HEAD
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key) ? $key : "'" . str_replace("'", "\\'", $key) . "'";
=======
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key) ? $key : "'".str_replace("'", "\\'", $key)."'";
>>>>>>> ac0ea089 (.)
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
<<<<<<< HEAD
        return "'" . str_replace(["\\", "'"], ["\\\\", "\\'"], (string) $value) . "'";
=======

        return "'".str_replace(['\\', "'"], ['\\\\', "\\'"], (string) $value)."'";
>>>>>>> ac0ea089 (.)
    }
}
