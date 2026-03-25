# PRD - Incentivi Module (2025-2026 Lean Standard)

## 1. Executive Summary
The Incentivi module manages employee incentives, bonuses, and performance-based rewards across the PTVX platform. It aims to automate complex calculations, reduce manual errors, and streamline the approval and payout process for provincial incentives.

## 2. Problem Statement
Manual calculation of employee incentives is prone to errors, time-consuming, and lacks transparency. Different sectors have varied incentive schemes and calculation rules, making a unified manual approach unsustainable. There is a need for a centralized, automated system that handles diverse projects, workgroups, and activities while ensuring financial accuracy and proper authorization.

## 3. KPIs
- **Accuracy:** 100% accuracy in automated incentive calculations compared to manual audits.
- **Efficiency:** 70% reduction in time spent by HR and Finance teams on incentive processing.
- **User Satisfaction:** Positive feedback from employees regarding transparency of their earned rewards.
- **Compliance:** 100% adherence to provincial regulations and internal policies.

## 4. Target Personas
- **Employees:** View and track their earned incentives and bonuses.
- **HR Managers:** Define, calculate, and manage incentive schemes.
- **Finance Team:** Review and approve incentive payouts.
- **Department Managers (RUP/DEC):** Manage projects and assign personnel to activities.

## 5. Functional Requirements

### P0: Critical (Must have)
- **Project Management:** Create and manage incentive-based projects with specific metadata (CIG, CUP, funding source).
- **Personnel Mapping:** Assign employees to projects and specific activities.
- **Automated Calculation:** Calculate incentives based on predefined percentages and actual performance data.
- **Authorization Workflow:** Implement multi-level approval (Policy-based) for projects and payouts.
- **Settlement Management:** Track and manage the liquidation of incentives.

### P1: Important (Should have)
- **Phase Management:** Support for multi-phase projects with distinct incentive pools.
- **Document Generation:** Export project summaries and settlement reports for official use.
- **Audit Logging:** Track all changes to incentive calculations and project states.

### P2: Enhancement (Nice to have)
- **Dashboard Visualizations:** Real-time charts showing incentive distribution and project progress.
- **Integration with Performance:** Automatically pull KPIs from the Performance module to drive incentive calculations.

## 6. Service Interface (The Contract)
- **Actions:**
  - `SpareImportoTotaleAction`: Distributes total project funds across activities.
  - `UpdateActivitiesEmployeesAction`: Syncs employees and their calculated shares for activities.
  - `UpdateProjectActivitiesAction`: Manages the lifecycle of activities within a project.
- **Events:**
  - `IncentiveCalculated`: Triggered when an incentive calculation completes.
  - `ProjectStatusChanged`: Triggered when a project moves through its lifecycle (Draft -> Approved -> Liquidated).

## 7. System Architecture & Dependencies
- **Data Ownership:** Owns incentive schemes, project metadata, and payout records.
- **Dependencies:** 
  - `User`: For employee profiles and roles.
  - `Ptv`: For organizational structure (Departments/Teams).
  - `Performance`: (Planned) For performance-driven incentive rules.

## 8. Non-Functional Requirements
- **Security:** Strict authorization via `XotBase` policies. High-level encryption for sensitive financial data.
- **Observability:** Comprehensive logging of calculation steps for auditing.
- **Scalability:** Handle thousands of concurrent incentive calculations without performance degradation.

## 9. Release Criteria
- **PHPStan:** Level 10 compliance for all module classes.
- **Testing:** 100% pass rate for Pest unit and integration tests.
- **Documentation:** Complete `docs/` folder with updated PRD, Architecture, and Model/Action details.
# PRD: Incentivi Module

## 📋 Overview
- **Author:** Gemini CLI
- **Status:** Draft
- **Target Release:** 1.0.0

## ❓ Problem Statement
Specialized logic for Incentivi needs a dedicated, type-safe Module to ensure maintainability.

## 🎯 Goals & Success Metrics
- **Goal 1:** 100% PHPStan L10 compliance.
- **Goal 2:** Seamless integration with XotBase.
