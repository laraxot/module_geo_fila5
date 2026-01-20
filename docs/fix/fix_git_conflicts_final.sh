#!/bin/bash

# Script finale per risolvere conflitti Git scegliendo sempre la "current change"
# Autore: AI Assistant con poteri della supermucca
# Data: $(date +%Y-%m-%d)
# Versione: 5.0 - Supermucca Edition FINAL

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

# Directory di base
BASE_DIR="/var/www/_bases/base_techplanner_fila4_mono"
SCRIPT_DIR="/var/www/_bases/base_techplanner_fila4_mono/bashscripts"

# Log file con timestamp
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
LOG_FILE="${SCRIPT_DIR}/logs/fix_conflicts_final_${TIMESTAMP}.log"
BACKUP_DIR="${SCRIPT_DIR}/backups/conflicts_final_${TIMESTAMP}"

# Crea directory se non esistono
mkdir -p "${SCRIPT_DIR}/logs"
mkdir -p "${BACKUP_DIR}"

echo -e "${BOLD}${BLUE}=== 🐄 SCRIPT SUPERMUCCA FINAL - RISOLUZIONE CONFLITTI GIT ===${NC}"
echo -e "${BOLD}${BLUE}=== Sceglie SEMPRE la 'current change' (dopo =======) ===${NC}"
echo -e "${BOLD}${BLUE}=== $(date) ===${NC}"
echo -e "${YELLOW}📁 Directory di lavoro: ${BASE_DIR}${NC}"
echo -e "${YELLOW}📝 Log salvato in: ${LOG_FILE}${NC}"
echo -e "${YELLOW}💾 Backup salvati in: ${BACKUP_DIR}${NC}\n"

# Inizializza il log
{
    echo "=== SCRIPT SUPERMUCCA FINAL - RISOLUZIONE CONFLITTI GIT ==="
    echo "=== $(date) ==="
    echo "=== Sceglie SEMPRE la 'current change' (dopo =======) ==="
    echo "=== Directory: ${BASE_DIR} ==="
    echo "=== Versione: 5.0 - Supermucca Edition FINAL ==="
    echo ""
} > "$LOG_FILE"

# Contatori globali
TOTAL_FILES=0
RESOLVED_FILES=0
FAILED_FILES=0
SKIPPED_FILES=0
TOTAL_CONFLICTS=0

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
    
    # Conta i conflitti prima della risoluzione
    conflict_count=$(grep -c "<<<<<<< " "$file" 2>/dev/null || echo "0")
    
    if [ "$conflict_count" -eq 0 ]; then
        echo -e "${YELLOW}⚠️  Nessun conflitto trovato in: $file${NC}"
        log_with_timestamp "INFO: Nessun conflitto trovato in $file"
        return 2
    fi
    
    # Crea backup del file originale
    local backup_file="${BACKUP_DIR}/$(basename "$file").backup.${TIMESTAMP}"
    cp "$file" "$backup_file"
    log_with_timestamp "Backup creato: $backup_file"
    
    # Usa sed per risolvere i conflitti scegliendo sempre la current change
    # Rimuove tutto tra marker e ======= (inclusi)
    # Mantiene tutto tra ======= e >>>>>>> (esclusi i marcatori)
    sed -E '/^<<<<<<< /,/^=======/{/^=======/!d;d};/^>>>>>>> /d' "$file" > "$temp_file"
    
    # Verifica che il file temporaneo sia stato creato correttamente
    if [ ! -f "$temp_file" ] || [ ! -s "$temp_file" ]; then
        echo -e "${RED}❌ Errore durante la creazione del file temporaneo: $file${NC}"
        log_with_timestamp "ERRORE: Impossibile creare file temporaneo per $file"
        rm -f "$temp_file"
        return 1
    fi
    
    # Sostituisci il file originale
    if mv "$temp_file" "$file"; then
        echo -e "${GREEN}✅ Risolti $conflict_count conflitti in: $file${NC}"
        log_with_timestamp "SUCCESSO: Risolti $conflict_count conflitti in $file"
        TOTAL_CONFLICTS=$((TOTAL_CONFLICTS + conflict_count))
        return 0
    else
        echo -e "${RED}❌ Errore durante la sostituzione di: $file${NC}"
        log_with_timestamp "ERRORE: Impossibile sostituire $file"
        rm -f "$temp_file"
        return 1
    fi
}

