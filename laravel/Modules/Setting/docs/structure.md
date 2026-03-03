# Modulo Setting

Data: 2025-04-23 19:09:56

## Informazioni generali

- **Namespace principale**: Modules\\Setting
Modules\\Setting\\Database\\Factories
Modules\\Setting\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_setting_fila5
Marco Sottana
- **Dipendenze**: filament/spatie-laravel-media-library-plugin * filament/spatie-laravel-settings-plugin * repositories type path url ../Xot type path url ../Tenant type path url ../UI scripts 
- **Totale file PHP**: 35
- **Totale classi/interfacce**: 17

## Struttura delle directory

```

.github
.github/workflows
.vscode
_docs
app
app/Actions
app/Actions/DB
app/Console
app/Console/Commands
app/Enums
app/Filament
app/Filament/Actions
app/Filament/Actions/Table
app/Filament/Forms
app/Filament/Forms/Components
app/Filament/Pages
app/Filament/Resources
app/Filament/Resources/DatabaseConnectionResource
app/Filament/Resources/DatabaseConnectionResource/Pages
app/Http
app/Http/Controllers
app/Http/Livewire
app/Http/Livewire/Auth
app/Http/Middleware
app/Http/Requests
app/Models
app/Models/Policies
app/Providers
app/Providers/Filament
app/View
app/View/Components
app_old
config
config_old
database
database/factories
database/migrations
database/seeders
database_old
docs
docs/phpstan
lang
lang/it
lang/lang
lang/lang/it
resources
resources/assets
resources/assets/js
resources/assets/sass
resources/img
resources/svg
resources/views
resources/views/components
resources/views/filament
resources/views/filament/pages
resources/views/layouts
resources_old
routes
tests
tests/Feature
tests/Unit
```

## Namespace e autoload

```json
    "autoload": {
        "psr-4": {
            "Modules\\Setting\\": "app/",
            "Modules\\Setting\\Database\\Factories\\": "database/factories/",
            "Modules\\Setting\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "require": {
        "filament/spatie-laravel-media-library-plugin": "*",
        "filament/spatie-laravel-settings-plugin": "*"
    },
    "require-dev": {
        
    },
    "repositories": [ {
        "type": "path",
```

## Dipendenze da altri moduli

-       1 Modules\Xot\Traits\Updater;
-       1 Modules\Xot\Providers\XotBaseServiceProvider;
-       1 Modules\Xot\Providers\XotBaseRouteServiceProvider;
-       1 Modules\Xot\Providers\Filament\XotBasePanelProvider;
-       1 Modules\Xot\Filament\Traits\NavigationActionLabelTrait;
-       1 Modules\Xot\Filament\Resources\XotBaseResource;

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

