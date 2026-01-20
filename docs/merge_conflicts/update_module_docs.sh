#!/bin/bash

# Script per aggiornare la documentazione dei moduli
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

# Funzione per verificare e creare la struttura di documentazione standard
create_standard_doc_structure() {
  local module_name=$1
  local docs_dir="/var/www/_bases/base_predict_fila4_mono/laravel/Modules/$module_name/docs"
  
  # Crea la directory docs se non esiste
  if [ ! -d "$docs_dir" ]; then
    mkdir -p "$docs_dir"
    log "INFO" "Creata directory docs per il modulo $module_name"
  fi
  
  # Crea le sottodirectory standard se non esistono
  local subdirs=("architecture" "best-practices" "phpstan" "filament" "development" "testing")
  
  for subdir in "${subdirs[@]}"; do
    if [ ! -d "$docs_dir/$subdir" ]; then
      mkdir -p "$docs_dir/$subdir"
      log "INFO" "Creata sottodirectory $subdir per il modulo $module_name"
    fi
  done
  
  # Crea un README.md se non esiste
  if [ ! -f "$docs_dir/readme.md" ] && [ ! -f "$docs_dir/README.md" ]; then
    cat > "$docs_dir/README.md" << EOF
# Modulo $module_name

## Descrizione
Documentazione del modulo $module_name.

## Struttura
- [Architecture](./architecture/): Architettura del modulo
- [Best Practices](./best-practices/): Best practices per lo sviluppo
- [PHPStan](./phpstan/): Configurazione e regole PHPStan
- [Filament](./filament/): Componenti e configurazione Filament
- [Development](./development/): Guide per lo sviluppo
- [Testing](./testing/): Strategie e casi di test

## Convenzioni
Seguire le convenzioni di codifica definite nel documento principale del progetto.

## Dipendenze
Elenco delle dipendenze del modulo.

## Autori
Team di sviluppo.

## Changelog
Storico delle modifiche principali.
EOF
    log "SUCCESS" "Creato README.md per il modulo $module_name"
  fi
}

