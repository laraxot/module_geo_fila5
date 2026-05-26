# Riepilogo Regole Filament - PTVX

> **Current Stack**: Filament **v5** (Livewire v4 + Schemas). See canonical memory: `docs/wiki/memories/filament-version-policy.md`

## 🚨 Regole Critiche Aggiornate

### 1. Estensione Classi Filament

**MAI estendere direttamente classi Filament** - sempre usare classi `XotBase`:

- `Filament\Resources\Resource` → `Modules\Xot\Filament\Resources\XotBaseResource`
- `Filament\Pages\Page` → `Modules\Xot\Filament\Pages\XotBasePage`
- `Filament\Resources\Pages\CreateRecord` → `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- `Illuminate\Support\ServiceProvider` → `Modules\Xot\Providers\XotBaseServiceProvider`

**Eccezioni documentate**: Pagine di autenticazione (`Login`, `Register`, `EditProfile`, `PasswordExpired`)

### 2. Array con Chiavi Stringhe Obbligatorie

I seguenti metodi **DEVONO SEMPRE** restituire `array<string, ...>`:

- `getTableColumns()` → `array<string, Column>`; firma `public function`, mai `public static function`
- `getFormSchema()` → `array<string, Component>`
- `getTableBulkActions()` → `array<string, BulkAction>`
- `getTableActions()` → `array<string, Action>`
- `getTableFilters()` → `array<string, BaseFilter>`
- `getHeaderActions()` → `array<string, Action>`

**Pattern Corretto**:
```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')->sortable(),
        'name' => TextColumn::make('name')->searchable(),
    ];
}
```

**Pattern Errato**:
```php
// ❌ ERRATO - Array numerico
public function getTableColumns(): array
{
    return [
        TextColumn::make('id')->sortable(),
        TextColumn::make('name')->searchable(),
    ];
}
```

### 3. protected $casts Deprecato

**MAI usare `protected $casts`** - sempre usare il metodo `casts()`:

```php
// ❌ DEPRECATO
protected $casts = [
    'created_at' => 'datetime',
];

// ✅ CORRETTO
/**
 * Get the attributes that should be cast.
 *
 * @return array<string, string>
 */
protected function casts(): array
{
    return [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

### 4. Mixed Type: Solo come Ultima Spiaggia

Evitare `mixed` quando possibile. Preferire:
1. Union types (`string|int|null`)
2. Generics (`Collection<int, User>`)
3. Interfacce (`ArrayAccess`, `Iterator`)
4. Type assertions con PHPDoc (`@var`)

### 5. property_exists: MAI con Modelli Eloquent

**MAI usare `property_exists()`** con modelli Eloquent (attributi magici).

**Pattern Corretto**:
```php
// ✅ CORRETTO
if (isset($model->email)) {
    $email = $model->email;
}

// ✅ CORRETTO
$email = $model->email ?? 'default@example.com';
```

**Pattern Errato**:
```php
// ❌ ERRATO
if (property_exists($model, 'email')) {
    $email = $model->email; // Mai eseguito!
}
```

### 6. Traduzioni: NO Metodi Diretti

**MAI usare `->label()`, `->placeholder()`, `->tooltip()` direttamente**:

```php
// ❌ ERRATO
TextInput::make('name')
    ->label('Nome')
    ->placeholder('Inserisci nome')

// ✅ CORRETTO
TextInput::make('name')
// Le traduzioni sono gestite automaticamente da LangServiceProvider
```

### 7. Actions invece di Services

Preferire **Spatie Queueable Actions** invece di servizi tradizionali.

## Checklist Pre-Implementazione

Prima di creare una nuova classe Filament:

- [ ] Ho verificato quale classe XotBase estendere?
- [ ] Non sto estendendo direttamente classi Filament?
- [ ] I metodi get* restituiscono `array<string, ...>`?
- [ ] Non sto usando `property_exists()` con modelli?
- [ ] Sto evitando `mixed` quando possibile?
- [ ] Ho migrato da `protected $casts` a `casts()`?
- [ ] Sto usando file di traduzione invece di ->label()?
- [ ] Sto usando Actions invece di Services?

## Collegamenti

- [Filament Class Extension Rules](../.cursor/rules/filament-class-extension-rules.mdc)
- [Array Keys Rules](../.cursor/rules/array-keys-mixed-property-exists.mdc)
- [Model Property Rules](../.cursor/rules/model-property-rules.mdc)

---

*Ultimo aggiornamento: Dicembre 2025*
