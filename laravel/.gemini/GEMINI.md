# GEMINI.md - Regole, Memories e Skills per il Progetto PTVX

## 1. REGOLE FONDAMENTALI

### 1.1 Gestione Composer e Moduli
- **NON modificare MAI `./laravel/composer.json`** per installare nuovi pacchetti
- **Installare i nuovi pacchetti SEMPRE nel modulo appropriato** (es: `Modules/Meetup/composer.json`)
- **Eseguire SEMPRE `composer go`** dalla cartella `laravel` dopo aver installato nuovi pacchetti
- Il comando `composer go` aggiorna le dipendenze, pulisce cache, pubblica asset e riavvia il server

### 1.2 Git e Version Control
- **MAI fare `git remote set-url`** - questo comando è riservato all'utente
- **Andare sempre avanti con git** - non ripristinare mai versioni vecchie
- **Studiare i log git e le modifiche** quando necessario
- **Creare commit atomici** per ogni fix/feature con messaggi descrittivi

### 1.3 Dependency Injection e Actions
- **NON usare dependency injection nel costruttore** per le azioni
- **Usare `spatie/laravel-queueable-action`** con `app(NomeAzione::class)->execute()`
- **NON usare `CreateClientAction::class)->createPersonalAccessClient()`** ma `->execute()`
- Preferire helper functions alle dipendenze hard-coded

### 1.4 Architettura Filament
- **Estendere SEMPRE le classi base Xot** (XotBaseResource, XotBasePage, XotBaseWidget)
- **NON estendere direttamente** le classi Filament
- **Usare i trait forniti** (InteractsWithRecord, InteractsWithForms, etc.)
- **Usare $resource** per le Page che usano getUrl()
- **I metodi protected nella classe base DEVONO essere protected anche nelle classi figlie** (non public) per compatibilità con Filament 5

### 1.5 Localizzazione
- Usare `mcamara/laravel-localization` per la gestione multilingua
- **NON hardcodare le traduzioni** - usare sempre i file di lingua
- **Usare i middleware** forniti dal pacchetto per le routes localizzate

---

## 2. MEMORIES

### 2.1 Struttura Progetto
Il progetto usa:
- **Laravel 12** con **Filament 5**
- **nwidart/laravel-modules** per la modularità
- **wikimedia/composer-merge-plugin** per unire i composer.json dei moduli
- **mcamara/laravel-localization** per la localizzazione
- **spatie/laravel-queueable-action** per le azioni

### 2.2 Compositor Setup
Il `composer.json` principale ha:
```json
"extra": {
    "merge-plugin": {
        "include": ["Modules/*/composer.json"]
    }
}
```
Questo permette di caricare automaticamente le dipendenze di ogni modulo.

### 2.3 Commandi Utili
- `composer go` - Installazione completa (update, publish, optimize)
- `php artisan make:filament-page NomePagina --resource=NomeResource --type=custom` - Crea custom page
- `php artisan module:make NomeModulo` - Crea nuovo modulo (se necessario)

---

## 3. SKILLS

### 3.1 Skill: Gestione Moduli Laravel
**Scopo**: Gestire correttamente l'installazione di pacchetti nei moduli

**Regole**:
1. Verificare che il modulo esista in `Modules/`
2. Leggere il `composer.json` del modulo
3. Aggiungere il pacchetto richiesto in `require`
4. Eseguire `composer go` dalla cartella `laravel`
5. Verificare che il pacchetto sia stato installato correttamente

### 3.2 Skill: Custom Pages Filament
**Scopo**: Creare custom pages in Filament seguendo i pattern del progetto

**Pattern da seguire**:
```php
class MiaPagina extends XotBasePage implements HasForms
{
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form->schema([...])->statePath('data');
    }
    
    protected function getFormActions(): array
    {
        return [
            Action::make('save')->submit('save'),
        ];
    }
    
    public function save(): void
    {
        $data = $this->form->getState();
        // logica di salvataggio
    }
}
```

### 3.3 Skill: Laravel Localization
**Scopo**: Implementare correttamente la localizzazione

