---
name: translation-check
description: Check and fix hardcoded translations in Filament components. Verifies that no label(), placeholder(), helperText(), or tooltip() have hardcoded strings. Creates missing translation files.
---

# Translation Check - Automatic Translation System

Verify and fix the translation system across Filament components.

## When to Use

- When creating or modifying Filament resources
- When the user reports missing translations
- When auditing a module for compliance
- When adding new form fields or table columns

## ABSOLUTE RULE

**NEVER use hardcoded strings in Filament components.**

The LangServiceProvider handles all translations automatically using the pattern:
`{module}::resource.fields.{field_name}.{type}`

Where `{type}` can be: `label`, `placeholder`, `helper_text`, `tooltip`

## Check for Violations

```bash
cd laravel
# Find all hardcoded labels in Filament components
grep -rn "->label('[^']*')" Modules/{Module}/app/Filament/
grep -rn '->label("[^"]*")' Modules/{Module}/app/Filament/
grep -rn "->placeholder('[^']*')" Modules/{Module}/app/Filament/
grep -rn "->helperText('[^']*')" Modules/{Module}/app/Filament/
grep -rn "->tooltip('[^']*')" Modules/{Module}/app/Filament/
grep -rn "->modalHeading('[^']*')" Modules/{Module}/app/Filament/
grep -rn "->navigationLabel('[^']*')" Modules/{Module}/app/Filament/
```

## Fix Pattern

```php
// WRONG
TextInput::make('nome_completo')
    ->label('Nome Completo')
    ->placeholder('Inserisci il nome completo')
    ->helperText('Il nome come appare sui documenti')

// CORRECT - remove all hardcoded strings
TextInput::make('nome_completo')
```

The translation file `lang/it/{resource_name}.php` handles it:

```php
return [
    'fields' => [
        'nome_completo' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Inserisci il nome completo',
            'helper_text' => 'Il nome come appare sui documenti',
        ],
    ],
];
```

## Translation File Template

Location: `Modules/{Module}/lang/it/{resource_name}.php`

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => '{ResourceName}',
        'plural' => '{ResourceNamePlural}',
        'group' => [
            'name' => '{GroupName}',
        ],
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Testo segnaposto',
            'helper_text' => 'Testo di aiuto',
            'tooltip' => 'Tooltip',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea',
        ],
        'edit' => [
            'label' => 'Modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
    ],
];
```

## After Fixing

1. Remove all `->label()`, `->placeholder()`, etc. from Filament components
2. Create/update translation file in `lang/it/`
3. Run PHPStan to verify no type errors
4. Test the UI to verify translations appear correctly
