# Linee Guida per la Riusabilità del Modulo Notify

## Principio Fondamentale
Il modulo Notify è progettato per essere **completamente riutilizzabile** tra diversi progetti Laraxot. Questo significa che NON deve mai contenere riferimenti hardcoded a progetti specifici.

## Regole Critiche per la Riusabilità

### 1. NO Hardcoding di Nomi Progetti
❌ **MAI usare stringhe hardcoded di progetti specifici:**
```php
// ERRORE: Hardcoding del nome progetto
$user = \Modules\<nome progetto>\Models\User::factory()->create();
'database' => '<nome progetto>_test',
$this->app['config']->set('database.connections.<nome progetto>_test', [
<<<<<<< Updated upstream
$user = \Modules\Quaeris\Models\User::factory()->create();
'database' => 'Quaeris_test',
$this->app['config']->set('database.connections.Quaeris_test', [
=======
<<<<<<< HEAD
<<<<<<< HEAD
$user = \Modules\Laraxot\Models\User::factory()->create();
'database' => 'ptvx_test',
$this->app['config']->set('database.connections.ptvx_test', [
=======
$user = \Modules\healthcare_app\Models\User::factory()->create();
'database' => 'healthcare_app_test',
$this->app['config']->set('database.connections.healthcare_app_test', [
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
$user = \Modules\Quaeris\Models\User::factory()->create();
'database' => 'Quaeris_test',
$this->app['config']->set('database.connections.Quaeris_test', [
>>>>>>> origin/dev
>>>>>>> Stashed changes
```

✅ **SEMPRE utilizzare pattern riutilizzabili:**
```php
// CORRETTO: Utilizzo di XotData per ottenere la classe User del progetto corrente
$user = XotData::make()->getUserClass()::factory()->create();
$database = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$database}", [
```

### 2. Utilizzo di XotData per Classi Dynamic
Il modulo Notify deve utilizzare `XotData::make()->getUserClass()` per ottenere dinamicamente la classe User del progetto corrente:

```php
use Modules\Xot\Datas\XotData;

// Invece di: \Modules\<nome progetto>\Models\User::class
<<<<<<< Updated upstream
// Invece di: \Modules\Quaeris\Models\User::class
=======
<<<<<<< HEAD
<<<<<<< HEAD
// Invece di: \Modules\Laraxot\Models\User::class
=======
// Invece di: \Modules\healthcare_app\Models\User::class
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
// Invece di: \Modules\Quaeris\Models\User::class
>>>>>>> origin/dev
>>>>>>> Stashed changes
$userClass = XotData::make()->getUserClass();
$user = $userClass::factory()->create();
```

### 3. Configurazioni Database Dynamic
Per i test che richiedono configurazioni database specifiche:

```php
// Invece di: '<nome progetto>_test'
<<<<<<< Updated upstream
// Invece di: 'Quaeris_test'
=======
<<<<<<< HEAD
<<<<<<< HEAD
// Invece di: 'ptvx_test'
=======
// Invece di: 'healthcare_app_test'
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
// Invece di: 'Quaeris_test'
>>>>>>> origin/dev
>>>>>>> Stashed changes
$testDatabase = config('database.default') . '_test';
$this->app['config']->set("database.connections.{$testDatabase}", [
    // configurazione
]);
```

### 4. Pattern per Namespace Dynamic
Quando necessario riferirsi a modelli di altri moduli:

```php
// Per ottenere il namespace del progetto corrente
$projectNamespace = XotData::make()->getProjectNamespace();
$userModel = "{$projectNamespace}\\Models\\User";
```

## Anti-Pattern da Evitare

### ❌ Riferimenti Diretti a Progetti
```php
// VIETATO: Riferimenti hardcoded
use Modules\<nome progetto>\Models\User;
use Modules\<nome progetto>\Models\Patient;
'database' => '<nome progetto>_test'
$this->artisan('migrate', ['--database' => '<nome progetto>_test']);
<<<<<<< Updated upstream
=======
<<<<<<< HEAD
<<<<<<< HEAD
use Modules\Laraxot\Models\User;
use Modules\Laraxot\Models\Patient;
'database' => 'ptvx_test'
$this->artisan('migrate', ['--database' => 'ptvx_test']);
=======
use Modules\healthcare_app\Models\User;
use Modules\healthcare_app\Models\Patient;
'database' => 'healthcare_app_test'
$this->artisan('migrate', ['--database' => 'healthcare_app_test']);
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
>>>>>>> Stashed changes
use Modules\Quaeris\Models\User;
use Modules\Quaeris\Models\Patient;
'database' => 'Quaeris_test'
$this->artisan('migrate', ['--database' => 'Quaeris_test']);
<<<<<<< Updated upstream
=======
>>>>>>> origin/dev
>>>>>>> Stashed changes
```

