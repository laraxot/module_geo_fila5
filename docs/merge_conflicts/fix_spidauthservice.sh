#!/bin/bash

# Script per risolvere i conflitti di merge in SpidAuthService.php
# Autore: Cascade
# Data: 2025-09-22

FILE_PATH="/var/www/_bases/base_predict_fila4_mono/laravel/Themes/Sixteen/src/Services/SpidAuthService.php"

# Verifica che il file esista
if [ ! -f "$FILE_PATH" ]; then
    echo "Errore: File $FILE_PATH non trovato."
    exit 1
fi

# Crea un backup del file originale
cp "$FILE_PATH" "${FILE_PATH}.bak"
echo "Backup creato in ${FILE_PATH}.bak"

# Risolvi i conflitti scegliendo la versione con namespace completo (\Exception, \InvalidArgumentException, ecc.)
sed -i '
    # Rimuovi i marker di conflitto e scegli la versione con namespace completo
        /^>>>>>>> c8b07ab \(.\)$/d
        /^=======$/d
        /^>>>>>>> 0eb3291 \(.\)$/d
        /^use InvalidArgumentException;$/d
        /^use Exception;$/d
        /^use DOMDocument;$/d
        /^use DOMXPath;$/d
        s/throw new InvalidArgumentException/throw new \\InvalidArgumentException/g
        s/throw new Exception/throw new \\Exception/g
        s/new DOMDocument/new \\DOMDocument/g
        s/new DOMXPath/new \\DOMXPath/g
        s/DOMDocument \$responseDoc/\\DOMDocument \$responseDoc/g
        s/DOMXPath\(/\\DOMXPath\(/g
    }
' "$FILE_PATH"

echo "Conflitti risolti in $FILE_PATH"

# Verifica che non ci siano più marker di conflitto
