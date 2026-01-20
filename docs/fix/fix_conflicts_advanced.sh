#!/bin/bash

# Script avanzato per risolvere automaticamente i conflitti Git scegliendo sempre la "current change"
# Autore: AI Assistant
# Data: $(date +%Y-%m-%d)
# Versione: 2.0

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Directory di base
BASE_DIR="/var/www/_bases/base_predict_fila4_mono"
SCRIPT_DIR="/var/www/_bases/base_predict_fila4_mono/bashscripts"

# Log file con timestamp
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
LOG_FILE="${SCRIPT_DIR}/logs/fix_conflicts_${TIMESTAMP}.log"
BACKUP_DIR="${SCRIPT_DIR}/backups/conflicts_${TIMESTAMP}"

# Crea directory se non esistono
mkdir -p "${SCRIPT_DIR}/logs"
mkdir -p "${BACKUP_DIR}"

echo -e "${BLUE}=== Script Avanzato di Risoluzione Conflitti Git ===${NC}"
echo -e "${BLUE}=== Sceglie sempre la 'current change' (dopo =======) ===${NC}"
echo -e "${BLUE}=== $(date) ===${NC}"
echo -e "${YELLOW}📁 Directory di lavoro: ${BASE_DIR}${NC}"
echo -e "${YELLOW}📝 Log salvato in: ${LOG_FILE}${NC}"
echo -e "${YELLOW}💾 Backup salvati in: ${BACKUP_DIR}${NC}\n"

# Inizializza il log
{
    echo "=== Script Avanzato di Risoluzione Conflitti Git ==="
    echo "=== $(date) ==="
    echo "=== Sceglie sempre la 'current change' (dopo =======) ==="
    echo "=== Directory: ${BASE_DIR} ==="
    echo ""
} > "$LOG_FILE"

# Contatori globali
TOTAL_FILES=0
RESOLVED_FILES=0
FAILED_FILES=0
SKIPPED_FILES=0

# Funzione per log con timestamp
log_with_timestamp() {
    local message="$1"
    local timestamp=$(date '+%Y-%m-%d %H:%M:%S')
    echo "[$timestamp] $message" >> "$LOG_FILE"
}

# Funzione per risolvere i conflitti in un singolo file
resolve_file_conflicts() {
    local file="$1"
    local temp_file="${file}.tmp.${TIMESTAMP}"
    local conflict_count=0
    local in_conflict=false
    local keep_current=false
    local line_number=0
    
    log_with_timestamp "Elaborazione file: $file"
    
    # Verifica se il file esiste e è leggibile
    if [ ! -f "$file" ]; then
        echo -e "${RED}❌ File non trovato: $file${NC}"
        log_with_timestamp "ERRORE: File non trovato: $file"
        return 1
    fi
    
    if [ ! -r "$file" ]; then
        echo -e "${RED}❌ File non leggibile: $file${NC}"
        log_with_timestamp "ERRORE: File non leggibile: $file"
        return 1
    fi
    
    if [ ! -w "$file" ]; then
        echo -e "${RED}❌ File non scrivibile: $file${NC}"
        log_with_timestamp "ERRORE: File non scrivibile: $file"
        return 1
    fi
    
    # Crea backup del file originale
    cp "$file" "${BACKUP_DIR}/$(basename "$file").backup"
    log_with_timestamp "Backup creato: ${BACKUP_DIR}/$(basename "$file").backup"
    
    # Processa il file riga per riga
    while IFS= read -r line; do
        ((line_number++))
        
        # Rileva inizio conflitto
            if [ "$in_conflict" = true ]; then
                keep_current=true
                log_with_timestamp "Separatore rilevato alla riga $line_number - scegliendo current change"
            fi
            continue
        fi
        
        # Rileva fine conflitto
        if [[ "$line" =~ ^">>>>>>> " ]]; then
            if [ "$in_conflict" = true ]; then
                in_conflict=false
                keep_current=false
                log_with_timestamp "Fine conflitto #$conflict_count alla riga $line_number"
            fi
            continue
        fi
        
        # Scrivi la riga se non siamo in conflitto o se stiamo tenendo la current change
        if [ "$in_conflict" = false ] || [ "$keep_current" = true ]; then
            echo "$line" >> "$temp_file"
        fi
        
    done < "$file"
    
    # Se abbiamo risolto conflitti, sostituisci il file originale
    if [ "$conflict_count" -gt 0 ]; then
        if mv "$temp_file" "$file"; then
            echo -e "${GREEN}✅ Risolti $conflict_count conflitti in: $file${NC}"
            log_with_timestamp "SUCCESSO: Risolti $conflict_count conflitti in $file"
            return 0
        else
            echo -e "${RED}❌ Errore durante la sostituzione di: $file${NC}"
            log_with_timestamp "ERRORE: Impossibile sostituire $file"
            rm -f "$temp_file"
            return 1
        fi
    else
        # Nessun conflitto trovato
        rm -f "$temp_file"
        echo -e "${YELLOW}⚠️  Nessun conflitto trovato in: $file${NC}"
        log_with_timestamp "INFO: Nessun conflitto trovato in $file"
        return 2
    fi
}

# Funzione per trovare e processare tutti i file con conflitti
find_and_resolve_all_conflicts() {
    local search_dir="$1"
    
    echo -e "${BLUE}🔍 Ricerca file con conflitti in: $search_dir${NC}"
    log_with_timestamp "Inizio ricerca conflitti in: $search_dir"
    
    # Trova tutti i file con conflitti
    local conflict_files=()
    while IFS= read -r -d '' file; do
        conflict_files+=("$file")
