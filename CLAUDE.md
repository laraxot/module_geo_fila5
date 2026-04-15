# Claude Context Central

Primary context loader for the **Claude** AI agent.

## 🔗 Shared Mandates (SOLID)
Every agent MUST follow the standards in `.agents/docs/ai-agents/shared/`:
- [[Core Mandates]]: R-R-S-U sequence and quality gates.
- [[LLM Wiki Mandate]]: Karpathy pattern and QMD search.
- [[Directory Standards]]: Organization and naming.
- [[GSD & BMAD Methodologies]]: Development frameworks.

---

## Mandate: LLM Wiki

Every agent MUST follow the Karpathy LLM Wiki pattern:

1. **Prima di qualsiasi task**: `qmd query "topic"` per verificare la conoscenza esistente
2. **Dopo la ricerca**: compilare i risultati in `docs/wiki/` del modulo rilevante
3. **Dopo l'implementazione**: aggiornare le pagine entity/concept per il codice modificato
4. **Non lasciare mai i risultati solo nella chat di sessione** — devono essere scritti nel wiki

### Wiki-First Workflow
```
START task
  → qmd query "relevant topic"           # verifica conoscenza esistente
  → leggi pagine wiki se trovate
  → esegui il lavoro
  → scrivi/aggiorna pages docs/wiki/     # persisti nuova conoscenza
  → aggiorna docs/wiki/index.md          # mantieni catalogo aggiornato
  → appendi a docs/wiki/log.md           # registra l'operazione
END
```

### Directory Map
| Scopo | Path |
|---|---|
| Raw docs modulo | `laravel/Modules/{Module}/docs/` |
| Wiki modulo | `laravel/Modules/{Module}/docs/wiki/` |
| Raw docs tema | `laravel/Themes/{Theme}/docs/` |
| Wiki tema | `laravel/Themes/{Theme}/docs/wiki/` |
| Wiki bashscripts | `bashscripts/docs/wiki/` |
| Wiki progetto (root) | `docs/wiki/` |

### QMD Tools Disponibili
- `mcp__plugin_qmd_qmd__query` — ricerca semantica + keyword su tutte le collezioni
- `mcp__plugin_qmd_qmd__get` — ottieni documento specifico
- `mcp__plugin_qmd_qmd__multi_get` — ottieni più documenti
- `mcp__plugin_qmd_qmd__status` — verifica stato collezione
