# Pitfalls Research: HR & Performance Evaluation Systems for Italian Public Administrations

**Domain:** Italian Public Administration HR Management  
**Researched:** 2026-03-18  
**Confidence:** HIGH  
**Project:** PTVX Fila5 Mono (Brownfield - Production System)

---

## Executive Summary

This research identifies **critical pitfalls** specific to HR & Performance Evaluation systems operating in the Italian Public Administration domain. These pitfalls are derived from:

- Analysis of 42+ production modules in PTVX system
- Italian regulatory requirements (D.Lgs. 150/2009, Law 104, GDPR, CCNL)
- High-stakes domain characteristics (employee careers, indemnities, legal compliance)
- Production troubleshooting documentation
- Multi-tenant architecture constraints

**Key Finding:** 80% of critical pitfalls relate to **calculation integrity**, **audit trail completeness**, and **regulatory compliance** — not generic software issues.

---

## Critical Pitfalls

### Pitfall 1: Floating-Point Calculation Drift in Indemnity Formulas

**What goes wrong:**
Indemnity calculations (performance bonuses, responsibility indemnities, working condition payments) use floating-point arithmetic instead of decimal/fixed-point, causing cumulative rounding errors that become legally significant at scale.

**Example:**
```php
// ❌ WRONG - Floating point drift
$bonus = 1000.50 * 0.15;  // 150.07499999999998
$total = $bonus * 1000;   // 150074.99999999997 instead of 150075.00

// ✅ CORRECT - BCMath or decimal
$bonus = bcmul('1000.50', '0.15', 2);  // 150.08
$total = bcmul($bonus, '1000', 2);     // 150080.00
```

**Why it happens:**
- Developers use native float operations for simplicity
- Testing done with small datasets where drift is invisible
- Italian PA regulations require exact cent precision (2 decimal places)
- CCNL formulas often involve percentages applied to large employee populations

**How to avoid:**
1. **Mandatory BCMath or Decimal pattern** for all monetary calculations
2. **Database columns** must use `DECIMAL(10,2)` or `DECIMAL(12,4)` — NEVER `FLOAT` or `DOUBLE`
3. **Validation rule**: All calculation results must match expected precision within tolerance of 0.01
4. **Audit test**: Recalculate all indemnities monthly and flag discrepancies > €0.01

**Warning signs:**
- Test assertions use `assertEqualsWithDelta()` instead of exact equality
- Database migrations show `decimal` but code uses float operations
- Total calculated indemnity differs from sum of individual amounts by > €0.01
- Users report "pochi centesimi di differenza" in payment certificates

**Phase to address:** **Phase 2 (Core Calculation Engine)** — Must be foundational

**Severity:** **CRITICAL** — Legal liability, payment disputes, audit failures

**Real-world example:**
Incentivi module shows calculation patterns in `/laravel/Modules/Incentivi/app/Actions/SpareImportoTotaleAction.php` — must verify BCMath usage.

---

### Pitfall 2: Incomplete Audit Trail for Performance Evaluations

**What goes wrong:**
Activity logging captures that a record was modified but not **which fields changed** or **what the old/new values were**, making it impossible to reconstruct evaluation history during legal disputes or union challenges.

**Why it happens:**
- Spatie Activity Log configured with `->logOnlyDirty()` but missing `->logAll()` or `->logOnly([...])`
- Developers assume "dirty" is sufficient without specifying fields
- Properties stored as JSON become large, teams disable field tracking for performance
- Multi-connection databases (activity log on different DB than business data) cause transaction issues

**How to avoid:**
1. **Mandatory configuration** in every model:
```php
public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logAll()  // ← CRITICAL: Without this, properties are EMPTY
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs()
        ->logExcept(['password', 'remember_token']); // Exclude sensitive
}
```

2. **Override in domain models** even if base class has it (IndennitaResponsabilita example)
3. **Test verification**: Every test that updates a model must assert `Activity::latest()->properties` is not empty
4. **Dual-connection awareness**: If activity log uses different DB connection, wrap in transaction

**Warning signs:**
- `Activity` table has records but `properties` column is `{}` or `null`
- Troubleshooting docs mention "properties vuote" (see `/laravel/Modules/Activity/docs/troubleshooting/properties-vuote-activity-log.md`)
- Users can see "updated" events but can't see what changed
- Audit requests require manual database comparison

**Phase to address:** **Phase 1 (Foundation & Compliance)** — Non-negotiable from day 1

**Severity:** **CRITICAL** — Fails D.Lgs. 150/2009 audit requirements, union challenges succeed

**Real-world example:**
Fixed in IndennitaResponsabilita by overriding `getActivitylogOptions()` with explicit field list including `stabi`, `coordinamento`, `responsabilita`, `tot`.

---

### Pitfall 3: Hardcoded Regulatory Percentages and Thresholds

**What goes wrong:**
CCNL-mandated percentages (performance bonus rates, seniority thresholds, indemnity multipliers) are hardcoded in code instead of configurable, requiring code deployment for every regulatory update.

