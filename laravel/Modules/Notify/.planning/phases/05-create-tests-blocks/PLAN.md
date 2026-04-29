# GSD Phase 05: Create Tests Block Views

**Phase ID**: 05-create-tests-blocks  
**Status**: 🟡 In Progress  
**Created**: 2026-03-30  
**Owner**: Amelia (BMAD Dev) + Multi-Agent Team

---

## 🎯 Goal

Creare tutte le block views mancanti per la directory `tests/` per rendere functional le 38 JSON pages convertite.

---

## 📊 Current State

**Block Views Required**: 7
**Block Views Existing**: 0
**Compliance**: 0% 🔴

| View Name | Usage Count | Status |
|-----------|-------------|--------|
| `tests/intro` | 30 | ❌ Missing |
| `tests/body` | 28 | ❌ Missing |
| `tests/governance-note` | 30 | ❌ Missing |
| `tests/source-link` | 30 | ❌ Missing |
| `tests/argomenti` | 1 | ❌ Missing |
| `tests/appuntamento-conferma` | 1 | ❌ Missing |
| `tests/reference-page` | 1 | ❌ Missing |

---

## 📋 Tasks

### Task 1: Create Directory Structure

```bash
mkdir -p laravel/Themes/Sixteen/resources/views/components/blocks/tests/
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 5 min

### Task 2: Create `intro.blade.php`

**Purpose**: Hero/intro section per tutte le pagine tests  
**Usage**: 30 JSON files  
**Content**:
- Title (uppercase)
- Subtitle (optional)
- Intro paragraph

**Template**:
```blade
@props(['title' => '', 'subtitle' => '', 'content' => ''])

<section class="test-intro py-5">
    <div class="container">
        @if($title)
            <h1 class="test-intro__title text-uppercase mb-3">{{ $title }}</h1>
        @endif
        
        @if($subtitle)
            <h2 class="test-intro__subtitle mb-3">{{ $subtitle }}</h2>
        @endif
        
        @if($content)
            <div class="test-intro__content">{!! $content !!}</div>
        @endif
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Task 3: Create `body.blade.php`

**Purpose**: Main content body  
**Usage**: 28 JSON files  
**Content**:
- Flexible content area
- Support for nested blocks

**Template**:
```blade
@props(['content' => ''])

<article class="test-body py-4">
    <div class="container">
        <div class="test-body__content">
            {!! $content !!}
        </div>
    </div>
</article>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Task 4: Create `governance-note.blade.php`

**Purpose**: Governance information box  
**Usage**: 30 JSON files  
**Content**:
- Governance note text
- Styled as info box

**Template**:
```blade
@props(['note' => ''])

@if($note)
    <div class="test-governance-note alert alert-info my-4" role="alert">
        <div class="container">
            <div class="test-governance-note__content">
                {!! $note !!}
            </div>
        </div>
    </div>
@endif
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Task 5: Create `source-link.blade.php`

**Purpose**: Link to upstream source  
**Usage**: 30 JSON files  
**Content**:
- Source URL
- Link text
- External link icon

**Template**:
```blade
@props(['url' => '', 'label' => 'Vedi pagina di riferimento'])

@if($url)
    <div class="test-source-link my-3">
        <div class="container">
            <a href="{{ $url }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="test-source-link__link btn btn-outline-primary btn-sm">
                {{ $label }}
                <svg class="icon icon-primary icon-xs">
                    <use href="#it-external"></use>
                </svg>
            </a>
        </div>
    </div>
@endif
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Task 6: Create `argomenti.blade.php`

**Purpose**: Argomenti page grid  
**Usage**: 1 JSON file (tests.argomenti)  
**Content**:
- Featured cards (3 items)
- Topic grid (18+ items)
- AGID-compliant styling

**Template**:
```blade
@props(['featured' => [], 'topics' => []])

