# Prenotazioni - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Prenotazioni Module Team

## 1. Purpose & Vision
The Prenotazioni module manages **appointments, desk bookings, and shared resources** for the PTVX platform. It provides a specialized calendaring and reservation engine to coordinate face-to-face meetings, room occupancy, and shared asset usage, ensuring efficient physical resources management.

## 2. Problem Statement
The organization needs:
- A structured way for users and citizens to book appointments.
- Management of shared company resources (meeting rooms, desks).
- Coordination between different types of services and available time slots.
- Prevent overbooking and manage cancellations.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Back-office Admin** | Resource Manager | Define bookable assets, manage calendars, oversee all reservations. |
| **Service Operator** | Service Provider | View their daily/weekly agenda, manage check-ins. |
| **Employee/Citizen** | Bookee | Browse available slots, book/cancel appointments. |

## 4. Scope
### In Scope
- Appointment and calendar management.
- Desk and room booking.
- Registry of dynamic "Service Types" (Tipi Appuntamento).
- Support for recurring reservations.
- Availability management for operators.
- Filament resources for calendar visualization and booking.

### Out of Scope
- Full-scale public ticketing (delegated to specialized citizens-portal).
- Logistics/Cleaning scheduling.

## 5. Functional Requirements (Prioritized)

### P0: Reservation Core (Must-have)
- **FR-001: Resource & Service Definition**: Create bookable services (HR advice, medical checks) and physical resources (desks, rooms) with availability rules.
- **FR-002: Dynamic Calendar Interface**: Integrated visual calendar for managing and viewing bookings in real-time.
- **FR-005: Concurrency Control**: Real-time locking mechanism to prevent double bookings across all channels.

### P1: Operational Management (Important)
- **FR-003: Check-in & Lifecycle Tracking**: Tools for operators to mark appointments as "Completed", "No-show", or "Cancelled".
- **FR-004: Automated Reminders**: Email and SMS notifications for upcoming reservations using the `Notify` module.

### P2: Advanced Logistics (Nice-to-have)
- **FR-006: Visual Resource Mapping**: Interactive maps for desk and room selection during the booking process.
- **FR-007: AI Availability Optimization**: Predictive suggestions for resource allocation based on historical booking trends.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Resource Agnosticism**: Prenotazioni MUST NOT be limited to specific assets; it provides a generic booking engine for any entity.
- **Interoperability**: Consumes user profiles from `User` and provides availability data to other modules (e.g., Performance for evaluation slots).
- **Independence**: The scheduling engine is abstracted from the specific business domain of the reservation.

### Performance & Safety
- **NFR-001: Data Consistency**: Guaranteed zero double-booking rate through database-level constraints.
- **NFR-002: Scalability**: Support for high-concurrency booking during organizational deadlines.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base core.
- **User**: For identifies of bookees.
- **Notify**: For reminders.
### Data Model
- Appuntamenti, Calendari, TipiAppuntamento.

## 8. User Experience
- Intuitive "pick-a-time" interface for users.
- Weekly/Monthly agenda view for operators.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Double-booking rate | 0% | Database audit. |
| No-show rate | < 10% | Completion tracking. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Users have access to the platform to book/cancel.
- Operators maintain their own availability calendars.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Calendar sync lag | Medium | Optimistic locking and real-time refreshes. |
| Resource downtime | Low | Ability to "black-out" dates in the calendar. |

## 11. Dependencies & Constraints
- Must respect per-tenant resource availability.

## 12. Release Plan
### Phase 1: Core Booking (Stable)
- Basic appointment and service registry. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Assets & Rules (Planned)
- Desk booking visual maps.
- Advanced availability rules (e.g., blackout dates, limited concurrency).

## 13. References
- [roadmap.md](roadmap.md)
