# Statistiche - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Statistiche Module Team

## 1. Purpose & Vision
The Statistiche module provides a **centralized Business Intelligence and analytical engine** for the Laraxot ecosystem. It aggregates data from various modules (HR, Performance, Attendance, Finance) to generate insightful dashboards, charts, and reports, enabling data-driven decision making for management.

## 2. Problem Statement
The organization needs:
- To see high-level trends across various departments and time periods.
- To compare data from different years or organizational units.
- To provide visual dashboards to executives that are easy to interpret.
- To generate complex data exports for external audit and planning purposes.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Executive** | Decision Maker | High-level KPIs, visual trends, comparative analysis. |
| **HR Analyst** | Data Researcher | Detailed reports on turnover, performance distribution, training impact. |
| **System Admin** | Resource Manager | Monitor system usage and data growth statistics. |

## 4. Scope
### In Scope
- Centralized Dashboard system within Filament.
- Library of reusable Widgets (Count, Trend, Chart, Table).
- Data aggregation engine for cross-module reporting.
- Support for various chart types (Bar, Line, Pie, Radar).
- Export of analytical data to Excel/PDF.
- Saved Reports and Scheduled reporting (via Job module).

### Out of Scope
- Detailed real-time log analysis (delegated to monitoring tools like Graylog/ELK).
- External BI integration (e.g., PowerBI) - though API support is planned.

## 5. Functional Requirements
### FR-001: Dashboard Builder
- **Priority**: Must-have
- **Description**: Assemble multiple widgets into a unified view for a specific persona.
- **Acceptance Criteria**: Dashboards can be filtered by Date, Unit, or Tenant.

### FR-002: Modular Widgets
- **Priority**: Must-have
- **Description**: Reusable components that fetch specific data (e.g., "Active Employee Count").
- **Acceptance Criteria**: Widgets are easy to drop into any Filament page.

### FR-003: Historical Comparison
- **Priority**: Should-have
- **Description**: compare current data vs same period last year.
- **Acceptance Criteria**: Charts support multiple datasets for time-series comparison.

### FR-004: Automated Exports
- **Priority**: Should-have
- **Description**: Schedule an Excel report to be sent to a specific user monthly.
- **Acceptance Criteria**: Integration with `Job` and `Notify` modules.

## 6. Non-Functional Requirements
- **NFR-001: Accuracy**: Aggregate numbers must be validated against the source material.
- **NFR-002: Performance**: Use of pre-aggregated "Snapshot" tables or optimized caching for heavy reports.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **Job**: For heavy analytics processing.
- **UI**: For chart components.
### Data Model
- SavedReports, DashboardConfigs, AnalyticalSnapshots.
### Integration Points
- Consumes data from `User`, `Performance`, `PresenzeAssenze`, and `Sigma`.

## 8. User Experience
- Interactive charts with drill-down capability (click to see detail).
- Clean, board-room ready visual design.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Dashboard Load Time | < 2s | Average load time in browser. |
| Decision Support Score | > 4/5 | User feedback on report utility. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Data across modules is clean and accurately structured.
- Users have basic literacy in interpreting data charts.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Performance bottleneck | High | Use of background workers to populate snapshot tables. |
| Misleading visualization | Medium | Strict rules on chart scales and legends. |

## 11. Dependencies & Constraints
- Must respect data access permissions (Role-based analytics).

## 12. Release Plan
### Phase 1: Base Widgets (Stable)
- Unified chart library and basic HR widgets. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced BI (Planned)
- Fully dynamic dashboard builder.
- Predictive modeling for turnover and costs.

## 13. References
- [roadmap.md](roadmap.md)