<section class="test-argomenti py-5">
    <div class="container">
        {{-- Featured Section --}}
        @if(count($featured) > 0)
            <div class="test-argomenti__featured mb-5">
                <h2 class="test-argomenti__section-title text-uppercase mb-4">In Evidenza</h2>
                <div class="row g-4">
                    @foreach($featured as $item)
                        <div class="col-md-4">
                            <div class="test-argomenti__card card">
                                <div class="card-body">
                                    <h3 class="card-title text-uppercase">{{ $item['title'] }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        {{-- Topics Grid --}}
        @if(count($topics) > 0)
            <div class="test-argomenti__topics">
                <h2 class="test-argomenti__section-title text-uppercase mb-4">Esplora per Argomento</h2>
                <div class="row g-4">
                    @foreach($topics as $topic)
                        <div class="col-md-6 col-lg-4">
                            <div class="test-argomenti__topic card">
                                <div class="card-body">
                                    <h3 class="card-title text-uppercase mb-2">{{ $topic['title'] }}</h3>
                                    @if($topic['description'])
                                        <p class="card-text">{{ $topic['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
```

**Owner**: Amelia + Sally (UX)  
**Status**: ⏳ Pending  
**ETA**: 30 min

### Task 7: Create `appuntamento-conferma.blade.php`

**Purpose**: Appointment confirmation page  
**Usage**: 1 JSON file (tests.appuntamento-06-conferma)  
**Content**:
- Steps summary
- Appointment details
- Confirmation message
- Next actions

**Template**:
```blade
@props(['steps' => [], 'details' => []])

<section class="test-appuntamento-conferma py-5">
    <div class="container">
        {{-- Confirmation Message --}}
        <div class="test-appuntamento-conferma__message alert alert-success mb-5">
            <h2 class="test-appuntamento-conferma__title text-uppercase mb-3">
                Appuntamento Confermato
            </h2>
            <p class="mb-0">La tua richiesta è stata registrata con successo</p>
        </div>
        
        {{-- Steps Summary --}}
        @if(count($steps) > 0)
            <div class="test-appuntamento-conferma__steps mb-5">
                <h3 class="mb-4">Riepilogo Passaggi</h3>
                <div class="row g-3">
                    @foreach($steps as $index => $step)
                        <div class="col-md-4">
                            <div class="test-appuntamento-conferma__step card bg-success text-white">
                                <div class="card-body">
                                    <div class="test-appuntamento-conferma__step-number mb-2">
                                        Step {{ $index + 1 }}
                                    </div>
                                    <h4 class="test-appuntamento-conferma__step-title">
                                        {{ $step['title'] }}
                                    </h4>
                                    @if($step['description'])
                                        <p class="test-appuntamento-conferma__step-desc mb-0">
                                            {{ $step['description'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        {{-- Appointment Details --}}
        @if(count($details) > 0)
            <div class="test-appuntamento-conferma__details card mb-5">
                <div class="card-body">
                    <h3 class="mb-4">Dettagli Appuntamento</h3>
                    <dl class="row">
                        @foreach($details as $label => $value)
                            <dt class="col-sm-4">{{ $label }}</dt>
                            <dd class="col-sm-8">{{ $value }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        @endif
        
        {{-- Actions --}}
        <div class="test-appuntamento-conferma__actions">
            <a href="/" class="btn btn-primary">Torna alla Home</a>
            <a href="#" class="btn btn-outline-primary">Scarica PDF</a>
        </div>
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 30 min

### Task 8: Create `reference-page.blade.php`

**Purpose**: Generic reference page wrapper  
**Usage**: 1 JSON file (tests.reference-page)  
**Content**:
- Page title
- Category
- Summary
- Source link

**Template**:
```blade
@props(['title' => '', 'category' => '', 'summary' => '', 'source_url' => ''])

<article class="test-reference-page py-5">
    <div class="container">
        <header class="test-reference-page__header mb-4">
            <h1 class="test-reference-page__title text-uppercase mb-2">
                {{ $title }}
            </h1>
            
            @if($category)
                <div class="test-reference-page__category badge bg-primary mb-3">
                    {{ $category }}
                </div>
            @endif
            
            @if($summary)
                <p class="test-reference-page__summary lead">
                    {{ $summary }}
                </p>
            @endif
        </header>
        
        @if($source_url)
            <div class="test-reference-page__source mt-4">
                <a href="{{ $source_url }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn btn-outline-primary btn-sm">
                    Vedi pagina di riferimento
                    <svg class="icon icon-primary icon-xs">
                        <use href="#it-external"></use>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</article>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

---

## 🧪 Testing

### Test Plan

1. **Unit Tests**:
   - [ ] Ogni view renderizza senza errori
   - [ ] Props opzionali gestite correttamente
   - [ ] HTML output è valido

2. **Integration Tests**:
   - [ ] JSON pages caricano senza errori 500
   - [ ] Block views sono chiamate correttamente
   - [ ] Styling AGID-compliant

3. **Visual Tests**:
   - [ ] Screenshot comparison con upstream
   - [ ] 95%+ visual match
   - [ ] Responsive su mobile/tablet/desktop

### Test Commands

```bash
# Run tests
php artisan test --filter=BlockViewsTest

# Visual verification
./bashscripts/docs/capture-screenshots.sh argomenti

# Validate views
./bashscripts/docs/validate-block-views.sh
```

---

## 📊 Success Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Views Create | 7 | 0 | 🔴 |
| JSON Pages Functional | 38 | 0 | 🔴 |
| Test Coverage | 100% | 0% | 🔴 |
| Visual Match | 95%+ | 0% | 🔴 |

---

## 🤖 Agent Coordination

### BMAD Agents

| Agent | Role | Tasks |
|-------|------|-------|
| **Amelia (Dev)** | Implementation | Task 1-8 |
| **Sally (UX)** | Design Review | Task 6 styling |
| **Winston (Architect)** | Architecture | Naming convention |
| **Paige (Tech Writer)** | Documentation | This file + reports |

### GSD Workflow

```
.discuss → .plan → .execute → .verify
```

### OpenViking Context

```bash
openviking add-memory \
  --title="Block Views Creation Phase 05" \
  --content="Creating 7 block views for tests/ directory"
```

---

## 📝 Execution Log

### 2026-03-30 - Phase Start

**Agent**: Multi-Agent Team  
**Status**: 🟡 In Progress

**Notes**:
- Directory structure creata
- Documentation completata
- Inizio implementazione views

---

**Next Update**: Dopo Task 1 completion  
**ETA**: 2 ore  
**Blockers**: Nessuno
