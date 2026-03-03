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

## 5. Functional Requirements
### FR-001: Resource/Service Definition
- **Priority**: Must-have
- **Description**: Create bookable services (e.g., HR advice) or resources (e.g., Desk 5).
- **Acceptance Criteria**: Each service defines slot duration and availability rules.

### FR-002: Dynamic Calendar
- **Priority**: Must-have
- **Description**: Visual calendar for managing and viewing bookings.
- **Acceptance Criteria**: Integration with Filament's calendar patterns.

### FR-003: Check-in/Completion
- **Priority**: Should-have
- **Description**: Mark an appointment as "Completed" or "No-show".
- **Acceptance Criteria**: Status history tracked per reservation.

### FR-004: Automated Notifications
- **Priority**: Should-have
- **Description**: Email/SMS reminders for upcoming appointments.
- **Acceptance Criteria**: Uses the Notify module with customizable triggers.

## 6. Non-Functional Requirements
- **NFR-001: Consistency**: Real-time locking to prevent double bookings.
- **NFR-002: Scalability**: Support high concurrency during heavy booking periods.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

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
