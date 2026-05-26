---
title: "github issue come audit trail per decisioni agent"
type: "how-to"
tags: [github, gh, issues, agent, documentation, second-brain]
created: 2026-05-19
updated: 2026-05-26
related: [../rules/validation-post-edit-rule.md, ../concepts/second-brain-operating-model.md, ../memories/github-issues-proactive.md, ../../../bashscripts/tools/prompts/llm-wiki.txt]
---

# GitHub issue come audit trail (agent / wiki)

## Scopo

La wiki (`docs/wiki/`) tiene la **policy sintetica** e i comandi. Le **GitHub issue** offrono thread ricercabili, notifiche e storico decisionale per chi non usa QMD o Cursor — senza duplicare paragrafi lunghi nei moduli.

## Disciplina agent (obbligatoria)

> **Non ammettere eccezioni:** task solo wiki, solo `.md`, solo trigger map o solo «piccolo refactor documentale» richiedono **ugualmente** `gh` — altrimenti si perde audit trail ricercabile fuori da QMD/Cursor.

1. **All’inizio del task:** `git remote -v` + `gh issue list --repo provtv/base_ptv_fila5_mono --search "<argomento>" --state all`.
2. **Argomento senza issue:** creare subito con `gh issue create` (non chiedere conferma all’utente).
3. **Argomento con issue aperta:** lavorare in quella issue (commento con path wiki + prove); chiudere quando la checklist nel corpo è soddisfatta.
4. **Fine task:** aggiornare wiki/log + commento issue; **vietato** chiudere la sessione chiedendo «vuoi che crei/chiuda un’issue?».

Memory operativa: [`github-issues-proactive.md`](../memories/github-issues-proactive.md).

## Guardrail anti-dimenticanza

Se l'agente scopre di aver iniziato modifiche senza issue:

1. fermare subito gli edit non essenziali;
2. eseguire `git remote -v`;
3. cercare issue esistenti con `gh issue list --repo provtv/base_ptv_fila5_mono --search "<argomento>" --state all`;
4. creare/commentare issue prima di proseguire;
5. registrare nel commento issue che il thread e' stato aperto in ritardo e quale guardrail e' stato aggiunto.

Esempio operativo: [issue #138](https://github.com/provtv/base_ptv_fila5_mono/issues/138) per Autocompact thrashing.

## Issue di riferimento

- **Ancoraggio decisionale (lock affiancato + qualità post-edit + propagazione):** [issue #124](https://github.com/provtv/base_ptv_fila5_mono/issues/124)

Aggiornare i puntatori nei doc se il numero cambiasse (preferire link stabili alla issue piuttosto che copiare il body).

## Workflow consigliato (`gh`)

Repo remoto verificato: `git remote -v` → `provtv/base_ptv_fila5_mono`.

**Confronto tra agenti:** thread in [`docs/chat/`](../../chat/) con file **`<slug-argomento>.md`** (un argomento = un file; risposte in append). Convenzione piena: `bashscripts/tools/prompts/llm-wiki.txt` §10.

```bash
# Nuovo thread decisionale
gh issue create --repo provtv/base_ptv_fila5_mono --title "[DOCS] …" --body-file ./note.md

# Aggiornare il ragionamento senza spam di commit wiki
gh issue comment <N> --repo provtv/base_ptv_fila5_mono --body "$(cat <<'EOF'
…
EOF
)"
```

## MCP (opzionale)

Se l’agent espone MCP GitHub o HTTP generico, si possono creare commenti equivalenti alla CLI. La **fonte normativa** resta il markdown versionato nel repo; l’issue è **complementare** per discussione e traceability.

## Stub nei moduli / temi

Ogni package espone `docs/agent-edit-discipline.md` (puntatore). Non duplicare qui la policy: solo link alla wiki e all’issue.

## Vedi anche

- [validation-post-edit-rule.md](../rules/validation-post-edit-rule.md)
- [module-wiki-documentation.md](./module-wiki-documentation.md)
- [theme-wiki-documentation.md](./theme-wiki-documentation.md)
- [00-TRIGGER_MAP.md](../rules/00-TRIGGER_MAP.md)
