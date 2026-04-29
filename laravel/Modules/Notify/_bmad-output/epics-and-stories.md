---
stepsCompleted: ['step-01-init', 'step-02-breakdown']
inputDocuments:
  - '_bmad-output/prd.md'
  - '_bmad-output/architecture.md'
  - '_bmad-output/ui-spec.md'
  - '_bmad-output/codebase/concerns-and-debt.md'
workflowType: 'epics-and-stories'
project_name: 'FixCity Fila5'
user_name: 'Xot'
date: '2026-04-01'
version: '1.0'
---

# Epics & User Stories - FixCity Fila5

**Version:** 1.0  
**Date:** 2026-04-01  
**Status:** Complete  

---

## Epic Overview

### Epic Summary

| Epic ID | Title | Priority | Status | Stories | Points |
|---------|-------|----------|--------|---------|--------|
| **EPIC-001** | Migration Cleanup | 🔴 Critical | Ready | 8 | 34 |
| **EPIC-002** | Performance Optimization | 🔴 Critical | Ready | 10 | 42 |
| **EPIC-003** | API Documentation | 🔴 Critical | Ready | 6 | 26 |
| **EPIC-004** | Test Coverage Improvement | 🟡 High | Ready | 12 | 52 |
| **EPIC-005** | Documentation Consolidation | 🟡 High | Ready | 8 | 30 |
| **EPIC-006** | Rate Limiting Implementation | 🟡 High | Ready | 5 | 20 |
| **EPIC-007** | Backup Strategy | 🟡 High | Ready | 4 | 16 |
| **EPIC-008** | Browser Testing Suite | 🟢 Medium | Ready | 6 | 24 |
| **EPIC-009** | Monitoring Enhancement | 🟢 Medium | Ready | 5 | 20 |
| **EPIC-010** | Security Hardening | 🟢 Medium | Ready | 7 | 28 |

**Total:** 10 Epics, 71 Stories, 292 Story Points

---

## EPIC-001: Migration Cleanup

**Priority:** 🔴 Critical  
**Status:** Ready  
**Story Points:** 34  
**Owner:** Backend Team  

### Description

Rimuovere le migrazioni duplicate (168 totali) e organizzare la struttura delle migrazioni per migliorare la manutenibilità e ridurre i tempi di deployment.

### Business Value

- Ridurre errori di deployment
- Migliorare la velocità delle migrazioni
- Semplificare il debugging
- Ridurre technical debt

### Acceptance Criteria

- [ ] Tutte le migrazioni duplicate rimosse
- [ ] Ogni tabella ha una singola migrazione
- [ ] Test di migrazione passing
- [ ] Documentazione aggiornata
- [ ] Backup creato prima della cleanup

### User Stories

#### Story 1.1: Audit Migrazioni Esistenti
**ID:** US-001.01  
**Points:** 3  
**Priority:** High  

**As a** developer  
**I want** to identify all duplicate migrations  
**So that** I can safely remove them without breaking the database  

**Acceptance Criteria:**
- [ ] Script di analisi migrazioni creato
- [ ] Report duplicati generato
- [ ] Mapping tabelle-migrazioni documentato
- [ ] Backup strategy definita

**Tasks:**
- [ ] Create migration analysis script
- [ ] Generate duplicate report
- [ ] Document table-migration mapping
- [ ] Create backup before cleanup

**Test Cases:**
```php
it('identifies duplicate migrations', function () {
    $duplicates = MigrationAnalyzer::findDuplicates();
    expect($duplicates)->toHaveCount(47);
});
```

---

#### Story 1.2: Consolidate User Table Migrations
**ID:** US-001.02  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** a single migration for the users table  
**So that** schema changes are predictable and maintainable  

**Acceptance Criteria:**
- [ ] Single migration file for users table
- [ ] All columns preserved
- [ ] Foreign keys intact
- [ ] Tests passing

**Tasks:**
- [ ] Create consolidated migration
- [ ] Migrate existing data
- [ ] Remove old migrations
- [ ] Update tests

---

#### Story 1.3: Consolidate Tickets Table Migrations
**ID:** US-001.03  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** a single migration for fixcity_tickets table  
**So that** ticket schema is easy to understand  

**Acceptance Criteria:**
- [ ] Single migration file
- [ ] All fields preserved
- [ ] Indexes maintained
- [ ] No data loss

---

#### Story 1.4: Create Migration Deduplication Script
**ID:** US-001.04  
**Points:** 8  
**Priority:** Medium  

**As a** developer  
**I want** an automated script to detect duplicates  
**So that** we prevent future duplication  

