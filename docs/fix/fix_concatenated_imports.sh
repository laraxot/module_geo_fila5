#!/bin/bash

echo "🔧 Fixing concatenated import statements..."

# Find all PHP files with concatenated imports (;use pattern)
files=$(grep -r -l ";use " . --include="*.php")

if [ -z "$files" ]; then
    echo "✅ No concatenated imports found!"
    exit 0
fi

total_files=$(echo "$files" | wc -l)
current=0

echo "📊 Found concatenated imports in $total_files files"

for file in $files; do
    ((current++))
    echo "[$current/$total_files] Processing: $file"
    
    # Create a backup
    cp "$file" "$file.backup"
    
    # Fix concatenated imports by replacing ";use " with ";\nuse "
    sed -i 's/;use /;\nuse /g' "$file"
    
    # Check if it's a PHP file and validate syntax
    if [[ "$file" == *.php ]]; then
        if ! php -l "$file" >/dev/null 2>&1; then
            echo "⚠️  PHP syntax error in $file after fix, restoring backup"
            mv "$file.backup" "$file"
        else
            echo "✅ Fixed: $file"
            rm "$file.backup"
        fi
    else
        echo "✅ Fixed: $file"
        rm "$file.backup"
    fi
done

echo "🎉 Finished processing $total_files files"