# Funzione per aggiornare la documentazione di un modulo
update_module_documentation() {
  local module_name=$1
  local module_dir="/var/www/_bases/base_predict_fila4_mono/laravel/Modules/$module_name"
  local docs_dir="$module_dir/docs"
  
  log "INFO" "Aggiornamento documentazione per il modulo $module_name..."
  
  # Verifica se il modulo esiste
  if [ ! -d "$module_dir" ]; then
    log "ERROR" "Il modulo $module_name non esiste"
    return 1
  fi
  
  # Crea la struttura standard della documentazione
  create_standard_doc_structure "$module_name"
  
  # Aggiorna la documentazione PHPStan
  if [ -f "$module_dir/phpstan.neon" ] || [ -f "$module_dir/phpstan.neon.dist" ]; then
    local phpstan_file=""
    if [ -f "$module_dir/phpstan.neon" ]; then
      phpstan_file="$module_dir/phpstan.neon"
    else
      phpstan_file="$module_dir/phpstan.neon.dist"
    fi
    
    # Estrai il livello PHPStan dal file di configurazione
    local phpstan_level=$(grep -o "level: [0-9]" "$phpstan_file" | grep -o "[0-9]")
    
    if [ -z "$phpstan_level" ]; then
      phpstan_level="N/A"
    fi
    
    # Crea o aggiorna il file di documentazione PHPStan
    cat > "$docs_dir/phpstan/configuration.md" << EOF
# Configurazione PHPStan per il modulo $module_name

## Livello attuale
Il modulo $module_name è attualmente configurato per il livello PHPStan: **$phpstan_level**

## File di configurazione
\`\`\`
$(cat "$phpstan_file")
\`\`\`

## Regole personalizzate
Elenco delle regole personalizzate per questo modulo.

## Problemi noti
Elenco dei problemi noti e delle soluzioni.

## Obiettivi
- Raggiungere il livello 5 entro la prossima release
- Raggiungere il livello 9 come obiettivo finale
EOF
    log "SUCCESS" "Aggiornata documentazione PHPStan per il modulo $module_name"
  fi
  
  # Aggiorna la documentazione dell'architettura
  cat > "$docs_dir/architecture/overview.md" << EOF
# Architettura del modulo $module_name

## Struttura generale
\`\`\`
$(find "$module_dir" -type d -not -path "*/vendor/*" -not -path "*/node_modules/*" -not -path "*/.git/*" | sort | sed "s|$module_dir||" | sed 's/^/- /')
\`\`\`

## Componenti principali
Descrizione dei componenti principali del modulo.

## Relazioni con altri moduli
Elenco delle dipendenze e relazioni con altri moduli.

## Diagramma di flusso
Diagramma di flusso delle principali funzionalità.

## Pattern utilizzati
Elenco dei pattern di design utilizzati nel modulo.
EOF
  log "SUCCESS" "Aggiornata documentazione dell'architettura per il modulo $module_name"
  
  # Aggiorna la documentazione Filament
  if [ -d "$module_dir/Filament" ] || [ -d "$module_dir/filament" ]; then
    cat > "$docs_dir/filament/components.md" << EOF
# Componenti Filament per il modulo $module_name

## Risorse
Elenco delle risorse Filament definite nel modulo.

## Widget
Elenco dei widget Filament definiti nel modulo.

## Form
Elenco dei form Filament definiti nel modulo.

## Table
Elenco delle tabelle Filament definite nel modulo.

## Best practices
- Utilizzare i contratti e le interfacce per il disaccoppiamento
- Seguire le convenzioni di naming di Filament
- Implementare correttamente le azioni e i form
- Testare l'interfaccia utente dopo le modifiche
EOF
    log "SUCCESS" "Aggiornata documentazione Filament per il modulo $module_name"
  fi
  
  # Aggiorna la documentazione delle best practices
  cat > "$docs_dir/best-practices/coding-standards.md" << EOF
# Standard di codifica per il modulo $module_name

## PSR-12
Seguire lo standard PSR-12 per la formattazione del codice.

## Tipizzazione
- Utilizzare strict_types=1 in tutti i file PHP
- Fornire tipizzazione completa per tutti i metodi e le proprietà
- Utilizzare typed properties in PHP 8.0+
- Preferire named arguments per i metodi con molti parametri

## Documentazione
- Documentare le classi e i metodi con DocBlocks completi
- Includere esempi di utilizzo per le API pubbliche
- Utilizzare il formato Markdown per tutta la documentazione

## Testing
- Scrivere test per tutte le nuove funzionalità
- Assicurarsi che i test esistenti passino dopo le modifiche
- Utilizzare mocking appropriato per isolare i componenti durante i test

## Sicurezza
- Validare tutti gli input utente
- Utilizzare prepared statements per le query SQL
- Implementare controlli di autorizzazione appropriati
EOF
  log "SUCCESS" "Aggiornata documentazione delle best practices per il modulo $module_name"
  
  # Aggiorna la documentazione di sviluppo
  cat > "$docs_dir/development/getting-started.md" << EOF
# Guida introduttiva per il modulo $module_name

## Prerequisiti
Elenco dei prerequisiti per lo sviluppo del modulo.

## Installazione
Istruzioni per l'installazione del modulo.

## Configurazione
Istruzioni per la configurazione del modulo.

## Sviluppo
Guida allo sviluppo del modulo.

## Testing
Istruzioni per il testing del modulo.

## Deployment
Istruzioni per il deployment del modulo.
EOF
  log "SUCCESS" "Aggiornata documentazione di sviluppo per il modulo $module_name"
  
  # Aggiorna la documentazione di testing
  cat > "$docs_dir/testing/strategy.md" << EOF
# Strategia di testing per il modulo $module_name

## Unit Testing
Descrizione della strategia di unit testing.

## Integration Testing
Descrizione della strategia di integration testing.

## End-to-End Testing
Descrizione della strategia di end-to-end testing.

## Mocking
Descrizione della strategia di mocking.

## Coverage
Obiettivi di coverage per il modulo.
EOF
  log "SUCCESS" "Aggiornata documentazione di testing per il modulo $module_name"
  
  return 0
}

# Funzione per aggiornare la documentazione di tutti i moduli
update_all_modules_documentation() {
  local modules_dir="/var/www/_bases/base_predict_fila4_mono/laravel/Modules"
  local modules=$(find "$modules_dir" -maxdepth 1 -type d -not -path "$modules_dir" | sort)
  
  log "INFO" "Aggiornamento documentazione per tutti i moduli..."
  
  for module_dir in $modules; do
    local module_name=$(basename "$module_dir")
    update_module_documentation "$module_name"
  done
  
  log "SUCCESS" "Documentazione aggiornata per tutti i moduli"
}

# Funzione per aggiornare la documentazione dei moduli principali
update_main_modules_documentation() {
  local main_modules=("Predict" "User" "Xot" "UI" "Tenant")
  
  log "INFO" "Aggiornamento documentazione per i moduli principali..."
  
  for module_name in "${main_modules[@]}"; do
    update_module_documentation "$module_name"
  done
  
  log "SUCCESS" "Documentazione aggiornata per i moduli principali"
}

# Menu principale
echo -e "${CYAN}=== Aggiornamento Documentazione Moduli ===${NC}"
echo "1. Aggiorna documentazione di un modulo specifico"
echo "2. Aggiorna documentazione dei moduli principali"
echo "3. Aggiorna documentazione di tutti i moduli"
echo "4. Esci"

read -p "Seleziona un'opzione (1-4): " option

case $option in
  1)
    read -p "Inserisci il nome del modulo: " module_name
    update_module_documentation "$module_name"
    ;;
  2)
    update_main_modules_documentation
    ;;
  3)
    update_all_modules_documentation
    ;;
  4)
    log "INFO" "Uscita..."
    exit 0
    ;;
  *)
    log "ERROR" "Opzione non valida"
    exit 1
    ;;
esac

log "SUCCESS" "Operazione completata con successo"
exit 0
