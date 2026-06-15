<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Facades\Module;

use function Safe\define;
use function Safe\glob;
use function Safe\preg_match;

use Webmozart\Assert\Assert;

if (! function_exists('isRunningTestBench')) {
    function isRunningTestBench(): bool
    {
        $path = app(FixPathAction::class)->execute('\vendor\orchestra\testbench-core\laravel');
        $base = app(FixPathAction::class)->execute(base_path());

        return Str::endsWith($base, $path);
    }
}

if (! function_exists('snake_case')) {
    function snake_case(string $str): string
    {
        return Str::snake($str);
    }
}

if (! function_exists('str_slug')) {
    function str_slug(string $str): string
    {
        return Str::slug($str);
    }
}

if (! function_exists('str_singular')) {
    function str_singular(string $str): string
    {
        return Str::singular($str);
    }
}

if (! function_exists('starts_with')) {
    function starts_with(string $str, string $str1): bool
    {
        return Str::startsWith($str, $str1);
    }
}

if (! function_exists('ends_with')) {
    function ends_with(string $str, string $str1): bool
    {
        return Str::endsWith($str, $str1);
    }
}

if (! function_exists('str_contains')) {
    function str_contains(string $str, string $str1): bool
    {
        return Str::contains($str, $str1);
    }
}

if (! function_exists('hex2rgba')) {
    function hex2rgba(string $color, float $opacity = -1.0): string
    {
        $default = 'rgb(0,0,0)';
        if (empty($color)) {
            return $default;
        }

        if ('#' === $color[0]) {
            $color = mb_substr($color, 1);
        }
        if (6 === mb_strlen($color)) {
            $hex = [$color[0].$color[1], $color[2].$color[3], $color[4].$color[5]];
        } elseif (3 === mb_strlen($color)) {
            $hex = [$color[0].$color[0], $color[1].$color[1], $color[2].$color[2]];
        } else {
            return $default;
        }

        $rgb = array_map('hexdec', $hex);
        if (-1.0 !== $opacity) {
            if ($opacity < 0 || $opacity > 1) {
                $opacity = 1.0;
            }
            $output = 'rgba('.implode(',', $rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(',', $rgb).')';
        }

        return $output;
    }
}

if (! function_exists('dddx')) {
    function dddx(mixed $params): void
    {
        $tmp = debug_backtrace();
        $start = defined('LARAVEL_START') ? (float) LARAVEL_START : microtime(true);
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', $start);
        }
        $data = [
            '_' => $params,
            'line' => $tmp[0]['line'] ?? 'line-unknows',
            'file' => app(FixPathAction::class)->execute($tmp[0]['file'] ?? 'file-unknown'),
            'time' => microtime(true) - $start,
            'memory_taken' => round(memory_get_peak_usage() / (1024 * 1024), 2).' MB',
        ];

        if (File::exists($data['file']) && Str::startsWith($data['file'], app(FixPathAction::class)->execute(storage_path('framework/views')))) {
            $content = File::get($data['file']);
            $data['view_file'] = app(FixPathAction::class)->execute(Str::between($content, '/**PATH ', ' ENDPATH**/'));
        }

        dd($data);
    }
}

if (! function_exists('getFilename')) {
    /** @param array<string, mixed> $params */
    function getFilename(array $params): string
    {
        $tmp = debug_backtrace();
        $class = class_basename($tmp[1]['class'] ?? 'class-unknown');
        $func = $tmp[1]['function'] ?? 'function-unknown';
        $params_list = collect($params)->except(['_token', '_method'])->implode('_');

        return Str::slug(str_replace('Controller', '', $class).'_'.str_replace('do_', '', $func).'_'.$params_list);
    }
}

if (! function_exists('req_uri')) {
    function req_uri(): mixed
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }
}

if (! function_exists('in_admin')) {
    /** @param array<string, mixed> $params */
    function in_admin(array $params = []): bool
    {
        return inAdmin($params);
    }
}

