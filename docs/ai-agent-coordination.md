# AI Agent Coordination Hub

> **Central Coordination Document for Multiple AI Agents**
> 
> **Purpose:** Evitare duplicazioni e conflitti quando múltiples agenti AI lavorano sullo stesso progetto
> 
> **Status:** Active
> 
> **Last Updated:** 2026-03-13

---

## Principi di Coordinamento

### 1. Single Source of Truth

Tutti gli agenti AI devono:
- ✅ Leggere questo documento prima di agire
- ✅ Aggiornare questo documento dopo azioni significative
- ✅ Coordinarsi tramite GitHub Issues/Discussions

### 2. Divisione dei Compiti

| Area | Responsabile | Status | Notes |
|------|-------------|--------|-------|
| Apache Fix | Agent 1 | ✅ Completed | Virtual host rimosso |
| Ollama Optimization | Agent 2 | ✅ Completed | Script creato |
| Documentation | Agent 3 | 🟡 In Progress | Docs in corso |
| Testing | Agent 4 | ⏳ Pending | Da iniziare |

### 3. Comunicazione

**Canali Preferiti:**
1. GitHub Issues - Per task specifici
2. GitHub Discussions - Per decisioni architetturali
3. Questo documento - Per coordinamento immediato

---

## Task Attivi

### Task #1: Apache2 Fix ✅

**Status:** COMPLETED

**Agent:** Any

**Azioni Intraprese:**
```bash
# Rimosso virtual host rotto
rm -f /etc/apache2/sites-enabled/quaeris.local.conf

# Verificato configurazione
apache2ctl configtest  # Syntax OK

# Riavviato Apache
sudo systemctl restart apache2
```

**Risultato:** Apache2 attivo e funzionante

---

### Task #2: Ollama Optimization ✅

**Status:** COMPLETED

**Agent:** Any

**Azioni Intraprese:**
```bash
# Creato script di ottimizzazione
touch bashscripts/ollama-optimize.sh
chmod +x bashscripts/ollama-optimize.sh

# Documentato
touch bashscripts/docs/ollama-optimize.md
```

**Risultato:** Script funzionante e documentato

---

### Task #3: Script Organization 🟡

**Status:** IN PROGRESS

**Agent:** Current Agent

**Regola:**
> Tutti gli script `.sh` devono essere in `bashscripts/` e documentati in `bashscripts/docs/`

**Azioni Richieste:**
- [x] Spostare eventuali script in root verso `bashscripts/`
- [x] Creare documentazione in `bashscripts/docs/`
- [ ] Verificare tutti i moduli
- [ ] Aggiornare AGENTS.md

---

### Task #4: Documentation Cleanup ⏳

**Status:** PENDING

**Agent:** Next Available

**Descrizione:**
Pulizia e organizzazione documentazione in tutti i moduli

**Azioni Richieste:**
- [ ] Identificare documentazione duplicata
- [ ] Rimuovere docs obsolete
- [ ] Standardizzare naming
- [ ] Aggiornare indici

---

## Conflitti Evitati

### Conflitto #1: Script Position

**Potenziale Conflitto:** Script `.sh` creati in locazioni sbagliate

**Soluzione:**
```markdown
REGOLA: Tutti gli script .sh devono essere in:
- bashscripts/ (script principali)
- bashscripts/docs/ (documentazione)
- Modules/*/bashscripts/ (script specifici per modulo)

MAI creare script .sh in:
- Root del modulo
- app/
- config/
```

---

## Linee Guida per AI Agents

### Prima di Agire

1. **Leggi questo documento**
   ```bash
   cat docs/ai-agent-coordination.md
   ```

2. **Verifica task in corso**
   ```bash
   git status
   git log --oneline -10
   ```

3. **Controlla GitHub Issues**
   ```bash
   gh issue list
   ```

### Durante l'Azione

1. **Documenta nel commit**
   ```bash
   git commit -m "[AI-Agent] Description of changes

   Coordinated via: docs/ai-agent-coordination.md
   Related issue: #123"
   ```

2. **Usa branch separati**
   ```bash
   git checkout -b ai-agent/task-name
   ```

### Dopo l'Azione

1. **Aggiorna questo documento**
   - Segna task come completato
   - Aggiungi note

2. **Crea/Aggiorna GitHub Issue**
   ```bash
   gh issue create --title "[AI-Agent] Task completed"
   ```

