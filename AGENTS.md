# AGENTS.md

> **Indice AI Agents (split)**: [.agents/docs/ai-agents/index.md](.agents/docs/ai-agents/index.md)
> Index completo: [.agents/docs/agents-guide/00-index.md](.agents/docs/agents-guide/00-index.md)

**Stack**: Laravel 12 | Filament v5 | Pest v4 | PHPStan L10 | PHP 8.3+

> Questo file è il punto di ingresso condiviso. I contenuti sono stati suddivisi in file tematici:
> - [Database Safety](.agents/docs/ai-agents/shared/database-safety.md)
> - [Bashscripts Philosophy](.agents/docs/ai-agents/shared/bashscripts-philosophy.md)
> - [Error Correction — 12 Steps](.agents/docs/ai-agents/shared/error-correction-12-steps.md)
> - [Translation Rules](.agents/docs/ai-agents/shared/translation-rules.md)
> - [Accessor/Mutator Pattern](.agents/docs/ai-agents/shared/accessor-mutator.md)
> - [Pattern SACRO Accessor](.agents/docs/accessor-auto-persistence.md)
> - [GSD Workflow](.agents/docs/ai-agents/shared/gsd-workflow.md)
> - [BMAD Workflow](.agents/docs/ai-agents/shared/bmad-workflow.md)
> - [Critical Rules](.agents/docs/ai-agents/shared/critical-rules.md)

## ⚠️ REGOLA CRITICA: Database SACRO 🔴

> **MAI eseguire**: `migrate:refresh`, `migrate:fresh`, `migrate:rollback`  
> **MAI usare**: `migrate --force` (manuale in produzione)  
> **SOLO eseguire**: `migrate` (forward-only)

Le migration Laraxot sono **IDEMPOTENTI** - usano `if (! $this->hasColumn())` e non cancellano mai dati.

**Perché**: I dati sono SACRI - `migrate:refresh` esegue `down()` che **CANCELLA TUTTO**.

**`--force` è PERICOLOSO**:
- ❌ MAI usarlo manualmente in produzione
- ✅ SOLO in CI/CD pipeline automatizzate
- SEMPRE backup e maintenance mode prima

📖 Vedi: `laravel/Modules/Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md`, `MAI_FARE_MIGRATE_FORCE.md`

---

## GSD (Get Shit Done) Integration

Questo progetto usa **GSD** per sviluppo spec-driven con context engineering.
GSD risolve il **context rot** — il degrado qualitativo quando il contesto dell'AI si riempie.

**Config GSD**: `.planning/config.json`
**State GSD**: `.planning/STATE.md`
**Templates**: `.gsd/templates/`
**Docs**: `docs/project/gsd-methodology.md`

→ Per workflow completo: usa `/gsd` (Windsurf) o "GSD {comando}" (Cursor)
→ Ciclo: `discuss → plan → execute → verify → complete`
→ Per task rapidi: `gsd quick "descrizione"`
→ Per stato: leggi `.planning/STATE.md`

### GSD Quick Commands

| Action | Command |
|--------|---------|
| New project | `/gsd` → `new-project` |
| Discuss phase | `/gsd` → `discuss N` |
| Plan phase | `/gsd` → `plan N` |
| Execute phase | `/gsd` → `execute N` |
| Verify work | `/gsd` → `verify N` |
| Quick task | `/gsd` → `quick "desc"` |
| Map codebase | `/gsd` → `map` |
| Progress | `/gsd` → `progress` |

## BMAD Method Integration

Questo progetto usa il **BMAD Method** (Breakthrough Method for Agile AI Driven Development) per workflow strutturati enterprise. BMAD eccelle nel trasformare idee vaghe in specifiche tecniche rigorose (Spec-Driven Development) attraverso una squadra di agenti specializzati.

**Configurazione BMAD**: `_bmad/` directory con workflow e configurazioni
**Catalog BMAD**: `_bmad/_config/bmad-help.csv` per tutti i workflow disponibili

