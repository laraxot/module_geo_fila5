# Story 7-46: segnalazione-crea step2 — HIGH HTML parity + ULTRA visual parity (sidebar leggibile, colonne corrette, header parity)

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)
**Ultimo aggiornamento**: 2026-04-14
**Dipende da**: 7-45 (visual parity CSS), 7-44 (TextEntry), 7-43 (container loop), 7-42 (HTML parity)

---

## Story

Come **utente che compila una segnalazione disservizio**,
voglio che lo step 2 ("Dati della segnalazione") abbia **HIGH HTML parity** e **ULTRA visual parity** con il riferimento Design Comuni, con sidebar sinistra leggibile, colonne proporzionate e header corretto,
così l'esperienza è indistinguibile dalle linee guida ufficiali.

---

## Analisi Gap — Screenshot Confronto

### Problemi CRITICI identificati (da screenshots reali)

| # | Problema | Severity | Reference ✅ | Locale ❌ |
|---|----------|----------|-------------|-----------|
| 1 | **Sidebar sinistra illeggibile** | 🔴 CRITICAL | Link verdi su sfondo bianco, font 14px | Testo invisibile, troppo piccolo, forse sovrapposto |
| 2 | **Colonne troppo strette** | 🔴 CRITICAL | ~700px contenuto principale | Colonna centrale ~400px, troppo spazio laterale |
| 3 | **Troppo spazio verticale** | 🟡 HIGH | Gap tra sezioni ~24px | Gap ~48-64px, troppo arioso |
| 4 | **Header "Accedi all'area personale"** | 🟡 HIGH | Testo bianco su sfondo verde, leggibile | Probabilmente non leggibile (colore/contrasto) |
| 5 | **Label raw field names** | 🔴 CRITICAL | "Tipo di disservizio*", "Titolo*" | `type*`, `name*`, `content*` (raw!) |
| 6 | **Description sotto il form** | 🔴 CRITICAL | Sotto heading sezione | SOTTO i campi del form |
| 7 | **Autore section vuota** | 🔴 CRITICAL | "Giulia Bianchi", CF visibili | Card vuote, TextEntry non renderizza |
| 8 | **Bottoni label sbagliate** | 🟡 HIGH | `← Indietro`, `Salva Richiesta`, `Avanti →` | `Precedente`, `Successivo`, `Invia` |
| 9 | **Manca required legend** | 🟡 HIGH | Presente sopra form | **ASSENTE** |
| 10 | **Section cards stile** | 🟡 HIGH | `#f0f4f8` + ombra | Bianco + bordo sottile |
| 11 | **No helper text textarea** | 🟢 MEDIUM | "Inserire al massimo 200 caratteri" | Manca |
| 12 | **No helper text immagini** | 🟢 MEDIUM | "Seleziona una o più immagini" | Manca |

---

## Zen — Perché Placeholder va sostituito con TextEntry

### Il Contratto Semantico di Filament v5 Schemas

```
┌─────────────────────────────────────────────────────────────┐
│                    Schema (v5) — UNIFICATO                  │
│                                                             │
│  Form Fields (input)    │  Infolist Entries (display)       │
│  TextInput              │  TextEntry ← USA QUESTO           │
│  Select                 │  ImageEntry                       │
│  Textarea               │  IconEntry                        │
│  FileUpload             │  KeyValueEntry                    │
│  Placeholder (DEPRECATED) │                                 │
└─────────────────────────────────────────────────────────────┘
```

### Religione: "Placeholder è DEPRECATED"

```php
// ❌ Placeholder: DEPRECATED, partecipa al form state
Placeholder::make('author_name')->content(fn() => $this->getAuthUserName()),

// ✅ TextEntry: CORRETTO, non partecipa al form state
TextEntry::make('author_name')->state(fn() => $this->getAuthUserName()),
```

**Perché**:
- `Placeholder` estende `TextEntry` ed è marcato `@deprecated` in Filament v5
- Placeholder partecipa al form state (è un "finto campo")
- TextEntry è dichiaratamente read-only
- TextEntry NON viene serializzato nel form state
- TextEntry è semanticamente onesto: "sono display", Placeholder mente