**Acceptance Criteria:**
- [ ] CLI command created
- [ ] Detects duplicate columns
- [ ] Detects duplicate tables
- [ ] Generates report

**Implementation:**
```php
<?php

declare(strict_types=1);

namespace Database\Commands;

use Illuminate\Console\Command;

class AnalyzeMigrations extends Command
{
    protected $signature = 'migrations:analyze';
    
    public function handle(): int
    {
        $migrations = Migration::all();
        $duplicates = $this->findDuplicates($migrations);
        
        $this->table(
            ['Table', 'Migration Count', 'Files'],
            $duplicates
        );
        
        return Command::SUCCESS;
    }
}
```

---

#### Story 1.5: Document Migration Strategy
**ID:** US-001.05  
**Points:** 3  
**Priority:** Medium  

**As a** team member  
**I want** clear migration guidelines  
**So that** we don't create duplicates in the future  

**Acceptance Criteria:**
- [ ] Migration best practices documented
- [ ] Code review checklist updated
- [ ] Team training completed

---

#### Story 1.6: Test Migration Rollforward
**ID:** US-001.06  
**Points:** 5  
**Priority:** High  

**As a** DevOps engineer  
**I want** to test migrations in staging  
**So that** production deployment is safe  

**Acceptance Criteria:**
- [ ] Staging environment updated
- [ ] Migration tested
- [ ] Rollback plan documented
- [ ] Success metrics defined

---

#### Story 1.7: Execute Production Migration Cleanup
**ID:** US-001.07  
**Points:** 8  
**Priority:** High  

**As a** DBA  
**I want** to safely execute the cleanup  
**So that** production database is optimized  

**Acceptance Criteria:**
- [ ] Backup completed
- [ ] Maintenance window scheduled
- [ ] Migration executed successfully
- [ ] Verification tests passing

---

#### Story 1.8: Post-Cleanup Verification
**ID:** US-001.08  
**Points:** 2  
**Priority:** Medium  

**As a** QA engineer  
**I want** to verify all functionality  
**So that** no regressions occurred  

**Acceptance Criteria:**
- [ ] All tests passing
- [ ] Performance benchmarks met
- [ ] No errors in logs
- [ ] Sign-off from stakeholders

---

## EPIC-002: Performance Optimization

**Priority:** 🔴 Critical  
**Status:** Ready  
**Story Points:** 42  
**Owner:** Backend Team  

### Description

Ottimizzare le performance dell'applicazione per raggiungere TTFB < 200ms e migliorare l'esperienza utente.

### Business Value

- Migliore user experience
- Riduzione bounce rate
- Migliore SEO ranking
- Aumento conversioni

### Acceptance Criteria

- [ ] TTFB < 200ms
- [ ] Page load < 2s
- [ ] API response < 100ms (p95)
- [ ] Lighthouse score > 90

### User Stories

#### Story 2.1: Performance Baseline Measurement
**ID:** US-002.01  
**Points:** 3  
**Priority:** High  

**As a** performance engineer  
**I want** to establish baseline metrics  
**So that** we can measure improvements  

**Acceptance Criteria:**
- [ ] TTFB baseline documented (780ms)
- [ ] Page load baseline measured
- [ ] API response times recorded
- [ ] Lighthouse audit completed

**Tools:**
- Laravel Pulse
- Lighthouse CI
- Blackfire.io

---

#### Story 2.2: Fix N+1 Queries
**ID:** US-002.02  
**Points:** 8  
**Priority:** Critical  

**As a** developer  
**I want** to eliminate N+1 queries  
**So that** database performance improves  

**Acceptance Criteria:**
- [ ] All N+1 queries identified
- [ ] Eager loading implemented
- [ ] Query count reduced by 90%
- [ ] Tests passing

**Implementation:**
```php
// ❌ Before: N+1 queries
$tickets = Ticket::all();
foreach ($tickets as $ticket) {
    echo $ticket->user->name;
}

// ✅ After: 1 query with eager loading
$tickets = Ticket::with('user')->get();
```

---

#### Story 2.3: Implement Query Caching
**ID:** US-002.03  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** to cache frequent queries  
**So that** database load is reduced  

**Acceptance Criteria:**
- [ ] Redis cache configured
- [ ] Query cache implemented
- [ ] Cache invalidation strategy defined
- [ ] Cache hit rate > 80%

**Implementation:**
```php
use Illuminate\Support\Facades\Cache;

$stats = Cache::remember(
    'ticket.stats',
    now()->addHour(),
    fn() => Ticket::selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->get()
);
```

