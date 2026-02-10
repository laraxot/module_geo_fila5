# Architectural Rules & Guidelines

Questo modulo aderisce alla **Laraxot Architecture** e **Super Cow Methodology** con particolare attenzione a **PHPStan Level 10 compliance**.

Per strict coding standards, Filament extension rules, e PHPStan guidelines, fare riferimento alla documentazione centrale nel **Xot Module**:

-   [Super Cow Methodology](../../Xot/docs/super_cow_methodology.md)
-   [PHP Quality Guide](../../Xot/docs/php_quality_guide.md)
-   [Filament Extension Rules](../../Xot/docs/filament_extension_rules.md)

---

## 🚨 **PHPStan Level 10 - REGOLE CRITICHE**

### **Stato Attuale: 126 Errori - CRITICAL**

### 📋 **PHPStan Rules Specifiche per Lang Module**

#### **1. Type Declarations - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - Mixed types
public function getTranslatableLocales()
{
    return $this->locales; // mixed
}

// ✅ CORRETTO - Explicit return type
public function getTranslatableLocales(): array
{
    return is_array($this->locales) ? $this->locales : [];
}
```

#### **2. Method Return Types - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - No return type
public function getRecord()
{
    return $this->record;
}

// ✅ CORRETTO - Explicit return type
public function getRecord(): Model
{
    if (!$this->record instanceof Model) {
        throw new \RuntimeException('Record not found or invalid type');
    }
    
    return $this->record;
}
```

#### **3. Parameter Type Safety - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - Mixed parameter
public function processTranslations($translations)
{
    foreach ($translations as $locale => $value) {
        // ...
    }
}

// ✅ CORRETTO - Explicit parameter type
public function processTranslations(array $translations): void
{
    foreach ($translations as $locale => $value) {
        if (!is_string($locale) || !is_string($value)) {
            continue;
        }
        // ...
    }
}
```

#### **4. Array Access Safety - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - Unsafe array access
public function getLocaleLabel($locale)
{
    return $this->labels[$locale]; // offsetAccess.nonOffsetAccessible
}

// ✅ CORRETTO - Safe array access
public function getLocaleLabel(string $locale): string
{
    return $this->labels[$locale] ?? $locale;
}
```

#### **5. Iteration Safety - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - Non-iterable foreach
public function processLocales($locales)
{
    foreach ($locales as $locale) { // foreach.nonIterable
        // ...
    }
}

// ✅ CORRETTO - Type-safe iteration
public function processLocales(array $locales): void
{
    foreach ($locales as $locale) {
        // ...
    }
}
```

---

## 🔧 **Pattern Anti-PHPStan - DA EVITARE**

### **1. Mixed Types - VIETATO**
```php
// ❌ VIETATO
private mixed $config;

// ✅ ALTERNATIVA
private array $config = [];
```

### **2. Method Chaining su Mixed - VIETATO**
```php
// ❌ VIETATO
$result = $this->getData()->process()->getResult();

// ✅ ALTERNATIVA
$data = $this->getData();
if ($data instanceof DataProcessor) {
    $result = $data->process()->getResult();
} else {
    $result = null;
}
```

### **3. Array Unpacking su Mixed - VIETATO**
```php
// ❌ VIETATO
$result = [...$mixedArray];

// ✅ ALTERNATIVA
$result = is_array($mixedArray) ? [...$mixedArray] : [];
```

---

## 🎯 **PHPStan Compliance Strategy**

### **Fase 1: Type Safety Foundation**
1. **Add explicit return types** a tutti i metodi
2. **Declare parameter types** per tutti i parametri
3. **Eliminate mixed types** dal codebase
4. **Implement type checking** runtime dove necessario

### **Fase 2: Array & Object Safety**
1. **Safe array access** con null coalescing
2. **Type checking prima iteration**
3. **Interface contracts** per method chaining
4. **Proper error handling** per type mismatches

### **Fase 3: Advanced Type System**
1. **Generic types** dove appropriato
2. **Union types** per flexibility
3. **Nullable types** espliciti
4. **Template types** per collections

---

## 📋 **Filament v5 Integration Rules**

### **1. XotBase Wrappers - OBBLIGATORIO**
```php
// ❌ SBAGLIATO - Estensione diretta
class MyResource extends \Filament\Resources\Resource

