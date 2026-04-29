# 🚀 FixCity Improvement Execution Plan

**URL**: http://fixcity.local/it  
**Date**: 2026-03-30  
**Status**: ✅ **READY TO EXECUTE**  
**AI Tools**: OpenViking + BMAD + GSD + Ralph Loop + NotebookLM

---

## 🎯 Executive Summary

**Mission**: Migliorare FixCity (piattaforma gestione segnalazioni urbane) utilizzando tutti gli AI tools in modo coordinato.

**Current State**:
- ✅ PHPStan Level 10 (0 errori)
- ✅ 17 moduli + architettura modulare
- ✅ Sixteen theme (AGID Bootstrap Italia)
- ⚠️ Test coverage: 40% → target 85%
- ⚠️ TTFB: 780ms → target 200ms
- ⚠️ Traduzioni IT: 60% → target 100%

**Timeline**: 17 settimane (4 mesi)  
**Effort**: ~1,212 ore totali

---

## 📊 Priority Matrix

### P0 - Critical (Week 1-2) ⚠️

| ID | Task | Effort | AI Tool | Status |
|----|------|--------|---------|--------|
| **P0.1** | Fix test syntax errors | 4h | Ralph Loop | ⏳ Pending |
| **P0.2** | Complete Italian translations | 16h | Qwen + NotebookLM | ⏳ Pending |
| **P0.3** | Eager loading (N+1 fix) | 8h | Claude | ⏳ Pending |
| **P0.4** | Accessibility quick wins | 12h | Ralph Loop | ⏳ Pending |
| **P0.5** | Documentation consolidation | 20h | Qwen | ⏳ Pending |

**Total P0**: 60h (2 settimane)

### P1 - High (Week 3-8) 🔴

12 items, 352h total

### P2 - Medium (Week 9-16) 🟡

18 items, 800h total

---

## 🤖 AI Tool Coordination

### Tool Strengths & Assignments

| AI Tool | Strength | Assigned Tasks | Timeline |
|---------|----------|----------------|----------|
| **Qwen** | Research, documentazione, analisi | P0.2, P0.5, P1.8 | Weeks 1-6 |
| **Claude** | Architecture, performance optimization | P0.3, P1.1, P1.7, P1.12 | Weeks 1-8 |
| **Cursor** | Rapid prototyping, UI/UX | P1.3, P1.6, P1.9 | Weeks 3-6 |
| **Copilot** | Test generation, code completion | P1.2, P2.18 | Weeks 3-16 |
| **Ralph Loop** | Autonomous implementation | P0.1, P0.4, P1.10 | Weeks 1-4 |
| **BMAD** | Requirements, architecture | P1.4, P1.5, P2.x | Weeks 3-16 |
| **GSD** | Phase execution, planning | All phases | Weeks 1-17 |
| **OpenViking** | Context management, memory | Cross-cutting | Weeks 1-17 |
| **NotebookLM** | Source-grounded research | P0.2, P1.8, P2.x | Weeks 1-12 |

---

## 📋 Execution Workflow

### Phase 0: Foundation (Weeks 1-2)

#### P0.1: Fix Test Syntax Errors (4h)

**AI Tool**: Ralph Loop  
**Command**:
```bash
# Setup PRD
cp .planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md .ralph/prd.json

# Execute
./.ralph/ralph-loop.sh 10 true

# Ralph will:
# 1. Find test files with syntax errors
# 2. Fix errors autonomously
# 3. Run tests to verify
# 4. Create checkpoints every 15min
```

**Quality Gate**:
```bash
php artisan test --stop-on-failure
# Expected: All tests run without syntax errors
```

**OpenViking Memory**:
```bash
openviking add-memory "P0.1 complete: Test syntax errors fixed"
```

---

#### P0.2: Complete Italian Translations (16h)

**AI Tools**: Qwen + NotebookLM

**Workflow**:
```bash
# 1. NotebookLM Research
"Ask my Laravel docs about translation best practices"
"Query my Lang module about translation patterns"

# 2. Extract missing translations
php artisan lang:extract --lang=it

# 3. Qwen analysis
# - Review extracted strings
# - Generate Italian translations
# - Validate with AGID guidelines

# 4. Update translation files
# - laravel/Modules/*/resources/lang/it/*.php
# - laravel/Themes/Sixteen/resources/lang/it/*.php

# 5. Quality check
php artisan lang:lint it
```

**NotebookLM Setup**:
1. Create notebook: "FixCity Italian Localization"
2. Upload: All translation files, AGID guidelines
3. Share → Copy link
4. Add to library: "Add [LINK] to my NotebookLM library"
5. Query: "What are best practices for Italian Laravel translations?"

