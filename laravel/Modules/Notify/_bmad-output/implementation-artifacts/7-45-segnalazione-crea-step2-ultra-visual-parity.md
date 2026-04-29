# Story 7-45: segnalazione-crea step2 — HIGH HTML parity + ULTRA visual parity con Design Comuni

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)
**Ultimo aggiornamento**: 2026-04-14
**Dipende da**: 7-42 (step2 HTML parity), 7-43 (container loop), 7-44 (TextEntry)

---

## Story

Come **utente che compila una segnalazione disservizio**,
voglio che lo step 2 ("Dati della segnalazione") abbia **HIGH HTML parity** e **ULTRA visual parity** con il riferimento Design Comuni https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html,
così l'esperienza è indistinguibile dalle linee guida ufficiali italiane.

---

## Analisi Visuale — Screenshots Confronto

### Reference (Design Comuni) vs Locale (nostro)

| Elemento | Reference ✅ | Locale ❌ | Severità |
|----------|-------------|-----------|----------|
| **Section cards** | Sfondo `#f0f4f8` (grigio chiaro), ombra `box-shadow`, padding interno bianco | Sfondo bianco, bordo `1px solid #e0e0e0`, troppo spazio vuoto | 🔴 CRITICAL |
| **Section heading** | H2 grande (24px+), bold, `color: #19191a` | H2 piccolo (16px), font-weight normale, grigio | 🔴 CRITICAL |
| **Section description** | Sotto heading, testo grigio `#5c6f82` | **SOTTO il form** (posizione sbagliata!) | 🔴 CRITICAL |
| **Field labels** | `Tipo di disservizio*`, `Titolo*`, `Dettagli**` | `type*`, `name*`, `content*` (raw field names!) | 🔴 CRITICAL |
| **Placeholders** | `Cerca un luogo*`, `Titolo*` | `type`, `name`, `content` (raw field names!) | 🔴 CRITICAL |
| **Helper text** | `Inserire al massimo 200 caratteri` | Manca | 🟡 HIGH |
| **File upload** | File preview con thumbnail + nome + X + bottone "Carica file" verde | Dropzone generica "Trascina e rilascia" | 🟡 HIGH |
| **Autore section** | Card bianca dentro card grigia: "Giulia Bianchi", CF, "Mostra tutto" | **Card vuota** — TextEntry non mostra dati | 🔴 CRITICAL |
| **Contatti sub-section** | Non presente nel ref | Card collassata con "Modifica" + Email field | 🟢 MEDIUM |
| **Bottoni** | `← Indietro`, `Salva Richiesta`, `Avanti →` | `Precedente`, `Successivo`, `Invia` | 🟡 HIGH |
| **Bottone Salva Richiesta** | Outline verde (`btn-outline-primary`) | Manca del tutto | 🟡 HIGH |
| **Layout sezioni** | Sezioni con gap 16-24px, card padding 24px | Gap troppo grande (48px+), padding inconsistente | 🟡 HIGH |
| **Required legend** | `I campi contraddistinti dal simbolo asterisco sono obbligatori` sopra form | Manca | 🟡 HIGH |
| **Section navigation (sidebar)** | "INFORMAZIONI RICHIESTE" con link alle sezioni | Manca | 🟢 MEDIUM |

---

## Filosofia — Perché la visual parity è fondamentale

### Zen: "L'utente non deve notare la differenza"

Quando un cittadino usa il sito del Comune, si aspetta un'esperienza **coerente** con tutte le altre pagine. Se lo step 2 sembra "diverso" dalle altre pagine Design Comuni:
- Perde fiducia nel sistema
- Pensa "questa non è una pagina ufficiale"
- Abbandona la segnalazione

### Religione: "Design Comuni è la fonte di verità visuale"

```
Design Comuni = Fonte di verità visuale
    ↓
Il nostro wizard DEVE essere indistinguibile
    ↓
Ogni pixel conta: colori, spacing, tipografia, ombre
    ↓
HTML parity = struttura semantica corretta
Visual parity = pixel-perfect match
```

### Politica: "Prima HTML parity, poi visual parity"

