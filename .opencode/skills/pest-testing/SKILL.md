---
name: pest-testing
description: Gestione completa testing con Pest PHP per progetti Laravel/Laraxot. Unit test, feature test, browser test, dataset e testing patterns. Usare per scrivere test, debugging test, coverage analysis o quando si menziona testing/quality assurance.
---

# Pest Testing - Complete Workflow

## Scopo
Skill completa per gestire testing con Pest PHP in architettura Laraxot,包括 unit test, feature test, browser test e dataset patterns.

## TDD: Red-Green-Refactor Cycle

TDD (Test-Driven Development) segue un ciclo di 3 fasi:

1. **🔴 RED** - Scrivi un test che fallisce
2. **🟢 GREEN** - Scrivi il minimo codice per far passare il test
3. **🔵 REFACTOR** - Migliora il codice mantenendo i test verdi

### Perché TDD?
- Qualità codice superiore
- Bug catturati in anticipo
- Documentazione eseguibile
- Refactoring sicuro
- Feedback immediato

---

## Quando Usare
- Scrivere nuovi test per moduli
- Debugging test falliti
- Coverage analysis
- Test patterns per repository/service layer
- Testing business logic complessa
- CI/CD testing pipeline

---

## TDD Workflow Patterns

### 1️⃣ Red Phase (Failing Test)
```php
// Prima di scrivere codice, scrivi il test che fallisce
it('can create a task with valid data', function () {
    // Arrange
    $user = User::factory()->create();
    
    // Act - usa il codice come se esistesse già
    $response = $this->actingAs($user)
        ->postJson('/api/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
        ]);
    
    // Assert
    $response->assertStatus(201);
    $this->assertDatabaseHas('tasks', [
        'title' => 'Test Task',
    ]);
});
```

### 2️⃣ Green Phase (Make it Pass)
```php
// Scrivi il MINIMO codice per far passare il test
// NON ottimizzare ancora, fallo solo passare

class TaskController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);
        
        return response()->json(['status' => 'created'], 201);
    }
}
```

### 3️⃣ Refactor Phase (Improve Code)
```php
// Ora migliora il codice mantenendo i test verdi
// Estrai validazione, refactorizza, ottimizza

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}

class TaskController extends Controller
{
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);
        
        return response()->json([
            'data' => new TaskResource($task)
        ], 201);
    }
}
```

---

## 🚀 Pest Testing Patterns

### 1️⃣ **Architettura Test Laraxot**

#### **Structure Standard**
```
Modules/ModuleName/
├── tests/
│   ├── Pest.php              # Test configuration
│   ├── Unit/                 # Unit test
│   │   ├── Models/
│   │   ├── Services/
│   │   └── Repositories/
│   ├── Feature/              # Feature test
│   │   ├── User/
│   │   ├── Admin/
│   │   └── API/
│   └── Browser/              # Browser test (Pest 4+)
│       ├── Authentication/
│       └── CRUD/
```

#### **Pest.php Configuration**
```php
<?php

// Modules/ModuleName/tests/Pest.php
use Modules\ModuleName\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');
uses(Modules\ModuleName\Tests\BrowserTestCase::class)->in('Browser');

// Custom expectations
expect()->extend('toBeValidUser', function () {
    return $this->toBeInstanceOf(\Modules\User\Models\User::class)
        ->and($this->value->id)->toBeInt()
        ->and($this->value->email)->toBeString();
});

// Helper functions
function createTestUser(array $attributes = []): \Modules\User\Models\User {
    return \Modules\User\Models\User::factory()->create($attributes);
}

function createTestTenant(array $attributes = []): \Modules\Tenant\Models\Tenant {
    return \Modules\Tenant\Models\Tenant::factory()->create($attributes);
}
```

### 2️⃣ **Unit Test Patterns**

