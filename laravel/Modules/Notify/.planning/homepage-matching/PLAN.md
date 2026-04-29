# 🎯 Homepage Matching Plan

**Date**: 2026-03-30  
**Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**Target**: http://fixcity.local/it/tests/homepage  
**Status**: 🟡 IN PROGRESS

---

## 📊 Current Status

### ✅ Completed
- [x] OpenViking installed globally
- [x] BMAD repository cloned
- [x] GSD repository cloned
- [x] Ralph Loop repository cloned
- [x] Icon error fixed (topics/highlight.blade.php)
- [x] Block components created (top-bar, header-enhanced, navigation, etc.)

### 🟡 In Progress
- [ ] Superpowers installation
- [ ] NotebookLM MCP installation
- [ ] HTML structure matching
- [ ] JSON config update

### ⚪ Pending
- [ ] Full HTML match verification
- [ ] Responsive design testing
- [ ] Accessibility testing

---

## 🎯 Reference HTML Structure

```html
<body>
  1. it-header-slim-wrapper (Top Bar)
     - Region name
     - Language selector (ITA/ENG)
  
  2. it-header-center-wrapper (Header)
     - Logo + City name + Tagline
     - Search bar
     - Social links (6 + RSS)
     - Login button
  
  3. it-nav-wrapper (Navigation)
     - Main menu (Amministrazione, Novità, Servizi, Vivere)
     - Submenus
     - Highlighted item
  
  4. it-hero-wrapper (Hero)
     - City name banner
     - "Contenuti in evidenza"
  
  5. Featured Content (News)
     - 1 featured news card
  
  6. Government Bodies
     - Mayor card
     - Council card
     - Municipal Council card
  
  7. Events (Calendar)
     - Month header
     - 7 days view
  
  8. Topics (Argomenti)
     - 4 featured topics
     - "Altri argomenti" link
  
  9. Thematic Sites
     - 3 sites
  
  10. Feedback Section
      - 5-star rating
      - Positive aspects
      - Difficulties
      - Details textarea
  
  11. Contact Section
      - Contact options (4)
      - Quick links (6)
  
  12. Footer
      - 4-5 columns
      - Legal links
      - Social links
</body>
```

---

## 📋 Implementation Plan

### Phase 1: Setup (COMPLETED)
- [x] Clone BMAD repository
- [x] Clone GSD repository
- [x] Clone Ralph Loop repository
- [ ] Install Superpowers plugin
- [ ] Install NotebookLM MCP

### Phase 2: Component Creation (COMPLETED)
- [x] Create `top-bar.blade.php`
- [x] Create `header-enhanced.blade.php`
- [x] Create `main-navigation.blade.php`
- [x] Create `government-bodies.blade.php`
- [x] Create `thematic-sites.blade.php`
- [x] Create `feedback-section.blade.php`
- [x] Create `contact-section.blade.php`

### Phase 3: JSON Config Update (PENDING)
- [ ] Update `tests.homepage.json` with all sections
- [ ] Add component data for each section
- [ ] Configure block ordering

### Phase 4: Integration (PENDING)
- [ ] Update `<x-page>` component to render all blocks
- [ ] Test each section rendering
- [ ] Fix any issues

### Phase 5: Testing (PENDING)
- [ ] Visual comparison with reference
- [ ] Responsive design testing
- [ ] Accessibility testing
- [ ] Performance testing

---

## 🔄 AI Tools Workflow

### BMAD (Architecture)
```
1. Analyze reference HTML structure
2. Define component architecture
3. Create data models for each section
4. Document patterns
```

### Superpowers (Planning)
```
1. Brainstorm homepage requirements
2. Create implementation spec
3. Break into tasks
4. Execute with TDD
5. Code review
```

### GSD (Execution)
```
Milestone: Homepage Matching
├── Phase 1: Setup ✅
├── Phase 2: Components ✅
├── Phase 3: JSON Config ⚪
├── Phase 4: Integration ⚪
└── Phase 5: Testing ⚪
```

### Ralph Loop (Autonomous)
```
Tasks:
1. Read JSON config
2. Generate block HTML
3. Test rendering
4. Fix issues
5. Commit changes
```

### OpenViking (Context)
```
Memory:
- Project: FixCity
- Pages: 23 pages
- Components: 10+ blocks
- Goal: Match Design Comuni homepage
- Progress: Phase 2/5 complete
```

### NotebookLM MCP (Research)
```
Research Topics:
- Bootstrap Italia components
- Design Comuni patterns
- Accessibility (WCAG 2.1)
- Responsive design patterns
```

---

## 📊 HTML Matching Checklist

### Top Bar
- [ ] Region name display
- [ ] Language selector (ITA/ENG)
- [ ] Correct CSS classes

### Header
- [ ] Logo + City name + Tagline
- [ ] Search bar with button
- [ ] Social links (6 platforms + RSS)
- [ ] Login button

### Navigation
- [ ] Main menu items
- [ ] Submenus support
- [ ] Highlighted item
- [ ] Mobile hamburger menu

### Hero
- [ ] City name banner
- [ ] "Contenuti in evidenza" title

### Featured Content
- [ ] 1 featured news card
- [ ] Correct layout

### Government Bodies
- [ ] 3 cards (Mayor, Council, Municipal Council)
- [ ] Image support
- [ ] Description + link

### Events
- [ ] Month header
- [ ] 7 days view
- [ ] Event types

### Topics
- [ ] 4 featured topics
- [ ] "Altri argomenti" link

### Thematic Sites
- [ ] 3 sites grid
- [ ] Icon + description

### Feedback
- [ ] 5-star rating
- [ ] Positive aspects buttons
- [ ] Difficulties buttons
- [ ] Details textarea

### Contact
- [ ] 4 contact options
- [ ] 6 quick links

### Footer
- [ ] 4-5 columns
- [ ] Legal links
- [ ] Social links

---

## 📐 File Structure

```
laravel/
├── Themes/Sixteen/
│   ├── resources/views/
│   │   ├── components/blocks/
│   │   │   ├── top-bar.blade.php ✅
│   │   │   ├── header-enhanced.blade.php ✅
│   │   │   ├── main-navigation.blade.php ✅
│   │   │   ├── government-bodies.blade.php ✅
│   │   │   ├── thematic-sites.blade.php ✅
│   │   │   ├── feedback-section.blade.php ✅
│   │   │   └── contact-section.blade.php ✅
│   │   └── pages/tests/
│   │       └── [slug].blade.php ✅
│   └── config/
└── config/local/fixcity/database/content/pages/
    └── tests.homepage.json ⚪ (needs update)
```

---

## ✅ Progress

| Phase | Status | Progress |
|-------|--------|----------|
| **Setup** | ✅ Complete | 100% |
| **Components** | ✅ Complete | 100% |
| **JSON Config** | ⚪ Pending | 0% |
| **Integration** | ⚪ Pending | 0% |
| **Testing** | ⚪ Pending | 0% |

**Overall**: 40% Complete (2/5 phases)

---

## 🎯 Next Steps

1. **Update JSON config** (tests.homepage.json)
2. **Add all sections data**
3. **Test rendering**
4. **Fix any issues**
5. **Visual comparison**

---

**Status**: 🟡 **PHASE 2/5 COMPLETE**  
**Next**: Update JSON config  
**ETA**: 4h for remaining phases

**Homepage matching plan created! 🎯🚀**
