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

## 5. Functional Requirements
### FR-001: Meal Registration
- **Priority**: Must-have
- **Description**: Record when and where an employee consumes a meal.
- **Acceptance Criteria**: Compatible with badge-based or app-based meal registration.

### FR-002: Voucher Management
- **Priority**: Must-have
- **Description**: Track and manage the entitlement and distribution of meal vouchers.
- **Acceptance Criteria**: Configurable rules for voucher entitlement (e.g., sessions of 6+ hours).

### FR-003: Cost Contribution
- **Priority**: Should-have
- **Description**: Track the portion of the meal cost paid by the employee vs the company.
- **Acceptance Criteria**: Integration with payroll system (Sigma) for monthly deductions.

### FR-004: Cooking Center Coordination
- **Priority**: Could-have
- **Description**: Manage information about different cooking centers and providers.
- **Acceptance Criteria**: Reports of meal counts sent to each provider daily.

## 6. Non-Functional Requirements
- **NFR-001: Real-time update**: Meal consumption data should be visible within the day.
- **NFR-002: Scalability**: Support processing of thousands of meal registrations daily.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

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