#### **Model Testing**
```php
<?php

// Modules/User/tests/Unit/Models/UserTest.php
use Modules\User\Models\User;

it('can create user with factory', function () {
    $user = User::factory()->create();
    
    expect($user)
        ->toBeInstanceOf(User::class)
        ->and($user->id)->toBeInt()
        ->and($user->email)->toBeString();
});

it('applies correct casts', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    
    expect($user->email_verified_at)
        ->toBeInstanceOf(Carbon::class);
});

it('respects tenant scope', function () {
    $tenant = createTestTenant();
    $user = User::factory()->for($tenant)->create();
    
    expect($user->tenant_id)
        ->toBe($tenant->id);
});
```

#### **Repository Testing**
```php
<?php

// Modules/User/tests/Unit/Repositories/UserRepositoryTest.php
use Modules\User\Contracts\UserRepositoryInterface;
use Modules\User\Models\User;

it('finds user by id', function () {
    $user = createTestUser();
    $repository = app(UserRepositoryInterface::class);
    
    $found = $repository->findById($user->id);
    
    expect($found)
        ->toBeInstanceOf(User::class)
        ->and($found->id)->toBe($user->id);
});

it('finds active users only', function () {
    User::factory()->create(['active' => false]);
    $activeUser = User::factory()->create(['active' => true]);
    
    $repository = app(UserRepositoryInterface::class);
    $activeUsers = $repository->findActive();
    
    expect($activeUsers)
        ->toHaveCount(1)
        ->and($activeUsers->first()->id)->toBe($activeUser->id);
});
```

#### **Service Testing**
```php
<?php

// Modules/User/tests/Unit/Services/UserServiceTest.php
use Modules\User\Services\UserService;
use Modules\User\Events\UserRegistered;
use Illuminate\Support\Facades\Event;

it('registers user successfully', function () {
    Event::fake();
    
    $service = app(UserService::class);
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
    ];
    
    $user = $service->register($userData);
    
    expect($user)
        ->toBeInstanceOf(User::class)
        ->and($user->email)->toBe($userData['email']);
    
    Event::assertDispatched(UserRegistered::class);
});

it('validates user data', function () {
    $service = app(UserService::class);
    
    expect(fn() => $service->register([]))
        ->toThrow(ValidationException::class);
});
```

### 3️⃣ **Feature Test Patterns**

#### **CRUD Operations**
```php
<?php

// Modules/User/tests/Feature/UserCRUDTest.php
use Modules\User\Models\User;
use Livewire\Livewire;

it('displays user index page', function () {
    $user = createTestUser();
    
    $response = $this->actingAs($user)
        ->get('/users');
    
    $response->assertOk()
        ->assertSee('Users');
});

it('creates new user via filament resource', function () {
    $admin = createTestUser(['role' => 'admin']);
    
    Livewire::actingAs($admin)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\CreateUser::class)
        ->fillForm([
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ])
        ->call('create')
        ->assertHasNoFormErrors();
    
    $this->assertDatabaseHas('users', [
        'email' => 'newuser@example.com',
    ]);
});

it('updates existing user', function () {
    $user = createTestUser();
    $admin = createTestUser(['role' => 'admin']);
    
    Livewire::actingAs($admin)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\EditUser::class, ['record' => $user->id])
        ->fillForm([
            'name' => 'Updated Name',
        ])
        ->call('save')
        ->assertHasNoFormErrors();
    
    $user->refresh();
    expect($user->name)->toBe('Updated Name');
});
```

#### **Authorization Testing**
```php
<?php

// Modules/User/tests/Feature/UserAuthorizationTest.php
it('allows admin to delete users', function () {
    $admin = createTestUser(['role' => 'admin']);
    $user = createTestUser();
    
    Livewire::actingAs($admin)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\ListUsers::class)
        ->callTableAction('delete', $user)
        ->assertOk();
    
    $this->assertModelMissing($user);
});

it('forbids regular users from deleting users', function () {
    $regularUser = createTestUser(['role' => 'user']);
    $user = createTestUser();
    
    Livewire::actingAs($regularUser)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\ListUsers::class)
        ->callTableAction('delete', $user)
        ->assertForbidden();
});
```