**Note**:
- Il pacchetto `mcamara/laravel-localization` è già installato
- middleware disponibili: `localize`, `localizationRedirect`, `localeSessionRedirect`, `localeViewPath`
- Helper: `LaravelLocalization::setLocale()`, `LaravelLocalization::getLocalizedURL()`

### 3.4 Skill: Actions con Spatie
**Scopo**: Usare correttamente le azioni queueable

**Pattern corretto**:
```php
// NON fare:
app(CreateClientAction::class)->createPersonalAccessClient();

// MA fare:
app(CreateClientAction::class)->execute();

// Oppure con parametri:
app(NomeAzione::class)->execute($param1, $param2);
```

---

## 4. FOLDER STRUCTURE

```
laravel/
├── .gemini/
│   └── GEMINI.md          <- Questo file
├── Modules/
│   ├── Xot/               <- Modulo core
│   ├── User/               <- Modulo utenti
│   ├── UI/                 <- Modulo UI/Temi
│   ├── Lang/               <- Modulo lingue
│   └── [Altri moduli]/
├── Themes/
│   └── [Temi del progetto]
├── composer.json          <- Principale (NON toccare per pacchetti)
└── .env                  <- Configurazione ambiente
```

---

## 5. AGGIORNAMENTO DOCUMENTAZIONE

### 5.1 Docs nei Moduli
Ogni modulo dovrebbe avere una cartella `docs/` con:
- Documentazione delle feature
- Note su configurazioni specifiche
- Pattern e convenzioni usate

### 5.2 Aggiornamento Docs
Prima di ogni intervento:
1. Leggere la documentazione esistente nel modulo
2. Verificare le rules specifiche del modulo
3. Aggiornare la documentazione se necessario
4. Collegare eventuali nuove risorse (issues, discussions, wiki)

---

## 6. GITHUB INTEGRATION

### 6.1 REGOLA FONDAMENTALE: Errori e Problemi
**QUANDO CAMBI UN'ERRORE O CORREGGI UN PROBLEMA DEVI SEMPRE:**
1. **Creare una GitHub Issue** - documentare il problema trovato
2. **Creare una GitHub Discussion** - discutere la soluzione
3. **Creare/aggiornare GitHub Wiki** - documentare la soluzione
4. **Creare/aggiornare GitHub Projects** - tracciare il lavoro
5. **Collegare tutto insieme** - Issue ↔ Discussion ↔ Wiki ↔ Projects

### 6.2 Issue Creation
Quando si crea un'issue:
1. Titolo chiaro e descrittivo
2. Descrizione dettagliata con step per riprodurre
3. Label appropriate
4. Collegamento a discussion/wiki se correlato
5. **SEMPRE aggiornare anche docs nei moduli**

### 6.3 Utilizzo gh
- `gh issue list` - Lista issue
- `gh issue create` - Crea issue
- `gh issue close` - Chiude issue
- `gh api repos/provtv/base_ptv_fila5_mono/discussions` - Lista discussion
- Creare discussion con API GraphQL o raw HTTP

### 6.4 Strumenti GitHub da Usare
- **Issues** - Tracciare bug e task
- **Discussions** - Q&A e informazioni
- **Wiki** - Documentazione tecnica
- **Projects** - Kanban per tracciare progresso
- **Actions** - CI/CD
- **Security** - Vulnerabilità

---

*Ultimo aggiornamento: 2026-02-17*

---

## 7. DEBUG E TROUBLESHOOTING

### 7.1 Errori di Boot Laravel
Quando il sito non parte:
1. `php -l file.php` - Verifica syntax PHP
2. `composer dump-autoload` - Ricrea autoload
3. `php artisan package:discover` - Scopri pacchetti
4. `php artisan serve` - Testa server locale

### 7.2 Errori Comuni
- **ParseError**: Codice fuori dalla classe - verificare } di chiusura
- **Access level conflict**: Metodi public che dovrebbero essere protected
- **Typed static property**: Proprietà non inizializzata - definire sempre $resource
