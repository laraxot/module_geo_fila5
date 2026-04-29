# 🏠 DESIGN COMUNI HOMEPAGE - EXACT HTML REPLICATION

**Data**: 2026-03-31  
**Status**: 🟡 IN PROGRESS  
**Priority**: CRITICAL

---

## 🎯 OBJECTIVE

Replicate EXACT HTML structure from:
- **Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- **Target**: http://fixcity.local/it/tests/homepage

**Requirement**: HTML inside `<body>` must be IDENTICAL

---

## 📊 CURRENT STATUS

### Tools Installed
- ✅ GSD (Get Shit Done) - `/tmp/gsd/`
- ✅ Superpowers - `/tmp/superpowers/`
- ✅ Ralph Loop - Already installed
- ⚪ BMAD - Connection reset (retry later)
- ✅ OpenViking - Already installed globally
- ⚪ NotebookLM MCP - To install

### HTML Analysis

**Extracted Structure** (text content):
1. Header (3 levels) ✅
2. Hero/Featured Content ✅
3. Governance Cards ✅
4. Events Calendar ✅
5. Topics Grid ✅
6. Thematic Sites ✅
7. Search Bar ✅
8. Feedback Form ✅
9. Contact & Services ✅
10. Footer ✅

**Missing**: Exact HTML tags, CSS classes, ARIA attributes

---

## 🔧 REQUIRED ACTIONS

### 1. Download Full HTML Source

```bash
curl -s https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html > /tmp/design-comuni-homepage.html
```

### 2. Analyze HTML Structure

Extract:
- All CSS classes
- All data attributes
- All ARIA attributes
- Exact nesting hierarchy

### 3. Create Blade Components

Match EXACT structure:
```blade
{{-- Must match exactly --}}
<div class="it-header-slim-wrapper" data-element="topbar">
  ...
</div>
```

### 4. Update JSON Config

Ensure all blocks render with correct classes.

---

## 📋 HTML STRUCTURE (Inferred)

### Header (3 Levels)

```html
<!-- Level 1: Top Bar -->
<div class="it-header-slim-wrapper" data-element="topbar">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="it-header-slim-wrapper-content">
          <a class="d-lg-block navbar-brand">Nome della Regione</a>
          <div class="it-header-slim-right-zone">
            <!-- Language, Login -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Level 2: Main Header -->
<div class="it-header-center-wrapper">
  <!-- Logo, Social, Search -->
</div>

<!-- Level 3: Navigation -->
<div class="it-header-navbar-wrapper">
  <!-- Menu, Submenu -->
</div>
```

### Main Content

```html
<main id="main-content">
  <!-- Hero -->
  <section class="hero-section">...</section>
  
  <!-- Governance -->
  <section class="card-wrapper">...</section>
  
  <!-- Events -->
  <section class="it-calendar-wrapper">...</section>
  
  <!-- Topics -->
  <section class="topic-list-wrapper">...</section>
  
  <!-- Thematic Sites -->
  <section class="thematic-sites">...</section>
  
  <!-- Search & Feedback -->
  <section class="search-feedback">...</section>
  
  <!-- Contact & Services -->
  <section class="contact-services">...</section>
</main>
```

### Footer

```html
<footer class="it-footer" role="contentinfo">
  <div class="it-footer-main">
    <!-- 4 Columns -->
  </div>
  <div class="it-footer-bottom">
    <!-- Legal, Social -->
  </div>
</footer>
```

---

## 🧘 DEVELOPER MANTRAS

> *"HTML IDENTICO. Non simile. IDENTICO."*

> *"Bootstrap Italia classes. Not Tailwind."*

> *"Exact structure. Exact classes. Exact ARIA."*

---

## 📖 NEXT STEPS

### Immediate
- [ ] Download full HTML source
- [ ] Parse and analyze structure
- [ ] Identify all CSS classes
- [ ] Identify all data/ARIA attributes

### Short-term
- [ ] Update Blade components
- [ ] Update JSON config
- [ ] Test exact match

### Long-term
- [ ] Validate with W3C validator
- [ ] Test accessibility
- [ ] Perfect visual match

---

**Status**: 🟡 ANALYSIS IN PROGRESS  
**Tools**: GSD, Superpowers, Ralph  
**Next**: Download HTML, analyze, replicate!
