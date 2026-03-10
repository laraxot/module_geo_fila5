# Zero Theme Docs

Documentazione tecnica del tema `Zero` (layout, componenti, integrazione Filament e linee guida UI).

## Stato Attuale (snapshot 2026-03-07)

- Documenti markdown in `docs/`: **69**
- File docs con marker di merge rilevati: **22 file** / **168 marker**
- Priorita: bonifica conflitti e consolidamento indice

## Uso consigliato

- partire da [00-index.md](00-index.md)
- usare [architecture.md](architecture.md) e [modern-theme-architecture.md](modern-theme-architecture.md) come riferimenti principali
- trattare i documenti con conflitti come **non affidabili** finche non bonificati

## Audit e piano

- report confidenza: [docs-confidence-audit-2026-03-07.md](docs-confidence-audit-2026-03-07.md)

## Struttura

- `resources/views/` — layout e componenti blade del tema
- `lang/` — traduzioni specifiche tema
- `docs/` — linee guida, roadmap, troubleshooting

## Regole

- nessun marker di merge nei file finali
- evitare duplicazioni tra `index.md`, `index-consolidated.md`, `00-index.md`
- ogni modifica ai componenti principali deve aggiornare almeno un documento canonico
