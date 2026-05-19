---
title: "Second Brain Maintenance Cadence"
module: "ptvx-project"
type: concept
created: "2026-04-29T10:33:00Z"
updated: "2026-04-29T10:33:00Z"
qmd: "second brain cadence, weekly audit, root module theme docs, maintenance rhythm"
related:
  - "second-brain-continuous-improvement.md"
  - "second-brain-audit-checks.md"
  - "second-brain-operating-model.md"
---

# Second Brain Maintenance Cadence

> Cadence operativa minima per mantenere il second brain aggiornato senza overhead inutile.

## Obiettivo

Trasformare il loop di miglioramento continuo in una routine prevedibile e verificabile, con trigger espliciti su root, moduli e temi.

## Rhythm (minimo sostenibile)

- **Daily (light):**
  - aggiornare wiki/log del nodo toccato durante task reali
  - evitare documentazione “a freddo” non collegata a una decisione
- **Weekly (maintenance pass):**
  - 1 pass root wiki
  - 1 pass su modulo ad alta frequenza (es. User, UI, Xot)
  - 1 pass su tema attivo (es. One)
- **Monthly (quality pass):**
  - audit naming/link/duplicazioni su cluster docs prioritari
  - riallineamento ingest backlog e priorita'

## Trigger Operativi

Eseguire subito maintenance pass quando si verifica uno di questi segnali:

1. stesso argomento ricercato piu' di 2 volte in una settimana
2. conflitti o regressioni dovute a docs incoerenti
3. file wiki non linkati da `index.md`
4. aumento di file duplicati/varianti sullo stesso topic

## Scope Federation

- **Root wiki (`docs/wiki`)**: solo regole cross-cutting
- **Module wiki (`laravel/Modules/*/docs/wiki`)**: regole bounded al dominio del modulo
- **Theme wiki (`laravel/Themes/*/docs/wiki`)**: regole bounded a UI/UX/composizione view

Escalation al root solo quando la regola e' riusabile in piu' moduli/temi.

## Weekly Checklist (snella)

1. apri `index.md` del nodo target (root/modulo/tema)
2. verifica pagine orfane e link rotti
3. aggiorna una pagina concept/source ad alto riuso
4. registra sempre l’operazione in `log.md`
5. se emerge pattern cross-cutting, promuovilo al root

## Definition of Done (cadence pass)

Un cadence pass e' valido quando:

- almeno un nodo wiki e' stato migliorato (non solo letto)
- `index.md` e `log.md` sono coerenti col cambiamento
- non sono stati creati file duplicati su topic gia' coperti
- il prossimo agente trova la decisione in <= 2 click da index

## References

- [Second Brain Continuous Improvement](second-brain-continuous-improvement.md)
- [Second Brain Audit Checks](second-brain-audit-checks.md)
- [Second Brain Operating Model](second-brain-operating-model.md)
