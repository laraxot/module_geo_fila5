#!/bin/bash

# Script per risolvere conflitti annidati e complessi
# Gestisce conflitti multipli nello stesso file

echo "🔧 Risoluzione conflitti annidati..."

# Funzione per risolvere conflitti annidati
fix_nested_conflicts() {
    local file="$1"
    echo "🔄 Processando conflitti annidati in: $file"
    
    # Backup del file originale
    cp "$file" "$file.backup"
    
    # Rimuove conflitti annidati mantenendo il contenuto più recente
    
    # Rimuove conflitti semplici rimanenti
            /^[[:space:]]*$/d
        }
        /=======/,/>>>>>>> [a-f0-9]* (\.)/{
            /^[[:space:]]*$/d
            /=======/d
            />>>>>>> [a-f0-9]* (\.)/d
        }
    }' "$file"
    
    # Pulisce linee vuote multiple
    sed -i '/^$/N;/^\n$/d' "$file"
    
    echo "✅ Completato: $file"
}

# Funzione per risolvere conflitti di import specifici
fix_import_conflicts() {
    local file="$1"
    echo "📦 Risoluzione conflitti import in: $file"
    
    # Rimuove conflitti per import mantenendo solo la versione più pulita
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
        }
    }' "$file"
}

# Funzione per risolvere conflitti PHPDoc
fix_phpdoc_conflicts() {
    local file="$1"
    echo "📝 Risoluzione conflitti PHPDoc in: $file"
    
    # Rimuove conflitti per PHPDoc mantenendo la versione più pulita
            s/>>>>>>> [a-f0-9]* (\.)\n//g
            s/\n\n/\n/g
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

# Funzione per processare un file
process_file() {
    local file="$1"
    echo "📝 Processando: $file"
    
    # Applica le correzioni in sequenza
    fix_nested_conflicts "$file"
    fix_import_conflicts "$file"
    fix_phpdoc_conflicts "$file"
    clean_duplicate_imports "$file"
    
    echo "✅ Completato: $file"
}

# Trova tutti i file PHP con conflitti
find /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules -name "*.php" -type f | while read -r file; do
