---
title: "Autocompact Thrashing Discipline"
type: "rule"
tags: [context, tokens, autocompact, thrashing, kilo, cursor, compaction, mandatory]
created: "2026-05-26"
updated: "2026-05-26"
confidence: high
related:
  - "./00-TRIGGER_MAP.md"
  - "./context-overflow-prevention.md"
  - "../how-to/autocompact-thrashing-recovery.md"
  - "../concepts/context-overflow-prevention.md"
  - "./rule-atomicity.md"
---

# Autocompact Thrashing Discipline

> **Obbligatoria per ogni agente** (Kilo, Cursor, Claude Code, ecc.) in questo repository.

## Trigger Automatico

È parte del **routing automatico**: riga dedicata in [`00-TRIGGER_MAP`](./00-TRIGGER_MAP.md) + sempre il pacchetto **BOOTSTRAP SESSIONE AGENTE** quando si intervengono prima sul tree.

Qualsiasi di questi segnali attiva **caricamento immediato obbligatorio** di questa regola + playbook canonico:

- Messaggio runtime: `Autocompact is thrashing: the context refilled to the limit within 3 turns...`
- `<runtime-telemetry>` che mostra token % in salita rapida dopo compact
- Errore "context refilled to the limit within 3 turns of the previous compact"

**Azione automatica:**
```bash
qmd search "Autocompact thrashing" --limit 5
```

## Regola Obbligatoria

1. **Dopo ogni compact visibile** (da telemetria o messaggio): le successive **1-2 azioni** DEVONO essere leggere (smart tool o chunk ≤50 righe).
2. **File >80 righe**: vietato `read` integrale. Usa `token-optimizer_smart_read` o `offset`/`limit`.
3. **Output tool potenzialmente grande**: reindirizza su file o usa `token-optimizer_*` prima di iniettare in chat.
4. **Sezione logica chiusa**: chiama `compress` **prima** di proseguire.
5. **Mai** leggere transcript completi di sub-agent o log interi.
6. Se il segnale appare → **prune chirurgico** (`acm_scan` → `acm_prune` sui blob pesanti) + eventuale `/clear`.

## Verifica

```bash
qmd search "Autocompact thrashing discipline" --limit 3
wc -l docs/wiki/rules/autocompact-thrashing-discipline.md
```

**Violazione = causa diretta di thrashing ricorrente e perdita di sessione.**

**Upstream:** [00-TRIGGER_MAP](./00-TRIGGER_MAP.md) (riga canonica) · [Autocompact Thrashing Recovery](../how-to/autocompact-thrashing-recovery.md)
