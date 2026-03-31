# PRD: User Module

## 📋 Executive Summary
The User module is the central authority for identity and access management (IAM) within the PTVX ecosystem. It manages authentication (via Laravel Fortify), authorization (via Spatie Permissions), and user profile metadata, ensuring that every interaction in the system is tied to a verified identity with appropriate permissions.

## 👥 Target Personas
- **Employees**: Need secure, easy access to their evaluation and payroll data.
- **HR Managers**: Need to manage user lifecycle (onboarding/offboarding) and role assignments.
- **Security Officers**: Need to audit access logs and manage permission sets.
- **AI Agents**: Need strict user typing (`UserContract`) for secure data handling.

## 🎯 Functional Requirements (P0/P1)
- **P0: Authentication**: Secure login, multi-factor authentication, and password recovery.
- **P0: Authorization**: Granular RBAC (Role-Based Access Control) across 35+ modules.
- **P0: Profile Management**: Multi-format profile data (metadata, preferences, avatars).
- **P1: Socialite Integration**: SSO support for PA-specific identity providers.
- **P1: Impersonation**: Secure administrative impersonation for troubleshooting.

## 🛠️ Technical Specs
- **Logic**: Uses Spatie Permission and Laravel Fortify/Passport for core IAM.
- **Contracts**: Enforces `Modules\Xot\Contracts\UserContract` for all user-bound methods.
- **Events**: Dispatches events on login/logout for global activity tracking.

## 🔌 Service Interface (The Contract)
- **Typing**: Never use `Model|null` for users; always use `UserContract`.
- **Resolution**: Use `Auth::user()` with explicit casting or helper methods.

## 🛡️ Non-Functional Requirements
- **Performance**: Permission checks < 1ms (cached).
- **Scalability**: Supports 10,000+ concurrent users per tenant.
- **Compliance**: Fully GDPR compliant (Right to be Forgotten, Data Portability).

## ✅ Release Criteria
- Security audit of authentication flows.
- 100% PHPStan Level 10 on all IAM logic.
- Italian/English translations for all notifications and pages.
