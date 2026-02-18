---
name: phpstan-level10
description: Gestione completa PHPStan Level 10 per progetti Laravel/Laraxot. Installazione, configurazione, esecuzione analisi e risoluzione errori strict typing. Usare per errori PHPStan, analisi statica, quality gates o quando si richiede code quality.
---

# PHPStan Level 10 - Complete Workflow

## Scopo
Skill completa per gestire PHPStan Level 10 in progetti Laravel/Laraxot con approccio "Fix, Don't Ignore".

## Quando Usare
- Utente menziona errori PHPStan/Larastan
- Si richiede analisi statica o code quality
- Quality gates falliti in CI/CD
- Refactoring con validazione tipo
- Problemi di tipizzazione strict

---

## 🚀 Workflow Completo

### 1️⃣ **Context Discovery**
```bash
# Identifica contesto progetto (preferisci scope minimo)
rg --files -g "phpstan*.neon*" .
rg --files -g "Modules/*" laravel
pwd
```

### 2️⃣ **Verifica Installazione**
```bash
# Controlla dipendenze
rg "larastan/larastan" laravel/composer.json laravel/Modules/*/composer.json

# Verifica binary
rg --files -g "phpstan" laravel/vendor/bin

# Configurazioni disponibili
rg --files -g "phpstan*.neon*" laravel
```

### 3️⃣ **Analisi Targeted**
**Sempre iniziare dallo scope più ristretto:**
```bash
# File singolo (massima precisione)
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse path/to/file.php --level=10

# Modulo specifico (scope ottimale)
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName --level=10

# Directory specifica
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName/app/Models --level=10

# Full scan (solo come ultimo passo)
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10
```

### 4️⃣ **Risoluzione Errori - Pattern Comuni**

#### **Missing Return Types**
```php
// ❌ PRIMA
public function getUsers() {
    return User::all();
}

// ✅ DOPO
public function getUsers(): Collection {
    return User::all();
}
```

#### **Parameter Types**
```php
// ❌ PRIMA
public function processUser($userId, $data) {
    $user = User::find($userId);
    // ...
}

// ✅ DOPO
public function processUser(int $userId, array $data): User {
    $user = User::findOrFail($userId);
    // ...
    return $user;
}
```

#### **Array Shapes with PHPDoc**
```php
// ❌ PRIMA
public function createProfile($data) {
    // $data è array non tipizzato
}

// ✅ DOPO
/**
 * @param array{name: string, email: string, age?: int} $data
 */
public function createProfile(array $data): Profile {
    return Profile::create($data);
}
```

#### **Property Types**
```php
// ❌ PRIMA
class User {
    public $name;
    private $email;
}

// ✅ DOPO
class User {
    public string $name;
    private string $email;
}
```

#### **Generic Collections**
```php
// ❌ PRIMA
public function getActiveUsers() {
    return User::where('active', true)->get();
}

// ✅ DOPO
public function getActiveUsers(): Collection {
    return User::where('active', true)->get();
}

// Oppure con typed collection
/**
 * @return \Illuminate\Database\Eloquent\Collection<int, User>
 */
public function getActiveUsers(): Collection {
    return User::where('active', true)->get();
}
```

### 5️⃣ **Best Practices Laraxot**

#### **Module Pattern Compliance**
```php
// ✅ USE Repository Interface
$users = app(\Modules\User\Contracts\UserRepositoryInterface::class)->getActive();

// ❌ DIRECT Model usage
$users = \Modules\User\Models\User::where('active', true)->get();
```

#### **XotBase Wrapper Usage**
```php
// ✅ CORRECT - Use XotBaseResource
class UserResource extends XotBaseResource {
    // ...
}

// ❌ WRONG - Direct Filament extension
class UserResource extends Filament\Resources\Resource {
    // ...
}
```

#### **Action Pattern**
```php
// ✅ CORRECT - Spatie Queueable Action
class SendWelcomeEmail {
    use QueueableAction;
    
    public function execute(User $user): void {
        // ...
    }
}

// ❌ WRONG - Business logic in controller
public function store(Request $request) {
    // ... complex email logic ...
}
```

### 6️⃣ **Memory Management**
```bash
# Per analisi su codebase grandi
php -d memory_limit=4G ./vendor/bin/phpstan analyse Modules/Xot --level=10

# Parallel processing (disponibile in PHPStan 1.10+)
./vendor/bin/phpstan analyse --parallel
```

### 7️⃣ **Configurazione Modulo Standard**
```neon
# Modules/ModuleName/phpstan.neon.dist
parameters:
    level: 10
    paths:
        - app/
    
    excludePaths:
        - app/Enums/
        - database/factories/
        - database/seeders/
    
    ignoreErrors:
        # Solo se assolutamente necessario con commento dettagliato
        - '#Call to an undefined method.*#'
    
    checkGenericClassInNonGenericObjectType: false
    checkMissingIterableValueType: false
```

