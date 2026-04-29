# User Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-29] ingest | operating focus and architecture summary
- Aggiunta pagina `concepts/user-module-operating-focus.md` per fissare scope, guardrail e priorita' di retrieval.
- Aggiunta pagina `sources/user-architecture-sources.md` per sintetizzare i raw docs a maggiore segnale.
- Registrato il rischio di duplicazione diffusa tra raw docs, archive e integration.

## [2026-04-29] update | local second brain operating loop
- Aggiornata `concepts/user-module-operating-focus.md` con loop locale second brain (retrieve -> distill -> index -> log).
- Allineato il comportamento documentale del modulo User al ciclo `/bmad-create-story` del progetto.
