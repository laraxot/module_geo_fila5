#!/bin/bash

TOTAL_ERRORS=0
ERRORS=()

for module in Modules/*/; do
    MODULE_NAME=$(basename "$module")
    echo "Analyzing: $MODULE_NAME"

    RESULT=$(./vendor/bin/phpstan analyse "$module" --memory-limit=1G 2>&1)
    ERROR_COUNT=$(echo "$RESULT" | grep -oP '\[ERROR\] Found \K\d+' | head -1)

    if [ -z "$ERROR_COUNT" ]; then
        ERROR_COUNT=0
    fi

    echo "  → $ERROR_COUNT errors"
    TOTAL_ERRORS=$((TOTAL_ERRORS + ERROR_COUNT))

    if [ "$ERROR_COUNT" -gt 0 ]; then
        ERRORS+=("$MODULE_NAME: $ERROR_COUNT")
    fi
done

echo ""
echo "========================================="
echo "Total Errors: $TOTAL_ERRORS"
echo "========================================="

for error in "${ERRORS[@]}"; do
    echo "$error"
done
