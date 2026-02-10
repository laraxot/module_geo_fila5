#!/bin/bash

# Hook post-edit per OpenCode
# Eseguito dopo ogni modifica file

FILE_PATH="$1"
AGENT_NAME="$2"
STATUS="$3"

echo "=== OpenCode Post-Edit Hook ==="
echo "File: $FILE_PATH"
echo "Agent: $AGENT_NAME"
echo "Status: $STATUS"

# Log della modifica
echo "$(date): $AGENT_NAME modified $FILE_PATH ($STATUS)" >> .opencode/edit-log.txt

# Se modifica PHP e status success, esegui controlli
if [[ "$FILE_PATH" == *.php ]] && [ "$STATUS" = "success" ]; then
    echo "Eseguendo controlli post-modifica..."
    
    # Formatta codice con Pint
    if command -v ./vendor/bin/pint >/dev/null 2>&1; then
        ./vendor/bin/pint "$FILE_PATH" 2>/dev/null || true
    fi
    
    # Verifica sintassi PHP
    php -l "$FILE_PATH" || echo "WARNING: PHP syntax error detected"
fi

# Se file di traduzione, verifica coerenza
if [[ "$FILE_PATH" == */lang/**/*.php ]]; then
    echo "Verifica coerenza file traduzione..."
    # Potrebbe aggiungere script di validazione traduzioni
fi

exit 0