**Success Metric**: 100% translation coverage

---

#### P0.3: Eager Loading Implementation (8h)

**AI Tool**: Claude

**Workflow**:
```bash
# 1. Identify N+1 queries
php artisan telescope:publish
# Check /telescope/queries

# 2. Claude analysis
# - Review models with relationships
# - Identify missing eager loading
# - Add with() calls

# 3. Fix patterns
# Before:
$tickets = Ticket::all(); // N+1 queries!

# After:
$tickets = Ticket::with(['user', 'category', 'status'])->get();

# 4. Test
php artisan test --filter=Ticket
```

**Expected Impact**: TTFB 780ms → 400ms (-50%)

---

#### P0.4: Accessibility Quick Wins (12h)

**AI Tool**: Ralph Loop

**Tasks**:
- [ ] Add ARIA labels to all buttons
- [ ] Fix color contrast issues
- [ ] Add skip links
- [ ] Fix form labels
- [ ] Add alt text to images

**Ralph Command**:
```bash
./.ralph/ralph-loop.sh 15 true
# Ralph will:
# 1. Scan blade files for accessibility issues
# 2. Fix ARIA labels
# 3. Add missing attributes
# 4. Verify with axe-core
```

**Quality Gate**:
```bash
# Run accessibility audit
npm run quality:accessibility
# Expected: WCAG AA compliance
```

---

#### P0.5: Documentation Consolidation (20h)

**AI Tool**: Qwen

**Tasks**:
- [ ] Consolidate 16 roadmap files → 2-3
- [ ] Remove temporal strings (already done: 784)
- [ ] Create master index
- [ ] Organize docs/ folder
- [ ] Cross-reference instead of duplicate

**Workflow**:
```bash
# 1. Analyze current state
find docs/ -name "*.md" | wc -l
# Expected: 153 files

# 2. Qwen analysis
# - Identify duplicates
# - Create consolidation plan
# - Execute reorganization

# 3. Update indices
# - docs/README.md
# - MASTER_INDEX.md

# 4. OpenViking update
openviking add-memory "Documentation consolidated"
```

**Success Metric**: <50 files in docs/ root

---

### Phase 1: Performance (Weeks 3-8)

#### P1.1: Query Optimization Deep Dive (40h)

**AI Tool**: Claude

**Tasks**:
- [ ] Analyze slowest 10 queries
- [ ] Add database indexes
- [ ] Optimize JOINs
- [ ] Implement query caching
- [ ] Setup query monitoring

**Expected Impact**: 87 queries → 40 queries/page

---

#### P1.2: Test Coverage 40% → 65% (80h)

**AI Tool**: Copilot

**Strategy**:
```bash
# 1. Identify untested code
php artisan test --coverage --min=40

# 2. Copilot generation
# - Generate tests for models
# - Generate tests for actions
# - Generate tests for resources

# 3. Run tests
php artisan test --parallel

# 4. Verify coverage
php artisan test --coverage --min=65
```

**Target**: 65% coverage by Week 8

---

#### P1.3: Citizen Dashboard (24h)

**AI Tool**: Cursor

**Features**:
- User ticket list
- Ticket status tracking
- New ticket form
- Interactive map
- Notifications

**Tech Stack**:
- Livewire 4 + Volt
- Tailwind CSS 4
- Leaflet.js maps
- Alpine.js interactions

---

### Phase 2: Advanced (Weeks 9-16)

See `.planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md` for complete P2 tasks.

---

## 📈 Success Metrics

### Technical KPIs

| Metric | Baseline | Week 2 | Week 8 | Week 16 | Target |
|--------|----------|--------|--------|---------|--------|
| **Test Coverage** | 40% | 45% | 65% | 85% | 85% |
| **TTFB** | 780ms | 400ms | 300ms | 200ms | 200ms |
| **DB Queries** | 87 | 40 | 25 | <10 | <10 |
| **Italian Coverage** | 60% | 100% | 100% | 100% | 100% |
| **WCAG Compliance** | Partial | AA | AA | AAA | AA |
| **PHPStan** | Level 10 | Level 10 | Level 10 | Level 10 | Level 10 |

### Business KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| Active Citizens | 5,000 | Monthly active users |
| Tickets/Month | 1,000 | Submitted tickets |
| Resolution Time | <14 days | Avg. days to resolve |
| Citizen Satisfaction | 4.0/5 | Post-resolution survey |

---

## 🔄 Daily Workflow

### Morning (9:00 AM)