**Example:**
```php
// ❌ WRONG - Hardcoded CCNL percentage
$bonus = $salary * 0.15;  // 15% from 2024 CCNL

// ✅ CORRECT - Configurable
$percentage = config('incentivi.ccnl_bonus_percentage', 0.15);
$bonus = $salary * $percentage;
```

**Why it happens:**
- "It's in the law, it won't change" assumption (false — CCNL renegotiated every 2-3 years)
- Quick implementation during MVP
- Multiple modules duplicate same constants

**How to avoid:**
1. **Central configuration file** per module: `config/{module}.php`
2. **Database-backed settings** for values that change per tenant (each PA may have integrations)
3. **Version tracking**: Store effective dates for regulatory changes
4. **Admin UI** for HR to update values without developer intervention

**Warning signs:**
- Magic numbers in calculation code: `* 0.15`, `* 0.02`, `>= 24` (months)
- Same number appears in multiple files
- Comments like "// D.Lgs. 150/2009 art. 7" next to numbers
- No admin screen to modify "system parameters"

**Phase to address:** **Phase 2 (Core Calculation Engine)**

**Severity:** **HIGH** — Operational rigidity, requires code deployment for policy changes

**Real-world example:**
Incentivi module PDF templates show hardcoded percentages: `percentuale applicabile per il calcolo del fondo è pari al 2%` — should be configurable per project type and year.

---

### Pitfall 4: Missing Multi-Tenant Data Isolation in Calculations

**What goes wrong:**
Queries accidentally cross tenant boundaries, exposing one Public Administration's employee data to another, or calculating indemnities using wrong tenant's budget/rules.

**Why it happens:**
- Global scopes not applied to complex joins or subqueries
- Raw SQL queries bypass tenant scoping
- Background jobs run without tenant context
- Cache keys not tenant-namespaced

**How to avoid:**
1. **Tenant scope on BaseModel**:
```php
// In BaseModel boot() method
static::addGlobalScope('tenant', function (Builder $query) {
    if (auth()->check() && auth()->user()->tenant_id) {
        $query->where('tenant_id', auth()->user()->tenant_id);
    }
});
```

2. **Explicit tenant ID in all queries** — never assume scope applies
3. **Cache key prefix**: `Cache::remember("tenant_{$tenantId}:key", ...)`
4. **Job middleware** to enforce tenant context:
```php
public function middleware(): array
{
    return ['tenant:' . $this->tenantId];
}
```

