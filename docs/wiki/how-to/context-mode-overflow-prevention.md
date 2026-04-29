---
name: Context-Mode Overflow Prevention
description: Come usare context-mode correttamente per non esaurire token
type: guide
---

# Context-Mode Overflow Prevention

**Problem:** Ricevi "This endpoint's maximum context length is 262144 tokens" anche dopo `/clear`.

**Root Cause:** Sistema + istruzioni di progetto sono molto pesanti (~168 KB). Devi processare in sandbox, non in context.

## Golden Rules

### 1️⃣ Usa `ctx_batch_execute` per elaborazioni complesse
```bash
# ✅ BUONO: tutto il processing rimane in sandbox
/ctx-batch-execute \
  commands: [
    {label: "find large files", command: "find . -size +1M"}
  ] \
  queries: ["quali file > 1MB", "spazio disco"]
```

```bash
# ❌ SBAGLIATO: Read + processo manualmente
Read "file.log"
→ [168 KB file entra in context]
```

### 2️⃣ Sempre setta `intent` su `ctx_execute`
```bash
# ✅ BUONO: output viene filtrato semanticamente
/ctx_execute_file path:log.txt intent:"error lines"

# ❌ SBAGLIATO: output grezzo entra in context
cat log.txt → [32 KB raw output]
```

### 3️⃣ Non indicizzare output di tool
```bash
# ✅ BUONO: indicizza solo documentazione
/ctx-index path:docs/wiki/ source:"Activity Module Docs"

# ❌ SBAGLIATO: indicizza git output
git log | /ctx-index → [10 KB log entries in KB]
```

### 4️⃣ Usa `ctx_search` per ricordare lavoro precedente
```bash
# ✅ BUONO: recupera solo quello che serve
/ctx_search queries: ["activity pattern", "event tracking"]
→ [2 KB summaries]

# ❌ SBAGLIATO: Read vecchi file dalla sessione
Read previous-session-notes.md → [full old context]
```

## Workflow Ottimizzato

### Research (wikification)
```
1. qmd query "topic"          → cerca wiki esistente
2. ctx_batch_execute ...      → ricerca (processing in sandbox)
3. ctx_search "findings"      → retrieval da precedenti
4. Write docs/wiki/X.md       → documenta (usa file, non context)
5. ctx_index docs/wiki/       → rendi searchable
```

### Implementation
```
1. Read file.php              → [solo files che modifichi]
2. Edit file.php              → scrivi cambio
3. Bash test.sh               → [no Bash per output >20 linee]
4. Don't index raw code       → [documentazione yes, codice no]
```

### Debugging
```
1. ctx_batch_execute commands → [analizza in sandbox con intent]
2. ctx_search patterns        → [cerca pattern documentati]
3. Don't Read logs            → [usa ctx_execute_file + intent]
```

## Checklist: Prima di Ogni Richiesta

- [ ] **Bash/Read?** → Solo se <20 linee output. Altrimenti `ctx_execute`
- [ ] **File grande?** → Usa `ctx_execute_file` + `intent`
- [ ] **Molti tool calls?** → Usa `ctx_batch_execute` (one call, many commands)
- [ ] **Cacheability?** → Se riusabile, scrivi in `docs/wiki/`, non context
- [ ] **Session later?** → Usa `Write` + wiki, non chat context

## Configuration

Vedi `.context-mode.json` per policy completa:
```bash
cat .context-mode.json
```

Key settings:
- `max_output_lines`: 100 per batch, 50 per single (rest stays in sandbox)
- `index_only_docs`: true (solo documentazione, no raw outputs)
- `auto_purge_old_sessions`: true (pulisce session vecchie)

## Quando Purgare di Nuovo

Se ancora ricevi overflow:
```bash
/ctx-purge   # Warn: cancella tutto il knowledge base
# Dopo: ricomancia fresco
```

Poi:
```bash
# Indicizza SOLO quello che serve
/ctx-index path:docs/wiki/ source:"Essential Docs"
/ctx-index path:laravel/Modules/Activity/docs/wiki/ source:"Activity Module"
```

## Maintenance Cadence

- **Daily:** Usa `ctx_batch_execute` per elaborate tasks
- **Weekly:** Controlli `ctx_stats` (se >100 KB context, pulisci)
- **Monthly:** `ctx_doctor` + verifica health

---

**Last Updated:** 2026-04-29
**Applies to:** All agents using this repository