# Funzione per trovare e processare tutti i file con conflitti
find_and_resolve_all_conflicts() {
    local search_dir="$1"
    
    echo -e "${BLUE}🔍 Ricerca file con conflitti in: $search_dir${NC}"
    log_with_timestamp "Inizio ricerca conflitti in: $search_dir"
    
    # Trova tutti i file con conflitti usando find per maggiore efficienza
    local conflict_files=()
    while IFS= read -r -d '' file; do
        conflict_files+=("$file")
    done < <(find "$search_dir" -type f \( -name "*.php" -o -name "*.js" -o -name "*.vue" -o -name "*.ts" -o -name "*.json" -o -name "*.md" -o -name "*.sh" -o -name "*.yml" -o -name "*.yaml" -o -name "*.blade.php" \) -exec grep -l "<<<<<<< " {} \; -print0 2>/dev/null)
    
    TOTAL_FILES=${#conflict_files[@]}
    
    if [ "$TOTAL_FILES" -eq 0 ]; then
        echo -e "${GREEN}🎉 Nessun file con conflitti trovato!${NC}"
        log_with_timestamp "INFO: Nessun file con conflitti trovato"
        return 0
    fi
    
    echo -e "${CYAN}📋 Trovati $TOTAL_FILES file con conflitti${NC}"
    log_with_timestamp "Trovati $TOTAL_FILES file con conflitti"
    
    # Processa ogni file
    local file_count=0
    for file in "${conflict_files[@]}"; do
        ((file_count++))
        echo -e "${YELLOW}[$file_count/$TOTAL_FILES] 🔧 Elaborazione: $file${NC}"
        
        # Risolvi i conflitti nel file
        case $(resolve_file_conflicts "$file") in
            0)
                ((RESOLVED_FILES++))
                ;;
            1)
                ((FAILED_FILES++))
                echo -e "${RED}❌ Impossibile risolvere i conflitti in: $file${NC}"
                log_with_timestamp "ERRORE: Impossibile risolvere i conflitti in $file"
                ;;
            2)
                ((SKIPPED_FILES++))
                ;;
        esac
    done
}

# Funzione per verificare che non ci siano più conflitti
verify_no_conflicts() {
    local search_dir="$1"
    local remaining_conflicts=0
    
    echo -e "${BLUE}🔍 Verifica finale: controllo conflitti rimanenti...${NC}"
    
    remaining_conflicts=$(find "$search_dir" -type f \( -name "*.php" -o -name "*.js" -o -name "*.vue" -o -name "*.ts" -o -name "*.json" -o -name "*.md" -o -name "*.sh" -o -name "*.yml" -o -name "*.yaml" -o -name "*.blade.php" \) -exec grep -l "<<<<<<< " {} \; 2>/dev/null | wc -l)
    
    if [ "$remaining_conflicts" -eq 0 ]; then
        echo -e "${GREEN}✅ Verifica completata: nessun conflitto rimanente!${NC}"
        log_with_timestamp "SUCCESSO: Verifica completata, nessun conflitto rimanente"
        return 0
    else
        echo -e "${RED}❌ ATTENZIONE: Trovati $remaining_conflicts file con conflitti rimanenti!${NC}"
        log_with_timestamp "ATTENZIONE: Trovati $remaining_conflicts file con conflitti rimanenti"
        return 1
    fi
}

# Funzione principale
main() {
    echo -e "${BOLD}${PURPLE}🚀 Avvio risoluzione conflitti Git...${NC}"
    
    # Trova e risolvi tutti i conflitti
    find_and_resolve_all_conflicts "$BASE_DIR"
    
    # Verifica che non ci siano più conflitti
    verify_no_conflicts "$BASE_DIR"
    local verify_result=$?
    
    # Riepilogo finale
    echo -e "\n${BOLD}${BLUE}=== 📊 RIEPILOGO FINALE ===${NC}"
    echo -e "${BLUE}📁 File totali processati: $TOTAL_FILES${NC}"
    echo -e "${GREEN}✅ File risolti con successo: $RESOLVED_FILES${NC}"
    echo -e "${YELLOW}⚠️  File senza conflitti: $SKIPPED_FILES${NC}"
    echo -e "${RED}❌ File con errori: $FAILED_FILES${NC}"
    echo -e "${PURPLE}🔧 Conflitti totali risolti: $TOTAL_CONFLICTS${NC}"
    
    # Salva riepilogo nel log
    {
        echo ""
        echo "=== RIEPILOGO FINALE ==="
        echo "File totali processati: $TOTAL_FILES"
        echo "File risolti con successo: $RESOLVED_FILES"
        echo "File senza conflitti: $SKIPPED_FILES"
        echo "File con errori: $FAILED_FILES"
        echo "Conflitti totali risolti: $TOTAL_CONFLICTS"
        echo "Verifica finale: $([ $verify_result -eq 0 ] && echo "SUCCESSO" || echo "ATTENZIONE")"
    } >> "$LOG_FILE"
    
    if [ $verify_result -eq 0 ]; then
        echo -e "${GREEN}🎉 TUTTI I CONFLITTI SONO STATI RISOLTI!${NC}"
        echo -e "${GREEN}💾 Backup salvati in: ${BACKUP_DIR}${NC}"
        echo -e "${GREEN}📝 Log completo in: ${LOG_FILE}${NC}"
        return 0
    else
        echo -e "${RED}⚠️  ALCUNI CONFLITTI POTREBBERO ESSERE RIMASTI${NC}"
        echo -e "${YELLOW}💡 Esegui nuovamente lo script per risolverli${NC}"
        return 1
    fi
}

# Esegui la funzione principale
main "$@"
