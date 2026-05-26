---
title: "Massima confidenza agente"
type: rule
status: approved
tags: [agents, confidence, verification, second-brain]
created: "2026-05-26"
updated: "2026-05-26"
---

# Massima confidenza agente

## Regola

Un agente aumenta la confidenza solo con prove verificabili:

1. `git remote -v` + issue GitHub collegata.
2. Trigger map + wiki owner caricati on-demand.
3. File target letti a chunk, senza output massivo.
4. Ipotesi separate dai fatti.
5. Modifiche minime e forward-only.
6. Gate adeguati: `php -l`, PHPStan, PHPMD, PHPInsights, test o N/A motivato.
7. Documentazione nel docs owner + log wiki.
8. Riepilogo finale: file, prove, limiti, blocker.

## Anti-pattern

- Dire “sicuro” senza comando eseguito.
- Fidarsi di memoria o training su fatti locali.
- Saltare issue, lock o gate.
- Confondere output vecchio con errore attuale.
