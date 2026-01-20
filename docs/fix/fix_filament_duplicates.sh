#!/bin/bash

# Script per correggere duplicazioni negli import dei file Filament
echo "🔧 Correzione duplicazioni specifiche Filament..."

# Trova file TechPlanner con duplicazioni
find /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/TechPlanner/app/Filament -name "*.php" -type f | while read file; do
    # Controlla se ha duplicazioni di import
    if grep -q "use Modules\\TechPlanner" "$file" && [ $(grep -c "use Modules\\TechPlanner" "$file") -gt 1 ]; then
        echo "🔍 Duplicazione in: $file"
        
        # Backup
        cp "$file" "$file.backup"
        
        # Rimuovi duplicazioni mantenendo solo la prima occorrenza di ogni import
        awk '
        /^use / {
            if (!seen[$0]++) print
            next
        }
        { print }
        ' "$file" > "$file.tmp" && mv "$file.tmp" "$file"
        
        # Verifica sintassi
        if php -l "$file" > /dev/null 2>&1; then
            echo "✅ Corretto: $file"
            rm "$file.backup"
        else
            echo "❌ Errore in: $file - Ripristino backup"
            mv "$file.backup" "$file"
        fi
    fi
done

echo "✅ Correzione duplicazioni Filament completata!"