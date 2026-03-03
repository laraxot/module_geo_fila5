# Lang - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Lang Module Team

## 1. Purpose & Vision

The Lang module is the **localization and translation engine** for the entire Laraxot ecosystem. It manages all translation keys, language files, locale detection, and provides the infrastructure for mandatory Italian + English internationalization.

The vision is to transform language management into an **intelligent, universal service** capable of generating and managing multilingual content on-the-fly via AI while maintaining brand coherence.

## 2. Problem Statement

Multilingual enterprise applications require:
- Centralized translation management across 35+ modules
- Mandatory dual-language support (Italian + English)
- No hardcoded labels in Filament components
- Dynamic locale switching with URL-based localization
- Translation key discovery and auto-generation

## 3. Target Users

| User | Role | Needs |
|------|------|-------|
| **Developer** | Module builder | Translation key conventions, auto-discovery |
| **Translator** | Content localizer | Translation management interface |
| **End User** | Application user | Seamless language switching |
| **Admin** | System configuration | Locale settings, missing key reports |

## 4. Scope

### In Scope
- Translation file management for all modules
- Locale detection and switching (`mcamara/laravel-localization`)
- Translation key auto-generation patterns
- Missing translation detection
- Filament-compatible translation infrastructure

### Out of Scope
- Business domain logic
- UI component rendering (UI module)
- User preferences storage (User module)

## 5. Functional Requirements (Prioritized)

### P0: Core Localization (Must-have)
- **FR-001: Centralized Translations**: Manage translation files for all modules from a single point (`Modules/{Module}/lang/{locale}/*.php`).
- **FR-002: Locale Switching**: URL-based locale switching using `mcamara/laravel-localization` and `LaravelLocalization::setLocale()`.
- **FR-005: Mandatory i18n**: Support for Italian (primary) and English (secondary) across all modules.

### P1: Developer Experience (Important)
- **FR-003: Auto-Discovery**: Detect missing translation keys and suggest additions through standardized naming patterns.
- **FR-006: Key Standardization**: Enforce consistent naming conventions for translation keys across the ecosystem.

### P2: Advanced Automation (Nice-to-have)
- **FR-004: AI Translation**: AI-powered translation suggestions for new keys, maintaining brand voice and technical terminology.
- **FR-007: Translation UI**: Browser-based interface for managing translations without touching PHP files.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Global Service**: Lang acts as a global provider; it MUST NOT depend on any domain-specific module.
- **Interoperability**: Provides a unified interface for all modules to register and retrieve translations.
- **Independent Extension**: Modules register their own language namespaces, maintaining isolation.

### Performance & Safety
- **NFR-001: Performance**: Translation lookup cached per request; zero filesystem reads after initial boot.
- **NFR-002: Completeness**: 100% key existence in both Italian and English enforced via CI.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture

### Dependencies
- **Xot**: Base service provider
- **mcamara/laravel-localization**: Route localization

### Data Model
- Translation files organized by module: `Modules/{Module}/lang/{locale}/*.php`
- No database storage (filesystem-based)

### Integration Points
- Every module registers its translations via service provider
- Filament resources use `trans()` keys from module namespace
- `LaravelLocalization` middleware in route groups

## 8. User Experience

- **Language switcher**: Available in theme header
- **Admin panel**: Translation key browser (planned)
- **Developer**: Automatic key resolution from class/method names

## 9. Success Metrics & KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| Translation coverage | 100% it + en | Missing key scanner |
| PHPStan Level 10 | 0 errors | PHPStan analysis |
| Hardcoded labels | 0 | Code audit |

## 10. Risks & Assumptions

### Assumptions
- Italian and English are the only mandatory languages
- Filesystem-based translations are sufficient for current scale
- All Filament labels use translation keys (not raw strings)

### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Missing translations in production | Medium | CI check for completeness |
| Performance with 35+ modules loading translations | Low | Laravel translation caching |

## 11. Dependencies & Constraints

- **Technical**: PHP 8.3+, Laravel 12, `mcamara/laravel-localization`
- **Regulatory**: Italian PA requires Italian UI as primary

## 12. Release Plan

### Phase 1: Stability & Cleanup (In Progress)
- PHPStan Level 10 ✅
- Obsolete file removal
- Standardize key naming conventions

### Phase 2: Developer Tooling (Planned)
- Translation key browser in admin panel
- Missing key auto-detection and reporting
- Import/export to XLIFF format

### Phase 3: AI-Powered Translation (Future)
- AI translation suggestions
- Brand voice consistency checker
- Auto-translation for new keys

## 13. References

- [roadmap.md](roadmap.md)
- [module.md](module.md)
