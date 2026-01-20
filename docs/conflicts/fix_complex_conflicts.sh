#!/bin/bash

# Script per risolvere conflitti complessi
# Gestisce import duplicati, PHPDoc e altri conflitti comuni

echo "🔧 Risoluzione conflitti complessi..."

# Funzione per pulire import duplicati
clean_duplicate_imports() {
    local file="$1"
    echo "🧹 Pulizia import duplicati in: $file"
    
    # Rimuove import duplicati mantenendo solo l'ultimo
    awk '
    /^use / {
        if (seen[$0]) {
            next
        }
        seen[$0] = 1
    }
    { print }
    ' "$file" > "$file.tmp" && mv "$file.tmp" "$file"
}

# Funzione per risolvere conflitti di import
fix_import_conflicts() {
    local file="$1"
    echo "📦 Risoluzione conflitti import in: $file"
    
    # Rimuove marker di conflitto per import
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
        }
    }' "$file"
}

# Funzione per risolvere conflitti PHPDoc
fix_phpdoc_conflicts() {
    local file="$1"
    echo "📝 Risoluzione conflitti PHPDoc in: $file"
    
    # Rimuove marker di conflitto per PHPDoc
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
        }
    }' "$file"
}

# Funzione per rimuovere marker di conflitto vuoti
remove_empty_conflicts() {
    local file="$1"
    echo "🗑️  Rimozione conflitti vuoti in: $file"
    
    # Rimuove blocchi di conflitto che contengono solo spazi o marker
            /^[[:space:]]*$/d
        }
        /=======/,/>>>>>>> [a-f0-9]* (\.)/{
            /^[[:space:]]*$/d
            /=======/d
            />>>>>>> [a-f0-9]* (\.)/d
        }
    }' "$file"
}

# Funzione per processare un file
process_file() {
    local file="$1"
    echo "📝 Processando: $file"
    
    # Backup del file originale
    cp "$file" "$file.backup"
    
    # Applica le correzioni
    fix_import_conflicts "$file"
    fix_phpdoc_conflicts "$file"
    remove_empty_conflicts "$file"
    clean_duplicate_imports "$file"
    
    echo "✅ Completato: $file"
}

# Trova tutti i file PHP con conflitti
find /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules -name "*.php" -type f | while read -r file; do
