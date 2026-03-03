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

## 5. Functional Requirements (Prioritized)

### P0: Fiscal Compliance (Must-have)
- **FR-001: Batch PDF Generation**: Simultaneous generation of thousands of fiscal certificates from source data using worker queues.
- **FR-002: Secure Document Delivery**: Authenticated download system for employees to retrieve their certificates.
- **FR-003: Multi-Year Archiving**: Secure storage and indexing of certifications across different fiscal years.

### P1: Process Automation (Important)
- **FR-004: Delivery Tracking**: Audit trail showing when a certificate was generated, emailed, and downloaded.
- **FR-006: Versioned Templates**: Support for annual changes in fiscal form formats mandated by tax authorities.

### P2: Digital Transformation (Nice-to-have)
- **FR-005: Digital Signature**: Integrated support for legally binding digital signatures on generated documents.
- **FR-007: AI Data Validation**: Automated anomaly detection in source data before document generation.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Data Sourcing**: CertFisc MUST consume standardized data structures; it does not directly query legacy payroll databases.
- **Interoperability**: Uses the `Xot` module's `GeneratePdfAction` and `Notify` module for delivery.
- **Independent Life-cycle**: Documents are stored as static PDF assets, ensuring readability even if the underlying source data changes.

### Performance & Safety
- **NFR-001: Confidentiality**: Strict encryption of fiscal documents at rest and in transit.
- **NFR-002: Scalability**: Capability to handle peak loads (5000+ PDFs/hour) during fiscal season.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

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