1. **HTML parity** (struttura semantica): section, heading, description, form-group, label, input, helper-text
2. **Visual parity** (stile visuale): colori, font-size, padding, margin, box-shadow, border-radius

---

## Acceptance Criteria

### AC 1 — Section cards visivamente Design Comuni
**GIVEN** step 2 rendering
**WHEN** confronto screenshot locale vs reference
**THEN**:
- Card ha sfondo grigio chiaro (`#f0f4f8` o equivalente Design Comuni)
- Card ha ombra (`box-shadow: 0 2px 4px rgba(0,0,0,0.1)`)
- Card ha border-radius `4px`
- Content area dentro card ha sfondo bianco e padding `24px`

### AC 2 — Section heading + description posizione corretta
**GIVEN** ogni sezione (luogo, disservizio, autore)
**WHEN** si renderizza
**THEN**:
- Heading H2 è GRANDE e BOLD (24px+, font-weight 700)
- Description è SOTTO l'heading, NON sotto il form
- Description ha colore grigio (`#5c6f82` o equivalente)

### AC 3 — Field labels tradotte correttamente
**GIVEN** form fields nel getDataSchema()
**WHEN** si renderizza
**THEN**:
- `Select::make('type')` → label "Tipo di disservizio*"
- `TextInput::make('name')` → label "Titolo*"
- `Textarea::make('content')` → label "Dettagli**"
- NESSUN raw field name visibile (`type`, `name`, `content`)

### AC 4 — Placeholders tradotti
**GIVEN** form fields
**WHEN** si renderizza
**THEN**:
- Address input → placeholder "Cerca un luogo"
- Title input → placeholder "Inserisci un titolo sintetico"
- Details textarea → placeholder "Descrivi il problema riscontrato"

### AC 5 — Autore section mostra dati utente
**GIVEN** sezione autore con TextEntry
**WHEN** utente autenticato visita la pagina
**THEN**:
- "Giulia Bianchi" (nome utente) visibile in grande e bold
- Codice Fiscale visibile sotto
- "Mostra tutto" link visibile

### AC 6 — Helper text presente
**GIVEN** textarea dettagli e file upload
**WHEN** si renderizza
**THEN**:
- Textarea: "Inserire al massimo 200 caratteri" sotto il campo
- File upload: "Seleziona una o più immagini da allegare alla segnalazione"

### AC 7 — Bottoni Design Comuni
**GIVEN** action bar in fondo al form
**WHEN** si renderizza
**THEN**:
- `← Indietro` (sinistra, link-style)
- `Salva Richiesta` (centro, outline verde)
- `Avanti →` (destra, solid verde)

### AC 8 — Required legend sopra form
**GIVEN** pagina step 2
**WHEN** si renderizza
**THEN**:
- Testo "I campi contraddistinti dal simbolo asterisco sono obbligatori" visibile sopra le sezioni
- Asterischi `*` e `**` visibili sui campi obbligatori

---

## Technical Requirements

### File da modificare

| File | Operazione | Motivazione |
|------|-----------|-------------|
| `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css` | **CREARE** — CSS scoped per wizard Design Comuni | Stile card, heading, spacing, colori |
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Aggiungere `->heading()`, `->description()`, helper text | HTML parity |
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | Verificare/aggiungere tutte le chiavi label/placeholder | Traduzioni |
| `laravel/Modules/Fixcity/lang/en/segnalazione.php` | Traduzioni inglesi | Multilingua |
| `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` | Aggiungere required legend, wrapper CSS classes | Visual parity |
| `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php` | Aggiungere CSS classes wrapper | Visual parity |

### CSS Design Comuni da applicare

