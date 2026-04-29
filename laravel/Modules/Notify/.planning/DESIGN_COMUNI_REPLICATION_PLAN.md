# 🚀 DESIGN COMUNI REPLICATION - WORK PLAN

**Data**: 2026-03-30  
**Status**: 🟡 PLANNING  
**Priority**: CRITICAL

---

## 🎯 OBJECTIVE

Replicate all Design Comuni pagine statiche using:
- ✅ Tailwind CSS (NOT Bootstrap)
- ✅ Reusable blocks (NOT page-specific)
- ✅ CMS-driven JSON (NOT hardcoded HTML)
- ✅ Section system (`<x-section>`)
- ✅ Filament 5 icons (`<x-filament::icon>`)

---

## 📊 PRIORITY PAGES

### Phase 1: Core Pages (Week 1)

| # | Design Comuni URL | Our URL | Blocks Needed | Status |
|---|---------------------|---------|---------------|--------|
| 1 | `/sito/homepage.html` | `/it/tests/homepage` | `hero`, `services`, `news`, `events` | 🟡 To Do |
| 2 | `/sito/argomenti.html` | `/it/tests/argomenti` | `hero`, `topics.grid`, `feedback` | 🟡 To Do |
| 3 | `/sito/appuntamento-06-conferma.html` | `/it/tests/appuntamento-06-conferma` | `confirmation`, `details`, `actions` | 🟡 To Do |

### Phase 2: Service Pages (Week 2)

| # | Design Comuni URL | Our URL | Blocks Needed | Status |
|---|---------------------|---------|---------------|--------|
| 4 | `/sito/servizio-dettaglio.html` | `/it/tests/servizio-dettaglio` | `service.detail`, `related` | ⚪ Planned |
| 5 | `/sito/notizia.html` | `/it/tests/notizia` | `news.detail`, `share` | ⚪ Planned |
| 6 | `/sito/evento.html` | `/it/tests/evento` | `event.detail`, `calendar` | ⚪ Planned |

### Phase 3: Admin Pages (Week 3)

| # | Design Comuni URL | Our URL | Blocks Needed | Status |
|---|---------------------|---------|---------------|--------|
| 7 | `/sito/amministrazione.html` | `/it/tests/amministrazione` | `org.chart`, `people.list` | ⚪ Planned |
| 8 | `/sito/personale-dettaglio.html` | `/it/tests/personale-dettaglio` | `person.detail`, `contacts` | ⚪ Planned |

---

## 🎨 BLOCK TYPES TO CREATE

### Universal Types (Reusable)

#### 1. Hero Blocks
- `hero.homepage` - Homepage hero
- `hero.argomenti` - Topics page hero
- `hero.service` - Service detail hero
- `hero.event` - Event detail hero

#### 2. Content Blocks
- `topics.grid` - Topics grid (3-4 columns)
- `topics.list` - Topics list
- `topics.featured` - Featured topics
- `services.grid` - Services grid
- `services.list` - Services list
- `news.grid` - News grid
- `news.list` - News list
- `events.grid` - Events grid
- `events.list` - Events list

#### 3. Detail Blocks
- `confirmation.simple` - Simple confirmation
- `confirmation.with-details` - Confirmation with details
- `confirmation.with-actions` - Confirmation with actions
- `service.detail` - Service detail
- `event.detail` - Event detail
- `news.detail` - News detail
- `person.detail` - Person detail

#### 4. Utility Blocks
- `feedback.rating` - Star rating
- `feedback.survey` - Survey form
- `search.form` - Search form
- `breadcrumb.default` - Breadcrumb
- `pagination.default` - Pagination

---

## 📁 FILE STRUCTURE

### Block Components

```
Themes/Sixteen/resources/views/components/blocks/
├── hero/
│   ├── homepage.blade.php
│   ├── argomenti.blade.php
│   └── service.blade.php
├── topics/
│   ├── grid.blade.php
│   ├── list.blade.php
│   └── featured.blade.php
├── confirmation/
│   ├── simple.blade.php
│   ├── with-details.blade.php
│   └── with-actions.blade.php
└── feedback/
    ├── rating.blade.php
    └── survey.blade.php
```

### CMS JSON Pages

