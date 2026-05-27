# Gdpr Wiki Log

## [2026-05-27] lint | phpstan zero

- PHPStan max: 16→0 errori (129 file).
- Rimosso `Listeners/GdprRegistrationListener.php` (duplicato di `app/Listeners/SaveGdprConsents`).
- Issue provtv/module_gdpr_fila5#9 chiusa.
- Doc: `docs/phpstan-analysis-gdpr.md`.

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`
