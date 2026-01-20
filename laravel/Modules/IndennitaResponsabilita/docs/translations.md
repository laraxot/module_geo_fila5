# Struttura Traduzioni - Modulo IndennitaResponsabilita

## Panoramica

Questo documento descrive la struttura completa delle traduzioni del modulo IndennitaResponsabilita, conforme alle regole Laraxot PTVX.

## Principi Fondamentali

### Struttura Espansa Obbligatoria

**TUTTE** le traduzioni devono utilizzare la struttura espansa con `label`, `placeholder`, `help`, e `tooltip`:

```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Testo placeholder',
    'help' => 'Testo di aiuto',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

### MAI Usare ->label() nei Componenti

❌ **VIETATO**:
```php
TextInput::make('anno')->label('Anno')
```

✅ **CORRETTO**:
```php
TextInput::make('anno') // Usa automaticamente indennitaresponsabilita::risorsa.fields.anno.label
```

## File di Traduzione del Modulo

### File Principali

1. **indennita_responsabilita.php** - Risorsa principale
2. **stabi_dirigente.php** - Gestione stabilimenti e dirigenti
3. **rating.php** - Sistema di valutazione
4. **rating_morph.php** - Relazioni polimorfe rating
5. **message.php** - Messaggi e comunicazioni
6. **condizioni_lavoro.php** - Condizioni lavorative
7. **compila_indennita_responsabilita.php** - Pagina compilazione

### File Secondari

- **lett_i.php**, **lett_f.php**, **lett_is.php**, **lett_fs.php** - Lettere specifiche
- **condizioni_lavoro_adm.php**, **condizioni_lavoro_rep.php**, **condizioni_lavoro_reps.php** - Varianti condizioni lavoro
- **servizio_esterno_reps.php** - Servizi esterni
- **xls_f_action.php** - Azioni export XLS
- **importi_categoria.php** - Importi per categoria

## Struttura Standard per Risorse

### Navigation

```php
'navigation' => [
    'name' => 'Nome Risorsa',           // Nome singolare
    'plural' => 'Nome Risorse',         // Nome plurale
    'group' => [
        'name' => 'Gruppo Navigazione', // Nome del gruppo
        'description' => 'Descrizione', // Descrizione opzionale
    ],
    'label' => 'Etichetta',             // Label per routing
    'sort' => 91,                       // Ordinamento
    'icon' => 'heroicon-o-nome',        // Icona Heroicon o custom
],
```

### Fields - Struttura Completa

```php
'fields' => [
    'anno' => [
        'label' => 'Anno',
        'placeholder' => 'Inserisci l\'anno',
        'help' => 'Anno di riferimento dell\'indennità',
        'tooltip' => 'Anno fiscale',
        'helper_text' => '',
    ],
    'matr' => [
        'label' => 'Matricola',
        'placeholder' => 'Inserisci la matricola',
        'help' => 'Numero di matricola del dipendente',
        'tooltip' => 'Matricola aziendale',
        'helper_text' => '',
    ],
    'cognome' => [
        'label' => 'Cognome',
        'placeholder' => 'Inserisci il cognome',
        'help' => 'Cognome del dipendente',
        'tooltip' => 'Cognome',
        'helper_text' => '',
    ],
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome del dipendente',
        'tooltip' => 'Nome',
        'helper_text' => '',
    ],
    'stabi' => [
        'label' => 'Stabilimento',
        'placeholder' => 'Seleziona lo stabilimento',
        'help' => 'Stabilimento di appartenenza',
        'tooltip' => 'Codice stabilimento',
        'helper_text' => '',
    ],
    'repar' => [
        'label' => 'Reparto',
        'placeholder' => 'Seleziona il reparto',
        'help' => 'Reparto di lavoro',
        'tooltip' => 'Codice reparto',
        'helper_text' => '',
    ],
    'valutatore_id' => [
        'label' => 'Valutatore',
        'placeholder' => 'Seleziona il valutatore',
        'help' => 'Utente che effettua la valutazione',
        'tooltip' => 'ID valutatore',
        'helper_text' => '',
    ],
    'is_compiled' => [
        'label' => 'Compilato',
        'help' => 'Indica se l\'indennità è stata compilata',
        'tooltip' => 'Stato compilazione',
        'helper_text' => '',
    ],
    'data_nascita' => [
        'label' => 'Data di Nascita',
        'placeholder' => 'Seleziona la data',
        'help' => 'Data di nascita del dipendente',
        'tooltip' => 'Formato: gg/mm/aaaa',
        'helper_text' => '',
    ],
],
```

### Actions - Struttura Completa

```php
'actions' => [
    'create' => [
        'label' => 'Crea Nuova Indennità',
        'icon' => 'heroicon-o-plus',
        'tooltip' => 'Crea una nuova indennità di responsabilità',
        'success' => 'Indennità creata con successo',
        'error' => 'Errore durante la creazione dell\'indennità',
    ],
    'edit' => [
        'label' => 'Modifica',
        'icon' => 'heroicon-o-pencil',
        'tooltip' => 'Modifica l\'indennità',
        'success' => 'Indennità aggiornata con successo',
        'error' => 'Errore durante l\'aggiornamento',
    ],
    'delete' => [
        'label' => 'Elimina',
        'icon' => 'heroicon-o-trash',
        'tooltip' => 'Elimina l\'indennità',
        'confirmation' => 'Sei sicuro di voler eliminare questa indennità?',
        'success' => 'Indennità eliminata con successo',
        'error' => 'Errore durante l\'eliminazione',
    ],
    'compila' => [
        'label' => 'Compila',
        'icon' => 'heroicon-o-document-text',
        'tooltip' => 'Compila l\'indennità',
        'success' => 'Indennità compilata con successo',
        'error' => 'Errore durante la compilazione',
    ],
    'export_pdf' => [
        'label' => 'Esporta PDF',
        'icon' => 'heroicon-o-document-arrow-down',
        'tooltip' => 'Esporta in formato PDF',
        'success' => 'PDF generato con successo',
        'error' => 'Errore durante la generazione del PDF',
    ],
    'export_xls' => [
        'label' => 'Esporta Excel',
        'icon' => 'heroicon-o-table-cells',
        'tooltip' => 'Esporta in formato Excel',
        'success' => 'File Excel generato con successo',
        'error' => 'Errore durante la generazione del file Excel',
    ],
    'import' => [
        'label' => 'Importa',
        'icon' => 'heroicon-o-arrow-up-tray',
        'tooltip' => 'Importa dati da file',
        'row_number' => 'Riga :row',
        'fields' => [
            'import_file' => [
                'label' => 'File da Importare',
                'placeholder' => 'Seleziona un file XLS o CSV',
                'help' => 'Carica il file da importare',
                'tooltip' => 'Formati supportati: XLS, XLSX, CSV',
            ],
        ],
        'success' => 'Dati importati con successo',
        'error' => 'Errore durante l\'importazione',
    ],
],
```

### Messages e Notifications

```php
'messages' => [
    'created' => 'Indennità creata con successo',
    'updated' => 'Indennità aggiornata con successo',
    'deleted' => 'Indennità eliminata con successo',
    'compiled' => 'Indennità compilata con successo',
    'error' => 'Si è verificato un errore',
    'validation_error' => 'Errore di validazione dei dati',
    'not_found' => 'Indennità non trovata',
    'already_compiled' => 'L\'indennità è già stata compilata',
    'cannot_delete_compiled' => 'Non è possibile eliminare un\'indennità già compilata',
],

