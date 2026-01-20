#!/bin/bash

# Script per risolvere automaticamente i conflitti Git con <git marker>
# Mantiene solo la "current change" (la versione dopo il merge)
# Aggiornato per il progetto Predict Fila4 Mono

echo "🔧 Risoluzione automatica conflitti Git con <git marker>..."
echo "📁 Directory di lavoro: $(pwd)"
echo ""

# Trova tutti i file con conflitti <git marker>

if [ -z "$CONFLICT_FILES" ]; then
    echo "✅ Nessun conflitto <git marker> trovato!"
    exit 0
fi

echo "📋 File con conflitti <git marker> trovati:"
echo "$CONFLICT_FILES" | head -20
if [ $(echo "$CONFLICT_FILES" | wc -l) -gt 20 ]; then
    echo "... (e altri $(($(echo "$CONFLICT_FILES" | wc -l) - 20)) file)"
fi
echo ""

# Contatore
count=0
total=$(echo "$CONFLICT_FILES" | wc -l)

for file in $CONFLICT_FILES; do
    count=$((count + 1))
    echo "[$count/$total] 🔧 Risolvendo: $file"

    # Backup del file originale
    backup_file="$file.backup.$(date +%Y%m%d_%H%M%S)"
    cp "$file" "$backup_file"

        in_conflict = 1
        keep_lines = 0
        next
    }
        if (in_conflict) {
            in_conflict = 0
            keep_lines = 0
        }
        next
    }
    {
        if (!in_conflict) {
            print $0
        } else if (keep_lines) {
            print $0
        }
    }
    ' "$file" > "$file.tmp"

    # Sostituisci il file originale
    if [ $? -eq 0 ]; then
        mv "$file.tmp" "$file"
        echo "   ✅ Completato: mantenuta current change"
    else
        echo "   ❌ Errore durante l'elaborazione"
        rm -f "$file.tmp"
    fi

done

echo ""
echo "🎉 Risoluzione completata!"
echo "📊 File processati: $total"
echo ""
echo "⚠️  IMPORTANTE:"
echo "   - I backup sono stati creati con estensione .backup.YYYYMMDD_HHMMSS"
echo "   - Verifica manualmente i file modificati prima di committare!"
echo "   - Usa 'git diff' per controllare le modifiche"
echo "   - Elimina i backup una volta verificato che tutto funzioni correttamente"
echo ""
echo "💡 Consiglio: Esegui 'git status' per vedere lo stato corrente"
