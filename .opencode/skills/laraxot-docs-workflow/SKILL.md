---
name: laraxot-docs-workflow
description: Gestisce il workflow di documentazione Laraxot (moduli e temi): studio, aggiornamento, naming e link relativi. Usare quando si modifica codice o si richiede aggiornare i docs.
---

# Laraxot Docs Workflow

## Scopo
Garantire che la documentazione dei moduli e dei temi sia aggiornata, coerente e con naming corretto.

## Quando usare
- Aggiornamenti di codice o bugfix
- Creazione o modifica di regole/procedure
- Richieste esplicite di aggiornare docs

## Checklist operativa
- [ ] Leggi la doc del modulo/tema interessato prima di modificare codice
- [ ] Aggiorna i docs del modulo/tema coinvolto
- [ ] Aggiorna i docs root solo se richiesto o necessario
- [ ] Usa link relativi
- [ ] Verifica naming: file `.md` in minuscolo (eccetto `README.md`)
- [ ] Se esiste `readme.md` insieme a `README.md`, elimina `readme.md`
- [ ] Non creare nuove cartelle `docs/`
- [ ] Crea nuovi `.md` solo se esplicitamente richiesto

## Regole di naming
- Solo `README.md` può essere maiuscolo
- Tutti gli altri `.md` devono essere minuscoli
- Niente date nei nomi file

## Link relativi (esempio)
```
[Guida Modulo](../Xot/docs/README.md)
```