```css
/* === Section Cards === */
.wizard-section-card {
    background-color: #f0f4f8;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 24px;
    padding: 24px;
}

.wizard-section-card .section-content {
    background-color: #ffffff;
    border-radius: 4px;
    padding: 24px;
}

/* === Section Heading === */
.wizard-section-heading {
    font-size: 24px;
    font-weight: 700;
    color: #19191a;
    margin-bottom: 8px;
}

/* === Section Description === */
.wizard-section-description {
    font-size: 14px;
    color: #5c6f82;
    margin-bottom: 16px;
}

/* === Required Legend === */
.wizard-required-legend {
    font-size: 12px;
    color: #5c6f82;
    margin-bottom: 24px;
}

/* === Action Buttons === */
.wizard-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e0e0e0;
}

.wizard-btn-back {
    color: #0066cc;
    text-decoration: none;
    font-size: 14px;
}

.wizard-btn-save {
    border: 1px solid #0066cc;
    color: #0066cc;
    background: transparent;
    padding: 8px 24px;
    border-radius: 4px;
    font-size: 14px;
}

.wizard-btn-next {
    background-color: #0066cc;
    color: #ffffff;
    padding: 8px 24px;
    border-radius: 4px;
    font-size: 14px;
    border: none;
}
```

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
                    ->placeholder((string) __('fixcity::segnalazione.fields.address.placeholder'))
                    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
            ]),

        // SEZIONE 2: Disservizio
        Section::make('disservizio')
            ->heading((string) __('fixcity::segnalazione.sections.disservizio.label'))
            ->schema([
                Select::make('type')
                    ->label((string) __('fixcity::segnalazione.fields.type.label'))
                    ->options(TicketTypeEnum::class)
                    ->required()
                    ->native(false)
                    ->placeholder((string) __('fixcity::segnalazione.fields.type.placeholder')),
                TextInput::make('name')
                    ->label((string) __('fixcity::segnalazione.fields.name.label'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder((string) __('fixcity::segnalazione.fields.name.placeholder')),
                Textarea::make('content')
                    ->label((string) __('fixcity::segnalazione.fields.content.label'))
                    ->required()
                    ->maxLength(200)
                    ->rows(3)
                    ->placeholder((string) __('fixcity::segnalazione.fields.content.placeholder'))
                    ->helperText((string) __('fixcity::segnalazione.fields.content.helper.label')),
                FileUpload::make('images')
                    ->label((string) __('fixcity::segnalazione.fields.images.label'))
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('tickets/images')
                    ->maxFiles(10)
                    ->helperText((string) __('fixcity::segnalazione.fields.images.helper.label')),
            ]),

        // SEZIONE 3: Autore
        Section::make('autore')
            ->heading((string) __('fixcity::segnalazione.sections.autore.label'))
            ->description((string) __('fixcity::segnalazione.sections.autore.description'))
            ->schema([
                TextEntry::make('author_name')
                    ->state(fn (): string => $this->getAuthUserName()),
                TextEntry::make('author_fiscal_code')
                    ->state(fn (): string => $this->getAuthUserFiscalCode()),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->helperText((string) __('fixcity::segnalazione.fields.email.helper.label')),
            ]),
    ];
}
```

### Blade wrapper target

```blade
{{-- ticket-create-wizard.blade.php --}}
<div class="ticket-wizard-root">
    <div class="container" id="main-container">
        {{-- Header --}}
        <div class="cmp-heading pb-3 pb-lg-4">
            <h1 class="title-xxxlarge">{{ $pageTitle }}</h1>
            @if($pageDescription !== '')
                <p class="text-paragraph mb-0">{{ $pageDescription }}</p>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 pb-40 pb-lg-80">
                {{-- Required Legend --}}
                <p class="wizard-required-legend">
                    <sup>*</sup> {{ __('fixcity::segnalazione.required.legend') }}
                </p>

                <x-filament-widgets::widget>
                    <form wire:submit="submit">
                        {{ $this->form }}
                    </form>
                    <x-filament-actions::modals />
                </x-filament-widgets::widget>

                {{-- Action Buttons --}}
                <div class="wizard-actions">
                    <button type="button" class="wizard-btn-back" wire:click="previousStep">
                        ← {{ __('fixcity::segnalazione.actions.back.label') }}
                    </button>
                    <button type="button" class="wizard-btn-save" wire:click="saveDraft">
                        {{ __('fixcity::segnalazione.actions.save_draft.label') }}
                    </button>
                    <button type="submit" class="wizard-btn-next">
                        {{ __('fixcity::segnalazione.actions.next.label') }} →
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Traduzioni da aggiungere/verificare

