# Story 7.41: CreateTicketWizardWidget — Step 3 Summary usa Filament Infolist Entries

**Stato**: ready-for-dev  
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)  
**Ultimo aggiornamento**: 2026-04-14

---

## Story

Come **sviluppatore che mantiene il wizard segnalazione**,  
voglio che `makeStepSummary()` in `CreateTicketWizardWidget` usi **Filament Infolist Entries** (`Filament\Infolists\Components\TextEntry`, `ImageEntry`, ecc.) con stato letto via `Get $get` dal contesto dello schema,  
così il passo di riepilogo rispetta la semantica Filament v5: display-only = Infolist, interactive = Form.

---

## Contesto e Zen — Perché Infolist nel riepilogo

### 1. Il contratto semantico di Filament v5

Filament v5 ha un sistema Schema unificato con tre categorie di componenti:

| Categoria | Namespace | Semantica |
|-----------|-----------|-----------|
| Form Fields | `Filament\Forms\Components` | Input interattivo (validazione, bind, mutazione) |
| Infolist Entries | `Filament\Infolists\Components` | Display read-only (nessuna interazione) |
| Layout / Schema | `Filament\Schemas\Components` | Struttura (Grid, Section, Wizard, Step...) |

**Regola**: uno Step che mostra dati già raccolti (riepilogo/review) è semanticamente un display-only.  
Va costruito con **Infolist Entries**, non con Form Fields in modalità read-only.

### 2. Perché non `TextInput::make()->disabled()->dehydrated(false)`

Un `TextInput` disabilitato:
- Partecipa al ciclo di validazione del form (anche se ignorato)
- Dichiara "sono un campo di input" mentre si comporta da visualizzatore
- È un **mentitore semantico**: il tipo dice "raccogli dato", l'intenzione dice "mostra dato"

Un `TextEntry`:
- Non partecipa alla validazione (non è un Field)
- Dichiara esplicitamente "sono un display read-only"
- È importabile da `Filament\Infolists\Components\TextEntry`
- Funziona in qualsiasi Schema Filament v5, inclusi i wizard Step

### 3. Come leggere lo stato del form in un TextEntry (via `Get`)

In Filament v5, tutti i componenti Schema possono ricevere `Get $get` nelle closure:

```php
TextEntry::make('review_title')
    ->state(fn (Get $get): string => (string) ($get('title') ?? ''))
```

`Get $get` è il meccanismo ufficiale Filament v5 per leggere il valore di altri componenti  
nel contesto dello stesso schema. Funziona anche cross-step: `$get('step_name.field')` o  
semplicemente `$get('field_name')` se i dati sono flat (come nel wizard Fixcity).

**NON usare**: `$this->data['title']` — lega il componente alla proprietà Livewire,  
rompe la testabilità isolata dello schema e non funziona in contesti senza widget.

### 4. Perché non una Blade view (`SchemaView`)

Il vecchio approccio usava `SchemaView::make('fixcity::filament.widgets.partials.ticket-create-wizard-summary')`:
- Porta la logica di display nel Blade (layer sbagliato)
- Nessuna traduzione automatica (LangServiceProvider non copre Blade partials)
- Nessuna type safety sui dati passati
- Nessun riuso di layout Filament (Grid, Section, IconEntry...)

**Regola**: se Filament ha un componente per farlo → usarlo. Il Blade è per struttura HTML, non per business display logic.

### 5. Perché non `ImageEntry` per le immagini nel summary

Le immagini caricate via `FileUpload` nel form sono **path temporanei** o **ID Livewire** finché non vengono saved. Il summary può mostrare il **conteggio** delle immagini (con `TextEntry`) ma NON può renderizzare le immagini con `ImageEntry` perché il record non esiste ancora.

```php
// ✓ Corretto nel summary pre-submit
TextEntry::make('review_images_count')
    ->state(function (Get $get): string {
        $images = $get('images');
        return (string) (is_array($images) ? count($images) : 0);
    })

// ✗ Sbagliato: il record non esiste ancora
ImageEntry::make('images') // → richiede un Eloquent record salvato
```

### 6. Zen — "La fase di review è l'ultimo controllo prima dell'irreversibile"

