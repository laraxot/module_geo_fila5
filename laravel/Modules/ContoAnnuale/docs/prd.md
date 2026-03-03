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

## 5. Functional Requirements (Prioritized)

### P0: Regulatory Reporting (Must-have)
- **FR-001: Data Aggregation Engine**: Aggregate personnel cost and head-count data for the entire fiscal year.
- **FR-002: Mandatory Table Generation**: Automated population of standardized national tables (T1, T2, etc.) for PA reporting.
- **FR-004: Compliant Exports**: Export finalized reports in mandated PDF/Excel formats with precise traceability.

### P1: Data Integrity (Important)
- **FR-003: Validation Checks**: Cross-table consistency verification to identify and flag accounting discrepancies.
- **FR-005: Multi-Subsystem Sync**: Integration with payroll (Sigma) and attendance modules for raw data collection.

### P2: Advanced Analysis (Nice-to-have)
- **FR-006: Trend Analysis**: Year-over-year cost comparison and dashboard visualization.
- **FR-007: Proactive Budgeting**: Forecasting personnel costs based on current Conto Annuale data.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Report-Centric Design**: ContoAnnuale MUST remain a reporting module; it does not contain the logic for payroll calculation.
- **Interoperability**: Consumes standardized data from Sigma and Attendance through Xot-mediated interfaces.
- **Agnostic Logic**: Reporting rules are abstracted from specific organizational entities.

### Performance & Safety
- **NFR-001: Accuracy**: 100% calculation accuracy with complete traceability back to source records.
- **NFR-002: Performance**: Support processing of thousands of records for a full year without timeouts.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
