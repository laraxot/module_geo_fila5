# Story 7.31: Refactor address field a AddressInput (Geo) — NO Blade::render workaround

Status: ready-for-dev

## Story

Come **sviluppatore del modulo Fixcity**,
voglio sostituire il workaround `Blade::render('geo::filament.components.address-field')` con il componente Filament nativo `AddressInput::make('address')` del modulo Geo,
cosi da seguire la "Filament way" e il DRY, eliminando HTML hardcoded e Placeholder hack.

## Contesto

### Stato Attuale (SBAGLIATO)

In `CreateTicketWizardWidget.php`:
```php
protected function getAddressComponent(): Component
{
    return Placeholder::make('address_section')
        ->label('')
        ->content(new HtmlString(
            \Blade::render('geo::filament.components.address-field', [...])
        ));
}
```

Questo e un **workaround** che:
1. Usa `Placeholder` invece di un vero form component
2. Renderizza Blade HTML dentro un form Filament (anti-pattern)
3. Non si integra con il sistema di validazione Filament
4. Non segue il pattern `AddressInput::make('address')`

### Target (CORRETTO)

```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

// In makeStepData():
AddressInput::make('address')
    ->label((string) __('fixcity::segnalazione.fields.address.label'))
    ->placeholder((string) __('fixcity::segnalazione.fields.address.placeholder'))
    ->required()
    ->maxLength(255)
    ->geolocationEnabled(true)
    ->autocompleteProvider('nominatim'),
```

### Perché (Filosofia / Zen)

`AddressInput` e una classe PHP Filament Component che:
- **Estende TextInput** — si integra nativamente con Filament Forms
- **Ha suffix action** per geolocalizzazione — built-in, NON workaround
- **Ha autocomplete** — configurabile via provider (Nominatim, Google, Mapbox)
- **E riutilizzabile** — qualsiasi modulo lo usa con una riga di codice
- **Segue la Filament way** — component PHP, NON Blade::render hack

### Files coinvolti

- `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` — da refactorare
- `laravel/Modules/Geo/app/Filament/Forms/Components/AddressInput.php` — componente Geo esistente (gia corretto)

### Vincoli

1. **Nessuna modifica a Geo** — `AddressInput` e gia completo e funzionante
2. **Solo Fixcity cambia** — rimuove Placeholder hack, usa AddressInput nativo
3. **Traduzioni preservate** — label e placeholder restano `__('fixcity::segnalazione.*')`
4. **Geolocalizzazione funzionante** — AddressInput ha gia il pulsante "Usa la mia posizione"

## Acceptance Criteria

1. **AddressInput nativo**: Il widget usa `AddressInput::make('address')`, NON `Placeholder` + `Blade::render`
2. **Nessun Blade::render**: Rimosso completamente il workaround HTML
3. **Validazione preservata**: Il campo `address` e validato come prima (`required`, `max:255`)
4. **Geolocalizzazione funzionante**: Il pulsante "Usa la mia posizione" appare e funziona
5. **Autocomplete funzionante**: L'indirizzo si autocompleta via Nominatim
6. **Build finale**: Nessun errore PHPStan, lint, o runtime
7. **Documentazione aggiornata**: Module docs, Geo docs, QWEN.md con bidirectional links

## Tasks / Subtasks

### Task 1 — Refactor getAddressComponent a AddressInput (AC: 1, 2)
- [ ] Rimuovere metodo `getAddressComponent()` con Placeholder + Blade::render
- [ ] Aggiungere `use Modules\Geo\Filament\Forms\Components\AddressInput;` (gia importato, verificare)
- [ ] Sostituire `$this->getAddressComponent()` in `makeStepData()` con `AddressInput::make('address')`

### Task 2 — Configurare AddressInput (AC: 3, 4, 5)
- [ ] Impostare label: `__('fixcity::segnalazione.fields.address.label')`
- [ ] Impostare placeholder: `__('fixcity::segnalazione.fields.address.placeholder')`
- [ ] Abilitare geolocalizzazione: `->geolocationEnabled(true)`
- [ ] Impostare provider autocomplete: `->autocompleteProvider('nominatim')`
- [ ] Verificare che il pulsante "Usa la mia posizione" appaia

### Task 3 — Verifica e cleanup (AC: 6, 7)
- [ ] Rimuovere eventuali import non usati (HtmlString se non serve piu)
- [ ] Verificare PHPStan level 10 su Fixcity widget
- [ ] Testare pagina `/it/tests/segnalazione-crea` — HTTP 200
- [ ] Testare geolocalizzazione e autocomplete
- [ ] Aggiornare documentazione con bidirectional links

## Dev Notes

### AddressInput — Implementazione Geo

Il componente `AddressInput` esiste gia in `Modules/Geo/app/Filament/Forms/Components/AddressInput.php`:
- Estende `TextInput` (Filament)
- Ha suffix action per geolocalizzazione
- Ha configurazione provider autocomplete
- Ha sprite URL per icone Design Comuni

Usage:
```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Via, numero, città')
    ->required()
    ->maxLength(255)
    ->geolocationEnabled(true)
    ->autocompleteProvider('nominatim')
    ->spriteUrl('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
```

### Filosofia — Perché AddressInput, NON Blade::render

| Aspetto | AddressInput (CORRETTO) | Placeholder + Blade (SBAGLIATO) |
|---------|------------------------|--------------------------------|
| **Tipo** | Filament Form Component | HTML hack dentro Placeholder |
| **Validazione** | Nativa Filament | Manuale, separata |
| **Geolocalizzazione** | Built-in suffix action | Script inline Blade |
| **Autocomplete** | Configurabile via provider | Hardcoded nel Blade |
| **Riutilizzabilita** | 1 riga in qualsiasi modulo | Workaround da copiare |
| **Filament way** | ✅ SI | ❌ NO |

### Relazione con story precedenti

- `7-30-refactor-ticket-wizard-to-filament-pure.md` — Refactor blade a Filament puro
- `7-29-segnalazione-crea-header-stepper-responsive-multilingual.md` — Header/stepper parity

Questa story completa il refactor eliminando l'ultimo workaround Blade::render.

### References

- [Source: `laravel/Modules/Geo/app/Filament/Forms/Components/AddressInput.php`]
- [Source: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`]
- [Source: `laravel/Modules/Fixcity/docs/MODULE-BOUNDARY-PHILOSOPHY.md`]
- [Source: `laravel/Modules/Geo/docs/address-field-component.md`]

## Dev Agent Record

### Agent Model Used

qwen-code (Qwen Code CLI)

### Debug Log References

- Richiesta utente: "dovevi utilizzare AddressInput che doveva risiedere dentro Modules\Geo\Filament\Forms\Components\AddressInput"
- Widget attuale usa `Placeholder::make('address_section')` + `Blade::render('geo::filament.components.address-field')`
- `AddressInput` gia esiste e importato in widget (linea 24), ma NON usato

### Completion Notes List

- Story creata per refactor address field a AddressInput nativo
- Rimozione workaround Placeholder + Blade::render
- AddressInput gia completo in Geo — nessuna modifica a Geo necessaria
- Previsto aggiornamento documentazione con bidirectional links

### File List

- `_bmad-output/implementation-artifacts/7-31-use-addressinput-from-geo-module.md`
- `_bmad-output/implementation-artifacts/sprint-status.yaml`

## Change Log

| Data | Descrizione |
|------|-------------|
| 2026-04-12 | Creata story 7.31 per refactor address field: AddressInput::make('address') invece di Placeholder + Blade::render. Rimozione workaround, adozione Filament way nativa. |
