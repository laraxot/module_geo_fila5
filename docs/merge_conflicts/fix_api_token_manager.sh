#!/bin/bash

# Script per risolvere i conflitti di merge in api-token-manager.blade.php
# Autore: Cascade
# Data: 2025-09-22

FILE_PATH="/var/www/_bases/base_predict_fila4_mono/laravel/Themes/Sixteen/resources/views/api/api-token-manager.blade.php"

# Verifica che il file esista
if [ ! -f "$FILE_PATH" ]; then
    echo "Errore: File $FILE_PATH non trovato."
    exit 1
fi

# Crea un backup del file originale
cp "$FILE_PATH" "${FILE_PATH}.bak"
echo "Backup creato in ${FILE_PATH}.bak"

# Risolvi i conflitti scegliendo la versione più recente (quella di c8b07ab e 0eb3291)
# Questo script sostituisce i componenti personalizzati con quelli standard di Jetstream

# Crea un file temporaneo per la sostituzione
TMP_FILE=$(mktemp)

# Rimuovi i marker di conflitto e scegli le versioni corrette
cat "$FILE_PATH" | awk '
BEGIN { printing = 1; }
/^>>>>>>> c8b07ab \(.\)$/ { next; }
/^=======$/      { next; }
/^>>>>>>> 0eb3291 \(.\)$/ { printing = 1; next; }
printing         { print; }
' > "$TMP_FILE"

# Sostituisci il file originale con quello modificato
mv "$TMP_FILE" "$FILE_PATH"

echo "Conflitti risolti in $FILE_PATH"

# Verifica che non ci siano più marker di conflitto
