# Pdnd - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Pdnd Module Team

## 1. Purpose & Vision
The Pdnd module manages the **integration with the Piattaforma Digitale Nazionale Dati (PDND)**, the Italian national data interoperability platform. It enables the PTVX platform to securely consume and provide APIs as per the national standards (e-governance), facilitating seamless communication with other public administrations (e.g., ANPR, INPS).

## 2. Problem Statement
The PTVX system must:
- Exchange data with other Italian Public Administrations securely.
- Adhere to the strict security standards of the PDND (JWT, JWS, PKI).
- Consume services from national bases like ANPR (National Population Register).
- Manage API keys, certificates, and vouchers required for PDND interoperability.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | System Integrator | Simple PHP interface to call PDND-wrapped APIs. |
| **System Admin** | Security Manager | Manage certificates, monitor API usage, track vouchers. |
| **Policy Maker** | Compliance Officer | Ensure that data exchange follows national guidelines. |

## 4. Scope
### In Scope
- PDND security handshake (Voucher request, JWT signing).
- Integration with ANPR (Registry data verification).
- Client and e-service management for PDND interaction.
- Secure storage of certificates and private keys.
- Logging of all interoperability transactions for audit.

### Out of Scope
- Direct user interface for public citizens.
- Non-PDND specialized integrations.

## 5. Functional Requirements (Prioritized)

### P0: National Interoperability (Must-have)
- **FR-001: PDND Security Handshake**: Automate JWT/JWS signing and voucher retrieval using local PKI certificates.
- **FR-002: ANPR Service Integration**: Securely verify and fetch official registry data from the National Population Register.
- **FR-003: PKI Certificate Lifecycle**: Secure management, rotation, and usage of PDND-specific certificates.

### P1: Compliance & Governance (Important)
- **FR-004: Transaction Audit Log**: Searchable history of every national interoperability request and response for legal compliance.
- **FR-005: E-Service Registry**: Management of active national services and their respective access vouchers.

### P2: Advanced Digital Citizen (Nice-to-have)
- **FR-006: Automated Data Reconciliation**: Proactive detection of discrepancies between local employee data and ANPR records.
- **FR-007: AI Identity Matching**: Enhanced matching algorithms for complex or incomplete national registry queries.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic Proxy**: Pdnd acts as a technical proxy for national data; it MUST NOT contain domain-specific logic.
- **Interoperability**: Provides standardized Service objects for other modules (e.g., User) to consume national APIs without knowing the PDND internals.
- **Independence**: The interoperability layer is abstracted from the specific PA e-service being consumed.

### Performance & Safety
- **NFR-001: Security**: 100% encryption of private keys; no plain-text storage of sensitive PKI material.
- **NFR-002: Reliability**: Asynchronous execution of national interoperability calls to prevent UI blocking during external downtime.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **Setting**: For connection parameters.
- **User**: (Optional) for verifying personal data against ANPR.
### Data Model
- Clients, Services, Vouchers, Logs.
### Integration Points
- Consumed by `User` module for official registry checks during onboarding.

## 8. User Experience
- Admin interface to check connection status and valid certificates.
- Developer-friendly Service objects for calling external PA APIs.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Voucher Success Rate | > 99% | Logs of PDND handshakes. |
| ANPR Match Rate | > 95% | Found vs queried records. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Valid PDND certificates are provided by the organization.
- External national services (PDND platform) are available.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Certificate expiration | High | Proactive alerts for expiration dates. |
| PDND API breaking changes | Medium | Abstracted API layer for quick version updates. |

## 11. Dependencies & Constraints
- Must comply with AgID (Agenzie per l'Italia Digitale) interoperability guidelines.

## 12. Release Plan
### Phase 1: Core PDND Implementation (Stable)
- Voucher retrieval and certificate signing. ✅
- Basic ANPR data fetching. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced e-Services (Planned)
- Integration with other base registries (e.g., INPS, Chamber of Commerce).
- Automated drift detection between local and national data.

## 13. References
- [roadmap.md](roadmap.md)
