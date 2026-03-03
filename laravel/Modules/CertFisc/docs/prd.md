# CertFisc - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: CertFisc Module Team

## 1. Purpose & Vision
The CertFisc module manages **fiscal certifications and tax compliance documents** for the PTVX platform. It automates the generation, storage, and delivery of fiscal documents (e.g., in Italy, Certificazione Unica - CU) to employees and contractors, ensuring legal compliance with national tax authorities.

## 2. Problem Statement
The HR department needs to:
- Generate large volumes of fiscal documents accurately and timely.
- Provide a secure and easy way for employees to download their certifications.
- Track document delivery status for legal proof.
- Handle different versions of fiscal forms updated annually by tax authorities.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Payroll Manager** | Fiscal Admin | Batch generate certifications, verify data against payroll, monitor distributions. |
| **Employee** | Data Recipient | View and download annual fiscal certifications for tax filing. |
| **Auditor** | System Validator | Verify that every eligible employee received the correct document. |

## 4. Scope
### In Scope
- Multi-year fiscal certification storage and index.
- Integration with external payroll data for document population.
- Secure PDF generation and storage of certificates.
- Email notification of available documents.
- User-facing download center in the personal profile.

### Out of Scope
- Detailed tax calculation (delegated to Payroll/Sigma system).
- E-filing directly to the Tax Bureau (delegated to specialized fiscal software).

## 5. Functional Requirements
### FR-001: Batch Generation
- **Priority**: Must-have
- **Description**: Generate hundreds of PDFs simultaneously from source data.
- **Acceptance Criteria**: Uses `GeneratePdfAction` via worker queues.

### FR-002: Secure Delivery
- **Priority**: Must-have
- **Description**: Notify users and provide a secure, authenticated link for download.
- **Acceptance Criteria**: Links are for authenticated users only, logged at download.

### FR-003: Versioning Support
- **Priority**: Should-have
- **Description**: Handle different certificate formats for different fiscal years.
- **Acceptance Criteria**: Documents are categorized and archived by year.

### FR-004: Delivery Status
- **Priority**: Should-have
- **Description**: Track whether a certificate was generated, emailed, and downloaded.
- **Acceptance Criteria**: Admin panel shows "Download status" for each document.

## 6. Non-Functional Requirements
- **NFR-001: Confidentiality**: Strict access control on fiscal files.
- **NFR-002: Scalability**: Handle high load during the fiscal season (Feb-Mar).
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Core framework (`GeneratePdfAction`).
- **User**: Recipient identification.
- **Notify**: Delivery notifications.
- **Media**: Secure file storage.
### Integration Points
- Receives source data from legacy systems (Sigma) to populate documents.

## 8. User Experience
- Simple "My Certifications" section in the User profile.
- One-click PDF download.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Distribution Success | 100% | Check if all eligible users have a certificate. |
| Document Integrity | 100% | MD5 checksum comparison. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Source payroll data is correct and finalized before generation.
- Users have valid email addresses.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Data mismatch in PDF | Critical | Sampling and batch validation before release. |
| System timeout on large batch | Medium | Use background jobs exclusively for generation. |

## 11. Dependencies & Constraints
- Adheres to annual templates provided by the Revenue Agency (AE).
- Multi-tenancy isolation.

## 12. Release Plan
### Phase 1: Stability (Stable)
- Basic document management and download. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Automation (Planned)
- Fully automated sync with payroll data.
- Integrated digital signature support.

## 13. References
- [roadmap.md](roadmap.md)
