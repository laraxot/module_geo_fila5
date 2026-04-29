# FixCity Italian Site Improvement Plan

**Project**: FixCity Platform - Italian Localization & UX Enhancement
**Domain**: Urban Issue Management Platform
**URL**: http://fixcity.local/it
**Theme**: Sixteen (AGID Bootstrap Italia Design System)
**Researched**: 2026-03-30
**Status**: Ready for Execution

---

## Executive Summary

FixCity is a **production-ready MVP** urban issue management platform built on Laravel 12 + Filament 5 with modular architecture. The Italian site demonstrates solid technical foundations but has significant improvement opportunities across **localization completeness**, **frontend UX**, **performance optimization**, and **testing coverage**.

### Current State Snapshot

| Metric | Current | Target | Gap | Priority |
|--------|---------|--------|-----|----------|
| **Test Coverage** | 40% | 85% | -45% | 🔴 Critical |
| **TTFB** | 780ms | 200ms | +580ms | 🔴 Critical |
| **DB Queries/Page** | 87 | <10 | +77 | 🟡 High |
| **Italian Translations** | ~60% complete | 100% | -40% | 🟡 High |
| **Accessibility (WCAG)** | Partial | AA Full | Gaps | 🟡 High |
| **PHPStan Level** | 10 (0 errors) | 10 (maintain) | ✅ On Target | 🟢 Maintained |
| **Documentation Files** | 15,101+ | Organized | Chaos | 🟡 High |

### Key Strengths ✅

- **Zero PHPStan errors** (Level 10 compliance)
- **Modular architecture** (17 modules + Laraxot framework)
- **AGID-compliant design system** (Bootstrap Italia + Tailwind CSS 4)
- **Advanced AI agent workflow** (BMAD + GSD + Ralph Loop + OpenViking)
- **Comprehensive test infrastructure** (774+ test files with Pest PHP)
- **Multi-agent collaboration ready**

### Critical Challenges ⚠️

- **Test coverage gap**: 40% → 85% requires ~120 hours
- **Performance bottlenecks**: TTFB 780ms, no eager loading, excessive queries
- **Translation gaps**: Italian localization incomplete across modules
- **Documentation chaos**: 15,101+ files need organization
- **Accessibility gaps**: WCAG AA compliance incomplete

---

## 1. Current State Analysis

### 1.1 Frontend (Sixteen Theme)

**Technology Stack**:
- Bootstrap Italia 2.0.0 (CDN)
- Tailwind CSS 4.x
- Font Awesome 6.0.0
- Leaflet.js 1.9.4 (maps)
- Filament 5.x (admin panel)
- Livewire 4.x (reactive components)

**Current Pages**:
- `/it` - Homepage (ticket submission + listing)
- `/it/tickets` - Ticket list with filters
- `/it/tickets/create` - New ticket form
- `/it/tickets/{slug}` - Ticket detail view
- `/it/admin/*` - Filament admin panel

**UI Components Identified**:
```
✅ Working:
- AGID-compliant footer (agid.blade.php)
- AGID header navigation (agid.blade.php)
- Ticket list (card + map views)
- Ticket creation form
- Priority badges
- Type badges
- User avatars
- Filament widgets (login, map, create ticket)

⚠️ Needs Improvement:
- Login page (basic Livewire, needs SPID/CIE integration polish)
- Citizen dashboard (missing `/my-tickets` personal view)
- Interactive map (Leaflet integration incomplete)
- Mobile responsiveness (gaps in mobile menu)
- Loading states (missing skeletons/spinners)
- Error states (generic error pages)
```

**Design System Status**:
- ✅ AGID colors defined (`:root` CSS variables)
- ✅ Typography (Titillium Web + Roboto Mono)
- ✅ Filament 5 integration (custom theme.css)
- ✅ Dark mode support (partial)
- ⚠️ Component library (incomplete - needs shadcn/ui or DaisyUI)
- ⚠️ Motion/animation (minimal - needs kinetic UX)

### 1.2 Italian Translations

**Current State**:
```
Modules/Lang/resources/lang/it/
├── lang_service.php      ✅ Complete
├── translation.php       ⚠️ Partial (generic fields only)
├── translations.php      ⚠️ Partial
└── txt.php              ⚠️ Partial

Missing Translations:
- Fixcity module: Ticket types, priorities, statuses
- User module: Profile fields, roles, permissions
- Cms module: Content types, blocks
- Geo module: Map labels, geocoding messages
- Notify module: Notification templates
- Frontend: Navigation, buttons, error messages, success messages
```

