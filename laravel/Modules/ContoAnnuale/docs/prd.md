# ContoAnnuale - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: ContoAnnuale Module Team

## 1. Purpose & Vision
The ContoAnnuale module provides a comprehensive **annual HR accounting and reporting system** for the PTVX platform, specifically designed for the Italian Public Administration requirements. It automates the collection, calculation, and reporting of personnel costs and statistics for the annual budget statement.

## 2. Problem Statement
The HR and Accounting departments need to:
- Aggregate complex data from payroll, attendance, and positions.
- Perform standardized calculations according to national reporting rules.
- Generate mandatory annual reports for regulatory bodies.
- Verify data consistency across various HR subsystems.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Accountant** | HR Controller | Aggregate costs, verify budget adherence. |
| **HR Director** | Reporting Manager | Generate annual reports for the Treasury. |
| **Auditor** | System Validator | Verify calculated data against source payroll. |

## 4. Scope
### In Scope
- Annual cost aggregation and categorization.
- Standardized templates for national report tables.
- Integration with Sigma/Payroll for raw data collection.
- Validation rules for accounting consistency.
- Filament resources for data review and report generation.

### Out of Scope
- Direct payroll processing (delegated to Sigma/Payroll).
- Financial accounting (delegated to specialized finance software).

## 5. Functional Requirements
### FR-001: Data Aggregation
- **Priority**: Must-have
- **Description**: Pull data from payroll and attendance modules for the whole fiscal year.
- **Acceptance Criteria**: Data is correctly grouped by cost category and personnel role.

### FR-002: Table Generation
- **Priority**: Must-have
- **Description**: Populate standardized reporting tables (T1, T2, etc. as defined by national rules).
- **Acceptance Criteria**: Values match payroll totals exactly.

### FR-003: Validation Checks
- **Priority**: Should-have
- **Description**: Automated consistency checks across different reporting tables.
- **Acceptance Criteria**: System flags discrepancies for administrator review.

### FR-004: PDF/Excel Export
- **Priority**: Must-have
- **Description**: Export finalized reports in mandated formats.
- **Acceptance Criteria**: Professional and compliant document output.

## 6. Non-Functional Requirements
- **NFR-001: Accuracy**: Calculation must be error-free with complete traceability.
- **NFR-002: Performance**: Support processing of thousands of records for a full year.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Core infrastructure.
- **Sigma**: Source payroll data.
- **Rating**: (If active) for performance-based costs.
### Data Model
- Specialized models for each reporting table and yearly aggregation.

## 8. User Experience
- Dedicated dashboard for the "Conto Annuale" cycle.
- Progress tracking for each section of the report.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Report Consistency | > 99.9% | Automated checks result. |
| Time to Report | < 3 days | Cycle duration from start to final export. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Source payroll data (Sigma) is final and correct.
- National reporting rules are stable or updated templates are available.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data drift from source DB | High | Snapshot mechanism and incremental sync. |
| Regulatory template changes | Medium | Modular template system for easy updates. |

## 11. Dependencies & Constraints
- Must comply with Circulars from "Ragioneria Generale dello Stato" (RGS).

## 12. Release Plan
### Phase 1: Stabilization (Planned)
- Core models and basic aggregation.
- PHPStan Level 10 compliance.
### Phase 2: Full Reporting (Future)
- Implementation of all mandatory tables.
- Automated validation engine.

## 13. References
- [roadmap.md](roadmap.md)
