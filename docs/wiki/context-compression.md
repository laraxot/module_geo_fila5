# Gestione della Compressione del Contesto

## Problema originale
L'errore **API Error 400 – maximum context length** si verificava quando il contesto superava i **262.144 token** (circa 419.418 token). Questo blocca le operazioni di compattazione e compromette la produttività.

## Soluzione definitiva
1. **Purge del contesto** (`ctx-purge --force`)
   - Elimina memorie e dati di sessione non più necessari.
2. **Upgrade di Context‑Mode** (`ctx-upgrade`)
   - Aggiorna alla versione **v1.0.121** con ottimizzazioni di compressione integrate.
3. **Verifica dello stato** (`ctx-stats`)
   - Controlla il consumo di token e le categorie più pesanti.
4. **Limitare la lettura dei file**
   - Utilizzare i parametri `limit` e `offset` di `Read` per leggere solo le parti necessarie.
5. **Configurazione in `settings.json`**
   ```json
   {
     "context_limit": 262144,
     "plugins": {
       "enabled": true,
       "context-compression": {
         "enabled": true,
         "strategy": "gzip",
         "exclude_tokens": ["memories.user_history", "feedback_llmwiki_mandatory.md"]
       }
     }
   }
   ```
6. **Aggiornamento regolare**
   - Eseguire periodicamente `ctx-purge` e controllare `ctx-stats` per mantenere il contesto entro i limiti.

## Documentazione nei Moduli e nei Temi
Per ciascun modulo e tema, aggiungere una sezione "Gestione del Contesto" che riporta:
- Il limite di token configurato.
- Eventuali esclusioni specifiche.
- I comandi consigliati per la pulizia (`ctx-purge`) e l'upgrade (`ctx-upgrade`).

> **Nota:** Dopo l'upgrade, è necessario **riavviare la sessione Claude Code** per caricare la nuova versione.

---
*Documento generato automaticamente da Claude Code dopo l'applicazione delle correzioni.*