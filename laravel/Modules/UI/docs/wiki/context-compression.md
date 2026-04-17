---
name: Context Compression Setup
description: Configurazione del sistema di compressione dei prompt per ottimizzare l'uso del contesto
type: setup
---

# Context Compression Setup

## Panoramica
Il sistema di compressione dei prompt è progettato per ottimizzare l'uso del contesto in Claude Code, riducendo la dimensione dei prompt mantenendo tutte le informazioni essenziali.

## Strumenti Utilizzati

### 1. QMD per Ricerca Semantica
- **Strumento**: `mcp__plugin_qmd_qmd__query`
- **Scopo**: Comprimere documenti lunghi in query semantiche concise
- **Configurazione**: 
  ```json
  {
    "searches": [
      {"type": "lex", "query": "keyword1 keyword2"},
      {"type": "vec", "query": "domanda naturale"}
    ],
    "limit": 5,
    "intent": "specific area"
  }
  ```

### 2. MCP Server per Document Management
- **Strumento**: `ListMcpResourcesTool`
- **Scopo**: Gestire risorse esterne e documenti compressi

### 3. Bash per Scripting
- **Strumento**: `Bash`
- **Scopo**: Automatizzare processi di compressione

## File di Configurazione

### settings.json Compressione
```json
{
  "compression": {
    "enabled": true,
    "max_context_ratio": 0.8,
    "compression_methods": [
      "semantic_search",
      "keyword_extraction",
      "summary_generation"
    ],
    "fallback_strategies": [
      "truncate_old_messages",
      "prioritize_relevant_only"
    ]
  }
}
```

## Script di Compressione

### script/compress-context.sh
```bash
#!/bin/bash
# Script di compressione contesto per Claude Code

# Comprimere documenti usando QMD
qmd query "$1" -c wiki --limit 3 > compressed_result.md

# Estrai keyword principali
qmd search "$1" -c fixcity-docs | head -5 > keywords.txt

# Genera sommario
qmd multi-get $(qmd search "$1" -c main_docs | head -10) | awk '/^# / {print; getline; print; print ""}' > summary.md
```

### script/compress-prompt.py
```python
#!/usr/bin/env python3
import json
import re

def compress_prompt(prompt, max_tokens=4000):
    """Comprime un mantenendo informazioni essenziali"""
    
    # Estrai e rimuovi codice non essenziale
    code_blocks = re.findall(r'```(?:\w+)?\n(.*?)\n```', prompt, re.DOTALL)
    
    # Estrai istruzioni chiave
    instructions = re.findall(r'#([^#]+)', prompt)
    
    # Comprimi mantenendo struttura
    compressed = {
        "instructions": instructions[:5],  # Prime 5 istruzioni
        "code_blocks": code_blocks[:3],   # Prime 3 code blocks
        "essential_context": extract_essential_context(prompt)
    }
    
    return json.dumps(compressed, indent=2)

def extract_essential_context(text):
    """Estrae contesto essenziale"""
    lines = text.split('\n')
    essential = []
    
    for line in lines:
        if any(keyword in line.lower() for keyword in ['import', 'use', 'require', 'config']):
            essential.append(line)
    
    return essential[:10]  # Prime 10 linee essenziali
```

## Integration con Claude Code

### .claude/settings.json
```json
{
  "hooks": {
    "before_prompt": "python script/compress-prompt.py --input",
    "after_response": "qmd embed --update"
  },
  "compression": {
    "auto_compress": true,
    "threshold_tokens": 8000,
    "preserve_structure": true
  }
}
```

## Utilizzo

### Query Compressa
```bash
# Comprimere prima di inviare
qmd query "come configurare un form in Filament" -c wiki --limit 3

# Usare risultati nella sessione
mcp__plugin_qmd_qmd__get "compressed_result.md"
```

### Compressione Automatica
```bash
# Abilitare compressione automatica
echo 'export CLAUDE_COMPRESS=true' >> ~/.bashrc
```

## Monitoraggio

### script/monitor-compression.sh
```bash
#!/bin/bash
# Monitorare l'efficacia della compressione

echo "=== Compression Statistics ==="
echo "Context size before: $(wc -c < original_prompt.md)"
echo "Context size after: $(wc -c < compressed_prompt.md)"
echo "Compression ratio: $(bc <<< "scale=2; $(wc -c < compressed_prompt.md) / $(wc -c < original_prompt.md) * 100")%"

echo "=== Quality Check ==="
qmd query "verifica completezza informazioni" -c wiki --limit 1
```

## Best Practices

1. **Conservare Metadata**: Mantenere informazioni di contesto essenziali
2. **Testare Qualità**: Verificare che informazioni non vengano perse
3. **Adattare al Contesto**: Modificare strategia in base al dominio
4. **Backup**: Conservare versioni originali per rollback

## Troubleshooting

### Errori Comuni
- **Compressione eccessiva**: Aumentare `max_context_ratio`
- **Perdita di informazioni**: Aggiungere keyword specifiche
- **Performance**: Ottimizzare query con `limit` appropriato

### Log di Debug
```bash
# Abilitare logging
export CLAUDE_COMPRESS_DEBUG=true
python script/compress-prompt.py --debug
```

## Prossimi Passi

1. Implementare compressione automatica nei settings
2. Aggiungere metriche di qualità
3. Creare dashboard per monitoring
4. Testare su workload reali