---

#### Story 2.4: Optimize Images
**ID:** US-002.04  
**Points:** 3  
**Priority:** Medium  

**As a** frontend developer  
**I want** optimized images  
**So that** page load is faster  

**Acceptance Criteria:**
- [ ] WebP format used
- [ ] Responsive images implemented
- [ ] Lazy loading enabled
- [ ] Image size < 200KB

---

#### Story 2.5: Enable Vite Production Build
**ID:** US-002.05  
**Points:** 2  
**Priority:** High  

**As a** frontend developer  
**I want** optimized asset bundling  
**So that** CSS/JS load faster  

**Acceptance Criteria:**
- [ ] Vite build configured
- [ ] Code splitting enabled
- [ ] Tree shaking active
- [ ] Manifest generated

---

#### Story 2.6: Implement Route Caching
**ID:** US-002.06  
**Points:** 2  
**Priority:** Medium  

**As a** DevOps engineer  
**I want** route caching enabled  
**So that** routing is faster  

**Acceptance Criteria:**
- [ ] Route cache generated
- [ ] Config cache enabled
- [ ] View cache precompiled
- [ ] Deployment script updated

---

#### Story 2.7: Database Index Optimization
**ID:** US-002.07  
**Points:** 5  
**Priority:** High  

**As a** DBA  
**I want** proper database indexes  
**So that** queries are faster  

**Acceptance Criteria:**
- [ ] Slow queries identified
- [ ] Indexes added to frequent columns
- [ ] Query performance improved 50%
- [ ] No duplicate indexes

**SQL:**
```sql
-- Add indexes for frequent queries
CREATE INDEX idx_tickets_status ON fixcity_tickets(status);
CREATE INDEX idx_tickets_user_id ON fixcity_tickets(user_id);
CREATE INDEX idx_tickets_created_at ON fixcity_tickets(created_at);
```

---

#### Story 2.8: Implement Redis Session Driver
**ID:** US-002.08  
**Points:** 3  
**Priority:** Medium  

**As a** DevOps engineer  
**I want** sessions stored in Redis  
**So that** session performance improves  

**Acceptance Criteria:**
- [ ] Redis configured
- [ ] Session driver updated
- [ ] Session performance tested
- [ ] No regressions

---

#### Story 2.9: CDN Integration
**ID:** US-002.09  
**Points:** 5  
**Priority:** Medium  

**As a** DevOps engineer  
**I want** static assets on CDN  
**So that** load times improve globally  

**Acceptance Criteria:**
- [ ] CDN provider selected
- [ ] Assets configured
- [ ] Cache headers set
- [ ] Performance measured

---

#### Story 2.10: Performance Monitoring Dashboard
**ID:** US-002.10  
**Points:** 3  
**Priority:** Low  

**As a** team member  
**I want** real-time performance metrics  
**So that** we can detect regressions  

**Acceptance Criteria:**
- [ ] Laravel Pulse configured
- [ ] Custom metrics added
- [ ] Alerts configured
- [ ] Dashboard shared

---

## EPIC-003: API Documentation

**Priority:** 🔴 Critical  
**Status:** Ready  
**Story Points:** 26  
**Owner:** Backend Team  

### Description

Creare documentazione API completa usando OpenAPI 3.0 (Swagger) per migliorare developer experience e facilitare integrazioni.

### User Stories

#### Story 3.1: Setup OpenAPI Generator
**ID:** US-003.01  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** OpenAPI documentation auto-generated  
**So that** docs stay in sync with code  

**Acceptance Criteria:**
- [ ] swagger-php installed
- [ ] Attributes added to controllers
- [ ] Documentation generated
- [ ] Swagger UI accessible

---

#### Story 3.2: Document Authentication Endpoints
**ID:** US-003.02  
**Points:** 3  
**Priority:** High  

**As a** API consumer  
**I want** clear auth documentation  
**So that** I can authenticate properly  

---

#### Story 3.3: Document Ticket Endpoints
**ID:** US-003.03  
**Points:** 5  
**Priority:** High  

**As a** API consumer  
**I want** ticket API documented  
**So that** I can integrate ticket management  

---

#### Story 3.4: Document User Endpoints
**ID:** US-003.04  
**Points:** 3  
**Priority:** Medium  

**As a** API consumer  
**I want** user API documented  
**So that** I can manage users  

---

#### Story 3.5: Add API Examples
**ID:** US-003.05  
**Points:** 5  
**Priority:** Medium  

**As a** developer  
**I want** request/response examples  
**So that** integration is easier  