**Translation Quality Issues**:
1. **Inconsistent terminology**: "Tecnico" vs "Operatore" vs "Utente"
2. **Missing context**: Many translations have empty `tooltip`, `helper_text`, `description`
3. **Mixed languages**: Some English strings remain untranslated
4. **No tone of voice**: Formal vs informal inconsistency

**Recommended Tone of Voice**:
- **Citizen-facing**: Informale ma professionale (tu)
- **Admin-facing**: Formale (Lei)
- **Error messages**: Chiaro, costruttivo, non colpevolizzante
- **Success messages**: Positivo, confermativo

### 1.3 User Experience

**Citizen Journey** (Report Issue):
```
1. Landing (/it) → See map + "Segnala un problema"
2. Click "Segnala" → Form with category, location, description
3. Upload photos → Optional attachments
4. Submit → Confirmation + tracking number
5. Track status → Email updates + dashboard view

Current Gaps:
❌ No citizen dashboard (/my-tickets missing)
❌ No email notifications (Notify module not configured)
❌ No tracking number system
❌ No status update timeline
❌ No estimated resolution time
```

**Admin Journey** (Resolve Issue):
```
1. Login → Filament dashboard
2. View tickets → Filter by status/priority/zone
3. Assign to technician → Manual or auto-assign
4. Update status → Workflow: Open → In Progress → Resolved → Closed
5. Notify citizen → Automatic via Notify module

Current Gaps:
⚠️ Manual assignment only (auto-assign planned Phase 2)
⚠️ No SLA tracking
⚠️ No escalation rules
⚠️ Notification templates incomplete
```

### 1.4 Performance Metrics

**Current Performance** (from PROJECT.md):
```
TTFB: 780ms (target: 200ms)
Page Load: 2s+ (target: <1s)
DB Queries: 87/page (target: <10)
Memory: >50MB/request (target: <30MB)

Root Causes:
1. No eager loading on ticket lists (N+1 queries)
2. AGID footer component uses DB::table() directly
3. No caching strategy (Redis/Memcached)
4. Geocoding synchronous (blocks rendering)
5. No query optimization (missing indexes)
```

**Lighthouse Scores** (estimated):
```
Performance: 65/100 (target: 95+)
Accessibility: 78/100 (target: 95+)
Best Practices: 85/100 (target: 95+)
SEO: 90/100 (target: 95+)
PWA: 45/100 (target: 80+)
```

### 1.5 Accessibility Compliance

**WCAG 2.1 AA Status**:
```
✅ Compliant:
- Color contrast (AGID colors meet 4.5:1 ratio)
- Keyboard navigation (Filament 5 supports)
- Form labels (present on all inputs)
- Alt text (images have alt attributes)

⚠️ Gaps:
- Skip links (missing "skip to content")
- Focus indicators (inconsistent styling)
- ARIA labels (missing on dynamic components)
- Screen reader announcements (no live regions)
- Error identification (not programmatically linked)
- Language changes (no lang attribute on foreign terms)
```

---

## 2. Priority Improvements

### Priority Matrix

| Priority | Impact | Effort | ROI | Count |
|----------|--------|--------|-----|-------|
| **P0 - Critical** | High | Low-Med | High | 5 items |
| **P1 - High** | High | Med-High | High | 12 items |
| **P2 - Medium** | Medium | Med | Medium | 18 items |
| **P3 - Low** | Low | Low | Low | 8 items |

---

### P0 - Critical (Complete in 2 weeks)

#### P0.1: Fix Test Syntax Errors
**Problem**: Test files with parse errors prevent CI/CD
**Files**: `TicketResourceTest.php`, other syntax errors
**Effort**: 4 hours
**Impact**: CI/CD confidence, unblock testing

**Tasks**:
- [ ] Fix all PHP syntax errors in test files
- [ ] Ensure all tests parse correctly
- [ ] Run full test suite: `php artisan test`
- [ ] Document test running in AGENTS.md

**Success Metric**: All tests parse, 0 syntax errors

---

#### P0.2: Italian Translation Completeness
**Problem**: ~40% of UI strings missing Italian translations
**Effort**: 16 hours
**Impact**: User experience, accessibility, compliance