→ Per guidanza: usa `bmad-help` skill o chiedi "cosa devo fare dopo?"
→ Per brainstorming: usa `bmad-brainstorming`
→ Per Spec: `bmad-create-prd` → `bmad-create-architecture` → `bmad-create-epics-and-stories`
→ Per Implementazione: `bmad-sprint-planning` → `bmad-dev-story`

### BMM (BMAD Method Modules) Workflow Catalog

| Phase | Workflow | Agent | Purpose |
|-------|----------|-------|---------|
| **Analysis** | `bmad-brainstorming` | Analyst | Ideazione e tecniche di facilitazione |
| **Analysis** | `bmad-create-product-brief` | Analyst | Definizione core dell'idea di prodotto |
| **Planning** | `bmad-create-prd` | PM | Generazione PRD standard 2025-2026 |
| **Planning** | `bmad-create-ux-design` | UX | User research e interaction design |
| **Solutioning**| `bmad-create-architecture` | Architect | Decisioni tecniche e schemi dati |
| **Solutioning**| `bmad-create-epics-and-stories`| PM | Scomposizione in task atomici |
| **Implementation**| `bmad-sprint-planning` | SM | Piano di sprint e sequenziamento |
| **Implementation**| `bmad-dev-story` | Dev | Esecuzione story e test (Story Cycle) |
| **Implementation**| `bmad-code-review` | Dev | Quality gate post-implementazione |
| **Anytime** | `bmad-help` | Facilitator | "What's Next" e guidanza agile |
| **Anytime** | `bmad-document-project` | Analyst | Analisi e documentazione codebase esistente |
| **Anytime** | `bmad-quick-dev` | Solo Dev | Workflow rapido per task isolati |

### Quando usare GSD vs BMAD

| Scenario | Framework |
|----------|-----------|
| Feature singola, refactoring | **GSD** |
| Bug fix complesso multi-file | **GSD** |
| Nuovo modulo completo | **BMAD** |
| Architettura, stakeholder alignment | **BMAD** |
| Sprint planning, epics, stories | **BMAD** |
| Quick task ad-hoc | **GSD quick** |

## Regola Fondamentale

**Read → Reason → Study → Update → Improve**

Prima di modificare: leggi → ragiona → studia → aggiorna docs → migliora.

After edit: PHPStan + PHPMD + PHPInsights.

---

## 🚫 REGOLA COSTITUZIONALE: Bashscripts è SACRO 🔴

> **`bashscripts/` DEVE rimanere nel `.gitignore`**  
> **NON è un bug - è una feature filosofica**

### La Filosofia in Breve

| bashscripts/ (Ignorato) | laravel/ (Tracciato) |
|------------------------|---------------------|
| 🛠️ Strumenti locali | 📦 Codice produzione |
| 🧪 Sperimentazione libera | ✅ Review richiesto |
| 📝 Personali | 🌍 Condiviso |
| 🔄 Mutevoli | 🗿 Eterno |

### Perché Questa Regola?

```
Il falegname non inchioda gli attrezzi al banco.
Gli attrezzi si cambiano, il mobile rimane.

bashscripts/ = Attrezzi
laravel/ = Mobile costruito
.gitignore = Banco che non fissa attrezzi
```

### Cosa FARE ✅

- Creare script in `bashscripts/` per automazione personale
- Sperimentare liberamente (v1, v2, v3...)
- Modificare senza commit
- Ottimizzare il TUO workflow

### Cosa NON FARE ❌

- `git add bashscripts/` (incostituzionale)
- Commitare script "temporanei"
- Confondere strumenti con codice
- Rimuovere `bashscripts/` da `.gitignore`

### Promozione a Codice

Se uno script diventa **produzione**:

1. Riscrivi come Action PHP o Workflow CI
2. Sposta in `laravel/` o `.github/workflows/`
3. Crea PR con review e test

📖 **Documentazione completa**: [docs/bashscripts-philosophy.md](docs/bashscripts-philosophy.md)

---

## 🚨 QUANDO RICEVI UN ERRORE DA CORREGGERE

> **SEGUITI 12 PASSI IN ORDINE - MAI SALTARNE NESSUNO**

### I 12 Passi Sacri

