# PRD - MobilitaVolontaria Module

## 1. Executive Summary
The MobilitaVolontaria module manages the voluntary mobility of employees within the organization, including job internal applications and transfers.

## 2. Target Personas
- **Employees:** Apply for internal positions and transfers.
- **HR Managers:** Review and manage voluntary mobility applications.
- **Department Heads:** Identify and evaluate candidates for internal roles.

## 3. Functional Requirements
- List and manage internal job postings and mobility opportunities.
- Secure application process for employees.
- Workflow for reviewing and approving mobility requests.
- Track and report on mobility trends and outcomes.

## 4. Service Interface (The Contract)
- **API Endpoints:**
  - `GET /api/mobilita-vol/postings`: List available internal job postings.
  - `POST /api/mobilita-vol/apply`: Submit an application for mobility.
- **Events:**
  - `MobilityApplicationSubmitted`: Dispatched for any new mobility application.

## 5. System Architecture & Dependencies
- **Data Ownership:** Owns mobility postings and application records.
- **Downstream Dependencies:** Depends on `User` and `Xot` modules.

## 6. Non-Functional Requirements
- **Security:** Strict privacy and access control for application data.
- **Reliability:** Reliable processing of mobility applications and status updates.

## 7. Release Criteria
- PHPStan Level 10 compliance.
- Streamlined mobility workflow verified through end-to-end tests.
