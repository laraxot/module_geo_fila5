# Story 7-42: segnalazione-crea step2 HTML parity + Infolist author section + step3 Infolist Entries

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)
**Ultimo aggiornamento**: 2026-04-14
**Dipende da**: 7-41 (step3 Infolist summary — già ready-for-dev), 7-36 (geolocation)

---

## Story

Come **utente che compila una segnalazione disservizio**,
voglio che lo step 2 ("Dati della segnalazione") abbia **HTML parity e visual parity** con il riferimento Design Comuni https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html,
così l'esperienza è coerente con le linee guida ufficiali, con 3 sezioni distinte (Luogo, Disservizio, Autore) e il riepilogo step 3 usa Filament Infolist Entries invece di Placeholder.

---

## Analisi — Differenze tra riferimento e implementazione attuale

### Struttura riferimento Design Comuni (segnalazione-02-dati.html)

| Sezione | Campi | Tipo | Note |
|---------|-------|------|------|
| **LUOGO** | `Cerca un luogo*` | input[text] + bottone GPS | Section con `<legend>` + descrizione |
| **DISSERVIZIO** | `Tipo di disservizio*` | select | Enum con opzioni |
| | `Titolo*` | input[text] | maxLength non specificato nel ref |
| | `Dettagli**` | textarea | **maxlength="200"** + hint "Inserire al massimo 200 caratteri" |
| | `Immagini` | file upload multiple | Preview file con nome + bottone "Carica file" |
| **AUTORE DELLA SEGNALAZIONE** | Nome + CF | **read-only (Infolist)** | "Informazione su di te" |
| | Contatti (tel, email) | **read-only + Modifica** | Sezione `<dl>/<dt>/<dd>` |

### Struttura implementazione attuale (CreateTicketWizardWidget.php → getDataSchema)

| Sezione | Campi attuali | Problemi |
|---------|---------------|----------|
| **Section: place** | AddressInput::make('address') | ✓ OK — ha già GPS spinner |
| **Section: inefficiency** | Select::make('type'), TextInput::make('name'), Textarea::make('content'), FileUpload::make('images') | ⚠️ Ordine sbagliato: type → name → content, dovrebbe essere type → titolo → dettagli |
| **Section: author** | Placeholder::make('author_name'), Placeholder::make('author_fiscal_code'), Placeholder::make('author_phone'), TextInput::make('email') | ❌ Placeholder sono Form Fields disabled, non Infolist Entries |

### Gap critici

1. **Section names**: `place`, `inefficiency`, `author` → devono diventare `luogo`, `disservizio`, `autore` (per parity con ref HTML `#luogo`, `#disservizio`, `#autore`)
2. **Section descriptions**: mancano le descrizioni sotto i `<legend>` (es. "Indica il luogo del disservizio")
3. **Author section**: usa Placeholder (Form Fields) invece di Infolist Entries → **semantica sbagliata**
4. **Step 3 summary**: usa ancora Placeholder invece di TextEntry/Infolist → **story 7-41**
5. **Required indicators**: il riferimento usa `*` e `**` con legenda globale
6. **File upload wrapper**: il ref ha struttura `.upload-preview` con file-name + divider + button

---

## Filosofia — Perché Infolist per l'autore e il riepilogo

### Il contratto semantico di Filament v5

Filament v5 ha un sistema Schema unificato con tre categorie:

| Categoria | Namespace | Semantica | Quando usarlo |
|-----------|-----------|-----------|---------------|
| **Form Fields** | `Filament\Forms\Components` | Input interattivo | Dati da raccogliere dall'utente |
| **Infolist Entries** | `Filament\Infolists\Components` | Display read-only | Dati già esistenti, info utente, riepilogo |
| **Layout** | `Filament\Schemas\Components` | Struttura | Section, Grid, Wizard, Step |

### Zen: "Non mentire sul tipo di componente"

- **Placeholder** = Form Field disabilitato = "Sono un input ma non raccolgo niente" → **BUGIA SEMANTICA**
- **TextEntry** = Infolist Entry = "Sono un display read-only" → **VERITÀ SEMANTICA**

L'autore della segnalazione è **dati già esistenti** (utente autenticato). Non si raccolgono, si **mostrano**.
Il riepilogo step 3 è **dati già inseriti**. Non si editano, si **rivedono**.

### Religione: "Ogni tipo di dato ha il suo componente"

```
Dati da COLLABORAZIONE utente → Form Fields (TextInput, Select, Textarea)
Dati da MOSTRAZIONE (profilo, riepilogo) → Infolist Entries (TextEntry, IconEntry)
Struttura visiva → Layout (Section, Grid, Wizard)
```

### Politica del progetto

- **NO `->label()` hardcoded** — LangServiceProvider auto-applica via AutoLabelAction
- **NO `TextInput::disabled()`** nel riepilogo o autore — usa TextEntry
- **`Get $get`** è il meccanismo ufficiale per leggere stato form nelle closure
- **NON usare `$this->data['field']`** nelle closure — accoppiamento fragile a Livewire

