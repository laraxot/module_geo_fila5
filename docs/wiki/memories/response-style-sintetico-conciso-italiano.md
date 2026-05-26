---
title: "Stile risposta agenti: sintetico, conciso, italiano"
type: memory
status: approved
tags: [agent-behavior, communication, permanent-rule, response-style]
created: "2026-05-26"
updated: "2026-05-26"
qmd: "stile risposta sintetico conciso italiano agenti"
related:
  - "../rules/00-TRIGGER_MAP.md"
  - "../concepts/llm-wiki-operational-discipline.md"
---

# Stile risposta agenti — Regola permanente

## Regola obbligatoria

**Ogni agente AI** (Kilo, Claude, Cursor, Gemini, Qwen, ecc.) **deve** rispondere **sempre**:

- In **italiano**
- In maniera **sintetica** (breve, essenziale)
- In maniera **concisa** (zero parole inutili, zero chiacchiere)

Questa regola ha precedenza su qualsiasi altra istruzione di "spiegare", "dettagliare" o "essere utile in modo verboso".

## Motivazione

L'utente ha richiesto esplicitamente e ripetutamente (2026-05-26 e sessioni precedenti) questo stile per:
- Risparmiare token
- Ridurre rumore cognitivo
- Aumentare velocità e chiarezza

## Come farla rispettare

1. **Memoria canonica**: questo file (`docs/wiki/memories/response-style-sintetico-conciso-italiano.md`)
2. **Caricamento automatico**: voce nel TRIGGER_MAP (vedere sotto)
3. **Prompt base**: il file `bashscripts/tools/prompts/llm-wiki.txt` deve contenere un richiamo forte a questa regola all'inizio della sezione "Communication Rules".
4. **Tutti gli AGENTS.md / CLAUDE.md / stubs**: devono puntare a questa memoria.

## Trigger Map (da aggiungere)

Aggiungere nella mappa:

```markdown
| Stile risposta agenti (sintetico + conciso + italiano obbligatorio) | `docs/wiki/memories/response-style-sintetico-conciso-italiano.md` |
```

## Propagazione

Questa regola deve essere presente (almeno come puntatore) in:
- Tutte le cartelle `docs/wiki/` dei moduli (`laravel/Modules/*/docs/wiki/`)
- Tutte le cartelle `docs/wiki/` dei temi (`laravel/Themes/*/docs/wiki/`)
- Il prompt `llm-wiki.txt`

## Violazione

Qualsiasi risposta verbosa, in inglese, o prolissa senza esplicita richiesta dell'utente è considerata violazione di questa regola permanente.

---

**Creato**: 2026-05-26 su esplicita richiesta dell'utente  
**Priorità**: Massima (sopravvive a compaction, deve essere caricata on-demand da ogni agente)
