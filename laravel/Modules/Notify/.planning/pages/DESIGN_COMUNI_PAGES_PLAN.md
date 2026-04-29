# 🎨 Design Comuni Pages - AI-Powered Creation Plan

**Date**: 2026-03-30  
**Status**: 🟡 **IN PROGRESS**  
**AI Tools**: OpenViking + BMAD + GSD + NotebookLM + Ralph Loop

---

## 📊 Pages to Create (35 remaining)

### Priority 0 (Critical) - 8 pages
- [x] homepage ✅
- [x] argomenti ✅
- [x] appuntamento-06-conferma ✅
- [ ] servizi
- [ ] eventi
- [ ] novita
- [ ] appuntamento-01-ufficio
- [ ] appuntamento-02-data-orario
- [ ] appuntamento-03-dettagli
- [ ] appuntamento-04-richiedente
- [ ] appuntamento-04-richiedente-autenticato
- [ ] appuntamento-05-riepilogo

### Priority 1 (High) - 12 pages
- [ ] assistenza-01-dati
- [ ] assistenza-02-conferma
- [ ] segnalazione-dettaglio
- [ ] segnalazione-01-privacy
- [ ] segnalazione-02-dati
- [ ] segnalazione-03-riepilogo
- [ ] segnalazione-04-conferma
- [ ] segnalazione-area-personale
- [ ] segnalazioni-elenco
- [ ] homepage (alternate)
- [ ] amministrazione
- [ ] documenti-dati

### Priority 2 (Medium) - 15 pages
- [ ] novita-dettaglio
- [ ] evento-dettaglio
- [ ] servizio-dettaglio
- [ ] servizi-categoria
- [ ] argomento (single)
- [ ] lista-risorse
- [ ] lista-categorie
- [ ] lista-risorse-categorie
- [ ] mappa-sito
- [ ] domande-frequenti
- [ ] risultati-ricerca
- [ ] auth pages
- [ ] error pages
- [ ] custom pages

---

## 🤖 AI Tool Assignment

### OpenViking - Context Management
**Purpose**: Store and retrieve page specifications
**Usage**:
```bash
openviking add-memory "Page: servizi - Service catalog page with grid layout, filters, search"
openviking search "appuntamento pages structure"
```

### BMAD - Requirements & Architecture
**Purpose**: Define page requirements and component architecture
**Usage**:
```
/bmad-create-prd "Create servizi page with service grid, filters, and search"
/bmad-create-architecture "Service page component structure"
```

### GSD - Phase Execution
**Purpose**: Execute page creation in phases
**Usage**:
```
/gsd-discuss-phase "Create P0 pages"
/gsd-plan-phase "Create P0 pages"
/gsd-execute-phase "Create P0 pages"
```

### NotebookLM - Source-Grounded Research
**Purpose**: Research Design Comuni patterns from reference pages
**Usage**:
```
"Research https://italia.github.io/design-comuni-pagine-statiche/sito/servizi.html"
"Extract page structure, components, and layout patterns"
```

### Ralph Loop - Autonomous Implementation
**Purpose**: Create pages autonomously based on specs
**Usage**:
```bash
cp .planning/pages/servizi.json .ralph/prd.json
./.ralph/ralph-loop.sh 20 true
```

---

## 📋 Page Templates

### Template 1: Service Catalog (servizi)
```blade
@extends('layouts.app')

@section('content')
<main class="container">
    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => '/it'],
        ['label' => 'Servizi', 'url' => '/it/servizi'],
    ]" />
    
    {{-- Page Header --}}
    <x-blocks.hero.hero :data="[
        'title' => 'Servizi',
        'subtitle' => 'Tutti i servizi del Comune',
    ]" />
    
    {{-- Search & Filters --}}
    <x-blocks.form.search :data="['placeholder' => 'Cerca servizio...']" />
    <x-blocks.filter.categories :data="['categories' => $categories]" />
    
    {{-- Services Grid --}}
    <x-blocks.grid.grid :data="[
        'columns' => 3,
        'items' => $services,
    ]">
        <x-slot name="item">
            <x-blocks.card.card :data="$service" />
        </x-slot>
    </x-blocks.grid.grid>
    
    {{-- Pagination --}}
    <x-blocks.navigation.pagination :data="['items' => $services]" />
</main>
@endsection
```

### Template 2: Appointment Steps (appuntamento-XX)
```blade
@extends('layouts.app')

@section('content')
<main class="container">
    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="$breadcrumbs" />
    
    {{-- Progress Stepper --}}
    <x-blocks.steps.steps :data="[
        'steps' => [
            ['number' => 1, 'title' => 'Ufficio', 'completed' => true],
            ['number' => 2, 'title' => 'Data e Ora', 'active' => true],
            ['number' => 3, 'title' => 'Dettagli', 'pending' => true],
            ['number' => 4, 'title' => 'Richiedente', 'pending' => true],
            ['number' => 5, 'title' => 'Riepilogo', 'pending' => true],
            ['number' => 6, 'title' => 'Conferma', 'pending' => true],
        ]
    ]" />
    
    {{-- Form Content --}}
    @yield('appointment-form')
</main>
@endsection
```

