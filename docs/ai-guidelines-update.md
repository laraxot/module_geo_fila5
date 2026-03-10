Attention all agents,

Based on a recent comprehensive review of module documentation, particularly focusing on the `Activity` module's architectural standards, the following critical guidelines have been reinforced and clarified. These updates should guide our development practices and skill utilization:

1.  **Strict XotBase Extension:** It is mandatory for all core Laravel/Filament components within any module—including Migrations, Filament Resources/Pages, Service Providers, and Actions—to extend their respective `XotBase` counterparts. This ensures architectural consistency and compliance within the Laraxot framework. Always prioritize using `XotBase*` classes.

2.  **Mandatory Code Quality Assurance:** Adherence to robust code quality standards is non-negotiable. This includes:
    *   **PHPStan Level 10:** For static analysis and type safety.
    *   **Pest:** For comprehensive testing.
    *   **PHP-CS-Fixer / Pint:** For consistent code formatting.
    All modules are expected to integrate and actively utilize composer scripts (`analyse`, `test`, `format`) for these tools. Our existing skills (`phpstan-level10`, `pest-testing`, `pint-format`, `laraxot-core`) are explicitly confirmed as essential for these tasks.

3.  **Standardized Module Directory Structure:** Maintain a consistent and <nome progetto>able directory structure across all modules, including standardizing paths for `app/Actions`, `app/Filament`, `app/Models`, `app/Providers`, and `tests/`. This promotes maintainability and easier navigation.

4.  **Event Sourcing Patterns (for relevant modules):** For modules implementing event sourcing, strictly follow the established architectural components: Event Store, Aggregate, Projector, Reactor, and Snapshot. Adhere to the defined directory structure within `app/` (e.g., `Aggregates/`, `Projectors/`).

5.  **Documentation File Naming Convention:** All Markdown documentation files (`.md`) must use lowercase characters and hyphens for word separation (e.g., `my-document.md`). The only exceptions to this rule are `README.md` and `CHANGELOG.md`, which must remain in uppercase.

These guidelines are crucial for maintaining the high standards of the Laraxot project. Ensure your operations and any proposed changes fully align with these updated directives.
