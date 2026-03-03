# Sms - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Sms Module Team

## 1. Purpose & Vision
The Sms module provides a **reliable and scalable SMS delivery infrastructure** for the Laraxot ecosystem. It abstracts various SMS gateway providers (e.g., Twilio, various local Italian providers) into a unified API, enabling other modules to send alerts, 2FA codes, and urgent notifications via text message.

## 2. Problem Statement
The system needs to:
- Reach users instantly on their mobile devices for urgent communications.
- Support multiple SMS gateways with easy failover.
- Track delivery status and costs of sent messages.
- Manage SMS templates centrally.
- Handle blacklists and user opt-outs for SMS communication.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Developer** | Module Builder | Single `Sms::send()` method to dispatch messages. |
| **System Admin** | Gateway Manager | Configure credentials, monitor delivery rates, manage costs. |
| **End User** | Recipient | Receive critical alerts (2FA, urgent shifts) via SMS. |

## 4. Scope
### In Scope
- Unified SMS sending API.
- Support for multiple provider drivers.
- Message history and status tracking (Sent, Delivered, Failed).
- SMS template management.
- Recipient blacklist management (for Opt-outs).
- Incoming SMS handling (if supported by provider).
- Filament resources for history and logs.

### Out of Scope
- Marketing SMS campaigns (delegated to specialized platforms).
- Physical GSM hardware management.

## 5. Functional Requirements
### FR-001: Multi-Gateway Support
- **Priority**: Must-have
- **Description**: Support for different SMS providers through a driver-based architecture.
- **Acceptance Criteria**: Ability to switch providers via configuration without code changes.

### FR-002: Message History
- **Priority**: Must-have
- **Description**: Permanent log of all sent messages including timestamp and status.
- **Acceptance Criteria**: Admin can filter logs by recipient or status.

### FR-003: SMS Templates
- **Priority**: Should-have
- **Description**: Pre-defined templates with placeholder support for dynamic content.
- **Acceptance Criteria**: Ensures consistent branding and messaging across the platform.

### FR-004: Status Webhooks
- **Priority**: Should-have
- **Description**: Handle delivery reports from providers to update message status in real-time.
- **Acceptance Criteria**: Successfully marks messages as "Delivered" based on gateway callback.

## 6. Non-Functional Requirements
- **NFR-001: Reliability**: Queue-based sending to prevent application bottlenecks.
- **NFR-002: Security**: Masking of phone numbers in some admin views if necessary.
- **NFR-003: Type Safety**: PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base framework.
- **Notify**: Acts as a bridge for multi-channel notifications.
### Data Model
- `sms_logs`: History of messages.
- `sms_templates`: Registry of pre-made messages.
### Integration Points
- Leveraged by `Notify` as a high-priority delivery channel.

## 8. User Experience
- Clear logs showing "Reason for failure" if a message was not delivered.
- Simple configuration UI for gateway credentials.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| Delivery Success Rate | > 98% | Delivered vs Sent (excluding invalid numbers). |
| Latency | < 10s | Time from trigger to provider dispatch. |
| PHPStan Compliance | Level 10 | Static analysis result. |

## 10. Risks & Assumptions
### Assumptions
- Organization has a valid contract with an SMS gateway provider.
- Mobile numbers in the User profiles are correctly formatted (international format).
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Gateway downtime | High | Multi-provider failover support. |
| High costs | Medium | Daily/Monthly sending limits per tenant. |

## 11. Dependencies & Constraints
- Must comply with national regulations on SMS communication and marketing.

## 12. Release Plan
### Phase 1: Core Sending (Stable)
- Basic driver-based API and logging. ✅
- PHPStan Level 10 compliance. ✅
### Phase 2: Advanced Templates (Planned)
- Fully visual template editor.
- Integrated gateway balance monitoring.

## 13. References
- [roadmap.md](roadmap.md)
