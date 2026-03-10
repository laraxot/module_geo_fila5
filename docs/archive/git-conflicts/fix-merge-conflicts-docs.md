# Fix Merge Conflicts Scripts

## Overview

These scripts automatically resolve Git merge conflicts by keeping the current version (HEAD) of conflicted files. They're particularly useful after merging branches or pulling changes that result in numerous merge conflicts.

- `fix_merge_conflicts.sh`: Resolves conflicts in all files (including vendor)
- `fix_merge_conflicts_no_vendor.sh`: Resolves conflicts only in non-vendor files (faster)

## Features

- **Automatic Resolution**: Resolves conflicts by keeping the current version (HEAD)
- **Backup System**: Creates backups of all modified files before making changes
- **File Validation**: Validates PHP and JSON files after resolution to ensure they remain valid
- **Comprehensive Reporting**: Provides detailed logs and summary of operations
- **Selective Processing**: Supports multiple file types and excludes common directories like vendor and node_modules

## Usage

```bash
# To resolve conflicts in all files (including vendor)
./fix_merge_conflicts.sh

# To resolve conflicts only in non-vendor files (faster)
./fix_merge_conflicts_no_vendor.sh
```

## Supported File Types

The script supports resolving conflicts in the following file types:

- PHP (`*.php`, `*.blade.php`)
- Markdown (`*.md`)
- Text (`*.txt`)
- JSON (`*.json`)
- JavaScript (`*.js`)
- TypeScript (`*.ts`)
- Vue (`*.vue`)
- CSS/SCSS (`*.css`, `*.scss`)
- YAML (`*.yaml`, `*.yml`)
- XML (`*.xml`)
- HTML (`*.html`)
- SQL (`*.sql`)
- Shell scripts (`*.sh`)

## Excluded Directories

The following directories are excluded from processing:

- vendor
- node_modules
- .git
- storage/logs
- storage/framework
- public/storage
- .tmp
- tmp

## How It Works

1. The script searches for files containing the marker
2. For each file found:
   - Creates a backup in a timestamped directory
   - Processes the file to keep only the current version (HEAD)
   - Validates the file (syntax check for PHP, structure check for JSON)
   - Restores from backup if validation fails
3. Generates a summary report of resolved and failed files
4. Performs a final verification to ensure all conflicts were resolved

## Error Handling

If any file fails validation after resolution, the script will:

1. Log an error message
2. Restore the file from backup
3. Continue processing other files
4. Report the failure in the summary

## Requirements

- Bash shell
- PHP (for validating PHP files)
- jq (optional, for validating JSON files)

## Related Scripts

- `fix_git_conflicts_current_change.sh`: Previous version with similar functionality
- `resolve_git_conflicts.sh`: Alternative approach for conflict resolution
- `batch_resolve_git_conflicts.sh`: Resolves conflicts in batches to avoid overwhelming the system

## Changelog

### Version 1.0.0 (2025-09-22)

- Initial release
- Automatic conflict resolution keeping HEAD version
- Backup system for all modified files
- Validation for PHP and JSON files
- Comprehensive logging and reporting
