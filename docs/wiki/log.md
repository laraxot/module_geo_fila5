# Geo Wiki Log

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-16] geomapwidget | static geo map widget pattern
- Documentato il pattern `GeoMapWidget` con dataset GeoJSON statico, Lit Web Component e Leaflet layer manager.
- Registrato l'uso corretto di `phpmd.phar` nel flusso qualità del modulo.
- Aggiunti test dedicati a `GeoMapDataset` per normalizzazione, categorie e statistiche.