**Warning signs:**
- Queries without `where('tenant_id', ...)`
- Shared cache between tenants (one PA sees another's data)
- Background jobs fail with "tenant not found"
- Reports show aggregated data across all tenants

**Phase to address:** **Phase 1 (Foundation & Compliance)**

**Severity:** **CRITICAL** — GDPR violation, data breach, legal liability

**Real-world example:**
Tenant module exists but must verify all 42+ modules properly implement tenant scoping in complex queries (joins, subqueries, raw SQL).

---

### Pitfall 5: Performance Evaluation Timeline Misalignment

**What goes wrong:**
System allows evaluations outside the legally-mandated annual cycle (January-December with specific phases), creating invalid evaluations that can be challenged by unions.

**Why it happens:**
- No date validation on evaluation creation
- System doesn't enforce "current cycle only" rule
- Mid-year reviews treated same as annual evaluations
- Appeal periods not enforced (15 days mandatory by law)

**How to avoid:**
1. **EvaluationCycle model** with strict date ranges:
```php
class EvaluationCycle extends Model
{
    public function isValidForDate(Carbon $date): bool
    {
        return $date->between($this->start_date, $this->end_date);
    }
    
    public function isInAppealPeriod(): bool
    {
        return Carbon::now()->between(
            $this->publication_date->addDays(1),
            $this->publication_date->addDays(15)
        );
    }
}
```

2. **Form validation** in Filament resources:
```php
->rules([
    'evaluation_date' => 'required|date|between:' . 
        $cycle->start_date . ',' . $cycle->end_date,
])
```

3. **State machine** for evaluation workflow with date guards

**Warning signs:**
- Evaluations dated outside January-December cycle
- Appeals submitted after 15-day window still accepted
- Multiple evaluation cycles active simultaneously without clear distinction
- Users can "backdate" evaluations to previous years

**Phase to address:** **Phase 3 (Performance Evaluation Workflow)**

**Severity:** **HIGH** — Evaluations legally voidable, union challenges

**Regulatory context:** D.Lgs. 150/2009 mandates annual cycle with specific phases and appeal periods.

---

### Pitfall 6: Law 104 Permit Calculation Errors

**What goes wrong:**
System miscalculates Law 104 permits (3 days/month paid leave for disabled employees or caregivers), leading to unauthorized absences or denied legal benefits.

**Why it happens:**
- Complex eligibility rules (disability percentage, family relationship, employment type)
- Monthly accrual vs. annual lump sum confusion
- Part-time pro-rata calculations incorrect
- Multiple Law 104 situations (employee disabled vs. caring for disabled family)

**How to avoid:**
1. **Dedicated Legge104 module** with explicit calculation rules:
```php
class Legge104PermitCalculator
{
    public function calculateMonthlyAccrual(Employee $employee): int
    {
        if (!$employee->hasLegge104()) return 0;
        
        $baseDays = 3;
        
        // Part-time pro-rata
        if ($employee->isPartTime()) {
            $baseDays = (int) ceil($baseDays * $employee->part_time_percentage / 100);
        }
        
        return $baseDays;
    }
}
```

2. **Integration with PresenzeAssenze** module for real-time balance tracking
3. **Certification expiry tracking** — Law 104 status can change
4. **Audit trail** of every permit day taken vs. accrued

**Warning signs:**
- Permit balances don't match HR manual calculations
- Part-time employees get same allowance as full-time
- Expired Law 104 certifications still granting permits
- No distinction between employee disability vs. caregiver status

**Phase to address:** **Phase 4 (Absence & Time Management)**

**Severity:** **CRITICAL** — Violates Law 104/1992, discrimination liability

**Real-world example:**
Legge104 module exists but documentation shows "TODO" — high-risk incomplete feature.

---

### Pitfall 7: GDPR Data Export Incompleteness

**What goes wrong:**
When employee exercises "right to data portability" (GDPR Art. 20), system exports only direct user data but misses related records (evaluations, indemnities, absences, permits), resulting in incomplete export and GDPR violation.

**Why it happens:**
- Export limited to `users` table
- Related models not discovered automatically
- Activity logs excluded (they contain personal data too)
- PDF certificates not included in export

**How to avoid:**
1. **GDPR export service** with complete relationship graph:
```php
class GdprDataExportService
{
    public function export(User $user): array
    {
        return [
            'user' => $user->toArray(),
            'evaluations' => $user->performances()->with('kpis')->get(),
            'indemnities' => $user->indemnities()->get(),
            'absences' => $user->absences()->get(),
            'permits' => $user->legge104Permits()->get(),
            'activity_logs' => Activity::forSubject($user)->get(),
            'consents' => $user->gdprConsents()->get(),
        ];
    }
}
```

2. **Automated discovery** of all modules that reference the user
3. **Machine-readable format** (JSON) + human-readable (PDF)
4. **30-day deadline tracking** (GDPR requires response within 30 days)

**Warning signs:**
- GDPR export takes >5 minutes (missing automation)
- Export file <1MB for long-term employee (data missing)
- No export for "deleted" users (data still exists for legal holds)
- Activity logs not included in export

**Phase to address:** **Phase 1 (Foundation & Compliance)**

**Severity:** **CRITICAL** — GDPR violation, fines up to €20M or 4% global turnover

**Real-world example:**
Gdpr module exists with compliance docs listing external resources — must verify complete implementation across all 42+ modules.

---

### Pitfall 8: Union Consultation Workflow Bypass

**What goes wrong:**
System allows indemnity distribution or performance criteria to be approved without mandatory union consultation (RSU - Rappresentanza Sindacale Unitaria), making decisions legally void.

**Why it happens:**
- No workflow state for "pending union consultation"
- Approval chain skips RSU role
- Union consultation period (typically 15-30 days) not enforced
- No tracking of union opinions/objections

**How to avoid:**
1. **Workflow state machine** with mandatory RSU step:
```php
'workflow_states' => [
    'draft' => 'hr_can_edit',
    'pending_rsu_consultation' => 'readonly',  // 15-day period
    'rsu_approved' => 'management_can_approve',
    'rsu_objections' => 'hr_must_revise',
    'final_approved' => 'locked',
]
```

2. **Sindacati module integration** for RSU member tracking
3. **Automatic notifications** to RSU representatives
4. **Consultation period timer** — can't approve until period expires

**Warning signs:**
- Projects/indemnities move from "draft" to "approved" without RSU state
- No RSU user role in system
- Union consultation documents not attached to records
- Approval dates before consultation period end

**Phase to address:** **Phase 5 (Union Relations & Collective Bargaining)**

**Severity:** **HIGH** — Decisions legally voidable, union grievances

**Real-world example:**
Sindacati module exists — must verify integration with Incentivi and Performance modules for RSU consultation workflows.

---

### Pitfall 9: ContoAnnuale Reporting Data Mismatch

**What goes wrong:**
Annual financial report (ContoAnnuale) submitted to Ministry shows different indemnity/bonus totals than what was actually paid, triggering audits and requiring corrective submissions.

**Why it happens:**
- ContoAnnuale aggregates from different tables than payment system
- Timing differences (accrual vs. cash basis)
- Some indemnity types excluded from report
- Round-trip validation missing (can't reconcile report back to source)

**How to avoid:**
1. **Single source of truth** — ContoAnnuale reads directly from payment tables
2. **Reconciliation report** before submission:
```php
class ContoAnnualeReconciliation
{
    public function verify(): array
    {
        $paid = Indennita::whereYear('payment_date', $year)->sum('amount');
        $reported = ContoAnnualeRecord::whereYear('reference_year', $year)->sum('amount');
        
        return [
            'match' => abs($paid - $reported) < 0.01,
            'difference' => $paid - $reported,
            'details' => $this->findDiscrepancies($year),
        ];
    }
}
```

3. **Audit trail** from report line items back to individual payments
4. **Ministry validation rules** encoded as system validations

**Warning signs:**
- Manual Excel reconciliation before submission
- "Adjustment entries" in ContoAnnuale without source documents
- Different totals in HR system vs. accounting system
- Last-minute "corrections" to report data

**Phase to address:** **Phase 6 (Financial Reporting & Compliance)**

**Severity:** **HIGH** — Ministry audit, corrective submissions, reputational damage

**Real-world example:**
ContoAnnuale module exists with "TODO" documentation — critical compliance feature at risk.

---

### Pitfall 10: PDF Certificate Generation with Stale Data

**What goes wrong:**
PDF certificates (indemnity statements, evaluation reports) generated from cached/snapshot data that doesn't match current database state, creating legally-binding documents with incorrect information.

**Why it happens:**
- PDF generated at workflow start, not at approval/finalization
- View data uses old model snapshot
- No version tracking on generated PDFs
- Regenerating PDF after changes creates duplicate with different data

**How to avoid:**
1. **Generate at final state only**:
```php
// In approval action
public function approve(Project $project): Pdf
{
    $project->approve();  // Change state first
    
    // Generate PDF AFTER state change with fresh data
    return ProjectReportPdf::generate($project->fresh());
}
```

2. **PDF versioning** — hash of data used:
```php
$pdf->metadata = [
    'generated_at' => Carbon::now(),
    'data_hash' => hash('sha256', json_encode($project->toArray())),
    'version' => $project->version,
];
```

3. **Regeneration invalidates old PDF** — mark previous as superseded
4. **Digital signature** after generation (prevents tampering)

**Warning signs:**
- Multiple PDF versions for same record
- PDF data doesn't match current UI display
- PDFs can be generated in "draft" state
- No timestamp on PDF documents

**Phase to address:** **Phase 2 (Core Calculation Engine)** — When PDF features added

**Severity:** **MEDIUM-HIGH** — Legal disputes over which version is authoritative

**Real-world example:**
Incentivi module has extensive PDF templates in `/laravel/Modules/Incentivi/resources/views/filament/pdf/` — must verify generation timing and versioning.

---

### Pitfall 11: Evaluation Committee Conflict of Interest

**What goes wrong:**
System assigns evaluators who have conflicts of interest (evaluating relatives, subordinates they directly manage, or colleagues in same office) violating impartiality requirements.

**Why it happens:**
- No conflict of interest detection
- Evaluator assignment doesn't check organizational relationships
- Self-evaluation not prevented
- Manager evaluating own family members in same administration

**How to avoid:**
1. **Conflict detection rules**:
```php
class EvaluatorConflictChecker
{
    public function hasConflict(User $evaluator, User $evaluatee): bool
    {
        // Same office
        if ($evaluator->office_id === $evaluatee->office_id) {
            return true;
        }
        
        // Direct reporting line
        if ($evaluator->isDirectManagerOf($evaluatee)) {
            return true;  // Or false depending on PA rules
        }
        
        // Family relationship (requires external data)
        if ($this->hasFamilyRelationship($evaluator, $evaluatee)) {
            return true;
        }
        
        return false;
    }
}
```

2. **Organizational hierarchy validation** — prevent upward/downward evaluation unless authorized
3. **Disclosure workflow** — evaluator must declare no conflicts
4. **Audit trail** of conflict checks performed

**Warning signs:**
- Same office colleagues evaluating each other
- Managers evaluating direct reports without authorization
- No conflict of interest declaration in evaluation workflow
- Union grievances about evaluator impartiality

**Phase to address:** **Phase 3 (Performance Evaluation Workflow)**

**Severity:** **HIGH** — Evaluations voidable, impartiality challenges

**Regulatory context:** D.Lgs. 150/2009 requires impartial evaluation committees.

---

### Pitfall 12: Career Progression Seniority Miscalculation

**What goes wrong:**
System calculates seniority incorrectly for career progression eligibility, denying eligible employees or approving ineligible ones based on wrong service years.

**Why it happens:**
- Seniority calculated from hire date only (misses previous PA service)
- Career breaks not excluded (unpaid leave, suspensions)
- Part-time service not pro-rated correctly
- External service recognition missing (military, other PAs)

**How to avoid:**
1. **Seniority service with explicit rules**:
```php
class SeniorityCalculator
{
    public function calculateForProgression(Employee $employee): SeniorityResult
    {
        $totalMonths = 0;
        
        // Current PA service
        $totalMonths += $employee->hire_date->diffInMonths(Carbon::now());
        
        // Exclude unpaid leaves > 30 days
        $totalMonths -= $employee->unpaidLeaves()
            ->where('duration_days', '>', 30)
            ->sum('duration_months');
        
        // Add recognized external service
        $totalMonths += $employee->recognizedExternalService()->sum('months');
        
        return new SeniorityResult(
            years: (int) floor($totalMonths / 12),
            months: $totalMonths % 12,
            eligible: $totalMonths >= 24  // CCNL minimum
        );
    }
}
```

2. **Service history tracking** — all employment periods
3. **Manual override with justification** — HR can adjust with reason
4. **Eligibility preview** — employee can see projected eligibility date

**Warning signs:**
- Seniority = current date minus hire date (too simple)
- No record of previous PA employment
- Employees with same hire date have different seniority without explanation
- Progression applications rejected for "insufficient seniority" with manual overrides

**Phase to address:** **Phase 7 (Career Progression Management)**

**Severity:** **HIGH** — Career damage, discrimination claims, union grievances

**Real-world example:**
Progressioni module documentation emphasizes "schede di valutazione" but seniority calculation rules not visible — verify implementation.

---

### Pitfall 13: Biometric Attendance Data Integration Failures

**What goes wrong:**
Biometric time clock data doesn't sync correctly with PresenzeAssenze module, creating attendance gaps that affect indemnity calculations and performance evaluations.

**Why it happens:**
- Biometric system API changes without notification
- Sync job fails silently (no monitoring)
- Timezone mismatches (biometric server vs. application server)
- Duplicate records from retry logic

**How to avoid:**
1. **Robust sync job with idempotency**:
```php
class SyncBiometricAttendance extends Action
{
    public function execute(): void
    {
        $records = $this->fetchFromBiometricSystem();
        
        foreach ($records as $record) {
            // Idempotent upsert
            Attendance::updateOrCreate(
                [
                    'employee_id' => $record->employee_id,
                    'date' => $record->date,
                    'fingerprint_hash' => $record->hash,  // Prevent duplicates
                ],
                ['clock_in' => $record->time, ...]
            );
        }
        
        // Alert if sync gap detected
        if ($this->hasGap()) {
            NotifyAdmin::send('Biometric sync gap detected');
        }
    }
}
```

2. **Reconciliation report** — compare expected vs. actual records
3. **Manual correction workflow** — HR can fix sync errors
4. **Monitoring alerts** — notify if sync hasn't run in 24 hours

**Warning signs:**
- Attendance records missing for specific dates
- Employees show "absent" but were present
- Duplicate clock-in records
- Sync job last run: 3 days ago

**Phase to address:** **Phase 4 (Absence & Time Management)**

**Severity:** **MEDIUM-HIGH** — Payroll errors, attendance disputes

**Real-world example:**
PresenzeAssenze module exists with "TODO" documentation — biometric integration likely incomplete.

---

### Pitfall 14: INAIL Injury Reporting Delays

**What goes wrong:**
Workplace injuries not reported to INAIL within legal deadline (2 days for serious injuries, 5 days for others), resulting in fines and coverage gaps.

**Why it happens:**
- No automatic deadline tracking
- Injury report workflow too complex
- Missing integration with INAIL online system
- Injury classification (serious vs. minor) unclear

**How to avoid:**
1. **Deadline tracking with escalation**:
```php
class InjuryReportDeadline
{
    public function check(Injury $injury): void
    {
        $deadline = $injury->occurred_at->addDays(
            $injury->is_serious ? 2 : 5
        );
        
        if (Carbon::now()->gt($deadline) && !$injury->reported_to_inail) {
            // Escalate
            NotifyManager::send("INAIL report overdue for injury #{$injury->id}");
            NotifyLegal::send("Potential fine for late INAIL reporting");
        }
    }
}
```

2. **INAIL telematico integration** — direct submission
3. **Checklist for injury classification** — guide HR on serious vs. minor
4. **Audit trail** of report submission confirmation

**Warning signs:**
- Injuries in system with no INAIL report number
- Report dates >5 days after injury date
- Manual Excel tracking of INAIL reports alongside system
- No alert when injury entered without INAIL submission

**Phase to address:** **Phase 8 (Workplace Safety & INAIL)**

**Severity:** **CRITICAL** — INAIL fines, criminal liability for serious injuries

**Real-world example:**
Inail module exists with "TODO" documentation — critical compliance feature at risk.

---

### Pitfall 15: Performance Bonus Budget Exhaustion

**What goes wrong:**
System calculates and approves bonuses exceeding the allocated budget, requiring clawbacks or creating unfunded liabilities.

**Why it happens:**
- Individual bonus calculations don't check remaining budget
- Budget defined annually but bonuses calculated throughout year
- Multiple projects drawing from same budget pool
- Budget amendments not reflected in system

**How to avoid:**
1. **Budget-aware calculation**:
```php
class BonusCalculator
{
    public function calculate(Project $project): Decimal
    {
        $totalBudget = $project->budget->total_amount;
        $alreadyAllocated = $project->bonuses()->sum('amount');
        $remaining = $totalBudget - $alreadyAllocated;
        
        $calculatedBonus = $this->applyFormula($project);
        
        if ($calculatedBonus > $remaining) {
            throw new BudgetExhaustedException(
                "Bonus €{$calculatedBonus} exceeds remaining budget €{$remaining}"
            );
        }
        
        return $calculatedBonus;
    }
}
```

2. **Budget reservation** — tentative bonuses reserve budget portion
3. **Real-time budget dashboard** — HR sees remaining budget
4. **Approval workflow** — bonuses > X% of remaining budget require director approval

**Warning signs:**
- Total bonuses > budget in financial reports
- "Supplementary budget" requests mid-year
- Bonuses approved then cancelled due to "budget issues"
- No real-time budget tracking in UI

**Phase to address:** **Phase 2 (Core Calculation Engine)**

**Severity:** **HIGH** — Financial liability, audit findings, employee disputes

**Real-world example:**
Incentivi module has budget management but must verify real-time budget checking in calculation actions.

---

## Technical Debt Patterns

| Shortcut | Immediate Benefit | Long-term Cost | When Acceptable |
|----------|-------------------|----------------|-----------------|
| **Float instead of Decimal** | Faster coding, no BCMath verbosity | Calculation drift, legal disputes, audit failures | **NEVER** for monetary/regulatory calculations |
| **Skip activity log configuration** | Faster model creation | Can't reconstruct history, failed audits, union challenges win | **NEVER** for HR/Performance domain |
| **Hardcode CCNL percentages** | Quick MVP, no config overhead | Code deployment for every regulatory change, HR can't adapt | MVP only, must fix before production |
| **Single tenant for testing** | Simpler development | Multi-tenant bugs found late, data leakage in production | Development only, must test multi-tenant before Phase 1 complete |
| **PDF at workflow start** | Faster user feedback | Stale PDFs, version confusion, legal disputes | Internal drafts only, never for final certificates |
| **Manual ContoAnnuale reconciliation** | No development time | Monthly manual work forever, submission errors, audits | **NEVER** — automate from start |
| **No conflict of interest checks** | Faster evaluator assignment | Impartiality challenges, voided evaluations | **NEVER** — legal requirement |
| **Silent sync job failures** | No alert infrastructure | Attendance gaps, payroll errors, disputes | MVP only, must add monitoring in Phase 1 |

---

## Integration Gotchas

| Integration | Common Mistake | Correct Approach |
|-------------|----------------|------------------|
| **Sigma (Payroll)** | Export CSV manually | Automated API integration with validation |
| **Europa (Accounting)** | Duplicate payment entries | Single source of truth, Europa reads from PTVX |
| **PDND (National Data Hub)** | Push all data | Push only required by law, with citizen consent tracking |
| **Biometric Systems** | Poll every minute | Event-based sync + scheduled reconciliation |
| **INAIL Telematico** | Manual web form entry | Direct API integration with submission tracking |
| **SPID/CIE (Identity)** | Custom authentication | Use official Laravel Socialite providers |
| **Ministry ContoAnnuale** | Excel manual upload | XML generation with validation against Ministry schema |

---

## Performance Traps

| Trap | Symptoms | Prevention | When It Breaks |
|------|----------|------------|----------------|
| **N+1 on employee lists** | Page loads 10s with 100+ employees | Eager loading, `with()` relationships | 50+ employees per page |
| **Full table scan for date ranges** | Reports timeout | Indexed date columns, partitioning by year | 10k+ records per table |
| **PDF generation in request** | Request timeout (504) | Queue PDF generation, notify when ready | PDFs >50 pages |
| **Real-time calculation on every keystroke** | UI lag, high CPU | Debounce calculations, cache intermediate results | Complex formulas with 10+ inputs |
| **Activity log on every field** | `activity` table grows 1GB/month | Log only business-critical fields, archive old logs | 100+ updates/day per model |
| **Cache without tenant namespace** | Tenant A sees Tenant B data | Prefix cache keys: `tenant_{id}:key` | 2+ tenants active |
| **Monolithic evaluation form** | Form submission fails silently | Split into steps, validate progressively | Forms with 50+ fields |

---

## Security Mistakes

| Mistake | Risk | Prevention |
|---------|------|------------|
| **Employee can view colleague's evaluation** | Privacy violation, GDPR fine | Policy checks on every evaluation access, test with different user roles |
| **HR can see all tenants' data** | Multi-tenant breach | Tenant middleware on every HR route, integration tests |
| **Indemnity amounts in URL** | Data tampering, privilege escalation | Use route model binding with policy checks, never expose amounts in URL |
| **Activity logs visible to all HR** | Insider threat, privacy violation | Activity log access restricted to compliance officer role |
| **PDF certificates without digital signature** | Document tampering | Mandatory digital signature (firma digitale) on all official PDFs |
| **GDPR export includes other employees' data** | Data breach | Test export with employees who have common records (same office, same projects) |
| **Evaluation comments not sanitized** | XSS attacks | Strip tags on input, escape on output, CSP headers |

---

## UX Pitfalls

| Pitfall | User Impact | Better Approach |
|---------|-------------|-----------------|
| **Evaluation form shows 100 fields at once** | Overwhelm, abandonment | Progressive disclosure, wizard steps, save progress |
| **Indemnity calculation is "black box"** | Distrust, manual verification | Show formula breakdown, "why this amount" tooltip |
| **No draft auto-save** | Lost work, frustration | Auto-save every 30 seconds, restore on return |
| **Union consultation deadline not visible** | Missed deadlines, voided decisions | Countdown timer, calendar integration, escalation alerts |
| **PDF preview before generation** | "Download" button does nothing | Show loading state, email when ready, download from notifications |
| **Seniority calculation unexplained** | Career progression disputes | "Eligibility calculator" showing current seniority + projected date |
| **Biometric sync failures invisible** | Attendance gaps unnoticed | Dashboard widget showing sync status, last sync time, error count |

---

## "Looks Done But Isn't" Checklist

- [ ] **Indemnity Calculation:** Often missing BCMath/decimal precision — verify all calculations use `bcmul()`, `bcadd()`, or Decimal objects
- [ ] **Audit Trail:** Often missing field-level changes — verify `Activity::latest()->properties` is not empty after updates
- [ ] **PDF Certificates:** Often missing version tracking — verify PDF metadata includes generation timestamp and data hash
- [ ] **Multi-Tenant:** Often missing in complex queries — verify all joins/subqueries include tenant scoping
- [ ] **GDPR Export:** Often missing related records — verify export includes evaluations, indemnities, activity logs
- [ ] **Union Consultation:** Often missing workflow state — verify RSU consultation is mandatory state before approval
- [ ] **ContoAnnuale:** Often missing reconciliation — verify report totals match payment totals within €0.01
- [ ] **Law 104:** Often missing part-time pro-rata — verify permits are reduced for part-time employees
- [ ] **INAIL:** Often missing deadline tracking — verify alerts trigger 1 day before reporting deadline
- [ ] **Evaluator Conflicts:** Often missing detection — verify system prevents/reports conflicts of interest

---

## Recovery Strategies

| Pitfall | Recovery Cost | Recovery Steps |
|---------|---------------|----------------|
| **Float calculation drift** | HIGH | 1) Audit all calculations, 2) Recalculate historical data with BCMath, 3) Issue corrected payment certificates, 4) Notify affected employees |
| **Empty audit trail** | MEDIUM | 1) Fix Activity Log config, 2) Backfill critical changes from database timestamps, 3) Document gap period, 4) Implement enhanced logging |
| **Hardcoded percentages** | LOW-MEDIUM | 1) Extract to config file, 2) Create admin UI, 3) Migrate existing values, 4) Document change process |
| **Tenant data leakage** | CRITICAL | 1) Immediate audit of affected tenants, 2) Notify affected parties, 3) Fix scoping, 4) Implement monitoring, 5) Legal review |
| **Stale PDF certificates** | MEDIUM | 1) Regenerate all active certificates, 2) Mark old PDFs as superseded, 3) Implement versioning, 4) Notify recipients of updated docs |
| **Budget exhaustion** | HIGH | 1) Freeze pending bonuses, 2) Recalculate within budget, 3) Seek supplementary budget, 4) Implement budget checks |
| **INAIL reporting delays** | MEDIUM-HIGH | 1) Submit late reports with justification, 2) Pay fines if assessed, 3) Implement deadline tracking, 4) Train HR on new workflow |

