---
name: ui-ux-standard
description: Protocols for modular Blade components, Filament Wizards, and UI consistency in Laraxot.
---

# UI/UX Standard Skill

This skill encodes the architectural patterns for building user interfaces within the PTVX/Laraxot modular system, focusing on Blade components and complex Filament forms.

## 🚨 Critical Rules

### 1. Modular Blade Components
Components must follow the standard directory structure to ensure automatic registration:
- **Vista**: `Modules/ModuleName/resources/views/components/kebab-case.blade.php`
- **Classe**: `Modules/ModuleName/View/Components/PascalCase.php`
- **Usage**: `<x-module-name::component-name>`

### 2. Filament Wizard Steps
When building Wizards, follow the **Separation of Definition** pattern:
- **Step Method**: `get{StepName}Step()` - Handles icon, label, and calls the schema method.
- **Schema Method**: `get{StepName}StepSchema()` - Returns the array of components.
- Avoid nesting schema arrays directly in the wizard definition.

### 3. Automatic Asset Publishing
Assets for modular components must be placed in `Modules/ModuleName/resources/assets` and published using `php artisan module:publish ModuleName`. Use the `module_asset('ModuleName', 'path/to/asset')` helper.

## 🛠️ Procedural Workflow

### Creating a Modular Blade Component
1. Create the view in `resources/views/components/`.
2. (Optional) Create the class in `View/Components/`.
3. Verify registration by using the tag in a test page.
4. Ensure all assets are linked via `module_asset()`.

### Building a Filament Wizard
1. Define each step in a dedicated `getXXXStep()` method.
2. Separate the component array into a `getXXXStepSchema()` method.
3. Use translated labels automatically (avoid `->label()`).
4. Ensure the Wizard is responsive (e.g., `columnSpanFull()` for major sections).