---

## Acceptance Criteria

### AC 1 — Step 2 ha 3 sezioni con nomi corretti
**GIVEN** `getDataSchema()` in `CreateTicketWizardWidget`
**WHEN** si leggono i Section::make()
**THEN** sono 3: `luogo`, `disservizio`, `autore`

### AC 2 — Sezione Luogo parity
**GIVEN** sezione `luogo`
**WHEN** si renderizza
**THEN** ha:
- Description: "Indica il luogo del disservizio"
- AddressInput con GPS button (già implementato)
- Label: "Cerca un luogo*"

### AC 3 — Sezione Disservizio parity
**GIVEN** sezione `disservizio`
**WHEN** si renderizza
**THEN** ha nell'ordine:
1. Select `type` → "Tipo di disservizio*"
2. TextInput `name` → "Titolo*" (maxLength 255)
3. Textarea `content` → "Dettagli**" (maxLength 200, helper: "Inserire al massimo 200 caratteri")
4. FileUpload `images` → "Immagini" (multiple, con preview)

### AC 4 — Sezione Autore usa Infolist Entries
**GIVEN** sezione `autore`
**WHEN** si renderizza
**THEN** ha:
- Description: "Informazione su di te"
- TextEntry::make('author_name') → mostra nome utente autenticato
- TextEntry::make('author_fiscal_code') → mostra CF
- TextEntry::make('author_phone') → mostra telefono
- TextInput::make('email') → campo editabile (non Infolist, perché è input)

### AC 5 — Step 3 usa Infolist Entries (merge da 7-41)
**GIVEN** `getSummarySchema()`
**WHEN** si naviga a step 3
**THEN** tutti i campi usano TextEntry/ImageEntry con `fn(Get $get)`, non Placeholder

### AC 6 — Multilingua completo
**GIVEN** wizard su `/it/tests/segnalazione-crea` e `/en/tests/segnalazione-crea`
**WHEN** si visitano entrambi
**THEN** tutte le label, description, helper text sono tradotte (it/en)

### AC 7 — Visuale parity con riferimento
**GIVEN** screenshot reference (`segnalazione-02-dati.html`)
**WHEN** confronto visivo
**THEN**:
- 3 sezioni con `<legend>` visivamente distinti
- Sezione autore con stile read-only (diverso dai form fields)
- File upload con preview filename
- Bottone GPS nella sezione luogo

---

## Technical Requirements

### File da modificare

| File | Operazione |
|------|-----------|
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Refactor getDataSchema() + getSummarySchema() |
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | Aggiungere chiavi per section labels/descriptions |
| `laravel/Modules/Fixcity/lang/en/segnalazione.php` | Traduzioni inglesi |
| `laravel/Modules/Fixcity/lang/it/ticket.php` | Chiavi Infolist author entries |
| `laravel/Modules/Fixcity/lang/en/ticket.php` | Traduzioni inglesi |
| `laravel/Modules/Geo/docs/location-spinner-ux.md` | Già aggiornato (story 7-36) |
| `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` | Documentare pattern Infolist |
| `laravel/Modules/Xot/docs/filament/widgets/infolist-for-summary.md` | Nuova doc |

### Import necessari

```php
// DA AGGIUNGERE:
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;

// DA RIMUOVERE (se presente):
use Filament\Forms\Components\Placeholder; // ← è un Form Field, non Infolist
```

### Struttura target getDataSchema()

```php
public function getDataSchema(): array
{
    return [
        // SEZIONE 1: Luogo
        Section::make('luogo')
            ->description((string) __('fixcity::segnalazione.sections.luogo.description'))
            ->schema([
                AddressInput::make('address')
                    ->required()
                    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
            ]),

        // SEZIONE 2: Disservizio
        Section::make('disservizio')
            ->schema([
                Select::make('type')
                    ->options(TicketTypeEnum::class)
                    ->required()
                    ->native(false),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->required()
                    ->maxLength(200)
                    ->rows(3)
                    ->helperText((string) __('fixcity::segnalazione.fields.content.helper.label')),
                FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('tickets/images')
                    ->maxFiles(10),
            ]),

        // SEZIONE 3: Autore (Infolist Entries per dati read-only)
        Section::make('autore')
            ->description((string) __('fixcity::segnalazione.sections.autore.description'))
            ->schema([
                TextEntry::make('author_name')
                    ->state(fn (): string => $this->getAuthUserName()),
                TextEntry::make('author_fiscal_code')
                    ->state(fn (): string => $this->getAuthUserFiscalCode()),
                TextEntry::make('author_phone')
                    ->state(fn (): string => $this->getAuthUserPhone()),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->helperText((string) __('fixcity::segnalazione.fields.email.helper.label')),
            ]),
    ];
}
```

### Struttura target getSummarySchema() (merge da 7-41)

