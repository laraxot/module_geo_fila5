---
title: "Policy Ownership – Ptv & Sigma"
type: concept
status: draft
tags: [redundancy, ptv, sigma, ownership, drY, architecture]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - "../modules/ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md"
  - "../modules/sigma/docs/wiki/redundancy-audit.md"
  - "../concepts/ptv-sigma-redundancy-policy.md"
qmd: "ptv sigma redundancy ownership"
---

# Policy Ownership – Ptv & Sigma (Project‑wide)

> **Nota**: Questo documento è collocato nel *project wiki* perché descrive regole e proprietà che coinvolgono più moduli (`Ptv`, `Sigma`, `Xot`, ecc.).

## Scopo
Definire chi è il responsabile di ogni parte di logica duplicata o condivisa tra i moduli **Ptv**, **Sigma** e i consumer HR, **a livello di progetto**.

## Bucket principali (aggiornati)
| Bucket | Definizione | Owner target | Esempi |
|--------|-------------|--------------|--------|
| **core‑hr** | Calcolo presenze, giorni, assenze, legami anagrafica – agnostico dal gestionale | Modulo **Xot** (trait/action condivisi) | `ggInSedeTot`, `getGgAnno` |
| **integration‑sigma** | Sync tabelle legacy, modelli `Anag`/`Qua00f`, API/upload CSV | **Sigma** | `SigmaService`, modelli `W*`, Filament `SqlUpload` |
| **domain‑ptv** | Valutazione, criteri esclusione, PDF/mail scheda, Filament scheda | **Ptv** | `CriteriEsclusione/*`, `SendMailByRecord`, `SchedaContract` |
| **presentation** | Colonne Filament, Blade, Infolist duplicati | UI / Theme module | `WorkerColumn` ×2, blade `login` One/Zero |

## Regole chiave (project‑wide)
1. **Sigma non dipende da Ptv** – nessun import/trait di Ptv in Sigma.
2. **Ptv non duplica azioni già presenti in Performance** – consolidare in Xot o in un pacchetto HR‑core.
3. **Contratti condivisi** – `SchedaContract` deve risiedere in un package comune (`Xot` o `hr-core`).
4. **Documentazione unica** – una sola verità nel wiki; ogni modifica deve aprire una issue GitHub (vedi `#162`).

## Zen
- Evitare rifattorizzazioni senza catalogo firmato in issue.
- Eliminare componenti orfani prima di spostare i trait.

## Issue di riferimento
- Verificare numeri con `gh issue list` dopo `git remote -v` (see `docs/wiki/how-to/github-issue-agent-discipline.md`).

---

*Questo documento sostituisce* `laravel/Modules/Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md` *che era collocato erroneamente nel modulo Xot.*