// ✅ CORRETTO - XotBase wrapper
class MyResource extends \Modules\Xot\Filament\Resources\XotBaseResource
```

### **2. Plugin Interface Compliance**
```php
// ❌ SBAGLIATO - Method inesistente
$plugin->getPersistLocale() // method.notFound

// ✅ CORRETTO - Interface compliance
if (method_exists($plugin, 'getPersistLocale')) {
    $locale = $plugin->getPersistLocale();
} else {
    $locale = null;
}
```

### **3. Form State Management**
```php
// ❌ SBAGLIATO - Mixed form state
public function mutateFormDataBeforeFill($data): array
{
    return $data; // argument.type
}

// ✅ CORRETTO - Type-safe form state
public function mutateFormDataBeforeFill(array $data): array
{
    return $this->sanitizeFormData($data);
}

private function sanitizeFormData(array $data): array
{
    // Sanitization logic
    return $data;
}
```

---

## 🔍 **Translation-Specific Rules**

### **1. Translation Method Safety**
```php
// ❌ SBAGLIATO - Method not found
$model->setTranslation('field', 'value', 'locale');

// ✅ CORRETTO - Interface check
if (method_exists($model, 'setTranslation')) {
    $model->setTranslation('field', 'value', 'locale');
} else {
    // Alternative implementation
    $this->setTranslationAttribute($model, 'field', 'value', 'locale');
}
```

### **2. Locale Validation**
```php
// ❌ SBAGLIATO - No validation
public function setLocale($locale): void
{
    $this->locale = $locale; // assign.propertyType
}

// ✅ CORRETTO - Type validation
public function setLocale(string $locale): void
{
    if (!in_array($locale, $this->getSupportedLocales(), true)) {
        throw new \InvalidArgumentException("Unsupported locale: {$locale}");
    }
    
    $this->locale = $locale;
}
```

### **3. Translation Array Safety**
```php
// ❌ SBAGLIATO - Unsafe access
public function getTranslation(string $key, string $locale): string
{
    return $this->translations[$locale][$key]; // Multiple risks
}

// ✅ CORRETTO - Safe access
public function getTranslation(string $key, string $locale): string
{
    if (!isset($this->translations[$locale][$key])) {
        return $key; // Fallback to key
    }
    
    $translation = $this->translations[$locale][$key];
    return is_string($translation) ? $translation : $key;
}
```

---

## 🎯 **Best Practices per Type Safety**

### **1. Constructor Property Promotion**
```php
// ✅ PREFERITO
class TranslationService
{
    public function __construct(
        private TranslationRepository $repository,
        private CacheManager $cache,
        private LoggerInterface $logger,
    ) {}
}
```

### **2. Early Type Validation**
```php
// ✅ PATTERN RICCOMANDATO
public function processTranslationData(array $data): void
{
    // Early validation
    if (!isset($data['key'], $data['locale'], $data['value'])) {
        throw new \InvalidArgumentException('Missing required translation fields');
    }
    
    $key = $data['key'];
    $locale = $data['locale']; 
    $value = $data['value'];
    
    if (!is_string($key) || !is_string($locale) || !is_string($value)) {
        throw new \InvalidArgumentException('Translation fields must be strings');
    }
    
    // Continue processing
    $this->saveTranslation($key, $locale, $value);
}
```

### **3. Null Safety**
```php
// ✅ PATTERN SICURO
public function getTranslationValue(?string $locale = null): string
{
    $locale ??= $this->getDefaultLocale();
    
    $translation = $this->translations[$locale] ?? null;
    
    return $translation?->value ?? $this->getFallbackValue();
}
```

---

## 📊 **Code Quality Metrics**

### **Target Metrics**
- **PHPStan Level 10**: 0 errori (target assoluto)
- **Type Coverage**: 100% (tutti metodi con tipi)
- **Mixed Types**: 0 (eliminati completamente)
- **Return Types**: 100% (espliciti)
- **Parameter Types**: 100% (espliciti)

### **Current Issues da Risolvere**
| Categoria | Errori | Priorità | Soluzione |
|-----------|--------|----------|----------|
| LaraZeus Package | 45 | Critica | Update/Refactor |
| Mixed Types | 38 | Alta | Explicit types |
| Return Types | 23 | Alta | Add declarations |
| Array Access | 15 | Media | Safe operations |
| Method Not Found | 5 | Critica | Interface checks |

---

## 🔧 **Sviluppo Guidelines**

### **1. Prima di Scrivere Codice**
1. **Think types first** - Definisci tipi prima di implementare
2. **Check interfaces** - Verifica metodi disponibili
3. **Plan error handling** - Gestisci type mismatches
4. **Write tests** - Copri tutti i type cases

### **2. Durante Sviluppo**
1. **Run PHPStan frequently** - Controlla dopo ogni cambiamento
2. **Use strict types** - `declare(strict_types=1);`
3. **Enable all type checks** - Non disabilitare errori
4. **Document types** - PHPDoc per tipi complessi

### **3. Prima del Commit**
1. **PHPStan Level 10 check**: `php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10`
2. **Type coverage check**: Verify 100% type coverage
3. **Test suite**: Run complete test suite
4. **Documentation**: Update type documentation

---

## 🚨 **ERRORI COMUNI DA EVITARE**

### **1. Assuming Method Existence**
```php
// ❌ NON ASSUMERE
$result = $object->nonExistentMethod();

