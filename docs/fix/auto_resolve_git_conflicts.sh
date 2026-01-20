#!/bin/bash

# Auto Git Conflict Resolution Script
# Automatically resolves git conflicts by taking the current version (HEAD)
# Location: bashscripts/fix/auto_resolve_git_conflicts.sh
# Category: Git Conflict Resolution
# Author: Auto-generated script
# Description: Finds all files with git conflict markers and automatically resolves them by keeping the current version

set -euo pipefail

# Colors for better output
readonly RED='\033[0;31m'
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly PURPLE='\033[0;35m'
readonly CYAN='\033[0;36m'
readonly NC='\033[0m' # No Color

# Script configuration
readonly SCRIPT_NAME="Auto Git Conflict Resolver"
readonly SCRIPT_VERSION="1.0.0"
readonly BACKUP_PREFIX="conflict_backup"

# Supported file extensions
readonly SUPPORTED_EXTENSIONS=(
    "*.php"
    "*.md" 
    "*.txt"
    "*.json"
    "*.blade.php"
    "*.js"
    "*.ts"
    "*.vue"
    "*.css"
    "*.scss"
    "*.yaml"
    "*.yml"
    "*.xml"
    "*.html"
    "*.sql"
    "*.sh"
)

# Excluded directories
readonly EXCLUDED_DIRS=(
    "vendor"
    "node_modules"
    ".git"
    "storage/logs"
    "storage/framework"
    "public/storage"
    ".tmp"
    "tmp"
)

# Function to display script header
show_header() {
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                ${SCRIPT_NAME}                ║${NC}"
    echo -e "${CYAN}║                    Version ${SCRIPT_VERSION}                     ║${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

# Function to log messages with timestamp
log_message() {
    local level="$1"
    local message="$2"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    
    case "$level" in
        "INFO")
            echo -e "${BLUE}[${timestamp}] INFO: ${message}${NC}"
            ;;
        "SUCCESS")
            echo -e "${GREEN}[${timestamp}] SUCCESS: ${message}${NC}"
            ;;
        "WARNING")
            echo -e "${YELLOW}[${timestamp}] WARNING: ${message}${NC}"
            ;;
        "ERROR")
            echo -e "${RED}[${timestamp}] ERROR: ${message}${NC}"
            ;;
        "PROCESSING")
            echo -e "${PURPLE}[${timestamp}] PROCESSING: ${message}${NC}"
            ;;
    esac
}

# Function to build grep include arguments
build_include_args() {
    local args=""
    for ext in "${SUPPORTED_EXTENSIONS[@]}"; do
        args="${args} --include=\"${ext}\""
    done
    echo "$args"
}

# Function to build grep exclude directory arguments
build_exclude_args() {
    local args=""
    for dir in "${EXCLUDED_DIRS[@]}"; do
        args="${args} --exclude-dir=\"${dir}\""
    done
    echo "$args"
}

# Function to find conflicted files
find_conflicted_files() {    
    local include_args=$(build_include_args)
    local exclude_args=$(build_exclude_args)
    
    # Use eval to properly expand the arguments
}

# Function to validate file after conflict resolution
validate_file() {
    local file="$1"
    local file_ext="${file##*.}"
    
    case "$file_ext" in
        "json")
            if command -v jq >/dev/null 2>&1; then
                if ! jq empty "$file" 2>/dev/null; then
                    return 1
                fi
            fi
            ;;
        "php")
            if ! php -l "$file" >/dev/null 2>&1; then
                return 1
            fi
            ;;
        "js"|"ts")
            if command -v node >/dev/null 2>&1; then
                if ! node -c "$file" 2>/dev/null; then
                    return 1
                fi
            fi
            ;;
    esac
    
    return 0
}

