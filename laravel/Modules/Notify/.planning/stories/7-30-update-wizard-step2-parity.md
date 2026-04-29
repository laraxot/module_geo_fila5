# Story: Wizard Step 2 - Design Comuni Parity (3 Sections)

**Story ID**: `7-30-update-wizard-step2-parity`  
**Status**: Ready  
**Priority**: High  
**Category**: Frontend / Filament / Design Comuni  
**Module**: Fixcity  
**Theme**: Sixteen

---

## Context

**Current State**: `http://127.0.0.1:8001/it/tests/segnalazione-crea?step=2`
- Step 2 has a flat form with fields: name, type, content, email
- No section grouping, no section navigation
- Visual structure does not match Design Comuni reference

**Target State**: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- 3 grouped sections: Luogo, Disservizio, Autore della segnalazione
- Section navigation anchors (jump links)
- User card (infolists-style) for author section
- Multilingual support (no hardcoded Italian)

---

## User Story

**Come** utente che compila una segnalazione,  
**Voglio** vedere i campi organizzati in 3 sezioni chiare (Luogo, Disservizio, Autore),  
**Così da** capire facilmente quali dati inserire e navigare rapidamente tra le sezioni.

---

## Acceptance Criteria

### AC1 - HTML Structure Parity
- [ ] Step 2 schema contains 3 Sections: `luogo`, `disservizio`, `autore`
- [ ] Section navigation (anchor links) at top of step
- [ ] Each section has heading (`h3` class) and description paragraph
- [ ] Visual structure matches Bootstrap Italia layout classes

### AC2 - Sezione LUOGO
- [ ] AddressInput field with label "Cerca un luogo" (required `*`)
- [ ] Geolocation button "Usa la tua posizione" with spinner loading state
- [ ] Subsection description: "Indica il luogo del disservizio"

### AC3 - Sezione DISSERVIZIO
- [ ] Select field "Tipo di disservizio" (required `*`) → `TicketTypeEnum`
- [ ] Text input "Titolo" (required `*`, maxLength 255)
- [ ] Textarea "Dettagli" (required `*`, maxLength 200, rows 3)
- [ ] FileUpload "Immagini" (multiple, max 5 files, disk public)
- [ ] Max 200 chars helper text below textarea

### AC4 - Sezione AUTORE (Infolists Pattern)
- [ ] User info displayed as read-only card (Infolists/TextEntry, NOT form inputs)
- [ ] Shows: Nome, Codice Fiscale, Telefono, Email
- [ ] "Modifica" toggle to switch between read-only and edit mode
- [ ] Section description: "Informazione su di te"

### AC5 - Multilingual Support
- [ ] NO hardcoded Italian text in PHP code
- [ ] ALL labels/descriptions use translation keys: `__('fixcity::segnalazione.sections.luogo.label')` etc.
- [ ] Translation files updated for: `it`, `en`, `fr`, `de`, `es`

### AC6 - Visual Parity
- [ ] Section headings use `title-medium mb-1` class
- [ ] Section descriptions use `subtitle-small mb-0 text-paragraph` class
- [ ] Section wrapper uses `cmp-card mb-4` class
- [ ] Required field indicator `*` with explanatory text at top
- [ ] Submit/Next button uses `btn btn-primary mobile-full`

---

## Technical Details

### 1. Schema Structure (getFormSchema)

```php
public function getDataSchema(): array
{
    return [
        // Sezione Navigation (anchor links)
        Placeholder::make('section_nav')->content(view('fixcity::filament.partials.step2-section-nav')),

        // Sezione LUOGO
        Section::make(__('fixcity::segnalazione.sections.luogo.label'))
            ->description(__('fixcity::segnalazione.sections.luogo.description'))
            ->schema([
                AddressInput::make('address')
                    ->required()
                    ->spritePath('/themes/Sixteen/...'),
            ]),

        // Sezione DISSERVIZIO
        Section::make(__('fixcity::segnalazione.sections.disservizio.label'))
            ->schema([
                Select::make('type')->options(TicketTypeEnum::class)->required()->native(false),
                TextInput::make('title')->required()->maxLength(255),
                Textarea::make('details')->required()->maxLength(200)->rows(3)
                    ->helperText(__('fixcity::segnalazione.fields.details.helper_text')),
                FileUpload::make('images')->multiple()->image()->disk('public')->maxFiles(5),
            ]),

        // Sezione AUTORE (Infolists for read-only, toggle to edit)
        Section::make(__('fixcity::segnalazione.sections.autore.label'))
            ->description(__('fixcity::segnalazione.sections.autore.description'))
            ->schema([
                // Infolists read-only view (default)
                Infolist::make('author_info')
                    ->schema([
                        TextEntry::make('userName')->label(__('fixcity::segnalazione.fields.user_name.label')),
                        TextEntry::make('userFiscalCode')->label(__('fixcity::segnalazione.fields.user_fiscal_code.label')),
                        TextEntry::make('userPhone')->label(__('fixcity::segnalazione.fields.user_phone.label')),
                        TextEntry::make('email')->label(__('fixcity::segnalazione.fields.email.label')),
                    ])
                    ->hidden(fn (Get $get) => $get('edit_author') === true),

                // Editable fields (visible only when edit_author = true)
                TextInput::make('userName')
                    ->visible(fn (Get $get) => $get('edit_author') === true),
                TextInput::make('userFiscalCode')
                    ->visible(fn (Get $get) => $get('edit_author') === true),
                // ... other editable fields
            ]),
    ];
}
```

