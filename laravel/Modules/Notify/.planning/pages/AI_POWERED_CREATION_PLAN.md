# 🤖 AI-Powered Page Creation - Master Plan

**Date**: 2026-03-30  
**Mission**: Create 32 remaining Design Comuni pages  
**AI Tools**: OpenViking + BMAD + GSD + NotebookLM + Ralph Loop

---

## 📊 Current Status

**Total Pages**: 38  
**Created**: 6 (16%)  
**Remaining**: 32 (84%)

### Completed Pages ✅
1. homepage
2. argomenti
3. appuntamento-06-conferma
4. servizi
5. eventi
6. appuntamento-01-ufficio

---

## 🎯 AI Tool Coordination

### OpenViking - Central Context Hub
```bash
# Store page specs
openviking add-memory "Page: novita - News listing with date filter, categories, grid"

# Retrieve patterns
openviking search "appointment page structure"

# Track progress
openviking add-memory "Pages created: 6/38, P0: 6/8, P1: 0/12, P2: 0/18"
```

### BMAD - Requirements & Architecture
```
/bmad-create-prd "Create 32 Design Comuni pages with reusable blocks"
/bmad-create-architecture "Page architecture: breadcrumbs, hero, content, footer"
/bmad-create-epics-and-stories "Break into P0, P1, P2 epics"
```

### GSD - Phase Execution
```
/gsd-new-milestone "Design_Comuni_Pages"
/gsd-discuss-phase "Create P0 pages (6 remaining)"
/gsd-plan-phase "Create P0 pages"
/gsd-execute-phase "Create P0 pages"
```

### NotebookLM - Source-Grounded Research
```
"Research Design Comuni page patterns from reference"
"Extract component structure for news pages"
"Document appointment flow patterns"
```

### Ralph Loop - Autonomous Implementation
```bash
# For each page
cp .planning/pages/prd-{page}.json .ralph/prd.json
./.ralph/ralph-loop.sh 20 true
```

---

## 📋 Batch 1: P0 Pages (6 remaining) - CRITICAL

### 1. Novità (News Listing)
**File**: `tests/novita.blade.php`  
**Components**: breadcrumbs, hero, filters, news grid, pagination  
**PRD**: `.planning/pages/prd-novita.json`

### 2. Appuntamento-02-Data-Orario
**File**: `tests/appuntamento-02-data-orario.blade.php`  
**Components**: breadcrumbs, stepper, calendar, time slots, navigation  
**PRD**: `.planning/pages/prd-appuntamento-02.json`

### 3. Appuntamento-03-Dettagli
**File**: `tests/appuntamento-03-dettagli.blade.php`  
**Components**: breadcrumbs, stepper, form fields, navigation  
**PRD**: `.planning/pages/prd-appuntamento-03.json`

### 4. Appuntamento-04-Richiedente
**File**: `tests/appuntamento-04-richiedente.blade.php`  
**Components**: breadcrumbs, stepper, personal info form, navigation  
**PRD**: `.planning/pages/prd-appuntamento-04.json`

### 5. Appuntamento-04-Richiedente-Autenticato
**File**: `tests/appuntamento-04-richiedente-autenticato.blade.php`  
**Components**: breadcrumbs, stepper, confirmed data, navigation  
**PRD**: `.planning/pages/prd-appuntamento-04-auth.json`

### 6. Appuntamento-05-Riepilogo
**File**: `tests/appuntamento-05-riepilogo.blade.php`  
**Components**: breadcrumbs, stepper, summary, edit buttons, navigation  
**PRD**: `.planning/pages/prd-appuntamento-05.json`

---

## 📋 Batch 2: P1 Pages (12 pages) - HIGH

### Assistenza Flow (2 pages)
- assistenza-01-dati
- assistenza-02-conferma

### Segnalazione Flow (5 pages)
- segnalazione-dettaglio
- segnalazione-01-privacy
- segnalazione-02-dati
- segnalazione-03-riepilogo
- segnalazione-04-conferma

### Additional Pages (5 pages)
- segnalazione-area-personale
- segnalazioni-elenco
- amministrazione
- documenti-dati
- novita-dettaglio

---

## 📋 Batch 3: P2 Pages (18 pages) - MEDIUM

### Dettaglio Pages (3 pages)
- evento-dettaglio
- servizio-dettaglio
- argomento (single)

### Liste Pages (3 pages)
- lista-risorse
- lista-categorie
- lista-risorse-categorie

### Utility Pages (4 pages)
- mappa-sito
- domande-frequenti
- risultati-ricerca
- auth pages

### Error Pages (4 pages)
- 404
- 500
- maintenance
- unauthorized

### Custom Pages (4 pages)
- custom templates
- landing pages
- special pages

---

## 🔄 Execution Workflow

### Step 1: OpenViking Setup (5 min)
```bash
openviking add-memory "Starting batch page creation with AI tools"
openviking add-memory "Pattern: Single root div, filament icons, block components"
openviking add-memory "Components: breadcrumbs, hero, steps, grid, card, pagination"
```

### Step 2: BMAD PRD Creation (10 min per batch)
```
/bmad-create-prd "Create P0 pages: novita, appuntamento-02 to 05"
```

### Step 3: GSD Planning (5 min per batch)
```
/gsd-discuss-phase "Create P0 pages"
/gsd-plan-phase "Create P0 pages"
```

### Step 4: NotebookLM Research (10 min per batch)
```
"Research appointment booking flow patterns"
"Extract news page structure from Design Comuni"
```

### Step 5: Ralph Loop Execution (20 min per page)
```bash
for page in novita appuntamento-02 appuntamento-03 appuntamento-04 appuntamento-04-auth appuntamento-05; do
  cp .planning/pages/prd-${page}.json .ralph/prd.json
  ./.ralph/ralph-loop.sh 20 true
done
```

---

## ⏱️ Time Estimates

| Batch | Pages | Time | ETA |
|-------|-------|------|-----|
| **P0** | 6 | 2h | Today |
| **P1** | 12 | 4h | Tomorrow |
| **P2** | 18 | 6h | Day 3 |

**Total**: 12h for all 32 pages

---

## ✅ Success Criteria

### Code Quality
- ✅ Single root `<div>` for Livewire/Volt
- ✅ `<x-filament::icon>` for all icons
- ✅ Block components reused
- ✅ Breadcrumbs on all pages
- ✅ Responsive grid layouts

### AI Tool Usage
- ✅ OpenViking: Context stored
- ✅ BMAD: PRDs created
- ✅ GSD: Phases planned
- ✅ NotebookLM: Research done
- ✅ Ralph Loop: Pages generated

---

**Status**: 🟡 **READY TO EXECUTE**  
**Next**: Start Batch 1 (P0 pages)  
**ETA**: 2h for 6 pages

**AI-powered page creation initiated! 🤖🚀**
