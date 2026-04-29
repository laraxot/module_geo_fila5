# 🎯 Homepage Gap Analysis - Design Comuni vs FixCity

**Date**: 2026-03-30  
**Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**Current**: http://fixcity.local/it/tests/homepage

---

## 📊 Gap Analysis

### Reference Structure (Design Comuni)

```
1. Top Bar (Region + Language)
2. Header (Login + Social + Search)
3. Navigation (Main Menu)
4. Hero (City Banner)
5. Featured Content (News)
6. Government Bodies (Mayor, Council)
7. Events (Calendar)
8. Topics (Argomenti)
9. Thematic Sites
10. Feedback Section
11. Contact Section
12. Footer (4-5 columns)
```

### Current Structure (FixCity)

```
1. Header (from x-section)
2. Hero (title + subtitle)
3. Services Grid (6 cards)
4. News Grid (3 cards)
5. Events Grid (3 cards)
6. Topics Grid (8 cards)
7. Footer (from x-section)
```

---

## 🔍 Missing Sections

### Critical Gaps

| Section | Reference | FixCity | Priority |
|---------|-----------|---------|----------|
| **Top Bar** | ✅ Region + Language | ❌ Missing | P0 |
| **Header Details** | ✅ Login + Social + Search | ❌ Partial | P0 |
| **Navigation** | ✅ Main Menu | ❌ Missing | P0 |
| **Government Bodies** | ✅ Mayor, Council | ❌ Missing | P1 |
| **Thematic Sites** | ✅ 3 sites | ❌ Missing | P1 |
| **Feedback Section** | ✅ Rating 1-5 | ❌ Missing | P1 |
| **Contact Section** | ✅ FAQ, Help | ❌ Missing | P1 |

### Partial Implementation

| Section | Reference | FixCity | Status |
|---------|-----------|---------|--------|
| **Hero** | ✅ City Banner | ✅ Basic | 🟡 Needs styling |
| **Services** | ✅ Grid | ✅ Grid | 🟡 Different layout |
| **News** | ✅ Featured | ✅ Grid | 🟡 Different layout |
| **Events** | ✅ Calendar | ✅ Grid | 🟡 Different layout |
| **Topics** | ✅ Topics | ✅ Grid | 🟡 Different layout |
| **Footer** | ✅ 4-5 columns | ✅ Basic | 🟡 Needs content |

---

## 🎯 Required Corrections

### P0 (Critical) - Must Match

#### 1. Top Bar
```blade
{{-- Add to header or create separate component --}}
<div class="it-header-slim-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <span>Nome della Regione</span>
                <div class="language-selector">
                    <button>ITA</button>
                    <button>ENG</button>
                </div>
            </div>
        </div>
    </div>
</div>
```

#### 2. Header with Login + Social + Search
```blade
{{-- Update header component --}}
<div class="it-header-center-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{-- Logo --}}
                {{-- Search bar --}}
                {{-- Social links --}}
                {{-- Login button --}}
            </div>
        </div>
    </div>
</div>
```

#### 3. Main Navigation
```blade
{{-- Add navigation component --}}
<nav class="it-nav-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="navbar-nav">
                    <li><a href="#">Amministrazione</a></li>
                    <li><a href="#">Novità</a></li>
                    <li><a href="#">Servizi</a></li>
                    <li><a href="#">Vivere il Comune</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
```

### P1 (High) - Should Match

#### 4. Government Bodies Section
```blade
{{-- Add after news section --}}
<section class="government-bodies">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Organi di governo</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-4">
                {{-- Mayor card --}}
            </div>
            <div class="col-12 col-md-4">
                {{-- Council card --}}
            </div>
            <div class="col-12 col-md-4">
                {{-- Municipal council card --}}
            </div>
        </div>
    </div>
</section>
```