### 4️⃣ **Browser Testing (Pest 4+)**

#### **Authentication Flow**
```php
<?php

// Modules/User/tests/Browser/AuthenticationTest.php
use Laravel\Dusk\Browser;

it('can login user', function () {
    $user = createTestUser();
    
    visit('/login')
        ->waitForText('Email')
        ->type('email', $user->email)
        ->type('password', 'password')
        ->click('button[type="submit"]')
        ->waitForLocation('/dashboard')
        ->assertPathIs('/dashboard')
        ->assertAuthenticatedAs($user);
});

it('shows validation errors on invalid login', function () {
    visit('/login')
        ->type('email', 'invalid@example.com')
        ->type('password', 'wrongpassword')
        ->click('button[type="submit"]')
        ->waitForText('These credentials do not match our records')
        ->assertSee('These credentials do not match our records');
});
```

#### **Complex Workflow Testing**
```php
<?php

// Modules/Ptv/tests/Browser/PtvWorkflowTest.php
it('completes full ptv evaluation workflow', function () {
    $manager = createTestUser(['role' => 'manager']);
    $employee = createTestUser();
    
    loginAs($manager);
    
    visit('/ptv/evaluations/create')
        ->select('employee_id', $employee->id)
        ->type('notes', 'Performance evaluation')
        ->click('Create Evaluation')
        ->waitForLocation('/ptv/evaluations/1')
        ->assertSee('Evaluation Created')
        
        ->click('Start Review')
        ->waitForText('Review Criteria')
        ->checkAllCheckboxes()
        ->type('comments', 'Good performance')
        ->click('Submit Review')
        ->waitForText('Review Submitted')
        ->assertSee('Evaluation Complete');
});
```

### 5️⃣ **Dataset Patterns**

#### **Validation Testing**
```php
<?php

// Modules/User/tests/Feature/UserValidationTest.php
it('validates user creation with various scenarios', function ($userData, $expectedErrors) {
    $admin = createTestUser(['role' => 'admin']);
    
    Livewire::actingAs($admin)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\CreateUser::class)
        ->fillForm($userData)
        ->call('create')
        ->assertHasFormErrors($expectedErrors);
})->with([
    'missing email' => [
        ['name' => 'Test User'],
        ['email' => 'required']
    ],
    'invalid email format' => [
        ['name' => 'Test User', 'email' => 'invalid-email'],
        ['email' => 'email']
    ],
    'duplicate email' => function () {
        $existingUser = createTestUser();
        return [
            ['name' => 'Test User', 'email' => $existingUser->email],
            ['email' => 'unique']
        ];
    }
]);
```

#### **Role-based Testing**
```php
<?php

it('handles different user roles correctly', function ($role, $canAccess, $canManage) {
    $user = createTestUser(['role' => $role]);
    
    $indexResponse = $this->actingAs($user)->get('/users');
    $canAccess ? $indexResponse->assertOk() : $indexResponse->assertForbidden();
    
    if ($canAccess) {
        Livewire::actingAs($user)
            ->test(\Modules\User\Filament\Resources\UserResource\Pages\ListUsers::class)
            ->assertCanSeeTableRecords(User::take(3)->get());
    }
    
    $testUser = createTestUser();
    Livewire::actingAs($user)
        ->test(\Modules\User\Filament\Resources\UserResource\Pages\ListUsers::class)
        ->canManageTableAction($canManage, 'delete', $testUser);
})->with([
    ['admin', true, true],
    ['manager', true, false],
    ['user', false, false],
]);
```

---

## 🔧 Script Utili

