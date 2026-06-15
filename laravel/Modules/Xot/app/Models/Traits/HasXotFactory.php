<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory as EloquentHasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Webmozart\Assert\Assert;

/** @template-covariant TFactory of Factory */
trait HasXotFactory
{
    /** @use EloquentHasFactory<TFactory> */
    use EloquentHasFactory {
        newFactory as parentNewFactory;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<covariant Model>
     */
    protected static function newFactory(): Factory
    {
        $action = app(GetFactoryAction::class);
        $factoryClass = $action->getFactoryClass(static::class);

        if (! class_exists($factoryClass)) {
            $action->createFactory(static::class);
            Assert::classExists($factoryClass);
        }

        $factory = $factoryClass::new();

        Assert::isInstanceOf($factory, Factory::class);

        return $factory;
    }
}