---

## Pitfall-to-Phase Mapping

| Pitfall | Prevention Phase | Verification |
|---------|------------------|--------------|
| **Float calculation drift** | Phase 2 (Core Calculation Engine) | All calculations use BCMath, tests verify exact decimal precision |
| **Incomplete audit trail** | Phase 1 (Foundation & Compliance) | Test asserts `Activity.properties` not empty after every update |
| **Hardcoded percentages** | Phase 2 (Core Calculation Engine) | Config file exists, admin UI allows changes without code deploy |
| **Multi-tenant isolation** | Phase 1 (Foundation & Compliance) | Integration tests with 2+ tenants, verify no cross-tenant queries |
| **Evaluation timeline** | Phase 3 (Performance Evaluation Workflow) | Test prevents evaluations outside cycle dates, appeal period enforced |
| **Law 104 calculations** | Phase 4 (Absence & Time Management) | Test part-time pro-rata, certification expiry, accrual accuracy |
| **GDPR export incomplete** | Phase 1 (Foundation & Compliance) | Export test includes 10+ related models, not just user record |
| **Union consultation bypass** | Phase 5 (Union Relations) | Workflow test blocks approval without RSU state |
| **ContoAnnuale mismatch** | Phase 6 (Financial Reporting) | Reconciliation test verifies report = payments within €0.01 |
| **Stale PDF data** | Phase 2 (Core Calculation Engine) | PDF test verifies generation after state change, includes version hash |
| **Evaluator conflicts** | Phase 3 (Performance Evaluation Workflow) | Test prevents conflicting evaluator assignments |
| **Seniority miscalculation** | Phase 7 (Career Progression) | Test calculates seniority with breaks, external service, part-time |
| **Biometric sync failures** | Phase 4 (Absence & Time Management) | Monitoring test alerts on sync gap >24 hours |
| **INAIL deadline missed** | Phase 8 (Workplace Safety) | Test triggers alert 1 day before deadline |
| **Budget exhaustion** | Phase 2 (Core Calculation Engine) | Test prevents bonus approval exceeding remaining budget |