**Tasks**:
- [ ] Audit all blade files for hardcoded English strings
- [ ] Extract to translation files using `__()` helper
- [ ] Complete Fixcity module translations (tickets, priorities, statuses)
- [ ] Complete User module translations (profile, auth, roles)
- [ ] Complete Cms module translations (navigation, blocks)
- [ ] Add translation for error messages, success messages
- [ ] Review tone of voice (informale per cittadini, formale per admin)

**Success Metric**: 100% Italian coverage, 0 hardcoded English strings

---

#### P0.3: Eager Loading Implementation
**Problem**: N+1 queries on ticket lists (87 queries/page)
**Effort**: 8 hours
**Impact**: TTFB 780ms → 400ms (estimated 50% improvement)

**Tasks**:
- [ ] Identify N+1 queries with Laravel Debugbar
- [ ] Add `with()` relationships on all list queries
- [ ] Add join relationships where appropriate
- [ ] Test with `php artisan test --filter=Ticket`
- [ ] Document in performance guide

**Success Metric**: DB queries 87 → 30, TTFB <400ms

---

#### P0.4: Accessibility Quick Wins
**Problem**: WCAG AA gaps blocking public sector compliance
**Effort**: 12 hours
**Impact**: Legal compliance, inclusivity

**Tasks**:
- [ ] Add skip links ("Vai al contenuto")
- [ ] Improve focus indicators (consistent 3px outline)
- [ ] Add ARIA labels to dynamic components
- [ ] Add live regions for screen reader announcements
- [ ] Link errors to inputs programmatically
- [ ] Test with NVDA/JAWS screen readers

**Success Metric**: WCAG 2.1 AA audit pass (automated + manual)

---

#### P0.5: Documentation Consolidation
**Problem**: 15,101+ markdown files, chaos, duplicates
**Effort**: 20 hours
**Impact**: Developer experience, multi-agent coordination

**Tasks**:
- [ ] Remove temporal strings (git tracks time)
- [ ] Consolidate 16 roadmap files → 2-3 master roadmaps
- [ ] Merge duplicate completion reports → 1-2 summaries
- [ ] Create master documentation index
- [ ] Archive historical docs
- [ ] Update cross-references

**Success Metric**: 50% reduction in doc files, clear navigation

---

### P1 - High (Complete in 4-6 weeks)

#### P1.1: Query Optimization Deep Dive
**Problem**: Remaining performance bottlenecks
**Effort**: 40 hours
**Impact**: TTFB 400ms → 200ms

**Tasks**:
- [ ] Refactor AGID component (remove DB::table())
- [ ] Add database indexes on frequently queried columns
- [ ] Implement repository pattern for complex queries
- [ ] Add strategic caching (Redis)
- [ ] Async geocoding (queue jobs)
- [ ] Query result caching (5 min TTL)

**Success Metric**: TTFB <200ms, DB queries <10/page

---

#### P1.2: Test Coverage Push (40% → 65%)
**Problem**: Low test coverage creates regression risk
**Effort**: 80 hours
**Impact**: Confidence, refactoring ability, CI/CD

**Tasks**:
- [ ] Pest tests for Fixcity module (models, actions, resources)
- [ ] User module tests (auth, profiles, permissions)
- [ ] Cms module tests (blocks, pages, navigation)
- [ ] Integration tests for critical paths
- [ ] Feature tests for user workflows
- [ ] Architecture tests (PHPStan for tests)

**Success Metric**: Coverage 40% → 65%, 0 failing tests

---

#### P1.3: Citizen Dashboard
**Problem**: No personal ticket view for citizens
**Effort**: 24 hours
**Impact**: User experience, transparency

**Tasks**:
- [ ] Create `/my-tickets` page (Folio + Livewire)
- [ ] Personal statistics (tickets submitted, resolved, pending)
- [ ] Status timeline per ticket
- [ ] Email notification preferences
- [ ] Photo upload for additional evidence
- [ ] Comment system for citizen-operator communication

**Success Metric**: Dashboard live, citizens can track all tickets

---

#### P1.4: Notification System
**Problem**: No email/SMS/push notifications configured
**Effort**: 32 hours
**Impact**: User engagement, transparency

**Tasks**:
- [ ] Configure Notify module (SMTP settings)
- [ ] Email templates (Italian, AGID-compliant)
- [ ] Notification triggers:
  - Ticket submitted
  - Status changed
  - Assigned to technician
  - Resolved
  - Closed