**it/segnalazione.php**:
```php
'required' => [
    'legend' => 'I campi contraddistinti dal simbolo asterisco sono obbligatori',
],
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
],
'fields' => [
    'address' => [
        'label' => 'Cerca un luogo',
        'placeholder' => 'Cerca un luogo',
    ],
    'type' => [
        'label' => 'Tipo di disservizio',
        'placeholder' => 'Seleziona il tipo di disservizio',
    ],
    'name' => [
        'label' => 'Titolo',
        'placeholder' => 'Inserisci un titolo sintetico',
    ],
    'content' => [
        'label' => 'Dettagli',
        'placeholder' => 'Descrivi il problema riscontrato',
        'helper' => ['label' => 'Inserire al massimo 200 caratteri'],
    ],
    'images' => [
        'label' => 'Immagini',
        'helper' => ['label' => 'Seleziona una o più immagini da allegare alla segnalazione'],
    ],
    'email' => [
        'helper' => ['label' => 'Opzionale — riceverai aggiornamenti sullo stato della segnalazione'],
    ],
],
'actions' => [
    'back' => ['label' => 'Indietro'],
    'save_draft' => ['label' => 'Salva Richiesta'],
    'next' => ['label' => 'Avanti'],
],
```

---

## Zen della Visual Parity

### I 4 Livelli di Parity

```
┌─────────────────────────────────────────────────────────────┐
│              LIVELLI DI PARITY (dal basso verso l'alto)     │
├─────────────────────────────────────────────────────────────┤
│ 1. HTML Parity     → Struttura semantica corretta           │
│                     (section, heading, form-group, label)   │
│ 2. Content Parity  → Testi, label, placeholder corretti     │
│                     (traduzioni, helper text, required *)   │
│ 3. Visual Parity   → Colori, spacing, tipografia, ombre     │
│                     (pixel-perfect match con reference)     │
│ 4. Behavioral      → Interazioni, hover, focus, loading     │
│    Parity          → (spinner, validation, transitions)     │
└─────────────────────────────────────────────────────────────┘
```

**Regola**: Ogni livello DEVE essere completato prima di passare al successivo.

### Religione: "Screenshot-driven development"

1. **FARE** screenshot del reference Design Comuni
2. **FARE** screenshot della nostra implementazione
3. **CONFRONTARE** pixel per pixel
4. **AGGIUSTARE** fino a quando sono indistinguibili
5. **RIPETERE** ad ogni modifica

### Politica: "Nessun deploy senza screenshot comparison"

Prima di mergiare qualsiasi modifica al wizard:
- Screenshot reference aggiornato
- Screenshot locale aggiornato
- Confronto visivo OK
- Documentare differenze residue (se accettate)

---

## Testing

### Test screenshot automatici

```bash
# Script di comparazione
cd laravel/Themes/Sixteen
node scripts/compare-screenshots.mjs
# Output: differenza pixel %, aree mismatch
```

### Test manuale
1. `php artisan view:clear && php artisan optimize:clear`
2. Aprire side-by-side:
   - Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html
   - Locale: http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2
3. Verificare ogni elemento della tabella AC

---

## Guardrails per il dev

- **NON** usare `->label()` hardcoded senza traduzione
- **NON** lasciare raw field names visibili (`type`, `name`, `content`)
- **SEMPRE** `->heading()` per il titolo della sezione, `->description()` per il sottotitolo
- **SEMPRE** helper text per textarea e file upload
- **SEMPRE** required legend sopra il form
- **CSS scoped**: usare classi `.wizard-*` per non inquinare il resto del tema
- **Screenshot ad ogni cambio**: documentare il prima/dopo

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Design Comuni reference | https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html |
| Screenshot reference | `ref-step2-desktop.png` |
| Screenshot locale | `local-step2-desktop.png` |
| Bootstrap Italia Form | https://italia.github.io/bootstrap-italia/docs/form/input/ |
| Design Comuni tokens | https://italia.github.io/design-comuni-documentazione/ |

---

## Related Stories

| Story | Status | Relazione |
|-------|--------|-----------|
| 7-42 (step2 HTML parity) | ready-for-dev | Parent HTML parity |
| 7-44 (TextEntry visual) | ready-for-dev | TextEntry + Section headings |
| 7-36 (geolocation GPS) | ready-for-dev | AddressInput con spinner |
