#!/bin/bash

# Batch Git Conflict Resolution Script
# Processes git conflicts in batches to avoid overwhelming the system
# Location: bashscripts/fix/batch_resolve_git_conflicts.sh
# Category: Git Conflict Resolution

set -euo pipefail

# Colors
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly CYAN='\033[0;36m'
readonly NC='\033[0m'

# Configuration
readonly BATCH_SIZE="${1:-10}"
readonly SCRIPT_DIR="$(dirname "$0")"
readonly LARAVEL_DIR="$SCRIPT_DIR/../../laravel"

show_header() {
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║              Batch Git Conflict Resolver                 ║${NC}"
    echo -e "${CYAN}║                Batch Size: $BATCH_SIZE files                    ║${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

resolve_single_file() {
    local file="$1"
    local backup_dir="$2"
    
    echo -e "${BLUE}Processing: $file${NC}"
    
    # Create backup
    local backup_file="${backup_dir}/$(echo "$file" | sed 's/^\.\///' | tr '/' '_')"
    cp "$file" "$backup_file"
    
    # Create temp file
    local temp_file="${file}.resolving"
    
    # Remove conflicts keeping HEAD version
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
    
    # Clean excessive blank lines
    sed -i '/^$/N;/^\n$/d' "$temp_file" 2>/dev/null || true
    
    # Validate PHP files
    if [[ "$file" == *.php ]]; then
        if php -l "$temp_file" >/dev/null 2>&1; then
            mv "$temp_file" "$file"
            echo -e "${GREEN}✅ Resolved: $file${NC}"
            return 0
        else
            echo -e "${YELLOW}❌ PHP Error: $file${NC}"
            cp "$backup_file" "$file"
            rm -f "$temp_file"
            return 1
        fi
    else
        mv "$temp_file" "$file"
        echo -e "${GREEN}✅ Resolved: $file${NC}"
        return 0
    fi
}

main() {
    show_header
    
    cd "$LARAVEL_DIR" || exit 1
    echo -e "${BLUE}Working directory: $(pwd)${NC}\n"
    
    # Find conflicted files
    local conflicted_files
        --include="*.php" \
        --include="*.md" \
        --include="*.txt" \
        --include="*.json" \
        --include="*.blade.php" \
        --exclude-dir=vendor \
        --exclude-dir=node_modules \
        --exclude="*.backup" \
        --exclude="*.bak" \
        2>/dev/null || true)
    
    if [ -z "$conflicted_files" ]; then
        echo -e "${GREEN}✅ No conflict markers found!${NC}"
        exit 0
    fi
    
    local total_files
    total_files=$(echo "$conflicted_files" | wc -l)
    echo -e "${BLUE}Found $total_files files with conflicts${NC}"
    
    # Create backup directory
    local backup_dir="conflict_backup_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$backup_dir"
    echo -e "${BLUE}Backup directory: $backup_dir${NC}\n"
    
    # Process files in batches
    local processed=0
    local resolved=0
    local failed=0
    
    echo "$conflicted_files" | head -n "$BATCH_SIZE" | while read -r file; do
        if [ -n "$file" ]; then
            if resolve_single_file "$file" "$backup_dir"; then
                ((resolved++))
            else
                ((failed++))
            fi
            ((processed++))
        fi
    done
    
    echo -e "\n${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                    BATCH SUMMARY                         ║${NC}"
    echo -e "${CYAN}╠══════════════════════════════════════════════════════════╣${NC}"
    echo -e "${CYAN}║${NC} Processed: ${YELLOW}$BATCH_SIZE${NC} files"
    echo -e "${CYAN}║${NC} Backup dir: ${BLUE}$backup_dir${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    
    # Check remaining conflicts
    local remaining
        --include="*.php" \
        --exclude-dir=vendor \
        --exclude-dir=node_modules \
        2>/dev/null | wc -l || echo "0")
    
    echo -e "\n${BLUE}Remaining conflicts: $remaining files${NC}"
    
    if [ "$remaining" -gt 0 ]; then
        echo -e "${YELLOW}Run the script again to process more files${NC}"
    else
        echo -e "${GREEN}🎉 All conflicts resolved!${NC}"
    fi
}

# Run if executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
