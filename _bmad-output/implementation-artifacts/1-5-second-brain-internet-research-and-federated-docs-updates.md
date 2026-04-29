# Story 1.5: Second Brain Internet Research and Federated Docs Updates

Status: draft

## Story

As a developer agent,
I want to continuously ingest external second-brain practices and apply them to root/module/theme wiki nodes,
so that documentation retrieval is faster, more reliable, and directly useful for delivery work.

## Business Goal

Ridurre tempo di ricerca e rischio di regressioni documentali, trasformando la documentazione distribuita in memoria operativa federata (root + moduli + temi).

## Why Now

- I task BMAD dipendono dalla qualita' del contesto disponibile.
- Le docs sono diffuse e disomogenee: senza ciclo di distillazione aumenta il costo cognitivo.
- Le pratiche esterne (CODE, progressive summarization, LLM wiki) sono allineate al modello gia' adottato nel progetto.

## Acceptance Criteria

1. Esiste una sintesi verificabile di benchmark esterni in `docs/wiki/sources/second-brain-external-benchmarks.md`.
2. Il root wiki integra regole operative che collegano `/bmad-create-story` al ciclo second-brain.
3. Almeno un modulo e un tema hanno aggiornato il proprio operating focus con loop documentale locale.
4. Gli indici wiki coinvolti includono link alle nuove/aggiornate pagine.
5. I file `log.md` coinvolti registrano l'operazione con rationale orientato al business.

## Tasks

- [ ] Aggiornare `docs/wiki/concepts/second-brain-continuous-improvement.md` con policy di ingest esterno.
- [ ] Aggiornare `docs/wiki/index.md` includendo benchmark esterni.
- [ ] Aggiornare operating focus locale di `Modules/User` e `Themes/One`.
- [ ] Aggiornare indici e log locali (`root`, `User`, `One`).
- [ ] Verificare naming e link relativi.

## Notes

- Focus su DRY + KISS: minimizzare documenti ridondanti, massimizzare pagine ad alta riusabilita'.
- Persistenza locale: decisioni modulo/tema restano nel wiki piu' vicino; escalation a root solo per regole cross-cutting.
- Nessun automatismo cieco: sintesi e merge documentale solo manuali.

## References

- [Second Brain External Benchmarks](../../docs/wiki/sources/second-brain-external-benchmarks.md)
- [Second Brain Operating Model](../../docs/wiki/concepts/second-brain-operating-model.md)
- [Second Brain Continuous Improvement](../../docs/wiki/concepts/second-brain-continuous-improvement.md)
