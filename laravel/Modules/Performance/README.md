# Performance Management Module

## Business Purpose
The Performance module manages employee performance evaluation and bonus calculation for public administration entities. It handles individual and organizational performance tracking, scoring, and monetary rewards distribution.

## Key Features

### Employee Performance Evaluation
- Individual performance assessments with weighted criteria:
  - Experience acquired (`esperienza_acquisita`)
  - Results obtained (`risultati_ottenuti`)
  - Professional enrichment (`arricchimento_professionale`)
  - Commitment (`impegno`)
  - Quality of performance (`qualita_prestazione`)
- Weighted scoring system with configurable weights per criterion
- Excellence tracking and multi-year performance analysis

### Financial Management
- Performance budget allocation and distribution
- Individual and organizational bonus calculations
- Part-time employee adjustments and prorated calculations
- Absence impact assessment and deductions
- Category-based coefficient calculations

### Administrative Structure
- Entity/organization hierarchy management (`ente`, `stabi`, `repar`)
- Position and function tracking (`posiz`, `posfun`, `propro`)
- Economic category classification (`categoria_eco`)
- Evaluator assignment and management (`valutatore_id`)

### Time Tracking & Attendance
- Annual and period-specific attendance tracking
- Absence calculation and impact on performance bonuses
- Part-time work percentage calculations
- Temporary contract handling (`gg_tempo_determinato`)

## Core Models

### Performance
Main model tracking individual employee performance data including:
- Personal information (matr, cognome, nome, email)
- Position details (stabi, repar, posiz, posfun, categoria_eco)
- Performance scores and weights for each evaluation criterion
- Attendance data (presence/absence days, hours)
- Financial calculations (quotas, budget, bonuses)
- Evaluator assignment and approval workflow

### Supporting Models
- **Individuale**: Individual performance bonus calculations
- **Organizzativa**: Organizational performance tracking
- **CriteriEsclusione**: Exclusion criteria management
- **CriteriMaggiorazione**: Bonus increment criteria
- **CriteriValutazione**: Evaluation criteria definitions
- **PerformanceFondo**: Performance fund management
- **MyLog**: Mail tracking and notifications

## Filament Integration
- Resource-based CRUD interfaces for all models
- Custom actions for money distribution and calculations
- Bulk operations for performance data management
- PDF generation for performance reports
- Mail notification system for evaluation workflows

## Business Logic Highlights
- Complex multi-criteria scoring with weighted averages
- Automatic budget distribution based on performance scores
- Integration with external HR systems (Sigma models)
- Hierarchical approval workflows
- Multi-year performance trend analysis
- Exception handling for special cases and exclusions

This module is critical for fair and transparent performance-based compensation in public administration environments.