---

## 🔧 Script Utili

### **check_module.sh**
```bash
#!/bin/bash
MODULE=$1
cd laravel

echo "🔍 Analisi PHPStan Level 10 - Module: $MODULE"
echo "=================================="

# Check se modulo esiste
if [ ! -d "Modules/$MODULE" ]; then
    echo "❌ Modulo $MODULE non trovato"
    exit 1
fi

# Esegui analisi
php -d memory_limit=2G ./vendor/bin/phpstan analyse "Modules/$MODULE" --level=10 --error-format=table

# Report finale
if [ $? -eq 0 ]; then
    echo "✅ PHPStan Level 10 passed for $MODULE"
else
    echo "❌ PHPStan Level 10 failed for $MODULE"
    exit 1
fi
```

### **fix_all_modules.sh**
```bash
#!/bin/bash
cd laravel

echo "🚀 PHPStan Level 10 - All Modules Analysis"
echo "==========================================="

for module in Modules/*/; do
    if [ -d "$module" ]; then
        module_name=$(basename "$module")
        echo ""
        echo "📦 Analizzando: $module_name"
        echo "----------------------------------------"
        
        php -d memory_limit=2G ./vendor/bin/phpstan analyse "Modules/$module_name" --level=10 --no-progress --error-format=basic
        
        if [ $? -eq 0 ]; then
            echo "✅ $module_name: PASSED"
        else
            echo "❌ $module_name: FAILED"
        fi
    fi
done
```

---

## 📊 Quality Gates Integration

### **GitHub Actions**
```yaml
- name: PHPStan Level 10 Analysis
  run: |
    cd laravel
    php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10 --error-format=github
```

### **Pre-commit Hook**
```bash
#!/bin/sh
# .git/hooks/pre-commit
cd laravel
echo "🔍 PHPStan Level 10 pre-commit check"
php -d memory_limit=1G ./vendor/bin/phpstan analyse --level=10 --no-progress

if [ $? -ne 0 ]; then
    echo "❌ PHPStan Level 10 failed - Commit bloccato"
    exit 1
fi
```

---

## 🚨 Anti-Patterns da Evitare

### **❌ NON FARE MAI**
```bash
# Non ignorare errori senza motivo
./vendor/bin/phpstan analyse --level=0  # NO!

# Non modificare phpstan.neon per ridurre severità
# parameters:
#     level: 5  # NO! Mantieni Level 10

# Non usare @phpstan-ignore senza spiegazione dettagliata
/** @phpstan-ignore-next-line */  // NO! Spiega perché
```

### **✅ FARE SEMPRE**
```bash
# Analisi targeted
./vendor/bin/phpstan analyse Modules/User/app/Models/User.php --level=10

# Memory limit adeguato
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Xot --level=10

# Verifica post-fix
./vendor/bin/phpstan analyse Modules/User --level=10  # Rilancia dopo fix
```

---

## 📋 Quick Reference

### **Comandi Essenziali**
```bash
# Analisi modulo singolo
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/ModuleName --level=10

# Check specifico file
cd laravel && php -d memory_limit=1G ./vendor/bin/phpstan analyse app/Models/User.php --level=10

# Full project (ultima risorsa)
cd laravel && php -d memory_limit=4G ./vendor/bin/phpstan analyse --level=10

# Con output formattato
cd laravel && ./vendor/bin/phpstan analyse --level=10 --error-format=table
```

### **Pattern Fix Comuni**
1. **Missing types** → Aggiungi return type e parameter types
2. **Mixed types** → Sostituisci con tipi specifici o PHPDoc shapes
3. **Array senza shape** → Aggiungi PHPDoc con struttura array
4. **Generic collections** → Usa Collection tipizzate o PHPDoc

---

## 🎯 Checklist Operativa

**Prima di ogni commit:**
- [ ] PHPStan Level 10 passa su modified files
- [ ] Memory limit adeguato per analisi
- [ ] Error patterns identificati e fixati
- [ ] Nessun @phpstan-ignore senza spiegazione
- [ ] Repository pattern utilizzato correttamente

**Durante sviluppo:**
- [ ] Analisi targeted su singolo file/modulo
- [ ] Fix mantenendo business logic
- [ ] Test integration dopo fix
- [ ] Documentazione aggiornata se necessario

---

## 📚 Risorse Aggiuntive

- **[PHPStan Docs](https://phpstan.org/)** - Documentazione ufficiale
- **[Larastan Docs](https://github.com/larastan/larastan)** - Specifiche Laravel
- **[PTVX Architecture Guide](../../../docs/architecture.md)** - Pattern progetto
- **[Module Development Guide](../../../docs/module-development.md)** - Best practices

---

*Skill specializzata per PTVX Laraxot + PHPStan Level 10*