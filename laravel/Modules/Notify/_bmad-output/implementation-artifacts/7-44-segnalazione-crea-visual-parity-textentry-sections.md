# Story 7-44: Increase Visual Parity — Section descriptions + TextEntry in Form schemas + multilang

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)
**Ultimo aggiornamento**: 2026-04-14
**Dipende da**: 7-42 (step2 HTML parity + Infolist author), 7-43 (container loop prevention)

---

## Story

Come **utente che compila una segnalazione disservizio**,
voglio che lo step 2 ("Dati della segnalazione") abbia **massima visual parity** con il riferimento Design Comuni https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html,
così l'esperienza è coerente con le linee guida ufficiali, con Section descriptions corrette, TextEntry per dati read-only, e multilingua completo it/en.

---

## Analisi — Gap Visuali Rimanenti

### Riferimento Design Comuni (segnalazione-02-dati.html)

| Elemento | Visual | CSS/Classe |
|----------|--------|------------|
| **Section LUOGO** | `<h2>LUOGO</h2>` + `<p>Indica il luogo del disservizio</p>` | `.form-group` con description sotto legend |
| **Section DISSERVIZIO** | `<h2>DISSERVIZIO</h2>` (nessuna description) | Campi: tipo*, titolo*, dettagli** |
| **Details helper** | `Inserire al massimo 200 caratteri` | `.form-text` sotto textarea |
| **File upload** | Label `Immagini` + filename + divider + bottone "Carica file" | `.upload-preview` |
| **Section AUTORE** | `<h2>AUTORE DELLA SEGNALAZIONE</h2>` + `<p>Informazione su di te</p>` | Read-only card |
| **Contatti sub-section** | `<h3>CONTATTI</h3>` + "Modifica" link | `<dl>/<dt>/<dd>` |
| **Required legend** | `I campi contraddistinti dal simbolo asterisco sono obbligatori` | Sopra il form |

### Implementazione Attuale (CreateTicketWizardWidget.php)

| Elemento | Stato | Gap |
|----------|-------|-----|
| Section::make('luogo') | ✅ Ha description | ⚠️ Description key potrebbe mancare in traduzioni |
| Section::make('disservizio') | ✅ OK | ⚠️ Manca helper text su textarea (200 char) |
| Section::make('autore') | ✅ Usa TextEntry | ⚠️ Manca sub-section "CONTATTI" |
| FileUpload images | ✅ OK | ⚠️ Helper text potrebbe mancare |
| Placeholder riepilogo (step 3) | ❌ Usa Placeholder | → Deve usare TextEntry (vedi sezione sotto) |

---

## Filosofia — Perché TextEntry nei Form Schemas (Filament v5)

### La Scoperta: Filament v5 ha un Sistema Schema Unificato

Filament v5 **unifica** Forms e Infolists sotto un singolo sistema **Schema**.

```
┌─────────────────────────────────────────────────────────────┐
│                    Schema (v5)                              │
│                                                             │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │ Form Fields   │  │ Infolist     │  │ Layout + Prime   │  │
│  │ (input)       │  │ Entries      │  │ Components       │  │
│  │               │  │ (read-only)  │  │                  │  │
│  │ TextInput     │  │ TextEntry    │  │ Section, Grid    │  │
│  │ Select        │  │ ImageEntry   │  │ Wizard, Tabs     │  │
│  │ Textarea      │  │ IconEntry    │  │ Text, Icon       │  │
│  │ FileUpload    │  │ KeyValueEntry│  │ Actions          │  │
│  │ Placeholder   │  │              │  │                  │  │
│  └──────────────┘  └──────────────┘  └──────────────────┘  │
│                                                             │
│  TUTTI possono essere mixati nello stesso schema[]          │
└─────────────────────────────────────────────────────────────┘
```

### Zen: "Non esistono più confini artificiali"

**PRIMA (v3/v4)**: Forms e Infolists erano sistemi separati. Non potevi mixarli.

**ORA (v5)**: Schema è il sistema unificato. **PUOI** usare TextEntry dentro un Form.

