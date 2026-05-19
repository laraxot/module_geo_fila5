<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

trait HasXotWizard
{
    /**
     * @return array<string, Step>
     */
    public static function getSteps(): array
    {
        return [];
    }

    protected static function getStepByName(string $name): Step
    {
        $methodName = Str::of($name)
            ->snake()
            ->studly()
            ->prepend('get')
            ->append('Schema')
            ->toString();

        if (! method_exists(static::class, $methodName)) {
            return Step::make($name)
                ->key($name)
                ->schema([]);
        }

        $schema = static::$methodName();
        /** @var array<Htmlable|string> $schemaComponents */
        $schemaComponents = is_array($schema) ? array_values($schema) : [];

        return Step::make($name)
            ->key($name)
            ->schema($schemaComponents);
    }
}
