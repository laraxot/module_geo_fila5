# Story 7-43: Prevent Container Loop — Root Cause Analysis + Permanent Guardrails

**Stato**: ready-for-dev
**Epic**: 7 (Ticket wizard — pagina unificata `tests.segnalazione-crea`)
**Ultimo aggiornamento**: 2026-04-14
**Dipende da**: 7-35 (widget non rendering fix), 7-42 (step2 HTML parity)

---

## Story

Come **sviluppatore e utente del sistema**,
voglio che il rendering del widget `CreateTicketWizardWidget` su `/it/tests/segnalazione-crea` **non vada mai più in loop** (Maximum execution time exceeded),
così il sistema è stabile e gli sviluppatori non perdono tempo a debuggare errori ricorrenti.

---

## Root Cause Analysis (RCA)

### Sintomo
```
[2026-04-14 11:53:47] local.ERROR: Maximum execution time of 120 seconds exceeded
at /var/www/.../vendor/laravel/framework/src/Illuminate/Container/Container.php:1504
```

### Catena di eventi

1. **Trigger**: Accesso a `http://127.0.0.1:8000/it/tests/segnalazione-crea`
2. **View include**: `@livewire(CreateTicketWizardWidget::class, [...])`
3. **Widget construct**: `XotBaseWidget::__construct()` → `$this->resolveView()`
4. **resolveView()**: `app(GetViewByClassAction::class)->execute(static::class)`
5. **Loop cause**: Compiled view cache corrotto → `view()->exists()` loop infinito nel Container

### Root cause tecnica

Il loop **NON è una dipendenza circolare nel codice** (che sarebbe permanente). È causato da:

```
Compiled View Cache Corrotto
    ↓
view()->exists() chiama ViewFinder
    ↓
ViewFinder cerca file con path invalidi (null bytes)
    ↓
Container retry logic entra in loop infinito
    ↓
Maximum execution time exceeded (120s)
```

### Evidenze sperimentali

| Test | Risultato | Tempo |
|------|-----------|-------|
| `php artisan tinker` → container base | ✅ OK | < 1s |
| `new CreateTicketWizardWidget()` | ✅ OK | < 1s |
| `$widget->mount()` | ✅ OK | < 1s |
| `$widget->getFormSchema()` | ❌ `file_put_contents(): Argument #1 must not contain null bytes` | - |
| Dopo `php artisan view:clear` | ✅ OK (page 200) | < 5s |

**Conclusione**: Il loop è **effimero** (causato da cache corrotta), non strutturale.

---

## Filosofia — Perché il loop è possibile

### Zen: "Il cache è una bugia ottimizzata"

Il sistema di cache di Laravel è un'**ottimizzazione**, non una fonte di verità. Quando si corrompe:
- I path diventano invalidi (null bytes)
- Il ViewFinder entra in retry loop
- Il Container non ha timeout interno

### Religione: "Ogni cache DEVE essere invalidabile"

```
┌─────────────────────────────────────────────────────────┐
│                    CACHE LAYERS                         │
├─────────────────────────────────────────────────────────┤
│ 1. Config cache     → php artisan config:clear          │
│ 2. Route cache      → php artisan route:clear           │
│ 3. View cache       → php artisan view:clear            │
│ 4. Compiled cache   → php artisan optimize:clear        │
│ 5. Filament cache   → incluso in optimize:clear         │
└─────────────────────────────────────────────────────────┘
```

**Regola**: Dopo OGNI modifica a:
- Blade views
- Service Providers
- Widget constructors
- View resolution logic

→ **ESEGUIRE** `php artisan view:clear`

### Politica del progetto: "Prevenzione > Cura"

**3 livelli di difesa**:
1. **Pre-commit hook**: Clear view cache automaticamente
2. **Dev server middleware**: Clear cache se timeout > 10s
3. **Widget constructor**: Lazy view resolution (non nel costruttore)

---

## Gap Architetturali

### 1. View Resolution nel Costruttore (PROBLEMA)

