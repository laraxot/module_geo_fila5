#!/bin/bash

# Script di cleanup e verifica post-risoluzione conflitti
# SuperMucca Cleanup & Verify 🐄

set -e

echo "🐄 SuperMucca Cleanup & Verify 🐄"
echo "=================================="
echo ""

# Colori
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

WORK_DIR="/var/www/_bases/base_techplanner_fila3_mono/laravel"
cd "$WORK_DIR"

echo -e "${BLUE}Directory di lavoro: ${WORK_DIR}${NC}"
echo ""

# Funzione per verificare conflitti residui
check_remaining_conflicts() {
    echo -e "${BLUE}Controllo conflitti residui...${NC}"
    
    local remaining_files
    
    if [ ${#remaining_files[@]} -eq 0 ]; then
        echo -e "${GREEN}✓ Nessun conflitto residuo trovato!${NC}"
        return 0
    else
        echo -e "${RED}⚠ Trovati ${#remaining_files[@]} file con conflitti residui:${NC}"
        for file in "${remaining_files[@]}"; do
            echo -e "${RED}  - ${file}${NC}"
        done
        return 1
    fi
}

# Funzione per contare i file di backup
count_backups() {
    local backup_count
    backup_count=$(find . -name "*.backup" -o -name "*.advanced_backup" | wc -l)
    echo "$backup_count"
}

# Funzione per cleanup dei backup
cleanup_backups() {
    echo -e "${BLUE}Cleanup dei file di backup...${NC}"
    
    local backup_count
    backup_count=$(count_backups)
    
    if [ "$backup_count" -eq 0 ]; then
        echo -e "${GREEN}✓ Nessun file di backup da rimuovere${NC}"
        return 0
    fi
    
    echo -e "${YELLOW}Trovati ${backup_count} file di backup${NC}"
    
    read -p "Vuoi rimuovere tutti i file di backup? (y/N): " -n 1 -r
    echo ""
    
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        find . -name "*.backup" -delete
        find . -name "*.advanced_backup" -delete
        echo -e "${GREEN}✓ File di backup rimossi${NC}"
    else
        echo -e "${YELLOW}File di backup mantenuti${NC}"
    fi
}

# Funzione per verificare la sintassi PHP
check_php_syntax() {
    echo -e "${BLUE}Controllo sintassi PHP...${NC}"
    
    local error_count=0
    local total_files=0
    
    while IFS= read -r -d '' file; do
        ((total_files++))
        if ! php -l "$file" >/dev/null 2>&1; then
            echo -e "${RED}✗ Errore di sintassi: ${file}${NC}"
            ((error_count++))
        fi
    done < <(find . -name "*.php" -print0)
    
    if [ $error_count -eq 0 ]; then
        echo -e "${GREEN}✓ Tutti i ${total_files} file PHP hanno sintassi corretta${NC}"
        return 0
    else
        echo -e "${RED}✗ Trovati ${error_count} file con errori di sintassi su ${total_files} totali${NC}"
        return 1
    fi
}

# Funzione per eseguire PHPStan
run_phpstan() {
    echo -e "${BLUE}Esecuzione PHPStan...${NC}"
    
    if [ ! -f "./vendor/bin/phpstan" ]; then
        echo -e "${YELLOW}⚠ PHPStan non trovato, saltando...${NC}"
        return 0
    fi
    
    echo -e "${YELLOW}Esecuzione PHPStan su alcuni moduli critici...${NC}"
    
    # Test su moduli critici
    local critical_modules=("User" "Xot" "Cms")
    local phpstan_errors=0
    
    for module in "${critical_modules[@]}"; do
        if [ -d "Modules/$module" ]; then
            echo -e "${BLUE}  Testando modulo: ${module}${NC}"
            if ./vendor/bin/phpstan analyze "Modules/$module" --level=8 --no-progress --quiet; then
                echo -e "${GREEN}  ✓ ${module}: OK${NC}"
            else
                echo -e "${RED}  ✗ ${module}: Errori trovati${NC}"
                ((phpstan_errors++))
            fi
        fi
    done
    
    if [ $phpstan_errors -eq 0 ]; then
        echo -e "${GREEN}✓ PHPStan: Nessun errore critico${NC}"
        return 0
    else
        echo -e "${YELLOW}⚠ PHPStan: ${phpstan_errors} moduli con errori${NC}"
        return 1
    fi
}

# Funzione per verificare lo stato Git
check_git_status() {
    echo -e "${BLUE}Controllo stato Git...${NC}"
    
    if ! git status --porcelain >/dev/null 2>&1; then
        echo -e "${YELLOW}⚠ Non in un repository Git o errore Git${NC}"
        return 0
    fi
    
    local modified_files
    modified_files=$(git status --porcelain | wc -l)
    
    if [ "$modified_files" -eq 0 ]; then
        echo -e "${GREEN}✓ Working directory pulito${NC}"
    else
        echo -e "${YELLOW}⚠ ${modified_files} file modificati${NC}"
        echo -e "${BLUE}Stato Git:${NC}"
        git status --short
    fi
}

# Menu principale
show_menu() {
    echo ""
    echo -e "${BLUE}Opzioni disponibili:${NC}"
    echo "1. Controlla conflitti residui"
    echo "2. Controlla sintassi PHP"
    echo "3. Esegui PHPStan (moduli critici)"
    echo "4. Controlla stato Git"
    echo "5. Cleanup file di backup"
    echo "6. Esegui tutti i controlli"
    echo "7. Esci"
    echo ""
}

# Esecuzione di tutti i controlli
run_all_checks() {
    echo -e "${BLUE}Esecuzione di tutti i controlli...${NC}"
    echo ""
    
    local all_passed=true
    
    if ! check_remaining_conflicts; then
        all_passed=false
    fi
    echo ""
    
    if ! check_php_syntax; then
        all_passed=false
    fi
    echo ""
    
    if ! run_phpstan; then
        all_passed=false
    fi
    echo ""
    
    check_git_status
    echo ""
    
    if [ "$all_passed" = true ]; then
        echo -e "${GREEN}🎉 Tutti i controlli superati con successo!${NC}"
        echo ""
        echo -e "${BLUE}Il tuo codice è pronto per il commit:${NC}"
        echo "  git add ."
        echo "  git commit -m 'Resolve merge conflicts - accept filament4 changes'"
    else
        echo -e "${YELLOW}⚠ Alcuni controlli hanno rilevato problemi${NC}"
        echo -e "${BLUE}Risolvi i problemi prima di committare${NC}"
    fi
}

# Main loop
while true; do
    show_menu
    read -p "Scegli un'opzione (1-7): " -n 1 -r
    echo ""
    echo ""
    
    case $REPLY in
        1)
            check_remaining_conflicts
            ;;
        2)
            check_php_syntax
            ;;
        3)
            run_phpstan
            ;;
        4)
            check_git_status
            ;;
        5)
            cleanup_backups
            ;;
        6)
            run_all_checks
            ;;
        7)
            echo -e "${GREEN}Arrivederci! 🐄${NC}"
            exit 0
            ;;
        *)
            echo -e "${RED}Opzione non valida${NC}"
            ;;
    esac
    
    echo ""
    read -p "Premi ENTER per continuare..."
done