#### 5. Thematic Sites Section
```blade
{{-- Add before feedback --}}
<section class="thematic-sites">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-md-4">
                {{-- Site 1 --}}
            </div>
            <div class="col-12 col-md-4">
                {{-- Site 2 --}}
            </div>
            <div class="col-12 col-md-4">
                {{-- Site 3 --}}
            </div>
        </div>
    </div>
</section>
```

#### 6. Feedback Section
```blade
{{-- Add before contact --}}
<section class="feedback-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Dicono di noi</h2>
                <div class="rating-stars">
                    <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                </div>
            </div>
        </div>
    </div>
</section>
```

#### 7. Contact Section
```blade
{{-- Add before footer --}}
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Contatta il Comune</h2>
                <div class="contact-options">
                    <a href="#">FAQ</a>
                    <a href="#">Assistenza</a>
                    <a href="#">Numero Verde</a>
                    <a href="#">Appuntamento</a>
                </div>
            </div>
        </div>
    </div>
</section>
```

---

## 📐 Layout Corrections

### Current Grid vs Reference Grid

#### Services Section
**Current**: 3 columns, 6 cards  
**Reference**: 3 columns, 3 featured cards  
**Action**: Reduce to 3 cards, add "See all" link

#### News Section
**Current**: 3 columns, 3 cards  
**Reference**: 1 featured card + list  
**Action**: Change to featured + list layout

#### Events Section
**Current**: 3 columns, 3 cards  
**Reference**: Calendar view (7 days)  
**Action**: Change to calendar layout

#### Topics Section
**Current**: 4 columns, 8 cards  
**Reference**: 4 featured + list  
**Action**: Change to 4 featured + "Show all" link

---

## 🎨 Styling Corrections

### CSS Classes to Add

```css
/* Bootstrap Italia classes */
.it-header-wrapper
.it-header-slim-wrapper
.it-header-center-wrapper
.it-nav-wrapper
.it-hero-wrapper
.it-card
.it-calendar-wrapper
.it-topic-wrapper
.it-sites-wrapper
.it-feedback-wrapper
.it-contact-wrapper
.it-footer-wrapper
```

### Color Scheme
```css
/* Primary colors */
--primary: #0066CC;  /* Bootstrap Italia blue */
--secondary: #5C6F82;
--success: #008055;
--warning: #FFB300;
--danger: #CC0000;
```

---

## ✅ Action Plan

### Phase 1: Header & Navigation (P0)
- [ ] Add Top Bar with region + language
- [ ] Update Header with login + social + search
- [ ] Add Main Navigation menu
- [ ] Ensure responsive behavior

### Phase 2: Content Sections (P1)
- [ ] Add Government Bodies section
- [ ] Add Thematic Sites section
- [ ] Add Feedback section
- [ ] Add Contact section

### Phase 3: Layout Corrections (P1)
- [ ] Change Services to 3 featured cards
- [ ] Change News to featured + list
- [ ] Change Events to calendar view
- [ ] Change Topics to 4 featured + list

### Phase 4: Styling (P1)
- [ ] Add Bootstrap Italia CSS classes
- [ ] Update color scheme
- [ ] Ensure responsive design
- [ ] Test accessibility

---

## 📊 Priority Matrix

| Task | Priority | Effort | Impact |
|------|----------|--------|--------|
| Top Bar | P0 | Low | High |
| Header Update | P0 | Medium | High |
| Navigation | P0 | Medium | High |
| Government Bodies | P1 | Medium | Medium |
| Thematic Sites | P1 | Low | Medium |
| Feedback Section | P1 | Medium | Low |
| Contact Section | P1 | Low | Medium |
| Layout Corrections | P1 | High | High |
| Styling | P1 | High | High |

---

**Status**: 🟡 **ANALYSIS COMPLETE**  
**Next**: Execute Phase 1 (Header & Navigation)  
**ETA**: 4h for P0, 8h for P1

**Gap analysis complete! Ready for corrections. 🎯**