```php
// XotBaseWidget.php — LINEA SBAGLIATA
public function __construct()
{
    $this->resolveView();  // ← Chiama GetViewByClassAction nel costruttore
}
```

**Perché è sbagliato**:
- Il costruttore dovrebbe essere **leggero** e **deterministico**
- La risoluzione della view è un'**operazione costosa** (container resolution + file I/O)
- Se la view non esiste, il fallback loop è nel costruttore → difficile da debuggare

**Soluzione corretta**:
```php
// Lazy resolution
public function getView(): string
{
    if ($this->view === 'xot::filament.widgets.base') {
        $this->view = app(GetViewByClassAction::class)->execute(static::class);
    }
    return $this->view;
}
```

### 2. Nessun Timeout nel Widget Rendering

Livewire/Filament non hanno un timeout di sicurezza. Se un widget entra in loop, l'intera richiesta muore dopo 120s (PHP max_execution_time).

**Soluzione**: Wrapper con timeout:
```php
public function render(): View
{
    $start = microtime(true);
    $view = view($this->getView(), [...]);
    $elapsed = round(microtime(true) - $start, 2);
    
    if ($elapsed > 5.0) {
        \Log::warning('[Widget] Slow render: ' . $elapsed . 's', ['widget' => static::class]);
    }
    
    return $view;
}
```

### 3. Compiled View Cache Corrompe Senza Avviso

Laravel non valida i compiled views prima di usarli. Se un file `.php` in `storage/framework/views` ha contenuto invalido, viene usato direttamente.

**Soluzione**: Validation hook nel Service Provider:
```php
// AppServiceProvider.php
public function boot(): void
{
    if (app()->isLocal()) {
        View::creator('*', function ($view) {
            $path = $view->getPath();
            if ($path && strpos($path, "\0") !== false) {
                \Log::error('[View] Corrupted compiled view: ' . $path);
                Artisan::call('view:clear');
            }
        });
    }
}
```

---

## Acceptance Criteria

### AC 1 — Nessun loop dopo modifiche a widget
**GIVEN** una modifica a `CreateTicketWizardWidget.php` o `XotBaseWidget.php`
**WHEN** si ricarica `/it/tests/segnalazione-crea`
**THEN** la pagina risponde con 200 in < 10s

### AC 2 — View resolution lazy
**GIVEN** `XotBaseWidget`
**WHEN** si cerca `__construct()`
**THEN** NON chiama `$this->resolveView()` nel costruttore

### AC 3 — Clear cache automatico post-modifica
**GIVEN** un dev modifica un widget o una view
**WHEN** fa commit
**THEN** pre-commit hook esegue `php artisan view:clear`

### AC 4 — Documentazione RCA
**GIVEN** la doc `laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md`
**WHEN** si cerca "loop" o "timeout" o "cache corrupted"
**THEN** esiste guida con root cause analysis e prevenzione

### AC 5 — Memoria di progetto aggiornata
**GIVEN** QWEN.md e `.qwen/memories/`
**WHEN** si cerca "container loop" o "view cache"
**THEN** esiste memoria con regola di prevenzione

---

## Technical Requirements

### File da modificare

| File | Operazione | Motivazione |
|------|-----------|-------------|
| `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php` | Rimuovere `resolveView()` dal costruttore, aggiungere lazy `getView()` | Prevenire loop nel costruttore |
| `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php` | Aggiungere slow render warning | Debugging precoce |
| `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` | Aggiungere slow render warning | Debugging precoce |
| `laravel/bootstrap/app.php` | Aggiungere view corruption hook (local only) | Auto-healing cache corrotto |
| `bashscripts/pre-commit` | Aggiungere `php artisan view:clear` | Prevenzione post-modifica |
| `.git/hooks/pre-commit` | Link a bashscripts/pre-commit | Automazione |

### Nuova documentazione

| File | Contenuto |
|------|-----------|
| `laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md` | RCA + prevention patterns |
| `laravel/Modules/Xot/docs/filament/widgets/lazy-view-resolution.md` | Lazy getView() pattern |

