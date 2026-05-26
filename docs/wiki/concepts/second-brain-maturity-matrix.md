---
title: "Second Brain Maturity Matrix"
type: "concept"
status: "approved"
tags: [second-brain, maturity, documentation, quality, assessment]
created: "2026-05-26"
related:
  - "./second-brain-operating-model.md"
  - "./context-mode-usage.md"
  - "../how-to/module-docs-audit.md"
---

# Second Brain Maturity Matrix

> Framework per valutare e migliorare la qualità della documentazione nei moduli e nei temi.

## Livelli di Maturità

### Livello 1 - Iniziale (0-25%)
**Caratteristiche:**
- Documentazione sporadica o assente
- File `.md` senza struttura
- Nessun front matter
- Nessun indice centralizzato

**Indicatori:**
- Meno di 10 file `.md` per modulo
- Nessun `README.md` strutturato
- Assenza di `docs/wiki/`

### Livello 2 - Base (25-50%)
**Caratteristiche:**
- Documentazione di base presente
- Front matter parziale
- Alcuni collegamenti tra documenti
- Struttura cartelle iniziale

**Indicatori:**
- 10-50 file `.md` per modulo
- `README.md` presente
- Alcuni file con front matter YAML

### Livello 3 - Strutturata (50-75%)
**Caratteristiche:**
- Documentazione completa per funzionalità principali
- Front matter coerente
- Collegamenti bidirezionali
- Indice centralizzato

**Indicatori:**
- 50-200 file `.md` per modulo
- Documentazione per: PRD, architettura, API, testing
- Wiki strutturata con concetti, entità, fonti

### Livello 4 - Matura (75-90%)
**Caratteristiche:**
- Documentazione olistica
- Front matter completo
- Collegamenti automatici
- Second Brain operativo

**Indicatori:**
- 200+ file `.md` per modulo
- Documentazione per ogni azione, modello, risorsa
- Wikilinks e riferimenti verificati
- Integrazione con QMD

### Livello 5 - Eccellente (90-100%)
**Caratteristiche:**
- Documentazione predittiva
- Auto-manutenzione
- Integrazione con sistemi esterni
- Continuous improvement

**Indicatori:**
- Documentazione che si aggiorna autonomamente
- Metriche di qualità monitorate
- Automazione dei test di documentazione
- Second Brain condiviso tra squadre

## Checklist di Valutazione

### Struttura Base
- [ ] `docs/README.md` presente
- [ ] `docs/wiki/index.md` presente
- [ ] Cartella `docs/wiki/concepts/` esistente
- [ ] Cartella `docs/wiki/rules/` esistente
- [ ] Cartella `docs/wiki/how-to/` esistente

### Front Matter
- [ ] Tutti i file `.md` iniziano con `---`
- [ ] Campi obbligatori presenti (`title`, `type`)
- [ ] Campo `related` utilizzato
- [ ] Campo `tags` coerente

### Collegamenti
- [ ] Wikilinks verificati (nessun broken link)
- [ ] Collegamenti bidirezionali presenti
- [ ] Riferimenti a risorse esterne aggiornati

### Contenuto
- [ ] Documentazione per ogni entità principale
- [ ] Guide operative per sviluppatori
- [ ] Esempi di utilizzo
- [ ] Troubleshooting

## Audit Automatizzato

### Comandi per verificare la maturità

```bash
# Contare file .md in un modulo
find laravel/Modules/ModuleName/docs -name "*.md" | wc -l

# Verificare front matter
grep -L "^---$" laravel/Modules/ModuleName/docs/*.md

# Trovare link rotti
grep -r "\[.*\](.*\)" laravel/Modules/ModuleName/docs --include="*.md" | grep -v "http"

# Verificare struttura wiki
ls -la laravel/Modules/ModuleName/docs/wiki/
```

## Obiettivi Mensili

| Mese | Obiettivo |
|------|-----------|
| Maggio 2026 | Portare tutti i moduli a Livello 3 |
| Giugno 2026 | Implementare audit automatico |
| Luglio 2026 | Raggiungere Livello 4 per moduli critici |

## Riferimenti

- [Second Brain Operating Model](./second-brain-operating-model.md)
- [Module Wiki Documentation](../how-to/module-wiki-documentation.md)
- [Naming Conventions Standard](../rules/naming-conventions-markdown.md)