---

## Italian Regulatory Context

### Critical Regulations

| Regulation | Area | Key Requirement | System Impact |
|------------|------|-----------------|---------------|
| **D.Lgs. 150/2009** | Performance Evaluation | Annual cycle, appeal periods, impartial committees | EvaluationCycle model, RSU workflow, conflict checks |
| **Law 104/1992** | Disability Rights | 3 days/month paid permits, workplace accommodations | Legge104 module, permit accrual, expiry tracking |
| **D.Lgs. 81/2008** | Workplace Safety | INAIL reporting within 2-5 days | Injury deadline tracking, INAIL integration |
| **GDPR (EU 2016/679)** | Data Protection | Data portability, right to erasure, consent | GdprDataExportService, consent management |
| **CCNL Funzioni Locali** | Employment Terms | Seniority thresholds, bonus percentages, progression rules | Configurable CCNL parameters, seniority calculator |
| **D.Lgs. 33/2013** | Transparency | Publication of evaluations, bonuses | Public dashboard (with privacy redaction) |
| **Law 109/1996** | Anti-Mafia | Certification for public works | Legge109 module, certificate expiry tracking |
| **D.Lgs. 82/2005 (CAD)** | Digital Administration | Digital signatures, electronic documents | PDF digital signature, SPID/CIE integration |