1. **STUDIARE** 📚 - Leggi docs esistenti (usa indici, no duplicati)
2. **AGGIORNARE DOCS** ✍️ - Prima di codificare, aggiorna documentazione
3. **STUDIARE GIT HISTORY** 📜 - Forward-only, MAI reset/revert
4. **CAPIRE LO SCOPO** 🎯 - A cosa serve? Business value?
5. **RAGIONARE** 🤔 - Pensa prima di agire
6. **AGGIORNARE REGOLE** 📖 - QWEN.md, memories, skills
7. **AGGIORNARE MEMORIES** 🧠 - Memoria a lungo termine
8. **AGGIORNARE SKILLS** 🛠️ - Pattern e conoscenze
9. **AGGIORNARE GUIDELINES** 📏 - Linee guida progetto
10. **GITHUB ISSUE** 📋 - Crea/aggiorna issue
11. **GITHUB ACTIONS** ⚙️ - Prevenzione CI/CD
12. **QUALITY GATES** ✅ - PHPStan + PHPMD + PHPInsights + Pest

### 🚫 MAI FARE

```bash
# Database SACRO
❌ migrate:refresh, migrate:fresh, db:wipe
❌ RefreshDatabase nei test
❌ migrate --force (manuale produzione)

# Git FORWARD-ONLY
❌ git reset --hard HEAD~N
❌ git checkout vecchie versioni
❌ git revert (se non forward fix)

# Documentazione
❌ Documenti doppi (usa indici)
❌ Timestamp nei filename
❌ Numerazione file (doc-1.md)
```

### ✅ SEMPRE FARE

```bash
# Quality dopo OGNI modifica
✅ PHPStan Level 10
✅ PHPMD
✅ PHPInsights
✅ Pest tests

# Multi-AI Coordination
✅ Leggi docs/ai-agent-coordination.md
✅ Controlla GitHub Issues
✅ Commit piccoli e frequenti
✅ Push ogni 5-10 minuti

# Git Remote
✅ git remote -v (verifica repo)
```

📖 **Workflow completo**: [docs/error-correction-workflow.md](docs/error-correction-workflow.md)

---

## 📚 REGOLE TRADUZIONI - CRITICAL 🔴

> **QUANDO MODIFICHI TRADUZIONI**  
> **SEGUITI QUESTE REGOLE IN ORDINE**

### Struttura OBBLIGATORIA

```php
// 1. Navigation (5 chiavi)
'navigation' => [
    'label' => 'Singolare',
    'plural_label' => 'Plurale',
    'group' => 'Gruppo',
    'icon' => 'heroicon-o-xxx',
    'sort' => 10,
],

// 2. Fields (5 chiavi per CAMPO)
'fields' => [
    'campo' => [
        'label' => 'Label Descrittiva',     // MAI 'campo'
        'placeholder' => 'Placeholder Utile',
        'helper_text' => 'Testo Aiuto',
        'description' => 'Descrizione',
        'tooltip' => 'Tooltip Info',
    ],
],

// 3. Actions (success/failure OBBLIGATORI)
'actions' => [
    'create' => [
        'label' => 'Crea Resource',
        'success' => 'Creato con successo',
        'failure' => 'Errore creazione',
    ],
],
```

### ❌ MAI FARE

```php
// MAI label = nome campo
'label' => 'matr',  // ❌ Deve essere 'Matricola'

// MAI placeholder = label
'placeholder' => 'Nome',  // ❌ Deve essere 'Inserisci nome'

// MAI chiavi mancanti
'fields' => [
    'email' => [
        'label' => 'Email',
        // ❌ Mancano 4 chiavi!
    ],
],

// MAI navigation incompleta
'navigation' => [
    'label' => 'Progetto',
    // ❌ Mancano 4 chiavi!
],
```

### ✅ SEMPRE FARE

1. **STUDIARE** `docs/translation-standards.md`
2. **USARE** struttura completa (5 chiavi per field)
3. **TRADURRE** label (MAI nomi tecnici)
4. **VERIFICARE** it/en/de coerenti
5. **TESTARE** in Filament UI
6. **QUALITY GATES**: PHPStan + PHPMD + Pest

