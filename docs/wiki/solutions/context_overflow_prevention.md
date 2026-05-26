# Prevenzione dell'autocompact thrashing in Claude Code

## Cause principali

1. **Letture di file troppo grandi**  
   - `Read` senza `offset`/`limit` restituisce l'intero file, spesso superando i 200 KB di token.  
   - Output di tool (git diff, stacktrace, logs) non filtrati generano centinaia di righe.

2. **Uso intensivo di `ctx_batch_execute`**  
   - Esecuzione di molti comandi con output voluminoso riempie il contesto rapidamente.  
   - Concurrency non controllata può sovraccaricare il buffer.

3. **Operazioni atomiche non suddivise**  
   - Un’unica operazione che modifica molti file o esegue grandi migrazioni genera un diff enorme, provocando un singolo blocco di token.

## Soluzioni definitive

### 1. Lettura a “pezzetti” controllati
- **`Read` con offset/limit**: limita il numero di linee lette.  
  ```bash
  Read path/to/file.txt offset:0 limit:5000   # 5 KB ≈ 3000 token
  ```
- **`smart_read`**: usa `mcp__plugin_context-mode_context-mode__ctx_execute_file` per leggere solo la sezione interessata (es. 10‑20 linee intorno a un errore).

### 2. Riduzione dell’output dei tool
- **`smart_diff`**: invece di `git diff` completo, usa `mcp__plugin_context-mode_context-mode__smart_diff` con `summaryOnly:true` per ottenere solo i file modificati.  
- **`tail -n` / `grep`**: limita le linee di log prima di passarle a Claude.  
- **`grep --line-buffered`**: evita buffer infiniti su log infiniti.

### 3. Controllo della concurrency e del batch
- **`ctx_batch_execute` con `concurrency: 1`** quando si lavora su file condivisi o su operazioni che dipendono l’una dall’altra.  
- **`maxLines`** nei comandi Bash per limitare il numero di linee prodotte (es. `git diff --stat | head -n 20`).

### 4. Suddivisione atomica delle operazioni
- **Commit singolo per operazione** → git garantisce un diff piccolo e ben definito.  
- **TaskCreate** per spezzare un grande refactoring in più sotto‑task, ciascuno con il proprio commit.  
- **Non usare `git add -A`**; aggiungi solo i file strettamente necessari.

### 5. Monitoraggio proattivo
- **`mcp__plugin_context-mode_context-mode__ctx_stats`**: controlla il token usage prima di ogni operazione.  
- **`ctx-stats`** in CLI: se il “bytes returned to context” si avvicina al limite, interrompi e riavvia con `/clear` o riduci l’output.

### 6. Configurazione di sicurezza (opzionale)
- Aggiungi in `.claude/settings.json`:
  ```json
  {
    "maxContextTokens": 180000,
    "autoCompactOnOverflow": false
  }
  ```
  Questo impedisce il compact automatico troppo frequente e permette di gestire manualmente il clearing.

## Best practice da documentare

- **Always prefer `smart_read`/`ctx_execute_file` over raw `Read`** for large source files.  
- **Limit Git diffs** to changed file names or statistics unless a full diff is required.  
- **Batch commands** should be scoped to ≤ 10 KB of output; otherwise split the task.  
- **Use `/clear`** immediately after a compact that refilled the context within 3 turns – indica thrashing imminente.  
- **Log the solution** in `docs/wiki/solutions/context_overflow_prevention.md` for reference by the team.

## Dove collocarli

Tutte le linee guida sopra vanno aggiunte:
- **`docs/wiki/solutions/`** – per la documentazione technique di prevenzione.  
- **`docs/wiki/memories/`** – per eventuali ricordi di configurazione di squadra.  
- **`docs/wiki/rules/00-TRIGGER_MAP.md`** – per collegare il pattern a trigger specifici (es. “autocompact_thrashing”).  

Aggiornare il file `docs/wiki/solutions/context_overflow_prevention.md` con questa guida e creare un collegamento da `docs/wiki/trigger/autocompact_thrashing.md` (se esiste) per richiamarla automaticamente quando il system‑reminder di overflow appare.