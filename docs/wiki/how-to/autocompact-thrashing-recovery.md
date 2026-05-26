---
title: "Autocompact thrashing — recovery e prevenzione (Cursor/Kilo)"
type: how-to
status: approved
tags: [context-window, autocompact, compaction, claude-code, cursor, agents, kilo, mcp]
module: ptvx-project
created: "2026-05-26"
updated: "2026-05-26"
qmd: "autocompact thrashing context refilled limit compact tool output too large recovery cursor clear chunk"
related:
  - "../concepts/context-overflow-prevention.md"
  - "../rules/context-overflow-prevention.md"
  - "../memories/compaction-exhausted-recovery.md"
  - "./github-issue-agent-discipline.md"
  - "./context-mode-overflow-prevention.md"
  - "./api-context-length-exceeded-131072.md"
  - "./kilo-autocompact-thrashing-prevention.md"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/138"
---

# Autocompact thrashing — recovery e prevenzione (Cursor/Kilo)

> Errore (IDE / agent runtime):
>
> `Autocompact is thrashing: the context refilled to the limit within 3 turns of the previous compact, 3 times in a row.`

**Perché succede:** la compattazione abbrevia la storia; **nel giro immediatamente dopo** una lettura tool o uno stdout enorme rimette il contesto sopra soglia. Tre cicli ⇒ il runtime rileva *thrashing* e blocca. Non esiste uno switch affidabile «disabilita sempre compact» ([spiegazione ufficiale summarizing — forum Cursor](https://forum.cursor.com/t/summarizing-chat-context-why/102842/2)).

**Soluzione stabile nel tempo:** combinare **sessioni brevi**, **ingressi piccoli** e **zero monoliti sempre attivi** — vedi playbook sotto ([contesto implicito Cursor — vexp](https://vexp.dev/blog/cursor-context-window-limitations-fit-more-code-in-less-space)).

---

## Stop immediato (ordine fisso)

1. **Interrompi** tool paralleli o letture bulky.
2. **`/clear`** oppure **nuova chat**: brief ≤10 righe (obiettivo, ambiente, file esatti già identificati, issue).
3. Opzionale: checkpoint append in `docs/chat/<slug-argomento>.md` ([convenzione inter-agent](../../chat/agent-edit-discipline.md)).
4. Riprendere con **una sola** lettura chunked + issue GitHub se il lavoro tocca policy/repo.

---

## Playbook Cursor Composer / Agent (priorità — senza MCP)

| Passo | Cosa fare |
|-------|-----------|
| Sessione | Dopo una feature/decision point → **nuova chat** riduce historia e injection implicita. |
| Riferimenti | Evita `@Codebase`/cartelle intere quando basta `@file`/simbolo. |
| Lettura file | Nessun mammuth intero nel tool: **`Read offset/limit`** o `grep` mirato (`rg -n`). |
| Post-compact | Le **prime 1–2 azioni** dopo un compact visibile devono essere leggere. |
| Regole `.mdc` | Vietati `alwaysApply: true` + megabyte; monoliti in `.bak` + wiki on-demand. |
| Indice | Usa `.cursorignore` / `.cursorindexignore` per vendor, build, dump. |
| Shell | Output lunghi → reindirizza su file o `tail`, non incollare nel prompt. |

---

## Playbook stack Kilo / MCP `token-optimizer` + ACM (solo se presente)

1. File > ~80 righe: `token-optimizer_smart_read` (o chunk espliciti), non read ripetuto integrale.
2. Chiudi ogni sezione logica con `compress`/compact **prima** di aprire nuove aree.
3. No `Read` di transcript sub-agent completi — solo sintesi del tool.
4. `acm_scan` → `acm_prune` / `acm_compact` se la telemetria lo espone.

**Disciplina obbligatoria automatica** (caricamento via TRIGGER_MAP su qualsiasi segnale thrashing/telemetria): [`../rules/autocompact-thrashing-discipline.md`](../rules/autocompact-thrashing-discipline.md)

Documento storico Kilo (alias, non duplicare): [`kilo-autocompact-thrashing-prevention.md`](./kilo-autocompact-thrashing-prevention.md).

---

## Prevenzione obbligatoria (check operativo)

| Rischio | Regola |
|---|---|
| File grande | `wc -l` prima; >300 righe → `sed -n 'A,Bp'` / `Read` offset+limit |
| Ricerca larga | `rg -n "pattern" path` ristretto |
| Elenco file | `find … -maxdepth N` |
| QMD | `qmd search "topic"` + apri solo i file necessari |
| Test / analisi | Log su disco; in chat solo estratti |
| Parallel tool | Solo output prevedibile e piccolo |
| Sessione lunga | Checkpoint ogni ~10–15 turn tool |

---

## Disciplina GitHub issue

```bash
git remote -v
gh issue list --repo provtv/base_ptv_fila5_mono --search "autocompact thrashing" --state all
```

Thread dedicato: [issue #138](https://github.com/provtv/base_ptv_fila5_mono/issues/138). Non chiudere lavori su contesto senza commento issue + riga `docs/wiki/log.md` quando la policy cambia.

---

## Anti-pattern vietati

- Aprire `.bak`, dump, report generati, log interi senza chunk.
- Incollare output enormi «per vedere tutto».
- Restare nella stessa chat dopo tre compact ravvicinati senza `/clear`.
- Usare `/compact` come uncino quando il working set è ancora troppo largo.

---

## Fonti esterne (verificate)

- [Forum Cursor — summarizing chat context](https://forum.cursor.com/t/summarizing-chat-context-why/102842/2)
- [Forum Cursor — context too large](https://forum.cursor.com/t/context-is-too-large-problem/60479)
- [vexp — Cursor context window / injection](https://vexp.dev/blog/cursor-context-window-limitations-fit-more-code-in-less-space)
- [Forum — file condensed to fit](https://forum.cursor.com/t/this-file-has-been-condensed-to-fit-in-context-message/128120)
- [Kilo — context condensing](https://kilo.ai/docs/customize/context/context-condensing)

---

## Verifica rapida

```bash
qmd search "autocompact thrashing context refilled" --limit 5
gh issue view 138 --repo provtv/base_ptv_fila5_mono
```

**Propagazione DRY:** ogni `laravel/**/docs/agent-edit-discipline.md` contiene il link relativo a **questo** file.
