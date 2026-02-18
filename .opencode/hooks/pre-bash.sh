#!/bin/bash

# Hook pre-bash per OpenCode
# Eseguito prima dell'esecuzione comandi bash

COMMAND="$1"
AGENT_NAME="$2"

echo "=== OpenCode Pre-Bash Hook ==="
echo "Command: $COMMAND"
echo "Agent: $AGENT_NAME"

# Sicurezza: verifica comandi pericolosi
if [[ "$COMMAND" == *"rm -rf /"* ]] || [[ "$COMMAND" == *"sudo rm"* ]]; then
    echo "WARNING: Comando potenzialmente pericoloso rilevato"
    echo "Continuare? (y/N)"
    read -r response
    if [[ "$response" != "y" ]]; then
        exit 1
    fi
fi

# Log comando
echo "$(date): $AGENT_NAME executed: $COMMAND" >> .opencode/command-log.txt

# Prepara ambiente se necessario
if [[ "$COMMAND" == *"php artisan migrate"* ]]; then
    echo "Preparando ambiente per migrazione..."
    php artisan config:cache 2>/dev/null || true
fi

exit 0