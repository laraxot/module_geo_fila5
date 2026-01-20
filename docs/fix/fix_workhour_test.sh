#!/bin/bash

# Script per pulire il file WorkHourTest.php
FILE="/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Employee/tests/Unit/Models/WorkHourTest.php"

echo "🔧 Pulizia file WorkHourTest.php..."

# Rimuovi duplicazioni e linee problematiche
sed -i '/^$/N;/^\n$/d' "$FILE"  # Rimuovi linee vuote multiple
sed -i '/^    $/d' "$FILE"      # Rimuovi linee vuote con solo spazi
sed -i '/^    \(.*\)\n    \1$/!b;N;s/^\(    .*\)\n\1$/\1/' "$FILE"  # Rimuovi duplicazioni

# Trova e rimuovi pattern duplicati specifici
sed -i '/^    \$clockIns = WorkHour::ofType.*$/{N;/\n.*\$clockIns = WorkHour::ofType/d;}' "$FILE"
sed -i '/^    \$clockOuts = WorkHour::ofType.*$/{N;/\n.*\$clockOuts = WorkHour::ofType/d;}' "$FILE"

echo "✅ Pulizia completata"
php -l "$FILE"