---

## Implementazione Detail

### 1. Lazy View Resolution in XotBaseWidget

```php
// PRIMA (sbagliato)
public function __construct()
{
    $this->resolveView();
}

// DOPO (corretto)
public function getView(): string
{
    if ($this->view === 'xot::filament.widgets.base') {
        try {
            $this->view = app(GetViewByClassAction::class)->execute(static::class);
        } catch (\Throwable $e) {
            // Fallback sicuro: non entra in loop
            $this->view = 'xot::filament.widgets.base';
            if (app()->isLocal()) {
                throw $e;
            }
        }
    }
    return $this->view;
}
```

### 2. Slow Render Warning

```php
// In CreateTicketWizardWidget.php
public function render(): View
{
    $start = microtime(true);
    $result = view($this->getView(), [
        'blockData' => $this->blockData,
        'pageTitle' => (string) ($this->blockData['title'] ?? __('fixcity::segnalazione.page.title.label')),
        'pageDescription' => (string) ($this->blockData['description'] ?? ''),
    ]);
    $elapsed = round(microtime(true) - $start, 2);
    
    if ($elapsed > 5.0) {
        \Log::warning('[Fixcity] Slow widget render', [
            'widget' => static::class,
            'elapsed' => $elapsed . 's',
            'step' => 'data',
        ]);
    }
    
    return $result;
}
```

### 3. View Corruption Hook (local only)

```php
// In bootstrap/app.php o AppServiceProvider
if (app()->isLocal()) {
    View::creator('*', function ($view) {
        $path = $view->getPath();
        if ($path && is_string($path) && strpos($path, "\0") !== false) {
            \Log::error('[View] Corrupted compiled view detected', ['path' => $path]);
            \Artisan::call('view:clear');
        }
    });
}
```

---

## Testing

### Test manuale — Simulazione cache corrotto

```bash
# 1. Corrompi cache volutamente
echo "<?php null_byte: \0" > laravel/storage/framework/views/corrupted.php

# 2. Forza uso cache corrotta
cp laravel/storage/framework/views/corrupted.php laravel/storage/framework/views/abc123.php

# 3. Testa pagina
curl -s -o /dev/null -w "%{http_code}" --max-time 15 http://127.0.0.1:8000/it/tests/segnalazione-crea

# ATTESA: 200 OK (grazie ad auto-healing hook)
# SENZA hook: 500 o timeout
```

### Test automatico

```bash
# Script di verifica
cd laravel
php artisan view:clear
curl -s -o /dev/null -w "%{http_code}" --max-time 10 http://127.0.0.1:8000/it/tests/segnalazione-crea
# Deve restituire 200
```

---

## Guardrails per il dev

- **NON** mettere logica costosa nei costruttori di widget
- **NON** chiamare `app()` o `resolve()` nel costruttore se puoi evitarlo
- **SEMPRE** usare lazy resolution per operazioni non critiche
- **SEMPRE** clear view cache dopo modifiche a Blade views
- **MAI** committare file in `storage/framework/views/` (sono nel .gitignore)
- **SE** vedi "Maximum execution time exceeded" → prima cosa: `php artisan view:clear`

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Container Loop RCA | `laravel/Modules/Xot/docs/filament/widgets/container-loop-prevention.md` (nuovo) |
| Lazy View Resolution | `laravel/Modules/Xot/docs/filament/widgets/lazy-view-resolution.md` (nuovo) |
| XotBaseWidget | `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWidget.php` |
| CreateTicketWizardWidget | `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` |
| Laravel View Caching | https://laravel.com/docs/12.x/views#optimizing-views |

---

## Related Stories

| Story | Status | Relazione |
|-------|--------|-----------|
| 7-35 (widget non rendering) | ready-for-dev | Parent: widget non appariva |
| 7-42 (step2 HTML parity) | ready-for-dev | Dipende: widget deve renderizzare |
| 7-36 (geolocation GPS) | ready-for-dev | Indipendente |
