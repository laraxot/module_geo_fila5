# 📚 Translation Standards - Laraxot

> **Standard per traduzioni con Spatie Translatable + Filament**  
> **Aggiornato**: 2025-03-25  
> **Versione**: 2.0

---

## 🎯 Panoramica

Questo documento definisce gli standard per le traduzioni nel progetto Laraxot, combinando:
- **Spatie Laravel Translatable** v6
- **Zeus Spatie Translatable** per Filament
- **mcamara/laravel-localization** per routing multilingua
- **Pattern Laraxot** per struttura file

---

## 📋 Struttura File di Traduzione

### Path Standard

```
Modules/{ModuleName}/
├── lang/
│   ├── it/
│   │   ├── {resource}.php        # Traduzioni resource
│   │   ├── navigation.php         # Traduzioni navigazione
│   │   └── fields.php             # Traduzioni campi comuni
│   ├── en/
│   └── de/
```

### Naming Convention

- **lowercase**: `navigation.php`, `fields.php`
- **kebab-case**: `user-resource.php`, `project-activity.php`
- **snake_case**: `xot_base.php`, `lang_service.php`

---

## 🏗️ Struttura File di Traduzione

### Template Completo

```php
<?php

declare(strict_types=1);

return [
    // Navigation (OBBLIGATORIO per Filament)
    'navigation' => [
        'label' => 'Progetto',
        'plural_label' => 'Progetti',
        'group' => 'Gestione Progetti',
        'icon' => 'heroicon-o-folder',
        'sort' => 10,
    ],
    
    // Label principali
    'label' => 'Progetto',
    'plural_label' => 'Progetti',
    
    // Campi (OBBLIGATORIO struttura completa)
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome progetto',
            'helper_text' => 'Il nome del progetto',
            'description' => 'Nome descrittivo del progetto',
            'tooltip' => 'Clicca per modificare',
        ],
        'codice' => [
            'label' => 'Codice',
            'placeholder' => 'Es. PROG-2025-001',
            'helper_text' => 'Codice univoco del progetto',
            'description' => '',
            'tooltip' => 'Formato: XXX-YYYY-NNN',
        ],
    ],
    
    // Azioni (OBBLIGATORIO per Filament)
    'actions' => [
        'create' => [
            'label' => 'Crea Progetto',
            'success' => 'Progetto creato con successo',
            'failure' => 'Errore nella creazione del progetto',
        ],
        'edit' => [
            'label' => 'Modifica Progetto',
            'success' => 'Progetto aggiornato con successo',
            'failure' => 'Errore nell\'aggiornamento del progetto',
        ],
        'delete' => [
            'label' => 'Elimina Progetto',
            'success' => 'Progetto eliminato con successo',
            'failure' => 'Errore nell\'eliminazione del progetto',
            'confirm' => 'Sei sicuro di voler eliminare questo progetto?',
        ],
        'view' => [
            'label' => 'Visualizza Progetto',
        ],
    ],
    
    // Messaggi (OPZIONALE ma consigliato)
    'messages' => [
        'no_records' => 'Nessun progetto trovato',
        'loading' => 'Caricamento in corso...',
    ],
];
```

---

## 🔍 Prototipo Chiavi Traduzione

### Formato: `<namespace>::<contesto>.<collezione>.<chiave>.<tipo>`

> Sinonimi accettati: `<contesto>` = `<attore>`, `<chiave>` = `<item>`, `<tipo>` = `<type>`.

### ⚠️ REGOLA INVALICABILE: ESATTAMENTE 5 ELEMENTI

`<namespace>` + 4 segmenti separati da `.` dopo `::`. **Né di più, né di meno.**

| Chiave | Elementi | Verdetto |
|---|---|---|
| `user::auth.register.submit` | 4 | ❌ manca `<tipo>` |
| `user::auth.register.submit.text` | 5 | ✅ |
| `user::auth.register.page.kicker.label` | 6 | ❌ un livello in più |
| `user::widgets.edit_user.actions.save.label` | 6 | ❌ idem |

**Tentazione tipica → errore:** aggiungere un livello intermedio (`.page.`, `.modal.`, `.sections.`) "per chiarezza". Non farlo: riorganizza dentro 4 segmenti.

### Esempi corretti (5 elementi)

```
Modules::Xot::navigation.label.text
Modules::Xot::fields.nome.label
Modules::Xot::actions.create.success
Modules::User::user.fields.email.label
user::auth.register.submit.text
user::auth.login.email.placeholder
xot::actions.delete.confirm.heading
```