📖 **Documentazione completa**: [docs/translation-standards.md](docs/translation-standards.md)  
📖 **Fix plan**: [docs/translation-errors-fix-plan.md](docs/translation-errors-fix-plan.md)

---

## 🔴 REGOLE ACCESSOR/MUTATOR - CRITICAL

> **QUANDO SCRIVI ACCESSOR O MUTATOR**  
> **SEGUITI QUESTE REGOLE IN ORDINE**

### Pattern SACRO

```php
// ✅ CORRETTO
protected function getAttribute(?float $value): ?float
{
    // 1. Controllo se il valore esiste già dal DB
    if (is_float($value)) {
        return $value;  // Già calcolato, torno subito
    }

    // 2. Calcolo complesso
    $result = $this->calculate();
    
    // 3. Persisto nel modello
    $this->attribute = $result;

    // 4. Persisto nel DB (solo se modello esiste)
    if ($this->getKey() !== null) {
        // 5. ActivityLog-Safe: prevengo ricorsione
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['attribute' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $result;
}
```

### ❌ MAI FARE

```php
// MAI usare mixed come tipo
protected function getAttribute(mixed $value): mixed  // ❌

// MAI ignorare il parametro con underscore
protected function getAttribute(mixed $_value)  // ❌

// MAI ricalcolare SEMPRE (ignori $value)
protected function getAttribute(?float $value): ?float
{
    return $this->calculate();  // ❌ Ignora $value!
}

// MAI aggiornare senza guard (ricorsione!)
protected function getAttribute(?float $value): ?float
{
    if ($value === null) {
        $this->update(['attribute' => 42]);  // ❌ CRASH!
    }
}
```

### ✅ SEMPRE FARE

1. **USARE** tipo forte (`?float`, `?string`, `?int`)
2. **CONTROLLARE** il valore (`is_float($value)`)
3. **PERSISTERE** il calcolo (`$this->attribute = $result`)
4. **AGGIORNARE** il DB (solo se `$this->exists`)
5. **USARE** guard per ActivityLog
6. **DOCUMENTARE** in `docs/accessor-mutator-philosophy.md`

📖 **Filosofia completa**: [docs/accessor-mutator-fix-summary.md](docs/accessor-mutator-fix-summary.md)  
📖 **Pattern SACRO**: [Sigma/docs/accessor-mutator-philosophy.md](laravel/Modules/Sigma/docs/accessor-mutator-philosophy.md)

---

## 🧘 I TRE LIVELLI DELL'ACCESSOR

### Livello 1: ❌ PRINCIPIANTE (Ignorante)

```php
protected function getAttribute(mixed $_value): int|float
{
    // ❌ mixed = tipo debole
    // ❌ $_value = ignorato
    // ❌ Ricalcola SEMPRE
    return $this->calculate();
}
```

### Livello 2: ✅ DISCEPOLO (Consapevole)

```php
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) {
        return $value;  // ✅ Uso DB
    }
    return $this->calculate();  // ❌ Nessuna persistenza
}
```

### Livello 3: 🧘 MAESTRO ZEN (Auto-Persistente)

```php
protected function getAttribute(?float $value): ?float
{
    private static bool $isUpdatingFromAccessor = false;
    
    if (is_float($value)) {
        return $value;  // ✅ Uso DB (1ms)
    }

    $result = $this->calculate();  // Calcolo (100ms)
    
    // ✅ AUTO-PERSISTENZA SACRA
    $this->attribute = $result;
    
    if ($this->getKey() !== null) {
        if (! static::$isUpdatingFromAccessor) {
            static::$isUpdatingFromAccessor = true;
            try {
                static::withoutEvents(function () use ($result): void {
                    $this->update(['attribute' => $result]);
                });
            } finally {
                static::$isUpdatingFromAccessor = false;
            }
        }
    }

    return $result;
}
```

**Performance**: 9.2x più veloce su 10 accessi

### ❌ MAI FARE