### ❌ Configurazioni Project-Specific
```php
// VIETATO: Configurazioni specifiche del progetto
'app_name' => '<nome progetto>',
'tenant_model' => \Modules\<nome progetto>\Models\Studio::class,
<<<<<<< Updated upstream
'app_name' => 'Quaeris',
'tenant_model' => \Modules\Quaeris\Models\Studio::class,
=======
<<<<<<< HEAD
<<<<<<< HEAD
'app_name' => 'Laraxot',
'tenant_model' => \Modules\Laraxot\Models\Studio::class,
=======
'app_name' => 'healthcare_app',
'tenant_model' => \Modules\healthcare_app\Models\Studio::class,
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
'app_name' => 'Quaeris',
'tenant_model' => \Modules\Quaeris\Models\Studio::class,
>>>>>>> origin/dev
>>>>>>> Stashed changes
```

## Pattern Corretti per Riusabilità

### ✅ Utilizzo di Helper e Configuration
```php
// CORRETTO: Utilizzo di configurazioni dynamic
$appName = config('app.name');
$tenantModel = config('filament.tenancy.tenant_model');
$userClass = XotData::make()->getUserClass();
```

### ✅ Test Configurabili
```php
// CORRETTO: Test che si adattano al progetto corrente
public function setUp(): void
{
    parent::setUp();
    
    $this->userClass = XotData::make()->getUserClass();
    $this->testDatabase = config('database.default') . '_test';
    
    // Configurazione dynamic
    $this->app['config']->set("database.connections.{$this->testDatabase}", [
        'driver' => 'sqlite',
        'database' => ':memory:',
    ]);
}
```

### ✅ Factory Pattern Riutilizzabili
```php
// CORRETTO: Factory che si adatta al progetto
protected function createTestUser(): mixed
{
    $userClass = XotData::make()->getUserClass();
    return $userClass::factory()->create([
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
}
```

## Checklist per Moduli Riutilizzabili

Prima di committare modifiche al modulo Notify:

- [ ] Nessun riferimento hardcoded a "<nome progetto>" o altri nomi di progetti
<<<<<<< Updated upstream
- [ ] Nessun riferimento hardcoded a "Quaeris" o altri nomi di progetti
=======
<<<<<<< HEAD
<<<<<<< HEAD
- [ ] Nessun riferimento hardcoded a "ptvx" o altri nomi di progetti
=======
- [ ] Nessun riferimento hardcoded a "healthcare_app" o altri nomi di progetti
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
- [ ] Nessun riferimento hardcoded a "Quaeris" o altri nomi di progetti
>>>>>>> origin/dev
>>>>>>> Stashed changes
- [ ] Utilizzo di `XotData::make()->getUserClass()` per la classe User
- [ ] Configurazioni database dinamiche nei test
- [ ] Nessun import diretto di modelli da altri progetti
- [ ] Traduzioni generiche senza riferimenti a progetti specifici
- [ ] Documentazione che non menziona progetti specifici
- [ ] Test che funzionano indipendentemente dal progetto host

## Testing della Riusabilità

Per verificare che il modulo sia veramente riutilizzabile:

```bash
# Cerca hardcoding di nomi progetti
grep -r -i "<nome progetto>\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
<<<<<<< Updated upstream
grep -r -i "Quaeris\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
=======
<<<<<<< HEAD
<<<<<<< HEAD
grep -r -i "ptvx\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
=======
grep -r -i "healthcare_app\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
grep -r -i "Quaeris\|salutemo\|dentalpro" Modules/Notify/ --exclude-dir=vendor
>>>>>>> origin/dev
>>>>>>> Stashed changes

# Cerca import diretti da altri moduli
grep -r "use Modules\\\\[^N][^o][^t][^i][^f][^y]" Modules/Notify/

# Cerca configurazioni hardcoded
grep -r "database.*<nome progetto>\|app.*<nome progetto>" Modules/Notify/
<<<<<<< Updated upstream
grep -r "database.*Quaeris\|app.*Quaeris" Modules/Notify/
=======
<<<<<<< HEAD
<<<<<<< HEAD
grep -r "database.*ptvx\|app.*ptvx" Modules/Notify/
=======
grep -r "database.*healthcare_app\|app.*healthcare_app" Modules/Notify/
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
=======
grep -r "database.*Quaeris\|app.*Quaeris" Modules/Notify/
>>>>>>> origin/dev
>>>>>>> Stashed changes
```

## Benefici della Riusabilità

1. **Portabilità**: Il modulo può essere utilizzato in qualsiasi progetto Laraxot
2. **Manutenibilità**: Un solo codebase da mantenere per tutti i progetti
3. **Coerenza**: Comportamento uniforme delle notifiche tra progetti
4. **Efficienza**: Evita duplicazione di codice e logica
5. **Scalabilità**: Facilita l'aggiunta di nuovi progetti

## Collegamenti

- [../../../../docs/module_reusability_guidelines.md](../../../../docs/module_reusability_guidelines.md)
- [../../Xot/docs/xotdata_usage.md](../../Xot/docs/xotdata_usage.md)
- [testing_best_practices.md](testing_best_practices.md)

*Ultimo aggiornamento: gennaio 2025*
