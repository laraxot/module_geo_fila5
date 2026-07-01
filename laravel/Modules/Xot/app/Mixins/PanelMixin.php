<?php

declare(strict_types=1);

namespace Modules\Xot\Mixins;

<<<<<<< HEAD
use Closure;
use Filament\Panel;
=======
>>>>>>> 6cc7cd025 (.)
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as NwidartModule;
use Webmozart\Assert\Assert;

/**
<<<<<<< HEAD
 * @method string getId()
 * @method string getName()
 * @method NwidartModule getModule()
 * @method array getConfig()
 * @method array getModuleConfig()
 * @method string getNavigationLabel()
 * @method string getNavigationIcon()
 * @method int getNavigationSort()
 */
class PanelMixin
{   
    
   
   /**
     * @return Closure
     */
    public function getName() {
        return function (): string {
        
            $id=$this->getId();
            $name=Str::before($id,'::');
=======
 * @method string        getId()
 * @method string        getName()
 * @method NwidartModule getModule()
 * @method array         getConfig()
 * @method array         getModuleConfig()
 * @method string        getNavigationLabel()
 * @method string        getNavigationIcon()
 * @method int           getNavigationSort()
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

>>>>>>> 6cc7cd025 (.)
            return $name;
        };
    }

<<<<<<< HEAD
     /**
     * @return Closure
     */
    public function getModule(){
        return function (): NwidartModule {
         $name=$this->getName();
         $module=Module::find($name);
         return $module;
       };
    }

     /**
     * @return Closure
     */
    public function getConfig() {
        return function (): array {
            $name=$this->getName();
            $config=Config::array($name);
            return $config;
       };
    }

    /**
     * @return Closure
     */
    public function getModuleConfig() {
        return function (): array {
            $module=$this->getModule();
            $configFilePath=$module->getPath().'/config/config.php';
            $config = File::getRequire($configFilePath);
            Assert::isArray($config,'['.__LINE__.']['.class_basename($this).']');
            return $config;
       };
    }


    /**
     * @return Closure
     */
    public function getNavigationLabel() {
        return function (): string {
            $config=$this->getModuleConfig();
            $name=Arr::get($config,'name');
            Assert::string($name,'['.__LINE__.']['.class_basename($this).']');
            
            
=======
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

>>>>>>> 6cc7cd025 (.)
            return $name;
        };
    }

    /**
<<<<<<< HEAD
     * @return Closure
     */
    public function getNavigationIcon() {
        return function (): string {
            $config=$this->getModuleConfig();
            $icon=Arr::get($config,'icon');
            Assert::string($icon,'['.__LINE__.']['.class_basename($this).']');
            
=======
     * @return \Closure
     */
    public function getNavigationIcon()
    {
        return function (): string {
            $config = $this->getModuleConfig();
            $icon = Arr::get($config, 'icon');
            Assert::string($icon, '['.__LINE__.']['.class_basename($this).']');

>>>>>>> 6cc7cd025 (.)
            return $icon;
        };
    }

    /**
<<<<<<< HEAD
     * @return Closure
     */
    public function getNavigationSort() {
=======
     * @return \Closure
     */
    public function getNavigationSort()
    {
>>>>>>> 6cc7cd025 (.)
        return function (): int {
            return 0;
        };
    }
<<<<<<< HEAD
   
}
=======
}
>>>>>>> 6cc7cd025 (.)