```php
// MAI Livello 1
protected function getAttribute(mixed $_value)  // ❌

// MAI Livello 2 (nessuna persistenza)
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;
    return $this->calculate();  // ❌ Non persisti!
}

// MAI senza guard
$this->update(['attribute' => $result]);  // ❌ CRASH!
```

### ✅ SEMPRE FARE

1. **RAGGIUNGERE** Livello 3 (auto-persistenza)
2. **USARE** tipo forte (`?float`, `?string`, `?int`)
3. **CONTROLLARE** `is_float($value)`
4. **PERSISTERE** automaticamente
5. **USARE** guard per ActivityLog
6. **DOCUMENTARE** in `docs/accessor-enlightenment-complete.md`

📖 **Illuminazione completa**: [docs/accessor-enlightenment-complete.md](docs/accessor-enlightenment-complete.md)  
📖 **Zen Level 3**: [docs/accessor-zen-level-3.md](docs/accessor-zen-level-3.md)  
📖 **Livello 4 (SUPREMO)**: [docs/accessor-level-4-supreme.md](docs/accessor-level-4-supreme.md)

---

## 🧘🧘 LIVELLO 4 - MAESTRO SUPREMO

### Pattern del Livello 4 (Delegazione + Purezza)

```php
// ✅ LIVELLO 4: Accessore PULITO (10 righe)
protected function getAttribute(?float $value): ?float
{
    if (is_float($value)) return $value;  // ✅ Cache
    
    // ✅ Delega calcolo a metodo separato
    $value = $this->calculateAttribute();
    
    // ✅ Persistenza PULITA
    if ($this->exists) {
        static::withoutEvents(function () use ($value): void {
            $this->update(['attribute' => $value]);
        });
    }
    
    return $value;
}

// ✅ Metodo separato per calcolo complesso
protected function calculateAttribute(): float
{
    // 50 righe di calcolo QUI
    // Accessore rimane PULITO
}
```

### Vantaggi del Livello 4

- ✅ **Accessore PULITO** (10 righe vs 100+)
- ✅ **Calcolo SEPARATO** (testabile)
- ✅ **Single Responsibility** (SOLID)
- ✅ **Manutenibilità ALTA**

---

## Quick Commands

| Action | Command |
|--------|---------|
| Tests | `./vendor/bin/pest` |
| PHPStan | `php -d memory_limit=2G ./vendor/bin/phpstan analyse` |
| Pint | `./vendor/bin/pint --dirty` |
| BMAD Help | Chiedi "bmad-help" o "cosa devo fare dopo?" |

→ [Dettagli](.agents/docs/agents-guide/02-tooling/quick-commands.md)

## Regole Critiche

## 🔴 REGOLA SACRALE: I DATI SONO SACRI

**MAI E POI MAI usare:**
- ❌ `php artisan migrate:fresh`
- ❌ `php artisan migrate:refresh`
- ❌ `php artisan db:wipe`
- ❌ `RefreshDatabase` trait nei test
- ❌ Qualsiasi comando che distrugge dati

**SEMPRE usare:**
- ✅ `php artisan migrate` (solo avanti, mai rollback)
- ✅ `DatabaseTransactions` nei test
- ✅ Backup prima di qualsiasi modifica schema

→ [Migration Safety Rules](.agents/docs/agents-guide/04-architecture/database-migration-safety.md)

---

- PHPStan Level 10 — no ignores
- `declare(strict_types=1)` always
- Short array `[]` — mai `array()`
- No `property_exists()` — usa `isset()`
- No constructor DI in Actions — usa `app(ActionClass::class)->execute()`
- No direct Filament — usa `XotBase*`
- No numbered filename suffixes (`-1.md`, `_2.md`) — edit in place, Git handles versioning
- Usa skill `markdown-filename-governance` per rename e prevenzione

→ [Tutte le regole](.agents/docs/agents-guide/04-architecture/critical-rules-summary.md)

## MCP

Config: `.cursor/mcp.json`

| Server | Purpose |
|--------|---------|
| filesystem | File operations |
| mysql | Database |
| playwright | Browser testing |
| git | Git operations |

→ [MCP details](docs/mcp/mcp-overview.md)