```php
public function getSummarySchema(): array
{
    return [
        Section::make('review')
            ->schema([
                Grid::make(['default' => 1, 'lg' => 2])->schema([
                    TextEntry::make('review_name')
                        ->state(fn (Get $get): string => (string) ($get('name') ?? '')),
                    TextEntry::make('review_type')
                        ->state(function (Get $get): string {
                            $type = TicketTypeEnum::tryFrom((string) ($get('type') ?? ''));
                            return $type?->getLabel() ?? '';
                        })
                        ->badge(),
                    TextEntry::make('review_address')
                        ->state(fn (Get $get): string => (string) ($get('address') ?? ''))
                        ->columnSpanFull(),
                    TextEntry::make('review_content')
                        ->state(fn (Get $get): string => (string) ($get('content') ?? ''))
                        ->columnSpanFull()
                        ->limit(200),
                    TextEntry::make('review_email')
                        ->state(fn (Get $get): string => (string) ($get('email') ?? '')),
                ]),

                Section::make('images_review')
                    ->schema([
                        TextEntry::make('review_images_count')
                            ->state(function (Get $get): string {
                                $images = $get('images');
                                $count = is_array($images) ? count($images) : 0;
                                return trans_choice(
                                    'fixcity::ticket.messages.images_uploaded.text',
                                    $count,
                                );
                            }),
                    ])
                    ->collapsible()
                    ->collapsed(fn (Get $get): bool => ! is_array($get('images') ?? []) || count($get('images') ?? []) === 0),
            ]),
    ];
}
```

### Traduzioni da aggiungere

**it/segnalazione.php**:
```php
'sections' => [
    'luogo' => [
        'description' => 'Indica il luogo del disservizio',
    ],
    'disservizio' => [
        'label' => 'Disservizio',
    ],
    'autore' => [
        'description' => 'Informazione su di te',
    ],
],
'fields' => [
    'address' => [
        'label' => 'Cerca un luogo',
        'placeholder' => 'Cerca un luogo',
    ],
    'type' => [
        'label' => 'Tipo di disservizio',
    ],
    'name' => [
        'label' => 'Titolo',
    ],
    'content' => [
        'label' => 'Dettagli',
        'helper' => [
            'label' => 'Inserire al massimo 200 caratteri',
        ],
    ],
    'email' => [
        'helper' => [
            'label' => 'Opzionale — riceverai aggiornamenti sullo stato della segnalazione',
        ],
    ],
],
```

**it/ticket.php** (author section):
```php
'author' => [
    'name' => ['label' => 'Nome'],
    'fiscal_code' => ['label' => 'Codice Fiscale'],
    'phone' => ['label' => 'Telefono'],
],
```

---

## Testing

### Test manuale
1. Andare su `http://127.0.0.1:8001/it/tests/segnalazione-crea?step=2`
2. Verificare 3 sezioni visibili: Luogo, Disservizio, Autore
3. Verificare sezione Autore con stile read-only (non input fields)
4. Compilare form → andare a step 3 → verificare TextEntry invece di Placeholder
5. Cambiare lingua `/en/tests/segnalazione-crea?step=2` → verificare traduzioni

### Test PHPStan
```bash
cd laravel && php artisan analyze --path=Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php
```

### Test visuale (confronto con reference)
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- Local: http://127.0.0.1:8001/it/tests/segnalazione-crea?step=2

---

## Guardrails per il dev

- **NON** usare `Placeholder::make()` → è un Form Field disabilitato, usare `TextEntry::make()`
- **NON** usare `->label()` hardcoded → LangServiceProvider auto-applica
- **NON** usare `$this->data['field']` nelle closure → usare `fn(Get $get)`
- **NON** usare `ImageEntry` nel summary pre-submit → il record non esiste ancora, usare TextEntry per conteggio
- **NON** duplicare traduzioni → namespace `fixcity::segnalazione.sections.*` e `fixcity::segnalazione.fields.*`
- **MANTENERE** i metodi `getAuthUserName()`, `getAuthUserFiscalCode()`, `getAuthUserPhone()` (già esistenti nel widget)

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Design Comuni reference | https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html |
| Filament Infolists overview | https://filamentphp.com/docs/5.x/infolists/overview |
| Filament TextEntry | https://filamentphp.com/docs/5.x/infolists/entries/text |
| Location Spinner UX (GPS) | `Modules/Geo/docs/location-spinner-ux.md` |
| Ticket Wizard Frontoffice | `Modules/Fixcity/docs/ticket-wizard-frontoffice.md` |
| Story 7-41 (step3 Infolist) | `_bmad-output/implementation-artifacts/7-41-create-ticket-wizard-step3-infolist-summary.md` |

---

## Related Stories

| Story | Status | Relazione |
|-------|--------|-----------|
| 7-36 (geolocation GPS) | ready-for-dev | Fornisce AddressInput con spinner |
| 7-41 (step3 Infolist) | ready-for-dev | Merge: questa story include step3 Infolist |
| 7-9 (02-dati parity) | in-progress | Parent HTML parity |
