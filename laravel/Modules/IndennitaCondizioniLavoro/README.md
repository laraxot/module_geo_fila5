# Working Conditions Allowance Module (Indennità Condizioni Lavoro)

## Business Purpose
The IndennitaCondizioniLavoro module manages special allowances and compensations for employees working in difficult or hazardous conditions. It handles the calculation and distribution of additional payments based on specific working condition types and exposure periods.

## Key Features

### Working Conditions Tracking
- Period-based tracking (quarterly/four-month periods)
- Attendance and presence monitoring during allowance periods
- Integration with time tracking systems (timbr)
- Absence impact calculations on allowance eligibility

### Allowance Types Management
- Multiple allowance categories (IndennitaTipo)
- Detailed allowance specifications (IndennitaTipoDettaglio)
- Daily rate calculations (euro_giorno)
- Validity period management (dal/al dates)
- SVOCFI code integration for accounting

### Calculation Engine
- Days-based calculations with pivot tables
- Automatic total calculation based on daily rates × days
- Part-time employee adjustments
- Presence period validation and controls

### Administrative Workflow
- Evaluator assignment and approval process
- Form compilation for allowance claims
- File upload system for supporting documentation
- Multi-step validation process

## Core Models

### CondizioniLavoro
Main model tracking employee allowance records including:
- Employee identification (ente, matr, cognome, nome)
- Position and department details (stabi, repar, propro, posfun)
- Time period specification (anno, quadrimestre, dal, al)
- Attendance tracking (gg_presenza_periodo, gg_assenza_anno)
- Total calculations (tot, tot_presenza_periodo_plus_no_timbr)
- Evaluator assignment (valutatore_id)

### IndennitaTipo
Allowance type definitions with:
- Category name and description
- SVOCFI accounting codes
- Administrative classification

### IndennitaTipoDettaglio
Detailed allowance specifications including:
- Specific allowance descriptions
- Daily rate amounts (euro_giorno)
- Validity periods (dal/al)
- Relationship to main allowance types

### Upload
Document management for:
- PDF file uploads per employee
- Period-specific documentation (quadrimestre, anno)
- User-specific file organization
- Notes and metadata tracking

## Filament Integration
- Form compilation interface (CompilaCondizioniLavoro page)
- Resource management for all allowance types
- File upload and document management
- Relationship management between employees and allowances
- Validation rules for days vs. presence periods

## Business Logic Highlights
- **Pivot Relationship**: CondizioniLavoro ↔ IndennitaTipoDettaglio with days tracking
- **Automatic Calculations**: Total = Σ(daily_rate × days) for each allowance type
- **Validation Logic**: Days cannot exceed total presence period plus untimed days
- **Part-time Adjustments**: Calculations consider part-time percentages
- **Quarterly Periods**: For 2023+ uses automatic 4-month period calculations
- **Integration**: Links with Sigma HR system for employee and position data

This module ensures accurate compensation for employees working in challenging conditions while maintaining proper administrative controls and audit trails.