### Politica: "NEVER use ->label(), ->placeholder(), ->tooltip()"

**Regola**: Tutte le label, placeholder e tooltip devono venire da **LangServiceProvider** automaticamente.

```php
// ❌ SBAGLIATO: hardcoded
TextInput::make('name')
    ->label('Titolo')
    ->placeholder('Inserisci un titolo'),

// ✅ CORRETTO: auto-label via LangServiceProvider
TextInput::make('name')
    ->required()
    ->maxLength(255),
    // LangServiceProvider applica:
    // - label: fixcity::segnalazione.fields.title.label
    // - placeholder: fixcity::segnalazione.fields.title.placeholder
```

**Eccezione**: Quando serve `->placeholder()` esplicito per valori non standard (es. coordinate), ma MAI hardcoded — sempre da traduzione.

---

## Filosofia — DRY + KISS

### DRY (Don't Repeat Yourself)

- **NON** duplicare CSS già esistente in `segnalazione-wizard.css`
- **NON** duplicare traduzioni già in `segnalazione.php`
- **NON** creare nuovi file docs se esistono già (verificare indici)
- **USARE** CSS classes esistenti con overrides scoped

### KISS (Keep It Simple, Stupid)

- **NON** refactorare l'intero widget — solo le parti rotte
- **NON** cambiare architettura — solo fix visual
- **NON** aggiungere dipendenze — usare CSS/Filament esistenti
- **FARE** fix minimali che risolvono i gap

---

## Acceptance Criteria

### AC 1 — Sidebar sinistra leggibile
**GIVEN** step 2 con sidebar
**WHEN** confronto visivo
**THEN**:
- Sidebar ha sfondo bianco o molto chiaro
- Link sezione sono verdi (`#0066cc` o equivalente)
- Font-size almeno 14px
- Padding/margin coerenti con Design Comuni

### AC 2 — Colonne proporzionate
**GIVEN** layout pagina
**WHEN** confronto con reference
**THEN**:
- Colonna contenuto principale ~700px (non 400px)
- Spazio laterale ridotto (non eccessivo)
- Responsive: mobile 100% width

### AC 3 — Spazio verticale corretto
**GIVEN** sezioni form
**WHEN** rendering
**THEN**:
- Gap tra sezioni ~24px (non 48-64px)
- Padding interno sezioni coerente
- No whitespace eccessivo