> Memoria operativa: [translation-key-prototype-5-elements](../memories/translation-key-prototype-5-elements.md) — pattern di violazione + quality-gate grep.

### Namespace per Modulo

| Modulo | Namespace |
|--------|-----------|
| Xot | `Modules::Xot::` |
| User | `Modules::User::` |
| Performance | `Modules::Performance::` |
| Ptv | `Modules::Ptv::` |

---

## 📝 Regole per Campi (Fields)

### OBBLIGATORIO per ogni campo

```php
'fields' => [
    '{field_name}' => [
        'label' => 'Label leggibile',           // OBBLIGATORIO
        'placeholder' => 'Placeholder testuale', // OBBLIGATORIO
        'helper_text' => 'Testo di aiuto',       // OBBLIGATORIO (può essere vuoto)
        'description' => 'Descrizione campo',    // OBBLIGATORIO (può essere vuoto)
        'tooltip' => 'Tooltip info',             // OBBLIGATORIO (può essere vuoto)
    ],
],
```

### Esempi Corretti

```php
// ✅ CORRETTO
'fields' => [
    'matr' => [
        'label' => 'Matricola',
        'placeholder' => 'Inserisci numero matricola',
        'helper_text' => 'Codice identificativo univoco',
        'description' => 'Numero di matricola del dipendente',
        'tooltip' => 'Formato: 6 cifre',
    ],
    'email' => [
        'label' => 'Email Aziendale',
        'placeholder' => 'nome.cognome@azienda.it',
        'helper_text' => 'Indirizzo email istituzionale',
        'description' => 'Email per comunicazioni ufficiali',
        'tooltip' => 'Verrà inviata una conferma',
    ],
],

// ❌ SBAGLIATO - Manicano chiavi obbligatorie
'fields' => [
    'matr' => [
        'label' => 'Matricola',
        // MANCA: placeholder, helper_text, description, tooltip
    ],
],

// ❌ SBAGLIATO - Label non descrittive
'fields' => [
    'matr' => [
        'label' => 'matr',  // ❌ Deve essere "Matricola"
    ],
],
```

---

## 🧭 Regole per Navigation

### OBBLIGATORIO struttura completa

```php
'navigation' => [
    'label' => 'Progetto',              // Singolare
    'plural_label' => 'Progetti',       // Plurale
    'group' => 'Gestione Progetti',     // Gruppo di appartenenza
    'icon' => 'heroicon-o-folder',      // Icona Heroicons
    'sort' => 10,                       // Ordinamento (numerico)
],
```

### Esempi Corretti

```php
// ✅ CORRETTO
'navigation' => [
    'label' => 'Dipendente',
    'plural_label' => 'Dipendenti',
    'group' => 'Risorse Umane',
    'icon' => 'heroicon-o-user-group',
    'sort' => 20,
],

// ❌ SBAGLIATO - Manicano chiavi
'navigation' => [
    'label' => 'Dipendente',
    // MANCA: plural_label, group, icon, sort
],
```

---

## 🎯 Regole per Actions

### OBBLIGATORIO per CRUD Filament

```php
'actions' => [
    'create' => [
        'label' => 'Crea {Resource}',
        'success' => '{Resource} creato con successo',
        'failure' => 'Errore nella creazione di {Resource}',
    ],
    'edit' => [
        'label' => 'Modifica {Resource}',
        'success' => '{Resource} aggiornato con successo',
        'failure' => 'Errore nell\'aggiornamento di {Resource}',
    ],
    'delete' => [
        'label' => 'Elimina {Resource}',
        'success' => '{Resource} eliminato con successo',
        'failure' => 'Errore nell\'eliminazione di {Resource}',
        'confirm' => 'Sei sicuro di voler eliminare questo {Resource}?',
    ],
    'view' => [
        'label' => 'Visualizza {Resource}',
    ],
    'bulk_delete' => [
        'label' => 'Elimina Selezionati',
        'success' => '{count} {ResourcePlural} eliminati con successo',
        'failure' => 'Errore nell\'eliminazione dei {ResourcePlural}',
        'confirm' => 'Sei sicuro di voler eliminare i {ResourcePlural} selezionati?',
    ],
],
```

---

## 🌍 Traduzioni Multilingua

### Lingue Supportate

- **it** (Italiano) - Primario
- **en** (Inglese) - Secondario
- **de** (Tedesco) - Opzionale

### Esempio Comparativo

