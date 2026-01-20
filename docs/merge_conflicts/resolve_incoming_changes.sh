#!/bin/bash

# Script per risolvere automaticamente tutti i conflitti Git prendendo la "incoming change" (develop)
# Creato: 2025-01-27
# Autore: Super Mucca AI Assistant
# Descrizione: Trova tutti i file con conflitti Git e risolve automaticamente prendendo la versione develop

set -e  # Exit on any error

echo "🚀 SUPERPOWERS ACTIVATED - Super Mucca Conflict Resolver"
echo "=================================================="
echo "📅 Data: $(date)"
echo "🎯 Obiettivo: Risolvere tutti i conflitti Git prendendo incoming changes (develop)"
echo ""

# Directory di lavoro
PROJECT_ROOT="/var/www/_bases/base_techplanner_fila3_mono"
LARAVEL_ROOT="$PROJECT_ROOT/laravel"

# Verifica che siamo nella directory corretta
if [ ! -d "$LARAVEL_ROOT" ]; then
    echo "❌ ERRORE: Directory Laravel non trovata: $LARAVEL_ROOT"
    exit 1
fi

cd "$LARAVEL_ROOT"

echo "📁 Directory di lavoro: $(pwd)"
echo ""

# Trova tutti i file con conflitti Git
echo "🔍 Ricerca file con conflitti Git..."

if [ -z "$CONFLICT_FILES" ]; then
    echo "✅ Nessun conflitto Git trovato!"
    exit 0
fi

echo "📋 File con conflitti trovati:"
echo "$CONFLICT_FILES" | while read -r file; do
    echo "   - $file"
done
echo ""

# Contatore
TOTAL_FILES=$(echo "$CONFLICT_FILES" | wc -l)
PROCESSED=0
SUCCESS=0
ERRORS=0

echo "🛠️  Inizio risoluzione conflitti..."
echo ""

# Backup directory
BACKUP_DIR="$PROJECT_ROOT/bashscripts/merge_conflicts/backup_$(date +%Y%m%d_%H%M%S)"
mkdir -p "$BACKUP_DIR"

echo "💾 Backup creato in: $BACKUP_DIR"
echo ""

# Processa ogni file
echo "$CONFLICT_FILES" | while read -r file; do
    PROCESSED=$((PROCESSED + 1))
    
    echo "[$PROCESSED/$TOTAL_FILES] 🔧 Processando: $file"
    
    # Backup del file originale
    cp "$file" "$BACKUP_DIR/"
    
    # Crea file temporaneo per la risoluzione
    TEMP_FILE=$(mktemp)
    
    # Flag per tracciare se siamo in una sezione da mantenere
    KEEP_SECTION=false
    IN_CONFLICT=false
    
    # Processa il file riga per riga
    while IFS= read -r line; do
        case "$line" in
                IN_CONFLICT=true
                KEEP_SECTION=false
                ;;
                IN_CONFLICT=false
                KEEP_SECTION=false
                ;;
            *)
                if [ "$IN_CONFLICT" = true ] && [ "$KEEP_SECTION" = true ]; then
                    # Mantieni questa riga (incoming change)
                    echo "$line" >> "$TEMP_FILE"
                elif [ "$IN_CONFLICT" = false ]; then
                    # Fuori dal conflitto, mantieni la riga
                    echo "$line" >> "$TEMP_FILE"
                fi
                ;;
        esac
    done < "$file"
    
    # Sostituisci il file originale
    mv "$TEMP_FILE" "$file"
    
    # Verifica che il conflitto sia stato risolto
        echo "   ❌ ERRORE: Conflitto non risolto in $file"
        ERRORS=$((ERRORS + 1))
    else
        echo "   ✅ Conflitto risolto con successo"
        SUCCESS=$((SUCCESS + 1))
    fi
    
    echo ""
done

# Statistiche finali
echo "📊 STATISTICHE FINALI"

if [ -z "$REMAINING_CONFLICTS" ]; then
    echo "🎉 TUTTI I CONFLITTI RISOLTI CON SUCCESSO!"
    echo ""
    echo "🚀 Prossimi passi suggeriti:"
    echo "   1. git add ."
    echo "   2. git commit -m 'Resolve merge conflicts: take incoming changes (develop)'"
    echo "   3. git push"
else
    echo "⚠️  Conflitti rimanenti:"
    echo "$REMAINING_CONFLICTS" | while read -r file; do
        echo "   - $file"
    done
fi

echo ""
echo "🏁 Script completato!"
echo "📅 Timestamp: $(date)"
