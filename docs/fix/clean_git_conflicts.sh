#!/bin/bash

# Script to clean all git conflict markers from files
# Keeps the current version (HEAD) and removes all conflict markers
# Location: bashscripts/fix/clean_git_conflicts.sh

# Colors for better output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🔍 Searching for files with git conflict markers in Laravel project...${NC}"

# Change to Laravel directory
cd "$(dirname "$0")/../../laravel" || exit 1

# Find all files with conflict markers (excluding vendor, node_modules, and backup files)
    --include="*.php" \
    --include="*.md" \
    --include="*.txt" \
    --include="*.json" \
    --include="*.blade.php" \
    --exclude-dir=vendor \
    --exclude-dir=node_modules \
    --exclude="*.backup" \
    --exclude="*.bak" \
    2>/dev/null)

if [ -z "$FILES" ]; then
    echo -e "${GREEN}✅ No conflict markers found!${NC}"
    exit 0
fi

echo -e "\n📝 Found ${YELLOW}$(echo "$FILES" | wc -l)${NC} files with conflict markers"

# Create backup directory with timestamp
BACKUP_DIR="conflict_backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

# Process each file
for file in $FILES; do
    echo -e "\n🔧 Processing: ${YELLOW}$file${NC}"
    
    # Create backup in backup directory
    backup_path="$BACKUP_DIR/$(echo "$file" | sed 's/^\///' | tr '/' '_')"
    cp "$file" "$backup_path"
    echo -e "   📦 Backup created: $backup_path"
    
    # Remove conflict markers while keeping current version (HEAD)
    awk '
    !in_conflict { print }
    ' "$file" > "${file}.tmp" && mv "${file}.tmp" "$file"
    
    # Remove excessive blank lines (more than 2 consecutive)
    sed -i -e '/./{H;$!d;}' -e 'x;/\n\n\n/!d' "$file"
    
    # Verify if file is still valid
    if [[ "$file" == *.json ]]; then
        if ! jq empty "$file" 2>/dev/null; then
            echo -e "   ${RED}❌ Error: Invalid JSON after conflict resolution. Restoring backup.${NC}"
            cp "$backup_path" "$file"
            continue
        fi
    fi
    
    if [[ "$file" == *.php ]]; then
        if ! php -l "$file" >/dev/null 2>&1; then
            echo -e "   ${RED}❌ Error: Invalid PHP syntax after conflict resolution. Restoring backup.${NC}"
            cp "$backup_path" "$file"
            continue
        fi
    fi
    
    echo -e "   ${GREEN}✅ Conflict markers removed successfully.${NC}"
done

# Final verification
echo -e "\n🔍 Verifying for remaining conflict markers..."
    --include="*.php" \
    --include="*.md" \
    --include="*.txt" \
    --include="*.json" \
    --include="*.blade.php" \
    --exclude-dir=vendor \
    --exclude-dir=node_modules \
    --exclude="*.backup" \
    --exclude="*.bak" \
    2>/dev/null)

if [ -z "$REMAINING" ]; then
    echo "✅ All conflict markers successfully removed!"
else
    echo "⚠️  Some conflict markers might still exist in:"
    echo "$REMAINING"
fi
