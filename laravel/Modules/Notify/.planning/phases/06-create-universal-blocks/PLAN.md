# GSD Phase 06: Create Universal Block Views

**Phase ID**: 06-create-universal-blocks  
**Status**: 🟡 In Progress  
**Created**: 2026-03-30  
**Owner**: Amelia (BMAD Dev) + Multi-Agent Team

---

## 🎯 Goal

Create universal block views based on Flowbite, Tailwind UI, and DaisyUI taxonomy to replace incorrect `blocks/tests/*` pattern.

---

## 📊 Current State

**Block Views Required**: 20+  
**Block Views Existing**: 2  
**Compliance**: 10% 🔴

**Error**:
```
Unable to locate a class or view for component 
[pub_theme::components.blocks.tests.argomenti.topics-grid].
```

**Root Cause**: `tests` is NOT a valid block category.

---

## 📋 Tasks

### Priority 1: Navigation Blocks (1 hour)

#### Task 1.1: Create `navigation/breadcrumb.blade.php`

**Purpose**: Show page hierarchy  
**Variants**: default, with-icons, solid  
**Upstream**: https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html

**Template**:
```blade
@props(['items' => []])

<nav aria-label="Breadcrumb" class="breadcrumb">
    <ol class="breadcrumb-list">
        @foreach($items as $index => $item)
            <li class="breadcrumb-item {{ $index === count($items) - 1 ? 'active' : '' }}">
                @if($index === count($items) - 1)
                    <span aria-current="page">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 20 min

#### Task 1.2: Create `navigation/steps.blade.php`

**Purpose**: Show process steps  
**Variants**: default, vertical, responsive  
**Usage**: Appointment confirmation pages

**Template**:
```blade
@props(['steps' => []])