### **run_module_tests.sh**
```bash
#!/bin/bash
MODULE=$1
cd laravel

echo "🧪 Running Pest Tests - Module: $MODULE"
echo "======================================="

if [ ! -d "Modules/$MODULE" ]; then
    echo "❌ Module $MODULE not found"
    exit 1
fi

# Run tests with coverage
./vendor/bin/pest "Modules/$MODULE/tests" --coverage --min=80

if [ $? -eq 0 ]; then
    echo "✅ All tests passed for $MODULE"
else
    echo "❌ Tests failed for $MODULE"
    exit 1
fi
```

### **debug_failing_test.sh**
```bash
#!/bin/bash
TEST_NAME=$1
MODULE=${2:-User}
cd laravel

echo "🐛 Debugging failing test: $TEST_NAME"
echo "===================================="

# Run with verbose output
./vendor/bin/pest "Modules/$MODULE/tests" --filter="$TEST_NAME" --verbose

# Run with coverage
./vendor/bin/pest "Modules/$MODULE/tests" --filter="$TEST_NAME" --coverage

# Run with stop on failure
./vendor/bin/pest "Modules/$MODULE/tests" --filter="$TEST_NAME" --stop-on-failure
```

### **generate_test_data.sh**
```bash
#!/bin/bash
MODULE=$1
cd laravel

echo "🏭 Generating test data for $MODULE"
echo "=================================="

# Run seeders
php artisan db:seed --class="${MODULE}Seeder"

# Generate factories
php artisan make:factory ${MODULE}TestFactory --model=Modules\\${MODULE}\\Models\\${MODULE}

echo "✅ Test data generated for $MODULE"
```

---

## TDD Best Practices

### AAA Pattern (Arrange-Act-Assert)
```php
it('creates a task and assigns to user', function () {
    // Arrange - prepara i dati
    $user = User::factory()->create();
    $taskData = [
        'title' => 'Complete Laravel TDD',
        'description' => 'Write a comprehensive guide',
    ];
    
    // Act - esegui l'azione
    $response = $this->actingAs($user)
        ->postJson('/api/tasks', $taskData);
    
    // Assert - verifica il risultato
    $response->assertStatus(201);
    expect($response->json('data.title'))->toBe('Complete Laravel TDD');
});
```

### Test Naming
```php
// ❌ NO - nome troppo generico
it('test_create', function () { });

// ✅ SÌ - nome descrittivo
it('creates a task with valid data and assigns it to the authenticated user', function () { });
it('validates required title when creating a task', function () { });
it('cannot create task without authentication', function () { });
```

### Edge Cases & Sad Paths
```php
describe('Task Validation', function () {
    it('rejects tasks with past due dates', function () {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => 'Test',
                'due_date' => '2020-01-01',
            ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['due_date']);
    });
    
    it('handles extremely long task titles gracefully', function () {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => str_repeat('a', 300),
            ]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    });
});
```

### Factory States
```php
// database/factories/TaskFactory.php
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'status' => 'pending',
            'priority' => 'medium',
            'user_id' => User::factory(),
        ];
    }
    
    public function completed(): static
    {
        return $this->state(fn () => ['status' => 'completed']);
    }
    
    public function highPriority(): static
    {
        return $this->state(fn () => ['priority' => 'high']);
    }
    
    public function overdue(): static
    {
        return $this->state(fn () => [
            'due_date' => now()->subDays(5),
        ]);
    }
}

// Usage
$completedTask = Task::factory()->completed()->create();
$urgentTask = Task::factory()->highPriority()->overdue()->create();
```

---

## 📊 Coverage & Quality Gates

### **Coverage Configuration**
```php
<?php

// Modules/ModuleName/tests/Pest.php
use Modules\ModuleName\Tests\TestCase;

uses(TestCase::class)
    ->in('Feature', 'Unit')
    ->coverage([
        'app/Models/',
        'app/Services/',
        'app/Repositories/',
        'app/Actions/',
    ])
    ->minCoverage(80);
```