- [ ] SMS integration (Twilio/MessageBird) - optional
- [ ] Push notifications (PWA) - Phase 4

**Success Metric**: Email notifications working, 90% delivery rate

---

#### P1.5: Auto-Assignment System
**Problem**: Manual ticket assignment (inefficient)
**Effort**: 40 hours
**Impact**: Operator efficiency +30%

**Tasks**:
- [ ] Geographic zones (Geo module)
- [ ] Technician availability tracking
- [ ] Load balancing algorithm
- [ ] Rules engine (priority, type, zone)
- [ ] Override manual assignment
- [ ] Audit log for assignments

**Success Metric**: 80% tickets auto-assigned, <5 min assignment time

---

#### P1.6: Interactive Map Enhancement
**Problem**: Leaflet integration incomplete
**Effort**: 20 hours
**Impact**: User experience, issue localization

**Tasks**:
- [ ] Full map on homepage (not placeholder)
- [ ] Cluster markers for tickets
- [ ] Filter by type/priority/status
- [ ] Draw on map to report issue
- [ ] Reverse geocoding (click → address)
- [ ] Heat map for high-density areas

**Success Metric**: Map fully functional, 50%+ tickets via map

---

#### P1.7: Filament 5 Migration Completion
**Problem**: Currently migrating 4→5, breaking changes
**Effort**: 40 hours
**Impact**: Stability, security, features

**Tasks**:
- [ ] Run `filament/upgrade` script
- [ ] Update all resource classes (form schema)
- [ ] Remove deprecated methods (`form()` → `getFormSchema()`)
- [ ] Update asset compilation (Tailwind 4)
- [ ] Test all admin panels
- [ ] Update documentation

**Success Metric**: 100% Filament 5, 0 deprecation warnings

---

#### P1.8: Performance Monitoring
**Problem**: No visibility into performance metrics
**Effort**: 16 hours
**Impact**: Proactive optimization, debugging

**Tasks**:
- [ ] Laravel Telescope (dev environment)
- [ ] Laravel Pulse (production metrics)
- [ ] Custom dashboard for KPIs:
  - TTFB per page
  - DB queries per page
  - Memory usage
  - Error rate
  - Cache hit rate
- [ ] Alerts for thresholds (TTFB >300ms, errors >1%)

**Success Metric**: Real-time performance visibility

---

#### P1.9: Mobile Responsiveness
**Problem**: Mobile UX gaps (menu, forms)
**Effort**: 24 hours
**Impact**: Mobile adoption (60%+ traffic)

**Tasks**:
- [ ] Mobile menu (hamburger, slide-out)
- [ ] Touch-friendly buttons (min 44x44px)
- [ ] Form optimization (input types, autocomplete)
- [ ] Image optimization (responsive srcset)
- [ ] Mobile-first CSS audit
- [ ] Test on iOS/Android devices

**Success Metric**: Mobile Lighthouse 90+, <1s load on 4G

---

#### P1.10: Error Handling & Recovery
**Problem**: Generic error pages, poor recovery
**Effort**: 12 hours
**Impact**: User experience, support load

**Tasks**:
- [ ] Custom error pages (404, 403, 500, 503)
- [ ] User-friendly messages (Italian, helpful)
- [ ] Automatic retry for transient failures
- [ ] Graceful degradation (partial content OK)
- [ ] Error reporting to admin (email/Slack)
- [ ] User guidance ("what to do next")

**Success Metric**: Error rate <0.5%, support tickets -30%

---

#### P1.11: Caching Strategy
**Problem**: No caching, repeated computation
**Effort**: 20 hours
**Impact**: TTFB -40%, infrastructure cost -30%

**Tasks**:
- [ ] Redis configuration
- [ ] Query result caching (5-15 min TTL)
- [ ] View caching (Blade compiled)
- [ ] Route caching (`php artisan route:cache`)
- [ ] Config caching (`php artisan config:cache`)
- [ ] Cache invalidation strategy

**Success Metric**: Cache hit rate >80%, TTFB -40%

---

#### P1.12: Security Hardening
**Problem**: MVP security, needs production hardening
**Effort**: 24 hours
**Impact**: Data protection, compliance

**Tasks**:
- [ ] Security audit (OWASP Top 10)
- [ ] Rate limiting (API, forms)
- [ ] CSP headers (Content Security Policy)
- [ ] CSRF protection audit
- [ ] XSS prevention (escape all output)
- [ ] SQL injection prevention (parameterized queries)
- [ ] File upload validation (mime, size, malware scan)