```bash
# 1. Check OpenViking context
openviking ls /memories/

# 2. Review yesterday's progress
git log --oneline --since="yesterday"

# 3. Plan today's tasks
cat .planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md

# 4. Start GSD phase
/gsd-execute-phase [phase_number]
```

### During Day

```bash
# Ralph Loop checkpoints (every 15min)
# Check .ralph/checkpoints/

# NotebookLM queries (as needed)
"Ask my docs about [topic]"

# OpenViking updates
openviking add-memory "Completed [task]"
```

### Evening (6:00 PM)

```bash
# 1. Commit work
git add .
git commit -m "feat: [description]"
git push origin dev

# 2. Update OpenViking
openviking add-memory "Day complete: [summary]"

# 3. Plan tomorrow
cat .planning/improvements/tomorrow.md
```

---

## 📊 Weekly Review

### Friday Afternoon

```bash
# 1. Review week's progress
git log --oneline --since="1 week ago"

# 2. Check metrics
php artisan test --coverage
php artisan pulse:check

# 3. Update improvement plan
edit .planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md

# 4. NotebookLM session
"Review this week's improvements and suggest optimizations"

# 5. OpenViking backup
openviking export --file=weekly_backup.json
```

---

## 🎯 Milestone Dates

| Milestone | Date | Status |
|-----------|------|--------|
| **Phase 0 Complete** | 2026-04-13 | ⏳ Pending |
| **Phase 1 Complete** | 2026-06-22 | ⏳ Pending |
| **Phase 2 Complete** | 2026-10-12 | ⏳ Pending |
| **Production Launch** | 2026-10-26 | ⏳ Pending |

---

## 🚀 Start Execution

### Immediate (Today)

```bash
# 1. Initialize GSD Phase 0
/gsd-new-milestone Phase_0_Foundation

# 2. Discuss P0.1
/gsd-discuss-phase 0.1

# 3. Plan P0.1
/gsd-plan-phase 0.1

# 4. Execute P0.1 (Ralph Loop)
cp .planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md .ralph/prd.json
./.ralph/ralph-loop.sh 10 true

# 5. Initialize OpenViking context
openviking init
openviking add-memory "FixCity Improvement Plan started"
```

### This Week

```bash
# P0.1: Test syntax fixes (Ralph)
# P0.2: Translation audit (Qwen + NotebookLM)
# P0.3: Eager loading analysis (Claude)
```

---

## 📚 Documentation

### Master Documents

1. **`.planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md`** (1,555 lines)
   - Complete improvement plan
   - All priorities (P0-P3)
   - Detailed task breakdowns
   - Success metrics

2. **`.planning/improvements/RESEARCH_SUMMARY.md`** (1 page)
   - Quick reference
   - Key metrics
   - Priority summary

3. **`.planning/improvements/NOTEBOOK_LM_GUIDE.md`**
   - NotebookLM integration
   - Research sessions
   - Query examples

4. **`AI_SKILLS_AND_PLUGINS_COMPLETE.md`**
   - All AI tools documented
   - Integration patterns
   - Usage examples

---

## 🎓 Lessons Learned

### What Worked Well

✅ **Coordinated AI workflow**: Each tool used for its strength  
✅ **DRY documentation**: Single source of truth  
✅ **KISS execution**: Simple priorities, clear metrics  
✅ **Ralph Loop**: Autonomous implementation effective  

### What Could Be Better

⚠️ **NotebookLM**: Manual upload required (no API)  
⚠️ **Context switching**: Multiple AI tools need coordination  
⚠️ **Git conflicts**: Parallel AI work needs coordination  

---

## 🔮 Next Steps

### Week 1 (P0 Foundation)

- [x] Research complete
- [ ] P0.1: Test syntax fixes (Ralph)
- [ ] P0.2: Translation audit (Qwen + NotebookLM)
- [ ] P0.3: Eager loading (Claude)
- [ ] P0.4: Accessibility (Ralph)
- [ ] P0.5: Documentation (Qwen)

### Week 2-8 (P1 Performance)

- [ ] P1.1: Query optimization (Claude)
- [ ] P1.2: Test coverage (Copilot)
- [ ] P1.3: Citizen dashboard (Cursor)
- [ ] ... (12 P1 items total)

### Week 9-16 (P2 Advanced)

- [ ] P2.x: Advanced features (18 items)

---

**Status**: ✅ **READY TO EXECUTE**  
**Next Command**: `/gsd-discuss-phase 0.1`  
**ETA Phase 0**: 2026-04-13 (2 weeks)  
**ETA Production**: 2026-10-26 (17 weeks)

**Let's improve FixCity! 🚀**
