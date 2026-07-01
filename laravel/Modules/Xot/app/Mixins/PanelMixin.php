<?php

declare(strict_types=1);

namespace Modules\Xot\Mixins;

<<<<<<< HEAD
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
=======
use Closure;
use Filament\Panel;
use Modules\Xot\Support\PanelModuleResolver;
>>>>>>> b8f35c374 (Fix merge conflicts and clean up documentation)
use Nwidart\Modules\Module as NwidartModule;
use Webmozart\Assert\Assert;

/**
<<<<<<< HEAD
 * @method string               getId()
 * @method string               getName()
 * @method NwidartModule        getModule()
 * @method array<string, mixed> getConfig()
 * @method array<string, mixed> getModuleConfig()
 * @method string               getNavigationLabel()
 * @method string               getNavigationIcon()
 * @method int                  getNavigationSort()
 */
class PanelMixin
{
    /**
     * @return \Closure
     */
    public function getName()
    {
        return function (): string {
            $id = $this->getId();
            $name = Str::before($id, '::');

            return $name;
        };
    }

    /**
     * @return \Closure
     */
    public function getModule()
    {
        return function (): NwidartModule {
            $name = $this->getName();
            $module = Module::find($name);

            return $module;
        };
    }

    /**
     * @return \Closure
     */
    public function getConfig()
    {
        return function (): array {
            $name = $this->getName();
            $config = Config::array($name);

            return $config;
        };
    }

    /**
     * @return \Closure
     */
    public function getModuleConfig()
    {
        return function (): array {
            $module = $this->getModule();
            $configFilePath = $module->getPath().'/config/config.php';
            $config = File::getRequire($configFilePath);
            Assert::isArray($config, '['.__LINE__.']['.class_basename($this).']');

            return $config;
        };
    }

    /**
     * @return \Closure
     */
    public function getNavigationLabel()
    {
        return function (): string {
            $config = $this->getModuleConfig();
            $name = Arr::get($config, 'name');
            Assert::string($name, '['.__LINE__.']['.class_basename($this).']');

            return $name;
=======
 * Macro Filament Panel → modulo nwidart (delega a PanelModuleResolver).
 */
class PanelMixin
{
    public function getName(): Closure
    {
        return function (): string {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::moduleName($this);
        };
    }

    public function getModule(): Closure
    {
        return function (): NwidartModule {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::module($this);
>>>>>>> b8f35c374 (Fix merge conflicts and clean up documentation)
        };
    }

    /**
<<<<<<< HEAD
     * @return \Closure
     */
    public function getNavigationIcon()
    {
        return function (): string {
            $config = $this->getModuleConfig();
            $icon = Arr::get($config, 'icon');
            Assert::string($icon, '['.__LINE__.']['.class_basename($this).']');

            return $icon;
=======
     * @return Closure(): array<string, mixed>
     */
    public function getConfig(): Closure
    {
        return function (): array {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::config($this);
>>>>>>> b8f35c374 (Fix merge conflicts and clean up documentation)
        };
    }

    /**
<<<<<<< HEAD
     * @return \Closure
     */
    public function getNavigationSort()
=======
     * @return Closure(): array<string, mixed>
     */
    public function getModuleConfig(): Closure
    {
        return function (): array {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::moduleConfig($this);
        };
    }

    public function getNavigationLabel(): Closure
    {
        return function (): string {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::navigationLabel($this);
        };
    }

    public function getNavigationIcon(): Closure
    {
        return function (): string {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::navigationIcon($this);
        };
    }

    public function getNavigationSort(): Closure
>>>>>>> b8f35c374 (Fix merge conflicts and clean up documentation)
    {
        return function (): int {
            Assert::isInstanceOf($this, Panel::class);

            return PanelModuleResolver::navigationSort($this);
        };
    }
}
