#!/bin/bash
cd /var/www/_bases/base_ptvx_fila5/laravel
modules=$(ls -d Modules/*/ | grep -v -E 'Incentivi|Pdnd')
echo "$modules" > modules_to_analyze.txt
while IFS= read -r dir; do
    echo "Running PHPStan on $dir"
    ./vendor/bin/phpstan analyse "$dir" --level max --error-format=json 2>&1 &
done < modules_to_analyze.txt
wait
echo "All done"