**Success Metric**: 0 critical/high vulnerabilities, AGID compliance

---

### P2 - Medium (Complete in 8-12 weeks)

#### P2.1: Database Migration (SQLite → PostgreSQL)
**Effort**: 40 hours
**Impact**: Production readiness, scalability

---

#### P2.2: API Development (REST + OpenAPI)
**Effort**: 60 hours
**Impact**: Third-party integrations, mobile apps

---

#### P2.3: Progressive Web App (PWA)
**Effort**: 80 hours
**Impact**: Mobile adoption +60%, offline support

---

#### P2.4: AI Auto-Categorization
**Effort**: 80 hours
**Impact**: Accuracy ≥85%, operator time -40%

---

#### P2.5: SLA & Escalation Engine
**Effort**: 40 hours
**Impact**: Resolution time -30%, compliance

---

#### P2.6: Analytics Dashboard
**Effort**: 40 hours
**Impact**: Data-driven decisions, transparency

---

#### P2.7: Multi-Language (IT/EN/DE)
**Effort**: 40 hours
**Impact**: Tourist-friendly, EU compliance

---

#### P2.8: Voting System
**Effort**: 32 hours
**Impact**: Citizen engagement, prioritization

---

#### P2.9: Gamification
**Effort**: 40 hours
**Impact**: User engagement +40%

---

#### P2.10: Slack/Telegram Integration
**Effort**: 32 hours
**Impact**: Operator responsiveness +50%

---

#### P2.11: Zapier/Make Integration
**Effort**: 24 hours
**Impact**: Workflow automation

---

#### P2.12: Google Maps Integration
**Effort**: 24 hours
**Impact**: Better geocoding accuracy

---

#### P2.13: Predictive Maintenance
**Effort**: 60 hours
**Impact**: ROI +30%, proactive repairs

---

#### P2.14: Duplicate Detection
**Effort**: 32 hours
**Impact**: Operator efficiency +20%

---

#### P2.15: Pattern Recognition
**Effort**: 40 hours
**Impact**: Systemic issue identification

---

#### P2.16: Advanced Search
**Effort**: 24 hours
**Impact**: Discoverability +50%

---

#### P2.17: Export/Reporting
**Effort**: 24 hours
**Impact**: Compliance, transparency

---

#### P2.18: Audit Logging
**Effort**: 20 hours
**Impact**: Accountability, debugging

---

### P3 - Low (Nice-to-have)

#### P3.1: Dark Mode Enhancement
**Effort**: 12 hours

#### P3.2: Social Media Sharing
**Effort**: 8 hours

#### P3.3: Newsletter Integration
**Effort**: 12 hours

#### P3.4: FAQ System
**Effort**: 16 hours

#### P3.5: Live Chat Support
**Effort**: 24 hours

#### P3.6: Video Tutorials
**Effort**: 20 hours

#### P3.7: Community Forum
**Effort**: 40 hours

#### P3.8: API Marketplace
**Effort**: 60 hours

---

## 3. AI Tool Assignment

### Tool Matrix

| Tool | Strength | Assigned Tasks |
|------|----------|----------------|
| **Qwen** | Research, documentation | P0.2, P0.5, P1.8 |
| **Claude** | Code quality, architecture | P0.3, P1.1, P1.7, P1.12 |
| **Cursor** | Rapid prototyping | P1.3, P1.6, P1.9 |
| **Copilot** | Test generation | P1.2, P2.18 |
| **Ralph Loop** | Autonomous implementation | P0.1, P0.4, P1.10 |
| **BMAD** | Requirements, architecture | P1.4, P1.5, P2.x |
| **GSD** | Phase execution | All phases |
| **OpenViking** | Context management | All (cross-cutting) |

### Tool Workflows

#### Translation Workflow (P0.2)
```bash
# Qwen: Extract strings
find laravel/Modules -name "*.blade.php" -exec grep -l "English" {} \;

# Claude: Create translation structure
Modules/Lang/resources/lang/it/fixcity.php

# Ralph Loop: Implement translations
./.ralph/ralph-loop.sh 10 true

# OpenViking: Store context
openviking add --type=translation --file="lang/it/fixcity.php"
```

