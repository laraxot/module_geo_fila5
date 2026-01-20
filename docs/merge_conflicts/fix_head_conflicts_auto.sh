#!/bin/bash

# Script per risolvere automaticamente i conflitti di merge
# Mantiene la versione più recente (quella dopo =======)
# Autore: Cascade AI
# Data: $(date +%Y-%m-%d)
# Versione: 1.0

echo "Ricerca di file con conflitti di merge..."

# Trova tutti i file con conflitti di merge
      SKIP_LINES=0
      continue
    fi
    
    # Se troviamo la fine di un conflitto
    if [[ "$LINE" == *">>>>>>>"* ]] && [ $IN_CONFLICT -eq 1 ]; then
      IN_CONFLICT=0
      continue
    fi
    
    # Se non siamo in un conflitto o se siamo nella parte da mantenere
    if [ $IN_CONFLICT -eq 0 ] || [ $SKIP_LINES -eq 0 ]; then
      echo "$LINE" >> "$TMP_FILE"
    fi
  done < "$FILE"
  
  # Verifica che il file temporaneo esista e non sia vuoto
  if [ -s "$TMP_FILE" ]; then
    # Sostituisci il file originale con quello modificato
    cp "$TMP_FILE" "$FILE"
    echo "[$FILE] Risolti $CONFLICTS_IN_FILE conflitti" >> "$LOG_FILE"
    PROCESSED=$((PROCESSED+1))
    echo "Risolto $FILE ($PROCESSED file elaborati, $CONFLICTS_IN_FILE conflitti)"
  else
    echo "[$FILE] ERRORE: File temporaneo vuoto o non creato" >> "$LOG_FILE"
    FAILED=$((FAILED+1))
    echo "ERRORE durante l'elaborazione di $FILE"
  fi
  
  # Rimuovi il file temporaneo
  rm -f "$TMP_FILE"
done

echo "Completato! Risolti $PROCESSED file con conflitti. Falliti: $FAILED"
echo "Log delle operazioni salvato in: $LOG_FILE"

# Aggiungi informazioni finali al log
echo "----------------------------------------" >> "$LOG_FILE"
echo "Operazione completata il $(date)" >> "$LOG_FILE"
echo "File elaborati con successo: $PROCESSED" >> "$LOG_FILE"
echo "File falliti: $FAILED" >> "$LOG_FILE"
echo "----------------------------------------" >> "$LOG_FILE"
