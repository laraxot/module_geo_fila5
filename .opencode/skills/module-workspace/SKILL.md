---
name: module-workspace
description: Create and manage VS Code workspace files for modules. Each module must have a _<snake_case_name>.code-workspace file. Use when creating new modules or verifying workspace conventions.
---

# Module Workspace - VS Code Configuration

Each module and theme must have a properly named VS Code workspace file.

## When to Use

- When creating a new module
- When verifying module structure conventions
- When the user asks about workspace files

## Naming Convention

```
_<snake_case_module_name>.code-workspace
```

### Examples

| Module | Workspace File |
|--------|---------------|
| CertFisc | `_cert_fisc.code-workspace` |
| IndennitaCondizioniLavoro | `_indennita_condizioni_lavoro.code-workspace` |
| MobilitaVolontaria | `_mobilita_volontaria.code-workspace` |
| UI | `_ui.code-workspace` |
| Xot | `_xot.code-workspace` |
| DbForge | `_dbforge.code-workspace` |
| Legge104 | `_legge104.code-workspace` |

## Template

```json
{
  "folders": [
    {
      "path": "."
    }
  ],
  "settings": {
    "editor.formatOnSave": true,
    "php-cs-fixer.onsave": true,
    "php-cs-fixer.formatHtml": true,
    "php-cs-fixer.executable": "php-cs-fixer",
    "php-cs-fixer.executablePath": "",
    "php-cs-fixer.executablePathWindows": "php-cs-fixer.bat",
    "vscode-php-cs-fixer.allowRisky": true,
    "phpmd.enabled": false,
    "phpmd.validate.rulesets": "cleancode,codesize,controversial,design,naming,unusedcode",
    "phpmd.SuppressWarnings": true,
    "phpmd.verbose": false,
    "php-cs-fixer.allowRisky": true,
    "editor.defaultFormatter": "junstyle.php-cs-fixer",
    "[php]": {
      "editor.defaultFormatter": "junstyle.php-cs-fixer"
    },
    "editor.tokenColorCustomizations": {
      "semanticHighlighting": true
    },
    "vscode-php-cs-fixer.useCache": true,
    "git.ignoreLimitWarning": true,
    "files.eol": "\n",
    "editor.wordWrap": "wordWrapColumn",
    "editor.wordWrapColumn": 120,
    "git.autofetch": "all"
  }
}
```

## Location

- Modules: `laravel/Modules/{ModuleName}/_<snake_case>.code-workspace`
- Themes: `laravel/Themes/{ThemeName}/_<snake_case>.code-workspace`