### Religione: "Usa il componente semanticamente corretto"

| Contesto | Componente | Perché |
|----------|-----------|--------|
| **Dato da INSERIRE** | `TextInput`, `Select`, `Textarea` | L'utente interagisce |
| **Dato da MOSTRARE** | `TextEntry` | Read-only, display only |
| **Testo statico** | `Text` (Prime) | Label, descrizione, helper |
| **Struttura** | `Section`, `Grid`, `Wizard` | Layout e organizzazione |

### Perché Placeholder è SBAGLIATO per dati read-only

```php
// ❌ Placeholder: è un "finto campo" - partecipa al form state
Placeholder::make('author_name')
    ->content(fn (): string => $this->getAuthUserName()),

// ✅ TextEntry: è dichiaratamente read-only - NON partecipa al form state
TextEntry::make('author_name')
    ->state(fn (): string => $this->getAuthUserName()),
```

**Placeholder**:
- È nel namespace `Filament\Forms\Components`
- Viene serializzato nel form state (anche se non dovrebbe)
- Dichiara "sono un campo" ma non raccoglie dati → **bugia semantica**

**TextEntry**:
- È nel namespace `Filament\Infolists\Components`
- NON viene serializzato nel form state
- Dichiara "sono display" → **verità semantica**
- Funziona dentro Form schemas in Filament v5 (Schema unificato)

### Politica del progetto

1. **Autore section (step 2)**: `TextEntry` per nome, CF, telefono. `TextInput` per email.
2. **Riepilogo (step 3)**: `TextEntry` per TUTTI i campi (è puro display).
3. **Mai `Placeholder`** per dati read-only — usare `TextEntry`.
4. **`Text` (Prime)** per testo statico/descrizioni che non sono dati.

---

## Acceptance Criteria

### AC 1 — Section descriptions visivamente parity
**GIVEN** step 2 rendering
**WHEN** confronto con reference
**THEN**:
- Sezione "LUOGO" ha description "Indica il luogo del disservizio" sotto il titolo
- Sezione "AUTORE DELLA SEGNALAZIONE" ha description "Informazione su di te"
- Helper text "Inserire al massimo 200 caratteri" sotto textarea dettagli
- Helper text sotto file upload immagini

### AC 2 — Author section usa TextEntry (non Placeholder)
**GIVEN** sezione `autore` nel getDataSchema()
**WHEN** si cerca `Placeholder` nel metodo
**THEN**: zero risultati — tutti i campi read-only usano `TextEntry`

### AC 3 — Step 3 riepilogo usa TextEntry (non Placeholder)
**GIVEN** getSummarySchema()
**WHEN** si cerca `Placeholder` nel metodo
**THEN**: zero risultati — tutti usano `TextEntry` con `fn(Get $get)`

### AC 4 — Multilingua completo
**GIVEN** wizard su `/it/tests/segnalazione-crea` e `/en/tests/segnalazione-crea`
**WHEN** si visitano entrambi
**THEN**: tutte le Section descriptions, helper text, e label sono tradotte

### AC 5 — Nessun loop o errore
**GIVEN** pagina `/it/tests/segnalazione-crea?step=2`
**WHEN** si carica
**THEN**: 200 OK in < 10s, nessun errore in laravel.log

---

## Technical Requirements

### File da modificare

| File | Operazione | Motivazione |
|------|-----------|-------------|
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Sostituire Placeholder con TextEntry, aggiungere helper text | Visual parity + semantica corretta |
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | Verificare/aggiungere tutte le chiavi | Multilingua |
| `laravel/Modules/Fixcity/lang/en/segnalazione.php` | Traduzioni inglesi | Multilingua |

### Struttura target getDataSchema()

