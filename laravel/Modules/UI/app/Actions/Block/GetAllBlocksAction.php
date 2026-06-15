<?php

declare(strict_types=1);

namespace Modules\UI\Actions\Block;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Actions\File\GetClassNameByPathAction;
use Modules\Xot\Datas\ComponentFileData;

use function Safe\realpath;

use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

final class GetAllBlocksAction
{
    /**
     * @return DataCollection<int, ComponentFileData>
     */
    public function execute(): DataCollection
    {
        Assert::string($relativePath = config('modules.paths.generator.model.path'));

        $files = File::glob(base_path('Modules').'/*/'.$relativePath.'/../Filament/Blocks/*.php');

        if (! is_array($files)) {
            return ComponentFileData::collection([]);
        }

        $blocks = [];

        foreach ($files as $path) {
            if (! is_string($path)) {
                continue;
            }

            $path = realpath($path);
            $class = app(GetClassNameByPathAction::class)->execute($path);

            $name = Str::of(class_basename($class))->snake()->toString();
            if (Str::endsWith($name, '_block')) {
                $name = Str::before($name, '_block');
            }

            $module = Str::of($class)->between('Modules\\', '\Filament\\')->toString();

            $blocks[] = [
                'name' => $name,
                'class' => $class,
                'module' => $module,
                'path' => $path,
            ];
        }

        return ComponentFileData::collection($blocks);
    }
}
