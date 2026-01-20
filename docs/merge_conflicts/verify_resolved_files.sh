#!/bin/bash

# Script per verificare i file dopo la risoluzione dei conflitti
# Autore: Cascade AI
# Data: $(date +%Y-%m-%d)
# Versione: 1.0

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
MAGENTA='\033[0;35m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Funzione per stampare messaggi di log
log() {
  local level=$1
  local message=$2
  local color=$NC
  
  case $level in
    "INFO") color=$GREEN ;;
    "WARNING") color=$YELLOW ;;
    "ERROR") color=$RED ;;
    "DEBUG") color=$BLUE ;;
    "SUCCESS") color=$CYAN ;;
  esac
  
  echo -e "${color}[$level] $message${NC}"
}

# Funzione per verificare la sintassi PHP
check_php_syntax() {
  local file=$1
  
  php -l "$file" > /dev/null 2>&1
  if [ $? -ne 0 ]; then
    log "ERROR" "Errore di sintassi PHP in $file"
    php -l "$file"
    return 1
  fi
  
  return 0
}

# Funzione per verificare la validità JSON
check_json_syntax() {
  local file=$1
  
  if command -v jq &> /dev/null; then
    cat "$file" | jq . > /dev/null 2>&1
    if [ $? -ne 0 ]; then
      log "ERROR" "Errore di sintassi JSON in $file"
      return 1
    fi
  else
    log "WARNING" "jq non è installato. Impossibile verificare la sintassi JSON."
  fi
  
  return 0
}

# Funzione per verificare la presenza di conflitti residui
check_remaining_conflicts() {
  local file=$1
  
