#!/bin/bash

# GSD Tool: Generate Homepage JSON Blocks
# Compares Design Comuni HTML with FixCity and generates missing blocks

set -e

DC_URL="https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html"
FIXCITY_URL="http://127.0.0.1:8000/it/tests/homepage"
JSON_FILE="laravel/config/local/fixcity/database/content/pages/tests.homepage.json"

echo "🔍 GSD Tool: Homepage Block Generator"
echo "======================================"

# Download HTML
echo "⬇️  Downloading Design Comuni HTML..."
curl -s "$DC_URL" | sed -n '/<body/,/<\/body>/p' | grep -v '<script' > /tmp/dc_homepage.html

echo "⬇️  Downloading FixCity HTML..."
curl -s "$FIXCITY_URL" | sed -n '/<body/,/<\/body>/p' | grep -v '<script' > /tmp/fixcity_homepage.html

# Count elements
echo ""
echo "📊 Analysis:"
echo "============"

DC_LINES=$(wc -l < /tmp/dc_homepage.html)
FIXCITY_LINES=$(wc -l < /tmp/fixcity_homepage.html)

echo "Design Comuni: $DC_LINES lines"
echo "FixCity:       $FIXCITY_LINES lines"
echo "Gap:           $((DC_LINES - FIXCITY_LINES)) lines"

# Check for key elements
echo ""
echo "🔍 Element Check:"
echo "================"

check_element() {
    local name=$1
    local pattern=$2
    
    DC_COUNT=$(grep -c "$pattern" /tmp/dc_homepage.html || echo "0")
    FIXCITY_COUNT=$(grep -c "$pattern" /tmp/fixcity_homepage.html || echo "0")
    
    if [ "$DC_COUNT" -gt 0 ] && [ "$FIXCITY_COUNT" -eq 0 ]; then
        echo "❌ $name: MISSING (DC has $DC_COUNT)"
    elif [ "$FIXCITY_COUNT" -ge "$DC_COUNT" ]; then
        echo "✅ $name: OK ($FIXCITY_COUNT/$DC_COUNT)"
    else
        echo "⚠️  $name: PARTIAL ($FIXCITY_COUNT/$DC_COUNT)"
    fi
}

check_element "Skip Links" "skiplink"
check_element "Header" "it-header-wrapper"
check_element "Hero" "it-hero-wrapper"
check_element "Card Teaser" "card-teaser"
check_element "Footer" "it-footer"
check_element "Rating" "cmp-rating"
check_element "Search" "cmp-input-search"

echo ""
echo "📝 JSON Update Required:"
echo "========================"

# Generate blocks to add
cat << 'EOF'
Blocks to add in tests.homepage.json:

1. Navigation block (menu principale)
2. Hero section (NOME DEL COMUNE)
3. News section (notizie complete)
4. Events section (calendario eventi)
5. Topics section (griglia argomenti)
6. Search section (cerca nel sito)
7. Feedback section (rating)

EOF

echo "✅ Tool Complete!"