### AC 4 — Header leggibile
**GIVEN** header pagina
**WHEN** rendering
**THEN**:
- "Accedi all'area personale" leggibile (contrasto corretto)
- Testo bianco su sfondo verde (#0066cc o #008758)
- Font-size e weight coerenti con Design Comuni

### AC 5 — Label tradotte (NO raw field names)
**GIVEN** form fields
**WHEN** rendering
**THEN**:
- `Select::make('type')` → "Tipo di disservizio*"
- `TextInput::make('name')` → "Titolo*"
- `Textarea::make('content')` → "Dettagli**"
- NESSUN raw field name visibile

### AC 6 — Description sotto heading
**GIVEN** sezioni con description
**WHEN** rendering
**THEN**:
- Description appare SOTTO l'heading sezione
- NON sotto i campi del form
- Colore grigio (`#5c6f82`)

### AC 7 — Autore section mostra dati
**GIVEN** sezione autore con TextEntry
**WHEN** utente autenticato
**THEN**:
- Nome utente visibile (es. "Giulia Bianchi")
- Codice Fiscale visibile
- Telefono visibile
- Stile read-only (non input fields)

### AC 8 — Bottoni Design Comuni
**GIVEN** action bar
**WHEN** rendering
**THEN**:
- `← Indietro` (sinistra, link-style blu)
- `Salva Richiesta` (centro, outline verde/blu)
- `Avanti →` (destra, solid verde/blu)

### AC 9 — Required legend presente
**GIVEN** pagina step 2
**WHEN** rendering
**THEN**:
- Testo "I campi contraddistinti dal simbolo asterisco sono obbligatori" visibile
- Posizione: sopra le sezioni form
- Font-size 12px, colore grigio

---

## Technical Requirements

### File da MODIFICARE (NO nuovi file — DRY)

| File | Operazione | Motivazione |
|------|-----------|-------------|
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Fix getDataSchema() labels/descriptions/TextEntry | Labels raw, description posizione, autore vuoto |
| `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css` | Aggiungere regole sidebar/colonne/spacing | Layout parity |
| `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` | Aggiungere required legend, action buttons | HTML parity |
| `laravel/Modules/Fixcity/lang/it/segnalazione.php` | Verificare chiavi esistenti | Multilingua |
| `laravel/Modules/Fixcity/lang/en/segnalazione.php` | Verificare traduzioni inglesi | Multilingua |

### File da NON CREARE (DRY — già esistono)

| File Esistente | Perché NON crearne uno nuovo |
|----------------|------------------------------|
| `segnalazione-wizard.css` | Già creato in story 7-45 — AGGIUNGERE regole |
| `segnalazione.php` (it/en) | Già completo — VERIFICARE chiavi |
| `ticket-create-wizard.blade.php` | Già esiste — MODIFICARE |
| `CreateTicketWizardWidget.php` | Già esiste — MODIFICARE |

---

## Implementazione Detail

### 1. Widget PHP — Fix getDataSchema()

**Problema**: Labels raw, description sotto form, TextEntry non renderizza

**Fix**:
```php
// PRIMA (sbagliato):
Section::make('type')  // raw field name
    ->schema([...])

// DOPO (corretto):
Section::make((string) __('fixcity::segnalazione.fields.inefficiency.section.label'))
    ->heading((string) __('fixcity::segnalazione.fields.inefficiency.section.label'))
    ->description((string) __('fixcity::segnalazione.fields.inefficiency.section.description'))
    ->schema([
        Select::make('type')
            ->label((string) __('fixcity::segnalazione.fields.type.label'))
            ->options(TicketTypeEnum::class)
            ->required()
            ->native(false)
            ->placeholder((string) __('fixcity::segnalazione.fields.type.placeholder')),
        // ...
    ])
```

### 2. CSS — Sidebar + Colonne + Spacing

**Aggiungere a `segnalazione-wizard.css`** (ESISTENTE — non creare nuovo):

```css
/* === Sidebar sinistra leggibile === */
.wizard-sidebar {
    background-color: #ffffff;
    min-width: 200px;
    padding: 16px;
}

.wizard-sidebar .sidebar-link {
    color: #0066cc;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: block;
    padding: 8px 0;
}

.wizard-sidebar .sidebar-link:hover {
    text-decoration: underline;
}

/* === Colonne proporzionate === */
.wizard-content-column {
    max-width: 700px;
    margin: 0 auto;
    width: 100%;
}

/* === Spacing verticale corretto === */
.wizard-section-card {
    margin-bottom: 24px;  /* NON 48px o più */
}

.wizard-section-card + .wizard-section-card {
    margin-top: 24px;
}

/* === Header leggibile === */
.wizard-header-user-link {
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
}

.wizard-header-user-link:hover {
    text-decoration: underline;
}
```

### 3. Blade — Required Legend + Action Buttons

**Modificare `ticket-create-wizard.blade.php`** (ESISTENTE):

```blade
{{-- Required Legend (AGGIUNGERE sopra le sezioni) --}}
<p class="wizard-required-legend">
    {{ __('fixcity::segnalazione.fields.required_note.label') }}
</p>

{{-- Action Buttons (SOSTITUIRE o AGGIUNGERE) --}}
<div class="wizard-actions">
    <button type="button" class="wizard-btn-back" wire:click="previousStep">
        ← {{ __('fixcity::segnalazione.actions.back.label') }}
    </button>
    <button type="button" class="wizard-btn-save" wire:click="saveDraft">
        {{ __('fixcity::segnalazione.fields.step.save_request.label') }}
    </button>
    <button type="button" class="wizard-btn-next" wire:click="nextStep">
        {{ __('fixcity::segnalazione.actions.next.label') }} →
    </button>
</div>
```

---

## Verifica Traduzioni Esistenti

**Prima di implementare**, verificare che le chiavi esistono:

```bash
# Verifica chiavi Italiane
grep -n "fields.type.label" Modules/Fixcity/lang/it/segnalazione.php
grep -n "fields.title.label" Modules/Fixcity/lang/it/segnalazione.php
grep -n "fields.details.label" Modules/Fixcity/lang/it/segnalazione.php
grep -n "actions.back.label" Modules/Fixcity/lang/it/segnalazione.php
grep -n "actions.next.label" Modules/Fixcity/lang/it/segnalazione.php
grep -n "fields.required_note.label" Modules/Fixcity/lang/it/segnalazione.php

# Verifica chiavi Inglesi
grep -n "fields.type.label" Modules/Fixcity/lang/en/segnalazione.php
```

**SE mancanti**: Aggiungere alle traduzioni esistenti, NON creare nuovo file.

---

## Testing

### Test Manuale

1. `php artisan view:clear && php artisan optimize:clear`
2. Aprire `http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2`
3. Verificare sidebar leggibile (testo verde visibile)
4. Verificare colonna contenuto ~700px
5. Verificare spazio tra sezioni ~24px
6. Verificare header "Accedi all'area personale" leggibile
7. Verificare label tradotte (NO `type*`, `name*`, `content*`)
8. Verificare description sotto heading
9. Verificare autore section con dati utente
10. Verificare bottoni "← Indietro", "Salva Richiesta", "Avanti →"
11. Verificare required legend sopra form

### Test Screenshot

```bash
# Screenshot locale
npx playwright screenshot --full-page http://127.0.0.1:8000/it/tests/segnalazione-crea?step=2 local-step2-fixed.png

# Confronto con reference
# Reference: ref-step2-desktop.png (già esiste)
```

### Quality Gates

```bash
cd laravel

# PHPStan Level 10
phpstan analyse Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php --level=10

# PHPMD
phpmd Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php text cleancode,codesize,controversial,design,naming,unusedcode

# PHPInsights
php artisan insights --preset=laravel

# Pest (se esistono test)
php artisan test --filter=CreateTicketWizard
```

---

## Guardrails per il dev

- **NON** usare `->label()` hardcoded — LangServiceProvider applica automaticamente
- **NON** usare `->placeholder()` hardcoded — usare traduzioni
- **NON** usare `->tooltip()` — Design Comuni non li usa
- **NON** creare nuovi file CSS — AGGIUNGERE a `segnalazione-wizard.css` esistente
- **NON** creare nuovi file di traduzione — AGGIUNGERE a `segnalazione.php` esistente
- **NON** refactorare l'intero widget — solo fix gap identificati
- **SEMPRE** `php artisan view:clear` dopo modifiche Blade
- **SEMPRE** screenshot comparison prima di commit
- **SEMPRE** PHPStan Level 10 pass

---

## Riferimenti

| Documento | URL/Path |
|-----------|----------|
| Design Comuni reference | https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html |
| Screenshot reference | `ref-step2-desktop.png` |
| Screenshot locale (broken) | `local-step2-desktop.png` |
| Filament v5 Schema | https://filamentphp.com/docs/5.x/schemas/overview |
| Filament v5 TextEntry | https://filamentphp.com/docs/5.x/infolists/entries/text |
| Wizard Visual Parity (doc) | `laravel/Modules/Fixcity/docs/wizard-visual-parity.md` |
| Filament Wizard Rules | `laravel/Modules/Fixcity/docs/rules/filament-wizard-rules.md` |
| Infolist for Summary | `laravel/Modules/Xot/docs/filament/widgets/infolist-for-summary.md` |
| CSS Wizard (esistente) | `laravel/Themes/Sixteen/resources/css/segnalazione-wizard.css` |
| Story 7-45 (visual parity) | `_bmad-output/implementation-artifacts/7-45-segnalazione-crea-step2-ultra-visual-parity.md` |

---

## Related Stories

| Story | Status | Relazione |
|-------|--------|-----------|
| 7-45 (ultra visual parity) | ready-for-dev | Parent visual parity CSS |
| 7-44 (TextEntry) | ready-for-dev | TextEntry vs Placeholder |
| 7-42 (HTML parity) | ready-for-dev | Parent HTML parity |
| 7-43 (container loop) | ready-for-dev | Loop prevention |

---

*Ultimo aggiornamento: 2026-04-14*
*Creato da: Qwen Code — BMad + GSD workflow*
