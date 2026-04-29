# 🚀 Multi-Agent Coordination: HTML-First Design Comuni Compliance

**Date**: 2026-03-30  
**Status**: ✅ Directive Established, Ready for Implementation  
**Priority**: 🔴 CRITICAL  
**Coordinating Agent**: gsd-executor

---

## 🎯 Golden Directive

```
WITHIN <body> (excluding <script>):
  Our HTML == Design Comuni HTML
```

**This is MANDATORY. Not optional.**

---

## 🤖 Agents Involved

### 1. general-purpose (HTML Analysis)
**Responsibility**: Fetch and analyze HTML from both sites

**Completed**:
- ✅ Analyzed Design Comuni reference HTML
- ✅ Identified Bootstrap Italia structure
- ✅ Saved comparison screenshots

**Key Finding**: Design Comuni uses **Bootstrap 5.2.3**, NOT Tailwind

### 2. gsd-project-researcher (Bootstrap Italia Research)
**Responsibility**: Research Bootstrap Italia integration

**Completed**:
- ✅ Installation guide: `npm install bootstrap-italia`
- ✅ Vite configuration (SCSS entry point)
- ✅ Dependency analysis (jQuery NOT required)
- ✅ Blade component patterns

**Output File**: `laravel/Themes/Sixteen/docs/bootstrap-italia-integration.md`

### 3. gsd-executor (Orchestrator)
**Responsibility**: Coordinate agents, establish directive, create documentation

**Completed**:
- ✅ Established HTML-First directive
- ✅ Created comprehensive documentation
- ✅ Updated OpenViking memory
- ✅ Created implementation plan

---

## 📊 Critical Findings

### 1. Framework Mismatch (CRITICAL)

| Layer | Design Comuni | We Use | Action |
|-------|---------------|--------|--------|
| **CSS Framework** | Bootstrap 5.2.3 | Tailwind CSS v4 | ❌ MUST CHANGE |
| **Components** | Bootstrap Italia | DaisyUI | ❌ MUST CHANGE |
| **Grid** | Bootstrap (`.row .col-*`) | Tailwind Grid | ❌ MUST CHANGE |
| **Icons** | Bootstrap Italia SVG Sprites | Heroicons | ❌ MUST CHANGE |

### 2. HTML Structure Gaps

**Missing Critical Elements**:

| Element | Required | We Have | Gap |
|---------|----------|---------|-----|
| **Skip Links** | ✅ `.visually-hidden` | ❌ Missing | 🔴 |
| **Header Wrapper** | ✅ `.it-header-wrapper` | ❌ `.site-header` | 🔴 |
| **Top Bar** | ✅ `.it-topbar` | ❌ `.top-bar` | 🔴 |
| **Main Nav** | ✅ `.it-main-nav` | ❌ `.main-nav` | 🔴 |
| **Secondary Nav** | ✅ `.it-secondary-nav` | ❌ Missing | 🔴 |
| **Card Type** | ✅ `.card-topic` | ❌ `.card` | 🟡 |
| **Footer** | ✅ `.it-footer` | ❌ Custom | 🔴 |

### 3. Why HTML Must Be Identical

1. **Accessibility**: Design Comuni is WCAG 2.1 AA compliant
2. **Bootstrap Italia**: CSS classes require exact HTML structure
3. **PA Compliance**: Italian law requires Design Comuni for PA sites
4. **SEO**: Semantic structure is standardized
5. **Third-party Tools**: Expect Design Comuni HTML

---

## 📚 Documentation Created (3 Files)

### 1. **HTML-First Compliance Guide** 📖
`laravel/Themes/Sixteen/docs/HTML_FIRST_DESIGN_COMUNI_COMPLIANCE.md`

**Contents**:
- Golden rule explanation
- Complete HTML comparison (before/after)
- Gap analysis table
- Bootstrap Italia integration guide
- Blade component examples
- Validation checklist

**Key Sections**:
- Why HTML identical is mandatory
- Complete Bootstrap Italia setup
- Header component (Bootstrap Italia HTML)
- Card topic component
- Argomenti page example

### 2. **Bootstrap Italia Integration** 🔧
`laravel/Themes/Sixteen/docs/bootstrap-italia-integration.md`

**Contents**:
- Installation (npm, CDN, Laravel preset)
- Vite configuration (SCSS)
- Import order (critical for Bootstrap Italia)
- JavaScript initialization
- Blade component patterns
- SVG sprite system

### 3. **OpenViking Master Memory** 🧠
`.openviking/html-first-design-comuni-compliance.md`

**Contents**:
- Golden directive
- Critical gaps summary
- Framework change table
- Implementation steps
- Validation process
- Developer mantras

---

## 🚀 Implementation Plan

### Phase 1: Bootstrap Italia Setup (Day 1)

```bash
cd laravel/Themes/Sixteen

# 1. Install Bootstrap Italia + dependencies
npm install bootstrap-italia@latest --save
npm install @popperjs/core @splidejs/splide animejs --save

# 2. Update vite.config.js
# Change entry from .css to .scss

# 3. Create resources/scss/app.scss
# Import Bootstrap Italia in correct order

# 4. Build
npm run build && npm run copy
```

