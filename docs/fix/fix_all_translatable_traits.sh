#!/bin/bash

# Script per commentare tutti gli usi del trait Translatable
# per compatibilità con Filament 4.x

echo "🔧 Fixing all Translatable trait usages for Filament 4.x compatibility..."

# Lista dei file PHP che usano il trait Translatable
files=(
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/ViewPageContent.php"
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/EditPageContent.php"
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/CreatePageContent.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseEditRecord.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseViewRecord.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseCreateRecord.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseListRecords.php"
    "Modules/User/app/Filament/Resources/BaseProfileResource.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "Processing: $file"
        
        # Commenta l'import del trait
        sed -i 's/use LaraZeus\\SpatieTranslatable\\Resources\\Concerns\\Translatable;/\/\/ use LaraZeus\\SpatieTranslatable\\Resources\\Concerns\\Translatable; \/\/ Temporaneamente commentato per compatibilità Filament 4.x/g' "$file"
        
        # Commenta l'uso del trait nella classe
        sed -i 's/use Translatable;/\/\/ use Translatable; \/\/ Temporaneamente commentato per compatibilità Filament 4.x/g' "$file"
        
        echo "✅ Fixed: $file"
    else
        echo "⚠️  File not found: $file"
    fi
done

echo "🎉 All Translatable trait usages have been commented out!"
echo "📝 Note: These traits will be re-enabled when LaraZeus\\SpatieTranslatable is compatible with Filament 4.x"