'validation' => [
    'anno_required' => 'L\'anno è obbligatorio',
    'matr_required' => 'La matricola è obbligatoria',
    'valutatore_required' => 'Il valutatore è obbligatorio',
    'stabi_required' => 'Lo stabilimento è obbligatorio',
    'repar_required' => 'Il reparto è obbligatorio',
],
```

## Lingue Supportate

### Italiano (it) - Principale
Directory: `Modules/IndennitaResponsabilita/lang/it/`

### Inglese (en) - Internazionalizzazione
Directory: `Modules/IndennitaResponsabilita/lang/en/`

### Tedesco (de) - Supporto Multilingua
Directory: `Modules/IndennitaResponsabilita/lang/de/`

## Convenzioni di Naming

### Chiavi dei File
- Usare **snake_case** per i nomi dei file: `indennita_responsabilita.php`
- Evitare trattini nei nomi dei file (preferire underscore)

### Chiavi delle Traduzioni
- Usare **snake_case** per le chiavi: `valutatore_id`, `is_compiled`
- Raggruppare logicamente: `fields.nome`, `actions.create`, `messages.success`

### Icone
- Usare icone Heroicons: `heroicon-o-nome` (outline) o `heroicon-s-nome` (solid)
- Per icone custom del modulo: registrarle nel ServiceProvider

## Problemi Comuni e Soluzioni

### Problema: `'icon' => 'indennita responsabilita.navigation'`
❌ **Errato**: Riferimento circolare o chiave mancante

✅ **Corretto**: `'icon' => 'heroicon-o-briefcase'`

### Problema: `'group' => ['name' => '']`
❌ **Errato**: Nome gruppo vuoto

✅ **Corretto**: `'group' => ['name' => 'Indennità']`

### Problema: Campi senza struttura espansa
❌ **Errato**: `'nome' => 'Nome'`

✅ **Corretto**:
```php
'nome' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Nome del dipendente',
    'tooltip' => 'Nome',
    'helper_text' => '',
],
```

## Checklist Completezza Traduzioni

- [ ] Tutte le chiavi hanno struttura espansa
- [ ] Navigation completa con icon, group, sort
- [ ] Fields con label, placeholder, help, tooltip
- [ ] Actions con label, icon, tooltip, success, error
- [ ] Messages e validation
- [ ] Traduzione presente in IT, EN, DE
- [ ] Nessuna stringa hardcoded nei componenti
- [ ] File conformi a PSR-12 e PHPStan livello 10

## Collegamenti

- [README Modulo](./README.md)
- [Regole Traduzioni Laraxot](../../Xot/docs/TRANSLATION_RULES.md)
- [Best Practices Filament](../../Xot/docs/FILAMENT_BEST_PRACTICES.md)

## Ultimo Aggiornamento

Data: 2025-12-04
Autore: iFlow CLI
Versione: 1.1

### Modifiche Recenti (v1.1)

#### Correzione Navigation .navigation Issues
Sono state corrette le traduzioni con riferimenti `.navigation` non validi:

1. **lett_i.php**: 
   - ❌ `'icon' => 'lett i.navigation'` → ✅ `'icon' => 'heroicon-o-document-check'`
   - ❌ `'group' => 'Indennità Responsabilità'` → ✅ `'group' => 'Indennità'`

2. **lett_f.php**:
   - ❌ `'icon' => 'lett f.navigation'` → ✅ `'icon' => 'heroicon-o-document-text'`
   - ❌ `'group' => 'Indennità Responsabilità'` → ✅ `'group' => 'Indennità'`

3. **my_log.php**:
   - ❌ `'icon' => 'my log.navigation'` → ✅ `'icon' => 'heroicon-o-document-text'`
   - ❌ `'group' => 'Indennità Responsabilità'` → ✅ `'group' => 'Indennità'`

4. **mail_template.php**:
   - ❌ `'label' => 'mail template.navigation'` → ✅ `'label' => 'Template Email'`
   - ❌ `'group' => 'mail template.navigation'` → ✅ `'group' => 'Indennità'`
   - ❌ `'icon' => 'mail template.navigation'` → ✅ `'icon' => 'heroicon-o-envelope'`

5. **importi_categoria.php**:
   - ❌ `'group' => 'Indennità Responsabilità'` → ✅ `'group' => 'Indennità'`

#### Pattern Laraxot Applicati
- **Icone Heroicon**: Tutte le icone ora usano il formato `heroicon-o-nome` 
- **Gruppi Semantic**: Gruppi di navigazione semplificati e coerenti
- **Nomi Italiani**: Tutte le label in italiano corretto
- **Niente Riferimenti Circolari**: Eliminati riferimenti `.navigation` non validi

#### Qualità del Codice
- ✅ PHPStan Livello 10: No errors
- ✅ PHPMD: Nessuna violazione
- ✅ PHPInsights: 98.8% qualità (solo warning lunghezza linee)
- ✅ Pint: Formattazione conforme

#### Filosofia Laraxot Rispettata
1. **MAI usare ->label()** nei componenti Filament
2. **Struttura espansa** per tutti i campi con label, placeholder, help, tooltip
3. **Icone Heroicon** standard invece di riferimenti custom
4. **Gruppi semanticamente coerenti** nel navigation
5. **Nomi in italiano** per l'interfaccia utente