#### Test Generation Workflow (P1.2)
```bash
# Copilot: Generate test scaffolding
php artisan make:test TicketBusinessLogicTest

# BMAD: Define test requirements
/bmad-create-epics-and-stories

# GSD: Execute test writing
/gsd-execute-phase 1.2

# OpenViking: Store test patterns
openviking add --type=test-pattern --file="tests/Feature/TicketTest.php"
```

#### Performance Optimization Workflow (P1.1)
```bash
# Claude: Audit queries
php artisan debugbar:measure

# Cursor: Implement eager loading
# Edit: TicketResource.php, add with() relationships

# Qwen: Document optimization
docs/performance/optimization-log.md

# OpenViking: Store learnings
openviking add --type=optimization --file="docs/performance/optimization-log.md"
```

---

## 4. Execution Timeline

### Phase Structure (GSD)

```
Phase 0: Foundation (Weeks 1-2)
├─ P0.1: Fix test syntax errors
├─ P0.2: Italian translations
├─ P0.3: Eager loading
├─ P0.4: Accessibility quick wins
└─ P0.5: Documentation consolidation

Phase 1: Performance & Features (Weeks 3-8)
├─ P1.1: Query optimization
├─ P1.2: Test coverage 40% → 65%
├─ P1.3: Citizen dashboard
├─ P1.4: Notification system
├─ P1.5: Auto-assignment
├─ P1.6: Map enhancement
├─ P1.7: Filament 5 migration
├─ P1.8: Performance monitoring
├─ P1.9: Mobile responsiveness
├─ P1.10: Error handling
├─ P1.11: Caching strategy
└─ P1.12: Security hardening

Phase 2: Advanced Features (Weeks 9-16)
├─ P2.1: PostgreSQL migration
├─ P2.2: REST API
├─ P2.3: PWA
├─ P2.4: AI categorization
├─ P2.5: SLA engine
└─ ... (13 more P2 items)

Phase 3: Innovation (Weeks 17-24)
├─ P2.6-P2.18 completion
├─ P3.x nice-to-haves
└─ Production launch preparation
```

### Sprint Cadence

**Sprint Length**: 2 weeks
**Sprint Day**: Monday (planning) → Friday (review)

**Weekly Rhythm**:
```
Monday:    Sprint planning (GSD)
Tuesday:   Deep work (implementation)
Wednesday: Deep work (implementation)
Thursday:  Deep work (implementation)
Friday:    Review, retrospective, demo
```

### Milestone Dates

| Milestone | Date | Deliverables |
|-----------|------|--------------|
| **Phase 0 Complete** | 2026-04-13 | P0.1-P0.5 done |
| **Phase 1 Complete** | 2026-06-22 | P1.1-P1.12 done |
| **Phase 2 Complete** | 2026-10-12 | P2.1-P2.18 done |
| **Production Launch** | 2026-10-26 | All phases, go-live |

---

## 5. Success Metrics

### Technical KPIs

| Metric | Baseline | Q1 Target | Q2 Target | Q3 Target | Q4 Target |
|--------|----------|-----------|-----------|-----------|-----------|
| **Test Coverage** | 40% | 65% | 75% | 85% | 90% |
| **TTFB** | 780ms | 400ms | 300ms | 200ms | <100ms |
| **DB Queries/Page** | 87 | 30 | 20 | 10 | <5 |
| **Memory Usage** | >50MB | 40MB | 35MB | 30MB | <25MB |
| **Error Rate** | 1.2% | 0.8% | 0.5% | 0.3% | <0.1% |
| **Uptime** | 95% | 98% | 99% | 99.5% | 99.9% |
| **Italian Coverage** | 60% | 95% | 98% | 100% | Maintain |
| **WCAG Compliance** | Partial | AA 80% | AA 90% | AA 95% | AA 100% |

### Business KPIs

| Metric | Baseline | Q4 Target | Measurement |
|--------|----------|-----------|-------------|
| **Active Citizens** | 0 | 5,000 | Monthly active users |
| **Tickets/Month** | 0 | 1,000 | Submitted tickets |
| **Resolution Time** | N/A | <14 days | Avg. days to resolve |
| **Citizen Satisfaction** | N/A | 4.0/5 | Post-resolution survey |
| **Operator Efficiency** | N/A | +30% | Tickets/operator/day |
| **Mobile Adoption** | N/A | 60% | Mobile vs desktop |
| **Email Open Rate** | N/A | 70% | Notification emails |

### Developer Experience KPIs