Il passo 3 ha una responsabilità specifica: mostrare all'utente i dati raccolti in modo chiaro, leggibile e senza possibilità di confusione con campi editabili. Usare `TextEntry` (Infolist) invece di `TextInput` (Form) comunica visivamente e semanticamente:

> "Non c'è più niente da inserire. Stai guardando ciò che verrà inviato."

---

## Stato corrente di `makeStepSummary()` — DA CAMBIARE

**Il codice attuale USA ANCORA `SchemaView` + Blade partial.** Non è stato ancora migrato a TextEntry.

```php
// STATO ATTUALE (da sostituire)
private function makeStepSummary(): Step
{
    return Step::make('3')
        ->schema([
            SchemaView::make('fixcity::filament.widgets.partials.ticket-create-wizard-summary')
                ->columnSpanFull(),
        ]);
}
```

Il Blade partial (`resources/views/filament/widgets/partials/ticket-create-wizard-summary.blade.php`):
- Accede a `$livewire->data` direttamente (accoppiamento fragile)
- Usa `__()` per le label (duplica il sistema i18n)
- Usa HTML Bootstrap Italia (`cmp-card`, `dl`/`dt`/`dd`) — logica display nel layer Blade

### Stato target

```php
// TARGET: usa TextEntry Infolist, stato letto via Get $get
private function makeStepSummary(): Step
{
    $empty = (string) __('fixcity::create_ticket_wizard.summary.empty');

    return Step::make('3')
        ->schema([
            TextEntry::make('review_address')
                ->state(fn (Get $get): string => (string) ($get('address') ?: $empty))
                ->columnSpanFull(),
            TextEntry::make('review_issueType')
                ->state(fn (Get $get): string =>
                    TicketTypeEnum::tryFrom((string) ($get('issueType') ?? ''))?->label
                    ?? (string) ($get('issueType') ?: $empty)
                ),
            TextEntry::make('review_title')
                ->state(fn (Get $get): string => (string) ($get('title') ?: $empty)),
            TextEntry::make('review_details')
                ->state(fn (Get $get): string => (string) ($get('details') ?: $empty))
                ->columnSpanFull(),
            TextEntry::make('review_images_count')
                ->state(function (Get $get): string {
                    $images = $get('images');
                    $count = is_array($images) ? count($images) : 0;
                    return (string) $count;
                })
                ->hidden(fn (Get $get): bool => count((array) ($get('images') ?? [])) === 0),
        ]);
}
```

### Import da aggiungere / modificare

```php
// AGGIUNGERE:
use Filament\Forms\Components\Get;
use Filament\Infolists\Components\TextEntry;

// RIMUOVERE (non più usato):
use Filament\Schemas\Components\View as SchemaView;
```

### File da eliminare dopo il refactor

```
laravel/Modules/Fixcity/resources/views/filament/widgets/partials/ticket-create-wizard-summary.blade.php
```

### Lang keys da aggiungere in `create_ticket_wizard.php` (it + en)

Aggiungere nella sezione `fields`:
```php
// it/create_ticket_wizard.php
'review_address'      => ['label' => 'Indirizzo'],
'review_issueType'    => ['label' => 'Tipo di disservizio'],
'review_title'        => ['label' => 'Titolo'],
'review_details'      => ['label' => 'Descrizione'],
'review_images_count' => ['label' => 'Immagini allegate'],
```
```php
// en/create_ticket_wizard.php
'review_address'      => ['label' => 'Address'],
'review_issueType'    => ['label' => 'Issue type'],
'review_title'        => ['label' => 'Title'],
'review_details'      => ['label' => 'Details'],
'review_images_count' => ['label' => 'Attached images'],
```

### Note implementative

- **NO `->label()` hardcoded** — `AutoLabelAction` via `Entry::configureUsing()` lo gestisce (vedi `LangServiceProvider.php:82`)
- **`Get $get`** è l'iniezione ufficiale Filament v5 per leggere stato form in chiusure schema
- **NON usare `$this->data['field']`** nelle closure dei componenti — accoppiamento fragile
- **`ImageEntry` NON applicabile** nel summary pre-submit: le immagini non sono ancora record Eloquent → usare `review_images_count` con `TextEntry`
- **Prefisso `review_`**: separa semanticamente display entries (riepilogo) da form fields (input), evita collisioni di stato e permette label diverse

