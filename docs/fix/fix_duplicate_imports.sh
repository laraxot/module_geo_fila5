#!/bin/bash

# Script per correggere import duplicati nei file PHP
echo "🔧 Correzione import duplicati PHP..."

# Trova tutti i file PHP con import duplicati
find /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules -name "*.php" -type f | while read file; do
    # Controlla se ci sono import duplicati sulla stessa linea
    if grep -q "use.*use.*;" "$file"; then
        echo "🔍 Trovato import duplicato in: $file"
        
        # Backup
        cp "$file" "$file.backup"
        
        # Correggi gli import duplicati sulla stessa linea
        sed -i 's/use \([^;]*\);use \([^;]*\);/use \1;\nuse \2;/g' "$file"
        
        # Rimuovi linee duplicate di import
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

echo "✅ Correzione import duplicati completata!"