# Function to resolve conflicts in a single file
resolve_file_conflicts() {
    local file="$1"
    local backup_dir="$2"
    
    log_message "PROCESSING" "Resolving conflicts in: $file"
    
    # Create backup with proper path structure
    local backup_file="${backup_dir}/$(echo "$file" | sed 's/^\.\///' | tr '/' '_')"
    cp "$file" "$backup_file"
    log_message "INFO" "Backup created: $backup_file"
    
    # Create temporary file for processing
    local temp_file="${file}.resolving"
    
    # Remove conflict markers keeping only the current version (HEAD)
    awk '
    BEGIN { in_conflict = 0 }
        in_conflict = 1
        next 
    }
        in_conflict = 0
        next 
    }
    {
        if (in_conflict == 1 || in_conflict == 0) {
            print
        }
    }
    ' "$file" > "$temp_file"
    
    # Clean up excessive blank lines (more than 2 consecutive)
    sed -i '/^$/N;/^\n$/d' "$temp_file" 2>/dev/null || true
    
    # Validate the resolved file
    if validate_file "$temp_file"; then
        mv "$temp_file" "$file"
        log_message "SUCCESS" "Conflicts resolved successfully in: $file"
        return 0
    else
        log_message "ERROR" "File validation failed after resolution: $file"
        log_message "WARNING" "Restoring from backup: $backup_file"
        cp "$backup_file" "$file"
        rm -f "$temp_file"
        return 1
    fi
}

# Function to verify no conflicts remain
verify_no_conflicts() {
    log_message "INFO" "Performing final verification..."
    
    local remaining_conflicts=$(find_conflicted_files)
    
    if [ -z "$remaining_conflicts" ]; then
        log_message "SUCCESS" "All conflict markers successfully removed!"
        return 0
    else
        log_message "WARNING" "Some conflict markers might still exist in:"
        echo "$remaining_conflicts" | while read -r file; do
            echo -e "  ${YELLOW}• $file${NC}"
        done
        return 1
    fi
}

# Function to generate summary report
generate_summary() {
    local total_files="$1"
    local resolved_files="$2"
    local failed_files="$3"
    local backup_dir="$4"
    
    echo ""
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                    RESOLUTION SUMMARY                    ║${NC}"
    echo -e "${CYAN}╠══════════════════════════════════════════════════════════╣${NC}"
    echo -e "${CYAN}║${NC} Total files found: ${YELLOW}$total_files${NC}"
    echo -e "${CYAN}║${NC} Successfully resolved: ${GREEN}$resolved_files${NC}"
    echo -e "${CYAN}║${NC} Failed to resolve: ${RED}$failed_files${NC}"
    echo -e "${CYAN}║${NC} Backup directory: ${BLUE}$backup_dir${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
}

# Main function
main() {
    show_header
    
    # Change to Laravel directory
    local script_dir="$(dirname "$0")"
    local laravel_dir="$script_dir/../../laravel"
    
    if [ ! -d "$laravel_dir" ]; then
        log_message "ERROR" "Laravel directory not found: $laravel_dir"
        exit 1
    fi
    
    cd "$laravel_dir" || exit 1
    log_message "INFO" "Working directory: $(pwd)"
    
    # Find conflicted files
    log_message "INFO" "Searching for files with git conflict markers..."
    local conflicted_files
    conflicted_files=$(find_conflicted_files)
    
    if [ -z "$conflicted_files" ]; then
        log_message "SUCCESS" "No conflict markers found!"
        exit 0
    fi
    
    # Count files
    local total_files
    total_files=$(echo "$conflicted_files" | wc -l)
    log_message "INFO" "Found $total_files files with conflict markers"
    
    # Create backup directory
    local backup_dir="${BACKUP_PREFIX}_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$backup_dir"
    log_message "INFO" "Created backup directory: $backup_dir"
    
    # Process each file
    local resolved_files=0
    local failed_files=0
    
    while IFS= read -r file; do
        if [ -n "$file" ]; then
            if resolve_file_conflicts "$file" "$backup_dir"; then
                ((resolved_files++))
            else
                ((failed_files++))
            fi
        fi
    done <<< "$conflicted_files"
    
    # Final verification
    verify_no_conflicts
    
    # Generate summary
    generate_summary "$total_files" "$resolved_files" "$failed_files" "$backup_dir"
    
    if [ "$failed_files" -gt 0 ]; then
        log_message "WARNING" "Some files could not be automatically resolved. Manual intervention may be required."
        exit 1
    else
        log_message "SUCCESS" "All conflicts resolved successfully!"
        exit 0
    fi
}

# Check if script is being sourced or executed
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
