# Mensa - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Mensa Module Team

## 1. Purpose & Vision
The Mensa module manages **corporate catering and canteen services** for the PTVX platform. It tracks employee meal attendance, meal vouchers, contribution towards costs, and coordinates with cooking centers, ensuring efficient management of company benefit lunch systems.

## 2. Problem Statement
The organization needs to:
- Track daily meal consumption per employee accurately.
- Manage individual meal vouchers and cash contributions.
- Coordinate orders and consumption data with internal/external catering providers.
- Integrate canteen data with payroll for meal-related deductions or benefits.
- Monitor canteen usage statistics for cost optimization.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Canteen Manager** | Catering Admin | Monitor daily meals, track stock, coordinate with providers. |
| **HR Administrator** | Payroll Manager | Calculate monthly meal deductions or voucher entitlements. |
| **Employee** | End User | Book meals (if required), see consumption history, view voucher balance. |

## 4. Scope
### In Scope
- Meal consumption/attendance tracking (timbrature mensa).
- Meal voucher (buoni pasto) registry and entitlement management.
- Canteen cash contribution/cost-sharing tracking.
- Registry of cooking centers (centri cottura) and service providers.
- Integration with payroll for meal-related accounting.
- Filament resources for admin and operational management.

### Out of Scope
- Detailed kitchen inventory (delegated to specialized catering software).
- Direct POS/payment terminal communication (delegated to specialized middleware).

## 5. Functional Requirements (Prioritized)

### P0: Meal Tracking & Entitlement (Must-have)
- **FR-001: Meal Registration**: Capture daily meal consumption events via badge-based or app-based identification.
- **FR-002: Voucher Management (Buoni Pasto)**: Automated entitlement tracking based on worked hours and session duration.
- **FR-005: Consumption History**: Immutable record of all meal events for employee and administrator review.

### P1: Operational Billing (Important)
- **FR-003: Cost Contribution Tracking**: Manage the cost-sharing split between employee and company for payroll deductions.
- **FR-006: Provider Coordination**: Dashboard for managing cooking centers and service provider performance.

### P2: Advanced Catering (Nice-to-have)
- **FR-004: Meal Booking**: Advance booking system for specialized meals or events.
- **FR-007: AI Nutritional Feedback**: Optional nutritional analysis of consumed meals based on provider menus.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Terminal Agnosticism**: Mensa MUST remain independent of specific canteen terminal hardware vendors.
- **Interoperability**: Consumes attendance data from `PresenzeAssenze` and identification from `Badge`; results are consumed by `Sigma` for payroll.
- **Isolation**: Canteen management logic is decoupled from general HR evaluations.

### Performance & Safety
- **NFR-001: Scalability**: Capability to handle peak lunch-hour loads (thousands of registrations in 60 mins).
- **NFR-002: Integrity**: Spot-check tools to verify badge ownership via photos from the `User` profile.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **User**: For employee association.
- **Badge**: For meal authentication.
- **PresenzeAssenze**: To verify eligibility for meal benefits based on hours worked.
### Data Model
- Timbrature, BuoniPasto, CentriCottura, Contribuzioni.
### Integration Points
- Consumed by monthly payroll for billing.

## 8. User Experience
- High-visibility dashboard for the canteen manager showing daily totals.
- Simple personal page for employees to verify their "last meal" or balance.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Recording Accuracy | 100% | Audit of badge swipes vs recorded meals. |
| Voucher Error Rate | 0% | Verification against attendance records. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- Employees use their standard identification badges for canteen access.
- Canteen terminals provide a standard data feed of meal events.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Offline terminals | Medium | Sync buffer and retry mechanism for logs. |
| Identity theft (sharing badges) | High | Spot checks and integration with photos from User profile. |

## 11. Dependencies & Constraints
- Must comply with national labor rules regarding meal benefits and taxation.

## 12. Release Plan
### Phase 1: Core Registry (Planned)
- Meal registration and basic voucher tracking.
- PHPStan Level 10 compliance.
### Phase 2: Payroll Integration (Future)
- Automated monthly payroll reporting for meal deductions.
- Direct API integration with major voucher providers (e.g., Edenred).

## 13. References
- [roadmap.md](roadmap.md)