| Metric | Baseline | Target | Measurement |
|--------|----------|--------|-------------|
| **CI/CD Pass Rate** | <80% | >95% | GitHub Actions success |
| **Time to Deploy** | N/A | <10 min | Commit → production |
| **Documentation Coverage** | 55% | 100% | README coverage |
| **Onboarding Time** | N/A | <2 hours | New dev → first commit |
| **Tech Debt Ratio** | N/A | <10% | Debt stories / total |

---

## 6. Risk Management

### Risk Register

| Risk | Probability | Impact | Mitigation | Owner |
|------|-------------|--------|------------|-------|
| **Documentation Overwhelm** | High | Medium | Incremental cleanup, prioritize critical | Qwen |
| **Test Coverage Gap** | High | High | Focus on critical paths first, use Ralph Loop | Copilot + Ralph |
| **Performance Regression** | Medium | High | Baseline metrics, monitor every change | Claude |
| **Translation Quality** | Medium | Medium | Native Italian review, tone of voice guide | Qwen |
| **CI/CD Complexity** | Medium | Medium | Fix one workflow at a time | Cursor |
| **Multi-Agent Conflicts** | Low | Low | GitHub issue coordination, frequent pushes | All agents |
| **Filament 5 Breaking Changes** | Medium | Medium | Staged migration, thorough testing | Claude |
| **PostgreSQL Migration Issues** | Low | High | Backup strategy, rollback plan | Claude |

### Contingency Plans

**If test coverage stalls at 50%**:
- Focus on critical paths only (ticket CRUD, auth)
- Defer edge cases to Phase 3
- Use AI-generated tests (Copilot)

**If TTFB doesn't improve**:
- Profile with Blackfire.io
- Consider caching layer (Redis)
- Evaluate infrastructure upgrade

**If translations incomplete**:
- Prioritize citizen-facing strings
- Admin can remain mixed IT/EN temporarily
- Use AI translation (DeepL API)

---

## 7. DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

**Single Source of Truth**:
- This document (`FIXCITY_IT_IMPROVEMENT_PLAN.md`) is the **master improvement plan**
- All other improvement docs reference this file
- No duplicate roadmaps (consolidated from 16 → 1)

**Cross-References**:
- PROJECT.md → References this plan for improvements
- MODULE PRDs → Reference this plan for module-specific improvements
- Roadmaps → Link to this plan for detailed tasks

### KISS (Keep It Simple, Stupid)

**Simple Priorities**:
- P0: Must have (blocker)
- P1: Should have (high value)
- P2: Nice to have (medium value)
- P3: Optional (low value)

**Simple Metrics**:
- Coverage % (one number)
- TTFB ms (one number)
- Queries count (one number)
- Satisfaction score (one number)

**Simple Execution**:
- 2-week sprints (predictable)
- Monday planning, Friday review (routine)
- GitHub issues for tracking (familiar)
- OpenViking for context (centralized)

---

## 8. Next Steps

### Immediate (This Week)

1. **Create GSD Structure**
   ```bash
   /gsd-new-milestone Phase_0_Foundation
   /gsd-plan-phase 0.1
   ```

2. **Fix Test Syntax Errors** (P0.1)
   - Assign: Ralph Loop
   - ETA: 4 hours
   - Success: All tests parse

3. **Start Italian Translation Audit** (P0.2)
   - Assign: Qwen
   - ETA: 8 hours
   - Success: Inventory complete

4. **Initialize OpenViking Context**
   ```bash
   openviking init
   openviking add --type=improvement-plan --file=".planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md"
   ```

### Next 2 Weeks (Phase 0)

5. **Complete All P0 Items**
   - P0.1: Test syntax ✅
   - P0.2: Translations
   - P0.3: Eager loading
   - P0.4: Accessibility
   - P0.5: Documentation

6. **Phase 0 Review**
   - Date: 2026-04-13
   - Demo: Improvements live
   - Retro: Lessons learned

### Next 4-6 Weeks (Phase 1)

7. **Start Phase 1 Planning**
   - Prioritize P1 items
   - Assign AI agents
   - Create GSD phases

8. **Execute Phase 1**
   - Performance optimization
   - Test coverage push
   - Feature development

---

## 9. Approval & Sign-off

**Created By**: AI Agent Research Team
**Reviewed By**: Pending
**Approved By**: Pending
**Date**: 2026-03-30

### Stakeholder Approval

