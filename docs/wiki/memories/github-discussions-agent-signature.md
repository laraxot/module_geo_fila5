---
name: github-discussions-agent-signature
title: "GitHub Discussions + firma agente AI (persistente)"
type: "memory"
tags: [github, discussions, agent, signature, multi-agent, persistent]
created: 2026-05-27
updated: 2026-05-27
related:
  - ../how-to/github-issue-agent-discipline.md
  - ../rules/00-TRIGGER_MAP.md
---

# GitHub Discussions + firma agente AI

> Regola operativa **persistente**. Vale per ogni interazione agent con repo modulo/tema.

## Tre regole indissociabili

1. **`git remote -v`** dentro la cartella del modulo/tema → estrai `<owner>/<repo>`.
2. **Issues = bug/audit/task chiusi**; **Discussions = dibattito multi-agente AI e decisioni**.
3. **Firma obbligatoria** in ogni commento/issue/discussion creata da agente AI: `— <Agente> (\`<modello>\`)`.

## Perché Discussions e non solo Issues

- Discussions = thread con categorie (`Architecture`, `Ideas`, `Q&A`, `Show & Tell`) → confronto strutturato.
- Issues = ticket con stati `open`/`closed` → bug e task con definizione chiusa.
- Mescolarli = perdita di leggibilità (issue con 50 commenti di brainstorm vs ticket atomici).

## Verifica Discussions abilitate

```bash
gh api repos/<owner>/<repo> --jq '.has_discussions'
```

Se `false`: **abilitare autonomamente** (l'agente ha permessi su `laraxot/*`):

```bash
gh api -X PATCH repos/<owner>/<repo> -f has_discussions=true
```

**Stato verificato 2026-05-27:** discussions abilitate su tutte le repo `laraxot/*_fila5` accessibili (activity, user, xot, gdpr, ui, notify, lang, media, job, setting, tenant, rating, seo, dbforge).

## Esempi firme accettate

| Agente AI | Esempio firma |
|---|---|
| Claude (Anthropic) | `— Claude (\`claude-opus-4-7\`)` |
| Cursor agent | `— Cursor (\`composer-1\`)` |
| GitHub Copilot | `— Copilot (\`gpt-5-codex\`)` |
| Gemini | `— Gemini (\`gemini-2.5-pro\`)` |
| Codex/OpenAI | `— Codex (\`gpt-5\`)` |

## Cosa fare ad ogni task agent

1. `git remote -v` → owner/repo.
2. `gh api repos/<owner>/<repo> --jq '.has_discussions'`.
3. Se task è dibattito/decisione → Discussion (con categoria).
4. Se task è bug/audit → Issue (rollup + sub-issue per categoria).
5. Includi sempre **almeno una domanda** agli altri agenti se vuoi consenso.
6. Aggiorna `docs/chat/<slug>.md` interno in parallelo (canale repo).
7. **Firma** sempre. Senza firma il post è incompleto.

## Discussions create (log)

| Repo | Discussion | Argomento |
|------|------------|----------|
| module_xot_fila5 | #19 | PHPStan 27 errori — coordinamento AI |
| module_user_fila5 | #22 | PHPStan 13 errori — coordinamento AI |
| module_ui_fila5 | #7 | PHPStan 49 errori — coordinamento AI |
| module_gdpr_fila5 | #16 | PHPStan 16 errori — coordinamento AI |

## Cross-link

- How-to canonico: [github-issue-agent-discipline.md](../how-to/github-issue-agent-discipline.md) § "Firma obbligatoria" + § "GitHub Discussions".
- Trigger map: [00-TRIGGER_MAP.md](../rules/00-TRIGGER_MAP.md) righe "firma" e "Discussione multi-agente".
- Memoria globale agent: `~/.claude/projects/-var-www--bases-base-ptvx-fila5/memory/github-discussions-multi-agent-signature.md`.

## Anti-pattern

| Sbagliato | Giusto |
|---|---|
| Commento senza firma | Suffisso `— Claude (\`claude-opus-4-7\`)` |
| Solo "Claude" senza modello | Sempre `<nome> (\`<modello>\`)` |
| Brainstorm su Issues | Discussions con categoria |
| Audit su Discussions | Issues con label + checklist |
| Nessuna domanda nel post | Almeno 1-2 domande esplicite agli altri agenti |
| Skip `docs/chat/<slug>.md` | Mantenuto in parallelo per audit locale |
