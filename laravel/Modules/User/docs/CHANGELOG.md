# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Fixed - 2026-05-08

- PHPStan Level 5: 0 errors in User module (reduced from 7)
- EditUserWidget.php: Removed redundant $view property, inherited from XotBaseWidget
- RegistrationWidget.php: Removed redundant $view property, removed incorrect PHPDoc
- LogoutWidget.php: Removed unnecessary view exists check (always true)
- PasswordResetConfirmWidget.php: Removed $view property conflict
- PasswordResetWidget.php: Removed $view property conflict, added Model import
- PassportServiceProvider.php: Removed unnecessary method_exists check (method always exists)
- Sixteen theme: Rebuilt assets with map-lit component included

### Related Documentation
- Geo module: `docs/wiki/concepts/segnalazioni-elenco-map-visibility-issue.md` (map regression)