---

#### Story 3.6: Setup API Testing
**ID:** US-003.06  
**Points:** 5  
**Priority:** High  

**As a** QA engineer  
**I want** API tests  
**So that** endpoints work as documented  

---

## EPIC-004: Test Coverage Improvement

**Priority:** 🟡 High  
**Status:** Ready  
**Story Points:** 52  
**Owner:** QA Team  

### Description

Aumentare la test coverage dal 65% attuale all'85% target, con focus sui moduli critici.

### User Stories

#### Story 4.1: Coverage Gap Analysis
**ID:** US-004.01  
**Points:** 3  
**Priority:** High  

**As a** QA lead  
**I want** to identify coverage gaps  
**So that** we know where to focus  

---

#### Story 4.2: Fixcity Module Tests
**ID:** US-004.02  
**Points:** 8  
**Priority:** Critical  

**As a** developer  
**I want** comprehensive Fixcity tests  
**So that** ticket logic is reliable  

---

#### Story 4.3: Notify Module Tests
**ID:** US-004.03  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** Notify module tests  
**So that** notifications work correctly  

---

#### Story 4.4: Geo Module Tests
**ID:** US-004.04  
**Points:** 5  
**Priority:** Medium  

**As a** developer  
**I want** Geo module tests  
**So that** geolocation is accurate  

---

#### Story 4.5: Media Module Tests
**ID:** US-004.05  
**Points:** 5  
**Priority:** Medium  

**As a** developer  
**I want** Media module tests  
**So that** file uploads work  

---

#### Story 4.6: Gdpr Module Tests
**ID:** US-004.06  
**Points:** 5  
**Priority:** High  

**As a** developer  
**I want** GDPR compliance tests  
**So that** we're legally compliant  

---

#### Story 4.7: Integration Tests
**ID:** US-004.07  
**Points:** 8  
**Priority:** High  

**As a** QA engineer  
**I want** end-to-end tests  
**So that** workflows are validated  

---

#### Story 4.8: Browser Tests
**ID:** US-004.08  
**Points:** 5  
**Priority:** Medium  

**As a** QA engineer  
**I want** browser automation tests  
**So that** UI works correctly  

---

#### Story 4.9: Performance Tests
**ID:** US-004.09  
**Points:** 3  
**Priority:** Medium  

**As a** performance engineer  
**I want** load tests  
**So that** we know breaking point  

---

#### Story 4.10: Security Tests
**ID:** US-004.10  
**Points:** 5  
**Priority:** High  

**As a** security engineer  
**I want** security tests  
**So that** vulnerabilities are caught  

---

#### Story 4.11: CI/CD Test Integration
**ID:** US-004.11  
**Points:** 3  
**Priority:** High  

**As a** DevOps engineer  
**I want** tests in CI/CD  
**So that** bad code doesn't deploy  

---

#### Story 4.12: Test Documentation
**ID:** US-004.12  
**Points:** 2  
**Priority:** Low  

**As a** developer  
**I want** testing guidelines  
**So that** team writes consistent tests  

---

## EPIC-005: Documentation Consolidation

**Priority:** 🟡 High  
**Story Points:** 30  

### User Stories

#### Story 5.1: Documentation Audit
**ID:** US-005.01  
**Points:** 5  

**As a** tech writer  
**I want** to audit all docs  
**So that** we know what to consolidate  

---

#### Story 5.2: Create Documentation Structure
**ID:** US-005.02  
**Points:** 3  

**As a** developer  
**I want** clear doc structure  
**So that** finding info is easy  

---

#### Story 5.3: Consolidate Module Docs
**ID:** US-005.03  
**Points:** 8  

**As a** developer  
**I want** module docs organized  
**So that** onboarding is faster  

---

#### Story 5.4: Create API Reference
**ID:** US-005.04  
**Points:** 5  

---

#### Story 5.5: Update README Files
**ID:** US-005.05  
**Points:** 3  

---

#### Story 5.6: Create Quick Start Guide
**ID:** US-005.06  
**Points:** 3  

---

#### Story 5.7: Setup Doc Search
**ID:** US-005.07  
**Points:** 2  

---

#### Story 5.8: Doc Maintenance Plan
**ID:** US-005.08  
**Points:** 1  

---

## EPIC-006: Rate Limiting

**Priority:** 🟡 High  
**Story Points:** 20  

### User Stories

#### Story 6.1: Setup Redis Rate Limiter
**ID:** US-006.01  
**Points:** 3  

---