```php
// it/navigation.php
'navigation' => [
    'label' => 'Progetto',
    'plural_label' => 'Progetti',
    'group' => 'Gestione Progetti',
],

// en/navigation.php
'navigation' => [
    'label' => 'Project',
    'plural_label' => 'Projects',
    'group' => 'Project Management',
],

// de/navigation.php
'navigation' => [
    'label' => 'Projekt',
    'plural_label' => 'Projekte',
    'group' => 'Projektverwaltung',
],
```

---

## 🔧 Spatie Translatable Integration

### Model Configuration

```php
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations;
    
    public array $translatable = [
        'name',
        'description',
    ];
}
```

### Usage

```php
// Setting translations
$project->setTranslation('name', 'it', 'Nome Progetto');
$project->setTranslation('name', 'en', 'Project Name');
$project->save();

// Getting translations
$project->name; // Returns based on app locale
$project->getTranslation('name', 'it'); // Returns Italian
$project->getTranslations('name'); // Returns all
```

---

## 🎨 Filament Integration

### Resource Translation

```php
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->label(__('Modules::Project::fields.name.label'))
                ->placeholder(__('Modules::Project::fields.name.placeholder'))
                ->helperText(__('Modules::Project::fields.name.helper_text'))
                ->description(__('Modules::Project::fields.name.description'))
                ->tooltip(__('Modules::Project::fields.name.tooltip')),
        ]);
}
```

### Navigation Translation

```php
public static function getNavigationLabel(): string
{
    return __('Modules::Project::navigation.label');
}

public static function getNavigationGroup(): string
{
    return __('Modules::Project::navigation.group');
}
```

---

## ✅ Checklist Qualità

### Prima di Commitare

```markdown
## Translation Quality Checklist

- [ ] Tutti i campi hanno 5 chiavi (label, placeholder, helper_text, description, tooltip)
- [ ] Navigation ha 5 chiavi (label, plural_label, group, icon, sort)
- [ ] Actions ha tutte le chiavi (label, success, failure, confirm)
- [ ] Label sono descrittive (MAI "matr", SEMPRE "Matricola")
- [ ] Placeholder sono utili (MAI uguali a label)
- [ ] Helper text è informativo
- [ ] Tooltip aggiunge valore
- [ ] Traduzioni coerenti tra it/en/de
- [ ] Naming convention rispettata (kebab-case/snake_case)
- [ ] PHPStan passa senza errori
- [ ] Pest tests passano
```

---

## 🚨 Errori Comuni da Evitare

### ❌ SBAGLIATO

```php
// 1. Label non tradotte
'fields' => [
    'matr' => [
        'label' => 'matr',  // ❌ Deve essere "Matricola"
    ],
],

// 2. Chiavi mancanti
'fields' => [
    'email' => [
        'label' => 'Email',
        // ❌ Mancano: placeholder, helper_text, description, tooltip
    ],
],

// 3. Navigation incompleta
'navigation' => [
    'label' => 'Progetto',
    // ❌ Mancano: plural_label, group, icon, sort
],

// 4. Placeholder = Label
'fields' => [
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Nome',  // ❌ Deve essere diverso
    ],
],

// 5. Helper text vuoto quando serve
'fields' => [
    'codice_fiscale' => [
        'label' => 'Codice Fiscale',
        'helper_text' => '',  // ❌ Dovrebbe spiegare formato
    ],
],
```

---

## 📚 Riferimenti

- [Spatie Laravel Translatable](https://spatie.be/docs/laravel-translatable/v6)
- [Zeus Spatie Translatable](https://github.com/lara-zeus/spatie-translatable)
- [Filament Translatable](https://filamentphp.com/docs/3.x/plugins/translatable)
- [Laravel Localization](https://github.com/mcamara/laravel-localization)
- [Heroicons](https://heroicons.com/)

---

## 🔄 Processo di Aggiornamento

### Quando Aggiungere Nuova Traduzione

1. **Studiare** documentazione Spatie
2. **Creare** file con struttura completa
3. **Verificare** con checklist qualità
4. **Testare** in Filament
5. **Eseguire** quality gates (PHPStan, PHPMD, Pest)
6. **Documentare** in questo file

### Quando Correggere Traduzione

1. **Identificare** errore (missing key, wrong label)
2. **Studiare** contesto d'uso
3. **Correggere** file traduzione
4. **Verificare** tutte le lingue (it/en/de)
5. **Testare** UI Filament
6. **Eseguire** quality gates

---

*Documento SACRO per traduzioni Laraxot. Violazioni = Errori di qualità.*  
*Ultimo aggiornamento: 2025-03-25*