3. **Notifica altri agenti**
   - Lascia commento in questo documento
   - Usa @mentions se necessario

---

## Script e Tool per AI Agents

### Coordination Check

```bash
#!/bin/bash
# verify-coordination.sh

echo "=== AI Agent Coordination Check ==="
echo ""
echo "1. Checking for other running agents..."
ps aux | grep -i "agent\|ai\|copilot" | grep -v grep

echo ""
echo "2. Recent git activity..."
git log --oneline -5

echo ""
echo "3. Open GitHub Issues..."
gh issue list --state open

echo ""
echo "4. Current coordination doc..."
cat docs/ai-agent-coordination.md | head -50
```

### Auto-Documentation

```bash
#!/bin/bash
# auto-document-changes.sh

echo "Generating documentation for changes..."

# Find modified files
git diff --name-only HEAD~1..HEAD

# Generate markdown
cat >> docs/ai-agent-changelog.md << EOF
## $(date +%Y-%m-%d)

**Agent:** $(hostname)
**Task:** $TASK_NAME

### Files Modified
$(git diff --name-only HEAD~1..HEAD | sed 's/^/- /')

### Changes Summary
$(git diff --stat HEAD~1..HEAD)

---
EOF
```

---

## GitHub Integration

### Issue Template per AI Agents

```markdown
---
name: AI Agent Task
title: '[AI-Agent] Task description'
labels: ['ai-agent', 'task']
assignees: ''
---

## Task Description

[Describe the task]

## Agent Information

- **Agent ID:** [Agent identifier]
- **Start Time:** [Timestamp]
- **Expected Duration:** [Time estimate]

## Coordination

- [ ] Checked ai-agent-coordination.md
- [ ] No conflicting tasks in progress
- [ ] Related issues linked

## Progress

- [ ] Step 1
- [ ] Step 2
- [ ] Step 3

## Completion

- [ ] Task completed
- [ ] Documentation updated
- [ ] Tests passing
- [ ] Coordination doc updated
```

### Discussion Template

```markdown
---
title: AI Agent Architecture Decision
category: Architecture
labels: ['ai-agent', 'architecture', 'decision']
---

## Proposal

[Describe the architectural decision]

## Impact

[List affected components]

## Coordination Required

- [ ] Agent 1 approval
- [ ] Agent 2 approval
- [ ] Human review

## Decision

[Final decision and rationale]
```

---

## Best Practices

### 1. Evitare Duplicazioni

**PRIMA di creare un file:**
```bash
# Cerca file simili
find . -name "*similar*" -type f

# Verifica se esiste già funzionalità
grep -r "similar_function" .
```

### 2. Coordinamento in Tempo Reale

**Usa lock file per operazioni critiche:**
```bash
LOCKFILE="/tmp/ai-agent.lock"

if [ -f "$LOCKFILE" ]; then
    echo "Another agent is running. Waiting..."
    sleep 5
fi

touch $LOCKFILE
# Esegui operazione
rm $LOCKFILE
```

### 3. Logging Condiviso

```bash
LOGFILE="/var/log/ai-agents/$(date +%Y%m%d).log"

echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$(hostname)] Starting task: $TASK" >> $LOGFILE
# Esegui task
echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$(hostname)] Completed task: $TASK" >> $LOGFILE
```

---

## Contatti e Risorse

### Documenti Correlati

- [AGENTS.md](../../AGENTS.md)
- [Workspace Naming](conventions/workspace-naming.md)
- [Folder Structure](conventions/module-folder-structure.md)
- [Copy Files Cleanup](conventions/copy-files-cleanup.md)

### GitHub Resources

- [Issues](https://github.com/provtv/base_ptv_fila5_mono/issues)
- [Discussions](https://github.com/provtv/base_ptv_fila5_mono/discussions)
- [Pull Requests](https://github.com/provtv/base_ptv_fila5_mono/pulls)

### Human Contacts

- **Project Owner:** @username
- **Tech Lead:** @username
- **AI Coordinator:** @username

---

## Changelog

| Date | Agent | Changes |
|------|-------|---------|
| 2026-03-13 | Agent 1 | Initial version |
| 2026-03-13 | Agent 2 | Added coordination examples |
| 2026-03-13 | Current | Updated with task tracking |

---

*Documento di coordinamento - Aggiornato in tempo reale dagli agenti AI*
*Ultimo aggiornamento: 2026-03-13*