### Template 3: News/Events Listing (novita/eventi)
```blade
@extends('layouts.app')

@section('content')
<main class="container">
    {{-- Breadcrumbs --}}
    <x-breadcrumbs :items="[
        ['label' => 'Home', 'url' => '/it'],
        ['label' => 'Novità', 'url' => '/it/novita'],
    ]" />
    
    {{-- Page Header --}}
    <x-blocks.hero.hero :data="[
        'title' => 'Novità',
        'subtitle' => 'Ultime notizie dal Comune',
    ]" />
    
    {{-- Filters --}}
    <x-blocks.filter.categories :data="['categories' => $categories]" />
    
    {{-- News Grid --}}
    <div class="row g-4">
        @foreach($news as $item)
        <div class="col-12 col-md-6 col-lg-4">
            <x-blocks.card.card :data="$item" />
        </div>
        @endforeach
    </div>
    
    {{-- Pagination --}}
    <x-blocks.navigation.pagination :data="['items' => $news]" />
</main>
@endsection
```

---

## 🔄 AI Workflow

### Step 1: OpenViking Context Setup
```bash
openviking add-memory "Design Comuni pages: 38 total, 3 created, 35 remaining"
openviking add-memory "Page structure: breadcrumbs, hero, content, footer"
openviking add-memory "Components: blocks/hero, blocks/card, blocks/steps, blocks/grid"
```

### Step 2: BMAD Requirements
```
/bmad-create-prd "Create 8 P0 pages for Design Comuni"
/bmad-create-architecture "Page architecture with reusable blocks"
```

### Step 3: GSD Planning
```
/gsd-discuss-phase "Create P0 pages (servizi, eventi, novita, appuntamento)"
/gsd-plan-phase "Create P0 pages"
```

### Step 4: NotebookLM Research
```
"Research Design Comuni page patterns"
"Extract component structure from reference pages"
"Document layout patterns for service pages"
```

### Step 5: Ralph Loop Implementation
```bash
# Create PRD for each page
cat > .ralph/prd.json << 'EOF'
{
    "page": "servizi",
    "route": "/it/servizi",
    "components": ["breadcrumbs", "hero", "search", "filters", "grid", "pagination"],
    "blocks": ["hero.hero", "form.search", "filter.categories", "grid.grid", "card.card"]
}
EOF

# Execute
./.ralph/ralph-loop.sh 20 true
```

---

## 📊 Progress Tracking

| Phase | Pages | Status | AI Tool |
|-------|-------|--------|---------|
| **P0** | 8 | 🟡 3/8 (38%) | Ralph Loop |
| **P1** | 12 | ⚪ 0/12 | Pending |
| **P2** | 15 | ⚪ 0/15 | Pending |

---

## ✅ Checklist

### Setup
- [x] OpenViking initialized
- [ ] BMAD PRD created
- [ ] GSD phase planned
- [ ] NotebookLM research done
- [ ] Ralph Loop configured

### P0 Pages
- [x] homepage
- [x] argomenti
- [x] appuntamento-06-conferma
- [ ] servizi
- [ ] eventi
- [ ] novita
- [ ] appuntamento-01-ufficio
- [ ] appuntamento-02-data-orario
- [ ] appuntamento-03-dettagli
- [ ] appuntamento-04-richiedente
- [ ] appuntamento-04-richiedente-autenticato
- [ ] appuntamento-05-riepilogo

### P1 Pages
- [ ] assistenza-01-dati
- [ ] assistenza-02-conferma
- [ ] segnalazione-dettaglio
- [ ] segnalazione-01-privacy
- [ ] segnalazione-02-dati
- [ ] segnalazione-03-riepilogo
- [ ] segnalazione-04-conferma
- [ ] segnalazione-area-personale
- [ ] segnalazioni-elenco
- [ ] amministrazione
- [ ] documenti-dati
- [ ] novita-dettaglio

### P2 Pages
- [ ] evento-dettaglio
- [ ] servizio-dettaglio
- [ ] servizi-categoria
- [ ] argomento (single)
- [ ] lista-risorse
- [ ] lista-categorie
- [ ] lista-risorse-categorie
- [ ] mappa-sito
- [ ] domande-frequenti
- [ ] risultati-ricerca
- [ ] auth pages
- [ ] error pages
- [ ] custom pages

---

**Status**: 🟡 **IN PROGRESS**  
**Next**: Execute Ralph Loop for P0 pages  
**ETA**: 4h for P0, 8h for P1, 8h for P2

**AI-powered page creation initiated! 🤖🚀**