**Status**: 🟡 Pending

---

### Phase 2: Component Rewrite (Day 2-3)

**Components to Rewrite**:

1. **Header** (`components/header.blade.php`)
   - Must output: `.it-header-wrapper`, `.it-topbar`, `.it-header`, `.it-main-nav`, `.it-secondary-nav`
   - Use Bootstrap Italia SVG sprites for icons

2. **Card Topic** (`components/card-topic.blade.php`)
   - Must output: `.card-topic`
   - Bootstrap Grid structure

3. **Breadcrumb** (`components/breadcrumb.blade.php`)
   - Must output: `.breadcrumb` with ARIA labels

4. **Footer** (`components/footer.blade.php`)
   - Must output: `.it-footer`

**Status**: 🟡 Pending

---

### Phase 3: Validation (Day 4)

```bash
# 1. Fetch our HTML
curl http://fixcity.local/it/tests/argomenti > our.html

# 2. Fetch Design Comuni HTML
curl https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html > reference.html

# 3. Compare structure (exclude scripts)
diff <(grep -v '<script>' our.html) <(grep -v '<script>' reference.html)
```

**Expected Result**: Only content differences, NO structure differences

**Status**: 🟡 Pending

---

## 📊 Success Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| HTML structure match | >95% | ~30% | 🔴 Critical Gap |
| Bootstrap Italia classes | 100% | 0% | 🔴 Not Started |
| Skip links present | ✅ Yes | ❌ No | 🔴 Missing |
| Header wrapper class | `.it-header-wrapper` | `.site-header` | 🔴 Wrong |
| Card class | `.card-topic` | `.card` | 🟡 Partial |
| Grid system | Bootstrap | Tailwind | 🔴 Wrong |
| Documentation | ✅ Complete | ✅ 100% | 🟢 Complete |

---

## 🧘 Developer Mantras

> *"HTML dentro body deve essere identico a Design Comuni. Non simile. Identico."*

> *"Bootstrap Italia non è un'opzione. È il requisito."*

> *"Componenti Blade generano HTML Bootstrap Italia. Niente Tailwind. Niente DaisyUI."*

> *"L'accessibilità non è negoziabile. WCAG 2.1 AA è il minimo."*

---

## 🔗 Documentation Cross-References

### Internal (Theme)
- [HTML-First Compliance](./Themes/Sixteen/docs/HTML_FIRST_DESIGN_COMUNI_COMPLIANCE.md)
- [Bootstrap Italia Integration](./Themes/Sixteen/docs/bootstrap-italia-integration.md)
- [Build Workflow](./Themes/Sixteen/docs/build-workflow.md)

### Internal (Module)
- [Zen Philosophy](./Modules/Cms/docs/blocks/ZEN_PHILOSOPHY.md)
- [Argomenti Error Analysis](./Modules/Cms/docs/blocks/argomenti-error-analysis.md)

### OpenViking
- `viking://themes/sixteen/html-first-compliance` - This directive
- `viking://themes/sixteen/docs/html-first-compliance` - Full guide
- `viking://themes/sixteen/bootstrap-italia-integration` - Integration

### External
- [Design Comuni Argomenti](https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html)
- [Bootstrap Italia Docs](https://italia.github.io/bootstrap-italia/)
- [Bootstrap Italia GitHub](https://github.com/italia/bootstrap-italia)

---

## ✅ Validation Checklist

- [x] Golden directive established
- [x] HTML comparison completed
- [x] Gap analysis documented
- [x] Bootstrap Italia research completed
- [x] Integration guide created
- [x] OpenViking updated
- [ ] Bootstrap Italia installed
- [ ] Components rewritten
- [ ] HTML validated (>95% match)
- [ ] Accessibility tested (WCAG AA)

**Status**: 40% Complete (Documentation ✅, Implementation 🟡 Pending)

---

## 🎯 Next Actions

### Immediate (Today)
```bash
# 1. Review documentation
cat laravel/Themes/Sixteen/docs/HTML_FIRST_DESIGN_COMUNI_COMPLIANCE.md

# 2. Install Bootstrap Italia
cd laravel/Themes/Sixteen
npm install bootstrap-italia@latest --save

# 3. Update vite.config.js
# Change entry to .scss
```

### Short-term (This Week)
- [ ] Complete Bootstrap Italia setup
- [ ] Rewrite header component
- [ ] Rewrite card components
- [ ] Test HTML match
- [ ] Validate accessibility

### Long-term (Next Week)
- [ ] Rewrite all pages to Bootstrap Italia
- [ ] Achieve >95% HTML match
- [ ] WCAG 2.1 AA certification
- [ ] Document any deviations

---

**Coordinated by**: gsd-executor  
**Contributing Agents**: general-purpose, gsd-project-researcher  
**Date**: 2026-03-30  
**Version**: 1.0  
**Priority**: 🔴 CRITICAL  
**Next Review**: After Phase 1 implementation

> *"Costruiamo non per oggi, ma per l'eternità. E l'eternità ha una struttura HTML precisa."*
