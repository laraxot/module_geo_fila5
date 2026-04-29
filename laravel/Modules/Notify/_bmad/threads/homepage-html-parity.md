# 🧵 BMAD Thread: Homepage HTML Parity

**Created**: 2026-03-30  
**Status**: 🔴 **CRITICAL**  
**Priority**: P0  
**Owner**: Multi-Agent Team

---

## 🎯 Goal

Rendere l'HTML dentro `<body>` di FixCity **IDENTICO** all'upstream AGID.

**Upstream**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**FixCity**: http://fixcity.local/it/tests/homepage

---

## 📋 Requirements

### R1: HTML Structure Parity
- [ ] Same tag hierarchy
- [ ] Same CSS classes (exact names)
- [ ] Same data-* attributes
- [ ] Same ARIA attributes
- [ ] Same text content (Italian)

### R2: Sections Parity
- [ ] Header (slim + main + navbar)
- [ ] Hero section
- [ ] Featured news (contenuti in evidenza)
- [ ] Governance cards (organi di governo)
- [ ] Events calendar
- [ ] Topics highlight (argomenti in evidenza)
- [ ] Thematic sites (siti tematici)
- [ ] Useful links + search
- [ ] Feedback rating
- [ ] Footer (4 sections)

### R3: Technical Parity
- [ ] Superpowers integration
- [ ] JSON-driven content
- [ ] Block views match structure
- [ ] Filament 5 icons
- [ ] Bootstrap Italia classes

---

## 🤖 Multi-Agent Assignment

### BMAD Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **John (PM)** | Requirements | Define parity metrics |
| **Winston (Architect)** | Architecture | HTML structure mapping |
| **Sally (UX)** | AGID Compliance | Visual parity |
| **Paige (Tech Writer)** | Documentation | Parity report |
| **Amelia (Dev)** | Implementation | JSON + blocks |

### GSD Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **gsd-planner** | Planning | Phase breakdown |
| **gsd-executor** | Execution | Update JSON/blocks |
| **gsd-verifier** | Verification | HTML diff |

### Other Agents
| Agent | Role | Tasks |
|-------|------|-------|
| **Ralph Loop** | Automation | Batch updates |
| **OpenViking** | Context | Memory preservation |
| **NotebookLM** | Research | AGID structure |

---

## 📐 Architecture

### Current Flow
```
/it/tests/homepage
    ↓
[slug].blade.php
    ↓
tests.homepage.json
    ↓
<x-page side="content" :slug="$pageSlug" :data="$data" />
    ↓
@foreach($content_blocks as $block)
    @include($block['data']['view'], $block['data'])
    ↓
HTML Output
```

### Target Structure (from upstream)
```html
<body>
  <!-- Header -->
  <div class="it-header-wrapper">
    <div class="it-header-slim-wrapper">...</div>
    <div class="it-header-main-wrapper">...</div>
    <nav class="navbar navbar-expand-lg">...</nav>
  </div>
  
  <!-- Main -->
  <main class="container" id="main">
    <!-- Hero -->
    <section class="hero-section">...</section>
    
    <!-- Featured News -->
    <section class="featured-news">...</section>
    
    <!-- Governance -->
    <section class="governance-section">...</section>
    
    <!-- Events -->
    <section class="events-section">...</section>
    
    <!-- Topics -->
    <section class="topics-section">...</section>
    
    <!-- Thematic Sites -->
    <section class="thematic-sites">...</section>
    
    <!-- Search + Feedback -->
    <section class="search-feedback">...</section>
  </main>
  
  <!-- Footer -->
  <footer class="it-footer">...</footer>
</body>
```

---

## 🔄 Execution Workflow

### Phase 1: Header Parity (P0)
**Owner**: Amelia  
**ETA**: 2 hours  
**Tasks**:
1. Update header block view
2. Add header-slim component
3. Add header-main component
4. Add navbar component
5. Match AGID classes exactly

### Phase 2: Content Sections (P0)
**Owner**: Amelia + Ralph  
**ETA**: 3 hours  
**Tasks**:
1. Hero section (exact structure)
2. Featured news (large card)
3. Governance cards (3 cards)
4. Events calendar (AGID format)
5. Topics highlight (cards + links)
6. Thematic sites (3 sites)
7. Search + feedback

### Phase 3: Footer Parity (P0)
**Owner**: Amelia  
**ETA**: 2 hours  
**Tasks**:
1. Footer top (4 columns)
2. Footer main (6 columns)
3. Footer bottom (social + legal)
4. Copyright section

### Phase 4: Verification (P0)
**Owner**: gsd-verifier  
**ETA**: 30 min  
**Tasks**:
1. HTML diff with upstream
2. CSS classes verification
3. ARIA attributes check
4. Visual comparison

---

## 📊 Success Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| **HTML Match** | 95%+ | ~30% | 🔴 Critical |
| **CSS Classes** | 100% | ~40% | 🔴 Critical |
| **ARIA Attributes** | 100% | ~20% | 🔴 Critical |
| **Sections Complete** | 10/10 | 6/10 | 🟡 In Progress |
| **AGID Compliance** | 100% | ~35% | 🔴 Critical |

---

## 🤖 OpenViking Context

```bash
openviking add-memory "Homepage HTML parity: Target 95%+ match with upstream AGID. Using Superpowers + JSON + block views. Multi-agent workflow: BMAD + GSD + Ralph + OpenViking + NotebookLM."
```

---

## 📚 Related Documentation

- [Superpowers Integration](./SUPERPOWERS_INTEGRATION_GUIDE.md)
- [Dynamic Route Correction](./DYNAMIC_ROUTE_CORRECTION.md)
- [SVG Icon Convention](./SVG_ICON_CONVENTION.md)
- [Theme Architecture](./THEME_ARCHITECTURE_OUTFIT.md)

---

**Last Updated**: 2026-03-30  
**Priority**: 🔴 **CRITICAL**  
**Next Action**: Execute Phase 1 (Header)  
**Owner**: Multi-Agent Team
