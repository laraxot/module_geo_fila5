# Struttura Traduzioni - Modulo Pdnd

## Principio Fondamentale
**MAI usare `->label()`, `->placeholder()`, `->tooltip()` nei componenti Filament**. 

Tutte le traduzioni sono gestite automaticamente dal `LangServiceProvider` del modulo Lang.

## Struttura File di Traduzione

### Posizionamento
```
Modules/Pdnd/lang/it/
├── pdnd.php                                          # Traduzioni generali
├── servizio_verifica_dich_generalita.php            # C003 test
├── servizio_verifica_dich_generalita_p_r_o_d.php    # C003 prod
├── servizio_accertamento_id_unico_nazionale.php     # C030 test
├── servizio_accertamento_id_unico_nazionale_page_p_r_o_d.php  # C030 prod
├── servizio_verifica_dich_esistenza_vita.php        # C007 test
├── guzzle_proxy.php                                  # Test Guzzle
└── curl_proxy.php                                    # Test cURL
```

## Pattern di Traduzione per Campi Form

### Struttura Espansa Obbligatoria
```php
// lang/it/servizio_verifica_dich_generalita.php
return [
    'fields' => [
        'codiceFiscale' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Codice fiscale del cittadino da verificare',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome come dichiarato dal cittadino',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome come dichiarato dal cittadino',
        ],
        'sesso' => [
            'label' => 'Sesso',
            'placeholder' => 'M o F',
            'help' => 'M per maschio, F per femmina',
        ],
        'dataNascita' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'YYYY-MM-DD',
            'help' => 'Data di nascita nel formato YYYY-MM-DD',
        ],
        'nomeComune' => [
            'label' => 'Nome Comune',
            'placeholder' => 'Es. Roma',
            'help' => 'Nome del comune di nascita',
        ],
        'codiceIstat' => [
            'label' => 'Codice ISTAT',
            'placeholder' => 'Es. 058091',
            'help' => 'Codice ISTAT del comune',
        ],
        'siglaProvinciaIstat' => [
            'label' => 'Sigla Provincia',
            'placeholder' => 'Es. RM',
            'help' => 'Sigla provincia secondo ISTAT',
        ],
        'descrizioneLocalita' => [
            'label' => 'Descrizione Località',
            'placeholder' => 'Es. Lazio',
            'help' => 'Descrizione della località o regione',
        ],
    ],
];
```

## Pattern per Actions

### Struttura Espansa per Azioni
```php
return [
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Invia Richiesta',
            'tooltip' => 'Invia la richiesta ad ANPR',
            'icon' => 'heroicon-o-paper-airplane',
        ],
        'testConnection' => [
            'label' => 'Esegui Test',
            'tooltip' => 'Testa la connessione al proxy',
            'icon' => 'heroicon-o-play',
        ],
        'clearResults' => [
            'label' => 'Pulisci Risultati',
            'tooltip' => 'Cancella i risultati del test',
            'icon' => 'heroicon-o-trash',
        ],
    ],
];
```

## Convenzioni di Naming

### File di Traduzione
- Nome file in snake_case
- Suffisso `_p_r_o_d` per varianti produzione
- Prefisso `servizio_` per servizi ANPR

### Chiavi di Traduzione
```php
'fields.campo_nome.label'       // Label del campo
'fields.campo_nome.placeholder' // Placeholder
'fields.campo_nome.help'        // Testo di aiuto

'actions.nome_azione.label'     // Label azione
'actions.nome_azione.tooltip'   // Tooltip azione
'actions.nome_azione.icon'      // Icona (opzionale)

'messages.success'              // Messaggio successo
'messages.error'                // Messaggio errore
```

## Utilizzo nelle Pagine

### ✅ CORRETTO - Senza label()
```php
public function pdndForm(Schema $schema): Schema
{
    return $schema->schema([
        TextInput::make('codiceFiscale')
            ->required(),
        TextInput::make('cognome')
            ->required(),
        TextInput::make('nome')
            ->required(),
    ]);
}
```

