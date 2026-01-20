#!/bin/bash

# Script per trovare file con nomi duplicati (case-insensitive)
# Identifica file che hanno lo stesso nome ma con differenze di maiuscole/minuscole

echo "🔍 Ricerca file con nomi duplicati (case-insensitive)..."
echo ""

# Directory di lavoro
PROJECT_ROOT="/var/www/_bases/base_fixcity_fila4_mono"
cd "$PROJECT_ROOT"

# Array per memorizzare i file trovati
declare -A file_map
declare -A duplicates

echo "📁 Scansionando tutti i file nel progetto..."
echo ""

# Trova tutti i file e li organizza per nome lowercase
while IFS= read -r -d '' file; do
    # Ottieni solo il nome del file (senza path)
    filename=$(basename "$file")
    filename_lower=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
    
    # Se il file esiste già nel map, aggiungilo ai duplicati
    if [[ -n "${file_map[$filename_lower]}" ]]; then
        if [[ -z "${duplicates[$filename_lower]}" ]]; then
            duplicates[$filename_lower]="${file_map[$filename_lower]}"
        fi
        duplicates[$filename_lower]+="|$file"
    else
        file_map[$filename_lower]="$file"
    fi
done < <(find . -type f -print0)

# Conta i duplicati trovati
duplicate_count=0
total_files=0

echo "📊 RISULTATI ANALISI:"
echo "====================="
echo ""

# Mostra i duplicati trovati
for key in "${!duplicates[@]}"; do
    duplicate_count=$((duplicate_count + 1))
    echo "🔴 DUPLICATO #$duplicate_count:"
    echo "   Nome (lowercase): $key"
    echo "   File trovati:"
    
    IFS='|' read -ra files <<< "${duplicates[$key]}"
    for file in "${files[@]}"; do
        echo "     - $file"
        total_files=$((total_files + 1))
    done
    echo ""
done

# Mostra statistiche finali
echo "📈 STATISTICHE FINALI:"
echo "======================"
echo "Totale gruppi di duplicati: $duplicate_count"
echo "Totale file coinvolti: $total_files"
echo ""

if [ $duplicate_count -eq 0 ]; then
    echo "✅ Nessun file duplicato trovato!"
    echo "   Il progetto non ha problemi di case-sensitivity."
else
    echo "⚠️  ATTENZIONE: Trovati $duplicate_count gruppi di file duplicati!"
    echo ""
    echo "💡 RACCOMANDAZIONI:"
    echo "   1. Rivedere i file duplicati"
    echo "   2. Decidere quale versione mantenere"
    echo "   3. Rinominare o eliminare i duplicati"
    echo "   4. Verificare che non ci siano riferimenti ai file eliminati"
    echo ""
    echo "🔧 Per risolvere automaticamente:"
    echo "   ./bashscripts/resolve_case_duplicates.sh"
fi

echo ""
echo "🏁 Analisi completata!"
