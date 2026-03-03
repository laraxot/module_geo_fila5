# PRD - ContoAnnuale Module

## 1. Executive Summary
The ContoAnnuale module handles the annual reporting and financial summary for users and the organization, focusing on budget tracking and yearly analysis.

## 2. Target Personas
- **Finance Managers:** Generate and review annual financial reports.
- **Budget Owners:** Monitor yearly budget allocation and spending.
- **Employees:** Access individual yearly financial summaries.

## 3. Functional Requirements
- Aggregate monthly financial data into annual reports.
- Track budget performance against initial targets.
- Export financial data in standard formats (CSV, PDF).
- Provide visual dashboards for yearly trends.

## 4. Service Interface (The Contract)
- **API Endpoints:**
  - `GET /api/conto-annuale/report/{year}`: Generate the yearly report.
  - `GET /api/conto-annuale/summary`: Retrieve a summary for the current year.
- **Events:**
  - `ContoAnnualeFinalized`: Triggered when an annual report is locked.

## 5. System Architecture & Dependencies
- **Data Ownership:** Owns annual financial records and report metadata.
- **Downstream Dependencies:** Depends on financial modules like `Ptv` and `Incentivi`.

## 6. Non-Functional Requirements
- **Performance:** Efficient aggregation of large datasets for reporting.
- **SLA:** Reliable report generation for audit purposes.

## 7. Release Criteria
- PHPStan Level 10 compliance.
- Accurate financial calculations verified through integration tests.