<div class="steps">
    <ol class="steps-list">
        @foreach($steps as $index => $step)
            <li class="step-item {{ $step['status'] ?? 'pending' }}">
                <span class="step-number">{{ $index + 1 }}</span>
                <span class="step-title">{{ $step['title'] }}</span>
                @if($step['description'])
                    <span class="step-description">{{ $step['description'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 20 min

#### Task 1.3: Create `navigation/tabs.blade.php`

**Purpose**: Tabbed content navigation  
**Variants**: default, underline, pills, vertical

**Template**:
```blade
@props(['tabs' => [], 'active' => 0])

<div role="tablist" class="tabs">
    @foreach($tabs as $index => $tab)
        <button 
            role="tab"
            class="tab {{ $index === $active ? 'tab-active' : '' }}"
            aria-selected="{{ $index === $active ? 'true' : 'false' }}">
            {{ $tab['label'] }}
        </button>
    @endforeach
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 20 min

### Priority 2: Hero Blocks (30 min)

#### Task 2.1: Create `hero/center.blade.php`

**Purpose**: Centered hero section  
**Variants**: center, left, right, with-image  
**Usage**: Argomenti, Homepage, Servizi

**Template**:
```blade
@props(['title' => '', 'subtitle' => '', 'content' => '', 'image' => null])

<section class="hero hero-center py-16">
    <div class="container">
        @if($image)
            <img src="{{ $image }}" alt="" class="hero-image mb-8">
        @endif
        
        @if($title)
            <h1 class="hero-title text-4xl font-bold text-uppercase mb-4">
                {{ $title }}
            </h1>
        @endif
        
        @if($subtitle)
            <h2 class="hero-subtitle text-xl mb-6">
                {{ $subtitle }}
            </h2>
        @endif
        
        @if($content)
            <div class="hero-content">
                {!! $content !!}
            </div>
        @endif
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

#### Task 2.2: Create `hero/left.blade.php`

**Purpose**: Left-aligned hero section  
**Variants**: left, right

**Template**:
```blade
@props(['title' => '', 'subtitle' => '', 'content' => '', 'image' => null])

<section class="hero hero-left py-16">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                @if($title)
                    <h1 class="hero-title text-4xl font-bold mb-4">
                        {{ $title }}
                    </h1>
                @endif
                
                @if($subtitle)
                    <h2 class="hero-subtitle text-xl mb-6">
                        {{ $subtitle }}
                    </h2>
                @endif
                
                @if($content)
                    <div class="hero-content">
                        {!! $content !!}
                    </div>
                @endif
            </div>
            
            @if($image)
                <div class="col-md-6">
                    <img src="{{ $image }}" alt="" class="hero-image img-fluid">
                </div>
            @endif
        </div>
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Priority 3: Content Blocks (1 hour)

#### Task 3.1: Create `content/text.blade.php`

**Purpose**: Main text content  
**Variants**: default, lead, columns, justified  
**Usage**: All pages

**Template**:
```blade
@props(['content' => '', 'columns' => 1])

<article class="content-text py-8">
    <div class="container">
        <div class="content-columns" style="column-count: {{ $columns }}">
            {!! $content !!}
        </div>
    </div>
</article>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

#### Task 3.2: Create `content/topics-grid.blade.php`

**Purpose**: Grid of topic cards  
**Variants**: default, featured, with-descriptions  
**Usage**: Argomenti page

**Template**:
```blade
@props(['title' => '', 'topics' => []])

<section class="topics-grid py-12">
    <div class="container">
        @if($title)
            <h2 class="topics-grid__title text-2xl font-bold text-uppercase mb-8">
                {{ $title }}
            </h2>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($topics as $topic)
                <div class="topic-card card">
                    <div class="card-body">
                        <h3 class="topic-card__title text-lg font-bold text-uppercase mb-2">
                            {{ $topic['title'] }}
                        </h3>
                        @if($topic['description'])
                            <p class="topic-card__description">
                                {{ $topic['description'] }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 30 min

#### Task 3.3: Create `content/cards.blade.php`

**Purpose**: General card grid  
**Variants**: grid, list, featured, with-sidebar

**Template**:
```blade
@props(['cards' => [], 'columns' => 3])

<div class="cards-grid py-8">
    <div class="container">
        <div class="grid gap-6" style="grid-template-columns: repeat({{ $columns }}, minmax(0, 1fr))">
            @foreach($cards as $card)
                <div class="card">
                    @if($card['image'])
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}" class="card-image">
                    @endif
                    <div class="card-body">
                        @if($card['title'])
                            <h3 class="card-title">{{ $card['title'] }}</h3>
                        @endif
                        @if($card['content'])
                            <p class="card-content">{{ $card['content'] }}</p>
                        @endif
                        @if($card['url'])
                            <a href="{{ $card['url'] }}" class="card-link">Read more</a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Priority 4: Marketing Blocks (1 hour)

#### Task 4.1: Create `marketing/features.blade.php`

**Purpose**: Feature showcase  
**Variants**: grid, list, with-icons, with-images, zigzag  
**Usage**: Homepage, Argomenti (featured section)

**Template**:
```blade
@props(['title' => '', 'items' => [], 'layout' => 'grid'])

<section class="features py-12">
    <div class="container">
        @if($title)
            <h2 class="features__title text-2xl font-bold text-uppercase mb-8">
                {{ $title }}
            </h2>
        @endif
        
        <div class="features-grid grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($items as $item)
                <div class="feature-item card">
                    <div class="card-body">
                        @if($item['icon'])
                            <div class="feature-icon mb-4">
                                <svg class="icon">
                                    <use href="#{{ $item['icon'] }}"></use>
                                </svg>
                            </div>
                        @endif
                        @if($item['title'])
                            <h3 class="feature-title text-lg font-bold text-uppercase">
                                {{ $item['title'] }}
                            </h3>
                        @endif
                        @if($item['description'])
                            <p class="feature-description">
                                {{ $item['description'] }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 30 min

#### Task 4.2: Create `marketing/cta.blade.php`

**Purpose**: Call to action section  
**Variants**: default, full-width, with-image, dark, with-form

**Template**:
```blade
@props(['title' => '', 'content' => '', 'buttonText' => '', 'buttonUrl' => '', 'image' => null])

<section class="cta py-16 {{ $image ? 'cta-with-image' : '' }}">
    <div class="container">
        <div class="cta-content text-center">
            @if($title)
                <h2 class="cta-title text-3xl font-bold mb-4">
                    {{ $title }}
                </h2>
            @endif
            
            @if($content)
                <p class="cta-content mb-8">
                    {!! $content !!}
                </p>
            @endif
            
            @if($buttonText && $buttonUrl)
                <a href="{{ $buttonUrl }}" class="btn btn-primary">
                    {{ $buttonText }}
                </a>
            @endif
        </div>
        
        @if($image)
            <div class="cta-image mt-8">
                <img src="{{ $image }}" alt="" class="w-full">
            </div>
        @endif
    </div>
</section>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 30 min

### Priority 5: Data Blocks (30 min)

#### Task 5.1: Create `data/description-list.blade.php`

**Purpose**: Key-value pairs display  
**Variants**: default, horizontal, bordered  
**Usage**: Appointment details, service info

**Template**:
```blade
@props(['title' => '', 'items' => []])

<div class="description-list py-6">
    @if($title)
        <h3 class="description-list__title text-xl font-bold mb-6">
            {{ $title }}
        </h3>
    @endif
    
    <dl class="description-list__grid grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($items as $label => $value)
            <div class="description-list__item">
                <dt class="description-list__label font-bold mb-1">
                    {{ $label }}
                </dt>
                <dd class="description-list__value">
                    {{ $value }}
                </dd>
            </div>
        @endforeach
    </dl>
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

#### Task 5.2: Create `data/stats.blade.php`

**Purpose**: Metrics display  
**Variants**: default, with-icon, with-chart, trend

**Template**:
```blade
@props(['stats' => []])

<div class="stats-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-8">
    @foreach($stats as $stat)
        <div class="stat-card card">
            <div class="card-body">
                @if($stat['icon'])
                    <div class="stat-icon mb-2">
                        <svg class="icon">
                            <use href="#{{ $stat['icon'] }}"></use>
                        </svg>
                    </div>
                @endif
                @if($stat['value'])
                    <div class="stat-value text-3xl font-bold">
                        {{ $stat['value'] }}
                    </div>
                @endif
                @if($stat['label'])
                    <div class="stat-label text-sm text-gray-600">
                        {{ $stat['label'] }}
                    </div>
                @endif
                @if($stat['trend'])
                    <div class="stat-trend {{ $stat['trend'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $stat['trend'] > 0 ? '↑' : '↓' }} {{ abs($stat['trend']) }}%
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

### Priority 6: Feedback Blocks (30 min)

#### Task 6.1: Create `feedback/alert.blade.php`

**Purpose**: Alert messages  
**Variants**: default, dismissible, with-icon, colors

**Template**:
```blade
@props(['type' => 'info', 'title' => '', 'message' => '', 'dismissible' => false])

<div class="alert alert-{{ $type }} py-4 px-6 mb-6" role="alert">
    <div class="container">
        @if($title)
            <h3 class="alert-title font-bold mb-2">
                {{ $title }}
            </h3>
        @endif
        
        @if($message)
            <div class="alert-message">
                {!! $message !!}
            </div>
        @endif
        
        @if($dismissible)
            <button class="alert-close" aria-label="Close">
                <svg class="icon"><use href="#it-close"></use></svg>
            </button>
        @endif
    </div>
</div>
```

**Owner**: Amelia  
**Status**: ⏳ Pending  
**ETA**: 15 min

#### Task 6.2: Create `feedback/banner.blade.php`

**Purpose**: Announcement bars  
**Variants**: top, bottom, cookie, sticky

**Template**:
```blade
@props(['position' => 'top', 'message' => '', 'buttonText' => '', 'buttonUrl' => ''])

<div class="banner banner-{{ $position }} py-3 px-6">
    <div class="container">
        <div class="banner-content flex items-center justify-between">
            <div class="banner-message">
                {!! $message !!}
            </div>
            
            @if($buttonText && $buttonUrl)
                <a href="{{ $buttonUrl }}" class="btn btn-sm btn-primary">
                    {{ $buttonText }}
                </a>
            @endif
        </div>
    </div>
</div>
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
   - [ ] JSON pages caricano senza errori
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
| Views Created | 14 | 0 | 🔴 |
| JSON Pages Fixed | 38 | 0 | 🔴 |
| Test Coverage | 100% | 0% | 🔴 |
| Visual Match | 95%+ | 0% | 🔴 |

---

## 🤖 Agent Coordination

### BMAD Agents

| Agent | Role | Tasks |
|-------|------|-------|
| **Amelia (Dev)** | Implementation | Task 1.1-6.2 |
| **Winston (Architect)** | Architecture | Block taxonomy validation |
| **Sally (UX)** | Design | AGID compliance review |
| **Paige (Tech Writer)** | Documentation | Update docs |

### GSD Workflow

```
.discuss → .plan → .execute → .verify
```

### OpenViking Context

```bash
openviking add-memory "Universal block taxonomy: 10 categories (navigation, hero, marketing, content, layout, data, forms, feedback, ecommerce, dashboard) from Flowbite/TailwindUI/DaisyUI"
```

---

## 📝 Execution Log

### 2026-03-30 - Phase Start

**Agent**: Multi-Agent Team  
**Status**: 🟡 In Progress

**Notes**:
- Universal taxonomy definita
- Documentation completata
- Inizio implementazione views

---

**Next Update**: Dopo Priority 1 completion  
**ETA**: 4.5 ore  
**Blockers**: Nessuno