---

## Task

### Task 1 — Verificare e rifinire `makeStepSummary()`

**File**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`

1. Verificare che tutti gli `use` siano corretti: `TextEntry` da `Filament\Infolists\Components\TextEntry`, `Get` da `Filament\Schemas\Components\Utilities\Get`
2. Rimuovere eventuali import orfani (`SchemaView` se rimasto)
3. Opzionale: aggiungere `->hidden()` su `review_images_count` se count = 0
4. Opzionale: aggiungere `->badge()->color()` su `review_issue_type` per visualizzare il tipo con colore enum

### Task 2 — Documentare la regola nel progetto

**File**: `.agents/docs/main-rules/gemini-filament.md`

Aggiungere sezione: **"Wizard summary step → Infolist Entries (REGOLA)"** con:
- Tabella Form Fields vs Infolist Entries
- Esempio `TextEntry::make()->state(fn(Get $get)=>...)`
- Anti-pattern: `TextInput::disabled()` nel riepilogo

### Task 3 — Aggiornare `CreateTicketWizardWidget.md`

**File**: `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md`

Aggiungere sezione:
- "Step 3 — Riepilogo: Infolist Entries via Get"
- Spiegare perché `TextEntry` non `TextInput`
- Spiegare perché `TextEntry` per immagini count, non `ImageEntry`
- Link a docs Filament Infolists: https://filamentphp.com/docs/5.x/infolists/overview

### Task 4 — Aggiornare memoria e regole agents

- Creare/aggiornare memory `feedback_wizard_summary_infolist.md`
- Aggiornare MEMORY.md index

---

## Acceptance Criteria

1. **GIVEN** `makeStepSummary()` in `CreateTicketWizardWidget`  
   **WHEN** si cerca `TextInput|Select|Textarea|Checkbox` nel metodo  
   **THEN** nessun risultato: nessun Form Field nel passo riepilogo

2. **GIVEN** `makeStepSummary()`  
   **WHEN** si cerca `TextEntry|ImageEntry|IconEntry` nel metodo  
   **THEN** tutti i campi display usano Infolist Entries

3. **GIVEN** il wizard su `/it/tests/segnalazione-crea`  
   **WHEN** si naviga al passo 3  
   **THEN** i valori inseriti negli step 1 e 2 sono visualizzati correttamente

4. **GIVEN** la doc `.agents/docs/main-rules/gemini-filament.md`  
   **WHEN** si cerca "summary" o "riepilogo"  
   **THEN** esiste una regola esplicita: summary step → Infolist Entries

5. **GIVEN** imports in `CreateTicketWizardWidget.php`  
   **WHEN** si cerca `SchemaView`  
   **THEN** nessun import orfano rimasto

---

## Guardrails per il dev

- NON usare `TextInput::make()->disabled()` nel passo riepilogo — è un form field travestito da display
- NON usare `SchemaView` per il riepilogo — porta logica nel layer Blade
- `Get $get` è il meccanismo corretto per leggere stato form in un wizard step — NON usare `$this->data['field']` nelle closure dei componenti schema
- `ImageEntry` richiede un Eloquent record salvato — nel summary pre-submit usare solo conteggio
- LangServiceProvider auto-genera chiavi per `TextEntry` proprio come per Form Fields — non usare `->label()` hardcoded

---

## Riferimenti Filament v5

| Documento | URL |
|-----------|-----|
| Infolists overview | https://filamentphp.com/docs/5.x/infolists/overview |
| TextEntry | https://filamentphp.com/docs/5.x/infolists/entries/text |
| Schema overview (Form + Infolist unificati) | https://filamentphp.com/docs/5.x/schemas/overview |

---

## File da toccare

| File | Operazione |
|------|-----------|
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Verificare/rifinire `makeStepSummary()` |
| `.agents/docs/main-rules/gemini-filament.md` | Aggiungere regola "summary step → Infolist Entries" |
| `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` | Aggiungere sezione Step 3 Infolist pattern |
| Memory: `feedback_wizard_summary_infolist.md` + `MEMORY.md` | Creare/aggiornare |