if (! function_exists('inAdmin')) {
    /** @param array<string, mixed> $params */
    function inAdmin(array $params = []): bool
    {
        if (isset($params['in_admin'])) {
            return (bool) $params['in_admin'];
        }

        if ('admin' === Request::segment(2)) {
            return true;
        }

        $segments = Request::segments();

        return (is_countable($segments) ? count($segments) : 0) > 0 && 'livewire' === $segments[0] && true === session('in_admin');
    }
}

if (! function_exists('getRouteParameters')) {
    /**
     * Parametri della route corrente (es. anno, stabi, repar nei contesti admin progressioni).
     *
     * @return array<string, mixed>
     */
    function getRouteParameters(): array
    {
        if (app()->runningInConsole()) {
            return [];
        }

        $route = Route::current();
        if ($route === null) {
            return [];
        }

        $params = $route->parameters();
        if (! is_array($params)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}

if (! function_exists('isHome')) {
    function isHome(): bool
    {
        if (URL::current() === url('')) {
            return true;
        }

        return Route::is('home');
    }
}

if (! function_exists('isAdminHome')) {
    function isAdminHome(): bool
    {
        return URL::current() === route('admin.index');
    }
}

if (! function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return Route::is('*admin*');
    }
}

if (! function_exists('fullTextWildcards')) {
    function fullTextWildcards(string $term): string
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
        $words = explode(' ', $term);
        foreach ($words as $key => $word) {
            if (mb_strlen($word) >= 3) {
                $words[$key] = '+'.$word.'*';
            }
        }

        return implode(' ', $words);
    }
}

if (! function_exists('isContainer')) {
    function isContainer(): bool
    {
        [$containers, $items] = params2ContainerItem();

        return count($containers) > count($items);
    }
}

if (! function_exists('isItem')) {
    function isItem(): bool
    {
        [$containers, $items] = params2ContainerItem();

        return count($containers) === count($items);
    }
}

if (! function_exists('params2ContainerItem')) {
    /**
     * @param array<string, mixed>|null $params
     *
     * @return array{0: array<string, mixed>, 1: array<string, mixed>}
     */
    function params2ContainerItem(?array $params = null): array
    {
        if (null === $params) {
            $params = [];
            $route_current = Route::current();
            if ($route_current instanceof Illuminate\Routing\Route) {
                $params = $route_current->parameters();
            }
        }

        $container = [];
        $item = [];
        foreach ($params as $k => $v) {
            $pattern = '/(container|item)(\d+)/';
            preg_match($pattern, $k, $matches);
            if (! empty($matches) && isset($matches[1], $matches[2]) && is_string($matches[1]) && is_string($matches[2])) {
                $sk = $matches[1];
                $sv = $matches[2];
                ${$sk}[$sv] = $v;
            }
        }

        return [$container, $item];
    }
}

if (! function_exists('getModelFields')) {
    /** @return array<int, string> */
    function getModelFields(Model $model): array
    {
        return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    }
}

if (! function_exists('getModelByName')) {
    function getModelByName(string $name): Model
    {
        $registered = config('morph_map.'.$name);
        if (is_string($registered) && class_exists($registered)) {
            Assert::isInstanceOf($res = app($registered), Model::class);

            return $res;
        }

        $files_path = base_path('Modules').'/*/Models/*.php';
        Assert::isArray($files = glob($files_path));
        $path = Arr::first($files, function (mixed $file) use ($name): bool {
            if (! is_string($file)) {
                return false;
            }

            $info = pathinfo($file);

            return Str::snake($info['filename'] ?? '') === $name;
        });

        if (! is_string($path)) {
            throw new Exception('['.$name.'] not in morph_map');
        }

        $path = app(FixPathAction::class)->execute($path);
        $info = pathinfo($path);
        $module_name = Str::between($path, 'Modules'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'Models');
        $class = 'Modules\\'.$module_name.'\Models\\'.$info['filename'];
        Assert::isInstanceOf($res = app($class), Model::class);

        return $res;
    }
}

