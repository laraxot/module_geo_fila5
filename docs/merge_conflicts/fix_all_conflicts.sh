#!/bin/bash

# Script per risolvere tutti i conflitti di merge nel progetto
# Autore: Cascade
# Data: 2025-09-22

# Directory di base del progetto
BASE_DIR="/var/www/_bases/base_predict_fila4_mono"
SCRIPTS_DIR="$BASE_DIR/bashscripts/merge_conflicts"

# Verifica che la directory degli script esista
if [ ! -d "$SCRIPTS_DIR" ]; then
    echo "Errore: Directory $SCRIPTS_DIR non trovata."
    exit 1
fi

# Rendi eseguibili tutti gli script
chmod +x "$SCRIPTS_DIR"/*.sh

# Esegui gli script specifici
echo "Esecuzione degli script specifici per la risoluzione dei conflitti..."
"$SCRIPTS_DIR/fix_spidauthservice.sh"
"$SCRIPTS_DIR/fix_api_token_manager.sh"

# Trova tutti i file con conflitti di merge rimanenti
echo -e "\nRicerca di conflitti di merge rimanenti..."
        /^>>>>>>> c8b07ab \(.\)$/ { next; }
        /^=======$/      { next; }
        /^>>>>>>> 0eb3291 \(.\)$/ { printing = 1; next; }
        printing         { print; }
        ' > "$TMP_FILE"
        
        # Sostituisci il file originale con quello modificato
        mv "$TMP_FILE" "$file"
        
        echo "Conflitti risolti in $file"
    done
else
    echo "Nessun conflitto di merge rimanente trovato."
fi

# Verifica finale
echo -e "\nVerifica finale per conflitti di merge rimanenti..."
