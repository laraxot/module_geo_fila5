# Correzioni PHPStan - Sessione Filament v4 Migration

**Data**: 1 Ottobre 2025  
**Obiettivo**: Portare tutti i moduli a PHPStan Level 9/10 compliance  
**Stato**: In Corso

## Correzioni Implementate

### 1. ✅ BaseUser.php - Syntax Error
**File**: `Modules/User/app/Models/BaseUser.php`  
**Problema**: Blocchi di codice orfani (senza dichiarazione di metodo) alle righe 377-419  
**Soluzione**: Rimosso completamente il codice orfano  
**Impatto**: Eliminati 7 errori di sintassi che bloccavano l'analisi PHPStan

### 2. ✅ GDPR Resources - getTableColumns() Removal
**Files**:
- `Modules/Gdpr/app/Filament/Resources/ConsentResource.php`
- `Modules/Gdpr/app/Filament/Resources/TreatmentResource.php`

**Problema**: Metodo `getTableColumns()` non dovrebbe esistere nei Resource che estendono `XotBaseResource`  
**Soluzione**: Rimossi entrambi i metodi  
**Motivo**: XotBaseResource gestisce automaticamente la tabella tramite il suo trait `HasXotTable`

### 3. ✅ AI Pages - navigationIcon Property Removal
**Files**:
- `Modules/AI/app/Filament/Pages/Completion.php`
- `Modules/AI/app/Filament/Pages/Dashboard.php`

**Problema**: Proprietà `navigationIcon` non dovrebbe esistere nelle Page che estendono `XotBasePage`  
**Soluzione**: Rimossa la proprietà `protected static string|\BackedEnum|null $navigationIcon`  
**Motivo**: XotBasePage gestisce automaticamente icone di navigazione tramite traduzioni

## Regole Consolidate

### ❌ MAI Fare

1. **Non estendere MAI classi Filament direttamente**
   ```php
   // ❌ ERRATO
   use Filament\Resources\Resource;
   class MyResource extends Resource { }
   
   // ✅ CORRETTO
   use Modules\Xot\Filament\Resources\XotBaseResource;
   class MyResource extends XotBaseResource { }
   ```

2. **Non usare MAI getTableColumns() nei Resource XotBase**
   ```php
   // ❌ ERRATO
   class MyResource extends XotBaseResource {
       public function getTableColumns(): array { ... }
   }
   
   // ✅ CORRETTO
   class MyResource extends XotBaseResource {
       // XotBase gestisce tutto automaticamente
   }
   ```

3. **Non dichiarare MAI navigationIcon/title/navigationLabel in XotBasePage**
   ```php
   // ❌ ERRATO
   class MyPage extends XotBasePage {
       protected static ?string $navigationIcon = 'heroicon-o-home';
       protected static ?string $title = 'My Title';
   }
   
   // ✅ CORRETTO
   class MyPage extends XotBasePage {
       // XotBasePage gestisce tutto tramite traduzioni
   }
   ```

4. **Non usare MAI ->label() / ->placeholder() / ->tooltip()**
   ```php
   // ❌ ERRATO
   TextInput::make('name')->label('Nome')
   
   // ✅ CORRETTO
   TextInput::make('name') // LangServiceProvider gestisce automaticamente
   ```

5. **Non usare MAI BadgeColumn (deprecato)**
   ```php
   // ❌ ERRATO
   BadgeColumn::make('status')
   
   // ✅ CORRETTO
   TextColumn::make('status')->badge()
   ```

### ✅ Sempre Fare

1. **Estendere sempre le classi XotBase appropriate**
   - Resources → `XotBaseResource`
   - Pages → `XotBasePage`
   - Widgets → `XotBaseWidget`
   - Service Providers → `XotBaseServiceProvider`
   - Migrations → `XotBaseMigration`

2. **Utilizzare sempre file di traduzione**
   - Struttura: `Modules/{Module}/lang/{locale}/{resource}.php`
   - Pattern chiavi: `{module}::{resource}.fields.{field}.{type}`

3. **Utilizzare sempre Actions invece di Services**
   - Preferire Spatie QueueableActions: https://github.com/spatie/laravel-queueable-action

4. **Dichiarare sempre strict types**
   ```php
   <?php
   declare(strict_types=1);
   ```

## Errori Rimanenti da Correggere

### Modulo Xot (9 errori)
1. `XotData.php:103` - isSuperAdmin() non definito in ProfileContract
2. `MainDashboard.php:44,48` - Accesso a proprietà $name non definita
3. `XotBasePage.php:127` - getModel() return type mismatch
4. `XotBaseRelationManager.php:107,119,124` - Vari problemi con method calls
5. `XotBaseResource.php:98` - Parameter type mismatch in components()
6. `XotBaseServiceProvider.php:190` - Dead catch block

### Altri Moduli
- Da analizzare sistematicamente

## Performance PHPStan

- **Modulo Xot**: 763 file → ~15 secondi
- **Tutti i moduli**: 4049 file → ~180 secondi (timeout)
- **Strategia**: Analizzare un modulo alla volta

## Prossimi Step

1. Correggere i 9 errori rimanenti in Xot
2. Analizzare modulo Fixcity
3. Analizzare modulo User (già corretto BaseUser)
4. Analizzare moduli UI, Cms, Tenant
5. Documentare tutte le correzioni nei docs dei moduli
6. Aggiornare memories e rules

## Collegamenti

- [PHPStan Analysis](./phpstan.md)
- [Filament v4 Upgrade Guide](https://filamentphp.com/docs/4.x/upgrade-guide)
- [Xot Module Docs](../../Modules/Xot/docs/README.md)
- [GDPR Module Docs](../../Modules/Gdpr/docs/README.md)
- [AI Module Docs](../../Modules/AI/docs/README.md)