### **GitHub Actions Test Pipeline**
```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: 8.3
        extensions: pdo, sqlite
        coverage: xdebug
        
    - name: Install dependencies
      run: |
        cd laravel
        composer install --no-interaction --prefer-dist
        
    - name: Run tests
      run: |
        cd laravel
        ./vendor/bin/pest --coverage --min=80
        
    - name: Upload coverage
      uses: codecov/codecov-action@v3
      with:
        file: ./laravel/coverage.xml
```

---

## 🎯 Testing Checklist

### **Prima di scrivere test:**
- [ ] Identifica il tipo di test (Unit/Feature/Browser)
- [ ] Verifica dependencies disponibili (factory, seeder)
- [ ] Pianifica coverage targets (min 80%)
- [ ] Controlla pattern esistenti nel modulo

### **Durante scrittura test:**
- [ ] Usa naming convention chiara e descrittiva
- [ ] Testa happy path e edge cases
- [ ] Usa dataset per multiple scenarios
- [ ] Implementa assertions specifiche e precise

### **Dopo scrittura test:**
- [ ] Verifica test passa in isolamento
- [ ] Controlla coverage metrics
- [ ] Test integration con altri moduli
- [ ] Documenta patterns non standard

---

## 🚨 Anti-Patterns da Evitare

### **❌ NON FARE**
```php
// Test dipendenti dall'ordine
it('creates user', function () {
    // Dipende da test precedente
    $user = User::first(); // NO!
});

// Test con side effects permanenti
it('creates user', function () {
    User::factory()->create(); // senza cleanup
    // Test successivi falliscono
});

// Assertion vaghe
it('works', function () {
    $response = $this->get('/users');
    $response->assertOk(); // Too generic
});
```

### **✅ FARE SEMPRE**
```php
// Test isolati e indipendenti
it('creates user', function () {
    $user = User::factory()->create();
    expect($user)->toBeInstanceOf(User::class);
});

// Setup/Teardown automatici
it('creates user', function () {
    $user = User::factory()->create();
    
    expect($user)
        ->toBeInstanceOf(User::class)
        ->and($user->email)->toBeString();
});

// Assertions specifiche
it('displays user management page', function () {
    $user = createTestUser();
    
    $this->actingAs($user)
        ->get('/users')
        ->assertOk()
        ->assertSee('User Management')
        ->assertSee($user->name);
});
```

---

## 📋 Quick Reference

### **Comandi Essenziali**
```bash
# Esegui tutti i test
./vendor/bin/pest

# Test modulo specifico
./vendor/bin/pest Modules/User/tests

# Test con coverage
./vendor/bin/pest --coverage

# Test singolo
./vendor/bin/pest --filter="test_name"

# Debug mode
./vendor/bin/pest --verbose --debug

# Stop al primo fallimento
./vendor/bin/pest --stop-on-failure
```

### **Pattern Assertions**
```php
// Model assertions
expect($user)->toBeInstanceOf(User::class);
expect($user->id)->toBeInt();
expect($user->email)->toBeString();

// Database assertions
$this->assertDatabaseHas('users', ['email' => $email]);
$this->assertDatabaseMissing('users', ['id' => $id]);
$this->assertModelMissing($user);

// Response assertions
$response->assertOk();
$response->assertRedirect('/dashboard');
$response->assertSee('Success');
$response->assertForbidden();
```

---

## 📚 Risorse Aggiuntive

- **[Pest Documentation](https://pestphp.com/)** - Guide ufficiali
- **[Laravel Testing Guide](https://laravel.com/docs/testing)** - Testing patterns
- **[PTVX Testing Standards](../../../docs/testing-standards.md)** - Standard progetto
- **[Browser Testing Guide](../../../docs/browser-testing.md)** - Dusk/Pest 4+

---

*Skill specializzata per PTVX Laraxot + Pest Testing*