```php
public function getDataSchema(): array
{
    return [
        // SEZIONE 1: Luogo
        Section::make('luogo')
            ->heading((string) __('fixcity::segnalazione.sections.luogo.label'))
            ->description((string) __('fixcity::segnalazione.sections.luogo.description'))
            ->schema([
                AddressInput::make('address')
                    ->required()
                    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
            ]),

        // SEZIONE 2: Disservizio
        Section::make('disservizio')
            ->heading((string) __('fixcity::segnalazione.sections.disservizio.label'))
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
                    ->maxFiles(10)
                    ->helperText((string) __('fixcity::segnalazione.fields.images.helper.label')),
            ]),

        // SEZIONE 3: Autore (TextEntry per read-only, TextInput per editabile)
        Section::make('autore')
            ->heading((string) __('fixcity::segnalazione.sections.autore.label'))
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

### Struttura target getSummarySchema() (step 3)

```php
public function getSummarySchema(): array
{
    return [
        Section::make('review')
            ->heading((string) __('fixcity::segnalazione.sections.review.label'))
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
                    ->heading((string) __('fixcity::segnalazione.sections.images_review.label'))
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

### Traduzioni da verificare/aggiungere

**it/segnalazione.php**:
```php
'sections' => [
    'luogo' => [
        'label' => 'LUOGO',
        'description' => 'Indica il luogo del disservizio',
    ],
    'disservizio' => [
        'label' => 'DISSERVIZIO',
    ],
    'autore' => [
        'label' => 'AUTORE DELLA SEGNALAZIONE',
        'description' => 'Informazione su di te',
    ],
    'review' => [
        'label' => 'RIEPILOGO',
    ],
    'images_review' => [
        'label' => 'IMMAGINI ALLEGATE',
    ],
],
'fields' => [
    'content' => [
        'helper' => ['label' => 'Inserire al massimo 200 caratteri'],
    ],
    'images' => [
        'helper' => ['label' => 'Seleziona una o più immagini da allegare alla segnalazione'],
    ],
    'email' => [
        'helper' => ['label' => 'Opzionale — riceverai aggiornamenti sullo stato della segnalazione'],
    ],
],
```

---

## Guardrails per il dev

- **TextEntry dentro Form schema**: ✅ CORRETTO in Filament v5 (Schema unificato)
- **Placeholder per read-only**: ❌ SBAGLIATO — usare TextEntry
- **`->heading()` vs `Section::make('key')`**: usare `->heading()` per il titolo visualizzato, il key rimane per traduzioni
- **`->description()`**: sempre da Filament translation namespace, mai hardcoded
- **`Get $get`**: meccanismo ufficiale per leggere stato form nelle closure
- **NON** usare `$this->data['field']` nelle closure — accoppiamento fragile
- **Clear cache** dopo modifiche: `php artisan view:clear && php artisan optimize:clear`

---

## Testing

### Test manuale
1. `php artisan view:clear && php artisan optimize:clear`
2. Andare su `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2`
3. Verificare 3 sezioni con heading e description
4. Verificare helper text sotto textarea e file upload
5. Verificare sezione autore con stile read-only (TextEntry, non input)
6. Andare a step 3 → verificare TextEntry invece di Placeholder
7. Cambiare lingua `/en/tests/segnalazione-crea` → verificare traduzioni

### Test PHPStan
```bash
cd laravel && phpstan analyse Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php --level=10
```

### Test visuale
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
- Local: http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Filament v5 Schema overview | https://filamentphp.com/docs/5.x/schemas/overview |
| Filament v5 TextEntry | https://filamentphp.com/docs/5.x/infolists/entries/text |
| Filament v5 Section | https://filamentphp.com/docs/5.x/schemas/layout/section |
| Design Comuni reference | https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html |
| Infolist for Summary (doc) | `laravel/Modules/Xot/docs/filament/widgets/infolist-for-summary.md` |
| Container Loop Prevention | `laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md` |

---

## Related Stories

| Story | Status | Relazione |
|-------|--------|-----------|
| 7-42 (step2 HTML parity) | ready-for-dev | Parent HTML parity |
| 7-43 (container loop) | ready-for-dev | Dipende: widget deve renderizzare |
| 7-41 (step3 Infolist) | ready-for-dev | Merge: questa story include step3 TextEntry |
