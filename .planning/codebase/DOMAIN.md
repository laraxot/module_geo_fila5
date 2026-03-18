# PTVX Business Domain Overview

> **Project**: PTVX Fila5 Mono - HR & Performance Evaluation System  
> **Domain**: Italian Public Administration HR Management  
> **Last Updated**: 2026-03-18

---

## Table of Contents

1. [Domain Context](#domain-context)
2. [Core Business Capabilities](#core-business-capabilities)
3. [HR Management](#hr-management)
4. [Performance Evaluation](#performance-evaluation)
5. [Indemnity & Bonus Management](#indemnity--bonus-management)
6. [Career Progression](#career-progression)
7. [Compliance & Legal](#compliance--legal)
8. [Italian Public Administration Context](#italian-public-administration-context)
9. [Key Business Processes](#key-business-processes)
10. [Domain Terminology](#domain-terminology)

---

## Domain Context

PTVX operates in the **Italian Public Administration HR Management** domain, providing a comprehensive system for:

- **Personnel management** for municipalities, provinces, and regional authorities
- **Performance evaluation** compliant with national regulations (D.Lgs. 150/2009)
- **Indemnity and bonus calculation** with automated formulas
- **Career progression** tracking and management
- **Legal compliance** with Italian public administration regulations

### Regulatory Framework

The system is designed to comply with:

| Regulation | Description | Module |
|------------|-------------|--------|
| **D.Lgs. 150/2009** | Public administration performance evaluation | Performance |
| **D.Lgs. 75/2017** | Public employment reform | Performance, Progressioni |
| **Law 104/1992** | Disability support and permits | Legge104 |
| **Law 109/1996** | Public works anti-mafia compliance | Legge109 |
| **GDPR** | Data protection and privacy | Gdpr |
| **INAIL regulations** | Workplace injury reporting | Inail |
| **CCNL** | National collective labor agreements | Job, Progressioni |

---

## Core Business Capabilities

### Capability Map

```
┌─────────────────────────────────────────────────────────────────┐
│                   PTVX Business Capabilities                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────┐  ┌──────────────────┐  ┌────────────────┐│
│  │ HR Management    │  │ Performance      │  │ Indemnities    ││
│  │ - Personnel      │  │ - Evaluations    │  │ - Calculations ││
│  │ - Roles          │  │ - KPIs           │  │ - Payments     ││
│  │ - Organization   │  │ - Feedback       │  │ - Audit        ││
│  └──────────────────┘  └──────────────────┘  └────────────────┘│
│                                                                  │
│  ┌──────────────────┐  ┌──────────────────┐  ┌────────────────┐│
│  │ Career           │  │ Compliance       │  │ Integration    ││
│  │ - Progressions   │  │ - Legal          │  │ - PDND         ││
│  │ - Qualifications │  │ - Reporting      │  │ - External     ││
│  │ - Seniority      │  │ - Audits         │  │ - Data Exchange││
│  └──────────────────┘  └──────────────────┘  └────────────────┘│
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## HR Management

### Overview

Comprehensive human resource management for Italian public administrations with support for:

- **Employee lifecycle** from hiring to retirement
- **Organizational structure** with departments and roles
- **Time and attendance** tracking
- **Payroll integration** support

### Key Entities

```
┌─────────────────┐
│     User        │  (Employee/Citizen)
├─────────────────┤
│ - id (uuid)     │
│ - name          │
│ - email         │
│ - fiscal_code   │
│ - hire_date     │
│ - employment_type│
│ - status        │
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
┌───▼───┐ ┌──▼──────┐
│  Job  │ │Department│
│Position│ │          │
└───────┘ └──────────┘
```

### Capabilities

#### 1. Employee Management (User Module)

- Employee profiles with complete personal and professional data
- Employment contract tracking (permanent, fixed-term, temporary)
- Multiple role assignments
- Manager-subordinate relationships
- Integration with authentication systems (SPID, CIE)

#### 2. Organizational Structure (Job Module)

- Department/office hierarchy
- Job position definitions
- Reporting lines
- Organizational charts
- Role-based access control

#### 3. Time & Attendance (PresenzeAssenze + Ptv Modules)

- Attendance tracking (biometric integration capable)
- Absence management:
  - Vacation days (ferie)
  - Permits (permessi)
  - Sick leave (malattia)
  - Law 104 permits
  - Union permits
- Variable time tracking (PTV - Personale Tempo Variabile)
- Overtime management
- Time bank (banca ore)

#### 4. Booking Services (Mensa + Prenotazioni Modules)

- Canteen meal booking
- Meeting room reservations
- Company vehicle booking
- Equipment loans

---

## Performance Evaluation

### Overview

Complete performance evaluation cycle management compliant with **D.Lgs. 150/2009** for Italian public administrations.

### Evaluation Cycle

```
┌─────────────────────────────────────────────────────────────────┐
│                  Performance Evaluation Cycle                    │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌─────────┐    ┌─────────┐    ┌─────────┐    ┌─────────────┐  │
│  │  Plan   │ →  │ Monitor │ →  │ Evaluate│ →  │   Review    │  │
│  │         │    │         │    │         │    │  & Approve  │  │
│  └─────────┘    └─────────┘    └─────────┘    └─────────────┘  │
│       │              │              │              │            │
│  - Define      - Track       - Self-        - Validation       │
│    KPIs          progress      evaluation   - Committee        │
│  - Set         - Mid-year    - Manager      - Publication      │
│    targets     review        evaluation   - Appeals            │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### Key Concepts

#### 1. Performance Evaluation (Performance Module)

**Evaluation Types**:
- **Individual Performance**: Employee-specific goals and achievements
- **Organizational Performance**: Department/office performance
- **Manager Performance**: Leadership and management effectiveness

**Evaluation Components**:
- **KPIs (Key Performance Indicators)**: Quantifiable metrics
- **Competencies**: Skills and behavioral indicators
- **Goals**: Specific objectives with targets
- **360° Feedback**: Multi-rater feedback (optional)

**Workflow**:
```
1. Evaluation Plan Creation (HR)
   ↓
2. Goal Assignment (Manager → Employee)
   ↓
3. Self-Evaluation (Employee)
   ↓
4. Manager Evaluation
   ↓
5. Evaluation Committee Review
   ↓
6. Final Approval
   ↓
7. Publication & Notification
   ↓
8. Appeal Period (if applicable)
```

#### 2. Rating System (Rating Module)

**Rating Scales**:
- Numeric: 1-10 scale
- Descriptive: Insufficient, Sufficient, Good, Very Good, Excellent
- Custom scales per evaluation type

**Score Calculation**:
- Weighted average of KPIs
- Competency scores
- Bonus/malus adjustments
- Normalization rules

#### 3. Questionnaires (Questionari Module)

**Survey Types**:
- Climate surveys
- 360° feedback
- Training needs assessment
- Satisfaction surveys

**Features**:
- Multiple question types (single choice, multiple choice, text, scale)
- Anonymous responses
- Statistical analysis
- Export capabilities

---

## Indemnity & Bonus Management

### Overview

Automated calculation and management of indemnities, bonuses, and additional compensation for public administration employees.

### Indemnity Types

#### 1. Performance Bonuses (Incentivi Module)

**Description**: Variable compensation based on performance evaluation results.

**Calculation**:
```
Bonus = Base Amount × Performance Coefficient × Allocation Percentage

Where:
- Base Amount: Defined by administration budget
- Performance Coefficient: Based on evaluation score (e.g., 0.5-1.5)
- Allocation Percentage: Based on employment percentage and months worked
```

**Features**:
- Configurable calculation formulas
- Budget allocation management
- Individual bonus calculation
- Payment tracking
- PDF certificate generation
- Tax treatment support

**Workflow**:
```
1. Budget Definition (Finance)
   ↓
2. Allocation Criteria Setup (HR)
   ↓
3. Performance Data Import (from Performance module)
   ↓
4. Automatic Calculation
   ↓
5. Verification & Approval
   ↓
6. Payment Processing
   ↓
7. Documentation Generation
```

#### 2. Working Conditions Indemnity (IndennitaCondizioniLavoro Module)

**Description**: Compensation for challenging or hazardous working conditions.

**Indemnity Types**:
- Turnwork (shift work)
- Night work
- Hazardous conditions
- Physical effort
- Environmental discomfort

**Calculation**:
- Fixed monthly amounts
- Hourly-based calculations
- Percentage of base salary
- Cumulative rules

#### 3. Responsibility Indemnity (IndennitaResponsabilita Module)

**Description**: Additional compensation for managerial or supervisory roles.

**Indemnity Types**:
- Position responsibility
- Supervisory responsibility
- Project responsibility
- Budget responsibility

**Features**:
- Role-based assignment
- Tiered responsibility levels
- Automatic recalculation on role changes
- Historical tracking

### Payment Management

**Integration Points**:
- Payroll system export
- Accounting system integration
- ContoAnnuale reporting
- Tax documentation

---

## Career Progression

### Overview

Management of employee career development, promotions, and qualification advancements within the public administration framework.

### Progression Types (Progressioni Module)

#### 1. Economic Progression

**Description**: Salary level advancements based on seniority and performance.

**Requirements**:
- Minimum seniority in current level (typically 2-4 years)
- Sufficient performance evaluations
- No disciplinary sanctions
- Training credits (if required)

**Process**:
```
1. Eligibility Check (automatic)
   ↓
2. Application Submission (employee)
   ↓
3. Documentation Review (HR)
   ↓
4. Committee Evaluation
   ↓
5. Approval
   ↓
6. Economic Effect Application
```

#### 2. Qualification Progression

**Description**: Advancement to higher qualification levels through competitions or evaluations.

**Types**:
- Internal competition
- Public competition
- Professional evaluation

**Requirements**:
- Educational qualifications
- Minimum service years
- Specific competencies
- Training completion

#### 3. Seniority Tracking

**Features**:
- Automatic seniority calculation
- Career anniversary tracking
- Step increases
- Level progression timelines

### Job & Position Management (Job Module)

**Capabilities**:
- Job catalog definition
- Position requirements
- Career path mapping
- Competency frameworks
- Succession planning

### Skills & Badges (Badge Module)

**Features**:
- Skill inventory
- Competency assessment
- Badge/certification awards
- Skill gap analysis
- Training recommendations

---

## Compliance & Legal

### Overview

Comprehensive compliance management for Italian public administration regulations.

### GDPR Compliance (Gdpr Module)

**Capabilities**:
- **Consent Management**: Track and manage data processing consents
- **Privacy Policies**: Version-controlled policy management
- **Data Subject Rights**:
  - Access requests (Art. 15)
  - Rectification (Art. 16)
  - Erasure/Right to be forgotten (Art. 17)
  - Data portability (Art. 20)
- **Processing Records**: Article 30 documentation
- **Privacy Impact Assessments**: DPIA workflows
- **Data Breach Management**: Incident tracking and notification

**Data Categories**:
- Personal employee data
- Sensitive data (health, union membership)
- Performance evaluation data
- Biometric data (if applicable)

### Law 104/1992 (Legge104 Module)

**Description**: Support for employees with disabilities or caring for disabled family members.

**Features**:
- Disability certification tracking
- Permit management (3 days/month paid permits)
- Workplace accommodation tracking
- Reduced working hours
- Priority in transfers

**Integration**: Connects with PresenzeAssenze for permit tracking

### Law 109/1996 (Legge109 Module)

**Description**: Anti-mafia certification for public works contracts.

**Features**:
- Anti-mafia certificate tracking
- Contractor verification
- Public works compliance documentation
- Expiration alerts

### INAIL Compliance (Inail Module)

**Description**: Workplace injury reporting and occupational health management.

**Features**:
- Injury incident recording
- INAIL communication (online filing)
- Medical leave tracking
- Prevention program management
- Safety training records

**Integration**: Connects with PresenzeAssenze for injury-related absences

### Annual Financial Reporting (ContoAnnuale Module)

**Description**: Annual financial data collection and reporting for Ministry submission.

**Data Collected**:
- Personnel costs
- Indemnities and bonuses paid
- Headcount statistics
- Performance evaluation adoption
- Training investments

**Output**: XML/JSON format for Ministry submission

### Union Relations (Sindacati Module)

**Features**:
- RSU (Union Representation) tracking
- Union permit management
- Collective agreement tracking
- Union meeting scheduling
- Information and consultation procedures

### Fiscal Certifications (CertFisc Module)

**Features**:
- CU (Certificazione Unica) support data
- Tax withholding tracking
- Fiscal code validation
- Integration with accounting systems

---

## Italian Public Administration Context

### Organizational Structure

Italian public administrations follow a standardized organizational model:

```
┌─────────────────────────────────────────┐
│            Political Leadership          │
│         (Mayor/President/Assessors)     │
└──────────────────┬──────────────────────┘
                   │
┌──────────────────▼──────────────────────┐
│         General Director/Secretary       │
│              (Top Manager)               │
└──────────────────┬──────────────────────┘
                   │
    ┌──────────────┼──────────────┐
    │              │              │
┌───▼───┐    ┌────▼────┐   ┌────▼────┐
│Dept 1 │    │ Dept 2  │   │ Dept N  │
│       │    │         │   │         │
└───────┘    └─────────┘   └─────────┘
```

### Employment Categories

**Areas (Level Groups)**:
- **Area A**: Operational employees (executives)
- **Area B**: Administrative assistants
- **Area C**: Specialized technicians
- **Area D**: Managers and directors

**Employment Types**:
- **Tempo indeterminato**: Permanent employment
- **Tempo determinato**: Fixed-term contracts
- **Part-time**: Part-time arrangements
- **Apprendistato**: Apprenticeship contracts

### Collective Agreements (CCNL)

The system supports **CCNL Funzioni Locali** (National Collective Labor Agreement for Local Authorities):

- Salary tables and levels
- Progression rules
- Indemnity definitions
- Working time arrangements
- Disciplinary procedures

### Key Regulations

| Regulation | Area | Impact |
|------------|------|--------|
| **D.Lgs. 165/2001** | Public Employment | General framework |
| **D.Lgs. 150/2009** | Performance | Evaluation requirements |
| **D.Lgs. 75/2017** | Public Employment Reform | Madia reform |
| **D.Lgs. 81/2008** | Workplace Safety | Health & safety |
| **Law 241/1990** | Administrative Procedure | Transparency |
| **D.Lgs. 33/2013** | Transparency | Publication requirements |

---

## Key Business Processes

### Process 1: Annual Performance Evaluation Cycle

```
┌─────────────────────────────────────────────────────────────────┐
│ Timeline: January - December (Annual Cycle)                     │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│ January-February:                                                │
│   └─→ Define annual evaluation plan                             │
│   └─→ Set organizational goals                                  │
│                                                                  │
│ March:                                                           │
│   └─→ Cascade goals to employees                                │
│   └─→ Individual goal setting                                   │
│                                                                  │
│ June:                                                            │
│   └─→ Mid-year review (optional)                                │
│   └─→ Goal adjustment (if needed)                               │
│                                                                  │
│ December:                                                        │
│   └─→ Self-evaluation phase                                     │
│   └─→ Manager evaluation                                        │
│                                                                  │
│ January (following year):                                        │
│   └─→ Evaluation committee review                               │
│   └─→ Final approval                                            │
│   └─→ Publication                                               │
│   └─→ Appeal period (15 days)                                   │
│                                                                  │
│ February:                                                        │
│   └─→ Bonus calculation                                         │
│   └─→ Payment processing                                        │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### Process 2: Indemnity Calculation and Payment

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                  │
│ 1. Budget Definition                                             │
│    └─→ Finance defines total budget                             │
│    └─→ Allocation criteria established                          │
│                                                                  │
│ 2. Data Collection                                               │
│    └─→ Import performance scores                                │
│    └─→ Verify employment data                                   │
│    └─→ Check eligibility                                        │
│                                                                  │
│ 3. Calculation                                                   │
│    └─→ Apply formula per employee                               │
│    └─→ Validate calculations                                    │
│    └─→ Generate preview                                         │
│                                                                  │
│ 4. Approval                                                      │
│    └─→ HR verification                                          │
│    └─→ Management approval                                      │
│    └─→ Union consultation (if required)                         │
│                                                                  │
│ 5. Payment                                                       │
│    └─→ Export to payroll                                        │
│    └─→ Process payment                                          │
│    └─→ Generate certificates                                    │
│                                                                  │
│ 6. Reporting                                                     │
│    └─→ Individual notifications                                 │
│    └─→ Aggregate reports                                        │
│    └─→ Archive documentation                                    │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### Process 3: Career Progression

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                  │
│ 1. Eligibility Detection                                         │
│    └─→ System identifies eligible employees                     │
│    └─→ Notification sent to employees                           │
│                                                                  │
│ 2. Application                                                   │
│    └─→ Employee submits application                             │
│    └─→ Uploads required documentation                           │
│                                                                  │
│ 3. Verification                                                  │
│    └─→ HR verifies requirements                                 │
│    └─→ Checks performance history                               │
│    └─→ Validates training credits                               │
│                                                                  │
│ 4. Evaluation                                                    │
│    └─→ Committee reviews applications                           │
│    └─→ Scores applications                                      │
│    └─→ Creates ranking                                          │
│                                                                  │
│ 5. Approval                                                      │
│    └─→ Management approves ranking                              │
│    └─→ Publication of results                                   │
│                                                                  │
│ 6. Implementation                                                │
│    └─→ Economic effect application                              │
│    └─→ Contract update                                          │
│    └─→ Notification to employee                                 │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

### Process 4: Absence Management

```
┌─────────────────────────────────────────────────────────────────┐
│                                                                  │
│ Request Phase:                                                   │
│   Employee → Submit absence request                              │
│          → Specify type (vacation, permit, sick)                │
│          → Attach documentation (if required)                   │
│                                                                  │
│ Approval Phase:                                                  │
│   Manager → Review request                                       │
│          → Check coverage                                        │
│          → Approve/Reject                                        │
│                                                                  │
│ Tracking Phase:                                                  │
│   System → Record absence                                        │
│          → Update balance                                        │
│          → Notify payroll                                        │
│                                                                  │
│ Integration:                                                     │
│   → Biometric system sync (if applicable)                       │
│   → Law 104 permit tracking                                     │
│   → Union permit tracking                                       │
│   → Sick leave medical verification                             │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## Domain Terminology

### Italian HR Terms

| Term | English | Definition |
|------|---------|------------|
| **Amministrazione Pubblica** | Public Administration | Government entity at local/regional/national level |
| **Dipendente** | Employee | Public administration employee |
| **Dirigente** | Manager | Executive/management level employee |
| **CCNL** | National Collective Labor Agreement | Industry-wide labor agreement |
| **Ferie** | Vacation | Annual paid leave |
| **Permessi** | Permits | Paid time off for specific reasons |
| **Malattia** | Sick Leave | Medical leave |
| **Maternità/Paternità** | Maternity/Paternity | Parental leave |
| **Legge 104** | Law 104 | Disability support legislation |
| **RSU** | Union Representation | Workplace union representatives |
| **Banca Ore** | Time Bank | Overtime hours stored for future use |
| **PTV** | Variable Time Personnel | Flexible working time system |
| **Progressione Economica** | Economic Progression | Salary level advancement |
| **Progressione di Qualifica** | Qualification Progression | Career level advancement |
| **Valutazione Performance** | Performance Evaluation | Annual performance review |
| **Indennità** | Indemnity | Additional compensation |
| **Premio** | Bonus | Performance-based incentive |
| **Conto Annuale** | Annual Account | Mandatory annual financial report |
| **Certificazione Unica (CU)** | Single Certification | Annual tax certification |

### Technical Terms

| Term | Definition |
|------|------------|
| **Tenant** | Isolated public administration instance |
| **KPI** | Key Performance Indicator |
| **360° Feedback** | Multi-rater evaluation method |
| **Competency Framework** | Structured list of required skills |
| **Evaluation Committee** | Group responsible for validating evaluations |
| **Budget Allocation** | Distribution of bonus budget |
| **Performance Coefficient** | Multiplier based on evaluation score |

---

## Domain Events

### Key Business Events

| Event | Trigger | Handlers |
|-------|---------|----------|
| **PerformanceEvaluationCreated** | New evaluation created | Notify employee, Calculate bonus eligibility |
| **PerformanceEvaluationApproved** | Evaluation approved by committee | Publish results, Start appeal period |
| **BonusCalculated** | Bonus calculation completed | Notify employee, Export to payroll |
| **CareerProgressionApproved** | Progression approved | Update salary, Notify employee |
| **AbsenceRequested** | Employee requests absence | Notify manager, Check balance |
| **AbsenceApproved** | Manager approves absence | Update calendar, Notify payroll |
| **InjuryReported** | Workplace injury recorded | INAIL notification, Safety review |

---

## Related Documentation

- [Architecture Overview](./ARCHITECTURE.md)
- [Technology Stack](./STACK.md)
- [Module Catalog](./MODULES.md)
- [Performance Module Documentation](../../laravel/Modules/Performance/docs/)
- [Incentivi Module Documentation](../../laravel/Modules/Incentivi/docs/)

---

*Last Updated: 2026-03-18*
