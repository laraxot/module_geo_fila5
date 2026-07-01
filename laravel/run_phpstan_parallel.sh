#!/usr/bin/env bash
# Esegui PHPStan su tutti i moduli (esclusi Incentivi e Pdnd), in modo paralelizzato.
# Uso:
#   ./run_phpstan_parallel.sh               # tutti i moduli
#   ./run_phpstan_parallel.sh Modules/Job   # singolo modulo
set -euo pipefail

cd /var/www/_bases/base_ptvx_fila5/laravel

# Limite di processi concorrenti per evitare problemi di memoria
MAX_JOBS=4

PHPSTAN="php -d memory_limit=512M ./vendor/bin/phpstan analyse --memory-limit=512M --no-progress"

if [ -n "${1:-}" ]; then
    echo "=== PHPStan: $1 ==="
    $PHPSTAN "$1"
    exit $?
fi

ERRORS=()

run_phpstan() {
    local dir_path="$1"
    local module_name
    module_name=$(basename "$dir_path")
    echo ""
    echo "=== PHPStan: $module_name ==="
    if ! $PHPSTAN "$dir_path"; then
        echo "⚠️  $module_name ha prodotto errori" >&2
        ERRORS+=("$module_name")
    fi
}

running_jobs=0

for dir in Modules/*/; do
    module=$(basename "$dir")
    [[ "$module" == "Incentivi" || "$module" == "Pdnd" ]] && continue

    run_phpstan "$dir" &
    ((running_jobs++))

    while [[ $(jobs -rp | wc -l) -ge $MAX_JOBS ]]; do
        wait -n
    done
done

wait

echo ""
if [ ${#ERRORS[@]} -eq 0 ]; then
    echo "✅ Tutti i moduli: nessun errore"
else
    echo "❌ Moduli con errori: ${ERRORS[*]}"
    exit 1
fi