#!/bin/bash

# Script per risolvere automaticamente i conflitti Filament 4
# Sostituisce Schema con Form e aggiorna i metodi correlati

echo "🔧 Risoluzione automatica conflitti Filament 4..."

# Funzione per processare un file
process_file() {
    local file="$1"
    echo "📝 Processando: $file"
    
    # Backup del file originale
    cp "$file" "$file.backup"
    
    # Sostituzioni automatiche
    sed -i 's/use Filament\\Schemas\\Schema;/use Filament\\Forms\\Form;/g' "$file"
    sed -i 's/use Filament\\Schemas\\Components\\Component;/use Filament\\Forms\\Components\\Component;/g' "$file"
    sed -i 's/use Filament\\Schemas\\Components\\Section;/use Filament\\Forms\\Components\\Section;/g' "$file"
    sed -i 's/use Filament\\Schemas\\Components\\Utilities\\Set;/use Filament\\Forms\\Set;/g' "$file"
    
    # Rimuove i marker di conflitto per Schema/Form
        />>>>>>> [a-f0-9]* (\.)/d
    }' "$file"
    
    # Aggiorna PHPDoc
    sed -i 's/@property Schema \$form/@property Form \$form/g' "$file"
    sed -i 's/@param Schema/@param Form/g' "$file"
    sed -i 's/@return Schema/@return Form/g' "$file"
    
    # Aggiorna type hints nei metodi
    sed -i 's/public function form(Schema \$schema): Schema/public function form(Form \$form): Form/g' "$file"
    sed -i 's/return \$schema->components(/return \$form->schema(/g' "$file"
    sed -i 's/return \$schema->statePath(/return \$form->statePath(/g' "$file"
    sed -i 's/return \$schema->model(/return \$form->model(/g' "$file"
    
    echo "✅ Completato: $file"
}

# Trova tutti i file PHP con conflitti
find /var/www/_bases/base_quaeris_fila4_mono/laravel/Modules -name "*.php" -type f | while read -r file; do