if (! function_exists('getModuleFromModel')) {
    function getModuleFromModel(object $model): Nwidart\Modules\Module
    {
        $class = $model::class;
        $module_name = Str::before(Str::after($class, 'Modules\\'), '\\Models\\');
        $moduleRepository = app(RepositoryInterface::class);
        Assert::isInstanceOf($res = $moduleRepository->find($module_name), Nwidart\Modules\Module::class);

        return $res;
    }
}

if (! function_exists('getModuleNameFromModel')) {
    function getModuleNameFromModel(object $model): string
    {
        $class = $model::class;

        return Str::before(Str::after($class, 'Modules\\'), '\\Models\\');
    }
}

if (! function_exists('getModuleNameFromModelName')) {
    function getModuleNameFromModelName(string $model_name): string
    {
        $model_class = config('morph_map.'.$model_name);
        if (! is_string($model_class)) {
            throw new Exception('['.__LINE__.']');
        }

        Assert::isInstanceOf($model = app($model_class), Model::class);

        return getModuleNameFromModel($model);
    }
}

if (! function_exists('getAllModules')) {
    /** @return array<string, mixed> */
    function getAllModules(): array
    {
        $modules = Module::all();
        $normalized = [];

        foreach ($modules as $name => $module) {
            $normalized[(string) $name] = $module;
        }

        return $normalized;
    }
}

if (! function_exists('xotModel')) {
    function xotModel(string $name): Model
    {
        $model_class = config('morph_map.'.$name);
        if (! is_string($model_class)) {
            throw new Exception('['.__LINE__.']');
        }

        Assert::isInstanceOf($res = app($model_class), Model::class);

        return $res;
    }
}

if (! function_exists('profile')) {
    function profile(): Model|ProfileContract
    {
        return XotData::make()->getProfileModel();
    }
}

if (! function_exists('authId')) {
    function authId(): ?string
    {
        try {
            $id = Filament::auth()->id() ?? auth()->guard()->id();

            return null === $id ? null : (string) $id;
        } catch (Throwable $e) {
            return null;
        }
    }
}

if (! function_exists('trans_string')) {
    /** @param array<string, mixed> $replace */
    function trans_string(string $key, array $replace = [], ?string $locale = null): string
    {
        $safeReplace = [];
        foreach ($replace as $k => $v) {
            if (! is_string($k)) {
                continue;
            }

            $safeReplace[$k] = (is_scalar($v) || null === $v) ? $v : (string) $v;
        }

        $result = __($key, $safeReplace, $locale);

        return is_string($result) ? $result : $key;
    }
}

if (! function_exists('isJson')) {
    function isJson(string $string): bool
    {
        return json_validate($string);
    }
}

/*
|--------------------------------------------------------------------------
| Pest Laravel Helper Stubs
|--------------------------------------------------------------------------
|
| Stubs for Pest global testing functions.
| These eliminate 'function not found' errors from PHPStan.
|
*/

if (! function_exists('actingAs')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function actingAs(Authenticatable|int|string|null $user = null, ?string $driver = null): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('get')) {
    /**
     * @param array<string, mixed> $options
     *
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function get(string $uri = '', array $options = []): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('post')) {
    /**
     * @param array<string, mixed> $options
     *
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function post(string $uri, mixed $data = [], array $options = []): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('put')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function put(string $uri, mixed $data = []): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('patch')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function patch(string $uri, mixed $data = []): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('delete')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function delete(string $uri): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('head')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function head(string $uri): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('options')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function options(string $uri): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('followingRedirects')) {
    /**
     * @return Illuminate\Testing\TestResponse<Illuminate\Http\Response>
     */
    function followingRedirects(int $number = 5): Illuminate\Testing\TestResponse
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('test')) {
    /** @param  string  $title  @param  \Closure  $callback  @return void */
    function test(string $title, Closure $callback): void
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}

if (! function_exists('describe')) {
    /** @param  string  $title  @param  \Closure  $callback  @return void */
    function describe(string $title, Closure $callback): void
    {
        throw new RuntimeException('Stub: This function is meant for static analysis only.');
    }
}