#### Story 6.2: API Rate Limiting
**ID:** US-006.02  
**Points:** 5  

---

#### Story 6.3: Authentication Rate Limiting
**ID:** US-006.03  
**Points:** 3  

---

#### Story 6.4: Custom Rate Limits per Tenant
**ID:** US-006.04  
**Points:** 5  

---

#### Story 6.5: Rate Limit Monitoring
**ID:** US-006.05  
**Points:** 4  

---

## EPIC-007: Backup Strategy

**Priority:** 🟡 High  
**Story Points:** 16  

### User Stories

#### Story 7.1: Database Backup Automation
**ID:** US-007.01  
**Points:** 5  

---

#### Story 7.2: File Storage Backup
**ID:** US-007.02  
**Points:** 3  

---

#### Story 7.3: Backup Testing
**ID:** US-007.03  
**Points:** 5  

---

#### Story 7.4: Disaster Recovery Plan
**ID:** US-007.04  
**Points:** 3  

---

## EPIC-008: Browser Testing Suite

**Priority:** 🟢 Medium  
**Story Points:** 24  

### User Stories

#### Story 8.1: Setup Pest Browser
**ID:** US-008.01  
**Points:** 3  

---

#### Story 8.2: Login Flow Tests
**ID:** US-008.02  
**Points:** 5  

---

#### Story 8.3: Ticket Creation Tests
**ID:** US-008.03  
**Points:** 5  

---

#### Story 8.4: Admin Panel Tests
**ID:** US-008.04  
**Points:** 5  

---

#### Story 8.5: Mobile Responsiveness Tests
**ID:** US-008.05  
**Points:** 3  

---

#### Story 8.6: Accessibility Tests
**ID:** US-008.06  
**Points:** 3  

---

## EPIC-009: Monitoring Enhancement

**Priority:** 🟢 Medium  
**Story Points:** 20  

### User Stories

#### Story 9.1: Laravel Pulse Setup
**ID:** US-009.01  
**Points:** 3  

---

#### Story 9.2: Custom Metrics
**ID:** US-009.02  
**Points:** 5  

---

#### Story 9.3: Alert Configuration
**ID:** US-009.03  
**Points:** 3  

---

#### Story 9.4: Log Aggregation
**ID:** US-009.04  
**Points:** 5  

---

#### Story 9.5: Uptime Monitoring
**ID:** US-009.05  
**Points:** 4  

---

## EPIC-010: Security Hardening

**Priority:** 🟢 Medium  
**Story Points:** 28  

### User Stories

#### Story 10.1: Security Audit
**ID:** US-010.01  
**Points:** 5  

---

#### Story 10.2: OWASP Compliance
**ID:** US-010.02  
**Points:** 5  

---

#### Story 10.3: CSP Headers
**ID:** US-010.03  
**Points:** 3  

---

#### Story 10.4: Dependency Updates
**ID:** US-010.04  
**Points:** 3  

---

#### Story 10.5: Security Testing
**ID:** US-010.05  
**Points:** 5  

---

#### Story 10.6: Incident Response Plan
**ID:** US-010.06  
**Points:** 4  

---

#### Story 10.7: Security Documentation
**ID:** US-010.07  
**Points:** 3  

---

## Release Planning

### Release 1.0 (Immediate - 2 weeks)
**Focus:** Critical fixes

- EPIC-001: Migration Cleanup
- EPIC-002: Performance Optimization (stories 1-5)
- EPIC-003: API Documentation (stories 1-3)

### Release 1.1 (Short-term - 1 month)
**Focus:** Quality improvements

- EPIC-003: API Documentation (complete)
- EPIC-004: Test Coverage (critical stories)
- EPIC-006: Rate Limiting
- EPIC-007: Backup Strategy

### Release 1.2 (Medium-term - 3 months)
**Focus:** Enhancement

- EPIC-004: Test Coverage (complete)
- EPIC-005: Documentation Consolidation
- EPIC-008: Browser Testing
- EPIC-009: Monitoring
- EPIC-010: Security

---

## Definition of Ready

A story is ready when:
- [ ] Acceptance criteria defined
- [ ] Dependencies identified
- [ ] Test approach defined
- [ ] Estimated by team
- [ ] Priority assigned

## Definition of Done

A story is done when:
- [ ] Code implemented
- [ ] Tests written and passing
- [ ] Code reviewed
- [ ] Documentation updated
- [ ] Deployed to staging
- [ ] PO approved

---

**Next Steps:**
1. ✅ Epics and stories created
2. ⏳ Sprint planning (next)
3. ⏳ Story implementation