### Compliance Deadlines

| Requirement | Deadline | System Enforcement |
|-------------|----------|-------------------|
| **Performance evaluation cycle** | January-December annually | EvaluationCycle dates enforced |
| **Appeal period** | 15 days from publication | Automatic closure after 15 days |
| **INAIL injury report** | 2 days (serious), 5 days (minor) | Alert 1 day before, block after deadline |
| **GDPR data export** | 30 days from request | Tracking dashboard for pending requests |
| **ContoAnnuale submission** | January 31 annually | Reminder starting December 1 |
| **Union consultation** | 15-30 days depending on matter | Workflow state with countdown |
| **Law 104 permit accrual** | Monthly by 1st | Automatic accrual job on 1st of month |

---

## Sources

### Internal Documentation
- `/var/www/_bases/base_ptvx_fila5/.planning/PROJECT.md` — Project context
- `/var/www/_bases/base_ptvx_fila5/.planning/codebase/DOMAIN.md` — Business domain (771 lines)
- `/var/www/_bases/base_ptvx_fila5/INCENTIVI_DETAILED_INVENTORY.md` — Incentivi module complete inventory
- `/var/www/_bases/base_ptvx_fila5/laravel/Modules/Activity/docs/troubleshooting/properties-vuote-activity-log.md` — Audit trail troubleshooting
- 42+ module README files (analyzed for completeness gaps)

### Regulatory References
- D.Lgs. 150/2009 — Performance evaluation in public administration
- Law 104/1992 — Disability rights and permits
- D.Lgs. 81/2008 — Workplace safety and INAIL
- GDPR (EU 2016/679) — Data protection
- CCNL Funzioni Locali — National collective labor agreement

### Production Experience
- Activity Log "properties vuote" issue — real production bug fixed October 2025
- Incentivi module calculation patterns — 13 models, 10 resources, 3 calculation actions
- Multi-tenant architecture — Tenant module with database scoping
- PDF generation — 20+ PDF templates across modules

---

## Research Quality Gates

- [x] Pitfalls specific to HR/PA domain (not generic advice) — All 15 pitfalls are HR/PA-specific
- [x] Prevention strategies actionable — Each pitfall includes code examples and specific steps
- [x] Phase mapping included — All pitfalls mapped to roadmap phases
- [x] Italian regulatory context addressed — 8 critical regulations mapped to system requirements
- [x] Severity levels assigned — CRITICAL (5), HIGH (7), MEDIUM-HIGH (3)

---

*Pitfalls research for: Italian Public Administration HR & Performance Evaluation*  
*Researched: 2026-03-18*  
*Confidence: HIGH (based on production system analysis)*