Il `LangServiceProvider` automaticamente:
1. Cerca `pdnd::servizio_verifica_dich_generalita.fields.codiceFiscale.label`
2. Applica `->label()` automaticamente
3. Applica `->placeholder()` e `->helperText()` se presenti

### ❌ ERRATO - Con label() esplicito
```php
// ❌ MAI FARE QUESTO
TextInput::make('codiceFiscale')
    ->label('Codice Fiscale')  // VIETATO
    ->placeholder('...')        // VIETATO
    ->required()
```

## File di Traduzione Attuali

### Verificati e Conformi
- ✅ `pdnd.php` - Struttura espansa completa
- ✅ `servizio_verifica_dich_generalita.php` - Struttura espansa completa
- ✅ `servizio_accertamento_id_unico_nazionale.php` - Struttura espansa completa
- ✅ `guzzle_proxy.php` - Struttura espansa completa
- ✅ `curl_proxy.php` / `curl_proxy_page.php` / `consultazione_anagrafica.php` / `servizio_accertamento_generalita.php` - Etichette navigation localizzate (aggiornamento 19/11/2025)

### Da Aggiornare (se necessario)
- Verificare completezza chiavi per tutti i campi usati
- Aggiungere tooltip dove mancanti
- Standardizzare format messaggi successo/errore
- Mantenere sincronizzati `icon`, `group` e `label` con la tassonomia PDND ogni volta che si introduce un nuovo servizio

## Checklist Traduzioni

Prima di creare un nuovo componente form:
- [ ] Creare/aggiornare file traduzione in `lang/it/`
- [ ] Usare struttura espansa (label, placeholder, help)
- [ ] NON usare `->label()`, `->placeholder()`, `->tooltip()` nel codice
- [ ] Testare che le traduzioni vengano applicate automaticamente
- [ ] Documentare in questo file eventuali convenzioni specifiche

## Automazione LangServiceProvider

Il provider carica automaticamente le traduzioni per:
- `TextInput`
- `Select`
- `Textarea`
- `DatePicker`
- `Toggle`
- `Checkbox`
- Tutti i componenti form Filament standard

### Come funziona
1. Componente `TextInput::make('codiceFiscale')` viene creato
2. `LangServiceProvider` intercetta il componente
3. Cerca la chiave `{module}::{resource}.fields.codiceFiscale.label`
4. Applica automaticamente `->label()`, `->placeholder()`, `->helperText()`

## Best Practices

### 1. Coerenza
Mantenere stessa struttura in tutti i file di traduzione del modulo.

### 2. Completezza
Ogni campo deve avere almeno `label`. Preferibile avere anche `placeholder` e `help`.

### 3. Contesto
Le traduzioni devono essere auto-esplicative senza dover vedere il codice.

### 4. Formato
- Label: Iniziale maiuscola, breve, chiara
- Placeholder: Esempio pratico di input
- Help: Descrizione completa dello scopo del campo

## Errori Comuni

### Errore: Label non appare
**Causa**: Chiave di traduzione mancante o nome file errato
**Soluzione**: Verificare che esista `lang/it/{resource}.php` con chiave corretta

### Errore: Traduzione in inglese
**Causa**: Fallback a lingua di default
**Soluzione**: Aggiungere traduzione italiana mancante

### Errore: `->label()` ignorato
**Causa**: LangServiceProvider sovrascrive label esplicite
**Soluzione**: Rimuovere `->label()` e usare solo file di traduzione

## Collegamenti
- [LangServiceProvider](../../Lang/app/Providers/LangServiceProvider.php)
- [Best Practices Filament](./filament-best-practices.md)
- [Regole Traduzioni Laraxot](../../Xot/docs/translations-best-practices.md)

*Ultimo aggiornamento: 19 Novembre 2025*

