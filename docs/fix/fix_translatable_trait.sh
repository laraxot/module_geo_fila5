#!/bin/bash

# Script per commentare temporaneamente tutti gli import e usi del trait LaraZeus\SpatieTranslatable
# per compatibilità con Filament 4.x

echo "🔧 Fixing LaraZeus\SpatieTranslatable imports and usages for Filament 4.x compatibility..."

# Lista dei file che contengono riferimenti a LaraZeus\SpatieTranslatable
files=(
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseListRecords.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseCreateRecord.php"
    "Modules/Lang/app/Providers/Filament/AdminPanelProvider.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseViewRecord.php"
    "Modules/Lang/app/Filament/Resources/Pages/LangBaseEditRecord.php"
    "Modules/User/app/Filament/Resources/BaseProfileResource.php"
    "Modules/Cms/app/Providers/Filament/AdminPanelProvider.php"
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/ViewPageContent.php"
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/EditPageContent.php"
    "Modules/Cms/app/Filament/Resources/PageContentResource/Pages/CreatePageContent.php"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "📝 Processing: $file"
        
        # Commenta gli import LaraZeus\SpatieTranslatable
        sed -i 's/^use LaraZeus\\SpatieTranslatable/\/\/ use LaraZeus\\SpatieTranslatable/g' "$file"
        
        # Commenta i trait use Translatable;
        sed -i 's/^    use Translatable;/    \/\/ use Translatable; \/\/ Temporaneamente commentato per compatibilità Filament 4.x/g' "$file"
        
        # Commenta SpatieTranslatablePlugin::make() nelle configurazioni panel
        sed -i 's/SpatieTranslatablePlugin::make(),/\/\/ SpatieTranslatablePlugin::make(), \/\/ Temporaneamente commentato per compatibilità Filament 4.x/g' "$file"
        
        echo "✅ Fixed: $file"
    else
        echo "⚠️  File not found: $file"
    fi
done

echo "🎉 All LaraZeus\SpatieTranslatable references have been temporarily commented for Filament 4.x compatibility!"
echo "📝 Note: These will need to be restored when compatible packages are available."