### 2. Translation Keys

**File**: `Modules/Fixcity/lang/it/segnalazione.php`
```php
'sections' => [
    'luogo' => [
        'label' => 'LUOGO',
        'description' => 'Indica il luogo del disservizio',
    ],
    'disservizio' => [
        'label' => 'DISSERVIZIO',
        'description' => 'Descrivi il disservizio che hai riscontrato',
    ],
    'autore' => [
        'label' => 'AUTORE DELLA SEGNALAZIONE',
        'description' => 'Informazione su di te',
    ],
],
'fields' => [
    'address' => ['label' => 'Cerca un luogo', 'placeholder' => 'Es. Via Roma 1, Milano'],
    'type' => ['label' => 'Tipo di disservizio'],
    'title' => ['label' => 'Titolo'],
    'details' => [
        'label' => 'Dettagli',
        'helper_text' => 'Inserire al massimo 200 caratteri',
    ],
    'images' => ['label' => 'Immagini'],
    'user_name' => ['label' => 'Nome e Cognome'],
    'user_fiscal_code' => ['label' => 'Codice Fiscale'],
    'user_phone' => ['label' => 'Telefono'],
    'email' => ['label' => 'Email'],
],
'actions' => [
    'use_my_location' => ['label' => 'Usa la tua posizione'],
    'edit_author' => ['label' => 'Modifica'],
    'show_all' => ['label' => 'Mostra tutto'],
],
```

### 3. Section Navigation Partial

**File**: `Modules/Fixcity/resources/views/filament/partials/step2-section-nav.blade.php`
```blade
{{-- Section Navigation - Design Comuni parity --}}
<nav class="section-nav mb-4" aria-label="Sezioni del form">
    <ul class="nav nav-pills">
        <li><a href="#section-luogo" class="nav-link">{{ __('fixcity::segnalazione.sections.luogo.label') }}</a></li>
        <li><a href="#section-disservizio" class="nav-link">{{ __('fixcity::segnalazione.sections.disservizio.label') }}</a></li>
        <li><a href="#section-autore" class="nav-link">{{ __('fixcity::segnalazione.sections.autore.label') }}</a></li>
    </ul>
</nav>
```

### 4. Author Section Toggle Logic

```php
// In mount()
$this->form->fill([
    'privacyAccepted' => false,
    'edit_author' => false,  // Toggle for author section edit mode
]);

// In getDataSchema()
Checkbox::make('edit_author')
    ->label(__('fixcity::segnalazione.actions.edit_author.label'))
    ->live()  // Triggers re-render when toggled
    ->dehydrated(false),
```

---

## Anti-Patterns (What NOT to do)

| ❌ WRONG | ✅ CORRECT | Why |
|---|---|---|
| Hardcoded Italian: `'label' => 'LUOGO'` | `__('fixcity::segnalazione.sections.luogo.label')` | Multilingual site |
| Flat form without sections | 3 Sections: Luogo, Disservizio, Autore | Design Comuni parity |
| Author fields as form inputs | Infolists TextEntry (read-only) + toggle to edit | UX pattern: display first, edit on demand |
| No section navigation | Section nav anchors at top | Design Comuni requires jump links |
| No required field indicator | `*` with explanatory text | Accessibility requirement |

---

## Files to Modify

| File | Change |
|---|---|
| `CreateTicketWizardWidget.php` | Update `getDataSchema()` with 3 sections |
| `segnalazione.php` (lang files) | Add section translation keys for it/en/fr/de/es |
| `step2-section-nav.blade.php` | CREATE new partial for section navigation |
| `ticket-create-wizard.blade.php` | Add required field indicator text |

---

## Dependencies

- Geo module's `AddressInput` component (already exists)
- `TicketTypeEnum` (already exists)
- Filament Infolists package (already installed)
- Bootstrap Italia CSS classes (theme provides)

---

## Testing Strategy

```php
// test_wizard_step2_has_3_sections()
it('renders wizard step 2 with 3 sections', function () {
    Livewire::test(CreateTicketWizardWidget::class)
        ->assertSee(__('fixcity::segnalazione.sections.luogo.label'))
        ->assertSee(__('fixcity::segnalazione.sections.disservizio.label'))
        ->assertSee(__('fixcity::segnalazione.sections.autore.label'));
});

// test_section_navigation_exists()
it('has section navigation anchors', function () {
    Livewire::test(CreateTicketWizardWidget::class)
        ->assertSeeHtml('href="#section-luogo"')
        ->assertSeeHtml('href="#section-disservizio"')
        ->assertSeeHtml('href="#section-autore"');
});

// test_author_section_uses_infolists()
it('displays author info as read-only by default', function () {
    // Verify TextEntry components are used, not TextInput
});
```

---

## Definition of Done

- [ ] All ACs pass
- [ ] Tests written and passing
- [ ] Translation files complete for all 5 languages
- [ ] Visual parity with Design Comuni reference verified
- [ ] No hardcoded Italian in PHP code
- [ ] Documentation updated (Fixcity docs)

---

*Created: 2026-04-14*
