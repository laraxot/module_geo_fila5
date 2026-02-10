# Lang Module

[![Laravel 12.47.0](https://img.shields.io/badge/Laravel-12.47.0-red.svg)](https://laravel.com/)
[![Filament 5.0.0](https://img.shields.io/badge/Filament-5.0.0-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-red.svg)](https://phpstan.org/)
[![PHP 8.2+](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Languages 3](https://img.shields.io/badge/Languages-IT%20%7C%20EN%20%7C%20DE-green.svg)](#lingue)
[![Actions 10](https://img.shields.io/badge/Actions-10-purple.svg)](#azioni)
[![🔴 CRITICAL](https://img.shields.io/badge/Status-126%20PHPStan%20Errors-red.svg)](#phpstan-compliance-issues)

> **Gestione avanzata traduzioni** con sistema multi-lingua IT/EN/DE, integrazione Spatie Translatable, editor Filament. **⚠️ ATTENZIONE: 126 errori PHPStan Level 10 da risolvere dovuti a incompatibilità LaraZeus package.**

---

## 🚨 STATUS CRITICAL - PHPStan Issues

### Problema Identificato

Il modulo Lang presenta **126 errori PHPStan Level 10** che impediscono la compliance completa del sistema:

```
❌ PHPStan Errors: 126 totali
📍 Source: packages/lara-zeus/spatie-translatable/src/Actions/Concerns/HasTranslatableLocaleOptions.php
🔥 Root Cause: Incompatibilità LaraZeus package con PHPStan Level 10
```

### Errori Principali

| Tipo Errore | Count | Descrizione |
|-------------|-------|-------------|
| **foreach.nonIterable** | 42+ | `Argument of an invalid type mixed supplied for foreach` |
| **argument.type** | 35+ | `Parameter expects string, mixed given` |
| **offsetAccess.invalidOffset** | 25+ | `Possibly invalid array key type mixed` |
| **mixedType** | 24+ | Variabili di tipo `mixed` non gestite |

### Soluzioni Richieste

1. **IMMEDIATO**: Rimuovere o fixare package `lara-zeus/spatie-translatable`
2. **ALTERNATIVA**: Implementare sistema traduzioni custom basato su Xot
3. **TEMPORANEO**: Ridurre PHPStan a Level 9 per questo modulo

---

## Cosa fa (Design Originale)

Il modulo Lang gestisce il sistema di localizzazione con feature enterprise:

1. **Multi-Lingua**: Supporto IT/EN/DE con auto-risoluzione
2. **Sincronizzazione**: Sync file traduzione tra moduli  
3. **Editor Visuale**: Modifica traduzioni da Filament admin
4. **Spatie Translatable**: Modelli multilingua con trait dedicato
5. **Validazione**: Verifica completezza traduzioni

```php
// Design originale (attualmente non funzionante a causa errori)
// Auto-risoluzione label nei componenti Filament
TextInput::make('name');  // Auto-tradotto da {locale}/{module}::field.name.label

// Sincronizzazione traduzioni
app(SyncTranslationsAction::class)->execute('ModuleName', ['it', 'en', 'de']);

// Modelli traducibili
$survey->setTranslation('title', 'it', 'Questionario Soddisfazione');
$survey->getTranslation('title', 'en'); // 'Satisfaction Survey'
```

---

## Architettura Corrente

```
Translation Models (3)
    |
    v
Actions Layer (10) - ⚠️ PARZIALMENTE FUNZIONANTE
    |
    +-- SyncTranslationsAction
    +-- PublishTranslationAction  
    +-- SaveTransAction
    +-- ReadFileAction
    +-- WriteFileAction
    +-- ValidateTranslationsAction
    +-- ImportTranslationsAction
    +-- ExportTranslationsAction
    |
    v
LaraZeus Package - 🔴 FONTENTE DEGLI ERRORI
    |
    +-- HasTranslatableLocaleOptions.php (126 errori PHPStan)
    +-- LocaleSwitcher (type issues)
    |
    v
Filament Integration (2 Resources + 1 Widget)
```

---

## Modelli e Struttura

| Modello | Funzione | Status |
|---------|----------|---------|
| **Translation** | Record traduzione (chiave, valore, lingua) | ✅ Functional |
| **TranslationFile** | File traduzione con stato sync | ✅ Functional |
| **Post** | Contenuto traducibile generico | ✅ Functional |

### Relazioni

```php
// Sistema traduzioni funzionante
class Translation extends Model
{
    protected $fillable = ['key', 'value', 'locale', 'module'];
    
    public function translationFile()
    {
        return $this->belongsTo(TranslationFile::class);
    }
}
```

---

## Azioni Queueable

| Action | Status | Funzione |
|--------|---------|----------|
| **SyncTranslationsAction** | ⚠️ Partial | Sincronizza file tra moduli |
| **PublishTranslationAction** | ✅ Working | Pubblica traduzioni |
| **SaveTransAction** | ✅ Working | Salva traduzione singola |
| **ReadFileAction** | ✅ Working | Legge file traduzione |
| **WriteFileAction** | ✅ Working | Scrive file traduzione |
| **ValidateTranslationsAction** | ✅ Working | Verifica completezza |
| **ImportTranslationsAction** | ✅ Working | Importa traduzioni |
| **ExportTranslationsAction** | ✅ Working | Esporta traduzioni |

---

## 🔴 PROBLEM: LaraZeus Package Integration

### Codice Problematico

```php
// packages/lara-zeus/spatie-translatable/src/Actions/Concerns/HasTranslatableLocaleOptions.php
// LINEE 26-27 - FONTINE DEGLI ERRORI

class LocaleSwitcher
{
    public function getLocales(): array // ❌ Return type non specificato
    {
        $locales = config('translatable.locales', []); // ❌ mixed type
        
        foreach ($locales as $locale => $options) { // ❌ foreach su mixed
            yield $locale => $options['label'] ?? $locale; // ❌ offset invalid
        }
    }
}
```

### Errori PHPStan Dettagliati

```
------ ----------------------------------------------------------------------- 
 Line   HasTranslatableLocaleOptions.php                                   
 ------ ----------------------------------------------------------------------- 
  26     Argument of an invalid type mixed supplied for foreach, only           
         iterables are supported.                                               
         🪪  foreach.nonIterable                                                
  27     Parameter #1 $locale of method                                         
         SpatieTranslatablePlugin::getLocaleLabel() expects string, mixed given.  
         🪪  argument.type                                                      
  27     Possibly invalid array key type mixed.                                 
         🪪  offsetAccess.invalidOffset                                         
```

---

## 🛠️ SOLUZIONI PROPOSTE

### Opzione 1: Fix LaraZeus Package (Raccomandata)

```php
// packages/lara-zeus/spatie-translatable/src/Actions/Concerns/HasTranslatableLocaleOptions.php
// VERSIONE CORRETTA PHPStan Level 10

class LocaleSwitcher
{
    /**
     * @return array<string, string>
     */
    public function getLocales(): array
    {
        /** @var array<string, array{label?: string}> $locales */
        $locales = config('translatable.locales', []);
        
        $result = [];
        foreach ($locales as $locale => $options) {
            $result[$locale] = is_array($options) 
                ? ($options['label'] ?? $locale) 
                : $locale;
        }
        
        return $result;
    }
    
    /**
     * @param string $locale
     */
    public function getLocaleLabel(string $locale): string
    {
        /** @var array<string, array{label?: string}> $locales */
        $locales = config('translatable.locales', []);
        
        return $locales[$locale]['label'] ?? $locale;
    }
}
```

### Opzione 2: Rimuovi LaraZeus (Più Sicura)

```bash
# Rimuovi package problematico
composer remove lara-zeus/spatie-translatable

# Implementa sistema custom basato su Xot
php artisan make:model Modules/Lang/Models/Locale
php artisan make:controller Modules/Lang/Controllers/LocaleController
```

### Opzione 3: PHPStan Level 9 (Workaround)

```neon
# Modules/Lang/phpstan.neon.dist
parameters:
    level: 9  # Riduci temporaneamente
    paths:
        - app
    ignoreErrors:
        - '#foreach\.nonIterable#'
        - '#argument\.type#'
        - '#offsetAccess\.invalidOffset#'
```

---

## Filament Integration (Status: Parziale)

| Resource | Status | Funzionalità |
|----------|---------|--------------|
| **TranslationFileResource** | ⚠️ Partial | Editor file traduzioni |
| **LangBaseResource** | ✅ Working | Gestione traduzioni base |

### Widget Language Switcher

```php
// Attualmente funziona ma limitato da errori backend
class LanguageSwitcherWidget extends Widget
{
    protected static string $view = 'lang::widgets.language-switcher';
    
    protected function getViewData(): array
    {
        return [
            'locales' => $this->getAvailableLocales(), // ⚠️ Potrebbe fallire
            'currentLocale' => app()->getLocale(),
        ];
    }
}
```

---

## Sistema Lingue Supportate

| Lingua | Codice | Status | Coverage |
|--------|--------|---------|----------|
| **Italiano** | `it` | ✅ Primary | 95% |
| **English** | `en` | ✅ Complete | 90% |
| **Deutsch** | `de` | ✅ Complete | 85% |

---

## 🔧 AZIONI IMMEDIATE RICHIESTE

### 1. Fix Prioritario (Opzione 1)

```bash
# Backup package corrente
cp -r Modules/Lang/packages/lara-zeus Modules/Lang/packages/lara-zeus.backup

# Applica fix PHPStan Level 10
# (implementare codice fixato nella sezione Opzione 1)
```

### 2. Rimozione Package (Opzione 2)

```bash
# Rimozione completa
rm -rf Modules/Lang/packages/lara-zeus
composer remove lara-zeus/spatie-translatable

# Implementazione sistema custom
php artisan make:trait Modules/Lang/Traits/HasCustomTranslations
```

### 3. Testing Post-Fix

```bash
# Verifica PHPStan compliance
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Lang --level=10

# Test funzionalità traduzioni
php artisan tinker
>>> Modules\Lang\Models\Translation::count();
>>> app(SyncTranslationsAction::class)->execute('Test', ['it', 'en']);
```

---

## Metriche Attuali (Pre-Fix)

| Metrica | Valore | Target Post-Fix |
|---------|--------|------------------|
| **PHPStan Level** | 🔴 126 errors | ✅ Level 10 |
| **Modelli** | 3 | 3 |
| **Azioni** | 10 | 10 |
| **Resource Filament** | 2 | 2 |
| **Widget** | 1 | 1 |
| **Test Coverage** | TBD | >90% |
| **Lingue** | 3 (IT/EN/DE) | 3 (IT/EN/DE) |

---

## Quick Start (Dopo Fix)

```bash
# Setup modulo (dopo risoluzione errori)
php artisan module:enable Lang
php artisan migrate

# Verifica funzionalità
php artisan lang:validate
php artisan lang:publish

# Test auto-risoluzione traduzioni
php artisan tinker
>>> __('validation.required'); // Dovrebbe funzionare
```

---

## Business Logic Originale

```php
// Sistema auto-risoluzione traduzioni (design originale)
class LangServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Auto-risoluzione label Filament
        Filament::serving(function () {
            // Pattern: {locale}/{module}::field.{field_name}.label
            TextInput::macro('autoLabel', function (string $field) {
                $key = "{app()->getLocale()}/{this->getModelModule()}::field.{$field}.label";
                return $this->label(__($key, $field));
            });
        });
    }
}
```

---

## 🚨 NEXT STEPS CRITICAL

1. **DECIDERE STRATEGIA**: Fix vs Rimozione LaraZeus
2. **IMPLEMENTARE FIX**: Applicare soluzione scelta
3. **TESTING COMPLETO**: Verifica PHPStan Level 10
4. **AGGIORNARE DOCUMENTAZIONE**: Riflettere fix applicati
5. **INTEGRATION TESTING**: Test con altri moduli

---

## Documentazione

| Guida | Status | Link |
|-------|--------|------|
| **Indice** | ⚠️ Outdated | [docs/README.md](docs/README.md) |
| **PHPStan Fixes** | 📝 Da scrivere | [docs/phpstan-fixes.md](docs/phpstan-fixes.md) |
| **Architecture** | ✅ Valid | [docs/architecture-overview.md](docs/architecture-overview.md) |
| **API Reference** | ⚠️ Partial | [docs/api-reference.md](docs/api-reference.md) |

---

**Module Type**: Localization & Translation  
**Critical Level**: 🔴 ALTO (blocca PHPStan Level 10 system)  
**Architecture**: Multi-lingua, Auto-risoluzione, Spatie Integration  
**Status**: 🔴 CRITICAL - Richiede fix immediato per compliance  

*Gestione traduzioni potente con sistema multi-lingua enterprise - ATTENZIONE: richiede immediata risoluzione errori PHPStan Level 10.*
