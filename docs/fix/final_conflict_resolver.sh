#!/bin/bash

# Final Git Conflict Resolution Script - Optimized
# Risolve tutti i conflitti escludendo le cartelle di backup
# Location: bashscripts/fix/final_conflict_resolver.sh

set -euo pipefail

# Colors
readonly GREEN='\033[0;32m'
readonly YELLOW='\033[1;33m'
readonly BLUE='\033[0;34m'
readonly CYAN='\033[0;36m'
readonly RED='\033[0;31m'
readonly NC='\033[0m'

# Configuration
readonly SCRIPT_DIR="$(dirname "$0")"
readonly LARAVEL_DIR="$SCRIPT_DIR/../../laravel"

show_header() {
    echo -e "${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║              Final Git Conflict Resolver                 ║${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    echo ""
}

resolve_single_file() {
    local file="$1"
    local backup_dir="$2"
    
    echo -e "${BLUE}🔧 Processing: $file${NC}"
    
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
            echo -e "${GREEN}✅ PHP file resolved: $file${NC}"
            return 0
        else
            echo -e "${RED}❌ PHP syntax error: $file${NC}"
            cp "$backup_file" "$file"
            rm -f "$temp_file"
            return 1
        fi
    else
        mv "$temp_file" "$file"
        echo -e "${GREEN}✅ File resolved: $file${NC}"
        return 0
    fi
}

main() {
    show_header
    
    cd "$LARAVEL_DIR" || exit 1
    echo -e "${BLUE}📁 Working directory: $(pwd)${NC}\n"
    
    # Find conflicted files excluding backup directories
    local conflicted_files
        --include="*.php" \
        --include="*.md" \
        --include="*.txt" \
        --include="*.json" \
        --include="*.blade.php" \
        --exclude-dir=vendor \
        --exclude-dir=node_modules \
        --exclude-dir=conflict_backup_* \
        --exclude="*.backup" \
        --exclude="*.bak" \
        2>/dev/null || true)
    
    if [ -z "$conflicted_files" ]; then
        echo -e "${GREEN}🎉 No conflict markers found!${NC}"
        exit 0
    fi
    
    local total_files
    total_files=$(echo "$conflicted_files" | wc -l)
    echo -e "${BLUE}📊 Found $total_files files with conflicts${NC}"
    
    # Create backup directory
    local backup_dir="conflict_backup_final_$(date +%Y%m%d_%H%M%S)"
    mkdir -p "$backup_dir"
    echo -e "${BLUE}💾 Backup directory: $backup_dir${NC}\n"
    
    # Process all files
    local resolved=0
    local failed=0
    local count=0
    
    echo "$conflicted_files" | while read -r file; do
        if [ -n "$file" ]; then
            ((count++))
            echo -e "${CYAN}[$count/$total_files]${NC}"
            
            if resolve_single_file "$file" "$backup_dir"; then
                ((resolved++))
            else
                ((failed++))
            fi
            echo ""
        fi
    done
    
    # Final verification
    echo -e "${CYAN}🔍 Final verification...${NC}"
    local remaining
        --include="*.php" \
        --include="*.md" \
        --include="*.txt" \
        --include="*.json" \
        --include="*.blade.php" \
        --exclude-dir=vendor \
        --exclude-dir=node_modules \
        --exclude-dir=conflict_backup_* \
        2>/dev/null | wc -l || echo "0")
    
    echo -e "\n${CYAN}╔══════════════════════════════════════════════════════════╗${NC}"
    echo -e "${CYAN}║                    FINAL SUMMARY                         ║${NC}"
    echo -e "${CYAN}╠══════════════════════════════════════════════════════════╣${NC}"
    echo -e "${CYAN}║${NC} Files processed: ${YELLOW}$total_files${NC}"
    echo -e "${CYAN}║${NC} Remaining conflicts: ${YELLOW}$remaining${NC} files"
    echo -e "${CYAN}║${NC} Backup directory: ${BLUE}$backup_dir${NC}"
    echo -e "${CYAN}╚══════════════════════════════════════════════════════════╝${NC}"
    
    if [ "$remaining" -eq 0 ]; then
        echo -e "\n${GREEN}🎉 ALL CONFLICTS RESOLVED SUCCESSFULLY! 🎉${NC}"
    else
        echo -e "\n${YELLOW}⚠️  $remaining files still have conflicts${NC}"
        echo -e "${YELLOW}These may require manual intervention${NC}"
    fi
}

# Run if executed directly
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi
