#!/bin/bash

# Hook pre-edit per OpenCode
# Eseguito prima di ogni modifica file

FILE_PATH="$1"
AGENT_NAME="$2"

echo "=== OpenCode Pre-Edit Hook ==="
echo "File: $FILE_PATH"
echo "Agent: $AGENT_NAME"

# Backup del file se esiste
if [ -f "$FILE_PATH" ]; then
    cp "$FILE_PATH" "${FILE_PATH}.backup-$(date +%Y%m%d-%H%M%S)"
fi

# Verifica PHPStan se file PHP
if [[ "$FILE_PATH" == *.php ]]; then
    echo "Verifica PHPStan per file PHP..."
    # Esegui PHPStan solo sul file specifico
    php -d memory_limit=1G ./vendor/bin/phpstan analyse "$FILE_PATH" --level=10 --no-progress 2>/dev/null || true
fi

# Verifica traduzioni se file Filament
if [[ "$FILE_PATH" == *Resource.php ]] || [[ "$FILE_PATH" == *Page.php ]]; then
    echo "Verifica hardcoded strings in file Filament..."
    if grep -q "label(" "$FILE_PATH"; then
        echo "WARNING: Possibili hardcoded strings trovate"
    fi
fi

exit 0