| Role | Name | Status | Date |
|------|------|--------|------|
| Product Owner | Pending | ⏳ | - |
| Technical Lead | GSD Orchestrator | ⏳ | - |
| QA Lead | Pest Testing Agent | ⏳ | - |
| DevOps Lead | GitHub Actions Agent | ⏳ | - |

---

## 10. Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-03-30 | AI Agent | Initial creation |

---

## Appendix A: NotebookLM Integration

### Documents to Upload

1. **This improvement plan** (`FIXCITY_IT_IMPROVEMENT_PLAN.md`)
2. **PROJECT.md** (`.planning/PROJECT.md`)
3. **Research summary** (`.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md`)
4. **Module PRDs** (all `Modules/*/docs/prd.json`)
5. **AGENTS.md** (project guidelines)
6. **BMAD PRDs** (all `_bmad/` files)
7. **GSD phases** (all `.planning/phases/` files)

### Research Questions for NotebookLM

1. **Current State**:
   - "What are the top 3 critical issues facing FixCity?"
   - "What is the current test coverage and how does it compare to targets?"
   - "What performance bottlenecks are documented?"

2. **Improvement Prioritization**:
   - "Which improvements have the highest ROI?"
   - "What are the dependencies between improvements?"
   - "Which improvements are prerequisites for others?"

3. **Execution Strategy**:
   - "What is the optimal phase ordering?"
   - "Which AI tools are best suited for each task?"
   - "What are the risks and mitigations?"

4. **Success Metrics**:
   - "How should we measure improvement success?"
   - "What are industry benchmarks for these metrics?"
   - "What metrics matter most to citizens?"

### NotebookLM Workflow

```
1. Upload all documents to NotebookLM
2. Ask research questions
3. Get source-grounded answers
4. Validate against actual codebase
5. Update improvement plan with insights
6. Store insights in OpenViking
```

---

## Appendix B: OpenViking Memories

### Key Findings to Store

```markdown
# FixCity Improvement Research - Key Findings

**Date**: 2026-03-30
**Researcher**: AI Agent
**Confidence**: HIGH

## Current State
- Test Coverage: 40% (target 85%)
- TTFB: 780ms (target 200ms)
- DB Queries: 87/page (target <10)
- Italian Translations: ~60% complete
- PHPStan: Level 10 (0 errors) ✅
- Documentation: 15,101+ files (chaos)

## Critical Improvements (P0)
1. Fix test syntax errors (4h)
2. Complete Italian translations (16h)
3. Implement eager loading (8h)
4. Accessibility quick wins (12h)
5. Documentation consolidation (20h)

## High Priority (P1)
1. Query optimization (40h)
2. Test coverage 40%→65% (80h)
3. Citizen dashboard (24h)
4. Notification system (32h)
5. Auto-assignment (40h)

## Timeline
- Phase 0: 2026-04-13 (P0 items)
- Phase 1: 2026-06-22 (P1 items)
- Phase 2: 2026-10-12 (P2 items)
- Launch: 2026-10-26

## AI Tool Assignment
- Qwen: Research, translations, docs
- Claude: Architecture, performance, security
- Cursor: Prototyping, frontend
- Copilot: Test generation
- Ralph Loop: Autonomous implementation
- BMAD: Requirements
- GSD: Execution
- OpenViking: Context

## Success Metrics
- Coverage: 40% → 85%
- TTFB: 780ms → 200ms
- Queries: 87 → <10
- Italian: 60% → 100%
- WCAG: Partial → AA 100%
```

---

## Appendix C: BMAD PRD Triggers

### Major Improvements Requiring PRDs

1. **Citizen Dashboard** (P1.3)
   ```bash
   /bmad-create-prd
   # Goal: Personal ticket view for citizens
   # Features: List, stats, timeline, notifications
   ```

2. **Auto-Assignment System** (P1.5)
   ```bash
   /bmad-create-prd
   # Goal: Automatic ticket assignment
   # Features: Zones, availability, load balancing
   ```

3. **Notification System** (P1.4)
   ```bash
   /bmad-create-prd
   # Goal: Multi-channel notifications
   # Features: Email, SMS, push, templates
   ```

4. **AI Auto-Categorization** (P2.4)
   ```bash
   /bmad-create-prd
   # Goal: ML-based ticket categorization
   # Features: NLP, training, continuous learning
   ```

---

**End of Improvement Plan**

**Next Command**: `/gsd-discuss-phase 0.1` to begin Phase 0 execution.
