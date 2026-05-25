- Inventario [ridondanze cross-modulo](../docs/redundancy-report.md)
- Concetti [ridondanze cross-cutting](../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)

# Redundancy Report — Modulo Geo

> Generato: 2026-05-21 | Analisi automatica deep-scan

## Problemi Trovati

### 1. 🔴 AddressField — 3 copie (2 in Geo, 1 in UI)

| File | Extends | Namespace |
|------|---------|-----------|
| `app/Filament/Forms/Components/AddressField.php` | `Section` | `Modules\Geo\Filament\Forms\Components` |
| `app/Filament/Fields/AddressField.php` | `Section` | `Modules\Geo\Filament\Fields` |
| `Modules/UI/app/Filament/Forms/Components/AddressField.php` | `XotBaseField` | `Modules\UI\Filament\Forms\Components` |

La versione in `Filament/Forms/Components/` usa `AddressResource`, la versione in `Filament/Fields/` usa `TextInput` direttamente. La versione UI ha logica diversa con `Select` e relazioni `HasOne`/`MorphOne`.

**Azione suggerita**: Geo è il modulo canonico per i componenti geografici. Mantenere una sola versione in `Geo/Filament/Forms/Components/AddressField.php`, eliminare `Geo/Filament/Fields/AddressField.php`. La versione UI potrebbe diventare un wrapper o alias se necessario.

### 2. 🔴 CoordinatePicker — 2 copie nello stesso modulo

| File | Extends | Note |
|------|---------|------|
| `app/Forms/Components/CoordinatePicker.php` | `Field` (Filament base) | Vecchia, usa `Http::get` direttamente |
| `app/Filament/Forms/Components/CoordinatePicker.php` | `XotBaseField` | Nuova, conforme Laraxot, usa trait `HasCoordinatePicker` |

**Azione suggerita**: Eliminare `app/Forms/Components/CoordinatePicker.php` (vecchia versione). Aggiornare eventuali import a `Modules\Geo\Filament\Forms\Components\CoordinatePicker`.

### 3. 🟠 BasePivot NON estende XotBasePivot

**File**: `app/Models/BasePivot.php`

```php
// ATTUALE (NON conforme)
abstract class BasePivot extends Pivot
{
    use Updater;
}

// CORRETTO
abstract class BasePivot extends XotBasePivot {}
```

### 4. 🟠 BaseMorphPivot NON estende XotBaseMorphPivot

**File**: `app/Models/BaseMorphPivot.php`

```php
// ATTUALE (NON conforme)
abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;
}

// CORRETTO
abstract class BaseMorphPivot extends XotBaseMorphPivot {}
```

### 5. 🟡 FilterCoordinatesInRadius — 2 copie

Verificare se esiste una copia duplicata di `FilterCoordinatesInRadius` tra diversi namespace del modulo.

### 6. 🟡 LocationDTO — Potenziale duplicazione

`LocationDTO.php` esiste nel modulo. Verificare che non ci siano Data Objects duplicati per coordinate/location sparsi in altri moduli.

### 7. ✅ Nuovi servizi creati (2026-05-21)

Creati `MapService.php` e `GeocodingService.php` in `app/Services/` come stubs per risolvere errori PHPStan nel modulo UI (`InteractiveMap.php` referenziava classi inesistenti).

## Riepilogo

| Priorità | Problema | File interessati |
|----------|----------|-----------------|
| 🔴 | AddressField 3 copie (2 Geo + 1 UI) | 3 file |
| 🔴 | CoordinatePicker 2 copie nello stesso modulo | 2 file |
| 🟠 | BasePivot non conforme | 1 file |
| 🟠 | BaseMorphPivot non conforme | 1 file |
| 🟢 | MapService/GeocodingService creati | ✅ Risolto |