// ✅ VERIFICA SEMPRE
if (method_exists($object, 'nonExistentMethod')) {
    $result = $object->nonExistentMethod();
} else {
    // Handle missing method
}
```

### **2. Unsafe Array Operations**
```php
// ❌ NON OPERARE SU MIXED
foreach ($mixedData as $item) { ... }

// ✅ VERIFICA TIPO
if (is_array($mixedData)) {
    foreach ($mixedData as $item) { ... }
}
```

### **3. Ignoring Return Types**
```php
// ❌ NON IGNORARE
function process() { return $data; }

// ✅ SPECIFICA SEMPRE
function process(): array { return $data; }
```

---

## 📋 **Checklist PHPStan Compliance**

### **Pre-Commit Checklist**
- [ ] Tutti i metodi hanno return type esplicito
- [ ] Tutti i parametri hanno type declaration
- [ ] Nessun mixed type nel codebase
- [ ] Array access safe con null coalescing
- [ ] Iterations solo su tipi verificati
- [ ] Method calls verificati con method_exists()
- [ ] PHPStan Level 10: 0 errori
- [ ] Test suite passa completamente

### **Review Focus Areas**
- [ ] Type safety in translation methods
- [ ] Form data mutability e type checking
- [ ] Plugin interface compatibility
- [ ] Array operations safety
- [ ] Error handling per type mismatches

---

## 🔗 **Collegamenti Correlati**

- [PHPStan Issues Dettagliati](phpstan-issues.md)
- [Roadmap PHPStan](roadmap.md)
- [Composer merge plugin](composer-merge-plugin.md)
- [Laraxot Architecture Guidelines](../../Xot/docs/architecture.md)

---

## 👨‍💻 **Development Workflow**

### **1. Setup Ambiente**
```bash
# Enable strict types
echo "declare(strict_types=1);" > temp_check.php

# PHPStan baseline
php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10 --generate-baseline

# Continuous checking
php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=10 --watch
```

### **2. Development Cycle**
1. **Write typed code first**
2. **Run PHPStan immediately**
3. **Fix errors before continuing**
4. **Write tests for type safety**
5. **Document complex types**

---

**Ultimo Aggiornamento**: 2026-02-10
**PHPStan Level**: 10 (Target: 0 errori)
**Priority**: CRITICAL
**Maintainer**: TBD

⚠️ **ATTENZIONE**: Queste regole sono **obbligatorie** per qualsiasi contributo al modulo Lang.
