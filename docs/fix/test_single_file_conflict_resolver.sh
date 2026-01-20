#!/bin/bash

# Test Script for Single File Git Conflict Resolution
# Tests the auto_resolve_git_conflicts.sh script on a single file
# Location: bashscripts/fix/test_single_file_conflict_resolver.sh

set -euo pipefail

# Colors for better output
readonly RED='\033[0;31m'
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly CYAN='\033[0;36m'
readonly NC='\033[0m' # No Color

# Configuration
readonly TEST_FILE="${1:-Modules/Employee/lang/it/work_hour.php}"
readonly SCRIPT_DIR="$(dirname "$0")"
readonly LARAVEL_DIR="$SCRIPT_DIR/../../laravel"

# Function to display header
show_header() {
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║              Single File Conflict Test                   ║${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

# Function to log messages
log_message() {
    local level="$1"
    local message="$2"
    local timestamp=$(date '+%H:%M:%S')
    
    case "$level" in
        "INFO")
            echo -e "${BLUE}[$timestamp] INFO: ${message}${NC}"
            ;;
        "SUCCESS")
            echo -e "${GREEN}[$timestamp] SUCCESS: ${message}${NC}"
            ;;
        "ERROR")
            echo -e "${RED}[$timestamp] ERROR: ${message}${NC}"
            ;;
        "WARNING")
            echo -e "${YELLOW}[$timestamp] WARNING: ${message}${NC}"
            ;;
    esac
}

# Function to check if file has conflicts
check_conflicts() {
    local file="$1"
        return 0  # has conflicts
    else
        return 1  # no conflicts
    fi
}

# Function to resolve conflicts in a single file
resolve_file_conflicts() {
    local file="$1"
    
    log_message "INFO" "Processing file: $file"
    
    # Check if file exists
    if [ ! -f "$file" ]; then
        log_message "ERROR" "File not found: $file"
        return 1
    fi
    
    # Check if file has conflicts
    if ! check_conflicts "$file"; then
        log_message "INFO" "No conflicts found in: $file"
        return 0
    fi
    
    # Create backup
    local backup_file="${file}.conflict_backup_$(date +%Y%m%d_%H%M%S)"
    cp "$file" "$backup_file"
    log_message "INFO" "Backup created: $backup_file"
    
    # Show conflicts before resolution
    echo -e "\n${YELLOW}=== CONFLICTS FOUND ===${NC}"
    echo ""
    
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
    
    # Clean up excessive blank lines
    sed -i '/^$/N;/^\n$/d' "$temp_file" 2>/dev/null || true
    
    # Validate the resolved file
    if [[ "$file" == *.php ]]; then
        if php -l "$temp_file" >/dev/null 2>&1; then
            log_message "SUCCESS" "PHP syntax validation passed"
        else
            log_message "ERROR" "PHP syntax validation failed"
            log_message "WARNING" "Restoring from backup"
            cp "$backup_file" "$file"
            rm -f "$temp_file"
            return 1
        fi
    fi
    
    # Replace original file with resolved version
    mv "$temp_file" "$file"
    
    # Verify no conflicts remain
    if check_conflicts "$file"; then
        log_message "ERROR" "Conflicts still remain after resolution"
        log_message "WARNING" "Restoring from backup"
        cp "$backup_file" "$file"
        return 1
    else
        log_message "SUCCESS" "All conflicts resolved successfully"
        
        # Show file size comparison
        local original_size=$(wc -l < "$backup_file")
        local resolved_size=$(wc -l < "$file")
        log_message "INFO" "Lines: $original_size → $resolved_size"
        
        return 0
    fi
}

# Main function
main() {
    show_header
    
    # Change to Laravel directory
    if [ ! -d "$LARAVEL_DIR" ]; then
        log_message "ERROR" "Laravel directory not found: $LARAVEL_DIR"
        exit 1
    fi
    
    cd "$LARAVEL_DIR" || exit 1
    log_message "INFO" "Working directory: $(pwd)"
    
    # Process the test file
    if resolve_file_conflicts "$TEST_FILE"; then
        log_message "SUCCESS" "Test completed successfully!"
        
        echo -e "\n${GREEN}=== FINAL VERIFICATION ===${NC}"
        log_message "INFO" "Checking for remaining conflicts..."
        
        if check_conflicts "$TEST_FILE"; then
            log_message "ERROR" "Conflicts still exist!"
            exit 1
        else
            log_message "SUCCESS" "No conflicts detected!"
        fi
        
        exit 0
    else
        log_message "ERROR" "Test failed!"
        exit 1
    fi
}

# Run if executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
