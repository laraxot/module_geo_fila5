# Modulo Progressioni - Documentazione

## Overview

Il modulo Progressioni gestisce il sistema di progressioni economiche e di carriera del personale.

## Componenti Principali

### Risorse Filament

Il modulo include diverse risorse Filament per la gestione completa del sistema progressioni:

- **ProgressioniResource** - Gestione schede progressioni
- **SchedeResource** - Schede valutazione  
- **SchedaCriteriResource** - Criteri valutazione
- **ValutatoreResource** - Gestione valutatori
- **StabiDirigenteResource** - Stabilimenti e dirigenti
- **MailTemplateResource** - Template email progressioni (multilingua)

### MailTemplateResource

**Estende**: `Modules\Notify\Filament\Resources\MailTemplateResource`

**Caratteristiche**:
- ✅ Supporto multilingua (Italiano, Inglese)
- ✅ Filtro automatico template Progressioni
- ✅ Riutilizzo Pages da Notify
- ✅ Traduzione automatica navigation

**Documentazione**: [mailtemplate-resource-integration.md](./mailtemplate-resource-integration.md)

## Integrazione Spatie Translatable

Il modulo supporta contenuti multilingua tramite **Lara Zeus Spatie Translatable**.

### Plugin Registration

```php
// Modules/Progressioni/app/Providers/Filament/AdminPanelProvider.php

$panel->plugins([
    SpatieTranslatablePlugin::make()
        ->defaultLocales(['it', 'en']),
]);
```

### Lingue Supportate

- **Italiano** (it) - predefinita
- **Inglese** (en)

## File Traduzione

### Struttura

Le traduzioni sono in `Modules/Progressioni/lang/{locale}/`:

- `mail_template.php` - Traduzioni MailTemplateResource
- Altri file per risorse specifiche

### Convenzioni

Tutti i file traduzione seguono la **struttura espansa**:

```php
return [
    'navigation' => [
        'name' => 'Nome Risorsa',
        'label' => 'Label Navigation',
        'group' => 'Gruppo',
        'icon' => 'heroicon-o-icon',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Label',
            'placeholder' => 'Placeholder',
            'help' => 'Testo aiuto',
        ],
    ],
];
```

## Errori Risolti

### Resource Non Visibile in Sidebar

**Problema**: MailTemplateResource aggiunta ma non visibile in navigation

**Cause**:
1. ❌ Plugin `SpatieTranslatablePlugin` non registrato
2. ❌ File traduzione `mail_template.php` incompleto
3. ❌ Pages mancanti (auto-discovery falliva)
4. ❌ Cache obsoleta

**Soluzioni Applicate**:
1. ✅ Plugin registrato in `AdminPanelProvider`
2. ✅ File traduzione con struttura navigation completa
3. ✅ Override `getPages()` per usare Pages di Notify
4. ✅ Clear cache

**Documentazione**: [filament-resource-navigation.md](./filament-resource-navigation.md)

## Testing

### Test Funzionali

```bash
cd laravel

# Verifica resource registrata
php artisan tinker --execute="
use Filament\Facades\Filament;
echo in_array(
    Modules\Progressioni\Filament\Resources\MailTemplateResource::class,
    Filament::getPanel('progressioni::admin')->getResources()
) ? 'REGISTERED' : 'NOT REGISTERED';
"

# Verifica navigation properties
php artisan tinker --execute="
use Modules\Progressioni\Filament\Resources\MailTemplateResource;
echo MailTemplateResource::getNavigationLabel();
"
```

## Best Practice

### 1. Cross-Module Resource Extension

Quando si estende una Resource da altro modulo:

- ✅ Registrare plugin richiesti nel panel
- ✅ Creare file traduzione completo
- ✅ Override `getPages()` per riutilizzare Pages
- ✅ Scope query per filtrare dati rilevanti

### 2. Navigation Properties

Affidarsi **SEMPRE** al sistema traduzione automatica:

```php
// ❌ NO: Hardcoded properties
protected static ?string $navigationLabel = 'Label';

// ✅ SÌ: Traduzione automatica
// File: lang/it/resource-name.php
return ['navigation' => ['label' => 'Label']];
```

### 3. Multilingua

Per risorse che estendono `LangBaseResource`:

- ✅ Plugin registrato nel panel
- ✅ Traduzioni per tutte le lingue supportate
- ✅ Model con trait `HasTranslations` se necessario

### 4. Debug Pulito
- ❌ Evitare `dd()` e commenti `// dd(...)` dentro i model o nelle view legacy: generano blocchi durante le attach action e rompono i log.
- ✅ Usare `\Log::debug()` o activity log per investigare problemi; se il debug non serve più va rimosso.
- ✅ Dal 19/11/2025 tutte le occorrenze `// dd(...)` in `Schede` e nelle viste `admin_test` sono state eliminate.

## Collegamenti

### Documentazione Interna
- [MailTemplate Resource Integration](./mailtemplate-resource-integration.md)
- [Filament Resource Navigation](./filament-resource-navigation.md)
- [Navigation Label Trait Explained](../../Xot/docs/filament/navigation-label-trait-explained.md)
- [Spatie Translatable in Notify](../../Notify/docs/spatie-translatable-integration.md)
- [Lang Module README](../../Lang/docs/README.md)

### Documentazione Esterna
- [Lara Zeus Spatie Translatable](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [Filament Resources](https://filamentphp.com/docs/resources)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Maintainer**: Team PTVX  
**Status**: ✅ ATTIVO

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.
