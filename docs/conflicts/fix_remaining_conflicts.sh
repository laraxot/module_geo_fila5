#!/bin/bash

# Script finale per risolvere tutti i conflitti rimanenti
# Gestisce import, PHPDoc e altri conflitti comuni

echo "🔧 Risoluzione finale conflitti rimanenti..."

# Funzione per risolvere conflitti di import
fix_import_conflicts() {
    local file="$1"
    echo "📦 Risoluzione conflitti import in: $file"
    
    # Rimuove marker di conflitto per import mantenendo il contenuto
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
        }
    }' "$file"
}

# Funzione per risolvere conflitti di commenti e PHPDoc
fix_comment_conflicts() {
    local file="$1"
    echo "💬 Risoluzione conflitti commenti in: $file"
    
    # Rimuove marker di conflitto per commenti
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
        }
    }' "$file"
}

# Funzione per risolvere conflitti di codice
fix_code_conflicts() {
    local file="$1"
    echo "💻 Risoluzione conflitti codice in: $file"
    
    # Rimuove marker di conflitto per codice mantenendo la versione più recente
            /^[[:space:]]*$/d
        }
        /=======/,/>>>>>>> [a-f0-9]* (\.)/{
            /^[[:space:]]*$/d
            /=======/d
            />>>>>>> [a-f0-9]* (\.)/d
        }
    }' "$file"
}

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

# Funzione per pulire linee vuote multiple
clean_empty_lines() {
    local file="$1"
    echo "🧽 Pulizia linee vuote in: $file"
    
    # Rimuove linee vuote multiple
    sed -i '/^$/N;/^\n$/d' "$file"
}

# Funzione per processare un file
process_file() {
    local file="$1"
    echo "📝 Processando: $file"
    
    # Backup del file originale
    cp "$file" "$file.backup"
    
    # Applica le correzioni in sequenza
    fix_import_conflicts "$file"
    fix_comment_conflicts "$file"
    fix_code_conflicts "$file"
    clean_duplicate_imports "$file"
    clean_empty_lines "$file"
    
    echo "✅ Completato: $file"
}

# Trova tutti i file PHP con conflitti
find /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules -name "*.php" -type f | while read -r file; do
