---
title: "Module Documentation Audit Guide"
type: "how-to"
status: "approved"
tags: [audit, documentation, quality, second-brain, modules]
created: "2026-05-26"
related:
  - "./second-brain-maturity-matrix.md"
  - "./module-wiki-documentation.md"
  - "../rules/naming-conventions-markdown.md"
---

# Module Documentation Audit Guide

> Procedura per valutare e migliorare la documentazione dei moduli.

## 📋 Checklist di Audit

### 1. Struttura Base
```bash
# Verifica presenza cartelle base
ls laravel/Modules/ModuleName/docs
ls laravel/Modules/ModuleName/docs/wiki
ls laravel/Modules/ModuleName/docs/wiki/concepts
ls laravel/Modules/ModuleName/docs/wiki/rules
ls laravel/Modules/ModuleName/docs/wiki/how-to
```

### 2. Conteggio File
```bash
# Conta file .md totali
find laravel/Modules/ModuleName/docs -name "*.md" | wc -l

# Conta file con front matter
grep -L "^---$" laravel/Modules/ModuleName/docs/*.md | wc -l
```

### 3. Front Matter
```bash
# Verifica campi obbligatori
grep -L "^title:" laravel/Modules/ModuleName/docs/*.md
grep -L "^type:" laravel/Modules/ModuleName/docs/*.md
grep -L "^tags:" laravel/Modules/ModuleName/docs/*.md
```

### 4. Collegamenti
```bash
# Trova link rotti
grep -r "\[" laravel/Modules/ModuleName/docs --include="*.md" | grep -v "http" | grep -v "related:" | grep -v "references:" | grep -v "wikilink"
```

### 5. Contenuto
```bash
# Verifica presenza documentazione per entità principali
grep -r "class.*extends" laravel/Modules/ModuleName/app/Models/*.php | cut -d' ' -f2 | while read model; do
  if [ ! -f "laravel/Modules/ModuleName/docs/$model.md" ]; then
    echo "Manca documentazione per $model"
  fi
done
```

## 🎯 Criteri di Valutazione

### Livello 1 - Iniziale
- [ ] Meno di 10 file `.md`
- [ ] Nessun `README.md` strutturato
- [ ] Front matter assente
- [ ] Collegamenti rotti

### Livello 2 - Base
- [ ] 10-50 file `.md`
- [ ] `README.md` presente ma incompleto
- [ ] Alcuni file con front matter
- [ ] Collegamenti parzialmente funzionanti

### Livello 3 - Strutturata
- [ ] 50-200 file `.md`
- [ ] `README.md` completo
- [ ] Front matter coerente
- [ ] Collegamenti bidirezionali verificati
- [ ] Documentazione per ogni modello principale

### Livello 4 - Matura
- [ ] 200+ file `.md`
- [ ] Documentazione per ogni azione, policy, risorsa
- [ ] Front matter completo con campi aggiuntivi
- [ ] Integrazione con QMD search
- [ ] Audit automatico in atto

## 📊 Report di Audit

### Struttura Report
```markdown
# Audit Documentazione - Modulo {Nome}

## Riepilogo
- **Totale file .md:** X
- **Livello maturità:** Y
- **Data audit:** 2026-05-26

## Problemi Critici
1. [Descrizione problema 1]
2. [Descrizione problema 2]

## Problemi Minori
1. [Descrizione problema 1]
2. [Descrizione problema 2]

## Raccomandazioni
- [Raccomandazione 1]
- [Raccomandazione 2]

## Piano d'Azione
- [Task 1] - Responsabile: [Nome] - Deadline: [Data]
- [Task 2] - Responsabile: [Nome] - Deadline: [Data]
```

### Esempio Pratico

**Audit modulo Performance:**
```bash
# Conta file
find laravel/Modules/Performance/docs -name "*.md" | wc -l  # Risultato: 42

# Verifica front matter
grep -L "^---$" laravel/Modules/Performance/docs/*.md  # Nessun risultato (tutti hanno front matter)

# Controlla collegamenti
grep -r "\[" laravel/Modules/Performance/docs --include="*.md" | grep -v "http" | grep -v "related:" | grep -v "references:" | wc -l  # 0 collegamenti rotti

# Verifica documentazione modelli
ls laravel/Modules/Performance/app/Models/*.php | wc -l  # 13 modelli
ls laravel/Modules/Performance/docs/models/*.md 2>/dev/null | wc -l  # 13 file modelli
```

## 🚀 Azioni Correttive

### Se Livello < 3:
1. **Creare template standard** per documenti mancanti
2. **Aggiungere front matter** a file senza
3. **Creare collegamenti** tra documenti correlati
4. **Documentare modelli mancanti**

### Se Livello >= 3:
1. **Implementare audit automatico** con script
2. **Aggiungere campi front matter aggiuntivi** (component, status)
3. **Integrare con QMD search**
4. **Creare documentazione per azioni e policy**

## 🔧 Strumenti Utili

### Script di Audit Automatico
```bash
#!/bin/bash
MODULE=$1

echo "=== Audit Documentazione - Modulo $MODULE ==="
echo ""

# Conteggio file
TOTAL=$(find laravel/Modules/$MODULE/docs -name "*.md" 2>/dev/null | wc -l)
echo "Totale file .md: $TOTAL"

# Verifica front matter
MISSING_FRONT=$(grep -rL "^---$" laravel/Modules/$MODULE/docs/*.md 2>/dev/null | wc -l)
echo "File senza front matter: $MISSING_FRONT"

# Verifica collegamenti
BROKEN_LINKS=$(grep -r "\[" laravel/Modules/$MODULE/docs --include="*.md" | grep -v "http" | grep -v "related:" | grep -v "references:" | wc -l)
echo "Possibili collegamenti rotti: $BROKEN_LINKS"

# Verifica documentazione modelli
MODEL_COUNT=$(ls laravel/Modules/$MODULE/app/Models/*.php 2>/dev/null | wc -l)
DOC_COUNT=$(ls laravel/Modules/$MODULE/docs/models/*.md 2>/dev/null | wc -l)
echo "Modelli: $MODEL_COUNT, Documentati: $DOC_COUNT"
```

### Trigger Map per Caricamento Automatico
Aggiungi al `TRIGGER_MAP`:
```
| Audit documentazione modulo | `docs/wiki/how-to/module-docs-audit.md` |
```

## 📅 Calendario Audit

- **Settimanale**: Audit rapido (10 minuti)
- **Mensile**: Audit completo (30 minuti)
- **Trimestrale**: Revisione livello maturità

## 🎯 Obiettivi

- **Maggio 2026**: Portare tutti i moduli a Livello 3
- **Giugno 2026**: Implementare audit automatico
- **Luglio 2026**: Raggiungere Livello 4 per moduli critici

## Riferimenti

- [Second Brain Maturity Matrix](./second-brain-maturity-matrix.md)
- [Naming Conventions Standard](../rules/naming-conventions-markdown.md)
- [Front Matter Minimum Standard](../rules/markdown-documentation-standard.md)