```
config/local/fixcity/database/content/pages/
├── tests.homepage.json
├── tests.argomenti.json
├── tests.appuntamento-06-conferma.json
├── tests.servizio-dettaglio.json
├── tests.notizia.json
└── tests.evento.json
```

### Documentation

```
Themes/Sixteen/docs/
├── blocks/
│   ├── BLOCKS_CATALOG.md (All block types)
│   ├── hero/
│   │   └── README.md
│   ├── topics/
│   │   └── README.md
│   └── confirmation/
│       └── README.md
└── design-comuni/
    ├── REPLICATION_PLAN.md
    ├── screenshots/
    │   ├── homepage-comparison.md
    │   ├── argomenti-comparison.md
    │   └── appuntamento-06-conferma-comparison.md
    └── BLOCKS_MAPPING.md (Which block for which Design Comuni section)
```

---

## 🔧 TECHNICAL REQUIREMENTS

### For Each Page

1. **Study Design Comuni HTML**
   - Analyze structure
   - Identify sections
   - Map to block types

2. **Create CMS JSON**
   ```json
   {
       "slug": "tests.argomenti",
       "content_blocks": {
           "it": [
               {"type": "hero", "data": {...}},
               {"type": "topics", "data": {...}}
           ]
       }
   }
   ```

3. **Create/Reuse Blocks**
   - Use universal types
   - Make reusable
   - Document

4. **Test**
   - Visual match (screenshots)
   - Responsive
   - Accessibility

---

## 📋 GITHUB ISSUES TO CREATE

### Issue Template

```markdown
## Design Comuni Page Replication

**Reference URL**: https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html
**Our URL**: http://fixcity.local/it/tests/argomenti

### Blocks Needed
- [ ] `hero.argomenti`
- [ ] `topics.grid`
- [ ] `feedback.rating`

### Acceptance Criteria
- [ ] Visual match >95%
- [ ] Responsive (mobile, tablet, desktop)
- [ ] Accessibility WCAG AA
- [ ] CMS-driven (JSON config)

### Screenshots
- [ ] Desktop comparison
- [ ] Tablet comparison
- [ ] Mobile comparison

### Documentation
- [ ] Blocks documented
- [ ] JSON config created
- [ ] Usage examples
```

### Issues to Create

1. **Replicate Homepage**
2. **Replicate Argomenti Page**
3. **Replicate Appuntamento-06-Conferma Page**
4. **Create Hero Block Catalog**
5. **Create Topics Block Catalog**
6. **Create Confirmation Block Catalog**
7. **Documentation: Agnostic Guidelines**
8. **Screenshots: Comparison System**

---

## 📚 DOCUMENTATION UPDATES

### Update These Files

1. **Module Docs** (Make agnostic)
   - Remove all "FixCity" references
   - Use `[PROJECT_NAME]` placeholder
   - Rename files if needed

2. **Theme Docs** (Add block catalog)
   - Create `blocks/BLOCKS_CATALOG.md`
   - Document each block type
   - Add usage examples

3. **OpenViking** (Update knowledge)
   - Add block types
   - Add CMS JSON structure
   - Add Design Comuni mapping

4. **This Repo** (Create issues)
   - GitHub Issues for each page
   - GitHub Discussions for architecture
   - Project board for tracking

---

## ✅ CHECKLIST

### Before Starting Each Page

- [ ] Studied Design Comuni HTML
- [ ] Identified all sections
- [ ] Mapped to block types
- [ ] Created CMS JSON
- [ ] Created/reused blocks
- [ ] Tested visual match
- [ ] Documented blocks

### After Each Page

- [ ] Screenshots taken (desktop, tablet, mobile)
- [ ] Comparison document created
- [ ] GitHub issue updated
- [ ] Documentation updated
- [ ] OpenViking updated

---

## 🧘 MANTRAS

> *"Blocchi universali, non pagine specifiche."*

> *"CMS-driven, non hardcoded."*

> *"Tailwind @apply, non Bootstrap."*

> *"Documentazione agnostica, no project-specific."*

> *"Screenshot e confronta, sempre."*

---

**Status**: 🟡 READY TO EXECUTE  
**Next**: Create GitHub issues, start Phase 1
